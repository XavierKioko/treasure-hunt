<?php
session_start();
require_once 'class.user.php';
require_once 'mailsending.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
 $reg_user->redirect('home.php');
}


if(isset($_POST['btn-signup']))
{
 $fname = trim($_POST['txtfname']);
 $lname = trim($_POST['txtlname']);
 $dob = trim($_POST['txtdob']);
 $email = trim($_POST['txtemail']);
 $mnumber = trim($_POST['txtmnumber']);
 $gender = trim($_POST['txtgender']);
 $idtype = trim($_POST['txtidtype']);
 $idnumber = trim($_POST['txtidnumber']);
 $countryoforigin = trim($_POST['txtcountryoforigin']);
 $upass = trim($_POST[md5('txtpass')]);
 $code = md5(uniqid(rand()));

 // File upload path
$targetDir = "profilepicturesusers/";
$uimage = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $uimage;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);


 
 $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
 $stmt->execute(array(":email_id"=>$email));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
 if($stmt->rowCount() > 0)
 {
  $msg = "
        <div class='alert alert-error'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  email already exists , Please Try another one
     </div>
     ";
 }
 else
 {
  if($reg_user->register($fname,$lname,$dob,$email,$mnumber,$gender,$idtype,$idnumber,$countryoforigin,$upass,$uimage,$code))
  {   
   $id = $reg_user->lasdID();  
   $key = base64_encode($id);
   $id = $key;
   
   $message = "     
      Hello $fname $lname,
      <br /><br />
      Welcome to the treasure hunt!<br/>
      To complete your registration  please , just click following link<br/>
      <br /><br />
      <a href='http://www.SITE_URL.com/verify.php?id=$id&code=$code'>Click HERE to Activate :)</a>
      <br /><br />
      Thanks,";
      
   $subject = "Confirm Registration";
      
   $reg_user->send_mail($email,$message,$subject); 
   $msg = "
     <div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Success!</strong>  We've sent an email to $email.
                    Please click on the confirmation link in the email to create your account. 
       </div>
     ";
  }
  else
  {
   echo "sorry , Query could not execute...";
  }  
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

    <title>Regisration Form </title> 
</head>
<body>
    <div class="container">
        <header>Registration</header>

        <form method="POST" enctype="multipart/form-data">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>First Name</label>
                            <input type="text" name="txtfname" placeholder="Enter your name" required>
                        </div>
                        <div class="input-field">
                            <label>Last Name</label>
                            <input type="text" name="txtlname" placeholder="Enter your name" required>
                        </div>

                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" name="txtdob" placeholder="Enter birth date" required>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" name="txtemail" placeholder="Enter your email" required>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="number" name="txtmnumber" placeholder="Enter mobile number" required>
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <select name="txtgender" required>
                                <option disabled selected>Select gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Others</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Identity Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Identification Type</label>
                            <select name="txtidtype" required>
                                <option disabled selected>Select Identification</option>
                                <option>Kenyan National ID</option>
                                <option>Passport</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>ID Number</label>
                            <input type="text" name="txtidnumber" placeholder="Enter ID number" required>
                        </div>

                        <div class="input-field">
                            <label>Country of Origin</label>
                            <select name="txtcountryoforigin" required>
                                <option disabled selected>Select Country</option>
                                <option>Kenya</option>
                                <option>Uganda</option>
                                <option>Tanzania</option>
                                <option>Rwanda</option>
                                <option>Burundi</option>
                                <option>Ethiopia</option>
                                <option>Sudan</option>
                                <option>South Sudan</option>
                                <option>Somalia</option>
                                <option>Djibouti</option>
                                <option>Eritrea</option>
                                <option>Nigeria</option>
                                <option>South Africa</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Password</label>
                            <input type="password" name="txtpass" placeholder="Enter Password" required>
                        </div>
                        <div class="input-field">
                            <label>Add Profile Picture</label>
                            <input type="file" name="txtimage" required>
                        </div>
                        <div class="tacbox">
                        <input id="checkbox" type="checkbox" required/>
                        <label for="checkbox"> I agree to these <a href="#">Terms and Conditions</a>.</label>
                    </div>
                    <div class="account">
                            <label>Have an account?<a href="login.php">Login</a></label>
                        </div>

                    </div>
                    <button class="sumbit" name="btn-signup">
                            <span class="btnText">Submit</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                </div> 
            </div>                        
        </form>
    </div>
</body>
</html>