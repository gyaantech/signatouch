<?php

class GetSet
{    
    public $HICN;
    public $NPI;
    public $FName;
    public $MName;
    public $LName;
    public $Address1;
    public $Address2;
    public $City;
    public $State;
    public $PhoneNo;
    public $Zip;
    public $Gender;
    public $PatientName;
    public $CertType;
    public $MedicalID;
    public $CertDate;
    public $StausFLG;
    public $LastUpdateID;  
    public $DOB;  
    public $Search;
    public $HdrID;
    public $DetailID;
    public $LengthNeed;
    public $ICD9;
    public $ICDver;
    public $Q1AmmHg;
    public $Q1Bpercent;
    public $Q1Cdate;
    public $Q2cond;
    public $Q3cond;
    public $Q4portable;
    public $Q5O2LPM;
    public $Q6AmmHg;
    public $Q6Bpercent;
    public $Q6Cdate;
    public $Q7CHF;
    public $Q8Hypert;
    public $Q9Herm;
    public $SignedByName;
    public $SignedByTitle;
    public $SignedByEmployer;
    public $PhysicianNPI;
    public $POS;
    public $FacilityNPI;
    public $ID;
    public $type;
    public $username;
    public $usernamenonst;
    public $password;
    public $op;
    public $domain;
    
    public $emailID;
    public $displayName;
    public $COS;
    public $COS_description;
    public $COS_notes;
    public $company;
    public $jobTitle;
    public $updatePassword;
    public $alias_email_id;
    public $target_account;
    public $alt_email_id;
    public $oldPassword;
    
    public $Domain_Name;
    public $DefaultCOS;
    
    public $npi;
    
     // get Domain_Name
    public function getDefaultCOS()
    {
    return $this->DefaultCOS;
    }
    // set Default COS
    public function setDefaultCOS($DefaultCOS)
    {
    $this->DefaultCOS = $DefaultCOS;
    } 
     // get Domain_Name
    public function getDomainName()
    {
    return $this->Domain_Name;
    }
    // set Domain_Name
    public function setDomainName($Domain_Name)
    {
    $this->Domain_Name = $Domain_Name;
    } 
    // set jobTitle
    public function setjobTitle($jobTitle)
    {
    $this->jobTitle = $jobTitle;
    } 
    // get COS_description
    public function getCOS_description()
    {
    return $this->COS_description;
    }
    // set COS_description
    public function setCOS_description($COS_description)
    {
    $this->COS_description = $COS_description;
    } 
        // get COS_notes
    public function getCOS_notes()
    {
    return $this->COS_notes;
    }
    // set COS_notes
    public function setCOS_notes($COS_notes)
    {
    $this->COS_notes = $COS_notes;
    } 
    // get jobTitle
    public function getjobTitle()
    {
    return $this->jobTitle;
    }
            // set updatePassword
    public function setupdatePassword($updatePassword)
    {
    $this->updatePassword = $updatePassword;
    } 
    // get updatePassword
    public function getupdatePassword()
    {
    return $this->updatePassword;
    }
    // set oldPassword
    public function setoldPassword($oldPassword)
    {
    $this->oldPassword = $oldPassword;
    } 
    // get oldPassword
    public function getoldPassword()
    {
    return $this->oldPassword;
    }
    // set company
    public function setcompany($company)
    {
    $this->company = $company;
    } 
    // get company
    public function getcompany()
    {
    return $this->company;
    }
    // set COS
    public function setCOS($COS)
    {
    $this->COS = $COS;
    } 
    // get COS
    public function getCOS()
    {
    return $this->COS;
    }
           // set displayName
    public function setdisplayName($displayName)
    {
    $this->displayName = $displayName;
    } 
    // get displayName
    public function getdisplayName()
    {
    return $this->displayName;
    }
       // set emailID
    public function setemailID($emailID)
    {
    $this->emailID = $emailID;
    } 
    // get emailID
    public function getemailID()
    {
    return $this->emailID;
    }
   // set PhysicianNPI
    public function setPhysicianNPI($PhysicianNPI)
    {
    $this->PhysicianNPI = $PhysicianNPI;
    } 
    // get PhysicianNPI
    public function getPhysicianNPI()
    {
    return $this->PhysicianNPI;
    }
    
    // set username
    public function setusername($username)
    {
    $this->username = $username.".st";
    // $this->username = $username;
    } 
    // get username
    public function getusername()
    {
    return $this->username;
    }
        // set username without st
    public function setusernamenonst($username)
    {
     $this->username = $username;
    } 
    // get username
    public function getusernamenonst()
    {
    return $this->username;
    }
        // set password
    public function setpassword($password)
    {
    $this->password = $password;
    } 
    // get password
    public function getpassword()
    {
    return $this->password;
    }
    // set op
    public function setop($op)
    {
    $this->op = $op;
    } 
    // get op
    public function getop()
    {
    return $this->op;
    }
    
    // set PhysicianNPI
    public function setFacilityNPI($FacilityNPI)
    {
    $this->FacilityNPI = $FacilityNPI;
    } 
    // get PhysicianNPI
    public function getFacilityNPI()
    {
    return $this->FacilityNPI;
    }
    
     // set ID
    public function setID($ID)
    {
    $this->ID = $ID;
    } 
    // get ID
    public function getID()
    {
    return $this->ID;
    }
    
      // set POS
    public function setPOS($POS)
    {
    $this->POS = $POS;
    } 
    // get POS
    public function getPOS()
    {
    return $this->POS;
    }
    
 // set HdrID
    public function setHdrID($HdrID)
    {
    $this->HdrID = $HdrID;
    } 
    // get HICN
    public function getHdrID()
    {
    return $this->HdrID;
    }

    // set HICN
    public function setHICN($HICN)
    {
    $this->HICN = $HICN;
    } 
    // get HICN
    public function getHICN()
    {
    return $this->HICN;
    }

    // set NPI
    public function setNPI($NPI)
    {
    $this->NPI = $NPI;
    } 
    // get NPI
    public function getNPI()
    {
    return $this->NPI;
    }

    // set user's first name
    public function setFName($FName)
    {
    $this->FName = $FName;
    } 
    // get user's first name
    public function getFName()
    {
    return $this->FName;
    }

    // set user's Middle name
    public function setMName($MName)
    {
    $this->MName = $MName;
    }

    // get user's Middle name
    public function getMName()
    {
    return $this->MName;
    } 

    // set user's last name
    public function setLName($LName)
    {
    $this->LName = $LName;
    }

    // get user's last name
    public function getLName()
    {
    return $this->LName;
    } 

    // set address1
    public function setAddress1($Address1)
    {
    $this->Address1 = $Address1;
    }

    // get address1
    public function getAddress1()
    {
    return $this->Address1;
    }

    // set address2
    public function setAddress2($Address2)
    {
    $this->Address2 = $Address2;
    }

    // get address2
    public function getAddress2()
    {
    return $this->Address2;
    }

    // set City
    public function setCity($City)
    {
    $this->City = $City;
    }

    // get City
    public function getCity()
    {
    return $this->City;
    }

    // set State
    public function setState($State)
    {
    $this->State = $State;
    }
    // get State
    public function getState()
    {
    return $this->State;
    }

    // set PhoneNo
    public function setPhoneNo($PhoneNo)
    {
    $this->PhoneNo = $PhoneNo;
    }
    // get PhoneNo
    public function getPhoneNo()
    {
    return $this->PhoneNo;
    }

    // set Gender
    public function setGender($Gender)
    {
    $this->Gender = $Gender;
    }
     // get Gender
    public function getGender()
    {
    return $this->Gender;
    }

    // set Zip
    public function setZip($Zip)
    {
    $this->Zip = $Zip;
    }
     // get Zip
    public function getZip()
    {
    return $this->Zip;
    }

    // set StausFLG
    public function setStausFLG($StausFLG)
    {
    $this->StausFLG = $StausFLG;
    }
     // get StausFLG
    public function getStausFLG()
    {
    return $this->StausFLG;
    }

    // set MedicalID
    public function setMedicalID($MedicalID)
    {
    $this->MedicalID = $MedicalID;
    }
     // get MedicalID
    public function getMedicalID()
    {
    return $this->MedicalID;
    }

    // set PatientName
    public function setPatientName($PatientName)
    {
    $this->PatientName = $PatientName;
    }
     // get PatientName
    public function getPatientName()
    {
    return $this->PatientName;
    }

    // set CertType
    public function setCertType($CertType)
    {
    $this->CertType = $CertType;
    }
     // get CertType
    public function getCertType()
    {
    return $this->CertType;
    }


    // set CertDate
    public function setCertDate($CertDate)
    {
    $this->CertDate = $CertDate;
    }
     // get CertDate
    public function getCertDate()
    {
    return $this->CertDate;
    }

    // set LastUpdateID
    public function setLastUpdateID($LastUpdateID)
    {
    $this->LastUpdateID = $LastUpdateID;
    }
     // get LastUpdateID
    public function getLastUpdateID()
    {
    return $this->LastUpdateID;
    }

    // set DOB
    public function setDOB($DOB)
    {
    $this->DOB = $DOB;
    }
     // get DOB
    public function getDOB()
    {
    return $this->DOB;
    }

    // set Search
    public function setSearch($Search)
    {
    $this->Search = $Search;
    }
     // get Search
    public function getSearch()
    {
    return $this->Search;
    }
    // set LengthNeed
    public function setDetailID($DetailID)
    {
    $this->DetailID = $DetailID;
    } 
    // get LengthNeed
    public function getDetailID()
    {
    return $this->DetailID;
    }
        // set StatusFLG
    public function setStatusFLG($StatusFLG)
    {
    $this->StatusFLG = $StatusFLG;
    } 
    // get StatusFLG
    public function getStatusFLG()
    {
    return $this->StatusFLG;
    }
    // set LengthNeed
    public function setLengthNeed($LengthNeed)
    {
    $this->LengthNeed = $LengthNeed;
    } 
    // get LengthNeed
    public function getLengthNeed()
    {
    return $this->LengthNeed;
    }
    // set $ICD9
    public function setICD9($ICD9)
    {
    $this->ICD9 = $ICD9;
    } 
    // get $ICD9
    public function getICD9()
    {
    return $this->ICD9;
    }
    // set ICDver
    public function setICDver($ICDver)
    {
    $this->ICDver = $ICDver;
    } 
    // get ICDver
    public function getICDver()
    {
    return $this->ICDver;
    }
    // set $Q1AmmHg
    public function setQ1AmmHg($Q1AmmHg)
    {
    $this->Q1AmmHg = $Q1AmmHg;
    } 
    // get Q1AmmHg
    public function getQ1AmmHg()
    {
    return $this->Q1AmmHg;
    }
    // set Q1Bpercent
    public function setQ1Bpercent($Q1Bpercent)
    {
    $this->Q1Bpercent = $Q1Bpercent;
    } 
    // get Q1Bpercent
    public function getQ1Bpercent()
    {
    return $this->Q1Bpercent;
    }
    // set Q1Cdate
    public function setQ1Cdate($Q1Cdate)
    {
    $this->Q1Cdate = $Q1Cdate;
    } 
    // get Q1Cdate
    public function getQ1Cdate()
    {
    return $this->Q1Cdate;
    }
    // set Q2cond
    public function setQ2cond($Q2cond)
    {
    $this->Q2cond = $Q2cond;
    } 
    // get Q2cond
    public function getQ2cond()
    {
    return $this->Q2cond;
    }
    // set Q3cond
    public function setQ3cond($Q3cond)
    {
    $this->Q3cond = $Q3cond;
    } 
    // get Q3cond
    public function getQ3cond()
    {
    return $this->Q3cond;
    }
    // set Q4portable
    public function setQ4portable($Q4portable)
    {
    $this->Q4portable = $Q4portable;
    } 
    // get Q4portable
    public function getQ4portable()
    {
    return $this->Q4portable;
    }
    // set Q5O2LPM
    public function setQ5O2LPM($Q5O2LPM)
    {
    $this->Q5O2LPM = $Q5O2LPM;
    } 
    // get Q5O2LPM
    public function getQ5O2LPM()
    {
    return $this->Q5O2LPM;
    }
    // set Q6AmmHg
    public function setQ6AmmHg($Q6AmmHg)
    {
    $this->Q6AmmHg = $Q6AmmHg;
    } 
    // get Q6AmmHg
    public function getQ6AmmHg()
    {
    return $this->Q6AmmHg;
    }
    // set Q6Bpercent
    public function setQ6Bpercent($Q6Bpercent)
    {
    $this->Q6Bpercent = $Q6Bpercent;
    } 
    // get Q6Bpercent
    public function getQ6Bpercent()
    {
    return $this->Q6Bpercent;
    }
    // set Q6Cdate
    public function setQ6Cdate($Q6Cdate)
    {
    $this->Q6Cdate = $Q6Cdate;
    } 
    // get Q6Cdate
    public function getQ6Cdate()
    {
    return $this->Q6Cdate;
    }
    // set Q7CHF
    public function setQ7CHF($Q7CHF)
    {
    $this->Q7CHF = $Q7CHF;
    } 
    // get Q7CHF
    public function getQ7CHF()
    {
    return $this->Q7CHF;
    }
    // set Q8Hypert
    public function setQ8Hypert($Q8Hypert)
    {
    $this->Q8Hypert = $Q8Hypert;
    } 
    // get Q8Hypert
    public function getQ8Hypert()
    {
    return $this->Q8Hypert;
    }
    // set Q9Herm
    public function setQ9Herm($Q9Herm)
    {
    $this->Q9Herm = $Q9Herm;
    } 
    // get Q9Herm
    public function getQ9Herm()
    {
    return $this->Q9Herm;
    }
    // set SignedByName
    public function setSignedByName($SignedByName)
    {
    $this->SignedByName = $SignedByName;
    } 
    // get SignedByName
    public function getSignedByName()
    {
    return $this->SignedByName;
    }
    // set SignedByTitle
    public function setSignedByTitle($SignedByTitle)
    {
    $this->SignedByTitle = $SignedByTitle;
    } 
    // get SignedByTitle
    public function getSignedByTitle()
    {
    return $this->SignedByTitle;
    }
    // set SignedByEmployer
    public function setSignedByEmployer($SignedByEmployer)
    {
    $this->SignedByEmployer = $SignedByEmployer;
    } 
    // get SignedByEmployer
    public function getSignedByEmployer()
    {
    return $this->SignedByEmployer;
    }
    
     // set Date
    public function setDate($Date)
    {
    $this->Date = $Date;
    } 
    // get Date
    public function getDate()
    {
    return $this->Date;
    }
    
     // set Date1
    public function setDate1($Date1)
    {
    $this->Date1 = $Date1;
    } 
    // get Date1
    public function getDate1()
    {
    return $this->Date1;
    }
	
	  // set type
    public function settype($type)
    {
    $this->type = $type;
    } 
    // get type
    public function gettype()
    {
    return $this->type;
    }
   // set SrcDomain
    public function setSrcDomain($SrcDomain)
    {
    $this->SrcDomain = $SrcDomain;
    } 
    // get SrcDomain
    public function getSrcDomain()
    {
    return $this->SrcDomain;
    }
    // set Domain
    public function setdomain($username)
    {
    $this->domain = substr(strrchr($username, "@"), 1);
    } 
    // get Domain
    public function getdomain()
    {
    return $this->domain;
    }
    // set npi from username
    public function set_npi($username)
    {
    $this->npi = explode("@",$username);
    } 
    // get npi from username
    public function get_npi()
    {
    return $this->npi[0];
    }
    public function setAliasEmailId($email_id){
      $this->alias_email_id = $email_id;
    }
    public function getAliasEmailId(){
      return $this->alias_email_id;
    }
    public function setTargetAccount($target_account){
      $this->target_account = $target_account;
    }
    public function getTargetAccount(){
      return $this->target_account;
    }
     public function setAltemailID($email_id){
      $this->alt_email_id = $email_id;
    }
    public function getAltemailID(){
      return $this->alt_email_id;
    }
	}
?>