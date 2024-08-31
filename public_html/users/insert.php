<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve variables from the form
    $userId = $_POST["userid"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $first_name = $_POST["first_name"];
    $surname = $_POST["surname"];
    // Now you can use these variables as needed
    // For example, you can insert them into a database

    // Example database connection and insertion (replace with your actual database logic)
    $dbConn = pg_connect("host=localhost dbname=db1u14 user=db1u14 password=ste4nV84");

  //Checking if the current ^ insertion is allready inside the Table
  //If this is the case then we ask the user to give input again
  $sql = 'SELECT * FROM Users';
 
   $rets = pg_query($dbConn, $sql);
   if(!$rets) {
     echo pg_last_error($dbConn);
     exit;
    } 
   
   $cnt = 0; //Counting the fields that are the same with the fields of another insertion
            //If all the fields are the same, then we ask the user to give input again
   while($row = pg_fetch_row($rets)) {
     
        if($row[1] == $userId)
        $cnt++;
        
        if($row[2] == $username)
        $cnt++;
        
        if($row[4] == $email)
        $cnt++;
        
        if($cnt > 0) //Found a similar insertion
        break;
        // echo "This Insertion already exists! \n";
   }//while

  // if There is no other similar insertion then we add it to the Table
  if($cnt == 0) {
    $query = "INSERT INTO Users (userid, username, email, password,first_name,surname) 
              VALUES ('$userId', '$username', '$email', '$password', '$first_name','$surname')";

    $result = pg_query($dbConn, $query);
    if ($result) {
       // echo "Record inserted successfully";
    } else {
       // echo "Error inserting record: " . pg_last_error($dbConn);
    }
       // Close the database connection
       pg_close($dbConn);
       header("Location: ../users.php");
       exit;
 }
 else
 {
     echo "This record compromises the functional dependencies";
 }
 
}
?>