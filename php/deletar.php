<?php

require_once 'DbOperations.php';
 
$response = array(); 
 
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

    $response = $_POST['id'];

    require_once dirname(__FILE__).'/DbConnect.php';

    $db = new DbConnect();

    $con = $db->connect();

    if (mysqli_connect_errno()) {
        $array['erro'] = mysqli_connect_error();
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $stmt = $con->prepare("DELETE FROM `usuarios` WHERE `id` = " . $_POST['id'] . "");
    $stmt->execute();
}
else {
    $response['error'] = true;
    $response['message'] = "Requisição inválida";
}

?>