<?php 

$header = 'Book Request # '.$_GET['id'];
include('header.php'); //Displays the logo and top navigation menu
include('connect_to_shady_grove.php'); // Creates a connection to the database

// Created by: Siddharth Choksi in May 2010
// This file displays the complete details of a particular Book Request. Not accessible without logging in. 

// Retrieve Book Request Details
$bid = $_GET['id'];
$query = "select *, DATE_FORMAT(b.b_req_date, '%m-%d-%Y') as req_date from b_request b , course c, professor p where b.c_id = c.c_id and b.p_email = p.p_email AND b.b_id = '$bid'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
if($num_rows == 1)
	{
	echo '<div align="center" style="font-size:large">Book Request # '.$bid.' ['.$row['req_date'].']</div> <br/>
		 <table border="1" cellpadding="5" cellspacing="3" style="border-collapse:collapse" width="70%" align="center">';

	echo '<tr bgcolor="#ffffcc">
	<td align="center" width = "30%"><strong>PROFESSOR INFORMATION</strong></td>	
	<td><strong>Name:</strong> '.$row['p_last_name'].' '. $row['p_first_name'].
	'<br/><strong>Email:</strong> '.$row['p_email'].
	'<br/><strong>Phone:</strong> '.$row['p_phone_number'].
	'<br/><strong>University:</strong> '.$row['p_university'].
	'</td></tr>';

	echo '<tr bgcolor="'.$bg.'">
	<td align="center"><strong>COURSE INFORMATION</strong></td>	
	<td><strong>Course:</strong> '.$row['course_no']. ', '.$row['course_title'].
	'<br/><strong>Semester:</strong> '.$row['semester'].' '. $row['semester_year'].
	'</td></tr>';

	echo '<tr bgcolor="#ffffcc">
	<td align="center"><strong>BOOK INFORMATION</strong></td><td>
	<strong>ISBN: </strong>'.$row['b_isbn'].
	'<br/><strong>Title:</strong> '.$row['b_title'].
	'<br/><strong>Author:</strong> '.$row['b_author'].
	'<br/><strong>Edition:</strong> '.$row['b_book_edition'].
	'<br/><strong>Publisher:</strong> '.$row['b_publisher'].
	'<br/><strong>Place of Publication:</strong> '.$row['b_place_of_pub'].
	'<br/><strong>Date of Publication:</strong> '.$row['b_date_of_pub'].
	'<br/><strong>Call Number:</strong> '.$row['b_call_number'].
	'</td></tr>';

	echo '<tr bgcolor="'.$bg.'">
	<td align="center"><strong>ADDITIONAL INFORMATION</strong></td>'.
	'<td><strong>Loan Period:</strong> '.$row['b_loan_period'].
	'<br/><strong>Supply Method:</strong> '.$row['b_supply_method'].
	'<br/><strong>Notes:</strong> '.$row['b_notes'].
	'</td></tr>';
	
	list($y,$m,$d) = split('-',$row['b_ordered_date']);
	$b_ordered_date = $m.'-'.$d.'-'.$y;
	list($y,$m,$d) = split('-',$row['b_recalled_date']);
	$b_recalled_date = $m.'-'.$d.'-'.$y;
	list($y,$m,$d) = split('-',$row['b_date_entered']);
	$b_date_entered = $m.'-'.$d.'-'.$y;
	list($y,$m,$d) = split('-',$row['b_date_deleted']);
	$b_date_deleted = $m.'-'.$d.'-'.$y;

	echo '<tr bgcolor="#ffffcc">
	<td align="center"><strong>LIBRARY INFORMATION</strong></td>	
	<td>
	<strong>Barcode: </strong>'.$row['b_barcode'].
	'<br/><strong>Order Date:</strong> '.$b_ordered_date.
	'<br/><strong>Recall Date:</strong> '.$b_recalled_date.
	'<br/><strong>Date Entered:</strong> '.$b_date_entered.
	'<br/><strong>Date Deleted:</strong> '.$b_date_deleted.
	'<br/><strong>Professor\'s Copy:</strong> '.$row['b_prof_copy'].
	'<br/><strong>Syllabi:</strong> '.$row['b_syllabi'].
	'<br/><strong>Comments:</strong> '.$row['b_comments'].
	'</td></tr>';

	echo '<tr><td colspan="2" align="center"><a href="edit_book_request.php?id='.$row['b_id'].'"><input type="button" value="Edit Request"></a><a href="delete_book_request.php?id='.$row['b_id'].'"><input type="button" value="Delete Request"></a></td></tr>';
	
	echo '</table>';
	echo "<br /><br />";

	}
include('footer.php'); 

?>
