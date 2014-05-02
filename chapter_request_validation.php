<!-- 
Created by: Siddharth Choksi in May 2010
This file validates the Chapter Request(s) Fields. (Parent File: chapter_request.php)
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
$bt1 = mysqli_real_escape_string($dbc,trim($_POST['bc_b_title1']));
$ba1 = mysqli_real_escape_string($dbc,trim($_POST['bc_author1']));
$bct1 = mysqli_real_escape_string($dbc,trim($_POST['bc_c_title1'])); 
$be1 = mysqli_real_escape_string($dbc,trim($_POST['bc_edition1']));
$bip1 = mysqli_real_escape_string($dbc,trim($_POST['bc_incl_pages1']));
$bi1 = mysqli_real_escape_string($dbc,trim($_POST['bc_isbn1']));
$bp1 = mysqli_real_escape_string($dbc,trim($_POST['bc_publisher1']));
$bpp1 = mysqli_real_escape_string($dbc,trim($_POST['bc_place_of_pub1']));
$bpd1 = mysqli_real_escape_string($dbc,trim($_POST['bc_date_of_pub1']));
$bcn1 = mysqli_real_escape_string($dbc,trim($_POST['bc_call_no1']));
$bsm1 = mysqli_real_escape_string($dbc,trim($_POST['bc_supply_method1']));
$bn1 = mysqli_real_escape_string($dbc,trim($_POST['bc_notes1']));

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
	{$loan_period1 = "" ;}
	else
	{$loan_period1 = $lp1;}
	
	// Book Title
	if(empty($bt1)) 
	{$errors1[] = "Please enter the <b>Book Title</b>";}
	else
	{$bc_b_title1 = $bt1;}

	//Book Author
	if(empty($ba1)) 
	{$errors1[] = "Please enter the <b>Book Author</b>";}
	else
	{$bc_author1 = $ba1;}	
	
	// Chapter Title
	if(empty($bct1)) 
	{$errors1[] = "Please enter the <b>Chapter Title</b>";}
	else
	{$bc_c_title1 = $bct1;}

	// Inclusive Pages
	if(empty($bip1)) 
	{$errors1[] = "Please enter the <b>Inclusive Pages</b>";}
	else
	{$bc_incl_pages1 = $bip1;}

	// Book ISBN
	if(empty($bi1)) 
	{$bc_isbn1 = "";}
	else
	{$bc_isbn1 = $bi1;}

	// Book Edition
	if(empty($be1)) 
	{$bc_edition1 = "";}
	else
	{$bc_edition1 = $be1;}
	
	// Book Publisher
	if(empty($bp1)) 
	{$bc_publisher1 = "";}
	else
	{$bc_publisher1 = $bp1;}
	
	// Place of Publication 
	if(empty($bpp1)) 
	{$bc_place_of_pub1 = "";}
	else
	{$bc_place_of_pub1 = $bpp1;}
		
	// Book Publication Date
	if(empty($bpd1)) 
	{$errors1[] = "Please enter the <b>Publication Date</b>";}
	else
	{$bc_pub_date1 = $bpd1;}
		
	// Book Call Number 
	if(empty($bcn1)) 
	{$bc_call_no1 = "";}
	else
	{$bc_call_no1 = $bcn1;}

	// Book Supply Method
	if(empty($bsm1)) 
	{$bc_supply_method1 = "";}
	else
	{$bc_supply_method1 = $bsm1;}
	
	// Book Notes
	if(empty($bn1)) 
	{$bc_notes1 = "";}
	else
	{$bc_notes1 = $bn1;}
	

// Allocation of posted values to temp variables after mysqli_real_escape_string($dbc,trimming) for Request #2 
$sem2 = mysqli_real_escape_string($dbc,$_POST['semester2']);
$sem_year2 = mysqli_real_escape_string($dbc,$_POST['semester_year2']);
$ct2 = mysqli_real_escape_string($dbc,trim($_POST['course_title2']));
$cn2 = mysqli_real_escape_string($dbc,trim($_POST['course_no2']));
$lp2 = mysqli_real_escape_string($dbc,trim($_POST['loan_period2']));
$bt2 = mysqli_real_escape_string($dbc,trim($_POST['bc_b_title2']));
$ba2 = mysqli_real_escape_string($dbc,trim($_POST['bc_author2']));
$bct2 = mysqli_real_escape_string($dbc,trim($_POST['bc_c_title2'])); 
$be2 = mysqli_real_escape_string($dbc,trim($_POST['bc_edition2']));
$bip2 = mysqli_real_escape_string($dbc,trim($_POST['bc_incl_pages2']));
$bi2 = mysqli_real_escape_string($dbc,trim($_POST['bc_isbn2']));	
$bp2 = mysqli_real_escape_string($dbc,trim($_POST['bc_publisher2']));
$bpp2 = mysqli_real_escape_string($dbc,trim($_POST['bc_place_of_pub2']));
$bpd2 = mysqli_real_escape_string($dbc,trim($_POST['bc_date_of_pub2']));
$bcn2 = mysqli_real_escape_string($dbc,trim($_POST['bc_call_no2']));
$bsm2 = mysqli_real_escape_string($dbc,trim($_POST['bc_supply_method2']));
$bn2 = mysqli_real_escape_string($dbc,trim($_POST['bc_notes2']));


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
	{$loan_period2 = "" ;}
	else
	{$loan_period2 = $lp2;}
	
	// Book Title
	if(empty($bt2)) 
	{$errors2[] = "Please enter the <b>Book Title</b>";}
	else
	{$bc_b_title2 = $bt2;}

	//Book Author
	if(empty($ba2)) 
	{$errors2[] = "Please enter the <b>Book Author</b>";}
	else
	{$bc_author2 = $ba2;}	
	
	// Chapter Title
	if(empty($bct2)) 
	{$errors2[] = "Please enter the <b>Chapter Title</b>";}
	else
	{$bc_c_title2 = $bct2;}

	// Inclusive Pages
	if(empty($bip2)) 
	{$errors2[] = "Please enter the <b>Inclusive Pages</b>";}
	else
	{$bc_incl_pages2 = $bip2;}

	//Book ISBN
	if(empty($bi2)) 
	{$bc_isbn2 = "";}
	else
	{$bc_isbn2 = $bi2;}

	// Book Edition
	if(empty($be2)) 
	{$bc_edition2 = "";}
	else
	{$bc_edition2 = $be2;}
	
	// Book Publisher
	if(empty($bp2)) 
	{$bc_publisher2 = "";}
	else
	{$bc_publisher2 = $bp2;}
	
	// Place of Publication 
	if(empty($bpp2)) 
	{$bc_place_of_pub2 = "";}
	else
	{$bc_place_of_pub2 = $bpp2;}
		
	// Book Publication Date
	if(empty($bpd2)) 
	{$errors2[] = "Please enter the <b>Publication Date</b>";}
	else
	{$bc_pub_date2 = $bpd2;}
		
	// Book Call Number 
	if(empty($bcn2)) 
	{$bc_call_no2 = "";}
	else
	{$bc_call_no2 = $bcn2;}

	// Book Supply Method
	if(empty($bsm2)) 
	{$bc_supply_method2 = "";}
	else
	{$bc_supply_method2 = $bsm2;}
	
	// Book Notes
	if(empty($bn2)) 
	{$bc_notes2 = "";}
	else
	{$bc_notes2 = $bn2;}

}


// Allocation of posted values to temp variables after mysqli_real_escape_string($dbc,trimming) 
$sem3 = mysqli_real_escape_string($dbc,$_POST['semester3']);
$sem_year3 = mysqli_real_escape_string($dbc,$_POST['semester_year3']);
$ct3 = mysqli_real_escape_string($dbc,trim($_POST['course_title3']));
$cn3 = mysqli_real_escape_string($dbc,trim($_POST['course_no3']));
$lp3 = mysqli_real_escape_string($dbc,trim($_POST['loan_period3']));
$bt3 = mysqli_real_escape_string($dbc,trim($_POST['bc_b_title3']));
$ba3 = mysqli_real_escape_string($dbc,trim($_POST['bc_author3']));
$bct3 = mysqli_real_escape_string($dbc,trim($_POST['bc_c_title3'])); 
$be3 = mysqli_real_escape_string($dbc,trim($_POST['bc_edition3']));
$bip3 = mysqli_real_escape_string($dbc,trim($_POST['bc_incl_pages3']));
$bi3 = mysqli_real_escape_string($dbc,trim($_POST['bc_isbn3']));	
$bp3 = mysqli_real_escape_string($dbc,trim($_POST['bc_publisher3']));
$bpp3 = mysqli_real_escape_string($dbc,trim($_POST['bc_place_of_pub3']));
$bpd3 = mysqli_real_escape_string($dbc,trim($_POST['bc_date_of_pub3']));
$bcn3 = mysqli_real_escape_string($dbc,trim($_POST['bc_call_no3']));
$bsm3 = mysqli_real_escape_string($dbc,trim($_POST['bc_supply_method3']));
$bn3 = mysqli_real_escape_string($dbc,trim($_POST['bc_notes3']));

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
	{$loan_period3 = "" ;}
	else
	{$loan_period3 = $lp3;}
	
	// Book Title
	if(empty($bt3)) 
	{$errors3[] = "Please enter the <b>Book Title</b>";}
	else
	{$bc_b_title3 = $bt3;}

	//Book Author
	if(empty($ba3)) 
	{$errors3[] = "Please enter the <b>Book Author</b>";}
	else
	{$bc_author3 = $ba3;}	
	
	// Chapter Title
	if(empty($bct3)) 
	{$errors3[] = "Please enter the <b>Chapter Title</b>";}
	else
	{$bc_c_title3 = $bct3;}

	// Inlcusive Pages
	if(empty($bip3)) 
	{$errors3[] = "Please enter the <b>Inclusive Pages</b>";}
	else
	{$bc_incl_pages3 = $bip3;}

	//Book ISBN
	if(empty($bi3)) 
	{$bc_isbn3 = "";}
	else
	{$bc_isbn3 = $bi3;}

	// Book Edition
	if(empty($be3)) 
	{$bc_edition3 = "";}
	else
	{$bc_edition3 = $be3;}
	
	// Book Publisher
	if(empty($bp3)) 
	{$bc_publisher3 = "";}
	else
	{$bc_publisher3 = $bp3;}
	
	// Place of Publication 
	if(empty($bpp3)) 
	{$bc_place_of_pub3 = "";}
	else
	{$bc_place_of_pub3 = $bpp3;}
		
	// Book Publication Date
	if(empty($bpd3)) 
	{$errors3[] = "Please enter the <b>Publication Date</b>";}
	else
	{$bc_pub_date3 = $bpd3;}
		
	// Book Call Number 
	if(empty($bcn3)) 
	{$bc_call_no3 = "";}
	else
	{$bc_call_no3 = $bcn3;}

	// Book Supply Method
	if(empty($bsm3)) 
	{$bc_supply_method3 = "";}
	else
	{$bc_supply_method3 = $bsm3;}
	
	// Book Notes
	if(empty($bn3)) 
	{$bc_notes3 = "";}
	else
	{$bc_notes3 = $bn3;}
}

?>
