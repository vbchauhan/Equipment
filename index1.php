<!-- 
Created by: Siddharth Choksi in May 2010
This is the main login file.
-->
<?php

include('connect_to_shady_grove.php'); // Connects to your Database 

$user = mysqli_real_escape_string($dbc,trim($_POST['user'])); 
$p = md5($_POST['pass']);

$query ="SELECT * FROM validate WHERE username = '$user' AND pwd = '$p'";
$result = @mysqli_query($dbc, $query);
$num_rows = mysqli_num_rows($result);


if($num_rows==1)
{
session_start();
$_SESSION['name']=$user;
header("Location:display_book_requests.php");
}

else
{
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>
<body bgcolor="#333333" style="font-family:verdana; font-size:12px">
<table width="70%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" height="100%" align="center">
  <tr>
    <td align="center"><img src="images/logo.jpg" alt="logo" /></td>
  </tr>
  <tr>
    <td align="center"><br /><br />
<div align="center" style="border:solid 1px; width:40%">

  <div align = "center" style="background-color:#edeada; padding:3px"><strong>Login</strong></div>
  <form method="POST" action="validate_input.php" align = "center">
  <p><label>Username <input type="text" name="user" size="30" value= "';if(isset($_POST['user'])){echo $_POST['user'];} echo'" /></label></p>
   <p><label>Password <input type="password" name="pass" size="30" /></label></p>
  <input type="submit" size="30" value="Sign In" />
   </form>
		  </div>';
	
	
include('footer.php'); 

}
?>