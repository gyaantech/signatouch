<?php
// Test for Zimbra Preauth access
//
// Ver 4
// Thu Aug 11 EDT 2014
// -------------------------------------
include "DBConnection.php";
include "GetSet.php";
include "ZimbraConnect.php";
class LDAP {
   //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();
        $connect = new Zimbra();
        $this->userURL = $connect->ZimbraAddress.':'.$connect->user_port.'/service/soap';
        $this->WEB_MAIL_PREAUTH_URL = $connect->ZimbraAddress.':'.$connect->user_port.'/service/preauth'; 
        $this->zmbpasswd = $connect->AdminPassword;
        $this->zmbADMURL = $connect->ServerAddress.':'.$connect->admin_port.'/service/admin/soap';
       
    }
 

  public function set_user_parameters() { // return username, password and domain name
    if(!isset($_SESSION)){
      session_start();
    }
      
    $GetSet = new GetSet();
    //print_r($_SESSION);
    // store password in session
    //session_start();
    // store session data
    if(!isset($_SESSION['password'])){
      $_SESSION['password'] = $_POST['txtPassword']; 
  }
    if(!isset($_SESSION['username'])){
      $_SESSION['username'] = $_POST['txtUsername'];
    }
    
    $user = $_SESSION['username'];
     $pass = $_SESSION['password'];
    //echo 'password '.$pass;
    //echo 'username '.$user;
    $user_post = isset($user) ? $user :'';

      $GetSet->setusername($user_post);
      $username = $GetSet->getusername();
      
      // get domain from username
      $GetSet->setdomain($username);
      $domain = $GetSet->getdomain();
      
      $npi = '';
      if($domain == 'npi.st'){
         // get npi from username
       $GetSet->set_npi($username);
        $npi = $GetSet->get_npi();
      }

      
    $pass_post = isset($pass) ? $pass : '';
    $GetSet->setpassword($pass_post);
    $password = $GetSet->getpassword();
    /*Extract domain from user email id*/
    
    $response = array('username'=>$username,'password'=>$password,'domain'=>$domain,'npi'=>$npi);
    //echo '<pre>';print_r($response);echo '</pre>';
    return $response;
  } // function def ends
  
  public function GetUserAuth(){
      // Auth Request
      // =====================================
      $user_data = $this->set_user_parameters();
    // print_r($user_data);
      $CurlHandle = curl_init();
      curl_setopt($CurlHandle, CURLOPT_URL, $this->userURL);
      curl_setopt($CurlHandle, CURLOPT_POST, TRUE );
      curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
      
      $post_data = '<Envelope xmlns="http://www.w3.org/2003/05/soap-envelope">
      <Header>
            <context xmlns="urn:zimbra">
            <nosession/>
            </context>
      </Header>

      <Body>
            <AuthRequest xmlns="urn:zimbraAccount">
            <account by="name">'. $user_data['username'] .'</account>
            <password>'. $user_data['password'] .'</password>
            </AuthRequest>
      </Body>
      </Envelope>';
      curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $post_data);

      $postResult = curl_exec($CurlHandle);

      if(!($ZimbraSOAPResponse = curl_exec($CurlHandle)))
                {
                        //print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                        return(FALSE);
                }
      else{
        $a='<Code>'; 
            $duplicate = strstr($ZimbraSOAPResponse, $a);
            if(strpos($duplicate,'account.CHANGE_PASSWORD') !== false){
              return 'change_password';
            }
            else{
              //echo $ZimbraSOAPResponse;
      // -------------------------------------
      // End Auth Request
      // =====================================
      // Parse for the authToken
      // -------------------------------------

                $authToken = strstr($ZimbraSOAPResponse, "<authToken");
                $authToken = strstr($authToken, ">");
                $authToken = substr($authToken, 1, strpos($authToken, "<") - 1);

      //print("\nAuthToken = $authToken\n");

      // --------------------------------------
      // Get Info
      // --------------------------------------
      // USE THIS CALL FOR ACCOUNT INFO


      $SOAPMessage = '<Envelope xmlns="http://www.w3.org/2003/05/soap-envelope">
      <Header>
            <context xmlns="urn:zimbra">
            <authToken>'. $authToken .'</authToken>
            <nosession/>
            </context>
      </Header>
      <Body>
            <GetInfoRequest  xmlns="urn:zimbraAccount"> 
               </GetInfoRequest>
      </Body>
      </Envelope>';

      curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);

      if(!($SOAPResponse = curl_exec($CurlHandle)))
      {
           // print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
            return(FALSE);
      }
 // echo $SOAPResponse;
      // =====================================
        // Parse for the Name & COS
        // -------------------------------------
                $id='<id>'; 
                $id = strstr($SOAPResponse, $id);
                $id = strstr($id, ">");
                $id = substr($id, 1, strpos($id, "<") - 1);
                
                $a='<attr name="displayName">'; 
                $cname = strstr($SOAPResponse, $a);
                $cname = strstr($cname, ">");
                $cname = substr($cname, 1, strpos($cname, "<") - 1);
               
                $b="cos id="; 
                $cos = strstr($SOAPResponse, $b);
                $cos = strstr($cos, "=");
                $cos = substr($cos, 1, strpos($cos, "/") - 1);

           //  print("displayName = $cname\n");
            //print("cos = $cos\n");
                $cos_code='';
                $cms_user_type='';
                if($cos){
                 
                  $cos_arr = explode(" ",$cos);
                  
                  $cos_code = $cos_arr[0];
                  $cos_code = str_replace('"','',$cos_code); // returns COS value
                    
                  $display_status = $cos_arr[1];
                  
                  $display_status_arr = explode("=",$display_status);
                  $cms_user_type = $display_status_arr[1];
                  //echo $cms_user_type;
                  $cms_user_type = str_replace('"','',$cms_user_type); // returns display name value
                  // check whther cos is admin or user
                  /*$cos_type='';
                  
                  //echo $cms_user_type;
                  if (strpos($cms_user_type,'-admin') !== false) {
                     $cos_type = 'admin';
                  }
                  if (strpos($cms_user_type,'-user') !== false) {
                     $cos_type = 'user';
                  }*/
                  $domain = $user_data['domain'];
                  $npi = $user_data['npi'];
                  if($cname != ''){
                    //$response = array('name');
                    //$sql = "SELECT displayType,FormNameID FROM forms WHERE COSname='$cos_type'; ";
                    $sql = "SELECT displayType,FormNameID,RouteType FROM forms2 WHERE COSname='$cms_user_type' and Active='1'; ";
                    //echo $sql;
                    $result = mysql_query($sql);
                    if (!$result) {
                    die('Invalid query: ' . $sql . "   " . mysql_error());
                    }
                    //Allocate the array
                    $app_list = array();

                    while ($row = mysql_fetch_assoc($result)) {
                    //echo '<pre>';print_r($row);echo '</pre>';
                      if($row['RouteType'] == '1'){
                        $routetype = 'provider';
                      }
                     if($row['RouteType'] == '2'){
                        $routetype = 'client';
                      }
                    $app_list[] = array('displayType'=> $row['displayType'],'FormNameID' => $row['FormNameID']);
                    }
                    // set routype in session variable
                        if(!isset($_SESSION)){
                        session_start();
                      }
                    /*if(!isset($_SESSION['RouteType'])){
                               $_SESSION['RouteType'] = $routetype;
                      }
                     * */
                      //echo $cms_user_type;
                      setcookie("route_type",$routetype); // set routype in cookie
                      setcookie("user_domain",$domain); //set users domain in cookie
                      setcookie("user_cos",$cms_user_type); //set users cos in cookie
                      if($npi != ''){
                        setcookie("user_npi",$npi); //set users npi in cookie
                      }
                       // print_r($_SESSION);
                    $response = array('status'=>$cms_user_type,'username'=>$cname,'cos'=>$cos_code,'domain'=>$domain,'email'=>$user_data['username'],'id'=>$id);
                    $response  = array('menu'=>$app_list,'response'=>$response);
                    
                  }
                }
                else{
                  $response = FALSE;
                }

    //print("\nGetInfoResponse :$SOAPResponse\n"); // returns full soap response
      curl_close($CurlHandle);
      
      return $response; 
            }
      }
     
  }// function def ends
 
  public function GetAcctInfo() {
  $user_data  = $this->set_user_parameters();
  // --------------------------------------
  // Get Account - gets Notes (zimbraAdmin)
  // --------------------------------------

    $CurlHandle = NULL;
    $CurlHandle = curl_init();

    curl_setopt($CurlHandle, CURLOPT_URL, $this->zmbADMURL );
    curl_setopt($CurlHandle, CURLOPT_POST, TRUE );
    curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);

    $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
    <soap:Header>
      <context xmlns="urn:zimbra">
      <nosession/>
      <userAgent name="zmprov" version="8.0.6_GA_5922"/>
      </context>
    </soap:Header>
    <soap:Body>
      <AuthRequest xmlns="urn:zimbraAdmin">
      <name>zimbra</name>
      <password>'. $this->zmbpasswd .'</password>
      </AuthRequest>
    </soap:Body>
    </soap:Envelope>';
    //echo $SOAPMessage;
    curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);

    if(!($SOAPResponse = curl_exec($CurlHandle)))
    {
           // print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
            return(FALSE);
    }

  // print("\n\nGetzimbraAuthResponse :$SOAPResponse\n");

    // Parse for the authToken
    // -------------------------------------

                $authToken = strstr($SOAPResponse, "<authToken");
                $authToken = strstr($authToken, ">");
                $authToken = substr($authToken, 1, strpos($authToken, "<") - 1);
    // ----
                //echo $authToken;
    $domain = $user_data['domain'];
    
    $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
    <soap:Header>
      <context xmlns="urn:zimbra">
      <authToken>'.$authToken.'</authToken>
      <nosession/>
      <userAgent name="zmprov" version="8.0.6_GA_5922"/>
      </context>
    </soap:Header>
    <soap:Body>
      <GetDomainRequest applyConfig="1" xmlns="urn:zimbraAdmin">
      <domain by="name">'.$domain.'</domain>
      </GetDomainRequest>
    </soap:Body>
    </soap:Envelope>';

    //print("\n\nGetAccountRequest: $SOAPMessage\n\n");

    curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);

    if(!($SOAPResponse = curl_exec($CurlHandle)))
    {
            print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
            return(FALSE);
    }

  //print("\n\nDomainResponse: $SOAPResponse\n\n");

    // =====================================
    // Parse for the ZimbraNotes
    // -------------------------------------   
                $zimbraNotes = strstr($SOAPResponse, '<a n="zimbraNotes"');
                $zimbraNotes = strstr($zimbraNotes, ">");
                $zimbraNotes = substr($zimbraNotes, 1, strpos($zimbraNotes, "<") - 1);

                $zimbraPreAuthKey = strstr($SOAPResponse, '<a n="zimbraPreAuthKey"');
                $zimbraPreAuthKey = strstr($zimbraPreAuthKey, ">");
                $zimbraPreAuthKey = substr($zimbraPreAuthKey, 1, strpos($zimbraPreAuthKey, "<") - 1);
    //print("\nzimbraPreAuthKey = $zimbraPreAuthKey\n");
    // =====================================

    curl_close($CurlHandle);
    //echo $zimbraPreAuthKey;
    return $zimbraPreAuthKey;
  }// function def ends
  
  public function Messaging_Preauth_URL() {
    // =====================================
    // Get Messaging Preauth URL 
    // -------------------------------------   
    session_start();
  //  print_r($_COOKIE);
   // $route_type = $_SESSION['RouteType'];
    session_destroy();
    // destroy cookies
    if(isset($_COOKIE['route_type'])){
      setcookie("route_type", "", time());
    }
    if(isset($_COOKIE['user_domain'])){
      setcookie("user_domain", "", time());
    }
    if(isset($_COOKIE['user_npi'])){
      setcookie("user_npi", "", time());
    }
    if(isset($_COOKIE['user_cos'])){
      setcookie("user_cos", "", time());
    }
    $user_data = $this->set_user_parameters();
   // print_R($user_data);
    $zimbraPreAuthKey  = $this->GetAcctInfo();
    //echo "key ".$zimbraPreAuthKey;
    $PREAUTH_KEY=$zimbraPreAuthKey;
    
    $account = isset($user_data['username']) ? $user_data['username'] : $_GET['username'];
    //echo 'account '.$account;
    $expires=0;
    $timestamp=time()*1000;
    if(!empty($PREAUTH_KEY)) 
     {    
      $value  = $account."|name|"."0"."|".$timestamp;



      //Note: $WEB_MAIL_PREAUTH_URL="http://mail.windward-dev.com:8080/soap/service/preauth";
      //$WEB_MAIL_PREAUTH_URL="http://mail.windward-dev.com:8080/service/preauth";

          $preauthToken=hash_hmac("sha1",$value,$PREAUTH_KEY);
      //Note: &timestamp vs &amptimestamp
          $preauthURL = $this->WEB_MAIL_PREAUTH_URL."?account=".$account."&timestamp=".$timestamp."&expires=0&preauth=".$preauthToken;
         // print ( "\n$preauthURL\n\n");
          /* Redirect to Zimbra preauth URL */
          $response = $this->GetUserAuth();
         // echo $preauthURL;
          if($response != ''){
            if($response != 'change_password'){
              // add preauthURL to response array
              $response['response']['preauthURL'] = $preauthURL;
            }
          }
          return $response;
    }
    else{
      return FALSE;
    }
  } // function def ends
} // class def ends

 $possible_url = array("Messaging_Preauth_URL");
 $val = "An error has occurred";
 $cms = new LDAP();
  if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
      switch ($_GET["action"]) {
          case "Messaging_Preauth_URL" :
              $value = $cms->Messaging_Preauth_URL();
              break;
      }
  }
  echo json_encode($value);
