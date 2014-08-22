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
  // function that returns cos ID from COS name
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
    // function that returns cos name from COS ID
  public function ZimbraGetCOSName($cos_id)
  {
         $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,"$this->ServerAddress:7071/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,TRUE);
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
                                             <cos by="id">'.$cos_id.'</cos>
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
                  
                  $cos_arr = explode("name=",$cos);
                  //echo '<pre>';print_r($cos_arr);echo '</pre>';
                  $cos_name = $cos_arr[1];
                  $cos_name = str_replace(">1<","",$cos_name);
                  $cos_name = str_replace(">","",$cos_name);
                  $cos_name = str_replace('"','',$cos_name); // returns COS value
                }
          curl_close($CurlHandle);
          return $cos_name;
  }   
   public function ZimbraGetPhysicianAlias($npi='')
  {
     $connect = new Zimbra();
    $GetSet = new GetSet();   
    // set PhysicianNPI
    if($npi == ''){
      $npi = $_GET['NPI'];
    }
    $GetSet->setPhysicianNPI($npi);
    // get PhysicianNPI
    $npi = $GetSet->getPhysicianNPI();
    $npi = $npi.$connect->npi_domain;
    
        //print_r($_POST);exit();
         $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,           "$connect->ServerAddress:7071/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,           TRUE);
          curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
         
          //$id = $connect->ZimbraGetAccountID($result['TargetAccount']);
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
     
                                  
    <GetAccountRequest xmlns="urn:zimbraAdmin">
         <account by="name">'.$npi.'</account>
    </GetAccountRequest>
    

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
        $alias = array();
        $a='<a n="zimbraMailAlias">'; 
        /*xml parser**/
        $p = xml_parser_create();
        xml_parse_into_struct($p, $ZimbraSOAPResponse, $vals, $index);
        xml_parser_free($p);

        foreach($vals as $key => $value){
          if($value['tag'] == 'A'){
            if (array_key_exists("attributes",$value)){
              if($value['attributes']['N'] == 'zimbraMailAlias'){
                $alias[] = array('id' => $value['value'],
                    'alias' => $value['value']);
              }   
            }
          }
           
        }
        if($alias){
          return $alias;
        }
        else{
          return FALSE;
        }
          
  }  
}