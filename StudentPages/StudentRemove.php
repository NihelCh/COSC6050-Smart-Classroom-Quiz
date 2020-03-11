<?php
	session_start();
	include('../php/session.php');
	include('../php/connect.php');
	
	// Get quiz id from URI
	$quiz_id = $_GET['id'];
	$_SESSION['quiz_id'] = $quiz_id;
	$user_id = $_SESSION['username'];
	$class_id = $_SESSION['class_id'];

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
    <script src="../js/Modal_popup.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</script>
	
    <title>Grades</title>
</head>
<body>
	<!-- Top Navigation  -->
	<header>
	<div class="logo">
		<h1 class="log-text">MarQuiz</h1>
		<h4>
		<a class= "class_name" href="#0">
		<i class="fas fa-grip-vertical" style="color:#E6E6FA"></i>&nbsp <?php echo $_SESSION['classname'];?></a>
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
			<li><a href="./StudentClass.php"><i class="fas fa-question-circle"></i>Quizzes</a></li>
			<li><a href="./StudentGrade.php"><i class="fas fa-bar-chart"></i>Grades</a></li>
			<li class="active"><a href="./StudentRemove.php"><i class="fas fa-hand-peace-o"></i>Unenroll</a></li>
        </ul>
       </div>
	<!--Main content here -->
	<div class="table-wrapper">
        <table class="table table-striped table-hover">
			<thead>
				<tr>
				<th style="width: 450px;">Actions</th>
				</tr>
			</thead>
		<tbody>
		<td><button type="button" class="btn_red" name="StudentRemove" onclick="window.location.href = '../php/StudentUnenroll.php?id=<?php echo $user_id ?>'"> Unenroll From This Class </button></td>
		</button></td>
		</tbody>
		</table>
	</div>
<!-- Footer: Used for any page 
	<div id="footer">
			<p> MarQuiz </p>
	</div>-->
</body>
</html>