<?php
// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");


   $replica = "CREATE TABLE IF NOT EXISTS Barometer2
               (id SERIAL PRIMARY KEY NOT NULL,
                userid VARCHAR(40), 
                atm DOUBLE PRECISION,
                time_stamp timestamp)";

   $copyTo =  "INSERT INTO Barometer2 (userid,atm,time_stamp)
               SELECT userid,atm,time_stamp
               FROM Barometer";  

   $drop =    "DROP TABLE IF EXISTS Barometer2"; 

   $sql = ' SELECT DISTINCT Users.first_name
            FROM Barometer, Barometer2, Users, Barometer_measurement
            WHERE Barometer_measurement.id_Users = Users.id AND Barometer_measurement.id_Barometer = Barometer.id AND Barometer.userid = Barometer2.userid 
            AND Barometer.atm - Barometer2.atm >= 0.13
            AND EXTRACT(EPOCH FROM Barometer.time_stamp - Barometer2.time_stamp) = 6
            AND Barometer.atm IS NOT NULL
            AND Barometer2.atm IS NOT NULL
            ';
            //0.01220703125
//**SOS**
//GROUP BY Geolocation.userid,Users.username,Users.surname,Users.first_name' tha's why SQL can't understand that id in WHERE statement corresponds to a unique record, so we have to maintain the uniqueness of the records through the GROUP BY 
// Decimal Latitude: 37.510136degrees N
// Decimal Longitude: 22.372643degrees E
$relations = array($replica,$copyTo);

for($i=0;$i<count($relations);$i++){ 
    $ret = pg_query($db_conn, $relations[$i]);
    if(!$ret) {
        echo pg_last_error($db_conn);
        exit;
    } 
}       

echo "Βρείτε τα ονόματα των χρηστών που μέσα σε 6 δευτερόλεπτα η τιμή του βαρόμετρου άλλαξε
κατά 0.13 και τυπώστε την θέση του χρήστη που αντιστοιχεί την αρχική και τελική ένδειξη
του βαρόμετρου (αν αυτή έχει αποθηκευθεί). Δηλαδή θα παρουσιάσετε την θέση του χρήστη
την χρονική στιγμή της αρχικής και την χρονική στιγμή της τελικής τιμής του βαρόμετρου.
Αν το ερώτημά σας αργεί δοκιμάστε να αγνοήσετε τυχόν κενές τιμές του βαρόμετρου.<br><br>";
echo "<table border='1'>";
echo "<tr><th>First Name</th></tr>";
$rets = pg_query($db_conn, $sql);
while ($row = pg_fetch_assoc($rets)) {
    echo "<tr><td>" . $row["first_name"] ."</td></tr>";
}

echo "</table>";

//Drop Barometer2
pg_query($db_conn,$drop);

pg_close($db_conn);
?>