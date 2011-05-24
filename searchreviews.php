<?php
/*
Plugin Name: SearchReviews.com Widget
Plugin URI: http://searchreviews.com/publisher
Description: Get reviews from SearchReviews.com on your website.
Version: 1.0
Author: Sumeet Jain
Author URI: http://sumeetjain.com
License: GPL2
*/

// ### FRONT-END ###

add_action('init', 'searchreviews_script');
add_filter('the_content', 'searchreviews_link');

function searchreviews_script(){
	$sr_script_loc = "http://searchreviews.com/widget/widget.jsp?pId=" . get_option('sr_pId');
	wp_register_script('searchreviews', $sr_script_loc);
	wp_enqueue_script('searchreviews');
}
function searchreviews_link($content){
	global $post;
	
	if(get_post_meta($post->ID, 'sr_tags', true) != ''){
		$link = '<a href="http://searchreviews.com" title="Reviews for ' . get_post_meta($post->ID, 'sr_tags', true) . '" class="searchReviewsLink" keywords="' . get_post_meta($post->ID, 'sr_tags', true) . '">' . get_post_meta($post->ID, 'sr_tags', true) . ' reviews</a>';
	}
	elseif(get_option('sr_showAlways') == "always"){
		$link = '<a href="http://searchreviews.com" title="Find Reviews" class="searchReviewsLink" rel="nonExistentID1234">Find Reviews</a>';
	}
	else{
		$link = '';
	}
	
	return $link . $content;
}


// ### BACK-END ###

// ### post settings ###
add_action('admin_init', 'sr_add_boxes');
add_action('save_post', 'sr_save_postdata');

function sr_add_boxes(){
	add_meta_box("searchreviews_box", __('SearchReviews.com Widget'), "sr_box_content", "post", "side");
	add_meta_box("searchreviews_box", __('SearchReviews.com Widget'), "sr_box_content", "page", "side");
}
function sr_box_content(){
	global $post;
	// Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), 'searchreviews');
	// The actual fields for data entry
	echo '<label for="sr_tags">';
	_e("Find reviews for:");
	echo '</label> ';
	echo '<input type="text" id="sr_tags" name="sr_tags" value="' . get_post_meta($post->ID, 'sr_tags', true) . '" size="25" />';
}
function sr_save_postdata($post_id){
	// Check if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return;
	}
	// Check if this came from our screen and with proper authorization,
	// because save_post can be triggered at other times
	if (!wp_verify_nonce($_POST['searchreviews'], plugin_basename(__FILE__))){
		return;
	}
	// Check permissions
	if ('page' == $_POST['post_type']){
		if (!current_user_can('edit_page', $post_id)){
			return;
		}
	}
	else{
		if (!current_user_can('edit_post', $post_id)){
			return;
		}
	}
	// OK, we're authenticated: we need to find and save the data
	$mydata = $_POST['sr_tags'];

	// Do something with $mydata 
	// probably using add_post_meta(), update_post_meta(), or 
	// a custom table (see Further Reading section below)
	add_post_meta($post_id, 'sr_tags', $mydata, true) or update_post_meta($post_id, 'sr_tags', $mydata);
	return $mydata;
}

// ### admin settings ###
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
	$hidden_field_name = 'sr_hidden';
	$opt_name1 = 'sr_pId';
	$opt_name2 = 'sr_showAlways';
	$data_field_name1 = 'sr_pId';
	$data_field_name2 = 'sr_showAlways';
	// Read in existing option value from database
	$opt_val1 = get_option($opt_name1);
	$opt_val2 = get_option($opt_name2);
	// See if the user has posted us some information
	// If they did, this hidden field will be set to 'Y'
	if (isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y'){
		// Read their posted value
		$opt_val1 = $_POST[$data_field_name1];
		$opt_val2 = $_POST[$data_field_name2];
		// Save the posted value in the database
		update_option($opt_name1, $opt_val1);
		update_option($opt_name2, $opt_val2);
		// Show "settings updated" message:	
?>

<div class="updated"><p><strong><?php _e('Updated Settings.'); ?></strong></p></div>

<?php
	}
	
	// Display the settings editing screen
	echo '<div class="wrap">';
	echo "<h2>" . __('SearchReviews.com Widget Settings') . "</h2>";
	
?>

	<form name="form1" method="post" action="">
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		<p><?php _e("Publisher ID (optional):"); ?> 
			<input type="text" name="<?php echo $data_field_name1; ?>" value="<?php echo $opt_val1; ?>" size="20">
		</p>
		<p>By default, if you don't enter any keywords for reviews when you write a post, the widget will look for its own keywords and use them to find reviews. To prevent this behavior, toggle this setting:</p>
		<p>
			<label><input type="radio" name="<?php echo $data_field_name2; ?>" value="always" <?php if($opt_val2 == "always"){ echo 'checked="checked"';} ?>> <?php _e("Always show widget."); ?></label><br />
			<label><input type="radio" name="<?php echo $data_field_name2; ?>" value="manual" <?php if($opt_val2 == "manual"){ echo 'checked="checked"';} ?>> <?php _e("Only show widget if I manually enter keywords."); ?></label>
		</p><hr />
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save') ?>" />
		</p>
	</form>
</div>

<?php
}
?>