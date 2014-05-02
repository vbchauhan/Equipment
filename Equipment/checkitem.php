<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
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

if (($action=='loanitemout') and ($submit=='BACK'))
	{
	$action='scanitem';
	}

if ($action=='loanto')
	{
	if ($submit=='Cancel/Exit')
		{
		$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/";
		Header($redirectstr);
		exit;
		} //END if ($submit=='Cancel/Exit')

	if ($submit=='Loan Item Out')
		{
		$LookupStr=lookupperson(@$_POST["fsid"],@$_POST["femail"],@$_POST["fname"],@$_POST["fphone"],@$_POST["institution"]);
		$LookupStrArr=explode(',',$LookupStr); //0=staffid,1=email,2=name,3=phone,4=isstaffmemeber
		$vinstitution= $_POST["institution"]; // will capture the institution  from the submitted form
		$vprogram= $_POST["program"];// will capture the program  from the submitted form
	
		if (strlen($LookupStr)>=2)
			{
			$LookupQueryRow = @mysql_fetch_array($LookupResult);
			$vsid=$LookupStrArr["0"];
			$vemail=$LookupStrArr["1"];
			$vname=$LookupStrArr["2"];
			$vphone=$LookupStrArr["3"];
			$vinstitution=$LookupStrArr["4"];
			$visstaffmemeber=$LookupStrArr["5"];
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


if ($action=='returnitem')
	{
	if ($submit<>'Cancel/Exit')
		{
		$ListQuery = "SELECT * FROM loansystem WHERE itembarcode='".@$_POST["scanitemdata"]."'";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		$ListQueryRow = @mysql_fetch_array($ListResult);
		$ItemStatus=loanstatus($ListQueryRow["warningamber"],$ListQueryRow["warningred"],$ListQueryRow["loanoverride"],$ListQueryRow["itemloandatestart"]);		
			
		$UpdateQuery="UPDATE loansystem SET 
					itemloanflag='0',
					loanoverride=null,
					itemloanedtoname=null,
					itemloanedtologinid=null,
					itemloanedtoemail=null,
					itemloanedtophone=null,
					itemloanedtoinstitution=null,
					itemloanedtonotes=null,					
					itemloandatestart=null,
					itemlastcheckedoutbyname=null,
					itemlastcheckedoutbyloginid=null,
					itemlastcheckedindate='".date('Y-m-d')."',
					itemlastcheckedinbyname='".ucwords(strtolower(@$_SESSION["AUTH_USER_NAME"]))."',
					itemlastcheckedinbyloginid='".strtoupper(@$_SESSION["AUTH_USER_LOGINID"])."' 
				WHERE (itembarcode='".@$_POST["scanitemdata"]."')";			
		$UpdateResult = @mysql_query($UpdateQuery);		
		if (@$UpdateResult)
			{
			$message=@$_POST["scanitemdata"].' was successfully returned';

			
			if ($ItemStatus=='green')
				{
				$vreturnstatus='green';
				$vitemreturnstatusnumber=1;
				}
			if ($ItemStatus=='amber')
				{
				$vreturnstatus='amber';
				$vitemreturnstatusnumber=2;
				}
			if ($ItemStatus=='red')
				{
				$vreturnstatus='red';
				$vitemreturnstatusnumber=3;
				}
			
			$vdaysonloan=dateDiff($ListQueryRow["itemloandatestart"],date("Y-m-d"));
			
			// Write Transaction Record to loansystemlog.
			$querylog="INSERT INTO loansystemlogs SET 
						actiondatetime = '".date('Y-m-d H:i')."',
						action = 'checkinitem',
						loangroup = '".$ListQueryRow["loangroup"]."',
						loanitemshorttitle = '".$ListQueryRow["shortitemtitle"]."',
						loanitembarcode = '".$ListQueryRow["itembarcode"]."',
						loantoname = '".$ListQueryRow["itemloanedtoname"]."',
						loantoinstitution='".$ListQueryRow["itemloanedtoinstitution"]."',
						loantologinid = '".$ListQueryRow["itemloanedtologinid"]."',
						loantoemail = '".$ListQueryRow["itemloanedtoemail"]."',
						loantophone = '".$ListQueryRow["itemloanedtophone"]."',
						itemloandatestart = '".date('Y-m-d')."',
						daysitemwasonloan = ".$vdaysonloan.",
						itemreturnstatus = '".$vreturnstatus."',
						itemreturnstatusnumber = ".$vitemreturnstatusnumber.",
						adminname = '".ucwords(strtolower(@$_SESSION["AUTH_USER_NAME"]))."',
						adminloginid = '".strtoupper(@$_SESSION["AUTH_USER_LOGINID"])."',
						adminip = '".$_SERVER["REMOTE_ADDR"]."',
						admindns = '".@gethostbyaddr($_SERVER["REMOTE_ADDR"])."',
						notes = 'AmberAlert=".$ListQueryRow["warningamber"].", RedAlert=".$ListQueryRow["warningred"].", LoanOverride=".$ListQueryRow["loanoverride"]."'";
			
			$resultlog = @mysql_query($querylog);			
			}
		else
			$message='ERROR: item '.@$_POST["scanitemdata"].' was not returned!!';		
		
		$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/index.php?message=".$message."";
		Header($redirectstr);
		exit;	
		} //END if ($submit<>'Cancel/Exit')
	else
		{
		$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/";
		Header($redirectstr);
		exit;	
		} //END ELSE if ($submit<>'Cancel/Exit')
	} //END if ($action=='returnitem')


if ($action=='loanitemout')
	{
	if ($submit<>'Cancel/Exit')
		{
		$LookupStr=lookupperson(@$_POST["fsid"],@$_POST["femail"],@$_POST["fname"],@$_POST["fphone"]);
		$LookupStrArr=explode(',',$LookupStr); //0=staffid,1=email,2=name,3=phone,4=isstaffmemeber,5=uid
		$vinstitution=$_POST["institution"];
		$vprogram=$_POST["program"];
		if (strlen($LookupStr)<=2)
			{
			// Add this persons details to the namecache
			$InsertQuery="INSERT INTO namecache SET
								staffid='".strtolower(@$_POST["vsid"])."',
								name='".ucwords(strtolower(@$_POST["vname"]))."',
								email='".strtolower(@$_POST["vemail"])."',
								institution='".strtolower(@$_POST["institution"])."',
								phone='".@$_POST["vphone"]."',
								tsdate='".date('Y-m-d H:i')."',
								tsdatenumber=".time(date('Y-m-d H:i'));
			$InsertResult = @mysql_query($InsertQuery);	
			} //END if (strlen($LookupStr)<=2)
		else
			{
			if ($LookupStrArr["4"]=='0')
				{
				$InsertQuery="UPDATE namecache SET
									tsdate='".date('Y-m-d H:i')."',
									tsdatenumber=".time(date('Y-m-d H:i'))." 
									WHERE uid=".$LookupStrArr["5"];
				$InsertResult = @mysql_query($InsertQuery);	
				} //END if ($LookupStrArr["4"]=='0')
			} //END ELSE if (strlen($LookupStr)<=2)
			
		$ListQuery = "SELECT * FROM loansystem WHERE itembarcode='".@$_POST["scanitemdata"]."'";
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		$ListQueryRow = @mysql_fetch_array($ListResult);		

		$ListQuery22 = "SELECT loandaysoverride FROM people WHERE (loginid='".strtolower(@$_SESSION["AUTH_USER_LOGINID"])."')";
		$ListResult22 = @mysql_query($ListQuery22);
		$ListQueryRow22 = @mysql_fetch_array($ListResult22);
		if ($ListQueryRow22["loandaysoverride"]=='1')
			{
			if (strlen(@$_POST["floanoverride"])>=1) 
				$LoanOverrideStr='loanoverride='.@$_POST["floanoverride"].',';
			else
				$LoanOverrideStr='';			
			}
		else
			$LoanOverrideStr='';
		
		$UpdateQuery="UPDATE `loansystem` SET 
					itemloanflag='1',
					".$LoanOverrideStr."
					itemloanedtoname='".@$_POST["vname"]."',
					itemloanedtologinid='".@$_POST["vsid"]."',
					itemloanedtoemail='".@$_POST["vemail"]."',
					itemloanedtophone='".@$_POST["vphone"]."',
					itemloanedtoinstitution='".$vinstitution."',
					itemloanedtoprogram='".$vprogram."',
					itemloandatestart='".date('Y-m-d')."',
					itemloanedtonotes='".@$_POST["fitemloanedtonotes"]."',					
					itemlastcheckedoutbyname='".ucwords(strtolower(@$_SESSION["AUTH_USER_NAME"]))."',
					itemlastcheckedoutbyloginid='".strtoupper(@$_SESSION["AUTH_USER_LOGINID"])."',
					itemlastcheckedindate='',
					itemlastcheckedinbyname='',
					itemlastcheckedinbyloginid='' 
				WHERE ((itembarcode='".@$_POST["scanitemdata"]."') and 
						(itemvisible='1') )";			

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
				loantoinstitution='".@$_POST["institution"]."',
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
				notes = 'AmberAlert=".$ListQueryRow["warningamber"].", RedAlert=".$ListQueryRow["warningred"].", LoanOverride=".@$_POST["floanoverride"]."'";
	$resultlog = @mysql_query($querylog);
			}
		else
			$message='ERROR: item '.@$_POST["scanitemdata"].' was not checked out!!';	
		$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/index.php?message=".$message."";
		Header($redirectstr);
		exit;	
		} //END if ($submit<>'Cancel/Exit')
	else
		{
		$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/";
		Header($redirectstr);
		exit;	
		} //END ELSE if ($submit<>'Cancel/Exit')
	} //END if ($action=='loanitemout')


top();

if ($action=='loantoverify')
	{
	$ListQuery = "SELECT
						itemloanflag,
						itembarcode,
						itemtitle,
						itemdescription,
						itemserial,
						itemmodel,
						warningred,
						itemloanedtologinid,
						itemloanedtoname,
						itemloanedtoemail,
						itemloanedtophone,
						itemloandatestart
				FROM loansystem WHERE ((itembarcode='".$scanitemdata."') and (itemvisible='1') and (loangroup='".@$_SESSION["LOANSYSTEM_GROUP"]."'))";

	$ListResult = @mysql_query($ListQuery);
	$ListNum = mysql_num_rows($ListResult);
	$ListQueryRow = @mysql_fetch_array($ListResult);
	
	if (@$_POST["floanoverride"]>=1)
		$LoanDaysStr=@$_POST["floanoverride"];
	else
		$LoanDaysStr=$ListQueryRow['warningred'];

	
	?>
	<BR><H1>THIS ITEM IS TO BE LOANED OUT TO "<?php echo strtoupper($vname)?>"</H1>
	<BR>
	<div align="center">
	<form name="form1" method="post" action="">
	<input type="hidden" name="action" value="loanitemout">
	<input type="hidden" name="scanitemdata" value="<?php echo $scanitemdata?>">
	<input type="hidden" name="floanoverride" value="<?php echo @$_POST["floanoverride"]?>">
	<input type="hidden" name="vsid" value="<?php echo $vsid?>">    
	<input type="hidden" name="vemail" value="<?php echo $vemail?>">    
	<input type="hidden" name="vname" value="<?php echo $vname?>">    
	<input type="hidden" name="vphone" value="<?php echo $vphone?>">    
	<input type="hidden" name="fsid" value="<?php echo @$_POST["fsid"]?>">    
	<input type="hidden" name="femail" value="<?php echo @$_POST["femail"]?>">    
	<input type="hidden" name="fname" value="<?php echo @$_POST["fname"]?>">    
	<input type="hidden" name="fphone" value="<?php echo @$_POST["fphone"]?>">
	<!-- Ambarish Start-->
	<input type="hidden" name="institution" value="<?php echo @$_POST["institution"]?>">
	<input type="hidden" name="program" value="<?php echo @$_POST["program"]?>">
	<!-- Ambarish Ends-->
	<input type="hidden" name="fitemloanedtonotes" value="<?php echo @$_POST["fitemloanedtonotes"]?>">    
	<table width="750" border="0">
	<tr>
		<td align="center" colspan="2"><b>LOAN ITEM DETAIL</b></td>
	</tr>
	<tr>
		<td width="250" CLASS="tablebody" align="right">Barcode:</td>
		<td width="400" CLASS="tablebody" align="left"><?php echo @$ListQueryRow['itembarcode']?>&nbsp;</td>
	</tr>
	<tr>
		<td CLASS="tablebody" align="right">Item Name:</td>
		<td CLASS="tablebody" align="left"><?php echo @$ListQueryRow['itemtitle']?>&nbsp;</td>
	</tr>
	<tr>
		<td CLASS="tablebody" align="right">Maximum Loan Time:</td>
		<td CLASS="tablebody" align="left"><?php echo $LoanDaysStr?>&nbsp;day(s)&nbsp;&nbsp;(Due Back:&nbsp;<?php 
		print date("d-M-Y",strtotime("+".$LoanDaysStr." days"));
		
		?>)</td>
	</tr>
	<tr>
 		<td align="center" colspan="2">&nbsp;</td>
	</tr>
	<tr>
 		<td align="center" colspan="2"><b>Patron Information</b></td>
	</tr>
	<tr>
		<td CLASS="tablebody" align="right">Staff ID Card or Login ID:</td>
		<td CLASS="tablebody" align="left"><?php echo $vsid?>&nbsp</td>
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
		<td CLASS="tablebody" align="left"><?php echo $vphone?>&nbsp;</td>
	</tr>
	<!--Ambarish code Starts-->
	<tr>
		<td CLASS="tablebody" align="right">Institution:</td>
		<td CLASS="tablebody" align="left"><?php echo $vinstitution;?>&nbsp;</td>
	</tr>
	<tr>
		<td CLASS="tablebody" align="right">Program:</td>
		<td CLASS="tablebody" align="left"><?php echo $vprogram;?>&nbsp;</td>
	</tr>
	<!--Ambarish code Ends-->
	<?php
	if (strlen(@$_POST["fitemloanedtonotes"])>=1)
		{
		?>
    <tr>
		<td CLASS="tablebody" align="right" valign="middle">Loan To Notes:<BR><em>(Optional)</em></td>
		<td CLASS="tablebody" align="left"><?php echo @$_POST["fitemloanedtonotes"]?>&nbsp;</td>
	</tr>
		<?php
		} // END 	if (strlen(@$_POST["fitemloanedtonotes"])>=1))
		?>
	<tr>
 		<td align="center" colspan="2">
			<?php
			if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
			?>&nbsp;
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<input type="submit" name="submit" value="LOAN ITEM TO <?php echo strtoupper($vname)?>">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="submit" value="BACK">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php

			$ListQuery44 = "SELECT shortitemtitle FROM loansystem WHERE LOWER(itembarcode)='".strtolower(@$ListQueryRow['itembarcode'])."'";
			$ListResult44 = @mysql_query($ListQuery44);
			$ListNum44 = mysql_num_rows($ListResult44);
			$ListQueryRow44 = @mysql_fetch_array($ListResult44);	
			if ($ListNum44>=1) $loanitemsliststr=$ListQueryRow44["shortitemtitle"].'('.@$ListQueryRow['itembarcode'].')';

			$emailtostr=$vemail.';'.$_SESSION["AUTH_USER_EMAIL"];
			$emailsubjectstr=$loanitemsliststr.' was loaned to '.$vname.' on the '.date('d-M-Y');
			$emailbodystr=$loanitemsliststr.' was loaned to '.$vname.' on the '.date('d-M-Y').' and is due back on the '.date("d-M-Y",strtotime("+".$LoanDaysStr." days")).'.';
			$MailToStr='mailto:'.$emailtostr.'?subject='.$emailsubjectstr.'&body='.$emailbodystr;
			?>
            <a href="<?php echo $MailToStr?>" target="_new" style="text-decoration: none">SEND EMAIL RECEIPT</a>
		</td>
	</tr>
	</form>
	</table>
	</div>
	<?php
	} //END if ($action=='loantoverify')


if ($action=='scanitem')
	{
	$ListQuery = "SELECT
						itemloanflag,
						itembarcode,
						itemtitle,
						itemdescription,
						itemserial,
						itemmodel,
						warningred,
						itemloanedtologinid,
						itemloanedtoname,
						itemloanedtoemail,
						itemloanedtophone,
						itemloandatestart
				FROM loansystem WHERE ((itembarcode='".$scanitemdata."') and (itemvisible='1') and (loangroup='".@$_SESSION["LOANSYSTEM_GROUP"]."'))";

	$ListResult = @mysql_query($ListQuery);
	$ListNum = mysql_num_rows($ListResult);
	$ListQueryRow = @mysql_fetch_array($ListResult);
	
	if ($ListNum<=0)
		{
		// ITEM NOT FOUND IN CURRENT LOAN GROUP
		$redirectstr="Location: /".strtolower($_SESSION["SystemNameStr"])."/index.php?message=Invalid Item";
		Header($redirectstr);
		exit;
		}

	if ($ListQueryRow['itemloanflag']==0)
		{
		// ITEM CAN BE LOANED OUT
		?>
		<BR><H1>ITEM TO BE LOANED OUT</H1>
		<BR>
        <div align="center">
		<form name="form1" method="post" action="">
	    <input type="hidden" name="action" value="loanto">
		<input type="hidden" name="scanitemdata" value="<?php echo $scanitemdata?>">
		<table width="650" border="0">
        <tr>
 				<td align="center" colspan="2"><b>LOAN ITEM DETAIL</b></td>
		</tr>
		<tr>
			<td width="270" CLASS="tablebody" align="right">Barcode:</td>
			<td width="350" CLASS="tablebody" align="left"><?php echo @$ListQueryRow['itembarcode']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Item Name:</td>
			<td CLASS="tablebody" align="left"><?php echo @$ListQueryRow['itemtitle']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Maximum Loan Time:</td>
			<td CLASS="tablebody" align="left"><?php echo @$ListQueryRow['warningred']?>&nbsp;day(s)&nbsp;</td>
		</tr>
		
		<?php
		$ListQuery = "SELECT loandaysoverride FROM people WHERE (loginid='".strtolower(@$_SESSION["AUTH_USER_LOGINID"])."')";
		$ListResult = @mysql_query($ListQuery);
		//$ListNum = mysql_num_rows($ListResult);
		$ListQueryRow = @mysql_fetch_array($ListResult);
		if ($ListQueryRow["loandaysoverride"]=='1')
			{
		?>
		<tr>
			<td CLASS="tablebody" align="right">Maximum Loan Time <em>(Override)</em>:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="floanoverride" size="3" maxlength="3" value="" />&nbsp;day(s)&nbsp;</td>
		</tr>
		<?php
			} //END if ($ListQueryRow=='1')
		?>

        <tr>
 				<td align="center" colspan="2">&nbsp;</td>
		</tr>
        <tr>
 				<td align="center" colspan="2"><b>Patron Information</b></td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Staff ID Card or Login ID:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fsid" size="20" maxlength="20" value="<?php echo @$_POST["fsid"]?>">&nbsp</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Email Address:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="femail" size="35" maxlength="35" value="<?php echo @$_POST["femail"]?>">&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Full Name: (eg. John Smith)</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fname" size="35" maxlength="35" value="<?php echo @$_POST["fname"]?>">&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Phone Number:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="fphone" size="30" maxlength="30" value="<?php echo @$_POST["fphone"]?>">&nbsp;</td>
		</tr>
		<!-- Ambarish code starts-->
		<tr>
			<td CLASS="tablebody" align="right">Institution:</td>
			<td CLASS="tablebody" align="left">	
				<select name="institution">
				<?php 
	// Build the query
				$query = "SELECT institutionId,institutionName FROM institution ORDER BY institutionName ASC";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
				echo '<option value="'.$row['institutionName'].'" selected="selected">'.$row['institutionName'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Program:</td>
			<td CLASS="tablebody" align="left"><input type="text" name="program" size="35" maxlength="35" value="<?php echo @$_POST["program"]?>">&nbsp;</td>
		</tr>
		<!-- the code ends here -->
		
		<tr>
			<td CLASS="tablebody" align="right" valign="middle">Loan To Notes:<BR><em>(Optional)</em></td>
			<td CLASS="tablebody" align="left"><textarea name="fitemloanedtonotes" cols="50" rows="2"><?php echo @$_POST["fitemloanedtonotes"]?></textarea>            
&nbsp;</td>
		</tr>
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
				<input type="submit" name="submit" autofocus="autofocus" default="default" value="Loan Item Out">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="submit" value="Cancel/Exit">
            </td>
		</tr>
		</form>
        </table>
		<?php focus('form1','fsid'); ?>        
        </div>
		<?php
		}
	else
		{
		// ITEM IS ALREADY OUT ON LOAN (ITS BEING RETURNED)
		?>
		<BR><H1>DO YOU WANT TO RETURN THIS ITEM?</H1>
        <?php
		$ListQuery = "SELECT
							loangroup,
							itemloanflag,
							itembarcode,
							itemtitle,
							itemdescription,
							itemserial,
							itemmodel,
							warningamber,
							warningred,
							loanoverride,
							itemloanedtologinid,
							itemloanedtoname,
							itemloanedtoemail,
							itemloanedtophone,
							itemloanedtonotes,
							itemloandatestart
					FROM loansystem WHERE ((itembarcode='".$scanitemdata."') and (itemvisible='1') and (loangroup='".@$_SESSION["LOANSYSTEM_GROUP"]."'))";

		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		$ListQueryRow = @mysql_fetch_array($ListResult);
		$ItemStatus=loanstatus($ListQueryRow["warningamber"],$ListQueryRow["warningred"],$ListQueryRow["loanoverride"],$ListQueryRow["itemloandatestart"]);	
		?>
		<BR>
		<div align="center">
		<form name="form1" method="post" action="">
		<input type="hidden" name="action" value="returnitem">
		<input type="hidden" name="scanitemdata" value="<?php echo $scanitemdata?>">
		<table width="650" border="0">
		<tr>
			<td align="center" colspan="2"><b>LOAN ITEM DETAIL</b></td>
		</tr>
		<tr>
			<td width="250" CLASS="tablebody" align="right">Barcode:</td>
			<td width="400" CLASS="tablebody" align="left"><?php echo @$ListQueryRow['itembarcode']?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Item Name:</td>
			<td CLASS="tablebody" align="left"><?php echo @$ListQueryRow['itemtitle']?>&nbsp;</td>
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
		<tr>
			<td CLASS="tablebody" align="right">Total days currently on Loan:</td>
			<td CLASS="tablebody" align="left"><?php
				if ($ItemStatus=='green') print '<b class="GreenAlertText">';
				if ($ItemStatus=='amber') print '<b class="AmberAlertText">';
				if ($ItemStatus=='red') print '<b class="RedAlertText">';
				print '&nbsp'.dateDiff($ListQueryRow["itemloandatestart"],date("Y-m-d"));
				?>&nbsp;day(s)&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Loan Group:</td>
			<td CLASS="tablebody" align="left"><?php echo @$ListQueryRow['loangroup']?>&nbsp;</td>
		</tr>
		<tr>
 			<td align="center" colspan="2">&nbsp;</td>
		</tr>
		<tr>
 			<td align="center" colspan="2"><b>LOAN TO DETAILS</b></td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Staff ID Card or Login ID:</td>
			<td CLASS="tablebody" align="left"><?php echo @$ListQueryRow["itemloanedtologinid"]?>&nbsp</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Email Address:</td>
			<td CLASS="tablebody" align="left"><?php echo @$ListQueryRow["itemloanedtoemail"]?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Full Name:</td>
			<td CLASS="tablebody" align="left"><?php echo @$ListQueryRow["itemloanedtoname"]?>&nbsp;</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Phone Number:</td>
			<td CLASS="tablebody" align="left"><?php echo @$ListQueryRow["itemloanedtophone"]?>&nbsp;</td>
		</tr>
		<?php
		if (strlen(@$ListQueryRow["itemloanedtonotes"])>=1)
			{
		?>
	    <tr>
			<td CLASS="tablebody" align="right" valign="middle">Loan To Notes:<BR><em>(Optional)</em></td>
			<td CLASS="tablebody" align="left"><?php echo @$ListQueryRow["itemloanedtonotes"]?>&nbsp;</td>
		</tr>
		<?php
			} // END 	if (strlen(@$_POST["fitemloanedtonotes"])>=1))
		?>
		<tr>
 			<td align="center" colspan="2">
			<?php
			if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
			?>&nbsp;
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<input type="submit" name="submit" value="Cancel/Exit">
        	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="submit" value="RETURN ITEM BACK INTO LOAN SYSTEM">
			</td>
		</tr>
		</form>
		</table>
		</div>
       
        <?php
		}
	} // END if ($action=='scanitem')

bottom();
?>
