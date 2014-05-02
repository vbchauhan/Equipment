<?php 
 
$header = "Chapter Requests";
include('header.php'); //Displays the logo and top navigation menu
include('connect_to_shady_grove.php'); // Creates a connection to the database

//Created by: Siddharth Choksi in May 2010
// This file displays all Chapter Requests existing in the database. Not accessible without logging in. 

$display = 20; // Number of entries per page

// Calculate the number of pages for displaying the results 
if(isset($_GET['p']) && is_numeric($_GET['p'])) 
{$pages = $_GET['p'];}

else
{
$query = 'select COUNT(bc_id) FROM c_request';
$result = @mysqli_query($dbc, $query);
$row = @mysqli_fetch_array($result, MYSQLI_NUM);
$records = $row[0];

	if($records>$display)
	{	$pages = ceil($records/$display);	}
	else
	{	$pages = 1;	}
}
// Defines what page we are on currently
if(isset($_GET['s']) && is_numeric($_GET['s']))
{$start = $_GET['s'];}
else
{$start = 0;}

$sort = (isset($_GET['sort']))? $_GET['sort']: 'req_date_d';
// Switch case to decide the sorting criteria to be implemented while displaying the results 
switch($sort)
{
case 'bc_id_a':
$order_by = 'bc.bc_id ASC';
break;

case 'bc_id_d':
$order_by = 'bc.bc_id DESC';
break;

case 'req_date_a':
$order_by = 'bc.bc_req_date ASC';
break;

case 'req_date_d':
$order_by = 'bc.bc_req_date DESC';
break;

case 'uni_a':
$order_by = 'p.p_university ASC';
break;

case 'uni_d':
$order_by = 'p.p_university DESC';
break;

case 'sem_a':
$order_by = 'c.semester_year ASC';
break;

case 'sem_d':
$order_by = 'c.semester_year DESC';
break;

case 'cno_a':
$order_by = 'c.course_no ASC';
break;

case 'cno_d':
$order_by = 'c.course_no DESC';
break;

case 'prof_a':
$order_by = 'p.p_last_name ASC';
break;

case 'prof_d':
$order_by = 'p.p_last_name DESC';
break;

case 'email_a':
$order_by = 'p.p_email ASC';
break;

case 'email_d':
$order_by = 'p.p_email DESC';
break;

case 'isbn_a':
$order_by = 'bc.bc_isbn ASC';
break;

case 'isbn_d':
$order_by = 'bc.bc_isbn DESC';
break;

case 'b_title_a':
$order_by = 'bc.bc_b_title ASC';
break;

case 'b_title_d':
$order_by = 'bc.bc_b_title DESC';
break;

case 'c_title_a':
$order_by = 'bc.bc_c_title ASC';
break;

case 'c_title_d':
$order_by = 'bc.bc_c_title DESC';
break;

case 'author_a':
$order_by = 'bc.bc_author ASC';
break;

case 'author_d':
$order_by = 'bc.bc_author DESC';
break;

case 'pub_date_a':
$order_by = 'bc.bc_date_of_pub ASC';
break;

case 'pub_date_d':
$order_by = 'bc.bc_date_of_pub DESC';
break;

case 'incl_pages_a':
$order_by = 'bc.bc_incl_pages ASC';
break;

case 'incl_pages_d':
$order_by = 'bc.bc_incl_pages DESC';
break;

case 'call_no_a':
$order_by = 'bc.bc_call_number ASC';
break;

case 'call_no_d':
$order_by = 'bc.bc_call_number DESC';
break;

case 'syllabi_a':
$order_by = 'bc.bc_syllabi ASC';
break;

case 'syllabi_d':
$order_by = 'bc.bc_syllabi DESC';
break;

case 'comments_a':
$order_by = 'bc.bc_comments ASC';
break;

case 'comments_d':
$order_by = 'bc.bc_comments DESC';
break;

default:
$order_by = 'bc.bc_req_date DESC';
break;
} 

// Query for retrieving all the entries in the database
$query = "select bc.bc_id as id, p.p_university as uni, concat(c.semester, '  ', c.semester_year) as sem, c.course_no as cno, concat(p.p_last_name, ',', p.p_first_name) as prof, p.p_email as email, p.p_phone_number as pno, bc.bc_isbn as isbn, bc.bc_b_title as b_title, bc.bc_author as author, bc.bc_c_title as c_title, bc.bc_date_of_pub as pub_date, bc.bc_incl_pages as incl_pages, bc.bc_call_number as call_no, bc.bc_syllabi as syllabi, bc.bc_comments as comments, DATE_FORMAT(bc.bc_req_date, '%m-%d-%y') as req_date
from c_request bc, professor p, course c  
where bc.p_email = p.p_email AND bc.c_id = c.c_id
ORDER BY $order_by LIMIT $start, $display";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffcc';
$this_page = ($start/$display)+1;
	echo '<div align="center" style="font-size:large">CHAPTER REQUESTS</div><br/> ';
	echo '<table border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse; font-size:11px" width="98%" align="center">
	<tr><td align="right" colspan ="18" style="font-weight:bold">Page '.$this_page.' of '.$pages.'</td></tr>';
	echo '<tr bgcolor="#990000">
	<th colspan = "3"  width="2%">&nbsp;</th>';

	if($sort == "req_date_a")
	{echo '<th align="center" width="7%"><a href="display_chapter_requests.php?sort=req_date_d">Req Date</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "req_date_d")
	{echo '<th align="center" width="7%"><a href="display_chapter_requests.php?sort=req_date_a">Req Date</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="7%"><a href="display_chapter_requests.php?sort=req_date_a">Req Date</a></th>';}
	
	if($sort == "bc_id_a")
	{echo '<th valign = "center" width="5%"><a href="display_chapter_requests.php?sort=bc_id_d">Req #</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "bc_id_d")
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=bc_id_a">Req #</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=bc_id_a">Req #</a></th>';}
	
	if($sort == "uni_a")
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=uni_d">Univ.</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "uni_d")
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=uni_a">Univ.</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=uni_a">Univ.</a></th>';}

	if($sort == "sem_a")
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=sem_d">Sem.</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "sem_d")
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=sem_a">Sem.</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=sem_a">Sem.</a></th>';}

	if($sort == "cno_a")
	{echo '<th align="center" width="4%"><a href="display_chapter_requests.php?sort=cno_d">Course</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "cno_d")
	{echo '<th align="center" width="4%"><a href="display_chapter_requests.php?sort=cno_a">Course</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="4%"><a href="display_chapter_requests.php?sort=cno_a">Course</a></th>';}

	if($sort == "prof_a")
	{echo '<th align="center" width="9%"><a href="display_chapter_requests.php?sort=prof_d">Professor</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "prof_d")
	{echo '<th align="center" width="9%"><a href="display_chapter_requests.php?sort=prof_a">Professor</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="9%"><a href="display_chapter_requests.php?sort=prof_a">Professor</a></th>';}
	
	if($sort == "email_a")
	{	echo '<th align="center" width="8%"><a href="display_chapter_requests.php?sort=email_d">Contact</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "email_d")
	{echo '<th align="center" width="8%"><a href="display_chapter_requests.php?sort=email_a">Contact</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="8%"><a href="display_chapter_requests.php?sort=email_a">Contact</a></th>';}


	if($sort == "isbn_a")
	{echo '<th align="center" width="6%"><a href="display_chapter_requests.php?sort=isbn_d">ISBN</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "isbn_d")
	{echo '<th align="center" width="6%"><a href="display_chapter_requests.php?sort=isbn_a">ISBN</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="6%"><a href="display_chapter_requests.php?sort=isbn_a">ISBN</a></th>';}
	
	if($sort == "b_title_a")
	{echo '<th align="center" width="15%"><a href="display_chapter_requests.php?sort=b_title_d">Book Title</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "b_title_d")
	{echo '<th align="center" width="15%"><a href="display_chapter_requests.php?sort=b_title_a">Book Title</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="15%"><a href="display_chapter_requests.php?sort=b_title_a">Book Title</a></th>';}

	if($sort == "c_title_a")
	{echo '<th align="center" width="10%"><a href="display_chapter_requests.php?sort=c_title_d">Chpt Title</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "c_title_d")
	{echo '<th align="center" width="10%"><a href="display_chapter_requests.php?sort=c_title_a">Chpt Title</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="10%"><a href="display_chapter_requests.php?sort=c_title_a">Chpt Title</a></th>';}

	if($sort == "author_a")
	{echo '<th align="center" width="7%"><a href="display_chapter_requests.php?sort=author_d">Author</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "author_d")
	{echo '<th align="center" width="7%"><a href="display_chapter_requests.php?sort=author_a">Author</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="7%"><a href="display_chapter_requests.php?sort=author_a">Author</a></th>';}

	if($sort == "pub_date_a")
	{echo '<th align="center" width="6%"><a href="display_chapter_requests.php?sort=pub_date_d">Pub Date</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "pub_date_d")
	{echo '<th align="center" width=6%"><a href="display_chapter_requests.php?sort=pub_date_a">Pub Date</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width=6%"><a href="display_chapter_requests.php?sort=pub_date_a">Pub Date</a></th>';}
	
	if($sort == "incl_pages_a")
	{echo '<th align="center" width="4%"><a href="display_chapter_requests.php?sort=incl_pages_d">Pgs</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "incl_pages_d")
	{echo '<th align="center" width="4%"><a href="display_chapter_requests.php?sort=incl_pages_a">Pgs</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="4%"><a href="display_chapter_requests.php?sort=incl_pages_a">Pgs</a></th>';}

	if($sort == "call_no_a")
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=call_no_d">Call #</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "call_no_d")
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=call_no_a">Call #</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="5%"><a href="display_chapter_requests.php?sort=call_no_a">Call #</a></th>';}

	if($sort == "syllabi_a")
	{echo '<th align="center" width="1%"><a href="display_chapter_requests.php?sort=syllabi_d">Syl</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "syllabi_d")
	{echo '<th align="center" width="1%"><a href="display_chapter_requests.php?sort=syllabi_a">Syl</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="1%"><a href="display_chapter_requests.php?sort=syllabi_a">Syl</a></th>';}
	
	if($sort == "comments_a")
	{echo '<th align="center" width="8%"><a href="display_chapter_requests.php?sort=comments_d">Comments</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th></tr>';}
	elseif($sort == "comments_d")
	{echo '<th align="center" width="8%"><a href="display_chapter_requests.php?sort=comments_a">Comments</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th></tr>';}
	else
	{echo '<th align="center" width="8%"><a href="display_chapter_requests.php?sort=comments_a">Comments</a></th></tr>';}

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
	switch ($row['uni']) // Displaying acronyms for the Universities
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
	
	$bg = ($bg=='#ffffcc'?'#ffffff':'#ffffcc');
	echo '<tr bgcolor="'.$bg.'">
	<td align="center"><a href="display_full_chapter_request.php?id='.$row['id'].'"><img src="images/info-icon.png" alt="More Information" border="0" width="18" height="18" title="More Information" /></a></td>
    <td align="center"><a href="edit_chapter_request.php?id='.$row['id'].'"><img src="images/edit-icon.png" alt="Edit Entry" border="0" width="18" height="18" title="Edit Entry"  /></a></td>
    <td align="center"><a href="delete_chapter_request.php?id='.$row['id'].'"><img src="images/delete-icon.png" alt="Delete" border="0" width="18" height="18" title="Delete Entry"  /></a></td>

	<td align="center">'.$row['req_date'].'</td>	
	<td align="center">'.$row['id'].'</td>
	<td align="center">'.$univ.'</td>
	<td align="center">'.$row['sem'].'</td>
	<td align="center">'.$row['cno'].'</td>
	<td align="center">'.$row['prof'].'</td>
	<td align="left">'.$row['email'].'<br/>Ph: '.$row['pno'].'</td>
	<td align="left">'.$row['isbn'].'</td>
	<td align="left">'.$row['b_title'].'</td>		
	<td align="left">'.$row['c_title'].'</td>		
	<td align="left">'.$row['author'].'</td>		
	<td align="center">'.$row['pub_date'].'</td>	
	<td align="center">'.$row['incl_pages'].'</td>
	<td align="center">'.$row['call_no'].'</td>
	<td align="center">'.$row['syllabi'].'</td>
	<td align="center">'.$row['comments'].'</td>
	
	</tr>';
	}
// Display page numbers 
echo '<tr><td align = "center" colspan="18">';
if($pages >1)
{
$current_page = ($start/$display)+1;

if($current_page != 1)
{
echo '<a href="display_chapter_requests.php?sort='.$sort.'&s='.($start-$display).'&p='.$pages.'"><span class="log"> '.Previous.' </span></a>';
}
for($i=1; $i<=$pages; $i++)
{
if($i != $current_page)
{
echo ' <a href="display_chapter_requests.php?sort='.$sort.'&s='.(($display * ($i - 1))).'&p='.$pages.'"><span class="log"> '.$i.' </span></a> ';
}
else
{
echo $i;
}
}
if($current_page != $pages)
{
echo '<a href="display_chapter_requests.php?sort='.$sort.'&s='.($start+$display).'&p='.$pages.'"><span class="log"> '.Next.' </span></a>';
}
}

echo '</td></tr></table>';
echo "<br /><br />";

include('footer.php'); 

?>
