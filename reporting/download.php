<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php"); 
include ("global.php");
include ("layout.php");
include ("functions.php");
if (!canupdate())
	{  
	header("HTTP/1.0 404 Not Found");
	exit;
	}

// Get variables
$action=@$_POST["action"]; 					// Check action was a POST variable

if ($action)
	{
	$userinputdata=@$_POST['userinputdata'];
	$lgroup=@$_POST['lgroup'];
	} // END if ($action)
else
	{
	$action=@$_GET['action'];
	$userinputdata=@$_GET["userinputdata"];
	$lgroup=@$_GET["lgroup"];
	}


if ($action=='ItemHistoryCSVl')
	{
	$querylog = "SELECT * FROM loansystemlogs WHERE ((loanitembarcode='".$userinputdata."') and (loangroup='".$lgroup."') and (action='checkinitem')) ORDER BY actiondatetime DESC";	
	
	$resultlog=@mysql_query($querylog);
	$numlog = @mysql_num_rows($resultlog);

	if ($numlog>=1)
		{
		$filename=$userinputdata.'_HISTORY_'.date('Ymd').'.CSV';
		header("Pragma: public");  // Added to allow IE to download through SSL tunnels.
		header("Cache-Control: private");
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=$filename ");

		//CSV HEADER
		print 'DateTimeReturned,LoanToName,DaysLoanedOut,ItemReturnStatus'.chr(13).chr(10);
		
		//CSV DATA
		for ($k=0; $k < $numlog; $k++) 
			{
			$rowlog = mysql_fetch_array($resultlog);
			print $rowlog["actiondatetime"].',';
			print $rowlog["loantoname"].',';
			print $rowlog["daysitemwasonloan"].',';
			print $rowlog["itemreturnstatus"];
			print chr(13).chr(10);
			} //END for ($k=0; $k < $$numlog; $k++)

		} //END if ($numlog>=1)
	} //END  if ($action=='ItemHistoryCSVl')



if ($action=='UserHistoryCSVl')
	{
	$querylog = "SELECT 
						*
					FROM
						 loansystemlogs
					WHERE (((lower(loantologinid )='".strtolower($userinputdata)."' ) or 
							(lower(loantoemail )='".strtolower($userinputdata)."' ) or 
							(lower(loantoname ) LIKE '%".strtolower($userinputdata)."%' )) and 
							(action='checkinitem'))
					ORDER BY actiondatetime DESC";	
	
	$resultlog=@mysql_query($querylog);
	$numlog = @mysql_num_rows($resultlog);

	if ($numlog>=1)
		{
		$filename=$userinputdata.'_HISTORY_'.date('Ymd').'.CSV';
		header("Pragma: public");  // Added to allow IE to download through SSL tunnels.
		header("Cache-Control: private");
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=$filename ");

		//CSV HEADER
		print 'DateTimeReturned,ItemBarcode,LoanGroup,LoanToName,';
		print 'LoanToEmail,LoanToPhone,LoanToLoginID,DaysLoanedOut,ItemReturnStatus';
		print chr(13).chr(10);
		
		//CSV DATA
		for ($k=0; $k < $numlog; $k++) 
			{
			$rowlog = mysql_fetch_array($resultlog);
			print $rowlog["actiondatetime"].',';
			print $rowlog["loanitembarcode"].',';
			print $rowlog["loangroup"].',';			
			print $rowlog["loantoname"].',';			
			print $rowlog["loantoemail"].',';
			print $rowlog["loantophone"].',';			
			print $rowlog["loantologinid"].',';			
			print $rowlog["daysitemwasonloan"].',';
			print $rowlog["itemreturnstatus"];
			print chr(13).chr(10);
			} //END for ($k=0; $k < $$numlog; $k++)

		} //END if ($numlog>=1)
	} //END  if ($action=='UserHistoryCSVl')


if ($action=='UserLoginsCSVl')
	{
	$querylog = "SELECT 
						*
					FROM
						 loginlogs
					ORDER BY ts DESC";	
	
	$resultlog=@mysql_query($querylog);
	$numlog = @mysql_num_rows($resultlog);

	if ($numlog>=1)
		{
		$filename=strtoupper($_SESSION["SystemNameStr"])'_LOGINHISTORY_'.date('Ymd').'.CSV';
		header("Pragma: public");  // Added to allow IE to download through SSL tunnels.
		header("Cache-Control: private");
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=$filename ");

		//CSV HEADER
		print 'DateTime,UserID,UserName,UserIP,UserDNS,Action,Result,Notes';
		print chr(13).chr(10);
		
		//CSV DATA
		for ($k=0; $k < $numlog; $k++) 
			{
			$rowlog = mysql_fetch_array($resultlog);
			print $rowlog["ts"].',';
			print $rowlog["userid"].',';
			print $rowlog["username"].',';			
			print $rowlog["userip"].',';			
			print $rowlog["action"].',';
			print $rowlog["result"].',';			
			print $rowlog["notes"].',';			
			print chr(13).chr(10);
			} //END for ($k=0; $k < $$numlog; $k++)

		} //END if ($numlog>=1)
	} //END  if ($action=='UserHistoryCSVl')


?>