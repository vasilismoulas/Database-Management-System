<?php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve variables from the form
    $x1 = isset($_POST["x1"]) ? $_POST["x1"] : null;
    $y1 = isset($_POST["y1"]) ? $_POST["y1"] : null;
    $x2 = isset($_POST["x2"]) ? $_POST["x2"] : null;
    $y2 = isset($_POST["y2"]) ? $_POST["y2"] : null;

// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");


   $sql = "SELECT Geolocation.userid, Users.username, MAX(Geolocation.time_stamp)
           FROM Geolocation, Users, Geolocation_measurement 
           WHERE Geolocation_measurement.id_Users = Users.id AND Geolocation_measurement.id_Geolocation = Geolocation.id 
           AND Geolocation.longtitude >= $x1  AND Geolocation.latitude >= $y1
           AND Geolocation.longtitude <= $x2 AND Geolocation.latitude <=  $y2
           GROUP BY Geolocation.userid,Users.username
           ORDER BY MAX(Geolocation.time_stamp) DESC";

// AND Geolocation.longtitude >= -122.084  AND Geolocation.latitude >= 37.4219983
// AND Geolocation.longtitude <= 23.8376549 AND Geolocation.latitude <= 38.2044868
// WHERE Geolocation_measurement.x >= x1 AND Geolocation_measurement.y >= y1
// AND Geolocation_measurement.x <= x2 AND Geolocation_measurement.y <= y2

    $rets = pg_query($db_conn, $sql);
    if(!$rets) {
      echo pg_last_error($db_conn);
      exit;
     } 

echo "Παρουσιάστε τα id και τα usernames των χρηστών που έχουν βρεθεί στο ορθογώνιο
που χαρακτηρίζεται από τα σημεία (x1,y1) και (x2,y2), όπως επίσης και την τελευταία
ημερομηνία και ώρα που βρέθηκαν σε αυτό. Η εμφάνιση των αποτελεσμάτων να γίνει με
φθίνουσα σειρά βάσει της ημερομηνίας και ώρας της τελευταίας επίσκεψης<br><br>";
echo "<table border='1'>";
echo "<tr><th>UserId</th><th>Username</th><th>Timestamp</th></tr>";

while ($row = pg_fetch_assoc($rets)) {
    echo "<tr><td>" . $row["userid"] . "</td><td>" . $row["username"] . "</td><td>".  $row['max'] ."</td></tr>";
}

echo "</table>";
pg_close($db_conn);
}
?>