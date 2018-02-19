<?php

//Conexão com o MySQL
    function DBConnect(){
        $link = @ mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysqli_connect_error());
        mysqli_set_charset($link, DB_CHARSET) or die(mysqli_error($link));
     
        return $link;
    }
    
 //Fecha Conexão
 function DBclose($link){
     @ mysqli_close($link) or die(mysqli_error($link));
 }
 
 //Adiciona barras invertidas a uma string - Protege contra SQL Injection
 
 function DBEscape($dados,$lower=false){
     $link = DBConnect();
     
     if($lower == true){
         $dados = strtolower($dados);
     }
     
     if(!is_array($dados)){
         $dados = strip_tags($dados); //RETIRA TAGS HTML E PHP
         $dados  = mysqli_real_escape_string($link, $dados);
     } else {
         $arr = $dados;
         foreach($arr as $key => $value){
             $key = mysqli_real_escape_string($link, $key);
             $value = mysqli_real_escape_string($link, $value);
             $value = strip_tags($value);
             $dados[$key] = $value;
         }
         DBclose($link);
         return $dados;
     }
 }