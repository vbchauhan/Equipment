<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");

if (canupdate()) {
?>
<?php
if(isset($_GET["id"]) ){
$id=$_GET["id"];
	if(isset($_GET["cancel"]) ){
	$query = "delete from request WHERE requestID=$id";
	mysql_query($query);
		}
	else	
		{
		$query = "UPDATE request
		SET status='reserved' WHERE requestID=$id";
		mysql_query($query);
		}
}
		
	if(isset($_GET["sort"]) ){
		$sort=$_GET["sort"];
		}
	else{
		$sort="request_date";
		}
	if(isset($_GET["order"]) ){
		$order=$_GET["order"];
		}
	else{
		$order="asc";
	}
?>
<head>
<link href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
</head>
<div id="banner" "style:width="90%"";>EQUIPMENT LOAN SYSTEM</div>
	<div id="topnavi">
	<div id="topnavi">
    		<?php if (@$_SESSION["AUTH_USER"]==true) 
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login/logout.php">LOGOFF</a>';
					else
						{
						$LoginSelectStr='';
						if ($CurrentRequestURLarr[2]=="login") $LoginSelectStr=' class="selected"';
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login/index.php"'.$LoginSelectStr.'>LOGIN</a>'; 
						}?>
			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/Public"<?php if ($CurrentRequestURLarr[2]=="webadmin") print ' class="selected"'?>>Public</a>
			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>"<?php if ($CurrentRequestURLarr[2]=="") print ' class="selected"'?>>Home</a>
	</div>	
</div>	
<?php
$image=$_SESSION["SystemNameStr"]."/css/images/delete-icon.png";
echo "<H1> iPad Requests sorted as per $sort $order</H1>";
$query = "SELECT requestID,fname,lname,barcode,email,pno,utype,institution,department,request_date,ipad_date,ipads,status FROM request where status='requested' order by $sort $order ";
$result = mysql_query($query); // Run the query.
echo '<table cellpadding="0" cellspacing="0" class="db-table"> <tr>';
if ($order=="asc"){
echo '<table align="center" cellspacing="0" cellpadding="5">
<tr>
	<td align="left"><a href="view_requests.php?sort=fname&order=desc"><b>First Name</b></a></td>
	<td align="left"><a href="view_requests.php?sort=lname&order=desc"><b>Last Name</a></b></a></td>
	<td align="left"><a href="view_requests.php?sort=barcode&order=desc"><b>Barcode</b></a></td>
	<td align="left"><a href="view_requests.php?sort=email&order=desc"><b>Email</b></a></td>
	<td align="left"><a href="view_requests.php?sort=pno&order=desc"><b>Phone</b></a></td>
	<td align="left"><a href="view_requests.php?sort=utype&order=desc"><b>User Type</b></a></td>
	<td align="left"><a href="view_requests.php?sort=institution&order=desc"><b>Institutions</b></a></td>
	<td align="left"><a href="view_requests.php?sort=department&order=desc"><b>Department</b></a></td>
	<td align="left"><a href="view_requests.php?sort=request_date&order=desc"><b>Request Date</b></a></td>
	<td align="left"><a href="view_requests.php?sort=ipad_date&order=desc"><b>Date Needed</b></a></td>
	<td align="left"><a href="view_requests.php?sort=ipads&order=desc"><b>#iPad_Requested</b></a></td>
	<td align="left"><b>Status</b></td>
	<td align="left"><b>Action</b></td>
	
</tr>';
}
else{
echo '<table align="center" cellspacing="0" cellpadding="5">
<tr>
	<td align="left"><a href="view_requests.php?sort=fname&order=asc"><b>First Name</b></a></td>
	<td align="left"><a href="view_requests.php?sort=lname&order=asc"><b>Last Name</a></b></a></td>
	<td align="left"><a href="view_requests.php?sort=barcode&order=asc"><b>Barcode</b></a></td>
	<td align="left"><a href="view_requests.php?sort=email&order=asc"><b>Email</b></a></td>
	<td align="left"><a href="view_requests.php?sort=pno&order=asc"><b>Phone</b></a></td>
	<td align="left"><a href="view_requests.php?sort=utype&order=asc"><b>User Type</b></a></td>
	<td align="left"><a href="view_requests.php?sort=institution&order=asc"><b>Institutions</b></a></td>
	<td align="left"><a href="view_requests.php?sort=department&order=asc"><b>Department</b></a></td>
	<td align="left"><a href="view_requests.php?sort=request_date&order=asc"><b>Request Date</b></a></td>
	<td align="left"><a href="view_requests.php?sort=ipad_date&order=asc"><b>Date Needed</b></a></td>
	<td align="left"><a href="view_requests.php?sort=ipads&order=asc"><b>#iPad_Requested</b></a></td>
	<td align="left"><b>Status</b></td>
	<td align="left"><b>Action</b></td>
	
</tr>';
}

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
		<td align="left"><a href="editRequest.php?id=' . $row['requestID'] . '" target="_blank"> <img src="images/edit-icon.png" width="32" height="32"></a></td>
		<td align="left"><a href="view_requests.php?id=' . $row['requestID'] . '">Reserve</a></td>
		<td align="left"><a href="view_requests.php?id=' . $row['requestID'] . '&cancel=1" onclick="confirmdelete()"><img src="images/delete-icon.png" width="32" height="32"></a></td>
		</tr>
	';
}
echo '</table>';
} //End of If Can Update
else
	{ // if person is not allowed to access page throw up a 404 error
	header("HTTP/1.0 404 Not Found");
	top();
	echo "<h1>Only Admin can view this page</h1>";
	exit;
	}
?>
<script language="javascript" type="text/javascript">
function confirmdelete(){
var c=confirm("Are you sure? Once Cancelled the action cannot be undone!");
if(c==false){
	window.location="view_requests.php?";
	}
else
{return false;}
}
</script>