<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve variables from the form
    $datefrom = isset($_POST["datefrom"]) ? $_POST["datefrom"] : null;
    $dateuntil = isset($_POST["dateuntil"]) ? $_POST["dateuntil"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $username = isset($_POST["username"]) ? $_POST["username"] : null;
    $first_name = isset($_POST["firstname"]) ? $_POST["firstname"] : null;
    $surname = isset($_POST["surname"]) ? $_POST["surname"] : null;
    // Now you can use these variables as needed
    // For example, you can insert them into a database

    // Example database connection and insertion (replace with your actual database logic)
    $dbConn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");
    $userid;
    $username;

    //Phase1
    $usernumber = "SELECT * FROM Users WHERE";

    if ($surname != null){
        $usernumber .= " surname = '$surname'";
    }

    if ($email != null){
        $usernumber .= "AND email = '$email'";
    }
   
    if ($username != null){
        $usernumber .= " AND username = '$username'";
    }
   
    if ($first_name != null){
        $usernumber .= " AND first_name = '$first_name'";
    }
   
    //Phase2 **old**
    $sql1 = "SELECT * FROM Accelerometer WHERE ";
    $sql2 = "SELECT * FROM Proximity WHERE ";
    $sql3 = "SELECT * FROM Step_counter WHERE ";
    $sql4 = "SELECT * FROM Geolocation WHERE ";
    $sql5 = "SELECT * FROM Gyroscope WHERE ";
    $sql6 = "SELECT * FROM Barometer WHERE ";
    $sql7 = "SELECT * FROM Magnetometer WHERE ";

    //Phase2 **new**
    $newsql = "SELECT userid, accelerometer_x, accelerometer_y, accelerometer_z, NULL AS proximity_boolean, NULL AS footsteps, NULL AS longtitude, NULL AS latitude, NULL AS altitude,  NULL AS gyroscope_x, NULL AS gyroscope_y, NULL AS gyroscope_z, NULL AS atm, NULL AS magnetometer_x, NULL AS magnetometer_y, NULL AS magnetometer_z, time_stamp, 'accelerometer' AS sensor 
               FROM   Accelerometer 
               WHERE  ".$newsql_t1." ". $newsql_t2." ".$newsql_u1."
   
               UNION 
  
               SELECT userid, NULL AS accelerometer_x, NULL AS accelerometer_y, NULL AS accelerometer_z, proximity_boolean, NULL AS footsteps, NULL AS longtitude, NULL AS latitude,  NULL AS altitude, NULL AS gyroscope_x,  NULL AS gyroscope_y, NULL AS gyroscope_z, NULL AS atm, NULL AS magnetometer_x, NULL AS magnetometer_y, NULL AS magnetometer_z, time_stamp, 'proximity' AS sensor 
               FROM Proximity 
               WHERE ".$newsql_t1." ". $newsql_t2." ".$newsql_u1."
  
               UNION 
  
               SELECT userid, NULL AS accelerometer_x, NULL AS accelerometer_y, NULL AS accelerometer_z, NULL AS proximity_boolean, footsteps, NULL AS longtitude, NULL AS latitude, NULL AS altitude, NULL AS gyroscope_x, NULL AS gyroscope_y,  NULL AS gyroscope_z, NULL AS atm, NULL AS magnetometer_x, NULL AS magnetometer_y, NULL AS magnetometer_z,  time_stamp, 'step_counter' AS sensor 
               FROM  Step_counter 
               WHERE ".$newsql_t1." ". $newsql_t2." ".$newsql_u1."
  
               UNION 
  
               SELECT userid, NULL AS accelerometer_x, NULL AS accelerometer_y, NULL AS accelerometer_z, NULL AS proximity_boolean, NULL AS footsteps, longtitude, latitude, altitude, NULL AS gyroscope_x, NULL AS gyroscope_y, NULL AS gyroscope_z,  NULL AS atm, NULL AS magnetometer_x, NULL AS magnetometer_y, NULL AS magnetometer_z, time_stamp,  'geolocation' AS sensor 
               FROM  Geolocation 
               WHERE ".$newsql_t1." ". $newsql_t2." ".$newsql_u1."
   
               UNION 
  
               SELECT userid,  NULL AS accelerometer_x, NULL AS accelerometer_y, NULL AS accelerometer_z, NULL AS proximity_boolean, NULL AS footsteps, NULL AS longtitude, NULL AS latitude, NULL AS altitude, gyroscope_x, gyroscope_y, gyroscope_z,  NULL AS atm, NULL AS magnetometer_x,  NULL AS magnetometer_y, NULL AS magnetometer_z, time_stamp,     'gyroscope' AS sensor 
               FROM  Gyroscope 
               WHERE ".$newsql_t1." ". $newsql_t2." ".$newsql_u1."
  
               UNION 
   
               SELECT userid, NULL AS accelerometer_x, NULL AS accelerometer_y, NULL AS accelerometer_z, NULL AS proximity_boolean, NULL AS footsteps, NULL AS longtitude, NULL AS latitude, NULL AS altitude, NULL AS gyroscope_x, NULL AS gyroscope_y, NULL AS gyroscope_z, atm, NULL AS magnetometer_x, NULL AS magnetometer_y,  NULL AS magnetometer_z, time_stamp,  'barometer' AS sensor 
               FROM  Barometer 
               WHERE ".$newsql_t1." ". $newsql_t2." ".$newsql_u1."
  
               UNION 
  
               SELECT userid, NULL AS accelerometer_x, NULL AS accelerometer_y, NULL AS accelerometer_z, NULL AS proximity_boolean, NULL AS footsteps, NULL AS longtitude, NULL AS latitude, NULL AS altitude, NULL AS gyroscope_x, NULL AS gyroscope_y, NULL AS gyroscope_z,NULL AS atm, magnetometer_x, magnetometer_y, magnetometer_z,  time_stamp,  'magnetometer' AS sensor 
               FROM  magnetometer 
               WHERE ".$newsql_t1." ". $newsql_t2." ".$newsql_u1."
  
              ";

   
     if ($datefrom != null) {
         // Convert mm/dd/yyyy to Unix epoch timestamp
         $timestamp = strtotime($datefrom);

         $sql1 .= "  time_stamp >= TO_TIMESTAMP($timestamp)";
         $sql2 .= "  time_stamp >= TO_TIMESTAMP($timestamp)";
         $sql3 .= "  time_stamp >= TO_TIMESTAMP($timestamp)";
         $sql4 .= "  time_stamp >= TO_TIMESTAMP($timestamp)";
         $sql5 .= "  time_stamp >= TO_TIMESTAMP($timestamp)";
         $sql6 .= "  time_stamp >= TO_TIMESTAMP($timestamp)";
         $sql7 .= "  time_stamp >= TO_TIMESTAMP($timestamp)";
         $newsql_t1 = "time_stamp >= TO_TIMESTAMP($timestamp)";
     }

     if ($dateuntil != null) {
         // Convert mm/dd/yyyy to Unix epoch timestamp
         $timestamp = strtotime($dateuntil);

         $sql1 .= " AND time_stamp <= TO_TIMESTAMP($timestamp)";
         $sql2 .= " AND time_stamp <= TO_TIMESTAMP($timestamp)";
         $sql3 .= " AND time_stamp <= TO_TIMESTAMP($timestamp)";
         $sql4 .= " AND time_stamp <= TO_TIMESTAMP($timestamp)";
         $sql5 .= " AND time_stamp <= TO_TIMESTAMP($timestamp)";
         $sql6 .= " AND time_stamp <= TO_TIMESTAMP($timestamp)";
         $sql7 .= " AND time_stamp <= TO_TIMESTAMP($timestamp)";
         $newsql_t2 = "AND time_stamp <= TO_TIMESTAMP($timestamp)";
     }

   //Phase 1 **Execution**
   
    $rets = pg_query($dbConn, $usernumber);
    if(!$rets) {
      echo pg_last_error($dbConn);
      //exit;
     }
     else{
        $cnt = 0;
        while($row = pg_fetch_row($rets)) {
           // echo " " . $row[0]." ".$row[1]." ".$row[6];  
         $userid = $row[1];  
         //echo $userid;
         $username = $row[2];
         $cnt++;                            //Number of Users
        }

        if($cnt>1){
            echo "**WARNING**: The search you performed returned ".$cnt." users. Please refine";
            exit;
        }
        else if($cnt==1){
            //line 20
            $sql1 .= "AND userid = '$userid'";
            $sql2 .= "AND userid = '$userid'";
            $sql3 .= "AND userid = '$userid'";
            $sql4 .= "AND userid = '$userid'";
            $sql5 .= "AND userid = '$userid'";
            $sql6 .= "AND userid = '$userid'";
            $sql7 .= "AND userid = '$userid'";
            $newsql_u1 = "AND userid = '$userid'";
            //Phase 2 **Execution** 
            $relations = array($sql1,$sql2,$sql3,$sql4,$sql5,$sql6,$sql7);

            for($i=0;$i<count($relations);$i++){ 
                $ret = pg_query($dbConn, $relations[$i]);
                
                switch ($relations[$i]){

                    case $sql1:
                    echo "<h3>Accelerometer</h3><br><br>";
                    echo "<table border='1'>";
                    echo "<tr><th>uid</th><th>username</th><th>timestamp</th><th>acceleretion_x</th><th>acceleretion_y</th><th>acceleretion_z</th></tr>";
                    while ($row = pg_fetch_assoc($ret)) {  
                    echo "<tr><td>" . $row['userid'] . "</td><td>" . $username . "</td><td>".$row['time_stamp']. "</td><td>". $row['accelerometer_x'] . "</td><td>" . $row['accelerometer_y'] . "</td><td>" . $row['accelerometer_z'] ."</td></tr>";
                    }
                    echo "</table>";  
                    break;
                    
                     case $sql2:
                     echo "<h3>Proximity</h3><br><br>";
                     echo "<table border='1'>";
                     echo "<tr><th>uid</th><th>username</th><th>timestamp</th><th>proximity</th></tr>";
                    while ($row = pg_fetch_assoc($ret)) {  
                    echo "<tr><td>" . $row['userid'] . "</td><td>" . $username . "</td><td>".$row['time_stamp']. "</td><td>". $row['proximity_boolean'] . "</td><tr>";
                    }
                     echo "</table>"; 
                     break;

                     case $sql3:
                     echo "<h3>Step_counter</h3><br><br>";
                     echo "<table border='1'>";
                     echo "<tr><th>uid</th><th>username</th><th>timestamp</th><th>footsteps</th></tr>";
                     while ($row = pg_fetch_assoc($ret)) {  
                     echo "<tr><td>" . $row['userid'] . "</td><td>" . $username . "</td><td>".$row['time_stamp']. "</td><td>". $row['footsteps'] . "</td><tr>";
                     }
                     echo "</table>";
                     break;
                    
                     case $sql4:
                     echo "<h3>Geolocation</h3><br><br>";
                     echo "<table border='1'>";
                     echo "<tr><th>uid</th><th>username</th><th>timestamp</th><th>longtitude</th><th>latitude</th><th>altitude</th></tr>";
                     while ($row = pg_fetch_assoc($ret)) {  
                     echo "<tr><td>" . $row['userid'] . "</td><td>" . $username . "</td><td>".$row['time_stamp']. "</td><td>". $row['longtitude'] . "</td><td>" . $row['latitude'] . "</td><td>" . $row['altitude'] ."</td></tr>";
                     }
                     echo "</table>"; 
                     break;
                    
                      case $sql5:
                      echo "<h3>Gyroscope</h3><br><br>";
                      echo "<table border='1'>";
                      echo "<tr><th>uid</th><th>username</th><th>timestamp</th><th>gyroscope_x</th><th>gyroscope_y</th><th>gyroscope_z</th></tr>";
                      while ($row = pg_fetch_assoc($ret)) {  
                      echo "<tr><td>" . $row['userid'] . "</td><td>" . $username . "</td><td>".$row['time_stamp']. "</td><td>". $row['gyroscope_x'] . "</td><td>" . $row['gyroscope_y'] . "</td><td>" . $row['gyroscope_z'] ."</td></tr>";
                      }
                      echo "</table>"; 
                      break;
                    
                     case $sql6:
                     echo "<h3>Barometer</h3><br><br>";
                     echo "<table border='1'>";
                     echo "<tr><th>uid</th><th>username</th><th>timestamp</th><th>pressure</th></tr>";
                     while ($row = pg_fetch_assoc($ret)) {  
                     echo "<tr><td>" . $row['userid'] . "</td><td>" . $username . "</td><td>".$row['time_stamp']. "</td><td>". $row['atm'] . "</td><tr>";
                     }
                     echo "</table>";  
                     break;

                      case $sql7:
                      echo "<h3>Magnetometer</h3><br><br>";
                      echo "<table border='1'>";
                      echo "<tr><th>uid</th><th>username</th><th>timestamp</th><th>magnetometer_x</th><th>magnetometer_y</th><th>magnetometer_z</th></tr>";
                      while ($row = pg_fetch_assoc($ret)) {  
                      echo "<tr><td>" . $row['userid'] . "</td><td>" . $username . "</td><td>".$row['time_stamp']. "</td><td>". $row['magnetometer_x'] . "</td><td>" . $row['magnetometer_y'] . "</td><td>" . $row['magnetometer_z'] ."</td></tr>";
                      }
                      echo "</table>"; 
                      break;
                    
                    default: 
                    break;
             }
            //temporary break
            //break; 
         }
         }
        else
        {
           echo "No users with those characteristics";
        }
    }



    // Close the database connection
    pg_close($dbConn);
    //header("Location: ../queries.php");
}
?>