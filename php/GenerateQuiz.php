<?php 
	//generate random quiz array and empty answers array based on quiz ID

	session_start();
	include('connect.php');
	$quiz_id = $_GET['id'];

	// create session arrays for question_ids and student's answers
	$_SESSION['question_ids'] = array();
	$_SESSION['student_answers'] = array();
	
	// get number of questions for the quiz
	$quiz_info_query = "select num_questions from quizzes where quiz_id = '$quiz_id'";
	$quiz_info_run = $conn->query($quiz_info_query);
	$quiz_info_row = mysqli_fetch_array($quiz_info_run);
	$num_questions = $quiz_info_row['num_questions'];
	
	// select the specified number of questions randomly and insert into question array
	$question_query = "select question_id from questions where quiz_id = '$quiz_id' order by rand() limit $num_questions";
	$question_run = $conn->query($question_query);
	$question_count = 0;
	while ($question_row = mysqli_fetch_array($question_run)){
		$_SESSION['question_ids'][$question_count] = $question_row['question_id'];
		$question_count++;
	}
?>