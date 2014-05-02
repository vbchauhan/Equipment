<?php 
$header = 'Delete Book Request # '.$_GET['id'];
include('header.php'); //Displays the logo and top navigation menu
include('connect_to_shady_grove.php'); // Creates a connection to the database

// Created by: Siddharth Choksi in May 2010
// This file provides the option to delete a particular book request permanently from the database. Not accessible without logging in. 

// Retrieve Book Request #
if(isset($_GET['id']) && is_numeric($_GET['id']))
{ $bid = $_GET['id'];}

elseif(isset($_POST['id']) && is_numeric($_POST['id']))
{ $bid = $_POST['id'];}

else
{
echo '<div align="center" style="font-size:normal">This page has been accessed in error<br/><br/><a href= "display_book_requests.php">Go Back to Book Requests</a></div><br/><br/>';
exit(0);
}

if(isset($_POST['submitted'])) // Perform these steps if form has been submitted
{
	if($_POST['sure'] == 'Yes')// Delete request if user confirmed 
	{
	$query = "DELETE from b_request WHERE b_id = '$bid' LIMIT 1";
	$result = @mysqli_query($dbc, $query);
	
		if(mysqli_affected_rows($dbc)==1) // Successful Deletion
		{
		echo '<div align="center" style="font-size:normal">Book Request # <strong>'.$bid.'</strong> has been successfully deleted from the database<br/><br/>
		<a href= "display_book_requests.php">Go Back to Book Requests</a></div>';		}
		else
		{
		echo '<div align="center" style="font-size:normal">Book Request # <strong>'.$bid.'</strong> could not be deleted due to a system error: mysqli_error($dbc)<br/><br/>
		<a href= "display_book_requests.php">Go Back to Book Requests</a></div>';
		}
	}
	else // Do nothing since user decided to cancel deletion
	{
	echo '<div align="center" style="font-size:normal">Book Request # <strong>'.$bid.'</strong> has <strong>NOT</strong> been deleted<br/><br/>
		  <a href= "display_book_requests.php">Go Back to Book Requests</a></div>';
	}
}
else // Display book details and ask for confirmation to delete 
{
$query = "select * from b_request b , course c, professor p where b.c_id = c.c_id and b.p_email = p.p_email AND b.b_id = '$bid'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);

	if($num_rows == 1)
	{
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 

	echo '<div align="center" style="font-size:normal"> Delete Book Request # <strong>'. $row['b_id'] .'</strong> </div> <br/>
		 <table border="1" cellpadding="5" cellspacing="3" style="border-collapse:collapse" width="60%" align="center">';

	echo '<tr bgcolor="#ffffcc">
	<td><strong>Professor:</strong> '.$row['p_last_name'].' '. $row['p_first_name'].
	'</td></tr>';

	echo '<tr bgcolor="'.$bg.'">
	<td><strong>Course:</strong> '.$row['course_no']. ', '.$row['course_title'].
	'<br/><strong>Semester:</strong> '.$row['semester'].' '. $row['semester_year'].
	'</td></tr>';

	echo '<tr bgcolor="#ffffcc">
	<td>
	<strong>ISBN: </strong>'.$row['b_isbn'].
	'<br/><strong>Title:</strong> '.$row['b_title'].
	'<br/><strong>Author:</strong> '.$row['b_author'].
	'<br/><strong>Edition:</strong> '.$row['b_edition'].
	'</td></tr>';
	
	echo '</table>';
	echo "<br /><br />";

	echo '<div align="center" style="font-size:normal">	Are you sure you want to permanently delete Book Request # <strong>'. $row['b_id'] .'</strong> from the system? <br/><form action="delete_book_request.php" method="post"> 
	<input type="radio" value="Yes" name="sure" />Yes &nbsp;<input type="radio" value="No" name="sure" />No
	<input type="submit" value="Submit" name="Submit" />
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="id" value="'.$bid.'" />
	</form></div> ';
	}

	else 
	{
echo '<div align="center" style="font-size:normal">This page has been accessed in error<br/><br/><a href= "display_book_requests.php">Go Back to Book Requests</a></div><br/><br/>';
	}
}



include('footer.php'); 

?>
