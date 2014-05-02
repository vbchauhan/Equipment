<?PHP
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
if (@$_SESSION["AUTH_USER"]==true){
top(); 
?>
<H1><strong>Public</strong></H1>
<BR>
<div align="center">
<table width="350" border="0">
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form1" METHOD="post" ACTION="view_requests.php">
				<INPUT TYPE="hidden" NAME="action" VALUE="list">
				<INPUT TYPE="hidden" NAME="Submit" VALUE="Submit">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="View iPad Requests">
				</FORM>
                Check All the requests for the iPad .<BR><BR>       
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form2" METHOD="post" ACTION="reserved.php">	
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="Check Current Reservations">
				</FORM> 
                Check all the current reservations in the system<BR><BR>
            </td>
		</tr>
</table>
</div>
<?PHP 
bottom(); 
} //End of the IF statement
else
	{ // if person is not allowed to access page throw up a 404 error
	top();
	echo "<h1>You have to log in to view this page</h1>	";
	header("HTTP/1.0 404 Not Found");
	exit;
	}
?>