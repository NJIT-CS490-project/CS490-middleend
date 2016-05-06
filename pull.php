<?php

function findRoom($words) {
        $returnVal = array();
        for($i = 0; $i < sizeof($words); $i++) {
                if (is_numeric($words[$i])){
                        $returnVal["room"] = $words[$i];
                        return $returnVal;
                } 
        }
        
        $returnVal["room"] = "";
        return $returnVal;

}

function getBuilding($word) {
        $lowerWord = strtolower($word);
        if(strpos($lowerWord, "gitc") !== false) {
                return "Guttenberg Information Technologies Center";
        }        
        elseif(strpos($lowerWord, "mechanic") !== false) {
                return "Mechanical Engineering Center";
        }
        elseif(strpos($lowerWord, "ckb") !== false || strpos($lowerWord, "king") !== false){
                return "Central King Building";
        }
        elseif(strpos($lowerWord, "campus") !== false || strpos($lowerWord, "ctr") !== false || strpos($lowerWord, "med") !== false) {
                return "Campus Center";
        }
        elseif(strpos($lowerWord, "eberhardt") !== false) {
                return "Eberhardt Hall";
        }
        elseif(strpos($lowerWord, "warren") !== false) {
                return "Warren Street Village";
        }
        elseif(strpos($lowerWord, "kup") !== false) {
                return "Kupfrian Hall";
        }
        elseif(strpos($lowerWord, "mall") !== false || strpos($lowerWord, "pc") !== false) {
                return "Student Mall";
        }
        elseif(strpos($lowerWord, "faculty") !== false || strpos($lowerWord, "fmh") !== false) {
                return "Faculty Memorial Hall";
        }
        elseif(strpos($lowerWord, "ece") !== false) {
                return "ECE Building";
        }
        elseif(strpos($lowerWord, "fens") !== false) {
                return "Fenster Hall";
        }
        elseif(strpos($lowerWord, "york") !== false) {
                return "York Center for Environmental Engineering & Science";
        }
        elseif(strpos($lowerWord, "laurel") !== false) {
                return "Laurel Residence Hall";
        }
        elseif(strpos($lowerWord, "oak") !== false) {
                return "Oak Residence Hall";
        }
        elseif(strpos($lowerWord, "west") !== false) {
                return "Weston Hall";
        }
        elseif(strpos($lowerWord, "specht") !== false) {
                return "Specht Building";
        }
        elseif(strpos($lowerWord, "colt") !== false) {
                return "Colton Hall";
        }
        elseif(strpos($lowerWord, "campbell") !== false) {
                return "Campbell Hall";
        }
        elseif(strpos($lowerWord, "tier") !== false) {
                return "Tiernan Hall";
        }
        elseif(strpos($lowerWord, "cul") !== false || strpos($lowerWord, "math") !== false) {
                return "Cullimore Hall";
        } 
        elseif(strpos($lowerWord, "green") !== false) {
                return "The Green";
        }
        elseif(strpos($lowerWord, "devel") !== false) {
                return "EDC 2";
        }
        else{
                return "Off Campus";
        }
        
}
 

$lines = file('http://25livepub.collegenet.com/calendars/NJIT_EVENTS.ics');

$events = array();
$temp = array();
$adding = false;
$NJIT = array();
$NJITLocations = array();
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
                echo "$info<br>";
                if(strpos($info,"SUMMARY:") !== false){
                        $currEvent["name"] = trim(substr($info,8,-1));
                }
                elseif(strpos($info,"LOCATION:") !== false){
                        $value = explode(":", $info);
                        $nvalue = array_slice($value, 1, 1)[0];
                        $svalue = explode("\\", $nvalue);
                        $fvalue = array_slice($svalue, 0, 1)[0];
                        $currEvent["location"] = trim($fvalue);
                        $words = explode(" ", $currEvent["location"]);
                        $locationsArray = findRoom($words);
                        $currEvent["building"] = getBuilding($currEvent["location"]);
                        $currEvent["room"] = $locationsArray["room"];
                }
                elseif(strpos($info,"DTSTART") !== false){
                        $value = explode(":", $info);
                        $currEvent["start"] = intval(trim(strtotime(array_slice($value, -1, 1)[0])));
                }
                elseif(strpos($info,"DTEND") !== false){
                        $value = explode(":", $info);
                        $currEvent["end"] = intval(trim(strtotime(array_slice($value, -1, 1)[0])));
                }        
                elseif(strpos($info,"UID:") !== false){
                        $value = explode("/", $info);
                        $currEvent["id"] = trim(array_slice($value, -1, 1)[0]);
                }        
        }
        array_push($NJIT, $currEvent);
    }

    $sendEvents = json_encode(array("events" => $NJIT, "njit" => true));

    //Used to populate DB with NJIT events

    $ch = curl_init();
    $db_url = "https://web.njit.edu/~mjc55/CS490/event/create.php";
    curl_setopt($ch, CURLOPT_URL, $db_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $sendEvents);
    curl_setopt($ch, CURLOPT_RETURNTRASNFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_exec($ch);
    curl_close($ch);

    echo $sendEvents;   
?>
