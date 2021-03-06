<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ekiline
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<?php rightSideButton(); ?>

<aside id="third" class="widget-area<?php rightSideOn(); ?>">
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</aside><!-- #secondary -->
