<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */
// d-flex justify-content-center align-items-center
// extracto personalizado
$customExcerpt = get_the_content();
$customExcerpt = strip_shortcodes( $customExcerpt ); 
$customExcerpt = wp_trim_words( $customExcerpt , '20', '...' );
$customExcerpt = $customExcerpt;
$cardBody = 'card-img-overlay';
if ( !has_post_thumbnail() && get_theme_mod( 'ekiline_getthumbs' ) == false ) $cardBody = 'card-body';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card bg-dark text-white'); ?>>
                
    <?php if ( has_post_thumbnail() || get_theme_mod( 'ekiline_getthumbs' ) == true ) { ?>
	    <?php if ( has_post_thumbnail() ){
	    	the_post_thumbnail( 'horizontal-slide', array( 'class' => 'card-img') );
		} else { ?>
	        <img class="card-img" alt="<?php the_title_attribute();?>" src="<?php ekiline_load_first_image(); ?>">
		<?php } ?>        
    <?php } ?>	  
                      
	    <div class="<?php echo $cardBody; ?> text-center d-flex justify-content-center align-items-center">
	    				
			<h2 class="lead">
				<?php the_title( sprintf( '<a class="text-light" href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' );?>
				<br><br>
				<small class="btn-group">
					<a class="read-more btn btn-sm btn-outline-light popover-rich" href="#pop-<?php the_ID(); ?>" data-placement="top"><?php echo __( 'Pre', 'ekiline' );?></a>			
					<a class="read-more btn btn-sm btn-outline-light" href="<?php echo esc_url( get_permalink() );?>"><?php echo __( 'Read more', 'ekiline' );?></a>
				</small>				
			</h2>

	    	<div id="pop-<?php the_ID(); ?>" class="entry-footer">
				<p><?php echo $customExcerpt; ?></p>
				<small><?php ekiline_posted_on(); ?></small>
	    		<small><?php ekiline_entry_footer(); ?></small>
	    	</div>

	    </div>	    
	    
</article><!-- #post-## -->

