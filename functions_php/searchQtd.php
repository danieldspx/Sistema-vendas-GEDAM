<?php

    require_once("../private_html_protected/config.php");   
    require_once("../private_html_protected/connection.php");   
    require_once("../private_html_protected/database.php");

    $pesquisa = DBSearch("itens","WHERE flag = 1","id,quantidade");
    
    $contador = 1;
    
    $totalItens = count($pesquisa);

    foreach($pesquisa as $item){
        if($contador == $totalItens){
            echo $item['id']."-".$item['quantidade'];
        } else {
            echo $item['id']."-".$item['quantidade']."&";
        }
        $contador++;
    }