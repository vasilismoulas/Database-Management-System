<?php
// delete.php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form values
    $userId = $_POST["userid"];
    $gyroscopeX = $_POST["gyroscope_x"];
    $gyroscopeY = $_POST["gyroscope_y"];
    $gyroscopeZ = $_POST["gyroscope_z"];
    $timeStamp = $_POST["time_stamp"];

    // Example database connection (replace with your actual connection code)
    $dbConn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");

    $reccor = "SELECT Users.id, Gyroscope.id FROM Users, Gyroscope WHERE Users.userid = Gyroscope.userid AND Users.userid = '$userId'";

    $ret = pg_query($dbConn, $reccor);
    while($row = pg_fetch_row($ret)) {
        $user_id = $row[0];
        $measure_id = $row[1];
        $delreccord = "DELETE FROM Gyroscope_measurement WHERE id_Users = ".$user_id."AND id_Gyroscope =".$measure_id."";

        $cor =pg_query($dbConn, $delreccord);
        if(!$cor) {
          echo pg_last_error($dbConn);
        } else {
         // echo "Succesful deletion\n";
        }   
    }

    // Construct the DELETE statement
    $query = "DELETE FROM Gyroscope
              WHERE userid = '$userId'
                AND gyroscope_x = CAST('$gyroscopeX'AS double precision)
                AND gyroscope_y = CAST('$gyroscopeY'AS double precision)
                AND gyroscope_z = CAST('$gyroscopeZ'AS double precision)
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
   // header("Location: ../gyroscope_sensor.php");
    exit;
}
?>
