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
    <html>

    <head>
        <link rel="stylesheet" href="css/reset.min.css">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Gedam</title>
        <link rel="sortcut icon" href="img/favicon/icon.png" type="image/png" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <link href="css/icon.min.css" rel="stylesheet">
        <script src="js/fontawesome-all.min.js" type="text/javascript"></script>
        <!--Import materialize.css-->
        <link rel="stylesheet" href="css/materialize.min.css" type="text/css" media="screen,projection"/>
        <link rel="stylesheet" href="css/animate.css" type="text/css">
        <link rel="stylesheet" href="css/painel.css">
    </head>

    <body>
        <button class="waves-effect waves-light  btn logout red lighten-1" onclick="window.location.href+='?logout=1';"><i class="fas fa-sign-out-alt"></i></button>
        <div class="container col s12">
            <header class="col s12">
                <div class="row">
                    <div class="input-field col s2" style="margin-left: 10px">
                        <i class="material-icons prefix">shopping_basket</i>
                        <input id="totalInput" type="text" readonly class="totalVenda inputMoneySize">
                        <label for="totalInput">Total (R$)</label>
                    </div>
                    <div class="input-field col s2">
                        <i class="material-icons prefix">payment</i>
                        <input id="pagamentoInput" type="text" class="moneyVenda inputMoneySize">
                        <label for="pagamentoInput">Pagamento</label>
                    </div>
                    <a class="waves-effect waves-light btn green lighten-1" style="font-weight: 700" onclick="openPayment()">Pagar</a>
                    <div class="splitter"></div>
                    <a href="graficos.php"><button class="waves-effect waves-light btn-large red accent-2 btnTop">Gráficos</button></a>
                    <div class="splitter"></div>
                    <a href="registros.php?p=1"><button class="waves-effect waves-light btn-large cyan darken-1 btnTop">Registros</button></a>
                </div>
                <hr class="separador" class="row col s12">
            </header>
            <div class="main">
               <?php
                    $itens = DBSearch("itens","WHERE flag = 1");
                    $contador = 1;
                    $TotalItens = count($itens);
                    $contadorTotal = 1;
                    foreach($itens as $item){
                        if($contador == 1){
                            echo "<div class='row col s12'>";
                        }
                                $idItem = $item['id'];
                                echo "<div class='col s4 foodItem'>";
                                    echo "<label class='nameItem col s6' title='R$ ".$item['preco']."' id='nome$idItem'>".$item['nome']."</label>";
                                    echo "<i class='material-icons plus col s1' data-reference='item$idItem' onclick='plusItem($idItem)'>add_circle</i>";
                                    echo "<input type='number' class='input-field col s2 qtdItemInput' data-reference='$idItem' value='0' id='item$idItem'>";
                                    echo "<i class='material-icons minus npl col s1' data-reference='item$idItem' onclick='minusItem($idItem)'>remove_circle</i>";
                                echo "</div>";
                        if($contador == 3 || $TotalItens == $contadorTotal){
                            echo "</div>";
                        }
                        if($contador==3){
                            $contador = 1;
                        } else {
                            $contador++;
                        }
                        $contadorTotal++;
                    }
                ?>
            </div>
            <div class="fixed-action-btn horizontal click-to-toggle">
                <a class="btn-floating btn-large red">
                    <i class="material-icons">menu</i>
                </a>
                <ul>
                    <li><a class="btn-floating light-blue lighten-3" onclick="clearEverything()"><i class="material-icons" title="Limpar input's">clear</i></a></li>
                    <?php include_once "add/navigationButton.php"; ?>
                </ul>
            </div>
            <div class="poupup">
                <div class="inside">
                    <i class="material-icons closeTop" onclick="closePayment()">clear</i>
                    <table class="popTable">
                        <tr>
                            <td class="lw">Total:</td>
                            <td>R$</td>
                            <td class="rw" id="popTotal"></td>
                        </tr>
                        <tr>
                            <td class="lw">Valor Pago:</td>
                            <td style="border-bottom: 3px #ef5350 solid;">R$</td>
                            <td class="rw" id="popPago" style="border-bottom: 3px #ef5350 solid;"></td>
                        </tr>
                        <tr>
                            <td class="lw">Troco:</td>
                            <td>R$</td>
                            <td class="rw" id="popTroco"></td>
                        </tr>
                    </table>
                    <a class="waves-effect waves-light btn-large popBtn" style="margin-left: 100px;" id="btnTransaction" onclick="registerTransation()"><i class="material-icons right"><i class="material-icons">check_circle</i></i>Pagar</a>
                    <a class="waves-effect waves-light btn-large popBtn red lighten-1" onclick="closePayment()"><i class="material-icons right"><i class="material-icons">cancel</i></i>Cancelar</a>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/painel.js"></script>
        <script type="text/javascript" src="js/jquery.maskMoney.min.js"></script>
    </body>

    </html>
