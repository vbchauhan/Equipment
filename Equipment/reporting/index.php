<?php 
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
top(); 
?>
<H1><strong>SYSTEM REPORTS AND STAFF LISTS</strong></H1>
<BR>
<div align="center">
<table width="300" border="0">
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form1" METHOD="post" ACTION="liststaff.php" target="_blank">
	   	    &nbsp;<INPUT TYPE="submit" NAME="submit" VALUE="Printable list of all staff">
				</FORM>
				Creates a list of all staff with a barcode for quick scanning of staff that forget thier ID cards.<BR><BR>       
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form2" METHOD="post" ACTION="lookupitem.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="submit" VALUE="Lookup ITEM Loan History">
				</FORM> 
                Look up the loan history of a ITEM within the loan system.<BR><BR>
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="lookupuser.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="submit" VALUE="Lookup USER Loan History">
				</FORM>
              	Look up the loan history of a USER within the loan system.<BR><BR>
            </td>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form2" METHOD="post" ACTION="lookuplogins.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="submit" VALUE="View staff web LOGIN History">
				</FORM> 
                View the web login history of the <?php echo strtoupper(strtolower($_SESSION["SystemNameStr"]))?> system.<BR><BR>
            </td>
		</tr>
		<!-- Ambarish Added code-->
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form2" METHOD="post" ACTION="lookuptransactions.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="submit" VALUE="View All Loans History">
				</FORM> 
                View ALL loans history of the <?php echo strtoupper(strtolower($_SESSION["SystemNameStr"]))?> system.<BR><BR>
            </td>
		</tr>
		<!-- Ambarish Added code Ends-->
</table>
</div>
<?php  
bottom(); 
?>