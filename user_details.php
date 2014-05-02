<!-- 
Created by: Siddharth Choksi in May 2010
Displays the Instructor Information form elements in the forms. 
-->
<?php
$universities = array('Please select one', 'Bowie State University', 'Salisbury University', 'Towson University', 'University of Baltimore', 'University of Maryland, Baltimore', 'University of Maryland, Baltimore County', 'University of Maryland, College Park',  'University of Maryland, Eastern Shore', 'University of Maryland, University College', 'Other');
?>

<table width="100%" style="text-align:left" border="0" cellpadding="3" >
  <tr>
    <td colspan="4" bgcolor="#990000" align="center" style="border:solid #646464 1px"><span style="color:#FFFFFF; font-size:13px"><strong>INSTRUCTOR INFORMATION</strong></span></td>
  </tr>
  <tr>
    <td><strong><span class="style2">Last Name *</span></strong></td>
    <td>
      <input name="p_last_name" type="text" id="last_name" size="30" value="<?php if(isset($_POST['p_last_name'])){echo $_POST['p_last_name'];}?>" />
    </td>
    <td><strong class="style2">First Name *</strong></td>
    <td>
      <input name="p_first_name" type="text" id="first_name" size="30" value="<?php if(isset($_POST['p_first_name'])){echo $_POST['p_first_name'];}?>"  />
    </td>
  </tr>
  <tr>
    <td><strong><span class="style2">Email *</span></strong></td>
    <td>
      <input name="p_email" type="text" id="last_name" size="30" value="<?php if(isset($_POST['p_email'])){echo $_POST['p_email'];}?>"  />
    </td>
    <td><strong>Phone Number</strong><br /> <span class="style1">(Format: XXXXXXXXXX, XXX-XXX-XXXX)</span></td>
    <td>
      <input name="p_phone_number" type="text" id="first_name" size="30" value="<?php if(isset($_POST['p_phone_number'])){echo $_POST['p_phone_number'];}?>"  />
    </td>
  </tr>
  <tr>
    <td><strong><span class="style2">USM University *</span></strong></td>
    <td colspan="3">
      <select name="p_university">
        <?php
 foreach($universities as $row)
 {
 	if ($row==$_POST['p_university'])
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
  </tr>
</table>
