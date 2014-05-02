<?php 
 
$header = "Article Requests";
include('header.php'); //Displays the logo and top navigation menu
include('connect_to_shady_grove.php'); // Creates a connection to the database

// Created by: Siddharth Choksi in May 2010
// This file displays all Article Requests existing in the database. Not accessible without logging in. 

$display = 20; // Number of entries per page

// Calculate the number of pages for displaying the results 
if(isset($_GET['p']) && is_numeric($_GET['p']))
{$pages = $_GET['p'];}

else
{
$query = 'select COUNT(a_id) FROM a_request';
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
case 'a_id_a':
$order_by = 'a.a_id ASC';
break;

case 'a_id_d':
$order_by = 'a.a_id DESC';
break;

case 'req_date_a':
$order_by = 'a.a_req_date ASC';
break;

case 'req_date_d':
$order_by = 'a.a_req_date DESC';
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

case 'issn_a':
$order_by = 'a.a_issn ASC';
break;

case 'issn_d':
$order_by = 'a.a_issn DESC';
break;

case 'j_title_a':
$order_by = 'a.j_title ASC';
break;

case 'j_title_d':
$order_by = 'a.j_title DESC';
break;

case 'a_title_a':
$order_by = 'a.a_title ASC';
break;

case 'a_title_d':
$order_by = 'a.a_title DESC';
break;

case 'author_a':
$order_by = 'a.a_author ASC';
break;

case 'author_d':
$order_by = 'a.a_author DESC';
break;

case 'vol_a':
$order_by = 'a.j_volume ASC';
break;

case 'vol_d':
$order_by = 'a.j_volume DESC';
break;

case 'issue_a':
$order_by = 'a.j_issue ASC';
break;

case 'issue_d':
$order_by = 'a.j_issue DESC';
break;

case 'year_a':
$order_by = 'a.j_year, a.j_month ASC';
break;

case 'year_d':
$order_by = 'a.j_year, a.j_month DESC';
break;

case 'incl_pages_a':
$order_by = 'a.a_incl_pages ASC';
break;

case 'incl_pages_d':
$order_by = 'a.a_incl_pages DESC';
break;

case 'syllabi_a':
$order_by = 'a.a_syllabi ASC';
break;

case 'syllabi_d':
$order_by = 'a.a_syllabi DESC';
break;

case 'comments_a':
$order_by = 'a.a_comments ASC';
break;

case 'comments_d':
$order_by = 'a.a_comments DESC';
break;

default:
$order_by = 'a.a_req_date DESC';
break;
} 

// Query for retrieving all the entries in the database
$query = "select a.a_id as id, p.p_university as uni, concat(c.semester, '  ', c.semester_year) as sem, c.course_no as cno, concat(p.p_last_name,',' , p.p_first_name) as prof, p.p_email as email, p.p_phone_number as pno, a.a_issn as issn, a.j_title as j_title, a.a_title as a_title, a.a_author as author, a.j_volume as vol, a.j_issue as issue, a.j_month as month, a.j_year as year,  a.a_incl_pages as incl_pages, a.a_syllabi as syllabi, a.a_comments as comments, DATE_FORMAT(a.a_req_date, '%m-%d-%y') as req_date
from a_request a, professor p, course c  
where a.p_email = p.p_email AND a.c_id = c.c_id
ORDER BY $order_by LIMIT $start, $display";
$result = @mysqli_query($dbc, $query);
$bg = '#ffffcc';
$this_page = ($start/$display)+1;
	echo '<div align="center" style="font-size:large">ARTICLE REQUESTS</div><br/> ';
	echo '<table border="1" cellpadding="3" cellspacing="0" style="border-collapse:collapse; font-size:11px" width="98%" align="center">
	<tr><td align="right" colspan ="19" style="font-weight:bold">Page '.$this_page.' of '.$pages.'</td></tr>';
	echo '<tr bgcolor="#990000">
	<th colspan = "3" width="1%">&nbsp;</th>';

	if($sort == "req_date_a")
	{echo '<th align="center" width="8%"><a href="display_article_requests.php?sort=req_date_d">Req Date</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "req_date_d")
	{echo '<th align="center" width="8%"><a href="display_article_requests.php?sort=req_date_a">Req Date</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="8%"><a href="display_article_requests.php?sort=req_date_a">Req Date</a></th>';}
	
	if($sort == "a_id_a")
	{echo '<th valign = "center" width="5%"><a href="display_article_requests.php?sort=a_id_d">Req #</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "a_id_d")
	{echo '<th align="center" width="5%"><a href="display_article_requests.php?sort=a_id_a">Req #</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="5%"><a href="display_article_requests.php?sort=a_id_a">Req #</a></th>';}
	
	if($sort == "uni_a")
	{echo '<th align="center" width="5%"><a href="display_article_requests.php?sort=uni_d">Univ.</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "uni_d")
	{echo '<th align="center" width="5%"><a href="display_article_requests.php?sort=uni_a">Univ.</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="5%"><a href="display_article_requests.php?sort=uni_a">Univ.</a></th>';}

	if($sort == "sem_a")
	{echo '<th align="center" width="5%"><a href="display_article_requests.php?sort=sem_d">Sem.</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "sem_d")
	{echo '<th align="center" width="5%"><a href="display_article_requests.php?sort=sem_a">Sem.</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="5%"><a href="display_article_requests.php?sort=sem_a">Sem.</a></th>';}

	if($sort == "cno_a")
	{echo '<th align="center" width="4%"><a href="display_article_requests.php?sort=cno_d">Course</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "cno_d")
	{echo '<th align="center" width="4%"><a href="display_article_requests.php?sort=cno_a">Course</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="4%"><a href="display_article_requests.php?sort=cno_a">Course</a></th>';}

	if($sort == "prof_a")
	{echo '<th align="center" width="9%"><a href="display_article_requests.php?sort=prof_d">Professor</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "prof_d")
	{echo '<th align="center" width="9%"><a href="display_article_requests.php?sort=prof_a">Professor</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="9%"><a href="display_article_requests.php?sort=prof_a">Professor</a></th>';}
	
	if($sort == "email_a")
	{	echo '<th align="center" width="8%"><a href="display_article_requests.php?sort=email_d">Contact</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "email_d")
	{echo '<th align="center" width="8%"><a href="display_article_requests.php?sort=email_a">Contact</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="8%"><a href="display_article_requests.php?sort=email_a">Contact</a></th>';}


	if($sort == "issn_a")
	{echo '<th align="center" width="6%"><a href="display_article_requests.php?sort=issn_d">ISSN</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "issn_d")
	{echo '<th align="center" width="6%"><a href="display_article_requests.php?sort=issn_a">ISSN</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="6%"><a href="display_article_requests.php?sort=issn_a">ISSN</a></th>';}
	
	if($sort == "j_title_a")
	{echo '<th align="center" width="15%"><a href="display_article_requests.php?sort=j_title_d">Journal Title</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "j_title_d")
	{echo '<th align="center" width="15%"><a href="display_article_requests.php?sort=j_title_a">Journal Title</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="15%"><a href="display_article_requests.php?sort=j_title_a">Journal Title</a></th>';}

	if($sort == "a_title_a")
	{echo '<th align="center" width="10%"><a href="display_article_requests.php?sort=a_title_d">Article Title</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "a_title_d")
	{echo '<th align="center" width="10%"><a href="display_article_requests.php?sort=a_title_a">Article Title</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="10%"><a href="display_article_requests.php?sort=a_title_a">Article Title</a></th>';}

	if($sort == "author_a")
	{echo '<th align="center" width="7%"><a href="display_article_requests.php?sort=author_d">Author</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "author_d")
	{echo '<th align="center" width="7%"><a href="display_article_requests.php?sort=author_a">Author</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="7%"><a href="display_article_requests.php?sort=author_a">Author</a></th>';}

	if($sort == "vol_a")
	{echo '<th align="center" width="3%"><a href="display_article_requests.php?sort=vol_d">Vol.</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "vol_d")
	{echo '<th align="center" width="3%"><a href="display_article_requests.php?sort=vol_a">Vol.</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="3%"><a href="display_article_requests.php?sort=vol_a">Vol.</a></th>';}

	if($sort == "issue_a")
	{echo '<th align="center" width="3%"><a href="display_article_requests.php?sort=issue_d">Issue</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "issue_d")
	{echo '<th align="center" width="3%"><a href="display_article_requests.php?sort=issue_a">Issue</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="3%"><a href="display_article_requests.php?sort=issue_a">Issue</a></th>';}

	if($sort == "year_a")
	{echo '<th align="center" width="3%"><a href="display_article_requests.php?sort=year_d">Year</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "year_d")
	{echo '<th align="center" width="3%"><a href="display_article_requests.php?sort=year_a">Year</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="3%"><a href="display_article_requests.php?sort=year_a">Year</a></th>';}
	
	if($sort == "incl_pages_a")
	{echo '<th align="center" width="4%"><a href="display_article_requests.php?sort=incl_pages_d">Pgs</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "incl_pages_d")
	{echo '<th align="center" width="4%"><a href="display_article_requests.php?sort=incl_pages_a">Pgs</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="4%"><a href="display_article_requests.php?sort=incl_pages_a">Pgs</a></th>';}

	if($sort == "syllabi_a")
	{echo '<th align="center" width="1%"><a href="display_article_requests.php?sort=syllabi_d">Syl</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th>';}
	elseif($sort == "syllabi_d")
	{echo '<th align="center" width="1%"><a href="display_article_requests.php?sort=syllabi_a">Syl</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th>';}
	else
	{echo '<th align="center" width="1%"><a href="display_article_requests.php?sort=syllabi_a">Syl</a></th>';}
	
	if($sort == "comments_a")
	{echo '<th align="center" width="8%"><a href="display_article_requests.php?sort=comments_d">Comments</a>&nbsp;<img src= "images/ascending.gif" border = "0"/></th></tr>';}
	elseif($sort == "comments_d")
	{echo '<th align="center" width="8%"><a href="display_article_requests.php?sort=comments_a">Comments</a>&nbsp;<img src= "images/descending.gif" border = "0"/></th></tr>';}
	else
	{echo '<th align="center" width="8%"><a href="display_article_requests.php?sort=comments_a">Comments</a></th></tr>';}

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
	$univ = 'UMES';
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
	<td align="center"><a href="display_full_article_request.php?id='.$row['id'].'"><img src="images/info-icon.png" alt="More Information" border="0" width="18" height="18" title="More Information" /></a></td>
    <td align="center"><a href="edit_article_request.php?id='.$row['id'].'"><img src="images/edit-icon.png" alt="Edit Entry" border="0" width="18" height="18" title="Edit Entry"  /></a></td>
    <td align="center"><a href="delete_article_request.php?id='.$row['id'].'"><img src="images/delete-icon.png" alt="Delete" border="0" width="18" height="18" title="Delete Entry"  /></a></td>

	<td align="center">'.$row['req_date'].'</td>	
	<td align="center">'.$row['id'].'</td>
	<td align="center">'.$row['uni'].'</td>
	<td align="center">'.$row['sem'].'</td>
	<td align="center">'.$row['cno'].'</td>
	<td align="center">'.$row['prof'].'</td>
	<td align="left">'.$row['email'].'<br/>Ph: '.$row['pno'].'</td>
	<td align="left">'.$row['issn'].'</td>
	<td align="left">'.$row['j_title'].'</td>		
	<td align="left">'.$row['a_title'].'</td>		
	<td align="left">'.$row['author'].'</td>		
	<td align="center">'.$row['vol'].'</td>	
	<td align="center">'.$row['issue'].'</td>	
	<td align="center">'.$row['month'].' '.$row['year'].'</td>	
	<td align="center">'.$row['incl_pages'].'</td>
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
echo '<a href="display_article_requests.php?sort='.$sort.'&s='.($start-$display).'&p='.$pages.'"><span class="log"> '.Previous.' </span></a>';
}
for($i=1; $i<=$pages; $i++)
{
if($i != $current_page)
{
echo ' <a href="display_article_requests.php?sort='.$sort.'&s='.(($display * ($i - 1))).'&p='.$pages.'"><span class="log"> '.$i.' </span></a> ';
}
else
{
echo $i;
}
}
if($current_page != $pages)
{
echo '<a href="display_article_requests.php?sort='.$sort.'&s='.($start+$display).'&p='.$pages.'"><span class="log"> '.Next.' </span></a>';
}
}

echo '</td></tr></table>';
echo "<br /><br />";

include('footer.php'); 

?>
