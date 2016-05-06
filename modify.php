<?php
    $request = file_get_contents("php://input");
    $recieve = json_decode($request, true);
    
    $startTime   = $recieve['startTime'];
    $endTime     = $recieve['endTime'];
    $building    = $recieve['building'];
    $room        = $recieve['room'];
    $id          = $recieve['id'];
    $date        = $recieve['date'];

    $ch = curl_init();

   //Update URL when endpoint is up 
    $db_url = "https://web.njit.edu/~mjc55/CS490/event/update.php";

    $headers = getallheaders();
    //Update db_fields when endpoint is up
    $db_fields = json_encode(array("startTime" => $startTime, "endTime" => $endTime, "building" => $building, "room" => $room, "id" => $id));
    $header_fields = array('Content-Type: application/json', 'Cookie: ' . $headers['Cookie']);
    $response = array();


    curl_setopt($ch, CURLOPT_URL, $db_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $db_fields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $db_result = json_decode(curl_exec($ch), true);
    
    if(curl_getinfo($ch)['http_code'] === 200) {
        http_response_code(200);
        $reponse['message'] = "Successfully modified event";
    }
    else {
        http_response_code(400);
        $response['message'] = $db_result['message'];   
    }

    curl_close($ch);
    echo json_encode($response);

?>
