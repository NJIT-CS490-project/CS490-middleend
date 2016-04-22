<?php
  $results = array();

	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/user/self.php";

    $headers = getallheaders();
        $cookieParam = $headers['Cookie'];
    curl_setopt($ch, CURLOPT_URL, $db_url);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, $cookieParam);
    $db_result = curl_exec($ch);


	curl_close($ch);
    header('Cookie: '.$headers['Cookie']);
	echo $db_result;
?>
