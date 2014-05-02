<?PHP
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
top(); 
?>
<H1><strong>SYSTEM ADMIN PAGE</strong></H1>
<BR>
<div align="center">
<table width="350" border="0">
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form1" METHOD="post" ACTION="people.php">
				<INPUT TYPE="hidden" NAME="action" VALUE="list">
				<INPUT TYPE="hidden" NAME="Submit" VALUE="Submit">
				<INPUT TYPE="hidden" NAME="sortorder" VALUE="fname">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="MANAGE STAFF LOGIN ACCOUNTS">
				</FORM>
                This manages the user accounts used to login to the Asset Loan System.<BR><BR>       
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form2" METHOD="post" ACTION="loanitems.php">
				<INPUT TYPE="hidden" NAME="action" VALUE="selectloangroup">
				<INPUT TYPE="hidden" NAME="Submit" VALUE="Submit">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="MANAGE SYSTEM ITEMS">
				</FORM> 
                This Manages the items within the system.<BR><BR>
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="loangroups.php">
				<INPUT TYPE="hidden" NAME="action" VALUE="list">
				<INPUT TYPE="hidden" NAME="Submit" VALUE="Submit">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="MANAGE ITEM GROUPS">
				</FORM>
              	This Manages the Item groups that are available to be used.<BR><BR>
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="namecache.php">
				<INPUT TYPE="hidden" NAME="action" VALUE="list">
				<INPUT TYPE="hidden" NAME="Submit" VALUE="Submit">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="MANAGE NAME CACHE">
				</FORM>
              	This Name Cache of people who are not registered users of the loan system but have been loaned an item.<BR><BR>
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="/equipment/reporting/index.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="SYSTEM REPORTS AND STAFF LISTS">
				</FORM>
              	This section contains report for things like "who used an item", "what items does somone use" and staff lists.<BR><BR>
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="/equipment/reporting/enterHistory.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="Enter Previous Records">
				</FORM>
              	This section will let user to enter the history records to the Logs<BR><BR>
            </td>
		</tr>
</table>
</div>
<?PHP 
bottom(); 
?>