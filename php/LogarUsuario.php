<?php

require_once 'DbOperations.php';
 
$response = array(); 

$user = array();
 
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	if ( isset($_POST['email']) and isset($_POST['senha']) and isset($_POST['csenha']) ) {

		$db = new DbOperation();

		if ($db->loginUsuario( $_POST['email'], $_POST['senha'], $_POST['csenha'] ) ) {

			$user = $db->pegarUsuarioPorEmail( $_POST['email'] );

			$response['error'] = false;

			$response['senha'] = $user['senha'];			

			$response['email'] = $user['email']; 

			$response['csenha'] = $user['csenha'];

		}
		else {

			$response['error'] = true; 

        	$response['message'] = "Esse usuário não existe!!!";

		}

	}
	else{

        $response['error'] = true; 

        $response['message'] = "Existe algum erro nos valores passados via POST.";
    }

}
else {

	$response['error'] = true; 

	$response['message'] = "A requisição feita não é do tipo POST! Conexão recusada.";
	
}

echo json_encode($response);