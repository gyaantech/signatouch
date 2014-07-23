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
  
   private $ServerAddress = 'https://msg96.isigndit.com';
  private $AdminUserName  = "zimbra";
  private $AdminPassword = "As8wriWew";
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
    
    $GetSet->setpassword($_POST['txtCPassword']);
    $NewUserPassword = $GetSet->getpassword();

    $GetSet->setCOS($_POST['txtSectionType']);
    $COSId = $GetSet->getCOS();

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
    
    
    
    $result = array('NewUserName'=>$NewUserName,'NewUserPassword'=>$NewUserPassword,'COSId'=>$COSId,'displayName'=>$displayName,'firstName'=>$firstName,'midName'=>$midName,'lastName'=>$lastName,'company'=>$company,'jobTitle'=>$jobTitle,'state'=>$state,'phone'=>$phone,'city'=>$city,'zip'=>$zip);
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
        $param = $this->set_user_parameters();
         $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,           "$this->ServerAddress:7071/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
          curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);

          // ------ Send the zimbraAdmin AuthRequest -----

          $connect = new Zimbra();
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
                                                  <password>' . $param['NewUserPassword'] . '</password>
                                                  <a n="zimbraCOSId">' . $param['COSId'] . '</a>
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
    $param = $this->set_user_parameters();
    $response = $this->ZimbraAdminCreateAccount(1, $this->ServerAddress, $this->AdminUserName, $this->AdminPassword, $param['NewUserName'], $param['NewUserPassword'], $param['COSId']);
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
        $param = $this->set_new_user_parameters();
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,           "$this->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        $connect = new Zimbra();
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


