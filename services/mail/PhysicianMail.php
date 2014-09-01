<?php

include 'EmailConnect.php'; // include the smtp connect file

class PhysicianEmail {
	public function mail() {
	
	//Name
    $name=$_POST["txtPhysicianFname"].' '.$_POST["txtPhysicianMname"].' '.$_POST["txtPhysicianLname"];
		// Username
		$name_f_l = strtolower(substr($_POST['txtPhysicianFname'], 0, 1).substr($_POST['txtPhysicianLname'], 0, 6));
		$domain_name = $name_f_l.'-'.substr($_POST['txtPhysicianZip'], 0, 5);
		$admin_account_name = 'admin@'.$domain_name;
		
		//Password
		$pass = explode('-',$_POST['txtPhysicianPhoneNo']);
		$password = implode("",$pass);		
		
		// message
		$body = "<html>
		<head>
		  <title>Physician is Created successfully</title>
		</head>
		<body>
		<table width='100%'>
		<tr><td>
			<img alt='' src='http://103.14.96.74/signatouch/resources/images/SignaTouch.png' /></td>
			</tr>
			<tr>
					 <td><font size='5'><b>High Efficiency Signature Capture System<b></font></td>
				</tr>
			
		<tr><td><br /></td></tr>
		<tr><td>Dear , ".$name."</td></tr>
		<tr><td></td></tr>
		<tr><td> Your Account is Created successfully!</td></tr>
		<tr><td></td></tr>
		<tr><td> 
			<table>
				<tr>
				  
					<td colspan='2'>Physician Information:</td>
				</tr>
				<tr>
					<td><b>NPI :</b></td>
					<td>".$_POST["txtPhysicianNPI"]."</td>
				</tr>
				  <tr>
					<td><b>Name :</b></td>
					<td>".$name."</td>
				</tr>
				<tr>
					 <td><b>Username :</b></td>
					<td>".$admin_account_name."</td>
				</tr>
				<tr>
					 <td><b>Password :</b></td>
					<td>".$password."</td>
				</tr>
					<tr>
					 <td><b>Alt. Email ID :</b></td>
					<td>".$_POST["txtPhysicianEmail"]."</td>
				</tr>	   
				
				<tr>
					 <td></td>
					<td></td>
				</tr>
				
			</table>


			</td></tr>
		<tr><td></td></tr>
		   <tr><td> Please <a href='http://103.14.96.74/signatouch' target='a'>Here Login </a> and Change your Password. 
			</td></tr>
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
		
		$mail->Subject = "Physician is Created successfully"; //Subject of your mail
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
 $cms = new PhysicianEmail();
  if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
      switch ($_GET["action"]) {
        case "mail" :
                $value = $cms->mail();
            break;

      }
  }
   echo json_encode($value);
	
?>
