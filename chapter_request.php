<!-- 
Created by: Siddharth Choksi in May 2010
This file provides the main framework for the Chapter Request Form. The file includes other .php files which handle features such as form validation, query insertion, etc.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reserves Request Form</title>
<style type="text/css">
<!--
.style2 {
	color: #990000
}
.style1 {
	font-size: 9px;
}
-->
</style>
<script type="text/javascript"> <!-- This function resets the form fields -->
function resetform(){window.location = "chapter_request.php";}
</script>
</head>
<body bgcolor="#404039" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td align="center"><br /><img src="images/usglogo.png" alt="logo" /></td>
  </tr>
  <tr>
    <td>
      <h2 align="center" style="color:#990000; font-family:Georgia, 'Times New Roman', Times, serif">BOOK CHAPTER REQUEST FORM</h2>
    </td>
  </tr>
  <tr>
    <td align="center">
    <div style="text-align:left; width:97%"> <a href="index.php">Return to Main Menu</a><br /><br />
      <div style="text-align:left; width:97%"> Please read the <a href="instructions.php" target="_blank">Instructions</a> before filling out the Priddy Library Reserves Request Form.<br />
        <br />
      </div>
      <div style="text-align:left; width:97%"><b>PLEASE NOTE: Fields marked in <span class="style2">red</span> are mandatory</b></div>
      <br />
    </td>
  </tr>
  <?php
date_default_timezone_set('UTC');
$date = date('Y-m-d');

if(isset($_POST['submitted'])) // Perform these actions once the form is submitted
{
	echo '<tr><td><table width="97%" style="text-align:left; border-collapse:collapse" border="1" cellpadding="3" align = "center"  bgcolor="#edeada"><tr><td>';

include('connect_to_shady_grove.php'); // Database connection file
include('user_validation.php'); // Validates the Instruction Information Section
include('chapter_request_validation.php'); // Validates the Book Request Fields

// All conditions satisfied and no errors detected
if(empty($errors) && empty($errors1) && empty($errors2) && empty($errors3))
{
include('chapter_request_insertion1.php'); // Insert Professor and Chapter Request 1 information
if($request_2 == 1)
{include('chapter_request_insertion2.php');} // Insert Chapter Request 2 information
else{$request2 = 1;$course2 = 1;} 

if($request_3 == 1)
{include('chapter_request_insertion3.php');} // Insert Chapter Request 3 information 
else{$request3 = 1;$course3 = 1;} 

if($course1 == 1 && $course2 == 1 && $course3 == 1 && $professor == 1 && $request1 == 1 && $request2 == 1 && $request3 == 1) // If everything worked fine 
{echo '<div class="style3"><br>Thank You <strong>Professor '. $p_last_name.'</strong><br>The following action has been taken with your request(s):<br>
<ul>';
if($exists1 == 1) // If Chapter Request 1 already exists
{echo '<li><strong>'.$bc_b_title1.' - '. $bc_author1.' Chapter: '.$bc_c_title1.'</strong>. This request already exists in our database.</li>';}
else 
{echo '<li><strong>'.$bc_b_title1.' - '. $bc_author1.' Chapter: '.$bc_c_title1.'</strong>. This request has been successfully added to our database.</li>';}

if($request_2 == 1)
{
if($exists2 == 1) // If Chapter Request 2 already exists
{echo '<li><strong>'.$bc_b_title2.' - '. $bc_author2.' Chapter: '.$bc_c_title2.'</strong>. This request already exists in our database.</li>';}
else 
{echo '<li><strong>'.$bc_b_title2.' - '. $bc_author2.' Chapter: '.$bc_c_title2.'</strong>. This request has been successfully added to our database.</li>';}
}

if($request_3 == 1)
{
if($exists3 == 1) // If Chapter Request 3 already exists
{echo '<li><strong>'.$bc_b_title3.' - '. $bc_author3.' Chapter: '.$bc_c_title3.'</strong>. This request already exists in our database.</li>';}
else 
{echo '<li><strong>'.$bc_b_title3.' - '. $bc_author3.' Chapter: '.$bc_c_title3.'</strong>. This request has been successfully added to our database.</li>';}
}

echo '</ul>';



// Emailing Request Information to the Professor
$to = $p_email;
$subject = 'Priddy Reserves - Chapter Request Details';

$body = 'Dear Professor '.$p_last_name.',

Thank you for making a request via Priddy Reserves. Your Reserves Request Details are as follows:

CHAPTER REQUEST 1:

Request # : '.$bc_id1.'
Book Title : '.$bc_b_title1.'
Chapter Title : '.$bc_c_title1.'
Author : '.$bc_author1.'

';

if($request_2 == 1)
{
$body .= '
CHAPTER REQUEST 2:

Request # : '.$bc_id2.'
Book Title : '.$bc_b_title2.'
Chapter Title : '.$bc_c_title2.'
Author : '.$bc_author2.'

';
}

if($request_3 == 1)
{

$body .= '
CHAPTER REQUEST 3:

Request # : '.$bc_id3.'
Book Title : '.$bc_b_title3.'
Chapter Title : '.$bc_c_title3.'
Author : '.$bc_author3.'

';
}

$body .= '
Thank You, 
Priddy Reserves

NOTE: This is an auto-generated email. Please contact Madhu Singh at madhus@umd.edu for any further assistance. You might be requested to provide your Request # for faster processing of your queries.';

$from = 'From: Priddy Reserves';
mail($to, $subject, $body, $from);


// Emailing Request Information to Madhu
$to = 'madhus@umd.edu';
$subject = 'New Chapter Request';
$body = '
A new Chapter Request has been made by Professor '.$p_last_name.' [Email: '.$p_email.'] via the Priddy Reserves System. The request details are as follows: 

CHAPTER REQUEST 1:

Request # : '.$bc_id1.'
Book Title : '.$bc_b_title1.'
Chapter Title : '.$bc_c_title1.'
Author : '.$bc_author1.'
Inclusive Pages : '.$bc_incl_pages1.'
Publication Date : '.$bc_pub_date1.'

';

if($request_2 == 1)
{
$body .= '
CHAPTER REQUEST 2:

Request # : '.$bc_id2.'
Book Title : '.$bc_b_title2.'
Chapter Title : '.$bc_c_title2.'
Author : '.$bc_author2.'
Inclusive Pages : '.$bc_incl_pages2.'
Publication Date : '.$bc_pub_date2.'

';
}

if($request_3 == 1)
{

$body .= '
CHAPTER REQUEST 3:

Request # : '.$bc_id3.'
Book Title : '.$bc_b_title3.'
Chapter Title : '.$bc_c_title3.'
Author : '.$bc_author3.'
Inclusive Pages : '.$bc_incl_pages3.'
Publication Date : '.$bc_pub_date3.'

';
}
mail($to, $subject, $body, $from);


echo 'The Request Information has been emailed to <strong>'.$p_email.'<br/></strong>Please contact Madhu Singh at <a href="mailto:madhus@umd.edu">madhus@umd.edu</a> for any further assistance</div>'; 
}
 
// If some server error occured 
else 
{echo 'An internal error occured. We apologize for any inconvenience. Please try back at a later time or contact <a href="mailto:madhus@umd.edu">madhus@umd.edu</a> for further assistance';}
}	

// Errors detected 
else
{
echo "<p><strong>The following fields need to be corrected in your request</strong></p>";
	// Print errors related to Instruction Information 
	if(!empty($errors))
	{
	echo "<strong>Instruction Information</strong><ul>";
	foreach($errors as $msg)
	{echo "<li>$msg</li>"; }
	echo "</ul>";
	}

	// Print errors related to Request #1
	if(!empty($errors1))
	{
	echo "<strong>Chapter Request #1</strong><ul>";
	foreach($errors1 as $msg)
	{echo "<li>$msg</li>"; }
	echo "</ul>";
	}	
	
	// Print errors related to Request #2
	if(!empty($errors2))
	{
	echo "<strong>Chapter Request #2</strong><ul>";
	foreach($errors2 as $msg)
	{echo "<li>$msg</li>"; }
	echo "</ul>";
	}	

	// Print errors related to Request #3
	if(!empty($errors3))
	{
	echo "<strong>Chapter Request #3</strong><ul>";
	foreach($errors3 as $msg)
	{echo "<li>$msg</li>"; }
	echo "</ul>";
	}	

}

echo "</td></tr></table><br></td></tr>";
}

?>
  <tr>
    <td align="center" >
      <div style=" border:solid 1px; border-color:#646464; color:#111111; width:97%">
        <?php
include('search_catalog.php'); // Prints the Search Catalog code snippet
?>
        <hr size="1" />
        <form id="form1" name="form1" method="post" action="chapter_request.php">
          <input type="submit" value="Submit Form" name="submit" />
          &nbsp;&nbsp;&nbsp;
          <input type="button" value="Reset Form" onclick="resetform()" />
          <?php
include('user_details.php'); // Displays Instruction Information Fields
include('chapter_request1.php'); // Displays Book Information Fields
?>
          <input type="hidden" value="TRUE" name="submitted" />
          <input type="submit" value="Submit Form" name="submit" />
          &nbsp;&nbsp;&nbsp;
          <input type="button" value="Reset Form" onclick="resetform()" />
        </form>
      </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
