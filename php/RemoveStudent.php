<?php
include('session.php');
include('connect.php');
session_start();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

	$student_id = $_GET['id'];
	$class_id = $_SESSION['class_id'];
	$removeSQL = "DELETE FROM enrollment WHERE class_id = '$class_id' and student_id = '$student_id'";
	if (mysqli_query($conn, $removeSQL)) {
		echo("<script>alert('This student has been removed!') </script>");
		echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/ClassList.php';</script>");
	}else{
		echo "error";
	}
}
?>