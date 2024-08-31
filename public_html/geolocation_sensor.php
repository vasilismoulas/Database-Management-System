<!DOCTYPE html>
<html lang="en">
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
  <a class="menu-text" href="index.php">DATABASE INITIALIZATION</a>
  <a class="menu-text" href="users.php">USERS</a>
  <div class="dropdown">
  <a class="menu-text active" href="sensors.php">SENSORS</a>
  <!-- The dropdown content -->
  <div class="dropdown-content">
  
        <a class="menu-text" href="magnetometer_sensor.php">Magnetometer</a>
        <a class="menu-text" href="accelerometer_sensor.php">Accelerometer</a>
        <a class="menu-text active" href="geolocation_sensor.php">Geolocation</a>
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
<form action="geolocation/insert.php" method="post">
    <table>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>UserId:</td>
            <td><input type="text" name="userid" required></td>
        </tr>
        <tr>
            <td>Longtitude:</td>
            <td><input type="number" name="longtitude" step="0.00000000000000001" required></td>
        </tr>
        <tr>
            <td>Latitude:</td>
            <td><input type="number" name="latitude" step="0.00000000000000001" required></td>
        </tr>
        <tr>
            <td>Altitude:</td>
            <td><input type="number" name="altitude" step="0.00000000000000001" required></td>
        </tr>
        <tr>
            <td>Time_stamp(Unix Epoch):</td>
            <td><input type="text" name="time_stamp" required></td>
        </tr>
    </table>
    <input type="submit" value="Insert Record">
</form>

<form action="geolocation/delete.php" method="post">
    <table>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>UserId:</td>
            <td><input type="text" name="userid" required></td>
        </tr>
        <tr>
            <td>Longtitude:</td>
            <td><input type="number" name="longtitude" step="0.00000000000000001" required></td>
        </tr>
        <tr>
            <td>Latitude:</td>
            <td><input type="number" name="latitude" step="0.00000000000000001" required></td>
        </tr>
        <tr>
            <td>Altitude:</td>
            <td><input type="number" name="altitude" step="0.00000000000000001" required></td>
        </tr>
        <tr>
            <td>Time_stamp(Unix Epoch):</td>
            <td><input type="text" name="time_stamp" required></td>
        </tr>
    </table>
    <input type="submit" value="Delete Record">
</form>
</div>
     
</body>
</html>
