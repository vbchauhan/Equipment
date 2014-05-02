<?php
function top()
	{
	$CurrentRequestURL=$_SERVER['REQUEST_URI'];
	$CurrentRequestURLarr=explode("/",$CurrentRequestURL);
	// ======================= TOP HTML CODE STARTS HERE =====================
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/html4/loose.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="/<?php echo "equipment";?>/css/main.css" rel="stylesheet" media="screen">
<title>Priddy Loan System</title>
<link rel="shortcut icon" href="/<?php echo "equipment";?>/favicon.ico" type="image/x-icon">
</head>

<body>

<div id="banner">EQUIPMENT LOAN SYSTEM</div>

	<div id="container">
		<div id="topnavi">
    		<?php if (@$_SESSION["AUTH_USER"]==true) {
						print '<a href="/equipment/login/logout.php">LOGOFF</a>';
						print '<a href="/equipment/public/index.php">View Requests</a>';
						}
					else
						{
						$LoginSelectStr='';
						if ($CurrentRequestURLarr[2]=="login") $LoginSelectStr=' class="selected"';
						print '<a href="/equipment/login/index.php"'.$LoginSelectStr.'>LOGIN</a>';
						
						}?>
			<a href="/<?php echo "equipment";?>"<?php if ($CurrentRequestURLarr[2]=="") print ' class="selected"'?>>Loan System</a>
			
			<?php if (@$_SESSION["AUTH_USER"]==true)
					{
					$UserQuery = "SELECT bulkloanitems FROM people WHERE LOWER(loginid)='".strtolower(@$_SESSION["AUTH_USER_LOGINID"])."'";
					$UserResult = @mysql_query($UserQuery);
					$UserNums = mysql_num_rows($UserResult);			
					$UserQueryRow = @mysql_fetch_array($UserResult);
					if ($UserNums>=1)
						{
						if ($UserQueryRow["bulkloanitems"]=='1')
							{	
							?>
							<a href="/<?php echo "equipment";?>/checkitembulk.php">Loan Multiple Items</a><?php							
							} //END if ($UserQueryRow["bulkloanitems"]=='1')
						} //END if ($GroupNums>=1)
					} //EMD if (@$_SESSION["AUTH_USER"]==true)
			?>
            
            <?php if ((strlen(@$_SESSION["LOANSYSTEM_GROUP"])>=2) and (@$_SESSION["AUTH_USER"]==true))
					{
					$GroupQuery = "select loangroup FROM loangroups WHERE groupvisible='1'";
					$GroupResult = @mysql_query($GroupQuery);
					$GroupNums = mysql_num_rows($GroupResult);			
					if ($GroupNums>=2)
						{
						?>							
						<a href="/<?php echo "equipment";?>/index.php?action=loangroupselect">Change Loan Group</a><?php
						} //END if ($GroupNums>=2)
					} 
			
            if (canupdate())
				{?>
	            <a href="/<?php echo "equipment";?>/webadmin"<?php if ($CurrentRequestURLarr[2]=="webadmin") print ' class="selected"'?>>Admin</a>
				
                <?php } //END if (canupdate()?>
            
		</div>
<div id="content"><?php
	// ======================= TOP HTML CODE ENDS HERE =======================
	} // END function top()


function bottom()
	{
  	// ======================= BOTTOM HTML CODE STARTS HERE ==================== 
	?></div>
<div id="footer"><?php
	if (@$_SESSION["AUTH_USER"]==true)
		{
		$UserStr='[Logged in as '.ucwords(strtolower(@$_SESSION["AUTH_USER_NAME"])).' <EM>('.strtoupper(@$_SESSION["AUTH_USER_LOGINID"]).')</EM> with '.ucwords(strtolower(@$_SESSION["AUTH_USER_TYPE"])).' access]';
		print $UserStr;
		} //END if (@$_SESSION["AUTH_USER"]==true)
		
		if (strlen(@$_SESSION["LOANSYSTEM_GROUP"])>=1)
			{
			$LoanGroupStr='['.$_SESSION["LOANSYSTEM_GROUP"].' loan group selected]';
			print '&nbsp;&nbsp;&nbsp;&nbsp;'.$LoanGroupStr;		
			}
	?></div></body></html><?php
  	// ======================= BOTTOM HTML CODE END HERE ======================= 
	} // END bottom()
	
	
	
// end of file layout.php	
?>