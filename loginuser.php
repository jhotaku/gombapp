<?php

require_once 'OperacionDb.php';

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'GET'){

	if(isset($_GET['loguser']) && isset($_GET['logpass'])){

		$db = new dbop();

		if($db->userLogin($_GET['loguser'], $_GET['logpass'])){

			$response['error'] = false;
			$response['user'] = $db->getUserByUsername($_GET['loguser']);

		}else{

			$response['error'] = true;
			$response['message'] = 'Invalid Username or Password';

		}

	}else{

		$response['error'] = true;
		$response['message'] = 'Parameters are missing';

	}

}else{

	$response['error'] = true;
	$response['message'] = 'Request not allowed';

}

echo json_encode($response);