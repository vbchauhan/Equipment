<!-- 
Created by: Siddharth Choksi in May 2010
This file inserts Chapter Request #2 into the database once everything has been validated. (Parent File: chapter_request.php)
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

// Function to generate Chapter Request ID
function bc_id2()
{
$first = ceil(rand(100000, 999999)); 
$second = ceil(rand(0,100));
$bc_id2 = $first+$second;
return $bc_id2;
}

// Check if Chapter Request ID is unique
while($x2 != 1)
{
$bc_id2 = bc_id2();
$query = "SELECT bc_id FROM c_request WHERE bc_id = '$bc_id2'";
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

// Check if Chapter Request already Exists 
$query = "SELECT b.bc_id, p.p_email 
FROM c_request b, course c, professor p 
WHERE b.bc_author = '$bc_author2' AND b.bc_b_title = '$bc_b_title2' AND b.bc_c_title = '$bc_c_title2' AND b.bc_incl_pages = '$bc_incl_pages2' AND b.bc_date_of_pub = '$bc_pub_date2' AND b.c_id = c.c_id AND b.p_email = '$p_email' AND b.c_id = '$c_id2' AND b.p_email = p.p_email";

$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num == 1)
{$exists2 = 1;
$request2 = 1;
}

else
{
// Insert Chapter Request Details
$query = "INSERT into c_request(bc_id, bc_b_title, bc_author, bc_c_title, bc_incl_pages, bc_publisher, bc_place_of_pub, bc_date_of_pub, bc_edition, bc_isbn, bc_supply_method, bc_notes, bc_call_number, bc_loan_period, p_email, c_id, bc_req_date) VALUES('$bc_id2', '$bc_b_title2', '$bc_author2', '$bc_c_title2', '$bc_incl_pages2', '$bc_publisher2', '$bc_place_of_pub2', '$bc_pub_date2', '$bc_edition2', '$bc_isbn2', '$bc_supply_method2', '$bc_notes2', '$bc_call_no2', '$bc_loan_period2', '$p_email', '$c_id2', '$date')";
$result = @mysqli_query($dbc, $query);

if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
{$request2 = 1;}
}

?>
