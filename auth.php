<?php
	//Gets input from frontend request and decodes it
	$request = file_get_contents("php://input");
	$recieve = json_decode($request, true);

	//Array for NJIT and DB login results
	$results = array();
	
	//Store username and password in variables
	$user = $recieve["user"];
	$pass =	$recieve["pass"];
	
	//Create array of fields needed for each login
	$db_fields = array("user" => $user, "pass" => $pass);
	$njit_fields = array("user" => $user, "pass" => $pass, "uuid" => "0xACA021");

	$ch1 = curl_init();
	$ch2 = curl_init();
	//Each url needed for logins
	$db_url = "https://osl84.njit.edu/~mjc55/CS490/user/login.php";
	$njit_url = "https://cp4.njit.edu/cp/home/login";

	curl_setopt($ch1, CURLOPT_URL, $db_url);
	curl_setopt($ch1, CURLOPT_POST, 1);
	curl_setopt($ch1, CURLOPT_POSTFIELDS, http_build_query(db_fields));
	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
	$db_result = curl_exec($ch1);
	
	//Stores result from cURL to DB
	$results["db"] = $db_result;

	curl_close($ch1);

	curl_setopt($ch2, CURLOPT_URL, $njit_url);
	curl_setopt($ch2, CURLOPT_POST, 1);
	curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query($njit_fields));
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	$njit_result = curl_exec($ch2);
	
	//Stores result from cURL to NJIT
	$results["njit"] = strpos($njit_result, "loginok.html") !== false;

	curl_close($ch2);
	
	echo json_encode($results);
?>
