<!-- 
Created by: Siddharth Choksi in May 2010
This file inserts Book Request #3 into the database once everything has been validated. (Parent File: book_request.php)
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

// Function to generate Book Request ID
function b_id3()
{
$first = ceil(rand(100000, 999999)); 
$second = ceil(rand(0,100));
$b_id3 = $first+$second;
return $b_id3;
}

// Check if Book Request ID is unique
while($x3 != 1)
{
$b_id3 = b_id3();
$query = "SELECT b_id FROM b_request WHERE b_id = '$b_id3'";
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

// Check if Book Request already Exists 
$query = "SELECT b.b_id, p.p_email 
FROM b_request b, course c, professor p 
WHERE b.b_author = '$b_author3' AND b.b_title = '$b_title3' AND b.b_date_of_pub = '$b_pub_date3' AND b.c_id = '$c_id3' AND b.c_id = c.c_id AND b.p_email = '$p_email' AND b.p_email = p.p_email";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num == 1)
{$exists3 = 1;
$request3 = 1;
}

else
{
// Insert Book Request Details
$query = "INSERT into b_request(b_id, b_title, b_author, b_publisher, b_place_of_pub, b_date_of_pub, b_book_edition, b_isbn, b_supply_method, b_notes, b_call_number, b_loan_period, p_email, c_id, b_req_date) VALUES('$b_id3', '$b_title3', '$b_author3', '$b_publisher3', '$b_place_of_pub3', '$b_pub_date3', '$b_edition3', '$b_isbn3', '$b_supply_method3', '$b_notes3', '$b_call_no3', '$b_loan_period3', '$p_email', '$c_id3', '$date')";
$result = @mysqli_query($dbc, $query);

if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
{$request3 = 1;}
}

?>
