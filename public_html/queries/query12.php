<?php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve variables from the form
    $x1 = isset($_POST["x1"]) ? $_POST["x1"] : null;
    $y1 = isset($_POST["y1"]) ? $_POST["y1"] : null;
    $x2 = isset($_POST["x2"]) ? $_POST["x2"] : null;
    $y2 = isset($_POST["y2"]) ? $_POST["y2"] : null;
    $x3 = isset($_POST["x3"]) ? $_POST["x3"] : null;
    $y3 = isset($_POST["y3"]) ? $_POST["y3"] : null;
    $x4 = isset($_POST["x4"]) ? $_POST["x4"] : null;
    $y4 = isset($_POST["y4"]) ? $_POST["y4"] : null;
// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");


   $sql = " SELECT Users.first_name
            FROM Geolocation, Users, Geolocation_measurement
            WHERE Geolocation_measurement.id_Users = Users.id AND Geolocation_measurement.id_Geolocation = Geolocation.id 
            AND Geolocation.longtitude >= CAST('$x1' AS double precision)  AND Geolocation.latitude >= CAST('$y1' AS double precision) 
            AND Geolocation.longtitude <= CAST('$x2' AS double precision)   AND Geolocation.latitude <= CAST('$y2' AS double precision) 
            GROUP BY Geolocation.userid,Users.username,Users.surname,Users.first_name
              
            INTERSECT

            SELECT Users.first_name
            FROM Geolocation, Users, Geolocation_measurement
            WHERE Geolocation_measurement.id_Users = Users.id AND Geolocation_measurement.id_Geolocation = Geolocation.id 
            AND Geolocation.longtitude >= CAST('$x3' AS double precision)   AND Geolocation.latitude >= CAST('$y3' AS double precision) 
            AND Geolocation.longtitude <= CAST('$x4' AS double precision)   AND Geolocation.latitude <= CAST('$y4' AS double precision) 
            GROUP BY Geolocation.userid,Users.username,Users.surname,Users.first_name
            
            ";
//**SOS**
//GROUP BY Geolocation.userid,Users.username,Users.surname,Users.first_name' tha's why SQL can't understand that id in WHERE statement corresponds to a unique record, so we have to maintain the uniqueness of the records through the GROUP BY 
// Decimal Latitude: 37.510136degrees N
// Decimal Longitude: 22.372643degrees E

    $rets = pg_query($db_conn, $sql);
    if(!$rets) {
      echo pg_last_error($db_conn);
      exit;
     } 

echo "Να βρείτε τα ονόματα των χρηστών που έχουν βρεθεί στο τετράγωνο που ορίζεται από το
(x1,y1) και (x2,y2) και στην συνέχεια βρέθηκαν στο τετράγωνο που ορίζεται από το
(x3,y3) και (x4,y4). ΄Ολες οι παραπάνω παράμετροι ορίζονται από τον χρήστη.
<br><br>";
echo "<table border='1'>";
echo "<tr><th>First Name</th></tr>";

while ($row = pg_fetch_assoc($rets)) {
    echo "<tr><td>" . $row["first_name"] ."</td></tr>";
}

echo "</table>";
pg_close($db_conn);
}
?>