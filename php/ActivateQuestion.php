<?php 
	session_start();
	include('connect.php');
	
	$quiz_id = $_GET['id'];
	$update = "update quizzes set active = 1 where quiz_id = '$quiz_id'";
	
	if($conn->query($update) === true){
		echo("<script>alert('Quiz activated successfully! Students can now take this quiz.')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/QuizList.php';</script>");
	} else {
		echo("<script>alert('Error activating question!')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/QuizList.php';</script>");
	}
?>