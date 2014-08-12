<?php
// Ver 3
// Wed Jun 23 2014
// -------------------------------------
// Section A
// =====================================

include "DBConnection.php";
include "GetSet.php";

class SectionA
{
    //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();
    }
     
/*----------------------------------------Section A record -------------------------------------------------------------*/
  
    /*Section A record selector*/
     public function get_SectionA1GridBind () {
           if(!isset($_SESSION)){
             session_start();
          }
        $routytype = ($_COOKIE['route_type']);
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
      patient.PatientHICN as HICN,
      cms484hdr.CertType as CertType,case when CertType='I' then DATE_FORMAT(InitialCertDate, '%m-%d-%Y') when CertType='V' then DATE_FORMAT(RevisedCertDate, '%m-%d-%Y') Else DATE_FORMAT(RecertificationDate, '%m-%d-%Y') End as CertDate,
      cms484hdr.MedicalID,cms484hdr.StausFLG, case when cms484hdr.StausFLG='A' then 'Edit' Else 'View' End as link,
      cms484hdr.HdrID as HdrID,patient.PatientLname ,case when (cms484hdr.MedicalID is not null and cms484hdr.PhysicianNPI is not null and cms484hdr.SupplierNPI and cms484hdr.PlaceService ) then 'Allow' Else 'Dis' End as Send 
      from cms484hdr 
      inner join patient 
      on patient.PatientHICN = cms484hdr.PatientHICN "; 
  if($count > 0){
   $sql .= " WHERE ";
   if($filter['SelectFilter'] == 'LastName'){
    $sql .= "patient.PatientLname LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'HICN'){
    $sql .= "patient.PatientHICN LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'MedID'){
    $sql .= "cms484hdr.MedicalID LIKE '%".$filter['PatientHICN']."%'";
   }
   
   if($filter['CertType'] != 'All'){
    $sql .= " AND cms484hdr.CertType LIKE '%".$filter['CertType']."%'";
   }
   if($filter['CertType'] == 'All'){
    if($filter['StartDate'] != '' && $filter['EndDate'] != ''){
      $sql .= " AND (DATE_FORMAT(InitialCertDate, '%m-%d-%Y') BETWEEN '".$filter['StartDate']."' AND '".$filter['EndDate']."'
        OR DATE_FORMAT(RevisedCertDate, '%m-%d-%Y') BETWEEN '".$filter['StartDate']."' AND '".$filter['EndDate']."'
        OR DATE_FORMAT(RecertificationDate, '%m-%d-%Y') BETWEEN '".$filter['StartDate']."' AND '".$filter['EndDate']."')";
    }elseif($filter['StartDate'] != '' && $filter['EndDate'] == ''){
      $sql .= " AND (DATE_FORMAT(InitialCertDate, '%m-%d-%Y') = '".$filter['StartDate']."'
        OR DATE_FORMAT(RevisedCertDate, '%m-%d-%Y') = '".$filter['StartDate']."'
        OR DATE_FORMAT(RecertificationDate, '%m-%d-%Y') = '".$filter['StartDate']."')";
    }elseif($filter['StartDate'] == '' && $filter['EndDate'] != ''){
      $sql .= " AND (DATE_FORMAT(InitialCertDate, '%m-%d-%Y') = '".$filter['EndDate']."'
        OR DATE_FORMAT(RevisedCertDate, '%m-%d-%Y') = '".$filter['EndDate']."'
        OR DATE_FORMAT(RecertificationDate, '%m-%d-%Y') = '".$filter['EndDate']."')";
    }
   }elseif($filter['CertType'] == 'I'){
    if($filter['StartDate'] != '' && $filter['EndDate'] != ''){
      $sql .= " AND (DATE_FORMAT(InitialCertDate, '%m-%d-%Y') BETWEEN '".$filter['StartDate']."' AND '".$filter['EndDate']."')";
    }elseif($filter['StartDate'] != '' && $filter['EndDate'] == ''){
      $sql .= " AND (DATE_FORMAT(InitialCertDate, '%m-%d-%Y') = '".$filter['StartDate']."')";
    }elseif($filter['StartDate'] == '' && $filter['EndDate'] != ''){
      $sql .= " AND (DATE_FORMAT(InitialCertDate, '%m-%d-%Y') = '".$filter['EndDate']."')";
    }    
   }elseif($filter['CertType'] == 'V'){
    if($filter['StartDate'] != '' && $filter['EndDate'] != ''){
      $sql .= " AND (DATE_FORMAT(RevisedCertDate, '%m-%d-%Y') BETWEEN '".$filter['StartDate']."' AND '".$filter['EndDate']."')";
    }elseif($filter['StartDate'] != '' && $filter['EndDate'] == ''){
      $sql .= " AND (DATE_FORMAT(RevisedCertDate, '%m-%d-%Y') = '".$filter['StartDate']."')";
    }elseif($filter['StartDate'] == '' && $filter['EndDate'] != ''){
      $sql .= " AND (DATE_FORMAT(RevisedCertDate, '%m-%d-%Y') = '".$filter['EndDate']."')";
    } 
   }elseif($filter['CertType'] != 'All'){
    if($filter['StartDate'] != '' && $filter['EndDate'] != ''){
      $sql .= " AND (DATE_FORMAT(RecertificationDate, '%m-%d-%Y') BETWEEN '".$filter['StartDate']."' AND '".$filter['EndDate']."')";
    }elseif($filter['StartDate'] != '' && $filter['EndDate'] == ''){
      $sql .= " AND (DATE_FORMAT(RecertificationDate, '%m-%d-%Y') = '".$filter['StartDate']."')";
    }elseif($filter['StartDate'] == '' && $filter['EndDate'] != ''){
      $sql .= " AND (DATE_FORMAT(RecertificationDate, '%m-%d-%Y') = '".$filter['EndDate']."')";
    }
   }
  }    
  $sql .=  " order By cms484hdr.LastUpdate DESC 
      LIMIT $start,$limit; ";

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
         $app_list[] = array('PatientName'=> ucwords($row['PatientName']),'PatientHICN' => $row['HICN'], 'CertType' => $row['CertType'],'CertDate'=>$row['CertDate'],'MedicalID'=>$row['MedicalID'],'StausFLG' => $row['StausFLG'],'PatientLname'=>$row['PatientLname'],'link' => $row['link'],'HdrID' => $row['HdrID'],'Send' => $row['Send']);
        }

        $return_arr = array('total'=>$num_rows,'data'=>$app_list);
        return $return_arr;
}
              

/*Get facility name from facility NPI*/
    public function fetchFacilityName($facility_NPI='') {
        if(isset($_GET['facility_NPI'])){
            $facility_NPI = trim($_GET['facility_NPI']);
            $SqlCheck = "Select FacilityName from cms484hdr where FacilityNPI= '$facility_NPI'";
            $result = mysql_query($SqlCheck);
            if($result){
             $row_count = mysql_num_rows($result);
              if($row_count == 1){
                  $row = mysql_fetch_array($result, MYSQL_ASSOC);
                  $facilityName = $row['FacilityName'];
                  return trim($facilityName);
              } 
            }
            else{
              return FALSE;  
            }
        }  
    }
  
  
  /*Insert Record On Proceed Section A*/
     public function InsertRecordOnProceed() {
	 $GetSet=new GetSet();
     
    $GetSet->setHICN($_POST['txtSectionAHICN']);
	$HICN = $GetSet->getHICN();
    $GetSet->setCertType($_POST['ddlSectionACertype1']);
	$CertType = $GetSet->getCertType();
    
   $GetSet->setCertDate($_POST['txtSectionA1CertificationDate']);
	$CertDate = $GetSet->getCertDate();

    $GetSet->setHdrID($_POST['txtSectionAHICN']. $_POST['ddlSectionACertype1']. str_replace("-","",$_POST['txtSectionA1CertificationDate']));
    $HdrID = $GetSet->getHdrID();
    $GetSet->setStausFLG('A');
    $StausFLG = $GetSet->getStausFLG();
    $GetSet->setSrcDomain($_GET['srcdomain']);
    $SrcDomain = $GetSet->getSrcDomain();
    $GetSet->setLastUpdateID($_GET['src']);
    $LastUpdateID = $GetSet->getLastUpdateID();
    
    $TBLver = '5';
        
    
    // Insert into header table first       
   switch($CertType){
   case 'I':
        $sql = "INSERT INTO cms484hdr(HdrID,CertType,InitialCertDate,PatientHICN,StausFLG,SrcDomain,LastUpdateID,TBLver) VALUES ('$HdrID','$CertType',STR_TO_DATE('$CertDate', '%m-%d-%Y'),'$HICN','$StausFLG','$SrcDomain','$LastUpdateID','$TBLver')";
        break;
    
       case 'V':
        
         $initialDate = $this->fetch_InitDate_from_HICN($HICN);
         $sql = "INSERT INTO cms484hdr(HdrID,CertType,InitialCertDate,RevisedCertDate,PatientHICN,StausFLG,SrcDomain,LastUpdateID,TBLver) VALUES ('$HdrID','$CertType','$initialDate',STR_TO_DATE('$CertDate', '%m-%d-%Y'),'$HICN','$StausFLG','$SrcDomain','$LastUpdateID','$TBLver')";
         
         
        break;

     case 'C':
       $initialDate = $this->fetch_InitDate_from_HICN($HICN);
       
        $sql = "INSERT INTO cms484hdr(HdrID,CertType,InitialCertDate,RecertificationDate,PatientHICN,StausFLG,SrcDomain,LastUpdateID,TBLver) VALUES ('$HdrID','$CertType','$initialDate',STR_TO_DATE('$CertDate', '%m-%d-%Y'),'$HICN','$StausFLG','$SrcDomain','$LastUpdateID','$TBLver')";
       
        break;
    }
    
   
      
    $result = mysql_query($sql);
    if (!$result) 
        {
        die('Invalid query: ' . $sql . "   " . mysql_error());
    }
    else{
        /*after inserting in header table insert in detail table also*/
       
        $sql_b = "INSERT INTO cms484det(DetailID,PatientHICN,StatusFLG,CertType,CertDate,SrcDomain,LastUpdateID) VALUES ('$HdrID','$HICN','$StausFLG','$CertType',STR_TO_DATE('$CertDate', '%m-%d-%Y'),'$SrcDomain','$LastUpdateID')";
        
        $result_b = mysql_query($sql_b);
        if (!$result_b) {
        die('Invalid query: ' . $sql_b . "   " . mysql_error());
        }
        else{
        $return_arr = array('status'=>TRUE,'hdrid'=>$HdrID);
        return json_encode($return_arr);
        }
    }
}

/*fetch initial cert date from HICN*/
  public function fetch_InitDate_from_HICN($hicn='') {
    $sql = "SELECT InitialCertDate FROM cms484hdr where PatientHICN='$hicn' limit 1";
    $result = mysql_query($sql);
    if($result){
      $row = mysql_fetch_array($result, MYSQL_ASSOC);
      $InitDate = $row['InitialCertDate'];
      return trim($InitDate);
    }
  }
  
   /*Check Section A CheckRecordLookUp record - SectionA1*/
    public function CheckRecordLookUp() {
      $GetSet=new GetSet();

      $GetSet->setHICN($_POST['txtSectionAHICN']);
      $HICN = $GetSet->getHICN();

      $GetSet->setCertType($_POST['ddlSectionACertype1']);
      $CertType = $GetSet->getCertType();

      $GetSet->setCertDate($_POST['txtSectionA1CertificationDate']);
      $CertDate = $GetSet->getCertDate();
      $CertDatesql = mysql_query("select STR_TO_DATE('$CertDate', '%m-%d-%Y') as date");
      $cnt = mysql_num_rows($CertDatesql);
      if($cnt >= 1){
      while ($row = mysql_fetch_object($CertDatesql)) {
      $CertDate1 = $row->date;
      }
      }
			
        $GetSet->setHdrID ($_POST['txtSectionAHICN']. $_POST['ddlSectionACertype1']. str_replace("-","",$_POST['txtSectionA1CertificationDate']));
		$HdrID = $GetSet->getHdrID();
        
      switch($CertType){
       case 'I': 
            $SqlCheck = "Select CertType from cms484hdr where CertType='$CertType' and PatientHICN='$HICN' ;";
           break;
       
       case 'V':
           $SqlCheck = "SELECT HdrID FROM cms484hdr WHERE PatientHICN ='$HICN' and StausFLG='S' and CertType='I' and InitialCertDate IS NOT NULL;";
           break;
       
       case 'C':
            $SqlCheck = "SELECT HdrID FROM cms484hdr WHERE PatientHICN ='$HICN' and StausFLG='S' and CertType='I' and InitialCertDate IS NOT NULL;";
            break;  
       }      
        $result = mysql_query($SqlCheck);
        
        $row_count = mysql_num_rows($result);
        
        if($row_count == 1){
             switch($CertType){
       case 'I': 
           return FALSE;
           break;
         case 'V':

           $certV = mysql_query("SELECT HdrID FROM cms484hdr WHERE PatientHICN ='$HICN' and CertType='V' and RevisedCertDate = '$CertDate1'");
              $row_count1 = mysql_num_rows($certV);
              if($row_count1 == 1){
                  return FALSE; 
              }
              else
              {
                  return TRUE;
              }
             break;
          
         case 'C':
                 $certC= mysql_query("SELECT HdrID FROM cms484hdr WHERE PatientHICN ='$HICN' and CertType='C' and RecertificationDate = '$CertDate1'");
              $row_count2 = mysql_num_rows($certC);
              if($row_count2 == 1){
                  return FALSE; 
              }
              else
              { return TRUE;
              }
             break;
             }
           
           /* while ($row = mysql_fetch_assoc($result)) {
                $resp_arr['hdrid'] = $row['HdrID'];
            }
            $resp_arr['status'] = TRUE;
            return json_encode($resp_arr);   */
        }
        else{
            //return FALSE;
          switch($CertType){
            case 'I': 
             return TRUE;
             break;
            case 'V':
             return FALSE;
             break;
            case 'C':
             return FALSE;
             break;
          }
        }
}

 /*Fetch supplier name from supplier NPI */
    public function fetchSupplierName($supplier_NPI='') {
        if(isset($_GET['SNPI'])){
            $supplier_NPI = trim($_GET['SNPI']);
        }
            $SqlCheck = "Select SupplierName from supplier where SupplierNPI= $supplier_NPI";
            $result = mysql_query($SqlCheck);
            if($result){
              $row_count = mysql_num_rows($result);
                if($row_count == 1){
                    $row = mysql_fetch_array($result, MYSQL_ASSOC);
                    $supplierName = $row['SupplierName'];
                    return trim($supplierName);
                }
                else{
                  return FALSE;
                }
            }
               
            else{
                return FALSE;  
            }
    }
   
    /*Fetch physician name from physician NPI */
    public function fetchPhysicianName($physician_NPI='') {
        if(isset($_GET['PNPI'])){
            $physician_NPI = trim($_GET['PNPI']);
        }
            $SqlCheck = "Select CONCAT (if(physician.PhysicianFirstname is null,'',physician.PhysicianFirstname),' ',if(physician.PhysicianMidname is null,'',physician.PhysicianMidname),' ',if(physician.PhysicianLastname is null,'',physician.PhysicianLastname)) as PhysicianFirstname from physician where PhysicianNPI= $physician_NPI";
            $result = mysql_query($SqlCheck);
            if($result) {
              $row_count = mysql_num_rows($result);
              if($row_count == 1){
                $row = mysql_fetch_array($result, MYSQL_ASSOC);
                $physicianName = $row['PhysicianFirstname'];
                return trim($physicianName);
              }
              else{
                return FALSE;  
              }
            }
            else{
                return FALSE;  
            }
    }

    
      /*Fetch HCPCS from SectionA1 */
    public function fetchHCPCS($HCPCS_CD='') {
      if(isset($_GET['HCPCS'])){
          $HCPCS_CD = trim($_GET['HCPCS']);
          $SqlCheck = "Select HCPCS_SHRT_DESC_TXT from hcpcs14 where HCPCS_CD='$HCPCS_CD'";
          $result = mysql_query($SqlCheck);
           if($result) {
              $row_count = mysql_num_rows($result);
              if($row_count == 1){
                $row = mysql_fetch_array($result, MYSQL_ASSOC);
                $HCPCS_SHRT = $row['HCPCS_SHRT_DESC_TXT'];
                return trim($HCPCS_SHRT);
              }
              else{
                return FALSE;  
              } 
           }
          else{
            return FALSE;  
          }
      }
    }
   
    /*Fetch HICN from SectionA1 */
    public function fetchHICN($HICN='') {
       //  $this->HICN = $_POST['txtHICN'];
        if(isset($_GET['HICN'])){
            $HICN = trim($_GET['HICN']);
        }
            $SqlCheck = "select CONCAT (if(PatientFname is null,'',PatientFname),' ',if(PatientMidName is null,'',PatientMidName),' ',if(PatientLname is null,'',PatientLname)) as PatientName from patient where PatientHICN='$HICN'";
            $result = mysql_query($SqlCheck);
            if($result)
                {
               $row_count = mysql_num_rows($result);
              // echo $row_count;
                if($row_count == 1)
                    {
                    $row = mysql_fetch_array($result, MYSQL_ASSOC);
                    $patient_name = $row['PatientName'];
                    return $patient_name;
                }
                else{
                    return FALSE;
                }
                
            }
            else{
                return FALSE;  
            }
        
    } 
    
    
    /*Section A record selector edit function*/
     public function EditRecordA($HdrID='') {
      
        if(isset($_GET['HdrID'])){
            $HdrID = trim($_GET['HdrID']);
            $SqlCheck = "SELECT HdrID, StausFLG, CertType,PhysicianAlias,DATE_FORMAT(InitialCertDate, '%m-%d-%Y') as InitialCertDate, DATE_FORMAT(RevisedCertDate, '%m-%d-%Y') as RevisedCertDate,DATE_FORMAT(RecertificationDate, '%m-%d-%Y') as RecertificationDate, PatientHICN, MedicalID, PhysicianNPI, SupplierNPI, PlaceService, FacilityNPI, FacilityID, FacilityName, FacilityAddr1, FacilityAddr2, FacilityCity, FacilityST, FacilityZip, FacilityPhone, `HCPCS-E0431`, case when `HCPCS-E0431SupChrg`='0' then '' else `HCPCS-E0431SupChrg` end as `HCPCS-E0431SupChrg`, case when `HCPCS-E0431MedFee` = '0' then '' else `HCPCS-E0431MedFee` end as `HCPCS-E0431MedFee`,`HCPCS-E1390`, case when `HCPCS-E1390SupChrg` = '0' then '' else `HCPCS-E1390SupChrg` end as `HCPCS-E1390SupChrg`, case when `HCPCS-E1390MedFee` = '0' then '' else `HCPCS-E1390MedFee` end as `HCPCS-E1390MedFee`, `HCPCS-E1392`, case when `HCPCS-E1392MedFee` = '0' then '' else `HCPCS-E1392MedFee` end as `HCPCS-E1392MedFee`, case when `HCPCS-E1392SupChrg`='0' then '' else `HCPCS-E1392SupChrg` end as `HCPCS-E1392SupChrg`,`HCPCS-K0738`, case when `HCPCS-K0738MedFee` = '0' then '' else `HCPCS-K0738MedFee` end as `HCPCS-K0738MedFee`, case when `HCPCS-K0738SupChrg` ='0' then '' else `HCPCS-K0738SupChrg` end as `HCPCS-K0738SupChrg`,`HCPCS-Other1Code`, case when `HCPCS-Other1Desc`='0' then '' else `HCPCS-Other1Desc` end as `HCPCS-Other1Desc`, case when `HCPCS-Other1MedFee`='0' then '' else `HCPCS-Other1MedFee` end as `HCPCS-Other1MedFee`, case when `HCPCS-Other1SupChrg` = '0' then '' else `HCPCS-Other1SupChrg` end as `HCPCS-Other1SupChrg`,`HCPCS-Other2Code`, case when `HCPCS-Other2Desc` = '0' then '' else `HCPCS-Other2Desc` end as `HCPCS-Other2Desc`, case when `HCPCS-Other2MedFee`='0' then '' else `HCPCS-Other2MedFee` end as `HCPCS-Other2MedFee`, case when `HCPCS-Other2SupChrg`='0' then '' else `HCPCS-Other2SupChrg` end as `HCPCS-Other2SupChrg`, `HCPCS-Other3Code`, case when `HCPCS-Other3Desc`='0' then '' else `HCPCS-Other3Desc` end as `HCPCS-Other3Desc`, case when `HCPCS-Other3MedFee` ='0' then '' else `HCPCS-Other3MedFee` end as `HCPCS-Other3MedFee`, case when `HCPCS-Other3SupChrg`='0' then '' else `HCPCS-Other3SupChrg` end as `HCPCS-Other3SupChrg`,`HCPCS-Other4Code`, case when `HCPCS-Other4Desc`='0' then '' else `HCPCS-Other4Desc` end as `HCPCS-Other4Desc`, case when `HCPCS-Other4MedFee`='0' then '' else `HCPCS-Other4MedFee` end as `HCPCS-Other4MedFee`,case when  `HCPCS-Other4SupChrg` = '0' then '' else  `HCPCS-Other4SupChrg` end as  `HCPCS-Other4SupChrg`, LastUpdateID, LastUpdate FROM cms484hdr WHERE HdrID='$HdrID'";
            $result = mysql_query($SqlCheck);
            if($result)
                {
               $row_count = mysql_num_rows($result);
              // echo $row_count;
                if($row_count == 1)
                    {
                    $row = mysql_fetch_array($result, MYSQL_ASSOC);
                    $patient_name = $this->fetchHICN($row['PatientHICN']);
                    
                    $supplier_name = $this->fetchSupplierName($row['SupplierNPI']);
                    if($supplier_name == ''){
                      $supplier_name = '';
                    }
                    $physician_name = $this->fetchPhysicianName($row['PhysicianNPI']);
                    if($physician_name == ''){
                      $physician_name = '';
                    }
                   
                    $result_arr = array('HdrID' => $row['HdrID'],
                                        'StausFLG' => $row['StausFLG'],
                                        'CertType' => $row['CertType'],
                                        'InitialCertDate' => $row['InitialCertDate'],
                                        'RevisedCertDate' => $row['RevisedCertDate'],
                                        'RecertificationDate' =>$row['RecertificationDate'],
                                        'PatientHICN' => $row['PatientHICN'],
                                        'PatientName' => $patient_name,
                                        'supplierName' => $supplier_name,
                                        'physicianName' => $physician_name,
                                        'MedicalID' => $row['MedicalID'],
                                        'PhysicianNPI' => $row['PhysicianNPI'],
                                        'PhysicianAlias' => $row['PhysicianAlias'],
                                        'SupplierNPI' => $row['SupplierNPI'],
                                        'PlaceService' => $row['PlaceService'],
                                        'FacilityNPI' => $row['FacilityNPI'],
                                        'FacilityID' => $row['FacilityID'],
                                        'FacilityName' => $row['FacilityName'],
                                        'FacilityAddr1' => $row['FacilityAddr1'],
                                        'FacilityAddr2' => $row['FacilityAddr2'],
                                        'FacilityCity' => $row['FacilityCity'],
                                        'FacilityST' => $row['FacilityST'],
                                        'FacilityZip' => $row['FacilityZip'],
                                        'FacilityPhone' => $row['FacilityPhone'],
                                        'HCPCS_E0431' => $row['HCPCS-E0431'],
                                        'HCPCS_E0431SupChrg' => $row['HCPCS-E0431SupChrg'],
                                        'HCPCS_E0431MedFee' => $row['HCPCS-E0431MedFee'],
                                        'HCPCS_E1390' => $row['HCPCS-E1390'],
                                        'HCPCS_E1390SupChrg' => $row['HCPCS-E1390SupChrg'],
                                        'HCPCS_E1390MedFee' => $row['HCPCS-E1390MedFee'],
                                        'HCPCS_E1392' => $row['HCPCS-E1392'],
                                        'HCPCS_E1392MedFee' => $row['HCPCS-E1392MedFee'],
                                        'HCPCS_E1392SupChrg' => $row['HCPCS-E1392SupChrg'],
                                        'HCPCS_K0738' => $row['HCPCS-K0738'],
                                        'HCPCS_K0738MedFee' => $row['HCPCS-K0738MedFee'],
                                        'HCPCS_K0738SupChrg' => $row['HCPCS-K0738SupChrg'],
                                        'HCPCS_Other1Code' => $row['HCPCS-Other1Code'],
                                        'HCPCS_Other1Desc' => $row['HCPCS-Other1Desc'],
                                        'HCPCS_Other1MedFee' => $row['HCPCS-Other1MedFee'],
                                        'HCPCS_Other1SupChrg' => $row['HCPCS-Other1SupChrg'],
                                        'HCPCS_Other2Code' => $row['HCPCS-Other2Code'],
                                        'HCPCS_Other2Desc' => $row['HCPCS-Other2Desc'],
                                        'HCPCS_Other2MedFee' => $row['HCPCS-Other2MedFee'],
                                        'HCPCS_Other2SupChrg' => $row['HCPCS-Other2SupChrg'],
                                        'HCPCS_Other3Code' => $row['HCPCS-Other3Code'],
                                        'HCPCS_Other3Desc' => $row['HCPCS-Other3Desc'],
                                        'HCPCS_Other3MedFee' => $row['HCPCS-Other3MedFee'],
                                        'HCPCS_Other3SupChrg' => $row['HCPCS-Other3SupChrg'],
                                        'HCPCS_Other4Code' => $row['HCPCS-Other4Code'],
                                        'HCPCS_Other4Desc' => $row['HCPCS-Other4Desc'],
                                        'HCPCS_Other4MedFee' => $row['HCPCS-Other4MedFee'],
                                        'HCPCS_Other4SupChrg' => $row['HCPCS-Other4SupChrg']);
                    return json_encode($result_arr);
                }
                else{
                    return FALSE;
                }
                
            }
            else{
                return FALSE;  
            }
        }
    } 

   
          /*Insert section A1 record in db*/
    public function insertSectionARecord() {
         $GetSet=new GetSet();
          if(isset($_GET['HdrID'])){
        $GetSet->setHdrID(trim($_GET['HdrID']));
        $HdrID = $GetSet->getHdrID();
        $GetSet->setPhysicianNPI(isset($_POST['txtSectionAPhysicianNPI']) ? $_POST['txtSectionAPhysicianNPI'] : '');
		$PhysicianNPI = $GetSet->getPhysicianNPI();
    $GetSet->setAliasEmailId(isset($_POST['PhysicianAliasInput']) ? $_POST['PhysicianAliasInput'] : '');
    $PhysicianAlias = $GetSet->getAliasEmailId();
        $GetSet->setNPI(isset($_POST['txtSectionASupplierNPI']) ? $_POST['txtSectionASupplierNPI'] : '');
		$NPI = $GetSet->getNPI();
        $GetSet->setPOS(isset($_POST['txtSectionAPOS']) ? $_POST['txtSectionAPOS'] : '');
		$POS = $GetSet->getPOS();
        $GetSet->setMedicalID (isset($_POST['MedIDSectionA']) ? $_POST['MedIDSectionA'] : NULL);
		$MedicalID = $GetSet->getMedicalID();
		
        if(!isset($_POST['InputE0431'])){
        $E0431 = 0; 
        }
        else{
        $E0431 = $_POST['InputE0431'];
        }

        $E0431SupChrg = isset($_POST['txtE0431SupplierCharge']) ? $_POST['txtE0431SupplierCharge'] : 0.00;
        $E0431MedFee = isset($_POST['txtE0431MediCareFee']) ? $_POST['txtE0431MediCareFee'] : 0.00;
        

        if(!isset($_POST['InputE1390'])){
        $E1390 = 0; 
        }
        else{
        $E1390 = $_POST['InputE1390'];
        }

        $E1390SupChrg = isset($_POST['txtE1390SupplierCharge']) ? $_POST['txtE1390SupplierCharge'] : 0.00;
        $E1390MedFee = isset($_POST['txtE1390MediCareFee']) ? $_POST['txtE1390MediCareFee'] : 0.00;

        if(!isset($_POST['InputE1392'])){
        $E1392 = 0; 
        }
        else{
        $E1392 = $_POST['InputE1392'];
        }
        $E1392MedFee = isset($_POST['txtE1392MediCareFee']) ? $_POST['txtE1392MediCareFee'] : 0.00;
        $E1392SupChrg = isset($_POST['txtE1392SupplierCharge']) ? $_POST['txtE1392SupplierCharge'] : 0.00;

        if(!isset($_POST['InputK0738'])){
        $K0738 = 0; 
        }
        else{
        $K0738 = $_POST['InputK0738'];
        }
        $K0738MedFee = isset($_POST['txtK0738MediCareFee']) ? $_POST['txtK0738MediCareFee']: NULL;
        $K0738SupChrg = isset($_POST['txtK0738SupplierCharge']) ? $_POST['txtK0738SupplierCharge'] : NULL;
        $Other1Code = isset($_POST['txtHCPCS1']) ? $_POST['txtHCPCS1'] : NULL;
        $Other1Desc = isset($_POST['txtHCPCS1Des']) ? $_POST['txtHCPCS1Des'] : NULL;
        $Other1MedFee=isset($_POST['txtHCPCS1MediCareFee']) ? $_POST['txtHCPCS1MediCareFee'] : NULL;
        $Other1SupChrg = isset($_POST['txtHCPCS1Sup']) ? $_POST['txtHCPCS1Sup'] : NULL;
        $Other2Code=isset($_POST['txtHCPCS2']) ? $_POST['txtHCPCS2'] : NULL;
        $Other2Desc=isset($_POST['txtHCPCS2Des']) ? $_POST['txtHCPCS2Des'] : NULL;
        $Other2MedFee=isset($_POST['txtHCPCS2MediCareFee']) ? $_POST['txtHCPCS2MediCareFee'] : NULL;
        $Other2SupChrg=isset($_POST['txtHCPCS2Sup']) ? $_POST['txtHCPCS2Sup'] : NULL;
        $Other3Code=isset($_POST['txtHCPCS3']) ? $_POST['txtHCPCS3'] : NULL;
        $Other3Desc=isset($_POST['txtHCPCS3Des']) ? $_POST['txtHCPCS3Des'] : NULL;
        $Other3MedFee=isset($_POST['txtHCPCS3MediCareFee']) ? $_POST['txtHCPCS3MediCareFee'] : NULL;
        $Other3SupChrg=isset($_POST['txtHCPCS3Sup']) ? $_POST['txtHCPCS3Sup'] : NULL;
        $Other4Code=isset($_POST['txtHCPCS4']) ? $_POST['txtHCPCS4'] : NULL;
        $Other4Desc=isset($_POST['txtHCPCS4Des']) ? $_POST['txtHCPCS4Des'] : NULL;
        $Other4MedFee=isset($_POST['txtHCPCS4MediCareFee']) ? $_POST['txtHCPCS4MediCareFee'] : NULL;
        $Other4SupChrg=isset($_POST['txtHCPCS4Sup']) ? $_POST['txtHCPCS4Sup'] : NULL;
        $GetSet->setLastUpdateID($_GET['src']);
        $LastUpdateID = $GetSet->getLastUpdateID();
        $GetSet->setSrcDomain($_GET['srcdomain']);
        $SrcDomain = $GetSet->getSrcDomain();
        $GetSet->setdomain($_POST['PhysicianAliasInput']);
        $destDomain = $GetSet->getdomain();
        $TBLver = '5';

$sql = "Update cms484hdr set MedicalID = '$MedicalID',PhysicianNPI='$PhysicianNPI', PhysicianAlias='$PhysicianAlias',SupplierNPI='$NPI', PlaceService='$POS',`HCPCS-E0431`='$E0431',`HCPCS-E0431SupChrg`='$E0431SupChrg', `HCPCS-E0431MedFee`='$E0431MedFee',`HCPCS-E1390`='$E1390',`HCPCS-E1390SupChrg`='$E1390SupChrg', `HCPCS-E1390MedFee`='$E1390MedFee',`HCPCS-E1392`='$E1392',`HCPCS-E1392MedFee`='$E1392MedFee', `HCPCS-E1392SupChrg`='$E1392SupChrg',`HCPCS-K0738`='$K0738',`HCPCS-K0738MedFee`='$K0738MedFee', `HCPCS-K0738SupChrg`='$K0738SupChrg', `HCPCS-Other1Code`='$Other1Code', `HCPCS-Other1Desc`='$Other1Desc', `HCPCS-Other1MedFee`='$Other1MedFee', `HCPCS-Other1SupChrg`='$Other1SupChrg', `HCPCS-Other2Code`='$Other2Code', `HCPCS-Other2Desc`='$Other2Desc', `HCPCS-Other2MedFee`='$Other2MedFee', `HCPCS-Other2SupChrg`='$Other2SupChrg', `HCPCS-Other3Code`='$Other3Code', `HCPCS-Other3Desc`='$Other3Desc', `HCPCS-Other3MedFee`='$Other3MedFee', `HCPCS-Other3SupChrg`='$Other3SupChrg', `HCPCS-Other4Code`='$Other4Code', `HCPCS-Other4Desc`='$Other4Desc', `HCPCS-Other4MedFee`='$Other4MedFee', `HCPCS-Other4SupChrg`='$Other4SupChrg', LastUpdateID='$LastUpdateID',LastUpdate=Now(),SrcDomain='$SrcDomain',DestDomain='$destDomain',TBLver='$TBLver' where HdrID='$HdrID';";
         $sql1 = "Update cms484det set MedicalID='$MedicalID',SrcDomain='$SrcDomain',DestDomain='$destDomain', LastUpdateID='$LastUpdateID' where DetailID='$HdrID' ";
                $result = mysql_query($sql);
                $result1 = mysql_query($sql1);
                if (!$result || !$result1) 
                    {
                    die('Invalid query: ' . $sql. "   " .$sql1. mysql_error());
                }
                return TRUE;  
            }
      


}
  
 } 
  
 $possible_url = array("get_SectionA1GridBind","fetchSupplierName","fetchPhysicianName","fetchHCPCS","fetchHICN","CheckRecordLookUp","EditRecordA","insertSectionARecord","InsertRecordOnProceed","fetchFacilityName");
 $value = "An error has occurred";
 $cms = new SectionA();
if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
    switch ($_GET["action"]) {
        case "get_SectionA1GridBind" :
            $value = $cms->get_SectionA1GridBind();
            break;
	
      
     
        case "fetchSupplierName" :
            if (isset ($_GET["SNPI"])){
                $value = $cms->fetchSupplierName($_GET["SNPI"]);
            }
            break;
        case "fetchFacilityName" :
            if (isset ($_GET["facility_NPI"])){
                $value = $cms->fetchFacilityName($_GET["facility_NPI"]);
            }
            break;
        case "fetchPhysicianName" :
            if (isset ($_GET["PNPI"])){
                $value = $cms->fetchPhysicianName($_GET["PNPI"]);
            }
            break;
            
        case "fetchHCPCS" :
            if (isset ($_GET["HCPCS"])){
                $value = $cms->fetchHCPCS($_GET["HCPCS"]);
            }
            break;
            
        case "fetchHICN":
            if (isset ($_GET["HICN"])){
                $value = $cms->fetchHICN($_GET["HICN"]);
            }
            break;
            
                   
        case "CheckRecordLookUp":
                $value = $cms->CheckRecordLookUp();
            break;
        
       
        
        case "EditRecordA" :
            if (isset ($_GET["HdrID"])){
                $value = $cms->EditRecordA($_GET["HdrID"]);
            }
            break;
            
       
        case "insertSectionARecord":
          if(isset($_GET['HdrID'])){
                $value = $cms->insertSectionARecord($_GET["HdrID"]);
            }
            break;
			
        case "InsertRecordOnProceed":
           $value = $cms->InsertRecordOnProceed();
           break; 
		   
    }
}
//return JSON array
echo json_encode($value);

?>