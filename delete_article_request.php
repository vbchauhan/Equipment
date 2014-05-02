<?php 
$header = 'Delete Article Request # '.$_GET['id'];
include('header.php'); //Displays the logo and top navigation menu
include('connect_to_shady_grove.php'); // Creates a connection to the database

// Created by: Siddharth Choksi in May 2010
// This file provides the option to delete a particular article request permanently from the database. Not accessible without logging in. 

// Retrieve Article Request #
if(isset($_GET['id']) && is_numeric($_GET['id']))
{$aid = $_GET['id'];}

elseif(isset($_POST['id']) && is_numeric($_POST['id']))
{$aid = $_POST['id'];}

else
{
echo '<div align="center" style="font-size:normal">This page has been accessed in error<br/><br/><a href= "display_article_requests.php">Go Back to Article Requests</a></div><br/><br/>';
exit(0);
}

if(isset($_POST['submitted'])) // Perform these steps if form has been submitted
{
	if($_POST['sure'] == 'Yes')// Delete request if user confirmed 
	{
	$query = "DELETE from a_request WHERE a_id = '$aid' LIMIT 1";
	$result = @mysqli_query($dbc, $query);
	
		if(mysqli_affected_rows($dbc)==1) // Successful Deletion
		{
		echo '<div align="center" style="font-size:normal">Article Request # <strong>'.$aid.'</strong> has been successfully deleted from the database<br/><br/>
		<a href= "display_article_requests.php">Go Back to Article Requests</a></div>';		
		}
		else // Do nothing since user decided to cancel deletion
		{
		echo '<div align="center" style="font-size:normal">Article Request # <strong>'.$aid.'</strong> could not be deleted due to a system error: mysqli_error($dbc)<br/><br/>
		<a href= "display_article_requests.php">Go Back to Article Requests</a></div>';
		}
	}
	else // Display article details and ask for confirmation to delete 
	{
	echo '<div align="center" style="font-size:normal">Article Request # <strong>'.$aid.'</strong> has <strong>NOT</strong> been deleted<br/><br/>
		  <a href= "display_book_requests.php">Go Back to Book Requests</a></div>';
	}
}
else
{
$query = "select * from a_request a , course c, professor p where a.c_id = c.c_id and a.p_email = p.p_email AND a.a_id = '$aid'";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffff';
$num_rows = mysqli_num_rows($result);

	if($num_rows == 1)
	{
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 

	echo '<div align="center" style="font-size:normal"> Delete Article Request # <strong>'. $row['a_id'] .'</strong> </div> <br/>
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
	<strong>ISSN: </strong>'.$row['a_issn'].
	'<br/><strong>Journal Title:</strong> '.$row['j_title'].
	'<br/><strong>Volume:</strong> '.$row['j_volume'].
	'<br/><strong>Article Title:</strong> '.$row['a_title'].
	'<br/><strong>Author:</strong> '.$row['a_author'].
	'<br/><strong>Inclusive Pages:</strong> '.$row['a_incl_pages'].
	'</td></tr>';
	
	echo '</table>';
	echo "<br /><br />";

	echo '<div align="center" style="font-size:normal">	Are you sure you want to permanently delete Article Request # <b>'. $row['a_id'] .' </b>from the system? <br/>
	
	<form action="delete_article_request.php" method="post"> 
	<input type="radio" value="Yes" name="sure" />Yes &nbsp;<input type="radio" value="No" name="sure" />No
	<input type="submit" value="Submit" name="Submit" />
	<input type="hidden" name="submitted" value="TRUE" />
	<input type="hidden" name="id" value="'.$aid.'" />
	</form></div> ';
	}

	else
	{
echo '<div align="center" style="font-size:normal">This page has been accessed in error<br/><br/><a href= "display_article_requests.php">Go Back to Article Requests</a></div><br/><br/>';
	}
}



include('footer.php'); 

?>
