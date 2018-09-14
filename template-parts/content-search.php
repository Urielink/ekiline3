<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
	<header class="entry-header">
		<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

		<?php // if ( 'post' === get_post_type() ) : ?>

		<small class="entry-meta">
			<?php ekiline_posted_on(); ?>
		</small><!-- .entry-meta -->
		
		<?php // endif; ?>
	</header><!-- .entry-header -->
	    
	<div class="entry-summary clearfix border-top pt-2 mt-2">
			    
        <?php if ( has_post_thumbnail() || get_theme_mod( 'ekiline_getthumbs' ) == true ) { ?>
        
            <div class="cat-thumb float-left mr-2 my-1">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php if ( has_post_thumbnail() ){
                    	the_post_thumbnail( 'thumbnail', array( 'class' => 'img-thumbnail') );
					} else { ?>
                        <img class="img-thumbnail img-fluid wp-post-image" alt="<?php the_title_attribute();?>" height="150" style="max-width: 150px;" src="<?php ekiline_load_first_image(); ?>">
					<?php } ?>
                </a>
            </div>
            
        <?php } ?>	    	    
		
		<?php the_excerpt(); ?>
		
	</div><!-- .entry-summary -->

	<footer class="entry-footer bg-light px-1">
		<small><?php ekiline_entry_footer(); ?></small>
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->

