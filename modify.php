<?php
    $request = file_get_contents("php://input");
    $recieve = json_decode($request, true);
    
    $description = $recieve['description'];
    $startTime   = $recieve['startTime'];
    $endTime     = $recieve['endTime'];
    $location    = $recieve['location'];

   //Update URL when endpoint is up 
    $db_url = "https://web.njit.edu/~mjc55/CS490/public/event/";

    //Update db_fields when endpoint is up
    $db_fields = array();
    $header_fields = array('Content-Type: application/json', 'Cookie: ' . $headers['Cookie']);
    $response = array();
    $headers = getallheaders();

    curl_setopt($ch, CURLOPT_URL, $db_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $db_fields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


    //Need to fix logic once endpoint is put up
    if(curl_getinfo($ch)['http_code'] === 200) {
        http_response_code(400);
        $reponse['message'] = "Failed to modify event";
    }
    else {
        http_response_code(200);
        $response['message'] = "Successfully modified event";   
    }

    curl_close($ch);
    echo json_encode($response);

?>
