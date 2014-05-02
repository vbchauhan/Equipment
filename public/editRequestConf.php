<head>
<link href="/<?=strtolower($_SESSION["SystemNameStr"])?>/css/main.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="/<?=strtolower($_SESSION["SystemNameStr"])?>/favicon.ico" type="image/x-icon">
<title>Priddy Loan System</title>
</head>
<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
include ("global.php");
include ("layout.php");
include ("functions.php");
top();

if(isset($_POST["fname"])){
	$fname=$_POST["fname"];}else{echo "first name is not Set <br />";}
if(isset($_POST["lname"])){
	$lname=$_POST["lname"];}else{echo "last name is not Set <br />";}
if(isset($_POST["barcode"])){
	$barcode=$_POST["barcode"];}else{echo "barcode is not Set <br />";}
if(isset($_POST["email"])){
	$email=$_POST["email"];}else{echo "Email is not Set <br />";}
if(isset($_POST["pno"])){
	$pno=$_POST["pno"];}else{echo "pno is not Set <br />";}
	
if(isset($_POST["utype"])){
	$utype=$_POST["utype"];}else{echo "utype is not Set <br />";}
	
if(isset($_POST["institution"])){
	$institution=$_POST["institution"];}else{echo "institution is not Set <br />";}
if(isset($_POST["department"])){
	$department=$_POST["department"];}else{echo "Department is not Set <br />";}
if(isset($_POST["request_date"])){
	$request_date=$_POST["request_date"];}else{echo "Request Date is not Set <br />";}
if(isset($_POST["ipads"])){
	$ipads=$_POST["ipads"];}else{echo "Ipads count is not set is not Set <br />";}
if(isset($_POST["request"])){
	$request=$_POST["request"];}else{echo "Request ID is not Set <br />";}
	//echo $request;
$sql="update request set fname='$fname',lname='$lname',barcode='$barcode',email='$email',pno='$pno',utype='$utype',institution='$institution',department='$department',request_date='$request_date',ipads='$ipads' 
where requestId='$request';";
$confirm=mysql_query($sql);
//This code will print the confirmation that the record has been updated in the database
if (!$confirm)
	{
		die('Error: ' . mysql_error());
	}
else 
	{
	echo " <h1>The User request was successfully updated in the database</h1>";
	}



?>