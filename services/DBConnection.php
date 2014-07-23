<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'dummy');
	// Create connection
class DB_Class 
{
    function __construct() 
    {
        $con = @mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('error');
               // or die('Oops connection error -> ' . mysql_error());
        mysql_select_db(DB_DATABASE, $con) 
        or die('error');
    }
}
?>
