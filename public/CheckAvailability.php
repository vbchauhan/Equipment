<?PHP
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
include ("global.php");
//if (@$_SESSION["AUTH_USER"]==true){
top(); 
?>

<?
			$query = "select itemtitle,itemloanflag,warningred from loansystem where loangroup='IPAD'";
			$result=@mysql_query($query);
			$date=date("Y/m/d");
			echo "<table>
			<tr><td><b>Item</b></td><td><b>Availability</b></td>";
			while ($row = @mysql_fetch_array($result)){
			echo "<tr><td>";
			echo $row['itemtitle'];
			echo "</td><td>";
			if ($row['itemloanflag']==0){
			echo "Available";}
			else {
			$days=$row['warningred'];
			$returndate = date("Y-m-d", strtotime("+ $days day"));
			echo "Due by "; echo $returndate;
			}
			echo "</td></tr>";
			}
			?>
			</table>
			
			</tr>
<?PHP 
//bottom(); 
//} //End of the IF statement
//else
	//{ // if person is not allowed to access page throw up a 404 error
	//top();
	//echo "<h1>You have to log in to view this page</h1>	";
	//header("HTTP/1.0 404 Not Found");
	//exit;
	//}
?>