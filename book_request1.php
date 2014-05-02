<!-- 
Created by: Siddharth Choksi in May 2010
This file provides the Book Request Fields. (Parent File: book_request.php)
-->
<?php
$semester = array('Summer I', 'Summer II', 'Fall', 'Winter', 'Spring');
$semester_year = array('2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020');
?>
<!-- BOOK REQUEST #1 STARTS HERE -->

<table width="100%" style="text-align:left" border="0" cellpadding="3">
  <tr>
    <td colspan="4" bgcolor="#990000" align="center" style="border:solid #646464 1px"><span style="color:#FFFFFF; font-size:13px"><strong>BOOK REQUEST #1</strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="4" align="center"><span style="color:#ffffff; font-size:13px"><strong>Course Information</strong></span> </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td align="left" width="25%"><strong><span class="style2">Semester *</span></strong>
      <select name="semester1" size="1">
        <?php
 foreach($semester as $row)
 {
 	if ($row==$_POST['semester1'])
	{echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';}	
	else
	{echo '<option value="'. $row . '">'. $row . '</option>';}
 }		
?>
      </select>
      <select name="semester_year1" size="1">
        <?php
 foreach($semester_year as $row)
 {
 	if ($row==$_POST['semester_year1'])
	{echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';}	
	else
	{echo '<option value="'. $row . '">'. $row . '</option>';}
  }		
?>
      </select>
    </td>
    <td align="left" width="25%"><strong>Course Title</strong>
      <input name="course_title1" type="text" size="20" value="<?php if(isset($_POST['course_title1'])){echo $_POST['course_title1'];}?>" />
    </td>
    <td align="center" width="25%"><strong><span class="style2">Course Number *</span></strong>
      <input name="course_no1" type="text" size="10" value="<?php if(isset($_POST['course_no1'])){echo $_POST['course_no1'];}?>" />
    </td>
    <td align="center" width="25%"><strong>Loan Period</strong>
      <input type="radio" name="loan_period1" value="2 hrs" id="RadioGroup1_0" />
      2 hrs
      <input type="radio" name="loan_period1" value="1 day " id="RadioGroup1_1" />
      1 day </td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="4" align="center"><span style="color:#ffffff; font-size:13px"><strong>Book Information</strong></span></td>
  </tr>
  <tr>
    <td align="center" valign="top"> <strong><span class="style2">Title *</span></strong><br />
      <span class="style1">Please do not abbreviate unless your citation is abbreviated</span><br />
      <input name="b_title1" type="text" size="40" value="<?php if(isset($_POST['b_title1'])){echo $_POST['b_title1'];}?>" />
    </td>
    <td align="center" valign="top"> <strong><span class="style2">Author(s) *</span></strong><br />
      <span class="style1">(Last Name, First Name)</span><br />
      <input name="b_author1" type="text" size="30" value="<?php if(isset($_POST['b_author1'])){echo $_POST['b_author1'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>ISBN</strong><br />
      <input name="b_isbn1" type="text" size="21" value="<?php if(isset($_POST['b_isbn1'])){echo $_POST['b_isbn1'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>Edition</strong><br />
      <input name="b_edition1" type="text" size="21" value="<?php if(isset($_POST['b_edition1'])){echo $_POST['b_edition1'];}?>" />
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td align="center" valign="top"> <strong>Publisher</strong><br />
      <input name="b_publisher1" type="text" size="40" value="<?php if(isset($_POST['b_publisher1'])){echo $_POST['b_publisher1'];}?>" />
    </td>
    <td align="center" valign="top"> <strong>Place of Publication</strong><br />
      <input name="b_place_of_pub1" type="text" size="30" value="<?php if(isset($_POST['b_place_of_pub1'])){echo $_POST['b_place_of_pub1'];}?>" />
    </td>
    <td align="center" valign="top"> <strong><span class="style2">Publication Date *</span></strong><br />
      <input name="b_pub_date1" type="text" size="21" value="<?php if(isset($_POST['b_pub_date1'])){echo $_POST['b_pub_date1'];}?>" />
    </td>
    <td align="center" valign="top"> <strong>Call Number</strong><br />
      <input name="b_call_no1" type="text" size="21" value="<?php if(isset($_POST['b_call_no1'])){echo $_POST['b_call_no1'];}?>" />
    </td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="4" align="center"><span style="color:#ffffff; font-size:13px"><strong>Additional Information</strong></span></td>
  </tr>
  <tr>
    <td valign="top"><strong>How will this item be supplied?</strong><br />
    </td>
    <td colspan="3">
      <label>
      <input name="b_supply_method1" type="radio" id="RadioGroup1_1" value="Pull Off Shelf" checked="checked"/>
      Please have library staff pull the material off the shelves<br />
      </label>
      <label>
      <input type="radio" name="b_supply_method1" value="Will Bring to Library" id="RadioGroup1_1" />
      I will bring the material to Priddy Library<br />
      </label>
      <label>
      <input type="radio" name="b_supply_method1" value="Purchase Item" id="RadioGroup1_1" />
      Please purchase this item and make it available to my students through course reserves<br />
      </label>
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td> <strong>Notes:</strong><br />
      <span class="style1">Put any information here that may help us find the item, as well as any other pertinent information. </span> </td>
    <td colspan="3">
      <textarea name="b_notes1" cols="80" rows="2"><?php if(isset($_POST['b_notes1'])){echo $_POST['b_notes1'];}?>
</textarea>
    </td>
  </tr>
</table>
<!-- BOOK REQUEST #1 ENDS HERE -->
<!-- BOOK REQUEST #2 STARTS HERE -->
<table width="100%" style="text-align:left" border="0" cellpadding="3">
  <tr>
    <td colspan="4" bgcolor="#990000" align="center" style="border:solid #646464 1px"><span style="color:#FFFFFF; font-size:13px"><strong>BOOK REQUEST #2</strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="4" align="center"><span style="color:#ffffff; font-size:13px"><strong>Course Information</strong></span> </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td align="left" width="25%"><strong><span class="style2">Semester *</span></strong>
      <select name="semester2" size="1">
        <?php
 foreach($semester as $row)
 {
 	if ($row==$_REQUEST['semester2'])
	{echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';}	
	else
	{echo '<option value="'. $row . '">'. $row . '</option>';}
  }		
?>
      </select>
      <select name="semester_year2" size="1">
        <?php
 foreach($semester_year as $row)
 {
 	if ($row==$_REQUEST['semester_year2'])
	{echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';}	
	else
	{echo '<option value="'. $row . '">'. $row . '</option>';}
  }		
?>
      </select>
    </td>
    <td align="left" width="25%"><strong>Course Title</strong>
      <input name="course_title2" type="text" size="20" value="<?php if(isset($_POST['course_title2'])){echo $_POST['course_title2'];}?>" />
    </td>
    <td align="center" width="25%"><strong><span class="style2">Course Number *</span></strong>
      <input name="course_no2" type="text" size="10" value="<?php if(isset($_POST['course_no2'])){echo $_POST['course_no2'];}?>" />
    </td>
    <td align="center" width="25%"><strong>Loan Period</strong>
      <input type="radio" name="loan_period2" value="2 hrs" id="RadioGroup1_0" />
      2 hrs
      <input type="radio" name="loan_period2" value="1 day " id="RadioGroup1_1" />
      1 day </td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="4" align="center"><span style="color:#ffffff; font-size:13px"><strong>Book Information</strong></span></td>
  </tr>
  <tr>
    <td align="center" valign="top"> <strong><span class="style2">Title *</span></strong><br />
      <span class="style1">Please do not abbreviate unless your citation is abbreviated</span><br />
      <input name="b_title2" type="text" size="40" value="<?php if(isset($_POST['b_title2'])){echo $_POST['b_title2'];}?>" />
    </td>
    <td align="center" valign="top"> <strong><span class="style2">Author(s) *</span></strong><br />
      <span class="style1">(Last Name, First Name)</span><br />
      <input name="b_author2" type="text" size="30" value="<?php if(isset($_POST['b_author1'])){echo $_POST['b_author2'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>ISBN</strong><br />
      <input name="b_isbn2" type="text" size="21" value="<?php if(isset($_POST['b_isbn2'])){echo $_POST['b_isbn2'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>Edition</strong><br />
      <input name="b_edition2" type="text" size="21" value="<?php if(isset($_POST['b_edition2'])){echo $_POST['b_edition2'];}?>" />
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td align="center" valign="top"> <strong>Publisher</strong><br />
      <input name="b_publisher2" type="text" size="40" value="<?php if(isset($_POST['b_publisher2'])){echo $_POST['b_publisher2'];}?>" />
    </td>
    <td align="center" valign="top"> <strong>Place of Publication</strong><br />
      <input name="b_place_of_pub2" type="text" size="30" value="<?php if(isset($_POST['b_place_of_pub2'])){echo $_POST['b_place_of_pub2'];}?>" />
    </td>
    <td align="center" valign="top"> <strong><span class="style2">Publication Date *</span></strong><br />
      <input name="b_pub_date2" type="text" size="21" value="<?php if(isset($_POST['b_pub_date2'])){echo $_POST['b_pub_date2'];}?>" />
    </td>
    <td align="center" valign="top"> <strong>Call Number</strong><br />
      <input name="b_call_no2" type="text" size="21" value="<?php if(isset($_POST['b_call_no2'])){echo $_POST['b_call_no2'];}?>" />
    </td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="4" align="center"><span style="color:#ffffff; font-size:13px"><strong>Additional Information</strong></span></td>
  </tr>
  <tr>
    <td valign="top"><strong>How will this item be supplied?</strong><br />
    </td>
    <td colspan="3">
      <label>
      <input name="b_supply_method2" type="radio" id="RadioGroup1_2" value="Pull Off Shelf" checked="checked"/>
      Please have library staff pull the material off the shelves<br />
      </label>
      <label>
      <input type="radio" name="b_supply_method2" value="Will Bring to Library" id="RadioGroup1_2" />
      I will bring the material to Priddy Library<br />
      </label>
      <label>
      <input type="radio" name="b_supply_method2" value="Purchase Item" id="RadioGroup1_2" />
      Please purchase this item and make it available to my students through course reserves<br />
      </label>
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td> <strong>Notes:</strong><br />
      <span class="style1">Put any information here that may help us find the item, as well as any other pertinent information. </span> </td>
    <td colspan="3">
      <textarea name="b_notes2" cols="80" rows="2"><?php if(isset($_POST['b_notes2'])){echo $_POST['b_notes2'];}?>
</textarea>
    </td>
  </tr>
</table>
<!-- BOOK REQUEST #2 ENDS HERE -->
<!-- BOOK REQUEST #3 STARTS HERE -->
<table width="100%" style="text-align:left" border="0" cellpadding="3">
  <tr>
    <td colspan="4" bgcolor="#990000" align="center" style="border:solid #646464 1px"><span style="color:#FFFFFF; font-size:13px"><strong>BOOK REQUEST #3</strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="4" align="center"><span style="color:#ffffff; font-size:13px"><strong>Course Information</strong></span> </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td align="left" width="25%"><strong><span class="style2">Semester *</span></strong>
      <select name="semester3" size="1">
        <?php
 foreach($semester as $row)
 {
 	if ($row==$_REQUEST['semester3'])
	{echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';}	
	else
	{echo '<option value="'. $row . '">'. $row . '</option>';}
  }		
?>
      </select>
      <select name="semester_year3" size="1">
        <?php
 foreach($semester_year as $row)
 {
 	if ($row==$_REQUEST['semester_year3'])
	{echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';}	
	else
	{echo '<option value="'. $row . '">'. $row . '</option>';}
  }		
?>
      </select>
    </td>
    <td align="left" width="25%"><strong>Course Title</strong>
      <input name="course_title3" type="text" size="20" value="<?php if(isset($_POST['course_title3'])){echo $_POST['course_title3'];}?>" />
    </td>
    <td align="center" width="25%"><strong><span class="style2">Course Number *</span></strong>
      <input name="course_no3" type="text" size="10" value="<?php if(isset($_POST['course_no3'])){echo $_POST['course_no3'];}?>" />
    </td>
    <td align="center" width="25%"><strong>Loan Period</strong>
      <input type="radio" name="loan_period3" value="2 hrs" id="RadioGroup1_0" />
      2 hrs
      <input type="radio" name="loan_period3" value="1 day " id="RadioGroup1_1" />
      1 day </td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="4" align="center"><span style="color:#ffffff; font-size:13px"><strong>Book Information</strong></span></td>
  </tr>
  <tr>
    <td align="center" valign="top"> <strong><span class="style2">Title *</span></strong><br />
      <span class="style1">Please do not abbreviate unless your citation is abbreviated</span><br />
      <input name="b_title3" type="text" size="40" value="<?php if(isset($_POST['b_title3'])){echo $_POST['b_title3'];}?>" />
    </td>
    <td align="center" valign="top"> <strong><span class="style2">Author(s) *</span></strong><br />
      <span class="style1">(Last Name, First Name)</span><br />
      <input name="b_author3" type="text" size="30" value="<?php if(isset($_POST['b_author3'])){echo $_POST['b_author3'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>ISBN</strong><br />
      <input name="b_isbn3" type="text" size="21" value="<?php if(isset($_POST['b_isbn3'])){echo $_POST['b_isbn3'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>Edition</strong><br />
      <input name="b_edition3" type="text" size="21" value="<?php if(isset($_POST['b_edition3'])){echo $_POST['b_edition3'];}?>" />
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td align="center" valign="top"> <strong>Publisher</strong><br />
      <input name="b_publisher3" type="text" size="40" value="<?php if(isset($_POST['b_publisher3'])){echo $_POST['b_publisher3'];}?>" />
    </td>
    <td align="center" valign="top"> <strong>Place of Publication</strong><br />
      <input name="b_place_of_pub3" type="text" size="30" value="<?php if(isset($_POST['b_place_of_pub3'])){echo $_POST['b_place_of_pub3'];}?>" />
    </td>
    <td align="center" valign="top"> <strong><span class="style2">Publication Date *</span></strong><br />
      <input name="b_pub_date3" type="text" size="21" value="<?php if(isset($_POST['b_pub_date3'])){echo $_POST['b_pub_date3'];}?>" />
    </td>
    <td align="center" valign="top"> <strong>Call Number</strong><br />
      <input name="b_call_no3" type="text" size="21" value="<?php if(isset($_POST['b_call_no3'])){echo $_POST['b_call_no3'];}?>" />
    </td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="4" align="center"><span style="color:#ffffff; font-size:13px"><strong>Additional Information</strong></span></td>
  </tr>
  <tr>
    <td valign="top"><strong>How will this item be supplied?</strong><br />
    </td>
    <td colspan="3">
      <label>
      <input name="b_supply_method3" type="radio" id="RadioGroup1_3" value="Pull Off Shelf" checked="checked"/>
      Please have library staff pull the material off the shelves<br />
      </label>
      <label>
      <input type="radio" name="b_supply_method3" value="Will Bring to Library" id="RadioGroup1_3" />
      I will bring the material to Priddy Library<br />
      </label>
      <label>
      <input type="radio" name="b_supply_method3" value="Purchase Item" id="RadioGroup1_3" />
      Please purchase this item and make it available to my students through course reserves<br />
      </label>
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td> <strong>Notes:</strong><br />
      <span class="style1">Put any information here that may help us find the item, as well as any other pertinent information. </span> </td>
    <td colspan="3">
      <textarea name="b_notes3" cols="80" rows="2"><?php if(isset($_POST['b_notes3'])){echo $_POST['b_notes3'];}?>
</textarea>
    </td>
  </tr>
</table>
<!-- BOOK REQUEST #3 STARTS HERE -->
