<?php 
session_start();
if(!isset($_SESSION['name']))
{
 header("Location:index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(isset($header)) {echo $header;} ?></title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
color:#FFFFFF;
text-decoration:none;
}
a:active {
color:#FFFFFF;
text-decoration:none;
}
a:visited {
color:#FFFFFF;
text-decoration:none;
}
a:hover {
color:#FFFFFF;
}
.style1 {font-size: 10px;}
.style2 {color: #990000}

.log
{color:#990000;
 
}

.hlog a:hover{
	text-decoration: underline;
}

-->
</style>
</head>
<body bgcolor="#333333" style="font-family:verdana; font-size:12px">
<?php 
$type = $_GET['type'];
$types = array('')
?>
<table width="98%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" height="100%" align="center">
  <tr>
    <td align="center"><br /><img src="images/usglogo.png" alt="logo" /></td>
  </tr>
 
 <tr><td>  	<div class="hlog" align="right" style="padding-right:10px; padding-bottom:3px;"><a href="logout.php"><strong><span class="log">LOGOUT</span></strong></a></div>
</td></tr>
  <tr>
    <td align="center" bgcolor="#edeada">
  
    <div style="padding:5px">
      <form name="search" method="get" action="search_results.php">
        Search by: <input name="search" type="text" size="50" value="<?php if(isset($_GET['search'])) echo $_GET['search']?>" />
        <select name="type">
<?php
if($type == 'a_id')
echo '<option value = "a_id" selected="selected">Article Request #</option>';
else
echo '<option value = "a_id">Article Request #</option>';

if($type == 'b_id')
echo '<option value = "b_id" selected="selected">Book Request #</option>';
else 
echo '<option value = "b_id">Book Request #</option>';

if($type == 'c_id')
echo '<option value = "c_id" selected="selected">Chapter Request #</option>';
else 
echo '<option value = "c_id">Chapter Request #</option>';

if($type == 'a_barcode')
echo '<option value = "a_barcode" selected="selected">Article Barcode #</option>';
else 
echo '<option value = "a_barcode">Article Barcode #</option>';

if($type == 'b_barcode')
echo '<option value = "b_barcode" selected="selected">Book Barcode #</option>';
else 
echo '<option value = "b_barcode">Book Barcode #</option>';

if($type == 'bc_barcode')
echo '<option value = "bc_barcode" selected="selected">Chapter Barcode #</option>';
else 
echo '<option value = "bc_barcode">Chapter Barcode #</option>';

if($type == 'p_email')
echo '<option value = "p_email" selected="selected">Email Address</option>';
else 
echo '<option value = "p_email">Email Address</option>';
?>
	    </select>
        <input name="go" type="submit" value="Search" />
      </form>
     </div>
    </td>
  </tr>
  <tr>
    <td id="asd" align="center" bgcolor="#ffc240">
      <ul id="MenuBar1" class="MenuBarHorizontal">
        <li><a href="display_article_requests.php">ARTICLE REQUESTS</a></li>
        <li><a href="display_book_requests.php">BOOK REQUESTS</a></li>
        <li><a href="display_chapter_requests.php">CHAPTER REQUESTS</a></li>
      </ul>
    </td>
  </tr>
  <tr><td><br>