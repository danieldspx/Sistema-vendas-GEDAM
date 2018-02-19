<?php
    session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
    session_start();
    if(!isset($_SESSION['usuario']['id'])){
        $_SESSION['ERROR'] = "Faça o login!";
        header("Location: index.php");
    }
    if(isset($_GET['logout'])){
        $_SESSION = array();
        session_destroy();
        session_name(md5("security".$_SERVER['REMODE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
	    session_start();
        $_SESSION['ERROR'] = "Você saiu com sucesso!";
        header("Location: index.php");
    }

    require_once("private_html_protected/config.php");   
    require_once("private_html_protected/connection.php");   
    require_once("private_html_protected/database.php");
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
    <script src="js/fontawesome-all.min.js" type="text/javascript"></script>
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <link href="iconfont/material-icons.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link href="css/spectrum.css" rel="stylesheet">
    <link href="css/gerenciar.css" rel="stylesheet">
</head>
<body>
    <button class="waves-effect waves-light  btn logout red lighten-1" onclick="window.location.href+='?logout=1';"><i class="fas fa-sign-out-alt"></i></button>
    <div class="container" style="padding-top: 50px;">
       <div class="itens">
            <?php
                $itens = DBSearch("itens");
                foreach($itens as $item){
                    $id = $item['id'];

                    echo "<div class='row linha$id'>";
                        echo "<div class='input-field col s3'>";
                            echo "<input id='item$id' type='text' value='".$item['nome']."'>";
                            echo "<label for='item$id' >Nome</label>";
                        echo "</div>";
                        echo "<div class='input-field col s1'>";
                            echo "<input id='preco$id' type='number' value='".$item['preco']."'>";
                            echo "<label for='preco$id'>Preço</label>";
                        echo "</div>";
                        echo "<div class='input-field col s1'>";
                            echo "<input id='qtd$id' type='number' value='".$item['quantidade']."'>";
                            echo "<label for='qtd$id'>Quantidade</label>";
                        echo "</div>";
                        echo "<div class='input-field col s3'>";
                            echo "<label class='active'>Venda</label>";
                            echo "<div class='switch'>";
                                if($item['flag']==1){
                                    $flag = "checked";
                                } else {
                                    $flag = "";
                                }
                                echo "<label>
                                        Desativada
                                        <input type='checkbox' $flag id='estoque$id'>
                                        <span class='lever'></span>
                                        Ativada
                                    </label>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class='input-field col s2'>";
                            echo "<input id='color$id' type='text'>";
                            echo "<label for='color$id' style='font-size: .8rem;-webkit-transform: translateY(-140%);transform: translateY(-140%);'>Cor no Gráfico</label>";
                        echo "</div>";
                        echo "<div class='input-field col s2'><i class='material-icons saveIcon mr20' title='Salvar alterações.' onclick='updateItem($id)'>cloud_upload</i><i class='material-icons deleteIcon' title='Delete este item' onclick='deleteItem($id)'>delete_forever</i></div>";
                    echo "</div>";
                }
            ?>
        </div>
        <div class="row left-align" style="margin-top: 50px;">
            <i class="material-icons addItem" title="Adicionar novo item." onclick="appendItem()">add_circle</i>
        </div>
        <div class="fixed-action-btn horizontal click-to-toggle">
            <a class="btn-floating btn-large red">
                <i class="material-icons">menu</i>
            </a>
            <ul>
                <?php include_once "add/navigationButton.php"; ?>
            </ul>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/spectrum.js"></script>
    <script type="text/javascript" src="js/gerenciar.js"></script>
    <script type="text/javascript">
        <?php
            foreach($itens as $item){
                $id = $item['id'];
                echo "$('#color$id').spectrum({color: '".$item['color']."',preferredFormat: 'rgb',showAlpha: true});";
            }
        ?>
    </script>
</body>
</html>