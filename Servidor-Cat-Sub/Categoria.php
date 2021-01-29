<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, POST, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: text/html; charset=utf-8");

include "Connect/connect.php";

$postjson = json_decode(file_get_contents('php://input'), true);


try {

  

if ($postjson['crud'] == 'Listar-Categorias') {
    
          
    $query = mysqli_query($mysqli,"SELECT * FROM categoria");

   

        While($row = mysqli_fetch_array($query)){
     
            $id = $row['id'];
     
             $query2 = mysqli_query($mysqli,"SELECT s.id, s.produto, s.categoria_id
                                             FROM
                                             subcategoria AS s INNER JOIN categoria AS c ON (s.categoria_id = c.id)
                                             WHERE c.id = $id ");
     
             foreach ($query2 as $key => $value) {
                
     
                 $data2[$key] = [
     
                     'id'                  => $value['id'],
                     'produto'             => $value['produto'],
                     'categoria_id'        => $value['categoria_id']
                
                 ];
             }
     
                 $data[] = [
     
     
                 'id'              => $row['id'],
                 'nome'            => $row['nome'],
                 'subcategoria'    => $data2
     
             ];

           
         }

         if ($query) $result = json_encode(array('success' => true, 'result' => $data));
         else $result = json_encode(array('success' => false));
         echo $result;
   
}


}



catch (Exception $e) {
echo "Erro: " . $e->getMessage();
};
