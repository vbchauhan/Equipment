<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");

//top();

	$ListQuery = "select action,loanitemshorttitle,loanitembarcode,loantoname,loantoemail,loantophone,itemloandatestart,daysitemwasonloan, itemreturnstatus from loansystemlogs";

	$ListResult = @MYSQL_QUERY($ListQuery);
	$ListNum = mysql_num_rows($ListResult);
?>
<head>
<link href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
<div id="banner" "style:width="90%"";>PRIDDY LIBRARY LOAN SYSTEM</div>
	<div id="topnavi">
    		<?PHP if (@$_SESSION["AUTH_USER"]==true) 
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login/logout.php">LOGOFF</a>';
					else
						{
						$LoginSelectStr='';
						if ($CurrentRequestURLarr[2]=="login") $LoginSelectStr=' class="selected"';
						print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/login/index.php"'.$LoginSelectStr.'>LOGIN</a>'; 
						}?>
			<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>"<?php if ($CurrentRequestURLarr[2]=="") print ' class="selected"'?>>Loan System</a>

			<?PHP if (@$_SESSION["AUTH_USER"]==true)
					{
					$UserQuery = "SELECT bulkloanitems FROM people WHERE LOWER(loginid)='".strtolower(@$_SESSION["AUTH_USER_LOGINID"])."'";
					$UserResult = @mysql_query($UserQuery);
					$UserNums = mysql_num_rows($UserResult);			
					$UserQueryRow = @mysql_fetch_array($UserResult);
					if ($UserNums>=1)
						{
						if ($UserQueryRow["bulkloanitems"]=='1')
							{	
							?>
							<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/checkitembulk.php">Bulk Loan Items</a><?php							
							} //END if ($UserQueryRow["bulkloanitems"]=='1')
						} //END if ($GroupNums>=1)
					} //EMD if (@$_SESSION["AUTH_USER"]==true)
			?>
            
            <?PHP if ((strlen(@$_SESSION["LOANSYSTEM_GROUP"])>=2) and (@$_SESSION["AUTH_USER"]==true))
					{
					$GroupQuery = "select loangroup FROM loangroups WHERE groupvisible='1'";
					$GroupResult = @mysql_query($GroupQuery);
					$GroupNums = mysql_num_rows($GroupResult);			
					if ($GroupNums>=2)
						{
						?>							
						<a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/index.php?action=loangroupselect">Change Loan Group</a><?php
						} //END if ($GroupNums>=2)
					} 
			
            if (canupdate())
				{?>
	            <a href="/<?php echo strtolower($_SESSION["SystemNameStr"])?>/webadmin"<? if ($CurrentRequestURLarr[2]=="webadmin") print ' class="selected"'?>>Admin</a>
                <?PHP } //END if (canupdate()?>
            
	</div>		
<BR><H1 align="center"><B><?php echo strtoupper(@$_POST["userinputdata"]);?> Loan History</B></H1><?php
	if (@$message) 
		print '<div align="center"><font class="messagetext"><b>'.$message.'&nbsp;</b></font></div><br>';
	else
		print '<br>';
	?>	
        <div align="center">
		<TABLE align="center" width="90%" class="tablebox" cellpadding=0 cellspacing=0 border=1>
		<TR >
			<td class="tableheading"  align="center"><b>Status</b></td>
			<td class="tableheading"  align="center"><b>Item</b></td>
			<td class="tableheading"  align="center"><b>Barcode</a></b></td>
			<td class="tableheading"  align="center"><b>Item Loaned To</b></td>
			<td class="tableheading"  align="center"><b>Institution</b></td>
			<td class="tableheading"  align="center"><b>Email</b></td>
			<td class="tableheading"  align="center"><b>Phone</b></td>
			<td class="tableheading"  align="center"><b>Loan Date</b></td>
			<td class="tableheading"  align="center"><b>Days on Loan</b></td>
			<td class="tableheading"  align="center"><b>Return Status</b></td>			
		</TR>
		<?PHP
		for ($i=1; $i<=$ListNum; $i++) 
			{
			$ListQueryRow = @mysql_fetch_array($ListResult);
        ?>
		<TR>
		
			<TD class="tablebody" NOWRAP ALIGN="left"><?php echo $ListQueryRow["action"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="left"><?php echo $ListQueryRow["loanitemshorttitle"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["loanitembarcode"];?></TD>					
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["loantoname"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["loantoinstitution"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["loantoemail"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["loantophone"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["itemloandatestart"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["daysitemwasonloan"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["itemreturnstatus"];?></TD>			
		</TR>
		
		


		<?PHP
			} //END for ($i=1; $i<=$ListNum; $i++)
		?>
		</table>

		<BR>
        <form name="form1scan" method="post" action="download.php" target="_blank">
		    <input type="hidden" name="action" value="ItemHistoryCSVl">
		    <input type="hidden" name="lgroup" value="<?php echo $lgroup?>">
		    <input type="hidden" name="userinputdata" value="<?php echo $_POST["userinputdata"]?>">            
			<input type="submit" name="submit" value="Download .CSV List">
		</form>
	