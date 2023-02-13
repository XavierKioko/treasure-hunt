<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
 $user_login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
 $email = trim($_POST['txtemail']);
 $upass = trim($_POST['txtupass']);
 
 if($user_login->login($email,$upass))
 {
  $user_login->redirect('home.php');
 }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="registrationandlogin.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Login Form </title> 
</head>
<body>
    <div class="container">
    <?php 
  if(isset($_GET['inactive']))
  {
   ?>
            <div class='alert alert-error'>
    <button class='close' data-dismiss='alert'>&times;</button>
    <strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it. 
   </div>
            <?php
  }
  ?>
        <form class="form-signin" method="post">
        <?php
        if(isset($_GET['error']))
  {
   ?>
            <div class='alert alert-success'>
    <strong>(-Sorry Wrong Email/Password! -)</strong> 
   </div>
            <?php
  }
  ?>
        <header>Login</header>

        <form action="#">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Login Details</span>
                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" placeholder="Enter your email" name="txtemail" required>
                        </div>
                        <div class="input-field">
                            <label>Password</label>
                            <input type="password" placeholder="Enter Password" name="txtupass" required>
                        </div>
                    </div>
                    <div class="account">
                            <label>Dont have an account?<a href="registration.php">Registration</a></label>
                        </div>
                        <div class="account">
                            <label>Forgot Password?<a href="resetpass.php">Reset Password</a></label>
                        </div>
                        <button class="submit" name="btn-login">
                            <span class="btnText">Submit</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                </div> 
            </div>                        
        </form>
    </div>
</body>
</html>
