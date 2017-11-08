<?php

    class Anuncios{
        
        public function getMeusAnuncios($id){
            global $pdo;
            $array = array();
            
            $sql = "SELECT *, (select anuncios_imagens.url from anuncios_imagens
            where anuncios_imagens.id_anuncio = anuncio.id limit 1) as url
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
        
        
    }




?>