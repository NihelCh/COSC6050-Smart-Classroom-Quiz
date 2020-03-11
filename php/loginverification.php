<?php
session_start();
include 'connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

	// Get form data 
	$username = filter_input(INPUT_POST, 'username');
	$password = filter_input(INPUT_POST, 'password');

	// Validate username and password
	$checkSQL = "SELECT username, role, password_hash from users where username = '$username'";
	$result = $conn->query($checkSQL);
		if ($result-> num_rows > 0) {
			while ($row = mysqli_fetch_array($result)) {
				
				// Get password hash
				$password_hash = $row['password_hash'];
	
				// Verify entered password against password hash 
				if (password_verify($password, $password_hash) == 1) {
					$_SESSION['username'] = $username;
					$_SESSION['last_activity'] = time();
					if ($row["role"] == "Teacher") {
						header('Location: https://pascal.mscsnet.mu.edu/quiz/TeacherPages/TeacherHome.php');
					} else {
						header('Location: https://pascal.mscsnet.mu.edu/quiz/StudentPages/StudentHome.php');
					}
				} else {
					echo ("<script>alert('username or password is invalid!')</script>");
					echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/index.html';</script>");
				}
				
			}
		} else {
			echo ("<script>alert('username or password is invalid!')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/index.html';</script>");
		}
		
		
}	
	
?>