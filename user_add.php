<?php

define('MyConst', TRUE);    
include_once('connection.php');

session_start();
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


$username = $_POST['username'];
$password = $_POST['password'];

$delete = "INSERT INTO login (up_mail, password, type) VALUES ('$username','$password','1')";
if ($conn->query($delete) === FALSE){
echo "<br>Error: ".$delete."<br>".$conn->error;
}

header("Location: user.php");



?>