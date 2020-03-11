<?php
include('GetClassCode.php');
include 'connect.php';
session_start();


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

	// Get form data 
	$classname = filter_input(INPUT_POST, 'classname');
    //$subject = $_POST['subject'];
	$subject = filter_input(INPUT_POST,'subject');
	// Insert escape characters into strings that include single quotes
	$classname = str_replace("'", "\'", $classname);
	
	// Ensure that the account can be added.  
	$valid = TRUE;
	$username = $_SESSION['username'];
	
	// Get a unique class code
	$codeExists = true;
	while($codeExists == true)
	{
		$classcode = generateRandomCode();
		$query = "select 'x' from class where class_code = '$classcode'";
		$numRows = $conn->query($query)->num_rows;
		if ($numRows == 0) {
			$codeExists = false;
		} 
	}
	
	// Subject is a required field
	if (empty($subject)) {
		$valid = false;
		echo("<script>alert('Subject is a required. Please select a subject to classify your class.')</script>");
		echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/TeacherHome.php';</script>");
	}

	// Check if a classname exists
	if ($valid === TRUE){
		$checkSQL = "SELECT * from class where classname = '$classname'";
		$result = $conn->query($checkSQL)->num_rows;
		if ($result > 0) {
			$valid = false;
			echo("<script>alert('There is already a class associated with ".$classname.". Try create a class with another class name.')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/TeacherHome.php';</script>");
		}
	}

	// If the data information is valid, insert into class table
	if ($valid === TRUE) {
		$newClassSQL = "insert into class (classname, class_code, subject, instructor_id) values ('$classname', '$classcode', '$subject', '$username')";
		if ($conn->query($newClassSQL) === TRUE) {
			echo("<script>alert('New class created successfully! Class Code: ".$classcode."')</script>");
            echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/TeacherHome.php';</script>");
		} else {
			$sql_error = "SQL Error: " . $sql . "<br>" . $conn->error;
			echo("<script>alert('Error with sql statement ".$newClassSQL. "')</script>");
			echo("<script>alert('".$sql_error. "')</script>");
            echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/TeacherHome.php';</script>");

		}
    }
}
?>