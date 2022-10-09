<?php
function travel_one_wp_travel_before_main_content() {
	?>
	<main id="primary" class="site-main">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
	<?php
}
add_action( 'wp_travel_before_main_content', 'travel_one_wp_travel_before_main_content' );

function travel_one_wp_travel_after_main_content() {
	?>
			</div>
		</article>
	</main>
	<?php
}
add_action( 'wp_travel_after_main_content', 'travel_one_wp_travel_after_main_content', 12 );

/**
 * Modify WPTravel hooks.
 *
 * @return void
 */
function travel_one_modify_wptravel_hooks() {
	remove_action( 'wp_travel_archive_listing_sidebar', 'wptravel_archive_listing_sidebar' );
	add_action( 'wp_travel_after_main_content', 'wptravel_archive_listing_sidebar', 10 );
	remove_action( 'wp_travel_before_main_content', 'wptravel_archive_title', 9 );
}
add_action( 'init', 'travel_one_modify_wptravel_hooks' );
