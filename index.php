<?php
    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
    session_start();
    if(isset($_SESSION['usuario']['id'])){
        header('Location: main.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <title>Gedam</title>
    <link rel="sortcut icon" href="img/favicon/icon.png" type="image/png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="css/animate.min.css"/>
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <link href="iconfont/material-icons.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="row center">
        <h1 class="titulo">SGV CEDAF</h1>
        <h2 class="subtitulo">Um sistema criado para gerenciar as vendas pela Gestao de 2017</h2>
    </div>
    <div class="login">
        <div class="row">
            <form action="valida.php" name="login_form" class="col s12 login-form" method="post">
                <div class="input-field col s10 offset-s1">
                    <i class="material-icons prefix">email</i>
                    <input id="usuario" name="usuario" type="text" usuarioclass="validate">
                    <label for="usuario">Usuário</label>
                </div>
                <div class="input-field col s10 offset-s1">
                    <i class="material-icons prefix">lock</i>
                    <input id="senha" name="senha" type="password" class="validate">
                    <label for="senha">Senha</label>
                </div>
            </form >
            <span class="center">
                <button class="waves-effect waves-light btn green accent-2" onclick="document.login_form.submit()">Entrar <i class="material-icons middle">input</i></button>
            </span>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.js"><\/script>')</script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script>
        <?php
            if(isset($_SESSION['ERROR'])){
                echo "Materialize.toast('".$_SESSION['ERROR']."', 4000, 'red lighten-1');";
            }
            unset($_SESSION['ERROR']);
        ?>
    </script>
</body>
</html>