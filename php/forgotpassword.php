<?php
$servername = "localhost";
$DBusername = "quizuser";
$DBpassword = "classquiz";
$DBname = "quiz";
// Create connection
$conn = new mysqli($servername, $DBusername, $DBpassword, $DBname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	
	$email = filter_input(INPUT_POST, 'email');
	
	$valid = TRUE;

	if ($valid === TRUE) {
		$checkSQL = "SELECT * from users where email = '$email'";
		$result = $conn->query($checkSQL)->num_rows;
		if ($result > 0) {
			echo success;
			$result = $conn->query($checkSQL);
			$r = mysqli_fetch_assoc($result);
			$password = $r['password'];
			$to = $r['email'];
			$subject = "Your Recovered Password";
			$message = "Please use the following password to login: " . $password . "\n" . "This is an automated message. Please do not reply to this address.";
			$headers = "From : Marquiz@marquette.edu";
			if(mail($to, $subject, $message, $headers)){
				echo("<script>alert('Your password has been sent to ".$email."')</script>");
				echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/index.html';</script>");
			}else{
				echo("<script>alert('Failed to recover password with provided email. Please try again.')</script>");
				echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/forgotpasswordpage.html';</script>");
			}
		} else {
			echo("<script>alert('The email ".$email." is not registered with MarQuiz. Try a different email.')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/forgotpasswordpage.html';</script>");
		}
	}



}
?>