<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");

// Get variables
$action=@$_POST["action"]; 					// Check action was a POST variable

if ($action)
		{
		$uid=@$_POST["uid"];				// Gets uid from POST variable.
		$submit=@$_POST["submit"];			// Gets Submit from POST variable.		
		$lgroup=@$_POST["lgroup"];
		}
	else
		{
		$action=@$_GET["action"];			// Gets action from GET variable.
		$uid=@$_GET["uid"]; 				// Gets uid from GET variable.
		$lgroup=@$_GET["lgroup"];
		}

if (strlen($action)<=1) $action='search';

if (($action=='cancelview') and ($submit=='Exit/Cancel'))
	{
	$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/";
	Header($redirectstr);
	exit;
	}


top();


if  (($action=='search') or ($action=='list'))
	{
?>
<BR>
<H1>TYPE IN ITEM BARCODE TO LOOK UP</H1>
<?php
if (@$message) 
	print '<div align="center"><font class="messagetext"><b>'.$message.'&nbsp;</b></font></div>';
else
	print '<br>';
?>

	<table align="center" width="90%" border="0" class="tablebox">
	<tr>
    	<td align="center" CLASS="tablebody" valign="middle">
		<form name="form1scan" method="post" action="">
		    <input type="hidden" name="action" value="list">
		    <input type="hidden" name="lgroup" value="<?php echo $lgroup?>">
			<p align="center">ITEM BARCODE HERE: <input type="text" name="userinputdata" size="20" maxlength="20" value="">
			<input type="submit" name="submit"  autofocus="autofocus" value="GO">
			</p>
		</form>
		<?php  focus('form1scan','scanitemdata'); ?>
		</td>
	</tr>
	</table>
<BR>
<?php
	} //END if ($action=='search')

if (($action=='list') or ($action=='listitem'))
	{
	$ListQuery = "SELECT * FROM loansystemlogs WHERE ((loanitembarcode='".@$_POST["userinputdata"]."') and (action='checkinitem')) ORDER BY actiondatetime DESC";

	$ListResult = @MYSQL_QUERY($ListQuery);
	$ListNum = mysql_num_rows($ListResult);
	
	print '<HR>';
	
	if ($ListNum<=0)
		{?>
<BR><H3 align="center"><B><?php echo strtoupper(@$_POST["userinputdata"]);?> Loan History</B></H3>
<BR>
		<div align="center">
        <table width="750" border="0">
		<TR>
			<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>Date&Time Returned</strong></TD>
			<TD WIDTH="250" class="tableheading" ALIGN="center"><strong>LoanToName</strong></TD>
			<TD WIDTH="50" class="tableheading" NOWRAP ALIGN="center"><strong>DaysLoanedOut</strong></TD>					
			<TD WIDTH="50" class="tableheading" ALIGN="center"><strong>ItemReturnStatus</strong></TD>					
		</TR>        
		<tr>
			<td width="250" CLASS="tablebody" align="center" colspan="4">Error: Unable to find a loan history for <?php echo $_POST["userinputdata"];?> in this system!</td>
		</tr>
        </table>
        </div>
		<?php 
        } // END if ($ListNum<=0)
	else
		{
		?>
<BR><H3 align="center"><B><?php echo strtoupper(@$_POST["userinputdata"]);?> Loan History</B></H3><?php 
	if (@$message) 
		print '<div align="center"><font class="messagetext"><b>'.$message.'&nbsp;</b></font></div><br>';
	else
		print '<br>';
	?>	
        <div align="center">
		<TABLE align="center" width="750" class="tablebox" cellpadding=2 cellspacing=2 border=0>
		<TR>
			<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>Date&Time Returned</strong></TD>
			<TD WIDTH="250" class="tableheading" ALIGN="center"><strong>LoanToName</strong></TD>
			<TD WIDTH="50" class="tableheading" NOWRAP ALIGN="center"><strong>DaysLoanedOut</strong></TD>					
			<TD WIDTH="50" class="tableheading" ALIGN="center"><strong>ItemReturnStatus</strong></TD>					
		</TR>
		<?php
		for ($i=1; $i<=$ListNum; $i++) 
			{
			$ListQueryRow = @mysql_fetch_array($ListResult);
        ?>
		<TR>
			<TD class="tablebody" NOWRAP ALIGN="left"><?php echo $ListQueryRow["actiondatetime"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="left"><?php echo $ListQueryRow["loantoname"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["daysitemwasonloan"];?></TD>					
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["itemreturnstatus"];?></TD>					
		</TR>


		<?php
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
       
        </div>
		<?php 
		} //END ELSE if ($ListNum<=0)
	
	} // END if ($action='list')



bottom();
?>