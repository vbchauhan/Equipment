<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
// Get variables
$action=@$_POST["action"]; 					// Check action was a POST variable

if ($action)
		{
		$scanitemdata=@$_POST["scanitemdata"];		// Gets uid from POST variable.
		$submit=@$_POST["submit"];					// Gets Submit from POST variable.		
		} // END if ($action)

if ($action=='') $action='scanitem'; // If no action the default to "list" groups.

if (($action=='loanitemsout') and ($submit=='BACK')) $action='scanitem';

if (($action=='loanto') or ($action=='loantoverify'))
	{
	if ($submit=='BACK')
		{
		$action='scanitem';
		} //END if ($submit=='BACK')
		
	if ($submit=='Cancel/Exit')
		{
		$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/";
		Header($redirectstr);
		exit;
		} //END if ($submit=='Cancel/Exit')

	if ($submit=='Loan Item(s) Out')
		{
		$LookupStr=lookupperson(@$_POST["fsid"],@$_POST["femail"],@$_POST["fname"],@$_POST["fphone"]);
		$LookupStrArr=explode(',',$LookupStr); //0=staffid,1=email,2=name,3=phone,4=isstaffmemeber

		if (strlen($LookupStr)>=2)
			{
			$LookupQueryRow = @mysql_fetch_array($LookupResult);
			$vsid=$LookupStrArr["0"];
			$vemail=$LookupStrArr["1"];
			$vname=$LookupStrArr["2"];
			$vphone=$LookupStrArr["3"];
			$visstaffmemeber=$LookupStrArr["4"];

			if ($LookupStrArr["4"]=='0')
				{
				$InsertQuery="UPDATE namecache SET
									tsdate='".date('Y-m-d H:i')."',
									tsdatenumber=".time(date('Y-m-d H:i'))." 
									WHERE uid=".$LookupStrArr["5"];
				$InsertResult = @mysql_query($InsertQuery);	
				} //END if ($LookupStrArr["4"]=='0')
							
			$action='loantoverify';					
			} //END if ($LookupNum==1)
		else
			{
			if ((strlen(@$_POST["femail"])>=3) and 
				(strlen(@$_POST["fname"])>=3) and 
				(strlen(@$_POST["fname"])>=3) and 
				(strlen(@$_POST["fphone"])>=3))
					{
					$vsid=@$_POST["fsid"];
					$vemail=@$_POST["femail"];
					$vname=@$_POST["fname"];
					$vphone=@$_POST["fphone"];
					$visstaffmemeber='';
					$action='loantoverify';	
					} //END if ((strlen(......))
				else
					{
					$message='You must type in EMAIL, NAME and PHONE details to continue!';
					$action='scanitem';
					} //END ELSE if ((strlen(......))
			} //END ELSE if ($LookupNum2>=1)
		} //END if ($submit=='Loan Item Out')
	else
		$action='scanitem';
	} // END if ($action=='loanto')


if ($action=='loanitemsout')
	{
	$LookupStr=lookupperson(@$_POST["vsid"],@$_POST["vemail"],@$_POST["vname"],@$_POST["vphone"]);
	$LookupStrArr=explode(',',$LookupStr); //0=staffid,1=email,2=name,3=phone,4=isstaffmemeber
		
	if (strlen($LookupStr)<=2)
		{
		// Add this persons details to the namecache
		$InsertQuery="INSERT INTO namecache SET
							staffid='".strtolower(@$_POST["vsid"])."',
							name='".ucwords(strtolower(@$_POST["vname"]))."',
							email='".strtolower(@$_POST["vemail"])."',
							phone='".@$_POST["vphone"]."',
							tsdate='".date('Y-m-d H:i')."',
							tsdatenumber=".time(date('Y-m-d H:i'));
		$InsertResult = @mysql_query($InsertQuery);	
		} //END if (strlen($LookupStr)<=2)
		
	$ItemLoanedlist='';
	for ($i=1; $i < 11; $i++)
		{
		$lookupbarcode=lookupbarcode(@$_POST["fitem".$i],0);
		if ((strlen($lookupbarcode)>=2)	and (IsItemOnLoan(@$_POST["fitem".$i])<>1)) 
			{
			if ($i==1)
				$ItemLoanedlist=@$_POST["fitem".$i];
			else
				$ItemLoanedlist=$ItemLoanedlist.', '.@$_POST["fitem".$i];
				
			$ListQuery = "SELECT * FROM loansystem WHERE itembarcode='".@$_POST["scanitemdata"]."'";
			$ListResult = @mysql_query($ListQuery);
			$ListNum = mysql_num_rows($ListResult);
			$ListQueryRow = @mysql_fetch_array($ListResult);		
			
			if (@$_POST["floanoverride"]>=1)
				{ 
				$loanoverridestr="loanoverride=".@$_POST["floanoverride"].",";
				$LogStrVal=@$_POST["floanoverride"];
				}
			else
				{
				$loanoverridestr="loanoverride=0,";
				$LogStrVal=0;
				}
			
			$UpdateQuery="UPDATE `loansystem` SET 
							itemloanflag='1',
							itemloanedtoname='".@$_POST["vname"]."',
							itemloanedtologinid='".@$_POST["vsid"]."',
							itemloanedtoemail='".@$_POST["vemail"]."',
							itemloanedtophone='".@$_POST["vphone"]."',
							itemloanedtonotes='".@$_POST["fitemloanedtonotes"]."',
							itemloandatestart='".date('Y-m-d')."',
							".$loanoverridestr."
							itemlastcheckedoutbyname='".ucwords(strtolower(@$_SESSION["AUTH_USER_NAME"]))."',
							itemlastcheckedoutbyloginid='".strtoupper(@$_SESSION["AUTH_USER_LOGINID"])."',
							itemlastcheckedindate='',
							itemlastcheckedinbyname='',
							itemlastcheckedinbyloginid='' 
						WHERE (itembarcode='".@$_POST["fitem".$i]."')";			
			$UpdateResult = @mysql_query($UpdateQuery);		
			if ($UpdateResult)
				{
				$message=@$_POST["scanitemdata"].' was successfully loaned to "'.@$_POST["vname"].'"';

				// Write Transaction Record to loansystemlog.
				$querylog="INSERT INTO loansystemlogs SET 
								actiondatetime = '".date('Y-m-d H:i')."',
								action = 'checkoutitem',
								loangroup = '".@$_SESSION["LOANSYSTEM_GROUP"]."',
								loanitemshorttitle = '".$ListQueryRow["shortitemtitle"]."',
								loanitembarcode = '".$ListQueryRow["itembarcode"]."',
								loantoname = '".@$_POST["vname"]."',
								loantologinid = '".@$_POST["vsid"]."',
								loantoemail = '".@$_POST["vemail"]."',
								loantophone = '".@$_POST["vphone"]."',
								itemloandatestart = '".date('Y-m-d')."',
								daysitemwasonloan = '',
								itemreturnstatus = '',
								adminname = '".ucwords(strtolower(@$_SESSION["AUTH_USER_NAME"]))."',
								adminloginid = '".strtoupper(@$_SESSION["AUTH_USER_LOGINID"])."',
								adminip = '".$_SERVER["REMOTE_ADDR"]."',
								admindns = '".@gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
								notes = 'AmberAlert=".$ListQueryRow["warningamber"].", RedAlert=".$ListQueryRow["warningred"].", LoanOverride=".$LogStrVal."'";
				$resultlog = @mysql_query($querylog);
				} //END if ($UpdateResult)
			} //END if ((strlen($lookupbarcode)>=2)	and (IsItemOnLoan(@$_POST["fitem".$i])<>1))
		} //END for ($i=1; $i < 11; $i++)

	$message=$ItemLoanedlist.' items were loaned out.';
	$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/index.php?message=".$message."";
	Header($redirectstr);
	exit;	
	} //END if ($action=='loanitemout')


top();

if ($action=='loantoverify')
	{
		?>
        <BR><H1>ITEMS TO BE LOANED OUT CONFIRM</H1>
		<BR>
        <div align="center">
		<form name="form1" method="post" action="">
	    <input type="hidden" name="fitem1" value="<?php echo $_POST["fitem1"]?>">
	    <input type="hidden" name="fitem2" value="<?php echo $_POST["fitem2"]?>">
	    <input type="hidden" name="fitem3" value="<?php echo $_POST["fitem3"]?>">
	    <input type="hidden" name="fitem4" value="<?php echo $_POST["fitem4"]?>">
	    <input type="hidden" name="fitem5" value="<?php echo $_POST["fitem5"]?>">
	    <input type="hidden" name="fitem6" value="<?php echo $_POST["fitem6"]?>">
	    <input type="hidden" name="fitem7" value="<?php echo $_POST["fitem7"]?>">
	    <input type="hidden" name="fitem8" value="<?php echo $_POST["fitem8"]?>">
	    <input type="hidden" name="fitem9" value="<?php echo $_POST["fitem9"]?>">
	    <input type="hidden" name="fitem10" value="<?php echo $_POST["fitem10"]?>">
	    <input type="hidden" name="floanoverride" value="<?php echo $_POST["floanoverride"]?>">        
	    <input type="hidden" name="fsid" value="<?php echo $_POST["fsid"]?>">
	    <input type="hidden" name="femail" value="<?php echo $_POST["femail"]?>">
	    <input type="hidden" name="fname" value="<?php echo $_POST["fname"]?>">
	    <input type="hidden" name="fphone" value="<?php echo $_POST["fphone"]?>">
	    <input type="hidden" name="fitemloanedtonotes" value="<?php echo $_POST["fitemloanedtonotes"]?>">
	    <input type="hidden" name="vsid" value="<?php echo $vsid?>">
	    <input type="hidden" name="vemail" value="<?php echo $vemail?>">
	    <input type="hidden" name="vname" value="<?php echo $vname?>">
	    <input type="hidden" name="vphone" value="<?php echo $vphone ?>">
	    <input type="hidden" name="action" value="loanitemsout">
		<input type="hidden" name="scanitemdata" value="<?php echo $scanitemdata?>">
		<table width="750" border="0">
        <tr>
 				<td align="center" colspan="2"><b>LOAN ITEM DETAILS</b></td>
		</tr>

		<?php
		$InvalidItemFlag=0;
		
		$ItemLookup=lookupbarcode(@$_POST["fitem1"],@$_POST["floanoverride"]);
		if ((strlen($ItemLookup)>=2)) 
			{
			if (IsItemOnLoan(@$_POST["fitem1"])==1) 
				{
				$InvalidItemFlag=1;
				$ItemLookup='<b class="RedAlertText">'.$ItemLookup.'</b>';
				}
			?>
			<tr>
				<td CLASS="tablebody" align="right">ITEM 1:</td>
				<td CLASS="tablebody" align="left"><?php 
				print $ItemLookup;
				?>&nbsp;</td>
			</tr>
			<?php
			} //END if ((strlen($ItemLookup)>=2)) 
			?>
            

		<?php
		$ItemLookup=lookupbarcode(@$_POST["fitem2"],@$_POST["floanoverride"]);
		if ((strlen($ItemLookup)>=2)) 
			{
			if (IsItemOnLoan(@$_POST["fitem2"])==1) 
				{
				$InvalidItemFlag=1;
				$ItemLookup='<b class="RedAlertText">'.$ItemLookup.'</b>';
				}
			?>
			<tr>
				<td CLASS="tablebody" align="right">ITEM 2:</td>
				<td CLASS="tablebody" align="left"><?php echo $ItemLookup;?>&nbsp;</td>
			</tr>
			<?php
			} //END if ((strlen($ItemLookup)>=2)) 
			?>
            

		<?php
		$ItemLookup=lookupbarcode(@$_POST["fitem3"],@$_POST["floanoverride"]);
		if ((strlen($ItemLookup)>=2)) 
			{
			if (IsItemOnLoan(@$_POST["fitem3"])==1) 
				{
				$InvalidItemFlag=1;
				$ItemLookup='<b class="RedAlertText">'.$ItemLookup.'</b>';
				}
			?>
			<tr>
				<td CLASS="tablebody" align="right">ITEM 3:</td>
				<td CLASS="tablebody" align="left"><?php echo $ItemLookup;?>&nbsp;</td>
			</tr>
			<?php
			} //END if ((strlen($ItemLookup)>=2)) 
			?>
            

		<?php
		$ItemLookup=lookupbarcode(@$_POST["fitem4"],@$_POST["floanoverride"]);
		if ((strlen($ItemLookup)>=2)) 
			{
			if (IsItemOnLoan(@$_POST["fitem4"])==1) 
				{
				$InvalidItemFlag=1;
				$ItemLookup='<b class="RedAlertText">'.$ItemLookup.'</b>';
				}
			?>
			<tr>
				<td CLASS="tablebody" align="right">ITEM 4:</td>
				<td CLASS="tablebody" align="left"><?php echo $ItemLookup;?>&nbsp;</td>
			</tr>
			<?php
			} //END if ((strlen($ItemLookup)>=2)) 
			?>
            

		<?php
		$ItemLookup=lookupbarcode(@$_POST["fitem5"],@$_POST["floanoverride"]);
		if ((strlen($ItemLookup)>=2)) 
			{
			if (IsItemOnLoan(@$_POST["fitem5"])==1) 
				{
				$InvalidItemFlag=1;
				$ItemLookup='<b class="RedAlertText">'.$ItemLookup.'</b>';
				}
			?>
			<tr>
				<td CLASS="tablebody" align="right">ITEM 5:</td>
				<td CLASS="tablebody" align="left"><?php echo $ItemLookup;?>&nbsp;</td>
			</tr>
			<?php
			} //END if ((strlen($ItemLookup)>=2)) 
			?>
            

		<?php
		$ItemLookup=lookupbarcode(@$_POST["fitem6"],@$_POST["floanoverride"]);
		if ((strlen($ItemLookup)>=2)) 
			{
			if (IsItemOnLoan(@$_POST["fitem6"])==1) 
				{
				$InvalidItemFlag=1;
				$ItemLookup='<b class="RedAlertText">'.$ItemLookup.'</b>';
				}
			?>
			<tr>
				<td CLASS="tablebody" align="right">ITEM 6:</td>
				<td CLASS="tablebody" align="left"><?php echo $ItemLookup;?>&nbsp;</td>
			</tr>
			<?php
			} //END if ((strlen($ItemLookup)>=2)) 
			?>
            

		<?php
		$ItemLookup=lookupbarcode(@$_POST["fitem7"],@$_POST["floanoverride"]);
		if ((strlen($ItemLookup)>=2)) 
			{
			if (IsItemOnLoan(@$_POST["fitem7"])==1) 
				{
				$InvalidItemFlag=1;
				$ItemLookup='<b class="RedAlertText">'.$ItemLookup.'</b>';
				}
			?>
			<tr>
				<td CLASS="tablebody" align="right">ITEM 7:</td>
				<td CLASS="tablebody" align="left"><?php echo $ItemLookup;?>&nbsp;</td>
			</tr>
			<?php
			} //END if ((strlen($ItemLookup)>=2)) 
			?>
            

		<?php
		$ItemLookup=lookupbarcode(@$_POST["fitem8"],@$_POST["floanoverride"]);
		if ((strlen($ItemLookup)>=2)) 
			{
			if (IsItemOnLoan(@$_POST["fitem8"])==1) 
				{
				$InvalidItemFlag=1;
				$ItemLookup='<b class="RedAlertText">'.$ItemLookup.'</b>';
				}
			?>
			<tr>
				<td CLASS="tablebody" align="right">ITEM 8:</td>
				<td CLASS="tablebody" align="left"><?php echo $ItemLookup;?>&nbsp;</td>
			</tr>
			<?php
			} //END if ((strlen($ItemLookup)>=2)) 
			?>
            

		<?php
		$ItemLookup=lookupbarcode(@$_POST["fitem9"],@$_POST["floanoverride"]);
		if ((strlen($ItemLookup)>=2)) 
			{
			if (IsItemOnLoan(@$_POST["fitem9"])==1) 
				{
				$InvalidItemFlag=1;
				$ItemLookup='<b class="RedAlertText">'.$ItemLookup.'</b>';
				}
			?>
			<tr>
				<td CLASS="tablebody" align="right">ITEM 9:</td>
				<td CLASS="tablebody" align="left"><?php echo $ItemLookup;?>&nbsp;</td>
			</tr>
			<?php
			} //END if ((strlen($ItemLookup)>=2)) 
			?>
            

		<?php
		$ItemLookup=lookupbarcode(@$_POST["fitem10"],@$_POST["floanoverride"]);
		if ((strlen($ItemLookup)>=2)) 
			{
			if (IsItemOnLoan(@$_POST["fitem10"])==1) 
				{
				$InvalidItemFlag=1;
				$ItemLookup='<b class="RedAlertText">'.$ItemLookup.'</b>';
				}
			?>
			<tr>
				<td CLASS="tablebody" align="right">ITEM 10:</td>
				<td CLASS="tablebody" align="left"><?php echo $ItemLookup;?>&nbsp;</td>
			</tr>
			<?php
			} //END if ((strlen($ItemLookup)>=2)) 
			?>

        <tr>
 				<td align="center" colspan="2">&nbsp;</td>
		</tr>
        <tr>
 				<td align="center" colspan="2"><b>Patron Information</b></td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Staff ID Card or Login ID:</td>
			<td CLASS="tablebody" align="left"><?php echo $vsid?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Email Address:</td>
			<td CLASS="tablebody" align="left"><?php echo $vemail?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Full Name:</td>
			<td CLASS="tablebody" align="left"><?php echo $vname?>&nbsp;<?php
		if ($visstaffmemeber=='1') print '(Staff Member)';
		if ($visstaffmemeber=='') print '(New Person)';	
		?></td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Phone Number:</td>
			<td CLASS="tablebody" align="left"><?php echo $vphone;?>&nbsp;</td>
		</tr>
		<?php
        if (strlen(@$_POST["fitemloanedtonotes"])>=1)
			{ 	?>
	    <tr>
			<td CLASS="tablebody" align="right" valign="middle">Loan To Notes:<BR><em>(This will be applied to all items<BR>being loaned out above)</em></td>
			<td CLASS="tablebody" align="left"><?php echo $_POST["fitemloanedtonotes"]?>&nbsp;</td>
		</tr>
		<?php
		} // END 	if (strlen(@$_POST["fitemloanedtonotes"])>=1))
		?>        
        
        <tr>
 				<td align="center" colspan="2">
                <?php
					if (@$message) 
						print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
				?>&nbsp;
                </td>
		</tr>
		</table>
        
		<table width="750" border="0">		
        <tr>
			<td align="center">
				<input type="submit" name="submit" autofocus="autofocus" default="default" value="Loan Item(s) Out"<?php
                if ($InvalidItemFlag==1) print 'disabled="disabled"';
				?>>
            </td>
			<td align="center">
				<input type="submit" name="submit" value="BACK">
                </form>
            </td>
			<td align="center">
				<?php
				$loanitemsliststr='';
				for ($i=1; $i < 11; $i++)
					{
					if (strlen(@$_POST["fitem".$i])>=2)
						{
						$ListQuery44 = "SELECT shortitemtitle FROM loansystem WHERE LOWER(itembarcode)='".strtolower(@$_POST["fitem".$i])."'";
						$ListResult44 = @mysql_query($ListQuery44);
						$ListNum44 = mysql_num_rows($ListResult44);
						$ListQueryRow44 = @mysql_fetch_array($ListResult44);	
						if ($ListNum44>=1)
							{
							if (strlen($loanitemsliststr)<=0)
								$loanitemsliststr=$ListQueryRow44["shortitemtitle"].'('.@$_POST["fitem".$i].')';
							else
								$loanitemsliststr=$loanitemsliststr.', '.$ListQueryRow44["shortitemtitle"].'('.@$_POST["fitem".$i].')';;
							} //END if ($ListNum44>=1)
						} //END if (strlen(@$_POST["fitem".$i])>=2)
					} //END for ($i=1; $i < 11; $i++)
				
				if (@$_POST["floanoverride"]>=1)
					$DueBackStr=' and all item(s) are due all back on the '.date("d-M-Y",strtotime("+".$_POST["floanoverride"]." days")).'.';
				else
					$DueBackStr='';
				
				$emailtostr=$vemail.';'.$_SESSION["AUTH_USER_EMAIL"];
				$emailsubjectstr='Loan of items to '.$vname.' on '.date('d-M-Y');
				$emailbodystr=$loanitemsliststr.' was loaned to '.$vname.' on the '.date('d-M-Y').$DueBackStr;
				
				$MailToStr='mailto:'.$emailtostr.'?subject='.$emailsubjectstr.'&body='.$emailbodystr;

                if ($InvalidItemFlag<>1)
					{
				?>
                <a href="<?php echo $MailToStr?>" target="_new" style="text-decoration: none">SEND EMAIL RECEIPT</a>
				<?php
					}
				else
					{
				?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php  } ?>
            </td>
		</tr>
        </table>
		<?php focus('form1','fsid'); ?>        
        </div>
		<?php

	} //END if ($action=='loantoverify')


if ($action=='scanitem')
	{
		?>
		<BR><H1>ITEMS TO BE LOANED OUT</H1>
		<BR>
        <div align="center">
		<form name="form1" method="post" action="">
	    <input type="hidden" name="action" value="loantoverify">
		<input type="hidden" name="scanitemdata" value="<?php echo $scanitemdata?>">
		<table width="650" border="0">
        <tr>
 				<td align="center" colspan="2"><b>LOAN ITEM DETAILS</b></td>
		</tr>

		<tr>
			<td CLASS="tablebody" align="right">ITEM 1:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fitem1" size="20" maxlength="20" value="<?php echo $_POST["fitem1"]?>"></td>
		</tr>

		<tr>
			<td CLASS="tablebody" align="right">ITEM 2:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fitem2" size="20" maxlength="20" value="<?php echo $_POST["fitem2"]?>"></td>
		</tr>

		<tr>
			<td CLASS="tablebody" align="right">ITEM 3:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fitem3" size="20" maxlength="20" value="<?php echo $_POST["fitem3"]?>"></td>
		</tr>

		<tr>
			<td CLASS="tablebody" align="right">ITEM 4:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fitem4" size="20" maxlength="20" value="<?php echo $_POST["fitem4"]?>"></td>
		</tr>

		<tr>
			<td CLASS="tablebody" align="right">ITEM 5:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fitem5" size="20" maxlength="20" value="<?php echo $_POST["fitem5"]?>"></td>
		</tr>

		<tr>
			<td CLASS="tablebody" align="right">ITEM 6:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fitem6" size="20" maxlength="20" value="<?php echo $_POST["fitem6"]?>"></td>
		</tr>

		<tr>
			<td CLASS="tablebody" align="right">ITEM 7:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fitem7" size="20" maxlength="20" value="<?php echo $_POST["fitem7"]?>"></td>
		</tr>

		<tr>
			<td CLASS="tablebody" align="right">ITEM 8:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fitem8" size="20" maxlength="20" value="<?php echo $_POST["fitem8"]?>"></td>
		</tr>

		<tr>
			<td CLASS="tablebody" align="right">ITEM 9:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fitem9" size="20" maxlength="20" value="<?php echo $_POST["fitem9"]?>"></td>
		</tr>

		<tr>
			<td CLASS="tablebody" align="right">ITEM 10:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fitem10" size="20" maxlength="20" value="<?php echo $_POST["fitem10"]?>"></td>
		</tr>
		<?php
		$ListQuery22 = "SELECT loandaysoverride FROM people WHERE (loginid='".strtolower(@$_SESSION["AUTH_USER_LOGINID"])."')";
		$ListResult22 = @mysql_query($ListQuery22);
		$ListQueryRow22 = @mysql_fetch_array($ListResult22);
		if ($ListQueryRow22["loandaysoverride"]=='1')
			{
		?>
        <tr>
 				<td align="center" colspan="2">&nbsp;</td>
		</tr>
        <tr>
			<td CLASS="tablebody" align="right" valign="middle">Maximum Loan Time <em>(Override)</em>:<BR>FOR ALL ITEMS LISTED ABOVE!</td>
			<td CLASS="tablebody" align="left"><input type="text" name="floanoverride" size="3" maxlength="3" value="<?php echo $_POST["floanoverride"]?>" />&nbsp;day(s)&nbsp;</td>
		</tr>
        
        <?php	
			} //END if ($ListQueryRow22["loandaysoverride"]=='1')

		?>

        <tr>
 				<td align="center" colspan="2">&nbsp;</td>
		</tr>
        <tr>
 				<td align="center" colspan="2"><b>Patron Information</b></td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Staff ID Card or Login ID:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fsid" size="20" maxlength="20" value="<?php echo $_POST["fsid"]?>">&nbsp</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Email Address:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="femail" size="35" maxlength="35" value="<?php echo $_POST["femail"]?>">&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Full Name:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fname" size="35" maxlength="35" value="<?php echo $_POST["fname"]?>">&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Phone Number:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fphone" size="30" maxlength="30" value="<?php echo $_POST["fphone"]?>">&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right" valign="middle">Loan To Notes:<BR><em>(Optional)</em></td>
			<td CLASS="tablebody" align="left"><textarea name="fitemloanedtonotes" cols="50" rows="2"><?php echo $_POST["fitemloanedtonotes"]?></textarea>            
&nbsp;</td>        
        <tr>
 				<td align="center" colspan="2">
                <?php
					if (@$message) 
						print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
				?>&nbsp;
                </td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<input type="submit" name="submit" autofocus="autofocus" default="default" value="Loan Item(s) Out">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="submit" value="Cancel/Exit">
            </td>
		</tr>
		</form>
        </table>
		<?php focus('form1','fsid'); ?>        
        </div>
		<?php
	} // END if ($action=='scanitem')

bottom();
?>