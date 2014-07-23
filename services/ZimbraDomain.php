<?php
// Create account Zimbra 
//
// Ver 1
//  july 2014
// -------------------------------------
include "DBConnection.php";
include "GetSet.php";
include "ZimbraConnect.php";

class CreateDomain {
 //private $ServerAddress = 'https://mail.windward-dev.com';
// private $AdminPassword = "b2T17F8DZ2";
  private $ServerAddress = 'https://msg96.isigndit.com';
  private $AdminUserName  = "zimbra";
  private $AdminPassword = "As8wriWew";
  
  //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();
       // $phy = new Maintainence();
    }

  
   //parameters for create COS
  public function set_Domain_parameters() {
    $GetSet = new GetSet();
    $GetSet->setDomainName($_POST['txtDomainName']);
    $Domain_Name = $GetSet->getDomainName();
    
    $GetSet->setDefaultCOS($_POST['txtDefaultCOS']);
    $DefaultCOS = $GetSet->getDefaultCOS();
    
    $GetSet->setCOS_description($_POST['txtDescription']);
    $Description = $GetSet->getCOS_description();
    
    $result = array('Domain_Name'=>$Domain_Name,'DefaultCOS'=>$DefaultCOS,'Description'=>$Description);
    return $result;
  }
  

// CREATE COS
 public function ZimbraCreateDomain()
{        
        $username = isset($_GET['user'])?$_GET['user']:'';
        
        $param = $this->set_Domain_parameters();
        $Domain_Name = $param['Domain_Name'];
        $DefaultCOS = $param['DefaultCOS'];
        $Description = $param['Description'];
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,"$this->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST, TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        $connect = new Zimbra();
        $parameters = $connect->ZimbraConnect();
        
        
         $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                <soap:Header>
                                        <context xmlns="urn:zimbra">
                                                <authToken>' . $parameters['authToken'] . '</authToken>
                                                <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                        </context>
                                </soap:Header>
                                <soap:Body>
                                    <CreateDomainRequest xmlns="urn:zimbraAdmin">
                                        <name>'.$Domain_Name.'</name>
                                        <a n="description">'.$DefaultCOS.'</a>
                                        <a n="zimbraNotes">'.$Description.'</a>
                                    </CreateDomainRequest>
                                    
                                            <CreateCosRequest xmlns="urn:zimbraAdmin"> 
                                            <name>'.$Domain_Name.'</name>
                                              <a n="description">'.$Description.'</a>
                                            <a n="zimbraDomainDefaultCOSId">'.$DefaultCOS.'</a>
                                                          
                                     </CreateCosRequest>
                                </soap:Body>
                        </soap:Envelope>';
       
        curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
        $ZimbraSOAPResponse = curl_exec($CurlHandle);
        curl_close($CurlHandle);
        $a='<Code>'; 
        $duplicate = strstr($ZimbraSOAPResponse, $a);
        //echo $ZimbraSOAPResponse;
        if(!($ZimbraSOAPResponse))
        {
                print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                return(FALSE); exit();
        }
  
        elseif(strpos($duplicate,'COS_EXISTS') !== false){
          return FALSE;
        }
        /*else{
          // split COS id from soap response
          $b="cos id="; 
                $cos = strstr($ZimbraSOAPResponse, $b);
                $cos = strstr($cos, "=");
                $cos = substr($cos, 1, strpos($cos, "/") - 1);
                
                if($cos){
                  $cos_arr = explode(" ",$cos);
                  $cos_code = $cos_arr[0];
                  $cos_code = str_replace('"','',$cos_code); // returns COS value
                  $sql = "INSERT INTO cos(COSID, COSName, COSNotes, COSDescription, LastUpdateID) VALUES ('$cos_code','$COS_name','$COS_notes','$COS_description','$username')";
                $result = mysql_query($sql);
                if (!$result) 
                    {
                    die('Invalid query: ' . $sql . "   " . mysql_error());
                }
                return TRUE;  
                }   
        }*/
               print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
        
    }
/*Fetch COS Data*/
   public function FetchAllCOS() {
        $CurlHandle = curl_init();
        curl_setopt($CurlHandle, CURLOPT_URL,"$this->ServerAddress:7071/service/admin/soap");
        curl_setopt($CurlHandle, CURLOPT_POST, TRUE);
        curl_setopt($CurlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($CurlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        $connect = new Zimbra();
        $parameters = $connect->ZimbraConnect();
        
        
         $SOAPMessage = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
                                <soap:Header>
                                        <context xmlns="urn:zimbra">
                                                <authToken>' . $parameters['authToken'] . '</authToken>
                                                <sessionId id="' . $parameters['sessionId'] . '">' . $parameters['sessionId'] . '</sessionId>
                                        </context>
                                </soap:Header>
                                <soap:Body>
                                            <GetAllCosRequest xmlns="urn:zimbraAdmin">                   
                                     </GetAllCosRequest >
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
  
             // print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
$p = xml_parser_create();
xml_parse_into_struct($p, $ZimbraSOAPResponse, $vals, $index);
xml_parser_free($p);

foreach($vals as $key => $value){

      if($value['tag'] == 'COS'){
        if (array_key_exists("attributes",$value)){
        $cos_attr[] = array('COSID' => $value['attributes']['ID'],
                    'COSName' => $value['attributes']['NAME']);
        }
  }
}
                
  return $cos_attr;
   }
}
$possible_url = array("ZimbraCreateDomain");
 $value = "An error has occurred";
 $cms = new CreateDomain();
  if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
      switch ($_GET["action"]) {
        case "ZimbraCreateDomain" :
                $value = $cms->ZimbraCreateDomain();
            break;
      }
  }
   echo json_encode($value);


