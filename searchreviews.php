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

function searchreviews_script(){
	echo '<script type="text/javascript" charset="utf-8" src="http://searchreviews.com/widget/widget.jsp"></script>';
}

function searchreviews_link($content){
	$link = '<a href="http://searchreviews.com" title="3P?" class="searchReviewsLink" keywords="2P">Speedo reviews</a>';
	return $link . $content;
}

add_action( 'wp_head', 'searchreviews_script');
add_filter('the_content', 'searchreviews_link');

?>