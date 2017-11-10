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
    $anuncio->removerAnuncio($_GET['id']);
}

header('Location: meus-anuncios.php');

?>