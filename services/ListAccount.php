<?php
ini_set('memory_limit', '-1');
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
                                        <domain by="name">akant-11111.st</domain>
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
    $res = $ZimbraSOAPResponse;
    $op = $this->soaptoarray($res);
echo "<pre>";
print_r($op);
        
    //return $cos_attr;
  }
  function soaptoarray($response)
{

$search  = array('<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"','<soapenv:Header/','<soapenv:Body','</', '<');
$replace = array(' ',' ',' ','@end@', '*start*');
$customer=str_replace($search, $replace, $response);
$soapres =explode('*start*',$customer);
echo "<pre>";
/* print_r($soapres);
exit */;

$final_res = array();
foreach($soapres as $key=>$value)
 {
   $res[$key]=$value;
   $temp=explode('@end@',$value);
   $tempval=explode('>',$temp[0]);
   $tmp=explode("State",$tempval[0]);
   if (isset($tempval[1])) {
	$resp{$tempval[0]}=$tempval[1];
	$final_res[] = $resp;
}

 }  
$count = count($final_res);
$final_return = $final_res[$count-1];
 return $final_return;
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


