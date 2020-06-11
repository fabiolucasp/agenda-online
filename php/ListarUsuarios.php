<?php

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {

    $response = '';

    require_once dirname(__FILE__).'/DbConnect.php';

    $db = new DbConnect();

    $conn = $db->connect();

    mysqli_set_charset($conn, "utf8");

    if (mysqli_connect_errno()) {
        $array['erro'] = mysqli_connect_error();
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $sqlSelecionar = "SELECT * FROM `usuarios`";

    $querySelecionar = mysqli_query($conn, $sqlSelecionar);

    if (mysqli_errno($conn) != 0) {
        $array['erro'] = mysqli_error($conn);
        die("Erro no mysql: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($querySelecionar) > 0) {
                //PEGA TODOS OS ELEMENTOS
        while ($row = mysqli_fetch_array($querySelecionar)) {  
        
            $response .= '<tr>
            <td>'.$row["id"].'</td>
            <td>'.$row["tipologin"].'</td>
            <td>'.$row["nome"].'</td>
            <td>'.$row["sobrenome"].'</td>
            <td>'.$row["cpf"].'</td>
            <td>'.$row["telefone"].'</td>
            <td>'.$row["email"].'</td>
            <td>
                <button type="button" name="visualizar" class="btn btn-success btn-xs visualizar" id="' . $row["id"] . '">Visualizar</button>
            </td>
			<td>
				<button type="button" name="editar" class="btn btn-warning btn-xs editar" id="'.$row["id"].'">Editar</button>
			</td>
			<td>
				<button type="button" name="deletar" class="btn btn-danger btn-xs deletar" id="'.$row["id"].'">Excluir</button>
			</td>
		</tr>';

        }
    }
    
}   
else {
    echo "Requisição Inválida.";
}     

echo $response;

?>