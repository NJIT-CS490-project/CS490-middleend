<?php

$lines = file('http://25livepub.collegenet.com/calendars/NJIT_EVENTS.ics');

$events = array();
$temp = array();
$adding = false;

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
        echo "<h3>New Event</h3>";    
        foreach($event as $info) {
            echo "$info <br>";
        }
    }

?>
