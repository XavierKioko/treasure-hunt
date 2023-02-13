<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "/vendor/autoload.php";
function send_mail($email,$message,$subject)
 {  
  $mail = new PHPMailer();
  $mail->IsSMTP(); 
  $mail->SMTPDebug  = 0;                     
  $mail->SMTPAuth   = true;                  
  $mail->SMTPSecure = "ssl";                 
  $mail->Host       = "smtp.gmail.com";      
  $mail->Port       = 465;             
  $mail->AddAddress($email);
  $mail->Username="kiokocodedev@gmail.com";  
  $mail->Password="Kimali10{}";            
  $mail->SetFrom('you@yourdomain.com','Coding Cage');
  $mail->AddReplyTo("you@yourdomain.com","Coding Cage");
  $mail->Subject    = $subject;
  $mail->MsgHTML($message);
  $mail->Send();
 } 
 ?>
