<?php
  print(json_encode(array (
        "id" => $User->getID(),
        "username" => $User->getUsername(),
        "thumbURL" => $User->getThumb(),
        "email" => $User->getEmail(),
  )));
?>
