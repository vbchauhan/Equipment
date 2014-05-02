<!-- 
Created by: Siddharth Choksi in May 2010
This file inserts Article Request #3 into the database once everything has been validated. (Parent File: article_request.php)
-->
<?php
$course3 = 0;
$result3 = 0;

// Check if Course Information already exists in the database
$query = "SELECT course_no, semester, semester_year FROM course WHERE course_no = '$course_no3' AND semester = '$semester3' AND  semester_year = '$semester_year3'";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num != 1)  // New Course Record
{
	$query = "INSERT into course(course_no, course_title, semester, semester_year) VALUES('$course_no3', '$course_title3', '$semester3', '$semester_year3')";
	$result = @mysqli_query($dbc, $query);
	if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
	{$course3 = 1;}
}
else{$course3 = 1;}

// Function to generate Article Request ID
function a_id3()
{
$first = ceil(rand(100000, 999999)); 
$second = ceil(rand(0,100));
$a_id3 = $first+$second;
return $a_id3;
}

// Check if Article Request ID is unique
while($x3 != 1)
{
$a_id3 = a_id3();
$query = "SELECT a_id FROM a_request WHERE a_id = '$a_id3'";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);
if($num != 1)
{$x3 = 1;}
}

// Retrieve Course Id
$query = "SELECT c_id FROM course WHERE course_no = '$course_no3' AND semester = '$semester3' AND  semester_year = '$semester_year3'";
$result = @mysqli_query($dbc, $query);
$row  = @mysqli_fetch_array($result, MYSQLI_NUM);
$c_id3 = $row[0];

// Check if Article Request already Exists 
$query = "SELECT a.a_id, p.p_email 
FROM a_request a, course c, professor p 
WHERE a.j_title = '$j_title3' AND a.j_volume = '$j_volume3' AND a.j_year = '$j_year3' AND a.a_title = '$a_title3' AND a.a_author = '$a_author3' AND a.a_incl_pages = '$a_incl_pages3' AND a.c_id = c.c_id AND a.p_email = '$p_email' AND a.c_id = '$c_id3' AND a.p_email = p.p_email";

$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num == 1)
{$exists3 = 1;
$request3 = 1;
}

else
{
// Insert Article Request Details
$query = "INSERT into a_request(a_id, j_title, j_volume, j_issue, j_month, j_year, a_title, a_author, a_incl_pages, a_issn, a_supply_method, a_notes, a_loan_period, p_email, c_id, a_req_date) VALUES('$a_id3', '$j_title3', '$j_volume3', '$j_issue3', '$j_month3', '$j_year3', '$a_title3', '$a_author3', '$a_incl_pages3', '$a_issn3', '$a_supply_method3', '$a_notes3', '$a_loan_period3', '$p_email', '$c_id3', '$date')";
$result = @mysqli_query($dbc, $query);

if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
{$request3 = 1;}
}

?>
