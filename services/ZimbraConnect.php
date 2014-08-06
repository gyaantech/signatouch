<?php
// Create Zimbra connectivity
//
// Ver 1
// 21 july 2014
// -------------------------------------

class Zimbra {
 //private $ServerAddress = 'https://mail.windward-dev.com';
// private $AdminPassword = "b2T17F8DZ2";
  public $ServerAddress = 'https://msg96.isigndit.com';
  public $ZimbraAddress = 'http://msg96.isigndit.com';
  public $AdminUserName  = "zimbra";
  public $AdminPassword = "As8wriWew";
  public $npi_domain = '@npi.st';
  public $non_st_domains = array('isigndit.com', 'gyaantech');
      
    //Zimbra Connect
     public function ZimbraConnect()
  {
          $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,           "$this->ServerAddress:7071/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
          curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);

          // ------ Send the zimbraAdmin AuthRequest -----


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
        <password>'. $this->AdminPassword .'</password>
        </AuthRequest>
      </soap:Body>
      </soap:Envelope>';

          curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);

          if(!($ZimbraSOAPResponse = curl_exec($CurlHandle)))
          {
                  print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                  return(FALSE);
          }

          // print("Raw Zimbra SOAP Response:<BR>" . htmlentities($ZimbraSOAPResponse) . "<BR><BR>\n");

          // Parse for the sessionId
          // <sessionId type="admin" id="123">123</sessionId>
          $sessionId = strstr($ZimbraSOAPResponse, "<sessionId");
          $sessionId = strstr($sessionId, ">");
          $sessionId = substr($sessionId, 1, strpos($sessionId, "<") - 1);
          // print("sessionId = $sessionId<BR>\n");

          // Parse for the authToken
       
          $authToken = strstr($ZimbraSOAPResponse, "<authToken");
          $authToken = strstr($authToken, ">");
          $authToken = substr($authToken, 1, strpos($authToken, "<") - 1);
          // print("authToken = $authToken<BR>\n");

          curl_close($CurlHandle);
          $results = array('authToken'=>$authToken,'sessionId'=>$sessionId);
          return $results;
  }
  // function that returns zimbra ID
  public function ZimbraGetAccountID($account_name)
  {
        //print_r($_POST);exit();
         $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,           "$this->ServerAddress:7071/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
          curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);

          
          // ------ Send the zimbraAdmin AuthRequest -----
          $parameters = $this->ZimbraConnect();
          
          
          // ------ Send the zimbraCreateAccount request -----
          $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                  <soap:Header>
                                          <context xmlns="urn:zimbra">
                                                  <authToken>' . $parameters['authToken'] . '</authToken>
                                                  <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                          </context>
                                  </soap:Header>
                                  <soap:Body>
                                    <GetAccountInfoRequest xmlns="urn:zimbraAdmin">
          <account by="name">'.$account_name.'</account>
          
    </GetAccountInfoRequest>

                                  </soap:Body>
                          </soap:Envelope>';

          curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);

          if(!($ZimbraSOAPResponse = curl_exec($CurlHandle)))
          {
                 /// print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                  return(FALSE); exit();
          }
          
                
                $a='<a n="zimbraId">'; 
                $zimbraId = strstr($ZimbraSOAPResponse, $a);
                $zimbraId = strstr($zimbraId, ">");
                $zimbraId = substr($zimbraId, 1, strpos($zimbraId, "<") - 1);
                
          
               // print("SOAP Response:<BR>" . $zimbraId . "<BR><BR>\n");
           //print("SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
          curl_close($CurlHandle);

          return $zimbraId;
  }   
  // function that returns cos ID
  public function ZimbraGetCOSID($cos_name)
  {
        //print_r($_POST);exit();
         $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,           "$this->ServerAddress:7071/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
          curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);

          
          // ------ Send the zimbraAdmin AuthRequest -----
          $parameters = $this->ZimbraConnect();
          
          
          // ------ Send the zimbraCreateAccount request -----
          $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                  <soap:Header>
                                          <context xmlns="urn:zimbra">
                                                  <authToken>' . $parameters['authToken'] . '</authToken>
                                                  <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                          </context>
                                  </soap:Header>
                                  <soap:Body>
                                      <GetCosRequest  xmlns="urn:zimbraAdmin">
                                             <cos by="name">'.$cos_name.'</cos>
                                         </GetCosRequest>
                                  </soap:Body>
                          </soap:Envelope>';

          curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);

          if(!($ZimbraSOAPResponse = curl_exec($CurlHandle)))
          {
                 /// print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                  return(FALSE); exit();
          }
          
                 //print("SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
                $b="cos id="; 
                $cos = strstr($ZimbraSOAPResponse, $b);
                $cos = strstr($cos, "=");
                $cos = substr($cos, 1, strpos($cos, "/") - 1);
                
                if($cos){
                  $cos_arr = explode(" ",$cos);
                  $cos_code = $cos_arr[0];
                  $cos_code = str_replace('"','',$cos_code); // returns COS value
                }
               // print("SOAP Response:<BR>" . $zimbraId . "<BR><BR>\n");
           //print("SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
          curl_close($CurlHandle);

          return $cos_code;
  }   
}