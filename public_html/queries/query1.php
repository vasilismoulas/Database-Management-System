<?php
include ('../connection.php');

$db_conn = connection();


  $query1 = 'SELECT surname,first_name,username,email FROM Users ORDER BY surname ASC, first_name ASC';
  $query2 = 'SELECT surname,first_name,username,email FROM Users ORDER BY surname ASC, first_name ASC'; 

    $rets = pg_query($db_conn, $query1);
    if(!$rets) {
      echo pg_last_error($db_conn);
      exit;
     } 

echo "<h3>Παρουσίαση χρηστών</h3>Παρουσίαση για κάθε χρήστη, το επώνυμο, το όνομα, το
           username και το email του, με αλφαβητική σειρά (βάσει των ονοματεπώνυμων).<br><br>";
echo "<table border='1'>";
echo "<tr><th>Επώνυμο</th><th>Ονομα</th><th>Username</th><th>Email</th></tr>";

while ($row = pg_fetch_assoc($rets)) {
    echo "<tr><td>" . $row['surname'] . "</td><td>" . $row['first_name'] . "</td><td>" . $row['username'] . "</td><td>" . $row['email'] . "</td></tr>";
}

echo "</table>";
pg_close($db_conn);
?>