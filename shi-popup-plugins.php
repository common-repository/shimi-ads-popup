<?php
/*
Plugin Name:  Shimi popup plugins
Plugin URI: http://shimivn.blogspot.com
Description:  Plugin popup
Author: shimi
Version: 1.0
Author URI: http://shimivn.blogspot.com
*/
// create tables
/** function load  css * */
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
define( 'SHI_PLUGIN_URL', plugins_url('', __FILE__ ) ); // url
define( 'SHI_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );  // include php
function shi_pop_add_scripts() {
wp_enqueue_style( 'style-shi-popup', SHI_PLUGIN_URL.'/css/style.css');
//  wp_enqueue_script( 'script-shi-jquery', SHI_PLUGIN_URL.'/js/jquery.10.2.js',  array(), '1.0.0', true );
wp_enqueue_script( 'script-shi-popup', SHI_PLUGIN_URL.'/js/script.js',  array(), '1.0.0', true );
}
function shi_pop_load(){
	if ( ! current_user_can( 'manage_options' ) ) {
if(get_option('shi-pop-active')){
add_action('wp_enqueue_scripts','shi_pop_add_scripts');
?>
<style>
#popupContactClose{
font-size:12px;
line-height:16px;
color: #ffffff;
font-weight: 700;
float: left;
position: absolute;
<?php switch (get_option('shi-pop-btn-close')){
case  0: ?>
left:-54px;
top: -54px;
<?php   break;
case 1:?>
right:-54px;
top: -54px;
<?php   break;  case 2:?>
right:-54px;
bottom:-54px;
<?php   break;  case 3:?>
left:-54px;
bottom:-54px;
<?php   break; } ?>
}
#closepop{
background:url('<?php echo SHI_PLUGIN_URL.'/img/ico_close.png'; ?>') no-repeat;
width:64px;
height:64px;
}
</style>
<script language="javascript" type="text/javascript">
var popup_area = "";
var linkimg = "<?php echo html_entity_decode(get_option('shi-pop-img')); ?>";
var linkurl = "<?php echo html_entity_decode(get_option('shi-pop-link')); ?>";
popup_area += "<div id=\"popupContact\">";
	popup_area += "<a href=" + linkurl + " target=\"_blank\"><img src=" + linkimg + "   alt=\"\" /></a>";
	popup_area += "<div><a id=\"popupContactClose\" href=\"#\"><img src='<?php echo SHI_PLUGIN_URL.'/img/ico_close.png' ; ?>' /> </a></div></div><div id=\"backgroundPopup\"></div>";
	<?php  if(get_option("shi-pop-cookie")==1){ ?>
	if (readCookie('open_popup') == "") {
	createCookie('open_popup', '1', 1);
	document.write(popup_area);
	}
	<?php  }else { ?>
	document.write(popup_area);
	<?php  } ?>
	</script>
	<?php
	}
	}
	}
	add_action('plugins_loaded','shi_pop_load');
	function shi_pop_register_setting(){
	add_option('shi-pop-active', 1);
	add_option('shi-pop-cookie',1);
	add_option('shi-pop-img', SHI_PLUGIN_URL.'/img/mecha.jpg');
	add_option('shi-pop-link', 'link');
	add_option('shi-pop-btn-close',0);
	}
	function shi_pop_uninstall(){
	delete_option('shi-pop-active');
	delete_option('shi-pop-cookie');
	delete_option('shi-pop-img');
	delete_option('shi-pop-link');
	delete_option('shi-pop-btn-close');
	}
	function shi_pop_add_menu() {
	if (current_user_can( 'manage_options')) {
	add_menu_page(' Shimi ads popup',' Shimi ads popup','administrator' ,__FILE__,'shi_pop_setting_page','dashicons-megaphone', 85 );
	add_action('admin_init','shi_pop_register_setting');
	}
	}

	if ( is_admin() ) {
	add_action('admin_menu','shi_pop_add_menu');
	}

	function shi_pop_setting_page(){
	if (!(current_user_can('manage_options')))
	{
	return false;
	}
		if(isset($_POST['status_submit'])){

if (!isset( $_POST['shi-pop-nonce-field'])|| ! wp_verify_nonce( $_POST['shi-pop-nonce-field'], 'shi-pop-nonce-post' )) {

   print 'Sorry, your nonce did not verify.';
   exit;

}
if (empty( $_POST ) && !check_admin_referer( 'shi-pop-nonce-post', 'shi-pop-nonce-field' ) ) {
exit();
}
			
		if($_POST['status_submit']==1){   // update post
	update_option('shi-pop-active', intval($_POST['shi-pop-active']));
	update_option('shi-pop-cookie', intval($_POST['shi-pop-cookie']));
	update_option('shi-pop-btn-close', intval($_POST['shi-pop-btn-close']));
	update_option('shi-pop-img', htmlentities(stripslashes($_POST['shi-pop-img'])));
	update_option('shi-pop-link', htmlentities(stripslashes($_POST['shi-pop-link'])));
	echo '<div id="message" class="updated fade"><p>Your settings were saved !</p></div>';
	
	}
	if($_POST['status_submit']==2){  // reset mac dinh
	update_option('shi-pop-active', intval($_POST['shi-pop-active']));
	update_option('shi-pop-cookie', intval($_POST['shi-pop-cookie']));
	update_option('shi-pop-img', SHI_PLUGIN_URL.'/img/mecha.jpg');
	update_option('shi-pop-link', 'link');
	update_option('shi-pop-btn-close',0);
	echo '<div id="message" class="updated fade"><p>Your settings were reset !</p></div>';
	}
	}
	$nonce = wp_create_nonce('post-1'); //tạo nonce
	if (!wp_verify_nonce($nonce, 'post-1'))
		{ exit(); }

	?>
	<h2>  Shimi pop up Setting</h2>
	<form method="post" id="ads-options">
		<input type="hidden" name="status_submit" id="status_submit" value="2"  />
		<table width="100%" cellspacing="2" cellpadding="5" class="editform">
			<tr valign="top">
				<td width="150" scope="row">Active plugin:</td>
   <?php wp_nonce_field( 'shi-pop-nonce-post', 'shi-pop-nonce-field' ); ?>

				<td>
					<label><input type="radio" name="shi-pop-active" <?php if (get_option('shi-pop-active')=='1'): ?> checked="checked"<?php endif; ?> value="1" />Yes</label>
					<label><input type="radio" name="shi-pop-active" <?php if (get_option('shi-pop-active')=='0'): ?> checked="checked"<?php endif; ?> value="0" />No</label>
				</td>
			</tr>
			<tr valign="top">
				<td width="150" scope="row">Cookie plugin:</td>
				<td>
					<label><input type="radio" name="shi-pop-cookie" <?php if (get_option('shi-pop-cookie')=='1'): ?> checked="checked"<?php endif; ?> value="1" />Yes (show only one)</label>
					<label><input type="radio" name="shi-pop-cookie" <?php if (get_option('shi-pop-cookie')=='0'): ?> checked="checked"<?php endif; ?> value="0" />No (show alaway)</label>
				</td>
			</tr>
			<tr valign="top">
				<td  scope="row">Image src:<br/><small>Put HTML code </small></td>
				<td scope="row">
					<textarea name="shi-pop-img" rows="5" cols="50"><?php echo html_entity_decode(get_option('shi-pop-img')); ?></textarea>
				</td>
			</tr>
			<tr valign="top">
				<td  scope="row">Link target:<br/><small>Put Link HTML code </small></td>
				<td scope="row">
					<textarea name="shi-pop-link" rows="5" cols="50"><?php echo html_entity_decode(get_option('shi-pop-link')); ?></textarea>
				</td>
			</tr>
			
			<tr valign="top">
				<td width="150" scope="row">Position button close:</td>
				<td>
					<label><input type="radio" name="shi-pop-btn-close" <?php if (get_option('shi-pop-btn-close')=='0'): ?> checked="checked"<?php endif; ?> value="0" />top-left</label>
					<label><input type="radio" name="shi-pop-btn-close" <?php if (get_option('shi-pop-btn-close')=='1'): ?> checked="checked"<?php endif; ?> value="1" />top-right</label>
					<label><input type="radio" name="shi-pop-btn-close" <?php if (get_option('shi-pop-btn-close')=='2'): ?> checked="checked"<?php endif; ?> value="2" />bottom-right</label>
					<label><input type="radio" name="shi-pop-btn-close" <?php if (get_option('shi-pop-btn-close')=='3'): ?> checked="checked"<?php endif; ?> value="3" />bottom-left</label>
				</td>
			</tr>
			<tr valign="top">
				<td  scope="row"></td>
				<td scope="row">
					<input type="button" name="save" onclick="document.getElementById('status_submit').value = '1';
					document.getElementById('ads-options').submit();" value="Save setting" class="button-primary" />
				</td>
			</tr>
			<tr><td colspan="2"><br /><br /></td></tr>
			<tr valign="top">
				<td  scope="row"></td>
				<td scope="row">
					<input type="button" name="reset" onclick="document.getElementById('status_submit').value = '2';
					document.getElementById('ads-options').submit();" value="Reset to default setting" class="button" />
				</td>
			</tr>
		</table>
	</form>
	<?php
	}
	//add setting menu
	/* What to do when the plugin is activated? */
	/* What to do when the plugin is deactivated? */
	//register_activation_hook(__FILE__, 'shi_pop_load' );
	register_uninstall_hook(__FILE__, 'shi_pop_uninstall' );
	?>