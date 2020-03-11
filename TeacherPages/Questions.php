<?php
	session_start();
	include('../php/session.php');
	include('../php/connect.php');
	
	// Get quiz id from URI
	$URI = $_SERVER['REQUEST_URI'];
	//$quiz_id = substr($URI, 36);
	$quiz_id = $_GET['id'];
	$_SESSION['quiz_id'] = $quiz_id;

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
	<link href="https://fonts.googleapis.com/css?family=Reenie+Beanie&display=swap" rel="stylesheet">
    
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
	
	<!-- Scripts for passing info to modals -->
	 <script type="text/javascript">
		$( document ).ready(function() {
			 $('.delete').click(function (e) {
				e.preventDefault();
				var link = this;
				var deleteModal = $("#deleteQuestionModal");
				// store the ID inside the modal's form
				deleteModal.find('input[name=q_id]').val(this.dataset.id);
			});
		});
    </script>
	
    <title>Questions</title>
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
			<a href="TeacherHome.php"><i class="fa fa-home" style="font-size: 1.5em;"></i></a>
		</li>
		<li><a href="#0">
			<i class="fa fa-plus " style="font-size: 1.5em;"></i></a>
			<ul style="left: 0px; 	z-index: 100;">
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
			<br> <br>
		</form>
	</div>
	<!--End of the Modal-->	
		
	</header>
	<!-- Sidebar here -->
		<!-- Sidebar here -->
<div class="wrapper">
    <div class="sidebar">
		<ul>
          <li><a href="./TeacherClass.php"><i class="fas fa-info-circle"></i>Class info</a></li>
	      <li><a href="./ClassList.php"><i class="fas fa-users"></i>Class List</a></li>
          <li><a href="./QuizList.php"><i class="fas fa-list"></i>Quizzes</a></li>
	      <li class="active"><a href="./Questions.php"><i class="fas fa-question-circle"></i>Questions</a></li>
		  <li><a href="./TeacherGrades.php"><i class="fas fa-bar-chart"></i>Grades</a></li>	
        </ul>
	</div>	
	<!--Main content here -->
    		<div class="container" style="overflow: auto;">
            	<div class="table-wrapper" >
                	<div class="table-title">
                    	<div class="row">
                            <div class="col-sm-6">
                                <div class="form-group col-md-4">
                                        <label>Select Quiz name: </label>&nbsp
									<select name="quiz_id" class="form-control" maxlength="20" onchange="location = this.value"required>
											<option value= "Questions.php">All Quizzes</option>
											<?php 
												// list all quizzes for the teacher and class
												$instructor_id = $_SESSION['username'];
												$class_id = $_SESSION['class_id'];
												$query = "select quiz_name, quiz_id from quizzes where class_id ='$class_id'";
												$query_run = $conn->query($query);
												
												while($row = mysqli_fetch_array($query_run)){
													$row_quiz_name = $row['quiz_name'];
													$row_quiz_id = $row['quiz_id'];
											?>
												<option value= "Questions.php?id=<?php echo $row_quiz_id; ?>" <?php if ($row_quiz_id == $quiz_id) { echo "selected";}?>><?php echo $row_quiz_name; ?></option>
											<?php 
												}
												
											?>
									</select>
                                    <a href="#addQuestionModal" class="btn" data-toggle="modal" <?php if ($quiz_id == "") {echo 'style="visibility: hidden;"';} ?>><i class="material-icons">&#xE147;</i> <span>Add Question</span></a>
                                </div>
                            </div>
                        </div>
                	</div>
                    <table class="table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="width:400px;">Question</th>
                                <th style="width:400px;">Correct Answer</th>
                                <th style="width:400px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php 
								if ($quiz_id == "") {
									$question_query = "SELECT a.question_id, a.question, case a.true_ans when 'A' then a.ans_a when 'B' then a.ans_b when 'C' then a.ans_c when 'D' then a.ans_d end as answer from questions a, quizzes b where a.quiz_id = b.quiz_id and b.instructor_id = '$instructor_id' and b.class_id = '$class_id'";
									//$question_query = "select a.question, a.correct_answer from questions_2 a, quizzes b where a.quiz_id = b.quiz_id and b.instructor_id = '$instructor_id'";
								} else {
									$question_query = "SELECT question_id, question, ans_a, ans_b, ans_c, ans_d, case true_ans when 'A' then ans_a when 'B' then ans_b when 'C' then ans_c when 'D' then ans_d end as answer, true_ans 
									from questions where quiz_id = '$quiz_id'";
									//$question_query = "select question, correct_answer from questions_2 where quiz_id = '$quiz_id'";
								}
								$count = 0;
								$query_run = $conn->query($question_query);
								while($row = mysqli_fetch_array($query_run)){
										$count++;
										$row_question = $row['question'];
										$row_answer = $row['answer'];
										$row_question_id = $row['question_id'];
										$row_ans_a = $row['ans_a'];
										$row_ans_b = $row['ans_b'];
										$row_ans_c = $row['ans_c'];
										$row_ans_d = $row['ans_d'];
										$true_ans = $row['true_ans'];
							?>
								<tr>
									<td><?php echo $count; ?></td>
									<td><?php echo $row_question; ?></td>
									<td><?php echo $row_answer; ?></td>
									<td>
										<a href="#editQuestionModal<?php echo $row_question_id?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
										<a href="#deleteQuestionModal" class="delete" data-toggle="modal" data-id="<?php echo $row_question_id; ?>"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
									</td>
								</tr>
							<?php
								}
							?>
                        </tbody>
                    </table>
					<br> <br> <br>
                </div>
				<?php 
					// if this quiz has no questions, prompt the user to add some
					if ($count == 0) {
				?>
				<br>
				<br>
				<p style="margin-left: 25%; "> You haven't added any questions to this quiz yet!  Click 'Add Question' to start filling up your question bank. </p>
				<?php
					}
				?>
			</div>
</div>
    <!-- Add Modal HTML -->
           <div id="addQuestionModal" class="modal">
                    <form action="../php/CreateQuestion.php" class="form-container" method="POST">
                        <h2>Add a new question</h2>
                        <br>
                            <textarea rows="2" placeholder="Enter the question here" name="q_name" ></textarea>
                            <textarea rows="2" placeholder="Enter Answer (A)" name="opt_1" ></textarea>
                            <textarea rows="2" placeholder="Enter Answer (B)" name="opt_2" ></textarea>
                            <textarea  rows="2" placeholder="Enter Answer (C)" name="opt_3" ></textarea>
                            <textarea  rows="2" placeholder="Enter Answer (D)" name="opt_4" ></textarea>
                            <select name="true_ans" required>
                                        <option name="">--Correct Answer--</option>
                                        <option name= "A">A</option>
                                        <option name= "B">B</option>
                                        <option name= "C">C</option>
                                        <option name= "D">D</option>
                            </select>
                            <input type="button" class="btn cancel" data-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn" value="Add">
                    </form>
            </div> 
			
			
            <!-- Edit Modal HTML -->
			<?php 
				if ($quiz_id == "") {
					$question_query = "SELECT question_id, question, ans_a, ans_b, ans_c, ans_d, case true_ans when 'A' then ans_a when 'B' then ans_b when 'C' then ans_c when 'D' then ans_d end as answer, true_ans
					from questions a, quizzes b where a.quiz_id = b.quiz_id and b.instructor_id = '$instructor_id'";
					//$question_query = "select a.question, a.correct_answer from questions_2 a, quizzes b where a.quiz_id = b.quiz_id and b.instructor_id = '$instructor_id'";
				} else {
					$question_query = "SELECT question_id, question, ans_a, ans_b, ans_c, ans_d, case true_ans when 'A' then ans_a when 'B' then ans_b when 'C' then ans_c when 'D' then ans_d end as answer, true_ans 
					from questions where quiz_id = '$quiz_id'";
					//$question_query = "select question, correct_answer from questions_2 where quiz_id = '$quiz_id'";
				}
				$count = 0;
				$query_run = $conn->query($question_query);
				while($row = mysqli_fetch_array($query_run)){
						$count = $count+1;
						$row_question = $row['question'];
						$row_answer = $row['answer'];
						$row_question_id = $row['question_id'];
						$row_ans_a = $row['ans_a'];
						$row_ans_b = $row['ans_b'];
						$row_ans_c = $row['ans_c'];
						$row_ans_d = $row['ans_d'];
						$true_ans = $row['true_ans'];
			?>
            <div id="editQuestionModal<?php echo $row_question_id;?>" class="modal">
                    <form action="../php/EditQuestion.php" class="form-container" method="POST">
                            <h2>Edit the question</h2>  
                            <br>
                                <textarea rows="2" placeholder="<?php echo $row_question ?>" name="q_name" ></textarea>
                                <textarea rows="2" placeholder="<?php echo $row_ans_a; ?>" name="opt_1" ></textarea>
								<textarea rows="2" placeholder="<?php echo $row_ans_b; ?>" name="opt_2" ></textarea>
								<textarea  rows="2" placeholder="<?php echo $row_ans_c; ?>" name="opt_3" ></textarea>
								<textarea  rows="2" placeholder="<?php echo $row_ans_d; ?>" name="opt_4" ></textarea>
								<input type="hidden" name="question_id" value="<?php echo $row_question_id; ?>" ></input>
                                <select placeholder="" name="true_ans" required>
                                            <option name="">--Correct Answer--</option>
                                            <option name= "ans1" <?php if ($true_ans == "A") { echo "selected";}?>>A</option>
                                            <option name= "ans2" <?php if ($true_ans == "B") { echo "selected";}?>>B</option>
                                            <option name= "ans3" <?php if ($true_ans == "C") { echo "selected";}?>>C</option>
                                            <option name= "ans4" <?php if ($true_ans == "D") { echo "selected";}?>>D</option>
                                </select>
                                <input type="button" class="btn cancel" data-dismiss="modal" value="Cancel">
                                <input type="submit" class="btn" value="Edit">
                        </form>
                
            </div>
				<?php } ?>
            <!-- Delete Modal HTML -->
            <div id="deleteQuestionModal" class="modal">
                <form action = "../php/DeleteQuestion.php" method="POST" class="form-container">
                    <br>
                    <h4>Delete Question</h4>
                    <br>					
                    <p>Are you sure you want to delete this question?</p>
                    <br>
					<input type="hidden" name="q_id" value="id" />
                    <input type="button" class="btn cancel" data-dismiss="modal" value="Cancel">
                    <button type="submit" class="btn" name="Delete"> Delete </input>
                </form>
            </div>
    
<!-- Footer: Used for any page 
	<div id="footer">
			<p> MarQuiz </p>
	</div>-->
</body>
</html>
