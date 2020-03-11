<?php
include 'connect.php';
session_start();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} elseif (isset($_POST['submit'])) {
	
	// Get form data 
	$firstname	= filter_input(INPUT_POST, 'firstname');
    $lastname 	= filter_input(INPUT_POST, 'lastname');
	$email	= filter_input(INPUT_POST, 'email');
	$newusername	= filter_input(INPUT_POST, 'username');
	$password	= filter_input(INPUT_POST, 'password');
	$confpassword = filter_input(INPUT_POST, 'confpassword');
	$username = $_SESSION['username'];
	
	
	// Ensure that the account can be added.  
	$valid = TRUE;
	
	//Update table information by overwriting it.
	if ($valid = TRUE) {
		
		//defining overwriting functions
		$updatefnameSQL = "UPDATE users SET firstname = '$firstname' WHERE username = '$username' ";
		$updatelnameSQL = "UPDATE users SET lastname = '$lastname' WHERE username = '$username' ";
		$updateemailSQL = "UPDATE users SET email = '$email' WHERE username = '$username' ";
		//$updatepasswordSQL = "UPDATE users SET password = '$password' WHERE username = '$username' ";
		
		if(!empty($firstname)){
			if (mysqli_query($conn, $updatefnameSQL)) {
			}
		}
		if(!empty($lastname)){
			if (mysqli_query($conn, $updatelnameSQL)) {
			}
		}
		if(!empty($email)){
			$checkSQL = "SELECT email from users where email = '$email'";
			$result = $conn->query($checkSQL)->num_rows;
			if ($result > 0) {
				$valid = false;
				echo("<script>alert('There is already an account associated with ".$email.". Try updating with another email address.')</script>");
				echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/MyProfile.php';</script>");
				
			} elseif (mysqli_query($conn, $updateemailSQL)) {
			}
		}
		if(!empty($password)){
			if (strlen($password) < 6){
				$valid = false;
				echo ("<script>alert('Your Password Must Contain At Least 6 Characters!')</script>");
				echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/MyProfile.php';</script>");

			} elseif (!preg_match("#[0-9]+#",$password)) {
				$valid = false;
				echo ("<script>alert('Your Password Must Contain At Least 1 Number!')</script>");
				echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/MyProfile.php';</script>");
		
			} elseif (!preg_match("#[A-Z]+#",$password)) {
				$valid = false;
				echo ("<script>alert('Your Password Must Contain At Least 1 Uppercase Letter!')</script>");
				echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/MyProfile.php';</script>");

			} elseif (!preg_match("#[a-z]+#",$password)) {
				$valid = false;
				echo ("<script>alert('Your Password Must Contain At Least 1 Lowercase Letter!')</script>");
				echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/MyProfile.php';</script>");
			
			} elseif ($password !== $confpassword) {
				$valid = false;
				echo ("<script>alert('Passwords do not match!')</script>");
				echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/MyProfile.php';</script>");		
	
			} else {
				$password_hash = password_hash($password, PASSWORD_BCRYPT);
				$updatepasswordSQL = "UPDATE users SET password_hash = '$password_hash' WHERE username = '$username'";
				if ($conn->query($updatepasswordSQL) == true) {
					echo("<script>alert('Password updated successfully!') </script>");
					echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/MyProfile.php';</script>");
				} else {
					echo("<script>alert('Password updated failed!') </script>");
					echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/MyProfile.php';</script>");
				}
					
			}
				
		}
		
		echo("<script>alert('Information updated successfully!') </script>");
		echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/MyProfile.php';</script>");
	}
	
//deleting your account
} elseif (isset($_POST['delete'])){
	$username = $_SESSION['username'];	
	$deleteSQL = "DELETE FROM users WHERE username = '$username' ";
	if (mysqli_query($conn, $deleteSQL)) {
	}
	
	echo("<script>alert('Your account has been deleted!') </script>");
	echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/index.html';</script>");
}
?>