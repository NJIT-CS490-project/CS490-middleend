<?php
	$id = $_GET["id"];

	$db_fields = json_encode(array("id" => $id));
	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/public/event/delete.php";

    $headers = getallheaders();

	curl_setopt($ch, CURLOPT_URL, $db_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $db_fields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Cookie: ' . $headers['Cookie']));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);

    

    if(curl_getinfo($ch)['http_code'] === 304){
        http_response_code(400);
    }
    else {
        http_response_code(200);
    }

	curl_close($ch);

	echo "";
?>
