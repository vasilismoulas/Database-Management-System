<?php
// delete.php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form values
    $userId = $_POST["userid"];
    $magnetometerX = $_POST["magnetometer_x"];
    $magnetometerY = $_POST["magnetometer_y"];
    $magnetometerZ = $_POST["magnetometer_z"];
    $timeStamp = $_POST["time_stamp"];

    // Example database connection (replace with your actual connection code)
    $dbConn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");

    $reccor = "SELECT Users.id, Magnetometer.id FROM Users, Magnetometer WHERE Users.userid = Magnetometer.userid AND Users.userid = '$userId'";

    $ret = pg_query($dbConn, $reccor);
    while($row = pg_fetch_row($ret)) {
        $user_id = $row[0];
        $measure_id = $row[1];
        $delreccord = "DELETE FROM Magnetometer_measurement WHERE id_Users = ".$user_id."AND id_Magnetometer =".$measure_id."";

        $cor =pg_query($dbConn, $delreccord);
        if(!$cor) {
          echo pg_last_error($dbConn);
        } else {
          //echo "Succesful deletion\n";
        }   
    }

    // Construct the DELETE statement
    $query = "DELETE FROM Magnetometer
              WHERE userid = '$userId'
                AND magnetometer_x = CAST('$magnetometerX'AS double precision)
                AND magnetometer_y = CAST('$magnetometerY'AS double precision)
                AND magnetometer_z = CAST('$magnetometerZ'AS double precision)
                AND time_stamp = TO_TIMESTAMP($timeStamp)::TIMESTAMP";

    // Execute the DELETE statement
    $result = pg_query($dbConn, $query);

    if ($result !== false) {
      $rowsAffected = pg_affected_rows($result);
      echo "$rowsAffected records deleted successfully";
  } else {
      echo "Error deleting records: " . pg_last_error($dbConn);
  }

    // Close the database connection
    pg_close($dbConn);
   // header("Location: ../magnetometer_sensor.php");
    exit;
}
?>
