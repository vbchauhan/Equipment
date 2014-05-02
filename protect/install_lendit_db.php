<?PHP
include_once($_SERVER['DOCUMENT_ROOT']."/equipment/protect/global.php");
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

if (strlen($action)<=0) $action='getsetting'; // If no action the default to "list" groups.

if ($submit=='Exit/Cancel')
	{
	$redirectstr="Location: /".strtolower($_SESSION["SystemNameStr"])."/";
	Header($redirectstr);
	exit;
	}
// TEST LINE BELOW
if ($action=='checksettings') 
	{
	if (@$_POST["fverifymysqlsettings"]=='1')
		{
		$vmysqlserver=strtoupper(@$_POST["fmysqlserver"]);
		$vmysqldb=strtoupper(@$_POST["fmysqldb"]);
		$vmysqluser=@$_POST["fmysqluser"];
		$vmysqlpassword=@$_POST["fmysqlpassword"];
		$ConnError=0;
		$ResultStr='';
		// VALIDATING SERVER DETAILS
		$ServerConnResult=mysql_connect($vmysqlserver, $vmysqluser, $vmysqlpassword);
		if ($ServerConnResult<=0)
			{
			if (strlen($message)<=0) $message="* Unable to connect to server ".strtoupper($vmysqlserver).".";
			$ResultStr=$ResultStr."<b>* Unable to connect to server ".strtoupper($vmysqlserver).".</b> <em>(".mysql_error().")</em><br>";
			$ConnError=1;
			}
		else
			{
			$ResultStr=$ResultStr."* Connected to MySQL server ".strtoupper($vmysqlserver).".<br>";		
			}
		//VALIDATING DB DETAILS
		$dbConnResult=mysql_select_db($vmysqldb);
		if ($dbConnResult<=0)
			{ 
			if (strlen($message)<=0) $message="Unable to connect to database ".strtoupper($vmysqldb).".";
			$ResultStr=$ResultStr."<b>* Unable to connect to database ".strtoupper($vmysqldb).".</b> <em>(".mysql_error().")</em><br>";
			$ConnError=1;
			}
		else
			{
			$ResultStr=$ResultStr."* Connected to database ".strtoupper($vmysqldb).".<br />";
			}
		@mysql_close($ServerConnResult);	

		if ($ConnError==1)
			$action='getsetting'; // MYSQL Error found
		else
			$action='verifysetting'; // MySQL Settings are OK
		} //END if (@$_POST["fmysqlserver"]=='1')
	else
		{
		$ConnError=0;
		$ResultStr='';
		$action='verifysetting'; // MySQL Settings are OK
		} //END ELSE if (@$_POST["fverifymysqlsettings"]=='1')
	}//END if ($action=='checksettings') 

top();


if ($action=="verifysetting")
	{
		$vmysqlserver=strtoupper(@$_POST["fmysqlserver"]);
		$vmysqldb=strtoupper(@$_POST["fmysqldb"]);
		$vmysqluser=@$_POST["fmysqluser"];
		$vmysqlpassword=@$_POST["fmysqlpassword"];
			
		print '<H1>ARE YOU SURE YOU WANT TO CONTINUE?</H1>';
        ?>
		<FORM NAME="form1" METHOD="post" ACTION="" ENCTYPE="multipart/form-data">
		<INPUT TYPE="hidden" NAME="action" VALUE="setuploanit">
		<INPUT TYPE="hidden" NAME="fmysqlserver" VALUE="<?=$vmysqlserver?>">
		<INPUT TYPE="hidden" NAME="fmysqldb" VALUE="<?=$vmysqldb?>">
		<INPUT TYPE="hidden" NAME="fmysqluser" VALUE="<?=$vmysqluser?>">
		<INPUT TYPE="hidden" NAME="fmysqlpassword" VALUE="<?=$vmysqlpassword?>">        
		<DIV align="center">
        <TABLE BORDER="0" WIDTH="750">
  			<TR> 
				<TD colspan="2" align="center"><h3>MYSQL CONNECTION DETAILS</h3></TD>
			</TR>
            <TR> 
				<TD nowrap WIDTH="250" CLASS="tablebody" align="right"><B>MY SQL SERVER:</B></TD>
				<TD WIDTH="300" CLASS="tablebody" align="left"><?=$vmysqlserver?>&nbsp;
				</TD>
			</TR>

			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>MYSQL DATABASE:</B></TD>
				<TD CLASS="tablebody" align="left"><?=$vmysqldb?>&nbsp;
				</TD>
			</TR>
			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>MYSQL USER:</B></TD>
				<TD CLASS="tablebody" align="left"><?=$vmysqluser?>&nbsp;
				</TD>
			</TR>
			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>MYSQL PASSWORD:</B></TD>
				<TD CLASS="tablebody" align="left"><em>(Not Displayed)</em>&nbsp;
				</TD>
			</TR>
  			<TR> 
				<TD colspan="2">&nbsp;</TD>
			</TR>
  			<TR> 
				<TD colspan="2">When you press "CONTINUE" below, this setup script will install the needed database tables for the '<?=$_SESSION["SystemNameStr"]?>' system.<BR>
                <BR>
                <em><b>NOTE:</b> IF THIS IS RAN ON AN ALREADY WORKING '<?=$_SESSION["SystemNameStr"]?>' DATABASE SYSTEM, ALL DATA WILL BE LOST!!!</em></TD>
			</TR>
  			<TR> 
				<TD colspan="2">&nbsp;</TD>
			</TR>
			<TR ALIGN="left"> 
				<TD nowrap colspan="2" align="center">
	              <INPUT TYPE="submit" NAME="submit" VALUE="CONTINUE">
    	        </TD>
        	</TR>
          
  			<TR> 
				<TD colspan="2">&nbsp;</TD>
			</TR>
            
        </TABLE>
        </DIV>
		</FORM>
		<?PHP
	} //END if if ($action=="verifysetting")


if ($action=="getsetting")
	{
	if (@$_POST["action"]=='checksettings')
		{
		$vmysqlserver=strtoupper(@$_POST["fmysqlserver"]);
		$vmysqldb=strtoupper(@$_POST["fmysqldb"]);
		$vmysqluser=@$_POST["fmysqluser"];
		$vmysqlpassword=@$_POST["fmysqlpassword"];
		} //END if (@$_POST["action"]=='checksettings')
	else
		{
		$vmysqlserver=strtoupper($mysql_server);
		$vmysqldb=strtoupper($mysql_db);
		$vmysqluser=$mysql_user;
		$vmysqlpassword=$mysql_password;
		} //END ELSE if (@$_POST["action"]=='checksettings')
		
		print '<H1>TYPE IN MYSQL SERVER SETTINGS</H1>';
        ?>
		<FORM NAME="form1" METHOD="post" ACTION="" ENCTYPE="multipart/form-data">
		<INPUT TYPE="hidden" NAME="action" VALUE="checksettings">
		<DIV align="center">
        <TABLE BORDER="0" WIDTH="750">
  			<TR> 
				<TD colspan="2" align="center"><?PHP if (@$message) print '<font class="messagetext"><b>'.$message.'&nbsp;</b></font>';?>&nbsp;</TD>
			</TR>
			<TR> 
				<TD nowrap WIDTH="250" CLASS="tablebody" align="right"><B>MY SQL SERVER:</B></TD>
				<TD WIDTH="300" CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="fmysqlserver" MAXLENGTH="128" SIZE="60" VALUE="<?=$vmysqlserver?>">
				</TD>
			</TR>

			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>MYSQL DATABASE:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="fmysqldb" MAXLENGTH="35" SIZE="35" VALUE="<?=$vmysqldb?>">
				</TD>
			</TR>
			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>MYSQL USER:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="text" NAME="fmysqluser" MAXLENGTH="35" SIZE="35" VALUE="<?=$vmysqluser?>">
				</TD>
			</TR>
			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>MYSQL PASSWORD:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<INPUT TYPE="password" NAME="fmysqlpassword" MAXLENGTH="35" SIZE="35" VALUE="<?=$vmysqlpassword?>">
				</TD>
			</TR>
			<TR> 
				<TD nowrap CLASS="tablebody" align="right"><B>VALIDATE MYSQL SETTINGS:</B></TD>
				<TD CLASS="tablebody" align="left"> 
					<SELECT NAME="fverifymysqlsettings" SIZE="1">
						<OPTION VALUE="1" selected="selected">YES</OPTION>
						<OPTION VALUE="0">NO</OPTION>
		       		</SELECT>&nbsp;<em>(Not recommended to change this setting)</em>
				</TD>
			</TR>
 
  			<TR> 
				<TD colspan="2">&nbsp;</TD>
			</TR>

			<TR ALIGN="left"> 
				<TD nowrap colspan="2" align="center">
	              <INPUT TYPE="submit" NAME="submit" VALUE="CONTINUE">
    	        </TD>
        	</TR>
          
  			<TR> 
				<TD colspan="2">&nbsp;</TD>
			</TR>
            
        </TABLE>
        </DIV>
		</FORM>
		<?PHP
		if ($ConnError==1)
			{
			print '<HR>';
			print $ResultStr;
			} //END if ($ConnError==1)
		
	} //END if if ($action=="getsetting")


if ($action=="setuploanit")
	{
	print '<H1>SETTING UP '.strtoupper($_SESSION["SystemNameStr"]).' DATABASES</H1>';

	$vmysqlserver=strtoupper(@$_POST["fmysqlserver"]);
	$vmysqldb=strtoupper(@$_POST["fmysqldb"]);
	$vmysqluser=@$_POST["fmysqluser"];
	$vmysqlpassword=@$_POST["fmysqlpassword"];		
		
	$MyConfigFile = "config.php";
	print '<BR><b>CREATING '.strtoupper($MyConfigFile).' FILE:-</b><BR>';
	print "* Creating ".strtoupper($MyConfigFile)." configuration file.<br>";
	$fh = fopen($MyConfigFile, 'w') or die("ERROR: Can't open config.ini file!");
	fwrite($fh, '<?PHP'.chr(13).chr(10));
	fwrite($fh, '$mysql_server="'.$vmysqlserver.'";'.chr(13).chr(10));
	fwrite($fh, '$mysql_db="'.$vmysqldb.'";'.chr(13).chr(10));
	fwrite($fh, '$mysql_user="'.text_protect($vmysqluser).'";'.chr(13).chr(10));
	fwrite($fh, '$mysql_password="'.text_protect($vmysqlpassword).'";'.chr(13).chr(10));
	fwrite($fh, '?>'.chr(13).chr(10));
	fclose($fh);

	print '<BR><b>SERVER DETAILS:-</b><BR>';
	print "* MYSQL server: ".$vmysqlserver.".<br>";
	print "* MYSQL database: ".$vmysqldb.".<br>";
	print "* MYSQL user: ".strtoupper($vmysqluser).".<br>";	
	
	// CHECK THE SETTINGS GIVEN BY THE USER
	print '<BR><b>VALIDATING SERVER DETAILS:-</b><BR>';
	// Check Server
	$ServerConnResult=mysql_connect($vmysqlserver, $vmysqluser, $vmysqlpassword);
	if ($ServerConnResult<=0) 
		die("<b>* Unable to connect to server ".strtoupper($vmysqlserver).".</b> <em>(".mysql_error().")</em>");
	else
		print "* Connected to MySQL server ".strtoupper($vmysqlserver).".<br>";

	// Check DB
	$dbConnResult=mysql_select_db($vmysqldb);
	if ($dbConnResult<=0) 
		die("<b>* Unable to connect to database ".strtoupper($vmysqldb).".</b> <em>(".mysql_error().")</em>");
	else
		print "* Connected to database ".strtoupper($vmysqldb).".<br />";

// CREATE TABLES /////////////////////////////////////////////////////////////////
print '<BR><b>CREATING TABLES:-</b><BR>';
print '* Creating LOANGROUPS table.';
$CreateTblQuery = "DROP TABLE IF EXISTS `loangroups`;";
//$CreateTblResult = mysql_query($CreateTblQuery);
$CreateTblQuery = "CREATE TABLE `loangroups` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this Loan Item Record.',
  `loangroup` varchar(10) DEFAULT NULL COMMENT 'Loan Group that this item belongs to (I.E. IT, Admin office etc)',
  `loangrouptitle` varchar(50) DEFAULT NULL COMMENT 'Title for this item',
  `loangroupdescription` varchar(128) DEFAULT NULL COMMENT 'Short title for the item (Used in the main page due to space restriction)',
  `verbosedisplay` varchar(3) DEFAULT '0',
  `cachenames` varchar(3) DEFAULT '0',
  `groupvisible` varchar(3) DEFAULT '1',
  `viewitemstatuswithoutlogin` varchar(3) DEFAULT '1' COMMENT 'If you can view the items in this loan group without loggin into the system',
  `dateitemcreatedinsystem` varchar(30) DEFAULT NULL COMMENT 'Date this item was created in the Loan System',
  PRIMARY KEY (`uid`),
  KEY `disp` (`uid`,`loangroup`,`loangroupdescription`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print ' OK<BR>';
else print '.. <em><b>ERROR: Unable to create table</b><em><BR>';

print '* Creating LOANSYSTEM table.';
$CreateTblQuery = "DROP TABLE IF EXISTS `loansystem`;";
$CreateTblResult = mysql_query($CreateTblQuery);
$CreateTblQuery = "CREATE TABLE `loansystem` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this Loan Item Record.',
  `loangroup` varchar(10) DEFAULT NULL COMMENT 'Loan Group that this item belongs to (I.E. IT, Admin office etc)',
  `itemtitle` varchar(50) DEFAULT NULL COMMENT 'Title for this item',
  `shortitemtitle` varchar(27) DEFAULT NULL COMMENT 'Short title for the item (Used in the main page due to space restriction)',
  `itemdescription` text COMMENT 'Full Description of the item feature/issues etc.',
  `sortorder` int(11) DEFAULT NULL COMMENT 'Sort order is used on main page to re-organise the sort order of the items displayed.',
  `itembarcode` varchar(40) DEFAULT NULL,
  `itemserial` varchar(50) DEFAULT NULL COMMENT 'Serial Number of the item being loaned out.',
  `itemmodel` varchar(60) DEFAULT NULL COMMENT 'Model Number of the item being loaned out.',
  `itemloanflag` int(11) DEFAULT NULL COMMENT 'Indicateds if the item has been loaned (0=not on loan, 1=item on loan)',
  `warningamber` int(11) DEFAULT NULL COMMENT 'How may days before an amber alert is displayed regarding the item.',
  `warningred` int(11) DEFAULT NULL COMMENT 'How may days before an red alert is displayed regarding the item.',
  `loanoverride` int(11) DEFAULT NULL,
  `itemloanedtologinid` varchar(15) DEFAULT NULL COMMENT 'login ID of person who the item has been loaned out to.',
  `itemloanedtoname` varchar(40) DEFAULT NULL COMMENT 'Name of person who the item has been loaned out to.',
  `itemloanedtoemail` varchar(128) DEFAULT NULL,
  `itemloanedtophone` varchar(40) DEFAULT NULL,
  `itemloanedtonotes` varchar(255) DEFAULT NULL COMMENT 'Notes regarding the loaning of this item.',
  `itemloandatestart` date DEFAULT NULL COMMENT 'Date when the item was loaned out to a person.',
  `itemlastcheckedoutbyname` varchar(40) DEFAULT NULL COMMENT 'Name of person who checked the item out.',
  `itemlastcheckedoutbyloginid` varchar(15) DEFAULT NULL COMMENT 'LoginID of person who checked the item out.',
  `itemlastcheckedindate` date DEFAULT NULL,
  `itemlastcheckedinbyname` varchar(40) DEFAULT NULL COMMENT 'Name of person who checked the item in.',
  `itemlastcheckedinbyloginid` varchar(15) DEFAULT NULL COMMENT 'LoginID of person who checked the item in.',
  `dateitemcreatedinsystem` varchar(30) DEFAULT NULL COMMENT 'Date this item was created in the Loan System',
  `itemcreatedbyinsystem` varchar(40) DEFAULT NULL COMMENT 'Name of person who created the item in the Loan System',
  `itemvisible` varchar(1) DEFAULT '1' COMMENT 'Should this item be seen in the loan system',
  `itemstolennotes` varchar(255) DEFAULT NULL COMMENT 'If the item was stolen, document who it was loaned to etc',
  PRIMARY KEY (`uid`),
  KEY `disp` (`uid`,`loangroup`,`shortitemtitle`,`itemloanedtologinid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print ' OK<BR>';
else print '.. <em><b>ERROR: Unable to create table</b><em><BR>';

print '* Creating LOANSYSTEMLOGS table.';
$CreateTblQuery = "DROP TABLE IF EXISTS `loansystemlogs`;";
$CreateTblResult = mysql_query($CreateTblQuery);
$CreateTblQuery = "CREATE TABLE `loansystemlogs` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for Log entrie.',
  `actiondatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time log file entry was created',
  `action` varchar(50) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Action taking place',
  `loangroup` varchar(15) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Loan Group Item is associated with.',
  `loanitemshorttitle` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `loanitembarcode` varchar(40) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Barcode of the Item in question.',
  `loantoname` varchar(40) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Full Name of the person who loaned the item.',
  `loantologinid` varchar(10) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Login ID of the person who loaned the item.',
  `loantoemail` varchar(128) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Email address of the person who loaned the item.',
  `loantophone` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `itemloandatestart` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `daysitemwasonloan` int(11) DEFAULT NULL,
  `itemreturnstatus` varchar(10) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Green=Returned item within loan period,Amber= Nearly Overdue, Red=OVERDUE',
  `itemreturnstatusnumber` int(11) DEFAULT NULL COMMENT '0=Green (Returned item within loan period), 1=Amber(Nearly Overdue), 2=Red (OVERDUE)',
  `adminname` varchar(40) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Full Name of Admin person who signed out/ Returned the item.',
  `adminloginid` varchar(15) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Login ID of Admin person who signed out/ Returned the item.',
  `adminip` varchar(16) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'IP address of Admin person who signed out/ Returned the item.',
  `admindns` varchar(128) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'User DNS of Admin person who signed out/ Returned the item.',
  `notes` varchar(255) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Additional log entry notes',
  PRIMARY KEY (`uid`),
  KEY `quickindex` (`uid`,`loangroup`,`loantoname`,`loantologinid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print ' OK<BR>';
else print '.. <em><b>ERROR: Unable to create table</b><em><BR>';

print '* Creating LOGINLOGS table.';
$CreateTblQuery = "DROP TABLE IF EXISTS `loginlogs`;";
$CreateTblResult = mysql_query($CreateTblQuery);
$CreateTblQuery = "CREATE TABLE `loginlogs` (
  `eventid` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(32) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Login ID of the person who this log file entry relates to',
  `username` varchar(30) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Username of the person who this log file entry relates to',
  `userip` varchar(16) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'IP address of the person who this log file entry relates to',
  `userdns` varchar(40) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'User DNS of the person who this log file entry relates to',
  `action` varchar(30) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Result',
  `result` varchar(30) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Result',
  `resultnumber` int(11) DEFAULT NULL COMMENT '400= Bad request (invalid account), 401=Unauthorized (Invalid Password), 409= Conflict (Login Disabled), 202=Accepted(Login OK)',
  `notes` varchar(255) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Additional log entry notes',
  `tsnumber` bigint(20) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time log file entry was created',
  PRIMARY KEY (`eventid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print ' OK<BR>';
else print '.. <em><b>ERROR: Unable to create table</b><em><BR>';

print '* Creating NAMECACHE table.';
$CreateTblQuery = "DROP TABLE IF EXISTS `namecache`;";
$CreateTblResult = mysql_query($CreateTblQuery);
$CreateTblQuery = "CREATE TABLE `namecache` (
  `uid` bigint(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this Record.',
  `staffid` varchar(15) DEFAULT NULL COMMENT 'login ID or proxy id or barcode number of person',
  `email` varchar(128) DEFAULT NULL COMMENT 'email address of person',
  `name` varchar(40) DEFAULT NULL COMMENT 'Name of person',
  `phone` varchar(40) DEFAULT NULL COMMENT 'phone number of person',
  `tsdate` varchar(40) DEFAULT NULL COMMENT 'date record was last updated',
  `tsdatenumber` bigint(20) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  KEY `disp` (`uid`,`staffid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print ' OK<BR>';
else print '.. <em><b>ERROR: Unable to create table</b><em><BR>';

print '* Creating PEOPLE table.';
$CreateTblQuery = "DROP TABLE IF EXISTS `people`;";
$CreateTblResult = mysql_query($CreateTblQuery);

$CreateTblQuery = "CREATE TABLE `people` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for this staff member’s record.',
  `loginid` varchar(15) DEFAULT '' COMMENT 'QMUL Login ID (IE BSW000)',
  `pw` varchar(201) DEFAULT NULL COMMENT 'Hash of users password',
  `email` varchar(64) DEFAULT '' COMMENT 'QMUL Email address of the staff member',
  `lastname` varchar(32) DEFAULT '' COMMENT 'The family name of the staff member',
  `firstname` varchar(32) DEFAULT NULL COMMENT 'The forename(s) of the staff member',
  `accesslevel` varchar(10) DEFAULT 'USER' COMMENT 'This field can be USER or ADMIN.',
  `proxycardno` varchar(10) DEFAULT NULL COMMENT 'Staff members proximity card number',
  `barcode` varchar(15) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL COMMENT 'Staff Mobile phone Number',
  `badlogincount` int(11) DEFAULT NULL COMMENT 'Bad Login counter:\r\nThis counts up the amount of consecutive bad logins a staff member has done, when they log in successfully it is reset to 0.',
  `lastbadlogincountdatetime` varchar(20) DEFAULT NULL COMMENT 'Date and Time last bad attempt was made',
  `lastbadlogincountdatetimenumber` int(20) DEFAULT NULL,
  `loandaysoverride` varchar(3) DEFAULT '0',
  `bulkloanitems` varchar(3) DEFAULT '0',
  `logindisabled` int(11) DEFAULT NULL COMMENT 'Flag for if the account is disabled 0=ok, 1=disabled',
  `logindisableddatetime` varchar(20) DEFAULT NULL COMMENT 'Date and Time Account was disabled',
  `lastlogindate` varchar(20) DEFAULT NULL COMMENT 'Date and time this person logged in last.',
  `lastloginip` varchar(16) DEFAULT NULL COMMENT 'IP address of staff members last logged in.',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time Stamp of when this record was last updated',
  PRIMARY KEY (`uid`),
  KEY `surname` (`loginid`),
  KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print ' OK<BR>';
else print '.. <em><b>ERROR: Unable to create table</b><em><BR>';

// POPULATE TABLES WITH DATA /////////////////////////////////////////////////////////////////
print '<BR><b>POPULATING TABLES WITH DATA:-</b><BR>';
print '* Populating LOANGROUPS table.';
$CreateTblQuery = "INSERT INTO `loangroups` VALUES ('1', 'IT', 'IT Equipment Loan Group', 'IT Related Items that can be loaned to staff.', '0', '1', '1', '1', '2012-02-29 13:13');";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';
print ' DONE<BR>';

print '* Populating LOANSYSTEM table.';
$CreateTblQuery = "INSERT INTO `loansystem` VALUES ('1', 'IT', 'Laptop 1 - Dell', 'Laptop 1', 'Dell Inspiron 630m \r\nProcessor Intel Core Duo \r\n1.6 GHz, Hard Drive 80 GB, Memory 1024 MB, Screen Size 15\", DVD-ROM.\r\n', '10', 'LT001', 'CD234DBV34', 'Inspiron 630m', '0', '2', '5', null, null, null, null, null, null, null, null, null, '2012-03-22', 'Darren Van Den Bogaard', 'BSW088', '2010-12-07 11:18', 'Supervisor User (SUPERVISOR)', '1', null);";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';

$CreateTblQuery = "INSERT INTO `loansystem` VALUES ('2', 'IT', 'Laptop 2 - Toshiba', 'Laptop 2', 'Toshiba Satellite Pro U200\r\nProcessor Intel Core Duo \r\n2.6 GHz, Hard Drive180 GB, Memory 3024 MB, Screen Size 17\", DVD-ROM.', '20', 'LT002', 'F234DF443', 'Satellite Pro U200', '0', '2', '5', null, null, null, null, null, null, null, null, null, null, null, null, '2010-11-09 16:11', 'Supervisor User (SUPERVISOR)', '1', null);";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';

$CreateTblQuery = "INSERT INTO `loansystem` VALUES ('3', 'IT', 'Laptop 3 - Sony', 'Laptop 3', 'Sony Sleek SN001\r\nProcessor Intel Core Duo \r\n4.6 GHz, Hard Drive180 GB, Memory 13024 MB, Screen Size 10\", DVD-ROM.', '30', 'LT003', '9346788989343', 'Sleek SN001', '0', '2', '5', null, null, null, null, null, null, null, null, null, null, null, null, '2009-03-19 13:37', 'Supervisor User (SUPERVISOR)', '1', null);";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';

$CreateTblQuery = "INSERT INTO `loansystem` VALUES ('4', 'IT', 'Laptop 4 - IBM', 'Laptop 4', 'IBM Raver RA2\r\nProcessor Intel Core Duo \r\n2.0 GHz, Hard Driv5000 GB, Memory 3024 MB, Screen Size 13\", DVD-ROM.', '40', 'LT004', '4823423445', 'Raver RA2', '0', '2', '5', null, null, null, null, null, null, null, null, null, null, null, null, '2009-03-19 13:38', 'Supervisor User (SUPERVISOR)', '1', null);";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';

$CreateTblQuery = "INSERT INTO `loansystem` VALUES ('5', 'IT', 'Laptop 5 - HP', 'Laptop 5', 'HP Charters CNA2z\r\nProcessor Intel Core Duo \r\n3.2 GHz, Hard Driv500 GB, Memory 2024 MB, Screen Size 14\", DVD-ROM.', '50', 'LT005', '73827492', 'Charters CNA2z', '0', '2', '5', null, null, null, null, null, null, null, null, null, null, null, null, '2011-02-17 16:36', 'Supervisor User (SUPERVISOR)', '1', null);";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';

$CreateTblQuery = "INSERT INTO `loansystem` VALUES ('6', 'IT', 'Projector 1 - Casio', 'Projector 1', 'Projector Casio VV27x', '200', 'PROJ001', '937283401', 'Casio VV27x', '0', '2', '5', null, null, null, null, null, null, null, null, null, null, null, null, '2012-02-29 13:18', 'Supervisor User (SUPERVISOR)', '1', null);";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';

$CreateTblQuery = "INSERT INTO `loansystem` VALUES ('7', 'IT', 'Projector 2 - Epson', 'Projector 2', 'Projector Epson EMP-X52', '210', 'PROJ002', '937283402', 'Epson EMP-X52', '0', '2', '5', null, null, null, null, null, null, null, null, null, null, null, null, '2012-02-29 13:14', 'Supervisor User (SUPERVISOR)', '1', null);";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';


$CreateTblQuery = "INSERT INTO `loansystem` VALUES ('8', 'IT', 'Voice Recorder 1 - Olympus', 'Voice Recorder 1', 'Olympus WS-320M Digital Voice Recorder,\r\n1 GB internal flash memory, Records up to 277 hours of WMA audio, USB Direct design plugs directly into PC or Mac\'s USB port; 4 recording modes (HQ, LP, SP, and HQ Stereo), \r\n5 separate file folders with 199 files each; voice activation mode enables hands-free recording \r\nRuns for roughly 15 hours on 1 AAA battery, 1.5 x 3.73 x 0.43 inches (W x H x D).', '300', 'VR001', '8432001', 'Olympus WS-320M', '0', '5', '10', null, null, null, null, null, null, null, null, null, '2012-03-21', 'Darren Van Den Bogaard', 'BSW088', '2012-02-23 16:34', 'Supervisor User (SUPERVISOR)', '1', null);";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';

$CreateTblQuery = "INSERT INTO `loansystem` VALUES ('9', 'IT', 'Voice Recorder 2 - Olympus', 'Voice Recorder 2', 'Olympus WS-320M Digital Voice Recorder,\r\n1 GB internal flash memory, Records up to 277 hours of WMA audio, USB Direct design plugs directly into PC or Mac\'s USB port; 4 recording modes (HQ, LP, SP, and HQ Stereo), \r\n5 separate file folders with 199 files each; voice activation mode enables hands-free recording \r\nRuns for roughly 15 hours on 1 AAA battery, 1.5 x 3.73 x 0.43 inches (W x H x D).', '310', 'VR002', '8432002', 'Olympus WS-320M', '0', '5', '10', null, null, null, null, null, null, null, null, null, null, null, null, '2012-03-19 11:16', 'Supervisor User (SUPERVISOR)', '1', null);";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';

print ' DONE<BR>';

print '* Populating NAMECACHE table.';
$CreateTblQuery = "INSERT INTO `namecache` VALUES ('1', '0232376801', 'd.bogaard@localhost', 'Darren van den Bogaard', 'x1234', '2012-03-19 13:14', '1332159274', '2012-03-19 13:13:24');";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';
print ' DONE<BR>';

print '* Populating PEOPLE table.';
$CreateTblQuery = "INSERT INTO `people` VALUES ('1', 'supervisor', 'MGx5ZJRmBQZ4AGZmAwExLJH0BJMyAQWuAmEuLwNlZGuzMQR2AJExLGRmAJLkAGqvAQOyATAzMwuuLzLlAmH5LGSxL2Z0BQtmZmV3LGuxZQAzZmHmAGOwLwpjMTL1Lmp1MwR2LGx0MQuzAQqzBGOuMJD1LGyuA2L1LmyyAGt0A2L=', 'supervisor@localhost', 'User', 'Supervisor', 'ADMIN', '', '12341234', '', '0', '2012-03-16 16:33', '1331912000', '1', '1', null, null, null, null, '2012-03-16 15:41:53');";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';

$CreateTblQuery = "INSERT INTO `people` VALUES ('2', 'visitor', 'AzHmLzDmZGV1ZGAyMwOxZmDmAJD3Z2Z1ZwuyZwLjBQAwBTVkZmR0AQIvZmR1LmV0LzDmAmDkMQL1AwuwAzH5LwMxMwNmLzH0Zwp1AQxjZGH3AwuxMwtmZzLmLmMzMQWxAQSvZTZkA2Z0MGZ0ZGDkMGAzMGZ0MzIuAmqyLGL2MzR=', 'visitor@localhost', 'User', 'Visitor', 'USER', 'abc123', '9999999999', '', '0', '2012-03-02 11:00', '1330682432', '0', '0', null, null, null, null, '2012-03-02 15:22:46');";
$CreateTblResult = mysql_query($CreateTblQuery);
if ($CreateTblResult==1) print '.';
else print '<b>x</b>';

print ' DONE<BR>';

print '<BR><b>SETUP COMPLETE.</b><BR>';
	} //END if ($action=="setuploanit")
	
	bottom();
// end of file people.php
?>




