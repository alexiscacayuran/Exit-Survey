<!DOCTYPE html>
<html>
<head>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css'>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js'></script>
<link href='https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css'>

<style>
body{
	font-family: 'Calibri', sans-serif;
}
</style>



</head>
<?php
            //shows an error message if include is accessed directly
            define('MyConst', TRUE);  

            //connect to the database
            include_once('connection.php');
            
            //Filter access to this file
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

            if($_SESSION['type']!=1){
                session_destroy();
                header("Location: login.php");
                die();
            }

            if($_SESSION['gatekeep1']!=TRUE){
                exit('Direct access denied!');
            }

//File name of the file to be downloaded
$file_name = 'Individual_Tally_' . time() . '.xls';
   
   //function that indicates that the following content will be downloaded
 header("Content-Disposition: attachment; filename=" . basename($file_name));           
 header("Content-Type: application/vnd.ms-excel");

?>

   <body>
    <?php
            

        //Gets the id passed from res_individual page
		$a = $_GET['id'];
            //gathers content from database's demographics table
		  $res_indi_sel = "SELECT * FROM demographics where id = $a";
            $res_indi_res = mysqli_query($conn,$res_indi_sel);


            //basic code for cycling through the table
            if(mysqli_num_rows($res_indi_res)>0){
                while($row=mysqli_fetch_assoc($res_indi_res)){

                    //put tables' elements in variables
                    $b = $row['up_mail'];
                    $c = $row['full_name'];
                    $d = $row['student_num'];
                    $e = $row['degree_program'];
                    $f = $row['time_out'];
                }
            }
		

        date_default_timezone_set("Asia/Hong_Kong");
        
        $date = date(DATE_RSS);

 
//Below this comment starts the content of the file to be downloaded
   ?>
    <div class="survey">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-8">

          <form id="regForm">
             <div align="center" width="100%" class="header">
                <h3 style="color: maroon">DMCS Exit Survey</h1>
             </div>

             <div align="center" width="100%" class="header">
                <h1>Individual Tally as of <?php echo $date?></h1>
             </div>

        <table>
               <tr>
                    <td>
                    	 <h4>
	                 <?php
	            	if($c == null) {
	                	echo "Anonymous";
	                }else
	                   echo $c;
					?>
					</h4>
					</td>
                </tr> 


			  	<tr>
			  		<td>
			  		Email: 
			  		<?php if($b == null){
			  			echo "Not Provided";
			  		}else{ 
			  		echo $b;
				  	}
				  	?>
			  	</td>
			  </tr>

		  	<tr><td>Student Number: 
		  		<?php 
				if($d == null) {
					echo "(not provided)";
				}else{
					echo $d;
				}?>
			<td></tr>
			<tr><td>Degree Program: <?php echo $e?></td></tr>
			<tr><td>Date and Time of Completion: 
				<?php echo $f; ?>
			</td></tr>
            </table> 


                <div class="tab" id="page1">
                
                    <h3 style= "color: Maroon;">I. Degree Program</h3>
                    
                    <?php
                    //Rating part of to be downloaded file, getting the questions side by side with the ratings(results from survey)
                        $select1 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, rating.rate
					FROM questionnaire NATURAL JOIN rating
					WHERE (questionnaire.question_id = rating.question_id) AND id ='$a'";
                        $result1 = mysqli_query($conn,$select1);

                        if(mysqli_num_rows($result1)>0){
                    ?>

                    <table cellspacing="0" style="margin:auto; width: 100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: center; border: 1px solid black">Question</th>
								<th style="text-align: center; border: 1px solid black">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result1)){
                                $i = $row['question_id'];
                                if($row['question_id'] <= 9){
                            ?>  
                            <tr class="question">

                                <td style="text-align: left; border: 1px solid black"><?php echo $row['question_id'].". ".$row['question']?></td>
                                </td>
                                <td style="text-align: center; border: 1px solid black"><?php echo $row['rate']?></td>
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                          <?php
                                    }else
                                        continue;
                                 }   
                            }
                            ?>
                        </tbody>

                    </table> 
                     <?php
                      /* This part of code is for comments/ suggestions on Degree Program
                   */
                   $select3 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, suggestion.comments
						FROM questionnaire NATURAL JOIN suggestion
						WHERE (questionnaire.question_id = suggestion.question_id) AND id ='$a'";
						$result3 = mysqli_query($conn,$select3); 
			 			 if(mysqli_num_rows($result3)>0){
             	       ?>

                      <table cellspacing="0" style="margin:auto; width: 100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: center; border: 1px solid black">Question</th>
								<th style="text-align: center; border: 1px solid black">Suggestion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result3)){
                                $i = $row['question_id'];
                                if($row['question_id'] >= 10 && $row['question_id'] <= 11){
                            ?>  
                            <tr class="question">

                                <td style="text-align: left; border: 1px solid black"><?php echo $row['question_id'].". ".$row['question']?></td>
                                </td>
                                <td style="text-align: center; border: 1px solid black"><?php echo $row['comments']?></td>
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                        
                          <?php
                                    }else
                                        continue;
                                 }   
                            }
                            ?>
                        </tbody>

                    </table> 

                    <div class="tab" id="page1">
                
                    <h3 style= "color: Maroon;">II. Facilities and Infrastructure</h3>

                       <?php

                        $select2 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, rating.rate
					FROM questionnaire NATURAL JOIN rating
					WHERE (questionnaire.question_id = rating.question_id) AND id ='$a'";
                        $result2 = mysqli_query($conn,$select2);

                        if(mysqli_num_rows($result2)>0){
                    ?>

                    <table cellspacing="0" style="margin:auto; width: 100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: center; border: 1px solid black">Question</th>
								<th style="text-align: center; border: 1px solid black">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result2)){
                                $i = $row['question_id'];
                                if($row['question_id'] >= 12 && $row['question_id'] <= 28){
						
                            ?>  
                            <tr class="question">
                            	
                                <td style="text-align: left; border: 1px solid black"><?php echo $row['question_id'].". ".$row['question']?></td>
                                </td>
                                <td style="text-align: center; border: 1px solid black">
                                		<?php 
						if ($row['rate'] == '0') {
							echo "Not Applicable";
						}else
						 	echo $row['rate'];
						 ?>
                                </td>
                                
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                          <?php
                                    }else
                                        continue;
                                 }   
                            }
                            ?>
                        </tbody>

                    </table> 
                    
                     <?php
                      /* This part of code is for comments/ suggestions on Facilities and Infrastructure
                   */
                    $select4 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, suggestion.comments
						FROM questionnaire NATURAL JOIN suggestion
						WHERE (questionnaire.question_id = suggestion.question_id) AND id ='$a'";
						$result4 = mysqli_query($conn,$select4); 
			 			 if(mysqli_num_rows($result4)>0){
             	       ?>

                      <table cellspacing="0" style="margin:auto; width: 100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: center; border: 1px solid black">Question</th>
								<th style="text-align: center; border: 1px solid black">Suggestion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result4)){
                                $i = $row['question_id'];
                                if($row['question_id'] == 15){
                            ?>  
                            <tr class="question">

                                <td style="text-align: left; border: 1px solid black"><?php echo $row['question_id'].". ".$row['question']?></td>
                                </td>
                                <td style="text-align: center; border: 1px solid black"><?php echo $row['comments']?></td>
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                        
                          <?php
                                    }else
                                        continue;
                                 }   
                            }
                            ?>
                        </tbody>

                    </table> 
 <h3 style= "color: Maroon;">III. Financial Aid </h3>
  <?php
        //Financial Aid part
			$select8 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, polar.answers
					FROM questionnaire NATURAL JOIN polar
					WHERE (questionnaire.question_id = polar.question_id) AND id ='$a'";
			$result8 = mysqli_query($conn,$select8); 

			if(mysqli_num_rows($result8)>0){
  				?>
				 <table cellspacing="0" style="margin:auto; width: 100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: center; border: 1px solid black">Question</th>
								<th style="text-align: center; border: 1px solid black">Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result8)){
                                $i = $row['question_id'];
                                if($row['question_id'] >= 29 && $row['question_id'] <= 30 ){
                            ?>  
                            <tr class="question">

                                <td style="text-align: left; border: 1px solid black"><?php echo $row['question_id'].". ".$row['question']?></td>
                                </td>
                                <td style="text-align: center; border: 1px solid black"><?php echo $row['answers']?></td>
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                        
                          <?php
                                    }else
                                        continue;
                                 }   
                            }
                            ?>
                        </tbody>

                    </table> 

                     <h3 style= "color: Maroon;">IV. Events </h3>
                     <?php
                      /* This part of code is for comments/ suggestions on Events
                   */
                    $select5 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, suggestion.comments
						FROM questionnaire NATURAL JOIN suggestion
						WHERE (questionnaire.question_id = suggestion.question_id) AND id ='$a'";
						$result5 = mysqli_query($conn,$select5); 
			 			 if(mysqli_num_rows($result5)>0){
             	       ?>

                      <table cellspacing="0" style="margin:auto; width: 100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: center; border: 1px solid black">Question</th>
								<th style="text-align: center; border: 1px solid black">Suggestion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result5)){
                                $i = $row['question_id'];
                                if($row['question_id'] >= 31 && $row['question_id'] <= 33){
                            ?>  
                            <tr class="question">

                                <td style="text-align: left; border: 1px solid black"><?php echo $row['question_id'].". ".$row['question']?></td>
                                </td>
                                <td style="text-align: center; border: 1px solid black"><?php echo $row['comments']?></td>
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                        
                          <?php
                                    }else
                                        continue;
                                 }   
                            }
                            ?>
                        </tbody>

                    </table> 

                    <h3 style= "color: Maroon;">V. Career Plans </h3>
                     <?php
                      /* This part of code is for comments/ suggestions on Career Plans
                   */
                    $select6 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, suggestion.comments
						FROM questionnaire NATURAL JOIN suggestion
						WHERE (questionnaire.question_id = suggestion.question_id) AND id ='$a'";
						$result6 = mysqli_query($conn,$select6); 
			 			 if(mysqli_num_rows($result6)>0){
             	       ?>

                      <table cellspacing="0" style="margin:auto; width: 100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: center; border: 1px solid black">Question</th>
								<th style="text-align: center; border: 1px solid black">Suggestion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result6)){
                                $i = $row['question_id'];
                                if($row['question_id'] ==34){
                            ?>  
                            <tr class="question">

                                <td style="text-align: left; border: 1px solid black"><?php echo $row['question_id'].". ".$row['question']?></td>
                                </td>
                                <td style="text-align: center; border: 1px solid black"><?php echo $row['comments']?></td>
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                        
                          <?php
                                    }else
                                        continue;
                                 }   
                            }
                            ?>
                        </tbody>

                    </table> 

                    <?php 

                      /* This part of code is for comments/ suggestions on Career Plans
                   */
			$select7 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, polar.answers
					FROM questionnaire NATURAL JOIN polar
					WHERE (questionnaire.question_id = polar.question_id) AND id ='$a'";
			$result7 = mysqli_query($conn,$select7); 

			if(mysqli_num_rows($result7)>0){
  				?>
				 <table cellspacing="0" style="margin:auto; width: 100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: center; border: 1px solid black">Question</th>
								<th style="text-align: center; border: 1px solid black">Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result7)){
                                $i = $row['question_id'];
                                if($row['question_id'] ==35){
                            ?>  
                            <tr class="question">

                                <td style="text-align: left; border: 1px solid black"><?php echo $row['question_id'].". ".$row['question']?></td>
                                </td>
                                <td style="text-align: center; border: 1px solid black"><?php echo $row['answers']?></td>
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                        
                          <?php
                                    }else
                                        continue;
                                 }   
                            }
                            ?>
                        </tbody>

                    </table> 


            <h3 style= "color: Maroon;">VI. Consent on follow-up interview </h3>
            <?php 
                    
                      /* This part of code is for comments/ suggestions on consent on follow up interviews
                   */
			$select9 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, consent.answers
					FROM questionnaire NATURAL JOIN consent
					WHERE (questionnaire.question_id = consent.question_id) AND id='$a'";
			$result9 = mysqli_query($conn,$select9); 

			if(mysqli_num_rows($result9)>0){
  				?>
				 <table cellspacing="0" style="margin:auto; width: 100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: center; border: 1px solid black">Question</th>
								<th style="text-align: center; border: 1px solid black">Answer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result9)){
                                $i = $row['question_id'];
                                if($row['question_id'] == 36){
                            ?>  
                            <tr class="question">

                                <td style="text-align: left; border: 1px solid black"><?php echo $row['question_id'].". ".$row['question']?></td>
                                </td>
                                <td style="text-align: center; border: 1px solid black"><?php echo $row['answers']?></td>
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                        
                          <?php
                                    }else
                                        continue;
                                 }   
                            }
                            ?>
                        </tbody>

                    </table> 
                     <h3 style= "color: Maroon;">VII. Other Comments and Suggestions</h3>
                     <?php
                      /* This part of code is for comments/ suggestions on Career Plans
                   */
                    $select10 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, suggestion.comments
						FROM questionnaire NATURAL JOIN suggestion
						WHERE (questionnaire.question_id = suggestion.question_id) AND id ='$a'";
						$result10 = mysqli_query($conn,$select10); 
			 			 if(mysqli_num_rows($result10)>0){
             	       ?>

                      <table cellspacing="0" style="margin:auto; width: 100%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: center; border: 1px solid black">Question</th>
								<th style="text-align: center; border: 1px solid black">Suggestion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result10)){
                                $i = $row['question_id'];
                                if($row['question_id'] ==34){
                            ?>  
                            <tr class="question">

                                <td style="text-align: center; border: 1px solid black"><?php echo $row['question_id'].". ".$row['question']?></td>
                                </td>
                                <td style="text-align: center; border: 1px solid black"><?php echo $row['comments']?></td>
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                        
                          <?php
                                    }else
                                        continue;
                                 }   
                            }
                            ?>
                        </tbody>
                    </table>
             
      
</div>
</div>
</form>
</body>
</html>