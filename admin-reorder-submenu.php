<?php
function whr_add_submenu_page() {
	add_submenu_page( 
		'edit.php?post_type=products', 
		'Change Heels Order', 
		'Change Heels Order', 
		'manage_options', 
		'reorder_womens_heels', 
		'reorder_womens_heels_callback' 
	);
}
add_action( 'admin_menu', 'whr_add_submenu_page' );

function reorder_womens_heels_callback(){
function display_heels($tax_id, $ul_id, $which_heels, $h2_class){
	$args = array(
		'taxonomy' => 'sizes',
		'orderby'  => 'term_group',
		'order'	   => 'ASC',
		'parent' => $tax_id,
	);
	
	$heels = get_terms($args);
	
	if ( ! is_wp_error( $terms ) ){ ?>
	
		
		 <h2 class="<?php echo $h2_class;?>"><?php _e( 'Reorder '. $which_heels.' Heels', 'womens-heels-reorder' ); ?>
		 	<img src="<?php echo esc_url( admin_url() . '/images/loading.gif' ); ?>" id="loading-animation-<?php echo $h2_class;?>"></h2>
		<div class="heels-container">
		<ul id="<?php echo $ul_id; ?>">
	<?php
	
		$counter=0;
		foreach ($heels as $heel) {
			?>
			<li id="<?php echo esc_attr($heel->term_id); ?>"><?php echo esc_html($heel->name); ?></li>
			<?php
			
		} ?>
	</ul>
	</div>
	<div class="clear"></div>
	<?php
		
	} else { ?>
		<h4><?php _e('Sorry, an error occured', 'womens-heels-reorder');?></h4>
		<?php
	}
}

?>

<?php

display_heels(130, 'custom-type-list-women', "Women's", 'womens');
display_heels(131, 'custom-type-list-men', "Men's", 'mens');

}

function whr_save_reorder() {
	if ( ! check_ajax_referer( 'whr-heels-reorder', 'security' ) ) {
		return wp_send_json_error( 'Invalid Nonce' );
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return wp_send_json_error( 'You are not allowed to do this.' );
	}
	$order = $_POST['order'];
	$counter = 0;
	foreach( $order as $item_id ) {
		wp_update_term((int)$item_id, 'sizes', array('term_group'=>$counter));
		$counter++;
	}
	wp_send_json_success('Order Saved');
}
add_action( 'wp_ajax_save_sort', 'whr_save_reorder' );