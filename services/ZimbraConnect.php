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
  public $admin_port = '7071';
  public $user_port = '8080';
      
    //Zimbra Connect
     public function ZimbraConnect()
  {
          $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,"$this->ServerAddress:".$this->admin_port."/service/admin/soap");
          curl_setopt($CurlHandle, CURLOPT_POST,TRUE);
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
          curl_setopt($CurlHandle, CURLOPT_URL,"$this->ServerAddress:".$this->admin_port."/service/admin/soap");
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
          curl_setopt($CurlHandle, CURLOPT_URL,           "$this->ServerAddress:".$this->admin_port."/service/admin/soap");
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
        $cos_name = '';
         $CurlHandle = curl_init();
          curl_setopt($CurlHandle, CURLOPT_URL,"$this->ServerAddress:".$this->admin_port."/service/admin/soap");
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
                  $cos_name = $cos_arr[1];
                  $cos_name = str_replace('<a n="zimbraMobilePolicyAllowUnsignedApplications">1<',"",$cos_name);
                  $cos_name = str_replace(">","",$cos_name);
                  $cos_name = str_replace('"','',$cos_name); // returns COS value
                 ///echo '<pre>';print_r($cos_name);echo '</pre>';
                }
          curl_close($CurlHandle);
         
          return $cos_name;
  }  
  // get physician alias from npi
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
  // generate preauth key
   public function ZimbraGeneratePreAuthKey($domain_name){
		
		//$domain = 'npi.st';
		$connect = new Zimbra();
    $admin_account_name = 'admin@'.$domain_name;
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