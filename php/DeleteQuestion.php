<?php 
	session_start();
	include('connect.php');
	
	$quiz_id = $_SESSION['quiz_id'];
	$question_id = $_POST['q_id'];
	$delete = "delete from questions where question_id = '$question_id'";
	
	if($conn->query($delete) === true){
		echo("<script>alert('Question deleted successfully!')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/Questions.php?id=$quiz_id';</script>");
	} else {
		echo("<script>alert('Error deleting question!')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/Questions.php?id=$quiz_id';</script>");
	}
	
?>