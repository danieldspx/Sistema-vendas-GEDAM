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

    if(empty($_GET['p'])){
        $pagina_atual = 1;
    } else {
        $pagina_atual = $_GET['p'];
    }
    $qpp = 10;
    $inicio = ($pagina_atual-1)*$qpp; //Pesquisa somente os resultados da pagina
    $pesquisa = DBSearch('transacoes','INNER JOIN itens ON itens.id = itens_id WHERE staff_id = '.$_SESSION['usuario']['id']." ORDER BY id DESC LIMIT $inicio, 10",'transacoes.id AS id,itens.nome AS nome, transacoes.quantidade AS quantidade, transacoes.hora AS hora');
    $pesquisaTotal = DBSearch("transacoes");
    $totalPesquisa = count($pesquisaTotal);
    unset($pesquisaTotal);
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
    <link type="text/css" rel="stylesheet" href="css/registros.css"/>
</head>
<body>
    <button class="waves-effect waves-light  btn logout red lighten-1" onclick="window.location.href+='?logout=1';"><i class="fas fa-sign-out-alt"></i></button>
    <div class="container" style="padding-top: 50px;">
        <?php
            if(!empty($pesquisa)){
        ?>
        <ul class="pagination">
            <li <?php if($pagina_atual!=1){ echo "class='waves-effect grey lighten-2'"; } else { echo "class='disabled grey lighten-2'"; } ?>><a <?php if($pagina_atual!=1){ echo "href='registros.php?p=".($pagina_atual-1)."'"; } ?>><i class="material-icons">chevron_left</i></a></li>
            <?php
                $paginas = ceil($totalPesquisa/10);
                for($i=1;$i<=$paginas;$i++){
                    if($i == $pagina_atual){
                        echo "<li class='active'><a href='registros.php?p=$i'>$i</a></li>";
                    } else {
                        echo "<li class='waves-effect'><a href='registros.php?p=$i'>$i</a></li>";
                    }
                }
                $i--; //Para usar no if da paginacao
            ?>
            <li <?php if($pagina_atual!= $i) { echo "class='waves-effect grey lighten-2'"; } else { echo "class='disabled grey lighten-2'"; } ?>><a <?php if($pagina_atual!= $i){ echo "href='registros.php?p=".($pagina_atual+1)."'"; } ?>><i class="material-icons">chevron_right</i></a></li>
        </ul>
        <table class="striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Hora</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($pesquisa as $item){
                        echo "<tr id='item".$item['id']."'>";
                            echo "<td>".$item['id']."</td>";
                            echo "<td>".$item['nome']."</td>";
                            echo "<td>".$item['quantidade']."</td>";
                            echo "<td>".$item['hora']."</td>";
                            echo "<td><i class='material-icons delete' onclick='deleteTransaction(".$item['id'].")'>delete_forever</i></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <?php } else { ?>
            <h1 class="msgNT" style="text-align: center"><i class="material-icons cloudIcon">cloud_queue</i><br>Não encontramos nenhuma transação registrada.</h1>
        <?php }; ?>
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
    <script type="text/javascript" src="js/registros.js"></script>
</body>
</html>