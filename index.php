<?php
include ('connection.php');

$db_conn = connection();

     $sqltmp3 =
     "CREATE TABLE IF NOT EXISTS sensors_tmp
     (userid VARCHAR(100),
      time_stamp INT,
      pressure       DOUBLE PRECISION DEFAULT NULL,
      acceleration_x DOUBLE PRECISION,
      acceleration_y DOUBLE PRECISION,
      acceleration_z DOUBLE PRECISION,
      gyroscope_x    DOUBLE PRECISION,
      gyroscope_y    DOUBLE PRECISION,
      gyroscope_z    DOUBLE PRECISION,
      magnetometer_x DOUBLE PRECISION,
      magnetometer_y DOUBLE PRECISION,
      magnetometer_z DOUBLE PRECISION,
      proximity      BOOLEAN,
      steps          INT
     )";

  $ret = pg_query($db_conn, $sqltmp3);
  if(!$ret) {
  echo pg_last_error($db_conn);
  } else {
  echo "Table created successfully\n";
 }   


?>