<?php

require_once 'OperacionDb.php';

$response = array();

if($_SERVER['REQUEST_METHOD'] == 'GET'){

	if(!verifyRequiredParams(array('reguser', 'regpass', 'regemail', 'regname', 'regsur', 'regbdate', 'regid'))){

		$username = $_GET['reguser'];
		$pass = $_GET['regpass'];
		$email = $_GET['regemail'];
		$name = $_GET['regname'];
		$last = $_GET['regsur'];
		$bdate = $_GET['regbdate'];
		$identi = $_GET['regid'];

		$db = new dbop();

		$result = $db->createUser($username, $pass, $email, $name, $last, $bdate, $identi);

		if($result == USER_CREATED){

			$response['error'] = false;
			$response['message'] = 'User created succesfully';

		}else if($result == USER_ALREADY_EXIST){

			$response['error'] = true;
			$response['message'] = 'User already exist';

		}else if($result == USER_NOT_CREATED){

			$response['error'] = true;
			$response['message'] = 'Some error occurred';

		}

	}else {

		$response['error'] = true;
		$responsê['message'] = 'Required parameters are missing';

	}


} else {

	$response['error'] = true;
	$response['message'] = 'Invalid request';

}

function verifyRequiredParams($required_fields)
{
 
    //Getting the request parameters
    $request_params = $_REQUEST;
 
    //Looping through all the parameters
    foreach ($required_fields as $field) {
        //if any requred parameter is missing
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
 
            //returning true;
            return true;
        }
    }
    return false;
}
 
echo json_encode($response);