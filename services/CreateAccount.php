<?php
// Create account Zimbra 
//
// Ver 1
//  july 2014
// -------------------------------------
include "DBConnection.php";
include "GetSet.php";
include "ZimbraConnect.php";
class CreateUser {
  //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();
       // $phy = new Maintainence();
    }
    
 
  //parameters to create user
  public function set_user_parameters() {
    $GetSet = new GetSet();
    $GetSet->setemailID($_POST['txtAccountName'].$_POST['hiddenDomain']);
    $NewUserName = $GetSet->getemailID();
    
   // $GetSet->setpassword($_POST['txtCPassword']);
    //$NewUserPassword = $GetSet->getpassword();
      if($_POST['isadmin'] == '1'){
        $cos_append = 'admin';
      }
      if($_POST['isadmin'] == '0'){
        $cos_append = 'user';
      }
    $GetSet->setdisplayName($_POST['txtDisplayNaMe']);
    $displayName = $GetSet->GetdisplayName();

    $GetSet->setFName($_POST['txtFirstName']);
    $firstName = $GetSet->getFName();

    $GetSet->setMName($_POST['txtMiddleInitial']);
    $midName = $GetSet->getMName();

    $GetSet->setLName($_POST['txtLastName']);
    $lastName = $GetSet->getLName();

    $GetSet->setcompany($_POST['txCompany']);
    $company = $GetSet->getcompany();

    $GetSet->setjobTitle($_POST['txCompanyTitle']);
    $jobTitle = $GetSet->getjobTitle();

    $GetSet->setState($_POST['ddlUState']);
    $state = $GetSet->getState();

    $GetSet->setPhoneNo($_POST['txtUPhoneno']);
    $phone = $GetSet->getPhoneNo();
    
    $GetSet->setZip($_POST['txtUZip']);
    $zip = $GetSet->getZip();
    $GetSet->setCity($_POST['txtUCity']);
    $city = $GetSet->getCity();
    $GetSet->setAltemailID($_POST['txtAltMailID']);
    $AltMailID = $GetSet->getAltemailID();
    
    
    $result = array('NewUserName'=>$NewUserName,'displayName'=>$displayName,'firstName'=>$firstName,'midName'=>$midName,'lastName'=>$lastName,'company'=>$company,'jobTitle'=>$jobTitle,'state'=>$state,'phone'=>$phone,'city'=>$city,'zip'=>$zip,'cos_append'=>$cos_append,'AltMailID'=>$AltMailID);
    return $result;
  }
    
  //parameters to change user's password
  public function set_new_user_parameters() {
    $GetSet = new GetSet();
          $GetSet->setupdatePassword($_POST['txtRChangePassword']);
    $updatePassword = $GetSet->getupdatePassword();
     $GetSet->setID($_POST['HiddenInputID']);
    $zimbraID = $GetSet->getID();
    $GetSet->setoldPassword($_POST['txtOldPassword']);
    $oldPassword = $GetSet->getoldPassword();
    
   $result = array('updatePassword'=>$updatePassword,'zimbraID'=>$zimbraID,'oldPassword'=>$oldPassword);
    return $result;
  }
 
     //to create zimbra Admin Account
  public function ZimbraAdminCreateAccount($Trace, $ServerAddress, $AdminUserName, $AdminPassword, $NewUserName, $NewUserPassword, $COSId)
  {
        $connect = new Zimbra();
        $param = $this->set_user_parameters();
        $pass = explode("-",$param['phone']);
        $password = implode("",$pass);
        $physician_cos_array = explode('-',$_COOKIE['user_cos']);
        $COS_user_name = $physician_cos_array[0].'-client-'.$param['cos_append'];
        $cosID = $connect->ZimbraGetCOSID($COS_user_name);
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
                                          <CreateAccountRequest xmlns="urn:zimbraAdmin">
                                                  <name>' . $param['NewUserName'].'.st' . '</name>
                                                  <password>' . $password . '</password>
                                                  <a n="zimbraCOSId">' . $cosID . '</a>
                                                  <a n="displayName">'.$param['displayName'].'</a>
                                               <a n="givenName">'.$param['firstName'].'</a>
                                                        <a n="initials">'.$param['midName'].'</a>
                                                    <a n="sn">'.$param['lastName'].'</a>
                                                      
                                                        <a n="company">'.$param['company'].'</a>
                                                        <a n="title">'.$param['jobTitle'].'</a>
                                                          <a n="st">'.$param['state'].'</a>
                                                            <a n="mobile">'.$param['phone'].'</a>
                                                              <a n="l">'.$param['city'].'</a>
                                                                <a n="postalCode">'.$param['zip'].'</a>
                                                                  <a n="zimbraNotes">'.$param['AltMailID'].'</a>
                                                                  
                                          </CreateAccountRequest>
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

          return($ZimbraSOAPResponse);
  }
  
   //to create zimbra User
  public function ZimbraCreateUser () {
     $connect = new Zimbra();
    $param = $this->set_user_parameters();
    $physician_cos_array = explode('-',$_COOKIE['user_cos']);
    $COS_user_name = $physician_cos_array[0].'-client-user';
    
    $response = $this->ZimbraAdminCreateAccount(1, $connect->ServerAddress, $connect->AdminUserName, $connect->AdminPassword, $param['NewUserName'], $param['phone'], $COS_user_name);
    $a='<Code>'; 
    $duplicate = strstr($response, $a);
    if($response == FALSE)
          {
                  printf("ZimbraAdminCreateAccount Failed!<BR>\n");
                  return(FALSE); exit();
          }
    elseif(strpos($duplicate,'ACCOUNT_EXISTS') !== false){
      return 'duplicate';
    }
    else{
       return TRUE;
    }
         
  }
    //For change password
  public function ZimbraUpdatePassword()
{       
      $connect = new Zimbra();
        $param = $this->set_new_user_parameters();
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,           "$connect->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
        
      
        $parameters = $connect->ZimbraConnect();
        //$id = $connect->ZimbraGetAccountID($param['zimbraID']);
        
         $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                <soap:Header>
                                        <context xmlns="urn:zimbra">
                                                <authToken>' . $parameters['authToken'] . '</authToken>
                                                <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                        </context>
                                </soap:Header>
                                <soap:Body>
                                       
                                <ChangePasswordRequest xmlns="urn:zimbraAccount">
                                       <account by="name">'.$param['zimbraID'].'</account>
                                       <oldPassword>'.$param['oldPassword'].'</oldPassword>
                                       <password>'.$param['updatePassword'].'</password>
                                   </ChangePasswordRequest>
                                </soap:Body>
                        </soap:Envelope>';

        curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
       
        if(!($ZimbraSOAPResponse = curl_exec($CurlHandle)))
        {
                print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                return(FALSE); exit();
        }
         else{
            $a='<Code>'; 
            $duplicate = strstr($ZimbraSOAPResponse, $a);
            if(strpos($duplicate,'AUTH_FAILED') !== false){
              return 'duplicate';
            }
            else{
               //print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
               return TRUE;
            }
         }
        
         
        curl_close($CurlHandle);
        
}
}
$possible_url = array("ZimbraCreateUser","ZimbraUpdatePassword");
 $value = "An error has occurred";
 $cms = new CreateUser();
  if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
      switch ($_GET["action"]) {
          case "ZimbraCreateUser" :
              $value = $cms->ZimbraCreateUser();
              break;  
          case "ZimbraUpdatePassword" :
              $value = $cms->ZimbraUpdatePassword();
              break;
      
      }
  }
   echo json_encode($value);


