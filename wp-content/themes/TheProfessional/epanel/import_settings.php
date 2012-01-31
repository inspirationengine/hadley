<?php 
add_action( 'admin_enqueue_scripts', 'import_epanel_javascript' );
function import_epanel_javascript( $hook_suffix ) {
	if ( 'admin.php' == $hook_suffix && isset( $_GET['import'] ) && isset( $_GET['step'] ) && 'wordpress' == $_GET['import'] && '1' == $_GET['step'] )
		add_action( 'admin_head', 'admin_headhook' );
}

function admin_headhook(){ ?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$("p.submit").before("<p><input type='checkbox' id='importepanel' name='importepanel' value='1' style='margin-right: 5px;'><label for='importepanel'>Replace ePanel settings with sample data values</label></p>");
		});
	</script>
<?php }

add_action('import_end','importend');
function importend(){
	global $wpdb, $shortname;
	
	#make custom fields image paths point to sampledata/sample_images folder
	$sample_images_postmeta = $wpdb->get_results("SELECT meta_id, meta_value FROM $wpdb->postmeta WHERE meta_value REGEXP 'http://et_sample_images.com'");
	if ( $sample_images_postmeta ) {
		foreach ( $sample_images_postmeta as $postmeta ){
			$template_dir = get_template_directory_uri();
			if ( is_multisite() ){
				switch_to_blog(1);
				$main_siteurl = site_url();
				restore_current_blog();
				
				$template_dir = $main_siteurl . '/wp-content/themes/' . get_template();
			}
			preg_match( '/http:\/\/et_sample_images.com\/([^.]+).jpg/', $postmeta->meta_value, $matches );
			$image_path = $matches[1];
			
			$local_image = preg_replace( '/http:\/\/et_sample_images.com\/([^.]+).jpg/', $template_dir . '/sampledata/sample_images/$1.jpg', $postmeta->meta_value );
			
			$local_image = preg_replace( '/s:55:/', 's:' . strlen( $template_dir . '/sampledata/sample_images/' . $image_path . '.jpg' ) . ':', $local_image );
			
			$wpdb->update( $wpdb->postmeta, array( 'meta_value' => $local_image ), array( 'meta_id' => $postmeta->meta_id ), array( '%s' ) );
		}
	}

	if ( !isset($_POST['importepanel']) )
		return;
	
	$importOptions = 'YTo5MDp7czowOiIiO047czoxNzoicHJvZmVzc2lvbmFsX2xvZ28iO3M6MDoiIjtzOjIwOiJwcm9mZXNzaW9uYWxfZmF2aWNvbiI7czowOiIiO3M6MjU6InByb2Zlc3Npb25hbF9jb2xvcl9zY2hlbWUiO3M6NzoiRGVmYXVsdCI7czoyMzoicHJvZmVzc2lvbmFsX2Jsb2dfc3R5bGUiO047czoyMzoicHJvZmVzc2lvbmFsX2dyYWJfaW1hZ2UiO047czoyNToicHJvZmVzc2lvbmFsX2NhdG51bV9wb3N0cyI7czoxOiI2IjtzOjI5OiJwcm9mZXNzaW9uYWxfYXJjaGl2ZW51bV9wb3N0cyI7czoxOiI1IjtzOjI4OiJwcm9mZXNzaW9uYWxfc2VhcmNobnVtX3Bvc3RzIjtzOjE6IjUiO3M6MjU6InByb2Zlc3Npb25hbF90YWdudW1fcG9zdHMiO3M6MToiNSI7czoyNDoicHJvZmVzc2lvbmFsX2RhdGVfZm9ybWF0IjtzOjY6Ik0gaiwgWSI7czoyNDoicHJvZmVzc2lvbmFsX3VzZV9leGNlcnB0IjtOO3M6MjI6InByb2Zlc3Npb25hbF9zZXJ2aWNlXzEiO3M6OToiV2hhdCBJIERvIjtzOjIyOiJwcm9mZXNzaW9uYWxfc2VydmljZV8yIjtzOjg6IldobyBJIEFtIjtzOjIyOiJwcm9mZXNzaW9uYWxfc2VydmljZV8zIjtzOjk6IldoYXQgSSBEbyI7czoyNzoicHJvZmVzc2lvbmFsX2hvbWVwYWdlX3Bvc3RzIjtzOjE6IjciO3M6Mjc6InByb2Zlc3Npb25hbF9leGxjYXRzX3JlY2VudCI7TjtzOjIxOiJwcm9mZXNzaW9uYWxfZmVhdHVyZWQiO3M6Mjoib24iO3M6MjI6InByb2Zlc3Npb25hbF9kdXBsaWNhdGUiO047czoyMToicHJvZmVzc2lvbmFsX2ZlYXRfY2F0IjtzOjg6IkZlYXR1cmVkIjtzOjI1OiJwcm9mZXNzaW9uYWxfZmVhdHVyZWRfbnVtIjtzOjE6IjMiO3M6MjI6InByb2Zlc3Npb25hbF91c2VfcGFnZXMiO047czoyMzoicHJvZmVzc2lvbmFsX2ZlYXRfcGFnZXMiO047czoyNDoicHJvZmVzc2lvbmFsX3NsaWRlcl9hdXRvIjtOO3M6MjQ6InByb2Zlc3Npb25hbF9wYXVzZV9ob3ZlciI7TjtzOjI5OiJwcm9mZXNzaW9uYWxfc2xpZGVyX2F1dG9zcGVlZCI7czo0OiI0MDAwIjtzOjI2OiJwcm9mZXNzaW9uYWxfc2xpZGVyX2VmZmVjdCI7czo0OiJmYWRlIjtzOjIyOiJwcm9mZXNzaW9uYWxfbWVudXBhZ2VzIjtOO3M6Mjk6InByb2Zlc3Npb25hbF9lbmFibGVfZHJvcGRvd25zIjtzOjI6Im9uIjtzOjIyOiJwcm9mZXNzaW9uYWxfaG9tZV9saW5rIjtzOjI6Im9uIjtzOjIzOiJwcm9mZXNzaW9uYWxfc29ydF9wYWdlcyI7czoxMDoicG9zdF90aXRsZSI7czoyMzoicHJvZmVzc2lvbmFsX29yZGVyX3BhZ2UiO3M6MzoiYXNjIjtzOjMwOiJwcm9mZXNzaW9uYWxfdGllcnNfc2hvd25fcGFnZXMiO3M6MToiMyI7czoyMToicHJvZmVzc2lvbmFsX21lbnVjYXRzIjtOO3M6NDA6InByb2Zlc3Npb25hbF9lbmFibGVfZHJvcGRvd25zX2NhdGVnb3JpZXMiO3M6Mjoib24iO3M6Mjk6InByb2Zlc3Npb25hbF9jYXRlZ29yaWVzX2VtcHR5IjtzOjI6Im9uIjtzOjM1OiJwcm9mZXNzaW9uYWxfdGllcnNfc2hvd25fY2F0ZWdvcmllcyI7czoxOiIzIjtzOjIxOiJwcm9mZXNzaW9uYWxfc29ydF9jYXQiO3M6NDoibmFtZSI7czoyMjoicHJvZmVzc2lvbmFsX29yZGVyX2NhdCI7czozOiJhc2MiO3M6Mjg6InByb2Zlc3Npb25hbF9kaXNhYmxlX3RvcHRpZXIiO047czoyMjoicHJvZmVzc2lvbmFsX3Bvc3RpbmZvMiI7YTo0OntpOjA7czo2OiJhdXRob3IiO2k6MTtzOjQ6ImRhdGUiO2k6MjtzOjEwOiJjYXRlZ29yaWVzIjtpOjM7czo4OiJjb21tZW50cyI7fXM6MjM6InByb2Zlc3Npb25hbF90aHVtYm5haWxzIjtzOjI6Im9uIjtzOjMwOiJwcm9mZXNzaW9uYWxfc2hvd19wb3N0Y29tbWVudHMiO3M6Mjoib24iO3M6Mjg6InByb2Zlc3Npb25hbF9wYWdlX3RodW1ibmFpbHMiO047czozMToicHJvZmVzc2lvbmFsX3Nob3dfcGFnZXNjb21tZW50cyI7TjtzOjIyOiJwcm9mZXNzaW9uYWxfcG9zdGluZm8xIjthOjQ6e2k6MDtzOjY6ImF1dGhvciI7aToxO3M6NDoiZGF0ZSI7aToyO3M6MTA6ImNhdGVnb3JpZXMiO2k6MztzOjg6ImNvbW1lbnRzIjt9czoyOToicHJvZmVzc2lvbmFsX3RodW1ibmFpbHNfaW5kZXgiO3M6Mjoib24iO3M6MjY6InByb2Zlc3Npb25hbF9jdXN0b21fY29sb3JzIjtOO3M6MjI6InByb2Zlc3Npb25hbF9jaGlsZF9jc3MiO047czoyNToicHJvZmVzc2lvbmFsX2NoaWxkX2Nzc3VybCI7czowOiIiO3M6MjY6InByb2Zlc3Npb25hbF9jb2xvcl9iZ2NvbG9yIjtzOjA6IiI7czoyNzoicHJvZmVzc2lvbmFsX2NvbG9yX21haW5mb250IjtzOjA6IiI7czoyNzoicHJvZmVzc2lvbmFsX2NvbG9yX21haW5saW5rIjtzOjA6IiI7czoyNzoicHJvZmVzc2lvbmFsX2NvbG9yX3BhZ2VsaW5rIjtzOjA6IiI7czozMzoicHJvZmVzc2lvbmFsX2NvbG9yX3NpZGViYXJfdGl0bGVzIjtzOjA6IiI7czoyNToicHJvZmVzc2lvbmFsX2NvbG9yX2Zvb3RlciI7czowOiIiO3M6MzE6InByb2Zlc3Npb25hbF9jb2xvcl9mb290ZXJfbGlua3MiO3M6MDoiIjtzOjI3OiJwcm9mZXNzaW9uYWxfc2VvX2hvbWVfdGl0bGUiO047czozMzoicHJvZmVzc2lvbmFsX3Nlb19ob21lX2Rlc2NyaXB0aW9uIjtOO3M6MzA6InByb2Zlc3Npb25hbF9zZW9faG9tZV9rZXl3b3JkcyI7TjtzOjMxOiJwcm9mZXNzaW9uYWxfc2VvX2hvbWVfY2Fub25pY2FsIjtOO3M6MzE6InByb2Zlc3Npb25hbF9zZW9faG9tZV90aXRsZXRleHQiO3M6MDoiIjtzOjM3OiJwcm9mZXNzaW9uYWxfc2VvX2hvbWVfZGVzY3JpcHRpb250ZXh0IjtzOjA6IiI7czozNDoicHJvZmVzc2lvbmFsX3Nlb19ob21lX2tleXdvcmRzdGV4dCI7czowOiIiO3M6MjY6InByb2Zlc3Npb25hbF9zZW9faG9tZV90eXBlIjtzOjI3OiJCbG9nTmFtZSB8IEJsb2cgZGVzY3JpcHRpb24iO3M6MzA6InByb2Zlc3Npb25hbF9zZW9faG9tZV9zZXBhcmF0ZSI7czozOiIgfCAiO3M6Mjk6InByb2Zlc3Npb25hbF9zZW9fc2luZ2xlX3RpdGxlIjtOO3M6MzU6InByb2Zlc3Npb25hbF9zZW9fc2luZ2xlX2Rlc2NyaXB0aW9uIjtOO3M6MzI6InByb2Zlc3Npb25hbF9zZW9fc2luZ2xlX2tleXdvcmRzIjtOO3M6MzM6InByb2Zlc3Npb25hbF9zZW9fc2luZ2xlX2Nhbm9uaWNhbCI7TjtzOjM1OiJwcm9mZXNzaW9uYWxfc2VvX3NpbmdsZV9maWVsZF90aXRsZSI7czo5OiJzZW9fdGl0bGUiO3M6NDE6InByb2Zlc3Npb25hbF9zZW9fc2luZ2xlX2ZpZWxkX2Rlc2NyaXB0aW9uIjtzOjE1OiJzZW9fZGVzY3JpcHRpb24iO3M6Mzg6InByb2Zlc3Npb25hbF9zZW9fc2luZ2xlX2ZpZWxkX2tleXdvcmRzIjtzOjEyOiJzZW9fa2V5d29yZHMiO3M6Mjg6InByb2Zlc3Npb25hbF9zZW9fc2luZ2xlX3R5cGUiO3M6MjE6IlBvc3QgdGl0bGUgfCBCbG9nTmFtZSI7czozMjoicHJvZmVzc2lvbmFsX3Nlb19zaW5nbGVfc2VwYXJhdGUiO3M6MzoiIHwgIjtzOjMyOiJwcm9mZXNzaW9uYWxfc2VvX2luZGV4X2Nhbm9uaWNhbCI7TjtzOjM0OiJwcm9mZXNzaW9uYWxfc2VvX2luZGV4X2Rlc2NyaXB0aW9uIjtOO3M6Mjc6InByb2Zlc3Npb25hbF9zZW9faW5kZXhfdHlwZSI7czoyNDoiQ2F0ZWdvcnkgbmFtZSB8IEJsb2dOYW1lIjtzOjMxOiJwcm9mZXNzaW9uYWxfc2VvX2luZGV4X3NlcGFyYXRlIjtzOjM6IiB8ICI7czozNjoicHJvZmVzc2lvbmFsX2ludGVncmF0ZV9oZWFkZXJfZW5hYmxlIjtzOjI6Im9uIjtzOjM0OiJwcm9mZXNzaW9uYWxfaW50ZWdyYXRlX2JvZHlfZW5hYmxlIjtzOjI6Im9uIjtzOjM5OiJwcm9mZXNzaW9uYWxfaW50ZWdyYXRlX3NpbmdsZXRvcF9lbmFibGUiO3M6Mjoib24iO3M6NDI6InByb2Zlc3Npb25hbF9pbnRlZ3JhdGVfc2luZ2xlYm90dG9tX2VuYWJsZSI7czoyOiJvbiI7czoyOToicHJvZmVzc2lvbmFsX2ludGVncmF0aW9uX2hlYWQiO3M6MDoiIjtzOjI5OiJwcm9mZXNzaW9uYWxfaW50ZWdyYXRpb25fYm9keSI7czowOiIiO3M6MzU6InByb2Zlc3Npb25hbF9pbnRlZ3JhdGlvbl9zaW5nbGVfdG9wIjtzOjA6IiI7czozODoicHJvZmVzc2lvbmFsX2ludGVncmF0aW9uX3NpbmdsZV9ib3R0b20iO3M6MDoiIjtzOjIzOiJwcm9mZXNzaW9uYWxfNDY4X2VuYWJsZSI7TjtzOjIyOiJwcm9mZXNzaW9uYWxfNDY4X2ltYWdlIjtzOjA6IiI7czoyMDoicHJvZmVzc2lvbmFsXzQ2OF91cmwiO3M6MDoiIjt9';
	
	/*global $options;
	
	foreach ($options as $value) {
		if( isset( $value['id'] ) ) { 
			update_option( $value['id'], $value['std'] );
		}
	}*/
	
	$importedOptions = unserialize(base64_decode($importOptions));
	
	foreach ($importedOptions as $key=>$value) {
		if ($value != '') update_option( $key, $value );
	}
	update_option( $shortname . '_use_pages', 'false' );
} ?>