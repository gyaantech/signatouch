<?php

include 'EmailConnect.php'; // include the smtp connect file
class SendEmail {
	public function mail() {
		$connect = new EmailConnect();
		$mail = $connect->setSmtpParameters();
		$mail->Subject = "test mail"; //Subject of your mail
		$mail->addAddress("abhinav@gyaantech.com");
		$mail->MsgHTML("<p>test mail</p>");
		$send = $mail->Send();
		if($send){
		$result  = TRUE;
		}
		else{
		$result  = FALSE;
		}
		return $result;
	}
}
$possible_url = array("mail");
 $value = "An error has occurred";
 $cms = new SendEmail();
  if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
      switch ($_GET["action"]) {
        case "mail" :
                $value = $cms->mail();
            break;

      }
  }
   echo json_encode($value);

?>
