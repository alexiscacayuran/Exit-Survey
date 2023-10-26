<html>
<style>

table, th, td{
	border: 1px solid maroon;
}

body{
    font-family: 'Calibri', sans-serif;
}

</style>

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

            if($_SESSION['gatekeep1']!=FALSE){
                exit('Direct access denied!');
            }
//File name of the file to be downloaded         
$file_name = 'Total_Tally_' . time() . '.xls';
    
//function that indicates that the following content will be downloaded
 header("Content-Disposition: attachment; filename=" . basename($file_name)); 			
 header("Content-Type: application/vnd.ms-excel");

date_default_timezone_set("Asia/Hong_Kong");

$date = date(DATE_RSS);

//Below this comment is the content of the file to be downloaded
?>

 <div align="center" width="100%" class="header">
    <h3 style="font-size: 16px">DMCS Exit Survey</h1>
 </div>

 <div align="center" width="100%" class="header">
    <h1>Total Tally as of <?php echo $date?></h1>
 </div>

    <div align="center" width="100%" class="header">
        <h3>Rating</h3>
    </div>




    <table width="100%" style="margin-top: 15px" cellspacing="0">
    <thead class="head">
    <tr>
        <th align="center" style="font-weight: bold; width: 50%; background-color: white">Questions</th>
        <th width="100%" style="background-color: white">
            <table style="font-weight: bold">
                <tr align="center">
                    <td>Not Applicable</td>
                    <td>Needs Improvement</td>
                    <td>Poor</td>
                    <td>Satisfactory</td>
                    <td>Good</td>
                    <td>Excellent</td>
                    
                </tr>
            </table>
        </th>
    </tr>
    </thead>
      

    
    <tr>
        <td colspan="2" style="font-weight: bold; "><p style="margin: 20px 0px 0px 0px">Degree Program</p></td>
    </tr> 
    
    <tbody>
                       
                            
    <?php
    //Here is the long function that gathers all the total tally for the rating part
    $select1 = "SELECT question_id, question, rateable FROM questionnaire";
    $result1 = mysqli_query($conn,$select1);

    
    

        if(mysqli_num_rows($result1)>0){
			while($row=mysqli_fetch_assoc($result1)){
                if ($row['rateable'] == 'True' && $row['question_id'] <= 11) {

                    $q_id = $row['question_id'];

                    $count11 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '1'";
                    $count_result11 = mysqli_query($conn,$count11);

                    $count12 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '2'";
                    $count_result12 = mysqli_query($conn,$count12);

                    $count13 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '3'";
                    $count_result13 = mysqli_query($conn,$count13);

                    $count14 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '4'";
                    $count_result14 = mysqli_query($conn,$count14);

                    $count15 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '5'";
                    $count_result15 = mysqli_query($conn,$count15);
        ?>  
                   
                <tr>
                    <td style="width: 400px;"><?php echo $row['question']?></td>
                    <td>
                    <table width="100%">
                    <tr align="center">
                        <td>X</td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result11)>0){
                                while($row = mysqli_fetch_assoc($count_result11)) {
                                    echo $row['score'];

                                    $score = $row['score'];



                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result12)>0){
                                while($row = mysqli_fetch_assoc($count_result12)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result13)>0){
                                while($row = mysqli_fetch_assoc($count_result13)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result14)>0){
                                while($row = mysqli_fetch_assoc($count_result14)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result15)>0){
                                while($row = mysqli_fetch_assoc($count_result15)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        


                    </tr>
                    </table>
                    </td>
                </tr>
                
		<?php
                }
			}
		}?>

 
    <tr>
        <td colspan="2" style="font-weight: bold; width: 400px"><p style="margin: 20px 0px 0px 0px">Facilities and Infrastructure</p></td>
    </tr>
       

<?php

    $select2 = "SELECT question_id, question, rateable FROM questionnaire";
    $result2 = mysqli_query($conn,$select2);

    
    

        if(mysqli_num_rows($result2)>0){
            while($row=mysqli_fetch_assoc($result2)){
                if ($row['rateable'] == 'True' && $row['question_id'] >= 12 && $row['question_id'] <= 15) {

                    $q_id = $row['question_id'];

                    $count21 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '1'";
                    $count_result21 = mysqli_query($conn,$count21);

                    $count22 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '2'";
                    $count_result22 = mysqli_query($conn,$count22);

                    $count23 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '3'";
                    $count_result23 = mysqli_query($conn,$count23);

                    $count24 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '4'";
                    $count_result24 = mysqli_query($conn,$count24);

                    $count25 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '5'";
                    $count_result25 = mysqli_query($conn,$count25);


   
        ?>  
                    
                <tr>
                    <td style="width: 400px;"><?php echo $row['question']?></td>
                    <td>
                    <table width="100%">
                    <tr align="center">
                        <td>X</td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result21)>0){
                                while($row = mysqli_fetch_assoc($count_result21)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result22)>0){
                                while($row = mysqli_fetch_assoc($count_result22)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result23)>0){
                                while($row = mysqli_fetch_assoc($count_result23)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result24)>0){
                                while($row = mysqli_fetch_assoc($count_result24)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result25)>0){
                                while($row = mysqli_fetch_assoc($count_result25)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>


                    </tr>
                    </table>
                    </td>
                </tr>
                
        <?php
                }
            }
        }?>


    
    <tr>
        <td colspan="2"><p style="margin: 20px 0px 0px 0px">How will you rate the following services provided by the following offices?</p></td>
    </tr>
    

<?php

    $select3 = "SELECT question_id, question, rateable FROM questionnaire";
    $result3 = mysqli_query($conn,$select3);

    
        if(mysqli_num_rows($result3)>0){
            while($row=mysqli_fetch_assoc($result3)){
                if ($row['rateable'] == 'True' && $row['question_id'] >= 16 && $row['question_id'] <= 28) {

                    $q_id = $row['question_id'];

                    $count30 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '0'";
                    $count_result30 = mysqli_query($conn,$count30);

                    $count31 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '1'";
                    $count_result31 = mysqli_query($conn,$count31);

                    $count32 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '2'";
                    $count_result32 = mysqli_query($conn,$count32);

                    $count33 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '3'";
                    $count_result33 = mysqli_query($conn,$count33);

                    $count34 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '4'";
                    $count_result34 = mysqli_query($conn,$count34);

                    $count35 = "SELECT COUNT(DISTINCT id) as score FROM rating WHERE question_id = '$q_id' AND rate = '5'";
                    $count_result35 = mysqli_query($conn,$count35);


   
        ?>  
                    
                <tr>
                    <td style="width: 400px;"><?php echo $row['question']?></td>
                    <td>
                    <table width="100%">
                    <tr align="center">
                        <td>
                            <?php
                            if(mysqli_num_rows($count_result30)>0){
                                while($row = mysqli_fetch_assoc($count_result30)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result31)>0){
                                while($row = mysqli_fetch_assoc($count_result31)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result32)>0){
                                while($row = mysqli_fetch_assoc($count_result32)) {
                                    echo $row['score'];

                                    $score = $row['score'];

                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result33)>0){
                                while($row = mysqli_fetch_assoc($count_result33)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result34)>0){
                                while($row = mysqli_fetch_assoc($count_result34)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>

                        <td>
                            <?php
                            if(mysqli_num_rows($count_result35)>0){
                                while($row = mysqli_fetch_assoc($count_result35)) {
                                    echo $row['score'];

                                    $score = $row['score'];


                                }
                            }
                             ?>
                                 
                        </td>


                    </tr>
                    </table>
                    </td>
                </tr>
                
        <?php
                }
            }
        }
    ?>
            </tbody>
        </table>














 <div align="center" width="100%" class="header">
        <h3>Suggestion/Opinion</h3>
 </div>

   <table width="100%" style="margin-top: 15px">
    <tr>
        <td colspan="7" style="font-weight: bold; ">Degree Program</td>
    </tr> 
    </table>

    <?php
    //From this starts the Suggestion/Opinion/Comment part of the file to be downloaded
    $select4 = "SELECT question_id, question, rateable FROM questionnaire";
    $result4 = mysqli_query($conn,$select4);

        if(mysqli_num_rows($result4)>0){
            while($row=mysqli_fetch_assoc($result4)){
                if ($row['rateable'] == 'False' && $row['question_id'] <= 11) {

                    $q_id = $row['question_id'];


                    $answer4 = "SELECT demographics.full_name, demographics.up_mail, suggestion.comments 
                    FROM demographics NATURAL JOIN suggestion
                    WHERE (demographics.id = suggestion.id) AND suggestion.question_id ='$q_id'";
                    $answer_result4 = mysqli_query($conn,$answer4);
                    
    ?>

        <table width="100%">
            <tr>
                <td colspan="7"><?php echo $row['question']?></td>
            </tr>
            <tr>
                <td colspan="7" style="padding: 10px">
                    <div class="list">                    
                        <ul>
                        <?php

                        $i = 1;
                        if(mysqli_num_rows($answer_result4)>0){
                             while($row = mysqli_fetch_assoc($answer_result4)) {
                        ?>
                        <li> 
                            <table width="100%">
                                <tr>
                                    <td valign="top" style="width: 400px">
                                        <?php
                                        echo $i.". ";

                                        if ($row['full_name'] == null) {
                                            echo $row['up_mail'];
                                        }else{
                                            echo $row['full_name']; }
                                        ?> 
                                    </td>
                                    <td colspan="6"><?php echo $row['comments'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
                            $i++;
                            }
                        }
                        ?>
                    </ul>
                    </div>
                </td>
            </tr>
    <?php 
                }
            }
        }
    ?>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td style="font-weight: bold; ">Facilities and Infrastructure</td>
    </tr> 
    </table>

     <?php
        $select4 = "SELECT question_id, question, rateable FROM questionnaire";
        $result4 = mysqli_query($conn,$select4);

        if(mysqli_num_rows($result4)>0){
            while($row=mysqli_fetch_assoc($result4)){
                if ($row['rateable'] == 'False' && $row['question_id'] == 15) {

                    $q_id = $row['question_id'];


                    $answer5 = "SELECT demographics.full_name, demographics.up_mail, suggestion.comments 
                    FROM demographics NATURAL JOIN suggestion
                    WHERE (demographics.id = suggestion.id) AND suggestion.question_id ='$q_id'";
                    $answer_result5 = mysqli_query($conn,$answer5);
                    
    ?>

        <table width="100%">
            <tr>
                <td colspan="7"><?php echo $row['question']?></td>
            <tr>
                <td colspan="7" style="padding: 10px">
                    <div class="list">   
                    <ul>
                        <?php

                        $i = 1;

                        if(mysqli_num_rows($answer_result5)>0){
                             while($row = mysqli_fetch_assoc($answer_result5)) {
                        ?>
                        <li> 
                            <table width="100%">
                                <tr>
                                    <td valign="top"style="width: 400px">
                                        <?php
                                        echo $i.". ";
                                        if ($row['full_name'] == null) {
                                            echo $row['up_mail'];
                                        }else{
                                            echo $row['full_name']; }
                                        ?> 
                                    </td>
                                    <td colspan="6"><?php echo $row['comments'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
                            $i++;
                            }
                        }
                        ?>
                    </ul>
                    </div>
                </td>
            </tr>
    <?php 
                }
            }
        }
    ?>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td colspan="7" style="font-weight: bold; ">Financial Aid</td>
    </tr> 
    </table>

     <?php

        $select4 = "SELECT question_id, question, rateable FROM questionnaire";
        $result4 = mysqli_query($conn,$select4);

        if(mysqli_num_rows($result4)>0){
            while($row=mysqli_fetch_assoc($result4)){
                if ($row['rateable'] == 'False' && $row['question_id'] >= 29 && $row['question_id'] <=30) {

                    $q_id = $row['question_id'];


                    $answer6 = "SELECT demographics.full_name, demographics.up_mail, polar.answers 
                    FROM demographics NATURAL JOIN polar
                    WHERE (demographics.id = polar.id) AND polar.question_id ='$q_id'";
                    $answer_result6 = mysqli_query($conn,$answer6);
                    
    ?>

        <table width="100%">
            <tr>
                <td colspan="7"><?php echo $row['question']?></td>
            <tr>
                <td colspan="7" style="padding: 10px">
                    <div class="list"> 
                    <ul>
                        <?php
                        $i = 1;

                        if(mysqli_num_rows($answer_result6)>0){
                             while($row = mysqli_fetch_assoc($answer_result6)) {
                        ?>
                        <li> 
                            <table width="100%">
                                <tr>
                                    <td valign="top"style="width: 400px">
                                        <?php
                                        echo $i.". ";
                                        if ($row['full_name'] == null) {
                                            echo $row['up_mail'];
                                        }else{
                                            echo $row['full_name']; }
                                        ?> 
                                    </td>
                                    <td colspan="6"><?php echo $row['answers'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
                            $i++;
                            }
                        }
                        ?>
                    </ul>
                    </div>
                </td>
            </tr>
    <?php 
                }
            }
        }
    ?>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td style="font-weight: bold; ">Events</td>
    </tr> 
    </table>

     <?php

        $select4 = "SELECT question_id, question, rateable FROM questionnaire";
        $result4 = mysqli_query($conn,$select4);

        if(mysqli_num_rows($result4)>0){
            while($row=mysqli_fetch_assoc($result4)){
                if ($row['rateable'] == 'False' && $row['question_id'] >= 31 && $row['question_id'] <=33) {

                    $q_id = $row['question_id'];


                    $answer7 = "SELECT demographics.full_name, demographics.up_mail, suggestion.comments 
                    FROM demographics NATURAL JOIN suggestion
                    WHERE (demographics.id = suggestion.id) AND suggestion.question_id ='$q_id'";
                    $answer_result7 = mysqli_query($conn,$answer7);
                    
    ?>

        <table width="100%">
            <tr>
                <td colspan="7"><?php echo $row['question']?></td>
            <tr>
                <td colspan="7" style="padding: 10px">
                    <div class="list">
                    <ul>
                        <?php
                        $i = 1;
                        if(mysqli_num_rows($answer_result7)>0){
                             while($row = mysqli_fetch_assoc($answer_result7)) {
                        ?>
                        <li> 
                            <table width="100%">
                                <tr>
                                    <td valign="top"style="width: 400px">
                                        <?php
                                        echo $i.". ";
                                        if ($row['full_name'] == null) {
                                            echo $row['up_mail'];
                                        }else{
                                            echo $row['full_name']; }
                                        ?> 
                                    </td>
                                    <td colspan="6"><?php echo $row['comments'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
                            $i++;
                            }
                        }
                        ?>
                    </ul>
                    </div>
                </td>
            </tr>
        </table>
    <?php 
                }
            }
        }
    ?>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td colspan="7" style="font-weight: bold; ">Career Plans</td>
    </tr> 
    </table>

     <?php

        $select4 = "SELECT question_id, question, rateable FROM questionnaire";
        $result4 = mysqli_query($conn,$select4);

        if(mysqli_num_rows($result4)>0){
            while($row=mysqli_fetch_assoc($result4)){
                if ($row['rateable'] == 'False' && $row['question_id'] == 34) {

                    $q_id = $row['question_id'];


                    $answer8 = "SELECT demographics.full_name, demographics.up_mail, suggestion.comments 
                    FROM demographics NATURAL JOIN suggestion
                    WHERE (demographics.id = suggestion.id) AND suggestion.question_id ='$q_id'";
                    $answer_result8 = mysqli_query($conn,$answer8);
                    
    ?>

        <table width="100%">
            <tr>
                <td colspan="7"><?php echo $row['question']?></td>
            <tr>
                <td colspan="7" style="padding: 10px">
                    <div class="list">  
                    <ul>
                        <?php
                        $i = 1;
                        if(mysqli_num_rows($answer_result8)>0){
                             while($row = mysqli_fetch_assoc($answer_result8)) {
                        ?>
                        <li> 
                            <table width="100%">
                                <tr>
                                    <td valign="top"style="width: 400px">
                                        <?php
                                        echo $i.". ";
                                        if ($row['full_name'] == null) {
                                            echo $row['up_mail'];
                                        }else{
                                            echo $row['full_name']; }
                                        ?> 
                                    </td>
                                    <td colspan="6"><?php echo $row['comments'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
                            $i++;
                            }
                        }
                        ?>
                    </ul>
                    </div>
                </td>
            </tr>
    <?php 
                }elseif ($row['rateable'] == 'False' && $row['question_id'] == 35) {

                    $q_id = $row['question_id'];

                    $answer9 = "SELECT demographics.full_name, demographics.up_mail, polar.answers 
                    FROM demographics NATURAL JOIN polar
                    WHERE (demographics.id = polar.id) AND polar.question_id ='$q_id'";
                    $answer_result9 = mysqli_query($conn,$answer9);
    ?>

            <table width="100%">
            <tr>
                <td colspan="7"><?php echo $row['question']?></td>
            <tr>
                <td colspan="7" style="padding: 10px">
                    <div class="list">  
                    <ul>
                        <?php
                        $i = 1;
                        if(mysqli_num_rows($answer_result9)>0){
                             while($row = mysqli_fetch_assoc($answer_result9)) {
                        ?>
                        <li> 
                            <table width="100%">
                                <tr>
                                    <td valign="top"style="width: 400px">
                                        <?php
                                        echo $i.". ";
                                        if ($row['full_name'] == null) {
                                            echo $row['up_mail'];
                                        }else{
                                            echo $row['full_name']; }
                                        ?> 
                                    </td>
                                    <td colspan="6"><?php echo $row['answers'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
                            $i++;
                            }
                        }
                        ?>
                    </ul>
                    </div>
                </td>
            </tr>

    <?php                
                }
            }
        }
    ?>

    <table width="100%" style="margin-top: 15px">
    <tr>
        <td colspan="7" style="font-weight: bold; ">Other Comments and Suggestions</td>
    </tr> 
    </table>

     <?php

        $select4 = "SELECT question_id, question, rateable FROM questionnaire";
        $result4 = mysqli_query($conn,$select4);

        if(mysqli_num_rows($result4)>0){
            while($row=mysqli_fetch_assoc($result4)){
                if ($row['rateable'] == 'False' && $row['question_id'] == 37) {

                    $q_id = $row['question_id'];


                    $answer8 = "SELECT demographics.full_name, demographics.up_mail, suggestion.comments 
                    FROM demographics NATURAL JOIN suggestion
                    WHERE (demographics.id = suggestion.id) AND suggestion.question_id ='$q_id'";
                    $answer_result8 = mysqli_query($conn,$answer8);
                    
    ?>

        <table width="100%">
            <tr>
                <td colspan="7" style="padding: 10px">
                    <div class="list">
                    <ul>
                        <?php
                        $i = 1;
                        if(mysqli_num_rows($answer_result8)>0){
                             while($row = mysqli_fetch_assoc($answer_result8)) {
                        ?>
                        <li> 
                            <table width="100%">
                                <tr>
                                    <td valign="top" style="width: 400px">
                                        <?php
                                        echo $i.". ";
                                        if ($row['full_name'] == null) {
                                            echo $row['up_mail'];
                                        }else{
                                            echo $row['full_name']; }
                                        ?> 
                                    </td>
                                    <td colspan="6"><?php echo $row['comments'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
                            $i++;
                            }
                        }
                        ?>
                    </ul>
                    </div>
                </td>
            </tr>
        </table>
    <?php 
                }
            }
        }
    ?>









 <div align="center" width="100%" class="header">
        <h3>Consent</h3>
 </div>

     <table width="100%" style="margin-top: 15px">
    <tr>
        <td colspan="7" style="font-weight: bold; ">Consent for a Follow-up Interview</td>
    </tr> 
    </table>

     <?php
        //lastly the consent part of this file to be downloaded
        $select4 = "SELECT question_id, question, rateable FROM questionnaire";
        $result4 = mysqli_query($conn,$select4);

        if(mysqli_num_rows($result4)>0){
            while($row=mysqli_fetch_assoc($result4)){
                if ($row['rateable'] == 'False' && $row['question_id'] == 36) {

                    $q_id = $row['question_id'];


                    $answer9 = "SELECT demographics.full_name, demographics.up_mail, consent.answers 
                    FROM demographics NATURAL JOIN consent
                    WHERE (demographics.id = consent.id) AND consent.question_id ='$q_id'";
                    $answer_result9 = mysqli_query($conn,$answer9);
                    
    ?>

        <table width="100%">
            <tr>
                <td><?php echo $row['question']?></td>
            <tr>
            <tr>
                <td style="padding: 10px">
                    <ul>
                        <?php
                        if(mysqli_num_rows($answer_result9)>0){
                             while($row = mysqli_fetch_assoc($answer_result9)) {
                        ?>
                        <li> 
                            <table width="100%">
                                <tr>
                                    <td style="width: 200px">
                                        <?php
                                        if ($row['full_name'] == null) {
                                            echo $row['up_mail'];
                                        }else{
                                            echo $row['full_name']; }
                                        ?> 
                                    </td>
                                    <td colspan="6"><?php echo $row['answers'] ?></td>
                                </tr>
                            </table>
                            </li>

                        <?php
                            }
                        }
                        ?>
                    </ul>
                </td>
            </tr>
        </table>
    <?php 
                }
            }
        }
    ?>


 </html>
