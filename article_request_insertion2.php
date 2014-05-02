<!-- 
Created by: Siddharth Choksi in May 2010
This file inserts Article Request #2 into the database once everything has been validated. (Parent File: article_request.php)
-->
<?php
$course2 = 0;
$result2 = 0;

// Check if Course Information already exists in the database
$query = "SELECT course_no, semester, semester_year FROM course WHERE course_no = '$course_no2' AND semester = '$semester2' AND  semester_year = '$semester_year2'";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num != 1)  // New Course Record
{
$query = "INSERT into course(course_no, course_title, semester, semester_year) VALUES('$course_no2', '$course_title2', '$semester2', '$semester_year2')";
$result = @mysqli_query($dbc, $query);
	if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
	{$course2= 1;}
}
else{$course2=1;}

// Function to generate Article Request ID
function a_id2()
{
$first = ceil(rand(100000, 999999)); 
$second = ceil(rand(0,100));
$a_id2 = $first+$second;
return $a_id2;
}

// Check if Article Request ID is unique
while($x2 != 1)
{
$a_id2 = a_id2();
$query = "SELECT a_id FROM a_request WHERE a_id = '$a_id2'";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);
if($num != 1)
{$x2 = 1;}
}

// Retrieve Course ID
$query = "SELECT c_id FROM course WHERE course_no = '$course_no2' AND semester = '$semester2' AND  semester_year = '$semester_year2'";
$result = @mysqli_query($dbc, $query);
$row  = @mysqli_fetch_array($result, MYSQLI_NUM);
$c_id2 = $row[0];

// Check if Article Request already Exists 
$query = "SELECT a.a_id, p.p_email 
FROM a_request a, course c, professor p 
WHERE a.j_title = '$j_title2' AND a.j_volume = '$j_volume2' AND a.j_year = '$j_year2' AND a.a_title = '$a_title2' AND a.a_author = '$a_author2' AND a.a_incl_pages = '$a_incl_pages2' AND a.c_id = c.c_id AND a.p_email = '$p_email' AND a.c_id = '$c_id2' AND a.p_email = p.p_email";

$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num == 1)
{$exists2 = 1;
$request2 = 1;
}

else
{
// Insert Article Request Details
$query = "INSERT into a_request(a_id, j_title, j_volume, j_issue, j_month, j_year, a_title, a_author, a_incl_pages, a_issn, a_supply_method, a_notes, a_loan_period, p_email, c_id, a_req_date) VALUES('$a_id2', '$j_title2', '$j_volume2', '$j_issue2', '$j_month2', '$j_year2', '$a_title2', '$a_author2', '$a_incl_pages2', '$a_issn2', '$a_supply_method2', '$a_notes2', '$a_loan_period2', '$p_email', '$c_id2', '$date')";
$result = @mysqli_query($dbc, $query);

if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
{$request2 = 1;}
}

?>
