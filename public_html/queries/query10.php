<?php
// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");




$sql1 = "    SELECT  *

             FROM(
             SELECT Users.userid, Users.username, TO_CHAR(Accelerometer.time_stamp, 'YYYY-MM-DD') AS date, TO_CHAR(Accelerometer.time_stamp, 'HH24:00') AS hour, COUNT(*) AS data_registries, 'accelerator' AS sensor
             FROM Accelerometer, Users, Accelerometer_measurement  
             WHERE Accelerometer_measurement.id_Users = Users.id AND Accelerometer_measurement.id_Accelerometer = Accelerometer.id 
             GROUP BY Users.userid, Users.username, TO_CHAR(Accelerometer.time_stamp, 'YYYY-MM-DD'), TO_CHAR(Accelerometer.time_stamp, 'HH24:00')
             
             UNION ALL

             SELECT Users.userid, Users.username, TO_CHAR(Barometer.time_stamp, 'YYYY-MM-DD') AS date,TO_CHAR(Barometer.time_stamp, 'HH24:00') AS hour, COUNT(*) AS data_registries, 'barometer' AS sensor
             FROM Barometer, Users, Barometer_measurement  
             WHERE Barometer_measurement.id_Users = Users.id AND Barometer_measurement.id_Barometer = Barometer.id 
             GROUP BY Users.userid, Users.username, TO_CHAR(Barometer.time_stamp, 'YYYY-MM-DD'), TO_CHAR(Barometer.time_stamp, 'HH24:00')

             UNION ALL

             SELECT Users.userid, Users.username, TO_CHAR(Magnetometer.time_stamp, 'YYYY-MM-DD') AS date,TO_CHAR(Magnetometer.time_stamp, 'HH24:00') AS hour, COUNT(*) AS data_registries, 'magnetometer' AS sensor
             FROM Magnetometer, Users, Magnetometer_measurement  
             WHERE Magnetometer_measurement.id_Users = Users.id AND Magnetometer_measurement.id_Magnetometer = Magnetometer.id 
             GROUP BY Users.userid, Users.username, TO_CHAR(Magnetometer.time_stamp, 'YYYY-MM-DD'), TO_CHAR(Magnetometer.time_stamp, 'HH24:00')

             UNION ALL

             SELECT Users.userid, Users.username, TO_CHAR(Geolocation.time_stamp, 'YYYY-MM-DD') AS date,TO_CHAR(Geolocation.time_stamp, 'HH24:00') AS hour, COUNT(*) AS data_registries, 'geolocation' AS sensor
             FROM Geolocation, Users, Geolocation_measurement  
             WHERE Geolocation_measurement.id_Users = Users.id AND Geolocation_measurement.id_Geolocation = Geolocation.id 
             GROUP BY Users.userid, Users.username, TO_CHAR(Geolocation.time_stamp, 'YYYY-MM-DD'), TO_CHAR(Geolocation.time_stamp, 'HH24:00')

             UNION ALL

             SELECT Users.userid, Users.username, TO_CHAR(Gyroscope.time_stamp, 'YYYY-MM-DD') AS date,TO_CHAR(Gyroscope.time_stamp, 'HH24:00') AS hour, COUNT(*) AS data_registries, 'gyroscope' AS sensor
             FROM Gyroscope, Users, Gyroscope_measurement  
             WHERE Gyroscope_measurement.id_Users = Users.id AND Gyroscope_measurement.id_Gyroscope = Gyroscope.id 
             GROUP BY Users.userid, Users.username, TO_CHAR(Gyroscope.time_stamp, 'YYYY-MM-DD'), TO_CHAR(Gyroscope.time_stamp, 'HH24:00')

             UNION ALL

             SELECT Users.userid, Users.username, TO_CHAR(Step_counter.time_stamp, 'YYYY-MM-DD') AS date,TO_CHAR(Step_counter.time_stamp, 'HH24:00') AS hour, COUNT(*) AS data_registries, 'step_counter' AS sensor
             FROM Step_counter, Users, Step_counter_measurement  
             WHERE Step_counter_measurement.id_Users = Users.id AND Step_counter_measurement.id_Step_counter = Step_counter.id 
             GROUP BY Users.userid, Users.username, TO_CHAR(Step_counter.time_stamp, 'YYYY-MM-DD'), TO_CHAR(Step_counter.time_stamp, 'HH24:00')

             UNION ALL

             SELECT Users.userid, Users.username, TO_CHAR(Proximity.time_stamp, 'YYYY-MM-DD') AS date,TO_CHAR(Proximity.time_stamp, 'HH24:00') AS hour, COUNT(*) AS data_registries, 'proximity' AS sensor
             FROM Proximity, Users, Proximity_measurement  
             WHERE Proximity_measurement.id_Users = Users.id AND Proximity_measurement.id_Proximity = Proximity.id 
             GROUP BY Users.userid, Users.username, TO_CHAR(Proximity.time_stamp, 'YYYY-MM-DD'), TO_CHAR(Proximity.time_stamp, 'HH24:00')
             ) AS SensorDataAlias

             ORDER BY userid, sensor
             
             ";



echo "Για κάθε χρήστη, να εμφανίσετε τον μοναδικό κωδικό του (user id), το username του,
τις ημερομηνίες και τις ώρες δραστηριότητας (δηλαδή τις ώρες κατά τις οποίες υπάρχουν
καταγραφές σε οποιονδήποτε αισθητήρα), το πλήθος των πραγματικών μετρήσεων του κάθε
αισθητήρα, καθώς επίσης και τον τύπο του αισθητήρα που έκανε αυτές τις καταγραφές<br><br>";
echo "<table border='1'>";

$relations = array($sql1);

for($i=0;$i<count($relations);$i++){ 
    $ret = pg_query($db_conn, $relations[$i]);
    
    switch ($relations[$i]){

        case $sql1:
        echo "<h3></h3><br><br>";
        echo "<table border='1'>";
        echo "<tr><th>uid</th><th>username</th><th>date</th><th>hour</th><th>data_registries</th><th>sensor</th></tr>";
        while ($row = pg_fetch_assoc($ret)) {  
        echo "<tr><td>" . $row['userid'] . "</td><td>" . $row['username'] . "</td><td>".$row['date']. "</td><td>".$row['hour']. "</td><td>". $row['data_registries'] . "</td><td>" . $row['sensor'] . "</td></tr>";
        }
        echo "</table>";  
        break;
        
        
        default: 
        break;
 }
//temporary break
//break; 
}

echo "</table>";
pg_close($db_conn);
?>