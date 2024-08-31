<?php
// insert.php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve variables from the form
    $userId = $_POST["userid"];
    $gyroscopeX = $_POST["gyroscope_x"];
    $gyroscopeY = $_POST["gyroscope_y"];
    $gyroscopeZ = $_POST["gyroscope_z"];
    $timeStamp = $_POST["time_stamp"];

    // Now you can use these variables as needed
    // For example, you can insert them into a database

    // Example database connection and insertion (replace with your actual database logic)
    $dbConn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");

   //**MULTITUDE**
    //Before we add the record inside the Desired sensor Table we must ensure that the given userId exists inside Users Table for multitude reasons 
    $multitude = "SELECT * FROM Users WHERE userid = '$userId'";

    $ret = pg_query($dbConn, $multitude);
    if(!$ret) {
    echo pg_last_error($dbConn);
    exit;
    } 

    $multitudecnt = 0; //Counting the fields that are the same with the fields of another insertion
          //If all the fields are the same, then we ask the user to give input again
    while($row = pg_fetch_row($ret)) {
      $multitudecnt++;
    }  


    $sql = 'SELECT * 
    FROM Gyroscope';
    
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
    
      if($row[2] == $gyroscopeX)
      {
        $cnt++;
      }
    
      if($row[3] == $gyroscopeY)
      {
        $cnt++;
      }
    
      if($row[4] == $gyroscopeZ)
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

    $query = "INSERT INTO Gyroscope (userid, gyroscope_x, gyroscope_y, gyroscope_z, time_stamp) 
              VALUES ('$userId', CAST('$gyroscopeX'AS double precision), CAST('$gyroscopeY'AS double precision), CAST('$gyroscopeZ'AS double precision), TO_TIMESTAMP($timeStamp)::TIMESTAMP)";

    $result = pg_query($dbConn, $query);

    if ($result) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . pg_last_error($dbConn);
    }

     //**UPDATING THE CORRESPONDING CORRELATION**
     $Idpairs =  "SELECT Users.id AS id_u, Gyroscope.id AS id_m 
     FROM Users, Gyroscope
     WHERE Users.userid = Gyroscope.userid AND Users.userid = '$userId' AND Gyroscope.userid = '$userId'";   
 
 
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
    $insertMeasurement = "INSERT INTO Gyroscope_measurement (id_Users,id_Gyroscope)
                        VALUES ($id_Users, $id_Measurement)";
    
    $insertResult = pg_query($dbConn, $insertMeasurement);
    
    if (!$insertResult) {
        echo pg_last_error($dbConn);
    } else {
       // echo "Data inserted into Magnetometer_measurement successfully\n";
    }                  
    }
    }                             

   }
   else
   {
     echo "This record compromises the functional dependencies";
   }
  } //multitude 
  else
{
  echo "No user with that userId";
}
    // Close the database connection
    pg_close($dbConn);
   // header("Location: ../gyroscope_sensor.php");
    exit;
}
?>