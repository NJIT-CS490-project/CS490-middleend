<?php
	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/user/logout.php";

    $headers = getallheaders();

  curl_setopt($ch1, CURLOPT_URL, $db_url);
	curl_setopt($ch1, CURLOPT_POST, 1);
	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Cookie: ' . $headers['Cookie']));
    $db_result = curl_exec($ch);

  curl_close($ch);

  if(empty($db_result)){
    echo "Succesfully logged out";
    die();
  }
  else{
    echo "Unsuccessful";
    die();
  }
?>
