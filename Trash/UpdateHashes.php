<?php
session_start();
include('connect.php');
$username=$_SESSION['username'];

$p_query = "select username, password from users";
$p_run = $conn->query($p_query);
while ($p_row = mysqli_fetch_array($p_run)){
	
	// Get their password and encrypt
	$old_pw = $p_row['password'];
	$username = $p_row['username'];
	$password_hash = password_hash($old_pw, PASSWORD_BCRYPT);
	
	// Insert their hashed password
	if (password_verify($old_pw, $password_hash) == 1){
		echo "Verification works.  Inserting password hash into table for user ".$username.".<br>";
		$insert = "update users set password_hash = '$password_hash' where username = '$username'";
		if($conn->query($insert) == true){
			echo "Password hash updated.<br>";
		} else {
			echo "SQL failed: ".$insert.".<br>";
		}
	} else {
		echo "Right password is not accepted for user ".$username.". <br>";
	}  
	
}

?>