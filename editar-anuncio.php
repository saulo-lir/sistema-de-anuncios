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
        
        if(isset($_FILES['fotos'])){
            $fotos = $_FILES['fotos'];
        }else {
            $fotos = array();
        }
        
        $anuncio->editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $_GET['id']);
?>
    <div class='alert alert-success'>
        Produto editado com sucesso!
    </div>

<?php        
    }
    
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $dado = $anuncio->getAnuncio($_GET['id']);    
    }else{
?>
        <script type='text/javascript'>window.location.href='meus-anuncios.php';</script>
    
<?php
        exit;
    }        
    
?>


<div class='container'>
    <h1>Editar Anúncio</h1>
    
    <form method='POST' enctype='multipart/form-data'>
        
        <div class='form-group'>
            <label for='categoria'>Categoria</label>
            <select name='categoria' id='categoria' class='form-control'>           
        <?php
            $c = new Categoria();
            $categorias = $c->getLista();
            
            foreach($categorias as $categoria){
        ?>                                               <!--           if(){                                          }else{ }  -->  
                <option value='<?=$categoria['id'];?>' <?= ($dado['id_categoria'] == $categoria['id'])?'selected="selected"':''?> >
                    <?=utf8_encode($categoria['nome']); ?>
                </option> 
        <?php
            }
        ?>        
            </select>
        </div>
        
        <div class='form-group'>
            <label for='titulo'>Título</label>
            <input type='text' name='titulo' id='titulo' class='form-control' value='<?=$dado['titulo']?>'/>
        </div>
        
        <div class='form-group'>
            <label for='valor'>Valor</label>
            <input type='text' name='valor' id='valor' class='form-control' value='<?=$dado['valor']?>'/>
        </div>
        
        <div class='form-group'>
            <label for='descricao'>Descrição</label>
            <textarea name='descricao' class='form-control' ><?=$dado['descricao']?></textarea>
        </div>
        
        <div class='form-group'>
            <label for='estado'>Estado de Conservação</label>
            <select name='estado' id='estado' class='form-control'>
                                  <!--           if(){                          }else{ }     -->  
                <option value='0' <?= ($dado['estado'] == 0)?'selected="selected"':''?>>Ruim</option>
                <option value='1' <?= ($dado['estado'] == 1)?'selected="selected"':''?>>Bom</option>
                <option value='2' <?= ($dado['estado'] == 2)?'selected="selected"':''?>>Ótimo</option>
            </select>
        </div>
        
        <div class='form-group'>
            <label for='add_foto'>Fotos do Anúncio</label>
            <input type='file' name='fotos[]' multiple id='add_foto' class='form-control' /><br/>
            
            <!-- Exibindo as fotos que já existem no anúncio -->
            <div class='panel panel-default'>
                <div class='panel-heading'>Fotos do Anúncio</div>
                <div class='panel-body'>
                    <?php
                        foreach($dado['fotos'] as $foto){
                    ?>
                        <div class='foto-item'>
                            <img src='assets/images/anuncios/<?=$foto['url']?>' class='img-thumbnail' border='0' /><br/>
                            <a href='excluir-foto.php?id=<?=$foto['id']?>' class='btn btn-default'>Excluir imagem</a>
                        </div>
                    <?php        
                        }
                    ?>
                </div>
            </div>
        </div>
        
        <input type='submit' value='Salvar' class='btn btn-primary' />
        
    </form>
       
</div>

<?php
    require 'pages/footer.php';
?>