<!-- 
Created by: Siddharth Choksi in May 2010
This file inserts Instructor Information and Chapter Request #1 into the database once everything has been validated. (Parent File: chapter_request.php)
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

// Function to generate Chapter Request ID
function bc_id()
{
$first = ceil(rand(100000, 999999)); 
$second = ceil(rand(0,100));
$bc_id1 = $first+$second;
return $bc_id1;
}

// Check if Chapter Request ID is unique
while($x1 != 1)
{
$bc_id1 = bc_id();
$query = "SELECT bc_id FROM c_request WHERE bc_id = '$bc_id1'";
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

// Check if Chapter Request already Exists 
$query = "SELECT b.bc_id, p.p_email 
FROM c_request b, course c, professor p 
WHERE b.bc_author = '$bc_author1' AND b.bc_b_title = '$bc_b_title1' AND b.bc_c_title = '$bc_c_title1' AND b.bc_incl_pages = '$bc_incl_pages1' AND b.bc_date_of_pub = '$bc_pub_date1' AND b.c_id = c.c_id AND b.p_email = '$p_email' AND b.c_id = '$c_id1' AND b.p_email = p.p_email";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);
$row  = @mysqli_fetch_array($result, MYSQLI_NUM);

if($num == 1)
{$exists1 = 1;
$request1 = 1;
}

else
{
// Insert Chapter Request Details
$query = "INSERT into c_request(bc_id, bc_b_title, bc_author, bc_c_title, bc_incl_pages, bc_publisher, bc_place_of_pub, bc_date_of_pub, bc_edition, bc_isbn, bc_supply_method, bc_notes, bc_call_number, bc_loan_period, p_email, c_id, bc_req_date) VALUES('$bc_id1', '$bc_b_title1', '$bc_author1', '$bc_c_title1', '$bc_incl_pages1', '$bc_publisher1', '$bc_place_of_pub1', '$bc_pub_date1', '$bc_edition1', '$bc_isbn1', '$bc_supply_method1', '$bc_notes1', '$bc_call_no1', '$bc_loan_period1', '$p_email', '$c_id1', '$date')";
$result = @mysqli_query($dbc, $query);

if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
{$request1 = 1;}
}

?>
