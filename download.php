<?php
include('connect_to_shady_grove.php'); // Creates a connection to the database

$query = "select b.b_id as id, p.p_university as uni, concat(c.semester, '  ', c.semester_year) as sem, c.course_no as cno, concat(p.p_last_name, ',', p.p_first_name) as prof, p.p_email as email, p.p_phone_number as pno, b.b_isbn as isbn, b.b_title as title, b.b_author as author, b.b_date_of_pub as pub_date, b.b_call_number as call_no, b.b_barcode as barcode, b.b_syllabi as syllabi, b.b_comments as comments, DATE_FORMAT(b.b_req_date, '%m-%d-%y') as req_date
from b_request b, professor p, course c  
where b.p_email = p.p_email AND b.c_id = c.c_id";
$result = @mysqli_query ($dbc, $query); //Runs the Query


$filename ="excelreport.xls";
$contents = "Request Date \t Request # \t University \t Sem \t Course \t professor \t email \t Phone \t ISBN \t Title \t Author \t pub_date \t Call No \t Barcode \t Syllabi \t Comments\n";
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
echo $row['req_date']; 
echo " \t ";
echo $row['id'];
echo " \t ";
echo $row['uni'];
echo " \t " ;
echo $row['sem'];
echo " \t " ;
echo $row['cno'];
echo " \t " ;
echo $row['prof'];
echo " \t " ;
echo $row['email'];
echo " \t " ;
echo $row['pno'];
echo " \t " ;
echo $row['isbn'];
echo " \t " ;
echo $row['title'];
echo " \t " ;
echo $row['author'];
echo " \t " ;
echo $row['pub_date'];
echo " \t " ;
echo $row['call_no'];
echo " \t " ;
echo $row['barcode'];
echo " \t " ;
echo $row['syllabi'];
echo " \t " ;
echo $row['comments'];
echo " \n";;
}
?>

