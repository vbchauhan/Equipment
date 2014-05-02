<?PHP
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
	$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/loangroups.php";
	Header($redirectstr);
	exit;
	}


if ($action=="addloangroup")
	{
	if ((strlen(@$_POST["floangroupid"])>=2) and 
		(strlen(@$_POST["floangrouptitle"])>=2) and
		(strlen(@$_POST["floangroupdesc"])>=2))
		{
		$LookupQuery = "SELECT 
							uid,
							loangroup
						FROM loangroups WHERE (LOWER(loangroup) = '".@$_POST["floangroupid"]."')";						
		$LookupResult = @MYSQL_QUERY($LookupQuery);
		$LookupNum = mysql_num_rows($LookupResult);

		if ($LookupNum<=0)
			{
			$InsertQuery="INSERT INTO loangroups SET 
						loangroup='".strtoupper(@$_POST["floangroupid"])."',
						loangrouptitle='".htmlspecialchars(@$_POST["floangrouptitle"], ENT_QUOTES)."',
						loangroupdescription='".htmlspecialchars(@$_POST["floangroupdesc"], ENT_QUOTES)."',
						groupvisible='".@$_POST["fgroupvisible"]."',
						viewitemstatuswithoutlogin='".@$_POST["fviewitemstatuswithoutlogin"]."',
						dateitemcreatedinsystem='".date('Y-m-d H:i')."'";
			$InsertResult = @mysql_query($InsertQuery);		
			if ($InsertResult)
				$message=strtoupper(@$_POST["floangroupid"]).' has been added';
			else
				$message='ERROR: item '.@$_POST["floangroupid"].' was not added!!';
			$action='add';
			} //END if ($LookupNum<=0)
		else
			{
			$message='ERROR: Item Category is already registered in the system!';
			$action='add';
			} //END ELSE if ($LookupNum<=0)
			
		} //END if ((strlen(@$_POST["....))
	else
		{
		$message='You must type in ID, TITLE and DESCRIPTION details to continue!';
		$action='add';
		} //END ELSE if ((strlen(@$_POST["....))
	} //END if ($action=="addloangroup")


if ($action=="updateloangroup")
	{
	if ((strlen(@$_POST["floangroupid"])>=2) and 
		(strlen(@$_POST["floangrouptitle"])>=2) and
		(strlen(@$_POST["floangroupdesc"])>=2))
		{
		$UpdateQuery="UPDATE loangroups SET 
					loangroup='".strtoupper(@$_POST["floangroupid"])."',
					loangrouptitle='".htmlspecialchars(@$_POST["floangrouptitle"], ENT_QUOTES)."',
					loangroupdescription='".htmlspecialchars(@$_POST["floangroupdesc"], ENT_QUOTES)."',
					verbosedisplay='".@$_POST["fverbosedisplay"]."',
					viewitemstatuswithoutlogin='".@$_POST["fviewitemstatuswithoutlogin"]."',
					groupvisible='".@$_POST["fgroupvisible"]."'
				WHERE (uid='".@$_POST["uid"]."')";
		$UpdateResult = @mysql_query($UpdateQuery);		
		if ($UpdateResult)
			$message=@$_POST["floangroupid"].' group has been updated';
		else
			$message='ERROR: item '.@$_POST["floangroupid"].' group was not updated!!';
		$action='edit';
		} //END if ((strlen(@$_POST["......))
	else
		{
		$message='No fields can be left blank, You must type in ID, TITLE and DESCRIPTION details to continue!';
		$action='edit';
		} //END ELSE if ((strlen(@$_POST["......))

	} // END if ($action=="updateloangroup")


if ($action=="delloangroup")
	{
	$LookupQuery = "SELECT uid,	loangroup FROM loangroups WHERE uid='".$uid."'";					
	$LookupResult = @mysql_query($LookupQuery);
	$LookupNum = mysql_num_rows($LookupResult);
	$LookupRows = @mysql_fetch_array($LookupResult);
	if (strtolower($LookupRows["loangroup"])==strtolower($_SESSION["LOANSYSTEM_GROUP"])) $_SESSION["LOANSYSTEM_GROUP"]='';
	
	// delete related record	
	$query="DELETE FROM loangroups WHERE uid='".$uid."'";
	$result = @mysql_query($query);

	// re-direct back to main list
	$redirectstr="Location: ".dirname($_SERVER["SCRIPT_NAME"])."/loangroups.php?message=".$_POST["loangroup"]." has been deleted.";
	Header($redirectstr);
	exit;
	} //END if (@$Submit==$DeleteButton)


if (canupdate())
	{
	
	top();


	if ($action=='list')
		{
		// build mysql query ----
		$ListQuery = "SELECT uid,loangroup,loangrouptitle,loangroupdescription,groupvisible FROM loangroups ORDER BY loangroup";
		
		// ----------------------
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if ($ListNum>=1)
			{
			?>
           	<H1>Manage Item Categories</H1>
            <div align="center">
	        <TABLE width="700" class="tablebox" cellpadding=2 cellspacing=2 border=0>
				<TR>
					<TD COLSPAN="5" ALIGN="center"><?PHP
                    	if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
					?>&nbsp;
					</TD>
				</TR>
                    
				<TR>
					<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;Item Category&nbsp;</strong></TD>
					<TD WIDTH="350" class="tableheading" ALIGN="center"><strong>&nbsp;Description&nbsp;</strong></TD>
					<TD WIDTH="350" class="tableheading" ALIGN="center"><strong>&nbsp;Visible&nbsp;</strong></TD>
                    <TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
				</TR>

				<?PHP
				for ($i=1; $i<=$ListNum; $i++) 
					{
					$ListRow = @mysql_fetch_array($ListResult);	
					?>				
    		    <TR>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left"><?php echo $ListRow["loangroup"]?>&nbsp;</TD>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left"><?php echo $ListRow["loangrouptitle"]?>&nbsp;</TD>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="center"><?php
					if ($ListRow["groupvisible"]==1)
						print 'YES';
					else
						print 'NO';
					?>&nbsp;</TD>                    
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
						<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $ListRow["uid"];?>">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="DELETE">
					</FORM>                    
 	    	        </TD>
				</TR>
					<?PHP
					} //END for ($i=1; $i<=$ListNum; $i++) 
					?>

	            <TR>
					<TD COLSPAN="3" ALIGN="left"><em><?PHP print $ListNum?>&nbsp;Item Categorys Listed Above</em>&nbsp;</TD>
					<TD class="tableheading" valign="middle" ALIGN="center" colspan="2">
					<FORM NAME="form3" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="add">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="ADD New Category">
					</FORM>                    
	            </TR>
			</TABLE>
            </div>
			<?PHP
			} //END if ($ListNum>=1)
		else
			{
			?>
           	<H1>Manage Item Categorys</H1>
            <div align="center">
	        <TABLE width="700" class="tablebox" cellpadding=2 cellspacing=2 border=0>
				<TR>
					<TD COLSPAN="5" ALIGN="center"><?PHP
                    	if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
					?>&nbsp;
					</TD>
				</TR>
                    
				<TR>
					<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;Item Category&nbsp;</strong></TD>
					<TD WIDTH="350" class="tableheading" ALIGN="center"><strong>&nbsp;Description&nbsp;</strong></TD>
					<TD WIDTH="350" class="tableheading" ALIGN="center"><strong>&nbsp;Category Visible&nbsp;</strong></TD>
                    <TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
				</TR>
    		    <TR>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left" colspan="5"><em>NO LOAN GROUPS IN THIS SYSTEM</em>&nbsp;</TD>
	            <TR>
	            <TR>
					<TD COLSPAN="3" ALIGN="left"><em><?PHP print $ListNum?>&nbsp;Item Categorys Listed Above</em>&nbsp;</TD>
					<TD class="tableheading" valign="middle" ALIGN="center" colspan="2">
					<FORM NAME="form3" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="add">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="ADD NEW GROUP">
					</FORM>                    
	            </TR>
			</TABLE>
            </div>

	<?PHP			
			} //END ELSE if ($ListNum>=1)
		} // END if ($action=='list')


	if (($action=='add') or ($action=='edit'))
		{
		if (($action=='add') and (!$submit))
			{
			$LoanGroupID='';
			$LoanGroupTitle='';
			$LoanGroupDesc='';
			$vverbosedisplay='0';
			$vcachenames='0';
			$vgroupvisible='1';
			$vviewitemstatuswithoutlogin='1';
			}

		if (($action=='add') and ($submit))
			{
			$LoanGroupID=@$_POST['floangroupid'];
			$LoanGroupTitle=@$_POST['floangrouptitle'];
			$LoanGroupDesc=@$_POST['floangroupdesc'];
			$vverbosedisplay=@$_POST["fverbosedisplay"];
			$vcachenames=@$_POST["fcachenames"];
			$vgroupvisible=@$_POST['fgroupvisible'];
			$vviewitemstatuswithoutlogin=@$_POST['fviewitemstatuswithoutlogin'];
			}

		if ($action=='edit')
			{
			$EditQuery = "select uid,
									loangroup,
									loangrouptitle,
									loangroupdescription,
									verbosedisplay,
									cachenames,
									groupvisible,
									viewitemstatuswithoutlogin
							FROM loangroups WHERE uid='".$uid."'";
			$EditResult = @MYSQL_QUERY($EditQuery);
			$EditNum = mysql_num_rows($EditResult);
			if ($EditNum>=1)
				{
				$EditRows = @mysql_fetch_array($EditResult);
				$LoanGroupID=$EditRows["loangroup"];
				$LoanGroupTitle=$EditRows["loangrouptitle"];
				$LoanGroupDesc=$EditRows["loangroupdescription"];
				$vverbosedisplay=$EditRows["verbosedisplay"];
				$vcachenames=$EditRows["cachenames"];
				$vgroupvisible=$EditRows["groupvisible"];
				$vviewitemstatuswithoutlogin=$EditRows['viewitemstatuswithoutlogin'];
				}
			} // END if ($action=='edit')		
	

		if ($action=="add") print '<H1>ADD A NEW LOAN GROUP</H1>';
		if ($action=="edit") print '<H1>UPDATE A LOAN GROUP DETAILS</H1>';
        ?>
		<FORM NAME="form1" METHOD="post" ACTION="" ENCTYPE="multipart/form-data">
		<?PHP
		if ($action=="add") print '<INPUT TYPE="hidden" NAME="action" VALUE="addloangroup">';
		if ($action=="edit") print '<INPUT TYPE="hidden" NAME="action" VALUE="updateloangroup">';
		?>
		<INPUT TYPE="hidden" NAME="uid" VALUE="<?PHP print $uid;?>">
		<DIV align="center">
        <TABLE BORDER="0" WIDTH="600">
  			<TR> 
				<TD colspan="2" align="center"><?PHP if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';?>&nbsp;</TD>
			</TR>
			<TR> 
				<TD nowrap WIDTH="250" CLASS="tablebody" align="right"><B>Item Category ID:</B></TD>
				<TD WIDTH="300" CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="floangroupid" MAXLENGTH="20" SIZE="25" VALUE="<?PHP print $LoanGroupID?>">
				</TD>
			</TR>

			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>Item Category Title:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="floangrouptitle" MAXLENGTH="35" SIZE="35" VALUE="<?PHP print $LoanGroupTitle?>">
				</TD>
			</TR>

			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>Item Category Description:</B></TD>
				<TD CLASS="tablebody" align="left"> 
	                <textarea name="floangroupdesc" cols="50" rows="8"><?php echo $LoanGroupDesc;?></textarea>                
				</TD>
			</TR>
			<TR>
				<TD CLASS="tablebody" align="right">Category List:</td>
				<TD CLASS="tablebody" align="left">
				<SELECT NAME="fverbosedisplay" SIZE="1">
					<OPTION VALUE="1" <?PHP if (@$vverbosedisplay=="1") print ' selected="selected"';?>>YES</OPTION>
					<OPTION VALUE="0" <?PHP if (@$vverbosedisplay<>"1") print ' selected="selected"';?>>NO</OPTION>
	       		</SELECT>&nbsp;<em>(More compact view of items on the main loan page)</em>
	            </TD>
			</TR>
			<TR>
				<TD CLASS="tablebody" align="right">Item Category Visible:</td>
				<TD CLASS="tablebody" align="left">
				<SELECT NAME="fgroupvisible" SIZE="1">
					<OPTION VALUE="1" <?PHP if (@$vgroupvisible<>"0") print ' selected="selected"';?>>YES</OPTION>
					<OPTION VALUE="0" <?PHP if (@$vgroupvisible=="0") print ' selected="selected"';?>>NO</OPTION>
	       		</SELECT>
	            </TD>
			</TR>
			<TR>
				<TD CLASS="tablebody" align="right">View Item Status Without Login:</td>
				<TD CLASS="tablebody" align="left">
				<SELECT NAME="fviewitemstatuswithoutlogin" SIZE="1">
					<OPTION VALUE="1" <?PHP if (@$vviewitemstatuswithoutlogin<>"0") print ' selected="selected"';?>>YES</OPTION>
					<OPTION VALUE="0" <?PHP if (@$vviewitemstatuswithoutlogin=="0") print ' selected="selected"';?>>NO</OPTION>
	       		</SELECT>
	            </TD>
			</TR>
  			<TR> 
				<TD colspan="2">&nbsp;</TD>
			</TR>

			<TR ALIGN="left"> 
				<TD nowrap colspan="2" align="center">
              <INPUT TYPE="submit" NAME="submit" VALUE="Exit/Cancel">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <INPUT TYPE="submit" NAME="submit" VALUE="<?PHP
			  	if ($action=="add") print 'Add New Category';
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
		<?PHP
		} //END if (($action=='add') or ($action=='edit'))


	if (($action=='del'))
		{
			
		$LookupQuery = "SELECT 
							uid,
							loangroup,
							loangrouptitle,
							loangroupdescription
						FROM 
							loangroups 
						WHERE 
							uid='".$uid."'";

		$LookupResult = @MYSQL_QUERY($LookupQuery);
		$LookupNum = mysql_num_rows($LookupResult);			
		$LookupRows = @mysql_fetch_array($LookupResult);
		?>
		<H1>DELETE A LOAN GROUP</H1>
	    <BR>
		<p align="center">Are you sure you want to delete the following loan group?</p>
        <div align="center">
		<form name="form1" method="post" action="">
		<INPUT TYPE="hidden" NAME="action" VALUE="delloangroup">
		<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
		<INPUT TYPE="hidden" NAME="loangroup" VALUE="<?php print $LookupRows["loangroup"];?>">        
        <table width="500" cellspacing="2" cellpadding="2" align="center">

			<tr valign="middle"> 
				<td width="200" nowrap align="right" CLASS="tablebody"><b>Item Category ID:</b></td>
				<td width="300" nowrap align="left" CLASS="tablebody">
					<?PHP print $LookupRows["loangroup"];?>&nbsp;
				</td>
			</tr>

			<tr valign="middle"> 
				<td nowrap align="right" CLASS="tablebody"><b>Item Category Title:</b></td>
				<td nowrap align="left" CLASS="tablebody">
					<?PHP print $LookupRows["loangrouptitle"];?>&nbsp;
				</td>
			</tr>

			<tr valign="middle"> 
				<td nowrap align="right" CLASS="tablebody"><b>Item Category Description:</b></td>
				<td align="left" CLASS="tablebody">
					<?PHP print $LookupRows["loangroupdescription"];?>&nbsp;
				</td>
			</tr>
        
			<tr valign="middle"> 
				<td nowrap colspan="2" >&nbsp;</td>
			</tr>
        
			<tr valign="middle"> 
				<td nowrap align="center" colspan="2" >
            	    <INPUT TYPE="submit" NAME="submit" VALUE="<?PHP print 'Exit/Cancel'?>">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<INPUT TYPE="submit" name="submit" value="<?PHP print 'DELETE THIS GROUP'?>">
				</td>
			</tr>
		</table>
		</form>	 
		</div>
		<?PHP
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




