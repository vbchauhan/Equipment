<!-- 
Created by: Siddharth Choksi in May 2010
This file validates the Article Request(s) Fields. (Parent File: article_request.php)
-->
<?php

$errors1 = array(); 
	
// Check Request #1 
// Allocation of posted values to temp variables after mysqli_real_escape_string($dbc,trimming) 
$sem1 = mysqli_real_escape_string($dbc,$_POST['semester1']);
$sem_year1 = mysqli_real_escape_string($dbc,$_POST['semester_year1']);
$ct1 = mysqli_real_escape_string($dbc,trim($_POST['course_title1']));
$cn1 = mysqli_real_escape_string($dbc,trim($_POST['course_no1']));
$lp1 = mysqli_real_escape_string($dbc,trim($_POST['loan_period1']));
$jt1 = mysqli_real_escape_string($dbc,trim($_POST['j_title1']));
$jv1 = mysqli_real_escape_string($dbc,trim($_POST['j_volume1']));
$ji1 = mysqli_real_escape_string($dbc,trim($_POST['j_issue1'])); 
$jm1 = mysqli_real_escape_string($dbc,trim($_POST['j_month1']));
$jy1 = mysqli_real_escape_string($dbc,trim($_POST['j_year1']));
$at1 = mysqli_real_escape_string($dbc,trim($_POST['a_title1']));
$aa1 = mysqli_real_escape_string($dbc,trim($_POST['a_author1']));
$aip1 = mysqli_real_escape_string($dbc,trim($_POST['a_incl_pages1']));
$ai1 = mysqli_real_escape_string($dbc,trim($_POST['a_issn1']));
$asm1 = mysqli_real_escape_string($dbc,trim($_POST['a_supply_method1']));
$an1 = mysqli_real_escape_string($dbc,trim($_POST['a_notes1']));

	// Semester	
	$semester1 = $sem1;

	// Semester Year
	$semester_year1 = $sem_year1; 
	
	// Course Title
	$course_title1 = $ct1; 
	
	// Course Number 
	if(empty($cn1)) 
	{$errors1[] = "Please enter the <b>Course Number</b>";}
	else
	{$course_no1 = $cn1;}
	
	//Loan Period
	if(empty($lp1)) 
	{$a_loan_period1 = "" ;}
	else
	{$a_loan_period1 = $lp1;}
	
	// Journal Title
	if(empty($jt1)) 
	{$errors1[] = "Please enter the <b>Journal Title</b>";}
	else
	{$j_title1 = $jt1;}

	// Journal Volume
	if(empty($jv1)) 
	{$errors1[] = "Please enter the <b>Journal Volume</b>";}
	else
	{$j_volume1 = $jv1;}

	//Journal Issue
	if(empty($ji1)) 
	{$j_issue1 = "" ;}
	else
	{$j_issue1 = $ji1;}

	//Journal Month
	if(empty($jm1)) 
	{$j_month1 = "" ;}
	else
	{$j_month1 = $jm1;}

	//Journal Year
	if(empty($jy1)) 
	{$errors1[] = "Please enter the <b>Journal Year</b>";}
	else
	{$j_year1 = $jy1;}	

	//Article Title
	if(empty($at1)) 
	{$errors1[] = "Please enter the <b>Article Title</b>";}
	else
	{$a_title1 = $at1;}	

	//Article Author
	if(empty($aa1)) 
	{$errors1[] = "Please enter the <b>Article Author</b>";}
	else
	{$a_author1 = $aa1;}	
	
	// Inclusive Pages
	if(empty($aip1)) 
	{$errors1[] = "Please enter the <b>Inclusive Pages</b>";}
	else
	{$a_incl_pages1 = $aip1;}

	//Article ISSN
	if(empty($ai1)) 
	{$a_issn1 = "";}
	else
	{$a_issn1 = $ai1;}

	// Article Supply Method
	if(empty($asm1)) 
	{$a_supply_method1 = "";}
	else
	{$a_supply_method1 = $asm1;}
	
	// Article Notes
	if(empty($an1)) 
	{$a_notes1 = "";}
	else
	{$a_notes1 = $an1;}
	

// Allocation of posted values to temp variables after mysqli_real_escape_string($dbc,trimming) for Request #2 
$sem2 = mysqli_real_escape_string($dbc,$_POST['semester2']);
$sem_year2 = mysqli_real_escape_string($dbc,$_POST['semester_year2']);
$ct2 = mysqli_real_escape_string($dbc,trim($_POST['course_title2']));
$cn2 = mysqli_real_escape_string($dbc,trim($_POST['course_no2']));
$lp2 = mysqli_real_escape_string($dbc,trim($_POST['loan_period2']));
$jt2 = mysqli_real_escape_string($dbc,trim($_POST['j_title2']));
$jv2 = mysqli_real_escape_string($dbc,trim($_POST['j_volume2']));
$ji2 = mysqli_real_escape_string($dbc,trim($_POST['j_issue2'])); 
$jm2 = mysqli_real_escape_string($dbc,trim($_POST['j_month2']));
$jy2 = mysqli_real_escape_string($dbc,trim($_POST['j_year2']));
$at2 = mysqli_real_escape_string($dbc,trim($_POST['a_title2']));
$aa2 = mysqli_real_escape_string($dbc,trim($_POST['a_author2']));
$aip2 = mysqli_real_escape_string($dbc,trim($_POST['a_incl_pages2']));
$ai2 = mysqli_real_escape_string($dbc,trim($_POST['a_issn2']));
$asm2 = mysqli_real_escape_string($dbc,trim($_POST['a_supply_method2']));
$an2 = mysqli_real_escape_string($dbc,trim($_POST['a_notes2']));


// Check if Request #2 exists
if(!empty($ct2) || !empty($cn2) || !empty($bt2) || !empty($ba2) || !empty($bct2) || !empty($bip2) || !empty($bi2) || !empty($be2) || !empty($bp2) || !empty($bpp2) || !empty($bpd2) || !empty($bcn2) || !empty($bn2)) 
{
$errors2 = array();
$request_2 = 1;

	// Semester	
	$semester2 = $sem2;

	// Semester Year
	$semester_year2 = $sem_year2; 
	
	// Course Title
	$course_title2 = $ct2; 
	
	// Course Number 
	if(empty($cn2)) 
	{$errors2[] = "Please enter the <b>Course Number</b>";}
	else
	{$course_no2 = $cn2;}
	
	//Loan Period
	if(empty($lp2)) 
	{$a_loan_period2 = "" ;}
	else
	{$a_loan_period2 = $lp2;}
	
	// Journal Title
	if(empty($jt2)) 
	{$errors2[] = "Please enter the <b>Journal Title</b>";}
	else
	{$j_title2 = $jt2;}

	// Journal Volume
	if(empty($jv2)) 
	{$errors2[] = "Please enter the <b>Journal Volume</b>";}
	else
	{$j_volume2 = $jv2;}

	//Journal Issue
	if(empty($ji2)) 
	{$j_issue2 = "" ;}
	else
	{$j_issue2 = $ji2;}

	//Journal Month
	if(empty($jm2)) 
	{$j_month2 = "" ;}
	else
	{$j_month2 = $jm2;}

	//Journal Year
	if(empty($jy2)) 
	{$errors2[] = "Please enter the <b>Journal Year</b>";}
	else
	{$j_year2 = $jy2;}	

	//Article Title
	if(empty($at2)) 
	{$errors2[] = "Please enter the <b>Article Title</b>";}
	else
	{$a_title2 = $at2;}	

	//Article Author
	if(empty($aa2)) 
	{$errors2[] = "Please enter the <b>Article Author</b>";}
	else
	{$a_author2 = $aa2;}	
	
	// Inclusive Pages
	if(empty($aip2)) 
	{$errors2[] = "Please enter the <b>Inclusive Pages</b>";}
	else
	{$a_incl_pages2 = $aip2;}

	//Article ISSN
	if(empty($ai2)) 
	{$a_issn2 = "";}
	else
	{$a_issn2 = $ai2;}

	// Article Supply Method
	if(empty($asm2)) 
	{$a_supply_method2 = "";}
	else
	{$a_supply_method2 = $asm2;}
	
	// Article Notes
	if(empty($an2)) 
	{$a_notes2 = "";}
	else
	{$a_notes2 = $an2;}

}


// Allocation of posted values to temp variables after mysqli_real_escape_string($dbc,trimming) 
$sem3 = mysqli_real_escape_string($dbc,$_POST['semester3']);
$sem_year3 = mysqli_real_escape_string($dbc,$_POST['semester_year3']);
$ct3 = mysqli_real_escape_string($dbc,trim($_POST['course_title3']));
$cn3 = mysqli_real_escape_string($dbc,trim($_POST['course_no3']));
$lp3 = mysqli_real_escape_string($dbc,trim($_POST['loan_period3']));
$jt3 = mysqli_real_escape_string($dbc,trim($_POST['j_title3']));
$jv3 = mysqli_real_escape_string($dbc,trim($_POST['j_volume3']));
$ji3 = mysqli_real_escape_string($dbc,trim($_POST['j_issue3'])); 
$jm3 = mysqli_real_escape_string($dbc,trim($_POST['j_month3']));
$jy3 = mysqli_real_escape_string($dbc,trim($_POST['j_year3']));
$at3 = mysqli_real_escape_string($dbc,trim($_POST['a_title3']));
$aa3 = mysqli_real_escape_string($dbc,trim($_POST['a_author3']));
$aip3 = mysqli_real_escape_string($dbc,trim($_POST['a_incl_pages3']));
$ai3 = mysqli_real_escape_string($dbc,trim($_POST['a_issn3']));
$asm3 = mysqli_real_escape_string($dbc,trim($_POST['a_supply_method3']));
$an3 = mysqli_real_escape_string($dbc,trim($_POST['a_notes3']));

// Check if Request #3 exists
if(!empty($ct3) || !empty($cn3) || !empty($bt3) || !empty($ba3) || !empty($bct3) || !empty($bip3) || !empty($bi3) || !empty($be3) || !empty($bp3) || !empty($bpp3) || !empty($bpd3) || !empty($bcn3) || !empty($bn3))
{
$errors3 = array();
$request_3 = 1;

	// Semester	
	$semester3 = $sem3;

	// Semester Year
	$semester_year3 = $sem_year3; 
	
	// Course Title
	$course_title3 = $ct3; 
	
	// Course Number 
	if(empty($cn3)) 
	{$errors3[] = "Please enter the <b>Course Number</b>";}
	else
	{$course_no3 = $cn3;}
	
	//Loan Period
	if(empty($lp3)) 
	{$a_loan_period3 = "" ;}
	else
	{$a_loan_period3 = $lp3;}
	
	// Journal Title
	if(empty($jt3)) 
	{$errors3[] = "Please enter the <b>Journal Title</b>";}
	else
	{$j_title3 = $jt3;}

	// Journal Volume
	if(empty($jv3)) 
	{$errors3[] = "Please enter the <b>Journal Volume</b>";}
	else
	{$j_volume3 = $jv3;}

	//Journal Issue
	if(empty($ji3)) 
	{$j_issue3 = "" ;}
	else
	{$j_issue3 = $ji3;}

	//Journal Month
	if(empty($jm3)) 
	{$j_month3 = "" ;}
	else
	{$j_month3 = $jm3;}

	//Journal Year
	if(empty($jy3)) 
	{$errors3[] = "Please enter the <b>Journal Year</b>";}
	else
	{$j_year3 = $jy3;}	

	//Article Title
	if(empty($at3)) 
	{$errors3[] = "Please enter the <b>Article Title</b>";}
	else
	{$a_title3 = $at3;}	

	//Article Author
	if(empty($aa3)) 
	{$errors3[] = "Please enter the <b>Article Author</b>";}
	else
	{$a_author3 = $aa3;}	
	
	// Inclusive Pages
	if(empty($aip3)) 
	{$errors3[] = "Please enter the <b>Inclusive Pages</b>";}
	else
	{$a_incl_pages3 = $aip3;}

	//Article ISSN
	if(empty($ai3)) 
	{$a_issn3 = "";}
	else
	{$a_issn3 = $ai3;}

	// Article Supply Method
	if(empty($asm3)) 
	{$a_supply_method3 = "";}
	else
	{$a_supply_method3 = $asm3;}
	
	// Article Notes
	if(empty($an3)) 
	{$a_notes3 = "";}
	else
	{$a_notes3 = $an3;}

}

?>
