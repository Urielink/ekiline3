<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
        <header class="entry-header border-bottom pb-2 mb-2">
                        
        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        
		<?php //if ( 'post' === get_post_type() ) : ?>
		    
		<small class="entry-meta">
			<?php ekiline_posted_on(); ?>
		</small><!-- .entry-meta -->

		<?php //endif; ?>
    
        </header><!-- .entry-header -->
    
        <div class="entry-content clearfix">
            	        
            <?php if ( has_post_thumbnail() || get_theme_mod( 'ekiline_getthumbs' ) == true ) { ?>
            
                <div class="cat-thumb">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php if ( has_post_thumbnail() ){
                        	the_post_thumbnail( 'horizontal-slide', array( 'class' => 'img-fluid img-thumbnail') );
						} else { ?>
	                        <img class="img-fluid img-thumbnail wp-post-image" alt="<?php the_title_attribute();?>" src="<?php ekiline_load_first_image(); ?>">
						<?php } ?>
                    </a>
                </div>
                
            <?php } ?>	        
	        
            
             <?php the_excerpt(); ?> 
                      
        </div><!-- .entry-content -->
        
    	<footer class="entry-footer page-footer bg-light px-2 mb-5">
    		<small><?php ekiline_entry_footer(); ?></small>
    	</footer><!-- .entry-footer -->
        

</article><!-- #post-## -->

