<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ekiline
 */

get_header(); 

//update: 29 08 2017 columns
$colSet = get_theme_mod('ekiline_Columns'); 
$cssCols = '';
if ($colSet != '0') $cssCols = ' row';
//Modulo bloque
$colClass='col-12';
$colCount='0';
if ($colSet == '1') { $colClass='col-md-6'; $colCount='2'; }
elseif ($colSet == '2') { $colClass='col-md-4'; $colCount='3'; }
elseif ($colSet == '3') { $colClass='col-md-3'; $colCount='4'; }
elseif ($colSet == '4') { $cssCols = ' card-columns'; }
?>

		<?php dynamic_sidebar( 'content-w1' ); ?>		

		<main id="main" class="site-main<?php echo $cssCols; ?>">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header class="entry-header">
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php /* Start the Loop */ ?>
			<?php $count = ''; while ( have_posts() ) : the_post(); $count++; ?>

				<?php
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					//get_template_part( 'template-parts/content', get_post_format() );
                
                if ($colSet > '0' && $colSet < '4') echo '<div class="'.$colClass.'">';
                 
	                if ($colSet == '0') {                    
	                    get_template_part( 'template-parts/content', get_post_format() );                    
	                } else if ($colSet <= '3' ) {
	                	get_template_part( 'template-parts/content', 'block' );                     
	                } else if ($colSet == '4' ) {
						if ( has_post_format( 'image' )) {
		                	get_template_part( 'template-parts/content', 'overcard' );    
						} else {
		                	get_template_part( 'template-parts/content', 'card' );    
						}
	                } 	

                if ($colSet > '0' && $colSet < '4') echo '</div>';
                
                if ($count == $colCount ) : echo '<div class="col-divider"></div>'; $count = 0;  endif;									
					
				?>

			<?php endwhile; ?>

            <?php ekiline_archive_pagination();?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->

		<?php dynamic_sidebar( 'content-w2' ); ?>		

<?php get_footer(); ?>
