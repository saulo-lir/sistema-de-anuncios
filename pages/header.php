<?php
    require './conexao.php';
?>

<html>
    <head>
        <meta charset='utf-8' />
        <title>Classificados</title>
        <link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css' />
        <link rel='stylesheet' type='text/css' href='assets/css/layout.css' />
        
    </head>
    <body>
        <nav class='navbar navbar-inverse'>
            <div class='container-fluid'>
                <div class='navbar-header'>
                    <a href='./' class='navbar-brand'>Classificados</a>
                </div>
                <ul class='nav navbar-nav navbar-right'>
                    <?php
                        if(isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])){
                            
                    ?>
                        <li><a href='meus-anuncios.php'>Meus Anúncios</a></li>
                        <li><a href='sair.php'>Sair</a></li>
                    <?php
                        }else{
                    ?>
                        <li><a href='cadastre-se.php'>Cadastre-se</a></li>
                        <li><a href='login.php'>Login</a></li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
        </nav>