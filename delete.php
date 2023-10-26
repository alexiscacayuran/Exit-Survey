<!DOCTYPE html>
<html>
<head>
    
    <title>Admin | DMCS Exit Survey</title>

    <!-- styles and font-->
        <link rel="icon" href="https://cs.upb.edu.ph/assets/images/upbcs-logo.png">
        <link rel="stylesheet" href="survey-style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

        <!-- scripts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'></script>
</head>
<body>
<?php
    
    //show an error message if access directly
    define('MyConst', TRUE);


    include_once('connection.php');
    
    //filter accesses on this file
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

        $username = $_GET['username'];

?>


<!-- modal for the delete button -->
<div id="myModal" class="modal">

  <!-- modal content -->
  <div class="modal-content"  style="width: 30%; height: auto; padding: 50px">
    <span class="close" onclick="location.href='user.php'">&times;</span>
    <div align="center" width="100%">

    <h3 style="font-size: 20px; font-weight: bolder">Delete</h3>

    <div><p>Do you wish to delete this record?</p></div>

    <!-- button for the delete function -->   
    <button id="normal-btn" style="margin-right: 5px;" type="button" title="Delete"  onclick="location.href='user_delete.php?username=<?php echo $username?>'">Delete</button>
    <button id="normal-btn" style="float: none" class="close" onclick="location.href='user.php'">Cancel</button>
    </form>
    <div style="margin: 20px;"><div class="loader" style="width: 80px; height: 80px; display: none"></div></div>
    </div>
  </div>


    

</body>
<script>
    
// show the modal
var modal = document.getElementById("myModal");

window.onload = function(){
    modal.style.display = "block";
}

</script>