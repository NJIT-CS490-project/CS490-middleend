<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
 */

  $results = array();

	$count = (empty($_GET["count"])) ? 10 : $_GET["count"];
	$offset = (empty($_GET["offset"])) ? 0 : $_GET["offset"];
        $order = (empty($_GET["order"])) ? "asc" : $_GET["order"];
        $sorting = (empty($_GET["sorting"])) ? "title" : $_GET["sorting"];
        $param = "order=$order&sorting=$sorting";
        if (array_key_exists('id', $_GET)) {
                $id = $_GET["id"];
                $param = $param . "&id=$id";
        }
        if (array_key_exists('search', $_GET)) {
                $query = $_GET["search"];
                $param = $param . "&query=$query";
        }
        if (array_key_exists('mine', $_GET)) {
                $mine = $_GET["mine"];
                $param = $param . "&limitToMine=$mine";
        }
        if (array_key_exists('onlyUser', $_GET)) {
                $onlyUser = $_GET["onlyUser"];
                $param = $param . "&limitToUser=$onlyUser";
        }
        if (array_key_exists('onlyNJIT', $_GET)) {
                $onlyNJIT = $_GET["onlyNJIT"];
                $param = $param . "&limitToNJIT=$onlyNJIT";
        }
        if (array_key_exists('favorited', $_GET)) {
                $favorited = $_GET["favorited"];
                $param = $param . "&limitToFavorites=$favorited";
        }
        if (array_key_exists('startTime', $_GET)) {
                $startTime = $_GET["startTime"];
                $param = $param . "&startTime=$startTime";
        }
        if (array_key_exists('endTime', $_GET)) {
                $endTime = $_GET["endTime"];
                $param = $param . "&endTime=$endTime";
        }
        if (array_key_exists('startDate', $_GET)) {
                $startDate = $_GET["startDate"];
                $param = $param . "&startDate=$startDate";
        }
        if (array_key_exists('endDate', $_GET)) {
                $endDate = $_GET["endDate"];
                $param = $param . "&endDate=$endDate";
        }
        if (array_key_exists('building', $_GET)) {
                $building = $_GET["building"];
                $param = $param . http_build_query($building);
                var_dump($param);
        }
        if (array_key_exists('room', $_GET)) {
                $room = $_GET["room"];
                $param = $param . "&room=$room";
        }
	$ch = curl_init();

	$db_url = "https://web.njit.edu/~mjc55/CS490/event/search.php?";
        $headers = getallheaders();

	curl_setopt($ch, CURLOPT_URL, $db_url . $param);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: ' . $headers['Cookie']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$db_result = json_decode(curl_exec($ch), true);

	if(empty($db_result)){
                $results["events"] = array();        
	}
        
        $results["events"] = array_slice($db_result, $offset, $count);
                
        foreach ($results["events"] as &$event) {
                $event["date"] = explode(" ", $event["start"])[0];
                $event["startTime"] = substr(explode(" ", $event["start"])[1], 0, 5); 
                $event["endTime"] = substr(explode(" ", $event["end"])[1], 0, 5); 
        }

        $results["done"] = !(sizeof($db_result) > ($offset+$count));
                

	curl_close($ch);

	echo json_encode($results);
?>
