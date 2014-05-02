<?php 
$header = 'Edit Chapter Request # '.$_GET['id'];
include('header.php'); //Displays the logo and top navigation menu
include('connect_to_shady_grove.php'); // Creates a connection to the database

// Created by: Siddharth Choksi in May 2010
// This file provides the option to edit a particular chapter request in the database. Not accessible without logging in. 

if(isset($_GET['id']) && is_numeric($_GET['id']))
{$bcid = $_GET['id'];}
elseif($_POST['id'] && is_numeric($_POST['id']))
{$bcid = $_POST['id'];}
else
{
echo '<div align="center" style="font-size:normal"><strong>This page has been accessed in error</strong><br/><br/><a href= "display_chapter_requests.php">Go Back to Chapter Requests</a></div><br/><br/>';
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
$bc_loan_period = mysqli_real_escape_string($dbc,trim($_POST['bc_loan_period']));
$bc_isbn = mysqli_real_escape_string($dbc,trim($_POST['bc_isbn']));	
$bc_edition = mysqli_real_escape_string($dbc,trim($_POST['bc_edition']));
$bc_publisher = mysqli_real_escape_string($dbc,trim($_POST['bc_publisher']));
$bc_place_of_pub = mysqli_real_escape_string($dbc,trim($_POST['bc_place_of_pub']));
$bc_call_number = mysqli_real_escape_string($dbc,trim($_POST['bc_call_number']));
$bc_supply_method = mysqli_real_escape_string($dbc,trim($_POST['bc_supply_method']));
$bc_notes = mysqli_real_escape_string($dbc,trim($_POST['bc_notes']));
$bc_barcode = mysqli_real_escape_string($dbc,trim($_POST['bc_barcode']));
$bc_prof_copy = mysqli_real_escape_string($dbc,trim($_POST['bc_prof_copy']));
$bc_syllabi = mysqli_real_escape_string($dbc,trim($_POST['bc_syllabi']));
$bc_comments = mysqli_real_escape_string($dbc,trim($_POST['bc_comments']));


	// Course Number 
	$cn = mysqli_real_escape_string($dbc,trim($_POST['course_no']));
	if(empty($cn)) 
	{$errors[] = "Please enter the <b>Course Number</b>";}
	else
	{$course_no = $cn;}

	$bt = mysqli_real_escape_string($dbc,trim($_POST['bc_b_title']));
	// Book Title
	if(empty($bt)) 
	{$errors[] = "Please enter the <b>Book Title</b>";}
	else
	{$bc_b_title = $bt;}

	// Chapter Title
	$ct = mysqli_real_escape_string($dbc,trim($_POST['bc_c_title']));
	if(empty($ct)) 
	{$errors[] = "Please enter the <b>Chapter Title</b>";}
	else
	{$bc_c_title = $ct;}

	//Book Author
	$ba = mysqli_real_escape_string($dbc,trim($_POST['bc_author']));
	if(empty($ba)) 
	{$errors[] = "Please enter the <b>Book Author</b>";}
	else
	{$bc_author = $ba;}	
	
	// Book Publication Date
	$bpd = mysqli_real_escape_string($dbc,trim($_POST['bc_date_of_pub']));
	if(empty($bpd)) 
	{$errors[] = "Please enter the <b>Publication Date</b>";}
	else
	{$bc_date_of_pub = $bpd;}
		
	// Inclusive Pages
	$ip = mysqli_real_escape_string($dbc,trim($_POST['bc_incl_pages']));
	if(empty($ip)) 
	{$errors[] = "Please enter the <b>Inclusive Pages</b>";}
	else
	{$bc_incl_pages = $ip;}

	// Book Ordered Date
	$bod = mysqli_real_escape_string($dbc,trim($_POST['bc_ordered_date']));
	if(empty($bod)) 
	{$bc_ordered_date = "";}
	else
	{
		if((ereg('(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])-(19|20)[0-9]{2}',$bod)))
		{$bc_ordered_date = $bod;}
		elseif((ereg('00-00-0000',$bod)))
		{$bc_ordered_date = $bod;}
		else
		{$errors[] = "Please enter the <b>Ordered Date</b> in the specified format";}
	}

	// Book Recalled Date
	$brd = mysqli_real_escape_string($dbc,trim($_POST['bc_recalled_date']));
	if(empty($brd)) 
	{$bc_recalled_date = "";}
	else
	{
		if((ereg('(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])-(19|20)[0-9]{2}',$brd)))
		{$bc_recalled_date = $brd;}
		elseif((ereg('00-00-0000',$brd)))
		{$bc_recalled_date = $brd;}
		else
		{$errors[] = "Please enter the <b>Recalled Date</b> in the specified format";}
	}

	// Date Entered
	$bed = mysqli_real_escape_string($dbc,trim($_POST['bc_date_entered']));
	if(empty($bed)) 
	{$bc_date_entered = "";}
	else
	{
		if((ereg('(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])-(19|20)[0-9]{2}',$bed)))
		{$bc_date_entered = $bed;}
		elseif((ereg('00-00-0000',$bed)))
		{$bc_date_entered = $bed;}
		else
		{$errors[] = "Please enter the <b>Date Entered</b> in the specified format";}
	}
	
	// Date Deleted
	$bdd = mysqli_real_escape_string($dbc,trim($_POST['bc_date_deleted']));
	if(empty($bed)) 
	{$bc_date_deleted = "";}
	else
	{
		if((ereg('(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])-(19|20)[0-9]{2}',$bdd)))
		{$bc_date_deleted = $bdd;}
		elseif((ereg('00-00-0000',$bdd)))
		{$bc_date_deleted = $bdd;}
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
list($m,$d,$y) = split('-',$bc_ordered_date);
$bc_ordered_date = $y.'-'.$m.'-'.$d;
list($m,$d,$y) = split('-',$bc_recalled_date);
$bc_recalled_date = $y.'-'.$m.'-'.$d;
list($m,$d,$y) = split('-',$bc_date_entered);
$bc_date_entered = $y.'-'.$m.'-'.$d;
list($m,$d,$y) = split('-',$bc_date_deleted);
$bc_date_deleted = $y.'-'.$m.'-'.$d;

// Update the database entry
$query = "UPDATE c_request 
SET bc_b_title = '$bc_b_title', bc_c_title = '$bc_c_title', bc_author = '$bc_author', bc_isbn = '$bc_isbn', bc_edition = '$bc_edition', bc_publisher = '$bc_publisher', bc_place_of_pub = '$bc_place_of_pub', bc_date_of_pub = '$bc_date_of_pub', bc_incl_pages = '$bc_incl_pages', bc_call_number = '$bc_call_number', bc_loan_period = '$bc_loan_period', bc_notes = '$bc_notes', bc_supply_method = '$bc_supply_method', bc_barcode = '$bc_barcode', bc_ordered_date = '$bc_ordered_date', bc_recalled_date = '$bc_recalled_date', bc_date_entered = '$bc_date_entered', bc_date_deleted = '$bc_date_deleted', bc_prof_copy = '$bc_prof_copy', bc_syllabi = '$bc_syllabi', bc_comments = '$bc_comments', p_email = '$p_email', c_id = '$c_id'
WHERE bc_id = '$bcid' LIMIT 1";
$result = @mysqli_query($dbc, $query); 

		if(mysqli_affected_rows($dbc) == 1)
		{
		
		echo '<div align="center" style="font-size:normal"><strong>Chapter Request # '.$bcid.' was successfully edited</strong><br/><br/><a href= "display_chapter_requests.php">Go Back to Chapter Requests</a></div><br/><br/>';
		}
		else
		{
		echo '<div align="center" style="font-size:normal"><strong>No alterations were made to Chapter Request # '.$bcid.'</strong><br/><br/><a href= "display_chapter_requests.php">Go Back to Chapter Requests</a></div><br/><br/>';
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
$semester = array('Summer I', 'Summer II', 'Fall', 'Spring');
$semester_year = array('2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020');
$loan_period = array('2 hrs', '1 day');
$supply_method = array('Pull Off Shelf','Will Upload File','Will Bring to Library');
$yn = array('Yes','No');

// Display the form
$query = "
select *, DATE_FORMAT(bc.bc_req_date, '%m-%d-%Y') as req_date, DATE_FORMAT(bc.bc_ordered_date, '%m-%d-%Y') as order_date, DATE_FORMAT(bc.bc_recalled_date, '%m-%d-%Y') as recall_date, DATE_FORMAT(bc.bc_date_entered, '%m-%d-%Y') as date_entered, DATE_FORMAT(bc.bc_date_deleted, '%m-%d-%Y') as date_deleted 
from c_request bc , course c, professor p where bc.c_id = c.c_id and bc.p_email = p.p_email AND bc.bc_id = '$bcid'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
if($num_rows == 1)
	{
	echo '<div align="center" style="font-size:large">Chapter Request # '.$bcid.' ['.$row['req_date'].']</div> <br/>';

	echo '<div align = "center">';
	include('search_catalog.php');
	echo '</div>';

	echo '<form action="edit_chapter_request.php" method="POST">
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
 	if ($rows==$row['bc_loan_period'])
	{echo '<input type = "radio" value="'. $rows . '" checked="checked" name = "bc_loan_period">'. $rows . '&nbsp;';}	
	else
	{echo '<input type = "radio" value="'. $rows . '" name = "bc_loan_period">'. $rows . '&nbsp;';}
 }			
 
 	echo '</td></tr>
	<tr style="color:#FFFFFF" bgcolor="#990000"><td align="center" colspan = "4">ITEM INFORMATION</td></tr>	

	<tr bgcolor="#ffffdd"><td><strong><span class = "style2">Book Title</span></strong></td>
	<td><input type="text" name="bc_b_title" size = "40" value="'.$row['bc_b_title'].'" /></td>
	
	<td><strong><span class = "style2">Chapter Title</span></strong></td>
	<td><input type="text" name="bc_c_title" size = "40" value="'.$row['bc_c_title'].'" /></td></tr> 

	<tr><td><strong><span class = "style2">Author</span></strong></td>
	<td><input type="text" name="bc_author" size = "40" value="'.$row['bc_author'].'" /></td>

	<td><strong>ISBN</strong></td>
	<td><input type="text" name="bc_isbn" size = "40" value="'.$row['bc_isbn'].'" /></td></tr> 

	<tr bgcolor="#ffffdd"><td><strong>Edition</strong></td>
	<td><input type="text" name="bc_edition" size = "40" value="'.$row['bc_edition'].'" /></td> 

	<td><strong>Publisher</strong></td>
	<td><input type="text" name="bc_publisher" size = "40" value="'.$row['bc_publisher'].'" /></td></tr>

	<tr><td><strong>Place of Publication</strong></td>
	<td><input type="text" name="bc_place_of_pub" size = "40" value="'.$row['bc_place_of_pub'].'" /></td>

	<td><strong><span class = "style2">Publication Date</span></strong></td>
	<td><input type="text" name="bc_date_of_pub" size = "40" value="'.$row['bc_date_of_pub'].'" /></td></tr> 

	<tr bgcolor="#ffffdd"><td><strong><span class = "style2">Inclusive Pages<span</strong></td>
	<td><input type="text" name="bc_incl_pages" size = "40" value="'.$row['bc_incl_pages'].'" /></td>

	<td><strong>Call Number</strong></td>
	<td><input type="text" name="bc_call_number" size = "40" value="'.$row['bc_call_number'].'" /></td></tr> 

	<tr><td><strong>Supply Method</strong></td>
	<td><select name="bc_supply_method" size="1">';
 foreach($supply_method as $rows)
 {
 	if ($rows==$row['bc_supply_method'])
	{echo '<option value="'. $rows . '" selected="selected">'. $rows . '</option>';	}	
	else
	{echo '<option value="'. $rows . '">'. $rows . '</option>';}
 }		
 
 
    echo ' </select></td>

	
	</td>

	<td><strong>Professor\'s Notes</strong></td>
	<td><textarea name="bc_notes" cols="30" >'.$row['bc_notes'].'</textarea></td></tr> 

	<tr style="color:#FFFFFF" bgcolor="#990000"><td align="center" colspan = "4">OTHER INFORMATION</td></tr>	


	<tr bgcolor="#ffffdd"><td><strong>Barcode</strong></td>
	<td><input type="text" name="bc_barcode" size = "40" value="'.$row['bc_barcode'].'" /></td>

	<td><strong>Professor Copy</strong> ';
 	if ($row['bc_prof_copy'] == 'Y')
	{
	echo '<input type = "radio" value="Y" checked="checked" name="bc_prof_copy" />Yes';
	echo '<input type = "radio" value="N" name="bc_prof_copy" />No';
	}	
	elseif ($row['bc_prof_copy'] == 'N')
	{
	echo '<input type = "radio" value="Y" name="bc_prof_copy" /> Yes';
	echo '<input type = "radio" value="N" checked="checked" name="bc_prof_copy" />No';
	} 
	else
	{
	echo '<input type = "radio" value="Y" name="bc_prof_copy" /> Yes';
	echo '<input type = "radio" value="N" name="bc_prof_copy" />No';
	}	
	echo '</td>';

	echo '<td><strong>Syllabi Submitted&nbsp;</strong>';
 	if ($row['bc_syllabi'] == 'Y')
	{
	echo '<input type = "radio" value="Y" checked="checked" name="bc_syllabi" />Yes';
	echo '<input type = "radio" value="N" name="bc_syllabi" />No';
	}	
	elseif ($row['bc_syllabi'] == 'N')
	{
	echo '<input type = "radio" value="Y" name="bc_syllabi" /> Yes';
	echo '<input type = "radio" value="N" checked="checked" name="bc_syllabi" />No';
	} 
	else
	{
	echo '<input type = "radio" value="Y" name="bc_syllabi" /> Yes';
	echo '<input type = "radio" value="N" name="bc_syllabi" />No';
	}	
	echo '</td>';

	echo '
	<tr><td><strong>Ordered Date</strong><span class="style1"> (MM-DD-YYYY)</span></td>
	<td><input type="text" name="bc_ordered_date" size = "10" value="'.$row['order_date'].'" /></td>
	
	<td><strong>Recalled Date</strong><span class="style1"> (MM-DD-YYYY)</span></td>
	<td><input type="text" name="bc_recalled_date" size = "10" value="'.$row['recall_date'].'" /></td></tr> 

	<tr bgcolor="#ffffdd"><td><strong>Date Entered</strong><span class="style1"> (MM-DD-YYYY)</span></td>
	<td><input type="text" name="bc_date_entered" size = "10" value="'.$row['date_entered'].'" /></td>

	<td><strong>Date Deleted</strong><span class="style1"> (MM-DD-YYYY)</span></td>
	<td><input type="text" name="bc_date_deleted" size = "10" value="'.$row['date_deleted'].'" /></td></tr>

	<tr><td><strong>Additional Notes</strong></td>
	<td colspan="3"><textarea name="bc_comments" cols="50" >'.$row['bc_comments'].'</textarea></td></tr>'; 

echo '<br />';
echo '<input type="hidden" name="submitted" value="TRUE" />
<input type="hidden" name="id" value="'.$bcid.'" />
<tr><td align="center" style="font-size:normal" colspan ="4"><input type = "submit" value = "Edit Request" name="edit" /></td></tr>
</table></form>';
}

else 
{
echo '<div align="center" style="font-size:normal">This page has been accessed in error<br/><br/><a href= "display_chapter_requests.php">Go Back to Chapter Requests</a></div><br/><br/>';
}

include('footer.php'); 

?>
