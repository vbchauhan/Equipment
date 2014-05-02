<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
if(isset($_GET['id'])){
$requestID=$_GET['id'];}
$query="select * from request where requestID=$requestID";
$result=mysql_query($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
?>
<head>
<link href="/<?=strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?=strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
<script>
function validateForm()
{
var a=document.forms["registration"]["fname"].value;
var b=document.forms["registration"]["lname"].value;
var c=document.forms["registration"]["barcode"].value;
var d=document.forms["registration"]["email"].value;
var e=document.forms["registration"]["pno"].value;
var f=document.forms["registration"]["ipads"].value;


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
<div id="banner" "style:width="90%"";>EQUIPMENT LOAN SYSTEM</div>
	<div id="topnavi">
    		<?PHP if (@$_SESSION["AUTH_USER"]==true) 
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login/logout.php">LOGOFF</a>';
					else
						{
						$LoginSelectStr='';
						if ($CurrentRequestURLarr[2]=="login") $LoginSelectStr=' class="selected"';
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login/index.php"'.$LoginSelectStr.'>Staff LOGIN</a>'; 
						}?>
			<a href="/<?=strtolower($_SESSION["SystemNameStr"])?>"<? if ($CurrentRequestURLarr[2]=="") print ' class="selected"'?>></a>
            
	</div>	
</div>	

<h1>Edit the Ipad Request Information</h1>
<form name="registration" action="editRequestConf.php" method="post" onsubmit="return validateForm(this)">
	<table border="1">
		<tr>
			<td><label for='fname' ><b>First Name:</b></label></td>
			<td><input type='text' name='fname' id='fname' value= <?php echo $row["fname"] ?> maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='Last Name' ><b>Last Name:</b></label></td>
			<td><input type='text' name='lname' id='lnamename' value= <?php echo $row["lname"] ?> maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='barcode' ><b>Barcode:</b></label></td>
			<td><input type='text' name='barcode' id='barcode' value= <?php echo $row["barcode"] ?> maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='Email' ><b>Email:</b></label></td>
			<td><input type='text' name='email' id='email' value= <?php echo $row["email"] ?> maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='Email' ><b>Phone Number:</b></label></td>
			<td><input type='text' name='pno' id='pno' value= <?php echo $row["pno"] ?> maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td>
				<label for='User Type:' ><b> User Type:</b></label></td>
			<td>
				<select name="utype" style="width:99%">
				<?php 
				// Build the query
				$utypequery = "SELECT user_type_ID, user_type_name FROM user_types ORDER BY User_Type_name ASC";
				$utyperesult = mysql_query ($utypequery);
				while ($utyperow = mysql_fetch_array($utyperesult, MYSQL_ASSOC))
		{
			if($row['utype']==$utyperow['user_type_name']){
				echo '<option value="'.$utyperow['user_type_name'].'" selected="selected">'.$utyperow['user_type_name'].'</option>';
		}else{
			echo '<option value="'.$utyperow['user_type_name'].'">'.$utyperow['user_type_name'];
		}
		}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for='Institution' ><b>Institution:</b></label></td>
			<td>	
				<select name="institution">
				<?php 
	// Build the query
				$ins = "SELECT institutionName FROM institution ORDER BY institutionName ASC";
				$insresult = mysql_query ($ins);
				while ($insrow = mysql_fetch_array($insresult, MYSQL_ASSOC))
		{
			if($row['institution']==$insrow['institutionName']){
				echo '<option value="'.$insrow['institutionName'].'" selected="selected">'.$insrow['institutionName'].'</option>';
		}else{
			echo '<option value="'.$insrow['institutionName'].'">'.$insrow['institutionName'];
		}
		}
				?>
				</select>
			</td>
		</tr>
		<tr>
		<tr>
			<td><label for='Email' ><b>Program Dept:</b></label></td>
			<td><input type='text' name='department' id='department' value= <?php echo $row["department"] ?> maxlength="50" style="width:98%"/></td>
			<input type='hidden' name='request' value=<?php echo $requestID;?>>
		</tr>
		<tr>
			<td><label for='Date needed' ><b>Date needed:</b></label></td>
			<td><input type='text' name='request_date' id='request_date' value = <?php echo $row["request_date"] ?> maxlength="50" style="width:98%"/></td>
		</tr>
		<tr>
			<td><label for='No of iPads:' ><b> No. of iPads :</b></label></td>
			<td><input type='text' name='ipads' id='ipads' maxlength="50" value= <?php echo $row["ipads"] ?> style="width:98%"/></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type='submit' value='Submit Request'/>
				
			</td>
		</tr>
	</table>
	</form>