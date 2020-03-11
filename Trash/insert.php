<?php
session_start();// Starting Session
//Register progess start, if user press the signup button
if (isset($_POST['signup-btn'])) {
if (empty($_POST['fname']) || $_POST['lname']) || $_POST['userID']) || $_POST['username']) ||
 empty($_POST['email']) || empty($_POST['password'] || empty($_POST['passwordConf'] || empty($_POST['role'])) {
echo "Please fill up all the required field.";
}
else
{
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$userID = $_POST['userID'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$hash = password_hash($password, PASSWORD_DEFAULT);
$passwordConf= $_POST['passwordConf'];
$role= $_POST['role'];    

// Make a connection with MySQL server.
$host = "localhost";
$dbusername = "quizuser";
$dbpassword = "classquiz";
$dbname = "quiz";
// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
$sQuery = "SELECT userID from multiusers where email=? LIMIT 1";
$iQuery = "INSERT Into multiusers (firstname, lastname, userID, username, email, password, role) values(?, ?, ?, ?, ?, ?, ?)";
// To protect MySQL injection for Security purpose
$stmt = $conn->prepare($sQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($userID);
$stmt->store_result();
$rnum = $stmt->num_rows;
if($rnum==0) { //if true, insert new data
          $stmt->close();
          
          $stmt = $conn->prepare($iQuery);
    	  $stmt->bind_param("ssissss", $fname, $lname, $userID, $username, $email,  $hash,  $role);
          if($stmt->execute()) {
        echo 'Register successfully, Please login with your login details';}
        } else { 
       echo 'Someone already register with this email address.';
     }
$stmt->close();
$conn->close(); // Closing database Connection
}
}
?> 
