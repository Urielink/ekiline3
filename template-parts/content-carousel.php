<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * https://developer.wordpress.org/reference/functions/has_post_thumbnail/
 *
 * @package ekiline
 */
 $thumbClass = 'no-thumb';
 if ( has_post_thumbnail() || get_theme_mod( 'ekiline_getthumbs' ) == true ) $thumbClass = '';

?>

<div id="post-<?php the_ID(); ?>" <?php post_class( $thumbClass ); ?>>
        
    <?php if ( has_post_thumbnail() || get_theme_mod( 'ekiline_getthumbs' ) == true ) { ?>
    
            <a class="link-image"  href="<?php echo esc_url( get_permalink() ); ?>">
                <?php if ( has_post_thumbnail() ){
                	the_post_thumbnail( 'horizontal-slide', array( 'class' => 'img-fluid') );
				} else { ?>
                    <img class="img-fluid wp-post-image" alt="<?php the_title_attribute();?>" src="<?php ekiline_load_first_image(); ?>">
				<?php } ?>
            </a>
        
    <?php } ?>    
    

    <div class="carousel-caption">
    		
    	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    	
        <?php the_excerpt(); ?> 

	</div>	
	
</div><!-- #post-## -->

