<?php
/***********USE TO GET SITE URL AND RUN QUERY IN FILES(not used in this file)**********/

$blogheader = explode("wp-content",$_SERVER["SCRIPT_FILENAME"]);
include $blogheader[0]."wp-blog-header.php";
global $wpdb;
$site_uri = get_settings('siteurl');


// ?lf_form_id="+formvalue+"&cf7_id=" + $cf7_id ;	
$action = $_GET['action'];
$lf_form_id = $_GET['lf_form_id'];
$cf7_id = $_GET['cf7_id'];
$use_lf_form = $_GET['use_lf_form'];

$table_name = $wpdb->prefix . "loopfuse_forms";

if($cf7_id == '')
	echo "No id specified!";
else {
	switch($action) 
	{
		case "removeLoopFuseForm":
			$update_qry = "update $table_name set cf7_id = '0', use_lf_form='0' WHERE cf7_id = '$cf7_id'";
			$result = $wpdb->query($update_qry);
			echo "LoopFuse form has been dettached from this CF7 form.";
			break;
		case "disableLoopFuseForm":
			$update_qry = "update $table_name set use_lf_form='0' WHERE cf7_id = '$cf7_id'";
			$result = $wpdb->query($update_qry);
			echo "LoopFuse form has been disabled for this CF7 form. However, it is still attached.";
			break;
		case "getSelectedForm":
			$select_qry = "select formName, id from $table_name WHERE cf7_id='$cf7_id'";
			$result = $wpdb->get_row($select_qry);
		break;
		
		case "forceAttach":
			$update_qry = "update $table_name set cf7_id='0', use_lf_form='0' WHERE cf7_id = '$cf7_id'";
			$result = $wpdb->query($update_qry);
			$update_qry = "update $table_name set cf7_id='$cf7_id', use_lf_form='$use_lf_form' WHERE id = $lf_form_id";
			$result = $wpdb->query($update_qry);
			$select_qry = "select formName from $table_name WHERE cf7_id='$cf7_id'";
			$result = $wpdb->get_var($select_qry);
			$but = "";
			if($use_lf_form == 0)
				$but = " but the usage is disabled";
			echo " LoopFuse form '" . $result . "' is now attached with this CF7 form$but.";
		break;		
		case "setFormsCF7":
			$select_qry = "select formName, cf7_id from $table_name WHERE id='$lf_form_id'";			
			$row = $wpdb->get_row($select_qry);
			if($row->cf7_id == '0' || $row->cf7_id == $cf7_id) 
			{
				$update_qry = "update $table_name set cf7_id='0', use_lf_form='0' WHERE cf7_id = '$cf7_id'";
				$result = $wpdb->query($update_qry);
				$update_qry = "update $table_name set cf7_id='$cf7_id', use_lf_form='$use_lf_form' WHERE id = $lf_form_id";
				$result = $wpdb->query($update_qry);
				$select_qry = "select formName from $table_name WHERE cf7_id='$cf7_id'";
				$result = $wpdb->get_var($select_qry);
				$but = "";
				if($use_lf_form == 0)
					$but = " but the usage is disabled";
				echo "LoopFuse form '" . $result . "' is now attached with this CF7 form$but.";
			}
			else
			{
				echo "The selected LoopFuse form '$row->formName' is already attached with another CF7 form. You can not use one LoopFuse form with multiple CF7 forms. However, you can remove the other CF7 form and attached this. <a href='javascript:void(0);' onclick='ForceAttach();' class='button-primary'>Click here</a> to force attachment.";
			}
			
		break;
		default:
			echo "no-action";
			break;
	}
}
/*
$query = "update $table_name set status='1' where id='".$id."'";
$results = $wpdb->query($query);
*/

?>