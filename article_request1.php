<!-- 
Created by: Siddharth Choksi in May 2010
This file provides the Article Request Fields. (Parent File: article_request.php)
-->
<?php
$semester = array('Summer I', 'Summer II', 'Fall', 'Winter', 'Spring');
$semester_year = array('2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020');
?>
<!-- ARTICLE REQUEST #1 STARTS HERE -->

<table width="100%" style="text-align:left" border="0" cellpadding="3">
  <tr>
    <td colspan="5" bgcolor="#990000" align="center" style="border:solid #646464 1px"><span style="color:#FFFFFF; font-size:13px"><strong>ARTICLE REQUEST #1</strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="5" align="center"><span style="color:#ffffff; font-size:13px"><strong>Course Information</strong></span> </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td width="25%" align="center"><strong><span class="style2">Semester *</span></strong>
      <select name="semester1" size="1">
        <?php
 foreach($semester as $row)
 {
 	if ($row==$_POST['semester1'])
	{
		echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';
	}	
	else
	{
		echo '<option value="'. $row . '">'. $row . '</option>';
	}
  }		
?>
      </select>
      <select name="semester_year1" size="1">
        <?php
 foreach($semester_year as $row)
 {
 	if ($row==$_POST['semester_year1'])
	{
		echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';
	}	
	else
	{
		echo '<option value="'. $row . '">'. $row . '</option>';
	}
  }		
?>
      </select>
    </td>
    <td width="30%" align="center"><strong>Course Title</strong>
      <input name="course_title1" type="text" size="20" value="<?php if(isset($_POST['course_title1'])){echo $_POST['course_title1'];}?>" />
    </td>
    <td width="25%" align="center"><strong><span class="style2">Course Number *</span></strong>
      <input name="course_no1" type="text" size="10" value="<?php if(isset($_POST['course_no1'])){echo $_POST['course_no1'];}?>" />
    </td>
    <td align="center" colspan="2"><strong>Loan Period</strong>
      <input type="radio" name="loan_period1" value="2 hrs" id="RadioGroup1_0" />
      2 hrs
      <input type="radio" name="loan_period1" value="1 day " id="RadioGroup1_1" />
      1 day </td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="5" align="center"><span style="color:#ffffff; font-size:13px"><strong>Article Information</strong></span></td>
  </tr>
  <tr>
    <td align="center" valign="top"> <strong><span class="style2">Journal Title *</span></strong><br />
      <span class="style1">Please do not abbreviate unless your citation is abbreviated</span><br />
      <input name="j_title1" type="text" size="40" value="<?php if(isset($_POST['j_title1'])){echo $_POST['j_title1'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong><span class="style2">Volume *</span></strong><br />
      <input name="j_volume1" type="text" size="30" value="<?php if(isset($_POST['j_volume1'])){echo $_POST['j_volume1'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>Issue</strong><br />
      <input name="j_issue1" type="text" size="21" value="<?php if(isset($_POST['j_issue1'])){echo $_POST['j_issue1'];}?>" />
    </td>
    <td width="15%" align="center" valign="bottom"> <strong>Month</strong><br />
      <input name="j_month1" type="text" size="20" value="<?php if(isset($_POST['j_month1'])){echo $_POST['j_month1'];}?>" />
    </td>
    <td width="10%" align="center" valign="bottom"> <strong><span class="style2">Year *</span></strong><br />
      <input name="j_year1" type="text" size="10" value="<?php if(isset($_POST['j_year1'])){echo $_POST['j_year1'];}?>" />
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td align="center" valign="bottom"> <strong><span class="style2">Article Title *</span></strong><br />
      <input name="a_title1" type="text" size="40" value="<?php if(isset($_POST['a_title1'])){echo $_POST['a_title1'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong><span class="style2">Author(s) *</span></strong><br />
      <span class="style1">(Last Name, First Name)</span><br />
      <input name="a_author1" type="text" size="30" value="<?php if(isset($_POST['a_author1'])){echo $_POST['a_author1'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong><span class="style2">Inclusive Pages *</span></strong><br />
      <input name="a_incl_pages1" type="text" size="20" value="<?php if(isset($_POST['a_incl_pages1'])){echo $_POST['a_incl_pages1'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>ISSN</strong><br />
      <input name="a_issn1" type="text" size="20" value="<?php if(isset($_POST['a_issn1'])){echo $_POST['a_issn1'];}?>" />
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="5" align="center"><span style="color:#ffffff; font-size:13px"><strong>Additional Information</strong></span></td>
  </tr>
  <tr>
    <td valign="top"><strong>How will this item be supplied?</strong><br />
    </td>
    <td colspan="4">
      <label>
      <input type="radio" name="a_supply_method1" value="Pull Off Shelf" id="RadioGroup1_1" checked="checked"/>
      Please have library staff pull the material off the shelves<br />
      </label>
      <label>
      <input type="radio" name="a_supply_method1" value="Will Upload a File" id="RadioGroup1_1" />
      I will upload a file. NOTE: Scanned copyright notice and title page from original required<br />
      </label>
      <label>
      <input type="radio" name="a_supply_method1" value="Will Bring to Library" id="RadioGroup1_1" />
      I will bring the material to Priddy Library<br />
      </label>
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td> <strong>Notes:</strong><br />
      <span class="style1">Put any information here that may help us find the item, as well as any other pertinent information. </span> </td>
    <td colspan="4">
      <textarea name="a_notes1" cols="80" rows="2"><?php if(isset($_POST['a_notes1'])){echo $_POST['a_notes1'];}?>
</textarea>
    </td>
  </tr>
</table>
<!-- ARTICLE REQUEST #1 ENDS HERE -->
<!-- ARTICLE REQUEST #2 STARTS HERE -->
<table width="100%" style="text-align:left" border="0" cellpadding="3">
  <tr>
    <td colspan="5" bgcolor="#990000" align="center" style="border:solid #646464 1px"><span style="color:#FFFFFF; font-size:13px"><strong>ARTICLE REQUEST #2</strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="5" align="center"><span style="color:#ffffff; font-size:13px"><strong>Course Information</strong></span> </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td width="25%" align="center"><strong><span class="style2">Semester *</span></strong>
      <select name="semester2" size="1">
        <?php
 foreach($semester as $row)
 {
 	if ($row==$_POST['semester2'])
	{
		echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';
	}	
	else
	{
		echo '<option value="'. $row . '">'. $row . '</option>';
	}
  }		
?>
      </select>
      <select name="semester_year2" size="1">
        <?php
 foreach($semester_year as $row)
 {
 	if ($row==$_POST['semester_year2'])
	{
		echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';
	}	
	else
	{
		echo '<option value="'. $row . '">'. $row . '</option>';
	}
  }		
?>
      </select>
    </td>
    <td width="30%" align="center"><strong>Course Title</strong>
      <input name="course_title2" type="text" size="20" value="<?php if(isset($_POST['course_title2'])){echo $_POST['course_title2'];}?>" />
    </td>
    <td width="25%" align="center"><strong><span class="style2">Course Number *</span></strong>
      <input name="course_no2" type="text" size="10" value="<?php if(isset($_POST['course_no2'])){echo $_POST['course_no2'];}?>" />
    </td>
    <td align="center" colspan="2"><strong>Loan Period</strong>
      <input type="radio" name="loan_period2" value="2 hrs" id="RadioGroup1_0" />
      2 hrs
      <input type="radio" name="loan_period2" value="1 day " id="RadioGroup1_1" />
      1 day </td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="5" align="center"><span style="color:#ffffff; font-size:13px"><strong>Article Information</strong></span></td>
  </tr>
  <tr>
    <td align="center" valign="top"> <strong><span class="style2">Journal Title *</span></strong><br />
      <span class="style1">Please do not abbreviate unless your citation is abbreviated</span><br />
      <input name="j_title2" type="text" size="40" value="<?php if(isset($_POST['j_title2'])){echo $_POST['j_title2'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong><span class="style2">Volume *</span></strong><br />
      <input name="j_volume2" type="text" size="30" value="<?php if(isset($_POST['j_volume2'])){echo $_POST['j_volume2'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>Issue</strong><br />
      <input name="j_issue2" type="text" size="21" value="<?php if(isset($_POST['j_issue2'])){echo $_POST['j_issue2'];}?>" />
    </td>
    <td width="15%" align="center" valign="bottom"> <strong>Month</strong><br />
      <input name="j_month2" type="text" size="20" value="<?php if(isset($_POST['j_month2'])){echo $_POST['j_month2'];}?>" />
    </td>
    <td width="10%" align="center" valign="bottom"> <strong><span class="style2">Year *</span></strong><br />
      <input name="j_year2" type="text" size="10" value="<?php if(isset($_POST['j_year2'])){echo $_POST['j_year2'];}?>" />
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td align="center" valign="bottom"> <strong><span class="style2">Article Title *</span></strong><br />
      <input name="a_title2" type="text" size="40" value="<?php if(isset($_POST['a_title2'])){echo $_POST['a_title2'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong><span class="style2">Author(s) *</span></strong><br />
      <span class="style1">(Last Name, First Name)</span><br />
      <input name="a_author2" type="text" size="30" value="<?php if(isset($_POST['a_author2'])){echo $_POST['a_author2'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong><span class="style2">Inclusive Pages *</span></strong><br />
      <input name="a_incl_pages2" type="text" size="20" value="<?php if(isset($_POST['a_incl_pages2'])){echo $_POST['a_incl_pages2'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>ISSN</strong><br />
      <input name="a_issn2" type="text" size="20" value="<?php if(isset($_POST['a_issn2'])){echo $_POST['a_issn2'];}?>" />
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="5" align="center"><span style="color:#ffffff; font-size:13px"><strong>Additional Information</strong></span></td>
  </tr>
  <tr>
    <td valign="top"><strong>How will this item be supplied?</strong><br />
    </td>
    <td colspan="4">
      <label>
      <input type="radio" name="a_supply_method2" value="Pull Off Shelf" id="RadioGroup1_1" checked="checked"/>
      Please have library staff pull the material off the shelves<br />
      </label>
      <label>
      <input type="radio" name="a_supply_method2" value="Will Upload a File" id="RadioGroup1_1" />
      I will upload a file. NOTE: Scanned copyright notice and title page from original required<br />
      </label>
      <label>
      <input type="radio" name="a_supply_method2" value="Will Bring to Library" id="RadioGroup1_1" />
      I will bring the material to Priddy Library<br />
      </label>
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td> <strong>Notes:</strong><br />
      <span class="style1">Put any information here that may help us find the item, as well as any other pertinent information. </span> </td>
    <td colspan="4">
      <textarea name="a_notes2" cols="80" rows="2"><?php if(isset($_POST['a_notes2'])){echo $_POST['a_notes2'];}?>
</textarea>
    </td>
  </tr>
</table>
<!-- ARTICLE REQUEST #2 ENDS HERE -->
<!-- ARTICLE REQUEST #3 STARTS HERE -->
<table width="100%" style="text-align:left" border="0" cellpadding="3">
  <tr>
    <td colspan="5" bgcolor="#990000" align="center" style="border:solid #646464 1px"><span style="color:#FFFFFF; font-size:13px"><strong>ARTICLE REQUEST #3</strong></span></td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="5" align="center"><span style="color:#ffffff; font-size:13px"><strong>Course Information</strong></span> </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td width="25%" align="center"><strong><span class="style2">Semester *</span></strong>
      <select name="semester3" size="1">
        <?php
 foreach($semester as $row)
 {
 	if ($row==$_POST['semester3'])
	{
		echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';
	}	
	else
	{
		echo '<option value="'. $row . '">'. $row . '</option>';
	}
  }		
?>
      </select>
      <select name="semester_year3" size="1">
        <?php
 foreach($semester_year as $row)
 {
 	if ($row==$_POST['semester_year3'])
	{
		echo '<option value="'. $row . '" selected="selected">'. $row . '</option>';
	}	
	else
	{
		echo '<option value="'. $row . '">'. $row . '</option>';
	}
  }		
?>
      </select>
    </td>
    <td width="30%" align="center"><strong>Course Title</strong>
      <input name="course_title3" type="text" size="20" value="<?php if(isset($_POST['course_title3'])){echo $_POST['course_title3'];}?>" />
    </td>
    <td width="25%" align="center"><strong><span class="style2">Course Number *</span></strong>
      <input name="course_no3" type="text" size="10" value="<?php if(isset($_POST['course_no3'])){echo $_POST['course_no3'];}?>" />
    </td>
    <td align="center" colspan="2"><strong>Loan Period</strong>
      <input type="radio" name="loan_period3" value="2 hrs" id="RadioGroup1_0" />
      2 hrs
      <input type="radio" name="loan_period3" value="1 day " id="RadioGroup1_1" />
      1 day </td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="5" align="center"><span style="color:#ffffff; font-size:13px"><strong>Article Information</strong></span></td>
  </tr>
  <tr>
    <td align="center" valign="top"> <strong><span class="style2">Journal Title *</span></strong><br />
      <span class="style1">Please do not abbreviate unless your citation is abbreviated</span><br />
      <input name="j_title3" type="text" size="40" value="<?php if(isset($_POST['j_title3'])){echo $_POST['j_title3'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong><span class="style2">Volume *</span></strong><br />
      <input name="j_volume3" type="text" size="30" value="<?php if(isset($_POST['j_volume3'])){echo $_POST['j_volume3'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>Issue</strong><br />
      <input name="j_issue3" type="text" size="21" value="<?php if(isset($_POST['j_issue3'])){echo $_POST['j_issue3'];}?>" />
    </td>
    <td width="15%" align="center" valign="bottom"> <strong>Month</strong><br />
      <input name="j_month3" type="text" size="20" value="<?php if(isset($_POST['j_month3'])){echo $_POST['j_month3'];}?>" />
    </td>
    <td width="10%" align="center" valign="bottom"> <strong><span class="style2">Year *</span></strong><br />
      <input name="j_year3" type="text" size="10" value="<?php if(isset($_POST['j_year3'])){echo $_POST['j_year3'];}?>" />
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td align="center" valign="bottom"> <strong><span class="style2">Article Title *</span></strong><br />
      <input name="a_title3" type="text" size="40" value="<?php if(isset($_POST['a_title3'])){echo $_POST['a_title3'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong><span class="style2">Author(s) *</span></strong><br />
      <span class="style1">(Last Name, First Name)</span><br />
      <input name="a_author3" type="text" size="30" value="<?php if(isset($_POST['a_author3'])){echo $_POST['a_author3'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong><span class="style2">Inclusive Pages *</span></strong><br />
      <input name="a_incl_pages3" type="text" size="20" value="<?php if(isset($_POST['a_incl_pages3'])){echo $_POST['a_incl_pages3'];}?>" />
    </td>
    <td align="center" valign="bottom"> <strong>ISSN</strong><br />
      <input name="a_issn3" type="text" size="20" value="<?php if(isset($_POST['a_issn3'])){echo $_POST['a_issn3'];}?>" />
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#cccccc" colspan="5" align="center"><span style="color:#ffffff; font-size:13px"><strong>Additional Information</strong></span></td>
  </tr>
  <tr>
    <td valign="top"><strong>How will this item be supplied?</strong><br />
    </td>
    <td colspan="4">
      <label>
      <input type="radio" name="a_supply_method3" value="Pull Off Shelf" id="RadioGroup1_1" checked="checked"/>
      Please have library staff pull the material off the shelves<br />
      </label>
      <label>
      <input type="radio" name="a_supply_method3" value="Will Upload a File" id="RadioGroup1_1" />
      I will upload a file. NOTE: Scanned copyright notice and title page from original required<br />
      </label>
      <label>
      <input type="radio" name="a_supply_method3" value="Will Bring to Library" id="RadioGroup1_1" />
      I will bring the material to Priddy Library<br />
      </label>
    </td>
  </tr>
  <tr bgcolor="#ffffdd">
    <td> <strong>Notes:</strong><br />
      <span class="style1">Put any information here that may help us find the item, as well as any other pertinent information. </span> </td>
    <td colspan="4">
      <textarea name="a_notes3" cols="80" rows="2"><?php if(isset($_POST['a_notes3'])){echo $_POST['a_notes3'];}?>
</textarea>
    </td>
  </tr>
</table>
<!-- ARTICLE REQUEST #3 STARTS HERE -->
