<?php
	session_start();
	include('php/session.php');
	include('php/connect.php');

	// Get class id from URI
	$URI = $_SERVER['REQUEST_URI'];
	$quiz_id = substr($URI, 25);
	$result = $conn->query("select * from quizzes where quiz_id = '$quiz_id'");
	$row = $result-> fetch_assoc();
	
	//set session variables
	if ($quiz_id != ""){
		$_SESSION['quiz_id'] = $quiz_id;
		$_SESSION['quiz_name'] = $row['quiz_name'];
		$_SESSION['quiz_description'] = $row['quiz_description'];
		$_SESSION['time_limit'] = $row['time_limit'];
		$_SESSION['num_questions'] = $row['num_questions'];
		$_SESSION['num_answer'] = $row['num_answer'];
		$_SESSION['max_attempt'] = $row['max_attempt'];
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
	
	<!-- Material Kit CSS -->
	<link rel="stylesheet" href="css/HeaderSheet.css">
    <link rel="stylesheet" href="css/Side_Main_sheet.css">
    <!--bootstrap-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/ClassInfo.css">
    

	<!-- Insert javascript Modal link-->
	<script src="js/Modal_popup.js"></script>

	<title>Teacher's Class</title>
</head>
<body>
	<!-- Top Navigation  -->
	<header>
	<div class="logo">
		<h1 class="log-text">MarQuiz</h1>
		<h4>
		<a class= "class_name" href="#0">
		<i class="fas fa-grip-vertical" style="color:#E6E6FA"></i>&nbsp <?php echo $_SESSION['classname']." > ".$_SESSION['quiz_name']?></a>
		</h4>
	</div>
	

	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav"> 
		<li>
			<a href="TeacherHome.php"><i class="fa fa-home" style="font-size: 1.5em;"></i></a>
		</li>
		<!--
		<li><a href="#0">
			<i class="fa fa-plus " style="font-size: 1.5em;"></i></a>
			<ul style="left: 0px;">
				<li><a href="#" onclick="ClickCreate()">Create Quiz</a></li>
			</ul> 
		</li>
		-->
		<li><a href="#">
			<i class="fa fa-user"style="height:18px;font-size: .9em;"></></></i>&nbsp <?php echo $_SESSION['name']; ?><i class="fa fa-chevron-down" style="font-size: .7em;"></i></a>
			<ul>
		       <li><a href="MyProfile.php">My profile</a></li>
		       <li><a href="php/logout.php">Logout</a></li>
			</ul>
		</li>
	</ul>
		
	</header>
	<!-- Sidebar here -->
		<!-- Sidebar here -->
 <div class="wrapper">
        <div class="sidebar">
		<ul>
			<li  class="active"><a href="TeacherQuiz.php"><i class="fas fa-info-circle"></i>Quiz Info</a></li>
			<li><a href="QuestionList.php"><i class="fas fa-question-circle"></i>Questions</a></li>
			<li><a href="#"><i class="fas fa-list"></i>Scores</a></li>
			<li style="position:absolute; bottom: 70;"><a href="TeacherClass.php"><i class="fas fa-undo"></i></i>Back to <?php echo $_SESSION['classname']?> </a></li> 
        </ul>
       </div>
		<!--Main content here -->
        <div class="main-section">
         
        </div>
</div>
<!-- Footer: Used for any page 
	<div id="footer">
			<p> MarQuiz </p>
	</div>-->
</body>
</html>
