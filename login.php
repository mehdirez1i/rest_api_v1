<?php
include 'config/db_connect.php';

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
	case 'GET':
		echo 'you not access to this oprtion';
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

function getToken($row)
{
	global $connection;
	$t = time();
	$token = bin2hex(random_bytes(16));
	//$row['id'];
	$sql = "SELECT * FROM u_token WHERE user_id= '" . $row['id'] . "' ";
	$result = $connection->query($sql);
	$user = $result->fetch_assoc(); // fetch_all();
	if ($result->num_rows == 0) {
		$sql2 = "INSERT INTO u_token ( user_id, login_time, access_token) VALUES ('" . $row['id'] . "','" . round(microtime(true) * 1000) . "','" . $token . "')";
		$result = $connection->query($sql2);
	} else {
		echo 'something';
		$sql_update = "UPDATE  u_token SET access_token='" . $token . "', login_time ='" . round(microtime(true) * 1000) . "' WHERE  user_id = '" . $row['id'] . "'  ";
		$result = $connection->query($sql_update);
	}
	return $token;
}