<?php
// Ver 1
//  August 14 2014
// -------------------------------------
// Print function
// =====================================

include "DBConnection.php";
include "GetSet.php";

class Function1
{
    //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();
    }
     
/*----------------------------------------Common Function-------------------------------------------------------------*/
  

 
/*Function to print all details of a record and bind to view page*/
    public function PrintRecordData($HdrID = ''){
        $HdrID = isset($_GET['HDRID']) ? trim($_GET['HDRID']) : '';
        $sql = "Select cms484hdr.HdrID,cms484hdr.CertType,cms484hdr.StausFLG,DATE_FORMAT(cms484hdr.InitialCertDate, '%M %d ,%Y') as InitialCertDate,DATE_FORMAT(cms484hdr.RevisedCertDate, '%M %d ,%Y') as RevisedCertDate,DATE_FORMAT(cms484hdr.RecertificationDate, '%M %d ,%Y') as RecertificationDate,patient.PatientHICN,CONCAT (if(patient.PatientFname is null,'',patient.PatientFname),' ',if(patient.PatientMidName is null,'',patient.PatientMidName),' ',if(patient.PatientLname is null,'',patient.PatientLname)) as PatientName,DATE_FORMAT(patient.PatientDOB, '%M %d ,%Y') as PatientDOB,patient.PatientSex,patient.PatientPhone,patient.PatientAddr1,patient.PatientAddr2,patient.PatientCity,patient.PatientSt,patient.PatientZip,supplier.SupplierNPI,supplier.SupplierName,supplier.SupplierAddr1,supplier.SupplierAddr2,supplier.SupplierCity,supplier.SupplierSt,supplier.SupplierZip,supplier.SupplierPhone,physician.PhysicianNPI,CONCAT (if(physician.PhysicianFirstname is null,'',physician.PhysicianFirstname),' ',if(physician.PhysicianMidname is null,'',physician.PhysicianMidname),' ',if(physician.PhysicianLastname is null,'',physician.PhysicianLastname)) as PhysicianName, physician.PhysicianAddr1,physician.PhysicianAddr2,physician.PhysicianCity,physician.PhysicianSt,physician.PhysicianZip,physician.PhysicianPhone,cms484hdr.PlaceService,cms484hdr.FacilityNPI,cms484hdr.FacilityName,cms484hdr.FacilityPhone,cms484hdr.FacilityAddr1,cms484hdr.FacilityAddr2,cms484hdr.FacilityCity,cms484hdr.FacilityST,cms484hdr.FacilityZip,cms484hdr.`HCPCS-E0431`,cms484hdr.`HCPCS-E0431SupChrg`,cms484hdr.`HCPCS-E0431MedFee`,cms484hdr.`HCPCS-E1390`,cms484hdr.`HCPCS-E1390SupChrg`,cms484hdr.`HCPCS-E1390MedFee`,cms484hdr.`HCPCS-E1392`,cms484hdr.`HCPCS-E1392MedFee`,cms484hdr.`HCPCS-E1392SupChrg`,cms484hdr.`HCPCS-K0738`,cms484hdr.`HCPCS-K0738MedFee`,cms484hdr.`HCPCS-K0738SupChrg`,cms484hdr.`HCPCS-Other1Code`,cms484hdr.`HCPCS-Other1Desc`,cms484hdr.`HCPCS-Other1MedFee`,cms484hdr.`HCPCS-Other1SupChrg`,cms484hdr.`HCPCS-Other2Code`,cms484hdr.`HCPCS-Other2Desc`,cms484hdr.`HCPCS-Other2MedFee`,cms484hdr.`HCPCS-Other2SupChrg`,cms484hdr.`HCPCS-Other3Code`,cms484hdr.`HCPCS-Other3Desc`,cms484hdr.`HCPCS-Other3MedFee`,cms484hdr.`HCPCS-Other3SupChrg`,cms484hdr.`HCPCS-Other4Code`,cms484hdr.`HCPCS-Other4Desc`,cms484hdr.`HCPCS-Other4MedFee`,cms484hdr.`HCPCS-Other4SupChrg`,cms484det.LengthNeed,CONCAT('ICD9-Diagnosis Code : ',cms484det.ICD9,' - ',icd9.ICD9ShortDesc) as ICD9,cms484det.Q1AmmHg,cms484det.Q1Bpercent,DATE_FORMAT(cms484det.Q1Cdate, '%M %d ,%Y') as Q1Cdate,cms484det.Q2cond,cms484det.Q3cond,cms484det.Q4portable,cms484det.Q5O2LPM,cms484det.Q6AmmHg,cms484det.Q6Bpercent,DATE_FORMAT(cms484det.Q6Cdate, '%M %d ,%Y') as Q6Cdate,cms484det.Q7CHF,cms484det.Q8Hypert,cms484det.Q9Herm,cms484det.SignedByName,cms484det.SignedByTitle,cms484det.SignedByEmployer,DATE_FORMAT(cms484det.LastUpdate, '%M %d ,%Y') as LastUpdate,case when (cms484det.LengthNeed is null and cms484det.ICD9 is null and cms484det.SignedByEmployer is null) then '(Not Filled Out)' End as Send from cms484hdr inner join patient on patient.PatientHICN = cms484hdr.PatientHICN Left join supplier on supplier.SupplierNPI = cms484hdr.SupplierNPI Left join physician on physician.PhysicianNPI = cms484hdr.PhysicianNPI inner join cms484det on cms484det.DetailID = cms484hdr.HdrID Left join icd9 on icd9.ICD9ID = cms484det.ICD9 Where cms484hdr.HdrID = '$HdrID';";
         $result = mysql_query($sql);
            if($result)
                {
               $row_count = mysql_num_rows($result);
                if($row_count == 1)
                    {
                    $row = mysql_fetch_array($result, MYSQL_ASSOC);
                       $result_arr = array('HdrID' => $row['HdrID'],
                        'CertType' => $row['CertType'],
                        'StausFLG' => $row['StausFLG'], 
                        'InitialCertDate' => isset($row['InitialCertDate']) ? $row['InitialCertDate']: '', 
                        'RevisedCertDate' => isset($row['RevisedCertDate']) ? $row['RevisedCertDate']: '', 
                        'RecertificationDate' => isset($row['RecertificationDate']) ? $row['RecertificationDate'] : '', 
                        'PatientHICN' => $row['PatientHICN'], 
                        'PatientName' => $row['PatientName'],
                        'PatientDOB' => isset($row['PatientDOB']) ? $row['PatientDOB'] : '',  
                        'PatientSex' => $row['PatientSex'],
                        'PatientPhone' => $row['PatientPhone'],
                        'PatientAddr1' => $row['PatientAddr1'],
                        'PatientAddr2' => $row['PatientAddr2'], 
                        'PatientCity' => $row['PatientCity'],
                        'PatientSt' => $row['PatientSt'],
                        'PatientZip' => $row['PatientZip'],
                        'SupplierNPI' => $row['SupplierNPI'], 
                        'SupplierName' => $row['SupplierName'], 
                        'SupplierAddr1' => $row['SupplierAddr1'], 
                        'SupplierAddr2' => $row['SupplierAddr2'], 
                        'SupplierCity' => $row['SupplierCity'], 
                        'SupplierSt' => $row['SupplierSt'], 
                        'SupplierZip' => $row['SupplierZip'], 
                        'SupplierPhone' => $row['SupplierPhone'], 
                        'PhysicianNPI' => $row['PhysicianNPI'], 
                        'PhysicianName' => $row['PhysicianName'],   
                        'PhysicianAddr1' => $row['PhysicianAddr1'], 
                        'PhysicianAddr2' => $row['PhysicianAddr2'], 
                        'PhysicianCity' => $row['PhysicianCity'], 
                        'PhysicianSt' => $row['PhysicianSt'], 
                        'PhysicianZip' => $row['PhysicianZip'], 
                        'PhysicianPhone' => $row['PhysicianPhone'], 
                        'PlaceService' => $row['PlaceService'], 
                        'FacilityNPI' => $row['FacilityNPI'], 
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
                        'HCPCS_Other4SupChrg' => $row['HCPCS-Other4SupChrg'],
                        'LengthNeed' => $row['LengthNeed'], 
                        'ICD9' => $row['ICD9'], 
                        'Q1AmmHg' => $row['Q1AmmHg'], 
                        'Q1Bpercent' => $row['Q1Bpercent'], 
                        'Q1Cdate' => isset($row['Q1Cdate']) ? $row['Q1Cdate'] : '',  
                        'Q2cond' => $row['Q2cond'], 
                        'Q3cond' => $row['Q3cond'], 
                        'Q4portable' => $row['Q4portable'], 
                        'Q5O2LPM' => $row['Q5O2LPM'], 
                        'Q6AmmHg' => $row['Q6AmmHg'], 
                        'Q6Bpercent' => $row['Q6Bpercent'], 
                        'Q6Cdate' => isset($row['Q6Cdate']) ? $row['Q6Cdate']: '',  
                        'Q7CHF' => $row['Q7CHF'], 
                        'Q8Hypert' => $row['Q8Hypert'], 
                        'Q9Herm' => $row['Q9Herm'], 
                        'SignedByName' => $row['SignedByName'], 
                        'SignedByTitle' => $row['SignedByTitle'], 
                         'LastUpdate'=> isset($row['LastUpdate']) ? $row['LastUpdate'] : '', 
                          'Send' => '<b><span style="color: #D94E37;font-size: 15px;">'.$row['Send'].'</span></b>',
                        'SignedByEmployer' => $row['SignedByEmployer']);
                       
            return json_encode($result_arr);
        }
   
    }
}
}

  
 $possible_url = array("PrintRecordData");
 $value = "An error has occurred";
 $cms = new Function1();
if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
    switch ($_GET["action"]) {
               
      
       case "PrintRecordData" :
            if (isset ($_GET["HDRID"]))
              $value = $cms->PrintRecordData($_GET["HDRID"]);
            else
              $value = "Missing argument";
            break;
		
      
    }
}
//return JSON array
echo json_encode($value);

?>