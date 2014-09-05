<?php
// Ver 3
// Wed Jun 23 2014
// -------------------------------------
// Section A
// =====================================

include "DBConnection.php";
include "GetSet.php";
include "ZimbraConnect.php";
class SectionA
{
    //Database connect 
    public function __construct() 
    {
        $db = new DB_Class();
    }
     
/*----------------------------------------Section A record -------------------------------------------------------------*/
  
    /*Section A record selector*/
     public function get_SectionA1GridBindFromNPI ($npi='') {
       $npi=  isset($_GET['NPI']) ? $_GET['NPI'] : '';
        $sql = "Select SQL_CALC_FOUND_ROWS CONCAT (if(patient.PatientFname is null,'',patient.PatientFname),' ',if(patient.PatientMidName is null,'',patient.PatientMidName),' ',if(patient.PatientLname is null,'',patient.PatientLname)) as PatientName, patient.PatientHICN as HICN,cms484hdr.PhysicianAlias, cms484hdr.CertType as CertType,case when CertType='I' then DATE_FORMAT(InitialCertDate, '%m-%d-%Y') when CertType='V' then DATE_FORMAT(RevisedCertDate, '%m-%d-%Y') Else DATE_FORMAT(RecertificationDate, '%m-%d-%Y') End as CertDate, cms484hdr.MedicalID,cms484hdr.StausFLG, case when cms484hdr.StausFLG='A' then 'Edit' Else 'View' End as link, cms484hdr.HdrID as HdrID,patient.PatientLname ,case when (cms484hdr.MedicalID is not null and cms484hdr.PhysicianNPI is not null and cms484hdr.SupplierNPI and cms484hdr.PlaceService ) then 'Allow' Else 'Dis' End as Send from cms484hdr inner join patient on patient.PatientHICN = cms484hdr.PatientHICN and PhysicianNPI='$npi' order By cms484hdr.LastUpdate DESC";
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
             
 } 
  
 $possible_url = array("get_SectionA1GridBindFromNPI");
 $value = "An error has occurred";
 $cms = new SectionA();
if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
    switch ($_GET["action"]) {
        case "get_SectionA1GridBindFromNPI" :
            $value = $cms->get_SectionA1GridBindFromNPI();
            break;
    }
}
//return JSON array
echo json_encode($value);

?>