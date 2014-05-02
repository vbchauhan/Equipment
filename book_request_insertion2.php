<!-- 
Created by: Siddharth Choksi in May 2010
This file inserts Book Request #2 into the database once everything has been validated. (Parent File: book_request.php)
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

// Function to generate Book Request ID
function b_id2()
{
$first = ceil(rand(100000, 999999)); 
$second = ceil(rand(0,100));
$b_id2 = $first+$second;
return $b_id2;
}

// Check if Book Request ID is unique
while($x2 != 1)
{
$b_id2 = b_id2();
$query = "SELECT b_id FROM b_request WHERE b_id = '$b_id2'";
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

// Check if Book Request already Exists 
$query = "SELECT b.b_id, p.p_email 
FROM b_request b, course c, professor p 
WHERE b.b_author = '$b_author2' AND b.b_title = '$b_title2' AND b.b_date_of_pub = '$b_pub_date2' AND b.c_id = '$c_id2' AND b.c_id = c.c_id AND b.p_email = '$p_email' AND b.p_email = p.p_email";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num == 1)
{$exists2 = 1;
$request2 = 1;
}

else
{
// Insert Book Request Details
$query = "INSERT into b_request(b_id, b_title, b_author, b_publisher, b_place_of_pub, b_date_of_pub, b_book_edition, b_isbn, b_supply_method, b_notes, b_call_number, b_loan_period, p_email, c_id, b_req_date) VALUES('$b_id2', '$b_title2', '$b_author2', '$b_publisher2', '$b_place_of_pub2', '$b_pub_date2', '$b_edition2', '$b_isbn2', '$b_supply_method2', '$b_notes2', '$b_call_no2', '$b_loan_period2', '$p_email', '$c_id2', '$date')";
$result = @mysqli_query($dbc, $query);

if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
{$request2 = 1;}
}

?>
