<?php 

	// Establish connection and session
	include 'connect.php';
	session_start();

	// Get input
	$question = filter_input(INPUT_POST, 'q_name');
	$opt_1 = filter_input(INPUT_POST, 'opt_1');
	$opt_2 = filter_input(INPUT_POST, 'opt_2');
	$opt_3 = filter_input(INPUT_POST, 'opt_3');
	$opt_4 = filter_input(INPUT_POST, 'opt_4');
	$true_ans = filter_input(INPUT_POST, 'true_ans');
	$question_id = $_SESSION['question_id'];
	$quiz_id = $_SESSION['quiz_id'];

	// Insert escape characters into strings that include single quotes
	$question = str_replace("'", "\'", $question);
	$opt_1 = str_replace("'", "\'", $opt_1);
	$opt_2 = str_replace("'", "\'", $opt_2);
	$opt_3 = str_replace("'", "\'", $opt_3);
	$opt_4 = str_replace("'", "\'", $opt_4);
	
	// Insert into table
	$insert = "insert into questions (quiz_id,question,ans_a,ans_b,ans_c,ans_d,true_ans) values ('$quiz_id','$question','$opt_1','$opt_2','$opt_3','$opt_4','$true_ans')";
	if ($conn->query($insert) === TRUE) {
			echo("<script>alert('New question created successfully!')</script>");
            echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/Questions.php?id=$quiz_id';</script>");
	} else {
		echo $insert;
        echo("<script>alert('Error creating question!')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/Questions.php?id=$quiz_id';</script>");

	}
?>