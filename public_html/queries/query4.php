<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Retrieve variables from the form
$x1 = isset($_POST["altitude"]) ? $_POST["altitude"] : null;

// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");


   $sql = "SELECT Users.surname, Users.first_name, MAX(Geolocation.altitude)
           FROM Geolocation, Users, Geolocation_measurement 
           WHERE Geolocation_measurement.id_Users = Users.id AND Geolocation_measurement.id_Geolocation = Geolocation.id  AND Geolocation.altitude > $x1
           GROUP BY Geolocation.userid,Users.surname, Users.first_name
           ORDER BY Users.surname, Users.first_name";

           //WHERE Geolocation_measurement.id_Users = Users.id AND Geolocation_measurement.id_Geolocation = Geolocation.id  AND Geolocation.altitude > 9

    $rets = pg_query($db_conn, $sql);
    if(!$rets) {
      echo pg_last_error($db_conn);
      exit;
     } 

echo "Εμφανίστε τα επώνυμα και τα ονόματα των χρηστών που έχουν βρεθεί σε υψόμετρο μεγαλύτερο της τιμής Y. Επιπλέον, για αυτούς τους χρήστες, να εμφανιστεί και η μέγιστη
καταγραφή υψομέτρου. Η εμφάνιση να γίνει με αλφαβητική σειρά βάσει των επωνύμων και
των ονομάτων των χρηστών.
<br><br>";
echo "<table border='1'>";
echo "<tr><th>Surname</th><th>First name</th><th>altitude</th></tr>";

while ($row = pg_fetch_assoc($rets)) {
    echo "<tr><td>" . $row["surname"] . "</td><td>" . $row["first_name"] . "</td><td>" . $row["max"] . "</td></tr>";
}

echo "</table>";
pg_close($db_conn);
}
?>