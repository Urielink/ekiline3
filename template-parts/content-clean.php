<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class('modpostlist-clean'); ?>>

    		<?php the_content(); ?>

</div><!-- #post-## -->
