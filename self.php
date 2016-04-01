<?php
  $results = array();

	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/public/user/self.php";

    $headers = getallheaders();

    curl_setopt($ch, CURLOPT_URL, $db_url);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Cookie: ' . $headers['Cookie']));
    $db_result = curl_exec($ch);

	curl_close($ch);

	echo $db_result;
?>
