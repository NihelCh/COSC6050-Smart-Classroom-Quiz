<?php
include('GetClassCode.php');
session_start();

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

	// Get form data 
	$classcode = filter_input(INPUT_POST, 'classcode');
	// Ensure that the account can be added.  
	$valid = TRUE;
	$username= $_SESSION['username'];
	
	// Get the class_id for the class code
	$get_id_query = "select class_id from class where class_code = '$classcode'";
	$get_id_run = $conn->query($get_id_query);
	
	if ($get_id_run->num_rows == 0){
		// no class exists for this code
		echo("<script>alert('Please enter a valid class code!')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/StudentPages/StudentHome.php';</script>");
	} else {
		// get the class id
		$get_id_row = mysqli_fetch_array($get_id_run);
		$class_id = $get_id_row['class_id'];
	}

	// Check if a classcode exists
	//if ($valid === TRUE){
		//$checkSQL = "SELECT * from enrollment where class_code = '$classcode'";
		//$result = $conn->query($checkSQL)->num_rows;
		//if ($result > 0) {
			//$valid = false;
			//echo("<script>alert('You are already registred for the class with code ".$classcode.". Try to join another class.')</script>");
			//echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/StudentPages/StudentHome.php';</script>");
		//}
	//}
	

	// If the data information is valid, insert into class table
	if ($valid === TRUE) {
		$newJoinSQL = "insert into enrollment (class_code, student_id, class_id) values ('$classcode','$username', '$class_id')";
		if ($conn->query($newJoinSQL) === TRUE) {
			echo("<script>alert('You are successfully joined to this class!')</script>");
            echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/StudentPages/StudentHome.php';</script>");
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
			echo("<script>alert('Please enter a valid class code!')</script>");
            echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/StudentPages/StudentHome.php';</script>");
		}
    }
}
?>