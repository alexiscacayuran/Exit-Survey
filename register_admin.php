<?php
define('MyConst', TRUE);  
require_once "connection.php";


$up_mail = $password_err = $confirm_password_err ="";
$up_mail_err = $password = $confirm_password = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    
     if(empty(trim($_POST["up_mail"]))){
       
        $up_mail_err = "Please enter a username."; 
    } 
    else{

        $sql = "SELECT id FROM login WHERE up_mail = ?";

        if($stmt = $conn->prepare($sql)){

            $stmt->bind_param("s", $param_up_mail);
            

            $param_up_mail = trim($_POST["up_mail"]);
            

            if($stmt->execute()){

                $stmt->store_result();
                
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

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } 
    elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } 
    else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm your password.";     
    } 
    else{
        $confirm_password = trim($_POST["confirm_password"]);
        
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }






        
    if(empty($up_mail_err) && empty($password_err) && empty($confirm_password_err)){
        

        $sql = "INSERT INTO login (up_mail, password, type) VALUES (?, ?, ?)";
         
        if($stmt = $conn->prepare($sql)){

            $stmt->bind_param("sss", $param_up_mail,  $param_password, $param_type);
            

            $param_up_mail = $up_mail;
            $param_password = $password;
            $param_type = "1";

        if($stmt->execute()){

            header("location: login.php");
            
        }

        $stmt->close();
        }
    }
    

    $conn->close();
}

?>
 
<!DOCTYPE html>


<html>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">


 <link rel="stylesheet" type="text/css" href="survey-style.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">


    <head>
        <title>Admin Registration</title>
    </head>
   


     <div class="survey">
    <div class="justify-content-center align-items-center">
        <div class="col-lg">
        <div id="regForm">
         <div style="position: relative; height: 40px; padding-left: 40px; float: right" id="nextprevious">
            <div class="center">
                <button id="nextBtn" title="Back" type="button" onclick="location.href='./admin.php?class=rating';"><i class="fa fa-arrow-left"></i></button>
            </div>
        </div>
       <h1>Admin Registration</h1>
    



        <table >
        <tr>
        
    
        
    <td style="padding: 20px;">

  <h3 align="center">Sign Up</h3>
        <p>Please enter your desired username and password to create an account to access the results of the survey.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div align="center">
            <div class="form-group" style="margin: 10px; width: 50%">
                <label>Username</label>
                <input type="text" name="up_mail" class="form-control <?php echo (!empty($up_mail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $up_mail; ?>">
                <span class="invalid-feedback"><?php echo $up_mail_err; ?></span>
            </div>    
            <div class="form-group" style="margin: 10px; width: 50%">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group" style="margin: 10px; width: 50%">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>

            <div class="form-group">
                
                <button style="border-radius: 4px; font-size: 14px; width: 50%; margin: 10px" type="submit">Submit</button>
            </div>
            </div>
            </div>
      
      </form>
    
    
</div>
</div>
</div>

   </body>
</html>