<?php
	session_start();
	include('../php/connect.php');
	include('../php/session.php');
	
	// set decimal precision for division
	ini_set("precision", 3);
	
	// get session variables
	$class_id = $_SESSION['class_id'];
	$user_id = $_SESSION['username'];
	$quiz_id = $_SESSION['quiz_id'];
	$class_id = $_SESSION['class_id'];
	$cur_question_id = $_SESSION['question_ids'];

?>

<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!--Font Awesome-->
	<script src="https://kit.fontawesome.com/f2904e4571.js" crossorigin="anonymous"></script>
	
	<!--Google Fonts-->
	<link href="https://fonts.googleapis.com/css?family=Candal|Lora&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,400,500,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">
    
	<!-- Material Kit CSS -->
	<link rel="stylesheet" href="../css/HeaderSheet.css">
	<link rel="stylesheet" href="../css/TakeQuiz_style.css">

    <!--bootstrap-->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<title>Score Quiz</title>
	<style>
		#results {
   		border-collapse: collapse;
  		width: 100%;
	}

#results td, #results caption {
  border: 1px solid #ddd;
  padding: 8px;
}

#results tr:nth-child(even){background-color: #f2f2f2;}

#results tr:hover {background-color: #ddd;}

#results caption {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #ffa31a;
  color: white;
}
</style>
</head>
<body>
	<!-- Top Navigation  -->
	<header>
	<div class="logo">
		<h1 class="log-text">MarQuiz</h1>
		<h4>
		<a class= "class_name" href="#0">
		<i class="fas fa-grip-vertical" style="color:#E6E6FA"></i>&nbsp <?php echo $_SESSION['classname']?></a>
		</h4>
	</div>
	

	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav"> 
		<li>
			<a href="./StudentClass.php"><i class="fa fa-home" style="font-size: 1.5em;"></i></a>
		</li>
		<li><a href="#">
			<i class="fa fa-user"style="height:18px;font-size: .9em;"></></></i>&nbsp <?php echo $_SESSION['name']; ?><i class="fa fa-chevron-down" style="font-size: .7em;"></i></a>
			<ul style="	z-index: 100; ">
		       <li><a href="../MyProfile.php">My profile</a></li>
		       <li><a href="../php/logout.php">Logout</a></li>
			</ul>
		</li>
	</ul>
    </header> 

<body>
<div id="container">
	<?php
		// compare student's answer to correct answer
		$total_questions = 0;
		$total_correct = 0;
		if (isset($_POST['submit'])) {
		foreach($_POST['quizcheck'] as $option_num => $student_ans){
			$ans_query = "SELECT quiz_id, true_ans FROM questions Where quiz_id = $quiz_id";
			$ans_run = $conn->query($ans_query);
			$ans_row = mysqli_fetch_array($ans_run);
				$true_ans = $ans_row['true_ans'];
				if ($true_ans == $student_ans){
					$total_correct++;
				}
				//echo("<script>alert('Checking row $total_questions: student answer = ".$student_ans." and correct ans = $true_ans')</script>");
				$total_questions++;
			}
		}
		$score = $total_correct / $total_questions;
		$score = $score * 100;
		// update score table
	
		// check to see if the student already has a row in scores
		$score_exists_query = "select 'x' from scores where student_id = '$user_id' and quiz_id = '$quiz_id'";
		$score_exists = $conn->query($score_exists_query)->num_rows;
	
		// If there is an existing row, we need to update that row with the current score and attempt count. Otherwise we insert a row 
	if ($score_exists > 0) {
		
		// Get attempt count and best score
		$score_query = "select attempt_count, best_score, best_attempt from scores where student_id = '$user_id' and quiz_id = '$quiz_id'";
		$score_run = $conn->query($score_query);
		$score_result = mysqli_fetch_assoc($score_run);
		$attempt_count = $score_result['attempt_count'];
		$best_score = $score_result['best_score'];
		$best_attempt = $score_result['best_attempt'];
		
		// Update attempt count
		$attempt_count++;
		
		// If the current score is better than the previous best score, update best score and best attempt
		if ($score >= $best_score) {
			$best_score = $score;
			$best_attempt = $attempt_count;
		}
		
		// Insert updated information
		$update = "update scores set attempt_count = '$attempt_count', best_score = '$best_score', best_attempt = '$best_attempt' where student_id = '$user_id' and quiz_id = '$quiz_id'";
		$update_run = $conn->query($update);
		if ($conn->query($update) === true){
			//echo("<script>alert('Your scores have been updated. Score: $total_correct out of $total_questions')</script>");
		} else {
			 echo "Error: " . $update . "<br>" . $conn->error;
		}
		
		
	} else {
		// if no row exists, we need to insert a row into the table
		$insert = "INSERT INTO `scores` (`student_id`, `class_id`, `quiz_id`, `attempt_count`, `best_score`, `best_attempt`, `first_attempt_score`) 
		VALUES ('$user_id', '$class_id', '$quiz_id', '1', '$score', '1', '$score')";
		if ($conn->query($insert) === true){
			//echo("<script>alert('Your scores have been updated. Score: $total_correct out of $total_questions')</script>");
		} else {
			 echo "Error: " . $insert . "<br>" . $conn->error;
		}
			
	}
	
	?>
	<table id="results">
    	<tr>
		<caption><h1>Results</h1> </caption>
		</tr>
		<tr>		      	
			<td>Questions Attempts</td>
        	<td>
            <?php
			echo " $total_questions";
			?>
			</td>
		</tr>
		<tr>		
			<td>Correct Answers</td>
        	<td>
            <?php
			echo " $total_correct";
			?>
			</td>
        </tr>
		<tr>		
			<td>Score</td>
        	<td>
            <?php
			echo " $score";
			?>
			</td>
        </tr>
		<tr>			
			<td>Quiz Best Sore </td>
        	<td>
            <?php
			echo " $best_score";
			?>
			</td>
        </tr>
	</table>
</div>
</body>
</html>
<?php
// clear quiz arrays
unset($_SESSION['question_ids']);
unset($_SESSION['student_answer']);
?>