<?php 
include ("global.php");
include ("layout.php");
include ("functions.php");
if (canupdate()) {
	?>
<head>
<link href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
</head>
<div id="banner" "style:width="90%"";></div>
	<div id="topnavi">
	<a>Select the devices to be Loaned</a>
</div>		
<?php

$query = "SELECT itemtitle FROM loansystem";
$result = mysql_query($query); // Run the query.
echo '<table align="left" cellspacing="0" cellpadding="5">';
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
echo "<tr>
	 <td><input type = 'checkbox'></td>
	 <td>".$row['itemtitle']."</td>";
echo '</tr>';
} 
echo '<tr><td><input type ="submit" id = "assignipadsubmit" value ="Loan Out"></input></td></tr>';
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