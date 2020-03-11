<?php
	session_start();
	include('../php/connect.php');
	include('../php/session.php');
	include('../php/GenerateQuiz.php');
	
	// Get quiz id from URI
	$URI = $_SERVER['REQUEST_URI'];
	//$quiz_id = substr($URI, 36);
	$quiz_id = $_GET['id'];
	$_SESSION['quiz_id'] = $quiz_id;
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

	<title>Take Quiz</title>
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
		<li><a href="#">
			<i class="fa fa-user"style="height:18px;font-size: .9em;"></></></i>&nbsp <?php echo $_SESSION['name']; ?><i class="fa fa-chevron-down" style="font-size: .7em;"></i></a>
			<ul style="	z-index: 100; ">
		       <li><a href="../MyProfile.php">My profile</a></li>
		       <li><a href="../php/logout.php">Logout</a></li>
			</ul>
		</li>
	</ul>
    </header> 
	<div id="container">
                <h1> Quiz is Starting </h1>
			<!--Countdown Timer Code-->
				<?php
					$class_id = $_SESSION['class_id'];
					$duration="";
					$res= "SELECT distinct a.quiz_id, a.class_id, a.time_limit FROM quizzes a WHERE a.class_id = '$class_id'"; 
					$res_run = $conn->query($res);
					while($row1= mysqli_fetch_array($res_run)){
					$duration = $row1['time_limit'];
					$row_quiz_id = $row1['quiz_id'];
						}
					$_SESSION['time_limit'] = $duration;
					$_SESSION['start_time'] = date("Y-m-d H:i:s");
					$end_time = date('Y-m-d H:i:s', strtotime('+'.$_SESSION['time_limit'].'minutes', strtotime($_SESSION['start_time'])));
					$_SESSION['end_time'] = $end_time;
				?>
				<b><h2 id="response"></h2></b>
				<script type="text/javascript">
					setInterval(function()
					{
						var xmlhttp=new XMLHttpRequest();
						xmlhttp.open("GET","../php/QuizTime.php",false);
						xmlhttp.send(null);
						document.getElementById("response").innerHTML=xmlhttp.responseText;
					},1000);
				</script>
			<!--End of Countdown Timer Code-->
				<hr style="border-top: dotted 1px;" /><br>
			<!-- Display student quiz questions -->
		<section id="results">
			<form action="../php/ScoreQuiz.php" method="POST">
				<?php 
					/* $quiz_id= $_SESSION['quiz_id'];
					$class_id = $_SESSION['class_id'];
					$query= "SELECT distinct b.question_id, b.quiz_id, b.question, b.ans_a, b.ans_b, b.ans_c, b.ans_d, b.true_ans, c.class_id FROM  questions b, quizzes c WHERE c.class_id = '$class_id'"; 
					$query_run = $conn->query($query);
					$count = 0;
					while($rows= mysqli_fetch_array($query_run))
					{
						$count++;
						$question = $rows['question'];
						$question_id = $rows['question_id'];
						$ans_a = $rows['ans_a'];
						$ans_b = $rows['ans_b'];
						$ans_c = $rows['ans_c'];
						$ans_d = $rows['ans_d'];
						$true_ans = $rows['true_ans'];	 */	
						
					// use GenerateQuiz function to populate questions
					GenerateQuiz($quiz_id);
					
					$count = 1;
					foreach($_SESSION['question_ids'] as $index=>$cur_question_id){
						
						$question_query = "SELECT distinct question, question_id, ans_a, ans_b, ans_c, ans_d, true_ans FROM  questions WHERE question_id = '$cur_question_id'"; 
						$question_run = $conn->query($question_query);
						$question_row = mysqli_fetch_array($question_run);
						$question = $rows['question'];
						$question_id = $rows['question_id'];
						$ans_a = $rows['ans_a'];
						$ans_b = $rows['ans_b'];
						$ans_c = $rows['ans_c'];
						$ans_d = $rows['ans_d'];
						$true_ans = $rows['true_ans'];	
						
				?>
					<ol>
						<li>
							<h3><?php echo $count; ?>)&nbsp<?php echo $question; ?></h3>
							<div>
								<input type="radio" name="ans1" id="ans" value="<?php echo $ans_a;?>" />
								<label for="ans"><?php echo $ans_a; ?></label>
							</div>
							<div>
								<input type="radio" name="ans2" id="ans" value="<?php echo $ans_b;?>" />
								<label for="ans"><?php echo $ans_b;?></label>
							</div>
							<div>
								<input type="radio" name="ans3" id="ans" value="<?php echo $ans_c;?>" />
								<label for="ans"><?php echo $ans_c;?></label>
							</div>
							<div>
								<input type="radio" name="ans4" id="ans" value="<?php echo $ans_d;?>" />
								<label for="ans"><?php echo $ans_d;?></label>
							</div>
						</li>
					</ol>
				<?php
					}
				?>
				<br>
					<input type="submit" value="Submit Answers">
			</form>				
		</section>

    </div>        
	<!-- Footer: Used for any page 
	<div id="footer">
			<p> MarQuiz </p>
	</div>-->
</body>
</html>