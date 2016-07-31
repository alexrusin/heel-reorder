<?php
/*
Plugin Name: Heels Reorder
Plugin URI: http://alexrusin.com/
Description: This plugin allows to reorder the heels are displayed on front end
Version: 1.0.0
Author: Alex Rusin
Author URI: http://alexrusin.com
License: GPLv2
*/
//Exit if accessed directly
if(!defined('ABSPATH')){
	exit;
}
//flush rewrite rules
function whr_activate(){
	flush_rewrite_rules();
}
register_activation_hook( __FILE__ , 'whr_activate');

require_once (plugin_dir_path(__FILE__).'admin-reorder-submenu.php');

function whr_enqueue_scripts(){
	global $typenow, $pagenow;
	
	if ( $typenow == 'products') {
		wp_enqueue_style( 'whr-style', plugins_url( 'css/whr-style.css', __FILE__ ) );
	}
	if($pagenow =='edit.php' && $typenow == 'products'){
		wp_enqueue_script( 'reorder-js', plugins_url( 'js/reorder.js', __FILE__ ), array( 'jquery', 'jquery-ui-sortable' ), '20150204', true );
		wp_localize_script('reorder-js', 'whr_heels_reorder', array (
			'security' => wp_create_nonce('whr-heels-reorder'),
			'success' => __( 'Heels sorting order has been saved.', 'womens-heels-reorder' ),
			'failure' => __( 'There was an error saving the sort order, or you do not have proper permissions.', 'womens-heels-reorder' )

		));
		wp_enqueue_script( 'reorder-mens-js', plugins_url( 'js/reorder-mens.js', __FILE__ ), array( 'jquery', 'jquery-ui-sortable' ), '20150204', true );
		wp_localize_script('reorder-js', 'whr_heels_reorder', array (
			'security' => wp_create_nonce('whr-heels-reorder'),
			'success' => __( 'Heels sorting order has been saved.', 'womens-heels-reorder' ),
			'failure' => __( 'There was an error saving the sort order, or you do not have proper permissions.', 'womens-heels-reorder' )

		));

	}
}

add_action('admin_enqueue_scripts', 'whr_enqueue_scripts');