<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
if (canupdate()) 
	{

top();

	$ListQuery = "SELECT 
						*
					FROM
						 loginlogs
					ORDER BY ts DESC";

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
			<TD WIDTH="150" class="tableheading" ALIGN="left"><strong>DateTime</strong></TD>
			<TD WIDTH="250" class="tableheading" ALIGN="center"><strong>UserID</strong></TD>
			<TD WIDTH="50" class="tableheading" ALIGN="center"><strong>UserIP</strong></TD>
			<TD WIDTH="50" class="tableheading" ALIGN="center"><strong>UserDNS</strong></TD>
			<TD WIDTH="50" class="tableheading" ALIGN="center"><strong>Action</strong></TD>
			<TD WIDTH="50" class="tableheading" ALIGN="center"><strong>Result</strong></TD>
		</TR>        
		<tr>
			<td width="250" CLASS="tablebody" align="center" colspan="4">Error: Unable to find any login history in this system!</td>
		</tr>
        </table>
        </div>
		<?php
        } // END if ($ListNum<=0)
	else
		{
		?>
<BR><H3 align="center"><B>Staff Login History</B></H3><?php
	if (@$message) 
		print '<div align="center"><font class="messagetext"><b>'.$message.'&nbsp;</b></font></div><br>';
	else
		print '<br>';
	?>	
        <div align="center">
		<TABLE align="center" width="750" class="tablebox" cellpadding=2 cellspacing=2 border=0>
		<TR>
			<TD WIDTH="150" class="tableheading" ALIGN="left"><strong>DateTime</strong></TD>
			<TD WIDTH="250" class="tableheading" ALIGN="center"><strong>UserID</strong></TD>
			<TD WIDTH="50" class="tableheading" ALIGN="center"><strong>UserIP</strong></TD>
			<TD WIDTH="50" class="tableheading" ALIGN="center"><strong>UserDNS</strong></TD>
			<TD WIDTH="50" class="tableheading" ALIGN="center"><strong>Action</strong></TD>
			<TD WIDTH="50" class="tableheading" ALIGN="center"><strong>Result</strong></TD>
		</TR>
		<?php
		for ($i=1; $i<=$ListNum; $i++) 
			{
			$ListQueryRow = @mysql_fetch_array($ListResult);
        ?>
		<TR>
			<TD class="tablebody" NOWRAP ALIGN="left"><?php echo $ListQueryRow["ts"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="left"><?php echo $ListQueryRow["userid"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["userip"];?></TD>					
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["userdns"];?></TD>					
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["action"];?></TD>
			<TD class="tablebody" NOWRAP ALIGN="center"><?php echo $ListQueryRow["result"];?></TD>            
		</TR>


		<?php
			} //END for ($i=1; $i<=$ListNum; $i++)
		?>
		</table>
        
        <BR>
        <form name="form1scan" method="post" action="download.php" target="_blank">
		    <input type="hidden" name="action" value="UserLoginsCSVl">
		    <input type="hidden" name="lgroup" value="<?php echo $lgroup?>">
		    <input type="hidden" name="userinputdata" value="<?php echo $_POST["userinputdata"]?>">            
			<input type="submit" name="submit" value="Download .CSV List">
		</form>
        </div>
		<?php
		} //END ELSE if ($ListNum<=0)
	
	}//END if (canupdate()) 
bottom();
?>