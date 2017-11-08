<?php
session_start();

global $pdo; // Permite que a variável seja usada em todos os arquivos

try{
    $pdo = new PDO('mysql:dbname=site_classificados;host=localhost','root','');

}catch(PDOException $ex){
    echo 'Erro: '.$ex->getMessage();
    exit;
}

?>