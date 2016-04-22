<?php

  $results = array();

	$query = $_GET["string"];
	$count = (empty($_GET["count"])) ? 10 : $_GET["count"];
	$offset = (empty($_GET["offset"])) ? 0 : $_GET["offset"];

	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/event/search.php?query=$query";

        $headers = getallheaders();

	curl_setopt($ch, CURLOPT_URL, $db_url);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: ' . $headers['Cookie']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$db_result = json_decode(curl_exec($ch), true);

	if(empty($db_result)){
        
		$results["message"] = "No events found";
	}
        
        else{
                
                $results["events"] = array_slice($db_result, $offset, $count);
                $results["hasNext"] = (sizeof($db_result) > ($offset+$count));
	}

	curl_close($ch);

	echo json_encode($results);
?>
