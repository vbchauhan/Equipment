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
		$submit=@$_POST["Submit"];			// Gets Submit from POST variable.		
		}
	else
		{
		$action=@$_GET["action"];			// Gets action from GET variable.
		$uid=@$_GET["uid"]; 				// Gets uid from GET variable.
		}

top();

if (($action=='cancelview') and ($submit=='Exit/Cancel'))
	{
	$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/";
	Header($redirectstr);
	exit;
	}

if ($action=='viewitem')
	{

	$ListQuery = "SELECT
						loangroup,
						itemtitle,
						shortitemtitle,
						itemdescription,
						sortorder,
						itembarcode,
						itemserial,
						itemmodel,
						itemloanflag,
						warningamber,
						warningred,
						loanoverride,
						itemloanedtoname,
						itemloanedtologinid,
						itemloanedtoemail,
						itemloanedtophone,
						itemloanedtonotes,
						itemloandatestart,
						itemlastcheckedoutbyname,
						itemlastcheckedoutbyloginid,
						itemlastcheckedindate,
						itemlastcheckedinbyname,
						itemlastcheckedinbyloginid,
						dateitemcreatedinsystem,
						itemcreatedbyinsystem
				FROM loansystem WHERE uid='".$uid."'";

	$ListResult = @MYSQL_QUERY($ListQuery);
	$ListNum = mysql_num_rows($ListResult);
	
	if ($ListNum<=0)
		{
		print 'Error: Item "'.$uid.'" was not found!';
		} // END if ($ListNum<=0)
	else
		{
		$ListQueryRow = @mysql_fetch_array($ListResult);
		$ItemStatus=loanstatus($ListQueryRow["warningamber"],$ListQueryRow["warningred"],$ListQueryRow["loanoverride"],$ListQueryRow["itemloandatestart"]);
		?>
<BR><H1>'<?php echo strtoupper($ListQueryRow['itembarcode'])?>' Item Detail</H1>
<BR><?php
	if (@$message) 
		print '<div align="center"><font class="messagetext"><b>'.$message.'&nbsp;</b></font></div><br>';
	else
		print '<br>';
	?>	
        <div align="center">
		<table width="650" border="0">
		<tr>
			<td width="250" CLASS="tablebody" align="right">Barcode:</td>
			<td width="400" CLASS="tablebody" align="left"><?php echo $ListQueryRow['itembarcode']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Short Title:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['shortitemtitle']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Long Title:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemtitle']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Description:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemdescription']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Serial No:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemserial']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Model No:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemmodel']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Loaned to Name:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemloanedtoname']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Loaned to Email:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemloanedtoemail']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Loaned to Phone:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemloanedtophone']?>&nbsp;</td>
		</tr>
		
		<tr>
			<td CLASS="tablebody" align="right">Maximum Loan Time:</td>
			<td CLASS="tablebody" align="left"><?php
			if ($ListQueryRow['loanoverride']>=1)
				print $ListQueryRow['loanoverride'];
			else
				print $ListQueryRow['warningred'];
			?>&nbsp;day(s)&nbsp;</td>
		</tr>

<?php   if ($ListQueryRow['itemloanflag']==0)
			{ ?>
		<tr>
			<td CLASS="tablebody" align="right">Loan Status:</td>
			<td CLASS="tablebody" align="left">Item Available</td>
		</tr>
		<?php  } // END if ($ListQueryRow['itemloanflag']==0)
		else
			{ ?>
		<tr>
			<td CLASS="tablebody" align="right">Total days currently on Loan:</td>
			<td CLASS="tablebody" align="left"><?php
				if ($ItemStatus=='green') print '<b class="GreenAlertText">';
				if ($ItemStatus=='amber') print '<b class="AmberAlertText">';
				if ($ItemStatus=='red') print '<b class="RedAlertText">';
				$now = time(); // or your date as well
     $your_date = strtotime($ListQueryRow["itemloandatestart"]);
     $datediff = $now - $your_date;
     echo floor($datediff/(60*60*24));
				print '&nbsp'.countdays($ListQueryRow["itemloandatestart"],date("Y-m-d"));
				?>&nbsp;day(s)&nbsp</b>&nbsp;</td>
		</tr>
		
		<tr>
			<td CLASS="tablebody" align="right">Loaned to Name:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemloanedtoname']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Loaned to Email:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemloanedtoemail']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Loaned to Phone:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemloanedtophone']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Loaned to LoginID:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemloanedtologinid']?>&nbsp;</td>
		</tr>
		
		<?php
        if (@$_SESSION["AUTH_USER"]==true)
			{ ?>
		<tr>
			<td CLASS="tablebody" align="right">Loaned to Notes:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemloanedtonotes']?>&nbsp;</td>
		</tr>
        <?php	} // END if (@$_SESSION["AUTH_USER"]==true) ?>
  		<tr>
			<td CLASS="tablebody" align="right">Loaned to Date:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemloandatestart']?>&nbsp;</td>
		</tr>
  		<tr>
			<td CLASS="tablebody" align="right">Item last checked OUT Name:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemlastcheckedoutbyname']?>&nbsp;</td>
		</tr>
  		<tr>
			<td CLASS="tablebody" align="right">Item last checked OUT LoginID:</td>
			<td CLASS="tablebody" align="left"><?php echo $ListQueryRow['itemlastcheckedoutbyloginid']?>&nbsp;</td>
		</tr>
        
		<?php	} // END ELSE if ($ListQueryRow['itemloanflag']==0)
		?>
  		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>        
        
		<tr>
			<td align="right"><FORM NAME="form3_a" METHOD="post" ACTION="">
					<INPUT TYPE="hidden" NAME="action" VALUE="cancelview">
					<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
			   	    <INPUT TYPE="submit" NAME="Submit" VALUE="Exit/Cancel">
				</FORM>
            </td>
			<td align="center"><FORM NAME="form3_a" METHOD="post" ACTION="">             
                <FORM NAME="form3_b" METHOD="post" ACTION="">
					<INPUT TYPE="hidden" NAME="action" VALUE="itemhistory">
					<INPUT TYPE="hidden" NAME="userinputdata" VALUE="<?php echo $ListQueryRow['itembarcode']?>">
			   	    <INPUT TYPE="submit" NAME="Submit" VALUE="Item Loan History">
				</FORM>                
                </td>
		</tr>
		</table>
        </div>

		<?php
		} //END ELSE if ($ListNum<=0)
	
	} // END if ($action='viewitem')


if ($action=='itemhistory')
	{
	$ListQuery = "SELECT * FROM loansystemlogs WHERE ((loanitembarcode='".@$_POST["userinputdata"]."') and (action='checkinitem')) ORDER BY actiondatetime DESC";

	$ListResult = @MYSQL_QUERY($ListQuery);
	$ListNum = mysql_num_rows($ListResult);
	
	print '<HR>';
	
	if ($ListNum<=0)
		{?>
		<br>
		<H3 align="center"><B><?php echo strtoupper(@$_POST["userinputdata"]);?> Loan History</B></H3>
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
			<td width="250" CLASS="tablebody" align="center" colspan="4">Error: Unable to find a loan history for <?php echo @$_POST["userinputdata"];?> in this system!</td>
		</tr>
		<tr>
			<td align="center" colspan="4">&nbsp;</td>
		</tr>
		<tr>
        	<td align="center" colspan="4"><FORM NAME="form3_a" METHOD="post" ACTION="">
					<INPUT TYPE="hidden" NAME="action" VALUE="cancelview">
					<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
			   	    <INPUT TYPE="submit" NAME="Submit" VALUE="Exit/Cancel">
				</FORM>
            </td>
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

  		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>        
        
		<tr>
			<td align="center" colspan="4"><FORM NAME="form3" METHOD="post" ACTION="">
					<INPUT TYPE="hidden" NAME="action" VALUE="cancelview">
					<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
			   	    <INPUT TYPE="submit" NAME="Submit" VALUE="Exit/Cancel">
				</FORM>
             </td>
		</tr>

		</table>
        </div>
		<?php
		} //END ELSE if ($ListNum<=0)
	
	} // END if ($action='list')


bottom();
?>