<?php

require_once 'DbOperations.php';
 
$response = array(); 
 
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

    $response = $_POST['id'];
}
else {
    $response['error'] = true;
    $response['message'] = "Requisição inválida";
}
 
echo json_encode($response);


$fp = fopen('../alterar.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);


?>