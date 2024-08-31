<?php
include ('connection.php');

$db_conn = connection();

$sqltmp3 = "DROP TABLE Magnetometer_measurement";
$sqltmp4 = "DROP TABLE Accelerometer_measurement";
$sqltmp5 = "DROP TABLE Geolocation_measurement";
$sqltmp6 = "DROP TABLE Gyroscope_measurement";
$sqltmp7 = "DROP TABLE Step_counter_measurement";
$sqltmp8 = "DROP TABLE Proximity_measurement";
$sqltmp9 = "DROP TABLE Barometer_measurement";
$sqltmp10 = "DROP TABLE sensors_tmp";
$sqltmp11 = "DROP TABLE Users";
$sqltmp12 = "DROP TABLE Accelerometer";
$sqltmp13 = "DROP TABLE Geolocation";
$sqltmp14 = "DROP TABLE Gyroscope";
$sqltmp15 = "DROP TABLE Step_counter";
$sqltmp16 = "DROP TABLE Proximity";
$sqltmp17 = "DROP TABLE Barometer";
$sqltmp18 = "DROP TABLE Users_tmp";
$sqltmp19 = "DROP TABLE Geolocation_tmp";
$sqltmp20 = "DROP TABLE Magnetometer";
     

$droptables = array($sqltmp3,$sqltmp4,$sqltmp5,$sqltmp6,$sqltmp7,$sqltmp8,$sqltmp9,$sqltmp10,$sqltmp11,$sqltmp12,$sqltmp13,$sqltmp14,$sqltmp15,$sqltmp16,$sqltmp17,$sqltmp18,$sqltmp19,$sqltmp20);


for($i=0;$i<count($droptables);$i++){
  $ret = pg_query($db_conn, $droptables[$i]);
  if(!$ret) {
  echo pg_last_error($db_conn);
  } else {
  echo "Table created successfully\n";
 }
}   

?>