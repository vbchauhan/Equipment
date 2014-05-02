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
	$lgroup=@$_POST["lgroup"];
	$fsortlist=@$_POST["sortlist"];
	} // END if ($action)
else
	{
	$uid=@$_GET['uid'];
	$action=@$_GET['action'];
	$submit=@$_GET["submit"];
	$message=@$_GET["message"];
	$lgroup=@$_GET["lgroup"];
	$fsortlist=@$_GET["sortlist"];
	}

if ($submit=="Exit/Cancel")
	{
	$action='list';
	}

if ($action=='') $action='selectloangroup'; // If no action the default to "list" groups.

if ($action=="delloanitem")
	{
	// delete related record	
	$query="DELETE FROM loansystem WHERE uid='".$uid."'";
	$result = @mysql_query($query);
	
	if ($result)
		$message='Item '.strtoupper(@$_POST["barcode"])." has been deleted.";	
	else
		$message='ERROR: Item '.strtoupper(@$_POST["barcode"]).' was not deleted!!';

	// re-direct back to main list
	$action='list';

	} //END if (@$submit==$DeleteButton)
	

if ($action=="addloanitem")
	{
	if ((strlen(@$_POST["fbarcode"])>=2) and 
		(strlen(@$_POST["fstitle"])>=2) and
		(strlen(@$_POST["ftitle"])>=2) and
		(strlen(@$_POST["famberwarn"])>=1) and		
		(strlen(@$_POST["fredwarn"])>=1))
		{
		$LookupQuery = "SELECT uid, itembarcode
						FROM loansystem 
						WHERE (LOWER(itembarcode) = '".@strtolower($_POST["fbarcode"])."')";						
		$LookupResult = @MYSQL_QUERY($LookupQuery);
		$LookupNum = mysql_num_rows($LookupResult);

		if ($LookupNum<=0)
			{
			$InsertQuery="INSERT INTO loansystem SET 
									loangroup='".@$_POST["flgroup"]."',
									itemtitle='".htmlspecialchars(@$_POST["ftitle"], ENT_QUOTES)."',
									shortitemtitle='".htmlspecialchars(@$_POST["fstitle"], ENT_QUOTES)."',
									itemdescription='".htmlspecialchars(@$_POST["fdesc"], ENT_QUOTES)."',
									sortorder='".@$_POST["fsort"]."',
									itembarcode='".strtoupper(@$_POST["fbarcode"])."',
									itemserial='".@$_POST["fserial"]."',
									itemmodel='".@$_POST["fmodel"]."',
									itemloanflag='0',
									warningamber='".@$_POST["famberwarn"]."',
									warningred='".@$_POST["fredwarn"]."',
									itemvisible='".@$_POST["fitemvisible"]."',
									dateitemcreatedinsystem='".date('Y-m-d H:i')."',
									itemcreatedbyinsystem='".ucwords(strtolower(@$_SESSION["AUTH_USER_NAME"]))." (".strtoupper(@$_SESSION["AUTH_USER_LOGINID"]).")'";
			$InsertResult = @mysql_query($InsertQuery);		
			if ($InsertResult)
				$message=strtoupper(@$_POST["fbarcode"]).' has been added';
			else
				$message='ERROR: Item '.strtoupper(@$_POST["fbarcode"]).' was not added!!';
			$action='add';
			} //END if ($LookupNum<=0)
		else
			{
			$message="ERROR: Loan item ".strtoupper(@$_POST["fbarcode"])." already registered in the system! (Item not saved!!)";
			$action='add';
			} //END ELSE if ($LookupNum<=0)
			
		} //END if ((strlen(@$_POST["....))
	else
		{
		$message='Items with a * against them need to be filled in continue!';
		$action='add';
		} //END ELSE if ((strlen(@$_POST["....))
	} //END if ($action=="addloangroup")


if ($action=="updateloanitem")
	{
	if ((strlen(@$_POST["fbarcode"])>=2) and 
		(strlen(@$_POST["fstitle"])>=2) and
		(strlen(@$_POST["ftitle"])>=2) and
		(strlen(@$_POST["famberwarn"])>=1) and		
		(strlen(@$_POST["fredwarn"])>=1))
		{
		$UpdateQuery="UPDATE loansystem SET 
									loangroup='".@$_POST["flgroup"]."',
									itemtitle='".htmlspecialchars(@$_POST["ftitle"], ENT_QUOTES)."',
									shortitemtitle='".htmlspecialchars(@$_POST["fstitle"], ENT_QUOTES)."',
									itemdescription='".htmlspecialchars(@$_POST["fdesc"], ENT_QUOTES)."',
									sortorder='".@$_POST["fsort"]."',
									itembarcode='".strtoupper(@$_POST["fbarcode"])."',
									itemserial='".@$_POST["fserial"]."',
									itemmodel='".@$_POST["fmodel"]."',
									itemloanflag='0',
									warningamber='".@$_POST["famberwarn"]."',
									warningred='".@$_POST["fredwarn"]."',
									itemvisible='".@$_POST["fitemvisible"]."',
									dateitemcreatedinsystem='".date('Y-m-d H:i')."'
								WHERE (uid='".@$_POST["uid"]."')";
		$UpdateResult = @mysql_query($UpdateQuery);		
		if ($UpdateResult)
			$message=strtoupper(@$_POST["fbarcode"]).' has been updated';
		else
			$message='ERROR: item '.strtoupper(@$_POST["fbarcode"]).' was not updated!!';
		$action='edit';
		} //END if ((strlen(@$_POST["......))
	else
		{
		$message='Items with a * against them need to be filled in continue!';
		$action='edit';
		} //END ELSE if ((strlen(@$_POST["......))

	} // END if ($action=="updateloangroup")


if (canupdate())
	{
	
	top();

	if ($action=="selectloangroup")
		{
		?>
		<BR>
		<H1>Select the Item group to generate a list of Items present</H1>
		<BR>
		<?PHP 
		$Query = "select loangroup,loangrouptitle,loangroupdescription FROM loangroups WHERE groupvisible='1'";
		$Result = @MYSQL_QUERY($Query);
		$Nums = mysql_num_rows($Result);
		?>
		<div align="center">
		<table width="500" border="0" align="center"><?php
			for ($i=1; $i<=$Nums; $i++) 
				{
				$Rows = @mysql_fetch_array($Result);
			?>
			<tr>
				<td align="center" CLASS="tablebody">
            	<FORM NAME="form1" METHOD="post" ACTION="">
				<INPUT TYPE="hidden" NAME="action" VALUE="list">
				<INPUT TYPE="hidden" NAME="lgroup" VALUE="<?php echo $Rows['loangroup'];?>">
	   		    &nbsp;<INPUT TYPE="submit" NAME="submit" VALUE="MANAGE ITEMS FOR <?php print $Rows['loangrouptitle'];?>">
				</FORM>
    	        <?php print $Rows['loangroupdescription']?><BR><BR>
        	    </td>
			</tr>
			<?php
    		    } //END for ($i=1; $i<=$Nums; $i++)
		?>
		</table>
		</div>
		<?PHP
		} //END if ($action=="selectloangroup")
	

	if ($action=='list')
		{
		if (($fsortlist=='barcode') or ($fsortlist=='desc') or ($fsortlist=='sortorder'))
			{
			if ($fsortlist=='barcode') $SortStr='itembarcode';
			if ($fsortlist=='desc') $SortStr='shortitemtitle';
			if ($fsortlist=='sortorder') $SortStr='sortorder';
			}
		else
			$SortStr='itembarcode';
				
		// build mysql query ----
		$ListQuery = "SELECT 
							uid,
							shortitemtitle,
							itembarcode,
							itemvisible,
							sortorder
						FROM 
							loansystem 
						WHERE
							loangroup='".$lgroup."'
						ORDER BY 
							".$SortStr;

		// ----------------------
		$ListResult = @mysql_query($ListQuery);
		$ListNum = mysql_num_rows($ListResult);
		if ($ListNum>=1)
			{
			?>
           	<H1>Manage <?php echo $lgroup; ?> Items</H1>
            <div align="center">
	        <TABLE width="700" class="tablebox" cellpadding=2 cellspacing=2 border=0>
				<TR>
					<TD COLSPAN="6" ALIGN="center"><?PHP
                    	if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
					?>&nbsp;
					</TD>
				</TR>

				<TR>
					<TD COLSPAN="6" ALIGN="center">(Sort information below by <a href="loanitems.php?sortlist=barcode&amp;action=list&amp;lgroup=<?php echo $lgroup;?>" target="_self">Barcode</a>, <a href="loanitems.php?sortlist=desc&amp;action=list&amp;lgroup=<?php echo $lgroup;?>" target="_self">SortDescription</a>, <a href="loanitems.php?sortlist=sortorder&amp;action=list&amp;lgroup=<?php echo $lgroup;?>" target="_self">SortOrder</a>) 
					</TD>
				</TR>
                    
				<TR>
					<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;Item Barcode&nbsp;</strong></TD>
					<TD WIDTH="150" class="tableheading" ALIGN="left"><strong>&nbsp;Short Description&nbsp;</strong></TD>
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;Sort Order&nbsp;</strong></TD>
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;Item Visible&nbsp;</strong></TD>
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
				</TR>

				<?PHP
				for ($i=1; $i<=$ListNum; $i++) 
					{
					$ListRow = @mysql_fetch_array($ListResult);	
					?>				
    		    <TR>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left"><?php echo $ListRow["itembarcode"]?>&nbsp;</TD>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left"><?php echo$ListRow["shortitemtitle"]?>&nbsp;</TD>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left"><?php echo$ListRow["sortorder"]?>&nbsp;</TD>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="center"><?php
					if (@$ListRow["itemvisible"]==1)
						print 'YES';
					else
						print 'NO';
					?>&nbsp;</TD>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="center">
					<FORM NAME="form1" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="edit">
						<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $ListRow["uid"]?>">
						<INPUT TYPE="hidden" NAME="lgroup" VALUE="<?php echo $lgroup?>">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="EDIT">
					</FORM>                    
 	    	        </TD>


					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="center">
					<FORM NAME="form1" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="del">
						<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $ListRow["uid"]?>">
						<INPUT TYPE="hidden" NAME="lgroup" VALUE="<?php echo $lgroup?>">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="DELETE">
					</FORM>                    
 	    	        </TD>
				</TR>
					<?PHP
					} //END for ($i=1; $i<=$ListNum; $i++) 
					?>

	            <TR>
					<TD COLSPAN="4" ALIGN="left"><em><?PHP print $ListNum?>&nbsp;Loan Items Listed Above</em>&nbsp;</TD>
					<TD class="tableheading" valign="middle" ALIGN="center" colspan="2">
					<FORM NAME="form3" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="add">
						<INPUT TYPE="hidden" NAME="lgroup" VALUE="<?php echo $lgroup?>">                        
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="ADD NEW ITEM">
					</FORM>                    
	            </TR>
				<TR>
					<TD NOWRAP colspan="2" valign="middle" ALIGN="left">
   					<FORM NAME="form3" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="selectloangroup">
						<INPUT TYPE="hidden" NAME="lgroup" VALUE="<?php echo $lgroup?>">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="SELECT ANOTHER GROUP">
					</FORM>  
                    </TD>                
				</TR>

			</TABLE>
            </div>
			<?PHP
			} //END if ($ListNum>=1)
		else
			{
			?>
           	<H1>Manage <?=@$_POST["lgroup"]?> Loan Items</H1>
            <div align="center">
	        <TABLE width="700" class="tablebox" cellpadding=2 cellspacing=2 border=0>
				<TR>
					<TD COLSPAN="4" ALIGN="center"><?PHP
                    	if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';
					?>&nbsp;
					</TD>
				</TR>
                    
				<TR>
					<TD WIDTH="150" class="tableheading" NOWRAP ALIGN="left"><strong>&nbsp;Item Barcode&nbsp;</strong></TD>
					<TD WIDTH="150" class="tableheading" ALIGN="left"><strong>&nbsp;Short Description&nbsp;</strong></TD>
					<!--<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;Sort<BR>Order&nbsp;</strong></TD>-->
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;Item<BR>Visible&nbsp;</strong></TD>
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;EDIT&nbsp;</strong></TD>					
					<TD WIDTH="100" class="tableheading" ALIGN="center"><strong>&nbsp;DELETE&nbsp;</strong></TD>					
				</TR>
    		    <TR>
					<TD CLASS="tablebody" NOWRAP valign="middle" ALIGN="left" colspan="6"><em>NO LOAN ITEMS IN THIS SYSTEM</em>&nbsp;</TD>
	            <TR>
					<TD COLSPAN="4" ALIGN="left"><em><?PHP print $ListNum?>&nbsp;Loan Items Listed Above</em>&nbsp;</TD>
					<TD class="tableheading" valign="middle" ALIGN="center" colspan="2">
					<FORM NAME="form3" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="add">
						<INPUT TYPE="hidden" NAME="lgroup" VALUE="<?php echo $lgroup?>">                        
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="ADD NEW ITEM">
					</FORM>                    
	            </TR>
				<TR>
					<TD NOWRAP colspan="2" valign="middle" ALIGN="left">
   					<FORM NAME="form3" METHOD="post" ACTION="">
						<INPUT TYPE="hidden" NAME="action" VALUE="selectloangroup">
						<INPUT TYPE="hidden" NAME="lgroup" VALUE="<?php echo $lgroup?>">
				   	    <INPUT TYPE="submit" NAME="submit" VALUE="SELECT ANOTHER LOAN GROUP">
					</FORM>  
                    </TD>                
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
			$vloangroup='';
			$vitemtitle='';
			$vshortitemtitle='';
			$vitemdescription='';
			$vsortorder='';
			$vitembarcode='';
			$vitemserial='';
			$vitemmodel='';
			$vwarningamber='';
			$vwarningred='';
			$vitemvisible='';
			$vitemstolennotes='';
			}

		if (($action=='add') and ($submit))
			{
			$vloangroup=@$_POST['flgroup'];
			$vitemtitle=@$_POST['ftitle'];
			$vshortitemtitle=@$_POST['fstitle'];
			$vitemdescription=@$_POST['fdesc'];
			$vsortorder=@$_POST['fsort'];
			$vitembarcode=@$_POST['fbarcode'];
			$vitemserial=@$_POST['fserial'];
			$vitemmodel=@$_POST['fmodel'];
			$vwarningamber=@$_POST['famberwarn'];
			$vwarningred=@$_POST['fredwarn'];
			$vitemvisible=@$_POST['fitemvisible'];
			$vitemstolennotes=@$_POST['fitemstolennotes'];
			}

		if ($action=='edit')
			{
			$EditQuery = "SELECT
							loangroup,
							itemtitle,
							shortitemtitle,
							itemdescription,
							sortorder,
							itembarcode,
							itemserial,
							itemmodel,
							itemloanflag,
							itemloanedtonotes,
							warningamber,
							warningred,
							itemvisible,
							itemstolennotes
						FROM 
							loansystem 
						WHERE 
							uid='".$uid."'";
			$EditResult = @MYSQL_QUERY($EditQuery);
			$EditNum = mysql_num_rows($EditResult);
			if ($EditNum>=1)
				{
				$EditRows = @mysql_fetch_array($EditResult);
				$vloangroup=$EditRows["loangroup"];
				$vitemtitle=$EditRows["itemtitle"];
				$vshortitemtitle=$EditRows["shortitemtitle"];
				$vitemdescription=$EditRows["itemdescription"];
				$vsortorder=$EditRows["sortorder"];
				$vitembarcode=$EditRows["itembarcode"];
				$vitemserial=$EditRows["itemserial"];
				$vitemmodel=$EditRows["itemmodel"];
				$vwarningamber=$EditRows["warningamber"];
				$vwarningred=$EditRows["warningred"];
				$vitemloanflag=$EditRows["itemloanflag"];
				$vitemloanedtonotes=$EditRows["itemloanedtonotes"];
				$vitemvisible=$EditRows["itemvisible"];
				$vitemstolennotes=$EditRows["itemstolennotes"];
				}
			} // END if ($action=='edit')		
	

		if ($action=="add") print '<H1>ADD A NEW LOAN ITEM</H1>';
		if ($action=="edit") print '<H1>UPDATE A LOAN ITEM DETAILS</H1>';
        ?>
		<FORM NAME="form1" METHOD="post" ACTION="" ENCTYPE="multipart/form-data">
			<INPUT TYPE="hidden" NAME="lgroup" VALUE="<?php echo $lgroup?>">        
		<?PHP
		if ($action=="add") print '<INPUT TYPE="hidden" NAME="action" VALUE="addloanitem">';
		if ($action=="edit") print '<INPUT TYPE="hidden" NAME="action" VALUE="updateloanitem">';

		?>
		<INPUT TYPE="hidden" NAME="uid" VALUE="<?PHP print $uid;?>">
		<div align="center">
		<table width="600" border="0">
		<tr> 
			<td colspan="2" align="center"><?PHP if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';?>&nbsp;</td>
		</tr>
		<tr>
			<td width="160" CLASS="tablebody" align="right">Barcode*:</td>
			<td width="240" CLASS="tablebody" align="left">
				<INPUT TYPE="text" NAME="fbarcode" MAXLENGTH="40" SIZE="40" VALUE="<?php echo $vitembarcode?>">
			</td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Short Title*:</td>
			<td CLASS="tablebody" align="left">
				<INPUT TYPE="text" NAME="fstitle" MAXLENGTH="20" SIZE="25" VALUE="<?php echo $vshortitemtitle?>">
            </td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Long Title*:</td>
			<td CLASS="tablebody" align="left">
				<INPUT TYPE="text" NAME="ftitle" MAXLENGTH="50" SIZE="50" VALUE="<?php echo $vitemtitle?>">
            </td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Description:</td>
			<td CLASS="tablebody" align="left">
                <textarea name="fdesc" cols="50" rows="15"><?php echo $vitemdescription?></textarea>
            </td>
		</tr>
		<tr>
			<td width="180" CLASS="tablebody" align="right">Loan Group:</td>
			<td width="300" CLASS="tablebody" align="left"><?php
			if ($action=='edit')
				{
				$ListQuery = "SELECT loangroup FROM loangroups";
			
				$ListResult = @mysql_query($ListQuery);
				$ListNum = mysql_num_rows($ListResult);
				if ($ListNum>=1)
					{
					?>
					<SELECT NAME="flgroup" SIZE="1"><?php
					for ($i=1; $i<=$ListNum; $i++) 
						{
						$ListRow = @mysql_fetch_array($ListResult);
						?>
					<OPTION VALUE="<?php echo $ListRow["loangroup"];?>" <?PHP if (@$ListRow["loangroup"]==$lgroup) print ' selected="selected"';?>><?=$ListRow["loangroup"];?></OPTION>					
						<?php	
						} //END for ($i=1; $i<=$ListNum; $i++)
					?>
					</SELECT><?php
					} //END if ($ListNum>=1)
				} //END if ($action=='edit')
			else
				{
				print $lgroup.'&nbsp;';
				?>
				<INPUT TYPE="hidden" NAME="flgroup" VALUE="<?php echo $lgroup?>">                
                <?php
				}
            ?>
            </td>
		</tr>
		<!--<tr>
			<td CLASS="tablebody" align="right">Sort Order:</td>
			<td CLASS="tablebody" align="left">
				<INPUT TYPE="text" NAME="fsort" MAXLENGTH="6" SIZE="6" VALUE="<?=$vsortorder?>">            
            </td>
		</tr>-->
		<tr>
			<td CLASS="tablebody" align="right">Serial No:</td>
			<td CLASS="tablebody" align="left">
				<INPUT TYPE="text" NAME="fserial" MAXLENGTH="50" SIZE="50" VALUE="<?php echo $vitemserial?>">
            </td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Model No:</td>
			<td CLASS="tablebody" align="left">
   				<INPUT TYPE="text" NAME="fmodel" MAXLENGTH="60" SIZE="50" VALUE="<?php echo $vitemmodel?>">
            </td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Warning Amber*:</td>
			<td CLASS="tablebody" align="left">
			<INPUT TYPE="text" NAME="famberwarn" MAXLENGTH="4" SIZE="4" VALUE="<?php echo $vwarningamber?>">
            </td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Warning Red* (Max No. of days to keep an Ipad):</td>
			<td CLASS="tablebody" align="left">
			<INPUT TYPE="text" NAME="fredwarn" MAXLENGTH="4" SIZE="4" VALUE="<?php echo $vwarningred?>">
            </td>
		</tr>
		<tr>
			<td CLASS="tablebody" align="right">Item Visible to loan:</td>
			<td CLASS="tablebody" align="left">
			<SELECT NAME="fitemvisible" SIZE="1">
				<OPTION VALUE="0" <?PHP if (@$vitemvisible=="0") print ' selected="selected"';?>>NO</OPTION>
				<OPTION VALUE="1" <?PHP if (@$vitemvisible<>"0") print ' selected="selected"';?>>YES</OPTION>
       		</SELECT>
            </td>
		</tr>
		<?php
		if ($vitemloanflag=='1')
			{
		?>
		<tr>
			<td CLASS="tablebody" align="right" valign="middle">Loan to Notes:<BR><em>(This is only visible while<BR>item is out on loan)</em></td>
			<td CLASS="tablebody" align="left"><textarea name="fitemloanedtonotes" cols="50" rows="2"><?=$vitemloanedtonotes?></textarea>            
&nbsp;</td>
		</tr>		
		<?php	} //END if ($vitemloanflag=='1')     ?>
        <tr>
			<td CLASS="tablebody" align="right">If Stolen/Lost Notes:</td>
			<td CLASS="tablebody" align="left">
            <textarea name="fitemstolennotes" cols="50" rows="5"><?php echo $vitemstolennotes?></textarea>
            </td>
		</tr>
        <tr>
        	<td colspan="2" align="center"><b><em>* THESE FIELDS MUST NOT BE LEFT BLANK</em></b></td>
        </tr>
		<tr>
			<td align="right">
		   	    <INPUT TYPE="submit" NAME="submit" VALUE="Exit/Cancel">
            </td>
        <?php
		if (canupdate())   // Is this person an admin user?
			{
		?>
			<td align="right">
	   	    <INPUT TYPE="submit" NAME="submit" VALUE="Save Changes">
            </td>
        <?php	} //END if (canupdate())
		?>
		</tr>
		</table>
        </div>
		</FORM>
		<?PHP
		} //END if (($action=='add') or ($action=='edit'))


	if (($action=='del'))
		{
			
		$LookupQuery = "SELECT 
							uid,
							itembarcode,
							itemtitle,
							loangroup
						FROM 
							loansystem
						WHERE 
							uid='".$uid."'";

		$LookupResult = @MYSQL_QUERY($LookupQuery);
		$LookupNum = mysql_num_rows($LookupResult);			
		$LookupRows = @mysql_fetch_array($LookupResult);
		?>
		<H1>DELETE A LOAN ITEM</H1>
	    <BR>
		<p align="center">Are you sure you want to delete the following loan item?</p>
        <div align="center">
		<form name="form1" method="post" action="">
		<INPUT TYPE="hidden" NAME="action" VALUE="delloanitem">
		<INPUT TYPE="hidden" NAME="uid" VALUE="<?php echo $uid;?>">
		<INPUT TYPE="hidden" NAME="barcode" VALUE="<?php echo $LookupRows["itembarcode"];?>">
		<INPUT TYPE="hidden" NAME="lgroup" VALUE="<?php echo $LookupRows["loangroup"];?>">        
        <table width="500" cellspacing="2" cellpadding="2" align="center">

			<tr valign="middle"> 
				<td width="200" nowrap align="right" CLASS="tablebody"><b>Barcode :</b></td>
				<td width="300" nowrap align="left" CLASS="tablebody">
					<?PHP print $LookupRows["itembarcode"];?>&nbsp;
				</td>
			</tr>

			<tr valign="middle"> 
				<td nowrap align="right" CLASS="tablebody"><b>Item Title:</b></td>
				<td nowrap align="left" CLASS="tablebody">
					<?PHP print $LookupRows["itemtitle"];?>&nbsp;
				</td>
			</tr>

			<tr valign="middle"> 
				<td nowrap align="right" CLASS="tablebody"><b>Loan Group:</b></td>
				<td align="left" CLASS="tablebody">
					<?PHP print $LookupRows["loangroup"];?>&nbsp;
				</td>
			</tr>
        
			<tr valign="middle"> 
				<td nowrap colspan="2" >&nbsp;</td>
			</tr>
        
			<tr valign="middle"> 
				<td nowrap align="center" colspan="2" >
			   	    <INPUT TYPE="submit" NAME="submit" VALUE="Exit/Cancel">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<INPUT TYPE="submit" NAME="submit" VALUE="DELETE THIS ITEM">
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




