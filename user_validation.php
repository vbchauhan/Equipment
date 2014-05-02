<!-- 
Created by: Siddharth Choksi in May 2010
Validates the Instructor Information form elements in the forms. 
-->
<?php 
	$errors = array();
	
	// Last Name Check
	$ln = mysqli_real_escape_string($dbc,trim($_POST['p_last_name']));
	if(empty($ln)) 
	{$errors[] = "Please enter your <b>Last Name</b>";}
	else
	{$p_last_name = $ln;}

	// First Name Check
	$fn = mysqli_real_escape_string($dbc,trim($_POST['p_first_name']));
	if(empty($fn)) 
	{$errors[] = "Please enter your <b>First Name</b>";}
	else
	{$p_first_name = $fn;}

	// Email Check
	$email = mysqli_real_escape_string($dbc,trim($_POST['p_email']));
	if(empty($email)) 
	{$errors[] = "Please enter your <b>Email Address</b>";}
	else
	{
	if(ereg('[0-9a-zA-Z]([\-\.\_0-9a-zA-Z])*[0-9a-zA-Z]\@([0-9a-zA-Z][0-9a-zA-Z\-\_]*\.)+[a-zA-Z]{2,}', $email))
	{$p_email = $email;}
	else
	{$errors[] = "Please enter a valid <strong>Email Address</strong>";}
	}

	// Phone Check
	$p_no = mysqli_real_escape_string($dbc,trim($_POST['p_phone_number']));
	if(empty($p_no)) 
	{$p_phone_number = "";}
	else
	{
	if(strlen($p_no) == 10 && (ereg('^[0-9]{10}$',$p_no)))
	{$p_phone_number = $p_no;}
	elseif(strlen($p_no) == 12 && (ereg('^[0-9]{3}-[0-9]{3}-[0-9]{4}$',$p_no)))
	{$p_phone_number = str_replace('-','',$p_no);}
	else
	{$errors[] = "Please enter your <b>Phone Number</b> in the specified format";}
	}

	// University Check
	if($_POST['p_university'] == "Please select one") 
	{$errors[] = "Please select your <b>University</b>";}
	else
	{$p_university = $_POST['p_university'];}


?>