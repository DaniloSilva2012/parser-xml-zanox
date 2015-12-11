<?php

//include 'test.php';
class xmlParser {
    
     public function curlXml(){
        //$start = microtime(true);
        $ch = curl_init();

        // informar URL e outras funções ao CURL
        curl_setopt($ch, CURLOPT_URL, "http://api.zanox.com/xml/2011-03-01/incentives/?connectid=DC00C374EE28B3DF5859&region=BR&adspace=2059117&incentiveType=coupons");
        //curl_setopt($ch, CURLOPT_USERAGENT, ‘My custom web spider/0.1’);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FILETIME, true);
        curl_close($ch);
        
        //echo microtime(true) - $tart;
        return curl_exec($ch);
    }
    
    public function createXml(){
        $url = 'http://api.zanox.com/xml/2011-03-01/incentives/?connectid=DC00C374EE28B3DF5859&region=BR&adspace=2059117&incentiveType=coupons';
        $xml = new SimpleXMLElement(file_get_contents($url));
        $xml->asXML("zanox.xml");
        return $xml;
    }

    
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
    
    
    public function filterXml(){
        
        $xml = $this->readXml();
        
        try{
            $parent = $xml->incentiveItems;
            $itens = $parent->incentiveItem;
            $html = '';
            $arrayPrograms = array();
            
            foreach($itens as $item){
                $program = $item->program;
                $loja = $item->loja;
                $name = $item->name;
                $endDate = $item->endDate;
                $description = $item->description;
                $htmlItem = '';
                
                $arrayPrograms[] = $program;
                
                //$nameString = $this->revealName($program);
                $nameString = explode($program);
                $nameString = array_shift($name);
                $nameString = array_pop($name);

                //Natue

                print_r($nameString);
                
                echo $nameString;
                //if(!in_array($program, $arrayPrograms)){
                    $htmlItem .='<h2 class="h-cupom" id="h-cupom-'.$nameString.'">Cupons '.$program.'</h2>';
                //}
                
                $htmlItem .='<div class="campo-cupom">';
                $htmlItem .='<span class="logo-cupom"><img src="http://outlet.papofitness.com.br/wp-content/themes/outlet-papofit/images/logo-cupom/cupom-desconto-logo-'.$nameString.'.jpg"></span>';
                $htmlItem .='<h3 class="titulo-cupom">'.$name.'</h3><p class="prazo-cupom">Válido até '.$endDate.'</p>';
                $htmlItem .='<p class="info-cupom">Mais informações <span>'.$description.'</span></p>';
                $htmlItem .='<a class="botao-cupom"><img src="http://outlet.papofitness.com.br/wp-content/uploads/2015/12/botao-ver-cupom.jpg"></a></div>';
                
                $html .= $htmlItem;
            }
            
            echo $html;
            
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }
    
    public function revealName($program){
        $name = explode($program);
        $name = array_shift($name);
        $name = array_pop($name);
        
        //Natue
        
        print_r($name);
        
        return implode($name, ' ');
        //case in_array('hotel urbano', $program): echo 'teste ';
        //echo in_array('kanui', $program);
        //echo in_array('netshoes', $program);
        //echo in_array('dafiti', $program);                
    }
    
    

}