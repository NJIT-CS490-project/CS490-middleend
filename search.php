<?php
	$request = file_get_contents("php://input");
  $recieve = json_decode($request, true);

  $results = array();

	$query = $recieve["string"];
	$count = (empty($recieve["count"])) ? 10 : $recieve["count"];
	$offset = (empty($recieve["offset"])) ? 0 : $recieve["offset"];

	$db_fields = json_encode(array("string" => $query));

	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/public/event/list.php";

    $headers = getallheaders();

	curl_setopt($ch, CURLOPT_URL, $db_url);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $db_fields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Cookie: ' . $headers['Cookie']));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$db_result = json_decode(curl_exec($ch), true);

	if(empty($db_result)){
		$results["db"] = false;
		$results["message"] = "No events found";
	}
	else{
		$results["db"] = true;
		$results["message"] = "Events found";
		$results["events"] = $db_result;
	}

	curl_close($ch);

	echo json_encode($results);
?>
