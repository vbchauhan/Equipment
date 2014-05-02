<?PHP
function focus($form,$field)
	{
	print '<SCRIPT TYPE="text/javascript" LANGUAGE="javascript">';
	print 'document.'.$form.'.'.$field.'.focus();';
	print '</SCRIPT>';
	} // END function focus($form,$field)


function leftstr($str,$len)
	{
	$length=strlen($str);
	if ( $len > $length ) $len=$length;
	$tempstr=substr($str, 0, $len);
	return ($tempstr);
	} //END function leftstr($str,$len)


function rightstr($str,$len)
	{
	$length=strlen($str);
	if ( $len > $length ) $len=$length;
	$tempstr=substr($str, $length-$len, $len);
	return ($tempstr);
	} //END function rightstr($str,$len)
	
function dateDiff($dt1, $dt2, $timeZone = 'GMT') {
$tZone = new DateTimeZone($timeZone);
$dt1 = new DateTime($dt1, $tZone);
$dt2 = new DateTime($dt2, $tZone);
$ts1 = $dt1->format('Y-m-d');
$ts2 = $dt2->format('Y-m-d');
$diff = abs(strtotime($ts1)-strtotime($ts2));
$diff/= 3600*24;
return $diff;
}

function countdays($fromdate,$todate)
	{
	$datetime1 = new DateTime($fromdate);
	$datetime2 = new DateTime($todate);
	$interval = $datetime1->diff($datetime2);
	$DifDays=intval($interval->format('%a'));
	return $DifDays;
	} //END function countdays($fromdate,$todate)


function displaymailto($EmailAddresses, $ShortCaption, $LongCaption)
	{
	$resultstr=0;
	if (strlen($EmailAddresses)>=2)
		{
		print '<DIV Align="right">';
		if (strlen($EmailAddresses)<=1500)
			{
			print '[<A HREF="mailto:'.$EmailAddresses.'">'.$ShortCaption.'</A>]';
			$resultstr=1;
			} //END if (strlen($EmailAddresses)<=1500)
		else 
			{
			$_SESSION["EmailAddresses"]=$EmailAddresses; // Pass the emails via a session variable to the displayemailaddresses web page.
			print '[<A HREF="/'.strtolower($_SESSION["SystemNameStr"]).'/email_list.php" TARGET="_blank">'.$LongCaption.'</A>]';
			$resultstr=2;
			} //END ELSE if (strlen($EmailAddresses)<=1500)
		print '</DIV>';
		} //END if (strlen($EmailAddresses)>=2)
	return $resultstr;
	} //END function displaymailto($EmailAddresses, $ShortCaption, $LongCaption)


function pwHash($input) 
	{ 
	return leftstr(str_rot13(base64_encode(hash('sha512', $input))),200); 
	} //END pwHash($input)

function canupdate() 
	{ 
	if (@$_SESSION["AUTH_USER_TYPE"]=='ADMIN')
		return true;
	else
		return false;
	} //END canupdate()


function lookupbarcode($barcodedata,$LoanOverride)
	{
	$ListQuery = "SELECT * FROM loansystem WHERE ((itembarcode='".$barcodedata."') and (itemvisible='1'))";
	$ListResult = @mysql_query($ListQuery);
	$ListNum = mysql_num_rows($ListResult);

	if ($ListNum>=1)
		{
		$ListQueryRow = @mysql_fetch_array($ListResult);
		$stitle=$ListQueryRow["shortitemtitle"];
		if ($LoanOverride>=1)
			$maxloandays='MaxLoan '.$LoanOverride.' days';			
		else
			$maxloandays='MaxLoan '.$ListQueryRow["warningred"].' days';
		
		if ($ListQueryRow["itemloanflag"]==1)
			$loanflag='ITEM IS ON LOAN ALREADY!!';
		else
			$loanflag='Available To Be Loaned';
		
		$OutputStr=strtoupper($barcodedata).', '.$stitle.', '.$maxloandays.', '.$loanflag;
		return $OutputStr;
		} //END if ($ListNum>=1)
	else
		return '';

	} //END function lookupbarcode($barcodedata)


function IsItemOnLoan($barcodedata)
	{
	$ListQuery = "SELECT * FROM loansystem WHERE (itembarcode='".$barcodedata."')";
	$ListResult = @mysql_query($ListQuery);
	$ListNum = mysql_num_rows($ListResult);

	if ($ListNum>=1)
		{
		$ListQueryRow = @mysql_fetch_array($ListResult);
		$stitle=$ListQueryRow["shortitemtitle"];
		if ($ListQueryRow["itemloanflag"]==1)
			$OutputStr=1;
		else
			$OutputStr=0;
		
		return $OutputStr;
		} //END if ($ListNum>=1)
	else
		return '';
	} //END IsItemOnLoan($barcodedata)


function lookupperson($ssid,$semail,$sname,$sphone)
	{
	// function will return the following if a record is found
	// staffid,email,name,phone,isstaffmemeber,uid
	
	$csid=strtolower($ssid);
	$cemail=strtolower($semail);
//	$cname=strtolower($sname);
//	$cphone=strtolower($sphone);
	
	if ((strlen($csid))<=1) $csid='99999988899999999a';
	if ((strlen($cemail))<=1) $cemail='99999988899999999a';
//	if ((strlen($cphone))<1) $cphone='99999988899999999a';				

	if ((strlen($cname))<1) 
		{
//		$cname='99999988899999999a';
//		$cnamefirst='99999988899999999a';
//		$cnamelast='99999988899999999a';
		} //END if (strlen($cname)<=1)
	else
		{
		$namebreak=strpos($cname,' ');
		if ($namebreak>=3)
			{
			$cnamefirst=leftstr($cname,$namebreak);
			$cnamelast=rightstr($cname,(strlen($cname)-($namebreak+1)));			
			} //END if ($namebreak>=3)
			else
				{
				$cnamefirst=$cname;
				$cnamelast=$cname;
				} //END ELSE if ($namebreak>=3)			
		} //END ELSE if (strlen($cname)<=1)

		$LookupQuery = "SELECT			
							uid,
							loginid,
							email,
							lastname,
							firstname,
							proxycardno,
							barcode,
							phone
						FROM people WHERE 
								((LOWER(loginid)='".strtolower($csid)."') or 
								(LOWER(email)='".strtolower($cemail)."') or 
								(LOWER(proxycardno)='".strtolower($csid)."') or 
								(LOWER(barcode)='".strtolower($csid)."'))";						
		$LookupResult = @mysql_query($LookupQuery);
		$LookupNum = mysql_num_rows($LookupResult);

		if ($LookupNum>=1)
			{
			$LookupQueryRow = @mysql_fetch_array($LookupResult);
			$OutputStr=$LookupQueryRow["loginid"].','.$LookupQueryRow["email"].','.$LookupQueryRow["firstname"].' '.$LookupQueryRow["lastname"].','.$LookupQueryRow["phone"].',1,'.$LookupQueryRow["uid"];
			return $OutputStr;
			} //END if ($LookupNum>=1)
		else
			{
			$LookupQuery2 = "SELECT
								uid,
								staffid,
								email,
								name,
								phone
							FROM namecache WHERE 
									((LOWER(staffid)='".$csid."') or 
									(LOWER(email)='".strtolower($cemail)."'))";						
			$LookupResult2 = @mysql_query($LookupQuery2);
			$LookupNum2 = mysql_num_rows($LookupResult2);
			$LookupQueryRow2 = @mysql_fetch_array($LookupResult2);			
			if ($LookupNum2>=1)
				{
				$LookupQueryRow = @mysql_fetch_array($LookupResult);
				$OutputStr=$LookupQueryRow2["staffid"].','.$LookupQueryRow2["email"].','.$LookupQueryRow2["name"].','.$LookupQueryRow2["phone"].',0,'.$LookupQueryRow2["uid"];
				return $OutputStr;							
				} //END if ($LookupNum2>=1)
			else
				{
				return '';					
				} //END ELSE if ($LookupNum2>=1)

			} //END ELSE if ($LookupNum>=1)
	} //END lookupperson($ssid,$semail,$sname,$sphone)


function loanstatus($AmberNum,$RedNum,$OverrideNum,$StartDate)
	{
	$OutputStr='';
	$DayCount = dateDiff($StartDate,date('Y-m-d'));	
	if ($OverrideNum>=1)
		{
		// Figure out the Amber Alert number
		$AmberCountNum=$OverrideNum-3;
		if ($AmberCountNum<=0) $AmberCountNum=$OverrideNum-1; 
		if ($AmberCountNum<=0) $AmberCountNum=$OverrideNum+1;  // disable the amber alert...	
		if ($DayCount <= ($AmberCountNum)) $OutputStr = 'green';
		if ($DayCount >= $AmberCountNum) $OutputStr = 'amber';
		if ($DayCount >= $OverrideNum) $OutputStr = 'red';		
		} //END if ($OverrideNum>=1)
	else
		{
		if ($DayCount <= $AmberNum) $OutputStr = 'green';
		if ($DayCount >= $AmberNum) $OutputStr = 'amber';
		if ($DayCount >= $RedNum) $OutputStr = 'red';
		} //END if ($OverrideNum>=1)
	return $OutputStr;
	} //END loanstatus($AmberNum,$RedNum,$OverrideNum,$StartDate)


function text_protect($InputStr)
	{
		// Put your Encryption here.
		// this function is uesed on the MYSQL UserID and password.		
		return $InputStr;
	} // END text_protect($InputStr)
	

function text_unprotect($InputStr)
	{
	// Put your Decryption here.
	// this function is uesed on the MYSQL UserID and password.
	return $InputStr;
	} // END text_unprotect($InputStr)
	


// end of file functions.php
?>