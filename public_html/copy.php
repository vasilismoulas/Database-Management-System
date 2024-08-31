<?php
function copyRecordstoTmpTables($db_conn)
{
// Array of Temporary Tables names
$tableNames = array('sensors_tmp','Geolocation_tmp','Users_tmp');
// Relative Path directing to the corresponding .csv files
$csvFilePaths = array('/home/Data/2023-24/sensorsF.csv','/home/Data/2023-24/coordinatesF.csv','/home/Data/2023-24/users.csv');
// Connecting errors checking
if (!$db_conn) {
    die("Connection failed: " . pg_last_error());
}

for($i = 0;$i<count($csvFilePaths);$i++){
    // Read the CSV file into an array
    $rows = file($csvFilePaths[$i], FILE_IGNORE_NEW_LINES);
    // Skip the header row if present
    array_shift($rows);
    // Copying .csv files records inside the Temporary table
    pg_copy_from($db_conn, $tableNames[$i], $rows, ",","");
}
}
?>
