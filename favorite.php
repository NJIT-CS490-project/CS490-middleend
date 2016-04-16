<?php

        $request = file_get_contents("php://input");
        $recieve = json_decode($request, true);
        
        $ch = curl_init();
        
        $eventID = $recieve['id'];
        $db_fields = json_encode(
                                array(
                                        'eventID' => $eventID
                                )
                        );

        $db_url = "https://web.njit.edu/~mjc55/CS490/event/favorite.php";
        $headers = getallheaders();
        $header_array = array('Content-Type: application/json', 'Cookie: ' . $headers['Cookie']);

        curl_setopt($ch, CURLOPT_URL, $db_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $db_fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);

        if(curl_getinfo($ch)['http_code'] === 200){
        
                http_response_code(200);
        
        }
        
        else {
                
                http_response_code(400);
        }

        curl_close($ch);

        echo "";
?>
