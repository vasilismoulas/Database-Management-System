<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve variables from the form
  $x = isset($_POST["X"]) ? $_POST["X"] : null;
  $y = isset($_POST["Y"]) ? $_POST["Y"] : null;

// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");


   $sql = "SELECT Users.username, MAX(Geolocation.altitude),MIN(Geolocation.altitude)
           FROM Geolocation, Users, Geolocation_measurement 
           WHERE Geolocation_measurement.id_Users = Users.id AND Geolocation_measurement.id_Geolocation = Geolocation.id  AND Geolocation.altitude > $x
           GROUP BY Geolocation.userid,Users.username

           EXCEPT

           SELECT Users.username, MAX(Geolocation.altitude),MIN(Geolocation.altitude)
           FROM Geolocation, Users, Geolocation_measurement 
           WHERE Geolocation_measurement.id_Users = Users.id AND Geolocation_measurement.id_Geolocation = Geolocation.id  AND Geolocation.altitude < $y
           GROUP BY Geolocation.userid,Users.username          
           ";

           //Y = 20
           //X = 90

    $rets = pg_query($db_conn, $sql);
    if(!$rets) {
      echo pg_last_error($db_conn);
      exit;
     } 

echo "Να παρουσιάσετε τα usernames των χρηστών που έχουν βρεθεί σε υψόμετρο μεγαλύτερο
του X, αλλά δεν έχουν βρεθεί ποτέ σε υψόμετρο μικρότερο του Y, εμφανίζοντας ακόμη τα
μέγιστα και ελάχιστα υψόμετρα στα οποία έχουν βρεθεί.<br><br>";
echo "<table border='1'>";
echo "<tr><th>Username</th><th>MAX(altitude)</th><th>MIN(altitude)</th></tr>";

while ($row = pg_fetch_assoc($rets)) {
    echo "<tr><td>" . $row["username"] . "</td><td>" . $row["max"] . "</td><td>" . $row["min"] . "</td></tr>";
}

echo "</table>";
pg_close($db_conn);
}
?>