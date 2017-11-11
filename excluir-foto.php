<?php

require 'conexao.php';
require 'classes/anuncios.class.php';

// Bloquear usuários não autorizados a acessar essa página
if(empty($_SESSION['cLogin'])){
    header('Location: login.php');  
    exit;
}

$anuncio = new Anuncios();

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id_anuncio = $anuncio->removerFoto($_GET['id']); // Remove a foto e retorna para a mesma página
}

if(isset($id_anuncio)){
    header('Location: editar-anuncio.php?id='.$id_anuncio);
}else {
    header('Location: meus-anuncios.php');    
}

?>