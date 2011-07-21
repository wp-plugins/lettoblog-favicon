<?php
/*
Plugin Name:LettoBlog Favicon 
Plugin URI: http://mustafa.lettoblog.com/2011/07/19/favicon-plugin-released-lettoblog-favicon
Description: The easiest way to put a favicon on your Wordpress & Wordpress Mu website.
Version: 1.1
Author: Mustafa UYSAL
Author URI: http://blog.uysalmustafa.com


Copyright 2011 LettoBlog (http://lettoblog.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/




// localizing
if ( is_admin() ) { add_action('init', 'favicon_init'); }
function favicon_init() {
	load_plugin_textdomain(favicon, '/wp-content/plugins/lettoblog-favicon/lang/');
}




function favicon_option_menu() {
	if (function_exists('current_user_can')) {
		if (!current_user_can('manage_options')) return;
	} else {
		global $user_level;
		get_currentuserinfo();
		if ($user_level < 8) return;
	}
	if (function_exists('add_options_page')) {
		add_options_page(__('Favicon',favicon), __('Favicon',favicon), 1, __FILE__, 'favicon_options_page');
	}
} 

//Adding menu
add_action('admin_menu', 'favicon_option_menu');

function favicon_options_page(){
	
	global $wpdb;
	if (isset($_POST['update_options'])) {
		$options['favicon_url'] = trim($_POST['favicon_url'],'{}');
		update_option('favicon_insert_url', $options);
	//Save notification
		echo '<div class="updated"><p>' . __('Options saved',favicon) . '</p></div>';
	} 
	else {
		
		$options = get_option('favicon_insert_url');
	}
	
	?>
		<div class="wrap">
		<h2><?php echo __('Favicon Settings',favicon); ?></h2>
		<form method="post" action="">
		
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Favicon URL:',favicon) ?></th>
				<td><input name="favicon_url" type="text" id="favicon_url" value="<?php echo $options['favicon_url']; ?>" size="60" /><br /> <?php echo __('Enter your favicon url (direct link).Example:<em>http://lettoblog.com/favicon.ico</em><br />Do not forget, refresh your browser to see changes.', favicon); ?></td>
			</tr>
		
		</table>
	
		<div class="submit"><input name="update_options"  type="submit" value="<?php _e('Update',favicon) ?>"  style="font-weight:bold;" /></div>
		</form> 
       		
	</div>
	<?php	
}


//hooks
add_action('wp_head', 'favicon_display');
add_action('admin_head', 'favicon_display');

function favicon_display() {
$options = get_option('favicon_insert_url');
echo '<!-- LettoBlog Favicon -->';
echo '<link rel="shortcut icon" href="' . $options[favicon_url] . '" type="image/x-icon" />';
}




?>