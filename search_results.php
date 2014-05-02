<!-- 
Created by: Siddharth Choksi in May 2010
Code snippet for displaying search results. No accessible without login.
-->
<?php 
$header = "Search Results";
include('header.php'); 

if(isset($_GET['type'])) // Check if search criteria is mentioned
{
include('connect_to_shady_grove.php'); // Connects to the database
$type = trim($_GET['type']); 
$search = trim($_GET['search']);

// Creating acronyms for university names
function uni_conversion($x)
{
	switch ($x)	
	{
	case 'Bowie State University':
	$univ = 'Bowie';
	break;
	case 'Salisbury University':
	$univ = 'Salisbury';
	break;
	case 'Towson University':
	$univ = 'Towson';
	break;
	case 'University of Baltimore':
	$univ = 'U of Baltimore';
	break;
	case 'University of Maryland, Baltimore':
	$univ = 'UMB';
	break;
	case 'University of Maryland, Baltimore County':
	$univ = 'UMBC';
	break;
	case 'University of Maryland, College Park':
	$univ = 'UMCP';
	break;
	case 'University of Maryland, Eastern Shore':
	$univ = 'UMEC';
	break;
	case 'University of Maryland, University College':
	$univ = 'UMUC';
	break;
	case 'Other':
	$univ = 'Other';
	break;
	default: 
	$univ = '';
	}
	return $univ;
}

	if(isset($search)) // Check if search box contains some text 
	{
		switch($type)
		{

case 'a_id': // Search results for Article Request

$aid = mysqli_real_escape_string($dbc, trim($_GET['search']));
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
	<td><strong>Name:</strong> '.$row['p_last_name'].' '.$row['p_first_name'].
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
	else 
	{
	echo '<div align="center" style="font-size:normal">No Search Results found for <strong>Article Request # '.$aid.'</strong><br/><br/><a href= "display_article_requests.php">Go Back to Article Requests</a></div><br/><br/>';
	}

break;
	


case 'b_id': // Search results for Book Request

$bid = mysqli_real_escape_string($dbc, trim($_GET['search']));

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
	'<br/><strong>Edition:</strong> '.$row['b_edition'].
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
	else 
	{
	echo '<div align="center" style="font-size:normal">No Search Results found for <strong>Book Request # '.$bid.'</strong><br/><br/><a href= "display_book_requests.php">Go Back to Book Requests</a></div><br/><br/>';
	}
	break;
		


case 'c_id': // Search results for Chapter Request

$bcid = mysqli_real_escape_string($dbc, trim($_GET['search']));

$query = "select *, DATE_FORMAT(bc.bc_req_date, '%m-%d-%Y') as req_date from c_request bc , course c, professor p where bc.c_id = c.c_id and bc.p_email = p.p_email AND bc.bc_id = '$bcid'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
if($num_rows == 1)
	{
	echo '<div align="center" style="font-size:large">Chapter Request # '.$bcid.' ['.$row['req_date'].']</div> <br/>
		 <table border="1" cellpadding="5" cellspacing="3" style="border-collapse:collapse" width="70%" align="center">';


	echo '<tr bgcolor="#990000">
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
	else 
	{
	echo '<div align="center" style="font-size:normal">No Search Results found for <strong>Chapter Request # '.$bcid.'</strong><br/><br/><a href= "display_chapter_requests.php">Go Back to Chapter Requests</a></div><br/><br/>';
	}


break;

case 'a_barcode': // Search results for Article Barcode

$abarcode = mysqli_real_escape_string($dbc, trim($_GET['search']));
$query = "select *, DATE_FORMAT(a.a_req_date, '%m-%d-%Y') as req_date from a_request a , course c, professor p where a.c_id = c.c_id and a.p_email = p.p_email AND a.a_barcode = '$abarcode'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
if($num_rows == 1)
	{
	echo '<div align="center" style="font-size:large">Article Barcode # '.$abarcode.' ['.$row['req_date'].']</div> <br/>
		<div align="center" style="font-size:large">Article Request # ['.$row['a_id'].']</div> <br/> 
		 <table border="1" cellpadding="5" cellspacing="3" style="border-collapse:collapse" width="70%" align="center">';

	echo '<tr bgcolor="#ffffcc">
	<td align="center" width = "30%"><strong>PROFESSOR INFORMATION</strong></td>	
	<td><strong>Name:</strong> '.$row['p_last_name'].' '.$row['p_first_name'].
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
	else 
	{
	echo '<div align="center" style="font-size:normal">No Search Results found for <strong>Article Barcode # '.$abarcode.'</strong><br/><br/><a href= "display_article_requests.php">Go Back to Article Requests</a></div><br/><br/>';
	}

break;


case 'b_barcode': // Search results for Book Barcode

$bbarcode = mysqli_real_escape_string($dbc, trim($_GET['search']));

$query = "select *, DATE_FORMAT(b.b_req_date, '%m-%d-%Y') as req_date from b_request b , course c, professor p where b.c_id = c.c_id and b.p_email = p.p_email AND b.b_barcode = '$bbarcode'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
if($num_rows == 1)
	{
	echo '<div align="center" style="font-size:large">Book Barcode # '.$bbarcode.' ['.$row['req_date'].']</div> <br/>
		<div align="center" style="font-size:large">Book Request # ['.$row['b_id'].']</div> <br/>
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
	'<br/><strong>Edition:</strong> '.$row['b_edition'].
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
	else 
	{
	echo '<div align="center" style="font-size:normal">No Search Results found for <strong>Book Barcode # '.$bbarcode.'</strong><br/><br/><a href= "display_book_requests.php">Go Back to Book Requests</a></div><br/><br/>';
	}
	break;

case 'c_barcode': // Search results for Chapter Barcode

$bcbarcode = mysqli_real_escape_string($dbc, trim($_GET['search']));

$query = "select *, DATE_FORMAT(bc.bc_req_date, '%m-%d-%Y') as req_date from c_request bc , course c, professor p where bc.c_id = c.c_id and bc.p_email = p.p_email AND bc.bc_barcode = '$bcbarcode'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
if($num_rows == 1)
	{
	echo '<div align="center" style="font-size:large">Chapter Barcode # '.$bcbarcode.' ['.$row['req_date'].']</div> <br/>
		<div align="center" style="font-size:large">Chapter Request # ['.$row['bc_id'].']</div> <br/>
		 <table border="1" cellpadding="5" cellspacing="3" style="border-collapse:collapse" width="70%" align="center">';


	echo '<tr bgcolor="#990000">
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
	else 
	{
	echo '<div align="center" style="font-size:normal">No Search Results found for <strong>Chapter Barcode # '.$bcbarcode.'</strong><br/><br/><a href= "display_chapter_requests.php">Go Back to Chapter Requests</a></div><br/><br/>';
	}


break;


case 'p_email': // Search results for Professor Email

$query = "select b.b_id as id, p.p_university as uni, c.course_no as cno, concat(p.p_last_name, ' ', p.p_first_name) as prof, p.p_email as email, p.p_phone_number as pno, b.b_isbn as isbn, b.b_title as title, b.b_author as author, b.b_date_of_pub as pub_date, b.b_call_number as call_no, b.b_syllabi as syllabi, b.b_comments as comments, DATE_FORMAT(b.b_req_date, '%m-%d-%y') as req_date
from b_request b, professor p, course c  
where b.p_email = p.p_email AND b.c_id = c.c_id AND p.p_email LIKE '%$search%'";
$result = @mysqli_query($dbc, $query);
$bg = '#990000';

	echo '<div align="center" style="font-size:large">SEARCH RESULTS for '.$search.'</div> <br/>';

if(mysqli_num_rows($result) != '')	
	{ 
	 echo '<div align="center" style="font-size:normal"><strong>BOOK RESULTS</strong></div><br/>
	 <table border="1" cellpadding="1" cellspacing="0" style="border-collapse:collapse; font-size:11px" width="98%" align="center">
	 <tr align="center" bgcolor="#990000" style="color:#444444">
	 <th colspan = "3" width="2%">&nbsp;</th>';
	echo '<th width="7%">Req. Date</th>';
	echo '<th width="6%">Req #</th>';
	echo '<th width="5%">Univ.</th>';
	echo '<th width="5%">Course</th>';
	echo '<th width="10%">Professor</th>';
	echo '<th width="8%">Contact</th>';
	echo '<th width="7%">ISBN</th>';
	echo '<th width="19%">Title</th>';
	echo '<th width="10%">Author</th>';
	echo '<th width="6%">Pub Date</th>';
	echo '<th width="6%">Call #</th>';
	echo '<th width="1%">Syl</th>';
	echo '<th width="8%">Comments</th></tr>';
	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
	$bg = ($bg=='#ffffcc'?'#ffffff':'#ffffcc');

	$univ = uni_conversion($row['uni']); 
	
	echo '<tr bgcolor="'.$bg.'">
	<td align="center"><a href="display_full_book_request.php?id='.$row['id'].'"><img src="images/info-icon.png" alt="More Information" border="0" width="18" height="18" title="More Information" /></a></td>
    <td align="center"><a href="edit_book_request.php?id='.$row['id'].'"><img src="images/edit-icon.png" alt="Edit Entry" border="0" width="18" height="18" title="Edit Entry"  /></a></td>
    <td align="center"><a href="delete_book_request.php?id='.$row['id'].'"><img src="images/delete-icon.png" alt="Delete" border="0" width="18" height="18" title="Delete Entry"  /></a></td>

	<td align="center">'.$row['req_date'].'</td>
	<td align="center">'.$row['id'].'</td>
	<td align="center">'.$univ.'</td>
	<td align="center">'.$row['cno'].'</td>
	<td align="center">'.$row['prof'].'</td>
	<td align="center">'.$row['email'].' '.$row['pno'].'</td>
	<td align="center">'.$row['isbn'].'</td>
	<td align="left">'.$row['title'].'</td>		
	<td align="left">'.$row['author'].'</td>		
	<td align="center">'.$row['pub_date'].'</td>	
	<td align="center">'.$row['call_no'].'</td>	
	<td align="center">'.$row['syllabi'].'</td>
	<td align="left">'.$row['comments'].'</td></tr>';

	}
	echo '</table>';
	echo "<br /><br />";
	$results1 = 1;
}



$query = "select bc.bc_id as id, p.p_university as uni, c.course_no as cno, concat(p.p_last_name, ' ', p.p_first_name) as prof, p.p_email as email, p.p_phone_number as pno, bc.bc_isbn as isbn, bc.bc_b_title as b_title, bc.bc_author as author, bc.bc_c_title as c_title, bc.bc_date_of_pub as pub_date, bc.bc_incl_pages as incl_pages, bc.bc_call_number as call_no, bc.bc_syllabi as syllabi, bc.bc_comments as comments, DATE_FORMAT(bc.bc_req_date, '%m-%d-%y') as req_date
from c_request bc, professor p, course c  
where bc.p_email = p.p_email AND bc.c_id = c.c_id AND p.p_email = '$search'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffcc';

if(mysqli_num_rows($result) != '')
	{
	echo '<div align="center" style="font-size:normal"><strong>BOOK CHAPTER RESULTS</strong></div><br/>
	 <table border="1" cellpadding="1" cellspacing="0" style="border-collapse:collapse; font-size:11px" width="98%" align="center">
	 <tr align="center" bgcolor="#ffc240" style="color:#444444">
	 <th colspan = "3" width="2%">&nbsp;</th>';
	echo '<th width="7%">Req. Date</th>';
	echo '<th width="5%">Req #</th>';
	echo '<th width="5%">Univ.</th>';
	echo '<th width="4%">Course</th>';
	echo '<th width="9%">Professor</th>';
	echo '<th width="8%">Contact</th>';
	echo '<th width="6%">ISBN</th>';
	echo '<th width="15%">Book Title</th>';
	echo '<th width="10%">Chpt Title</th>';
	echo '<th width="7%">Author</th>';
	echo '<th width="6%">Pub Date</th>';
	echo '<th width="4%">Pgs</th>';
	echo '<th width="5%">Call #</th>';
	echo '<th width="1%">Syl</th>';
	echo '<th width="8%">Comments</th></tr>';
	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
	$bg = ($bg=='#ffffcc'?'#ffffff':'#ffffcc');

	$univ = uni_conversion($row['uni']); 

	echo '<tr bgcolor="'.$bg.'">
	<td align="center"><a href="display_full_chapter_request.php?id='.$row['id'].'"><img src="images/info-icon.png" alt="More Information" border="0" width="18" height="18" title="More Information" /></a></td>
    <td align="center"><a href="edit_chapter_request.php?id='.$row['id'].'"><img src="images/edit-icon.png" alt="Edit Entry" border="0" width="18" height="18" title="Edit Entry"  /></a></td>
    <td align="center"><a href="delete_chapter_request.php?id='.$row['id'].'"><img src="images/delete-icon.png" alt="Delete" border="0" width="18" height="18" title="Delete Entry"  /></a></td>

	<td align="center">'.$row['req_date'].'</td>
	<td align="center">'.$row['id'].'</td>
	<td align="center">'.$univ.'</td>
	<td align="center">'.$row['cno'].'</td>
	<td align="center">'.$row['prof'].'</td>
	<td align="center">'.$row['email'].' '.$row['pno'].'</td>
	<td align="center">'.$row['isbn'].'</td>
	<td align="left">'.$row['b_title'].'</td>		
	<td align="left">'.$row['c_title'].'</td>		
	<td align="left">'.$row['author'].'</td>		
	<td align="center">'.$row['pub_date'].'</td>	
	<td align="left">'.$row['incl_pages'].'</td>	
	<td align="center">'.$row['call_no'].'</td>	
	<td align="center">'.$row['syllabi'].'</td>
	<td align="left">'.$row['comments'].'</td></tr>';
	}

echo '</td></tr></table>';
echo "<br /><br />";
$results2 = 1;
}



$query = "select a.a_id as id, p.p_university as uni, c.course_no as cno, concat(p.p_last_name,' ' , p.p_first_name) as prof, p.p_email as email, p.p_phone_number as pno, a.a_issn as issn, a.j_title as j_title, a.a_title as a_title, a.a_author as author, a.j_volume as vol, a.j_issue as issue, a.j_month as month, a.j_year as year,  a.a_incl_pages as incl_pages, a.a_syllabi as syllabi, a.a_comments as comments, DATE_FORMAT(a.a_req_date, '%m-%d-%y') as req_date
from a_request a, professor p, course c  
where a.p_email = p.p_email AND a.c_id = c.c_id AND p.p_email = '$search'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffcc';

if(mysqli_num_rows($result) != '')
{

	echo '<div align="center" style="font-size:normal"><strong>ARTICLE RESULTS</strong></div><br/>
	 <table border="1" cellpadding="1" cellspacing="0" style="border-collapse:collapse; font-size:11px" width="98%" align="center">
	 <tr align="center" bgcolor="#ffc240" style="color:#444444">
	 <th colspan = "3" width="1%">&nbsp;</th>';
	echo '<th width="8%">Req. Date</th>';
	echo '<th width="5%">Req #</th>';
	echo '<th width="5%">Univ.</th>';
	echo '<th width="4%">Course</th>';
	echo '<th width="9%">Professor</th>';
	echo '<th width="8%">Contact</th>';
	echo '<th width="6%">ISSN</th>';
	echo '<th width="15%">Journal Title</th>';
	echo '<th width="10%">Article Title</th>';
	echo '<th width="7%">Author</th>';
	echo '<th width="3%">Vol.</th>';
	echo '<th width="3%">Issue</th>';
	echo '<th width="3%">Year</th>';
	echo '<th width="4%">Pgs</th>';	
	echo '<th width="1%">Syl</th>';
	echo '<th width="8%">Comments</th></tr>';
	
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
	$bg = ($bg=='#ffffcc'?'#ffffff':'#ffffcc');

	$univ = uni_conversion($row['uni']); 

	echo '<tr bgcolor="'.$bg.'">
	<td align="center"><a href="display_full_article_request.php?id='.$row['id'].'"><img src="images/info-icon.png" alt="More Information" border="0" width="18" height="18" title="More Information" /></a></td>
    <td align="center"><a href="edit_article_request.php?id='.$row['id'].'"><img src="images/edit-icon.png" alt="Edit Entry" border="0" width="18" height="18" title="Edit Entry"  /></a></td>
    <td align="center"><a href="delete_article_request.php?id='.$row['id'].'"><img src="images/delete-icon.png" alt="Delete" border="0" width="18" height="18" title="Delete Entry"  /></a></td>

	<td align="center">'.$row['req_date'].'</td>
	<td align="center">'.$row['id'].'</td>
	<td align="center">'.$univ.'</td>
	<td align="center">'.$row['cno'].'</td>
	<td align="center">'.$row['prof'].'</td>
	<td align="center" style = "font-size:11px">'.$row['email'].' '.$row['pno'].'</td>
	<td align="center">'.$row['issn'].'</td>
	<td align="left">'.$row['j_title'].'</td>		
	<td align="left">'.$row['a_title'].'</td>		
	<td align="left">'.$row['author'].'</td>		
	<td align="center">'.$row['vol'].'</td>	
	<td align="center">'.$row['issue'].'</td>	
	<td align="center">'.$row['month'].' '.$row['year'] .'</td>	
	<td align="left">'.$row['incl_pages'].'</td>	
	<td align="center">'.$row['syllabi'].'</td>
	<td align="left">'.$row['comments'].'</td></tr>';
	}

echo '</td></tr></table>';
echo "<br /><br />";
$results3 = 1;
}

if($results1 != '1' && $results2 != '1' && $results3 != '1')
echo '<div align="center" style="font-size:normal"><strong>No search results for '.$search.'</div>';

		break;
		}
	}
}
else
{
echo "<strong>This page was accessed in error.</strong>";
}

include('footer.php');

?>