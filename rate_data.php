<?php
header('Content-Type: application/json');
define('MyConst', TRUE);
include_once('connection.php');
        
        session_start();

        $_SESSION['gatekeep1']=FALSE;
        $_SESSION['gatekeep2']=FALSE;

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

$q_id = $_GET['q_id'];
        

$select = "SELECT zero, one, two, three, four, five FROM rating_graph WHERE question_id = '$q_id'";

$result = mysqli_query($conn,$select);

$data = array();

foreach ($result as $row) {
	$data[] = $row;
}




echo json_encode($data);

mysqli_close($conn);
?>