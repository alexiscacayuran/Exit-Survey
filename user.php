<!DOCTYPE html>

<?php
//This page is for managing admins, adding and deleting function to be exact

//shows an error message if include is accessed directly
define('MyConst', true);
//connect to the database
include_once 'connection.php';

session_start();
//Below are codes that filter access to this file
$_SESSION['gatekeep1'] = false;

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

?>


<html>
        <!-- styles and font-->
        <link rel="icon" href="https://cs.upb.edu.ph/assets/images/upbcs-logo.png">
        <link rel="stylesheet" href="survey-style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

        <!-- scripts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'></script>




<head>
  <title>Admin | DMCS Exit Survey</title>
</head>

<body>

   <!-- modal -->
        <div id="myModal" class="modal">

          <!-- modal content -->
          <div class="modal-content" action="backup.php" style="width: 40%; height: auto; padding: 50px">




            <span class="close">&times;</span>
            <div align="center" width="100%">

            <h3 style="font-size: 20px; font-weight: bolder">Add Administrator</h3>

            <p>Please enter your desired username and password to create an account for the administrator.</p>

        <form action="" method="post">

            <?php
//Function that adds admin
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    //checks if username already exists
    $check        = "SELECT up_mail FROM login WHERE up_mail = '$username'";
    $result_check = mysqli_query($conn, $check);

    //if check comes back as 0 new admin login credentials will be add to the database
    if (mysqli_num_rows($result_check) == 0) {
        $add = "INSERT INTO login (up_mail, password, type) VALUES ('$username','$password','1')";
        if ($conn->query($add) === false) {
            echo "<br>Error: " . $add . "<br>" . $conn->error;
        }
    }

}

?>

            <div align="center">
            <div class="form-group" style="margin: 20px;">

                <input style="width:50%; padding: 10px" type="text" name="username" placeholder="Username">

            </div>

            <div class="form-group" style="margin: 20px; ">

                <input style="width:50%; padding: 10px" type="text" name="password" placeholder="Password" >

            </div>

            <div class="form-group">

                <button id="submit" style="border-radius: 4px; font-size: 14px; width: 50%; margin: 10px" type="submit">Submit</button>
            </div>
            </div>
            </div>

      </form>


            <div style="margin: 20px;"><div class="loader" style="width: 80px; height: 80px; display: none"></div></div>
            </div>
          </div>

        </div>

  <div class="container">
  <div class="admin">
  <div class="row d-flex justify-content-center align-items-center">
  <div id="regForm">

    <div style="position: relative; height: 40px; padding-left: 50px; float: right" id="nextprevious">
        <div class="center">
                <form action="" method="post">
               <button id="signoutBtn" title="Log Out" type="submit" name="logout" value="Log Out"><i class="fa fa-sign-out"></i></button>
               </form>
        </div>
    </div>


        <div style="position: relative; height: 40px; padding-left: 50px; float: left" id="nextprevious">
            <div class="center">
                   <button id="nextBtn" title="Back" type="button" onclick="location.href='./admin.php?class=rating';"><i class="fa fa-arrow-left"></i></button>
          </div>
        </div>

<div align="center">
<h1 style="margin: 100px 0px 40px 0px; font-size: 40px">DMCS Exit Survey</h1>
</div>

<div align="center" width="100%" class="header">
    <h3>MANAGE ADMINISTRATORS</h3>
</div>



  <table align="center" width="50%">
    <thead>
        <tr>
          <th >Username</th>
          <th >Password</th>
          <th >Delete</th>
        </tr>
    </thead>

        <?php
//prints all admin login credentials from the database
$select_users = "SELECT up_mail, password, type FROM login WHERE type = 1";
$result_users = mysqli_query($conn, $select_users);

if (mysqli_num_rows($result_users) > 0) {
    while ($row = mysqli_fetch_assoc($result_users)) {
        ?>
      <tbody class="rate-list">
      <tr valign="top">
        <td style="padding: 20px"><?php echo $row['up_mail'] ?></td>
        <td align="center" style="padding: 20px"><?php echo $row['password'] ?></td>
        <!-- Below is the delete function that will post the admin username to be deleted-->
        <td align="center"><button class="btn" type="button" style="padding: 20px" onclick="location.href='delete.php?username=<?php echo $row['up_mail'] ?>'" ><i class="fa fa-trash"></i></button></td>



        </div>
      </tr>
      </tbody>

      <?php
}
}?>
      </table>


            <div align="center">
                   <button id="myBtn" class="btn-modal" title="Add Administrator" type="button" style="font-size: 12px;width: 50%; border-radius: 10px; margin-bottom: 50px"><i class="fa fa-user-plus"></i>  Add Admin</button>
            </div>




          <script>
        // Get the modal
        var modal = document.getElementById("myModal");



        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");


        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];


        // When the user clicks the button, open the modal
        btn.onclick = function() {
          modal.style.display = "block";
        }

                // When the user clicks the button, open the modal
        submit.onclick = function() {
          modal.style.display = "block";
        }




        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = "none";
        }



        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }


        </script>









</div>
</div>
</div>
</div>
  </body>
</html>