<?php

  $results = array();

	$query = $_GET["string"];
	$count = (empty($_GET["count"])) ? 10 : $recieve["count"];
	$offset = (empty($_GET["offset"])) ? 0 : $recieve["offset"];
    
	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/public/event/list.php?query=$query";

    $headers = getallheaders();

	curl_setopt($ch, CURLOPT_URL, $db_url);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
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
