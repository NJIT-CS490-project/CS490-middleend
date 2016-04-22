<?php

$lines = file('http://25livepub.collegenet.com/calendars/NJIT_EVENTS.ics');

$events = array();
$temp = array();
$adding = false;
$NJIT = array();

    foreach ($lines as $line_num => $line) {
        if(strcmp($line, 'BEGIN:VEVENT') === 2) {
            $adding = true;
        }
        elseif(strcmp($line, 'END:VEVENT') === 2) {
            $adding = false;
        }
        if($adding){
            array_push($temp, $line);
        }
        elseif(sizeof($temp) != 0){
            array_push($events, $temp);
            unset($temp);
            $temp = array();                                          
        }    
    }

    foreach($events as $event) {
        $temp = "";
        $currEvent = array();
        foreach($event as $info) {
                
                if(strpos($info,"SUMMARY:") !== false){
                        $currEvent["name"] = substr($info,8,-1);
                }
                elseif(strpos($info,"LOCATION:") !== false){
                        $value = explode(":", $info);
                        $nvalue = array_slice($value, 1, 1)[0];
                        $svalue = explode("\\", $nvalue);
                        $fvalue = array_slice($svalue, 0, 1)[0];
                        $currEvent["location"] = $fvalue;
                        $words = explode(" ", $fvalue);

                        
                }
                elseif(strpos($info,"START;") !== false){
                        $value = explode(":", $info);
                        $currEvent["start"] = strtotime(array_slice($value, -1, 1)[0]);
                }
                elseif(strpos($info,"END;") !== false){
                        $value = explode(":", $info);
                        $currEvent["end"] = strtotime(array_slice($value, -1, 1)[0]);
                }        
                elseif(strpos($info,"UID:") !== false){
                        $value = explode("/", $info);
                        $currEvent["id"] = array_slice($value, -1, 1)[0];
                }        
        }
        array_push($NJIT, $currEvent);
    }
    
        foreach($NJIT as $event){
                foreach($event as $key => $value){
                        echo "$key $value<br>";
                }
        }
   
?>
