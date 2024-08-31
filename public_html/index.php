<!DOCTYPE html>
<html lang="en">
  <?php
  // include ('connection_local.php');
  // $db = connecting();
  include ('connection.php');
  $db_conn = connection();

 if(isset($_GET['status']) == 'exists'){
   echo'
  <script>alert("Entry Already exists. Try another one.");</script>';
   header('Location: index.php');
 }
  ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Μετρήσεις Κινητών Συσκευών Χρηστών</title>
    <link rel="stylesheet" type="text/css" href="static/style.css">
    <link rel="icon" type="image/x-icon" href="media/sensor.png">
</head>
<body>


<!-- The sidebar -->
<div class="sidebar">
  <a class="active menu-text" href="index.php">DATABASE INITIALIZATION</a>
  <a class="menu-text" href="users.php">USERS</a>

  <div class="dropdown">
  <a class="menu-text" href="sensors.php">SENSORS</a>
  <!-- The dropdown content -->
  <div class="dropdown-content">
  
        <a class="menu-text active" href="magnetometer_sensor.php">Magnetometer</a>
        <a class="menu-text" href="accelerometer_sensor.php">Accelerometer</a>
        <a class="menu-text" href="geolocation_sensor.php">Geolocation</a>
        <a class="menu-text" href="gyroscope_sensor.php">Gyroscope</a>
        <a class="menu-text" href="step-counter_sensor.php">Step-counter</a>
        <a class="menu-text" href="barometer_sensor.php">Barometer</a>
        <a class="menu-text" href="proximity_sensor.php">Proximity</a>
  </div>
  </div>
  <a class="menu-text" href="queries.php">QUERIES</a>
</div>

<!-- Page content -->
<div class="content">
  <form action="database_init.php" method="post">
      <button type="submit" name="submit">DATABASE INITIALIASATION</button><!-- DATABASE INITIALIASATION -->
  </form>
</div>


</body>
</html>
