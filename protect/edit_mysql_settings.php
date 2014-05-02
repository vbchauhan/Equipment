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
				<TD colspan="2">When you press "CONTINUE" below, the MYSQL settings above will be saved.</TD>
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
	print '<H1>EDIT '.strtoupper($_SESSION["SystemNameStr"]).' MYSQL SETTINGS</H1>';

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

	print '<BR><b>MYSQL DETAILS UPDATE COMPLETE.</b><BR>';
	} //END if ($action=="setuploanit")
	
	bottom();
// end of file people.php
?>




