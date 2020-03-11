<?php
	session_start();
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
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,200,400,500,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">
    
	
    <!--bootstrap-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/ClassInfo.css">
    
	<!-- Material Kit CSS -->
	<link rel="stylesheet" href="../css/HeaderSheet.css">
    <link rel="stylesheet" href="../css/Side_Main_sheet.css">
	<link rel="stylesheet" href="../css/Questions_style.css">
	
	<!-- Insert javascript Modal link-->
	<script src="../js/Modal_popup.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
			<ul style="left: 0px; z-index: 100;">
				<li><a href="#" onclick="ClickCreate()">Create Quiz</a></li>
			</ul>
		</li>
		
		<li><a href="#">
			<i class="fa fa-user"style="height:18px;font-size: .9em;"></></></i>&nbsp <?php echo $_SESSION['name']; ?><i class="fa fa-chevron-down" style="font-size: .7em;"></i></a>
			<ul style="	z-index: 100; ">
		       <li><a href="../MyProfile.php">My profile</a></li>
		       <li><a href="../php/logout.php">Logout</a></li>
			</ul>
		</li>
	</ul>
	<!-- The Modal for Create Quiz -->
	<div id="addQuizModal" class="modal" style="">
		<form action="../php/CreateQuiz.php" class="form-container" method="POST">
			<br>
			<h2>Create Quiz</h2>
			<p>Enter the title of the quiz here.</p>
			<input id="quizname" name="quizname" placeholder="Quiz Title" type="text" required>
			<p>Give a quick description for the quiz (less than 100 characters).</p>
			<input id="quizdescription" name="quizdescription" placeholder="Quiz Description" type="text" maxlength="100" required>
			<p>Enter the time limit for the quiz.</p>
			<input id="timelimit" name="timelimit" placeholder="Time Limit (minutes)" type="text" required>
			<p>Enter the number of questions that should be included for this quiz. </p>
			<input id="numquestions" name="numquestions" placeholder="Number of Questions" type="text" required>
			<p>Enter the maximum number of attempts students should have. </p>
			<input id="numattempts" name="numattempts" placeholder="Max Number of Attempts" type="text" required>
			<button type="submit" name="btn create" class="btn"  id="submit">Submit</button>
			<button type="button" name="btn cancel" class="btn cancel" onclick="closeForm4()">Cancel</button>
			<br><br>
		</form>
	</div>
	<!--End of the Modal-->	
	
	</header>
	<!-- Sidebar here -->
		<!-- Sidebar here -->
 <div class="wrapper">
        <div class="sidebar">
		<ul>
         		<li><a href="TeacherClass.php"><i class="fas fa-info-circle"></i>Class info</a></li>
				<li><a href="./ClassList.php"><i class="fas fa-users"></i>Class List</a></li>
          		<li class="active"><a href="QuizList.php"><i class="fas fa-list"></i>Quizzes</a></li>
				<li><a href="./Questions.php"><i class="fas fa-question-circle"></i>Questions</a></li>
				<li><a href="./TeacherGrades.php"><i class="fas fa-bar-chart"></i>Grades</a></li>						
			   </ul>
		</div>
		<!--Main content here -->
		<div class="container">
            <div class="table-wrapper">
                <table class="table table-striped table-hover">
                    <thead>
					<tr>
					  <th>#</th>
						<th style="width: 225px;">Quiz Name</th>
						<th style="width: 500px;">Description</th>
						<th style="width: 300px;">Time Limit (min)</th>
						<th style="width: 300px;">Num. of Questions</th>
						<th style="width: 300px;">Num. of Attempts</th>
						<th style="width: 400px;">Status</th>
						<th style="width: 400px;">Actions</th>
					</tr>
			  </thead>
			  <tbody>
				  <?php 
					$class_id = $_SESSION['class_id'];
					$query = "SELECT * FROM quizzes q WHERE q.class_id = '$class_id'"; 
					$query_run = $conn->query($query);
					$count = 0;
					while($row= mysqli_fetch_array($query_run)){
						$count++;
						$q_id = $row['quiz_id'];
						$q_name = $row['quiz_name'];
						$q_desp = $row['quiz_description'];
						$q_time = $row['time_limit'];
						$q_quest = $row['num_questions'];
						$q_takes = $row['max_attempt'];
						$q_active=$row['active'];
					?>
						<tr>
						  <th scope="row"><?php echo $count; ?></th>
						  <td><?php echo $q_name; ?></td>
						  <td><?php echo $q_desp; ?></td>
						  <td><?php echo $q_time; ?></td>
						  <td><?php echo $q_quest; ?></td>
						  <td><?php echo $q_takes; ?></td>
						  <?php if ($q_active == 0) { ?>
							<td><button type="button" class="btn_green" name="Activate" onclick="window.location.href = '../php/ActivateQuiz.php?id=<?php echo $q_id ?>'"> Activate Quiz </button></td>
						  <?php 
						  } else if ($q_active == 2) { ?>
							  <td><button type="button" class="btn_red name="Activate" onclick="window.location.href = '../php/ActivateQuiz.php?id=<?php echo $q_id ?>'"> Reactivate Quiz </button></td>
						  <?php } else { ?>
							<td><button type="button" class="btn_green" name="Close" onclick="window.location.href = '../php/CloseQuiz.php?id=<?php echo $q_id ?>'"> Close Quiz </button></td>
						  <?php } ?>
						  <td>
							<a href="#editQuizModal<?php echo $q_id; ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<a href="#copyQuizModal<?php echo $q_id; ?>" class="copy" data-toggle="modal" data-id="<?php echo $row_question_id; ?>"><i class="material-icons" data-toggle="tooltip" title="Copy">file_copy</i></a>
						  </td>
						</tr>
						
					<?php
					}
					?>
			  </tbody>
			  
				</table>
				<br><br><br><br>
			</div>
        </div> 
</div>
	
	<!-- Edit Quiz Modal -->
	<?php 
		$query = "SELECT * FROM quizzes q WHERE q.class_id = '$class_id'"; 
		$query_run = $conn->query($query);
		$user_id = $_SESSION['username'];
		while($row= mysqli_fetch_array($query_run)){
			$q_id = $row['quiz_id'];
			$q_name = $row['quiz_name'];
			$q_descr = $row['quiz_description'];
			$q_time = $row['time_limit'];
			$q_quest = $row['num_questions'];
			$q_takes = $row['max_attempt'];
			$q_active=$row['active'];
		?>
			<!-- The Modal for Edit Quiz -->
			<div id="editQuizModal<?php echo $q_id; ?>" class="modal" style="position: fixed; left: 45%;width: auto;height: 500px;max-height: 500px; overflow: auto;transform: translate(0%, -25%);">
				<form action="../php/EditQuiz.php" class="form-container" method="POST" style=" height: 100%;overflow: auto;margin-bottom: 10px;">
					<br>
					<h2>Edit Quiz</h2>
					<p>Enter the title of the quiz here.</p>
					<input id="quizname" name="quizname" placeholder="<?php echo $q_name; ?>" type="text">
					<p>Give a quick description for the quiz (less than 100 characters).</p>
					<input id="quizdescription" name="quizdescription" placeholder="<?php echo $q_descr; ?>" type="text" maxlength="100">
					<p>Enter the time limit for the quiz.</p>
					<input id="timelimit" name="timelimit" placeholder="<?php echo $q_time; ?>" type="text">
					<p>Enter the number of questions that should be included for this quiz. </p>
					<input id="numquestions" name="numquestions" placeholder="<?php echo $q_quest; ?>" type="text">
					<p>Enter the maximum number of attempts students should have. </p>
					<input id="numattempts" name="numattempts" placeholder="<?php echo $q_takes; ?>" type="text">
					<input type="hidden" name="quiz_id" value="<?php echo $q_id; ?>" ></input>
					<button type="submit" name="btn create" class="btn"  id="submit">Submit</button>
					<button type="button" name="btn cancel" class="btn cancel" data-dismiss="modal">Cancel</button>
					<br><br><br>
				</form>
				<br>
			</div>
			<!--End of the Modal-->	
			
			<!-- The Modal for Edit Quiz -->
			<div id="copyQuizModal<?php echo $q_id; ?>" class="modal" style="position: fixed; left: 45%;width: auto;height: 500px;max-height: 500px; overflow: auto;transform: translate(0%, -25%);">
				<form action="../php/CopyQuiz.php" class="form-container" method="POST" style=" height: 100%;overflow: auto;margin-bottom: 10px;">
					<br>
					<h2>Copy Quiz</h2>
					<p> Choose a class to copy this quiz to </p>
					<select id="class_id" name="class_id" required>
						<option value="">-- Class --</option>
						<?php 
							$class_query = "select class_id, classname from class where instructor_id = '$user_id' and class_id <> '$class_id'";
							$class_run = $conn->query($class_query);
							while($class_row = mysqli_fetch_array($class_run))
							{
								$row_class_id = $class_row['class_id'];
								$row_class_name = $class_row['classname'];
						?>
								<option name= <?php echo $row_class_id; ?> value="<?php echo $row_class_id; ?>" ><?php echo $row_class_name; ?> </option>
						<?php } ?>
					</select>
					<p>Enter the title of the quiz here.</p>
					<input id="quizname" name="quizname" placeholder="<?php echo $q_name; ?>" type="text">
					<p>Give a quick description for the quiz (less than 100 characters).</p>
					<input id="quizdescription" name="quizdescription" placeholder="<?php echo $q_descr; ?>" type="text" maxlength="100">
					<p>Enter the time limit for the quiz.</p>
					<input id="timelimit" name="timelimit" placeholder="<?php echo $q_time; ?>" type="text">
					<p>Enter the number of questions that should be included for this quiz. </p>
					<input id="numquestions" name="numquestions" placeholder="<?php echo $q_quest; ?>" type="text">
					<p>Enter the maximum number of attempts students should have. </p>
					<input id="numattempts" name="numattempts" placeholder="<?php echo $q_takes; ?>" type="text">
					<input type="hidden" name="quiz_id" value="<?php echo $q_id; ?>" ></input>
					<button type="submit" name="btn create" class="btn"  id="submit">Submit</button>
					<button type="button" name="btn cancel" class="btn cancel" data-dismiss="modal">Cancel</button>
					<br><br><br>
				</form>
				<br>
			</div>
			<!--End of the Modal-->	
		<?php } ?>
					
</body>
</html>