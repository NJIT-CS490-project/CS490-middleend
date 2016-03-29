<?php
	$request = file_get_contents("php://input");
//Assuming JSON of search terms is passed
  $recieve = json_decode($request, true);

	$ch = curl_init();
  $results = array();

	//Will update URL
	$db_url = "https://web.njit.edu/~mjc55/CS490/src/";

	curl_setopt($ch, CURLOPT_URL, $db_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $recieve);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$db_result = json_decode(curl_exec($ch), true);

  if(!curl_errno($ch) && curl_getinfo($ch) == 200) {
    $results["message"] = "Results found";
    $results["count"] = sizeof($db_result);
    $results["events"] = $db_result;
  }
  else {
    $results["message"] = $db_result["message"];
  }
	curl_close($ch);

	echo json_encode($results);
?>
