<?php
    
    require_once("../private_html_protected/config.php");   
    require_once("../private_html_protected/connection.php");   
    require_once("../private_html_protected/database.php");

    $dados['nome'] = $_POST['nome'];
    $dados['preco'] = $_POST['preco'];
    $dados['quantidade'] = $_POST['quantidade'];
    $dados['flag'] = $_POST['flag'];
    $dados['color'] = $_POST['color'];
    $id = $_POST['id'];
    
    DBUpdate("itens","WHERE id = $id",$dados);
    
    echo "1";
