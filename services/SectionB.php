<?php
// Ver 3
// Wed Jun 23 2014
// -------------------------------------
// Section B
// =====================================

include "DBConnection.php";
include "GetSet.php";
include "ZimbraConnect.php";
class SectionB
{
  //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();

    }
 
	
 /*Section B record selector*/
     public function get_SectionBGridBind () {
       if(!isset($_SESSION)){
             session_start();
          }
          $routetype = '';
          $userdomain = '';
          $where = '';
          if(isset($_COOKIE['route_type'])){
            $routetype = ($_COOKIE['route_type']);  
          }
       if(isset($_COOKIE['user_domain'])){
         $userdomain = ($_COOKIE['user_domain']);
       } 
        
        if(isset($_COOKIE['user_npi'])){
          $connect = new Zimbra();
          $phy_alias = $connect->ZimbraGetPhysicianAlias($_COOKIE['user_npi']);
         
        }
        //print_r($_COOKIE);
        if($routetype == 'provider'){
          $where = "and SrcDomain='$userdomain'";
        }
       if($routetype == 'client'){
         $alias_data = '';
          if(!empty($phy_alias)){
            foreach($phy_alias as $alias){
              $my_domain = substr(strrchr($alias['alias'], "@"), 1);
              if($alias_data != '')
                $alias_data = $alias_data.','."'".$my_domain."'";
              else
                $alias_data = "'".$my_domain."'";
            }
            $where = "AND DestDomain IN ($alias_data)";
          }
          else{
            $where = "and DestDomain='$userdomain'";
          }
        }
        $filter = array();
  $filter_array = '';
  $filter_json = isset($_GET['filter']) ? $_GET['filter'] : '';
  $filter_array = json_decode($filter_json);
  //print_r($filter_array);
  if(is_array($filter_array)){
   foreach($filter_array as $value){
    $filter[$value->property] = $value->value;
   }
  }
  $count = count($filter);
  
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $sql = "Select  SQL_CALC_FOUND_ROWS CONCAT (if(patient.PatientFname is null,'',patient.PatientFname),' ',if(patient.PatientMidName is null,'',patient.PatientMidName),' ',if(patient.PatientLname is null,'',patient.PatientLname)) as PatientName,
  patient.PatientHICN as HICN,cms484det.CertType as CertType,
  DATE_FORMAT(cms484det.CertDate, '%m-%d-%Y') as CertDate,cms484det.MedicalID,cms484det.StatusFLG,case when cms484det.StatusFLG='B' then 'Edit' Else 'View' End as link, case when (cms484det.LengthNeed is not null and ICD9 is not null and cms484det.StatusFLG='B') then 'Allow' Else 'Dis' End as Send, 
  cms484det.DetailID as DetailID,patient.PatientLname 
  from cms484det 
  inner join patient 
  on patient.PatientHICN = cms484det.PatientHICN 
  where (cms484det.StatusFLG='B' 
  or cms484det.StatusFLG='S') $where"; 
  if($count > 0){
   $sql .= " AND ";
   if($filter['SelectFilter'] == 'LastName'){
    $sql .= "patient.PatientLname LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'HICN'){
    $sql .= "patient.PatientHICN LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'MedID'){
    $sql .= "cms484det.MedicalID LIKE '%".$filter['PatientHICN']."%'";
   }
   
   if($filter['CertType'] != 'All'){
    $sql .= " AND cms484det.CertType LIKE '%".$filter['CertType']."%'";
   }
   
   if($filter['StartDate'] != '' && $filter['EndDate'] != ''){
     $sql .= " AND (DATE_FORMAT(cms484det.CertDate, '%m-%d-%Y') BETWEEN '".$filter['StartDate']."' AND '".$filter['EndDate']."')";
   }elseif($filter['StartDate'] != '' && $filter['EndDate'] == ''){
     $sql .= " AND (DATE_FORMAT(cms484det.CertDate, '%m-%d-%Y') = '".$filter['StartDate']."')";
   }elseif($filter['StartDate'] == '' && $filter['EndDate'] != ''){
     $sql .= " AND (DATE_FORMAT(cms484det.CertDate, '%m-%d-%Y') = '".$filter['EndDate']."')";
   }
   
  }    
  $sql .=  " order By cms484det.LastUpdate DESC 
  LIMIT $start,$limit;";  
    $result = mysql_query($sql);
    if (!$result) {
        die('Invalid query: ' . $sql . "   " . mysql_error());
    }
  $total_count = mysql_query("SELECT FOUND_ROWS()");
        $num_rows = mysql_fetch_row($total_count);
//Allocate the array
    $app_list = array();
//Loop through database to add books to array
    while ($row = mysql_fetch_assoc($result)) {
      //echo '<pre>';print_r($row);echo '</pre>';
        $app_list[] = array('PatientName'=> ucwords($row['PatientName']),'PatientHICN' => $row['HICN'], 'CertType' => $row['CertType'],'CertDate'=>$row['CertDate'],'MedicalID'=>$row['MedicalID'],'StausFLG' => $row['StatusFLG'],'link' => $row['link'],'DetailID' => $row['DetailID'],'PatientLname' => $row['PatientLname'],'Send' => $row['Send']);
    }
      $return_arr = array('total'=>$num_rows,'data'=>$app_list);
    return $return_arr;
   // return $app_list;

                
 
}

                
  /*Fetch ICD short description from ICD code NPI */
    public function fetchICDDescription($ICDCode='') {
        if(isset($_GET['ICDCode'])){
            $ICDCode = trim($_GET['ICDCode']);
        }
            $SqlCheck = "Select ICD9ShortDesc from icd9 where ICD9ID= $ICDCode";
            $result = mysql_query($SqlCheck);
            if($result) {
               $row_count = mysql_num_rows($result);
                if($row_count == 1){
                    $row = mysql_fetch_array($result, MYSQL_ASSOC);
                    $ICDDescription = $row['ICD9ShortDesc'];
                    return trim($ICDDescription);
                }
                else{
                return FALSE;  
              }
            }
            else{
                return FALSE;  
            }
    }
    
    /*Insert section B1 record in db*/
    public function insertSectionBRecord() {
       $GetSet=new GetSet();    
      
        $GetSet->setDetailID($_GET['DetailID']) ;
		$DetailID = $GetSet->getDetailID();
        $GetSet->setStatusFLG('B');
		$StatusFLG = $GetSet->getStatusFLG();
        $GetSet->setLengthNeed($_POST['txtLengthNeed']);
		$LengthNeed = $GetSet->getLengthNeed();
        $GetSet->setICD9($_POST['txtSectionB1ICD']);
		$ICD9 = $GetSet->getICD9();
        $GetSet->setICDver('9');
		$ICDver = $GetSet->getICDver();
       
        $GetSet->setQ1AmmHg(isset($_POST['txtSectionB1Q1a']) ? $_POST['txtSectionB1Q1a'] : '');
		$Q1AmmHg = $GetSet->getQ1AmmHg();
        $GetSet->setQ1Bpercent(isset($_POST['txtSectionB1Q1b']) ? $_POST['txtSectionB1Q1b'] : '');
		$Q1Bpercent = $GetSet->getQ1Bpercent();
        $GetSet->setQ1Cdate($_POST['txtSectionB1Q1c']);
      $Q1Cdate = $GetSet->getQ1Cdate();
        $GetSet->setQ2cond ($_POST['ddlSectionB1Q2']);
		$Q2cond = $GetSet->getQ2cond ();
        $GetSet->setQ3cond($_POST['ddlSectionB1Q3']);
		$Q3cond = $GetSet->getQ3cond();
        $GetSet->setQ4portable($_POST['ddlSectionB1Q4']);
		$Q4portable = $GetSet->getQ4portable();
        $GetSet->setQ5O2LPM($_POST['ddlSectionB1Q5']);
		$Q5O2LPM = $GetSet->getQ5O2LPM();
        $GetSet->setQ6AmmHg(isset($_POST['ddlSectionB1Q6a']) ? $_POST['ddlSectionB1Q6a'] : NULL);
		$Q6AmmHg = $GetSet->getQ6AmmHg();
        $GetSet->setQ6Bpercent (isset($_POST['ddlSectionB1Q6b']) ? $_POST['ddlSectionB1Q6b'] : NULL);
		$Q6Bpercent = $GetSet->getQ6Bpercent();
        $GetSet->setQ6Cdate(isset($_POST['ddlSectionB1Q6c']) ? $_POST['ddlSectionB1Q6c'] : NULL);
        $Q6Cdate = $GetSet->getQ6Cdate(); 
        $GetSet->setQ7CHF(isset($_POST['ddlSectionB1Q7']) ? $_POST['ddlSectionB1Q7'] : NULL);
		$Q7CHF = $GetSet->getQ7CHF();
        $GetSet->setQ8Hypert(isset($_POST['ddlSectionB1Q8']) ? $_POST['ddlSectionB1Q8'] : NULL);
		$Q8Hypert = $GetSet->getQ8Hypert();
        $GetSet->setQ9Herm (isset($_POST['ddlSectionB1Q9']) ?  $_POST['ddlSectionB1Q9'] : NULL);
		$Q9Herm = $GetSet->getQ9Herm();
        $GetSet->setSignedByName($_POST['txtSectionB1Name']);
		$SignedByName = $GetSet->getSignedByName();
        $GetSet->setSignedByTitle($_POST['txtSectionB1Title']);
		$SignedByTitle = $GetSet->getSignedByTitle();
        $GetSet->setSignedByEmployer ($_POST['txtSectionB1Emp']);
		$SignedByEmployer = $GetSet->getSignedByEmployer();
    
      $GetSet->setSrcDomain($_GET['srcdomain']);
        $SrcDomain = $GetSet->getSrcDomain();
      $GetSet->setLastUpdateID($_GET['src']);
        $LastUpdateID = $GetSet->getLastUpdateID();
       // $GetSet->setDestDomain($_GET['srcdomain']);
        //$destDomain = $GetSet->getDestDomain();
        $TBLver = '5';
        
        $SqlCheck = "SELECT * FROM cms484det WHERE DetailID = '$DetailID'";
        $result = mysql_query($SqlCheck);
        $row_count = mysql_num_rows($result);
        if($row_count == 1){
             $sql = "Update cms484det set StatusFLG='$StatusFLG',LengthNeed='$LengthNeed',ICD9='$ICD9',ICDver='$ICDver',Q1AmmHg='$Q1AmmHg',Q1Bpercent='$Q1Bpercent',Q1Cdate=STR_TO_DATE('$Q1Cdate', '%m-%d-%Y'),Q2cond='$Q2cond',Q3cond='$Q3cond',Q4portable='$Q4portable',Q5O2LPM='$Q5O2LPM',Q6AmmHg='$Q6AmmHg',Q6Bpercent='$Q6Bpercent',Q6Cdate=STR_TO_DATE('$Q6Cdate', '%m-%d-%Y'),Q7CHF='$Q7CHF',Q8Hypert='$Q8Hypert',Q9Herm='$Q9Herm',SignedByName='$SignedByName',SignedByTitle='$SignedByTitle',SignedByEmployer='$SignedByEmployer',LastUpdateID='$LastUpdateID',LastUpdate=NOW(),SrcDomain='$SrcDomain',LastUpdateID='$LastUpdateID',TBLver='$TBLver' where DetailID='$DetailID'";
              $result = mysql_query($sql);
              if (!$result) 
                  {
                  die('Invalid query: ' . $sql . "   " . mysql_error());
              }
              return TRUE;  
            
        }
        else{
           return FALSE;
        }
}

    /*Section B edit records*/
       public function get_LastSectionB1Bind ($HdrID='') {
           if(isset($_GET['HdrID'])){
            $HdrID = trim($_GET['HdrID']);
$sql = "Select CONCAT (if(patient.PatientFname is null,'',patient.PatientFname),' ',if(patient.PatientMidName is null,'',patient.PatientMidName),' ',if(patient.PatientLname is null,'',patient.PatientLname)) as PatientName,patient.PatientHICN as HICN, DATE_FORMAT(patient.PatientDOB, '%m-%d-%Y') as PatientDOB ,CONCAT (if(physician.PhysicianFirstname is null,'',physician.PhysicianFirstname),' ',if(physician.PhysicianMidname is null,'',physician.PhysicianMidname),' ',if(physician.PhysicianLastname is null,'',physician.PhysicianLastname)) as physicianName,cms484hdr.HdrID as HdrID,cms484hdr.MedicalID,cms484det.CertType,DATE_FORMAT(cms484det.CertDate, '%m-%d-%Y') as CertDate
,cms484det.LengthNeed,cms484det.ICD9,cms484det.Q1AmmHg,cms484det.Q1Bpercent,DATE_FORMAT(cms484det.Q1Cdate, '%m-%d-%Y') as Q1Cdate ,cms484det.Q2cond,cms484det.Q3cond,cms484det.Q4portable,cms484det.Q5O2LPM,cms484det.Q6AmmHg,cms484det.Q6Bpercent,DATE_FORMAT(cms484det.Q6Cdate, '%m-%d-%Y') as Q6Cdate,cms484det.Q7CHF,cms484det.Q8Hypert,cms484det.Q9Herm,cms484det.SignedByName,cms484det.SignedByTitle,cms484det.SignedByEmployer from cms484hdr inner join patient on patient.PatientHICN = cms484hdr.PatientHICN left join physician on physician.PhysicianNPI = cms484hdr.PhysicianNPI inner join cms484det on cms484det.DetailID = cms484hdr.HdrID where cms484hdr.HdrID='$HdrID';";        
    $result = mysql_query($sql);
    if (!$result) {
        die('Invalid query: ' . $sql . "   " . mysql_error());
    }
//Allocate the array
    $app_list = array();
//Loop through database to add books to array
    while ($row = mysql_fetch_assoc($result)) {
      $icd9Des = $this->fetchICDDescription($row['ICD9']);
      if($icd9Des == ''){
       $icd9Des = ''; 
      }
        
     
     
        $app_list = array('PatientName'=> $row['PatientName'],
            'PatientHICN' => $row['HICN'],
            'CertType' => $row['CertType'],
          'CertDate' => $row['CertDate'],
          'PatientDOB'=>$row['PatientDOB'],
            'physicianName' => $row['physicianName'],
            'MedicalID' => $row['MedicalID'],
            'LengthNeed' => $row['LengthNeed'], 
                        'ICD9' => $row['ICD9'], 
                        'ICD9ShortDesc' => $icd9Des,
                        'Q1AmmHg' => $row['Q1AmmHg'], 
                        'Q1Bpercent' => $row['Q1Bpercent'], 
         'Q1Cdate' =>$row['Q1Cdate'], 
                        'Q2cond' => trim($row['Q2cond']), 
                        'Q3cond' => $row['Q3cond'], 
                        'Q4portable' => $row['Q4portable'], 
                        'Q5O2LPM' => $row['Q5O2LPM'], 
                        'Q6AmmHg' => $row['Q6AmmHg'], 
                        'Q6Bpercent' => $row['Q6Bpercent'], 
         'Q6Cdate' => $row['Q6Cdate'], 
                        'Q7CHF' => $row['Q7CHF'], 
                        'Q8Hypert' => $row['Q8Hypert'], 
                        'Q9Herm' => $row['Q9Herm'], 
                        'SignedByName' => $row['SignedByName'], 
                        'SignedByTitle' => $row['SignedByTitle'], 
                        'SignedByEmployer' => $row['SignedByEmployer']);
    }
           }
   // mysql_close($con);
    return json_encode($app_list);
 
    }
              
 } 
  
 $possible_url = array("get_SectionBGridBind","get_LastSectionB1Bind","insertSectionBRecord","fetchICDDescription");
 $value = "An error has occurred";
 $cms = new SectionB();
if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
    switch ($_GET["action"]) {
       
			            
           case "fetchICDDescription":
            if(isset($_GET['ICDCode'])){
                $value = $cms->fetchICDDescription($_GET["ICDCode"]);
            }
            break;
            
        
        case "get_SectionBGridBind" :
            $value = $cms->get_SectionBGridBind();
            break;
        
            
        case "get_LastSectionB1Bind" :
            if (isset ($_GET["HdrID"])){
                $value = $cms->get_LastSectionB1Bind($_GET["HdrID"]);
            }
            break;
            
        case "insertSectionBRecord":
           $value = $cms->insertSectionBRecord();
           break;  
       
    }
}
//return JSON array
echo json_encode($value);

?>