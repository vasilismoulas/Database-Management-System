<?php
// insert.php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve variables from the form
    $userId = $_POST["userid"];
    $accelerometerX = $_POST["accelerometer_x"];
    $accelerometerY = $_POST["accelerometer_y"];
    $accelerometerZ = $_POST["accelerometer_z"];
    $timeStamp = $_POST["time_stamp"];

    // Now you can use these variables as needed
    // For example, you can insert them into a database
   // echo "".$userId;
    // Example database connection and insertion (replace with your actual database logic)
    $dbConn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");

    //Before we add the record inside the Desired sensor Table we must ensure that the given userId exists inside Users Table for multitude reasons 
    $multitude = "SELECT * FROM Users WHERE userid = '$userId'";

    $ret = pg_query($dbConn, $multitude);
    if(!$ret) {
    echo pg_last_error($dbConn);
    exit;
    } 

    $multitudecnt = 0; //Counting the fields that are the same with the fields of another insertion
          //If all the fields are the same, then we ask the user to give input again
    if($row = pg_fetch_row($ret)) {
      $multitudecnt++;    
      //echo "<tr><td>" . $row[1] ;
    }

    $sql = 'SELECT * 
            FROM Accelerometer';
    

 if($multitudecnt > 0){
    $rets = pg_query($dbConn, $sql);
    if(!$rets) {
    echo pg_last_error($dbConn);
    exit;
    } 
    
    $duplicate = false; 
    $cnt = 0; //Counting the fields that are the same with the fields of another insertion
          //If all the fields are the same, then we ask the user to give input again
    while($row = pg_fetch_row($rets)) {
    
      if($row[1] == $userId)
      {
        $cnt++;
      }
    
      if($row[2] == $accelerometerX)
      {
        $cnt++;
      }
    
      if($row[3] == $accelerometerY)
      {
        $cnt++;
      }
    
      if($row[4] == $accelerometerZ)
      {
        $cnt++;
      }
      
      if(strtotime($row[5]) == $timeStamp)
      {
        $cnt++;
      }
    
    
    if($cnt == 5) //Found a similar insertion
    {
     // echo "This Insertion already exists! \n";
      break;
    }  
    else
    {
     $cnt = 0; //Reset for each repetetion
    }
    
    }//while
    
    
    if($cnt == 0) // if There is no other similar insertion then we add it to the Table
    {
     echo "".$cnt;

    $query = "INSERT INTO Accelerometer (userid, accelerometer_x, accelerometer_y, accelerometer_z, time_stamp) 
              VALUES ('$userId', CAST('$accelerometerX' AS double precision), CAST('$accelerometerY' AS double precision), CAST('$accelerometerZ' AS double precision), TO_TIMESTAMP($timeStamp)::TIMESTAMP)";

    $result = pg_query($dbConn, $query);

    if ($result) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . pg_last_error($dbConn);
    }

    //**UPDATING THE CORRESPONDING CORRELATION**
    $Idpairs =  "SELECT Users.id AS id_u, Accelerometer.id AS id_m 
                  FROM Users, Accelerometer
                  WHERE Users.userid = Accelerometer.userid AND Users.userid = '$userId' AND Accelerometer.userid = '$userId'";   

 
    $result = pg_query($dbConn, $Idpairs);
    if(!$result) {
      echo pg_last_error($dbConn);
    } else {
      //echo "Table created successfully\n";
    } 

    // Fetch the result row
    while ($row = pg_fetch_assoc($result)){
      $id_Users = $row['id_u'];
      $id_Measurement = $row['id_m'];

      // Check if values are not empty
    if (!empty($id_Users) && !empty($id_Measurement)) {
      $insertMeasurement = "INSERT INTO Accelerometer_measurement (id_Users,id_Accelerometer)
                                 VALUES ($id_Users, $id_Measurement)";

      $insertResult = pg_query($dbConn, $insertMeasurement);

      if (!$insertResult) {
          echo pg_last_error($dbConn);
      } else {
          //echo "Data inserted into Magnetometer_measurement successfully\n";
      }                           
    }
   }                             

    // Close the database connection
    pg_close($dbConn);
   // header("Location: ../accelerometer_sensor.php");
    exit;
 }
 else
   {
     echo "This record compromises the functional dependencies";
   }

}//if multitude
else
{
  echo "No user with that userId";
}
}
?>