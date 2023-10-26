<?php
	define('MyConst', TRUE);    
	include_once('connection.php');
	
	session_start();
	if(!isset($_SESSION['username'])){
		session_destroy();
		header("Location: login.php");
		die();
	}
	
	if(isset($_POST['logout'])){
		session_destroy();
		header("Location: ./login.php");
		exit;
	}

	if($_SESSION['type']!=0){
        //session_destroy();
        header("Location: admin.php?class=rating");
        //die();
    }
	
	if($_SESSION['anti_skip']==0){
    	
    }else if($_SESSION['anti_skip']==1){
    	header("Location: demographics.php");
    }else if($_SESSION['anti_skip']==2){
    	header("Location: survey.php");
    }else if($_SESSION['anti_skip']==3){
    	header("Location: end.php?class=Degree Program");
    }
?>

<html>
<!-- styles and font-->
<link rel="stylesheet" type="text/css" href="survey-style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="icon" href="https://cs.upb.edu.ph/assets/images/upbcs-logo.png">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

<!-- scripts -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


	<head>
		<title>DMCS Exit Survey</title>

		
        
		
	</head>

<div class="survey" style="width: 60%">	
<div class="justify-content-center align-items-center">
<div class="col-md-15">

<!--  privacy notice -->
<form id="regForm" action="demographics_submit.php?id=<?php echo $a?>" method="post">
	 	<div style="margin: 40 50 40 50; text-align: center;" width="100%">
	 	<h2 >University of the Philippines (UP) Privacy Notice for Students</h2>

		<p style="text-align: justify;"><br>
			To exercise and safeguard academic freedom and uphold your right to quality education, the University of the Philippines needs to process your personal and sensitive personal information-that is, information that identifies you as an individual.<br><br>

			UP is committed to comply with the <a href="http://www.officialgazette.gov.ph/2012/08/15/republic-act-no-10173/">Philippine Data Privacy Act of 2012 (DPA)</a>  in order to protect your right to data privacy.<br><br>

			This notice explains in general terms the purpose and legal basis for the processing of the typical or usual examples of personal and sensitive personal information that UP collects from students like you, the measures in place to protect your data privacy and the rights that you may exercise in relation to such information. Please note that this document does not contain an exhaustive list of all of UP's processing systems as well as the purpose and legal basis for processing.
		</p>

			<!-- proceed to the demographics information section -->
			<div style="overflow:auto;">
				<div style="float: right;">
			<button type="button" id="nextBtn" onclick="location.href='demographics.php'"><i class="fa fa-angle-double-right"></i></button>
		</div>
		</div>
	</div>


		 

	
</form>
</div>
</div>
</div>	 
</body>
</html>