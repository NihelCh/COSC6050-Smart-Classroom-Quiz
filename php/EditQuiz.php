<?php 

	// Establish connection and session
	include 'connect.php';
	session_start();


	// Get input
	// Get Form Data
	$quiz_id = filter_input(INPUT_POST, 'quiz_id');
	$quizname = filter_input(INPUT_POST, 'quizname');
    $quizdescription = filter_input(INPUT_POST, 'quizdescription');
	$timelimit = filter_input(INPUT_POST, 'timelimit');
	$numquestions = filter_input(INPUT_POST, 'numquestions');
	$numattempts = filter_input(INPUT_POST, 'numattempts');
	
	// Get current fields 
	$get = "select * from quizzes where quiz_id = '$quiz_id'";
	$get_run = $conn->query($get);
	$row = mysqli_fetch_array($get_run);
	
	// If these values aren't changed, set them to the original values before updating
	if ($quizname == ""){
		$quizname = $row['quiz_name'];
	}
	
	if ($quizdescription == ""){
		$quizdescription = $row['quiz_description'];
	}
	
	if ($timelimit == ""){
		$timelimit = $row['time_limit'];
	}
	
	if ($numquestions == ""){
		$numquestions = $row['num_questions'];
	}
	
	if ($numattempts == ""){
		$numattempts = $row['max_attempt'];
	}
	
	// Insert escape characters into strings that include single quotes
	$quizname = str_replace("'", "\'", $quizname);
	$quizdescription = str_replace("'", "\'", $quizdescription);
	
	// Update table
	$update = "update quizzes set quiz_name = '$quizname', quiz_description = '$quizdescription', time_limit = '$timelimit', num_questions = '$numquestions', max_attempt = '$numattempts' 
				where quiz_id = '$quiz_id'";
	if ($conn->query($update) === TRUE) {
			echo("<script>alert('Your quiz has been updated!')</script>");
            echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/QuizList.php';</script>");
	} else {
		echo $update;
        echo("<script>alert('Error updating quiz!')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/QuizList.php';</script>");

	}
?>