<?php
include 'library.php'; // include the library file
include "classes/class.phpmailer.php"; // include the class name
if(isset($_GET["send"])){
	$email = $_GET["send"];
	$mail	= new PHPMailer; // call the class 
	$mail->IsSMTP(); 
	$mail->Host = 'smtp.gyaantech.com'; //Hostname of the mail server
	$mail->Port = 25; //Port of the SMTP like to be 25, 80, 465 or 587
	$mail->SMTPAuth = true; //Whether to use SMTP authentication
	$mail->Username = 'abhinav@gyaantech.com';                   // SMTP username
$mail->Password = 'Abhinav@123';               // SMTP password
	
	//$mail->AddReplyTo("reply@yourdomain.com", "Reply name"); //reply-to address
	$mail->SetFrom('smit.abhinavkant@gmail.com', 'abhinav kant');     //Set who the message is to be sent from
	//$mail->SetFrom("from@yourdomain.com", "Asif18 SMTP Mailer"); //From address of the mail
	// put your while loop here like below,
	$mail->Subject = "Your Record is Sent To Dr. office"; //Subject od your mail
	$mail->addAddress('jayshree@gyaantech.com', 'jayshree');  // Add a recipient
$mail->addAddress($email);               // Name is optional
	$mail->MsgHTML("<b>Hi, Your Record is Sent To Dr. office successfully.</b>"); //Put your body of the message you can place html code here
	//$mail->AddAttachment("images/asif18-logo.png"); //Attach a file here if any or comment this line, 
	$send = $mail->Send(); //Send the mails
	if($send){
		$result  = TRUE;
	}
	else{
		$result  = FALSE;
	}
}
  echo json_encode($result);
?>
