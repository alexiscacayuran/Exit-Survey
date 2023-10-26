<?php

//show an error message if access directly
define('MyConst', true);

//connect to database
include_once 'connection.php';

//filter accesses on this file
session_start();
if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: login.php");
    die();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ./login.php");
    exit;
}

if ($_SESSION['type'] != 0) {
    header("Location: admin.php?class=rating");
}

$_SESSION['gate_keep0'] = true;

//prevent skips, bounce back to their corresponding page if this file is accessed
if ($_SESSION['anti_skip'] == 0) {
    $_SESSION['anti_skip'] = 1;
} else if ($_SESSION['anti_skip'] == 1) {

} else if ($_SESSION['anti_skip'] == 2) {
    header("Location: survey.php");
} else if ($_SESSION['anti_skip'] == 3) {
    header("Location: end.php?class=Degree Program");
}
?>

<html>



	<head>
		<title>DMCS Exit Survey</title>

		<!-- styles and fonts-->
		<link rel="icon" href="https://cs.upb.edu.ph/assets/images/upbcs-logo.png">
		<link rel="stylesheet" href="survey-style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
		
		<!-- scripts -->
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        

	</head>

<!-- container -->
<div class="survey" style="width: 70%">
<div class="row d-flex justify-content-center">
<div class="col-md-8">

<!-- personal details form  -->
<form id="regForm" action="demographics_submit.php" method="post">

		
		<div style="margin: 0 20 30 20; text-align: center;" >
			<h1 id="register" style="padding: 20px">DMCS Exit Survey</h1>
			<p style="text-align: center">Please input your personal information below.</p>
			<label for="name">Full Name (optional):</label>
			<input id="name" style="width: 80%" type="text" name="fullname" placeholder="Juan Dela Cruz"><br><br>

			<label for="num"> Student Number (optional): </label>
			<input id="num" style="width: 80%" type="text" name="studentnum" placeholder="XXXX-XXXXX"><br><br>

			<label for="num"> Year of Graduation: </label>
			<input id="num" style="width: 80%" type="text" name="grad" placeholder="XXXX" required><br><br>

			<label for="course">Degree Program:
				<select class="form-select form-select-sm form-select-border-color: 1px solid #aaaaaa " style="margin: 5px 0 15px 0;" id="course" name="course" required>
					<option value="BS Computer Science">BS Computer Science</option>
		    		<option value="BS Mathematics">BS Mathematics</option>
		    	</select>
		    </label>
		    <br>

		    <!-- submit button  -->
		    <div>
		    		<button style="border-radius: 5px; font-size: 12px; width: 80%" type="submit" value="Submit">Submit</button>
			</div>
	    </div>



</form>
</div>
</div>
</div>
</body>
</html>
