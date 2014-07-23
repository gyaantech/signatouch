<?php
// Ver 3
// Wed Jun 23 2014
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
        $total_count = mysql_query("SELECT PatientHICN FROM patient");
        $num_rows = mysql_num_rows($total_count);
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $sql = "Select patient.PatientHICN,CONCAT (if(patient.PatientFname is null,'',patient.PatientFname),' ',if(patient.PatientMidName is null,'',patient.PatientMidName),' ',if(patient.PatientLname is null,'',patient.PatientLname)) as PatientName,PatientLname,PatientFname,patient.PatientPhone,patient.PatientCity,patient.PatientSt,patient.PatientZip FROM patient order by patient.LastUpdate DESC LIMIT $start,$limit;";

        $result = mysql_query($sql);
        if (!$result) {
        die('Invalid query: ' . $sql . "   " . mysql_error());
        }
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
    //  $dob = date('Y-m-d',strtotime($_POST['txtDOB']));
      $GetSet->setHICN($_POST['txtHICN']);
      $HICN = $GetSet->getHICN();
      $GetSet->setFName($_POST['txtFname']);
      $FName = $GetSet->getFName();
      $GetSet->setMName($_POST['txtMname']);
      $MName = $GetSet->getMName();
      $GetSet->setLName($_POST['txtLname']);
      $LName = $GetSet->getLName();
      $GetSet->setDOB($_POST['txtDOB']);
      $DOB1 = $GetSet->getDOB();
      $GetSet->setGender($_POST['ddlSex']);
      $Gender = $GetSet->getGender();
      $GetSet->setAddress1($_POST['txtAddress1']);
      $Address1 = $GetSet->getAddress1();
      $GetSet->setAddress2($_POST['txtAddress2']);
      $Address2 = $GetSet->getAddress2();
      $GetSet->setCity($_POST['txtCity']);
      $City = $GetSet->getCity();
      $GetSet->setState($_POST['ddlNewPatientState']);
      $State = $GetSet->getState();
      $GetSet->setZip($_POST['txtHICNZip']);
      $Zip = $GetSet->getZip();
      $GetSet->setPhoneNo($_POST['txtPhoneno']);   
      $PhoneNo = $GetSet->getPhoneNo();   
      $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
                     
            $SqlCheck = "Select * from patient where PatientHICN= '$HICN'";
            $result = mysql_query($SqlCheck);
            $row_count = mysql_num_rows($result);
            if($row_count == 1){
                return FALSE;
            }
            else{
                $sql = "Insert into patient (PatientHICN,PatientFname,PatientMidName,PatientLname,PatientDOB,PatientSex,PatientAddr1,PatientAddr2,PatientCity,PatientSt,PatientZip,PatientPhone,LastUpdateID) values('$HICN','$FName','$MName','$LName',STR_TO_DATE('$DOB1', '%m-%d-%Y'),'$Gender','$Address1','$Address2','$City','$State','$Zip','$PhoneNo','$LastUpdateID')";
                $result = mysql_query($sql);
                if (!$result) 
                    {
                    die('Invalid query: ' . $sql . "   " . mysql_error());
                }
                return TRUE;  
            }
}

/*Insert Pop PatientHICN record in db*/
    public function POPinsertPatientHICN() {
		$GetSet=new GetSet();
        $GetSet->setHICN($_POST['txtPOPHICN']);
		$hicn = $GetSet->getHICN();      
        $GetSet->setFName($_POST['txtPOPFname']);
		$FName = $GetSet->getFName();
        $GetSet->setMName($_POST['txtPOPMname']);
		$MName = $GetSet->getMName();
        $GetSet->setLName($_POST['txtPOPLname']);
		$LName = $GetSet->getLName();
        $GetSet->setDOB($_POST['txtPOPDOB']);
		$DOB1 = $GetSet->getDOB();
        $GetSet->setGender($_POST['ddlPOPSex']);
		$Gender = $GetSet->getGender();
        $GetSet->setAddress1($_POST['txtPOPAddress1']);
		$Address1 = $GetSet->getAddress1();
        $GetSet->setAddress2($_POST['txtPOPAddress2']);
		$Address2 = $GetSet->getAddress2();
        $GetSet->setCity($_POST['txtPOPCity']);
		$City = $GetSet->getCity();
        $GetSet->setState($_POST['ddlPOPNewPatientState']);
		$State = $GetSet->getState();
        $GetSet->setZip($_POST['txtPOPZip']);
		$Zip = $GetSet->getZip();
        $GetSet->setPhoneNo($_POST['txtPOPPhoneno']);  
		$PhoneNo = $GetSet->getPhoneNo();   
    $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
		
        $SqlCheck = "Select * from patient where PatientHICN= '$hicn'";
        $result = mysql_query($SqlCheck);
        $row_count = mysql_num_rows($result);
        if($row_count == 1){
            return FALSE;
        }
        else{
            $sql = "Insert into patient (PatientHICN,PatientFname,PatientMidName,PatientLname,PatientDOB,PatientSex,PatientAddr1,PatientAddr2,PatientCity,PatientSt,PatientZip,PatientPhone,LastUpdateID) values('$hicn','$FName','$MName','$LName',STR_TO_DATE('$DOB1', '%m-%d-%Y'),'$Gender','$Address1','$Address2','$City','$State','$Zip','$PhoneNo','$LastUpdateID')";
            $result = mysql_query($sql);

            if (!$result) 
            {
                die('Invalid query: ' . $sql . "   " . mysql_error());
            }
            $patient_name = $FName.' '.$MName.' '.$LName;
            $hicn_arr = array('HICN'=>$hicn,'Name'=>$patient_name,'status'=>'ok');
            return $hicn_arr;  
        }
}

 /*Show Patient record*/
  public function ShowPatientRecord($HICN = '',$form='') {
     if(isset($_GET['HICN'])){
            $HICN = trim($_GET['HICN']);
        }
        if($form == 'view'){
           $SqlCheck = "SELECT PatientHICN,PatientFname,PatientMidName,PatientLname,DATE_FORMAT(PatientDOB, '%M %d ,%Y') as PatientDOB,PatientSex,PatientAddr1,PatientAddr2,PatientCity,PatientSt,PatientZip,PatientPhone FROM patient WHERE PatientHICN = '$HICN'";
        }
        if($form == 'edit'){
           $SqlCheck = "SELECT PatientHICN,PatientFname,PatientMidName,PatientLname,DATE_FORMAT(PatientDOB, '%m-%d-%Y') as PatientDOB,PatientSex,PatientAddr1,PatientAddr2,PatientCity,PatientSt,PatientZip,PatientPhone FROM patient WHERE PatientHICN = '$HICN'";
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
      $HICN = $GetSet->getHICN();
      $GetSet->setFName($_POST['txtFname']);
      $FName = $GetSet->getFName();
      $GetSet->setMName($_POST['txtMname']);
      $MName = $GetSet->getMName();
      $GetSet->setLName($_POST['txtLname']);
      $LName = $GetSet->getLName();
      $GetSet->setDOB($_POST['txtDOB']);
      $DOB1 = $GetSet->getDOB();
      $GetSet->setGender($_POST['ddlSex']);
      $Gender = $GetSet->getGender();
      $GetSet->setAddress1($_POST['txtAddress1']);
      $Address1 = $GetSet->getAddress1();
      $GetSet->setAddress2($_POST['txtAddress2']);
      $Address2 = $GetSet->getAddress2();
      $GetSet->setCity($_POST['txtCity']);
      $City = $GetSet->getCity();
      $GetSet->setState($_POST['ddlNewPatientState']);
      $State = $GetSet->getState();
      $GetSet->setZip($_POST['txtHICNZip']);
      $Zip = $GetSet->getZip();
      $GetSet->setPhoneNo($_POST['txtPhoneno']);   
      $PhoneNo = $GetSet->getPhoneNo();   
      $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
            $SqlCheck = "SELECT PatientHICN FROM patient WHERE PatientHICN = '$HICN'";
            $result = mysql_query($SqlCheck);
            if($result){
               $row_count = mysql_num_rows($result);
                if($row_count == 1){
                    
                   $sql = "UPDATE patient SET PatientLname='$LName',PatientMidName='$MName',PatientFname='$FName',PatientAddr1='$Address1',PatientAddr2='$Address2',PatientCity='$City',PatientSt='$State',PatientZip='$Zip',PatientPhone='$PhoneNo',PatientDOB = STR_TO_DATE('$DOB1', '%m-%d-%Y'),PatientSex='$Gender',LastUpdate=NOW(),LastUpdateID = '$LastUpdateID'  where PatientHICN= '$HICN'";
                  $result1 = mysql_query($sql);
                if (!$result1) 
                  {
                   die('Invalid query: ' . $sql . "   " . mysql_error());
                  }
                    return TRUE;
                } 
            }
            else{
                return FALSE;  
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
              $FacilityNPI = $GetSet->getFacilityNPI();
            $GetSet->setFName($_POST['txtPOPFacilityname']);
              $Fname = $GetSet->getFName();
            $GetSet->setAddress1($_POST['txtPOPFacilityAddress1']);
              $Address1 = $GetSet->getAddress1();
            $GetSet->setAddress2($_POST['txtPOPFacilityAddress2']);
              $Address2 = $GetSet->getAddress2();
            $GetSet->setCity($_POST['txtPOPFacilityCity']);
              $City = $GetSet->getCity();
            $GetSet->setState($_POST['ddlPOPFacilityState']);
              $State = $GetSet->getState();
            $GetSet->setZip($_POST['txtPOPFacilityzip']);
              $Zip = $GetSet->getZip();
            $GetSet->setPhoneNo($_POST['txtPOPFacilityPhoneNo']); 
              $PhoneNo = $GetSet->getPhoneNo(); 
               
            $SqlCheck = "Select * from cms484hdr where FacilityNPI= '$FacilityNPI'";
            $result = mysql_query($SqlCheck);
            $row_count = mysql_num_rows($result);
            if($row_count == 1){
                return FALSE;
            }
            else{
                $sql = "Update cms484hdr set FacilityNPI='$FacilityNPI', FacilityID='', FacilityName='$Fname', FacilityAddr1='$Address1', FacilityAddr2='$Address2', FacilityCity='$City', FacilityST='$State', FacilityZip='$Zip', FacilityPhone='$PhoneNo' where HdrID='$HdrID' ";
                $result = mysql_query($sql);
                if (!$result) 
                    {
                    die('Invalid query: ' . $sql . "   " . mysql_error());
                }
                $return_arr = array('status'=>TRUE,'facility_npi'=>$FacilityNPI);
               // echo '<pre>';print_r(json_encode($return_arr));echo '</pre>';
                return json_encode($return_arr);
            }
         }
 
}

/*----------------------Facility  End-------------------------------------------------------------- */

/*----------------------Physician record start-------------------------------------------------------------- */
 
 /*physician record */
     public function get_physicianGridBind () {
        $total_count = mysql_query("SELECT PhysicianNPI FROM physician");
        $num_rows = mysql_num_rows($total_count);
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $sql = "Select CONCAT (if(PhysicianFirstname is null,'',PhysicianFirstname),' ',if(PhysicianMidname is null,'',PhysicianMidname),' ',if(PhysicianLastname is null,'',PhysicianLastname)) as PhysicianName,PhysicianNPI,PhysicianPhone,PhysicianCity,PhysicianZip,PhysicianSt,PhysicianFirstname,PhysicianLastname FROM physician order by PhysicianLastUpdate DESC LIMIT $start,$limit;";

        $result = mysql_query($sql);
        if (!$result) {
        die('Invalid query: ' . $sql . "   " . mysql_error());
        }
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
                



  /*Show physician record*/
  public function ShowPhysicianRecord($physician_NPI = '') {
     if(isset($_GET['physician_NPI'])){
            $physician_NPI = trim($_GET['physician_NPI']);
        }
            $SqlCheck = "SELECT PhysicianLastname, PhysicianMidname, PhysicianFirstname, PhysicianAddr1, PhysicianAddr2,PhysicianCity, PhysicianSt, PhysicianZip, PhysicianPhone, PhysicianAltEmailId FROM physician WHERE PhysicianNPI = '$physician_NPI'";
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
		$PhysicianNPI=$GetSet->getPhysicianNPI();
		$GetSet->setFName($_POST['txtPhysicianFname']);
		$FName = $GetSet->getFName();
        $GetSet->setMName($_POST['txtPhysicianMname']);
		$MName = $GetSet->getMName();
		$GetSet->setLName($_POST['txtPhysicianLname']);
		$LName = $GetSet->getLName();
        $GetSet->setAddress1($_POST['txtPhysicianAddress1']);
		$Address1 = $GetSet->getAddress1();
        $GetSet->setAddress2($_POST['txtPhysicianAddress2']);
		$Address2 = $GetSet->getAddress2();
        $GetSet->setCity($_POST['txtPhysicianCity']);
		$City = $GetSet->getCity();
        $GetSet->setState($_POST['ddlPhysicianState']);
		$State = $GetSet->getState();
        $GetSet->setZip($_POST['txtPhysicianZip']);
		$Zip = $GetSet->getZip();
        $GetSet->setPhoneNo($_POST['txtPhysicianPhoneNo']);
		$PhoneNo = $GetSet->getPhoneNo();
		
    $GetSet->setAltemailID($_POST['txtPhysicianEmail']);
    $AltEmailId = $GetSet->getAltemailID();
    
    $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
		
            $SqlCheck = "SELECT PhysicianNPI FROM physician WHERE PhysicianNPI = '$PhysicianNPI'";
            $result = mysql_query($SqlCheck);
            if($result){
               $row_count = mysql_num_rows($result);
                if($row_count == 1){
                    
                   $sql = "UPDATE physician SET PhysicianLastname='$LName',PhysicianMidname='$MName',PhysicianFirstname='$FName',PhysicianAddr1='$Address1',PhysicianAddr2='$Address2',PhysicianCity='$City',PhysicianSt='$State',PhysicianZip='$Zip',PhysicianPhone='$PhoneNo', PhysicianAltEmailId='$AltEmailId',PhysicianLastUpdateID='$LastUpdateID',PhysicianLastUpdate=NOW()  where PhysicianNPI= '$PhysicianNPI'";
                  $result1 = mysql_query($sql);
                if (!$result1) 
                  {
                   die('Invalid query: ' . $sql . "   " . mysql_error());
                  }
                    return TRUE;
                } 
            }
            else{
                return FALSE;  
            }
   }
   
 
  /*----------------------Physician record end-------------------------------------------------------------- */
  
    /*----------------------Supplier record start-------------------------------------------------------------- */
   /*Supplier record */
     public function get_SupplierGridBind () {
        $total_count = mysql_query("SELECT SupplierNPI FROM supplier");
        $num_rows = mysql_num_rows($total_count);
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $sql = "SELECT SupplierNPI, SupplierName,SupplierCity, SupplierSt, SupplierZip, SupplierPhone,LastUpdate FROM supplier order by LastUpdate DESC LIMIT $start,$limit;";

        $result = mysql_query($sql);
        if (!$result) {
        die('Invalid query: ' . $sql . "   " . mysql_error());
        }
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
			$FName = $GetSet->getFName();
			$GetSet->setAddress1($_POST['txtSAddress1']);
			$Address1 = $GetSet->getAddress1();
			$GetSet->setAddress2($_POST['txtSAddress2']);
			$Address2 = $GetSet->getAddress2();
            $GetSet->setCity($_POST['txtSCity']);
			$City = $GetSet->getCity();
            $GetSet->setState( $_POST['ddlSState']);
			$State = $GetSet->getState ();
            $GetSet->setZip($_POST['txtSZip']);
			$Zip = $GetSet->getZip();
            $GetSet->setPhoneNo($_POST['txtSPhoneNo']);
			$PhoneNo = $GetSet->getPhoneNo();
    $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
            $SqlCheck = "Select * from supplier where SupplierNPI= $NPI";
            $result = mysql_query($SqlCheck);
            $row_count = mysql_num_rows($result);
            if($row_count == 1){
                return FALSE;
            }
            else{
       $sql = "Insert into supplier (SupplierNPI,SupplierName,SupplierAddr1,SupplierAddr2,SupplierCity,SupplierSt,SupplierZip,SupplierPhone,LastUpdateID) values('$NPI','$FName','$Address1','$Address2','$City','$State','$Zip','$PhoneNo','$LastUpdateID')";
                $result = mysql_query($sql);
                if (!$result) 
                    {
                    die('Invalid query: ' . $sql . "   " . mysql_error());
                }
                return TRUE;  
            }
}

 /*Show Supplier record*/
  public function ShowSupplierRecord($SupplierNPI = '') {
     if(isset($_GET['SupplierNPI'])){
            $SupplierNPI = trim($_GET['SupplierNPI']);
        }
            $SqlCheck = "SELECT SupplierNPI, SupplierName, SupplierAddr1, SupplierAddr2, SupplierCity, SupplierSt, SupplierZip, SupplierPhone FROM supplier WHERE SupplierNPI = '$SupplierNPI'";
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
			$FName = $GetSet->getFName();
			$GetSet->setAddress1($_POST['txtSAddress1']);
			$Address1 = $GetSet->getAddress1();
			$GetSet->setAddress2($_POST['txtSAddress2']);
			$Address2 = $GetSet->getAddress2();
            $GetSet->setCity($_POST['txtSCity']);
			$City = $GetSet->getCity();
            $GetSet->setState( $_POST['ddlSState']);
			$State = $GetSet->getState ();
            $GetSet->setZip($_POST['txtSZip']);
			$Zip = $GetSet->getZip();
            $GetSet->setPhoneNo($_POST['txtSPhoneNo']);
			$PhoneNo = $GetSet->getPhoneNo();
    $GetSet->setLastUpdateID($_GET['src']);
      $LastUpdateID = $GetSet->getLastUpdateID();
			
            $SqlCheck = "Select * from supplier where SupplierNPI= $NPI";
   $result = mysql_query($SqlCheck);
            if($result){
               $row_count = mysql_num_rows($result);
                if($row_count == 1){
                    
                   $sql = "UPDATE supplier SET SupplierName='$FName',SupplierAddr1='$Address1',SupplierAddr2='$Address2',SupplierCity='$City',SupplierSt='$State',SupplierZip='$Zip',SupplierPhone='$PhoneNo',LastUpdateID='$LastUpdateID',LastUpdate=NOW() where SupplierNPI= '$NPI'";
                  $result1 = mysql_query($sql);
                if (!$result1) 
                  {
                   die('Invalid query: ' . $sql . "   " . mysql_error());
                  }
                    return TRUE;
                } 
            }
            else{
                return FALSE;  
            }
   }
   /*----------------------Supplier record end-------------------------------------------------------------- */
   /*Fetch COS Data*/
   public function FetchCOS() {
     $SqlCheck = "SELECT COSID,COSName FROM cos";
            $result = mysql_query($SqlCheck);
            if($result){
               $row_count = mysql_num_rows($result);
                if($row_count >= 1){
                   while ($row = mysql_fetch_assoc($result)) {
                    $result_arr[] = array('COSID' => $row['COSID'],
                    'COSName' => $row['COSName'],
                    ); 
                   }
                    echo '<pre>';print_r($result_arr);echo '</pre>';
                    return $result_arr;
                } 
            }
  }
   
      

}// Class def ends 
  
 $possible_url = array( "get_physicianGridBind","insertsupplierRecord","insertPatientHICN","POPinsertPatientHICN","insertFacility","editPhysicianRecord","ShowPhysicianRecord","get_SupplierGridBind","ShowSupplierRecord","editSupplierRecord","get_PatientGridBind","ShowPatientRecord","editPatientRecord","FetchCOS");
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
      case "FetchCOS":
         
                $value = $cms->FetchCOS();
  
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