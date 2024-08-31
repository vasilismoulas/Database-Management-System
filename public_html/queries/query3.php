<?php
// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");


   $sql = 'SELECT Users.username, COUNT(atm), MAX(atm), MIN(atm) 
           FROM Barometer, Users, Barometer_measurement 
           WHERE Barometer_measurement.id_Users = Users.id AND Barometer_measurement.id_Barometer = Barometer.id  
           GROUP BY Barometer.userid, Users.username';

//  $sql = "SELECT userid
//          FROM Barometer";        
 

    $rets = pg_query($db_conn, $sql);
    if(!$rets) {
      echo pg_last_error($db_conn);
      exit;
     } 

echo "Για κάθε χρήστη, να παρουσιάσετε το username του, και το πλήθος των μετρήσεων ατμοσφαιρικής πίεσης (μέσω του αισθητήρα βαρόμετρου), όπως επίσης και τις ακραίες τους
      τιμές (MIN, MAX) που τον αφορούν..<br><br>";
echo "<table border='1'>";
echo "<tr><th>Username</th><th>COUNT(atm)</th><th>MAX(atm)</th><th>MIN(atm)</th></tr>";

while ($row = pg_fetch_assoc($rets)) {
    echo "<tr><td>" . $row["username"] . "</td><td>" . $row["count"] . "</td><td>" . $row["max"] . "</td><td>" . $row["min"] . "</td></tr>";
}

echo "</table>";
pg_close($db_conn);
?>