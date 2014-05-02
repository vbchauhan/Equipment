<?php 
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
top();
?>
<head>
<link href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
<script>
function validateForm()
{
var a=document.forms["registration"]["fname"].value;
var b=document.forms["registration"]["lname"].value;
var c=document.forms["registration"]["barcode"].value;
var d=document.forms["registration"]["email"].value;
var e=document.forms["registration"]["pno"].value;
var f=document.forms["registration"]["institution"].value;


if (a==null || a=="" || b==null || b=="" || c==null || c=="" || d==null || d=="")
  {
  alert("None of the text boxes can be empty");
  return false;
  }
/*A function call to ValidateSelect and checking if the function returns in false.*/
  if(validateSelect()==false)
  {return false;}
/*A function Call to FileCheck and checking if user wants to continue without selecting a upload*/  
  if(filecheck()==false)
  {return false;}
}

</script>
</head>
<?php 
//this is the block "before" submit
if(isset($_POST["submit"]))
	{
		if(isset($_POST["fname"])){
			$fname=$_POST["fname"];}else{echo "first name is not Set <br />";}
		if(isset($_POST["lname"])){
			$lname=$_POST["lname"];}else{echo "last name is not Set <br />";}
		if(isset($_POST["barcode"])){
			$barcode=$_POST["barcode"];}else{echo "barcode is not Set <br />";}
		if(isset($_POST["email"])){
			$email=$_POST["email"];}else{echo "Email is not Set <br />";}
		if(isset($_POST["pno"])){
			$pno=$_POST["pno"];}else{echo "pno is not Set <br />";}	
		if(isset($_POST["institution"])){
			$institution=$_POST["institution"];}else{echo "institution is not Set <br />";}
		if(isset($_POST["loan_date"])){
			$loan_date=$_POST["loan_date"];}else{echo "Loan Date is not Set <br />";}
		if(isset($_POST["loan_date"])){
			$return_date=$_POST["return_date"];}else{echo "Return Date is not Set <br />";}
	
	$vdaysonloan=dateDiff($loan_date,$return_date);
	// Write Transaction Record to loansystemlog.
	$checkoutlog="INSERT INTO loansystemlogs SET 
				actiondatetime = '".date('Y-m-d H:i')."',
				action = 'checkoutitem',
				loangroup = '".@$_SESSION["LOANSYSTEM_GROUP"]."',
				loanitemshorttitle = 'Ipad history',
				loanitembarcode = '".$barcode."',
				loantoname = '".$fname."".$lname."',
				loantoinstitution='".$institution."',
				loantologinid = '".@$_POST["vsid"]."',
				loantoemail = '".$email."',
				loantophone = '".@$pno."',
				itemloandatestart = '".$loan_date."',
				daysitemwasonloan = '".$vdaysonloan."',
				itemreturnstatus = 'Manual',
				adminname = '".ucwords(strtolower(@$_SESSION["AUTH_USER_NAME"]))."',
				adminloginid = '".strtoupper(@$_SESSION["AUTH_USER_LOGINID"])."',
				adminip = '".$_SERVER["REMOTE_ADDR"]."',
				admindns = '".@gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
				notes = 'Manual Entry'";
				//echo $checkoutlog;
	$resultlog = @mysql_query($checkoutlog);
	echo "The record was entered in the datbase as a manual entry. Please click Continue to add more records or exit to return to the loan system";
	
	?>
	<div align="center">
	<table>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="/lendit/reporting/enterHistory.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Continue" VALUE="Enter Previous Records">
				</FORM>
              	Click to Add more History Records
            </td>
		</tr>
		<tr>
			<td align="center" CLASS="tablebody">
				<FORM NAME="form3" METHOD="post" ACTION="/lendit/index.php">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Exit" VALUE="Loan System">
				</FORM>
              	Click to Go Back to the Loan System
            </td>
		</tr>
	</table>
	</div>
	<?php
	} //end of the If Statement
	else{
?>
<h1>Enter the History Records for iPad</h1>
<form name="registration" action="" method="post" onsubmit="return validateForm(this)">
	<table border="1">
		<tr>
			<td><label for='fname' ><b>First Name:</b></label></td>
			<td><input type='text' name='fname' id='fname' maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='Last Name' ><b>Last Name:</b></label></td>
			<td><input type='text' name='lname' id='lnamename' maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='barcode' ><b>Barcode:</b></label></td>
			<td><input type='text' name='barcode' id='barcode' maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='Email' ><b>Email:</b></label></td>
			<td><input type='text' name='email' id='email' maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='Email' ><b>Phone Number:</b></label></td>
			<td><input type='text' name='pno' id='pno' maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='Institution' ><b>Institution:</b></label></td>
			<td>	
				<select name="institution" id="institution">
				<?php 
	// Build the query
				$query = "SELECT institutionName FROM institution ORDER BY institutionName ASC";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				echo '<option value="'.$row['institutionName'].'" selected="selected">'.$row['institutionName'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
		<tr>
			<td><label for='Date needed' ><b>Loan Date:</b></label></td>
			<td><input type='date' name='loan_date' id='loan_date' maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='Date needed' ><b>Return Date:</b></label></td>
			<td><input type='date' name='return_date' id='return_date' maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type='submit' name="submit" value='Enter Data'/>
			</td>
		</tr>
	</table>
	</form>
<?php 
} //end of else
?>