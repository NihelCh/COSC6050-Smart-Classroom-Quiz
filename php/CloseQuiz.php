<?php 
	session_start();
	include('connect.php');
	
	$quiz_id = $_GET['id'];
	$update = "update quizzes set active = 2 where quiz_id = '$quiz_id'";
	
	if($conn->query($update) === true){
		echo("<script>alert('Your quiz has been closed! Students will no longer be able to take this quiz.')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/QuizList.php';</script>");
	} else {
		echo("<script>alert('Error closing quiz!')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/QuizList.php';</script>");
	}
?>