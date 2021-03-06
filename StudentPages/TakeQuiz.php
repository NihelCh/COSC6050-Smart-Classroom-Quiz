<?php
	session_start();
	include('../php/connect.php');
	include('../php/session.php');
	include('../php/GenerateQuiz.php');
	
	// Get quiz id from URI
	$URI = $_SERVER['REQUEST_URI'];
	$quiz_id = substr($URI, 36);
	$quiz_id = $_GET['id'];
	$_SESSION['quiz_id'] = $quiz_id;
	
	$quiz_id= $_SESSION['quiz_id'];
	$class_id= $_SESSION['class_id'];
	$_SESSION['quiz_started'] = true;
	
	/* Get quiz duration */
	$duration="";
	$res= "SELECT a.time_limit, a.quiz_id FROM quizzes a WHERE quiz_id='$quiz_id'";
	$res_run = $conn->query($res);
	while($row1= mysqli_fetch_array($res_run)){
		$duration = $row1['time_limit'];
	}
	
	$_SESSION['time_limit'] = $duration;
	$timeout = $duration * 60000;
	$_SESSION['start_time'] = date("Y-m-d H:i:s");
	$end_time = date('Y-m-d H:i:s', strtotime('+'.$_SESSION['time_limit'].'minutes', strtotime($_SESSION['start_time'])));
	$_SESSION['end_time'] = $end_time;
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

	<!-- Timeout script -->
	<script >
        window.onload = function(){
			var timeout = <?php echo $timeout; ?>;
		   setInterval("document.quiz.submit.click()", timeout);
		};
    </script>
	
	<!-- Back button should score the quiz -->
	<script type="text/javascript">
		history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
		window.addEventListener('popstate', function(event) {
			var r = confirm("Your quiz will be scored as is! Are you sure you want to leave the page?");
			if (r == true) {
				document.quiz.submit.click();
			} else {
				history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
			}
		});
	</script>

	<title>Take Quiz</title>
</head>
<body >
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
				
				<!-- Countdown timer code-->
				<b><h2 id="response"></h2></b>
				<script type="text/javascript">
					var x = setInterval(fun1,1000);
 					function fun1(){
 					var xmlhttp = new XMLHttpRequest();
  					xmlhttp.open("GET","../php/QuizTime.php",false);
 					xmlhttp.send(null);
  					var str = document.getElementById("response").innerHTML=xmlhttp.responseText;
					  if(xmlhttp.responseText == "Time Out!"){
						clearInterval(x);
        				document.quiz.submit();
						submitForm();
					  }
					  
					}
 					function submitForm(){
  						window.location.href='../php/ScoreQuiz.php';
 					}
  				</script>		
			<!--End of Countdown Timer Code-->

				<hr style="border-top: dotted 1px;" /><br>
			<!-- Display student quiz questions -->
		<section id="results">
			<form action="../php/ScoreQuiz.php" method="POST" name="quiz">
				<?php 
					// use GenerateQuiz function to populate questions
					
					$count = 1;
					foreach($_SESSION['question_ids'] as $index=>$cur_question_id){
						
						$question_query = "SELECT distinct question, question_id, ans_a, ans_b, ans_c, ans_d, true_ans FROM  questions WHERE question_id = '$cur_question_id'"; 
						$question_run = $conn->query($question_query);
						while($question_row = mysqli_fetch_array($question_run)){
						$question = $question_row['question'];
						$question_id = $question_row['question_id'];
						$ans_a = $question_row['ans_a'];
						$ans_b = $question_row['ans_b'];
						$ans_c = $question_row['ans_c'];
						$ans_d = $question_row['ans_d'];
						$true_ans = $question_row['true_ans'];	
						
				?>
					<ol>
						<li>
						<h3><?php echo $count; ?>) &nbsp<?php echo $question; ?></h3>
							<div>
								<input type="radio" name="quizcheck<?php echo $index; ?>" value="A" />
								A)&nbsp;<?php echo $ans_a; ?>
							</div>
							<div>
								<input type="radio" name="quizcheck<?php echo $index; ?>" value="B" />
								B)&nbsp;<?php echo $ans_b;?>
							</div>
							<div>
								<input type="radio" name="quizcheck<?php echo $index; ?>" value="C" />
								C)&nbsp;<?php echo $ans_c;?>
							</div>
							<div>
								<input type="radio" name="quizcheck<?php echo $index; ?>" value="D" />
								D)&nbsp;<?php echo $ans_d;?>
							</div>
						</li>
					</ol>
				<?php
						$count++;
					 }
					}
				?>
				<br>
					<input type="submit" name="submit" value="Submit Answers">
			</form>				
		</section>

		



    </div>        
	<!-- Footer: Used for any page 
	<div id="footer">
			<p> MarQuiz </p>
	</div>-->
	<script>
		// Warning before leaving the page (back button, or outgoinglink)
		window.onbeforeunload = function() { 
			//return "Are you sure you want to leave this page?"; 
		};
	</script>
</body>
</html>
