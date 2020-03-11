<?php
include 'connect.php';
session_start();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

	// Get form data 
	$firstname = filter_input(INPUT_POST, 'fname');
	$lastname = filter_input(INPUT_POST, 'lname');
	$username = filter_input(INPUT_POST, 'username');
	$email = filter_input(INPUT_POST, 'email');
	$password = filter_input(INPUT_POST, 'password');
	$passwordConf = filter_input(INPUT_POST, 'passwordConf');
	$role = filter_input(INPUT_POST, 'role');
	
	// Set session variables for form in the case that the user will need to re-enter data
	if ($firstname != "") {
		$_SESSION['first_name_form'] = $firstname;
	}
	if ($lastname != "") {
		$_SESSION['last_name_form'] = $lastname;
	}
	if ($username != "") {
		$_SESSION['username_form'] = $username;
	}
	if ($email != "") {
		$_SESSION['email_form'] = $email;
	}
	
	$firstname = $_SESSION['first_name_form'];
	$lastname = $_SESSION['last_name_form'];
	$username = $_SESSION['username_form'];
	$email = $_SESSION['email_form'];
	
	// Ensure that the account can be added.  
	
	$valid = TRUE;

	// Check if username exists
	if ($valid === TRUE) {
		$checkSQL = "SELECT * from users where username = '$username'";
		$result = $conn->query($checkSQL)->num_rows;
		if ($result > 0) {
			$valid = false;
			$_SESSION['username_form'] = ""; //reset username to null because it is not valid
			echo("<script>alert('The username ".$username." already exists.  Try a different username')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/signup_retry.php';</script>");
			
		}
	}

	// Check if an account existst for this email address
	if ($valid === TRUE){
		$checkSQL = "SELECT * from users where email = '$email'";
		$result = $conn->query($checkSQL)->num_rows;
		if ($result > 0) {
			$valid = false;
			$_SESSION['email_form'] = ""; //reset email to null because it is not valid
			echo("<script>alert('There is already an account associated with ".$email.". Try signing up with another email address.')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/signup_retry.php';</script>");
		}
	}
	
	//Verify passwords match and are the proper criteria
	if ($valid === TRUE){
		if ($password !== $passwordConf){
			$valid = false;
			echo ("<script>alert('Passwords do not match!')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/signup_retry.php';</script>");

		// Validate password strength
		} elseif (strlen($password) < 6){
			$valid = false;
			echo ("<script>alert('Your Password Must Contain At Least 6 Characters!')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/signup_retry.php';</script>");

		} elseif (!preg_match("#[0-9]+#",$password)) {
			$valid = false;
			echo ("<script>alert('Your Password Must Contain At Least 1 Number!')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/signup_retry.php';</script>");
	
		} elseif (!preg_match("#[A-Z]+#",$password)) {
			$valid = false;
			echo ("<script>alert('Your Password Must Contain At Least 1 Uppercase Letter!')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/signup_retry.php';</script>");

		} elseif (!preg_match("#[a-z]+#",$password)) {
			$valid = false;
			echo ("<script>alert('Your Password Must Contain At Least 1 Lowercase Letter!')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/signup_retry.php';</script>");
		}
	}

	// If the account information is valid, insert into user table
	if ($valid === TRUE) {
		// Set session variables
		$_SESSION['username'] = $username;
		$_SESSION['last_activity'] = time();
		// Encrypt password
		$password_hash = password_hash($password, PASSWORD_BCRYPT);
		$newUserSQL = "insert into users (username, firstname, lastname, email, role, password_hash) values ('$username', '$firstname', '$lastname', '$email', '$role', '$password_hash')";
		if ($conn->query($newUserSQL) === TRUE) {
			$checkSQL = "SELECT username, role from users where username = '$username'";
			$result = $conn->query($checkSQL);
			while ($row = $result-> fetch_assoc()) {
				
				//reset form data to null
				$_SESSION['first_name_form'] = "";
				$_SESSION['last_name_form'] = "";
				$_SESSION['username_form'] = "";
				$_SESSION['email_form'] = "";
				
				//redirect to appropriate homescreen
				if ($row["role"] == "Teacher") {
					echo ("<script>alert('Your account has been successfully created.')</script>");
					echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/TeacherHome.php';</script>");
				} else {
					echo ("<script>alert('Your account has been successfully created.')</script>");
					echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/StudentPages/StudentHome.php';</script>");
			}
			}
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}
?>