<?php

include 'EmailConnect.php'; // include the smtp connect file

class SendToDrOfficeEmail {
	public function mail() {
		// message
		$body = "<html>
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
		</html>";
		$connect = new EmailConnect();
		$mail = $connect->setSmtpParameters();
		//$send = isset($_GET["send"])?$_GET["send"]:'';
		$mail->Subject = "Record is sent to Dr. office"; //Subject of your mail
		$mail->addAddress($_GET["send"]);
		$mail->MsgHTML($body);
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
 $cms = new SendToDrOfficeEmail();
  if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
      switch ($_GET["action"]) {
        case "mail" :
                $value = $cms->mail();
            break;

      }
  }
   echo json_encode($value);
	
?>
