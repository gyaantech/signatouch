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
    $GetSet->setDomainName($_POST['txtDomainName1']);
    $Domain_Name = $GetSet->getDomainName();
    
    $GetSet->setDefaultCOS($_POST['txtDefaultCOS1']);
    $DefaultCOS = $GetSet->getDefaultCOS();
    
    $GetSet->setCOS_description($_POST['txtDescription1']);
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
        $cos_detail = $connect->ZimbraGetCOSID($DefaultCOS);
        
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
                                        <a n="zimbraDomainDefaultCOSId">'.$cos_detail.'</a>
                                        <a n="zimbraNotes">'.$Description.'</a>
                                    </CreateDomainRequest>
                                </soap:Body>
                        </soap:Envelope>';
       
        curl_setopt($CurlHandle, CURLOPT_POSTFIELDS, $SOAPMessage);
        $ZimbraSOAPResponse = curl_exec($CurlHandle);
        //print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
        curl_close($CurlHandle);
        $a='<Code>'; 
        $duplicate = strstr($ZimbraSOAPResponse, $a);
        if(!($ZimbraSOAPResponse))
        {
                print("ERROR: curl_exec - (" . curl_errno($CurlHandle) . ") " . curl_error($CurlHandle));
                return(FALSE); exit();
        }
        elseif(strpos($duplicate,'DOMAIN_EXISTS') !== false){
          return 'duplicate';
        }
        else{
          return TRUE;
        }
          
              // print("Raw Zimbra SOAP Response:<BR>" . $ZimbraSOAPResponse . "<BR><BR>\n");
        
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


