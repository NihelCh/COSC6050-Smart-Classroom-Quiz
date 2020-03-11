<?php 
	session_start();
?>
<head>
  <title>Register</title>
   <!--Bootsrap 4 CSS-->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/indexstyles_updated.css">
</head>
<body>
<header>
  <div class="header">
    <h1>Welcome to MarQuiz!</h1>
  </div>
</header>
<div class="container">
  <div class="row">
      <div class="col-md-4 offset-md-4 form-div">
      <form action="php/registration.php" method="POST" oninput='validatePassword()' >
        <h3 class="text-center">Sign Up</h3> 
        <div class="form-group">
            <label for="fname"><b>First Name</b></label>
            <input type="text" name="fname" class="form-control form-control-lg" required value=<?php echo $_SESSION['first_name_form'] ?> >
        </div>
        <div class="form-group">
            <label for="lname"><b>Last Name</b></label>
            <input type="text" name="lname"  class="form-control form-control-lg" required value=<?php echo $_SESSION['last_name_form'] ?>>
        </div>
        <div class="form-group">
            <label for="username"><b>Username</b></label>
            <input type="text" name="username" class="form-control form-control-lg" required value=<?php echo $_SESSION['username_form'] ?>>
        </div>
        <div class="form-group">
            <label for="email"><b>Email</b></label>
            <input type="email" name="email" class="form-control form-control-lg" required value=<?php echo $_SESSION['email_form'] ?>>
        </div>
        <div class="form-group">
            <label  for="psw"> <b>Password</b>
			<p class="text-left">Must contain at least 6 characters, one uppercase letter, one lowercase letter and one number. </p></label>
            <input  type="password" name="password" id="password" class="form-control form-control-lg" required>
        </div>
        <div class="form-group">
            <label for="passwordConf"><b>Confirm Password</b></label>
            <input type="password" name="passwordConf" id="passwordConf" class="form-control form-control-lg" required>
        </div>
        <div class="form-group">
          <label for="role"> I am a: &nbsp;
           <input type="radio" name="role" value="Student" required> Student 
           <input type="radio" name="role" value="Teacher" required> Teacher<br>
          </label>
        </div>
        <div class="form-group">
          <button type="submit" name="signup-btn" class="btn btn-primary btn-block btn-lg">Sign up</button>
        </div>
        <p class="text-center">Already a member? <a href="index.html">Sign In</a></p>
      </form>
    </div>
  </div>
</div>
</body>
</html>