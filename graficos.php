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


        
    function printData($dados){

        $total = count($dados);
        $contador = 1;
        foreach($dados as $dado){
            if($contador == $total){
                echo "'".$dado."'";
            } else {
                echo "'".$dado."',";
            }
            $contador++;
        }
    }
///--------------------------------------- Grafico de Vendas -------------------------------
    $pesquisa = DBSearch("transacoes","INNER JOIN itens ON itens.id = itens_id GROUP BY itens_id ASC","itens.nome AS label, SUM(transacoes.quantidade) as quantidade, itens.color AS color"); //Busca da quantidade vendida
    $i = 0;
    foreach($pesquisa as $item){
        $label[$i] = $item['label'];
        $color[$i] = $item['color'];
        $quantidade[$i] = $item['quantidade'];
        $border[$i] = "rgba(0, 0, 0, .8)";
        $i++;
    }
///-----------------------------------------------------------------------------------------

///--------------------------------------- Grafico de Valores ------------------------------
    $pesquisa2 = DBSearch("transacoes","INNER JOIN itens ON itens.id = itens_id GROUP BY itens_id ASC","itens.nome AS label, SUM(transacoes.quantidade*itens.preco) AS valor"); //Busca dos valores recebidos com cada item
    $i = 0;
    $totalVendido = 0;
    foreach($pesquisa2 as $item){
        $label2[$i] = $item['label'];
        $valor[$i] = $item['valor'];
        $totalVendido += $valor[$i];
        $i++;
    }
///-----------------------------------------------------------------------------------------

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
    <style type="text/css">
        body{
            background: -webkit-radial-gradient(circle, #ffffff, #f7f7f7, #ecf0f1); 
            background: -o-radial-gradient(circle, #ffffff, #f7f7f7, #ecf0f1);
            background: -moz-radial-gradient(circle, #ffffff, #f7f7f7, #ecf0f1);
            background: radial-gradient(circle, #ffffff, #f7f7f7, #ecf0f1); 
        }
        .cfontblack{
            color: black;
        }
        .logout{
            position: fixed;
            margin-top: 0px;
            width: auto;
            right: 10px;
        }
        .showRaised{
            text-align: center;
            position: relative;
            font-size: 3em;
            padding: 20px 0px;;
            border-radius: 8px;
            width: 50%;
            left: 25%;
            color: #333;
            font-weight: 800;
            background: #0cebeb;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #29ffc6, #20e3b2, #0cebeb);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #29ffc6, #20e3b2, #0cebeb); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
    </style>
</head>
<body>
    <button class="waves-effect waves-light  btn logout red lighten-1" onclick="window.location.href+='?logout=1';"><i class="fas fa-sign-out-alt"></i></button>
    <div class="container" style="padding-top: 50px;">
       <div class="row">
           <div class="showRaised">Valor arrecadado<br>R$ <?php echo $totalVendido; ?></div>
       </div>
        <div class="row">
            <div class="col s5">
                <h4 style="text-align: center">Gráfico de Vendas</h4>
                <canvas id="vendasChart" width="400px" height="400px"></canvas>
            </div>
            <div class="col s5 push-s2">
                <h4 style="text-align: center">Gráfico de Valores</h4>
                <canvas id="valoresChart" width="400px" height="400px"></canvas>
            </div>
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
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <script type="text/javascript">
        Chart.defaults.global.defaultFontSize = 15;
        var veChart = document.getElementById("vendasChart").getContext('2d');
        var vaChart = document.getElementById("valoresChart").getContext('2d');
        var createChart = new Chart(veChart,{
            type: 'doughnut',
            data: {
                labels: [<?php printData($label); ?>],
                datasets: [{
                    data: [<?php printData($quantidade); ?>],
                    backgroundColor: [<?php printData($color); ?>],
                    borderColor: [<?php printData($border); ?>],
                    borderWidth: 1
                }]
            }
        });
        var createChart2 = new Chart(vaChart,{
            type: 'doughnut',
            data: {
                labels: [<?php printData($label2); ?>],
                datasets: [{
                    data: [<?php printData($valor); ?>],
                    backgroundColor: [<?php printData($color); ?>],
                    borderColor: [<?php printData($border); ?>],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>