<?php

    class Anuncios{
        
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
        
        public function editAnuncio($titulo, $categoria, $valor, $descricao, $estado,$id){
            global $pdo;
            
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
        
        
        
     
    }   

?>