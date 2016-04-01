<?php
	$request = file_get_contents("php://input");
  $recieve = json_decode($request, true);

	$id = $recieve["id"];

	$db_fields = json_encode(array("id" => $id));
	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/public/event/delete.php";

    $headers = getallheaders();

	curl_setopt($ch, CURLOPT_URL, $db_url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $db_fields);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Cookie: ' . $headers['Cookie']));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_exec($ch);

	curl_close($ch);

	echo "";
?>
