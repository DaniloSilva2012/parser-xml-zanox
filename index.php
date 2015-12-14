<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="cupons-zanox.css">
</head>
<body>
    
<?php 

    include 'classXml.php';
    
    $test = new xmlParser();
    echo $test->initXmlToHtml();
    
?>

<div id="lightbox-zanox" class="lightbox-zanox">
    <div class="top row">
        <div class="extra-info">
            <div class="toggle-content" data-toggle-tab="info" style="display:block;">
                <span class="heading">
                        <!--Aqui está seu cupom da <strong>Netshoes</strong>-->
                </span>
                <span class="sub-heading">
                    <!--Cupom 50% OFF no segundo item!-->
                </span>
                <p class="description">
                <!--Ganhe 50% OFF no segundo item de menor valor ao inserir este código no carrinho! Promoção não cumulativa. Exceto combos, bicicletas, equipamentos de fitness, eletrônicos, games, saúde e bem-estar, jogos de mesa e produtos com selo Lançamento, Natal e Collection.--></p>
            </div>
        </div>
        <hr>
        <div class="go-to-wrapper">
            <div class="copy">
                <input type="text" name="code" class="inputCode" value="50off">
                <button data-track="Copy code clicked" class="copy-btn" data-clipboard-text="">
                    Copiar
                </button>
            </div>
            <span>
                Ir à loja <span>▶</span>
            </span>
        </div>
    </div>
</div>
<div class="lightbox-zanox-opacity" id="lightbox-zanox-opacity"></div>
<script src="cupons-zanox.js" async="true"></script>
</body>
</html>
