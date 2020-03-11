<?php
include 'connect.php';
include 'TeacherClass.php';
//include 'CreateClass.php';

session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

	// Get Form Data
	$quizname = filter_input(INPUT_POST, 'quizname');
    $quizdescription = filter_input(INPUT_POST, 'quizdescription');
	$timelimit = filter_input(INPUT_POST, 'timelimit');
	$numquestions = filter_input(INPUT_POST, 'numquestions');
	$numattempts = filter_input(INPUT_POST, 'numattempts');
	
	// Ensure that the account can be added.  
	$valid = TRUE;
	$username = $_SESSION['username'];
	$classid = $_SESSION['class_id'];
	
	// Check if a quizname exists
	if ($valid === TRUE){
		$checkSQL = "SELECT * from quizzes where quiz_name = '$quizname'";
		$result = $conn->query($checkSQL)->num_rows;
		if ($result > 0) {
			$valid = false;
			echo("<script>alert('There is already a quiz associated with ".$quizname.". Try creating a quiz with another name.')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/TeacherClass.php';</script>");
		}
	}

	// If the data information is valid, insert into quizzes table
	if ($valid === TRUE) {
		var_dump ($classid);
		$newSQL = "insert into quizzes (quiz_name, quiz_description, instructor_id, time_limit, num_questions, num_answer, max_attempt, class_id) values ('$quizname', '$quizdescription', '$username', '$timelimit', '$numquestions', 10, '$numattempts', '$classid')";
		if ($conn->query($newSQL) === TRUE) {
			
			// Get the ID of this quiz and redirect to the questions page for this 
			$id_query = "select quiz_id from quizzes 
				where quiz_name = '$quizname' 
				and quiz_description = '$quizdescription' 
				and instructor_id = '$username' 
				and time_limit = '$timelimit'
				and num_questions = '$numquestions'
				and max_attempt = '$numattempts'
				and class_id = '$classid'";
			
			$id_run = $conn->query($id_query);
			$id_row = mysqli_fetch_array($id_run);
			$quiz_id = $id_row['quiz_id'];
			
			echo ("<script>alert('New quiz created successfully!')</script>");
			echo ("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/Questions.php?id=$quiz_id';</script>");
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
			echo("<script>alert('Error creating quiz')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/TeacherClass.php';</script>");
		}
    }
}


?>