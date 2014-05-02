<?PHP
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
// Get variables
$action=@$_POST["action"]; // Check if a POST action is present.

if ($action)
	{
	$fuid=@$_POST["fuid"];						// LoginID
	$fpw=@$_POST["fpw"];						// Login pw
	$lgroup=@$_POST["lgroup"];					// Loan Group	
	}
else
	{
	$action=@$_GET["action"];					// action (add,edit,delete)
	$fuid=@$_GET["fuid"];						// LoginID
	$fpw=@$_GET["fpw"];							// Login pw
	$lgroup=@$_GET["lgroup"];					// Loan Group
	}

// Check submitted password
if ($action=='submitpw')
	{
	$CheckQuery = "select loginid,pw,logindisabled,firstname,lastname,email,accesslevel FROM people WHERE loginid='".strtolower($fuid)."'";
	$CheckResult = @mysql_query($CheckQuery);
	$CheckNum = mysql_num_rows($CheckResult);
	If ($CheckNum>=1)
		{
		$CheckRow = @mysql_fetch_array($CheckResult);
		// Make sure this person can log in.
		if ($CheckRow["logindisabled"]==false)
			{
			if (pwHash($fpw)==$CheckRow["pw"])
				{
				$_SESSION["AUTH_USER"]=true;
				$_SESSION["AUTH_USER_LOGINID"]=$CheckRow["loginid"];
				$_SESSION["AUTH_USER_EMAIL"]=$CheckRow["email"];
				$_SESSION["AUTH_USER_NAME"]=$CheckRow["firstname"].' '.$CheckRow["lastname"];
				$_SESSION["AUTH_USER_TYPE"]=$CheckRow["accesslevel"];

				$querylog="INSERT INTO loginlogs SET 
								userid='".$CheckRow["loginid"]."',
								username='".$CheckRow["firstname"].' '.$CheckRow["lastname"]."',
								userip='".$_SERVER["REMOTE_ADDR"]."',
								userdns='".@gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
								action='login',
								result='OK',
								resultnumber=202,							
								notes='Access:".$CheckRow["accesslevel"]."',
								tsnumber =".time(date('Y-m-d H:i')).",
								ts = '".date('Y-m-d H:i')."'";
				$resultlog = @MYSQL_QUERY($querylog);

				// Reset Bad Login Count			
				$BadLoginUpdateQuery="UPDATE people SET badlogincount=0 WHERE (loginid='".$CheckRow["loginid"]."')";
				$BadLoginUpdateQueryResult = @mysql_query($BadLoginUpdateQuery);
				
				//If loan group present then set session variable
				if (strlen($lgroup)>=1) 
					$_SESSION["LOANSYSTEM_GROUP"]=$lgroup;
				
				Header("Location: /".strtolower($_SESSION["SystemNameStr"])."/");
				exit;
				}
			else
				{
				$message = 'Invalid loginid or password!';
				
				$BadLoginQuery="SELECT badlogincount FROM people WHERE (loginid='".$CheckRow["loginid"]."')";
				$BadLoginQueryResult = @mysql_query($BadLoginQuery);
				$BadLoginQueryRow = @mysql_fetch_array($BadLoginQueryResult);
				
				if (strtolower($CheckRow["loginid"])<>'supervisor')
					{
					// Too many bad logins, disable the account
					if ($BadLoginQueryRow["badlogincount"]>=7) // Wait till 8 logins before Disabling user
						$LoginDisableUserStr="logindisabled='1',";
					}
				
				$BadLoginUpdateQuery="UPDATE people SET 
										badlogincount=".($BadLoginQueryRow["badlogincount"]+1).",
										".@$LoginDisableUserStr."
										lastbadlogincountdatetime='".date('Y-m-d H:i')."',
										lastbadlogincountdatetimenumber=".time(date('Y-m-d H:i'))." 
										WHERE
											(loginid='".$CheckRow["loginid"]."')";
				$BadLoginUpdateQueryResult = @mysql_query($BadLoginUpdateQuery);						
				
								
				$querylog="INSERT INTO loginlogs SET 
								userid='".$CheckRow["loginid"]."',
								username='".$CheckRow["firstname"].' '.$CheckRow["lastname"]."',
								userip='".$_SERVER["REMOTE_ADDR"]."',
								userdns='".@gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
								action='login',
								result='FAILED',
								resultnumber=401,
								notes='Invalid Password!',
 								tsnumber =".time(date('Y-m-d H:i')).",
								ts = '".date('Y-m-d H:i')."'";
				$resultlog = @mysql_query($querylog);				
				}

			} // END if ($CheckRow["logindisabled"]==false)
		else
			{
			$message = 'LoginID "'.$CheckRow["loginid"].'" is a disabled account!';
			$querylog="INSERT INTO loginlogs SET 
							userid='".$CheckRow["loginid"]."',
							username='".$CheckRow["firstname"].' '.$CheckRow["lastname"]."',
							userip='".$_SERVER["REMOTE_ADDR"]."',
							userdns='".@gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
							action='login',
							result='FAILED',
							resultnumber=409,
							notes='Login Disabled!',
							tsnumber =".time(date('Y-m-d H:i')).",
							ts = '".date('Y-m-d H:i')."'";
			$resultlog = @MYSQL_QUERY($querylog);		
			
			} //END ELSE if ($CheckRow["logindisabled"]==false)
		} //END If ($CheckNum>=1)
	else
		{
		$message = 'Invalid loginid or password!';
		$querylog="INSERT INTO loginlogs SET 
						userid='".strtolower($fuid)."',
						username='',
						userip='".$_SERVER["REMOTE_ADDR"]."',
						userdns='".@gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
						action='login',
						result='FAILED',
						resultnumber=400,
						notes='Invalid Login Account!',
						tsnumber =".time(date('Y-m-d H:i')).",
						ts = '".date('Y-m-d H:i')."'";
		$resultlog = @MYSQL_QUERY($querylog);		
		} //END ELSE If ($CheckNum>=1)
	} // END if ($action=='submitpw')


top();

?>
<BR><H1 align="left">SYSTEM LOGIN PAGE</H1><BR>
<BR>
<div align="center">
<form name="form1" method="post" action="index.php">
<INPUT TYPE="hidden" NAME="action" VALUE="submitpw">
<?PHP	if (@$message) 
			print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
		else
			print '<BR>';
		?>
<table width="200" border="0" style="border:#000000 2px solid; width:375px;">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="30">LoginID:</td>
    <td width="160" align="left"><input type="text" name="fuid" size="15" /></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Password:</td>
    <td align="left"><input type="password" name="fpw" size="35" /></td>
    <td>&nbsp;</td>    
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="submit" value="Submit" style="text-align:center;" /></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
</form>
<? focus('form1','fuid'); ?>
</DIV>
<BR>
<?PHP 

bottom();
?>