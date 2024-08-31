<?php
// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");


   $sql = 'SELECT Accelerometer.userid, Users.username, AVG(SQRT(Accelerometer.accelerometer_x^2 + Accelerometer.accelerometer_y^2 + Accelerometer.accelerometer_z^2))
           FROM Accelerometer, Users, Accelerometer_measurement 
           WHERE Accelerometer_measurement.id_Users = Users.id AND Accelerometer_measurement.id_Accelerometer = Accelerometer.id 
           GROUP BY Accelerometer.userid,Users.username
           ORDER BY AVG(SQRT(Accelerometer.accelerometer_x^2 + Accelerometer.accelerometer_y^2 + Accelerometer.accelerometer_z^2)) DESC';

// WHERE Geolocation_measurement.x >= x1 AND Geolocation_measurement.y >= y1
// AND Geolocation_measurement.x <= x2 AND Geolocation_measurement.y <= y2

    $rets = pg_query($db_conn, $sql);
    if(!$rets) {
      echo pg_last_error($db_conn);
      exit;
     } 

echo "Για κάθε χρήστη, να εμφανίσετε το id, το username και το μέσο μέτρο της επιτάχυνσης
όπως αυτό προκύπτει από τα δεδομένα του επιταχυνσιόμετρου. Η εμφάνιση να γίνει με
φθίνουσα σειρά βάσει του μέσου μέτρου της επιτάχυνσης.
Σημείωση. Για τον υπολογισμό του μέτρου της επιτάχυνσης χρησιμοποιείστε τη συνάρτηση
SQRT(acceleration x^2 + acceleration y^2 + acceleration z^2).
<br><br>";
echo "<table border='1'>";
echo "<tr><th>UserId</th><th>Username</th><th>Average(acceleration)</th></tr>";

while ($row = pg_fetch_assoc($rets)) {
    echo "<tr><td>" . $row["userid"] . "</td><td>" . $row["username"] . "</td><td>".  $row['avg'] ."</td></tr>";
}

echo "</table>";
pg_close($db_conn);
?>