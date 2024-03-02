<?php
include 'config/db_connect.php';

// $sql = 'SELECT id, name, phone, email  FROM user';

// $result = mysqli_query($connection, $sql);
// $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
// mysqli_free_result($result);
// mysqli_close($connection);

// header('Content-Type: application/json');
// echo json_encode($user);

$request_method = $_SERVER["REQUEST_METHOD"];
echo $request_method;

switch ($request_method) {
	case 'GET':
		if (!empty($_GET["id"])) {

			$id = intval($_GET["id"]);
			getUser($id);
		}
		break;
	case 'POST':
		$data = json_decode(file_get_contents('php://input'), true);

		insertUser($data["name"], $data["email"], $data["phone"], $data["password"]);
		break;
}

function getUser($id)
{
	global $connection;
	$sql = "SELECT * from user WHERE id='" . $id . "'";
	$result = $connection->query($sql);
	$row = $result->fetch_assoc();
	header('Content-Type: application/json');
	echo json_encode($row);
}

function insertUser($name, $email, $phone, $password)
{
	global $connection;
	$response = array();

	$sql2 = "SELECT email from user WHERE email='" . $email . "'";
	$res = $connection->query($sql2);
	if ($res->num_rows > 0) {
		header("HTTP/1.0 403");
		$response = array(
			'status' => 1,
			'status_message' => 'User Already Exists.'
		);
	} else {

		$sql = "INSERT INTO user ( name, email, phone, password) VALUES ('" . $name . "','" . $email . "','" . $phone . "','" . $password . "')";

		if ($connection->query($sql)) {
			//Success
			header("HTTP/1.0 201");
			$response = array(
				'status' => 1,
				'status_message' => 'User Added Successfully.'
			);
		} else {
			//Failed
			header("HTTP/1.0 400");
			$response = array(
				'status' => 0,
				'status_message' => 'User Addition Failed.'
			);
		}
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}
