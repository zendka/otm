<?php
/*
 * Style the font-end
 */

/**
 * Add stylesheets and scripts
 */
add_action( 'wp_enqueue_scripts', 'otm_enqueue_styles_and_scripts' );
function otm_enqueue_styles_and_scripts() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

	wp_enqueue_script( 'otm-script', get_stylesheet_directory_uri() . '/script.js', array(), '1.0.0', true );

	// Selectric is a jQuery plugin to customize HTML selects
	wp_enqueue_style( 'selectric-style',
		get_stylesheet_directory_uri() . '/bower_components/jquery-selectric/public/selectric.css' );
	wp_enqueue_script( 'selectric-script',
		get_stylesheet_directory_uri() . '/bower_components/jquery-selectric/public/jquery.selectric.min.js',
		array(), '1.0.0', true );
}

/**
 * Disable admin bar for most users
 */
add_filter( 'show_admin_bar', 'otm_disable_admin_bar_for_members' );
function otm_disable_admin_bar_for_members() {
	return current_user_can( 'edit_others_posts' ) ? true : false;
}

/**
 * Display 30 documents per page
 */
add_action( 'pre_get_posts', 'otm_display_30_documents_per_page', 1 );
function otm_display_30_documents_per_page( $query ) {
	global $pagenow;

	if ( is_post_type_archive( 'document' ) && 'edit.php' != $pagenow || is_search() ) {
		$query->set( 'posts_per_page', 30 );

		return;
	}
}
