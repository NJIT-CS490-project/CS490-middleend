<?php
        $db_url = "https://web.njit.edu/~mjc55/CS490/event/search.php?favorite=1";
        
        $ch = curl_init();

        $headers = getallheaders();

        curl_setopt($ch, CURLOPT_URL, $db_url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Cookie: ' . $headers['Cookie'])); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $db_result = curl_exec($ch);
        
        curl_close($ch);

        if(empty($db_result)){

                $results["message"] = "No events found";

        }
        else {

                echo $db_result;

        }
         
?>
