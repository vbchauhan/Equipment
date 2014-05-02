<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
// Get variables
$action=@$_POST["action"]; 					// Check action was a POST variable

if ($action)
	{
	$uid=@$_POST["uid"];
	$submit=@$_POST["submit"];
	$message=@$_POST["message"];
	} // END if ($action)
else
	{
	$uid=@$_GET['uid'];
	$action=@$_GET['action'];
	$submit=@$_GET["submit"];
	$message=@$_GET["message"];
	}

if ($action=='') $action='list'; // If no action the default to "list" groups.

if ($submit=='Exit/Cancel')
	{
	$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/namecache.php";
	Header($redirectstr);
	exit;
	}


if ($action=="addrecord")
	{
	if ((strlen(@$_POST["fstaffid"])>=2) and 
		(strlen(@$_POST["fname"])>=2) and
		(strlen(@$_POST["femail"])>=2) and
		(strlen(@$_POST["fphone"])>=2))
		{
		$LookupQuery="SELECT			
							uid
							staffid,
							email
						FROM namecache WHERE 
								((LOWER(staffid) LIKE '%".@$_POST["fstaffid"]."%') or
								(LOWER(email) LIKE '%".@$_POST["fname"]."%'))";

		$LookupResult = @mysql_query($LookupQuery);
		$LookupNum = mysql_num_rows($LookupResult);
			
		if ($LookupNum<=0)
			{
			$InsertQuery="INSERT INTO namecache SET
								staffid='".strtolower(@$_POST["fstaffid"])."',
								name='".@$_POST["fname"]."',
								email='".@$_POST["femail"]."',
								phone='".@$_POST["fphone"]."',
								tsdate='".date('Y-m-d H:i')."',
								tsdatenumber=".time(date('Y-m-d H:i'));
			$InsertResult = @mysql_query($InsertQuery);		
			if ($InsertResult)
				$message=strtoupper(@$_POST["fstaffid"]).' record has been added';
			else
				$message='ERROR: item '.@$_POST["fstaffid"].' record was not added!!';
			$action='add';
			} //END if ($LookupNum<=0)
		else
			{
			$message='ERROR: This record is already registered in the system!';
			$action='add';
			} //END ELSE if ($LookupNum<=0)
			
		} //END if ((strlen(@$_POST["....))
	else
		{
		$message='You must type in ISTAFFID, NAME, EMAIL and PHONE details to continue!';
		$action='add';
		} //END ELSE if ((strlen(@$_POST["....))
	} //END if ($action=="addloangroup")


if ($action=="updaterecord")
	{
	if ((strlen(@$_POST["fstaffid"])>=2) and 
		(strlen(@$_POST["fname"])>=2) and
		(strlen(@$_POST["femail"])>=2) and
		(strlen(@$_POST["fphone"])>=2))
		{
		$UpdateQuery="UPDATE namecache SET 
					staffid='".strtolower(@$_POST["fstaffid"])."',
					name='".@$_POST["fname"]."',
					email='".@$_POST["femail"]."',
					phone='".@$_POST["fphone"]."',
					tsdate='".date('Y-m-d H:i')."',
					tsdatenumber=".time(date('Y-m-d H:i'))." 
				WHERE (uid='".@$_POST["uid"]."')";
		$UpdateResult = @mysql_query($UpdateQuery);		
		if ($UpdateResult)
			$message=@$_POST["fstaffid"].' record has been updated';
		else
			$message='ERROR: '.@$_POST["staffid"].' record was not updated!!';
		$action='edit';
		} //END if ((strlen(@$_POST["......))
	else
		{
		$message='All No fields can be left blank, You must type in STAFFID, NAME, EMAIL and PHONE details to continue!';
		$action='edit';
		} //END ELSE if ((strlen(@$_POST["......))

	} // END if ($action=="updateloangroup")


if (($action=="delrecord") and (canupdate()))
	{
	// delete related record	
	$query="DELETE FROM namecache WHERE uid='".$uid."'";
	$result = @mysql_query($query);

	// re-direct back to main list
	$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/namecache.php?message=".ucwords(strtolower($_POST["name"]))." (".strtoupper($_POST["staffid"]).") has been deleted.";
	Header($redirectstr);
	exit;
	} //END if (@$Submit==$DeleteButton)


if (($action=="delalloldrecords") and (canupdate()) and ($submit=='DELETE OLD RECORD NOW!'))
	{
	// delete related record
	$OneYearAgoDate=strtotime("-1 year", time());
	if ($OneYearAgoDate>=10000000)
		{
		$query="DELETE FROM namecache WHERE (tsdatenumber<=".$OneYearAgoDate.")";
		$result = @mysql_query($query);
		$NumRows=mysql_affected_rows();
		}
	
	// re-direct back to main list
	$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/namecache.php?message=".$NumRows.' old record(s) have been deleted from the NAMECACHE.';
	Header($redirectstr);
	exit;
	} //END if (@$Submit==$DeleteButton)


if (canupdate())
	{
	top();

	if ($action=='list')
		{
		// build mysql query ----
		$ListQuery = "SELECT uid,staffid,email,name,phone,tsdate,tsdatenumber,ts FROM namecache ORDER BY ts";
		
		// ----------------------
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if ($ListNum>=1)
			{
			?>
           	<H1>Manage Name Cache</H1>
            <div align="center">
	        <TABLE width="700" class="tablebox" cellpadding=2 cellspacing=2 border=0>
				<TR>
					<TD COLSPAN="5" ALIGN="center"><?php
                    	if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
					?>&nbsp;
					</TD>
				</TR>
                    
				<TR>
					<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>StaffID</strong></TD>
					<TD WIDTH="350" class="tableheading" ALIGN="center"><strong>Name</strong></TD>
					<TD WIDTH="350" class="tableheading" ALIGN="center"><strong>Email</strong></TD>
					<TD WIDTH="350" class="tableheading" ALIGN="center"><strong>Phone</strong></TD>                    
                    <TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
				</TR>

				<?php
				for ($i=1; $i<=$ListNum; $i++) 
					{
					$ListRow = @mysql_fetch_array($ListResult);	
					?>				
    		    <TR>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left"><?php echo $ListRow["staffid"]?>&nbsp;</TD>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left"><?php echo $ListRow["name"]?>&nbsp;</TD>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left"><?php echo $ListRow["email"]?>&nbsp;</TD>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left"><?php echo $ListRow["phone"]?>&nbsp;</TD>

                    <TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="center">
					<FORM NAME="form1" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="edit">
						<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $ListRow["uid"]?>">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="EDIT">
					</FORM>                    
 	    	        </TD>


					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="center">
					<FORM NAME="form1" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="del">
						<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $ListRow["uid"]?>">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="DELETE">
					</FORM>                    
 	    	        </TD>
				</TR>
					<?php
					} //END for ($i=1; $i<=$ListNum; $i++) 
					?>

	            <TR>
					<TD COLSPAN="4" ALIGN="left"><em><?php print $ListNum?>&nbsp;Record(s) Listed Above</em>&nbsp;</TD>
					<TD class="tableheading" valign="middle" ALIGN="center" colspan="2">
					<FORM NAME="form3" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="add">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="ADD NEW RECORD">
					</FORM>                    
	            </TR>
			</TABLE>
            <BR>
			<FORM NAME="form3" METHOD="post" ACTION="">
				<INPUT TYPE="hidden" NAME="action" VALUE="delold">
		   	    <INPUT TYPE="submit" NAME="submit" VALUE="DELETE RECORDS THAT ARE OLDER THAN 1 YEAR">
			</FORM>               
            </div>
			<?php
			} //END if ($ListNum>=1)
		else
			{
			?>
           	<H1>Manage Loan Groups</H1>
            <div align="center">
	        <TABLE width="700" class="tablebox" cellpadding=2 cellspacing=2 border=0>
				<TR>
					<TD COLSPAN="5" ALIGN="center"><?php
                    	if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
					?>&nbsp;
					</TD>
				</TR>
                    
				<TR>
					<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>StaffID</strong></TD>
					<TD WIDTH="350" class="tableheading" ALIGN="center"><strong>Name</strong></TD>
					<TD WIDTH="350" class="tableheading" ALIGN="center"><strong>Email</strong></TD>
					<TD WIDTH="350" class="tableheading" ALIGN="center"><strong>Phone</strong></TD>                    
                    <TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
				</TR>
    		    <TR>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left" colspan="6"><em>NO RECORDS FOUND</em>&nbsp;</TD>
	            <TR>
	            <TR>
					<TD COLSPAN="4" ALIGN="left"><em><?php print $ListNum?>&nbsp;Record(s) Listed Above</em>&nbsp;</TD>
					<TD class="tableheading" valign="middle" ALIGN="center" colspan="2">
					<FORM NAME="form3" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="add">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="ADD NEW RECORD">
					</FORM>                    
	            </TR>
			</TABLE>
            </div>

	<?php			
			} //END ELSE if ($ListNum>=1)
		} // END if ($action=='list')


	if (($action=='add') or ($action=='edit'))
		{
		if (($action=='add') and (!$submit))
			{
			$vstaffid='';
			$vname='';
			$vemail='';
			$vphone='';
			}

		if (($action=='add') and ($submit))
			{
			$vstaffid=@$_POST['fstaffid'];
			$vname=@$_POST['fname'];
			$vemail=@$_POST['femail'];
			$vphone=@$_POST['fphone'];
			}

		if ($action=='edit')
			{
			$EditQuery = "SELECT
								uid,
								staffid,
								name,
								email,
								phone,
								tsdate
							FROM namecache WHERE uid='".$uid."'";
			$EditResult = @mysql_query($EditQuery);
			$EditNum = mysql_num_rows($EditResult);
			if ($EditNum>=1)
				{
				$EditRows = @mysql_fetch_array($EditResult);
				$vstaffid=$EditRows["staffid"];
				$vname=$EditRows["name"];
				$vemail=$EditRows["email"];
				$vphone=$EditRows["phone"];
				$vLastUpdated=$EditRows["tsdate"];
				}
			} // END if ($action=='edit')		
	

		if ($action=="add") print '<H1>ADD A NEW RECORD</H1>';
		if ($action=="edit") print '<H1>UPDATE RECORD DETAILS</H1>';
        ?>
		<FORM NAME="form1" METHOD="post" ACTION="" ENCTYPE="multipart/form-data">
		<?php
		if ($action=="add") print '<INPUT TYPE="hidden" NAME="action" VALUE="addrecord">';
		if ($action=="edit") print '<INPUT TYPE="hidden" NAME="action" VALUE="updaterecord">';
		?>
		<INPUT TYPE="hidden" NAME="uid" VALUE="<?php print $uid;?>">
		<DIV align="center">
        <TABLE BORDER="0" WIDTH="600">
  			<TR> 
				<TD colspan="2" align="center"><?php if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';?>&nbsp;</TD>
			</TR>
			<TR> 
				<TD nowrap WIDTH="250" CLASS="tablebody" align="right"><B>Staff ID *:</B></TD>
				<TD WIDTH="300" CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="fstaffid" MAXLENGTH="15" SIZE="15" VALUE="<?php echo $vstaffid?>">
				</TD>
			</TR>

			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>Name *:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="fname" MAXLENGTH="40" SIZE="40" VALUE="<?php echo $vname?>">
				</TD>
			</TR>

			<TR> 
				<TD nowrap WIDTH="250" CLASS="tablebody" align="right"><B>Email *:</B></TD>
				<TD WIDTH="300" CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="femail" MAXLENGTH="128" SIZE="40" VALUE="<?php echo $vemail?>">
				</TD>
			</TR>

			<TR> 
				<TD nowrap WIDTH="250" CLASS="tablebody" align="right"><B>Phone *:</B></TD>
				<TD WIDTH="300" CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="fphone" MAXLENGTH="40" SIZE="40" VALUE="<?php echo $vphone?>">
				</TD>
			</TR>
			<?php
			if ($action=="edit") 
				{
			?>
			<TR> 
				<TD nowrap WIDTH="250" CLASS="tablebody" align="right"><B>Last DateTime Record updated:</B></TD>
				<TD WIDTH="300" CLASS="tablebody" align="left"><?php echo $vLastUpdated?></TD>
			</TR>
        	<?php
				} //END	if ($action=="edit") 
			?>

  			<TR> 
				<TD colspan="2" align="center"><em><b>* THESE FIELDS MUST NOT BE LEFT BLANK</b></em></TD>
			</TR>

			<TR ALIGN="left"> 
				<TD nowrap colspan="2" align="center">
              <INPUT TYPE="submit" NAME="submit" VALUE="Exit/Cancel">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <INPUT TYPE="submit" NAME="submit" VALUE="<?php
			  	if ($action=="add") print 'ADD RECORD';
				if ($action=="edit") print 'SAVE UPDATES';
				?>">
    	        </TD>
        	</TR>
          
  			<TR> 
				<TD colspan="2">&nbsp;</TD>
			</TR>
            
        </TABLE>
        </DIV>
		</FORM>
		<?php
		} //END if (($action=='add') or ($action=='edit'))


	if (($action=='del'))
		{
			
		$LookupQuery = "SELECT 
							uid,
							staffid,
							name,
							email,
							phone
						FROM 
							namecache 
						WHERE 
							uid='".$uid."'";

		$LookupResult = @mysql_query($LookupQuery);
		$LookupNum = mysql_num_rows($LookupResult);			
		$LookupRows = @mysql_fetch_array($LookupResult);
		?>
		<H1>DELETE A NAME CACHE RECORD</H1>
	    <BR>
		<p align="center">Are you sure you want to delete the following record?</p>
        <div align="center">
		<form name="form1" method="post" action="">
		<INPUT TYPE="hidden" NAME="action" VALUE="delrecord">
		<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
		<INPUT TYPE="hidden" NAME="staffid" VALUE="<?php echo $LookupRows["staffid"];?>">  
		<INPUT TYPE="hidden" NAME="name" VALUE="<?php echo $LookupRows["name"];?>">                
		<INPUT TYPE="hidden" NAME="loangroup" VALUE="<?php echo $LookupRows["loangroup"];?>">        
        <table width="500" cellspacing="2" cellpadding="2" align="center">

			<tr valign="middle"> 
				<td width="200" nowrap align="right" CLASS="tablebody"><b>Staff ID:</b></td>
				<td width="300" nowrap align="left" CLASS="tablebody">
					<?php print $LookupRows["staffid"];?>&nbsp;
				</td>
			</tr>

			<tr valign="middle"> 
				<td nowrap align="right" CLASS="tablebody"><b>Name:</b></td>
				<td nowrap align="left" CLASS="tablebody">
					<?php print $LookupRows["name"];?>&nbsp;
				</td>
			</tr>

			<tr valign="middle"> 
				<td nowrap align="right" CLASS="tablebody"><b>Email:</b></td>
				<td align="left" CLASS="tablebody">
					<?php print $LookupRows["email"];?>&nbsp;
				</td>
			</tr>
        
			<tr valign="middle"> 
				<td nowrap colspan="2" >&nbsp;</td>
			</tr>
        
			<tr valign="middle"> 
				<td nowrap align="center" colspan="2" >
            	    <INPUT TYPE="submit" NAME="submit" VALUE="<?php print 'Exit/Cancel'?>">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<INPUT TYPE="submit" name="submit" value="<?php print 'DELETE THIS RECORD'?>">
				</td>
			</tr>
		</table>
		</form>	 
		</div>
		<?php
		} //END if ($action=='del')


	if (($action=='delold'))
		{
		?>
		<H1>DELETE RECORDS THAT ARE OLDER THAN 1 YEAR?</H1>
	    <BR>
        <div align="center">
  		<form name="form1" method="post" action="">
		<INPUT TYPE="hidden" NAME="action" VALUE="delalloldrecords">
        <table width="500" cellspacing="2" cellpadding="2" align="center">

			<tr valign="middle"> 
				<td width="500" nowrap align="right" CLASS="tablebody"><b>Are you sure you want to delete all records in the namecache that are older thay 1 year?</b></td>
				</td>
			</tr>
        
			<tr valign="middle"> 
				<td nowrap colspan="2" >&nbsp;</td>
			</tr>
        
			<tr valign="middle"> 
				<td nowrap align="center" colspan="2" >
            	    <INPUT TYPE="submit" NAME="submit" VALUE="<?php print 'Exit/Cancel'?>">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<INPUT TYPE="submit" name="submit" value="<?php print 'DELETE OLD RECORD NOW!'?>">
				</td>
			</tr>
		</table>
		</form>	 
		</div>
		<?php
		} //END if ($action=='del')


	bottom();
	
	} // END if (canupdate()
else
	{ // if person is not allowed to access page throw up a 404 error
	header("HTTP/1.0 404 Not Found");
	exit;
	}


// end of file people.php
?>




