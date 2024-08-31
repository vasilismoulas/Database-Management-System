<?php
// Check if the form was submitted
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Retrieve variables from the form
     $timeStampFrom = $_POST["dateFrom"];
     $timeStampUntil = $_POST["dateUntil"];

// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");
$timeStampF = strtotime($timeStampFrom);
$timeStampU = strtotime($timeStampUntil);

   $sql = "SELECT COUNT(*),COUNT(username) AS u, COUNT(atm) AS a, COUNT(footsteps ) AS f ,COUNT(proximity_boolean ) AS p,TO_CHAR(Proximity.time_stamp, 'YYYY-MM') AS time_stamp
           FROM Proximity, Barometer,Step_counter, Users, Proximity_measurement,Barometer_measurement,Step_counter_measurement
           WHERE Proximity.time_stamp>TO_TIMESTAMP($timeStampF) AND Proximity.time_stamp<TO_TIMESTAMP($timeStampU) AND Proximity_measurement.id_Proximity = Proximity.id  
           AND Barometer_measurement.id_Barometer = Barometer.id AND Proximity_measurement.id_Proximity = Barometer_measurement.id_Barometer AND Proximity_measurement.id_Users = Users.id
           AND Step_counter_measurement.id_Step_counter = Step_counter.id AND Proximity_measurement.id_Proximity = Step_counter_measurement.id_Step_counter 
           GROUP BY TO_CHAR(Proximity.time_stamp, 'YYYY-MM')
           ORDER BY TO_CHAR(Proximity.time_stamp, 'YYYY-MM')";

//echo ""." ".$timeStampF." ".$timeStampU ;          
//**SOS**
//GROUP BY Geolocation.userid,Users.username,Users.surname,Users.first_name' tha's why SQL can't understand that id in WHERE statement corresponds to a unique record, so we have to maintain the uniqueness of the records through the GROUP BY 
// Decimal Latitude: 37.510136degrees N
// Decimal Longitude: 22.372643degrees E

    $rets = pg_query($db_conn, $sql);
    if(!$rets) {
      echo pg_last_error($db_conn);
      exit;
     } 

echo "Μεταξύ του μήνα X και του μήνα Y, βρείτε και παρουσιάσετε ανά μήνα: (α) τις συνολικές
εγγραφές των αισθητήρων εγγύτητας, βαρόμετρου και βηματόμετρου, (β) τους συνολικούς
διακριτούς χρήστες που τις κατέγραψαν, (γ) τις συνολικές διακριτές τιμές πίεσης, (δ) τις
συνολικές διακριτές τιμές βημάτων και (ε) τις συνολικές διακριτές τιμές εγγύτητας.
Καθώς το ερώτημα είναι απαιτητικό στο χρόνο απάντησής του, δοκιμάστε το αρχικά για το
Ιούνιο του 2013 (2023-06) όπου τα δεδομένα δεν είναι πολλά. Προσέξτε και βεβαιωθείτε ότι
κάθε φορά είτε ολοκληρώνεται είτε τερματίζεται. Δείτε και τις αντίστοιχες οδηγίες στην
ομάδα του teams<br><br>";
echo "<table border='1'>";
echo "<tr><th>COUNT(measurements)</th><th>COUNT(username)</th><th>COUNT(atm)</th><th>COUNT(footsteps )</th><th>COUNT(proximity_boolean )</th><th>timestamp</th></tr>";

while ($row = pg_fetch_assoc($rets)) {
    echo"<tr><td>" . $row["count"] ."</td><td>". $row["u"] . "</td><td>" . $row["a"] . "</td><td>". $row["f"] ."</td><td>". $row["p"] ."</td><td>". $row["time_stamp"] ."</td></tr>";
}

echo "</table>";
pg_close($db_conn);
}
?>