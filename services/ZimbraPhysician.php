<?php
// Create account Zimbra 
//
// Ver 1
//  july 2014
// -------------------------------------
include "DBConnection.php";
include "GetSet.php";
include "ZimbraConnect.php";

class CreatePhysician {
  //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();
       // $phy = new Maintainence();
    }
    
   //parameters to create physician
  public function set_physician_parameters() {
    $GetSet = new GetSet();
    
    $user_email_id = $_POST['txtPhysicianNPI'].'@npi.st'; 
    
    $GetSet->setemailID($user_email_id);
    $NewUserName = $GetSet->getemailID();
    
    $GetSet->setAltemailID($_POST['txtPhysicianEmail']);
    $NewAltUserName = $GetSet->getAltemailID();
    
   /* $GetSet->setpassword($_POST['txtPHYCPassword']);
    $NewUserPassword = $GetSet->getpassword();
    
    $GetSet->setCOS('e245149a-9d1e-4e23-a695-e340ab6c0fb0');
    $COSId = $GetSet->getCOS();
    */
    $GetSet->setdisplayName($_POST['txtPhysicianFname'].' '.$_POST['txtPhysicianLname']);
    $displayName = $GetSet->GetdisplayName();

    $GetSet->setFName($_POST['txtPhysicianFname']);
    $firstName = $GetSet->getFName();

    $GetSet->setMName($_POST['txtPhysicianMname']);
    $midName = $GetSet->getMName();

    $GetSet->setLName($_POST['txtPhysicianLname']);
    $lastName = $GetSet->getLName();

    $GetSet->setcompany($_POST['txtPhysicianAddress1']);
    $address1 = $GetSet->getcompany();

    $GetSet->setjobTitle($_POST['txtPhysicianAddress2']);
    $address2 = $GetSet->getjobTitle();

    $GetSet->setState($_POST['ddlPhysicianState']);
    $state = $GetSet->getState();

    $GetSet->setPhoneNo($_POST['txtPhysicianPhoneNo']);
    $phone = $GetSet->getPhoneNo();
    
    $GetSet->setZip($_POST['txtPhysicianZip']);
    $zip = $GetSet->getZip();
    $GetSet->setCity($_POST['txtPhysicianCity']);
    $city = $GetSet->getCity();
    
    
    
    $result = array('NewUserName'=>$NewUserName,'NewAltUserName' => $NewAltUserName ,'displayName'=>$displayName,'firstName'=>$firstName,'midName'=>$midName,'lastName'=>$lastName,'address1'=>$address1,'address2'=>$address2,'state'=>$state,'phone'=>$phone,'city'=>$city,'zip'=>$zip,'email'=>$user_email_id);
    return $result;
  }
  
   //parameters to create Alias
  public function set_alias_parameters() {
    $GetSet = new GetSet();
    
    $email_id = $_POST['txtAlias'].'@'.$_POST['txtDomainName'].'.st';        
            
    $GetSet->setAliasEmailId($email_id);
    $AliasEmailId = $GetSet->getAliasEmailId();
    
    $target_email_id = $_POST['txtTargetAccount'].'.st';
    $GetSet->setTargetAccount($target_email_id);
    $TargetAccount = $GetSet->getTargetAccount();
    
    $result = array('AliasEmailId'=>$AliasEmailId,'TargetAccount'=>$TargetAccount);
    return $result;
  }
  
  
    //to update zimbra Physician
  public function ZimbraUpdatePhysician () {
     $connect = new Zimbra();
    $param = $this->set_physician_parameters();
    $response = $this->ZimbraUpdatePhysicianAccount(1, $connect->ServerAddress, $connect->AdminUserName, $connect->AdminPassword, $param['NewUserName'], $param['phone']);
    $a='<Code>'; 
    $duplicate = strstr($response, $a);
    if($response == FALSE)
          {
                  printf("ZimbraUpdatePhysicianAccount Failed!<BR>\n");
                  return(FALSE); exit();
          }
    else{
      
      $result = $this->editPhysicianRecord();
      
       return $result;
    }
         
  }
public function create_another_office() {
		
		$username = isset($_GET['user'])?$_GET['user']:'';
		$param = $this->set_office_parameters();
		$COS_name_common = '';
		
		$name_f_l = ''; 
		$name_f_l = strtolower(substr($param['firstName'], 0, 1).substr($param['lastName'], 0, 6));
		
		$COS_name_common = $name_f_l.'-'.substr($param['zip'], 0, 5);
		//$COS_user_name = $COS_name_common.'-user';01
		//$COS_user_name = 'barnes-client-admin';
		$physician_cos_array = explode('-',$_COOKIE['user_cos']);
		$COS_user_name = $physician_cos_array[0].'-client-admin';
		$domain_name = $COS_name_common.'.st';
		
		//$cos_user_response_id = $this->copy_default_cos($COS_user_name); 

        $description = 'Domain '.$domain_name.' with default COS.';
        $domain_response = $this->create_domain($domain_name , $COS_user_name , $description);
		
		$allias_name = $name_f_l.'@'.$domain_name;
        $allias_response = $this->create_physician_allias($param['NewUserName'] , $allias_name);
		//exit();
		if($allias_response === TRUE){
			$sql = "INSERT INTO physician_office SET PhysicianNPI = '".$param['physician_npi']."', 
													PhysicianAddr1 = '".$param['address1']."', 
													PhysicianAddr2 = '".$param['address2']."' , 
													PhysicianCity = '".$param['city']."' , 
													PhysicianSt = '".$param['state']."' , 
													PhysicianZip = '".$param['zip']."' , 
													PhysicianLastUpdateID = '".$username."' ";
			mysql_query($sql);
		}
		return $allias_response;
  }
   public function set_office_parameters() {
        $GetSet = new GetSet();
		//print_r($_POST);exit();
		$GetSet->setPhysicianNPI($_POST['txtPOPPhyNPI']);
		$physician_npi = $GetSet->getPhysicianNPI();
		
        $user_email_id = $_POST['txtPOPPhyNPI'].'@npi.st'; 
		
        $GetSet->setemailID($user_email_id);
        $NewUserName = $GetSet->getemailID();
		
		$GetSet->setFName($_POST['txtPOPPhyFname']);
		$firstName = $GetSet->getFName();

		$GetSet->setLName($_POST['txtPOPPhyLname']);
		$lastName = $GetSet->getLName();
		
        $GetSet->setcompany($_POST['txtPOPPhyAddress1']);
        $address1 = $GetSet->getcompany();

        $GetSet->setjobTitle($_POST['txtPOPPhyAddress2']);
        $address2 = $GetSet->getjobTitle();

        $GetSet->setState($_POST['ddlPOPPhyState']);
        $state = $GetSet->getState();

        $GetSet->setZip($_POST['txtPOPPhyzip']);
        $zip = $GetSet->getZip();
        
        $GetSet->setCity($_POST['txtPOPPhyCity']);
        $city = $GetSet->getCity();

        $result = array('physician_npi' => $physician_npi, 'NewUserName'=>$NewUserName, 'firstName' => $firstName, 'lastName' => $lastName, 'address1'=>$address1,'address2'=>$address2,'state'=>$state,'city'=>$city,'zip'=>$zip);
        return $result;
      }
	  
	  
	public function ZimbraCheckPhysician(){
		$param = $this->set_physician_parameters();
    
		$COS_name_common = '';
		$name_f_l = '';
		$okay = FALSE;    
		$name_f_l = strtolower(substr($param['firstName'], 0, 1).substr($param['lastName'], 0, 6));
		
		$COS_name_common = $name_f_l.'-'.substr($param['zip'], 0, 5);
		
		$domain_name = $COS_name_common.'.st';
		/* Check if Domain and Physician NPI User Exists or not*/
		$okay = $this->check_for_existaince($domain_name , $param['NewUserName']);
		return $okay;
	}  
	public function ZimbraPhysicianCreate(){
    //print_r($_COOKIE);
		$connect = new Zimbra();
		$param = $this->set_physician_parameters();
		
		$COS_name_common = '';
		$name_f_l = '';
		$okay = FALSE;    
		$name_f_l = strtolower(substr($param['firstName'], 0, 1).substr($param['lastName'], 0, 6));
		
		$COS_name_common = $name_f_l.'-'.substr($param['zip'], 0, 5);
		/*
		$COS_admin_name = $COS_name_common.'-admin';
		$COS_user_name = $COS_name_common.'-user';
		*/
		$physician_cos_array = explode('-',$_COOKIE['user_cos']);
		$COS_admin_name = $physician_cos_array[0].'-client-admin';
		$COS_user_name = $physician_cos_array[0].'-client-admin';
		
		$domain_name = $COS_name_common.'.st';
		/*
		$cos_admin_response_id = $this->copy_default_cos($COS_admin_name); 
        $cos_user_response_id = $this->copy_default_cos($COS_user_name); 
		*/
		$cos_admin_response_id = $connect->ZimbraGetCOSID($COS_admin_name);
        $cos_user_response_id = $connect->ZimbraGetCOSID($COS_user_name); 

        $description = 'Domain '.$domain_name.' with default COS.';
        $domain_response = $this->create_domain($domain_name , $COS_user_name , $description);


        $response = $this->ZimbraCreatePhysicianAccount(1, $connect->ServerAddress, $connect->AdminUserName, $connect->AdminPassword, $param['NewUserName'], $param['phone'], $cos_admin_response_id);


        $admin_account_name = 'admin@'.$domain_name;
        $account_response = $this->create_office_admin_account($admin_account_name , $param['phone'] , $cos_admin_response_id , $param['displayName']);

		//$preauth = $this->ZimbraPhysicianPreAuthKey($domain_name , $admin_account_name);
		
        $allias_name = $name_f_l.'@'.$domain_name;
        $allias_response = $this->create_physician_allias($param['NewUserName'] , $allias_name);
        //print_r($response);exit();
        $a='<Code>'; 
        $duplicate = strstr($response, $a);
        if($response == FALSE){
				  printf("ZimbraCreatePhysicianAccount Failed!<BR>\n");
				  return(FALSE); exit();

		}
        elseif(strpos($duplicate,'ACCOUNT_EXISTS') !== false){
          return FALSE;
        }
        else{
			//$alias_response = $this->ZimbraCreatePhysicianAlias(1, $this->ServerAddress, $this->AdminUserName, $this->AdminPassword);
			$result = $this->insertPhysicianRecord();
			return $result;
        }
	}
	
  //to create zimbra Physician
  public function ZimbraCreatePhysician () {
     $connect = new Zimbra();
    
    $param = $this->set_physician_parameters();
    
    $COS_name_common = '';
    $name_f_l = '';
    $okay = FALSE;    
    $name_f_l = strtolower(substr($param['firstName'], 0, 1).substr($param['lastName'], 0, 6));
    
    $COS_name_common = $name_f_l.'-'.substr($param['zip'], 0, 5);
    
    $COS_admin_name = $COS_name_common.'-admin';
    $COS_user_name = $COS_name_common.'-user';
  
    
    $domain_name = $COS_name_common.'.st';
    /* Check if Domain and Physician NPI User Exists or not*/
    $okay = $this->check_for_existaince($domain_name , $param['NewUserName']);
    if($okay){
        $cos_admin_response_id = $this->copy_default_cos($COS_admin_name); 
        $cos_user_response_id = $this->copy_default_cos($COS_user_name); 

        $description = 'Domain '.$domain_name.' with default COS.';
        $domain_response = $this->create_domain($domain_name , $COS_user_name , $description);


        $response = $this->ZimbraCreatePhysicianAccount(1, $connect->ServerAddress, $connect->AdminUserName, $connect->AdminPassword, $param['NewUserName'], $param['phone'], $cos_admin_response_id);


        $admin_account_name = 'admin@'.$domain_name;
        $account_response = $this->create_office_admin_account($admin_account_name , $param['phone'] , $cos_admin_response_id , $param['displayName']);


        $allias_name = $name_f_l.'@'.$domain_name;
        $allias_response = $this->create_physician_allias($param['NewUserName'] , $allias_name);
        //print_r($response);exit();
        $a='<Code>'; 
        $duplicate = strstr($response, $a);
        if($response == FALSE)

              {
                      printf("ZimbraCreatePhysicianAccount Failed!<BR>\n");
                      return(FALSE); exit();

              }
        elseif(strpos($duplicate,'ACCOUNT_EXISTS') !== false){
          return FALSE;

        }
        else{
          //$alias_response = $this->ZimbraCreatePhysicianAlias(1, $this->ServerAddress, $this->AdminUserName, $this->AdminPassword);
          $result = $this->insertPhysicianRecord();


           return $result;


        }
    }else{
        return FALSE;
    }  
  }
  
public function check_for_existaince($domain , $physician_npi_user) {
      $response = FALSE;
      $response = $this->check_for_domain($domain);
      if($response){
            $response = $this->check_for_physician_npi_user($physician_npi_user);
            return $response;
      }else{
            return $response;
      }
  }
  
  public function check_for_physician_npi_user($physician_npi_user) {
		$connect = new Zimbra();
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,           "$connect->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);

        
        // ------ Send the zimbraAdmin AuthRequest -----
        $parameters = $connect->ZimbraConnect();

        // ------ Send the zimbraCreateAccount request -----
        $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                <soap:Header>
                                        <context xmlns="urn:zimbra">
                                                <authToken>' . $parameters['authToken'] . '</authToken>
                                                <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                        </context>
                                </soap:Header>
                                <soap:Body>
                                        <GetAccountRequest  xmlns="urn:zimbraAdmin">
                                            <account by="name">'.$physician_npi_user.'</account>
                                        </GetAccountRequest>
                                </soap:Body>
                        </soap:Envelope>';

        curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
        $ZimbraSOAPResponse = curl_exec($CurlHandle);
        curl_close($CurlHandle);
        //print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
        //exit();
        $a='<Code>'; 
        $exists = strstr($ZimbraSOAPResponse, $a);
        if(!($ZimbraSOAPResponse)){
                //print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
            return FALSE;
        }
        elseif(strpos($exists,'NO_SUCH_ACCOUNT') !== false){
            return TRUE;
        }
        else{
            return FALSE;
        }
  }
  
  public function check_for_domain($domain) {
		$connect = new Zimbra();
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,           "$connect->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);

        // ------ Send the zimbraAdmin AuthRequest -----
        $parameters = $connect->ZimbraConnect();

        // ------ Send the zimbraCreateAccount request -----
        $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                <soap:Header>
                                        <context xmlns="urn:zimbra">
                                                <authToken>' . $parameters['authToken'] . '</authToken>
                                                <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                        </context>
                                </soap:Header>
                                <soap:Body>
                                        <GetDomainRequest xmlns="urn:zimbraAdmin">
                                            <domain by="name">'.$domain.'</domain>
                                        </GetDomainRequest>
                                </soap:Body>
                        </soap:Envelope>';

        curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
        $ZimbraSOAPResponse = curl_exec($CurlHandle);
        curl_close($CurlHandle);
        $a='<Code>'; 
        $exists = strstr($ZimbraSOAPResponse, $a);
        if(!($ZimbraSOAPResponse)){
                //print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
            return FALSE;
        }
        elseif(strpos($exists,'NO_SUCH_DOMAIN') !== false){
            return TRUE;
        }
        else{
            return FALSE;
        }
  }
  
  public function create_physician_allias($target , $allias_name)
  {
        $connect = new Zimbra();
         $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,           "$connect->ServerAddress:7071/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
          curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
          
          
          $id = $connect->ZimbraGetAccountID($target);
          // ------ Send the zimbraAdmin AuthRequest -----
          
          $parameters = $connect->ZimbraConnect();
          
          // ------ Send the zimbraCreateAccount request -----
          $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                  <soap:Header>
                                          <context xmlns="urn:zimbra">
                                                  <authToken>' . $parameters['authToken'] . '</authToken>
                                                  <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                          </context>
                                  </soap:Header>
                                  <soap:Body>
										<AddAccountAliasRequest xmlns="urn:zimbraAdmin" id="'.$id.'" alias="'.$allias_name.'" />
                                  </soap:Body>
                          </soap:Envelope>';

          curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);

          if(!($ZimbraSOAPResponse = curl_exec($CurlHandle)))
          {
                 /// print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                  return(FALSE); exit();
          }
          
          //print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
        curl_close($CurlHandle);
        $a='<soap:Reason><soap:Text>'; 
        $duplicate = strstr($ZimbraSOAPResponse, $a);
        if(strpos($duplicate,'email address already exists') !== false){
            return 'exists';
        }
        elseif(strpos($duplicate,'no such domain') !== false){
            return 'domain_error';
        }
        elseif(strpos($duplicate,'no such account') !== false){
            return 'account_error';
        }
        else{
          return TRUE; 
        }  
          
  }   
  
  public function create_office_admin_account($admin_account_name , $password , $COS_admin_name , $displayName){
       $connect = new Zimbra();
       $username = isset($_GET['user'])?$_GET['user']:'';
        $param = $this->set_physician_parameters();
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,"$connect->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST, TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
        
 
        $parameters = $connect->ZimbraConnect();
        //$cos_detail = $connect->ZimbraGetCOSID($COS_admin_name);
        
         $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                <soap:Header>
                                        <context xmlns="urn:zimbra">
                                                <authToken>' . $parameters['authToken'] . '</authToken>
                                                <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                        </context>
                                </soap:Header>
                                <soap:Body>
                                    <CreateAccountRequest name="'.$admin_account_name.'" password="'.$password.'"  xmlns="urn:zimbraAdmin">
                                        <a n="sn">admin</a>
                                        <a n="zimbraCOSId">'.$COS_admin_name.'</a>
										<a n="displayName">'.$displayName.'</a>
										<a n="mobile">'.$password.'</a>
                                        <a n="description">Administrative Account</a>
                                    </CreateAccountRequest>
                                </soap:Body>
                        </soap:Envelope>';
       
        curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
        $ZimbraSOAPResponse = curl_exec($CurlHandle);
        //print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
        curl_close($CurlHandle);
        $a='<Code>'; 
        $duplicate = strstr($ZimbraSOAPResponse, $a);
        if(!($ZimbraSOAPResponse))
        {
                print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                return(FALSE); exit();
        }
        elseif(strpos($duplicate,'DOMAIN_EXISTS') !== false){
          return 'duplicate';
        }
        else{
          return TRUE;
        }
          
  }

    public function create_domain($Domain_Name , $DefaultCOS , $Description)
{       $connect = new Zimbra(); 
        $username = isset($_GET['user'])?$_GET['user']:'';
        
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,"$connect->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST, TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        
        $parameters = $connect->ZimbraConnect();
        $cos_detail = $connect->ZimbraGetCOSID($DefaultCOS);
        
         $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                <soap:Header>
                                        <context xmlns="urn:zimbra">
                                                <authToken>' . $parameters['authToken'] . '</authToken>
                                                <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                        </context>
                                </soap:Header>
                                <soap:Body>
                                    <CreateDomainRequest xmlns="urn:zimbraAdmin">
                                        <name>'.$Domain_Name.'</name>
                                        <a n="zimbraDomainDefaultCOSId">'.$cos_detail.'</a>
                                        <a n="zimbraNotes">'.$Description.'</a>
                                    </CreateDomainRequest>
                                </soap:Body>
                        </soap:Envelope>';
       
        curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
        $ZimbraSOAPResponse = curl_exec($CurlHandle);
        //print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
        curl_close($CurlHandle);
        $a='<Code>'; 
        $duplicate = strstr($ZimbraSOAPResponse, $a);
        if(!($ZimbraSOAPResponse))
        {
                print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                return(FALSE); exit();
        }
        elseif(strpos($duplicate,'DOMAIN_EXISTS') !== false){
          return 'duplicate';
        }
        else{
          return TRUE;
        }
          
              // print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
        
    }

  
  
  public function copy_default_cos($COS_name){
        $connect = new Zimbra();
        $username = isset($_GET['user'])?$_GET['user']:'';
        
        
        $param = $this->get_default_cos();
        
        $COS_description = $param['COS_description'];
        $COS_notes = $param['COS_notes'];
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,"$connect->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST, TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        
        $parameters = $connect->ZimbraConnect();
        
        
         $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                <soap:Header>
                                        <context xmlns="urn:zimbra">
                                                <authToken>' . $parameters['authToken'] . '</authToken>
                                                <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                        </context>
                                </soap:Header>
                                <soap:Body>
                                            <CopyCosRequest xmlns="urn:zimbraAdmin"> 
                                                <name>'.$COS_name.'</name>
                                                <cos by="id">e245149a-9d1e-4e23-a695-e340ab6c0fb0</cos>
                                            </CopyCosRequest>
                                </soap:Body>
                        </soap:Envelope>';
       
        curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
        $ZimbraSOAPResponse = curl_exec($CurlHandle);
        curl_close($CurlHandle);
        $a='<Code>'; 
        $duplicate = strstr($ZimbraSOAPResponse, $a);
        //echo $ZimbraSOAPResponse;
        if(!($ZimbraSOAPResponse))
        {
                print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                return(FALSE);
        }
  
        elseif(strpos($duplicate,'COS_EXISTS') !== false){
          return FALSE;
        }
        else{
          // split COS id from soap response
          $b="cos id="; 
                $cos = strstr($ZimbraSOAPResponse, $b);
                $cos = strstr($cos, "=");
                $cos = substr($cos, 1, strpos($cos, "/") - 1);
                
                if($cos){
                  $cos_arr = explode(" ",$cos);
                  $cos_code = $cos_arr[0];
                  $cos_code = str_replace('"','',$cos_code); // returns COS value
                  $sql = "INSERT INTO cos(COSID, COSName, COSNotes, COSDescription, LastUpdateID) VALUES ('$cos_code','$COS_name','$COS_notes','$COS_description','$username')";
                $result = mysql_query($sql);
                if (!$result) 
                    {
                    die('Invalid query: ' . $sql . "   " . mysql_error());
                }
                return $cos_code;  
                }   
        }
              // print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
  }
  
  public function get_default_cos(){
         $connect = new Zimbra();
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,"$connect->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST, TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
        
       
        $parameters = $connect->ZimbraConnect();
        
        
         $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                <soap:Header>
                                        <context xmlns="urn:zimbra">
                                                <authToken>' . $parameters['authToken'] . '</authToken>
                                                <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                        </context>
                                </soap:Header>
                                <soap:Body>
                                        <GetCosRequest attrs="description,zimbraNotes" xmlns="urn:zimbraAdmin">
                                            <cos by="id">e245149a-9d1e-4e23-a695-e340ab6c0fb0</cos>
                                        </GetCosRequest>
                                </soap:Body>
                        </soap:Envelope>';
       
        curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
        $ZimbraSOAPResponse = curl_exec($CurlHandle);
        curl_close($CurlHandle);
        //print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
        $cos_desc = '';
        $a=' n="description">'; 
        $cos_desc = strstr($ZimbraSOAPResponse, $a);
        $cos_desc = strstr($cos_desc, ">");
        $cos_desc = substr($cos_desc, 1, strpos($cos_desc, "<") - 1);
        
        $cos_notes = '';
        $b=' n="zimbraNotes">'; 
        $cos_notes = strstr($ZimbraSOAPResponse, $b);
        $cos_notes = strstr($cos_notes, ">");
        $cos_notes = substr($cos_notes, 1, strpos($cos_notes, "<") - 1);
        $params = array('COS_description' => $cos_desc , 'COS_notes' => $cos_notes);
        
        return $params;
        
  }
    public function ZimbraCreatePhysicianAccount($Trace, $ServerAddress, $AdminUserName, $AdminPassword, $NewUserName, $NewUserPassword, $DefaultCOS)
  {

         $connect = new Zimbra();
        $param = $this->set_physician_parameters();
         $phone_arr = explode("-",$param['phone']);
        $password = implode("",$phone_arr);
         $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,           "$connect->ServerAddress:7071/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
          curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);

          // ------ Send the zimbraAdmin AuthRequest -----
         
          $parameters = $connect->ZimbraConnect();
          //$COSId = $connect->ZimbraGetCOSID($DefaultCOS);
          // ------ Send the zimbraCreateAccount request -----
          $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                  <soap:Header>
                                          <context xmlns="urn:zimbra">
                                                  <authToken>' . $parameters['authToken'] . '</authToken>
                                                  <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                          </context>
                                  </soap:Header>
                                  <soap:Body>
                                   <CreateAccountRequest xmlns="urn:zimbraAdmin">
                                                  <name>' . $param['NewUserName']. '</name>
                                                  <password>' . $password . '</password>
                                                  <a n="zimbraCOSId">' . $DefaultCOS . '</a>
                                                  <a n="displayName">'.$param['displayName'].'</a>
                                               <a n="givenName">'.$param['firstName'].'</a>
                                                        <a n="initials">'.$param['midName'].'</a>
                                                    <a n="sn">'.$param['lastName'].'</a>
                                                      
                                                        <a n="street">'.$param['address1'].'</a>
                                                        
                                                          <a n="st">'.$param['state'].'</a>
                                                            <a n="mobile">'.$param['phone'].'</a>
                                                              <a n="l">'.$param['city'].'</a>
                                                                <a n="postalCode">'.$param['zip'].'</a> 
                                                                   <a n="zimbraNotes">'.$param['NewAltUserName'].'</a>
                                          </CreateAccountRequest>
                                  </soap:Body>
                          </soap:Envelope>';

          curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);

          if(!($ZimbraSOAPResponse = curl_exec($CurlHandle)))
          {
                 /// print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                  return(FALSE); exit();
          }

          // print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
          curl_close($CurlHandle);

          return($ZimbraSOAPResponse);
  }
  
  public function ZimbraCreatePhysicianAlias()
  {
         $connect = new Zimbra();
         $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,           "$connect->ServerAddress:7071/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
          curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
          $result = $this->set_alias_parameters();
          $id = $connect->ZimbraGetAccountID($result['TargetAccount']);
          // ------ Send the zimbraAdmin AuthRequest -----
          
          $parameters = $connect->ZimbraConnect();
          
          // ------ Send the zimbraCreateAccount request -----
          $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                  <soap:Header>
                                          <context xmlns="urn:zimbra">
                                                  <authToken>' . $parameters['authToken'] . '</authToken>
                                                  <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                          </context>
                                  </soap:Header>
                                  <soap:Body>
<AddAccountAliasRequest xmlns="urn:zimbraAdmin" id="'.$id.'" alias="'.$result['AliasEmailId'].'" />
                                  </soap:Body>
                          </soap:Envelope>';

          curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);

          if(!($ZimbraSOAPResponse = curl_exec($CurlHandle)))
          {
                 /// print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                  return(FALSE); exit();
          }
          
        //  print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
        curl_close($CurlHandle);
        $a='<soap:Reason><soap:Text>'; 
        $duplicate = strstr($ZimbraSOAPResponse, $a);
        if(strpos($duplicate,'email address already exists') !== false){
            return 'exists';
        }
        elseif(strpos($duplicate,'no such domain') !== false){
            return 'domain_error';
        }
        elseif(strpos($duplicate,'no such account') !== false){
            return 'account_error';
        }
        else{
			$GetSet=new GetSet();
			$GetSet->setLastUpdateID($_GET['src']);
			$LastUpdateID = $GetSet->getLastUpdateID();
			/*$sql = "Insert into physician_alias (PhysicianNPI,PhysicianAlias,PhysicianLastUpdateID) values('".$result['TargetAccount']."','".$result['AliasEmailId']."','$LastUpdateID')";

            $result = mysql_query($sql);
            if (!$result) 
                {
                die('Invalid query: ' . $sql . "   " . mysql_error());
            }*/
			return TRUE; 
        }  
          
  }   
   
  
   public function ZimbraUpdatePhysicianAccount($Trace, $ServerAddress, $AdminUserName, $AdminPassword, $NewUserName, $NewUserPassword){
     $param = $this->set_physician_parameters();
     $connect = new Zimbra();
     $id = $connect->ZimbraGetAccountID($param['email']);
         $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,           "$connect->ServerAddress:7071/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
          curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);

          // ------ Send the zimbraAdmin AuthRequest -----
          $parameters = $connect->ZimbraConnect();
          
          // ------ Send the zimbraCreateAccount request -----
          $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                  <soap:Header>
                                          <context xmlns="urn:zimbra">
                                                  <authToken>' . $parameters['authToken'] . '</authToken>
                                                  <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                          </context>
                                  </soap:Header>
                                  <soap:Body>
                                  
                                  
  <ModifyAccountRequest xmlns="urn:zimbraAdmin" id="'.$id.'">
          
                                                    <a n="displayName">'.$param['displayName'].'</a>
                                                 <a n="givenName">'.$param['firstName'].'</a>
                                                 <a n="initials">'.$param['midName'].'</a>
                                                      <a n="sn">'.$param['lastName'].'</a>
                                                          <a n="street">'.$param['address1'].'</a>
                                                            <a n="st">'.$param['state'].'</a>
                                                              <a n="mobile">'.$param['phone'].'</a>
                                                                <a n="l">'.$param['city'].'</a>
                                                                  <a n="postalCode">'.$param['zip'].'</a> 
                                                                     <a n="zimbraNotes">'.$param['NewAltUserName'].'</a>
      </ModifyAccountRequest>
     
                                  </soap:Body>
                          </soap:Envelope>';

          curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);

          if(!($ZimbraSOAPResponse = curl_exec($CurlHandle)))
          {
                 /// print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                  return(FALSE); exit();
          }

          // print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
          curl_close($CurlHandle);

          return($ZimbraSOAPResponse);
   }
  /*Insert physician record in db*/
    public function insertPhysicianRecord() {
	 $GetSet=new GetSet();
        $GetSet->setPhysicianNPI($_POST['txtPhysicianNPI']);
		$PhysicianNPI=$GetSet->getPhysicianNPI();
		
        $GetSet->setFName($_POST['txtPhysicianFname']);
		$FName = $GetSet->getFName();
		
        $GetSet->setMName($_POST['txtPhysicianMname']);
		$MName = $GetSet->getMName();
        
		$GetSet->setLName($_POST['txtPhysicianLname']);
		$LName = $GetSet->getLName();
		
        $GetSet->setAddress1($_POST['txtPhysicianAddress1']);
		$Address1 = $GetSet->getAddress1();
		
        $GetSet->setAddress2($_POST['txtPhysicianAddress2']);
		$Address2 = $GetSet->getAddress2();
		
        $GetSet->setCity($_POST['txtPhysicianCity']);
		$City = $GetSet->getCity();
		
        $GetSet->setState($_POST['ddlPhysicianState']);
		$State = trim($GetSet->getState());
		
        $GetSet->setZip($_POST['txtPhysicianZip']);
		$Zip = $GetSet->getZip();
		
        $GetSet->setPhoneNo($_POST['txtPhysicianPhoneNo']);
		$PhoneNo = $GetSet->getPhoneNo();
		
    $GetSet->setAltemailID($_POST['txtPhysicianEmail']);
    $AltEmailId = $GetSet->getAltemailID();
    
    $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();

        $SqlCheck = "Select * from physician where PhysicianNPI=$PhysicianNPI";
        $result = mysql_query($SqlCheck);
        $row_count = mysql_num_rows($result);
        if($row_count == 1){
            return FALSE;
        }
        else{
          $sql = "Insert into physician (PhysicianNPI,PhysicianFirstname,PhysicianMidname,PhysicianLastname,PhysicianAddr1,PhysicianAddr2,PhysicianCity,PhysicianSt,PhysicianZip,PhysicianPhone,PhysicianAltEmailId,PhysicianLastUpdateID) values('$PhysicianNPI','$FName','$MName','$LName','$Address1','$Address2','$City','$State','$Zip','$PhoneNo','$AltEmailId','$LastUpdateID')";

            $result = mysql_query($sql);
            if (!$result) 
                {
                die('Invalid query: ' . $sql . "   " . mysql_error());
            }
			//$this->send_email($AltEmailId , $FName ,$LName, $PhysicianNPI , $PhoneNo);
            return TRUE;  
        }
}

public function send_email($to , $FName ,$LName, $user_name, $password) {
    
    // subject
    $subject = 'User Created Suceessfully.';

    // message
    $message = '
    <html>
    <head>
      <title>User Created</title>
    </head>
    <body>
      <p>Change Passowrd!</p>
      <table>
        <tr>
          <th>Dear '.$FName.' '.$LName.',</th>
        </tr>
        <tr>
          <td>Please use following details for login:</td>
        </tr>
        <tr>
          <td><a href="#">Click here for login</a></td>
        </tr>
        <tr>
          <td>Username: '.$user_name.'</td>
        </tr>
        <tr>
          <td>Password: '.$password.'</td>
        </tr>
      </table>
    </body>
    </html>
    ';

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Additional headers
    $headers .= 'To: '.$FName .' '.$LName.' <'.$to.'>' . "\r\n";
    
    // Mail it
    mail($to, $subject, $message, $headers);
    return TRUE;
}

    /*Edit physician record*/
   public function editPhysicianRecord() {
        $GetSet=new GetSet();
        $GetSet->setPhysicianNPI($_POST['txtPhysicianNPI']);
		$PhysicianNPI=$GetSet->getPhysicianNPI();
		$GetSet->setFName($_POST['txtPhysicianFname']);
		$FName = $GetSet->getFName();
        $GetSet->setMName($_POST['txtPhysicianMname']);
		$MName = $GetSet->getMName();
		$GetSet->setLName($_POST['txtPhysicianLname']);
		$LName = $GetSet->getLName();
        $GetSet->setAddress1($_POST['txtPhysicianAddress1']);
		$Address1 = $GetSet->getAddress1();
        $GetSet->setAddress2($_POST['txtPhysicianAddress2']);
		$Address2 = $GetSet->getAddress2();
        $GetSet->setCity($_POST['txtPhysicianCity']);
		$City = $GetSet->getCity();
        $GetSet->setState($_POST['ddlPhysicianState']);
		$State = trim($GetSet->getState());
        $GetSet->setZip($_POST['txtPhysicianZip']);
		$Zip = $GetSet->getZip();
        $GetSet->setPhoneNo($_POST['txtPhysicianPhoneNo']);
		$PhoneNo = $GetSet->getPhoneNo();
		
    $GetSet->setAltemailID($_POST['txtPhysicianEmail']);
    $AltEmailId = $GetSet->getAltemailID();
    
    $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
		
            $SqlCheck = "SELECT PhysicianNPI FROM physician WHERE PhysicianNPI = '$PhysicianNPI'";
            $result = mysql_query($SqlCheck);
            if($result){
               $row_count = mysql_num_rows($result);
                if($row_count == 1){
                    
                   $sql = "UPDATE physician SET PhysicianLastname='$LName',PhysicianMidname='$MName',PhysicianFirstname='$FName',PhysicianAddr1='$Address1',PhysicianAddr2='$Address2',PhysicianCity='$City',PhysicianSt='$State',PhysicianZip='$Zip',PhysicianPhone='$PhoneNo', PhysicianAltEmailId='$AltEmailId',PhysicianLastUpdateID='$LastUpdateID',PhysicianLastUpdate=NOW()  where PhysicianNPI= '$PhysicianNPI'";
                  $result1 = mysql_query($sql);
                if (!$result1) 
                  {
                   die('Invalid query: ' . $sql . "   " . mysql_error());
                  }
                    return TRUE;
                } 
            }
            else{
                return FALSE;  
            }
   }
   public function ZimbraPhysicianPreAuthKey(){
		
		$param = $this->set_physician_parameters();
		$COS_name_common = '';
		$name_f_l = '';
		   
		$name_f_l = strtolower(substr($param['firstName'], 0, 1).substr($param['lastName'], 0, 6));

		$COS_name_common = $name_f_l.'-'.substr($param['zip'], 0, 5);

		$domain_name = $COS_name_common.'.st';
		$admin_account_name = 'admin@'.$domain_name;
		
		//$domain = 'npi.st';
		$connect = new Zimbra();
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,           "$connect->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);

        // ------ Send the zimbraAdmin AuthRequest -----
        $parameters = $connect->ZimbraConnect();

        // ------ Send the zimbraCreateAccount request -----
        $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                <soap:Header>
                                        <context xmlns="urn:zimbra">
                                                <authToken>' . $parameters['authToken'] . '</authToken>
                                                <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                        </context>
                                </soap:Header>
                                <soap:Body>
                                        <GetDomainRequest xmlns="urn:zimbraAdmin">
                                            <domain by="name">'.$domain_name.'</domain>
                                        </GetDomainRequest>
                                </soap:Body>
                        </soap:Envelope>';

        curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
        $ZimbraSOAPResponse = curl_exec($CurlHandle);
        curl_close($CurlHandle);
		$cos_desc = '';
        $a = '<domain id="'; 
        $domain_id = strstr($ZimbraSOAPResponse, $a);
        //$domain_id = strstr($domain_id, '" name="');
        $domain_id = substr($domain_id, 12, strpos($domain_id, '" name="') - 12);
		//exit();
		//print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
		
        $a='<Code>'; 
        $exists = strstr($ZimbraSOAPResponse, $a);
        if(!($ZimbraSOAPResponse)){
                //print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
            return FALSE;
        }
        elseif(strpos($exists,'NO_SUCH_DOMAIN') !== false){
            return FALSE;
        }
        else{
            $PREAUTH_KEY="0f6f5bbf7f3ee4e99e2d24a7091e262db37eb9542bc921b2ae4434fcb6338284";
			$timestamp = time()*1000;
			//$email = $_GET["email"];
			//$email = '1111111111@npi.st';
			$preauthToken = hash_hmac("sha1",$admin_account_name."|name|0|".$timestamp,$PREAUTH_KEY);
			
			$connect = new Zimbra(); 
			//$username = isset($_GET['user'])?$_GET['user']:'';
			
			$CurlHandle = curl_init();
			curl_setopt($CurlHandle, CURLOPT_URL,"$connect->ServerAddress:7071/service/admin/soap");
			curl_setopt($CurlHandle, CURLOPT_POST, TRUE);
			curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
			
			
			$parameters = $connect->ZimbraConnect();
			
			 $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
									<soap:Header>
											<context xmlns="urn:zimbra">
													<authToken>' . $parameters['authToken'] . '</authToken>
													<sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
											</context>
									</soap:Header>
									<soap:Body>
										<ModifyDomainRequest xmlns="urn:zimbraAdmin">
											<id>'.$domain_id.'</id>
											<a n="zimbraPreAuthKey">'.$preauthToken.'</a>
										</ModifyDomainRequest> 
									</soap:Body>
							</soap:Envelope>';
		   
			curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
			$ZimbraSOAPResponse = curl_exec($CurlHandle);
			//print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
			curl_close($CurlHandle);
			if(!($ZimbraSOAPResponse))
			{
					print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
					return(FALSE); exit();
			}
			else{
			  return TRUE;
			}
        }
   }
}
$possible_url = array("ZimbraCreatePhysician","ZimbraCreatePhysicianAlias","ZimbraUpdatePhysician", "get_default_cos", "create_another_office","ZimbraCheckPhysician" ,"ZimbraPhysicianCreate" , "ZimbraPhysicianPreAuthKey");
 $value = "An error has occurred";
 $cms = new CreatePhysician();
  if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
      switch ($_GET["action"]) {
       case "ZimbraCreatePhysician" :
                $value = $cms->ZimbraCreatePhysician();
            break;
      case "ZimbraCreatePhysicianAlias" :
                $value = $cms->ZimbraCreatePhysicianAlias();
            break;
      case "ZimbraUpdatePhysician" :
                $value = $cms->ZimbraUpdatePhysician();
            break;
      case "get_default_cos" :
                $value = $cms->get_default_cos();
            break;
		case "create_another_office" :
                $value = $cms->create_another_office();
            break;
		case "ZimbraCheckPhysician" :
                $value = $cms->ZimbraCheckPhysician();
            break;
      case "ZimbraPhysicianCreate" :
                $value = $cms->ZimbraPhysicianCreate();
            break;
      case "ZimbraPhysicianPreAuthKey" :
                $value = $cms->ZimbraPhysicianPreAuthKey();
            break;
      }
  }
   echo json_encode($value);


