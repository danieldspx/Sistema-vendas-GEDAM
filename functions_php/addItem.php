<?php
    
    require_once("../private_html_protected/config.php");   
    require_once("../private_html_protected/connection.php");   
    require_once("../private_html_protected/database.php");

    $dados['nome'] = $_POST['nome'];
    $dados['preco'] = $_POST['preco'];
    $dados['quantidade'] = $_POST['quantidade'];
    $dados['flag'] = $_POST['flag'];
    $dados['color'] = $_POST['color'];
    
    DBCadastro("itens",$dados);
    $clause = "WHERE nome = '".$_POST['nome']."' and preco = '".$dados['preco']."' and quantidade = '".$dados['quantidade']."' and flag = '".$dados['flag']."'";
    $pesquisa = DBSearch("itens",$clause,"id");
    
    echo $pesquisa[0]['id'];
