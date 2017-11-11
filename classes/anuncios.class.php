<?php

    class Anuncios{
        
        public function getTotalAnuncios(){
            global $pdo;
            
            $sql = "SELECT COUNT(*) as c FROM anuncios";
            $sql = $pdo->query($sql);
            $row = $sql->fetch();
            
            return $row['c'];
            
        }
        
        public function getUltimosAnuncios($pagina, $itemPorPagina){
            global $pdo;
            
            // Criando a paginação
            $offset = ($pagina - 1) * $itemPorPagina;
            
            
            
            $array = array();
            
            $sql = "SELECT *, (select anuncios_imagens.url from anuncios_imagens
            where anuncios_imagens.id_anuncio = anuncios.id limit 1) as url,
            (select categorias.nome from categorias
            where categorias.id = anuncios.id_categoria) as categoria
            FROM anuncios ORDER BY id DESC LIMIT $offset, 2";
                        
            $sql = $pdo->prepare($sql);
            
            $sql->execute();
            
            if($sql->rowCount() > 0){
                $array = $sql->fetchAll();    
            }
            
            return $array;
        }
        
        public function getMeusAnuncios($id){
            global $pdo;
            $array = array();
            
            $sql = "SELECT *, (select anuncios_imagens.url from anuncios_imagens
            where anuncios_imagens.id_anuncio = anuncios.id limit 1) as url
            FROM anuncios WHERE id_usuario = :id_usuario";
            // Seleciona todos os campos da tabela anuncios, junto com as urls das imagens
            // contidas na tabela anuncios_imagens, limitando a uma imagem
                        
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':id_usuario',$id);
            $sql->execute();
            
            if($sql->rowCount() > 0){
                $array = $sql->fetchAll();    
            }
            
            return $array;
        }
        
        public function getAnuncio($id){
            $array= array();
            global $pdo;
            
            $sql = "SELECT * FROM anuncios WHERE id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':id',$id);
            $sql->execute();
            
            if($sql->rowCount() > 0){
                $array = $sql->fetch();
                $array['fotos'] = array();
                
                // Selecionar as imagens do anúncio
                $sql = "SELECT id, url FROM anuncios_imagens WHERE id_anuncio = :id_anuncio";
                $sql = $pdo->prepare($sql);
                $sql->bindValue(':id_anuncio', $id);
                $sql->execute();
                
                if($sql->rowCount() > 0){
                    $array['fotos'] = $sql->fetchAll();
                }
            }
            
            return $array;           
        }
        
        public function addAnuncio($titulo, $categoria, $valor, $descricao, $estado){
            global $pdo;
            
            $sql = "INSERT INTO anuncios SET id_usuario = :id_usuario, id_categoria = :id_categoria,
            titulo = :titulo, descricao = :descricao, valor = :valor, estado = :estado";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':id_usuario', $_SESSION['cLogin']);
            $sql->bindValue(':id_categoria', $categoria);
            $sql->bindValue(':titulo', $titulo);
            $sql->bindValue(':descricao', $descricao);
            $sql->bindValue(':valor', $valor);
            $sql->bindValue(':estado', $estado);
            $sql->execute();
        }
        
        public function editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $id){
            global $pdo;
            
            // Atualizar as informações do anúncio
            $sql = "UPDATE anuncios SET id_usuario = :id_usuario, id_categoria = :id_categoria,
            titulo = :titulo, descricao = :descricao, valor = :valor, estado = :estado WHERE id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':id_usuario', $_SESSION['cLogin']);
            $sql->bindValue(':id_categoria', $categoria);
            $sql->bindValue(':titulo', $titulo);
            $sql->bindValue(':descricao', $descricao);
            $sql->bindValue(':valor', $valor);
            $sql->bindValue(':estado', $estado);
            $sql->bindValue(':id', $id);
            $sql->execute();
            
            // Atualizar as fotos do anúncio
            if(count($fotos) > 0){
                for($i=0;$i<count($fotos['tmp_name']);$i++){
                    $tipo = $fotos['type'][$i];
                    
                    if(in_array($tipo, array('image/jpeg', 'image/png'))){ // Verifica se o tipo da foto é jpeg ou png
                        $novoNome = md5(time().rand(0, 9999)).'.jpg'; // Cria o novo nome da foto
                        move_uploaded_file($fotos['tmp_name'][$i], 'assets/images/anuncios/'.$novoNome); // Salva a foto na pasta designada
                        
                        // Redimensionar a foto e salvar na pasta local
                        list($width_orig, $height_orig) = getimagesize('assets/images/anuncios/'.$novoNome);
                        $ratio = $width_orig / $height_orig;
                        
                        $width = 500; // Largura máxima que a foto irá ter em px
                        $height = 500; // Altura máxima que a foto irá ter em px
                        
                        if($width / $height > $ratio){ 
                            $width = $height * $ratio;
                        }else {
                            $height = $width / $ratio;
                        }
                        
                        $img = imagecreatetruecolor($width, $height);
                        
                        if($tipo == 'image/jpeg'){
                            $origi = imagecreatefromjpeg('assets/images/anuncios/'.$novoNome);
                        } elseif($tipo == 'image/png'){
                            $origi = imagecreatefrompng('assets/images/anuncios/'.$novoNome);
                        }
                        
                        imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                        
                        imagejpeg($img, 'assets/images/anuncios/'.$novoNome, 80); // Salva a imagem final no formato jpeg
                        
                        // Salvar o nome da foto no banco de dados
                        $sql = "INSERT INTO anuncios_imagens set id_anuncio = :id_anuncio, url = :url";
                        $sql = $pdo->prepare($sql);
                        $sql->bindValue(':id_anuncio', $id);
                        $sql->bindValue(':url', $novoNome);
                        $sql->execute();
                        
                    }
                }
            }
        }
        
             
        public function removerAnuncio($id){
            global $pdo;
            
            //Remover as imagens do anúncio
            $sql = "DELETE FROM anuncios_imagens WHERE id_anuncio = :id_anuncio";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':id_anuncio', $id);
            $sql->execute();
            
            //Remover o anúncio
            $sql = "DELETE FROM anuncios WHERE id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
        }
        
        public function removerFoto($id){
            global $pdo;
            $id_anuncio = 0;
            
            $sql = "SELECT id_anuncio FROM anuncios_imagens WHERE id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
            
            if($sql->rowCount() > 0){
                $row = $sql->fetch();
                $id_anuncio = $row['id_anuncio'];
            }
            
            $sql = "DELETE FROM anuncios_imagens WHERE id = :id";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
            
            return $id_anuncio;
        }  
     
    }   

?>