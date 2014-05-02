<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
if (canupdate()) 
	{

	// Get variables
	$Submit=@$_POST["Submit"]; // Check if a file upload form has been submitted

	// Define Form Button Names
	$ButtonAdd='Add Person';
	$ButtonEdit='Save Changes';
	$ExitButton='Exit/Cancel';
	$DeleteButton='Delete Person';
	$DeleteExitButton='Exit Without Deleting';

	if ($Submit)
		{
		$action=@$_POST["action"];					// action (add,edit,delete)
		$uid=@$_POST["uid"];						// Long Unique File ID String (40 Chars Long)
		$fdel=@$_POST["fdel"];						// Delete File Flag
		$floginid=@$_POST["floginid"];				// Login ID
		$fpw=@$_POST["fpw"];						// Login Password
		$ffirstname=@$_POST["ffirstname"];			// First Name
		$flastname=@$_POST["flastname"];			// Last Name (Sirname)
		$femail=@$_POST["femail"];					// Email Address
		$fphone=@$_POST["fphone"];					// Phone Number
		$fproxycardno=@$_POST["fproxycardno"];		// Proxy Card Number
		$fbarcode=@$_POST["fbarcode"];				// Barcode Card Number
		$faccesslevel=@$_POST["faccesslevel"];		// User Access Level
		$flogindisabled=@$_POST["flogindisabled"];	// Login Disabled Status
		$SortOrder=@$_POST["sortorder"];			// Sort by column
		$vloandaysoverride = @$_POST["floandaysoverride"];
		$vbulkloanitems = @$_POST["fbulkloanitems"];
		$loandaysoverride = @$_POST["floandaysoverride"];
		$bulkloanitems = @$_POST["fbulkloanitems"];
		}
	else
		{
		if (strlen(@$_POST["action"])>=2)
			{
			$action=@$_POST["action"];					// action (add,edit,delete)
			$uid=@$_POST["uid"];						// Long Unique File ID String (40 Chars Long)
			$fdel=@$_POST["fdel"];						// Delete File Flag
			$floginid=@$_POST["floginid"];				// Login ID
			$fpw=@$_POST["fpw"];						// Login Password
			$ffirstname=@$_POST["ffirstname"];			// First Name
			$flastname=@$_POST["flastname"];			// Last Name (Sirname)
			$femail=@$_POST["femail"];					// Email Address
			$fphone=@$_POST["fphone"];					// Phone Number
			$fproxycardno=@$_POST["fproxycardno"];		// Proxy Card Number
			$fbarcode=@$_POST["fbarcode"];				// Barcode Card Number
			$faccesslevel=@$_POST["faccesslevel"];		// User Access Level
			$flogindisabled=@$_POST["flogindisabled"];	// Login Disabled Status
			$SortOrder=@$_POST["sortorder"];			// Sort by column					
			}
		else
			{
			$action=@$_GET["action"];			// action (add,edit,delete)
			$uid=@$_GET["uid"]; 				// Long Unique File ID String (40 Chars Long)
			$SortOrder=@$_GET["sortorder"];		// Sort by column
			}
		}


	if (($Submit==$ExitButton) or ($Submit==$DeleteExitButton))
		{
		$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/people.php?action=list";
		Header($redirectstr);
		exit;
		}

	if (@$Submit==$DeleteButton)
		{
		// delete related record	
		$query="DELETE FROM people WHERE uid='".$uid."'";
		$result = @mysql_query($query);

		// re-direct back to main list
		$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/people.php?action=list";
		Header($redirectstr);
		exit;
		} //END if (@$Submit==$DeleteButton)


	if (((@$Submit==$ButtonAdd) or (@$Submit==$ButtonEdit)) and (@!$message))
		{
		if ($action=='add')
			{
			if ( (strlen($floginid)<=1) and (strlen($ffirstname)<=1) and 
				 (strlen($flastname)<=1) and (strlen($femail)<=1) and 
				 (strlen($fbarcode)<=1) )
				{
				// Not all fields have been filled out
				$message="ERROR: Not all fields have been filled out.";
				}
			
			
			$CheckQuery = "select loginid FROM people WHERE loginid='".strtolower($floginid)."'";
			$CheckResult = @MYSQL_QUERY($CheckQuery);
			$CheckNum = mysql_num_rows($CheckResult);
			
			if ($CheckNum>=1)
				{
				// this login id is already in the system
				$message="ERROR: Unable to add person. Login ID is already being used by another person.";
				}
			else
				{
				if (strlen($fpw)>=2)
					$pwstr="pw='".pwHash($fpw)."',";
				else
					$pwstr="";				
				
				$query="INSERT INTO people 
					SET loginid='".strtolower($floginid)."',
						".$pwstr."
						firstname='".$ffirstname."',
						lastname='".$flastname."',
						email='".$femail."',
						proxycardno='".$fproxycardno."',
						barcode='".$fbarcode."',
						phone='".$fphone."',
						loandaysoverride='".$vloandaysoverride."',
						bulkloanitems='".$vbulkloanitems."',	
						accesslevel='".$faccesslevel."'";
				$result = @MYSQL_QUERY($query);	
					
				if ($result and (@$message == '')) $message="Person Added.";
				}
			} // END if ($action=='add')

		if (($action=="edit") and (@!$message))
			{
			if ((strlen($fpw)>=2) and (strtolower($floginid)<>'supervisior'))
				$pwstr="pw='".pwHash($fpw)."',";
			else
				$pwstr="";	

			$query="UPDATE people 
				SET loginid='".strtolower($floginid)."',
					".$pwstr."				
					firstname='".$ffirstname."',
					lastname='".$flastname."',
					email='".$femail."',
					proxycardno='".$fproxycardno."',
					barcode='".$fbarcode."',
					phone='".$fphone."',
					loandaysoverride='".$vloandaysoverride."',
					bulkloanitems='".$vbulkloanitems."',	
					badlogincount='0',
					accesslevel='".$faccesslevel."'";
			if ($flogindisabled=='YES')
				$query = $query.", logindisabled=1";
			else
				$query = $query.", logindisabled=null";
			$query = $query." WHERE uid='".$uid."'";
			// --------------
			$result = @mysql_query($query);
			if ($result and (@$message == '')) $message="Person Details Updated.";			
			} // END if ($action=="edit")
		} // END if (((@$Submit==$ButtonAdd) or (@$Submit==$ButtonEdit)) and (@!$message))

	// If no action defined default to listing all users.
	if (($action=='') or ($action==null)) 	$action='list';

	top();

	if ($action=='list')
		{
		// build mysql query ----
		$ListQuery = "SELECT uid,loginid,firstname,lastname,logindisabled FROM people ORDER BY ";
		
		if (($SortOrder=='name') or ($SortOrder=='loginid') or ($SortOrder=='disflag'))
			{
			if ($SortOrder=='fname') $ListQuery = $ListQuery."firstname";
			if ($SortOrder=='loginid') $ListQuery = $ListQuery."loginid";
			if ($SortOrder=='disflag') $ListQuery = $ListQuery."logindisabled DESC";
			}
		else
			{
			$ListQuery = $ListQuery."firstname";
			}
		
		// ----------------------
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if ($ListNum>=1)
			{
			?>
           	<H1>Manage User Login Accounts</H1>
			<BR> 
            <div align="center">
            (Sort information below by <a href="people.php?action=list&amp;sortorder=fname" target="_self">Full Name</a>, <a href="people.php?action=list&amp;sortorder=loginid" target="_self">Login ID</a>, <a href="people.php?action=list&amp;sortorder=disflag" target="_self">Login Disabled</a>)
            </div>
            <div align="center">
	        <TABLE align="center" width="80%" class="tablebox" cellpadding=2 cellspacing=2 border=0>
				<TR>
					<TD WIDTH="60%" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;Full Name&nbsp;</strong></TD>
					<TD WIDTH="10%" class="tableheading" ALIGN="center"><strong>&nbsp;LoginID&nbsp;</strong></TD>
					<TD WIDTH="10%" class="tableheading" NOWRAP ALIGN="center"><strong>&nbsp;LoginDisabled&nbsp;</strong></TD>					
					<TD WIDTH="10%" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
					<TD WIDTH="10%" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
				</TR>

				<?php
				for ($i=1; $i<=$ListNum; $i++) 
					{
					$ListRow = @mysql_fetch_array($ListResult);	
					$queryuid = $ListRow["uid"];
					$LoginID = $ListRow["loginid"];
					$FullName = $ListRow["firstname"].' '.$ListRow["lastname"];
					$LoginDisabled = $ListRow["logindisabled"];
					?>				
    		    <TR>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left">
	            	    &nbsp;<?php print $FullName;?>&nbsp;
	 	            </TD>

					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="center">
	    	            <?php print $LoginID;?>&nbsp;
            	    </TD>                


					<?php
					if ($LoginDisabled=='1') $DispLoginStatus = '<b>YES</b>'; 
					if ($LoginDisabled<>'1') $DispLoginStatus = 'no';
					?>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="center">
		                <?php print $DispLoginStatus;?>&nbsp;
 		            </TD>

					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="center">
					<FORM NAME="form1" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="edit">
						<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $queryuid;?>">
				   	    <INPUT TYPE="submit" NAME="Submit" VALUE="EDIT">
					</FORM>                    
 	    	        </TD>


					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="center">
					<FORM NAME="form1" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="del">
						<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $queryuid;?>">
				   	    <INPUT TYPE="submit" NAME="Submit" VALUE="DELETE" <?php 
						if (strtolower($ListRow["loginid"])=='supervisor') 
							print 'disabled="disabled"';?>>
					</FORM>                    
 	    	        </TD>
				</TR>
					<?php
					} //END for ($i=1; $i<=$ListNum; $i++) 
					?>

	            <TR>
					<TD WIDTH="90%" COLSPAN="3" ALIGN="center">&nbsp</TD>
					<TD WIDTH="90%" class="tableheading" valign="middle" ALIGN="center" colspan="3">
					<FORM NAME="form3" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="add">
				   	    <INPUT TYPE="submit" NAME="Submit" VALUE="ADD PERSON">
					</FORM>                    
	            </TR>

				<TR>
					<TD NOWRAP colspan="2" valign="middle" ALIGN="left">
	    	            <em><?php print $ListNum?> People Listed Above</em>
            	    </TD>
				</TR>

				<TR>
					<TD NOWRAP colspan="2" valign="middle" ALIGN="center">&nbsp;
	    	            
            	    </TD>                
				</TR>

			</TABLE>
            </DIV>
			<?php
			} //END if ($ListNum>=1)
		} // END if ($action=='list')


	if (($action=='add') or ($action=='edit'))
		{
		if (($action=='add') and (!$Submit))
			{
			$LoginID='';
			$FirstName='';
			$LastName='';
			$EmailAddr='';
			$AdvisorCode='';
			$ProxyCardNo='';
			$Barcode='';
			$Phone='';
			$AccessLevel = 'USER';
			$vloandaysoverride = '0';
			$vbulkloanitems = '0';
			}

		if (($action=='add') and ($Submit))
			{
			$LoginID=$floginid;
			$FirstName=$ffirstname;
			$LastName=$flastname;
			$EmailAddr=$femail;
			$ProxyCardNo=$fproxycardno;
			$AccessLevel = $faccesslevel;							
			$Phone = $fphone;			
			$Barcode=$fbarcode;
			$vloandaysoverride = $loandaysoverride;
			$vbulkloanitems = $bulkloanitems;
			}

		if ($action=='edit')
			{
			$EditQuery = "select loginid,
									firstname,
									lastname,
									email,
									proxycardno,
									barcode,
									phone,
									accesslevel,
									loandaysoverride,
									bulkloanitems,
									logindisabled,
									badlogincount,
									lastbadlogincountdatetime
							FROM people WHERE uid='".$uid."'";
			$EditResult = @MYSQL_QUERY($EditQuery);
			$EditNum = mysql_num_rows($EditResult);
			if ($EditNum>=1)
				{
				$EditRows = @mysql_fetch_array($EditResult);
				$LoginID = $EditRows["loginid"];
				$FirstName = $EditRows["firstname"];
				$LastName = $EditRows["lastname"];
				$EmailAddr = $EditRows["email"];
				$ProxyCardNo = $EditRows["proxycardno"];
				$Barcode = $EditRows["barcode"];
				$Phone = $EditRows["phone"];
				$AccessLevel = $EditRows["accesslevel"];
				$vloandaysoverride = $EditRows["loandaysoverride"];
				$vbulkloanitems = $EditRows["bulkloanitems"];								
				$LoginDisabled = $EditRows["logindisabled"];
				$vBadLoginCount = $EditRows["badlogincount"];
				$vlastbadlogincountdatetime = $EditRows["lastbadlogincountdatetime"];
				}
			} // END if ($action=='edit')		
	
		?>
		<H1><?php
			if ($action=="add") print 'ADD A NEW PERSON';
			if ($action=="edit") print 'UPDATE PERSON DETAILS'; ?>
		</H1>
		<div align="center">
		<FORM NAME="form1" METHOD="post" ACTION="" ENCTYPE="multipart/form-data">
		<INPUT TYPE="hidden" NAME="action" VALUE="<?php print $action;?>">
		<INPUT TYPE="hidden" NAME="uid" VALUE="<?php print $uid;?>">
        <?php
		if (strtolower($LoginID)=='supervisor')
			{?>
			<INPUT TYPE="hidden" NAME="floginid" VALUE="<?php echo $LoginID?>">
			<INPUT TYPE="hidden" NAME="floandaysoverride" VALUE="<?php echo $vloandaysoverride?>">
			<INPUT TYPE="hidden" NAME="fbulkloanitems" VALUE="<?php echo $vbulkloanitems?>">
			<INPUT TYPE="hidden" NAME="faccesslevel" VALUE="<?php echo $AccessLevel?>">
			<INPUT TYPE="hidden" NAME="flogindisabled" VALUE="<?php echo $LoginDisabled ?>">
			<?php 
			} //if (strtolower($LoginID)=='supervisor')
		?>
        
        <TABLE BORDER="0" WIDTH="750">
  			<TR> 
				<TD colspan="2" align="center"><?php if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';?>&nbsp;</TD>
			</TR>

			<TR> 
				<TD nowrap WIDTH="250" CLASS="tablebody" align="right"><B>Login ID *:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="floginid" MAXLENGTH="20" SIZE="25" VALUE="<?php print $LoginID;?>" <?php 
						if (strtolower($LoginID)=='supervisor') 
							print 'disabled="disabled"';?>>
				</TD>
			</TR>

			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>Password:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="password" NAME="fpw" MAXLENGTH="50" SIZE="25" VALUE="" <?php 
						if ((strtolower($LoginID)=='supervisor') and (strtolower(@$_SESSION["AUTH_USER_LOGINID"])<>'supervisor'))
							print 'disabled="disabled"';?>>
				<?php
				if ((strtolower($LoginID)=='supervisor') and (strtolower(@$_SESSION["AUTH_USER_LOGINID"])<>'supervisor'))
						print '<EM>(ONLY SUPERVISOR CAN CHANGE THIS)</EM>';
				?>
				</TD>
			</TR>

			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>First Name *:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="ffirstname" MAXLENGTH="30" SIZE="40" VALUE="<?php print $FirstName;?>">
				</TD>
			</TR>

			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>Last Name *:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="flastname" MAXLENGTH="30" SIZE="40" VALUE="<?php print $LastName;?>">
				</TD>
			</TR>

			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>Email *:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="femail" MAXLENGTH="40" SIZE="40" VALUE="<?php print $EmailAddr;?>">
				</TD>
			</TR>
 
			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>Proxy Card Number :&nbsp;</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="fproxycardno" MAXLENGTH="15" SIZE="11" VALUE="<?php print $ProxyCardNo;?>">
                    (ID card)
				</TD>
			</TR>
 
 			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>Barcode Number *:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="fbarcode" MAXLENGTH="15" SIZE="11" VALUE="<?php print $Barcode;?>">
                    (10 digit barcode number on ID card)
				</TD>
			</TR>

			<TR> 
				<TD nowrap valign="middle" CLASS="tablebody" align="right"><B>Override Due Date:</B></TD>
				<TD valign="middle" CLASS="tablebody" align="left">
					<SELECT NAME="floandaysoverride" SIZE="1" <?php 
						if (strtolower($LoginID)=='supervisor') 
							print 'disabled="disabled"';?>>
						<OPTION VALUE="0" <?php if (@$vloandaysoverride<>"1") print ' selected="selected"';?>>NO</OPTION>
						<OPTION VALUE="1" <?php if (@$vloandaysoverride=="1") print ' selected="selected"';?>>YES</OPTION>
		       		</SELECT>&nbsp;<EM>(Allows this user to be able to override loan items due date)</EM>
				</TD>
			</TR>
			<TR> 
				<TD nowrap valign="middle" CLASS="tablebody" align="right"><B>Is Able To Bulk Loan Items:</B></TD>
				<TD valign="middle" CLASS="tablebody" align="left">
					<SELECT NAME="fbulkloanitems" SIZE="1" <?php 
						if (strtolower($LoginID)=='supervisor') 
							print 'disabled="disabled"';?>>
						<OPTION VALUE="0" <?php if (@$vbulkloanitems<>"1") print ' selected="selected"';?>>NO</OPTION>
						<OPTION VALUE="1" <?php if (@$vbulkloanitems=="1") print ' selected="selected"';?>>YES</OPTION>
		       		</SELECT>&nbsp;<EM>(Allows this user to bulk loan items out)</EM>
				</TD>
			</TR>


            
			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>Phone Number:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="fphone" MAXLENGTH="30" SIZE="20" VALUE="<?php print $Phone;?>">
				</TD>
			</TR>

			<TR> 
				<TD nowrap valign="middle" CLASS="tablebody" align="right"><B>User Type:</B></TD>
				<TD valign="middle" CLASS="tablebody" align="left">
					<SELECT NAME="faccesslevel" SIZE="1" <?php 
						if (strtolower($LoginID)=='supervisor') 
							print 'disabled="disabled"';?>>
						<OPTION VALUE="USER" <?php if (@$AccessLevel<>"ADMIN") print ' selected="selected"';?>>USER</OPTION>
						<OPTION VALUE="ADMIN" <?php if (@$AccessLevel=="ADMIN") print ' selected="selected"';?>>ADMIN</OPTION>
		       		</SELECT>
				</TD>
			</TR>
			<TR> 
				<TD nowrap valign="middle" CLASS="tablebody" align="right"><B>WEB Login Disabled:</B></TD>
				<TD valign="middle" CLASS="tablebody" align="left">
					<SELECT NAME="flogindisabled" SIZE="1" <?php 
						if (strtolower($LoginID)=='supervisor') 
							print 'disabled="disabled"';?>>
						<OPTION VALUE="NO" <?php if (@$LoginDisabled<>"1") print ' selected="selected"';?>>NO</OPTION>
						<OPTION VALUE="YES" <?php if (@$LoginDisabled=="1") print ' selected="selected"';?>>YES</OPTION>
		       		</SELECT>
				</TD>
			</TR>


			<?php
			if ($action=='edit')
				{
				?>
 			<TR> 
				<TD nowrap CLASS="tablebody" align="right" valign="middle"><B>Bad Login Count:</B></TD>
				<TD CLASS="tablebody" valign="middle" align="left"> 
					<?php print $vBadLoginCount?>&nbsp;
                    <em>(Bigger than 8 the WEB LOGIN will be automatically disabled.<br>
	                    &nbsp;&nbsp;&nbsp;&nbsp;This will be cleared to 0 when WEB LOGIN is enabled)
                    </em>
				</TD>
			</TR>
 			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>Last Bad Login Attempt:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<?php print $vlastbadlogincountdatetime;?>&nbsp;
				</TD>
			</TR>
            
  			<?php
				} // END if ($action=='edit')
			?>
  			<TR> 
				<TD colspan="2" align="center">*&nbsp;<b><em>THESE FIELDS MUST NOT BE LEFT BLANK</em></b></TD>
			</TR>
  			<TR> 
				<TD colspan="2">&nbsp;</TD>
			</TR>
			<TR ALIGN="left"> 
				<TD nowrap WIDTH="1%">&nbsp;</TD>
	            <TD> 
              <INPUT TYPE="submit" NAME="Submit" VALUE="<?php print $ExitButton;?>">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <INPUT TYPE="submit" NAME="Submit" VALUE="<?php
			  	if ($action=="add") print $ButtonAdd;
				if ($action=="edit") print $ButtonEdit;
				?>">
    	        </TD>
        	</TR>
          
  			<TR> 
				<TD colspan="2">&nbsp;</TD>
			</TR>
            
        </TABLE>
		</FORM>
		</DIV>
		<?php
		} //END if (($action=='add') or ($action=='edit'))


	if (($action=='del'))
		{
		$Query = "select loginid,firstname,lastname,email FROM people WHERE uid='".$uid."'";
		$Result = @MYSQL_QUERY($Query);
		$Rows = @mysql_fetch_array($Result);
		$fLoginID = $Rows["loginid"];
		$fFullName = $Rows["firstname"].' '.$Rows["lastname"];
		$fEmail = $Rows["email"];
		?>
		<h1>DELETE A PERSON</h1>
	    <BR>
		<div align="center">
		<p>Are you sure you want to delete the following person?</p>
		<form name="form1" method="post" action="">
		<INPUT TYPE="hidden" NAME="action" VALUE="<?php print $action;?>">
		<INPUT TYPE="hidden" NAME="uid" VALUE="<?php print $uid;?>">
		<table cellspacing="2" cellpadding="2">

			<tr valign="middle"> 
				<td nowrap align="right" CLASS="tablebody"><b>Login ID:&nbsp;</b></td>
				<td nowrap align="left" CLASS="tablebody">
					<?php print $fLoginID;?>&nbsp;
				</td>
			</tr>

			<tr valign="middle"> 
				<td nowrap align="right" CLASS="tablebody"><b>Name:&nbsp;</b></td>
				<td nowrap align="left" CLASS="tablebody">
					<?php print $fFullName;?>&nbsp;
				</td>
			</tr>

			<tr valign="middle"> 
				<td nowrap align="right" CLASS="tablebody"><b>Email:&nbsp;</b></td>
				<td nowrap align="left" CLASS="tablebody">
					<?php print $fEmail;?>&nbsp;
				</td>
			</tr>
        
			<tr valign="middle"> 
				<td nowrap colspan="2" >&nbsp;</td>
			</tr>
        
			<tr valign="middle"> 
				<td nowrap align="center" colspan="2">
            	    <INPUT TYPE="submit" NAME="Submit" VALUE="<?php print $DeleteExitButton;?>">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<INPUT TYPE="submit" name="Submit" value="<?php print $DeleteButton;?>">
				</td>
			</tr>
		</table>
	    <BR>
	    <BR>
	    <BR>
	    <BR>                  
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




