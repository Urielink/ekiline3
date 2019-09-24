<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                
    <?php if ( has_post_thumbnail() || get_theme_mod( 'ekiline_getthumbs' ) == true ) { ?>

        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php if ( has_post_thumbnail() ){
            	the_post_thumbnail( 'horizontal-slide', array( 'class' => 'card-img-top') );
			} else { ?>
                <img class="card-img-top" alt="<?php the_title_attribute();?>" src="<?php ekiline_load_first_image(); ?>">
			<?php } ?>
        </a>
        
    <?php } ?>	                    
              

	    <div class="card-body">
 
          <?php the_title( sprintf( '<h2 class="entry-title card-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

          <?php the_excerpt(); ?> 

  		  <small class="text-muted entry-meta">
			<?php ekiline_posted_on(); ?>
		  </small><!-- .entry-meta -->

	    </div>

        
    	<footer class="entry-footer card-footer">
    		<small><?php ekiline_entry_footer(); ?></small>
    	</footer><!-- .entry-footer -->
        

</article><!-- #post-## -->

