<!DOCTYPE html>
<html>

<head>
    <title>DMCS Exit Survey</title>

    <!-- styles and font-->
    <link rel="icon" href="https://cs.upb.edu.ph/assets/images/upbcs-logo.png">
    <link rel="stylesheet" href="survey-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

    <!-- scripts -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'></script>
        

   
    <!-- link html file containing the steps for progress bar -->
     <script> 
    $(function(){
      $("#progress-bar").load("progress-bar.html"); 
    });
    
    </script> 
</head>

<body>

        <!-- sign out modal -->
        <div id="myModal" class="modal" name="Sign-out modal">

          <!-- modal content -->
          <div class="modal-content" action="backup.php" style="width: 30%; height: auto; padding: 20px">
            <span class="close">&times;</span>
            <div align="center" width="100%">

                <h3 style="font-size: 20px; font-weight: bolder">Sign Out</h3>

                
                <form method="post" action="" enctype="multipart/form-data" id="frm-restore">
                    <div class="file-picker-container">
                        <p>Do you wish to continue? Your response will be lost and will not be recorded.</p>
                    </div>

                <!-- confirmation buttons -->
                <button id="normal-btn" style=" width: 100px;" type="submit" title="Sign Out" name="logout" value="Log Out"><i class="fa fa-sign-out"></i> Sign Out</button>
                <span class="btn btn-secondary" >Cancel</span>
                </form>
            
            </div>
          </div>
        </div>


    <?php
        //show an error message if access directly
        define('MyConst', TRUE);  

        //connect to the database  
        include_once('connection.php');
        
        //filter accesses on this file
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
            header("Location: admin.php?class=rating");
        }

        //prevent skips, bounce back to their corresponding page if this file is accessed
        if($_SESSION['anti_skip']==0){
            header("Location: notice.php");
        }else if($_SESSION['anti_skip']==1){
            $_SESSION['anti_skip']=2;
        }else if($_SESSION['anti_skip']==2){

        }else if($_SESSION['anti_skip']==3){
            header("Location: end.php?class=Degree Program");
        }
   ?>

   <!-- container-->
    <div class="survey">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-8">

            <!-- sign out button -->
          <div style="position: relative; height: 40px; padding-left: 40px; float: right" id="nextprevious">
              <div class="center">
                <button id="myBtn" title="Sign out" name="logout" value="Log Out" style="width: 40px; margin-right: 90px; margin-top: 100px"><i class="fa fa-sign-out"></i></button>
              </div>
          </div>

          <!-- form containing the survey questions -->
          <form id="regForm" name="survey" method="post" action="survey_submit.php">

            <h1 id="title">DMCS Exit Survey</h1>

            <!-- progress bar, a lit up circle indicates a completely answered page -->
            <div id="progress-bar"></div>
            

                <!-- tab for page 1-->
                <div class="tab" id="page1">
                

                    <h3>I. Degree Program</h3>

                    <!-- legend for the rating scores -->
                    <div class="legend-container" style="width: 100%">
                        <ul id="legend" >
                          <li>1 - Needs Improvement</li>
                          <li>2 - Poor</li>
                          <li>3 - Satisfactory</li>
                          <li>4 - Good</li>
                          <li>5 - Excellent</li>
                        </ul>  
                    </div>
                    <?php

                        
                        //select the questions and its id from the questionnaire
                        $select1 = "select * from questionnaire";
                        $result1 = mysqli_query($conn,$select1);

                        if(mysqli_num_rows($result1)>0){
                    ?>


                    <table cellspacing="0" style="margin:auto; width: 90%">

                        <!-- table header containing the randomized choices -->
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: left">Question</th>
                                <th width="30px">5</th>
                                <th width="30px">4</th>
                                <th width="30px">3</th>
                                <th width="30px">2</th>
                                <th width="30px">1</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result1)){

                                //used as a reference to the question in the database
                                $i = $row['question_id'];

                                //select the questions having an id of 1 to 6
                                if($row['question_id'] <= 6){
                            ?>  

                            <!-- the order of table data in this row is deliberately altered each tab to randomize the choices-->
                            <tr class="question">

                                <!-- print the question -->
                                <td><?php echo $row['question_id'].". ".$row['question']?>

                                <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                <span name="rate<?php echo $i?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>

                                </td>

                                <!-- 
                                pass each of the field values to survey_submit
                                survey_submit then refer to each of the field names which is rate[question_id]
                                -->
                                <td>
                                    <input type="radio" id="Five" name="rate<?php echo $i?>" value="5"  title="Excellent" required>
                                    <label for="Five"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Four" name="rate<?php echo $i?>" value="4"  title="Good" required>
                                    <label for="Four"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Three" name="rate<?php echo $i?>" value="3"  title="Satisfactory" required>
                                    <label for="Three"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Two" name="rate<?php echo $i?>" value="2" title="Poor" required><label for="Two"></label>
                                </td>
                                <td>
                                    <input type="radio" id="One" name="rate<?php echo $i?>" value="1"  title="Needs Improvement" required>
                                    <label for="One"></label>
                                </td>
                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
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
                


                <!-- tab for page 2-->
                <div class="tab" id="page2">
                   <h3>I. Degree Program</h3>

                   <!-- legend for the rating scores -->
                    <div class="legend-container" style="width: 100%">
                        <ul id="legend" >
                          <li >1 - Needs Improvement</li>
                          <li>2 - Poor</li>
                          <li>3 - Satisfactory</li>
                          <li>4 - Good</li>
                          <li>5 - Excellent</li>
                        </ul>  
                    </div>
                    <?php

                        //select the questions and its id from the questionnaire
                        $select2 = "select * from questionnaire";
                        $result2 = mysqli_query($conn,$select2);

                        //initiaze an interator j, this will be used to name the fields uniquely and
                        // to help survey_submit recognize which answers it has to read
                        $j = 0;


                        if(mysqli_num_rows($result2)>0){
                    ?>
                    <table cellspacing="0" style="margin:auto; width: 90%">

                        <!-- table header containing the randomized choices -->
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: left">Question</th>
                                <th width="30px">1</th>
                                <th width="30px">2</th>
                                <th width="30px">3</th>
                                <th width="30px">4</th>
                                <th width="30px">5</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result2)){

                                //used as a reference to the question in the database
                                $i = $row['question_id'];

                                //select the questions having an id of 7 to 9
                                if($row['question_id'] >= 7 && $row['question_id'] <= 9){
                            ?>  

                            <!-- the order of table data in this row is deliberately altered each tab to randomize the choices-->
                            <tr class="question">

                                <!-- print the question -->
                                <td><?php echo $row['question_id'].". ".$row['question']?>


                                <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                <span name="rate<?php echo $i?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>
                                </td>
                                
                                <!-- 
                                pass each of the field values to survey_submit
                                survey_submit then refer to each of the field names which is rate[question_id]
                                -->
                                <td>
                                    <input type="radio" id="One" name="rate<?php echo $i?>" value="1"  title="Needs Improvement" required>
                                    <label for="One"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Two" name="rate<?php echo $i?>" value="2" title="Poor" required>
                                    <label for="Two"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Three" name="rate<?php echo $i?>" value="3"  title="Satisfactory" required>
                                    <label for="Three"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Four" name="rate<?php echo $i?>" value="4"  title="Good" required>
                                    <label for="Four"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Five" name="rate<?php echo $i?>" value="5"  title="Excellent" required>
                                    <label for="Five"></label>
                                </td>
                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">

                                <?php

                                    //select the questions having an id of 10
                                    }elseif ($row['question_id'] == 10) {
                                ?>
                            <tr>
                                <td colspan="7"  style="width: 100%;">

                                    <!-- print the question-->
                                    <?php echo $row['question_id'].". ".$row['question']?> 

                                    <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                    <span name="comment<?php echo $j?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>

                                    <!-- 
                                    pass the value of the text field to survey_submit
                                    survey_submit then refer to the field name which is comment[iterator $j]
                                    -->
                                    <textarea style="margin-bottom: 10px" class="textarea" width="100%" name="comment<?php echo $j?>" required></textarea> 
                                </td>
                            </tr>

                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">

                                <?php
                                    //select the questions having an id of 11
                                    }elseif ($row['question_id'] == 11) {
                                ?>
                            <tr>
                                <td colspan="7"  style="width: 100%;">

                                    <!-- print the question-->
                                    <?php echo $row['question_id'].". ".$row['question']?> 

                                    <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                    <span name="comment<?php  echo $j + 1?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>

                                    <!-- 
                                    pass the value of the text field to survey_submit
                                    survey_submit then refer to the field name which is comment[iterator $j]
                                    -->
                                   <textarea style="margin-bottom: 10px" class="textarea" type="text" width="100%" name="comment<?php  echo $j + 1?>" required></textarea>
                                </td>
                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
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
              
              <!-- tab for page 3-->
                <div class="tab" id="page3">
                    <h3>II. Facilities and Infrastructure</h3>

                    <!-- legend for the rating scores -->
                    <div class="legend-container" style="width: 100%">
                        <ul id="legend" >
                          <li >1 - Needs Improvement</li>
                          <li>2 - Poor</li>
                          <li>3 - Satisfactory</li>
                          <li>4 - Good</li>
                          <li>5 - Excellent</li>
                        </ul>  
                    </div>
                    <?php

                        //select the questions and its id from the questionnaire
                        $select3 = "select * from questionnaire";
                        $result3 = mysqli_query($conn,$select3);

                        //initiaze an interator j, this will be used to name the fields uniquely and
                        // to help survey_submit recognize which answers it has to read
                        $j = 2;
                        if(mysqli_num_rows($result3)>0){
                    ?>
                    <table cellspacing="0" style=" margin:auto; width: 90%">

                        <!-- table header containing the randomized choices -->
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: left">Question</th>
                                <th width="30px">5</th>
                                <th width="30px">4</th>
                                <th width="30px">3</th>
                                <th width="30px">2</th>
                                <th width="30px">1</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result3)){

                                //used as a reference to the question in the database
                                $i = $row['question_id'];

                                //select the questions having an id of 12 to 14
                                 if($row['question_id'] >= 12 && $row['question_id'] <=14){
                            ?>  

                            <!-- the order of table data in this row is deliberately altered each tab to randomize the choices-->
                            <tr class="question">

                                <!-- print the question -->
                                <td><?php echo $row['question_id'].". ".$row['question']?>

                                <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                <span name="rate<?php echo $i?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span></td>

                                <!-- 
                                pass each of the field values to survey_submit
                                survey_submit then refer to each of the field names which is rate[question_id]
                                -->
                                <td>
                                    <input type="radio" id="Five" name="rate<?php echo $i?>" value="5"  title="Excellent" required>
                                    <label for="Five"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Four" name="rate<?php echo $i?>" value="4"  title="Good" required>
                                    <label for="Four"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Three" name="rate<?php echo $i?>" value="3"  title="Satisfactory" required>
                                    <label for="Three"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Two" name="rate<?php echo $i?>" value="2" title="Poor" required>
                                    <label for="Two"></label>
                                </td>
                                <td>
                                    <input type="radio" id="One" name="rate<?php echo $i?>" value="1"  title="Needs Improvement" required>
                                    <label for="One"></label>
                                </td>
                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">

                            <?php
                            //select the questions having an id of 15
                            }elseif ($row['question_id'] == 15) {
                            ?>
                                <tr>
                                <td colspan="7">
                                    <?php echo $row['question_id'].". ".$row['question']?> 

                                    <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                    <span class="checkbox<?php echo $j?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>
                                </td>
                                </tr>
                                <tr>
                                <td colspan="7"  style="width: 100%;">

                                    <!--post unchecked checkboxes-->
                                    <input type="hidden" name="comment<?php echo $j?>" value="">
                                    <input type="hidden" name="comment<?php echo $j + 1?>" value="">
                                    <input type="hidden" name="comment<?php echo $j + 2?>" value="">
                                    <input type="hidden" name="comment<?php echo $j + 3?>" value="">
                                    <input type="hidden" name="comment<?php echo $j + 4?>" value="">
                                    <input type="hidden" name="comment<?php echo $j + 5?>" value="">
                                    <input type="hidden" name="comment<?php echo $j + 6?>" value="">
                                    <input type="hidden" name="comment<?php echo $j + 7?>" value="">


                                    <!-- 
                                    pass each of the field values to survey_submit
                                    survey_submit then refer to each of the field names which is comment[iterator $j]
                                    -->
                                    <div>
                                        <ul >
                                            <li>
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Lighting" name="comment<?php echo $j?>" value="Lighting">
                                                <label for="Lighting"> Lighting</label><br>
                                            </li>
                                            <li>
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Computer" name="comment<?php echo $j + 1?>" value="Computer">
                                                <label for="Computer"> Computer</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Blackboards" name="comment<?php echo $j + 2?>" value="Blackboards">
                                                <label for="Blackboards"> Blackboards</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Projectors" name="comment<?php echo $j + 3?>" value="Projectors">
                                                <label for="Projectors"> Projectors</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Room Layout" name="comment<?php echo $j + 4?>" value="Room Layout">
                                                <label for="Room Layout"> Room Layout</label><br>                                         
                                             <li>
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Ventilation" name="comment<?php echo $j + 5?>" value="Ventilation">
                                                <label for="Ventilation"> Ventilation</label><br>                                  
                                             <li>
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Internet Connection" name="comment<?php echo $j + 6?>" value="Internet Connection">
                                                <label for="Internet Connection"> Internet Connection</label><br>                                   
                                            <li>
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="None" name="comment<?php echo $j + 7?>" value="None">
                                                <label for="None"> None</label><br>                            
                                            <li>
                                                <label for="Other">Other: </label><input id="Other" class="checkbox<?php echo $j?>" type="text" value=""name="comment<?php echo $j + 8?>"><br>
                                            </li>
                                        </ul>  
                                    </div>                            
                                </td>
                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
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

                <!-- tab for page 4-->
                <div class="tab" id="page4">

                    <!-- legend for the rating scores -->
                    <h3>II. Facilities and Infrastructure</h3>
                    <div class="legend-container" style="width: 100%">
                        <ul id="legend">
                          <li >1 - Needs Improvement</li>
                          <li>2 - Poor</li>
                          <li>3 - Satisfactory</li>
                          <li>4 - Good</li>
                          <li>5 - Excellent</li>
                          <li>N/A - Not Applicable</li>
                        </ul>  
                    </div>
                    <?php

                        //select the questions and its id from the questionnaire
                        $select4 = "select * from questionnaire";
                        $result4 = mysqli_query($conn,$select4);

                        
                        if(mysqli_num_rows($result4)>0){
                    ?>
                        <table cellspacing="0" style=" margin:auto; width: 90%">
                        <thead style="text-align: center;">
                            <tr>
                                <td colspan="7" style="text-align: left">How will you rate the following services provided by the following offices?</td>
                            </tr>
                            <tr>

                                <!-- table header containing the randomized choices -->
                                <th style="text-align: left">Facility</th>
                                <th width="30px">N/A</th>
                                <th width="30px">1</th>
                                <th width="30px">2</th>
                                <th width="30px">3</th>
                                <th width="30px">4</th>
                                <th width="30px">5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result4)){

                                //used as a reference to the question in the database
                                $i = $row['question_id'];

                                //select the questions having an id of 15 to 23
                                if($row['question_id'] > 15 && $row['question_id'] < 23 ){
                            ?>  

                            <!-- the order of table data in this row is deliberately altered each tab to randomize the choices-->
                            <tr class="question">

                                <!-- print the question -->
                                <td><?php echo $row['question_id'].". ".$row['question']?>

                                <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                <span name="rate<?php echo $i?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span></td>  

                                <!-- 
                                pass each of the field values to survey_submit
                                survey_submit then refer to each of the field names which is rate[question_id]
                                --> 
                                <td>
                                    <input type="radio" id="Zero" name="rate<?php echo $i?>" value="0" title="Not Applicable" required><label for="Zero"></label>
                                </td>
                                <td>
                                    <input type="radio" id="One" name="rate<?php echo $i?>" value="1"  title="Needs Improvement" required>
                                    <label for="One"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Two" name="rate<?php echo $i?>" value="2" title="Poor" required><label for="Two"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Three" name="rate<?php echo $i?>" value="3"  title="Satisfactory" required>
                                    <label for="Three"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Four" name="rate<?php echo $i?>" value="4"  title="Good" required>
                                    <label for="Four"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Five" name="rate<?php echo $i?>" value="5"  title="Excellent" required>
                                    <label for="Five"></label>
                                </td>
                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">

                            <?php
                                    }else
                                        continue;
                                 }   
                            }?>
                        </tbody>
                      </table>
                </div>

                <!-- tab for page 5-->
                <div class="tab" id="page5">

                    <!-- legend for the rating scores -->
                    <h3>II. Facilities and Infrastracture</h3>
                    <div class="legend-container" style="width: 100%">
                        <ul id="legend" >
                              <li >1 - Needs Improvement</li>
                              <li>2 - Poor</li>
                              <li>3 - Satisfactory</li>
                              <li>4 - Good</li>
                              <li>5 - Excellent</li>
                              <li>N/A - Not Applicable</li>
                        </ul>
                    </div>
                    <?php
                        //select the questions and its id from the questionnaire
                        $select5 = "select * from questionnaire";
                        $result5 = mysqli_query($conn,$select5);

                        
                        if(mysqli_num_rows($result5)>0){
                    ?>
                        <table cellspacing="0" style=" margin:auto; width: 90%">
                        <thead style="text-align: center;">
                            <tr>

                                <!-- table header containing the randomized choices -->
                                <th style="text-align: left">Facility</th>
                                <th width="30px">5</th>
                                <th width="30px">4</th>
                                <th width="30px">3</th>
                                <th width="30px">2</th>
                                <th width="30px">1</th>
                                <th width="30px">N/A</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result5)){

                                //used as a reference to the question in the database
                                $i = $row['question_id'];

                                //select the questions having an id of 23 to 28
                                if($row['question_id'] >= 23 && $row['question_id'] <= 28 ){
                            ?>  

                            <!-- the order of table data in this row is deliberately altered each tab to randomize the choices-->
                            <tr class="question">

                                <!-- print the question -->
                                <td><?php echo $row['question_id'].". ".$row['question']?>

                                <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                <span name="rate<?php echo $i?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span></td>

                                <!-- 
                                pass each of the field values to survey_submit
                                survey_submit then refer to each of the field names which is rate[question_id]
                                -->
                                <td>
                                    <input type="radio" id="Five" name="rate<?php echo $i?>" value="5"  title="Excellent" required>
                                    <label for="Five"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Four" name="rate<?php echo $i?>" value="4"  title="Good" required>
                                    <label for="Four"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Three" name="rate<?php echo $i?>" value="3"  title="Satisfactory" required>
                                    <label for="Three"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Two" name="rate<?php echo $i?>" value="2" title="Poor" required><label for="Two"></label>
                                </td>
                                <td>
                                    <input type="radio" id="One" name="rate<?php echo $i?>" value="1"  title="Needs Improvement" required>
                                    <label for="One"></label>
                                </td>
                                <td>
                                    <input type="radio" id="Zero" name="rate<?php echo $i?>" value="0" title="Not Applicable" required><label for="Zero"></label>
                                </td>
                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
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

                <!-- tab for page 6-->
                <div class="tab" id="page6">
                    <h3>III. Financial Assistance</h3>
                    <?php
                        //select the questions and its id from the questionnaire
                        $select6 = "select * from questionnaire";
                        $result6 = mysqli_query($conn,$select6);

                        
                        if(mysqli_num_rows($result6)>0){
                    ?>
                        <table cellspacing="0" style=" margin:auto; width: 90%">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="text-align: left">Question</th>
                                <th width="30px">Yes</th>
                                <th width="30px">No</th>
                                <th width="30px">N/A</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result6)){

                                //used as a reference to the question in the database
                                $i = $row['question_id'];

                                //select the questions having an id of 29 to 30
                                 if($row['question_id'] >= 29 && $row['question_id'] <= 30 ){
                            ?>  

                            <!-- the order of table data in this row is deliberately altered each tab to randomize the choices-->
                            <tr class="question">

                                <!-- print the question -->
                                <td><?php echo $row['question_id'].". ".$row['question']?>

                                <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                <span name="answer<?php echo $i?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span></td>

                                <!-- 
                                pass each of the field values to survey_submit
                                survey_submit then refer to each of the field names which is answer[question_id]
                                -->
                                <td>
                                    <input type="radio" id="Yes" title="Yes" name="answer<?php echo $i?>" value="Yes" required> 
                                </td>
                                <td>
                                    <input type="radio" id="No" title="No" name="answer<?php echo $i?>" value="No" required>
                                </td>
                                <td>
                                    <input type="radio" id="Not Applicable" title="Not Applicable" name="answer<?php echo $i?>" value="Not Applicable" required>
                                </td>

                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
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

                <!-- tab for page 7-->
                <div class="tab" id="page7">
                    <h3>IV. Events</h3>
                    <?php
                        //select the questions and its id from the questionnaire
                        $select7 = "select * from questionnaire";
                        $result7 = mysqli_query($conn,$select7);

                        //initiaze an interator j, this will be used to name the fields uniquely and
                        // to help survey_submit recognize which answers it has to read
                        $j = 11;
                        if(mysqli_num_rows($result7)>0){
                    ?>
                    <table cellspacing="0" style=" margin:auto; width: 90%">
                        <tbody>
                            <?php
                            while($row=mysqli_fetch_assoc($result7)){

                                //used as a reference to the question in the database
                                $i = $row['question_id'];

                                //select the questions having an id of 31
                                 if($row['question_id'] == 31) {
                            ?>
                                <tr>
                                <td>

                                    <!-- print the question -->
                                    <?php echo $row['question_id'].". ".$row['question']?>

                                    <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                    <span class="checkbox<?php echo $j?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>
                                </td>
                                </tr>

                                
                                <tr>
                                    <td>
                                    <div class="choices">
                                   
                                        <!-- post unchecked checkboxes -->
                                        <input type="hidden" name="comment<?php echo $j?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 1?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 2?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 3?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 4?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 5?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 6?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 7?>" value="">

                                        <!-- 
                                        pass each of the field values to survey_submit
                                        survey_submit then refer to each of the field names which is comment[iterator $j]
                                        -->
                                        <ul>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Pasiklaban" name="comment<?php echo $j?>" value="Pasiklaban">
                                                <label for="Pasiklaban"> Pasiklaban</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="CS Week" name="comment<?php echo $j + 1?>" value="CS Week">
                                                <label for="CS Week"> CS Week</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Knowledge Festival" name="comment<?php echo $j + 2?>" value="Knowledge Festival">
                                                <label for="Knowledge Festival"> Knowledge Festival</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Organization-led Quiz Bees" name="comment<?php echo $j + 3?>" value="Organization-led Quiz Bees">
                                                <label for="Organization-led Quiz Bees"> Organization-led Quiz Bees</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" class="checkbox<?php echo $j?>" type="checkbox" id="Intramurals" name="comment<?php echo $j + 4?>" value="Intramurals">
                                                <label for="Intramurals"> Intramurals</label><br>
                                            </li>
                                        </ul>
                                        <ul>
                                             <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Tagislakas" name="comment<?php echo $j + 5?>" value="Tagislakas">
                                                <label for="Tagislakas"> Tagislakas</label><br>      
                                            </li>
                            
                                             <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Salakniban" name="comment<?php echo $j + 6?>" value="Salakniban">
                                                <label for="Salakniban"> Salakniban</label><br>  
                                            </li>                                 
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="None" name="comment<?php echo $j + 7?>" value="None">
                                                <label for="None"> None</label><br>             
                                            </li>   
                                                <label for="Other">Other: </label><input id="Other" class="checkbox<?php echo $j?>" type="text" value=""name="comment<?php echo $j + 8?>"><br>
                                        </ul> 
                                    </div>
                                    </td>
                                </tr>


                                <!-- pass the question id to know which questions that have these answers -->
                                <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">

                            <?php

                            //select the questions having an id of 32
                            }elseif ($row['question_id'] == 32) {
                            ?>
                                <tr>
                                <td>

                                    <!-- print the question -->
                                    <?php echo $row['question_id'].". ".$row['question']?>

                                    <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                    <span class="checkbox<?php echo $j+1?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>
                                </td>
                                </tr>
                                <tr>
                                <td >
                                    <div class="choices" >

                                         <!--post unchecked checkboxes-->
                                            <input type="hidden" name="comment<?php echo $j + 9?>" value="">
                                            <input type="hidden" name="comment<?php echo $j + 10?>" value="">
                                            <input type="hidden" name="comment<?php echo $j + 11?>" value="">
                                         
                                            <!-- 
                                            pass each of the field values to survey_submit
                                            survey_submit then refer to each of the field names which is comment[iterator $j]
                                            -->
                                            <ul>
                                                <li>
                                                    <input class="checkbox<?php echo $j+1?>"  type="checkbox" id="Math-Physics Society" name="comment<?php echo $j + 9?>" value="Math-Physics Society">
                                                    <label for="Math-Physics Society"> Math-Physics Society</label>
                                                </li>
                                            </ul>
                                            <ul>
                                                <li>
                                                    <input class="checkbox<?php echo $j+1?>" type="checkbox" id="UP SIKAT" name="comment<?php echo $j + 10?>" value="UP SIKAT">
                                                    <label for="UP SIKAT"> UP SIKAT</label>
                                                </li>
                                            </ul>
                                            <ul>
                                                <li>
                                                    <input class="checkbox<?php echo $j+1?>" type="checkbox" id="ComSci@UP.BAG" name="comment<?php echo $j + 11?>" value="ComSci@UP.BAG">
                                                    <label for="ComSci@UP.BAG"> ComSci@UP.BAG</label>
                                                </li>
                                         </ul>
                                         <ul>
                                               <li>
                                                <input class="checkbox<?php echo $j+1?>" type="checkbox" id="None" name="comment<?php echo $j + 12?>" value="None">
                                                <label for="None"> None</label>
                                            </li>
                                         </ul>
                                    </div>                            
                                </td>
                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">

                           <?php

                           //select the questions having an id of 33
                            }elseif ($row['question_id'] == 33) {
                            ?>
                            <tr>
                               <td colspan="7"  style="width: 100%;">

                                     <!-- print the question -->
                                    <?php echo $row['question_id'].". ".$row['question']?> 

                                    <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                    <span name="comment<?php  echo $i?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>

                                 <!-- 
                                pass the value of the text field to survey_submit
                                survey_submit then refer to the field name which is comment[iterator $j]
                                -->
                                   <textarea style="margin-bottom: 10px" class="textarea" type="text" width="100%" name="comment<?php  echo $i?>" required></textarea>
                                </td>
                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">

                            <?php
                                    }   
                                }
                            }
                            ?>
                        </tbody>
                     </table>
                </div>

                <!-- tab for page 8-->
                <div  class="tab" id="page8">
                    <h3>IV. Events</h3>
                    
                    <table cellspacing="0" style=" margin:auto; width: 90%">
                    <?php

                        //select the questions and its id from the questionnaire
                        $select8 = "select * from questionnaire";
                        $result8 = mysqli_query($conn,$select8);

                        //initiaze an interator j, this will be used to name the fields uniquely and
                        // to help survey_submit recognize which answers it has to read
                        $j = 24;

                        if(mysqli_num_rows($result8)>0){
                            while($row=mysqli_fetch_assoc($result8)){

                                //used as a reference to the question in the database
                                $i = $row['question_id'];

                                //select the questions having an id of 34
                                if($row['question_id'] == 34) {
                            ?>
                                <tr>
                                <td>

                                    <!-- print the question -->
                                    <?php echo $row['question_id'].". ".$row['question']?>

                                    <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                    <span class="checkbox<?php echo $j?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>
                                </td>
                                </tr>
                                <tr>
                                    <td>
                                    <div>

                                       <!--post unchecked checkboxes-->
                                        <input type="hidden" name="comment<?php echo $j?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 1?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 2?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 3?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 4?>" value="">
                                        <input type="hidden" name="comment<?php echo $j + 5?>" value="">

                                        <!-- 
                                        pass each of the field values to survey_submit
                                        survey_submit then refer to each of the field names which is comment[iterator $j]
                                        -->
                                        <ul>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Scientific Research" name="comment<?php echo $j?>" value="Scientific Research">
                                                <label for="Scientific Research"> Scientific Research</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Graduate School" name="comment<?php echo $j + 1?>" value="Graduate School">
                                                <label for="Graduate School"> Graduate School</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Teaching" name="comment<?php echo $j + 2?>" value="Teaching">
                                                <label for="Teaching"> Teaching</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="NGO" name="comment<?php echo $j + 3?>" value="NGO">
                                                <label for="NGO"> NGO</label><br>
                                            </li>
                                            <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Government" name="comment<?php echo $j + 4?>" value="Government">
                                                <label for="Government"> Government</label><br>
                                            </li>
                                             <li >
                                                <input class="checkbox<?php echo $j?>" type="checkbox" id="Private Sector" name="comment<?php echo $j + 5?>" value="Private Sector">
                                                <label for="Private Sector"> Private Sector (bank and finance, data science, actuarial, insurance, etc.</label><br>
                                            </li>
                                                <label for="Other">Other: </label><input id="Other" class="checkbox<?php echo $j?>" value="" type="text" name="comment<?php echo $j + 6?>"><br>
                                        </ul> 
                                    </div>
                                    </td>
                                </tr>

                                 <!-- pass the question id to know which questions that have these answers -->
                                <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                        </table>
                        <table cellspacing="0" style=" margin:auto; width: 90%">
                            <?php

                                //select the questions having an id of 35
                                }elseif($row['question_id'] == 35) {
                            ?>
                             <thead style="text-align: center; margin-top: 10px">
                            <tr>
                                <th style="text-align: left">Question</th>
                                <th width="30px">Yes</th>
                                <th width="30px">No</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <!-- print the question -->
                                <td><?php echo $row['question_id'].". ".$row['question']?>

                                <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                <span name="answer<?php echo $i?>" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span></td>

                                <!-- 
                                pass each of the field values to survey_submit
                                survey_submit then refer to each of the field names which is answer[question_id]
                                -->
                                <td>
                                    <input type="radio" id="Yes" title="Yes" name="answer<?php echo $i?>" value="Yes" required> 
                                </td>
                                <td>
                                    <input type="radio" id="No" title="No" name="answer<?php echo $i?>" value="No" required>
                                </td>

                            </tr>

                            <!-- pass the question id to know which questions that have these answers -->
                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                                
                            <?php
                                    }   
                                }
                            }
                            ?>
                        </tbody>
                     </table>
                </div>
                    
                <!-- tab for page 9-->
               <div class="tab" id="page9">
                <h3>V. Consent for a follow-up interview</h3>
                    
                    <table cellspacing="0" style=" margin:auto; width: 90%">
                    <?php

                        //select the questions and its id from the questionnaire
                        $select9 = "select * from questionnaire";
                        $result9 = mysqli_query($conn,$select9);

                        
                        if(mysqli_num_rows($result9)>0){
                            while($row=mysqli_fetch_assoc($result9)){

                                //used as a reference to the question in the database
                                $i = $row['question_id'];

                                //select the questions having an id of 36
                                if($row['question_id'] == 36) {
                            
                            ?>
                             <thead style="text-align: center;">
                            <tr>
                                <th rowspan="2" style="text-align: left">Question</th>
                                <th width="30px">Yes</th>
                                <th width="30px">No</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div>
                                <tr>

                                    <!-- print the question -->
                                    <td><?php echo $row['question_id'].". ".$row['question']?>

                                    <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                    <span name="polar" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span></td>

                                    <!-- 
                                    pass the selected value to survey_submit
                                    survey_submit then refer field name of the answer which is "polar"
                                    -->
                                    <td>
                                        <input type="radio" id="Yes" name="polar" value="Yes" required> 
                                    </td>
                                    <td>
                                        <input type="radio" id="No" name="polar" value="No" required>
                                    </td>

                                    <!-- pass the question id to know which questions that have these answers -->
                                    <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                                </tr>
                            </div>
                        </tbody>
                    </table>

                            <div style="display: none;" id="div_contact">
                                <table cellspacing="0" style=" margin:auto; width: 90%">
                                <tr>
                                    <!-- print the question -->
                                    <td><label for="contact">What would be the best way?</label>

                                    <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                    <span name="means" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <ul>
                                                
                                                    <!-- 
                                                    pass the selected value to survey_submit
                                                    survey_submit then refer to name of the answer which is "means"
                                                    -->
                                                    <li>
                                                        <label class="radio">
                                                        <input type="radio" class="optional" id="contact" name="means" value="Email" >Email
                                                        </label>
                                                    </li>
                                                
                                                    <li>
                                                        <label class="radio">
                                                        <input type="radio" class="optional" id="contact" name="means" value="Snail Mail">Snail Mail
                                                        </label>
                                                    </li>
                                                
                                           
                                                    <li>
                                                        <label class="radio">
                                                        <input type="radio" class="optional" id="contact" name="means" value="Mobile Phone" >Mobile Phone
                                                        </label>
                                                    </li>
                                                

                                                
                                                    <li>
                                                        <label class="radio">
                                                        <input type="radio" class="optional" id="contact" name="means" value="Facebook">Facebook
                                                        </label>
                                                    </li>
                                                
                                                <li>
                                                    <label>Other: 
                                                    <input type="text" class="optional" id="contact" name="other-contact" value="">
                                                    </label>
                                                </li>
                                            </ul>
                                        
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <!-- print the question -->
                                        <label for="contact_details">Please provide your contact details: </label>

                                        <!-- show an error if the user tries to go to the next tab and some of the questions were not answered yet-->
                                        <span name="contact_details" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>

                                        <!-- 
                                        pass the value of the text field to survey_submit
                                        survey_submit then refer to its name which is "contact_details"
                                        -->
                                        <input type="text" class="optional" id="contact_details" name="contact_details" value="" style="width: 99%; margin-bottom: 10px"></input>
                                    </td>
                                </tr>

                                </table>
                            </div>


                            
                            <!-- pass the question id to know which questions that have these answers -->
                            <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">
                                
                        <?php
                                //select the questions having an id of 37
                                }elseif ($row['question_id'] == 37){
                        ?>

                       <div>
                            <table style=" margin:auto; width: 90%">
                            <tr>
                                <td>
                                    <!-- print the question -->
                                    <label for="comment"><?php echo $row['question_id'].". Please feel free to leave your comments and suggestions below."?></label>
                                        <span name="comment" style="color: red; font-size: 15px; display: none">&nbsp;<i id="exclamation" title="This is a required question" class="fa fa-exclamation-circle"></i></span>


                                    <textarea class="textarea" name="comment"> </textarea>
                                </td>
                            </tr>
                            </table>
                        </div>

                        <!-- pass the question id to know which questions that have these answers -->
                        <input type="hidden" name="question_id<?php echo $i?>" value="<?php echo $i?>">                        
                        <input type="hidden" name="bool" value="<?php echo TRUE?>">
                        
                        </tbody>
                     </table>

                    
                </div>

            <!-- container for the loading animation -->
            <div class="tab" id="loading-page">
                <div style="margin: auto; padding: 30px; width: 110px"><div class="loader" style="width: 80px; height: 80px;"></div></div>
            </div>    

            <div style="overflow:auto;" id="nextprevious">
              <div class="bg-light clearfix">
                  <button type="button" class="pull-right" id="submit-btn" title="Submit" style="display: none;" onclick="nextPrev(1)"><i class="fa fa-angle-double-right"></i></button>
                  <button type="button" class="pull-right" id="nextBtn" title="Next" onclick="nextPrev(1)"><i class="fa fa-angle-double-right"></i></button> 
                <button type="button" class="pull-right" id="prevBtn" onclick="nextPrev(-1)" style="margin-right: 5px"><i class="fa fa-angle-double-left"></i></button>
               

               <!-- submit Modal -->
                    <div id="submitModal" class="modal" name="Sign-out modal">
                      <!-- modal content -->
                      <div class="modal-content" style="width: 30%; height: auto; padding: 20px">
                        <span class="close" id="close-submit">&times;</span>
                        <div align="center" width="100%">
                            <h3 style="font-size: 20px; font-weight: bolder">Submit</h3>
                                <div class="file-picker-container">
                                    <p>Once you submit, you can't go back and edit your response. Do you wish to submit your response?</p>
                                </div>

                            <!-- confirmation buttons -->
                            <button type="submit" class="submit-button" id="normal-btn" style="width:80px" title="Submit" onclick="nextPrev(1)">Submit</button>
                            <span class="btn btn-secondary" id="cancel-submit">Cancel</span>
                        
                        </div>
                      </div>
                    </div>

              </div>
            </div>

             <?php
                            }

                        //close the connection
                         }mysqli_close($conn);
                    }
             ?>

          </form>
        </div>
      </div>
    </div>
  </body>

  <script>

  	// Initialize survey page number to 0
    var currentTab = 0;

    document.addEventListener("DOMContentLoaded", function(event) {
      showTab(currentTab);
    });
    // Function to show current page on survey
    function showTab(n) {
      var x = document.getElementsByClassName("tab");
      x[n].style.display = "block";
      // If survey is on first page, hide previous page button
      if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
      } else {
        document.getElementById("prevBtn").style.display = "inline";
     
      }
      if (n == (x.length - 1)) { 
        document.getElementById("nextBtn").innerHTML = '<i class="fa fa-angle-double-right"></i>';
      } else {  
        document.getElementById("nextBtn").innerHTML = '<i class="fa fa-angle-double-right"></i>';
      }
      fixStepIndicator(n)
    }
    // Function to show previous page on survey
    function nextPrev(n) {
      var x = document.getElementsByClassName("tab");
      if (n == 1 && !validateForm()) return false;
      x[currentTab].style.display = "none";
      currentTab = currentTab + n;
      // If respondent reaches the last page, replace the 'next page' button with the 'submit' button.
      if (currentTab == x.length-2) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("submit-btn").style.display = "block";
      // Else, show next button and hide submit button.
      } else { 
        document.getElementById("nextBtn").style.display = "block";
        document.getElementById("submit-btn").style.display = "none";
      }
       showTab(currentTab);
    }
    // Function to validate the respondent's inputs on the current page before moving to the one.
    function validateForm() {
        var v, w, x, y, i, j, ctr = 0, ctrChk = 0, valid = true, answered;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        z = x[currentTab].getElementsByTagName("textarea");
        // This loop validates the ff types of responses: radio buttons, checkboxes & user-specified option ("other:____" field)
        for (i = 0; i < y.length; i++) {
        	// Assume temporarily that none of the radio buttons are selected
                answered = false;
            // Validate required radio button-type of responses
            if (y[i].type=="radio" && y[i].className != "optional") {
            	// Check if question is optional but the respondent agreed to answer & therefore has been classified as non-optional and must be validated
                if (y[i].className == "non-optional") {
                	// If the above is true, then proceed to check the radio buttons and the "other:___" field
                    v = x[currentTab].getElementsByClassName("non-optional");
                    other = document.getElementsByName("other-contact")[0];
                    // First check if the "other:___" field has an input. If yes, then the respondent has properly answered the question.
                    if (other.value != "") answered = true;	
                    // Proceed to check if one among the group of radio buttons has been checked by the user. If yes, then the respondent has properly answered the question.
                    for (j = 0; j < v.length; j++) if(v[j].checked) answered = true;		
                // If not, then the group of radio buttons belong to a "required" question which must be validated
                }else { // Proceed to check if one among the group of radio buttons has been checked by the respondent. If yes, then the respondent has properly answered the question.
                    v = document.getElementsByName(y[i].name);
                    for (j = 0; j < v.length; j++) if(v[j].checked) answered = true;
                }
                if (!answered){ // If question is not answered
                        valid = false; // Then current question has no valid response.
                        $("span[name="+y[i].name+"]").css("display","inline-block"); // // Show the (!) sign next to the unanswered question.
                    }else // If question is answered
                    	$("span[name="+y[i].name+"]").css("display","none"); // Hide the (!) sign next to the question
            }
            // Validate required checkbox-type of responses
            if (y[i].type=="checkbox") {
        		// Assume temporarily that the checkbox's group is not accompanied by an "other:___" field
                var hasOther = false;
                // Get group of checkboxes
                var t = y[i].className;
                // Get group of checkboxes and the accompanying "other:___" field (if it exists)
                var u = x[currentTab].getElementsByClassName(t);
                // Verify if at least one among the group of checkboxes has been checked.
                checked = $(" input[class="+t+"]:checked ").length; 
                // Check for "other:___" field.
                for (j = 0; j < u.length; j++) {
                    if (u[j].id=="Other") {
                        var answered2 = u[j].value;
                        hasOther = true;
                    }
                }
                // If there is an "other:___" field,
                if (hasOther) { 
                	// then if no checkboxes are selected and "other:___" field is empty,
                    if(!checked && answered2 =="") { 
                    	valid = false; // then the current question has no valid response.
                        $("span[class="+t+"]").css("display","inline-block"); // Show the (!) sign next to the unanswered question.
                    }else // Else, then at least one of the 2 conditions is true. Hence, a valid response has been given.
                    	$("span[class="+t+"]").css("display","none"); // Hide the (!) sign next to the unanswered question
                // // If there is no "other:___" field,
                }else {
                	//Check if no checkboxes are selected,
                    if(!checked) { 
                       valid = false;// then the current question has no valid response.
                       $("span[class="+t+"]").css("display","inline-block"); // Show the (!) sign next to the unanswered question.
                    }else // Else, then at least one of the 2 conditions is true. Hence, a valid response has been given.
                    	$("span[class="+t+"]").css("display","none"); // Hide the (!) sign next to the question.
                }
            }
            // Validate input for contact details if respondent agreed to answer.
            if (y[i].className == "non-optional" && y[i].name=="contact_details"){
                 //Check if no checkboxes are selected,
                 if(y[i].value == ""){
                 	// then the current question has no valid response.
                    valid = false; 
                    // Show the (!) sign next to the unanswered question.
                    $("span[name="+y[i].name+"]").css("display","inline-block"); 
                       $("span[class="+t+"]").css("display","inline-block"); 
                // if not, then the field has a valid input    
                }else 
                	// Hide the (!) sign next to the question.
                	$("span[name="+y[i].name+"]").css("display","none");
            }

        } 
         // This loop validates responses to required open-ended questions. Each input is enclosed in a textarea field.
        for (j = 0; j < z.length; j++) {
        	// Check if question is not optional
             if (z[j].id != "Other" && z[j].id != "optional") {
             	// Check if field is empty.  
                if (z[j].value=="") {
                	// if yes, then question has no valid response.
                    z[j].className +=" invalid" ;
                    valid=false;
                    // Show the (!) sign next to the unanswered question.
                    $("span[name="+z[j].name+"]").css("display","inline-block");
                }
            }else // Else, then at least one of the 2 conditions is true. Hence, a valid response has been given.
            	// Hide the (!) sign next to the question.
            	$("span[name="+z[j].name+"]").css("display","none");
        } 

	      // If respondent reaches the last page, replace the 'next page' button with the 'submit' button.
	      if (currentTab == x.length-2) {
	        document.getElementById("nextBtn").style.display = "none";
	        document.getElementById("submit-btn").style.display = "block";
	      // Else, show next button and hide submit button.
	      } else { 
	        document.getElementById("nextBtn").style.display = "block";
	        document.getElementById("submit-btn").style.display = "none";
	      }

	// Function for checking the trigger for answering optional questions.
    $( document ).ready(function() {
                    
        //Wrappers for all fields
        var polar = $('#regForm input:radio[name="polar"]');
        var contact = $('#regForm input:radio[name="means"] input:text[name="other"]');

        var contact_parent = $('#regForm #div_contact');
        
        // function to change optional questions to non-optional so they can be included for input validation, and vice versa
        polar.change(function(){
            var value = this.value;                     
            contact_parent.hide();
            $(".non-optional").attr('class', 'optional');
            
            if (value == 'Yes'){
                contact_parent.show();
                $(".optional").attr('class', 'non-optional');
            }
        }); 

    });
   	// If the valid flag is true, then respondent can proceed to the next step.
    if (valid) {
        document.getElementsByClassName("step")[currentTab].className +=" finish" ;
    } return valid; 
    }

    // Function that updates the step indicator (a.k.a the progress bar) as the respondent navigates from one step to another.
    function fixStepIndicator(n) {
        var i, x=document.getElementsByClassName("step");
        for (i=0; i < x.length; i++) { 
            x[i].className=x[i].className.replace(" active", "" );
         } 
         x[n].className +=" active" ;
     }
     

    //SIGN OUT MODAL
     // Get the modal
    var signOut_modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Get the <button> element that cancels the sign out
    var cancel = document.getElementsByClassName("btn btn-secondary")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
      signOut_modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      signOut_modal.style.display = "none";
    }

     // When the user clicks on cancel, close the modal
    cancel.onclick = function() {
      signOut_modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == signOut_modal) {
        signOut_modal.style.display = "none";
      }
    }


    // SUBMIT MODAL
      // Get the submit modal
    var submit_modal = document.getElementById("submitModal");

    // Get the button that opens the modal
    var btn = document.getElementById("submit-btn");

    // Get the <span> element that closes the modal
    var span = document.getElementById("close-submit");

    // Get the <button> element that cancels the sign out
    var cancel = document.getElementById("cancel-submit");

    var submitButton = document.getElementsByClassName("submit-button")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        if (validateForm()) {
            submit_modal.style.display = "block";
        }
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      submit_modal.style.display = "none";
    }

     // When the user clicks on cancel, close the modal
    cancel.onclick = function() {
      submit_modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == submit_modal) {
        submit_modal.style.display = "none";
      }
    }
    // When the user confirms to submit the responses, close the modal.
    submitButton.onclick = function() {
        submit_modal.style.display = "none";
    }


</script>

</html>
