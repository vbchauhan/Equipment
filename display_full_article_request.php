<?php 

$header = 'Article Request # '.$_GET['id'];
include('header.php'); //Displays the logo and top navigation menu
include('connect_to_shady_grove.php'); // Creates a connection to the database

// Created by: Siddharth Choksi in May 2010
// This file displays the complete details of a particular Article Request. Not accessible without logging in. 

// Retrieve Article Request Details
$aid = $_GET['id'];
$query = "select *, DATE_FORMAT(a.a_req_date, '%m-%d-%Y') as req_date from a_request a , course c, professor p where a.c_id = c.c_id and a.p_email = p.p_email AND a.a_id = '$aid'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
if($num_rows == 1)
	{
	echo '<div align="center" style="font-size:large">Article Request # '.$aid.' ['.$row['req_date'].']</div> <br/>
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
	<td align="center"><strong>ARTICLE INFORMATION</strong></td><td>
	<strong>ISSN: </strong>'.$row['a_issn'].
	'<br/><strong>Journal Title:</strong> '.$row['j_title'].
	'<br/><strong>Volume:</strong> '.$row['j_volume'].
	'<br/><strong>Issue:</strong> '.$row['j_issue'].
	'<br/><strong>Month:</strong> '.$row['j_month'].
	'<br/><strong>Year:</strong> '.$row['j_year'].
	'<br/><strong>Article Title:</strong> '.$row['a_title'].
	'<br/><strong>Author:</strong> '.$row['a_author'].
	'<br/><strong>Inclusive Pages:</strong> '.$row['a_incl_pages'].
	'</td></tr>';

	echo '<tr bgcolor="'.$bg.'">
	<td align="center"><strong>ADDITIONAL INFORMATION</strong></td>'.
	'<td><strong>Loan Period:</strong> '.$row['a_loan_period'].
	'<br/><strong>Supply Method:</strong> '.$row['a_supply_method'].
	'<br/><strong>Notes:</strong> '.$row['a_notes'].
	'</td></tr>';
	
	list($y,$m,$d) = split('-',$row['a_ordered_date']);
	$a_ordered_date = $m.'-'.$d.'-'.$y;
	list($y,$m,$d) = split('-',$row['a_recalled_date']);
	$a_recalled_date = $m.'-'.$d.'-'.$y;
	list($y,$m,$d) = split('-',$row['a_date_entered']);
	$a_date_entered = $m.'-'.$d.'-'.$y;
	list($y,$m,$d) = split('-',$row['a_date_deleted']);
	$a_date_deleted = $m.'-'.$d.'-'.$y;

	echo '<tr bgcolor="#ffffcc">
	<td align="center"><strong>LIBRARY INFORMATION</strong></td>	
	<td>
	<strong>Barcode: </strong>'.$row['a_barcode'].
	'<br/><strong>Order Date:</strong> '.$a_ordered_date.
	'<br/><strong>Recall Date:</strong> '.$a_recalled_date.
	'<br/><strong>Date Entered:</strong> '.$a_date_entered.
	'<br/><strong>Date Deleted:</strong> '.$a_date_deleted.
	'<br/><strong>Professor\'s Copy:</strong> '.$row['a_prof_copy'].
	'<br/><strong>Syllabi:</strong> '.$row['a_syllabi'].
	'<br/><strong>Comments:</strong> '.$row['a_comments'].
	'</td></tr>';

	echo '<tr><td colspan="2" align="center"><a href="edit_article_request.php?id='.$row['a_id'].'"><input type="button" value="Edit Request"></a><a href="delete_article_request.php?id='.$row['a_id'].'"><input type="button" value="Delete Request"></a></td></tr>';
	
	echo '</table>';
	echo "<br /><br />";

	}
include('footer.php'); 

?>
