<?php
session_start();
include('connect.php');

// Check if username exists for the session
 if (!isset($_SESSION['username'])) {
		echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/index.html';</script>");
} else {
	$now = time(); // Checking the time now when home page starts.

	if ($now - $_SESSION['last_activity'] > 1800) {
		// Last activity was more than 30 minutes ago
		session_destroy();
		echo ("<script>alert('Your session has expired!  Please log in again.')</script>");
		echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/index.html';</script>");
	}
	else {  
		// Session is valid. Get session variables
		$_SESSION['last_activity'] = time();
		$username = $_SESSION['username'];

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} else {
			// Get user information
			$checkSQL = "SELECT * from users where username = '$username'";
			$result = $conn->query($checkSQL);
			
			while ($row = $result-> fetch_assoc()){
				$name = $row['firstname'] ." ". $row['lastname']." ";
				$_SESSION['name'] = $name;
				$_SESSION['role'] = $row['role'];
				$_SESSION['email'] = $row['email'];
			}
		}
	}
}
?>
