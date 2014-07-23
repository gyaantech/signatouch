<?php
include "DBConnection.php";
class User {
    public function __construct() 
    {
        $db = new DB_Class();
          // $this = new Getset();
    }
            // Login process
    public function check_login($emailusername, $password) 
    {
        $SqlCheck = "SELECT * FROM login WHERE Name = '$emailusername' AND Password = '$password'";
        $result = mysql_query($SqlCheck);
        $user_data = mysql_fetch_array($result);
        //print_r($user_data);
        $no_rows = mysql_num_rows($result);
        if ($no_rows == 1) 
        {
            if($emailusername == 'a' && $password== 'a'){
                $_SESSION['login'] = 'usera';
            }
            if($emailusername == 'b' && $password== 'b'){
                $_SESSION['login'] = 'userb';
            }
            
            $_SESSION['uid'] = $user_data['Userid'];
            $_SESSION['username'] = $user_data['Name'];
            $array = array('status'=>$_SESSION['login'],'uid'=>$_SESSION['uid'],'username'=>$_SESSION['username']);
            return $array;
            
        }
        else
        {
            return FALSE;
        }
    }
}

$possible_url = array("check_login");
 $value = "An error has occurred";
 $user = new User();
if (isset ($_GET["action"]) && in_array($_GET["action"], $possible_url)) {
    switch ($_GET["action"]) {
        case "check_login" :
            if (isset ($_POST["txtUsername"]) && isset($_POST['txtPassword'])){
                $value = $user->check_login($_POST["txtUsername"],$_POST["txtPassword"]);
            }
            break;
    }
}
//return JSON array
echo json_encode($value);

/*$username = $_POST['txtUsername'];
$password = $_POST['txtPassword'];
if($username == 'a' && $password == 'a'){
    session_start();
    $_SESSION['logina'] = 'sectiona';
    echo $_SESSION['logina'];
}
elseif($username == 'b' && $password == 'b') {
    session_start();
    $_SESSION['loginb'] = 'sectionb';
    echo $_SESSION['loginb'];
}
else{
    echo 'false';
}*/
?>