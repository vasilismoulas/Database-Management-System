<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Μετρήσεις Κινητών Συσκευών Χρηστών</title>
    <link rel="stylesheet" type="text/css" href="static/style.css">
    <link rel="icon" type="image/x-icon" href="media/sensor.png">
    <style>
      .content_queries {
       margin-left: 250px;
       padding: 16px;
      }

      .content_queries form {
       text-align: left;
       margin-bottom: 20px;
     }

      #search_bar {
      width: 50vw;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
      background-color: white;
      background-image: url('media/searchicon.png');
      background-size: 20px;
      background-position: 10px 10px; 
      background-repeat: no-repeat;
      padding: 12px 20px 12px 40px;
      text-align: left;
    }

    table {
    table-layout: fixed;
    border-collapse: collapse;
    border: 3px #04AA6D;
    }

    </style>
</head>
<body>
    
<!-- The sidebar -->
<div class="sidebar">
  <a class="menu-text" href="index.php">DATABASE INITIALIZATION</a>
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
  <a class="active menu-text" href="queries.php">QUERIES</a>
</div>

<!-- Page content -->
<div class="">
  <form action="" method="post" onsubmit="return validateForm();">
    <input id="search_bar" type="text" name="search" placeholder="Search..">
    <!-- <h3 style=margin-right:600px>results:</h3> -->
 </form>  

 <!-- Query Forms -->
 <div class="">
  <form id="form_query2" action="queries/query2.php" method="post" style=display:none onsubmit="return fieldinput();">
  <table>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Date From:</td>
            <td><input style = width:100%;height:100% type="date" name="datefrom" required></td>
        </tr>
        <tr>
            <td>Date Until:</td>
            <td><input style = width:100%;height:100% type="date" name="dateuntil" required></td>
        </tr>
        <tr>
            <td>Surname:</td>
            <td><input style = width:100%;height:100% type="text" name="surname" required></td>
        </tr>
        <tr>
            <td>Firstname:</td>
            <td><input style = width:100%;height:100% type="text" name="firstname"></td>
        </tr>
        <tr>
            <td>Username:</td>
            <td><input style = width:100%;height:100% type="text" name="username"></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input style = width:100%;height:100% type="email" name="email"></td>
        </tr>
    </table>
    <input style = background-color:#04AA6D type="submit" value="Submit">  
  </form>  
 </div>

 <!-- Query Forms -->
 <div class="">
  <form id="form_query11" action="queries/query11.php" method="post" style=display:none onsubmit="">
  <table>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        <tr>
            <td>Date From:</td>
            <td><input style = width:100%;height:100% type="date" name="dateFrom" required></td>
        </tr>
        <tr>
            <td>Date Until:</td>
            <td><input style = width:100%;height:100% type="date" name="dateUntil" required></td>
        </tr>
        <tr>
    </table>
    <input style = background-color:#04AA6D type="submit" value="Submit">  
  </form>  
 </div>

<!-- Query Forms -->
<div class="">
  <form id="form_query12" action="queries/query12.php" method="post" style=display:none onsubmit="">
  <table>
        <tr>
            <th>Coordinates</th>
            <th>Values</th>
        </tr>
        <tr>
            <td>x1:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="x1" required></td>
        </tr>
        <tr>
            <td>y1:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="y1" required></td>
        </tr>
        <tr>
            <td>x2:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="x2" required></td>
        </tr>
        <tr>
            <td>y2:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="y2" required></td>
        </tr>

        <tr>
            <td>x3:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="x3" required></td>
        </tr>
        <tr>
            <td>y3:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="y3" required></td>
        </tr>
        <tr>
            <td>x4:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="x4" required></td>
        </tr>
        <tr>
            <td>y4:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="y4" required></td>
        </tr>

        <tr>
    </table>
    <input style = background-color:#04AA6D type="submit" value="Submit">  
  </form>  
 </div>

 <div class="">
  <form id="form_query6" action="queries/query6.php" method="post" style=display:none onsubmit="">
  <table>
        <tr>
            <th>Coordinates</th>
            <th>Values</th>
        </tr>
        <tr>
            <td>x1:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="x1" required></td>
        </tr>
        <tr>
            <td>y1:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="y1" required></td>
        </tr>
        <tr>
            <td>x2:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="x2" required></td>
        </tr>
        <tr>
            <td>y2:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="y2" required></td>
        </tr>
        <tr>
    </table>
    <input style = background-color:#04AA6D type="submit" value="Submit">  
  </form>  
 </div>

 <div class="">
  <form id="form_query4" action="queries/query4.php" method="post" style=display:none onsubmit="">
  <table>
        <tr>
            <th>Altitude</th>
            <th>Values</th>
        </tr>
        <tr>
            <td>altitude:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="altitude" required></td>
        </tr>
        <tr>
    </table>
    <input style = background-color:#04AA6D type="submit" value="Submit">  
  </form>  
 </div>

 <div class="">
  <form id="form_query5" action="queries/query5.php" method="post" style=display:none onsubmit="">
  <table>
        <tr>
            <th>Altitude</th>
            <th>Values</th>
        </tr>
        <tr>
            <td>altitude_X:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="X" required></td>
        </tr>
        <tr>
            <td>altitude_Y:</td>
            <td><input style = width:100%;height:100% type="number" step="0.00000000000000001" name="Y" required></td>
        </tr>
        <tr>
    </table>
    <input style = background-color:#04AA6D type="submit" value="Submit">  
  </form>  
 </div>

</div>


<!-- Include .js file -->
<script src="queries/validterms.js"></script>
<script src="queries/emptyfields.js"></script>
</body>
</html>
