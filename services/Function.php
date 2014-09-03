<?php
// Ver 3
// Wed Jun 23 2014
// -------------------------------------
// Common Function for View Data - Section A & Section B
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
  

 
/*Function to fetch all details of a record and bind to view page*/
    public function ViewRecordData($HdrID = ''){
   $HdrID = isset($_GET['HDRID']) ? trim($_GET['HDRID']) : '';
   $status = isset($_GET['flag']) ? trim($_GET['flag']) : '';
    
   
    switch($status){
     case 'A':
        $sql = "Select * from ViewRecordStatusA where HdrID = '$HdrID'";
       break;
     
     default:
        $sql = "Select * from viewallrecord where HdrID = '$HdrID'";
       
   }
       
         $result = mysql_query($sql);
            if($result)
                {
               $row_count = mysql_num_rows($result);
                if($row_count == 1)
                    {
                    $row = mysql_fetch_array($result, MYSQL_ASSOC);
                    if(isset($row['HCPCS-E0431SupChrg']) || isset($row['HCPCS-E0431MedFee'])){
                      if($row['HCPCS-E0431SupChrg']=='0.00' || $row['HCPCS-E0431MedFee']=='0.00' )
                      {
                       $row['HCPCS-E0431SupChrg'] = '';
                       $row['HCPCS-E0431MedFee'] = '';
                      }
                      else
                      {
                       $row['HCPCS-E0431SupChrg'] =  $row['HCPCS-E0431SupChrg'];
                       $row['HCPCS_E0431MedFee'] =  $row['HCPCS-E0431MedFee'];
                      }
                    }
                     if(isset($row['HCPCS-E1390SupChrg']) || isset($row['HCPCS-E1390MedFee'])){
                        if($row['HCPCS-E1390SupChrg']=='0.00' || $row['HCPCS-E1390MedFee']=='0.00' )
                        {
                         $row['HCPCS-E1390SupChrg'] = '';
                         $row['HCPCS-E1390MedFee'] = '';
                        }
                        else
                        {
                         $row['HCPCS-E1390SupChrg'] =  $row['HCPCS-E1390SupChrg'];
                         $row['HCPCS-E1390MedFee'] =  $row['HCPCS-E1390MedFee'];
                        }
                     }
                      if(isset($row['HCPCS-E1392MedFee']) || isset($row['HCPCS-E1392SupChrg'])){
                        if($row['HCPCS-E1392MedFee']=='0.00' || $row['HCPCS-E1392SupChrg']=='0.00' )
                        {
                         $row['HCPCS-E1392MedFee'] = '';
                         $row['HCPCS-E1392SupChrg'] = '';
                        }
                        else
                        {
                         $row['HCPCS-E1392MedFee'] =  $row['HCPCS-E1392MedFee'];
                         $row['HCPCS-E1392SupChrg'] =  $row['HCPCS-E1392SupChrg'];
                        }
                      }
                       if(isset($row['HCPCS-K0738MedFee']) || isset($row['HCPCS-K0738SupChrg'])){

                          if($row['HCPCS-K0738MedFee']=='0.00' || $row['HCPCS-K0738SupChrg']=='0.00' )
                          {
                           $row['HCPCS-K0738MedFee'] = '';
                           $row['HCPCS-K0738SupChrg'] = '';
                          }
                          else
                          {
                           $row['HCPCS-K0738MedFee'] =  $row['HCPCS-K0738MedFee'];
                           $row['HCPCS-K0738SupChrg'] =  $row['HCPCS-K0738SupChrg'];
                          }
                       }
                        if(isset($row['HCPCS-Other1MedFee']) || isset($row['HCPCS-Other1SupChrg'])){
                            if($row['HCPCS-Other1MedFee']=='0.00' || $row['HCPCS-Other1SupChrg']=='0.00' )
                            {
                             $row['HCPCS-Other1MedFee'] = '';
                             $row['HCPCS-Other1SupChrg']='';
                            }
                            else
                            {
                             $row['HCPCS-Other1MedFee'] =  $row['HCPCS-Other1MedFee'];
                             $row['HCPCS-Other1SupChrg'] = $row['HCPCS-Other1SupChrg'];
                            }
                        }
                         if(isset($row['HCPCS-Other2MedFee']) || isset($row['HCPCS-Other2SupChrg'])){
                            if($row['HCPCS-Other2MedFee']=='0.00' || $row['HCPCS-Other2SupChrg']=='0.00' )
                            {
                             $row['HCPCS-Other2MedFee'] = '';
                             $row['HCPCS-Other1SupChrg']='';
                            }
                            else
                            {
                             $row['HCPCS-Other2MedFee'] =  $row['HCPCS-Other2MedFee'];
                             $row['HCPCS-Other2SupChrg'] = $row['HCPCS-Other2SupChrg'];
                            }
                         }
                          if(isset($row['HCPCS-Other3MedFee']) || isset($row['HCPCS-Other3SupChrg'])){
                            if($row['HCPCS-Other3MedFee']=='0.00' || $row['HCPCS-Other3SupChrg']=='0.00' )
                            {
                             $row['HCPCS-Other3MedFee'] = '';
                             $row['HCPCS-Other3SupChrg']='';
                            }
                            else
                            {
                             $row['HCPCS-Other3MedFee'] =  $row['HCPCS-Other3MedFee'];
                             $row['HCPCS-Other3SupChrg'] = $row['HCPCS-Other3SupChrg'];
                            }
                          }
                           if(isset($row['HCPCS-Other4MedFee']) || isset($row['HCPCS-Other4SupChrg'])){
                              if($row['HCPCS-Other4MedFee']=='0.00' || $row['HCPCS-Other4SupChrg']=='0.00' )
                              {
                               $row['HCPCS-Other4MedFee'] = '';
                               $row['HCPCS-Other4SupChrg']='';
                              }
                              else
                              {
                               $row['HCPCS-Other4MedFee'] =  $row['HCPCS-Other4MedFee'];
                               $row['HCPCS-Other4SupChrg'] = $row['HCPCS-Other4SupChrg'];
                              }
                           }
                           // build common array
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
								  'PhysicianAltEmailId' => $row['PhysicianAltEmailId'],
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
                                  'HCPCS_Other4SupChrg' => $row['HCPCS-Other4SupChrg']
                             );
                        switch($status){
                                case 'A':
                                  
                                break;
                       default:
                          if(isset($row['ICDa'])){
                              if($row['ICDa']=='0')
                              {
                               $row['ICDa'] = '';
                              }
                              else
                              {
                                $row['ICDa'] = $row['ICDa'];
                              }
                           }
                           if(isset($row['ICDb'])){
                              if($row['ICDb']=='0')
                              {
                               $row['ICDb'] = '';
                              }
                              else
                              {
                                $row['ICDb'] = $row['ICDb'];
                              }
                           }
                            if(isset($row['Q6AmmHg'])){
                              if($row['Q6AmmHg']=='0')
                              {
                               $row['Q6AmmHg'] = '';
                              }
                              else
                              {
                                $row['Q6AmmHg'] = $row['Q6AmmHg'];
                              }
                           }
                           if(isset($row['Q6Bpercent'])){
                              if($row['Q6Bpercent']=='0')
                              {
                               $row['Q6Bpercent'] = '';
                              }
                              else
                              {
                                $row['Q6Bpercent'] = $row['Q6Bpercent'];
                              }
                           }
                        $result_arr2 = array(
                        'LengthNeed' => $row['LengthNeed'], 
                        'ICDver' => '<b>ICD Version: </b>'.$row['ICDver'],
                        'ICDa' => $row['ICDa'],
                        'ICDb' => $row['ICDb'],
                        'ICDc' => $row['ICDc'],
                        'ICDd' => $row['ICDd'],
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
                        $result_arr = array_merge($result_arr, $result_arr2); // merge common array and new array
                               }

                       
            return json_encode($result_arr);
        }
   
    }
}


/*function to changes status of record*/
 public function ChangeRecordStatus($form='',$HdrID = ''){
   
    $HdrID = $_GET['hdrid'];
    $form = $_GET['form'];
    switch ($form) {
        case "Review" :
          $sql = "update cms484hdr set StausFLG='B' where StausFLG='A' and HdrID='$HdrID'"; 
          $sql1 = "update cms484det set StatusFLG='B' where  StatusFLG='A' and DetailID='$HdrID'"; 
        break;
        case "DrOffice" :
          $sql = "update cms484hdr set StausFLG='S' where StausFLG='B' and HdrID='$HdrID' "; 
         $sql1 = "update cms484det set StatusFLG='S' where StatusFLG='B' and DetailID='$HdrID'"; 
        break;
     }
                  
     $result = mysql_query($sql);
     $result1 = mysql_query($sql1);
    if (!$result || !$result1) {
        die('Invalid query: ' . $sql . "   " . mysql_error());
     }
    return TRUE;
  } 
 
  /*function to logout and clear session*/
 public function logout(){
   session_start();
    if(isset($_SESSION['password'])){
      unset($_SESSION['password']);
    }
    if(isset($_SESSION['username'])){
      unset($_SESSION['username']);
    }
      // unset routetype in session variable
    if(isset($_COOKIE['route_type'])){
      setcookie("route_type", "", time());
    }
    if(isset($_COOKIE['user_domain'])){
      setcookie("user_domain", "", time());
    }
    if(isset($_COOKIE['user_npi'])){
      setcookie("user_npi", "", time());
    }
     if(isset($_COOKIE['user_cos'])){
      setcookie("user_cos", "", time());
    }
    session_destroy();
    return TRUE;
  } 
 } 
  
 $possible_url = array("ViewRecordData","ChangeRecordStatus","logout");
 $value = "An error has occurred";
 $cms = new Function1();
if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
    switch ($_GET["action"]) {
               
      
       case "ViewRecordData" :
            if (isset ($_GET["HDRID"]))
              $value = $cms->ViewRecordData($_GET["HDRID"]);
            else
              $value = "Missing argument";
            break;
			
      case "ChangeRecordStatus" :
            if (isset ($_GET["hdrid"]) && isset($_GET["form"])){
                $value = $cms->ChangeRecordStatus($_GET["hdrid"],$_GET["form"]);
            }
            else
                $value = "Missing argument";
            break;
      case "logout" :
                $value = $cms->logout();
            break;
      
    }
}
//return JSON array
echo json_encode($value);

?>