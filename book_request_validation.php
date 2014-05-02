<!-- 
Created by: Siddharth Choksi in May 2010
This file validates the Book Request(s) Fields. (Parent File: book_request.php)
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
$bt1 = mysqli_real_escape_string($dbc,trim($_POST['b_title1']));
$ba1 = mysqli_real_escape_string($dbc,trim($_POST['b_author1']));
$bi1 = mysqli_real_escape_string($dbc,trim($_POST['b_isbn1']));	
$be1 = mysqli_real_escape_string($dbc,trim($_POST['b_edition1']));
$bp1 = mysqli_real_escape_string($dbc,trim($_POST['b_publisher1']));
$bpp1 = mysqli_real_escape_string($dbc,trim($_POST['b_place_of_pub1']));
$bpd1 = mysqli_real_escape_string($dbc,trim($_POST['b_pub_date1']));
$bcn1 = mysqli_real_escape_string($dbc,trim($_POST['b_call_no1']));
$bsm1 = mysqli_real_escape_string($dbc,trim($_POST['b_supply_method1']));
$bn1 = mysqli_real_escape_string($dbc,trim($_POST['b_notes1']));

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
	{$b_title1 = $bt1;}

	//Book Author
	if(empty($ba1)) 
	{$errors1[] = "Please enter the <b>Book Author</b>";}
	else
	{$b_author1 = $ba1;}	
	
	//Book ISBN
	if(empty($bi1)) 
	{$b_isbn1 = "";}
	else
	{$b_isbn1 = $bi1;}

	// Book Edition
	if(empty($be1)) 
	{$b_edition1 = "";}
	else
	{$b_edition1 = $be1;}
	
	// Book Publisher
	if(empty($bp1)) 
	{$b_publisher1 = "";}
	else
	{$b_publisher1 = $bp1;}
	
	// Place of Publication 
	if(empty($bpp1)) 
	{$b_place_of_pub1 = "";}
	else
	{$b_place_of_pub1 = $bpp1;}
		
	// Book Publication Date
	if(empty($bpd1)) 
	{$errors1[] = "Please enter the <b>Publication Date</b>";}
	else
	{$b_pub_date1 = $bpd1;}
		
	// Book Call Number 
	if(empty($bcn1)) 
	{$b_call_no1 = "";}
	else
	{$b_call_no1 = $bcn1;}

	// Book Supply Method
	if(empty($bsm1)) 
	{$b_supply_method1 = "";}
	else
	{$b_supply_method1 = $bsm1;}
	
	// Book Notes
	if(empty($bn1)) 
	{$b_notes1 = "";}
	else
	{$b_notes1 = $bn1;}
	

// Allocation of posted values to temp variables after mysqli_real_escape_string($dbc,trimming) for Request #2 
$sem2 = mysqli_real_escape_string($dbc,$_POST['semester2']);
$sem_year2 = mysqli_real_escape_string($dbc,$_POST['semester_year2']);
$ct2 = mysqli_real_escape_string($dbc,trim($_POST['course_title2']));
$cn2 = mysqli_real_escape_string($dbc,trim($_POST['course_no2']));
$lp2 = mysqli_real_escape_string($dbc,trim($_POST['loan_period2']));
$bt2 = mysqli_real_escape_string($dbc,trim($_POST['b_title2']));
$ba2 = mysqli_real_escape_string($dbc,trim($_POST['b_author2']));
$bi2 = mysqli_real_escape_string($dbc,trim($_POST['b_isbn2']));	
$be2 = mysqli_real_escape_string($dbc,trim($_POST['b_edition2']));
$bp2 = mysqli_real_escape_string($dbc,trim($_POST['b_publisher2']));
$bpp2 = mysqli_real_escape_string($dbc,trim($_POST['b_place_of_pub2']));
$bpd2 = mysqli_real_escape_string($dbc,trim($_POST['b_pub_date2']));
$bcn2 = mysqli_real_escape_string($dbc,trim($_POST['b_call_no2']));
$bsm2 = mysqli_real_escape_string($dbc,trim($_POST['b_supply_method2']));
$bn2 = mysqli_real_escape_string($dbc,trim($_POST['b_notes2']));

// Check if Request #2 exists
if(!empty($ct2) || !empty($cn2) || !empty($bt2) || !empty($ba2) || !empty($bi2) || !empty($be2) || !empty($bp2) || !empty($bpp2) || !empty($bpd2) || !empty($bcn2) || !empty($bn2))
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
	{$b_title2 = $bt2;}

	//Book Author
	if(empty($ba2)) 
	{$errors2[] = "Please enter the <b>Book Author</b>";}
	else
	{$b_author2 = $ba2;}	
	
	//Book ISBN
	if(empty($bi2)) 
	{$b_isbn2 = "";}
	else
	{$b_isbn2 = $bi2;}

	// Book Edition
	if(empty($be2)) 
	{$b_edition2 = "";}
	else
	{$b_edition2 = $be2;}
	
	// Book Publisher
	if(empty($bp2)) 
	{$b_publisher2 = "";}
	else
	{$b_publisher2 = $bp2;}
	
	// Place of Publication 
	if(empty($bpp2)) 
	{$b_place_of_pub2 = "";}
	else
	{$b_place_of_pub2 = $bpp2;}
		
	// Book Publication Date
	if(empty($bpd2)) 
	{$errors2[] = "Please enter the <b>Publication Date</b>";}
	else
	{$b_pub_date2 = $bpd2;}
		
	// Book Call Number 
	if(empty($bcn2)) 
	{$b_call_no2 = "";}
	else
	{$b_call_no2 = $bcn2;}

	// Book Supply Method
	if(empty($bsm2)) 
	{$b_supply_method2 = "";}
	else
	{$b_supply_method2 = $bsm2;}
	
	// Book Notes
	if(empty($bn2)) 
	{$b_notes2 = "";}
	else
	{$b_notes2 = $bn2;}

}


// Allocation of posted values to temp variables after mysqli_real_escape_string($dbc,trimming) 
$sem3 = mysqli_real_escape_string($dbc,$_POST['semester3']);
$sem_year3 = mysqli_real_escape_string($dbc,$_POST['semester_year3']);
$ct3 = mysqli_real_escape_string($dbc,trim($_POST['course_title3']));
$cn3 = mysqli_real_escape_string($dbc,trim($_POST['course_no3']));
$lp3 = mysqli_real_escape_string($dbc,trim($_POST['loan_period3']));
$bt3 = mysqli_real_escape_string($dbc,trim($_POST['b_title3']));
$ba3 = mysqli_real_escape_string($dbc,trim($_POST['b_author3']));
$bi3 = mysqli_real_escape_string($dbc,trim($_POST['b_isbn3']));	
$be3 = mysqli_real_escape_string($dbc,trim($_POST['b_edition3']));
$bp3 = mysqli_real_escape_string($dbc,trim($_POST['b_publisher3']));
$bpp3 = mysqli_real_escape_string($dbc,trim($_POST['b_place_of_pub3']));
$bpd3 = mysqli_real_escape_string($dbc,trim($_POST['b_pub_date3']));
$bcn3 = mysqli_real_escape_string($dbc,trim($_POST['b_call_no3']));
$bsm3 = mysqli_real_escape_string($dbc,trim($_POST['b_supply_method3']));
$bn3 = mysqli_real_escape_string($dbc,trim($_POST['b_notes3']));

 

// Check if Request #3 exists
if(!empty($ct3) || !empty($cn3)|| !empty($bt3) || !empty($ba3) || !empty($bi3) || !empty($be3) || !empty($bp3) || !empty($bpp3) || !empty($bpd3) || !empty($bcn3) || 
!empty($bn3) )
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
	{$b_title3 = $bt3;}

	//Book Author
	if(empty($ba3)) 
	{$errors3[] = "Please enter the <b>Book Author</b>";}
	else
	{$b_author3 = $ba3;}	
	
	//Book ISBN
	if(empty($bi3)) 
	{$b_isbn3 = "";}
	else
	{$b_isbn3 = $bi3;}

	// Book Edition
	if(empty($be3)) 
	{$b_edition3 = "";}
	else
	{$b_edition3 = $be3;}
	
	// Book Publisher
	if(empty($bp3)) 
	{$b_publisher3 = "";}
	else
	{$b_publisher3 = $bp3;}
	
	// Place of Publication 
	if(empty($bpp3)) 
	{$b_place_of_pub3 = "";}
	else
	{$b_place_of_pub3 = $bpp3;}
		
	// Book Publication Date
	if(empty($bpd3)) 
	{$errors3[] = "Please enter the <b>Publication Date</b>";}
	else
	{$b_pub_date3 = $bpd3;}
		
	// Book Call Number 
	if(empty($bcn3)) 
	{$b_call_no3 = "";}
	else
	{$b_call_no3 = $bcn3;}

	// Book Supply Method
	if(empty($bsm3)) 
	{$b_supply_method3 = "";}
	else
	{$b_supply_method3 = $bsm3;}
	
	// Book Notes
	if(empty($bn3)) 
	{$b_notes3 = "";}
	else
	{$b_notes3 = $bn3;}
}

?>
