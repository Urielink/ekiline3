<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekilinewp
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>
    
	<?php /* En caso de tener imagen destacada (thumbnail):
	       * Se Agrega un div para dividir la informacion */ ?>

	<?php if ( has_post_thumbnail() ) { $thumbCss = 'col-md-8'; ?>
	
	    <div class="cat-thumb col-md-4 pull-right">
	        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	            <?php the_post_thumbnail(); ?>
	        </a>
	    </div>
	    
	<?php } else { $thumbCss = 'col-md-12'; } ?>
	
    <div class="<?php echo $thumbCss;?>">
    	<header class="entry-header">
    				  	
		  	<?php miniDate();?>
    		
    		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    
    		<?php if ( 'post' === get_post_type() ) : ?>
    		    
    		<div class="entry-meta">
    			<?php ekilinewp_posted_on(); ?>
    		</div><!-- .entry-meta -->

    		<?php endif; ?>
    	</header><!-- .entry-header -->
    
    	<div class="entry-content">

    	     <?php the_excerpt(); ?> 
    	    
    		<?php /**
    			the_content( sprintf(
    				// translators: %s: Name of current post. //
    				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ekilinewp' ), array( 'span' => array( 'class' => array() ) ) ),
    				the_title( '<span class="screen-reader-text">"', '"</span>', false )
    			) ); **/
    		?>
          
    		<?php
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ekilinewp' ),
    				'after'  => '</div>',
    			) );
    		?>
    		
    	</div><!-- .entry-content -->
    
    	<footer class="entry-footer">
    		<?php ekilinewp_entry_footer(); ?>
    	</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
