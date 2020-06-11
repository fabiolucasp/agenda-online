<?php

require_once 'DbOperations.php';
 
$response = array(); 
 
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

    if ( isset($_POST['id']) ) {
       
        $response = '';

        require_once dirname(__FILE__).'/DbConnect.php';
    
        $db = new DbConnect();
    
        $conn = $db->connect();
    
        mysqli_set_charset($conn, "utf8");
    
        if (mysqli_connect_errno()) {
            $array['erro'] = mysqli_connect_error();
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $sqlSelecionar = "SELECT * FROM `usuarios` WHERE `id` = " . $_POST['id'] . "";
    
        $querySelecionar = mysqli_query($conn, $sqlSelecionar);
    
        if (mysqli_errno($conn) != 0) {
            $array['erro'] = mysqli_error($conn);
            die("Erro no mysql: " . mysqli_error($conn));
        }
    
        if (mysqli_num_rows($querySelecionar) > 0) {

            while ($row = mysqli_fetch_array($querySelecionar)) {  
            
                $response = $row;
    
            }
        }
 
    }
    else{

        $response['error'] = true; 

        $response['message'] = "Estão faltando alguns parâmetros.";

    }
}
else {
    $response['error'] = true;
    $response['message'] = "Requisição inválida";
}
 
echo json_encode($response);

?>