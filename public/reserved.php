<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
?>
<?
if(isset($_GET["id"])){
	$id=$_GET["id"];
	$query = "delete from request WHERE requestID=$id";
	mysql_query($query);
	}
?>
<head>
<link href="/<?=strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?=strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
</head>
<div id="banner" "style:width="90%"";>EQUIPMENT LOAN SYSTEM</div>
	<div id="topnavi">
	<div id="topnavi">
    		<?PHP if (@$_SESSION["AUTH_USER"]==true) 
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login/logout.php">LOGOFF</a>';
					else
						{
						$LoginSelectStr='';
						if ($CurrentRequestURLarr[2]=="login") $LoginSelectStr=' class="selected"';
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login/index.php"'.$LoginSelectStr.'>LOGIN</a>'; 
						}?>
			<a href="/<?=strtolower($_SESSION["SystemNameStr"])?>"<? if ($CurrentRequestURLarr[2]=="") print ' class="selected"'?>>Home</a>
	</div>	
</div>	
<H1>  </H1>
<?php
$query = "SELECT requestID,fname,lname,barcode,email,pno,utype,institution,department,request_date,ipad_date,ipads,status FROM request where status='reserved'";
$result = mysql_query($query); // Run the query.
echo '<table cellpadding="0" cellspacing="0" class="db-table"> <tr>';

echo '<table align="center" cellspacing="0" cellpadding="5">
<tr class = "BackgroundColorChange">
	<td align="left"><b>First Name</b></td>
	<td align="left"><b>Last Name</a></b></td>
	<td align="left"><b>Barcode</b></td>
	<td align="left"><b>Email</b></td>
	<td align="left"><b>Phone</b></td>
	<td align="left"><b>User Type</b></td>
	<td align="left"><b>Institutions</b></td>
	<td align="left"><b>Department</b></td>
	<td align="left"><b>Request Date</b></td>
	<td align="left"><b>Date Needed</b></td>
	<td align="left"><b>#iPad_Requested</b></td>
	<td align="left"><b>Status</b></td>
	<td align="left"><b>Action</b></td>
	
</tr>';

// Fetch and print all the records.
$bg = '#eeeeee'; // Set the background color.
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	echo '<tr bgcolor="' . $bg . '">
		<td align="left">' . $row['fname'] . '</td>
		<td align="left">' . $row['lname'] . '</td>
		<td align="left">' . $row['barcode'] . '</td>
		<td align="left">' . $row['email'] . '</td>
		<td align="left">' . $row['pno'] . '</td>
		<td align="left">' . $row['utype'] . '</td>
		<td align="left">' . $row['institution'] . '</td>
		<td align="left">' . $row['department'] . '</td>
		<td align="left">' . $row['request_date'] . '</td>
		<td align="left">' . $row['ipad_date'] . '</td>
		<td align="left"><b>' . $row['ipads'] . '</b></td>
		<td align="left">' . $row['status'] . '</td>
		<td align="left"><a href="reserved.php?id=' . $row['requestID'] . '">Finish</a></td>
		</tr>
	';
}
echo '</table>';
?>
