<?php
include('../php/session.php');
include('../php/connect.php');
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
	<link rel="stylesheet" href="../css/HeaderSheet.css">
	<link rel="stylesheet" href="../css/Side_Main_sheet.css">

	<!-- Insert javascript Modal link-->
	<script src="../js/Modal_popup.js"></script>
	
	<title>Student's Homepage</title>
	
	
</head>
<body>
	<!-- Top Navigation  -->
	<header>
	<div class="logo">
		<h1 class="log-text">Welcome to MarQuiz!</h1>
	</div>
	<i class="fa fa-bars menu-toggle"></i>
	<ul class="nav"> 
		<li><a href="#">
			<i class="fa fa-plus " style="font-size: 1.5em;"></i></a>
			<ul style="left: 0px;">
				<li><a href="#" onclick="ClickJoin()">Join Class</a></li>
			</ul>
		</li>
		<li><a href="#">
			<i class="fa fa-user"style="height:18px;font-size: .9em;"></></></i>&nbsp <?php echo $name;?><i class="fa fa-chevron-down" style="font-size: .7em;"></i></a>
			<ul>
		       <li><a href="../MyProfile.php">My profile</a></li>
		       <li><a href="../php/logout.php">Logout</a></li>
			</ul>
		</li>
	</ul>
	<!-- The Modal for join class -->
	<div id="myModal2" class="modal">
			<form action="../php/JoinClass.php" class="form-container" method="POST">
				<h2>Join class</h2>
					<p>Ask your teacher for the class code, then enter it here.</p>
					<input id="classcode" name="classcode" placeholder="Class Code" type="text" required>
					<button type="submit" name="btn create" class="btn"  id="submit">Join</button>
					<button type="button" name="btn cancel" class="btn cancel" onclick="closeForm3()">Cancel</button>
			</form>
		</div>
	<!--End of the Modal-->	
	</header>
	<!-- Main -->
	<main>
	<div class="content-box">
		<?php 
		$username = $_SESSION['username'];
		$query= "SELECT users.username, subject_image.image, class.class_id, class.classname, class.class_code, enrollment.student_id, enrollment.class_code FROM users, subject_image, class, enrollment WHERE users.username= enrollment.student_id and class.class_code=enrollment.class_code and class.subject=subject_image.subject and users.username = '$username'"; 
		$query_run = $conn->query($query);
		$class_count = 0;
		while($row= mysqli_fetch_array($query_run))
		{
			$classname = $row["classname"];
			$class_code = $row["class_code"];
			$class_id = $row["class_id"];
			$img = "../images/class_images/" . $row["image"];
			
			$new_quiz = "select 'x'
							from quizzes a, enrollment b
							where a.class_id = b.class_id
							and b.student_id = '$username'
							and b.class_id = '$class_id'
							and not exists 
								(select 'x'
								 from scores c
								 where c.student_id = b.student_id
								 and c.quiz_id = a.quiz_id)
							and a.active = 1";
			$new_quiz_run = $conn->query($new_quiz);
			$new_quiz_result = mysqli_num_rows($new_quiz_run);
			$class_count++;
		?>
			<div class="content-img">
				<a href="./StudentClass.php?id=<?php echo $class_id?>" >
					<img src=<?php echo $img?> width= "270px" height="195px"/> 
					<?php 
					// If the student has open quizzes they have not taken yet, display the 'new quiz' notification
					if ($new_quiz_result > 0) {
					?>
					<span class="notify-badge">New Quiz!</span>
					<?php 
					}
					?>
					<h2 class="content-title"> <?php echo $classname?> </h2>
				</a>
			</div>
		<?php
			}
			// Display a message if there are no classes yet
			if ($class_count == 0) {
			?>
			<br> <br> <br> <br>
			<h2 style="margin-left: 10%; ">Welcome to MarQuiz!  Click the '+' to join your first class! </h2>
			<?php
			}
		?>
	</div>
</main>
<!-- Footer: Used for any page 
	<div id="footer">
			<p> MarQuiz </p>
	</div>-->
</body>
</html>