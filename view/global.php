<?PHP
ini_set('display_errors','0');
ini_set('log_errors','0');
session_name("equipment");
session_start();
$CurrentRequestURLarr = explode("/",$_SERVER['REQUEST_URI']);


// Includes
//include_once($_SERVER['HTTP_HOST']."/equipment/protect/layout.php");
//include_once($_SERVER['HTTP_HOST']."/equipment/protect/functions.php");
//include($_SERVER['HTTP_HOST']."/".strtolower($_SESSION["SystemNameStr"])."/protect/layout.php");
//include($_SERVER['HTTP_HOST']."/".strtolower($_SESSION["SystemNameStr"])."/protect/functions.php");

// NAME OF THE LOAN SYSTEM (THIS WEEK)
$_SESSION["SystemNameStr"]='EQUIPMENT';

// Get MySQL Details
//include_once($_SERVER['HTTP_HOST']."/".strtolower($_SESSION["SystemNameStr"])."/protect/config.php");
/*
// MySQL
$mysqlserver = $mysql_server;
$mysqluser = text_unprotect($mysql_user); // user with read and write access
$mysqlpw = text_unprotect($mysql_password);
$mysqldb = $mysql_db;

$mysqldbCheck = @fsockopen($mysqlserver, 3306, $errno, $errstr, 1);   //Check to See If MYSQL DB is UP.
	if ($mysqldbCheck) 
		{	// YES MYSQL DB is present.
		$dbok = mysql_connect($mysqlserver, $mysqluser, $mysqlpw);
		if ($dbok) @mysql_select_db($mysqldb,$dbok);		
		}
	else
		{	// NO MYSQL DB is NOT present.
		print 'Database server is down - access to this site will be severely restricted<BR>'; 
		}
		*/
$dbok = mysql_connect('localhost', 'root', 'root');
$db_selected = mysql_select_db('equipment', $dbok);
?>