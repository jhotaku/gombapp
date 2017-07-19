<?php

class dbop{

	private $conn;

	function __construct(){

		require_once 'Constantes.php';
		require_once 'ConexionDb.php';

		$db = new dbcon();
		$this->conn = $db->connect();

	}

	public function userLogin($username, $pass){

		$stmt = $this->conn->prepare("SELECT id FROM seusuarios WHERE cusuario = ? AND cpassword = ?");
		$stmt->bind_param("ss", $username, $pass);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows > 0;

	}

	public function getUserByUsername($username){

		$stmt = $this->conn->prepare("SELECT id, xnombre, xapellido, xemail, cidentificacion FROM seusuarios WHERE cusuario = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($id, $name, $last, $email, $identi);
		$stmt->fetch();
		$user = array();
		$user['id'] = $id;
		$user['nombre'] = $name;
		$user['apellido'] = $last;
		$user['email'] = $email;
		$user['identi'] = $identi;
		return $user;

	}

	public function createUser($username, $pass, $email, $name, $last, $bdate, $identi){

		if(!$this->isUserExist($username, $email)){
			$stmt = $this->conn->prepare("INSERT INTO seusuarios (cusuario, cpassword, xnombre, xapellido, fnacimiento, cidentificacion, xemail) VALUES (?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssss", $username, $pass, $name, $last, $bdate, $identi, $email);
			if($stmt->execute()){
				
				return USER_CREATED;

				$admin_email = 'gombapp@gmail.com';
				$subject = 'Money Back Register';
				$comment = 'Hi';

				mail($email, $subject, $comment, "From:" . $admin_email);

			}else{
				return USER_NOT_CREATED;
			}
		}else{
			return USER_ALREADY_EXIST;
		}

	}

	private function isUserExist($username, $email){

		$stmt = $this->conn->prepare("SELECT id FROM seusuarios WHERE cusuario = ? OR xemail = ?");
		$stmt->bind_param("ss", $username, $email);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows > 0;
	}

}