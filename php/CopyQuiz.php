<?php 

	// Establish connection and session
	include 'connect.php';
	session_start();


	// Get input
	// Get Form Data
	$new_class_id = filter_input(INPUT_POST, 'class_id');
	$quiz_id = filter_input(INPUT_POST, 'quiz_id');
	$quizname = filter_input(INPUT_POST, 'quizname');
    $quizdescription = filter_input(INPUT_POST, 'quizdescription');
	$timelimit = filter_input(INPUT_POST, 'timelimit');
	$numquestions = filter_input(INPUT_POST, 'numquestions');
	$numattempts = filter_input(INPUT_POST, 'numattempts');
	$username = $_SESSION['username'];
	
	// Get current fields 
	$get = "select * from quizzes where quiz_id = '$quiz_id'";
	$get_run = $conn->query($get);
	$row = mysqli_fetch_array($get_run);
	$old_quiz_name = $row['quiz_name'];
	
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
	
	// Check if this quiz already exists in the new class
	$check = "select 'x' from quizzes where class_id = '$new_class_id' and quiz_name = '$quizname'";
	$check_run = $conn->query($check);
	$result = mysqli_num_rows($check_run);
	
	if ($result > 0) {
		echo("<script>alert('This quiz already exists in the class you are copying to.  Try copying a different quiz or changing the title of the quiz.')</script>");
        echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/QuizList.php';</script>");
	} else {
	
		// Insert escape characters into strings that include single quotes
		$quizname = str_replace("'", "\'", $quizname);
		$quizdescription = str_replace("'", "\'", $quizdescription);

		$insert = "insert into quizzes (quiz_name, quiz_description, instructor_id, time_limit, num_questions, num_answer, max_attempt, class_id) values ('$quizname', '$quizdescription', '$username', '$timelimit', '$numquestions', 10, '$numattempts', '$new_class_id')";

		if ($conn->query($insert) === TRUE) {
			
			// get the new quiz id
			$get_id = "select quiz_id from quizzes where quiz_name = '$quizname' 
						and quiz_description = '$quizdescription'
						and instructor_id = '$username'
						and time_limit = '$timelimit'
						and num_questions = '$numquestions'
						and max_attempt = '$numattempts'
						and class_id = '$new_class_id'";
						
			$get_id_run = $conn->query($get_id);
			$get_id_row = mysqli_fetch_array($get_id_run);
			$new_quiz_id = $get_id_row['quiz_id'];
			
			// copy all questions from old quiz to new quiz
			$questions = "insert into questions (quiz_id, question, ans_a, ans_b, ans_c, ans_d, true_ans)
							select '$new_quiz_id', a.question, a.ans_a, a.ans_b, a.ans_c, a.ans_d, a.true_ans
							from questions a
							where a.quiz_id = '$quiz_id'";
			if ($conn->query($questions) === TRUE) {
			
				$alert = $quizname . " has been copied succesfully!"; 
				echo("<script>alert('".$alert."')</script>");
				echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/QuizList.php';</script>");
			} else {
				//echo $get_id;
				echo("<script>alert('Error inserting questions into copied quiz!')</script>");
				echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/QuizList.php';</script>");
			}
		} else {
			echo $update;
			echo("<script>alert('Error updating quiz!')</script>");
			echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz/TeacherPages/QuizList.php';</script>");

		}
	}
?>