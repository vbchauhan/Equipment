<?php 
session_start();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(isset($header)) {echo $header;} ?></title>
<style type="text/css">
<!--
a:link {
color:#444444;
text-decoration:none;
}
a:active {
color:#444444;
text-decoration:none;
}
a:visited {
color:#444444;
text-decoration:none;
}
a:hover {
color:#cc0000;
}
.style1 {font-size: 10px;}
.style2 {color: #990000}
-->
</style>
</head>
<body bgcolor="#333333" style="font-family:verdana; font-size:12px">
<table width="70%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" height="100%" align="center">
  <tr>
    <td align="center"><img src="images/logo.jpg" alt="logo" /></td>
  </tr>
  <tr>
    <td align="center"><br><br>
<div align="center" style="border:solid 1px; width:40%">


<?php 

echo '
<div align ="center" style="padding:5px"> You have been successfully Logged Out !</div>

  <div align = "center" style="background-color:#edeada; padding:3px"><strong>Login Again</strong></div>
  <form method="POST" action="validate_input.php" align = "center">
  <p><label>Username <input type="text" name="user" size="30" /></label></p>
   <p><label>Password <input type="password" name="pass" size="30" /></label></p>
  <input type="submit" size="30" value="Sign In" />
   </form>
		  </div>';
	
include('footer.php'); 
	
?>