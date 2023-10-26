<!-- insert the answers from demographics.php to the database -->
<?php
//show an error message if access directly
define('MyConst', true);

//connect to the database
include_once 'connection.php';

//filter the accesses on this file
session_start();
if ($_SESSION['gate_keep0'] != true) {
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

    //prevent skips, bounce back to their corresponding page if this file is accessed
    if ($_SESSION['anti_skip'] == 0) {
        $_SESSION['anti_skip'] = 1;
    } else if ($_SESSION['anti_skip'] == 1) {

    } else if ($_SESSION['anti_skip'] == 2) {
        header("Location: survey.php");
    } else if ($_SESSION['anti_skip'] == 3) {
        header("Location: end.php?class=Degree Program");
    }
}

//get the external data from demographics
$a = $_SESSION['id'];
$b = $_POST['fullname'];
$c = $_POST['studentnum'];
$d = $_POST['course'];
$e = $_SESSION['username'];
$f = $_POST['grad'];

//query to insert the data to the database
$insert = "INSERT INTO demographics (id, up_mail, full_name, student_num, degree_program, grad) VALUES ('$a', '$e', '$b', '$c', '$d', '$f') ";

if ($conn->query($insert) === true) {

} else {
    echo "Error: " . $insert . "<br>" . $conn->error . "<br><br>";
    $conn->close();
}

//proceed to the survey questions
header("location: survey.php");
