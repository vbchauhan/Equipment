<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");

if (canupdate())
	{  // Check to see if a staff member has logged in.
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $_SESSION["SystemNameStr"]?></title>
<meta name="author" content="Darren van den Bogaard, info AT  (darren.vdb AT iscrafty DOT com)">
<meta http-equiv="content-language" content="en">
<meta name="Description" content="LendIT, Equipment loan management system">
<meta name="Copyright" content="Darren van den Bogaard" />
<meta name="robots" content="noarchive" />
<link rel="shortcut icon" href="/equipment/favicon.ico" type="image/x-icon">
</head>
<?php

$query = "SELECT 
				* 
			FROM 
				people 
			WHERE 
				((loginid!='' )and (loginid!='supervisor' ))
			ORDER BY firstname ASC";
$result = @mysql_query($query);
$num = @mysql_num_rows($result);

if ($num>=1)
	{
	print '<H1 align="center">STAFF LIST FOR '.strtoupper($_SESSION["SystemNameStr"]).' SYSTEM</H1>';
	print '<DIV align="center">LIST CREATED: '.strtoupper(date('d-M-Y @ h:iA')).'</DIV>';
	$rowcounter=0;
	$pagecounter=1;
	
	$rows_x=3;
	$rows_y=15;
	
	for ($k=0; $k < ($num/$rows_x); $k++) 
		{
		if ($rowcounter<=0)
			print '<BR>';
		
		$rowcounter+=1;
		?>
		<table width="700" align="center" border="0">				
			<tr>
				<?php
				for ($i=0; $i < $rows_x; $i++) 
					{ ?>

					<td>
						<?php
						$row = mysql_fetch_array($result);
						?>

						<table width="280" align="center" border="1">				
							<tr>
								<td>
								<?php
								if ($row["firstname"])
									{ ?>

									<table width="100%" align="center" border="0">
										<td class="tablecell" width="70%"><b><?php echo strtoupper($row["firstname"])?></b> <?php echo $row["lastname"]?> </td>
										<td rowspan="11" valign="top" align="center" width="30%">&nbsp; 
												
										</td>
										<tr> 
											<td align="center">
											<IMG BORDER="0" SRC="barcode39/barcode39.php?bcdata=<?php echo $row["loginid"]?>">&nbsp;
											</td>
										</tr>
									</table>

									<?php
									} //END if ($row["firstname"]) 
									else print '<BR>&nbsp;<BR>&nbsp;<BR>&nbsp;';
									?>

								</td>
							</tr>
						</table>
	
					</td>

				<?php
				} //END for ($i=0; $i < 2; $i++)  ?>
			</tr>

		</table>
		<?php
		if ($rowcounter>=$rows_y)
			{
			print '<div align="right">page '.$pagecounter.'</div>';
			print '<div class="printerpagebreak">&nbsp;</div>'; // Force a page break
			$rowcounter=0; // Reset the counter
			$pagecounter+=1;
			} //END if ($rowcounter>=7)
		
		} //END for ($k=0; $k < $num; $k++) 

	print '<BR><BR><BR><BR><BR><div align="right">page '.$pagecounter.'</div>';
	} //END if ($num>=1)

?>
</BODY>
</HTML>
<?php
	} //END if (canupdatepath('/webadmin/index.php'))
?>