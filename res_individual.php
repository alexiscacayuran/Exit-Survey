<!DOCTYPE html>
<html>
    <head>

        <title>Admin | DMCS Exit Survey</title>

		<!-- styles and font -->
		<link rel="icon" href="https://cs.upb.edu.ph/assets/images/upbcs-logo.png">
        <link rel="stylesheet" href="survey-style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

        <!-- scripts -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'></script>


    </head>


    <body>
		<?php

//show an error message if access directly
define('MyConst', true);

//connect to database
include_once 'connection.php';

//filter accesses on this file
session_start();
$_SESSION['gatekeep1'] = true;
$_SESSION['gatekeep2'] = false;

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

if ($_SESSION['type'] != 1) {
    session_destroy();
    header("Location: login.php");
    die();
}

//get the id of the respondent and the initial questions category from admin
$a = $_GET['id'];
$f = $_GET['class'];

//get the demographic information od the respondent
$res_indi_sel = "SELECT up_mail, full_name, student_num, degree_program FROM demographics where id = $a";
$res_indi_res = mysqli_query($conn, $res_indi_sel);

if (mysqli_num_rows($res_indi_res) > 0) {
    while ($row = mysqli_fetch_assoc($res_indi_res)) {
        $b = $row['up_mail'];
        $c = $row['full_name'];
        $d = $row['student_num'];
        $e = $row['degree_program'];
    }
}

?>
	<!-- container -->
	<div class="admin">
    <div class="row d-flex justify-content-center align-items-center">
    <div class="col-md-8">
    <div id="regForm" action="" method="post">

    <button onclick="topFunction()" id="scrolltop-btn" title="Go to top"><i class="fa fa-arrow-up"></i></button>

    <script>
        // get the button
        mybutton = document.getElementById("scrolltop-btn");

        // when the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
          if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
          } else {
            mybutton.style.display = "none";
          }
        }

        // when the user clicks on the button, scroll to the top of the document
        function topFunction() {
          document.body.scrollTop = 0; // for Safari
          document.documentElement.scrollTop = 0; // for Chrome, Firefox, IE and Opera
        }
    </script>

    	<!-- sign out button -->
         <div style="position: relative; height: 40px; padding-left: 50px; float: right" id="nextprevious">
            <div class="center">
                    <form action="" method="post">
                   <button id="signoutBtn" title="Log Out" type="submit" name="logout" value="Log Out"><i class="fa fa-sign-out"></i></button>
                   </form>
            </div>
        </div>

        <!-- back button -->
        <div style="position: relative; height: 40px; padding-left: 50px; float: left" id="nextprevious">
            <div class="center">
                   <button id="nextBtn" title="Back" type="button" onclick="location.href='./admin.php?class=rating';"><i class="fa fa-arrow-left"></i></button>
        	</div>
       	</div>

       	<!-- download indiviual tally button -->
        <div style="position: relative; height: 40px; padding-left: 150px; float: left" id="nextprevious">
            <div class="center">
                <button id="btn" title="Download Individual Tally" type="button" onclick="location.href='res_download.php?id=<?php echo $a ?>';" style="font-size: 12px"><i class="fa fa-download"></i>&nbsp;Download Individual</button>
            </div>
        </div>


        <div align="center">
        <h1 style="margin: 100px 0px 40px 0px; font-size: 40px">DMCS Exit Survey</h1>
        </div>


        <!-- sidebar for the list of respondents -->
    <div class="sidebar"  style="height: auto">
    	<div align="center">
	    <h3>Respondents</h3>
	    </div>
	    <div class="list" style="max-height: 500px">
	    <ul>
	         <?php
//select the respondents wo have completed the survey
$select_resp = "SELECT id, up_mail, full_name, student_num, degree_program FROM demographics WHERE time_out != ''";
$result_resp = mysqli_query($conn, $select_resp);

if (mysqli_num_rows($result_resp) > 0) {
    while ($row = mysqli_fetch_assoc($result_resp)) {
    	//highlight the name if id matches the record in the database
        if ($a == $row['id']) {
            ?>
		    <li class="border-bot">
		    <p style="font-weight: bolder; font-size: 16px" onclick="location.href='res_individual.php?id=<?php echo $row['id'] ?>&class=<?php echo "Degree Program" ?>';">
		            <?php
		    //print their full name, or their up mail if they didn't provide their name
			//cut the excess characters for each entries to organize the list
			$max = 20;
            if ($row['full_name'] == null) {
                if (strlen($row['up_mail']) > $max) {
                    echo substr($row['up_mail'], 0, $max) . "...";
                } else {
                    echo $row['up_mail'];
                }

            } else {
                if (strlen($row['full_name']) > $max) {
                    echo substr($row['full_name'], 0, $max) . "...";
                } else {
                    echo $row['full_name'];
                }

            }?>
	        </p>
	        </li>
	         <?php
// do not highlight if it does not match
} elseif ($a != $row['id']) {
            ?>
			        <li class="border-bot">
			        <p onclick="location.href='res_individual.php?id=<?php echo $row['id'] ?>&class=<?php echo "Degree Program" ?>';">
			            <?php

			//print their full name, or their up mail if they didn't provide their name
			//cut the excess characters according to $max for each entries to organize the list
            $max = 20;
            
            if ($row['full_name'] == null) {
                if (strlen($row['up_mail']) > $max) {
                    echo substr($row['up_mail'], 0, $max) . "...";
                } else {
                    echo $row['up_mail'];
                }

            } else {
                if (strlen($row['full_name']) > $max) {
                    echo substr($row['full_name'], 0, $max) . "...";
                } else {
                    echo $row['full_name'];
                }

            }?>
			        </p>
			        </li>

	        <?php
}
    }
}?>
	    </ul>
		</div>
    </div>

    <!-- container for the main grid-->
    <div class="main_indiv">

        <h3 style="font-size: 30px">
		<?php

//print the respondent's name else, print "Graduate"
if ($c == null) {
    echo "Graduate";
} else {
    echo $c;
}
?>
		</h3>

		<div >
		<ul width="100%">
			<!-- print the respondent's email -->
		  	<li><table class="border-bot" width="100%">
		  		<tr>
		  		<td width="500px">Email </td>

		  		<td ><?php echo $b ?></td>
		  		</tr>
		  		</table>
		  	</li>

		  	<!-- print the respondent's student number, else print (not provided) -->
		  	<li><table class="border-bot" width="100%">
		  		<tr>
		  		<td  width="500px">Student Number </td>
		  		<td>
		  		<?php
				if ($d == null) {
				    echo "(not provided)";
				} else {
				    echo $d;
				}?>
				</td>
				</tr>
				<table>
			</li>

			<!-- print the respondent's degree program, else print (not provided) -->
			<li><table class="border-bot" width="100%">
		  		<tr>
		  		<td  width="500px">Degree Program </td>

		  		<td><?php echo $e ?></td>
		  		</tr>
		  		</table>
		  	</li>

		  	<!-- ffetch and print the respondent's year of graduation -->
			<li><table class="border-bot" width="100%">
		  		<tr>
		  		<td  width="500px">Year Graduated </td>
		  		<td>
				<?php
				$grad        = "SELECT grad FROM demographics WHERE id='$a'";
				$result_grad = mysqli_query($conn, $grad);

				if (mysqli_num_rows($result_grad) > 0) {
				    while ($row = mysqli_fetch_assoc($result_grad)) {
				        echo $row['grad'];
				    }
				}
				?>
				</td>
				</tr>
				</table>
			</li>
			<!-- fetch and print the time the survey was completed by the respondent -->
			<li><table class="border-bot" width="100%">
		  		<tr>
		  		<td  width="500px">Time of Completion </td>
		  		<td>
				<?php
				$timestamp        = "SELECT time_out FROM demographics WHERE id='$a'";
				$result_timestamp = mysqli_query($conn, $timestamp);

				if (mysqli_num_rows($result_timestamp) > 0) {
				    while ($row = mysqli_fetch_assoc($result_timestamp)) {
				        echo $row['time_out'];
				    }
				}
				?>
				</td>
				</tr>
				</table>
			</li>
			<!-- print the respondent's answer to the consent -->
			<li><table class="border-bot" width="100%">
		  		<tr>
		  		<td  width="500px">Will you be willing to be contacted for an interview? </td>
		  		<td>
				<?php
				$consent        = "SELECT answers FROM consent WHERE id='$a'";
				$result_consent = mysqli_query($conn, $consent);

				if (mysqli_num_rows($result_consent) > 0) {
				    while ($row = mysqli_fetch_assoc($result_consent)) {
				        echo $row['answers'];
				    }
				}
				?>
				</td>
				</tr>
				</table>
			</li>
				<!-- print the respondent's other comments and suggestions -->
				<li><table class="border-bot" width="100%">
		  		<tr>
		  		<td  width="500px">Other comments and suggestions</td>


				<td class="rate-list">
				<?php
				$consent        = "SELECT comments FROM suggestion WHERE id='$a' AND question_id = 37";
				$result_consent = mysqli_query($conn, $consent);

				if (mysqli_num_rows($result_consent) > 0) {
				    while ($row = mysqli_fetch_assoc($result_consent)) {
				        echo $row['comments'];
				    }
				}
				?>
				</td>
				</tr>
				</table>
			</li>



		</ul>
		</div>


		<?php
//view the response of the respondent

//check if the category is Degree Program
if ($f == "Degree Program") {
    ?>

    	<!-- navigation bar for the questions category -->
		<div align="center" style="margin-top: 15px">
			<div class="pagination">
			  <a href="">&laquo;</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Degree Program" ?>">1</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Facilities and Infrastructure" ?>">2</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Financial Aid" ?>">3</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Events" ?>">4</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Career Plans" ?>">5</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Facilities and Infrastructure" ?>">&raquo;</a>
			</div>
	    </div>

	    <!-- print the category -->
		<div style="padding-top: 30px"><h3><?php echo $f ?></h3></div>

		<!-- table for the response -->
		<table width="100%" style="margin-top: 15px">
		<tr>
			<th style="text-align: center; width: 500px">Questions</th>
			<th>Rating</th>
		</tr>
		</table>


<!--select the rateable questions and the answers from the database -->
		<?php
$select1 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, rating.rate
					FROM questionnaire NATURAL JOIN rating
					WHERE (questionnaire.question_id = rating.question_id) AND id ='$a'";
    $result1 = mysqli_query($conn, $select1);

    if (mysqli_num_rows($result1) > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
        	 //check if the category is Degree Program
            if ($row['classification'] == $f) {
                ?>
                <!-- print the question and the corresponding respondent's rate-->
				<table class="question" width="100%">
				<tr>
					<td style="width: 500px"><?php echo $row['question'] ?></td>
					<td style="text-align: center;"><?php echo $row['rate'] ?></td>
				</tr>
				</table>
		<?php
}
        }

    }
    ?>


		<table width="100%" style="margin-top: 15px">
		<tr>
			<th style="text-align: center; width: 500px">Questions</th>
			<th>Answers</th>
		</tr>
		</table>


<!--select the questions answerable by suggestion/opinion and the answers from the database -->
		<?php
$select11 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, suggestion.comments
					FROM questionnaire NATURAL JOIN suggestion
					WHERE (questionnaire.question_id = suggestion.question_id) AND id ='$a'";
    $result11 = mysqli_query($conn, $select11);

    if (mysqli_num_rows($result11) > 0) {
        while ($row = mysqli_fetch_assoc($result11)) {
        	//check if the question falls under the Degree program category
            if ($row['classification'] == $f) {
                ?>
                <!-- print the question and the corresponding respondent's rate-->
				<table class="question" width="100%">
				<tr>
					<td style="width: 500px"><?php echo $row['question'] ?></td>
					<td style="text-align: center;"><?php echo $row['comments'] ?></td>
				</tr>
				</table>
		<?php
}
        }

    }
}?>



		<?php
//check if the category is Facilities and Infrastructure
if ($f == "Facilities and Infrastructure") {
    ?>
    	<!-- navigation bar for the question category-->
		<div align="center" style="margin-top: 15px">
			<div class="pagination">
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Degree Program" ?>">&laquo;</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Degree Program" ?>">1</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Facilities and Infrastructure" ?>">2</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Financial Aid" ?>">3</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Events" ?>">4</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Career Plans" ?>">5</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Financial Aid" ?>">&raquo;</a>
			</div>
	    </div>

		<div style="padding-top: 30px"><h3><?php echo $f ?></h3></div>

		<table width="100%" style="margin-top: 15px">
		<tr>
			<th style="text-align: center; width: 500px">Questions</th>
			<th>Rating/Answers</th>
		</tr>
		</table>



			<?php
$select2 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, rating.rate
					FROM questionnaire NATURAL JOIN rating
					WHERE (questionnaire.question_id = rating.question_id) AND id ='$a'";
    $result2 = mysqli_query($conn, $select2);

    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            if ($row['classification'] == $f && $row['question_id'] <= 14) {
                ?>
				<table class="question" width="100%">
				<tr>
					<td style="width: 500px"><?php echo $row['question'] ?></td>
					<td style="text-align: center;"><?php echo $row['rate'] ?></td>
				</tr>
				</table>
		<?php
			}
        }

    }
    ?>

	<?php

    $select3 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, suggestion.comments
						FROM questionnaire NATURAL JOIN suggestion
						WHERE (questionnaire.question_id = suggestion.question_id) AND id ='$a'";
    $result3 = mysqli_query($conn, $select3);

    if (mysqli_num_rows($result3) > 0) {
        while ($row = mysqli_fetch_assoc($result3)) {
            if ($row['classification'] == $f) {
                ?>
				<table class="question" width="100%">
				<tr>
					<td style="width: 500px"><?php echo $row['question'] ?></td>
					<td style="text-align: center;"><?php echo $row['comments'] ?></td>
				</tr>
				</table>

		<?php
}
        }
    }

    ?>

		<table width="100%"  style="margin-top: 15px">
			<tr>
				<td colspan="2">How will you rate the following services provided by the following offices?</td>

			</tr>
			<tr>
				<th style="text-align: center; width: 500px">Facility</th>
				<th>Rating</th>
			</tr>
		</table>

		<?php

    $select4 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, rating.rate
					FROM questionnaire NATURAL JOIN rating
					WHERE (questionnaire.question_id = rating.question_id) AND id ='$a'";
    $result4 = mysqli_query($conn, $select4);

    if (mysqli_num_rows($result4) > 0) {
        while ($row = mysqli_fetch_assoc($result4)) {
            if ($row['classification'] == $f && $row['question_id'] > 14 && $row['question_id'] <= 28) {
                ?>
				<table class="question" width="100%">
				<tr>
					<td style="width: 500px"><?php echo $row['question'] ?></td>
					<td style="text-align: center;">
						<?php
if ($row['rate'] == '0') {
                    echo "Not Applicable";
                } else {
                    echo $row['rate'];
                }

                ?>
					</td>
				</tr>
				</table>

		<?php
}
        }
    }
}
?>

		<?php
//check if the category is Financial Aid
if ($f == "Financial Aid") {
    ?>
    	<!-- navigation bar for the question category-->
		<div align="center" style="margin-top: 15px">
			<div class="pagination">
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Facilities and Infrastructure" ?>">&laquo;</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Degree Program" ?>">1</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Facilities and Infrastructure" ?>">2</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Financial Aid" ?>">3</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Events" ?>">4</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Career Plans" ?>">5</a>
			  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Events" ?>">&raquo;</a>
			</div>
	    </div>

		<div style="padding-top: 30px"><h3><?php echo $f ?></h3></div>

		<table width="100%" style="margin-top: 15px">
		<tr>
			<th style="text-align: center; width: 500px">Questions</th>
			<th>Answers</th>
		</tr>
		</table>



		<?php
//select the polar questions and the answers from the database
$select5 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, polar.answers
					FROM questionnaire NATURAL JOIN polar
					WHERE (questionnaire.question_id = polar.question_id) AND id ='$a'";
    $result5 = mysqli_query($conn, $select5);

    if (mysqli_num_rows($result5) > 0) {
        while ($row = mysqli_fetch_assoc($result5)) {
        	//check if the question falls under the Financial Aid category
            if ($row['classification'] == $f) {
                ?>

                <!-- print the question and the corresponding respondent's rate-->
				<table class="question" width="100%">
				<tr>
					<td style="width: 500px"><?php echo $row['question'] ?></td>
					<td style="text-align: center;"><?php echo $row['answers'] ?></td>
				</tr>
				</table>
		<?php
}
        }

    }
}?>



		<?php
//check if the category is Events
if ($f == "Events") {
    ?>
    	<!-- navigation bar for the question category-->
		<div align="center" style="margin-top: 15px">
		<div class="pagination">
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Financial Aid" ?>">&laquo;</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Degree Program" ?>">1</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Facilities and Infrastructure" ?>">2</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Financial Aid" ?>">3</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Events" ?>">4</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Career Plans" ?>">5</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Career Plans" ?>">&raquo;</a>
		</div>
    	</div>

		<div style="padding-top: 30px"><h3><?php echo $f ?></h3></div>

		<table width="100%" style="margin-top: 15px">
		<tr>
			<th style="text-align: center; width: 500px">Questions</th>
			<th>Answers</th>
		</tr>
		</table>



		<?php
$select6 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, suggestion.comments
					FROM questionnaire NATURAL JOIN suggestion
					WHERE (questionnaire.question_id = suggestion.question_id) AND id ='$a'";
    $result6 = mysqli_query($conn, $select6);

    if (mysqli_num_rows($result6) > 0) {
        while ($row = mysqli_fetch_assoc($result6)) {
            if ($row['classification'] == $f) {
                ?>
				<table class="question" width="100%">
				<tr>
					<td style="width: 500px"><?php echo $row['question'] ?></td>
					<td style="text-align: center;"><?php echo $row['comments'] ?></td>
				</tr>
				</table>
		<?php
}
        }

    }
}?>


		<?php
//check if the category is Career Plans
if ($f == "Career Plans") {
    ?>

    	<!-- navigation bar for the question category-->
		<div align="center" style="margin-top: 15px">
		<div class="pagination">
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Events" ?>">&laquo;</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Degree Program" ?>">1</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Facilities and Infrastructure" ?>">2</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Financial Aid" ?>">3</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Events" ?>">4</a>
		  <a href="res_individual.php?id=<?php echo $a ?>&class=<?php echo "Career Plans" ?>">5</a>
		  <a href="">&raquo;</a>

		</div>
    	</div>

		<div style="padding-top: 30px"><h3><?php echo $f ?></h3></div>

		<table width="100%" style="margin-top: 15px">
		<tr>
			<th style="text-align: center; width: 500px">Questions</th>
			<th>Answers</th>
		</tr>
		</table>



		<?php
$select7 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, suggestion.comments
					FROM questionnaire NATURAL JOIN suggestion
					WHERE (questionnaire.question_id = suggestion.question_id) AND id ='$a'";
    $result7 = mysqli_query($conn, $select7);

    if (mysqli_num_rows($result7) > 0) {
        while ($row = mysqli_fetch_assoc($result7)) {
            if ($row['classification'] == $f) {
                ?>
				<table class="question" width="100%">
				<tr>
					<td style="width: 500px"><?php echo $row['question'] ?></td>
					<td style="text-align: center;"><?php echo $row['comments'] ?></td>
				</tr>
				</table>
		<?php
}
        }

    }
    ?>


		<?php
$select8 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, polar.answers
					FROM questionnaire NATURAL JOIN polar
					WHERE (questionnaire.question_id = polar.question_id) AND id ='$a'";
    $result8 = mysqli_query($conn, $select8);

    if (mysqli_num_rows($result8) > 0) {
        while ($row = mysqli_fetch_assoc($result8)) {
            if ($row['classification'] == $f) {
                ?>
				<table class="question" width="100%">
				<tr>
					<td style="width: 500px"><?php echo $row['question'] ?></td>
					<td style="text-align: center;"><?php echo $row['answers'] ?></td>
				</tr>
				</table>
		<?php
}
        }

    }
}

//close the connection
mysqli_close($conn);?>






</div>
</div>
</div>
</div>

</body>
</html>
