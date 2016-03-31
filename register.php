<?php
	//Gets input from frontend request and decodes it
	$request = file_get_contents("php://input");
	$recieve = json_decode($request, true);

	//Array for NJIT and DB login results
	$results = array();

	//Store username and password in variables
	$user = $recieve["username"];
	$pass =	$recieve["password"];

	//Create array of fields needed for each login
	$db_fields = json_encode(array("username" => $user, "password" => $pass));

	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/public/user/create.php";

	curl_setopt($ch1, CURLOPT_URL, $db_url);
	curl_setopt($ch1, CURLOPT_POST, 1);
	curl_setopt($ch1, CURLOPT_POSTFIELDS, $db_fields);
	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
	$db_result = json_decode(curl_exec($ch1), true);

	if(empty($db_result)){
		$results["db"] = true;
		$results["message"] = "Properly created account";
	}
	else{
		$results["db"] = false;
		$results["message"] = $db_result["message"];
	}

	curl_close($ch);

	echo json_encode($results);
