<?php
//this file deletes admin from the database

//shows an error if include is accessed directly
define('MyConst', TRUE);    

//connect to the database
include_once('connection.php');

session_start();

//Below are codes that filter access to this file
$_SESSION['gatekeep1']=FALSE;

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


//gets the admin's user name about to be deleted, from previous webpage
$username = $_GET['username'];

//Deletes entire row of admin using the variable from above
$delete = "DELETE FROM login WHERE up_mail = '$username'";
$result = mysqli_query($conn, $delete);


if ($conn->query($delete) === FALSE){
echo "<br>Error: ".$delete."<br>".$conn->error;
}   

//redirect back to user.php
header("Location: user.php");

?>