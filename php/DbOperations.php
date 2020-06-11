<?php

	class DbOperation {

		private $con;

		function __construct() {

			require_once dirname(__FILE__).'/DbConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect();

			if (mysqli_connect_errno()) {
				$array['erro'] = mysqli_connect_error();
				die("Connection failed: " . mysqli_connect_error());
			}

		}

		public function atualizarUsuario($id, $nome, $sobrenome, $datanascimento, $rg, $cpf, $email, $telefone, $rua, $bairro, $cidade, $estado, $quadra,  $lote,  $numero,  $complemento,  $senha,  $csenha, $tipouser) {
			
				$query = ' UPDATE `usuarios` SET 
				`nome`= "' . $nome . '",`sobrenome`= "'. $sobrenome . '",
				`datanascimento`= "' . $datanascimento . '",`rg`= "' . $rg . '",
				`cpf`= "' . $cpf . '",`email`= "' . $email . '",`telefone`= "' . $telefone . '",`rua`=
				 "' . $rua . '",`bairro`= "' . $bairro . '",`cidade`= "' . $cidade . '",`estado`=
				  "' . $estado . '",`quadra`= "' . $quadra . '",`lote`= "' . $lote . '",`numero`=
				   "' . $numero . '",`complemento`= "' . $complemento . '",`senha`= "' . $senha . '",`csenha`=
				    "' . $csenha . '",`tipologin`= "' . $tipouser . '" WHERE `id` = "' . $id . '"';
				$stmt = $this->con->prepare($query);
				$stmt->execute();

				return 1;
			

		}


		public function cadastrarUsuario($nome, $sobrenome, $datanascimento, $rg, $cpf, $email, $telefone, $rua, $bairro, $cidade, $estado, $quadra,  $lote,  $numero,  $complemento,  $senha,  $csenha, $tipouser) {

			if ( $this->seUsuarioExistir($nome, $cpf, $telefone, $email) ) {
				return 0;
			}
			else {


				$senha = md5($senha);
				$csenha = md5($csenha);
				
				$stmt = $this->con->prepare("INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `datanascimento`, `rg`, `cpf`, `email`, `telefone`, `rua`, `bairro`, `cidade`, `estado`, `quadra`, `lote`, `numero`, `complemento`, `senha`, `csenha`, `tipologin`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

				$stmt->bind_param("ssssssssssssssssss", $nome,
				$sobrenome,
				$datanascimento,
				$rg,
				$cpf,
				$email,
				$telefone,
				$rua,
				$bairro,
				$cidade,
				$estado,
				$quadra, 
				$lote, 
				$numero, 
				$complemento, 
				$senha, 
				$csenha,
				$tipouser);

				if($stmt->execute()) {
					return 1;
				}
				else {
					return 2;
				}

			}
		}

		public function loginUsuario ($email, $senha, $csenha) {

			$senhaMD5 = md5($senha);
			$csenhaMD5 = md5($csenha);

			$stmt = $this->con->prepare("SELECT id FROM usuarios WHERE email = ? AND senha = ? AND csenha = ?");
			$stmt->bind_param("sss", $email, $senha, $csenha);
			$stmt->execute();
			$stmt->store_result();

			return $stmt->num_rows > 0;

		}

		public function pegarUsuarioPorEmail($email) {

			$stmt = $this->con->prepare("SELECT * FROM usuarios WHERE email = ?");

			if (mysqli_errno($this->con) != 0) {
				$array['erro'] = mysqli_error($this->con);
				die("Erro no mysql: " . mysqli_error($this->con));
			}

			$stmt->bind_param("s", $email);

			if (mysqli_errno($this->con) != 0) {
				$array['erro'] = mysqli_error($this->con);
				die("Erro no mysql: " . mysqli_error($this->con));
			}

			$stmt->execute();

			if (mysqli_errno($this->con) != 0) {
				$array['erro'] = mysqli_error($this->con);
				die("Erro no mysql: " . mysqli_error($this->con));
			}

			return $stmt->get_result()->fetch_assoc();

		}

		private function seUsuarioExistir($nome, $cpf, $telefone, $email) {		
			
			$stmt = $this->con->prepare("SELECT id FROM `usuarios` WHERE `nome` = ? OR `cpf` = ? OR `telefone` = ? OR `email` = ?");

			$stmt->bind_param("ssss", $nome, $cpf, $telefone, $email);

			$stmt->execute();

			$stmt->store_result();

			return $stmt->num_rows > 0;
		}
	}