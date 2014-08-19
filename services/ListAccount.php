<?php
// Create account Zimbra 
//
// Ver 1
//  july 2014
// -------------------------------------
include "DBConnection.php";
include "GetSet.php";
include "ZimbraConnect.php";
class ListUser {
  //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();
    }
  
   //to list zimbra User
  public function ZimbraListUser () {
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
                                 
                                     <GetAllAccountsRequest xmlns="urn:zimbraAdmin">
                                        <domain by="name">npi.st</domain>
                                     </GetAllAccountsRequest>
    
                            </soap:Body>
                    </soap:Envelope>';

    curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
    $ZimbraSOAPResponse = curl_exec($CurlHandle);
    curl_close($CurlHandle);

    if(!($ZimbraSOAPResponse))
    {
            print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
            return(FALSE); exit();
    }

         // print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n"); exit();
    $p = xml_parser_create();
    xml_parse_into_struct($p, $ZimbraSOAPResponse, $vals, $index);
    xml_parser_free($p);

    foreach($vals as $key => $value){
        print_r($value);
     /*    if($value['tag'] == 'A'){
            if (array_key_exists("attributes",$value)){
                if($value['attributes']['N'] == 'displayName'){
                $cos_attr[] = array('displayName' => $value['value']);
                }   
                if($value['attributes']['N'] == 'zimbraCOSId'){
                $cos_attr[] = array('zimbraCOSId' => $value['value']);
                } 
                if($value['attributes']['N'] == 'company'){
                $cos_attr[] = array('company' => $value['value']);
                } 
                if($value['attributes']['N'] == 'title'){
                $cos_attr[] = array('title' => $value['value']);
                }
                if($value['attributes']['N'] == 'mobile'){
                $cos_attr[] = array('mobile' => $value['value']);
                } 
                if($value['attributes']['N'] == 'l'){
                $cos_attr[] = array('city' => $value['value']);
                } 
                if($value['attributes']['N'] == 'postalCode'){
                $cos_attr[] = array('postalCode' => $value['value']);
                } 
                if($value['attributes']['N'] == 'st'){
                $cos_attr[] = array('state' => $value['value']);
                } 
            }
         }
         */
    }

    //return $cos_attr;
  }
}
$possible_url = array("ZimbraListUser");
 $value = "An error has occurred";
 $cms = new ListUser();
  if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
      switch ($_GET["action"]) {
          case "ZimbraListUser" :
              $value = $cms->ZimbraListUser();
              break; 
      }
  }
   //echo json_encode($value);


