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
                if ($info[0] === " "){
                        $temp = $temp . $info;
                        continue;
                } 
                if($temp !== ""){
                        $info = $temp;
                        $temp = "";
                }
                if(strpos($info,"SUMMARY:") !== false){
                        $currEvent["name"] = substr($info,8,-1);
                }
                elseif(strpos($info,"LOCATION:") !== false){
                        $currEvent["location"] = substr($info,9,-1);
                }
                elseif(strpos($info,"DTSTART") !== false){
                        $currEvent["start"] = substr($info,8,-1);
                }
                elseif(strpos($info,"DTEND") !== false){
                        $currEvent["end"] = substr($info,6,-1);
                }        
                elseif(strpos($info,"UID:") !== false){
                        $currEvent["id"] = $info;
                }        
        }
        array_push($NJIT, $currEvent);
    }
        
        foreach($NJIT as $event){
                foreach($event as $key => $value){
                        echo "$key $value <br>";
                }
        }
        
?>
