<?php

//show an error message if access directly
define('MyConst', TRUE);  

//connect to the database
require_once "connection.php";
// required php files to send an email without creating your own server
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//filter accesses on this file
 session_start();
            
            if($_SESSION['type']!=3){
                session_destroy();
                header("Location: login.php");
                die();
            }


//initialize  the up_mail, the error message, and the domain name of the email
$up_mail = "";
$up_mail_err = "";
$testEmail = "up.edu.ph";

//the string length of the domain name
$n = 9;

//get the data from the form
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //remove the domain name
    $start = strlen(($_POST["up_mail"])) - $n;

    //initialize a variable to store the domain name of the entered email
    $emailLast = '';

    //to check if the entered email is a UP email
    if (strlen(($_POST["up_mail"])) >= 10) {
        
        for ($x = $start; $x < strlen(($_POST["up_mail"])); $x++){
                $emailLast .= ($_POST["up_mail"])[$x];
         }
    }else
        $up_mail_err = "Please use your UP mail";


     if(empty(trim($_POST["up_mail"]))){
       
        $up_mail_err = "Please enter your UP mail."; 
    } 
    elseif($testEmail != $emailLast)
    {
        $up_mail_err = "Please use your UP mail";
    }
    else{

        $sql = "SELECT id FROM login WHERE up_mail = ?";



        if($stmt = $conn->prepare($sql)){

            $stmt->bind_param("s", $param_up_mail);
            

            $param_up_mail = trim($_POST["up_mail"]);
            

            if($stmt->execute()){

                $stmt->store_result();
                //to check if the UP mail was already used and existing in the database
                if($stmt->num_rows == 1){
                    $up_mail_err = "This UP mail was already used.";
                } else{
                    $up_mail = trim($_POST["up_mail"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }


            $stmt->close();
        }
    }
    //a function to generate the random password from a set of random characters
    function password_generate($chars) 
{
  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz!@#$%^&*()_';
  return substr(str_shuffle($data), 0, $chars);
}
    
    if(empty($up_mail_err) && empty($password_err) && empty($confirm_password_err)){
        
    	//an sql query to insert the up mail and random password in the database
        $sql = "INSERT INTO login (up_mail, password) VALUES (?, ?)";
         
        if($stmt = $conn->prepare($sql)){

            $stmt->bind_param("ss", $param_up_mail,  $param_password);
            

            $param_up_mail = $up_mail;
            $param_username = $username;
            $param_password = password_generate(9);//to ensure that the password given contains 9 characters

            //will execute and send an email if there are no errors 
            if($stmt->execute()){

                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = "true";
                $mail->SMTPSecure = "tls";
                $mail->Port = "587";
                $mail->Username = "upb.dmcs.survey@gmail.com";//email created that will send the login credentials
                $mail->Password = "#Admin01";//password of the email
                $mail->Subject = "Password for DMCS Exit Survey";//subject of the email
                $mail->setFrom("upb.dmcs.survey@gmail.com");//to show where the email came from

                //content of email which is the login credentials

                $mail->Body = "Here are your login credentials for the DMCS Exit Survey Program\n\nUP mail: $param_up_mail\nYour password is: $param_password\n\n\n\nThis is an auto generated email, please do not reply.\n";
                $mail->addAddress("$param_up_mail");

                $mail->Send();
                $mail->smtpClose();
                header("location: login.php");//to redirect in the login page
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }
    
    //to close connection
    $conn->close();
}

?>
 
<!DOCTYPE html>


<html>
 <link rel="stylesheet" type="text/css" href="survey-style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">


    <head>
        <title>Sign In | DMCS Exit Survey</title>
    </head>
   


     <div class="survey">
    <div class="justify-content-center align-items-center">
        <div class="col-lg">
        <form id="regForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div style="position: relative; height: 40px; padding-left: 40px; float: right" id="nextprevious">
            <div class="center">        
                   <button id="nextBtn" title="Back" type="button" onclick="location.href='./login.php';"><i class="fa fa-undo"></i></button>
            </div>
        </div>

      <div style="margin: 50px 10px 10px 10px; text-align: center;"><img style="width: 20%;"  src="https://cs.upb.edu.ph/assets/images/upbcs-logo.png"   /></div>


       <h1 style="margin-top: 30px">DMCS Exit Survey</h1>
    



        <h3 align="center" width="50%" style="margin-top: 50px; font-size: 18px;">Student Registration</h3>
        <p align="center" width="50%">Please enter your UP mail to create an account to access the survey. <br> Your password will be sent through your UP mail.</p>
        

        <div style="margin: 20px">
        <div class="form-group" align="center">
            
            <input  style="width: 50%" type="text" name="up_mail" class="form-control <?php echo (!empty($up_mail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $up_mail; ?>" placeholder="jdelacruz@up.edu.ph">
            <span  class="invalid-feedback"><?php echo $up_mail_err; ?></span>
        </div>    

        <div class="form-group" align="center">
            <button  align="center" style="border-radius: 4px; font-size: 14px; width: 50%; margin: 10px" type="submit">Submit</button>
 
        </div>
        </div>

           <p align="center" style="font-size:10px">*Only UP emails will be allowed to create an account.<br> *Please check your UP mail inbox and spam folder for the password.<br></p>
            <p align="center" style="font-size:10px"></p>

        </div>
      
      </form>
    
    
</div>
</div>
</div>

   </body>
</html>