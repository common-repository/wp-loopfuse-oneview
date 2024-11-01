<?php
//Database variable 
global $wpdb;
$site_uri = get_settings('siteurl');
?>
<!--javascript Files Included -->
<script language="javascript" type="text/javascript" src="<?php echo bloginfo('siteurl');  ?>/wp-content/plugins/contact_form7/js/validate.js" ></script>
<!--javascript Files Included -->

<script>
function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to delete")) {
    document.location = delUrl;
  }
}
</script>

<?php 
// Get the values passed from the task placed in form action
 $task = $_REQUEST["task"];
 $id   = $_REQUEST["id"];  
 $eid  = $_REQUEST["eid"]; 
 $nid  = $_REQUEST["nid"]; 
 
 // The switch cases of functions
 switch($task)
   {

	   case 'insertCUSTval':
		  		insertcustID();
			   echo "<strong style='color:red;'>The Customer Id Has Been Added/Updated Successfully</strong>";
			   addform();
		     break;

	   case 'insertFormval':
			insertvalue();
			echo "<strong style='color:red;'>The Form Has Been Added Successfully</strong>";
			addform();

	   break;
       case 'editFormval':
	        editform();
		
			//editValue();
	   break;
	   case 'deleteFormval':
	        deleteform();
			echo "<strong style='color:red;'>The Entry Has Been Deleted Successfully</strong>";
			addform();
			//editValue();
	   break;	   	   
	   default:
	        addform();
	   break;
  }
  
  
  
  
  
  
  

function addform(){ 	  
?>	
<style type="text/css">
.button { background-color:#CCCCCC;}
.trackheader { font-family:Arial, Helvetica, sans-serif; font-size:15px; margin-top:12px; }
.dot {float:right;}
#forspace {height: 40px;}
</style>
<title>alternate iedit</title><fieldset class="trackheader">	
<legend style="margin-top:14px;"><strong>Tracking Beacon Configuration</strong></legend>

<form method="post" name="cust" id="cust">
<table class="widefat" width="100%" style="border:1px solid #CCCCCC;" cellpadding="0" cellspacing="0">
   <tr class="alternate iedit">
		  <td style="padding-left:4px;" colspan="2">
		  <strong> LoopFuse Customer ID: </strong><span class="dot"></span>

			  <?php 
				global $wpdb;
			        $table_loopfuse_cid = $wpdb->prefix . "loopfuse_cid";
			  		$selectValue = "SELECT cid from $table_loopfuse_cid WHERE id = '1' ";
					$lf_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
					$lf_help = 'customer-id.png';
					$resultValue = $wpdb->get_results($selectValue);
					$c_id =	$resultValue[0]->cid;
					
			  ?>
			  
			   <input type="text" name="loopfuse" id="loopfuse" value="<?php echo $c_id ?>" size="40" />

		  </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			
	</tr>
	<tr >
		    <td style="padding-left:4px;" colspan="5">
              <div id="explanation" style="background: #fff; border: 1px solid #ccc; padding: 5px;">
				<strong>Explanation</strong><br/>
				Find the Customer ID, starting with LF_ under "Help -> About" within your account:<br/>
				<br/>
                   <?php echo ('<img src="'.$lf_path.'images/'.$lf_help.'" alt="Customer ID"/> '); ?>
				<br/>
				Once you have entered your Customer ID in the box above, your pages will be trackable by LoopFuse OneView.<br/>
			  </div>		  
		    </td>
	</tr>
	<tr class="alternate iedit">
		  <td style="padding-left:4px;">
		   <input type="submit" name="submitid" value="Update LoopFuse OneView Customer ID &raquo;" class="button-primary"  />
		   <input type="hidden" name="task" value="insertCUSTval"/>
		  </td>
		    <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
	</tr>			
</table>
</form>
</fieldset>
<fieldset class="trackheader">	
<legend style="margin-top:14px;"><strong>List Of OneView Forms</strong></legend>
<div style="font-size:10px;">These forms use the "<a href="http://wordpress.org/extend/plugins/contact-form-7/" target="_blank">Contact Form 7</a>" plugin as a dependency. 
Please install that plugin for this forms integration to function properly.
<table  id="all-plugins-table" class="widefat" width="80%" style="border:1px solid #CCCCCC;" cellpadding="0" cellspacing="0">
 	<thead>
 	 <tr>
		<th id="" class="manage-column" bgcolor="#D9D9D9" style="padding-left:4px;" ><strong>Name</strong></th>
		<th class="manage-column" bgcolor="#D9D9D9"><strong>FormID</strong></th>
		<th class="manage-column" bgcolor="#D9D9D9"><strong>Form Action</strong></th>
		<th class="manage-column" bgcolor="#D9D9D9"><strong>CF7 Form</strong></th>
		<th class="manage-column" bgcolor="#D9D9D9"><strong>Edit</strong></th>
		<th class="manage-column" bgcolor="#D9D9D9"><strong>Delete</strong></th>
	 </tr>
	</thead>
<?php 
global $wpdb;
# variable for calling database 
$table_name = $wpdb->prefix . "loopfuse_forms";
$cf7_table = $wpdb->prefix . "contact_form_7";

$site_uri = get_settings('siteurl');
$src= $site_uri.'/wp-content/plugins/contact_form7/';
// This variable is fetchiing the data from the table 

$get_forms_sql = "
SELECT lf.*, cf7.title cf7_title FROM $table_name lf 
left outer  join 
	$cf7_table cf7
on 
	lf.cf7_id = cf7.cf7_unit_id
";
$lf_forms = $wpdb->get_results($get_forms_sql);

$edit_id = $_REQUEST['id'];
$edit_form = '';

foreach($lf_forms as $lf_form) 
{
	if($edit_id == $lf_form->id)
		$edit_form = $lf_form;
		
?>
	<tbody>
	<tr class="alternate iedit">
		<td style="padding-left:4px;"><?php echo $lf_form->formName; ?></td>
		<td><?php echo $lf_form->formId; ?></td>
		<td><?php echo $lf_form->formAction; ?></td>
		<td><?php echo $lf_form->cf7_title; ?></td>
		<td><a href="?page=loopfuse.php&task=editFormval&id=<?php echo $lf_form->id; ?>">Edit</a></td>
		<td><a href="javascript:confirmDelete('?page=loopfuse.php&task=deleteFormval&id=<?php echo $lf_form->id; ?>')">Delete</a></td>
	</tr>
	</tbody>			 
<?php 	

}
?>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</fieldset>

<fieldset class="trackheader">	
<legend style="margin-top:14px;"><strong>Add New Form</strong></legend>
    <form method="post" name="addnew" onSubmit="return validateData();" id="addnew">
	  <table id="all-plugins-table" class="widefat" width="60%">
		<tr class="alternate iedit">
		  <td>
		   <strong>Name Of The Form</strong><span class="dot">:</span>
		  </td>
		  <td>
		      <input type="text" name="formname" id="formname" size="40" />    
		  </td>
		</tr>
		<tr >
		  <td>
		   <strong>Form ID</strong><span class="dot">:</span>
		  </td>
		  <td>
		      <input type="text" name="formid" id="formid" size="40" />    
		  </td>
		</tr>
		<tr class="alternate iedit">
		  <td class="manage-column">
		   <strong>Form Action</strong><span class="dot">:</span>
		  </td>
		  <td>
		      <input type="text" name="formaction" id="formaction" size="40" /> <span style="color:#999999">Example : http://lfov.net/webrecorder/f</span>
			  
		  </td>
		</tr>
		<tr>
		  <td>&nbsp;
		  
		  </td>
		  <td>
			  <input type="submit" name="submit" value="Save Form Details &raquo;" class="button-primary" />
			  <input type="hidden" name="task" value="insertFormval"/>
		  </td>
		</tr>
	  </table>
	</form>
</fieldset>
   <div id="forspace"></div>
<?php	 
	 # form structure ends here 	
}









function editform()
{
global $wpdb;
# Variable for displaying the table name 
$table_name = $wpdb->prefix . "loopfuse_forms";
# Getting form inputted variables  
	$table_loopfuse_cid = $wpdb->prefix . "loopfuse_cid";
	$selectValue1 = "SELECT cid from $table_loopfuse_cid WHERE id = '1' ";
	$resultValue1 = $wpdb->get_results($selectValue1);
	$c_id1 =	$resultValue1[0]->cid;

$selectValue = "SELECT * from $table_name WHERE id = '".$_GET['id']."'"; 
$resultValue = mysql_query($selectValue);
$finalValue = mysql_fetch_assoc($resultValue);	  



if (isset($_REQUEST['submit']))
	{
		 $updateval = "UPDATE $table_name SET 
							formName = 		'".$_REQUEST['formname']."', 
							formId = 		'".$_REQUEST['formid']."', 
							formAction = 	'".$_REQUEST['formaction']."' 
							WHERE id=		 ".$_GET['id']."";
		
		
		$resultVal = mysql_query($updateval);
		
		?>
		<script type="text/javascript">

			window.location.href = "<?php echo bloginfo('url'); ?>/wp-admin/admin.php?page=loopfuse.php";
			</script>
		<?php
	
	}
?>	
<fieldset class="trackheader">	
<legend style="margin-top:14px;"><strong>Tracking Beacon Configuration</strong></legend>
<table class="widefat" width="87%" style="border:1px solid #CCCCCC;" cellpadding="0" cellspacing="0">
   <tr class="alternate iedit">
		  <td style="padding-left:4px;">
		   <strong>Please enter Your LoopFuse OneView Customer ID</strong><span class="dot"></span>
		  </td>
		    <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
	</tr>
	<tr>
		  <td style="padding-left:4px;">
			  
		   <input type="text" name="loopfuse" id="loopfuse" value="<?php echo $c_id1 ?>" size="40" />
		 	 </td>
		    <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
	</tr>
	<tr class="alternate iedit">
		  <td style="padding-left:4px;">
		   <input type="submit" name="submit" value="Update Customer ID" class="button"/>
		   <input type="hidden" name="task" value="insertFormval"/>
		  </td>
		    <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
	</tr>			
</table>
</fieldset>
<fieldset class="loopfuse_formsheader">	
<legend style="margin-top:14px;"><strong>List Of OneView Forms</strong></legend>
<form name="" id="edit" method="post">
<table id="all-plugins-table" class="widefat" width="80%" style="border:1px solid #CCCCCC;" cellpadding="0" cellspacing="0">
  <thead>
 	 <tr>
		<th id="" class="manage-column" bgcolor="#D9D9D9" style="padding-left:4px;" ><strong>Name</strong></th>
		<th class="manage-column" bgcolor="#D9D9D9"><strong>FormID</strong></th>
		<th class="manage-column" bgcolor="#D9D9D9"><strong>Form Action</strong></th>
		<th class="manage-column" bgcolor="#D9D9D9"><strong>CF7 Form</strong></th>
		<th class="manage-column" bgcolor="#D9D9D9"><strong>Edit</strong></th>
		<th class="manage-column" bgcolor="#D9D9D9"><strong>Delete</strong></th>
	 </tr>
	</thead>
<?php 
global $wpdb;
# variable for calling database 
$table_name = $wpdb->prefix . "loopfuse_forms";
$cf7_table = $wpdb->prefix . "contact_form_7";

$site_uri = get_settings('siteurl');
$src= $site_uri.'/wp-content/plugins/contact_form7/';
// This variable is fetchiing the data from the table 

$get_forms_sql = "
SELECT lf.*, cf7.title cf7_title FROM $table_name lf 
left outer  join 
	$cf7_table cf7
on 
	lf.cf7_id = cf7.cf7_unit_id
";
$lf_forms = $wpdb->get_results($get_forms_sql);

$edit_id = $_REQUEST['id'];
$edit_form = '';

foreach($lf_forms as $lf_form) 
{
	if($edit_id == $lf_form->id)
		$edit_form = $lf_form;
		
?>
	<tbody>
	<tr class="alternate iedit">
		<td style="padding-left:4px;"><?php echo $lf_form->formName; ?></td>
		<td><?php echo $lf_form->formId; ?></td>
		<td><?php echo $lf_form->formAction; ?></td>
		<td><?php echo $lf_form->cf7_title; ?></td>
		<td><a href="?page=loopfuse.php&task=editFormval&id=<?php echo $lf_form->id; ?>">Edit</a></td>
		<td><a href="javascript:confirmDelete('?page=loopfuse.php&task=deleteFormval&id=<?php echo $lf_form->id; ?>')">Delete</a></td>
	</tr>
	</tbody>			 
<?php 	

}
?>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</fieldset>

   <div style="margin-top:10px;"><strong>Edit Form</strong></div>
    <form method="post" name="addnew" onSubmit="return validateData();">
	  <table id="all-plugins-table" class="widefat"width="60%">
		<tr class="alternate iedit">
		  <td>
		  <strong> Name Of The Form</strong><span class="dot">:</span>
		  </td>
		  <td>
		      <input type="text" name="formname" id="formname" value="<?php echo $edit_form->formName; ?>" size="40" />    
		  </td>
		</tr>
		<tr>
		  <td>
		   <strong>Form ID</strong><span class="dot">:</span>
		  </td>
		  <td>
		      <input type="text" name="formid" id="formid" value="<?php echo $edit_form->formId; ?>" size="40" />    
		  </td>
		</tr>
		<tr class="alternate iedit">
		  <td>
		  <strong> Form Action</strong><span class="dot">:</span>
		  </td>
		  <td>
		      <input type="text" name="formaction" id="formaction" value="<?php echo $edit_form->formAction; ?>" size="40" />    
		  </td>
		</tr>
		<tr>
		  <td>&nbsp;
		  
		  </td>
		  <td>
			  <input type="submit" name="submit" value="Save" class="button"/>
			  <input type="hidden" name="task" value="editFormval"/>
		  </td>
		</tr>
	  </table>
	</form>

   <div id="forspace"></div>
<?php	 
	 # form structure ends here 	
}



function insertcustID() {
	global $wpdb;
	$table_options = $wpdb->prefix . "options";
	$table_loopfuse_cid = $wpdb->prefix . "loopfuse_cid";
	$cat_id = $_REQUEST['loopfuse'];


    $conditional = "SELECT * FROM ".$table_loopfuse_cid." ";
	$conditional_results = $wpdb->query($conditional);
	//print_r($conditional_results);
	if($conditional_results == ''){

	$insert = 	"INSERT INTO ".$table_loopfuse_cid.
				"(cid)".
				"VALUES ('".$cat_id."')"; 
	$results = $wpdb->query($insert);

			
		      
		  		$selectValue = "SELECT cid from $table_loopfuse_cid WHERE id = '1' ";
				$resultValue = $wpdb->get_results($selectValue);
				$c_id =	$resultValue[0]->cid;
				

				  
   $insert_options = "INSERT INTO ".$table_options."(blog_id,option_name,option_value,autoload) VALUES (0,'lf_loopfuse_cid_id','$c_id','yes')"; 
   $results_options = $wpdb->query($insert_options);
	}else{

	$update = "Update ".$table_loopfuse_cid." SET cid='".$cat_id."' WHERE id='1'";				 
	$results = $wpdb->query($update);
	}
}




 // function for inserting values inside the table 
function insertvalue()
{
   global $wpdb;
   # Variable for displaying the table name 
   $table_name = $wpdb->prefix . "loopfuse_forms";
   # Getting form inputted variables  
   $formName    = stripslashes($_REQUEST['formname']);
   $formId      = stripslashes($_REQUEST['formid']);
   $formAction  = $_REQUEST['formaction'];
   
   if ($formAction == "") {
   	$formAction = " http://lfov.net/webrecorder/f";
   }
 
   # query for inserting values inside Table  wp_3dimageslider!
      $insert = "INSERT INTO ".$table_name.
                "(formName, formId, formAction)".
                "VALUES ('".$formName."','".$formId."','".$formAction."')";
     $results = $wpdb->query($insert);
}





function deleteform()
{
		global $wpdb;
		# Variable for displaying the table name 
		$table_name = $wpdb->prefix . "loopfuse_forms";
		# Getting form inputted variables  
		
		$selectValue = "SELECT * from $table_name WHERE id = '".$_GET['id']."'";
		$resultValue = mysql_query($selectValue);
		$finalValue = mysql_fetch_assoc($resultValue);	  
		if($_REQUEST['task'] == 'deleteFormval')
		{
		   $deleteval = "DELETE FROM $table_name WHERE id=".$_GET['id']."";
		   $resultVal = mysql_query($deleteval);

		}


}

?>