<?PHP
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
	$redirectstr="Location: /".strtolower($_SESSION["SystemNameStr"])."/view";
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
<BR><H1>'<?php  echo strtoupper($ListQueryRow['itembarcode'])?>' Item Detail</H1>
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
			<td CLASS="tablebody" align="right">Maximum Loan Time:</td>
			<td CLASS="tablebody" align="left"><?php
			if ($ListQueryRow['loanoverride']>=1)
				print $ListQueryRow['loanoverride'];
			else
				print $ListQueryRow['warningred'];
			?>&nbsp;day(s)&nbsp;</td>
		</tr>

<?PHP   if ($ListQueryRow['itemloanflag']==0)
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
			<td align="center" colspan="2"><FORM NAME="form3_a" METHOD="post" ACTION="">
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
	
	} // END if ($action='viewitem')


bottom();
?>