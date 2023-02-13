<?php

require_once 'dbconfig.php';

class USER
{ 

 private $conn;
 
 public function __construct()
 {
  $database = new Database();
  $db = $database->dbConnection();
  $this->conn = $db;
    }
 
 public function runQuery($sql)
 {
  $stmt = $this->conn->prepare($sql);
  return $stmt;
 }
 
 public function lasdID()
 {
  $stmt = $this->conn->lastInsertId();
  return $stmt;
 }
 
 public function register($fname,$lname,$dob,$email,$mnumber,$gender,$idtype,$idnumber,$countryoforigin,$upass,$uimage,$code)
 {
  try
  {       
   $password = md5($upass);
   $stmt = $this->conn->prepare("INSERT INTO tbl_users(userFname,userSname,userDob,userEmail,userMobile,userGender,userIDType,userIDNumber,userCountryoforigin,userPicture,userPass,tokenCode) 
                                                VALUES(:user_fname,:user_lname,:user_dob, :user_mail,:user_mnumber,:user_gender,:user_idtype,:user_idnumber,:user_countryoforigin,:user_image, :user_pass, :active_code)");
   $stmt->bindparam(":user_fname",$fname);
   $stmt->bindparam(":user_lname",$lname);
   $stmt->bindparam(":user_dob",$dob);
   $stmt->bindparam(":user_mail",$email);
   $stmt->bindparam(":user_mnumber",$mnumber);
   $stmt->bindparam(":user_gender",$gender);
   $stmt->bindparam(":user_idtype",$idtype);
   $stmt->bindparam(":user_idnumber",$idnumber);
   $stmt->bindparam(":user_countryoforigin",$countryoforigin);
   $stmt->bindparam(":user_pass",$upass);
   $stmt->bindparam(":user_image",$uimage);
   $stmt->bindparam(":active_code",$code);
   $stmt->execute(); 
   return $stmt;
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }
 
 public function login($email,$upass)
 {
  try
  {
   $stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
   $stmt->execute(array(":email_id"=>$email));
   $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
   
   if($stmt->rowCount() == 1)
   {
    if($userRow['userStatus']=="Y")
    {
     if($userRow['userPass']==md5($upass))
     {
      $_SESSION['userSession'] = $userRow['userID'];
      return true;
     }
     else
     {
      header("Location: login.php?error");
      exit;
     }
    }
    else
    {
     header("Location: login.php?inactive");
     exit;
    } 
   }
   else
   {
    header("Location: login.php?error");
    exit;
   }  
  }
  catch(PDOException $ex)
  {
   echo $ex->getMessage();
  }
 }
 
 
 public function is_logged_in()
 {
  if(isset($_SESSION['userSession']))
  {
   return true;
  }
 }
 
 public function redirect($url)
 {
  header("Location: $url");
 }
 
 public function logout()
 {
  session_destroy();
  $_SESSION['userSession'] = false;
 }
}