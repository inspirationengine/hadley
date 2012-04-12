<?php
/*
Plugin Name: jqDock Post Thumbs
Plugin URI: http://mynewsitepreview.com/jqdpostthumbs
Description: Create a Mac-like Dock menu with post thumbnail links in any post or page, using a simple shortcode.
Version: 2.0
Author: Shaun Scovil
Author URI: http://shaunscovil.com/
License: GPL2
*/

/*  Copyright 2011  Shaun Scovil  (email : sscovil@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Load plugin stylesheet, jquery.jqDock.min.js by Roger Barrett, and jqDock settings
if ( !is_admin() ) {
	function jqdpostthumbs_enqueue_scripts() {
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jqdock', plugins_url( '/scripts/jquery.jqDock.min.js', __FILE__), 'jquery' );
		wp_enqueue_script( 'jqdcustom', plugins_url( '/scripts/jqDock.custom.js', __FILE__), 'jqdock' );
		wp_enqueue_script( 'jqdoptions', plugins_url( '/scripts/jqDock.options.js', __FILE__), 'jqdock' );
	} 
	add_action('wp_enqueue_scripts', 'jqdpostthumbs_enqueue_scripts'); 
	
	function jqdpostthumbs_enqueue_styles() {
		$myStyleUrl = plugins_url('/css/jqdpostthumbs.css', __FILE__);
		wp_register_style('jqdpostthumbs', $myStyleUrl);
		wp_enqueue_style( 'jqdpostthumbs');
	}
	add_action('wp_print_styles', 'jqdpostthumbs_enqueue_styles');
}


// jqDock Post Thumbs
function jqdpostthumbs($args) {
	// If the theme does not support post thumbnails, stop right here
	if( !current_theme_supports( 'post-thumbnails' ) == TRUE ) { return; }

	// Get option to display thumbnail titles
	$opt_notitle = $args['notitle'] . $args['notitles']; // Boolean: If true, do not show titles	

	// Get option for max number of thumbnails to display	
	$opt_qty = $args['qty'];
		if( $opt_qty == '' ) { $opt_qty = '5'; }
		$qty = (int)$opt_qty;

	// Get option for Custom Post Type
	$opt_type = $args['type'];
		if( !$opt_type == '' ) { // Validate custom post type, if one is set
			$valid_post_types = get_post_types('','names');
			if( !in_array( $opt_type, $valid_post_types ) ) {
				$opt_type = 'post'; // Default to 'post'
			}
		}

	// Get options for the order in which thumbnails will appear
	$opt_order = $args['order'];
		if( !$opt_order == 'ASC' ) { $opt_order = 'DESC'; } // Default to 'DESC'
	$opt_orderby = $args['orderby'];
		if( !$opt_orderby == '' ) { // Validate orderby parameter, if one is set
			$valid_orderby_params = array ( 'none', 'ID', 'author', 'title', 'date', 'modified', 'parent', 'rand', 'comment_count', 'menu_order' );
			if( !in_array( $opt_orderby, $valid_orderby_params ) ) {
				$opt_orderby = 'rand'; // Default to 'rand'
			}
		} else {
			$opt_orderby = 'rand'; // Default to 'rand'
		}
	
	// Query the database
	$do_not_duplicate[] = $post->ID;

	$args =  array(
		'post_type'      => $opt_type, //'products-and-solutions',
		'post__not_in'   => $do_not_duplicate, // Do not get the post currently being viewed
		'posts_per_page' => $qty,
		'meta_key'       => '_thumbnail_id', // Only get posts with thumbnails set
		'order'          => $opt_order,
		'orderby'        => $opt_orderby
	);
	$jqd = new WP_Query( $args );

	// Begin recording echos as an output string
	ob_start();

	// Begin the loop
	if( $jqd->have_posts() ) :

		// Open the container divs
		echo '<div class="jqd_container"><div class="jqd_menu">';
		while ( $jqd->have_posts() ) : $jqd->the_post();
			global $post;

			// Get the thumbnail title
			if( !$opt_notitle == 'true' ) { $title = get_the_title(); }
			// Get the thumbnail link
			$link = get_permalink();
			// Get the image source and attributes
			$attachment_id = get_post_thumbnail_id();
			$image_attributes = wp_get_attachment_image_src( $attachment_id );

			// Generate HTML
			echo '<a href="' . $link . '">';
			echo '<img src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" alt="' . $title . '" title="' . $title . '">';
			echo '</a>';
		
		endwhile;
		echo '</div></div>';
		// Close the container divs

	endif;
	// End of loop
	wp_reset_query(); 

	// End recording echos as an output string
	$content = ob_get_contents();;
	ob_end_clean();
	return $content;
}
add_shortcode("jqdpostthumbs", "jqdpostthumbs");


// jqDock Image Gallery
function jqdgallery($args) {
	// Get option for post ID
	$opt_id = $args['id'];
	global $post;
		if( !$opt_id ) {
			$parent = $post->ID; // Current post will be post_parent in wp_query
		} else {
			$parent = (int)$opt_id; // Post ID specified will be post_parent in wp_query
		}
 
	// Get option to display thumbnail titles
	$opt_notitle = $args['notitle'] . $args['notitles']; // Boolean: If true, do not show titles

	// Get option for max number of thumbnails to display	
	$opt_qty = $args['qty'];
		if( $opt_qty == '' ) { $opt_qty = '5'; }
		$qty = (int)$opt_qty;
		
	// Get options for link attributes (target, class, & rel)
	$opt_nolinks = $args['nolink'] . $args['nolinks']; // Boolean: If true, disable thumbnail links
		if( !$opt_nolinks == 'true' ) {
			$opt_target = $args['target'];
			$opt_class = $args['class'];
			$opt_rel = $args['rel'];
		}

	// Query the database
	$args =  array(
		'post_parent'    => $parent,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'posts_per_page' => $qty
	);
	$attachments = get_children( $args );

	// Begin recording echos as an output string
	ob_start();

	// Begin the loop
	if( $attachments ) {
	
		// Open the container divs
		echo '<div class="jqd_container"><div class="jqd_menu">';
		foreach( $attachments as $attachment ) {

			// Get the thumbnail title
			if( !$opt_notitle ) { $title = $attachment->post_title; }
			// Get the image source and attributes
			$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' )  ? wp_get_attachment_image_src( $attachment->ID, 'thumbnail' ) : wp_get_attachment_image_src( $attachment->ID, 'full' );

			if( !$opt_nolinks ) { echo '<a href="' . wp_get_attachment_url( $attachment->ID ) . '"  class= "' . $opt_class . '" rel="' . $opt_rel . '" target="' . $opt_target . '">'; }
			echo '<img src="' . wp_get_attachment_thumb_url( $attachment->ID ) . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" title="' . $title . '">';
			if( !$opt_nolinks ) { echo '</a>'; }

		}
		echo '</div></div>';
		// Close the container divs
	}
	// End of loop

	// End recording echos as an output string
	$content = ob_get_contents();;
	ob_end_clean();
	return $content;
}
add_shortcode("jqdgallery", "jqdgallery");



add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'product-and-solution',
		array(
			'labels' => array(
				'name' => __( 'Products and Solutions' ),
				'singular_name' => __( 'Products and Solutions' )
			),
		'show_ui' => true,
    		'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'hierarchical' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt',
                             'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats')
		)
	);
}
?>
