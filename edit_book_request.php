<?php 
$header = 'Edit Book Request # '.$_GET['id'];
include('header.php'); //Displays the logo and top navigation menu
include('connect_to_shady_grove.php'); // Creates a connection to the database

// Created by: Siddharth Choksi in May 2010
// This file provides the option to edit a particular book request in the database. Not accessible without logging in. 

if(isset($_GET['id']) && is_numeric($_GET['id']))
{$bid = $_GET['id'];}
elseif($_POST['id'] && is_numeric($_POST['id']))
{$bid = $_POST['id'];}
else
{
echo '<div align="center" style="font-size:normal"><strong>This page has been accessed in error</strong><br/><br/><a href= "display_book_requests.php">Go Back to Book Requests</a></div><br/><br/>';
exit(0);
}
// Check if changes have been submitted and validate each field
if(isset($_POST['submitted']))
{
$errors = array();
	
	// Last Name Check	
	$ln = mysqli_real_escape_string($dbc,trim($_POST['p_last_name']));
	if(empty($ln)) 
	{$errors[] = "Please enter the <b>Last Name</b>";}
	else
	{$p_last_name = $ln;}

	// First Name Check
	$fn = mysqli_real_escape_string($dbc,trim($_POST['p_first_name']));
	if(empty($fn)) 
	{$errors[] = "Please enter the <b>First Name</b>";}
	else
	{$p_first_name = $fn;}

	// Email Check
	$email = mysqli_real_escape_string($dbc,trim($_POST['p_email']));
	if(empty($email)) 
	{$errors[] = "Please enter the <b>Email Address</b>";}
	else
	{
	if(ereg('[0-9a-zA-Z]([\-\.\_0-9a-zA-Z])*[0-9a-zA-Z]\@([0-9a-zA-Z][0-9a-zA-Z\-\_]*\.)+[a-zA-Z]{2,}', $email))
	{$p_email = $email;}
	else
	{$errors[] = "Please enter a valid <strong>Email Address</strong>";}
	}

	// Phone Check
	$p_no = mysqli_real_escape_string($dbc,trim($_POST['p_phone_number']));
	if(empty($p_no)) 
	{$p_phone_number = "";}
	else
	{
	if(strlen($p_no) == 10 && (ereg('^[0-9]{10}$',$p_no)))
	{$p_phone_number = $p_no;}
	elseif(strlen($p_no) == 12 && (ereg('^[0-9]{3}-[0-9]{3}-[0-9]{4}$',$p_no)))
	{$p_phone_number = str_replace('-','',$p_no);}
	else
	{$errors[] = "Please enter the <b>Phone Number</b> in the specified format";}
	}
	
	$p_university = mysqli_real_escape_string($dbc,trim($_POST['p_university']));

$semester = mysqli_real_escape_string($dbc,$_POST['semester']);
$semester_year = mysqli_real_escape_string($dbc,$_POST['semester_year']);
$course_title = mysqli_real_escape_string($dbc,trim($_POST['course_title']));
$b_loan_period = mysqli_real_escape_string($dbc,trim($_POST['b_loan_period']));
$b_isbn = mysqli_real_escape_string($dbc,trim($_POST['b_isbn']));	
$b_book_edition = mysqli_real_escape_string($dbc,trim($_POST['b_book_edition']));
$b_publisher = mysqli_real_escape_string($dbc,trim($_POST['b_publisher']));
$b_place_of_pub = mysqli_real_escape_string($dbc,trim($_POST['b_place_of_pub']));
$b_call_number = mysqli_real_escape_string($dbc,trim($_POST['b_call_number']));
$b_supply_method = mysqli_real_escape_string($dbc,trim($_POST['b_supply_method']));
$b_notes = mysqli_real_escape_string($dbc,trim($_POST['b_notes']));
$b_barcode = mysqli_real_escape_string($dbc,trim($_POST['b_barcode']));
$b_prof_copy = mysqli_real_escape_string($dbc,trim($_POST['b_prof_copy']));
$b_syllabi = mysqli_real_escape_string($dbc,trim($_POST['b_syllabi']));
$b_comments = mysqli_real_escape_string($dbc,trim($_POST['b_comments']));


	// Course Number 
	$cn = mysqli_real_escape_string($dbc,trim($_POST['course_no']));
	if(empty($cn)) 
	{$errors[] = "Please enter the <b>Course Number</b>";}
	else
	{$course_no = $cn;}

	// Book Title
	$bt = mysqli_real_escape_string($dbc,trim($_POST['b_title']));
	if(empty($bt)) 
	{$errors[] = "Please enter the <b>Book Title</b>";}
	else
	{$b_title = $bt;}

	//Book Author
	$ba = mysqli_real_escape_string($dbc,trim($_POST['b_author']));
	if(empty($ba)) 
	{$errors[] = "Please enter the <b>Book Author</b>";}
	else
	{$b_author = $ba;}	
	
	// Book Publication Date
	$bpd = mysqli_real_escape_string($dbc,trim($_POST['b_date_of_pub']));
	if(empty($bpd)) 
	{$errors[] = "Please enter the <b>Publication Date</b>";}
	else
	{$b_date_of_pub = $bpd;}
		
	// Book Ordered Date
	$bod = mysqli_real_escape_string($dbc,trim($_POST['b_ordered_date']));
	if(empty($bod)) 
	{$b_ordered_date = "";}
	else
	{
		if((ereg('(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])-(19|20)[0-9]{2}',$bod)))
		{$b_ordered_date = $bod;}
		elseif((ereg('00-00-0000',$bod)))
		{$b_ordered_date = $bod;}
		else
		{$errors[] = "Please enter the <b>Ordered Date</b> in the specified format".$bod;}
	}

	// Book Recalled Date
	$brd = mysqli_real_escape_string($dbc,trim($_POST['b_recalled_date']));
	if(empty($brd)) 
	{$b_recalled_date = "";}
	else
	{
		if((ereg('(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])-(19|20)[0-9]{2}',$brd)))
		{$b_recalled_date = $brd;}
		elseif((ereg('00-00-0000',$brd)))
		{$b_recalled_date = $brd;}
		else
		{$errors[] = "Please enter the <b>Recalled Date</b> in the specified format";}
	}

	// Date Entered
	$bed = mysqli_real_escape_string($dbc,trim($_POST['b_date_entered']));
	if(empty($bed)) 
	{$b_date_entered = "";}
	else
	{
		if((ereg('(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])-(19|20)[0-9]{2}',$bed)))
		{$b_date_entered = $bed;}
		elseif((ereg('00-00-0000',$bed)))
		{$b_date_entered = $bed;}
		else
		{$errors[] = "Please enter the <b>Date Entered</b> in the specified format";}
	}
	
	// Date Deleted
	$bdd = mysqli_real_escape_string($dbc,trim($_POST['b_date_deleted']));
	if(empty($bed)) 
	{$b_date_deleted = "";}
	else
	{
		if((ereg('(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])-(19|20)[0-9]{2}',$bdd)))
		{$b_date_deleted = $bdd;}
		elseif((ereg('00-00-0000',$bdd)))
		{$b_date_deleted = $bdd;}
		else
		{$errors[] = "Please enter the <b>Date Deleted</b> in the specified format";}
	}

	if(empty($errors))
	{

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
$query = "SELECT course_no, semester, semester_year FROM course WHERE course_no = '$course_no' AND semester = '$semester' AND  semester_year = '$semester_year'";
$result = @mysqli_query($dbc, $query);
$num = @mysqli_num_rows($result);

if($num != 1)  // New Course Record
{

$query = "INSERT into course(course_no, course_title, semester, semester_year) VALUES('$course_no', '$course_title', '$semester', '$semester_year')";
$result = @mysqli_query($dbc, $query);
	if(mysqli_affected_rows($dbc) == 1) // Record insertion successful
	{$course1= 1;}
}
else
{
$query = "UPDATE course SET course_title= '$course_title' WHERE course_no = '$course_no' AND semester = '$semester' AND  semester_year = '$semester_year' LIMIT 1";
$result = @mysqli_query($dbc, $query);
$course1 =1;
}

// Retrieve Course Id
$query = "SELECT c_id FROM course WHERE course_no = '$course_no' AND semester = '$semester' AND  semester_year = '$semester_year'";
$result = @mysqli_query($dbc, $query);
$row  = @mysqli_fetch_array($result, MYSQLI_NUM);
$c_id = $row[0];

// Formatting dates in YYYY-MM-DD format
list($m,$d,$y) = split('-',$b_ordered_date);
$b_ordered_date = $y.'-'.$m.'-'.$d;

list($m,$d,$y) = split('-',$b_recalled_date);
$b_recalled_date = $y.'-'.$m.'-'.$d;

list($m,$d,$y) = split('-',$b_date_entered);
$b_date_entered = $y.'-'.$m.'-'.$d;

list($m,$d,$y) = split('-',$b_date_deleted);
$b_date_deleted = $y.'-'.$m.'-'.$d;

// Update the database entry
$query = "UPDATE b_request 
SET b_title = '$b_title', b_author = '$b_author', b_isbn = '$b_isbn', b_book_edition = '$b_book_edition', b_publisher = '$b_publisher', b_place_of_pub = '$b_place_of_pub', b_date_of_pub = '$b_date_of_pub', b_call_number = '$b_call_number', b_loan_period = '$b_loan_period', b_notes = '$b_notes', b_supply_method = '$b_supply_method', b_barcode = '$b_barcode', b_ordered_date = '$b_ordered_date', b_recalled_date = '$b_recalled_date', b_date_entered = '$b_date_entered', b_date_deleted = '$b_date_deleted', b_prof_copy = '$b_prof_copy', b_syllabi = '$b_syllabi', b_comments = '$b_comments', p_email = '$p_email', c_id = '$c_id'
WHERE b_id = '$bid' LIMIT 1";
$result = @mysqli_query($dbc, $query); 

		if(mysqli_affected_rows($dbc) == 1)
		{
		
		echo '<div align="center" style="font-size:normal"><strong>Book Request # '.$bid.' was successfully edited</strong><br/><br/><a href= "display_book_requests.php">Go Back to Book Requests</a></div><br/><br/>';
		}
		else
		{
		echo '<div align="center" style="font-size:normal"><strong>No alterations were made to Book Request # '.$bid.'</strong><br/><br/><a href= "display_book_requests.php">Go Back to Book Requests</a></div><br/><br/>';
		}
	} 
	else 
	{
	echo '	<table width="80%" style="text-align:left; border-collapse:collapse" border="1" cellpadding="3" align = "center"  bgcolor="#edeada"><tr><td>
	The following errors occured<ul>';

	foreach($errors as $msg)
	{
	echo "<li>$msg</li>";
	}
	echo '</ul></td></tr></table>';
	}
}


// Creating arrays to display drop down menus
$universities = array('Bowie State University', 'Salisbury University', 'Towson University', 'University of Baltimore', 'University of Maryland, Baltimore', 'University of Maryland, Baltimore County', 'University of Maryland, College Park',  'University of Maryland Eastern Shore', 'University of Maryland University College', 'Other');
$semester = array('Summer I', 'Summer II', 'Fall', 'Winter','Spring');
$semester_year = array('2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020');
$loan_period = array('2 hrs', '1 day');
$supply_method = array('Pull Off Shelf','Will Bring to Library','Purchase Item');
$yn = array('Yes','No');

// Display the form
$query = "
select *, DATE_FORMAT(b.b_req_date, '%m-%d-%Y') as req_date, DATE_FORMAT(b.b_ordered_date, '%m-%d-%Y') as order_date, DATE_FORMAT(b.b_recalled_date, '%m-%d-%Y') as recall_date, DATE_FORMAT(b.b_date_entered, '%m-%d-%Y') as date_entered, DATE_FORMAT(b.b_date_deleted, '%m-%d-%Y') as date_deleted 
from b_request b , course c, professor p where b.c_id = c.c_id and b.p_email = p.p_email AND b.b_id = '$bid'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
if($num_rows == 1)
	{
	echo '<div align="center" style="font-size:large">Book Request # '.$bid.' ['.$row['req_date'].']</div> <br/>';

	echo '<div align = "center">';
	include('search_catalog.php');
	echo '</div>';

	echo '<form action="edit_book_request.php" method="POST">
	<table width = "80%" align="center" border="0" cellpadding = "3" style = "border-collapse:collapse; border:solid 1px" >';

	echo '<tr style="color:#FFFFFF" bgcolor="#990000"><td align="center" colspan = "4">PROFESSOR INFORMATION</td></tr>	
	
	<tr><td width = "25%" ><strong><span class = "style2">Last Name</span></strong></td>
	<td><input type="text" name="p_last_name" size = "40" value="'.$row['p_last_name'].'" /></td>
	
	<td width = "25%" ><strong><span class = "style2">First Name</span></strong></td>
	<td><input type="text" name="p_first_name" size = "40" value="'.$row['p_first_name'].'" /></td></tr> 

	<tr bgcolor="#ffffdd"><td><strong><span class = "style2">Email</span></strong></td>
	<td><input type="text" name="p_email" size = "40" value="'.$row['p_email'].'" /></td>

	<td><strong>Phone Number</strong><br/><span class = "style1">(XXX-XXX-XXXX, XXXXXXXXXX)</td>
	<td><input type="text" name="p_phone_number" size = "40" value="'.$row['p_phone_number'].'" /></td></tr> 

	<tr><td><strong><span class = "style2">University</span></strong></td>
	<td colspan = "3"><select name="p_university">';
 foreach($universities as $rows)
 {
 	if ($rows==$row['p_university'])
	{echo '<option value="'. $rows . '" selected="selected">'. $rows . '</option>';}	
	else
	{echo '<option value="'. $rows . '">'. $rows . '</option>';}
  }		
	echo '</select></td></tr>'; 


	echo '<tr style="color:#FFFFFF" bgcolor="#990000"><td align="center" colspan = "4">COURSE INFORMATION</td></tr>	
	
	<tr bgcolor="#ffffdd"><td width = "20%" ><strong><span class = "style2">Semester</span></strong></td>
	<td><select name="semester" size="1">';

 foreach($semester as $rows)
 {
 	if ($rows==$row['semester'])
	{echo '<option value="'. $rows . '" selected="selected">'. $rows . '</option>';}	
	else
	{echo '<option value="'. $rows . '">'. $rows . '</option>';}
  }		

    echo '  </select><select name="semester_year" size="1">';
 foreach($semester_year as $rows)
 {
 	if ($rows==$row['semester_year'])
	{echo '<option value="'. $rows . '" selected="selected">'. $rows . '</option>';	}	
	else
	{echo '<option value="'. $rows . '">'. $rows . '</option>';}
 }			
    echo ' </select></td>
	
	<td><strong>Course Title</strong></td>
	<td><input type="text" name="course_title" size = "40" value="'.$row['course_title'].'" /></td></tr> 

	<tr><td><strong><span class = "style2">Course Number</span></strong></td>
	<td><input type="text" name="course_no" size = "40" value="'.$row['course_no'].'" /></td>
	
	<td><strong>Loan Period</strong></td>
	<td>';

 foreach($loan_period as $rows)
 {
 	if ($rows==$row['b_loan_period'])
	{echo '<input type = "radio" value="'. $rows . '" checked="checked" name = "b_loan_period">'. $rows . '&nbsp;';}	
	else
	{echo '<input type = "radio" value="'. $rows . '" name = "b_loan_period">'. $rows . '&nbsp;';}
 }			
 
 	echo '</td></tr>
	<tr style="color:#FFFFFF" bgcolor="#990000"><td align="center" colspan = "4">BOOK INFORMATION</td></tr>	

	<tr bgcolor="#ffffdd"><td><strong><span class = "style2">Title</span></strong></td>
	<td><input type="text" name="b_title" size = "40" value="'.$row['b_title'].'" /></td>
	
	<td><strong><span class = "style2">Author</span></strong></td>
	<td><input type="text" name="b_author" size = "40" value="'.$row['b_author'].'" /></td></tr> 

	<tr><td><strong>ISBN</strong></td>
	<td><input type="text" name="b_isbn" size = "40" value="'.$row['b_isbn'].'" /></td>

	<td><strong>Edition</strong></td>
	<td><input type="text" name="b_book_edition" size = "40" value="'.$row['b_book_edition'].'" /></td></tr> 

	<tr bgcolor="#ffffdd"><td><strong>Publisher</strong></td>
	<td><input type="text" name="b_publisher" size = "40" value="'.$row['b_publisher'].'" /></td>

	<td><strong>Place of Publication</strong></td>
	<td><input type="text" name="b_place_of_pub" size = "40" value="'.$row['b_place_of_pub'].'" /></td></tr> 

	<tr><td><strong><span class = "style2">Publication Date</span></strong></td>
	<td><input type="text" name="b_date_of_pub" size = "40" value="'.$row['b_date_of_pub'].'" /></td>

	<td><strong>Call Number</strong></td>
	<td><input type="text" name="b_call_number" size = "40" value="'.$row['b_call_number'].'" /></td></tr> 

	<tr bgcolor="#ffffdd"><td><strong>Supply Method</strong></td>
	<td><select name="b_supply_method" size="1">';
 foreach($supply_method as $rows)
 {
 	if ($rows==$row['b_supply_method'])
	{echo '<option value="'. $rows . '" selected="selected">'. $rows . '</option>';	}	
	else
	{echo '<option value="'. $rows . '">'. $rows . '</option>';}
 }		
 
 
    echo ' </select></td>

	
	</td>

	<td><strong>Professor\'s Notes</strong></td>
	<td><textarea name="b_notes" cols="30" >'.$row['b_notes'].'</textarea></td></tr> 

	<tr style="color:#FFFFFF" bgcolor="#990000"><td align="center" colspan = "4">OTHER INFORMATION</td></tr>	


	<tr><td><strong>Barcode</strong></td>
	<td><input type="text" name="b_barcode" size = "40" value="'.$row['b_barcode'].'" /></td>

	<td><strong>Professor Copy</strong> ';
 	if ($row['b_prof_copy'] == 'Y')
	{
	echo '<input type = "radio" value="Y" checked="checked" name="b_prof_copy" />Yes';
	echo '<input type = "radio" value="N" name="b_prof_copy" />No';
	}	
	elseif ($row['b_prof_copy'] == 'N')
	{
	echo '<input type = "radio" value="Y" name="b_prof_copy" /> Yes';
	echo '<input type = "radio" value="N" checked="checked" name="b_prof_copy" />No';
	} 
	else
	{
	echo '<input type = "radio" value="Y" name="b_prof_copy" /> Yes';
	echo '<input type = "radio" value="N" name="b_prof_copy" />No';
	}	
	echo '</td>';

	echo '<td><strong>Syllabi Submitted&nbsp;</strong>';
 	if ($row['b_syllabi'] == 'Y')
	{
	echo '<input type = "radio" value="Y" checked="checked" name="b_syllabi" />Yes';
	echo '<input type = "radio" value="N" name="b_syllabi" />No';
	}	
	elseif ($row['b_syllabi'] == 'N')
	{
	echo '<input type = "radio" value="Y" name="b_syllabi" /> Yes';
	echo '<input type = "radio" value="N" checked="checked" name="b_syllabi" />No';
	} 
	else
	{
	echo '<input type = "radio" value="Y" name="b_syllabi" /> Yes';
	echo '<input type = "radio" value="N" name="b_syllabi" />No';
	}	
	echo '</td>';

	echo '
	<tr bgcolor="#ffffdd"><td><strong>Ordered Date</strong><span class="style1"> (MM-DD-YYYY)</span></td>
	<td><input type="text" name="b_ordered_date" size = "10" value="'.$row['order_date'].'" /></td>
	
	<td><strong>Recalled Date</strong><span class="style1"> (MM-DD-YYYY)</span></td>
	<td><input type="text" name="b_recalled_date" size = "10" value="'.$row['recall_date'].'" /></td></tr> 

	<tr><td><strong>Date Entered</strong><span class="style1"> (MM-DD-YYYY)</span></td>
	<td><input type="text" name="b_date_entered" size = "10" value="'.$row['date_entered'].'" /></td>

	<td><strong>Date Deleted</strong><span class="style1"> (MM-DD-YYYY)</span></td>
	<td><input type="text" name="b_date_deleted" size = "10" value="'.$row['date_deleted'].'" /></td></tr>

	<tr bgcolor="#ffffdd"><td><strong>Additional Notes</strong></td>
	<td colspan="3"><textarea name="b_comments" cols="50" >'.$row['b_comments'].'</textarea></td></tr>'; 

echo '<br />';
echo '<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="'.$bid.'" />
<tr><td align="center" style="font-size:normal" colspan ="4"><input type = "submit" value = "Edit Request" name="edit" /><a href="display_full_book_request.php?id='.$row['b_id'].'"><input type="button" value="View Information"></a></td></tr>
</table></form>';
}

else 
{
echo '<div align="center" style="font-size:normal">This page has been accessed in error<br/><br/><a href= "display_book_requests.php">Go Back to Book Requests</a></div><br/><br/>';
}

include('footer.php'); 

?>
