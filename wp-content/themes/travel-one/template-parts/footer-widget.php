<?php
/**
 * Displays footer widgets if assigned
 *
 * @package Travel_One
 */

?>

<?php
if ( is_active_sidebar( 'sidebar-2' ) ) :
?>

	<aside id="tertiary" class="footer-widget-area-wrapper" role="complementary">
		<?php
		if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
			<div class="widget-column footer-widget-1">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div>
		<?php } ?>
	</aside><!-- .widget-area -->

<?php endif;
