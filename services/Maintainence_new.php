<?php
// Ver 3
// Wed Sept 12 2014
// -------------------------------------
// Maintainence - Patient, Supplier,Facility,Physician
// =====================================

include "DBConnection.php";
include "GetSet.php";

class Maintainence
{
    //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();	
    }
   
/*----------------------Patient record start-------------------------------------------------------------- */
   /*Patient record */
     public function get_PatientGridBind () {
  //print_r($_GET['filter']);exit();
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
  
  $sql = "Select SQL_CALC_FOUND_ROWS patient.PatientHICN,CONCAT (if(patient.PatientFname is null,'',patient.PatientFname),' ',if(patient.PatientMidName is null,'',patient.PatientMidName),' ',if(patient.PatientLname is null,'',patient.PatientLname)) as PatientName,PatientLname,PatientFname,patient.PatientPhone,patient.PatientCity,patient.PatientSt,patient.PatientZip 
  FROM patient";
  if($count > 0){
   $sql .= " WHERE ";
   if($filter['SelectFilter'] == 'LastName'){
    $sql .= "patient.PatientLname LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'HICN'){
    $sql .= "patient.PatientHICN LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'FirstName'){
    $sql .= "patient.PatientFname LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'ZipCode'){
    $sql .= "patient.PatientZip LIKE '%".$filter['PatientHICN']."%'";
   }
  }
  $sql .= " order by patient.LastUpdate DESC LIMIT $start,$limit";

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
         $app_list[] = array('PatientName'=> ucwords($row['PatientName']),'PatientHICN' => $row['PatientHICN'], 'PatientPhone' => $row['PatientPhone'],'PatientCity'=>ucwords($row['PatientCity']),'PatientZip'=>$row['PatientZip'],'PatientSt'=>$row['PatientSt'],'PatientFname'=>$row['PatientFname'],'PatientLname'=>$row['PatientLname']);
        }

        $return_arr = array('total'=>$num_rows,'data'=>$app_list);
        return $return_arr;
}
                
/*Insert PatientHICN record in db*/
    public function insertPatientHICN() {
      $GetSet=new GetSet();
      $GetSet->setHICN($_POST['txtHICN']);
      $HICN = trim($GetSet->getHICN());
      $GetSet->setFName($_POST['txtFname']);
      $FName = trim($GetSet->getFName());
      $GetSet->setMName($_POST['txtMname']);
      $MName = trim($GetSet->getMName());
      $GetSet->setLName($_POST['txtLname']);
      $LName = trim($GetSet->getLName());
      $GetSet->setDOB($_POST['txtDOB']);
      $DOB1 = trim($GetSet->getDOB());
      $GetSet->setGender($_POST['ddlSex']);
      $Gender = trim($GetSet->getGender());
      $GetSet->setAddress1($_POST['txtAddress1']);
      $Address1 = trim($GetSet->getAddress1());
      $GetSet->setAddress2($_POST['txtAddress2']);
      $Address2 = trim($GetSet->getAddress2());
      $GetSet->setCity($_POST['txtCity']);
      $City = trim($GetSet->getCity());
      $GetSet->setState($_POST['ddlNewPatientState']);
      $State = trim($GetSet->getState());
      $GetSet->setZip($_POST['txtHICNZip']);
      $Zip = trim($GetSet->getZip());
      $GetSet->setPhoneNo($_POST['txtPhoneno']);   
      $PhoneNo = trim($GetSet->getPhoneNo());   
      $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
            
			 $SqlCheck = "CALL Sp_insertUpdate_Patient('Insert','$HICN','$LName','$MName','$FName','$Address1','$Address2','$City','$State','$Zip','$PhoneNo','$DOB1','$Gender','$LastUpdateID')";
            $result = mysql_query($SqlCheck);
                if (!$result) 
                  {
                   die('Invalid query: ' . $sql . "   " . mysql_error());
                  }
            else{
				if($result == 'OK'){
					 return TRUE;  
				}
				if($result == 'Already'){
					return FALSE;
				}
                
            }
			
}

/*Insert Pop PatientHICN record in db*/
    public function POPinsertPatientHICN() {
		$GetSet=new GetSet();
        $GetSet->setHICN($_POST['txtPOPHICN']);
		$hicn = trim($GetSet->getHICN());      
        $GetSet->setFName($_POST['txtPOPFname']);
		$FName = trim($GetSet->getFName());
        $GetSet->setMName($_POST['txtPOPMname']);
		$MName = trim($GetSet->getMName());
        $GetSet->setLName($_POST['txtPOPLname']);
		$LName = trim($GetSet->getLName());
        $GetSet->setDOB($_POST['txtPOPDOB']);
		$DOB1 = trim($GetSet->getDOB());
        $GetSet->setGender($_POST['ddlPOPSex']);
		$Gender = trim($GetSet->getGender());
        $GetSet->setAddress1($_POST['txtPOPAddress1']);
		$Address1 = trim($GetSet->getAddress1());
        $GetSet->setAddress2($_POST['txtPOPAddress2']);
		$Address2 = trim($GetSet->getAddress2());
        $GetSet->setCity($_POST['txtPOPCity']);
		$City = trim($GetSet->getCity());
        $GetSet->setState($_POST['ddlPOPNewPatientState']);
		$State = trim($GetSet->getState());
        $GetSet->setZip($_POST['txtPOPZip']);
		$Zip = trim($GetSet->getZip());
        $GetSet->setPhoneNo($_POST['txtPOPPhoneno']);  
		$PhoneNo = trim($GetSet->getPhoneNo());   
    $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
		  $SqlCheck = "CALL Sp_insertUpdate_Patient('Insert','$hicn','$LName','$MName','$FName','$Address1','$Address2','$City','$State','$Zip','$PhoneNo','$DOB1','$Gender','$LastUpdateID')";
            $result = mysql_query($SqlCheck);
                if (!$result) 
                  {
                   die('Invalid query: ' . $sql . "   " . mysql_error());
                  }
            else{
				if($result == 'OK'){
					$patient_name = $FName.' '.$MName.' '.$LName;
					$hicn_arr = array('HICN'=>$hicn,'Name'=>$patient_name,'status'=>'ok');
					return $hicn_arr;  
				}
				if($result == 'Already'){
					return FALSE;
				}
                
            }

}

 /*Show Patient record*/
  public function ShowPatientRecord($HICN = '',$form='') {
     if(isset($_GET['HICN'])){
            $HICN = trim($_GET['HICN']);
        }
        if($form == 'view'){
           $SqlCheck = "CALL GetPatientRecord_ByHICN('view','$HICN')";
        }
        if($form == 'edit'){
            $SqlCheck = "CALL GetPatientRecord_ByHICN('edit','$HICN')";
        }
            $result = mysql_query($SqlCheck);
            if($result){
               $row_count = mysql_num_rows($result);
                if($row_count == 1){
                   $row = mysql_fetch_array($result, MYSQL_ASSOC);
                    $result_arr = array('PatientFname' => ucwords($row['PatientFname']),
                    'PatientMidName' => ucwords($row['PatientMidName']),
                    'PatientLname' => ucwords($row['PatientLname']),
                    'PatientSex' => $row['PatientSex'],
                    'PatientDOB' => $row['PatientDOB'],
                    'PatientAddr1' => $row['PatientAddr1'],
                    'PatientAddr2' => $row['PatientAddr2'],
                    'PatientSt' => $row['PatientSt'],
                    'PatientZip' => $row['PatientZip'],
                    'PatientPhone' => $row['PatientPhone'],
                    'PatientHICN' => $row['PatientHICN'],
                    'PatientCity' => ucwords($row['PatientCity']));
                    
                    return json_encode($result_arr);
                } 
            }
            else{
                return FALSE;  
            }
  }
 
 /*Edit patient record*/
   public function editPatientRecord() {
      $GetSet=new GetSet();
    
      $GetSet->setHICN($_POST['txtHICN']);
      $HICN = trim($GetSet->getHICN());
      $GetSet->setFName($_POST['txtFname']);
      $FName = trim($GetSet->getFName());
      $GetSet->setMName($_POST['txtMname']);
      $MName = trim($GetSet->getMName());
      $GetSet->setLName($_POST['txtLname']);
      $LName = trim($GetSet->getLName());
      $GetSet->setDOB($_POST['txtDOB']);
      $DOB1 = trim($GetSet->getDOB());
      $GetSet->setGender($_POST['ddlSex']);
      $Gender = trim($GetSet->getGender());
      $GetSet->setAddress1($_POST['txtAddress1']);
      $Address1 = trim($GetSet->getAddress1());
      $GetSet->setAddress2($_POST['txtAddress2']);
      $Address2 = trim($GetSet->getAddress2());
      $GetSet->setCity($_POST['txtCity']);
      $City = trim($GetSet->getCity());
      $GetSet->setState($_POST['ddlNewPatientState']);
      $State = trim($GetSet->getState());
      $GetSet->setZip($_POST['txtHICNZip']);
      $Zip = trim($GetSet->getZip());
      $GetSet->setPhoneNo($_POST['txtPhoneno']);   
      $PhoneNo = trim($GetSet->getPhoneNo());   
      $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
            $SqlCheck = "CALL Sp_insertUpdate_Patient('Update','$HICN','$LName','$MName','$FName','$Address1','$Address2','$City','$State','$Zip','$PhoneNo','$DOB1','$Gender','$LastUpdateID')";
            
            $result = mysql_query($SqlCheck);
            
            if (!$result) 
            {
             die('Invalid query: ' . $sql . "   " . mysql_error());
            }
            else{
              if($result == 'OK'){
                return TRUE;
              }
              if($result == 'Already'){
                return FALSE;
              }
            }
   }

   
/*----------------------Patient record end-------------------------------------------------------------- */

/*----------------------Facility Insert record  Start-------------------------------------------------------------- */

    public function insertFacility($HdrID='') {
        $GetSet=new GetSet();
         if(isset($_GET['HdrID'])){
            $GetSet->setHdrID(trim($_GET['HdrID']));
              $HdrID = $GetSet->getHdrID();
            $GetSet->setFacilityNPI($_POST['txtPOPFacilityNPI']);
              $FacilityNPI = trim($GetSet->getFacilityNPI());
            $GetSet->setFName($_POST['txtPOPFacilityname']);
              $Fname = trim($GetSet->getFName());
            $GetSet->setAddress1($_POST['txtPOPFacilityAddress1']);
              $Address1 = trim($GetSet->getAddress1());
            $GetSet->setAddress2($_POST['txtPOPFacilityAddress2']);
              $Address2 = trim($GetSet->getAddress2());
            $GetSet->setCity($_POST['txtPOPFacilityCity']);
              $City = trim($GetSet->getCity());
            $GetSet->setState($_POST['ddlPOPFacilityState']);
              $State = trim($GetSet->getState());
            $GetSet->setZip($_POST['txtPOPFacilityzip']);
              $Zip = trim($GetSet->getZip());
            $GetSet->setPhoneNo($_POST['txtPOPFacilityPhoneNo']); 
              $PhoneNo = trim($GetSet->getPhoneNo()); 
               
           
                $sql = "Update cms484hdr set FacilityNPI='$FacilityNPI', FacilityID='', FacilityName='$Fname', FacilityAddr1='$Address1', FacilityAddr2='$Address2', FacilityCity='$City', FacilityST='$State', FacilityZip='$Zip', FacilityPhone='$PhoneNo' where HdrID='$HdrID' ";
                $result = mysql_query($sql);
                if (!$result) 
                    {
                    die('Invalid query: ' . $sql . "   " . mysql_error());
                }
                $return_arr = array('status'=>TRUE,'facility_npi'=>$FacilityNPI);
              
                return json_encode($return_arr);
         }
 
}

/*----------------------Facility  End-------------------------------------------------------------- */

/*----------------------Physician record start-------------------------------------------------------------- */
 
 /*physician record */

   public function get_physicianGridBind () {
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

  $sql = "Select SQL_CALC_FOUND_ROWS CONCAT (if(PhysicianFirstname is null,'',PhysicianFirstname),' ',if(PhysicianMidname is null,'',PhysicianMidname),' ',if(PhysicianLastname is null,'',PhysicianLastname)) as PhysicianName,PhysicianNPI,PhysicianPhone,PhysicianCity,PhysicianZip,PhysicianSt,PhysicianFirstname,PhysicianLastname 
  FROM physician";
  if($count > 0){
   $sql .= " WHERE ";
   if($filter['SelectFilter'] == 'LastName'){
    $sql .= "PhysicianLastname LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'NPI'){
    $sql .= "PhysicianNPI LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'FirstName'){
    $sql .= "PhysicianFirstname LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'ZipCode'){
    $sql .= "PhysicianZip LIKE '%".$filter['PatientHICN']."%'";
   }
  }
  $sql .= " order by PhysicianLastUpdate DESC LIMIT $start,$limit;";

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
         $app_list[] = array('PhysicianName'=> ucwords($row['PhysicianName']),'PhysicianNPI' => $row['PhysicianNPI'], 'PhysicianPhone' => $row['PhysicianPhone'],'PhysicianCity'=>ucwords($row['PhysicianCity']),'PhysicianZip'=>$row['PhysicianZip'],'PhysicianSt'=>$row['PhysicianSt'],'PhysicianFirstname'=>$row['PhysicianFirstname'],'PhysicianLastname'=>$row['PhysicianLastname']);
        }

        $return_arr = array('total'=>$num_rows,'data'=>$app_list);
        return $return_arr;
}
                

     /* public function get_physicianGridBind () {
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
		
		$P_Filter= isset($filter['PatientHICN']) ? $filter['PatientHICN'] : '';
		$P_FilterType=isset($filter['SelectFilter']) ? $filter['SelectFilter'] : '';
		
        $start = isset($_GET['start']) ? $_GET['start'] : '';
        $limit = isset($_GET['limit']) ? $_GET['limit'] : '';
	$sql = "CALL Sp_GetphysicianGridBind('$P_FilterType','$P_Filter','$start','$limit')";
     $result = mysql_query($sql);
        if (!$result) {
        die('Invalid query: ' . $sql . "   " . mysql_error());
        }
		//if($result == 'OK'){
		$total_count = mysql_query("SELECT FOUND_ROWS()");
        $num_rows = mysql_fetch_row($total_count);
       
	   //Allocate the array
        $app_list = array();
        //Loop through database to add books to array
        while ($row = mysql_fetch_assoc($result)) {
        //echo '<pre>';print_r($row);echo '</pre>';
         $app_list[] = array('PhysicianName'=> ucwords($row['PhysicianName']),'PhysicianNPI' => $row['PhysicianNPI'], 'PhysicianPhone' => $row['PhysicianPhone'],'PhysicianCity'=>ucwords($row['PhysicianCity']),'PhysicianZip'=>$row['PhysicianZip'],'PhysicianSt'=>$row['PhysicianSt'],'PhysicianFirstname'=>$row['PhysicianFirstname'],'PhysicianLastname'=>$row['PhysicianLastname']);
        }

        $return_arr = array('total'=>$num_rows,'data'=>$app_list);
        return $return_arr;
}
        */        



  /*Show physician record*/
  public function ShowPhysicianRecord($physician_NPI = '') {
     if(isset($_GET['physician_NPI'])){
            $physician_NPI = trim($_GET['physician_NPI']);
        }
            $SqlCheck = "CALL GetPhysicians_ByNPI('$physician_NPI')";
            $result = mysql_query($SqlCheck);
            if($result){
               $row_count = mysql_num_rows($result);
                if($row_count == 1){
                   $row = mysql_fetch_array($result, MYSQL_ASSOC);
                    $result_arr = array('PhysicianFirstname' => ucwords($row['PhysicianFirstname']),
                    'PhysicianMidname' => ucwords($row['PhysicianMidname']),
                    'PhysicianLastname' => ucwords($row['PhysicianLastname']),
                    'PhysicianAddr1' => $row['PhysicianAddr1'],
                    'PhysicianAddr2' => $row['PhysicianAddr2'],
                    'PhysicianCity' => ucwords($row['PhysicianCity']),
                    'PhysicianSt' => $row['PhysicianSt'],
                    'PhysicianZip' => $row['PhysicianZip'],
                    'PhysicianPhone' => $row['PhysicianPhone'],
                    'PhysicianAltEmailId' => $row['PhysicianAltEmailId']);
                    return json_encode($result_arr);
                } 
            }
            else{
                return FALSE;  
            }
  }
  
  /*Edit physician record*/
   public function editPhysicianRecord() {
    $GetSet=new GetSet();
    $GetSet->setPhysicianNPI($_POST['txtPhysicianNPI']);
    $PhysicianNPI=trim($GetSet->getPhysicianNPI());
    $GetSet->setFName($_POST['txtPhysicianFname']);
    $FName = trim($GetSet->getFName());
    $GetSet->setMName($_POST['txtPhysicianMname']);
    $MName = trim($GetSet->getMName());
    $GetSet->setLName($_POST['txtPhysicianLname']);
    $LName = trim($GetSet->getLName());
    $GetSet->setAddress1($_POST['txtPhysicianAddress1']);
    $Address1 = trim($GetSet->getAddress1());
    $GetSet->setAddress2($_POST['txtPhysicianAddress2']);
    $Address2 = trim($GetSet->getAddress2());
    $GetSet->setCity($_POST['txtPhysicianCity']);
    $City = trim($GetSet->getCity());
    $GetSet->setState($_POST['ddlPhysicianState']);
    $State = trim($GetSet->getState());
    $GetSet->setZip($_POST['txtPhysicianZip']);
    $Zip = trim($GetSet->getZip());
    $GetSet->setPhoneNo($_POST['txtPhysicianPhoneNo']);
    $PhoneNo = trim($GetSet->getPhoneNo());

    $GetSet->setAltemailID($_POST['txtPhysicianEmail']);
    $AltEmailId = trim($GetSet->getAltemailID());

    $GetSet->setLastUpdateID($_GET['src']);
    $LastUpdateID = $GetSet->getLastUpdateID();
		 $SqlCheck = "CALL Sp_insertUpdate_Physicians('Update','$PhysicianNPI','$LName','$MName','$FName','$Address1','$Address2','$City','$State','$Zip','$PhoneNo','$AltEmailId','$LastUpdateID')";
          $result = mysql_query($SqlCheck);
                if (!$result) 
                  {
                   die('Invalid query: ' . $sql . "   " . mysql_error());
                  }
            else{
				if($result == 'OK'){
					return TRUE;
				}
				if($result == 'Already'){
					return FALSE;
				}
                
            }
           
   }
   
  /*----------------------Physician record end-------------------------------------------------------------- */
  
    /*----------------------Supplier record start-------------------------------------------------------------- */
   /*Supplier record */
     public function get_SupplierGridBind () {
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
  
  $sql = "Select SQL_CALC_FOUND_ROWS SupplierNPI, SupplierName,SupplierCity, SupplierSt, SupplierZip, SupplierPhone,LastUpdate 
  FROM supplier";
  if($count > 0){
   $sql .= " WHERE ";
   if($filter['SelectFilter'] == 'SupplierName'){
    $sql .= "SupplierName LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'NPI'){
    $sql .= "SupplierNPI LIKE '%".$filter['PatientHICN']."%'";
   }elseif($filter['SelectFilter'] == 'ZipCode'){
    $sql .= "SupplierZip LIKE '%".$filter['PatientHICN']."%'";
   }
  }
  $sql .= " order by LastUpdate DESC LIMIT $start,$limit;";

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
         $app_list[] = array('SupplierName'=> ucwords($row['SupplierName']),'SupplierNPI' => $row['SupplierNPI'], 'SupplierCity' => ucwords($row['SupplierCity']),'SupplierSt'=>$row['SupplierSt'],'SupplierZip'=>$row['SupplierZip'],'SupplierPhone'=>$row['SupplierPhone']);
        }

        $return_arr = array('total'=>$num_rows,'data'=>$app_list);
        return $return_arr;
}
  
    /*Insert supplier record in db*/
    public function insertsupplierRecord() {
      $GetSet=new GetSet();
      $GetSet->setNPI($_POST['txtSNPI']); 
      $NPI = $GetSet->getNPI(); 

      $GetSet->setFName($_POST['txtSupplierName']);
      $FName = trim($GetSet->getFName());
      $GetSet->setAddress1($_POST['txtSAddress1']);
      $Address1 = trim($GetSet->getAddress1());
      $GetSet->setAddress2($_POST['txtSAddress2']);
      $Address2 = trim($GetSet->getAddress2());
            $GetSet->setCity($_POST['txtSCity']);
      $City = trim($GetSet->getCity());
            $GetSet->setState( $_POST['ddlSState']);
      $State = trim($GetSet->getState ());
            $GetSet->setZip($_POST['txtSZip']);
      $Zip = trim($GetSet->getZip());
            $GetSet->setPhoneNo($_POST['txtSPhoneNo']);
      $PhoneNo = trim($GetSet->getPhoneNo());
      $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
	              $SqlCheck = "CALL Sp_insertUpdate_Supplier('Insert','$NPI','$FName','$Address1','$Address2','$City','$State','$Zip','$PhoneNo','$LastUpdateID')";
      $result = mysql_query($SqlCheck);
                if (!$result) 
                  {
                   die('Invalid query: ' . $sql . "   " . mysql_error());
                  }
            else{
				if($result == 'OK'){
					 return TRUE;
				}
				if($result == 'Already'){
					return FALSE;
				}
                
            }			
			
}

 /*Show Supplier record*/
  public function ShowSupplierRecord($SupplierNPI = '') {
     if(isset($_GET['SupplierNPI'])){
            $SupplierNPI = trim($_GET['SupplierNPI']);
        }
            $SqlCheck = "CALL GetSupplier_ByNPI('$SupplierNPI')";
            $result = mysql_query($SqlCheck);
            if($result){
               $row_count = mysql_num_rows($result);
                if($row_count == 1){
                   $row = mysql_fetch_array($result, MYSQL_ASSOC);
                    $result_arr = array('SupplierNPI' => $row['SupplierNPI'],
                    'SupplierName' => ucwords($row['SupplierName']),
                    'SupplierAddr1' => $row['SupplierAddr1'],
                    'SupplierAddr2' => $row['SupplierAddr2'],
                    'SupplierCity' => ucwords($row['SupplierCity']),
                    'SupplierSt' => $row['SupplierSt'],
                    'SupplierZip' => $row['SupplierZip'],
                     'SupplierPhone' => $row['SupplierPhone']);
                    return json_encode($result_arr);
                } 
            }
            else{
                return FALSE;  
            }
  }
  
  
 /*Edit Supplier record*/
   public function editSupplierRecord() {
    $GetSet=new GetSet();
    $GetSet->setNPI($_POST['txtSNPI']); 
    $NPI = $GetSet->getNPI(); 

    $GetSet->setFName($_POST['txtSupplierName']);
    $FName = trim($GetSet->getFName());
    $GetSet->setAddress1($_POST['txtSAddress1']);
    $Address1 = trim($GetSet->getAddress1());
    $GetSet->setAddress2($_POST['txtSAddress2']);
    $Address2 = trim($GetSet->getAddress2());
      $GetSet->setCity($_POST['txtSCity']);
    $City = trim($GetSet->getCity());
      $GetSet->setState( $_POST['ddlSState']);
    $State = trim($GetSet->getState());
      $GetSet->setZip($_POST['txtSZip']);
    $Zip = trim($GetSet->getZip());
      $GetSet->setPhoneNo($_POST['txtSPhoneNo']);
    $PhoneNo = trim($GetSet->getPhoneNo());
    $GetSet->setLastUpdateID($_GET['src']);
    $LastUpdateID = $GetSet->getLastUpdateID();

            $SqlCheck = "CALL Sp_insertUpdate_Supplier('Update','$NPI','$FName','$Address1','$Address2','$City','$State','$Zip','$PhoneNo','$LastUpdateID')";
      $result = mysql_query($SqlCheck);
                if (!$result) 
                  {
                   die('Invalid query: ' . $sql . "   " . mysql_error());
                  }
            else{
				if($result == 'OK'){
					 return TRUE;
				}
				if($result == 'Already'){
					return FALSE;
				}
                
            }			
   }
   /*----------------------Supplier record end-------------------------------------------------------------- */

      

}// Class def ends 
  
 $possible_url = array( "get_physicianGridBind","insertsupplierRecord","insertPatientHICN","POPinsertPatientHICN","insertFacility","editPhysicianRecord","ShowPhysicianRecord","get_SupplierGridBind","ShowSupplierRecord","editSupplierRecord","get_PatientGridBind","ShowPatientRecord","editPatientRecord");
 $value = "An error has occurred";
 $cms = new Maintainence();
if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
    switch ($_GET["action"]) {
      case "get_physicianGridBind" :
            $value = $cms->get_physicianGridBind();
            break;

      case "get_PatientGridBind" :
            $value = $cms->get_PatientGridBind();
            break;

      case "get_SupplierGridBind" :
            $value = $cms->get_SupplierGridBind();
            break;

      case "insertsupplierRecord" :
            $value = $cms->insertsupplierRecord();
            break;

      case "insertPatientHICN" :
             $value = $cms->insertPatientHICN();
             break;

      case "POPinsertPatientHICN" :
             $value = $cms->POPinsertPatientHICN();
             break;

      case "insertFacility" :
            if (isset ($_GET["HdrID"])){
                $value = $cms->insertFacility($_GET["HdrID"]);
            }
            else
                $value = "Missing argument";
            break;

      case "ShowPhysicianRecord":
         if (isset ($_GET['physician_NPI'])){
                $value = $cms->ShowPhysicianRecord($_GET['physician_NPI']);
            }
            else
                $value = "Missing argument";
            break;

      case "ShowPatientRecord":
         if (isset ($_GET['HICN']) && isset($_GET['form'])){
                $value = $cms->ShowPatientRecord($_GET['HICN'],$_GET['form']);
            }
            else
                $value = "Missing argument";
            break;


      case "ShowSupplierRecord":
         if (isset ($_GET['SupplierNPI'])){
                $value = $cms->ShowSupplierRecord($_GET['SupplierNPI']);
            }
            else
                $value = "Missing argument";
            break;


      case "editPhysicianRecord":
                $value = $cms->editPhysicianRecord();
            break;

          case "editSupplierRecord":
                $value = $cms->editSupplierRecord();
            break;

      case "editPatientRecord":
                $value = $cms->editPatientRecord();
            break;

    }
}
//return JSON array
echo json_encode($value);

?>