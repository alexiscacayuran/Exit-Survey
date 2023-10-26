<?php

	//show an error message if access directly
	define('MyConst', TRUE);    

	//connect to the database
	include_once('connection.php');

	// assign the initial values of these values to prevent skips
	session_start();
	$_SESSION['anti_skip']=0;
	$_SESSION['type']=3;
?>

<html>
<!-- styles and font-->
<link rel="stylesheet" type="text/css" href="survey-style.css">
<link rel="icon" href="https://cs.upb.edu.ph/assets/images/upbcs-logo.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

<!-- scripts -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<head>
	<title>Login | DMCS Exit Survey</title>
</head>
   
	<!-- container -->
     <div class="survey">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-lg">

        <!-- form for the login credentials -->
        <form id="regForm" action = "" method = "post">
      <div style="margin: 20px; text-align: center;"><img style="width: 20%;"  src="https://cs.upb.edu.ph/assets/images/upbcs-logo.png"   /></div>
       <h1>DMCS Exit Survey</h1>

    


    
 		<table >
 		<tr>
 		<td style="padding: 20px; border-right: 1px solid lightgray; width: 60%">

 		<!-- short description about the exit survey -->
     	<p style="font-size: 80%">As a part of the graduation process, the College of Science would like to ask a series of questions that should help in the systematic evaluation necessary to improve the quality of each student's journey towards the completion of his/her degree.<br><br>

		This survey should assess your experience as a UP student and how you think it can be improved for the future. You are highly encouraged to answer all questions applicable to optimize the information we can gather from your experience. It will take approximately 8-10 minutes to accomplish this survey. We assure you that all information provided in this survey will be treated with the utmost confidentiality.</p>
		</td>
    
    	
    <td style="padding: 20px;">

    <div class="form-group" width="100%">
    <?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		//username and password sent from form 
		$myusername = mysqli_real_escape_string($conn,$_POST['username']);
		$mypassword = mysqli_real_escape_string($conn,$_POST['password']); 
      
      	//select the login record that is similar to what the user entered
		$sql = "SELECT * FROM login WHERE up_mail = '$myusername' and password = '$mypassword'";
		$result = mysqli_query($conn,$sql);     
      
		if($count=mysqli_num_rows($result)>0){
			while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

				//get the first row of the table
				if($count == 1) {

					//if the user is a respndent
					if($row['type']==0){

						//query to check if the resoindent was already in the the demographics table
						$verify1 = "SELECT up_mail, time_out FROM demographics WHERE up_mail = '$myusername'";
						$result_verify1 = mysqli_query($conn,$verify1);  

						//query to check if it a new respondent
						$verify2 = "SELECT up_mail, time_out FROM demographics WHERE up_mail = '$myusername'";
						$result_verify2 = mysqli_query($conn,$verify2);  

						 	if(mysqli_num_rows($result_verify1)==1){
						 		while($row1=mysqli_fetch_assoc($result_verify1)){

						 			//check if there is no time out recorded for the responent
						 			if ($row1['time_out'] == null) {
									 	$_SESSION['username']=$myusername;
										$_SESSION['type']=$row['type'];
										$_SESSION['id']=$row['id'];

										//proceed to the privacy notice section
										header("location: notice.php");
						 			}else
						 				break;
								}
							}


							if(mysqli_num_rows($result_verify2)==0){

								//proceed to the privacy notice section
								$_SESSION['username']=$myusername;
								$_SESSION['type']=$row['type'];
								$_SESSION['id']=$row['id'];
								header("location: notice.php");
								
							}
					}
							
					//if the user is an admin
					if($row['type']==1){
						$_SESSION['username']=$myusername;
						$_SESSION['type']=$row['type'];

						//proceed to the admin section
						header("location: admin.php?class=rating");
					}
				}
			}
			
		}else 
	?>
		<!-- show an error message if no record has been found-->
		<p align="center" style="font-size: 12px; color: red">Invalid login credentials. Please try again.</p>
	<?php
	}
	//close the connection
   	mysqli_close($conn);
    ?>
    	<!-- fields for the login credentials -->
		<input class="form-control" type="text" id="login"  name="username" placeholder=" Email"><br>
		<input class="form-control" type="password" id="password"  name="password" placeholder=" Password"><br>
		<div class="d-grid gap-2">

		<!-- login button -->
		<button style="border-radius: 4px; font-size: 14px" type="submit" value="Log In">Log In</button>

		<!-- sign up button -->
		<p style= "font-size: 11px">Don't have an account? <a href="register.php">Sign up now</a>.</p>
  		</div>
    </div>
  </td>
  </table>
      
    

    <!-- Remind Passowrd -->
    
      
      </form>
    
    
</div>
</div>
</div>

   </body>


</html>