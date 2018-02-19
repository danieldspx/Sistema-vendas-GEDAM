<?php
    
    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
    session_start();

    function redirect_login($issue){
        $_SESSION['ERROR'] = $issue;
        header('Location: index.php');
        exit();
    }

    $usuario = addslashes($_POST['usuario']);
    $senha = md5($_POST['senha']);
    
    if(isset($usuario) && isset($senha)){
        require_once("private_html_protected/config.php");   
        require_once("private_html_protected/connection.php");   
        require_once("private_html_protected/database.php"); 
        
        $validar = DBSearch("staff","WHERE usuario = '$usuario' AND senha = '$senha' LIMIT 1");
        if(isset($validar) && $usuario = $validar[0]['usuario'] && $senha = $validar[0]['senha']){
            $_SESSION['usuario']['id'] = $validar[0]['id'];
            header('Location: painel.php');
            exit();
        } else {
            redirect_login("E-mail ou senha inválidos.");
        }
        
    } else {
        redirect_login("Digite o E-mail e a senha.");
    }