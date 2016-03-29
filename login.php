<?php
	//Gets input from frontend request and decodes it
	$request = file_get_contents("php://input");
	$recieve = json_decode($request, true);

	//Array for DB login results
	$result = array();

	//Store username and password in variables
	$user = $recieve["user"];
	$pass =	$recieve["pass"];

	//Create array of fields needed for login
	$db_fields = json_encode(array("username" => $user, "password" => $pass));

	$ch = curl_init();

	//Url needed for login
	$db_url = "https://web.njit.edu/~mjc55/CS490/src/user/login.php";

	curl_setopt($ch, CURLOPT_URL, $db_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $db_fields);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$db_result = curl_exec($ch);

	//Stores result from cURL to DB
	$results["db"] = empty($db_result);

	curl_close($ch);

	echo json_encode($results);
?>
