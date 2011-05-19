<?php
/*
Plugin Name: SearchReviews.com Widget
Plugin URI: http://searchreviews.com/publishers
Description: Get reviews on your website; earn affiliate cash.
Version: 1.0
Author: Sumeet Jain
Author URI: http://sumeetjain.com
License: GPL2
*/

// ### FRONT-END ###

add_action( 'init', 'searchreviews_script');
add_filter('the_content', 'searchreviews_link');

function searchreviews_script(){
	$sr_script_loc = "http://searchreviews.com/widget/widget.jsp?pId=" . get_option('sr_pId');
	wp_register_script('searchreviews', $sr_script_loc);
	wp_enqueue_script('searchreviews');
}

function searchreviews_link($content){
	$link = '<a href="http://searchreviews.com" title="3P?" class="searchReviewsLink" keywords="2P">Speedo reviews</a>';
	return $link . $content;
}


// ### BACK-END ###

add_action('admin_menu', 'searchreviews_menu');

function searchreviews_menu() {
	add_options_page(
		'SearchReviews.com Widget Settings', 
		'SearchReviews.com', 
		'manage_options', 
		'searchreviews-widget', 
		'searchreviews_options');
}

function searchreviews_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	
	// Variables for the field and option names 
	$opt_name = 'sr_pId';
	$hidden_field_name = 'sr_hidden';
	$data_field_name = 'sr_pId';

	// Read in existing option value from database
	$opt_val = get_option($opt_name);

	// See if the user has posted us some information
	// If they did, this hidden field will be set to 'Y'
	if (isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y'){
		// Read their posted value
		$opt_val = $_POST[$data_field_name];

		// Save the posted value in the database
		update_option($opt_name, $opt_val);

		// Show "settings updated" message:	
?>
			
<div class="updated"><p><strong><?php _e('Updated Publisher ID.'); ?></strong></p></div>
			
<?php
	}

	// Display the settings editing screen
	echo '<div class="wrap">';
	echo "<h2>" . __('SearchReviews.com Widget Settings') . "</h2>";
?>

	<form name="form1" method="post" action="">
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

		<p><?php _e("Publisher ID (optional):"); ?> 
			<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
		</p><hr />

		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save') ?>" />
		</p>
	</form>
</div>

<?php
}
?>