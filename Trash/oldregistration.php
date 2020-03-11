<?php
$firstname = filter_input(INPUT_POST, 'fname');
$lastname = filter_input(INPUT_POST, 'lname');
$userid = filter_input(INPUT_POST, 'userID');
$username = filter_input(INPUT_POST, 'username');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'psw');

if (!empty($firstname)){
if (!empty($lastname)){
if (!empty($userid)){
if (!empty($username)){
if (!empty($email)){
if (!empty($password)){
$host= "localhost";
$dbusername= "root";
$dbpassword= "";
$dbname= "quiz";

//creating a connection
$conn = new mysql ($host, $dbusername, $dbpassword, $dbname);
if (mysqli_connect_error()){
	die('Connect Error ('. mysqli_connect_errno() .')'
	. mysqli_connect_error());
}
else{
	$sql = "INSERT INTO users (id, fistname, lastname, username, email, password)
	values ('$userid', '$firstname', '$lastname', '$username', '$email', '$password')";
	if ($conn->query($sql)){
		echo "New user successfully registered";
	}
	else{
		echo "Error: ". $sql . "<br>". $conn->error;
	}
	$conn->close();
}
}
else{
	echo "password should not be empty";
	die();
}
else{
	echo "email should not be empty";
	die();
}
else{
	echo "username should not be empty";
	die();
}
else{
	echo "User ID should not be empty";
	die();	
}
else{
	echo "last name should not be empty";
	die();
}
else{
	echo "first name should not be empty";
	die();
}
?>