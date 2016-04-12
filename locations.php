<?php

  $data = file("buildings.txt");
  $locations = array();

  foreach($data as $line) {
    array_push($locations, trim($line));
  }

  echo json_encode($locations);

?>
