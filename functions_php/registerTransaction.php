<?php

    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	session_start();

    require_once("../private_html_protected/config.php");   
    require_once("../private_html_protected/connection.php");   
    require_once("../private_html_protected/database.php");

    $dados['staff_id'] = $_SESSION['usuario']['id'];

    $chain = $_POST['chain'];

    $itens = explode('&',$chain);

    date_default_timezone_set("America/Sao_Paulo");

    foreach($itens as $item){
        $info = explode('_',$item);
        $dados['itens_id'] = $info[0];
        $dados['quantidade'] = $info[1];
        $dados['hora'] = date('H:i:s d/m/Y');
        DBCadastro("transacoes",$dados);
    }
    
    echo '1';