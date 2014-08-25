<?php

include 'library.php'; // include the library file
include "classes/class.phpmailer.php"; // include the class name

class EmailConnect{
	public function setSmtpParameters(){
		 $mail = new PHPMailer; // call the class 
		 $mail->IsSMTP(); 
		 $mail->Host = 'smtp.gyaantech.com'; //Hostname of the mail server
		 $mail->Port = 25; //Port of the SMTP like to be 25, 80, 465 or 587
		 $mail->SMTPAuth = true; //Whether to use SMTP authentication
		 $mail->Username = 'abhinav@gyaantech.com';                   // SMTP username
		 $mail->Password = 'Abhinav@123';               // SMTP password

		//$mail->AddReplyTo("reply@yourdomain.com", "Reply name"); //reply-to address

		 $mail->SetFrom('abhinav@gyaantech.com', 'Abhinav kant');     //Set who the message is to be sent from

		$mail->AddCC("jayshree@gyaantech.com", "Jayshree"); //From address of the mail

		// put your while loop here like below,
		 //$mail->Subject = "Record is Sent To Dr. office"; //Subject od your mail
		 //$mail->addAddress('jayshree@gyaantech.com', 'jayshree');  // Add a recipient
		return $mail;
	}
	
}
  
  
?>
