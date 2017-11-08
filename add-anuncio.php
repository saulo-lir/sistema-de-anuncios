<?php
    require 'pages/header.php';
    require 'classes/categoria.class.php';
    require 'classes/anuncios.class.php';
?>

<?php
// Bloquear usuários não autorizados a acessar essa página

if(empty($_SESSION['cLogin'])){
    
?>
    <script type='text/javascript'>window.location.href='login.php';</script>
    
<?php
    exit;
    
    }
       
    $anuncio = new Anuncios();
    
    if(isset($_POST['titulo']) && !empty($_POST['titulo'])){
        $titulo = addslashes($_POST['titulo']);
        $categoria = addslashes($_POST['categoria']);
        $valor = addslashes($_POST['valor']);
        $descricao = addslashes($_POST['descricao']);
        $estado = addslashes($_POST['estado']);
        
        $anuncio->addAnuncio($titulo, $categoria, $valor, $descricao, $estado);
?>
    <div class='alert alert-success'>
        Produto anunciado com sucesso!
    </div>

<?php        
    }    
?>

<div class='container'>
    <h1>Adicionar Anúncio</h1>
    
    <form method='POST' enctype='multipart/form-data'>
        
        <div class='form-group'>
            <label for='categoria'>Categoria</label>
            <select name='categoria' id='categoria' class='form-control'>           
        <?php
            $c = new Categoria();
            $categorias = $c->getLista();
            
            foreach($categorias as $categoria){
        ?>      
                <option value='<?=$categoria['id']?>'><?=utf8_encode($categoria['nome']); ?></option> 
        <?php
            }
        ?>        
            </select>
        </div>
        
        <div class='form-group'>
            <label for='titulo'>Título</label>
            <input type='text' name='titulo' id='titulo' class='form-control' />
        </div>
        
        <div class='form-group'>
            <label for='valor'>Valor</label>
            <input type='text' name='valor' id='valor' class='form-control' />
        </div>
        
        <div class='form-group'>
            <label for='descricao'>Descrição</label>
            <textarea name='descricao' class='form-control' ></textarea>
        </div>
        
        <div class='form-group'>
            <label for='estado'>Estado de Conservação</label>
            <select name='estado' id='estado' class='form-control'>
                <option value='0'>Ruim</option>
                <option value='1'>Bom</option>
                <option value='2'>Ótimo</option>
            </select>
        </div>
        
        <input type='submit' value='Anunciar' class='btn btn-primary' />
        
    </form>
       
</div>

<?php
    require 'pages/footer.php';
?>