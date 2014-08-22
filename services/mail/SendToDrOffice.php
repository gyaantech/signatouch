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
	
	$mail->SetFrom('abhinav@gyaantech.com', 'Abhinav kant');     //Set who the message is to be sent from
	
	//$mail->SetFrom("from@yourdomain.com", "Asif18 SMTP Mailer"); //From address of the mail
	
	// put your while loop here like below,
	$mail->Subject = "Record is Sent To Dr. office"; //Subject od your mail
	$mail->addAddress('jayshree@gyaantech.com', 'jayshree');  // Add a recipient

	$mail->addAddress($email);               // Name is optional
	
	// message
$mail->MsgHTML ("<html>
<head>
  <title>Record is Sent To Dr. office successfully.</title>
</head>
<body>
<table width='100%'>
<tr><td>
    <table>
        <tr>
            <td><img alt='' src='http://103.14.96.74/signatouch/resources/images/SignaTouch.png' /></td>
             <td><font size='5'><b>High Efficiency Signature Capture System<b></font></td>
        </tr>
    </table>
    </td></tr>
<tr><td><br /></td></tr>
<tr><td>Dear , ".$_GET["Name"]."</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td> Record is Sent To Dr. office successfully!</td></tr>
<tr><td></td></tr>
<tr><td> 
    <table>
        <tr>
          
            <td colspan='2'><b>Patient Information:</b></td>
        </tr>
          <tr>
            <td width='140px'><b>Cert Type :</b></td>
            <td></td>
        </tr>
        <tr>
             <td><b>Date :</b></td>
            <td></td>
        </tr>
         <tr>
            <td><b>Supplier NPI :</b></td>
            <td></td>
        </tr>
        
       
        <tr>
            <td><b>Patient HICN :</b></td>
            <td></td>
        </tr>
        <tr>
             <td><b>Patient Name :</b></td>
            <td></td>
        </tr>
        <tr>
             <td><b>Phone No :</b></td>
            <td></td>
        </tr>

        <tr>
             <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
             <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>


    </td></tr>
<tr><td>&nbsp;</td></tr>
   <tr><td>
    &nbsp;</td></tr>
<tr><td>Thanks & Regards,</td></tr>
<tr><td>Admin<br /></td> </tr>
<tr><td><b>CMS-484</b></td></tr>
<tr><td>
</td></tr>
</table>
</body>
</html>");



	//$mail->MsgHTML("<b>Hi, Your Record is Sent To Dr. office successfully.</b>"); //Put your body of the message you can place html code here
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
