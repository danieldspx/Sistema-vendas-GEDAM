<?php
//Executa Query
function DBExecute($query){
//    echo $query;
    $link = DBConnect();
    $result = @mysqli_query($link, $query) or die(mysqli_error($link));
    DBclose($link);
    return $result;
}
//Grava registros

function DBCadastro($table, array $data){
    $data = DBEscape($data);
    $campos = implode(", ",  array_keys($data));
    $valores = "'".implode("', '", $data)."'";

    $query = "INSERT INTO $table ($campos) VALUES ($valores);";
    return DBExecute($query);
}

///Procurar registros
function DBSearch($table, $params=null, $campos='*'){
    $query = trim("SELECT $campos FROM $table $params"); //trim() retira os espaços do inicio e fim da string, o espaço seria no final //caso $params==null
    $result = DBExecute($query);
    if(!mysqli_num_rows($result)){
        return false;
    } else {
        while ($res = mysqli_fetch_assoc($result)){ //Transform a pesquisa em um array
            $data[] = $res;
        }
        return $data;
    }

}

///Deleta registros
function DBDelete($table,$params=null){
    if($param){
        return false;
    }
    $query = "DELETE FROM $table $params";
    return DBExecute($query);
}

//Faz o update dos registros
function DBUpdate($table, $params=null,array $data){
    $data = DBEscape($data);
    $query = "UPDATE $table SET";
    $itens = count($data);
    $contador = 1;
    foreach($data as $key => $value){
        if($contador == $itens){
            $query .= " $key = '$value'";
        } else {
            $query .= " $key = '$value',";
        }
        $contador++;
    }
    $query .= " $params";
    return DBExecute($query);
}