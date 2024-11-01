<?php
/*
 * Plugin Name: LoopFuse OneView
 * Plugin URI: https://help.loopfuse.com/View.jsp?procId=012c91fffaa15ec5324e5bccf84a38d6
 * Description: Lets you add the LoopFuse OneView tracking script to your Wordpress site. Also integrates with Contact Form 7 for Form submissions.
 * Version: 2.2
 * Author: LoopFuse, Kreative Mart - Shahbaz Hussain
 * Author URI: http://loopfuse.com
 * Copyright 2011 LoopFuse
*/
// error_reporting(0);
register_activation_hook(__FILE__,'install');

define( 'LF_VERSION', '0.99' );
if ( ! defined( 'LF_PLUGIN_BASENAME' ) )
	define( 'LF_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
	
if ( ! defined( 'LF_PLUGIN_NAME' ) )
	define( 'LF_PLUGIN_NAME', trim( dirname( LF_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'LF_PLUGIN_DIR' ) )
	define( 'LF_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . LF_PLUGIN_NAME );

	
add_action( 'wpcf7_admin_after_mail_2', 'wpcf7_cm_add_LOOPFUSE' );
//remove_shortcode('contact-form');
// add_shortcode( 'contact-form', 'wpcf7_contact_form_tag_func_loopfuse' );

function wpcf7_cm_add_LOOPFUSE($args)
{
	 $cf7_id = $args->id;
	
	 /*
	 $fh_class = fopen($LF_CLASS,'r');
	 $theData = fread($fh_class, filesize($LF_CLASS));
	 @fclose($fh_class);
	 $fw_class = @fopen($WPCF7_CLASS,'w');
	 @fwrite($fw_class, $theData);
	 @fclose($fw_class);

	 $fh = fopen($LF_CONTROLLER,'r');
	 $theData = fread($fh, filesize($LF_CONTROLLER));
	 @fclose($fh);
	 

	 $fw = @fopen($WPCF7_CONTROLLER,'w');
	 @fwrite($fw, $theData);
	 @fclose($fw);

	*/
	if ( wpcf7_admin_has_edit_cap() ) 
	{
				$cf7_cm_defaults = array();
				$cf7_cm = get_option( 'cf7_cm_'.$args->id, $cf7_cm_defaults );

				global $wpdb;
		        $table_name = $wpdb->prefix . "loopfuse_forms";
		  		$hasLFForm = "SELECT id FROM $table_name WHERE cf7_id = '$cf7_id'";
				$hasLFForm = $wpdb->get_var($hasLFForm);

				?>
<script type="text/javascript">
function check_box() {
	var checkboxvalue = document.getElementById('wpcf7-campaignmonitor-active').checked; 
	if(checkboxvalue==true) {
		document.getElementById('drop_down').style.display="block";
		document.getElementById('wpcf7-campaignmonitor-active').checked=true;
	} else {
		document.getElementById('drop_down').style.display="block";
		//document.getElementById('drop_down').style.display="none";	
	}
}
</script>
<script type="text/javascript" src="<?php echo bloginfo('url'); ?>/wp-content/plugins/wp-loopfuse-oneview/js/jsajax.js" /></script>

	<table class="widefat" style="margin-top: 1em;">
        <thead>
			<tr>
				<th colspan="2"><?php echo esc_html( __( 'LoopFuse Forms Integration', 'wpcf7' ) ); ?> <span id="campaignmonitor-fields-toggle-switch"></span></th>
			</tr>
		</thead>
		<tbody>
		<tr>
		<td>
			<div style="float:left; width: 250px;">
						<input type="checkbox" onchange="Lf_checked_data(this.checked);" id="wpcf7-campaignmonitor-active" name="wpcf7-campaignmonitor-active" onclick="check_box();" <?php echo $hasLFForm > 0 ? " checked": ""; ?>/>
						<label for="wpcf7-campaignmonitor-active"><?php echo esc_html( __( 'Attach LoopFuse Form', 'wpcf7' ) ); ?></label>
						
			</div>
			<div style="float:left; width: 200px;">
	<?php 
	
			global $wpdb;
			# variable for calling database 
			$table_name = $wpdb->prefix . "loopfuse_forms";
	
			$site_uri = get_settings('siteurl');
			// This variable is fetchiing the data from the table 
			
		# variable for calling database 
		$table_name = $wpdb->prefix . "loopfuse_forms";
		$get_forms = "SELECT * FROM $table_name";
		$lf_forms = $wpdb->get_results($get_forms);
		
		?>
		<div id="drop_down" style="display:<?php echo $hasLFForm > 0 ? "block": "none"; ?>;">   
		
		<select name="LFuse" id="LFuse" onChange="Lf_data();">
			<option value="0">-- No Form --</option>
			<?php
				foreach ($lf_forms as $lf_form) {
					echo "<option value='$lf_form->id' " . ($cf7_id == $lf_form->cf7_id ? "selected" : "" ) . ">$lf_form->formName</option>";
				}
			?>
		</select>
	
		 </div>
		<script>
			 function to_check_checkboxval()
			{
		
				var checkvalue = "<?php echo $flag; ?>";
				if(checkvalue=="true")
				{
				document.getElementById('wpcf7-campaignmonitor-active').checked="true";
				document.getElementById('drop_down').style.display="block";
		
				}
			}
			to_check_checkboxval();
		 </script>
		 <script type="text/javascript">
	  
			function Lf_data() {
				
				var formvalue	=   document.getElementById('LFuse').value;	
				var useLoopFuseForm = document.getElementById('wpcf7-campaignmonitor-active').checked;
				var url_contact = "<?php bloginfo('url'); ?>/wp-content/plugins/wp-loopfuse-oneview";
				url_contact=url_contact+"/ajaxupdatestatus.php";
				
				var action='setFormsCF7';
				if(formvalue == "0" || formvalue == 0)
					action='removeLoopFuseForm';
				url_contact=url_contact+"?use_lf_form="+(useLoopFuseForm ? 1 : 0 )+"&lf_form_id="+formvalue+"&cf7_id=" + "<?php echo $cf7_id ?>";	
				url_contact=url_contact+"&action="+action;
				var result_contact=url_contact;
				return get_response(result_contact,'contactowner_msg12');
			}
	
			function ForceAttach() {
				
				var formvalue =   document.getElementById('LFuse').value;	
				var useLoopFuseForm = document.getElementById('wpcf7-campaignmonitor-active').checked;
				
				var url_contact = "<?php bloginfo('url'); ?>/wp-content/plugins/wp-loopfuse-oneview";
				url_contact=url_contact+"/ajaxupdatestatus.php";
				var action='forceAttach';
				url_contact=url_contact+"?use_lf_form="+(useLoopFuseForm ? 1 : 0 )+"&lf_form_id="+formvalue+"&cf7_id=" + "<?php echo $cf7_id ?>";	
				url_contact=url_contact+"&action="+action;
				var result_contact=url_contact;
				return get_response(result_contact,'contactowner_msg12');
			}
			
			function Lf_checked_data() {
				var useLoopFuseForm = document.getElementById('wpcf7-campaignmonitor-active').checked;
				var formvalue	=   document.getElementById('LFuse').value;	

				if(formvalue == 0)
					return;


				var url_contact1 = "<?php bloginfo('url'); ?>/wp-content/plugins/wp-loopfuse-oneview";
				url_contact1=url_contact1+"/ajaxupdatestatus.php";
				
				var action1='setFormsCF7';
				
				if(!useLoopFuseForm) 
				{
					action1 = 'disableLoopFuseForm';
				}
	
				url_contact1=url_contact1+"?use_lf_form="+(useLoopFuseForm ? 1 : 0 )+"&lf_form_id="+formvalue+"&cf7_id=" + "<?php echo $cf7_id ?>";	
				url_contact1=url_contact1+"&action="+action1;
	
				var result_contact1=url_contact1;
				response = get_response(result_contact1,'contactowner_msg12');
				return response;
						
			}
			
			
			
	
		</script>
			</div>
			<div style="clear:both; height:auto;">
				<div style=" height:autho;">
							<div id="contactowner_msg12"></div>
				</div>
			</div>
				
	
			</td>
		</tr>
		</tbody>
	</table>
				<?php
	}
}


	
	global $wpdb;
	$table_loopfuse_cid = $wpdb->prefix . "loopfuse_cid";
	$selectValue1 = "SELECT cid from $table_loopfuse_cid WHERE id = '1' ";
	$lf_cid = $wpdb->get_var($selectValue1);

	if($lf_cid != '')
	{

/**
 * Code that actually inserts stuff into pages. - Attach to admin_footer. 
 */
		/* Insert the loopfuse_cid script into the page */
	function set_lfov_code() 
	{	
		global $wpdb;
		$table_loopfuse_cid = $wpdb->prefix . "loopfuse_cid";
		$selectValue1 = "SELECT cid from $table_loopfuse_cid WHERE id = '1' ";
		$lf_cid = $wpdb->get_var($selectValue1);

		//global $wp_query;					
		//$lfov_code  = get_option('lf_loopfuse_cid_id');
		
		if ( $lf_cid != "" ) 
		{ 
			echo "\n".'<!-- LoopFuse OneView for WordPress | http://loopfuse.com -->'."\n";
			echo '<script type="text/javascript">'."\n";
			echo 'var LFHost = (("https:" == document.location.protocol) ? "https://" : "http://");'."\n";
			echo 'document.write(unescape("%3Cscript src=\'" + LFHost + "lfov.net/webrecorder/js/listen.js\' type=\'text/javascript\'%3E%3C/script%3E"));'."\n";
			echo '</script>'."\n";
			echo '<script type="text/javascript">'."\n";
			echo '_lf_cid="'.$lf_cid.'";'."\n";
			echo '_lf_remora();'."\n";
			echo '</script>'."\n";
			echo '<!-- End of LoopFuse OneView code -->'."\n";
		} 
		else if ( $lf_cid == "") // && current_user_can('edit_users') ) 
		{
			echo "<!-- LoopFuse OneView tracking code not shown because you haven't entered your Customer ID yet. -->";
		}
	}
	add_action('get_footer', 'set_lfov_code', '25');
}

function install() {
   global $wpdb;

   $site_uri = get_settings('siteurl');
   $table_name = $wpdb->prefix . "loopfuse_forms";
   $table_loopfuse_cid = $wpdb->prefix . "loopfuse_cid";

	$wpdb->query("DROP TABLE IF EXISTS " . $table_loopfuse_cid);
    $sql = "
		CREATE TABLE " . $table_loopfuse_cid . " (
		  id int(10) NOT NULL AUTO_INCREMENT,
		  cid varchar(100) default NULL,
		  PRIMARY KEY  id (id)
		  );";
	$wpdb->query($sql);
	
	$wpdb->query("DROP TABLE IF EXISTS " . $table_name);
    $sql = "
			CREATE TABLE IF NOT EXISTS " . $table_name . " (
			  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
			  `formName` text NOT NULL,
			  `formId` varchar(255) NOT NULL,
			  `formAction` varchar(255) NOT NULL DEFAULT 'http://lfov.net/webrecorder/f',
			  `cf7_id` int(11) NOT NULL DEFAULT '0',
			  `use_lf_form` enum('1','0') NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) 
			";
	$wpdb->query($sql);
	install_files();
}

function install_files() 
{
	$LF_WPCF7_CLASS = LF_PLUGIN_DIR."/wpcf7_classes.php";
	$LF_WPCF7_CONTROLLER = LF_PLUGIN_DIR ."/wpcf7_controller.php";
	$LF_WPCF7_JQUERY_FORM = LF_PLUGIN_DIR."/wpcf7_jquery.form.js";

	$WPCF7_CLASS = WPCF7_PLUGIN_DIR ."/includes/classes.php";
	$WPCF7_CONTROLLER = WPCF7_PLUGIN_DIR."/includes/controller.php";
	$WPCF7_JQUERY_FORM = WPCF7_PLUGIN_DIR."/jquery.form.js";
	 
	$backup_folder = LF_PLUGIN_DIR ; // . "/wpcf7";
	
	/*
	if(!file_exists($backup_folder))
	{
		if (!mkdir($backup_folder, 0, true)) 
		{
			die ('Failed to create folders...');
		}
	}
	*/
	
	// else echo "dir already exists.";
	
	 if(file_exists($WPCF7_CLASS) && file_exists($WPCF7_CONTROLLER))
	 {
	 	 // take backup of wpcf7 files
		 
		 // copy classes.php
		 $backup_classes = $backup_folder . "/backup_classes.php" ;
		 // echo "WPCF7_CLASS:" . $WPCF7_CLASS . "<br>";
		 // echo "backup_classes:" . $backup_classes . "<br>";
		 $success = copy($WPCF7_CLASS, $backup_classes );

	 	 if($success == 1 )
		 {		 
		 	 $backup_controller = $backup_folder . "/backup_controller.php" ;
			 // echo "WPCF7_CONTROLLER:" . $WPCF7_CONTROLLER . "<br>";
			 // echo "backup_controller:" . $backup_controller . "<br>";
			 $success = copy($WPCF7_CONTROLLER, $backup_controller );
			  if($success == 1 )
			  {
			  		 
				 $backup_jquery_form = $backup_folder . "/backup_jquery.form.js" ;
				 // echo "WPCF7_JQUERY_FORM:" . $WPCF7_JQUERY_FORM . "<br>";
				 // echo "backup_jquery_form:" . $backup_jquery_form . "<br>";
				 $success = copy($WPCF7_JQUERY_FORM, $backup_jquery_form);
				 if($success == 1 )
				 {	
					 $success = copy($LF_WPCF7_CLASS, $WPCF7_CLASS );
					 $success = copy($LF_WPCF7_CONTROLLER, $WPCF7_CONTROLLER );
					 $success = copy($LF_WPCF7_JQUERY_FORM, $WPCF7_JQUERY_FORM );
					 // echo "All files copied ";
				 }
			  }
	 	 }
	}
}

function lf_admin_menu() {
	add_menu_page(__('LoopFuse'), __('LoopFuse','cp'), 8, basename(__FILE__), '', 'http://loopfuse.com/images/global/favicon.ico');
	add_submenu_page(basename(__FILE__), __('LoopFuse','cp'), __('Edit','cp'), '10', basename(__FILE__), 'loopfuse_form_editor');	
}

function loopfuse_form_editor() {
// include 'loopfuse_form_editor.php';
include 'loopfuse_add.php';

}

add_action('admin_menu', 'lf_admin_menu'); 
// We're forced to bed, but we're free to dream.



?>
