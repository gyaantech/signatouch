<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
// list accounts of domain Zimbra 
//
// Ver 1
//  august 2014
// -------------------------------------
include "DBConnection.php";
include "GetSet.php";
include "ZimbraConnect.php";


class XmlToArrayParser {
    /** The array created by the parser can be assigned to any variable: $anyVarArr = $domObj->array.*/
    public $array = array();
    private $parse_error = false;
    private $parser;
    private $pointer;

    /** Constructor: $domObj = new xmlToArrayParser($xml); */
    public function __construct($xml) {
        $xml = str_replace(array('&'), array('&amp;'), $xml);
        $this->pointer =& $this->array;
        $this->parser = xml_parser_create("UTF-8");
        xml_set_object($this->parser, $this);
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($this->parser, "tag_open", "tag_close");
        xml_set_character_data_handler($this->parser, "cdata");
        $this->parse_error = xml_parse($this->parser, ltrim($xml)) ? false : true;
    }

    /** Free the parser. */
    public function __destruct() {
        xml_parser_free($this->parser);
    }

    /** Get the xml error if an an error in the xml file occured during parsing. */
    public function get_xml_error() {
        if ($this->parse_error) {
            $errCode = xml_get_error_code($this->parser);
            $thisError = "Error Code [" . $errCode . "] \"<strong style='color:red;'>" . xml_error_string($errCode) . "</strong>\",
                            at char " . xml_get_current_column_number($this->parser) . "
                            on line " . xml_get_current_line_number($this->parser) . "";
        } else {
            $thisError = $this->parse_error;
        }
        return $thisError;
    }

    private function tag_open($parser, $tag, $attributes) {
        $this->convert_to_array($tag, 'attrib');
        $idx = $this->convert_to_array($tag, 'cdata');
        if (isset($idx)) {
            $this->pointer[$tag][$idx] = Array(
                '@idx' => $idx,
                '@parent' => &$this->pointer
            );
            $this->pointer =& $this->pointer[$tag][$idx];
        } else {
            $this->pointer[$tag] = Array(
                '@parent' => &$this->pointer
            );
            $this->pointer =& $this->pointer[$tag];
        }
        if (!empty($attributes)) {
            $this->pointer['attrib'] = $attributes;
        }
    }

    /** Adds the current elements content to the current pointer[cdata] array. */
    private function cdata($parser, $cdata) {
        if (strlen(trim($cdata)) > 0) {
            if (isset($this->pointer['cdata'])) {
                $this->pointer['cdata'] .= $cdata;
            } else {
                $this->pointer['cdata'] = $cdata;
            }
        }
    }

    private function tag_close($parser, $tag) {
        $current =& $this->pointer;
        if (isset($this->pointer['@idx'])) {
            unset($current['@idx']);
        }

        $this->pointer =& $this->pointer['@parent'];
        unset($current['@parent']);

        if (isset($current['cdata']) && count($current) == 1) {
            $current = $current['cdata'];
        } else if (empty($current['cdata'])) {
            unset($current['cdata']);
        }
    }

    /** Converts a single element item into array(element[0]) if a second element of the same name is encountered. */
    private function convert_to_array($tag, $item) {
        if (isset($this->pointer[$tag][$item])) {
            $content = $this->pointer[$tag];
            $this->pointer[$tag] = array(
                (0) => $content
            );
            $idx = 1;
        } else if (isset($this->pointer[$tag])) {
            $idx = count($this->pointer[$tag]);
            if (!isset($this->pointer[$tag][0])) {
                foreach ($this->pointer[$tag] as $key => $value) {
                    unset($this->pointer[$tag][$key]);
                    $this->pointer[$tag][0][$key] = $value;
                }
            }
        } else {
            $idx = null;
        }
        return $idx;
    }
}

class ListUser {
  //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();
    }
  
   //to list zimbra User
  public function ZimbraListUser () {   
    $domain = '';
    if(isset($_GET['domain'])){
      $domain = $_GET['domain'];
    }
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
                                        <domain by="name">'.$domain.'</domain>
                                     </GetAllAccountsRequest>
    
                            </soap:Body>
                    </soap:Envelope>';

    curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
    $ZimbraSOAPResponse = curl_exec($CurlHandle);
    curl_close($CurlHandle);
//echo $ZimbraSOAPResponse;
    if(!($ZimbraSOAPResponse))
    {
            print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
            return(FALSE); exit();
    }
 

  $displayName = '';
  $FirstName = '';
  $MidName = '';
  $LastName = '';
  $altEmail = '';
  $cos = '';
  $company = '';
  $title = '';
  $mobile = '';
  $city = '';
  $postalCode = '';
  $state = '';
  $Type = '';
  $xmlObject = new XmlToArrayParser($ZimbraSOAPResponse);
  $arr = $xmlObject->array;
  $domain_accounts = $arr['soap:Envelope']['soap:Body']['GetAllAccountsResponse']['account'];
  foreach($domain_accounts as $key => $value){
    $email = $value['attrib']['name'];
  foreach($value['a'] as $k => $v){
  //  echo '<pre>';print_r($v);echo '</pre>';
    if($v['attrib']['n'] == 'displayName'){
      $displayName = $v['cdata']; 
    }
    if($v['attrib']['n'] == 'givenName'){
      $FirstName = $v['cdata']; 
    }
    if($v['attrib']['n'] == 'initials'){
      $MidName = $v['cdata']; 
    }
    if($v['attrib']['n'] == 'sn'){
      $LastName = $v['cdata']; 
    }
    if($v['attrib']['n'] == 'zimbraNotes'){
      $altEmail = $v['cdata']; 
    }
     /* if($v['attrib']['n'] == 'zimbraCOSId'){
        $cos = $connect->ZimbraGetCOSName($v['cdata']);
        $cos_arr = explode("-",$cos);
        if (array_key_exists('2', $cos_arr)) {
          $type = $cos_arr[2];
        }
        else{
          $type = $cos_arr[1];
        }
         //$cos = $v['cdata'];
    }*/
      if($v['attrib']['n'] == 'company'){
      $company = $v['cdata']; 
    }
     if($v['attrib']['n'] == 'title'){
      $title = $v['cdata']; 
    }
     if($v['attrib']['n'] == 'mobile'){
      $mobile = $v['cdata']; 
    }
    if($v['attrib']['n'] == 'l'){
      $city = $v['cdata']; 
    }
      if($v['attrib']['n'] == 'postalCode'){
      $postalCode = $v['cdata']; 
    }
     if($v['attrib']['n'] == 'st'){
      $state = $v['cdata']; 
    }

  }
  
    //  $app_list[] = array('Type'=>$type,'email'=>$email,'displayName'=> $displayName, 'Company' => $company,'JobTitle'=>$title,'Phone'=>$mobile,'City'=>$city,'Zip'=>$postalCode,'State'=>$state); 
      $app_list[] = array('email'=>$email,'displayName'=> $displayName, 'FirstName'=>$FirstName,'MidName'=>$MidName,'LastName'=>$LastName,'altEmail'=>$altEmail,'Company' => $company,'JobTitle'=>$title,'Phone'=>$mobile,'City'=>$city,'Zip'=>$postalCode,'State'=>$state); 
      
          }
    return array_reverse($app_list);  
  
}
  
   //to update zimbra User
  public function ZimbraUpdateUser () { 
    $connect = new Zimbra();
    $account = $_POST['txtAccountName'].$_POST['hiddenDomain'].'.st';
    $account_id = $connect->ZimbraGetAccountID($account);
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
                            <ModifyAccountRequest xmlns="urn:zimbraAdmin" id="'.$account_id.'">
                                  <a n="givenName">'.$_POST['txtFirstName'].'</a>
                                  <a n="initials">'.$_POST['txtMiddleInitial'].'</a>
                                  <a n="sn">'.$_POST['txtLastName'].'</a>
                                  <a n="displayName">'.$_POST['txtDisplayNaMe'].'</a>
                                  <a n="company">'.$_POST['txCompany'].'</a>
                                  <a n="title">'.$_POST['txCompanyTitle'].'</a>
                                  <a n="l">'.$_POST['txtUCity'].'</a>
                                  <a n="st">'.$_POST['ddlUState'].'</a>
                                  <a n="postalCode">'.$_POST['txtUZip'].'</a>
                                  <a n="mobile">'.$_POST['txtUPhoneno'].'</a>
                                  <a n="zimbraNotes">'.$_POST['txtAltMailID'].'</a>
                                    
                              </ModifyAccountRequest>
                            </soap:Body>
                    </soap:Envelope>';

    curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
    $ZimbraSOAPResponse = curl_exec($CurlHandle);
    curl_close($CurlHandle);
    echo $ZimbraSOAPResponse;
    if(!($ZimbraSOAPResponse))
    {
            print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
            return(FALSE); exit();
    }
      return TRUE;
    }
  }

$possible_url = array("ZimbraListUser","ZimbraUpdateUser");
 $value = "An error has occurred";
 $cms = new ListUser();
  if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
      switch ($_GET["action"]) {
          case "ZimbraListUser" :
              $value = $cms->ZimbraListUser();
              break; 
          case "ZimbraUpdateUser" :
              $value = $cms->ZimbraUpdateUser();
              break; 
          
      }
  }
echo json_encode($value);


