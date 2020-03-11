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
	
	<title>Teacher's Homepage</title>
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
				<li><a href="#" onclick="Display()">Create Class</a></li>
			</ul>
		</li>
		<li><a href="#">
			<i class="fa fa-user"style="font-size: .9em;"></></></i>&nbsp Teacher<i class="fa fa-chevron-down" style="font-size: .7em;"></i></a>
			<ul>
		       <li><a href="#">My profile</a></li>
		       <li><a href="#">Settings</a></li>
		       <li><a href="https://pascal.mscsnet.mu.edu/quiz/">Logout</a></li>
			</ul>
		</li>
	</ul>	
	<!-- The Modal -->
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
	<!-- Main -->
<main>
	<div class="row" style="margin: 0px; padding: 0px;"	>
		<?php 
		$servername = "localhost";
		$DBusername = "quizuser";
		$DBpassword = "classquiz";
		$DBname = "quiz";
		// Create connection
		$conn = new mysqli($servername, $DBusername, $DBpassword, $DBname);

		$query= "SELECT * FROM subject_image"; 
		$query_run = $conn->query($query);
		while($row= mysqli_fetch_array($query_run))
		{
			$subject = $row["subject"];
			$img = "images/class_images/" . $row["image"];
		?>
			<div class="col-sm-3">
				<div class="content-img" style="margin-top: 10%;">
				<a href="TeacherClass.html">
					<img src=<?php echo $img?> width= "270px" height="195px"/> 
					<h2 class="content-title"> <?php echo $subject?> </h2>
				</a>
				</div>
			</div>
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