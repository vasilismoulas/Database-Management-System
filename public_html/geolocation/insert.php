<?php
// insert.php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve variables from the form
    $userId = $_POST["userid"];
    $longtitude = $_POST["longtitude"];
    $altitude = $_POST["altitude"];
    $latitude = $_POST["latitude"];
    $timestamp   = $_POST["time_stamp"];
 

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
    FROM Geolocation';
    


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
    
      if($row[2] == $longtitude)
      {
        $cnt++;
      }
    
      if($row[3] == $latitude)
      {
        $cnt++;
      }
    
      if($row[4] == $altitude)
      {
        $cnt++;
      }
      
      if(strtotime($row[5]) == $timestamp)
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

    $query = "INSERT INTO Geolocation (userid,longtitude,altitude,latitude,time_stamp) 
              VALUES ('$userId', CAST('$longtitude' AS double precision),CAST('$altitude' AS double precision),CAST('$latitude' AS double precision), TO_TIMESTAMP($timestamp)::TIMESTAMP)";

    $result = pg_query($dbConn, $query);

    if ($result) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . pg_last_error($dbConn);
    }


    //**UPDATING THE CORRESPONDING CORRELATION**
    $Idpairs =  "SELECT Users.id AS id_u, Geolocation.id AS id_m 
    FROM Users, Geolocation
    WHERE Users.userid = Geolocation.userid AND Users.userid = '$userId' AND Geolocation.userid = '$userId'";   


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
    $insertMeasurement = "INSERT INTO Geolocation_measurement (id_Users,id_Geolocation)
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
    //header("Locaiotn: ../geolocation_sensor.php");
    exit;
}
else
   {
     echo "This record compromises the functional dependencies";
   }
}
else
{
  echo "No user with that userId";
}
}
?>