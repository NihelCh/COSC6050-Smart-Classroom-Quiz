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
			<i class="fa fa-user"style="height:18px;font-size: .9em;"></></></i>&nbsp <?php echo $name;?><i class="fa fa-chevron-down" style="font-size: .7em;"></i></a>
			<ul>
		       <li><a href="../MyProfile.php">My profile</a></li>
		       <li><a href="../php/logout.php">Logout</a></li>
			</ul>
		</li>
	</ul>	
	<!-- The Modal -->
	<div id="myModal" class="modal">
		<form action="../php/CreateClass.php" class="form-container" method="POST">
			<h2>Create class</h2>
				<input id="classname" name="classname" placeholder="Class Name" type="text" required>
				<select id="subject" name="subject" required>
				<option value="">--Subject--</option>
				<?php 
					$query = "select subject from subject_image";
					$query_run = $conn->query($query);
					while($row = mysqli_fetch_array($query_run))
					{
						$subject_name = $row['subject'];
				?>
						<option name= <?php echo $subject_name ?> value="<?php echo $subject_name ?>" ><?php echo $subject_name ?> </option>
				<?php } ?>
				</select>
				<button type="submit" name="btn create" class="btn"  id="submit">Create</button>
				<button type="button" name="btn cancel" class="btn cancel" onclick="closeForm()">Cancel</button>
		</form>
	</div>
	<!--End of the Modal-->
</header>
	<!-- Main -->
<main>
	<div class="content-box">
		<?php 
		$username = $_SESSION['username'];
		$query= "select b.classname, b.class_id, c.image from users a, class b, subject_image c where a.username = b.instructor_id and b.subject = c.subject and a.username = '$username'"; 
		$query_run = $conn->query($query);
		$class_count = 0;
		while($row= mysqli_fetch_array($query_run))
		{
			$classname = $row["classname"];
			$class_id = $row["class_id"];
			$img = "../images/class_images/" . $row["image"];
			$class_count++;
		?>
			<div class="content-img">
				<a href="./TeacherClass.php?id=<?php echo $class_id?>" >
					<img src=<?php echo $img?> width= "270px" height="195px"/> 
					<h2 class="content-title"> <?php echo $classname?> </h2>
				</a>
			</div>
		<?php
			}
			
			// Display a message if there are no classes yet
			if ($class_count == 0) {
			?>
			<br> <br> <br> <br>
			<h2 style="margin-left: 10%; ">Welcome to MarQuiz!  Click the '+' to create your first class! </h2>
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