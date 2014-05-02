<?php
//include_once($_SERVER['DOCUMENT_ROOT']."/lendit/protect/global.php");
//top();

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
	
//if(isset($_POST["utype"])){
	//$utype=$_POST["utype"];}else{echo "utype is not Set <br />";}
	
if(isset($_POST["institution"])){
	$institution=$_POST["institution"];}else{echo "institution is not Set <br />";}
if(isset($_POST["department"])){
	$department=$_POST["department"];}else{echo "Department is not Set <br />";}
if(isset($_POST["request_date"])){
	$request_date=$_POST["request_date"];}else{echo "Request Date is not Set <br />";}
if(isset($_POST["ipads"])){
	$ipads=$_POST["ipads"];}else{echo "Ipads count is not set is not Set <br />";}
//$sql=" INSERT INTO request
//(fname,lname,barcode,email,pno,utype,institution,department,request_date,ipad_date,ipads)
//VALUES
//('$fname','$lname','$barcode','$email','$pno','$utype','$institution','$department',NOW(),'$request_date','$ipads')";

//echo $sql;
//$confirm=mysql_query($sql);


//This code will print the confirmation that the player has been registered in the database.


// Emailing Request Information to Madhu
$to = 'madhus@umd.edu,ambarish19@gmail.com';
$subject = 'Ambarish has sent you an email. Cheers for the functionality';
$body = 'This is how you send emails from PHP. All the best';
$from = 'From: Ambarish MIM UMCP ';
mail($to, $subject, $body, $from);

?>