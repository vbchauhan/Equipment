<!-- 
Created by: Siddharth Choksi in May 2010
This file inserts Instructor Information and Article Request #1 into the database once everything has been validated. (Parent File: article_request.php)
-->
<?php 
$professor = 0;
$course1=0;
$request1 = 0;

// Check if Instructor Information already exists in the database
$query = "SELECT p_email FROM professor WHERE p_email = '$p_email'";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

// Instructor Record already exists 
if($num == '1')
{
$query = "UPDATE professor SET p_last_name= '$p_last_name', p_first_name = '$p_first_name', p_phone_number = '$p_phone_number', p_university = '$p_university' WHERE p_email = '$p_email' LIMIT 1";
$result = @mysqli_query($dbc, $query);
$professor = 1;
}

// New Instructor Record to be inserted
else
{
echo "prof";
$query = "INSERT into professor VALUES('$p_email','$p_last_name','$p_first_name','$p_university','$p_phone_number')";
$result = @mysqli_query($dbc, $query);
	if(mysqli_affected_rows($dbc) == 1) // Professor Record insertion successful
	{$professor = 1;}
}

// Check if Course Information already exists in the database
$query = "SELECT course_no, semester, semester_year FROM course WHERE course_no = '$course_no1' AND semester = '$semester1' AND  semester_year = '$semester_year1'";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num != 1)  // New Course Record
{
$query = "INSERT into course(course_no, course_title, semester, semester_year) VALUES('$course_no1', '$course_title1', '$semester1', '$semester_year1')";
$result = @mysqli_query($dbc, $query);
	if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
	{$course1= 1;}
}
else{$course1=1;}

// Function to generate Article Request ID
function a_id()
{
$first = ceil(rand(100000, 999999)); 
$second = ceil(rand(0,100));
$a_id1 = $first+$second;
return $a_id1;
}

// Check if Article Request ID is unique
while($x1 != 1)
{
$a_id1 = a_id();
$query = "SELECT a_id FROM a_request WHERE a_id = '$a_id1'";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);
if($num != 1)
{$x1 = 1;}
}

// Retrieve Course Id
$query = "SELECT c_id FROM course WHERE course_no = '$course_no1' AND semester = '$semester1' AND  semester_year = '$semester_year1'";
$result = @mysqli_query($dbc, $query);
$row  = @mysqli_fetch_array($result, MYSQLI_NUM);
$c_id1 = $row[0];

// Check if Article Request already Exists 
$query = "SELECT a.a_id, p.p_email 
FROM a_request a, course c, professor p 
WHERE a.j_title = '$j_title1' AND a.j_volume = '$j_volume1' AND a.j_year = '$j_year1' AND a.a_title = '$a_title1' AND a.a_author = '$a_author1' AND a.a_incl_pages = '$a_incl_pages1' AND a.c_id = c.c_id AND a.p_email = '$p_email' AND a.c_id = '$c_id1' AND a.p_email = p.p_email";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);
$row  = @mysqli_fetch_array($result, MYSQLI_NUM);

if($num == 1)
{$exists1 = 1;
$request1 = 1;
}

else
{
// Insert Article Request Details
$query = "INSERT into a_request(a_id, j_title, j_volume, j_issue, j_month, j_year, a_title, a_author, a_incl_pages, a_issn, a_supply_method, a_notes, a_loan_period, p_email, c_id, a_req_date) VALUES('$a_id1', '$j_title1', '$j_volume1', '$j_issue1', '$j_month1', '$j_year1', '$a_title1', '$a_author1', '$a_incl_pages1', '$a_issn1', '$a_supply_method1', '$a_notes1', '$a_loan_period1', '$p_email', '$c_id1', '$date')";
$result = @mysqli_query($dbc, $query);

if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
{$request1 = 1;}
}

?>
