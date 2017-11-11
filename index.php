<?php
require 'pages/header.php';
require 'classes/anuncios.class.php';
require 'classes/usuarios.class.php';

$a = new Anuncios();
$u = new Usuarios();

$totalAnuncios = $a->getTotalAnuncios();
$totalUsuarios = $u->getTotalUsuarios();

// Criando a paginação
$paginaAtual = 1;

if(isset($_GET['p']) && !empty($_GET['p'])){
    $paginaAtual = addslashes($_GET['p']);
}

$itemPorPagina = 2;
$totalPaginas = ceil($totalAnuncios / $itemPorPagina); // ceil: arredonda o resultado para cima

$anuncios = $a->getUltimosAnuncios($paginaAtual, $itemPorPagina);

?>       
    <div class='container-fluid'>
        <div class='jumbotron'>
            <h2>Nós temos hoje <?=$totalAnuncios?> anúncios cadastrados no sistema</h2>
            <p>E mais <?=$totalUsuarios?> usuários cadastrados</p>
        </div>
        
        <div class='row'>
            <div class='col-sm-3'>
                <h4>Pesquisa Avançada</h4>
            </div>
            <div class='col-sm-9'>
                <h4>Últimos Anúncios</h4>
                
                <table class='table table-striped'>
                    <tbody>
                        <?php foreach($anuncios as $anuncio) {?>
                        
                        <tr>
                            <td>
                                <?php if(!empty($anuncio['url'])){ ?>
                                <img src='assets/images/anuncios/<?=$anuncio['url']?>' height='50' border='0' />
                                <?php }else{ ?>
                                <img src='assets/images/default.png' height='50' border='0' />
                                <? } ?>
                            </td>
                            <td>
                                <a href='produto.php?id=<?=$anuncio['id']?>'><?=$anuncio['titulo']?></a><br/>
                                <?=utf8_encode($anuncio['categoria'])?>
                            </td>
                            <td>
                                R$ <?= number_format($anuncio['valor'],2); ?>
                            </td>
                        </tr>
                        
                        <?php } ?>
                    </tbody>
                </table>
                
                <ul class='pagination'>
                    <?php for($i=1;$i<=$totalPaginas;$i++){ ?>
                           <li class="<?= ($paginaAtual == $i)?'active':''; ?>"><a href='index.php?p=<?=$i?>'><?=$i?></a></li> 
                    <?php } ?>
                </ul>
                
            </div>
        </div>
        
    </div>
        
<?php
require 'pages/footer.php';
?>        
