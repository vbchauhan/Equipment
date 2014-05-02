<?PHP
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
	
// Write login status to loginlogs
$querylog="INSERT INTO loginlogs SET 
					userid='".$_SESSION["AUTH_USER_LOGINID"]."',
					username='".$_SESSION["AUTH_USER_NAME"]."',
					userip='".$_SERVER["REMOTE_ADDR"]."',
					userdns='".@gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
					action='logout',
					result='OK',
					resultnumber=203,	
					notes='Access:".$_SESSION["AUTH_USER_TYPE"].", Loan Group:".$_SESSION["LOANSYSTEM_GROUP"]."',
					tsnumber =".time(date('Y-m-d H:i')).",					
					ts = '".date('Y-m-d H:i')."'";
$resultlog = @MYSQL_QUERY($querylog);
				
//Clear user AUTH session variables
$_SESSION["AUTH_USER"]=false;
$_SESSION["AUTH_USER_LOGINID"]='';
$_SESSION["AUTH_USER_EMAIL"]='';
$_SESSION["AUTH_USER_NAME"]='';
$_SESSION["AUTH_USER_TYPE"]='';
	
$_SESSION["LOANSYSTEM_GROUP"]='';

session_unset();
session_destroy();
$RedirStr="Location: /equipment/";
Header($RedirStr);
exit;
?>