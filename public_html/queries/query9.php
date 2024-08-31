<?php
// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");


   $sql = 'SELECT Geolocation.longtitude, Geolocation.latitude, Geolocation.altitude, Barometer.atm, Users.username
           FROM Geolocation, Geolocation_measurement, Barometer, Barometer_measurement, Users
           WHERE Geolocation_measurement.id_Geolocation = Geolocation.id  AND Barometer_measurement.id_Barometer = Barometer.id 
           AND Geolocation_measurement.id_Geolocation = Barometer_measurement.id_Barometer AND Geolocation_measurement.id_Users = Users.id
           ORDER BY Geolocation.time_stamp';
//**SOS**
//GROUP BY Geolocation.userid,Users.username,Users.surname,Users.first_name' tha's why SQL can't understand that id in WHERE statement corresponds to a unique record, so we have to maintain the uniqueness of the records through the GROUP BY 
// Decimal Latitude: 37.510136degrees N
// Decimal Longitude: 22.372643degrees E

    $rets = pg_query($db_conn, $sql);
    if(!$rets) {
      echo pg_last_error($db_conn);
      exit;
     } 

echo "Να εμφανίσετε με αύξουσα χρονολογική σειρά, το γεωγραφικό μήκος, το γεωγραφικό
πλάτος, το υψόμετρο, την ατμοσφαιρική πίεση και το username του χρήστη, του οποίου η
συσκευή παρήγαγε αυτά τα δεδομένα για κάθε χρονική στιγμή συσχέτισής τους<br><br>";
echo "<table border='1'>";
echo "<tr><th>Longtitude</th><th>Latitude</th><th>Altitude</th><th>Pressure</th><th>Username</th></tr>";

while ($row = pg_fetch_assoc($rets)) {
    echo "<tr><td>" . $row["longtitude"] . "</td><td>" . $row["latitude"] . "</td><td>". $row["altitude"] ."</td><td>". $row["atm"] ."</td><td>". $row["username"]  ."</td></tr>";
}

echo "</table>";
pg_close($db_conn);
?>