<?php

	//show an error message if access directly
	define('MyConst', TRUE);    

	//connect to the database  
	include_once('connection.php');
	
	//get the responden's id
	session_start();
	$a = $_SESSION['id'];

	//set the time zone which will then be used to record the time stamp
	date_default_timezone_set("Asia/Hong_Kong");

	//use the DATA_RSS formar
	$date = date(DATE_RSS);

	//update the time out of the respondent's demograpic information
	$update = "UPDATE demographics SET time_out = '$date' WHERE id = '$a'";

	if ($conn->query($update) === FALSE){
		echo "Error: ".$update."<br>".$conn->error."<br><br>";
	}

	

	//check if the survey is done
	if($bool!=TRUE){

		//filter accesses on this file
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

	    //prevent skips, bounce back to their corresponding page if this file is accessed
	    if($_SESSION['anti_skip']==0){
	    	header("Location: notice.php");
	    }else if($_SESSION['anti_skip']==1){
	    	header("Location: demographics.php");
	    }else if($_SESSION['anti_skip']==2){
	    	header("Location: survey.php");
	    }else if($_SESSION['anti_skip']==3){
			header("Location: end.php?class=Degree Program");
	    }
	}

	//page1,2

	//get the unique names of the fields (question1, ..., question9) and their respective answer by referring 
	//to the question id passed by the survey 
	for ($i = 1; $i <= 9; $i++){

		$question_id = "question_id$i";
		$rate = "rate$i";

		$b = $_POST[$question_id];
		$c = $_POST[$rate];
		
		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO rating (id, question_id, rate) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "<br>Error: ".$insert."<br>".$conn->error;
		}
	}	

	//get the unique names of the fields (question1, ..., question9) and their respective answer by referring 
	//to the question id passed by the survey 
	for ($i = 10; $i <= 11; $i++){

		$question_id = "question_id$i";

		//match the value of the iterator $j with its counterpart in the survey, and get the answer   
		$j = $i - 10;
		$comment = "comment$j";

		$b = $_POST[$question_id];

		//pass the comments to mysqli_real_escape_string to accept special characters
		$c = mysqli_real_escape_string($conn, $_POST[$comment]);

		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO suggestion (id, question_id, comments) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "<br>Error: ".$insert."<br>".$conn->error;
		}
	
	}

	//page3

	//get the unique names of the fields (question12, ..., question14) and their respective answer by referring 
	//to the question id passed by the survey 
	for ($i = 12; $i <= 14; $i++){

		$question_id = "question_id$i";
		$rate = "rate$i";

		$b = $_POST[$question_id];
		$c = $_POST[$rate];

		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO rating (id, question_id, rate) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "Error: ".$insert."<br>".$conn->error;
		}
	}

	//get the unique name of the field (question15) and its answer by referring 
	//to the question id passed by the survey 
	if ($i = 15){

		$question_id = "question_id$i";

		//initialize this variable to collect and concatenate the answers from the checkboxes into a single string
		$trim_comment = "";
		
		//match the values of the iterator $j with its counterpart in the survey, and get each of the answers
		for ($j = 2; $j <= 10; $j++){
			$comment = "comment$j";
			$concat_comment = mysqli_real_escape_string($conn, $_POST[$comment]);
			
			//concatenate all the answers using comma as a delimiter
			if ($concat_comment != null) {
				$trim_comment .= ", ".$concat_comment;
			}
			
		}
		
		//trim the extra commas
		$c = substr($trim_comment, 2);


		$b = $_POST[$question_id];

		
		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO suggestion (id, question_id, comments) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "<br>Error: ".$insert."<br>".$conn->error;
		}	
		
		
	}

	//page4,5

	//get the unique names of the fields (question16, ..., question20) and their respective answer by referring 
	//to the question id passed by the survey 	
	for ($i = 16; $i <= 28; $i++){


		$question_id = "question_id$i";
		$rate = "rate$i";

		$b = $_POST[$question_id];
		$c = $_POST[$rate];

		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO rating (id, question_id, rate) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "Error: ".$insert."<br>".$conn->error;
		}
	}


	//page6

	//get the unique names of the fields (question29, question30) and their respective answer by referring 
	//to the question id passed by the survey 	
	for ($i = 29; $i <= 30; $i++){

		$question_id = "question_id$i";
		$answer = "answer$i";

		$b = $_POST[$question_id];
		$c = $_POST[$answer];

		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO polar (id, question_id, answers) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "<br>Error: ".$insert."<br>".$conn->error;
		}	
	}


	//page7

	//get the unique name of the field (question31) and its answer by referring 
	//to the question id passed by the survey 
	if ($i = 31){


		$question_id = "question_id$i";

		//initialize this variable to collect and concatenate the answers from the checkboxes into a single string
		$trim_comment = "";
		
		//match the values of the iterator $j with its counterpart in the survey, and get each of the answers
		for ($j = 11; $j <= 19; $j++){
			$comment = "comment$j";
			$concat_comment = mysqli_real_escape_string($conn, $_POST[$comment]);
			
			//concatenate all the answers using comma as a delimiter
			if ($concat_comment != null) {
				$trim_comment .= ", ".$concat_comment;
			}
			
		}
		
		//trim the extra commas
		$c = substr($trim_comment, 2);

		$b = $_POST[$question_id];


		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO suggestion (id, question_id, comments) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "<br>Error: ".$insert."<br>".$conn->error;
		}	
		

	}

	//get the unique name of the field (question32) and its answer by referring 
	//to the question id passed by the survey 
	if ($i = 32){
		$question_id = "question_id$i";

		//initialize this variable to collect and concatenate the answers from the checkboxes into a single string
		$trim_comment = "";
		

		for ($j = 20; $j <= 23; $j++){
			$comment = "comment$j";
			$concat_comment = mysqli_real_escape_string($conn, $_POST[$comment]);
			
			//concatenate all the answers using comma as a delimiter
			if ($concat_comment != null) {
				$trim_comment .= ", ".$concat_comment;
			}
			
		}
		
		//trim the extra commas
		$c = substr($trim_comment, 2);
		$b = $_POST[$question_id];

		
		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO suggestion (id, question_id, comments) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "<br>Error: ".$insert."<br>".$conn->error;
		}	
		
	}

	//get the unique name of the field (question33) and its answer by referring 
	//to the question id passed by the survey 
	if ($i = 33){


		$question_id = "question_id$i";
		$comment = "comment$i";

			$b = $_POST[$question_id];
			$c = mysqli_real_escape_string($conn, $_POST[$comment]);


		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO suggestion (id, question_id, comments) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "<br>Error: ".$insert."<br>".$conn->error;
		}	
	}

	//page8

	//get the unique name of the field (question34) and its answer by referring 
	//to the question id passed by the survey 
	if ($i = 34){
		$question_id = "question_id$i";

		//initialize this variable to collect and concatenate the answers from the checkboxes into a single string
		$trim_comment = "";
		

		//match the values of the iterator $j with its counterpart in the survey, and get each of the answers		
		for ($j = 24; $j <= 30; $j++){
			$comment = "comment$j";
			$concat_comment = mysqli_real_escape_string($conn, $_POST[$comment]);
			
			//concatenate all the answers using comma as a delimiter
			if ($concat_comment != null) {
				$trim_comment .= ", ".$concat_comment;
			}
			
		}
		
		$c = substr($trim_comment, 2);
		$b = $_POST[$question_id];

		//trim the extra commas
		$insert = "INSERT INTO suggestion (id, question_id, comments) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "<br>Error: ".$insert."<br>".$conn->error;
		}	
		
	}

	//get the unique name of the field (question35) and its answer by referring 
	//to the question id passed by the survey 	
	if ($i = 35){
		$question_id = "question_id$i";
		$answer = "answer$i";

		$b = $_POST[$question_id];
		$c = $_POST[$answer];

		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO polar (id, question_id, answers) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "<br>Error: ".$insert."<br>".$conn->error;
		}	
	}

	//page9


	//get the unique name of the field (question36) 	
	if ($i = 36){
		$question_id = "question_id$i";
		$b = $_POST[$question_id];

		//get all of the question's answer from the survey fields in this question
		$polar = $_POST['polar'];
		$contact = mysqli_real_escape_string($conn, $_POST['means']);
		$other = mysqli_real_escape_string($conn, $_POST['other']);
		$contact_details = mysqli_real_escape_string($conn, $_POST['contact_details']);

		//if the respondent's answer is no, override the answers made when chose yes to null
		if ($polar == 'No') {
			$contact = null;
			$other = null;
			$contact_details = null;
		}

		//f the respondent's answer is yes, concatenate the answer to the question, connteact means, and contact details
		if ($contact != null && $contact_details != null) {
			$c = $polar.", ".$contact.", ".$contact_details;
		}elseif ($other == !null && $contact_details != null){
			$c = $polar.", ".$other.", ".$contact_details;

		}elseif ($contact == null && $contact_details == null){
			$c = $polar;
		}


		//insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		$insert = "INSERT INTO consent (id, question_id, answers) VALUES ('$a','$b','$c')";
		if ($conn->query($insert) === FALSE){
			echo "<br>Error: ".$insert."<br>".$conn->error;
		}	
	}
	
	//get the unique name of the field (question37) and its answer by referring 
	//to the question id passed by the survey 	
	if ($i = 37){
		$question_id = "question_id$i";
		$b = $_POST[$question_id];

		//pass the comments to mysqli_real_escape_string to accept special characters
		$c = mysqli_real_escape_string($conn, $_POST['comment']);
			

		//if not null, insert the respondents id, the question ids which are the questions the respodent answwered, 
		//and their answer to each of the questions to the database
		if ($c != null) {
			$insert = "INSERT INTO suggestion (id, question_id, comments) VALUES ('$a','$b','$c')";
			if ($conn->query($insert) === FALSE){
				echo "<br>Error: ".$insert."<br>".$conn->error;
			}else
				header("location: end.php?class=Degree Program");		
		}
	}

	mysqli_close($conn);

?>