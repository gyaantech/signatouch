<?php
// Create account Zimbra 
//
// Ver 1
//  july 2014
// -------------------------------------
include "DBConnection.php";
include "GetSet.php";
include "ZimbraConnect.php";

class GetPhysicianAlias {
  public function ZimbraGetPhysicianAlias()
  {
     $connect = new Zimbra();
    $GetSet = new GetSet();   
    // set PhysicianNPI
    $GetSet->setPhysicianNPI($_GET['NPI']);
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
$possible_url = array("ZimbraGetPhysicianAlias");
 $value = "An error has occurred";
 $cms = new GetPhysicianAlias();
  if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
      switch ($_GET["action"]) {
       case "ZimbraGetPhysicianAlias" :
                $value = $cms->ZimbraGetPhysicianAlias();
            break;
      }
  }
echo json_encode($value);

