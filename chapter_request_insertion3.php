<!-- 
Created by: Siddharth Choksi in May 2010
This file inserts Chapter Request #3 into the database once everything has been validated. (Parent File: chapter_request.php)
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

// Function to generate Chapter Request ID
function bc_id3()
{
$first = ceil(rand(100000, 999999)); 
$second = ceil(rand(0,100));
$bc_id3 = $first+$second;
return $bc_id3;
}

// Check if Chapter Request ID is unique
while($x3 != 1)
{
$bc_id3 = bc_id3();
$query = "SELECT bc_id FROM b_request WHERE bc_id = '$bc_id3'";
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

// Check if Chapter Request already Exists 
$query = "SELECT b.bc_id, p.p_email 
FROM c_request b, course c, professor p 
WHERE b.bc_author = '$bc_author3' AND b.bc_b_title = '$bc_b_title3' AND b.bc_c_title = '$bc_c_title3' AND b.bc_incl_pages = '$bc_incl_pages3' AND b.bc_date_of_pub = '$bc_pub_date3' AND b.c_id = c.c_id AND b.p_email = '$p_email' AND b.c_id = '$c_id3' AND b.p_email = p.p_email";

$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num == 1)
{$exists3 = 1;
$request3 = 1;
}

else
{
// Insert Chapter Request Details
$query = "INSERT into c_request(bc_id, bc_b_title, bc_author, bc_c_title, bc_incl_pages, bc_publisher, bc_place_of_pub, bc_date_of_pub, bc_edition, bc_isbn, bc_supply_method, bc_notes, bc_call_number, bc_loan_period, p_email, c_id, bc_req_date) VALUES('$bc_id3', '$bc_b_title3', '$bc_author3', '$bc_c_title3', '$bc_incl_pages3', '$bc_publisher3', '$bc_place_of_pub3', '$bc_pub_date3', '$bc_edition3', '$bc_isbn3', '$bc_supply_method3', '$bc_notes3', '$bc_call_no3', '$bc_loan_period3', '$p_email', '$c_id3', '$date')";
$result = @mysqli_query($dbc, $query);

if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
{$request3 = 1;}
}

?>
