<?php
	$request = file_get_contents("php://input");
  $recieve = json_decode($request, true);

  $results = array();

	$title = $recieve["title"];
	$description = $recieve["description"];
	$date = $recieve["date"];
	$start = $recieve["startTime"];
	$end = $recieve["endTime"];
	$location = $recieve["location"];

	$db_fields = json_encode(array("name" => $title, "start" => $start, "end" => $end, "location" => $location));

	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/public/event/create.php";

	curl_setopt($ch, CURLOPT_URL, $db_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $db_fields);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$db_result = json_decode(curl_exec($ch), true);
    
    $headers = getallheaders();

    if (isset($headers['Cookie']) && $endpoint != 'login.php') {
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'Cookie: ' . $headers['Cookie']);
    }


	if(empty($db_result)){
		$results["db"] = true;
		$results["message"] = "Event successfully created";
	}
	else{
		$results["db"] = false;
		$results["message"] = $db_result["message"];
	}

	curl_close($ch);

	echo json_encode($results);
?>
