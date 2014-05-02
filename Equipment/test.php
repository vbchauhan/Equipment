<?php


$link = mysql_connect('localhost', 'madhus', 'L3arning!4Edu');
$db_selected = mysql_select_db('equipment', $link);
$query = "select user_type_id,user_type_name from user_types";
$result = mysql_query($query); // Run the query.
echo '<table align="center" cellspacing="0" cellpadding="5">
<tr>
	<td CLASS="tablebox"  align="left"><b>Action</b></td>
	<td CLASS="tablebody"  align="left"><b>Item</b></td>
</tr>';
// Fetch and print all the records.
$bg = '#eeeeee'; // Set the background color.
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	echo '<tr bgcolor="' . $bg . '">
		<td CLASS="tablebody"  align="left">' . $row['user_type_id'] . '</td>
		<td CLASS="tablebody"  align="left">' . $row['user_type_name'] . '</td>
		</tr>
	';
}
echo '</table>';
?>
