<?php
	session_start();
	include('../php/connect.php');
	include('../php/session.php');


	// Get class id from URI
	$URI = $_SERVER['REQUEST_URI'];
	$class_id = substr($URI, 39);
	$result = $conn->query("select * from class where class_id = '$class_id'");
	$row = $result-> fetch_assoc();
	$user_id = $_SESSION['username'];
	
	//set session variables
	if ($class_id != ""){
		$_SESSION['class_id'] = $class_id;
		$_SESSION['class_code'] = $row['class_code'];
		$_SESSION['classname'] = $row['classname'];
		$_SESSION['subject'] = $row['subject'];
	}
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
    <link rel="stylesheet" href="../css/Side_Main_sheet.css">
    <link rel="stylesheet" href="../css/Questions_style.css">

    <!--bootstrap-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   
	<!-- Insert javascript Modal link-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</script>

	<title>Student's Class</title>

	<!-- Script contains an alert message when clicking on Take Quiz Button-->
	<script>
 		function showAlert() {
    	var myText = "Be ready! The quiz will start now. If the time clock runs out, your quiz will be automatically submitted and only the answered questions will count toward your grade!";
		alert (myText);
 		 }
	</script>

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
			<a href="./StudentHome.php"><i class="fa fa-home" style="font-size: 1.5em;"></i></a>
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
	<!-- Sidebar here -->
		<!-- Sidebar here -->
 	<div class="wrapper">
        <div class="sidebar">
		<ul>
          <li class="active"><a href="./StudentClass.php"><i class="fas fa-question-circle"></i>Quizzes</a></li>
		  <li><a href="./StudentGrade.php"><i class="fas fa-bar-chart"></i>Grades</a></li>
		  <li><a href="./StudentRemove.php"><i class="fas fa-hand-peace-o"></i>Unenroll</a></li>
        </ul>
       </div>
		<!--Main content here -->
		<div class="container">
            <div class="table-wrapper">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="width:322px;">Quiz Name</th>
							<th style="width:122px;">Duration (min)</th>
							<th style="width:122px;">Questions</th>
							<th style="width:122px;">Attempts Remaining</th>
							<th style="width:322px;">Status</th>
							<th style="width:322px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php 
					
					// Populate quizzes that the student hasn't taken yet
					$classcode= $_SESSION['class_code'];
					$class_id= $_SESSION['class_id'];
					// $query= "SELECT a.class_id, a.quiz_id, a.quiz_name, a.time_limit, a.num_questions, a.max_attempt  FROM quizzes a WHERE a.class_id = '$class_id'"; 
					$query = "select a.quiz_id, a.quiz_name, a.quiz_description, a.time_limit, a.num_questions, a.max_attempt
							from quizzes a, enrollment b
							where a.class_id = b.class_id
							and b.student_id = '$user_id'
							and b.class_id = '$class_id'
							and not exists 
								(select 'x'
								 from scores c
								 where c.student_id = b.student_id
								 and c.quiz_id = a.quiz_id)
							and a.active = 1";

					$query_run = $conn->query($query);
					$quiz_count = 0;
					$count = 0;
					while($row1= mysqli_fetch_array($query_run)){
						$count++;
						$quiz_count++;
						$quiz_name = $row1['quiz_name'];
						$quiz_time = $row1['time_limit'];
						$quiz_ques = $row1['num_questions'];
						$quiz_atmpt = $row1['max_attempt'];
						$quiz_id = $row1['quiz_id'];
					
					?>
                        <tr>
                            <td scope="row"><?php echo $count; ?></td>
                            <td><?php echo $quiz_name; ?></td>
							<td><?php echo $quiz_time; ?></td>
							<td><?php echo $quiz_ques; ?></td>
							<td><?php echo $quiz_atmpt; ?></td>
							<td>Active</td>
							<td><a href="TakeQuiz.php?id=<?php echo $quiz_id;?>" class="button" onclick="showAlert()">Take Quiz</a></td>
							<!--<td><a href="../php/GenerateQuiz.php?id=<?php echo $quiz_id;?>" class="button">Take Quiz</a></td>-->
                        </tr>
						<?php
					}
					
					// Populate quizzes that the student has taken, for which they still have attempts left over
					$classcode= $_SESSION['class_code'];
					$class_id= $_SESSION['class_id'];
					//$query= "SELECT a.class_id, a.quiz_id, a.quiz_name, a.time_limit, a.num_questions, a.max_attempt  FROM quizzes a WHERE a.class_id = '$class_id'"; 
					$query = "select a.quiz_id, a.quiz_name, a.quiz_description, a.time_limit, a.num_questions, a.max_attempt, c.attempt_count
								from quizzes a, enrollment b, scores c
								where a.class_id = b.class_id
								and b.student_id = '$user_id'
								and b.class_id = '$class_id'
								and a.quiz_id = c.quiz_id
								and b.student_id = c.student_id
								and c.attempt_count < a.max_attempt
								and a.active = 1";

					$query_run = $conn->query($query);
					$count = 0;
					while($row1= mysqli_fetch_array($query_run)){
						$count++;
						$quiz_count++;
						$quiz_name = $row1['quiz_name'];
						$quiz_time = $row1['time_limit'];
						$quiz_ques = $row1['num_questions'];
						$quiz_id = $row1['quiz_id'];
						$remaining_attempts = $row1['max_attempt'] - $row1['attempt_count'];
					
					?>
                        <tr>
                            <td scope="row"><?php echo $count; ?></td>
                            <td><?php echo $quiz_name; ?></td>
							<td><?php echo $quiz_time; ?></td>
							<td><?php echo $quiz_ques; ?></td>
							<td><?php echo $remaining_attempts; ?></td>
							<td>Active</td>
							<td><a href="TakeQuiz.php?id=<?php echo $quiz_id;?>" class="button" onclick="showAlert()">Take Quiz</a></td>
							<!--<td><a href="../php/GenerateQuiz.php?id=<?php echo $quiz_id;?>" class="button">Take Quiz</a></td>-->
                        </tr>
						<?php
					}
					?>
                    </tbody>
                </table>
					<?php 
					if ($quiz_count == 0) {
					?>
					<br>
					<br>
					<p style="margin-left: 10%; "> You don't have any quizzes to take for this class right now!  Check the 'Grades' tab to see how you've done on previous quizzes. </p>
					<br>
					<br>
					<?php
					}
					?>
            </div>
		</div>
	</div>
	<!-- Footer: Used for any page 
	<div id="footer">
			<p> MarQuiz </p>
	</div>-->
</body>
</html>
