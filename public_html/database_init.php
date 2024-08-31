<?php
include ('copy.php');
include ('connection.php');


function FinalRelations_create($db_conn){
    // **CREATE FINAL TABLES **

        // Σχέση Users
        $sql1 =
        "CREATE TABLE IF NOT EXISTS Users
        (id SERIAL PRIMARY KEY NOT NULL,
         userid VARCHAR(40), 
         username VARCHAR(40),
         password VARCHAR(40),
         email VARCHAR(40), 
         first_name VARCHAR(40), 
         surname VARCHAR(40))";
        // Σχέση Magnetometer
        $sql2 =
        "CREATE TABLE IF NOT EXISTS Magnetometer
        (id SERIAL PRIMARY KEY NOT NULL,
         userid VARCHAR(40),
         magnetometer_x DOUBLE PRECISION, 
         magnetometer_y DOUBLE PRECISION, 
         magnetometer_z DOUBLE PRECISION, 
         time_stamp timestamp)";
        
        // Σχέση Accelerometer
        $sql3 =
        "CREATE TABLE IF NOT EXISTS Accelerometer
        (id SERIAL PRIMARY KEY NOT NULL,
         userid VARCHAR(40),
         accelerometer_x DOUBLE PRECISION,
         accelerometer_y DOUBLE PRECISION,
         accelerometer_z DOUBLE PRECISION,
         time_stamp timestamp)";
        
        // Σχέση Geolocation 
        $sql4 =
        "CREATE TABLE IF NOT EXISTS Geolocation
        (id SERIAL PRIMARY KEY NOT NULL,
         userid VARCHAR(40), 
         longtitude DOUBLE PRECISION,
         latitude   DOUBLE PRECISION,
         altitude   DOUBLE PRECISION, 
         time_stamp timestamp)";
        
        // Σχέση Gyroscope
        $sql5 =
        "CREATE TABLE IF NOT EXISTS Gyroscope
        (id SERIAL PRIMARY KEY NOT NULL,
         userid VARCHAR(40), 
         gyroscope_x DOUBLE PRECISION,
         gyroscope_y DOUBLE PRECISION,
         gyroscope_z DOUBLE PRECISION, 
         time_stamp timestamp)"; 
        
        // Σχέση Step_counter
        $sql6 =
        "CREATE TABLE IF NOT EXISTS Step_counter
        (id SERIAL PRIMARY KEY NOT NULL, 
         userid VARCHAR(40),
         footsteps INT,
         time_stamp timestamp)";
         
        // Σχέση Proximity
        $sql7 =
        "CREATE TABLE IF NOT EXISTS Proximity
        (id SERIAL PRIMARY KEY NOT NULL,
         userid VARCHAR(40), 
         proximity_boolean BOOLEAN,
         time_stamp timestamp)";
        
        // Σχέση Barometer
        $sql8 =
        "CREATE TABLE IF NOT EXISTS Barometer
        (id SERIAL PRIMARY KEY NOT NULL,
         userid VARCHAR(40), 
         atm DOUBLE PRECISION,
         time_stamp timestamp)";

         // Συσχέτιση Magnetometer - Users
         $sql9 =
         "CREATE TABLE IF NOT EXISTS Magnetometer_measurement
         ( id_Users INTEGER,
           id_Magnetometer INTEGER,
           FOREIGN KEY (id_Users) REFERENCES Users(id),
           FOREIGN KEY (id_Magnetometer) REFERENCES Magnetometer(id))";

        // Συσχέτιση Accelerometer - Users
         $sql10 =
         "CREATE TABLE IF NOT EXISTS Accelerometer_measurement
         ( id_Users INTEGER,
           id_Accelerometer INTEGER,
           FOREIGN KEY (id_Users) REFERENCES Users(id),
           FOREIGN KEY (id_Accelerometer) REFERENCES Accelerometer(id))";

         // Συσχέτιση Geolocation - Users
         $sql11 =
         "CREATE TABLE IF NOT EXISTS Geolocation_measurement
         ( id_Users INTEGER,
           id_Geolocation INTEGER,
           FOREIGN KEY (id_Users) REFERENCES Users(id),
           FOREIGN KEY (id_Geolocation) REFERENCES Geolocation(id))";

         // Συσχέτιση Gyroscope - Users
         $sql12 =
         "CREATE TABLE IF NOT EXISTS Gyroscope_measurement
         ( id_Users INTEGER,
           id_Gyroscope INTEGER,
           FOREIGN KEY (id_Users) REFERENCES Users(id),
           FOREIGN KEY (id_Gyroscope) REFERENCES Gyroscope(id))"; 

         // Συσχέτιση Step-counter - Users
         $sql13 =
         "CREATE TABLE IF NOT EXISTS Step_counter_measurement
         ( id_Users INTEGER,
           id_Step_counter INTEGER,
           FOREIGN KEY (id_Users) REFERENCES Users(id),
           FOREIGN KEY (id_Step_counter) REFERENCES Step_counter(id))";
 
         // Συσχέτιση Proximity - Users
         $sql14 =
         "CREATE TABLE IF NOT EXISTS Proximity_measurement
         ( id_Users INTEGER,
           id_Proximity INTEGER,
           FOREIGN KEY (id_Users) REFERENCES Users(id),
           FOREIGN KEY (id_Proximity) REFERENCES Proximity(id))";

         // Συσχέτιση Barometer - Users
         $sql15 =
         "CREATE TABLE IF NOT EXISTS Barometer_measurement
         (id_Users INTEGER,
          id_Barometer INTEGER,
          FOREIGN KEY (id_Users) REFERENCES Users(id),
          FOREIGN KEY (id_Barometer) REFERENCES Barometer(id))";


          //**Execution** of SQL queries
          $relations = array($sql1,$sql2,$sql3,$sql4,$sql5,$sql6,$sql7,$sql8,$sql9,$sql11,$sql10,$sql12,$sql13,$sql14,$sql15);
          for($i=0;$i<count($relations);$i++){ 
            $ret = pg_query($db_conn, $relations[$i]);
            echo "".$relations[$i];
            if(!$ret) {
            echo pg_last_error($db_conn);
            } else {
            // echo "Table created successfully\n";
            }   
          }
    }
  
    function TmpRelations_create($db_conn)
    {
        // **CREATE TEMPORARY TABLES**

        // Σχέση Users_tmp
        $sqltmp1 =
        "CREATE TABLE IF NOT EXISTS Users_tmp
        ( userid VARCHAR(40), 
          email VARCHAR(40),
          username VARCHAR(30),
          password VARCHAR(40),   
          surname VARCHAR(40),
          first_name VARCHAR(40))";
        
        // Σχέση Geolocation_tmp
        $sqltmp2 =
        "CREATE TABLE IF NOT EXISTS Geolocation_tmp
        ( userid VARCHAR(40),
         time_stamp INT,
         latitude   DOUBLE PRECISION,
         longtitude DOUBLE PRECISION,
         altitude   DOUBLE PRECISION )";

        // Σχέση sensors_tmp
        $sqltmp3 =
        "CREATE TABLE IF NOT EXISTS sensors_tmp
        (userid VARCHAR(40),
         time_stamp INT,
         pressure       DOUBLE PRECISION,
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
         steps          INT)";


        //**Execution** of SQL queries
        $TmpRelations = array($sqltmp1,$sqltmp2,$sqltmp3);

        for($i=0;$i<count($TmpRelations);$i++){ 
          $ret = pg_query($db_conn, $TmpRelations[$i]);
          if(!$ret) {
          echo pg_last_error($db_conn);
          } else {
        // echo "Table created successfully\n";
        }   
       }
    copyRecordstoTmpTables($db_conn);     
}


function Relations_init($db_conn){
 // **INSERT QUERIES FOR RELATIONS**

      $sqlinsert1 = "INSERT INTO Users (userid, username, password, email, first_name, surname)
                     SELECT userid,username, password, email, first_name, surname
                     FROM Users_tmp";

      $sqlinsert2 = "INSERT INTO Geolocation (userid, longtitude,latitude,altitude,time_stamp)
                     SELECT userid, longtitude, latitude, altitude, TO_TIMESTAMP(time_stamp)::TIMESTAMP
                     FROM Geolocation_tmp";

      $sqlinsert3 = "INSERT INTO Magnetometer (userid, magnetometer_x,magnetometer_y,magnetometer_z,time_stamp)
                     SELECT userid, magnetometer_x,magnetometer_y,magnetometer_z,TO_TIMESTAMP(time_stamp)::TIMESTAMP
                     FROM sensors_tmp";

      $sqlinsert4 = "INSERT INTO Accelerometer (userid, accelerometer_x,accelerometer_y,accelerometer_z,time_stamp)
                     SELECT userid, acceleration_x,acceleration_y,acceleration_z,TO_TIMESTAMP(time_stamp)::TIMESTAMP
                     FROM sensors_tmp";

      $sqlinsert5 = "INSERT INTO Gyroscope (userid, gyroscope_x,gyroscope_y,gyroscope_z,time_stamp)
                     SELECT userid, gyroscope_x,gyroscope_y,gyroscope_z,TO_TIMESTAMP(time_stamp)::TIMESTAMP
                     FROM sensors_tmp";  

      $sqlinsert6 = "INSERT INTO Step_counter (userid,footsteps,time_stamp)
                     SELECT userid,steps,TO_TIMESTAMP(time_stamp)::TIMESTAMP
                     FROM sensors_tmp"; 
                    
      $sqlinsert7 = "INSERT INTO Proximity (userid,proximity_boolean,time_stamp)
                     SELECT userid,proximity,TO_TIMESTAMP(time_stamp)::TIMESTAMP
                     FROM sensors_tmp";  

      $sqlinsert8 = "INSERT INTO Barometer (userid,atm,time_stamp)
                     SELECT userid,pressure,TO_TIMESTAMP(time_stamp)::TIMESTAMP
                     FROM sensors_tmp"; 


      $sqldrop1 = "DROP TABLE sensors_tmp";  

      $sqldrop2 = "DROP TABLE Users_tmp"; 

      $sqldrop3 = "DROP TABLE Geolocation_tmp"; 

      //**Execution** of SQL queries
      $droptmptables = array($sqldrop1,$sqldrop2,$sqldrop3);
      $relationload = array($sqlinsert1,$sqlinsert2,$sqlinsert3,$sqlinsert4,$sqlinsert5,$sqlinsert6,$sqlinsert7,$sqlinsert8);
      for($i=0;$i<count($relationload);$i++){ 
        $ret = pg_query($db_conn, $relationload[$i]);
        if(!$ret) {
        echo pg_last_error($db_conn);
        } else {
        //echo "Table created successfully\n";
        }   
      }

     for($i=0;$i<count($droptmptables);$i++){ 
      $ret = pg_query($db_conn, $droptmptables[$i]);
      if(!$ret) {
      echo pg_last_error($db_conn);
      } else {
      //echo "Table created successfully\n";
      }   
     }

    }

    function correlation_init($db_conn){
     // Extracts the corresponding id measurements(sensors) by userid 
     $Idpairs1 = "SELECT Users.id AS id_u, Magnetometer.id AS id_m 
                  FROM Users, Magnetometer
                  WHERE Users.userid = Magnetometer.userid";
               
     $Idpairs2 = "SELECT Users.id AS id_u, Barometer.id AS id_m 
                  FROM Users, Barometer
                  WHERE Users.userid = Barometer.userid";

     $Idpairs3 = "SELECT Users.id AS id_u, Accelerometer.id AS id_m 
                  FROM Users, Accelerometer
                  WHERE Users.userid = Accelerometer.userid";

     $Idpairs4 = "SELECT Users.id AS id_u, Proximity.id AS id_m 
                  FROM Users, Proximity
                  WHERE Users.userid = Proximity.userid";

     $Idpairs5 = "SELECT Users.id AS id_u, Step_counter.id AS id_m 
                  FROM Users, Step_counter
                  WHERE Users.userid = Step_counter.userid";

     $Idpairs6 = "SELECT Users.id AS id_u, Geolocation.id AS id_m 
                  FROM Users, Geolocation
                  WHERE Users.userid = Geolocation.userid";

     $Idpairs7 = "SELECT Users.id AS id_u, Gyroscope.id AS id_m 
                  FROM Users, Gyroscope
                  WHERE Users.userid = Gyroscope.userid";

     $correlationsrecs = array($Idpairs1,$Idpairs2,$Idpairs3,$Idpairs4,$Idpairs5,$Idpairs6,$Idpairs7);     
     

    for($i=0;$i<count($correlationsrecs);$i++){
    $result = pg_query($db_conn, $correlationsrecs[$i]);
    if(!$result) {
      echo pg_last_error($db_conn);
    } else {
      //echo "Table created successfully\n";
    } 

    // Fetch the result row
    while ($row = pg_fetch_assoc($result)){
      $id_Users = $row['id_u'];
      $id_Measurement = $row['id_m'];

      // Check if values are not empty
    if (!empty($id_Users) && !empty($id_Measurement)) {
      $insertMeasurement1 = "INSERT INTO Magnetometer_measurement (id_Users,id_Magnetometer)
                                 VALUES ($id_Users, $id_Measurement)";
      
      $insertMeasurement2 = "INSERT INTO Barometer_measurement (id_Users,id_Barometer)
                                 VALUES ($id_Users, $id_Measurement)";

      $insertMeasurement3 = "INSERT INTO Accelerometer_measurement (id_Users,id_Accelerometer)
                                 VALUES ($id_Users, $id_Measurement)";

      $insertMeasurement4 = "INSERT INTO Proximity_measurement (id_Users,id_Proximity)
                                 VALUES ($id_Users, $id_Measurement)";

      $insertMeasurement5 = "INSERT INTO Step_counter_measurement (id_Users,id_Step_counter)
                                 VALUES ($id_Users, $id_Measurement)";

      $insertMeasurement6 = "INSERT INTO Geolocation_measurement (id_Users,id_Geolocation)
                                 VALUES ($id_Users, $id_Measurement)";

      $insertMeasurement7 = "INSERT INTO Gyroscope_measurement (id_Users,id_Gyroscope)
                                 VALUES ($id_Users, $id_Measurement)";

      $correlationsrecsins = array($insertMeasurement1,$insertMeasurement2,$insertMeasurement3,$insertMeasurement4,$insertMeasurement5,$insertMeasurement6,$insertMeasurement7); 

      $insertResult = pg_query($db_conn, $correlationsrecsins[$i]);

      if (!$insertResult) {
          echo pg_last_error($db_conn);
      } else {
          //echo "Data inserted into Magnetometer_measurement successfully\n";
      }
    } else {
      // Handle empty values if needed
    }
    }
   } 
  } 


set_time_limit(100);

$db_conn = connection();

FinalRelations_create($db_conn);
TmpRelations_create($db_conn);
Relations_init($db_conn);
correlation_init($db_conn);

pg_close($dbConn);

// Redirect to the main page (index.php)
header("Location: index.php");
exit(); 
?>
