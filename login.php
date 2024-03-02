<?php
include 'config/db_connect.php';

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
	case 'GET':
		echo 'user not find';
		break;
	case 'POST':
		$data = json_decode(file_get_contents('php://input'), true);
		loginUser($data["email"], $data["password"]);
		break;
}



function loginUser($email, $password)
{
	global $connection;
	$response = array();

	$sql = "SELECT * FROM user WHERE email= '" . $email . "' and password = '" . $password . "' ";
	$result = $connection->query($sql);
	$row = $result->fetch_assoc(); // fetch_all();
	if ($result->num_rows > 0) {
		
		$token = getToken($row);
		header("HTTP/1.0 403");
		$response = array(
			'status' => 1,
			'status_message' => 'User Exists.',
			'access token' => $token
		);
	} else {
		header("HTTP/1.0 403");
		$response = array(
			'status' => 1,
			'status_message' => 'User Not Exists.'
		);
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}

function getToken($id){
	$token = bin2hex(random_bytes(16));
	//$row['id'];
	return $token;
}
