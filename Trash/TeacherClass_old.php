<?php
	session_start();
	include('php/session.php');
	include('php/connect.php');

	// Get class id from URI
	$URI = $_SERVER['REQUEST_URI'];
	$class_id = substr($URI, 26);
	$result = $conn->query("select * from class where class_id = '$class_id'");
	$row = $result-> fetch_assoc();
	
	//set session variables
	$_SESSION['class_id'] = $class_id;
	$_SESSION['class_code'] = $row['class_code'];
	$_SESSION['classname'] = $row['classname'];
	$_SESSION['subject'] = $row['subject'];
?>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!--Font Awesome-->
	<script src="https://kit.fontawesome.com/f2904e4571.js" crossorigin="anonymous"></script>
	
	<!--Google Fonts-->
	<link href="https://fonts.googleapis.com/css?family=Candal|Lora&display=swap" rel="stylesheet">
	
	<!-- Material Kit CSS -->
	<link rel="stylesheet" href="css/HeaderSheet.css">
	<link rel="stylesheet" href="css/Side_Main_sheet.css">

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
		<i class="fas fa-grip-vertical" style="color:#E6E6FA"></i>&nbsp <?php echo $_SESSION['classname']?></a>
		</h4>
	</div>
	

	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav"> 
		<li>
			<a href="TeacherHome.php"><i class="fa fa-home" style="font-size: 1.5em;"></i></a>
		</li>
		<li><a href="#0">
			<i class="fa fa-plus " style="font-size: 1.5em;"></i></a>
			<ul style="left: 0px;">
				<li><a href="/CreateQuiz.html">Create Quiz</a></li>
			</ul>
		</li>
		
		<li><a href="#">
			<i class="fa fa-user"style="font-size: .9em;"></></></i>&nbsp <?php echo $name;?><i class="fa fa-chevron-down" style="font-size: .7em;"></i></a>
			<ul>
		       <li><a href="#">My profile</a></li>
		       <li><a href="#">Settings</a></li>
		       <li><a href="php/logout.php">Logout</a></li>
			</ul>
		</li>
	</ul>
	<!-- The Modal for create class -->
	<div id="myModal" class="modal">
			<form action="php/CreateClass.php" class="form-container" method="POST">
				<h2>Create class</h2>
					<input id="classname" name="classname" placeholder="Class Name" type="text" required>
					<input id="instructorID" name="instructorID" placeholder="Instructor ID" type="text" required>
					<select id="subject" name="subject" required>
						<option name="">--Subject--</option>
      						<option name="Bioinformatics" value="Bioinformatics">Bioinformatics</option>
      						<option name="Biology" value="Biology">Biology</option>
						<option name="Business Administration" value="Business Administration">Business Administration</option>
						<option name="Computing" value="Computing">Computing</option>
						<option name="Mathematics" value="Mathematics">Mathematics</option>
					</select>
					<button type="submit" name="btn create" class="btn"  id="submit">Create</button>
					<button type="button" name="btn cancel" class="btn cancel" onclick="closeForm()">Cancel</button>
			</form>
	</div>
	<!--End of the Modal-->
		
	</header>
	<!-- Sidebar here -->
		<!-- Sidebar here -->
 <div class="wrapper">
        <div class="sidebar">
		<ul>
          <li><a href="#0"><i class="fas fa-info-circle"></i>Class info</a></li>
		  <li><a href="./ClassList.html"><i class="fas fa-users"></i>Class List</a></li>
          <li><a href="./QuizList.html"><i class="fas fa-list"></i>Quizzes</a></li>
		  <li><a href="./Question.html"><i class="fas fa-question-circle"></i>Question Bank</a></li>  
        </ul>
       </div>
		<!--Main content here -->
	  <div class="main_content">  
		<div class="info">
          <div>Here the main content</div>
		</div>
	  </div>
</div>
<!-- Footer: Used for any page 
	<div id="footer">
			<p> MarQuiz </p>
	</div>-->
</body>
</html>
