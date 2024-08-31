<?php
// delete.php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form values
    $userId = $_POST["userid"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $first_name = $_POST["first_name"];
    $surname = $_POST["surname"];

    // Example database connection (replace with your actual connection code)
    $dbConn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");


   // $user_id = 0;
   // $measure_id = 0;
    //**DELETE the correlations between the records that corresponds to the given userid**
    $reccor = "SELECT Users.id, Accelerometer.id FROM Users, Accelerometer WHERE Users.userid = Accelerometer.userid AND Users.userid = '$userId'";
      //$delreccord = "DELETE FROM Accelerometer_measurement WHERE id_Users = ".$user_id."AND id_Accelerometer =".$measure_id."";

    $reccor2 = "SELECT Users.id, Magnetometer.id FROM Users, Magnetometer WHERE Users.userid = Magnetometer.userid AND Users.userid = '$userId'";
      //$delreccord2 = "DELETE FROM Magnetometer_measurement WHERE id_Users = ".$user_id."AND id_Magnetometer =".$measure_id."";

    $reccor3 = "SELECT Users.id, Geolocation.id FROM Users, Geolocation WHERE Users.userid = Geolocation.userid AND Users.userid = '$userId'";
     // $delreccord3 = "DELETE FROM Geolocation_measurement WHERE id_Users = ".$user_id."AND id_Geolocation =".$measure_id."";

    $reccor4 = "SELECT Users.id, Gyroscope.id FROM Users, Gyroscope WHERE Users.userid = Gyroscope.userid AND Users.userid = '$userId'";
     // $delreccord4 = "DELETE FROM Gyroscope_measurement WHERE id_Users = ".$user_id."AND id_Gyroscope =".$measure_id."";

    $reccor5 = "SELECT Users.id, Step_counter.id FROM Users, Step_counter WHERE Users.userid = Step_counter.userid AND Users.userid = '$userId'";
     // $delreccord5 = "DELETE FROM Step_counter_measurement WHERE id_Users = ".$user_id."AND id_Step_counter =".$measure_id."";

    $reccor6 = "SELECT Users.id, Proximity.id FROM Users, Proximity WHERE Users.userid = Proximity.userid AND Users.userid = '$userId'";
      //$delreccord6 = "DELETE FROM Proximity_measurement WHERE id_Users = ".$user_id."AND id_Proximity =".$measure_id."";

    $reccor7 = "SELECT Users.id, Barometer.id FROM Users, Barometer WHERE Users.userid = Barometer.userid AND Users.userid = '$userId'";
     // $delreccord7 = "DELETE FROM Barometer_measurement WHERE id_Users = ".$user_id."AND id_Barometer =".$measure_id."";

    $relation = array($reccor,$reccor2,$reccor3,$reccor4,$reccor5,$reccor6,$reccor7);
    for($i=0;$i<count($relation);$i++){ 
      $ret = pg_query($dbConn, $relation[$i]);
      while($row = pg_fetch_row($ret)) {
        $user_id = $row[0];
        $measure_id = $row[1];
        $delreccord = "DELETE FROM Accelerometer_measurement WHERE id_Users = ".$user_id."AND id_Accelerometer =".$measure_id."";
        $delreccord2 = "DELETE FROM Magnetometer_measurement WHERE id_Users = ".$user_id."AND id_Magnetometer =".$measure_id."";
        $delreccord3 = "DELETE FROM Geolocation_measurement WHERE id_Users = ".$user_id."AND id_Geolocation =".$measure_id."";
        $delreccord4 = "DELETE FROM Gyroscope_measurement WHERE id_Users = ".$user_id."AND id_Gyroscope =".$measure_id."";
        $delreccord5 = "DELETE FROM Step_counter_measurement WHERE id_Users = ".$user_id."AND id_Step_counter =".$measure_id."";
        $delreccord6 = "DELETE FROM Proximity_measurement WHERE id_Users = ".$user_id."AND id_Proximity =".$measure_id."";
        $delreccord7 = "DELETE FROM Barometer_measurement WHERE id_Users = ".$user_id."AND id_Barometer =".$measure_id."";

        echo "". $user_id."<br>".$measure_id.""."<br>";

        switch ($relation[$i]){
        
          case $reccor:
            $cor =pg_query($dbConn, $delreccord);
            if(!$cor) {
              echo pg_last_error($dbConn);
              } else {
              echo "Succesful deletion\n";
              }   
            break;
          
          case $reccor2:
            $cor =pg_query($dbConn, $delreccord2);
            if(!$cor) {
              echo pg_last_error($dbConn);
              } else {
              echo "Succesful deletion\n";
              }   
            break;
            
          case $reccor3:
            $cor =pg_query($dbConn, $delreccord3);
            if(!$cor) {
              echo pg_last_error($dbConn);
              } else {
              echo "Succesful deletion\n";
              }   
            break;

          case $reccor4:
            $cor =pg_query($dbConn, $delreccord4);
            if(!$cor) {
              echo pg_last_error($dbConn);
              } else {
              echo "Succesful deletion\n";
              }   
            break;
            
          case $reccor5:
            $cor =pg_query($dbConn, $delreccord5);
            if(!$cor) {
              echo pg_last_error($dbConn);
              } else {
              echo "Succesful deletion\n";
              }   
            break; 
            
           case $reccor6:
            $cor =pg_query($dbConn, $delreccord6);
            if(!$cor) {
              echo pg_last_error($dbConn);
              } else {
              echo "Succesful deletion\n";
              }   
            break;
            
           case $reccor7:
            $cor =pg_query($dbConn, $delreccord7);
            if(!$cor) {
              echo pg_last_error($dbConn);
              } else {
              echo "Succesful deletion\n";
              }   
            break;
            
      }
      if(!$ret) {
      echo pg_last_error($dbConn);
      } else {
      echo "Table created successfully\n";
      }   
    }
    }

    // **DELETE the records of the final tables the records that correspond to the given userid**
    $query = "DELETE FROM Users
              WHERE userid = '$userId'
                AND username = '$username'
                AND email = '$email'
                AND password = '$password'
                AND first_name = '$first_name'
                AND surname = '$surname'" ;
    
    
    $query2 = "DELETE FROM Magnetometer
               WHERE userid = '$userId'";
               
              
    $query3 = "DELETE FROM Accelerometer
               WHERE userid = '$userId'";

     
    $query4 = "DELETE FROM Geolocation
               WHERE userid = '$userId'";

                
    $query5 = "DELETE FROM Gyroscope
               WHERE userid = '$userId'";
               
                
    $query6 = "DELETE FROM Step_counter
               WHERE userid = '$userId'";

               
    $query7 = "DELETE FROM Proximity
               WHERE userid = '$userId'";

               
    $query8 = "DELETE FROM Barometer
               WHERE userid = '$userId'";


     //**Execution** of SQL queries
     $relations = array($query,$query2,$query3,$query4,$query5,$query6,$query7,$query8);
     for($i=0;$i<count($relations);$i++){ 
       $ret = pg_query($dbConn, $relations[$i]);
       echo "".$relations[$i];
       if(!$ret) {
       echo pg_last_error($dbConn);
       } else {
        echo "Table created successfully\n";
       }   
     }

    // Close the database connection
    pg_close($dbConn);
    header("Location: ../users.php");
    exit;
}
?>
