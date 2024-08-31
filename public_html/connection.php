<?php
function connection(){
    $conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");
    return $conn;
  }
?>