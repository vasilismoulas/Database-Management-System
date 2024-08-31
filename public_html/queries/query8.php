<?php
// Example database connection and insertion (replace with your actual database logic)
$db_conn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");


   $sql = 'SELECT Geolocation.userid, Users.surname, Users.first_name, MIN(time_stamp), MAX(time_stamp)
           FROM Geolocation, Users, Geolocation_measurement 
           WHERE Geolocation_measurement.id_Users = Users.id AND Geolocation_measurement.id_Geolocation = Geolocation.id 
           AND Geolocation.longtitude >= 22.3721399  AND Geolocation.latitude >= 37.5272276
           AND Geolocation.longtitude <= 22.3722522  AND Geolocation.latitude <= 37.5273043
           GROUP BY Geolocation.userid,Users.username,Users.surname,Users.first_name';
//**SOS**
//GROUP BY Geolocation.userid,Users.username,Users.surname,Users.first_name' tha's why SQL can't understand that id in WHERE statement corresponds to a unique record, so we have to maintain the uniqueness of the records through the GROUP BY 
// Decimal Latitude: 37.510136degrees N
// Decimal Longitude: 22.372643degrees E

    $rets = pg_query($db_conn, $sql);
    if(!$rets) {
      echo pg_last_error($db_conn);
      exit;
     } 

echo "Να βρείτε τους χρήστες που βρέθηκαν πλησίον ή εντός των πάνω κτιρίου της σχολής στην
Τρίπολη. Για αυτούς, να παρουσιάσετε το id, το επώνυμο, το όνομα, καθώς επίσης και
τις ημερομηνίες επίσκεψης. Επιπλέον, για κάθε ημερομηνία να εμφανίζετε τις ώρες που
βρέθηκαν εκεί για πρώτη και τελευταία φορά.
Πρέπει πρώτα να ορίσετε ένα ορθογώνιο που περιέχει το κτήριο. Μετά ελέγχετε αν
οι χρήστες είναι εντός του ορθογωνίου. Για να εξάγετε την ημερομηνία από το τύπο
timestamp μπορείτε να αντλήσετε τις συναρτήσεις DATE και TO CHAR<br><br>";
echo "<table border='1'>";
echo "<tr><th>UserId</th><th>Surname</th><th>First Name</th><th>First Visit</th><th>Last Visit</th></tr>";

while ($row = pg_fetch_assoc($rets)) {
    echo "<tr><td>" . $row["userid"] . "</td><td>" . $row["surname"] . "</td><td>". $row["first_name"] ."</td><td>". $row["min"] . "</td><td>". $row["max"] ."</td></tr>";
}

echo "</table>";
pg_close($db_conn);
?>