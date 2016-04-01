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
    $db_fields = array("username" => $user, "password" => $pass);
    $ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/public/user/login.php";

	curl_setopt($ch, CURLOPT_URL, $db_url);
	curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($db_fields));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURLOPT_HEADER, 1);
    $db_result = json_decode(curl_exec($ch), true);
    
    if($db_result["sessionID"]){
		$results["db"] = true;
		$results["message"] = "Valid login";
        $results["sessionID"] = $db_result["sessionID"];	
    }
    else{
		$results["db"] = false;
        $temp = json_decode($db_result, true);
        $results["message"] = $temp["message"];
        $results["sessionID"] = 0;
    }

    curl_close($ch);
	echo json_encode($results);
?>
