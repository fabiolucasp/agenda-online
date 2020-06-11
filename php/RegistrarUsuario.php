<?php
 
require_once 'DbOperations.php';
 
$response = array(); 
 
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

    if ( isset($_POST['nome']) 
    and isset($_POST['sobrenome']) 
    and isset($_POST['datanascimento']) 
    and isset($_POST['rg']) 
    and isset($_POST['cpf']) 
    and isset($_POST['email']) 
    and isset($_POST['telefone']) 
    and isset($_POST['rua']) 
    and isset($_POST['bairro']) 
    and isset($_POST['cidade']) 
    and isset($_POST['estado']) 
    and isset($_POST['quadra']) 
    and isset($_POST['lote']) 
    and isset($_POST['numero']) 
    and isset($_POST['complemento']) 
    and isset($_POST['senha']) 
    and isset($_POST['csenha'])
    and isset($_POST['tipouser']) ) {
       
        $db = new DbOperation(); 

        $result =  $db->cadastrarUsuario( $_POST['nome'], $_POST['sobrenome'], $_POST['datanascimento'], $_POST['rg'], $_POST['cpf'], $_POST['email'], $_POST['telefone'], $_POST['rua'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['quadra'], $_POST['lote'], $_POST['numero'], $_POST['complemento'], $_POST['senha'], $_POST['csenha'], $_POST['tipouser']);
        if ( $result == 1) {

            $response['error'] = false; 

            $response['message'] = "Usuário Cadastrado com sucesso";            

        }
        else{

            if ( $result == 2) {
                
                $response['error'] = true; 

                $response['message'] = "Alguns dados estão errados.";
            }
            else {

                if ( $result == 0) {
                    $response['error'] = true; 

                    $response['message'] = "Usuario ja cadastrado";
                }

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