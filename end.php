<!DOCTYPE html>

<html>
    <head>
        <title>DMCS Exit Survey</title>


        <!-- styles and fonts -->
        <link rel="icon" href="https://cs.upb.edu.ph/assets/images/upbcs-logo.png">
        <link rel="stylesheet" type="text/css" href="survey-style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    </head>
    <body>

<?php

//show an error message if access directly
define('MyConst', true);

//connect to the database
include_once 'connection.php';

//filter the accesses on this file
session_start();
$_SESSION['anti_skip'] = 3;

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

//prevent skips, bounce back to their corresponding page if this file is accessed
if ($_SESSION['anti_skip'] == 0) {
    header("Location: notice.php");
} else if ($_SESSION['anti_skip'] == 1) {
    header("Location: demographics.php");
} else if ($_SESSION['anti_skip'] == 2) {
    header("Location: survey.php");
} else if ($_SESSION['anti_skip'] == 3) {

}

//get the id from session and initial question category from survey_submit
$a = $_SESSION['id'];
$f = $_GET['class'];
?>


    <div class="survey">
    <div class="row d-flex justify-content-center align-items-center">
    <div class="col-md-8">

             <!-- log out button -->
            <div style="position: relative; height: 40px; padding-left: 40px; float: right" id="nextprevious">

                <form id="logout" method="post">
                    <div class="center" >
                           <button id="signoutBtn" title="Sign out" type="submit" name="logout" value="Log Out" style="margin-right: 50px; margin-top: 120px"><i class="fa fa-sign-out"></i></button>
                    </div>
                </form>

            </div>

             <!-- container -->
            <div id="regForm">
                <h1 id="register">DMCS Exit Survey</h1>
                <div class="tab" style="padding: 100px; display: block; padding: 0;">

                    <!-- thank you message -->
                    <p align="center">
                        <i class="fa fa-check-circle" style="font-size: 150px; color: #165016; "></i> <br> <br>
                        Thank you for taking the time to complete this survey!
                    </p>
                </div>

                <?php

//view the response of the students

//check if the category is Degree Program
if ($f == "Degree Program") {
    ?>

        <!-- navigation bar for the questions category -->
        <div align="center">
            <div class="pagination">
              <a href="#">&laquo;</a>
              <a href="end.php?class=<?php echo "Degree Program" ?>">1</a>
              <a href="end.php?class=<?php echo "Facilities and Infrastructure" ?>">2</a>
              <a href="end.php?class=<?php echo "Financial Aid" ?>">3</a>
              <a href="end.php?class=<?php echo "Events" ?>">4</a>
              <a href="end.php?class=<?php echo "Career Plans" ?>">5</a>
              <a href="end.php?class=<?php echo "Consent for a follow-up interview" ?>">6</a>
              <a href="end.php?class=<?php echo "Facilities and Infrastructure" ?>">&raquo;</a>
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
        <div align="center">
            <div class="pagination">
              <a href="end.php?class=<?php echo "Degree Program" ?>">&laquo;</a>
              <a href="end.php?class=<?php echo "Degree Program" ?>">1</a>
              <a href="end.php?class=<?php echo "Facilities and Infrastructure" ?>">2</a>
              <a href="end.php?class=<?php echo "Financial Aid" ?>">3</a>
              <a href="end.php?class=<?php echo "Events" ?>">4</a>
              <a href="end.php?class=<?php echo "Career Plans" ?>">5</a>
              <a href="end.php?class=<?php echo "Consent for a follow-up interview" ?>">6</a>
              <a href="end.php?class=<?php echo "Financial Aid" ?>">&raquo;</a>

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
                <td>How will you rate the following services provided by the following offices?</td>
                <td></td>
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
        <div align="center">
            <div class="pagination">
              <a href="end.php?class=<?php echo "Facilities and Infrastructure" ?>">&laquo;</a>
              <a href="end.php?class=<?php echo "Degree Program" ?>">1</a>
              <a href="end.php?class=<?php echo "Facilities and Infrastructure" ?>">2</a>
              <a href="end.php?class=<?php echo "Financial Aid" ?>">3</a>
              <a href="end.php?class=<?php echo "Events" ?>">4</a>
              <a href="end.php?class=<?php echo "Career Plans" ?>">5</a>
              <a href="end.php?class=<?php echo "Consent for a follow-up interview" ?>">6</a>
              <a href="end.php?class=<?php echo "Events" ?>">&raquo;</a>
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
        <div align="center">
        <div class="pagination">
          <a href="end.php?class=<?php echo "Financial Aid" ?>">&laquo;</a>
          <a href="end.php?class=<?php echo "Degree Program" ?>">1</a>
          <a href="end.php?class=<?php echo "Facilities and Infrastructure" ?>">2</a>
          <a href="end.php?class=<?php echo "Financial Aid" ?>">3</a>
          <a href="end.php?class=<?php echo "Events" ?>">4</a>
          <a href="end.php?class=<?php echo "Career Plans" ?>">5</a>
          <a href="end.php?class=<?php echo "Consent for a follow-up interview" ?>">6</a>
          <a href="end.php?class=<?php echo "Career Plans" ?>">&raquo;</a>
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
        <div align="center">
        <div class="pagination">
          <a href="end.php?class=<?php echo "Events" ?>">&laquo;</a>
          <a href="end.php?class=<?php echo "Degree Program" ?>">1</a>
          <a href="end.php?class=<?php echo "Facilities and Infrastructure" ?>">2</a>
          <a href="end.php?class=<?php echo "Financial Aid" ?>">3</a>
          <a href="end.php?class=<?php echo "Events" ?>">4</a>
          <a href="end.php?class=<?php echo "Career Plans" ?>">5</a>
          <a href="end.php?class=<?php echo "Consent for a follow-up interview" ?>">6</a>
          <a href="end.php?class=<?php echo "Consent for a follow-up interview" ?>">&raquo;</a>

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
}?>

<!-- check if the category is Consent-->
                <?php
if ($f == "Consent for a follow-up interview") {
    ?>

        <!-- navigation bar for the question category-->
        <div align="center">
        <div class="pagination">
          <a href="end.php?class=<?php echo "Career Plans" ?>">&laquo;</a>
          <a href="end.php?class=<?php echo "Degree Program" ?>">1</a>
          <a href="end.php?class=<?php echo "Facilities and Infrastructure" ?>">2</a>
          <a href="end.php?class=<?php echo "Financial Aid" ?>">3</a>
          <a href="end.php?class=<?php echo "Events" ?>">4</a>
          <a href="end.php?class=<?php echo "Career Plans" ?>">5</a>
          <a href="end.php?class=<?php echo "Consent for a follow-up interview" ?>">6</a>
          <a href="end.php?class=<?php echo "Consent for a follow-up interview" ?>">&raquo;</a>
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
//select the consent questions and answers from the database
$select7 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, consent.answers
                    FROM questionnaire NATURAL JOIN consent
                    WHERE (questionnaire.question_id = consent.question_id) AND id ='$a'";
    $result7 = mysqli_query($conn, $select7);

    if (mysqli_num_rows($result7) > 0) {
        while ($row = mysqli_fetch_assoc($result7)) {

            //check if the question falls under the Consent category
            if ($row['classification'] == $f) {
                ?>

                <!-- print the question and the corresponding respondent's answer-->
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
    ?>

        <?php
$select8 = "SELECT questionnaire.question_id, questionnaire.question, questionnaire.classification, suggestion.comments
                    FROM questionnaire NATURAL JOIN suggestion
                    WHERE (questionnaire.question_id = suggestion.question_id) AND id ='$a'";
    $result8 = mysqli_query($conn, $select8);

    if (mysqli_num_rows($result8) > 0) {
        while ($row = mysqli_fetch_assoc($result8)) {
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
            </div>

    </div>
    </div>
    </div>



</body>

</html>
