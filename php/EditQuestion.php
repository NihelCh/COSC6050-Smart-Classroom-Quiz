<?php 

	// Establish connection and session
	include 'connect.php';
	session_start();

	// Get input
	$question = filter_input(INPUT_POST, 'q_name');
	$ans_a = filter_input(INPUT_POST, 'opt_1');
	$ans_b = filter_input(INPUT_POST, 'opt_2');
	$ans_c = filter_input(INPUT_POST, 'opt_3');
	$ans_d = filter_input(INPUT_POST, 'opt_4');
	$true_ans = filter_input(INPUT_POST, 'true_ans');
	$question_id = filter_input(INPUT_POST, 'question_id');
	$quiz_id = $_SESSION['quiz_id'];
	
	// Get current fields 
	$get = "select * from questions where question_id = '$question_id'";
	$get_run = $conn->query($get);
	$row = mysqli_fetch_array($get_run);
	
	// If these values aren't changed, set them to the original values before updating
	if ($question == ""){
		$question = $row['question'];
	}
	
	if ($ans_a == ""){
		$ans_a = $row['ans_a'];
	}
	
	if ($ans_b == ""){
		$ans_b = $row['ans_b'];
	}
	
	if ($ans_c == ""){
		$ans_c = $row['ans_c'];
	}
	
	if ($ans_d == ""){
		$ans_d = $row['ans_d'];
	}
	
	if ($true_ans == ""){
		$true_ans = $row['true_ans'];
	}

	// Insert escape characters into strings that include single quotes
	$question = str_replace("'", "\'", $question);
	$opt_1 = str_replace("'", "\'", $opt_1);
	$opt_2 = str_replace("'", "\'", $opt_2);
	$opt_3 = str_replace("'", "\'", $opt_3);
	$opt_4 = str_replace("'", "\'", $opt_4);
	
	// Update table
	$update = "update questions set question = '$question', ans_a = '$ans_a', ans_b = '$ans_b', ans_c = '$ans_c', ans_d = '$ans_d', true_ans = '$true_ans' 
				where question_id = '$question_id'";
	if ($conn->query($update) === TRUE) {
			//echo("<script>alert('Your question has been updated!')</script>");
            echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/Questions.php?id=$quiz_id';</script>");
	} else {
		echo $insert;
        echo("<script>alert('Error updating question!')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/Questions.php?id=$quiz_id';</script>");

	}
?>