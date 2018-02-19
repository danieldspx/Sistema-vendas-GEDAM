<?php
    
    require_once("../private_html_protected/config.php");   
    require_once("../private_html_protected/connection.php");   
    require_once("../private_html_protected/database.php");

    $id = $_POST['id'];
    
    DBDelete("itens","WHERE id = $id");
    
    echo "1";
