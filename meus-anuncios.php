<?php
    require 'pages/header.php';
?>

<?php
// Bloquear usuários não autorizados a acessar essa página

if(empty($_SESSION['cLogin'])){
    
?>
    <script type='text/javascript'>window.location.href='login.php';</script>
    
<?php
    exit;
    
    }
?>

<div class='container'>
    <h1>Meus Anúncios</h1>
    
    <a href='add-anuncio.php' class='btn btn-default'>Adicionar Anúncio</a>
    
    <table class='table table-striped'>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Título</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <?php
            require 'classes/anuncios.class.php';
            $a = new Anuncios();
            $anuncios = $a->getMeusAnuncios($_SESSION['cLogin']);
            
            foreach($anuncios as $anuncio){
        ?>
        <tbody>
            <tr>
                <td><img src='assets/images/anuncios/<?=$anuncio['url']?>' border='0' /></td>
                <td><?= $anuncio['titulo']; ?></td>
                <td>R$ <?= number_format($anuncio['valor'],2); ?></td>
                <td></td>
            </tr>
        </tbody>    
        
        <?php        
            }
        ?>
        
    </table>
        
</div>



<?php
    require 'pages/footer.php';
?>