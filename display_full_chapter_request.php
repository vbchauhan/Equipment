<?php 

$header = 'Chapter Request # '.$_GET['id'];
// Created by: Siddharth Choksi in May 2010
// This file displays the complete details of a particular Chapter Request. Not accessible without logging in. 

include('header.php'); //Displays the logo and top navigation menu
include('connect_to_shady_grove.php'); // Creates a connection to the database

// Retrieve Chapter Request Details
$bcid = $_GET['id'];
$query = "select *, DATE_FORMAT(bc.bc_req_date, '%m-%d-%Y') as req_date from c_request bc , course c, professor p where bc.c_id = c.c_id and bc.p_email = p.p_email AND bc.bc_id = '$bcid'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
if($num_rows == 1)
	{
	echo '<div align="center" style="font-size:large">Chapter Request # '.$bcid.' ['.$row['req_date'].']</div> <br/>
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
	<td align="center"><strong>ITEM INFORMATION</strong></td><td>
	<strong>ISBN: </strong>'.$row['bc_isbn'].
	'<br/><strong>Book Title:</strong> '.$row['bc_b_title'].
	'<br/><strong>Chapter Title:</strong> '.$row['bc_c_title'].
	'<br/><strong>Author:</strong> '.$row['bc_author'].
	'<br/><strong>Edition:</strong> '.$row['bc_edition'].
	'<br/><strong>Inclusive Pages:</strong> '.$row['bc_incl_pages'].
	'<br/><strong>Publisher:</strong> '.$row['bc_publisher'].
	'<br/><strong>Place of Publication:</strong> '.$row['bc_place_of_pub'].
	'<br/><strong>Date of Publication:</strong> '.$row['bc_date_of_pub'].
	'<br/><strong>Call Number:</strong> '.$row['bc_call_number'].
	'</td></tr>';

	echo '<tr bgcolor="'.$bg.'">
	<td align="center"><strong>ADDITIONAL INFORMATION</strong></td>'.
	'<td><strong>Loan Period:</strong> '.$row['bc_loan_period'].
	'<br/><strong>Supply Method:</strong> '.$row['bc_supply_method'].
	'<br/><strong>Notes:</strong> '.$row['bc_notes'].
	'</td></tr>';
	
	list($y,$m,$d) = split('-',$row['bc_ordered_date']);
	$bc_ordered_date = $m.'-'.$d.'-'.$y;
	list($y,$m,$d) = split('-',$row['bc_recalled_date']);
	$bc_recalled_date = $m.'-'.$d.'-'.$y;
	list($y,$m,$d) = split('-',$row['bc_date_entered']);
	$bc_date_entered = $m.'-'.$d.'-'.$y;
	list($y,$m,$d) = split('-',$row['bc_date_deleted']);
	$bc_date_deleted = $m.'-'.$d.'-'.$y;

	echo '<tr bgcolor="#ffffcc">
	<td align="center"><strong>LIBRARY INFORMATION</strong></td>	
	<td>
	<strong>Barcode: </strong>'.$row['bc_barcode'].
	'<br/><strong>Order Date:</strong> '.$bc_ordered_date.
	'<br/><strong>Recall Date:</strong> '.$bc_recalled_date.
	'<br/><strong>Date Entered:</strong> '.$bc_date_entered.
	'<br/><strong>Date Deleted:</strong> '.$bc_date_deleted.
	'<br/><strong>Professor\'s Copy:</strong> '.$row['bc_prof_copy'].
	'<br/><strong>Syllabi:</strong> '.$row['bc_syllabi'].
	'<br/><strong>Comments:</strong> '.$row['bc_comments'].
	'</td></tr>';

	echo '<tr><td colspan="2" align="center"><a href="edit_chapter_request.php?id='.$row['bc_id'].'"><input type="button" value="Edit Request"></a><a href="delete_chapter_request.php?id='.$row['bc_id'].'"><input type="button" value="Delete Request"></a></td></tr>';
	echo '</table>';
	echo "<br /><br />";

	}

include('footer.php'); 

?>
