<?php
//arquivo para testes
//include 'test.php';

class xmlParser {
    
     //url do arquivo xml dos cupons
     private $_urlXml = '...';
    
     public function curlXml(){
        //$start = microtime(true);
        $ch = curl_init();

        // informar URL e outras funções ao CURL
        curl_setopt($ch, CURLOPT_URL, $this->_urlXml);
        //curl_setopt($ch, CURLOPT_USERAGENT, ‘My custom web spider/0.1’);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FILETIME, true);
        curl_close($ch);
        
        //echo microtime(true) - $tart;
        return curl_exec($ch);
    }
    
    public function createXml(){
        //header para xml gzip
        $opts = array(
		  'http'=>array(
			'method'=>"GET",
			'header'=>  "Accept-Language: en-US,en;q=0.8rn" .
				        "Accept-Encoding: gzip,deflate,sdchrn" .
						"Accept-Charset:UTF-8,*;q=0.5rn" .
						"User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:19.0) Gecko/20100101 Firefox/19.0 FirePHP/0.4rn"
		  )
	    );

        $context = stream_context_create($opts);        
        
        $url = $this->_urlXml;
        $xml = new SimpleXMLElement(file_get_contents($url, false, $context));
        $xml->addAttribute('getDateServer', getdate()['mday'] . '-' . getdate()['hours'] . '-' . getdate()['minutes']);
        $xml->asXML("zanox.xml");
        //print_r($xml);
        //die();
        return $xml;
    }
    
    //primeiro método a ser chamado
    public function initXmlToHtml(){
        return $this->filterXml();
    }
    
    //Lê o xml ou cria um xml caso não exista um
    public function readXml(){
        //$start = microtime(true);
        
        if(!file_exists('zanox.xml')){
            $xml = $this->createXml();
        } else {
            $xml = simplexml_load_file('zanox.xml');
        }
        
        //echo microtime(true) - $start;
        
        return $xml;
    }
    
    //constroi o cupons
    //TODO Factory
    public function createItemsHtml($program = '', $loja= '', $name= '', $endDate= '', $description= '', $title = '', $trackingLink='', $firstCupomLoja){
        $htmlItem = '';

        $nameString = $this->revealName($program);

        //string usada nas imagens
        $nameCode = str_replace(" ", "-", $nameString);

        if($firstCupomLoja){
            $htmlItem .='<h2 class="h-cupom" id="h-cupom-'.$nameString.'">Cupons '.$program.'</h2>';
        }

        $htmlItem .='<div class="campo-cupom">';

        $htmlItem .='<span class="logo-cupom"><img src="/wp-content/themes/THEME/images/logo-cupom/cupom-de-desconto-logo-'. strtolower($nameCode) .'.jpg"></span>';

        $htmlItem .= '<h3 class="titulo-cupom">'.$name.'</h3>';

        $htmlItem .='<a class="botao-cupom" data-title="'.title.'" data-heading="Aqui está seu cupom da '.$nameString.'" data-subheading="'.$program.'" data-description="'.$description.'" href="'.$trackingLink.'" target="_blank"><img src="/wp-content/uploads/2015/12/botao-ver-cupom.jpg"></a>';
        
        if(!empty($endDate)){
            $endDate = explode('T', $endDate)[0];
            $date = date_create($endDate);
            $endDate = date_format($date,"d/m/Y");
            $htmlItem .='<p class="prazo-cupom">Válido até ' . $endDate . '</p>';
        }
        
        if(!empty($description)){
            $htmlItem .='<p class="info-cupom">Mais informações</p>';
        
            $htmlItem .='<div class="more-information more-information-hide"><span>Mais informações</span><br/>' . $description . '</div>';
                    
        }

        $htmlItem .='</div>';

        $html .= $htmlItem;
        
        return $html;
    }
    
    //filtra o objeto xml
    public function filterXml(){
        
        try{
            $xml = $this->readXml();
            $parent = $xml->incentiveItems;
            $itens = $parent->incentiveItem;
            $html = '';
            $oldProgram = '';
            
            foreach($itens as $item){
                $program = $item->program;
                $loja = $item->loja;
                $name = $item->name;
                $endDate = $item->endDate;
                $trackingLink = $item->admedia->admediumItem->trackingLinks->trackingLink->ppc;
                $title = $item->title;

                $description = $item->admedia->admediumItem->description;
                $firstCupomLoja = false;
                
                //verifica se deve colocar um titulo ou não, pois a sequências são variáveis
                if((string) $oldProgram !== (string) $program){
                    $oldProgram = $program;
                    $firstCupomLoja = true;
                } 
                                
                $html .= $this->createItemsHtml($program, $loja, $name, $endDate, $description, $title, $trackingLink, $firstCupomLoja);
            }
            
            $this->createHtml($html);
            return $html;
            
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }
    
    //cria o arquivo html no diretorio, para ser usado eliminando a requisição e/ou construção do xml
    public function createHtml($html){
        $zanoxHtml = fopen("zanox.html", "w") or die("Unable to open file!");
        fwrite($zanoxHtml, $html);
        fclose($zanoxHtml);
    }
    
    //limpa a string do nome da loja
    public function revealName($program){
        $nameString = end($program);
        $nameString = explode(" ", $nameString);
        array_pop($nameString);
        $nameString = implode($nameString, ' ');
        return $nameString; 
    }

}