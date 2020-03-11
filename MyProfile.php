<?php
include('php/session.php');
include('php/connect.php');
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
	<link rel="stylesheet" href="../css/Questions_style.css">
	<link rel="stylesheet" href="css/Profile.css">
    <!--bootstrap-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<title>User Profile</title>
</head>
<body>

	<!-- Top Navigation  -->
<header>
	<div class="logo">
		<h1 class="log-text">MarQuiz</h1>
		<h4>
		<a class= "class_name" href="#0">
		<i class="fas fa-grip-vertical" style="color:#E6E6FA"></i>&nbsp User Profile</a>
		</h4>
	</div>
	
	
	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav"> 
		<li>
			<a href=
				<?php 
					$user_role = $_SESSION['role'];
					If ($user_role === "Student")
					  //header("Location: StudentHome.php");
						echo ("StudentPages/StudentHome.php");
					else if ($user_role === "Teacher")
						// header("Location: TeacherHome.php");
						echo ("TeacherPages/TeacherHome.php");
					else
						echo "#";
				?>
			><i class="fa fa-home" style="font-size: 1.5em;"></i></a>
		</li>
		
		<li><a href="#">
			<i class="fa fa-user"style="height:18px;font-size: .9em;"></></></i>&nbsp <?php echo $_SESSION['name']; ?><i class="fa fa-chevron-down" style="font-size: .7em;"></i></a>
			<ul>
		       <li><a href="MyProfile.php">My profile</a></li>
		       <li><a href="php/logout.php">Logout</a></li>
			</ul>
		</li>
	</ul>
</header>
	<!-- Main -->
	<div class="wrapper">
	   <!-- main content -->
		<form action="php/UpdateInformation.php" method="POST">
			<fieldset class="fieldset" >
				<legend class="legend">Personal information:</legend>
				<img src="images/personal_information.jpg" alt="information" class="marginauto" style="width:775px; height:190px;"> 

				<p> If you would like to update your information, please enter any changes and submit. <p><br>
				<a> First name: </a><br>
				<input id = "firstname" type="text" name="firstname"><br>

				Last name:<br>
				<input id = "lastname" type="text" name="lastname"><br>

				Email Address:<br>
				<input id = "email" type="email" name="email"><br>	
	
				Password - <br> Every password must be at least 6 characters and contain at least 1 number, upper and lowercase letter: <br>
				<input id = "password" type="text" name="password"><br>
				Confirm Password: <br>
				<input id = "confpassword" type="text" name="confpassword"><br><br>
				<input type="submit" value="Submit" name="submit"> <br><br>
				<h4>Deleting your Account</h4>
				<br>					
				<p>This will erase all your information stored in our database. Are you sure you want to delete your account?</p>
				<br>
				<input type="submit" value="Delete" name="delete">	
			</fieldset>
		</form>
	</div>
<main>
</main>
<!-- Footer: Used for any page 
	<div id="footer">
			<p> MarQuiz </p>
	</div>-->
</body>
</html>