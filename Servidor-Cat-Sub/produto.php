<?php
 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, POST, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: text/json; charset=utf-8");


include "Connect/connect.php";

$postjson = json_decode(file_get_contents('php://input'),true);



if($postjson['crud'] == "listar-produtos"){

        $data = array();
       
        $query = mysqli_query($mysqli, "SELECT 
        p.id                 as id,
        p.data               as data,
        p.codigo             as codigo,
        p.barra              as barra,
        p.nome               as nome,
        p.aplicacao          as aplicacao,
        p.qtd                as qtd,
        p.valor_compra       as valor_compra,
        p.valor_venda        as valor_venda,
        p.categoria_id       as categoria_id,
        p.subcategoria_id    as subcategoria_id,
        p.marca_id           as marca_id,
        p.veiculo_id         as veiculo_id,
        p.fornecedor_id      as fornecedor_id,
        c.nome               as categoria,
        f.nome               as fornecedor_nome,
        f.fone               as fornecedor_fone,
        f.email              as fornecedor_email,
        s.produto            as subcategoria,
        v.nome               as veiculo,
        p.foto               as foto
        FROM
        produto AS p
        INNER JOIN
        categoria AS c ON (c.id = p.categoria_id)
        INNER JOIN
        subcategoria AS s ON (s.id = p.subcategoria_id)
        INNER JOIN
        marca AS m ON (m.id = p.marca_id)
        INNER JOIN
        veiculo AS v ON (v.id = p.veiculo_id)
        INNER JOIN
        fornecedor AS f ON (f.id = p.fornecedor_id) order by p.id ASC LIMIT $postjson[start], $postjson[limit]");

        while($row = mysqli_fetch_array($query)){
            $data[] = array(

				'id'                       => $row['id'],
				'data'                     => $row['data'],
				'codigo'                   => $row['codigo'],
				'barra'                    => $row['barra'],
				'nome'                     => $row['nome'],
				'aplicacao'                => $row['aplicacao'],
				'qtd'                      => $row['qtd'],
				'valor_compra'             => $row['valor_compra'],
				'valor_venda'              => $row['valor_venda'],
				'categoria_id'             => $row['categoria_id'],
				'subcategoria_id'          => $row['subcategoria_id'],
				'marca_id'                 => $row['marca_id'],
				'veiculo_id'               => $row['veiculo_id'],
				'fornecedor_id'            => $row['fornecedor_id'],
				'categoria'                => $row['categoria'],
				'fornecedor_nome'          => $row['fornecedor_nome'],
				'fornecedor_fone'          => $row['fornecedor_fone'],
				'fornecedor_email'         => $row['fornecedor_email'],
				'subcategoria'             => $row['subcategoria'],
				'veiculo'                  => $row['veiculo'],
				'foto'                     => $row['foto']
				
            );
        }

        if($query) $result = json_encode(array('success' => true,'result' =>$data));
        else $result = json_encode(array('success'=> false));
        echo $result;

    }


	elseif($postjson['crud'] == "adicionar"){
       
        $data = array();

        $radom     = date('Y-m-d_H_i_s');

        $entry     = base64_decode($postjson['foto']);

        $img       = imagecreatefromstring($entry);

        $directory = "./imgs/img_user".$radom.".jpg";

        imagejpeg($img, $directory);

        imagedestroy($img);
    
        $query   = mysqli_query($mysqli, "INSERT INTO produto SET
                   
                   
                   referencia         = '$postjson[referencia]',
                   codigo             = '$postjson[codigo]',
                   barra              = '$postjson[barra]',
                   foto               = '$directory',
                   marca_id           = '$postjson[marca_id]',
                   modelo_id          = '$postjson[modelo_id]',
                   categoria_id       = '$postjson[categoria_id]',
                   fabricante_id      = '$postjson[fabricante_id]',
                   usuario_id         = '$postjson[usuario_id]',
                   valor_compra       = '$postjson[valor_compra]',
                   valor_venda        = '$postjson[valor_venda]',
                   aplicacao          = '$postjson[aplicacao]',
                   qtd                = '$postjson[qtd]'


                   ");
    
        $idadd = mysqli_insert_id($mysqli);
    
        if($query) $result = json_encode(array('success' => true, 'idadd' => $idadd));
        else $result = json_encode(array('success'=> false));
        echo $result;

       
    
        }  
        
        elseif($postjson['crud'] == "editar-produto"){
  

        $data = array();

        $radom     = date('Y-m-d_H_i_s');

        $entry     = base64_decode($postjson['foto']);

        $img       = imagecreatefromstring($entry);

        $directory = "./imgs/img_user".$radom.".jpg";

        imagejpeg($img, $directory);

        imagedestroy($img);
  
        $query   = mysqli_query($mysqli, "UPDATE produto SET
	           
                   codigo             = '$postjson[codigo]',
                   barra              = '$postjson[barra]',
                   referencia         = '$postjson[referencia]',
                   foto               = '$directory',
                   marca_id           = '$postjson[marca_id]',
                   modelo_id          = '$postjson[modelo_id]',
                   categoria_id       = '$postjson[categoria_id]',
                   valor_compra       = '$postjson[valor_compra]',
                   valor_venda        = '$postjson[valor_venda]',
                   aplicacao          = '$postjson[aplicacao]',
                   qtd                = '$postjson[qtd]',
                   fabricante_id      = '$postjson[fabricante_id]'  WHERE id  = '$postjson[id]'");
    

        if($query) $result = json_encode(array('success'=>true));
        else $result = json_encode(array('success'=>false));
        echo $result;

        
       
    }


    elseif($postjson['crud'] == "editar-produto2"){
  

        $data = array();

  
        $query   = mysqli_query($mysqli, "UPDATE produto SET
	           
                   codigo             = '$postjson[codigo]',
                   barra              = '$postjson[barra]',
                   referencia         = '$postjson[referencia]',
                   foto               = '$postjson[foto]',
                   marca_id           = '$postjson[marca_id]',
                   modelo_id          = '$postjson[modelo_id]',
                   categoria_id       = '$postjson[categoria_id]',
                   valor_compra       = '$postjson[valor_compra]',
                   valor_venda        = '$postjson[valor_venda]',
                   aplicacao          = '$postjson[aplicacao]',
                   qtd                = '$postjson[qtd]',
                   fabricante_id      = '$postjson[fabricante_id]'  WHERE id  = '$postjson[id]'");
    

        if($query) $result = json_encode(array('success'=>true));
        else $result = json_encode(array('success'=>false));
        echo $result;

        
       
    }




    elseif ($postjson['crud'] == "deletar") {

        $query   = mysqli_query($mysqli, "DELETE FROM produto WHERE id  = '$postjson[id]'");
    
    
        if ($query) $result = json_encode(array('success' => true));
        else $result = json_encode(array('success' => false, 'msg' => 'error, Por favor, tente novamente... '));
        echo $result;
    }
?>