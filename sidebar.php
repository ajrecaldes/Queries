<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package thrive
 */

global $post;

$sidebar 		= 'sidebar-1';
$sidebar_right 	= 'sidebar-1';
$sidebar_left 	= 'sidebar-1';
$page_layout    = 'content-sidebar';
$is_shop 		= false;

if ( function_exists('is_shop') ) {
	if ( is_shop() ) {
		$post->ID = get_option( 'woocommerce_shop_page_id' );
		$is_shop = true;
	}
}

if ( !empty( $post ) ) {

	$sidebar_right = get_post_meta( $post->ID, 'thrive_sidebar', true );
	$sidebar_left  = get_post_meta( $post->ID, 'thrive_sidebar_left', true );
	$page_layout   = get_post_meta( $post->ID, 'thrive_page_layout', true );

}

if ( 'sidebar-content' === $page_layout ) {
	$sidebar = $sidebar_left;
}

if ( 'content-sidebar' === $page_layout ) {
	$sidebar = $sidebar_right;
}

if ( is_archive() || is_home() ) {
	if ( !$is_shop ) {
		$sidebar = 'archives-sidebar';
	}
}

if ( function_exists( 'is_buddypress' ) ) {

	if ( is_buddypress() ) {

		$sidebar = 'bp-sidebar';

	}
}

if ( class_exists( 'TaskBreaker' ) ) {

	$pages = get_option('bp-pages');
	$project_page = 0;
	if ( ! empty ( $pages['projects'] ) ) {
		$project_page = absint( $pages['projects'] );
	}

	// Check if is project page.
	if ( is_singular('page') && $project_page !== 0 ) {
		$current_page_id = get_queried_object_id();
		if ( $current_page_id === $project_page ) {
			$sidebar = 'taskbreaker-projects';
		}
	}

	// Check if it is singular project.
	if ( is_singular('project') ) {
		$sidebar = 'taskbreaker-projects';
	}

}

?>

<div id="secondary" class="widget-area" role="complementary">

	<?php if ( is_active_sidebar( $sidebar ) ) { ?>

		<?php dynamic_sidebar( esc_attr( $sidebar ) ); ?>

	<?php } ?>

</div><!-- #secondary -->
