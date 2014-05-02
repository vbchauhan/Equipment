<?php 
//include_once($_SERVER['HTTP_HOST']."/equipment/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
//$dbok = mysql_connect('localhost', 'madhus', '');
//$mysql_db = mysql_select_db('equipment', $dbok);
ini_set('display_errors', '1');

$action=@$_POST["Submit"]; 	// Check if action variable was Posted

if ($action)
	{
	$action=@$_POST["action"];
	$lgroup=@$_POST["lgroup"];
	$message=@$_POST["message"];
	$listsort=@$_POST["flistsort"];
	}
else
	{
	$action=@$_GET["action"];
	$lgroup=@$_GET["lgroup"];
	$message=@$_GET["message"];	
	$listsort=@$_GET["flistsort"];
	}

if ($action=='loangroupset')
	{
	$_SESSION["LOANSYSTEM_GROUP"]=$lgroup;
	if(@$_SESSION["AUTH_USER"]==true)
		Header("Location: /".strtolower($_SESSION["SystemNameStr"])."/");
	else
		Header("Location: /".strtolower($_SESSION["SystemNameStr"])."/view");		
	exit;
	}

top();

if (@$_SESSION["AUTH_USER"]==true)
	{
	if ((strlen(@$_SESSION["LOANSYSTEM_GROUP"])<=1) or ($action=='loangroupselect'))
		{
		$GroupQuery = "select loangroup FROM loangroups WHERE groupvisible='1'";
		$GroupResult = @mysql_query($GroupQuery);
		$GroupNums = mysql_num_rows($GroupResult);			
		if ($GroupNums==1)
			{
			$GroupRows = @mysql_fetch_array($GroupResult);
			$_SESSION["LOANSYSTEM_GROUP"]=$GroupRows["loangroup"];
			$action='listloanitems';
			} //END if ($GroupNums==1)
		else
			{ 
			$action='loangroupset';
			?>

<BR>
<H1>SELECT LOAN SYSTEM</H1>
<BR>
<?php  
		$Query = "select loangroup,loangrouptitle,loangroupdescription FROM loangroups WHERE groupvisible='1'";
		$Result = @mysql_query($Query);
		$Nums = mysql_num_rows($Result);
		
		if ($Nums>=1)
			{
?>
<div align="center">
<table width="300" border="0" align="center"><?php 
		for ($i=1; $i<=$Nums; $i++) 
			{
			$Rows = @mysql_fetch_array($Result);
		?>
		<tr>
			<td align="center" CLASS="tablebody">
            <FORM NAME="form1" METHOD="post" ACTION="">
			<INPUT TYPE="hidden" NAME="action" VALUE="loangroupset">
			<INPUT TYPE="hidden" NAME="lgroup" VALUE="<?php echo $Rows['loangroup'];?>">
	   	    &nbsp;<INPUT TYPE="submit" NAME="Submit" VALUE="<?php echo strtoupper($Rows['loangrouptitle'])?>">
			</FORM>
            <?php print $Rows['loangroupdescription']?><BR><BR>
            </td>
		</tr>
		<?php 
    	    } //END for ($i=1; $i<=$Nums; $i++)
?>
</table>
</div>
<?php 
			} //END if ($Nums>=1)
		else
			{?>
<div align="center">            
<table width="300" border="0" align="center">
		<tr>
			<td align="center" CLASS="tablebody">
            <em>No loan groups avaliable!</em><BR>
            </td>
		</tr>
</table>
</div>
			<?php 				
			} //END ELSE if ($Nums>=1)
			} //END ELSE if ($GroupNums==1)
		} //END if ((strlen(@$_SESSION["LOANSYSTEM_GROUP"])<=1) or ($action='loangroupselect'))


if ((@$_SESSION["AUTH_USER"]==true) and ($action<>'loangroupset'))
		{?>
<BR>
<H1><?php  print @$_SESSION["LOANSYSTEM_GROUP"];?></H1>

<?php 
if (@$message) 
	print '<div align="center"><font class="messagetext"><b>'.$message.'&nbsp;</b></font></div>';
else
	print '<br>';
?>

	<table align="center" width="90%" border="0" class="tablebox">
	<tr>
    	<td align="center" CLASS="tablebody" valign="middle">
		<form name="form1scan" method="post" action="checkitem.php">
		    <input type="hidden" name="action" value="scanitem">
			<p align="center">SCAN ITEM BARCODE HERE: <input type="text" name="scanitemdata" size="20" maxlength="20" value="">
			<input type="submit" name="submit"  autofocus="autofocus" value="GO">
			</p>
		</form>
		<?php  focus('form1scan','scanitemdata'); ?>
		</td>
	</tr>
	</table>
<BR>

<?php 
		$lgroup=@$_SESSION["LOANSYSTEM_GROUP"];
		
		$SortNum=999;
		$MaSortDir='';
		if (strlen($listsort)>=2)
			{
			//Sort Array 
			// 0=itembarcode, 1=shortitemtitle, 2=itemloanedtoname, 3=itemloanedtoemail, 
			// 4=itemloanedtophone, 5=itemloanedtologinid,6=itemloandatestart,7=warningamber,
			// 8=warningred, 9=itemloanflag, 10=sortorder, 11=itemvisible,12=ItemStatus,
			// 13=ItemStatusNum, 14=DaysOnLoan, 15=uid			

			if ($listsort=='sortorder') $SortNum=10;
			if ($listsort=='barcode') $SortNum=0;
			if ($listsort=='name') $SortNum=2;
			if ($listsort=='loandaysa') $SortNum=14;		
			if ($listsort=='loandaysd') 
				{
				$SortNum=14;
				$MaSortDir='SORT_DESC';				
				}
			if ($listsort=='statusa') $SortNum=13;
			if ($listsort=='statusd') 
				{
				$SortNum=13;
				$MaSortDir='SORT_DESC';
				} //END if ($listsort=='statusd')
			if ($SortNum==999) 
				{
				$SortNum=10; // catchall
				$listsort='sortorder';
				} //END if ($SortNum==999)
			} //END if (strlen($listsort)>=2)
		else
			{
			$SortNum=10; 
			$listsort='sortorder';
			} //END ELSE if (strlen($listsort)>=2)

		// Get All Records relating to a particular loan group
		$queryitems = "SELECT * FROM loansystem WHERE loangroup =  '".$lgroup."'".$SortStr;
		$resultitems=@mysql_query($queryitems);
		$numitems= @mysql_num_rows($resultitems);
		//$rowitem = mysql_fetch_array($resultitems);

		$greenlist='';
		$amberlist='';
		$redlist='';
		$alllist='';

		if ($numitems>=1)
			{
			// Populate Array
			for ($k=0; $k < $numitems; $k++)
				{
				
				$rowitem = mysql_fetch_array($resultitems);
				$ItemStatus=loanstatus($rowitem["warningamber"],$rowitem["warningred"],$rowitem["loanoverride"],$rowitem["itemloandatestart"]);

				if ($rowitem["itemloanflag"]=='1')	// Create email lists
					{
					if ($ItemStatus=='green')
						{
						if (strlen($greenlist)<=1)
							{
							if (strlen($rowitem["itemloanedtoemail"])>=2) $greenlist=$greenlist.$rowitem["itemloanedtoemail"];
							}
						else
							{
							if (strlen($rowitem["itemloanedtoemail"])>=2) $greenlist=$greenlist.';'.$rowitem["itemloanedtoemail"];
							}
						} //END if ($ItemStatus=='green')

					if ($ItemStatus=='amber')
						{
						if (strlen($amberlist)<=1)
							{
							if (strlen($rowitem["itemloanedtoemail"])>=2) $amberlist=$amberlist.$rowitem["itemloanedtoemail"];
							}
						else
							{
							if (strlen($rowitem["itemloanedtoemail"])>=2) $amberlist=$amberlist.';'.$rowitem["itemloanedtoemail"];
							}
						} //END if ($ItemStatus=='amber')
						
					if ($ItemStatus=='red')
						{
						if (strlen($redlist)<=1)
							{
							if (strlen($rowitem["itemloanedtoemail"])>=2) $redlist=$redlist.$rowitem["itemloanedtoemail"];
							}
						else
							{
							if (strlen($rowitem["itemloanedtoemail"])>=2) $redlist=$redlist.';'.$rowitem["itemloanedtoemail"];
							}
						} //END if ($ItemStatus=='red')

						// All People using the loan system
						if (strlen($alllist)<=1)
							{
							if (strlen($rowitem["itemloanedtoemail"])>=2) $alllist=$alllist.$rowitem["itemloanedtoemail"];
							}
						else
							{
							if (strlen($rowitem["itemloanedtoemail"])>=2) $alllist=$alllist.';'.$rowitem["itemloanedtoemail"];
							}
						
					} //END if ($rowitem["itemloanflag"]=='1')
				
				if ($ItemStatus=='green') $ItemStatusNum=1;
				if ($ItemStatus=='amber') $ItemStatusNum=2;			
				if ($ItemStatus=='red') $ItemStatusNum=3;
				if (($ItemStatus<>'green') and ($ItemStatus<>'amber') and ($ItemStatus<>'red')) $ItemStatusNum=0;
				if ($rowitem["itemloanflag"]<>'1') $ItemStatusNum=0;
				if ($rowitem["itemloanflag"]<>'1') $ItemStatus='';
				// Ambarish fix for time bug
				
		
				$SortArray[$k]=array($rowitem["itembarcode"],$rowitem["shortitemtitle"],$rowitem["itemloanedtoname"],$rowitem["itemloanedtoemail"],$rowitem["itemloanedtophone"],$rowitem["itemloanedtologinid"],$rowitem["itemloandatestart"],$rowitem["warningamber"],$rowitem["warningred"],$rowitem["itemloanflag"],$rowitem["sortorder"],$rowitem["itemvisible"],$ItemStatus,$ItemStatusNum,dateDiff($rowitem["itemloandatestart"],date("Y-m-d")),$rowitem["uid"] );
				
				
				
				//Sort Array 
				// 0=itembarcode, 1=shortitemtitle, 2=itemloanedtoname, 3=itemloanedtoemail, 
				// 4=itemloanedtophone, 5=itemloanedtologinid,6=itemloandatestart,7=warningamber,
				// 8=warningred, 9=itemloanflag, 10=sortorder, 11=itemvisible,12=ItemStatus,
				// 13=ItemStatusNum, 14=DaysOnLoan, 15=uid
				}

			// Sort Array

			$tmp = Array();
			foreach($SortArray as &$ma) 
    			$tmp[] = &$ma[$SortNum];  
			
			if (@$MaSortDir=='SORT_DESC')
				array_multisort($tmp, SORT_DESC, $SortArray);
			else
				array_multisort($tmp, SORT_ASC, $SortArray);			

			if (strlen($greenlist)>=6)
				{
				// Removes Duplicates within the Green email list
				$TmpDataArr=explode(';',$greenlist);
				$TmpRemoveDupsArr=array_count_values($TmpDataArr);
				$greenlist='';
				foreach( $TmpRemoveDupsArr as $itemstr => $itemstrdata)
					{
					if (strlen($greenlist)<=1)
						$greenlist=$itemstr;
					else
						$greenlist=$greenlist.';'.$itemstr;
					} //END foreach( $TmpRemoveDupsArr as $itemstr => $itemstrdata)
				} // END if (strlen($greenlist)>=6)

			if (strlen($amberlist)>=6)
				{
				// Removes Duplicates within the amber email list
				$TmpDataArr=explode(';',$amberlist);
				$TmpRemoveDupsArr=array_count_values($TmpDataArr);
				$amberlist='';
				foreach( $TmpRemoveDupsArr as $itemstr => $itemstrdata)
					{
					if (strlen($amberlist)<=1)
						$amberlist=$itemstr;
					else
						$amberlist=$amberlist.';'.$itemstr;
					} //END foreach( $TmpRemoveDupsArr as $itemstr => $itemstrdata)
				} // END if (strlen($amberlist)>=6)

			if (strlen($redlist)>=6)
				{
				// Removes Duplicates within the Red email list
				$TmpDataArr=explode(';',$redlist);
				$TmpRemoveDupsArr=array_count_values($TmpDataArr);
				$redlist='';
				foreach( $TmpRemoveDupsArr as $itemstr => $itemstrdata)
					{
					if (strlen($redlist)<=1)
						$redlist=$itemstr;
					else
						$redlist=$redlist.';'.$itemstr;
					} //END foreach( $TmpRemoveDupsArr as $itemstr => $itemstrdata)
				} // END if (strlen($redlist)>=6)				


		if ($rowqueryloangroup["verbosedisplay"]=='1')
			$colspanvalue=2;
		else
			$colspanvalue=3;			
		?>
		<H1 align="left">ITEM STATUS</H1>
   		<FORM NAME="form1" METHOD="post" ACTION="" ENCTYPE="multipart/form-data"> 
		<table align="center" width="90%" border="0" class="tablebox">
   			<TR> 
				<TD align="right" colspan="<?php echo $colspanvalue;?>">Sort By:
				<SELECT NAME="flistsort" SIZE="1">
					<!--<OPTION VALUE="sortorder" <?php  if (@$listsort=="sortorder") print ' selected="selected"';?>>SortOrder</OPTION>-->
					<OPTION VALUE="statusa" <?php  if (@$listsort=="statusa") print ' selected="selected"';?>>Status (ascending)</OPTION>
					<OPTION VALUE="statusd" <?php  if (@$listsort=="statusd") print ' selected="selected"';?>>Status (descending)</OPTION>
					<OPTION VALUE="loandaysa" <?php  if (@$listsort=="loandaysa") print ' selected="selected"';?>>LoanDays (ascending)</OPTION>
					<OPTION VALUE="loandaysd" <?php  if (@$listsort=="loandaysd") print ' selected="selected"';?>>LoanDays (descending)</OPTION>					
                    <OPTION VALUE="name" <?php  if (@$listsort=="name") print ' selected="selected"';?>>Name</OPTION>
					<OPTION VALUE="barcode" <?php  if (@$listsort=="barcode") print ' selected="selected"';?>>Barcode</OPTION>
	       		</SELECT>
				<INPUT TYPE="submit" name="Submit" value="UPDATE">
                &nbsp;</TD>                
			</TR>	
			<?php 
			$queryloangroup = "SELECT verbosedisplay,cachenames FROM loangroups WHERE loangroup='".@$_SESSION["LOANSYSTEM_GROUP"]."'";
			$resultqueryloangroup=@mysql_query($queryloangroup);
			$rowqueryloangroup = @mysql_fetch_array($resultqueryloangroup); 
			if ($rowqueryloangroup["verbosedisplay"]=='1')
				{
				$MaxColNum=5;	// Max num Columns
				$ColNum=1;		// counter
				foreach($SortArray as &$ma)
					{
					if ($ColNum==1) print '<tr>';
					print '<td align="center" CLASS="tablebody" valign="middle">';
					if ($ma[9]=='1')
						{
						if ($ma[12]=='green') print '<b class="GreenAlertText">';
						if ($ma[12]=='amber') print '<b class="AmberAlertText">';
						if ($ma[12]=='red') print '<b class="RedAlertText">';
						}
					$TextDecoration=' style="text-decoration: none"';
					print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/loanitemdetail.php?action=viewitem&uid='.$ma[15].'"'.$TextDecoration.' target="_self">';
					
					//print $ma[0].':&nbsp;'.$ma[1].',&nbsp;';  Ambarish changed it to      print $ma[1].',&nbsp;';
					print $ma[1].',&nbsp;';
					if ($ma[9]=='1') 
						{
						$titlestr = 'PHONE: '.$ma[4].', EMAIL: '.$ma[3];													
						print '<b title="'.$titlestr.'">'.$ma[2].'</b>,&nbsp;';
						
						if ($ma[14]<=0) 
							print 'Today';
						else
							{
							print $ma[14].' day';
							if ($ma[14]>=2) print 's';
							} //END ELSE ($ma[14]<=0)
						} //END if ($ma[9]=='1')
					else
						print 'Available';

					print '</a>'; // Close hyperlink
					
					if ($ma[9]=='1') print '</b>'; // Close text colour

					print '</td>';					
					if ($ColNum>=$MaxColNum)
						{
						print '</tr>';
						$ColNum=0;
						} //END if ($ColNum==$MaxColNum)
					$ColNum=$ColNum+1;
					} //END foreach($SortArray as &$ma)
		?>
   			<TR> 
				<TD align="right" colspan="2">&nbsp;</TD>
            </TR>
   			<TR> 
				<TD align="right" colspan="2"><?php 
					$ResultDisp = displaymailto($redlist, 'email all <b class="RedAlertText">RED:</b> Send Recall Email', 'cut and paste email addresses for <b class="RedAlertText">RED</b> loan people');
					$ResultDisp = displaymailto($amberlist, 'email all <b class="AmberAlertText">AMBER: </b> Send Recall Email', 'cut and paste email addresses for <b class="amberAlertText">AMBER</b> loan people');
					$ResultDisp = displaymailto($greenlist, '<b class="GreenAlertText">GREEN: </b> Send Recall Email', 'cut and paste email addresses for <b class="GreenAlertText">GREEN:</b> loan people');
					$ResultDisp = displaymailto($alllist, 'Send Recall Email to All patrons', 'cut and paste email addresses for ALL loan people');
                ?></TD>
            </TR>
        
        </FORM>
		<?php 
				} //END if ($rowqueryloangroup["verbosedisplay"]=='1')
			else
				{
				$ColNum=1;
				$MaxColNum=6;
				foreach($SortArray as &$ma)
					{
					if ($ColNum==1) print '<tr>';
					print '<td align="center" CLASS="tablebody" valign="middle">';
					if ($ma[9]=='1')
						{
						if ($ma[12]=='green') print '<b class="GreenAlertText">&nbsp;&nbsp;';
						if ($ma[12]=='amber') print '<b class="AmberAlertText">&nbsp;&nbsp;';
						if ($ma[12]=='red') print '<b class="RedAlertText">&nbsp;&nbsp;';
						}
					$TextDecoration=' style="text-decoration: none"';
					print '<a href="/'.strtolower($_SESSION["SystemNameStr"]).'/loanitemdetail.php?action=viewitem&uid='.$ma[15].'"'.$TextDecoration.' target="_self">';
					
					print $ma[0].':&nbsp;'.$ma[1].'&nbsp;&nbsp;';
					
					if ($ma[9]=='1') 
						{
						$titlestr = 'PHONE: '.$ma[4].', EMAIL: '.$ma[3];													
						print '<BR>&nbsp;&nbsp;Loaned To:<b title="'.$titlestr.'">'.$ma[2].'</b>&nbsp;&nbsp;<BR>';
						
						if ($ma[14]<=0) 
							print 'Today';
						else
							{
							print '&nbsp;&nbsp;'.$ma[14].' day';
							if ($ma[14]>=2) print 's';
							} //END ELSE ($ma[14]<=0)
						} //END if ($ma[9]=='1')
					else
						print '<BR>Item Available';

					print '</a>'; // Close hyperlink
					
					if ($ma[9]=='1') print '&nbsp;&nbsp;</b>'; // Close text colour

					print '</td>';					
					if ($ColNum>=$MaxColNum)
						{
						print '</tr>';
						$ColNum=0;
						} //END if ($ColNum==$MaxColNum)
					$ColNum=$ColNum+1;
					} //END foreach($SortArray as &$ma)
		?>
   			<TR> 
				<TD align="right" colspan="2">&nbsp;</TD>
            </TR>
            <TR> 
				<TD align="right" colspan="3"><?php 
					$ResultDisp = displaymailto($redlist, 'email all <b class="RedAlertText">RED</b> loan people', 'cut and paste email addresses for <b class="RedAlertText">RED</b> loan people');
					$ResultDisp = displaymailto($amberlist, 'email all <b class="AmberAlertText">AMBER</b> loan people', 'cut and paste email addresses for <b class="amberAlertText">AMBER</b> loan people');
					$ResultDisp = displaymailto($greenlist, 'email all <b class="GreenAlertText">GREEN</b> loan people', 'cut and paste email addresses for <b class="GreenAlertText">GREEN</b> loan people');
					$ResultDisp = displaymailto($alllist, 'email ALL loan people', 'cut and paste email addresses for ALL loan people');
                ?></TD>
            </TR>
			<?php 			
				} //END ELSEif ($rowqueryloangroup["verbosedisplay"]=='1')?>
				</table> 
			<?php 
			} //END if ($numitems>=1)
		else			
			{?>
<BR>
<H1> <?php  print @$_SESSION["LOANSYSTEM_GROUP"];?> GROUP</H1>
            
<div align="center">            
<table width="300" border="0" align="center">
		<tr>
			<td align="center" CLASS="tablebody">
            <em>No loan items avaliable!</em><BR>
            </td>
		</tr>
</table>
</div>				
			<?php 
			} //END ELSE if ($numitems>=1)
		} //END ELSE if ((strlen(@$_SESSION["LOANSYSTEM_GROUP"])<=1) or ($action='loangroupselect'))
		
		
	} //END if (@$_SESSION["AUTH_USER"]==true)

if (@$_SESSION["AUTH_USER"]==false)
	{?>
<BR>
<H1>WELCOME TO THE PRIDDY LIBRARY LOAN SYSTEM</H1>
<BR>
<BR>
<H3>
<BR>
<BR>
To use this system you will need to login, <a href="/equipment/login/index.php" target="_self">click here to login</a>.<b>(STAFF USE ONLY)</b><BR>
<BR> 
<?php 
	$GroupQuery = "select loangroup FROM loangroups WHERE ((groupvisible='1') and (viewitemstatuswithoutlogin='1'))";
	$GroupResult = @mysql_query($GroupQuery);
	$GroupNums = mysql_num_rows($GroupResult);
	if ($GroupNums>=1)
		{
	?>
<BR>
<!--Otherwise you can see the status of items the loan system by <a href="/equipment/view/index.php" target="_self">clicking here for view only access</a>.-->
To request a Hold on the iPad, please submit a request by filling the form  <a href="/equipment/public/request.php" target="_self">Click here to access the Form</a>
</H3>
<?php 
		} //END if ($GroupNums>=1)
	} //END if (@$_SESSION["AUTH_USER"]==false)
bottom();
?>
