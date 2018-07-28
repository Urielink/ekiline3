<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

/**
 * En lugar de crear un breadcrumb fijo, mejor lo transformo a widget .
 * https://codex.wordpress.org/Widgets_API
 * https://www.cssigniter.com/extending-wordpress-core-3rd-party-widgets/
 *
 */

class ekilineBreadcrumb extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'ekilineBreadcrumb',
			'description' => 'Add bootstrap breadcrumb',
		);
		parent::__construct( 'ekilineBreadcrumb', 'Show breadcrumb', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
				
	    //** $args = array(
	        // 'before_widget' => '<nav id="%1$s" class="widget %2$s">',
	        // 'after_widget'  => '</nav>',
	    // );     

		// outputs the content of the widget
		//* echo $args['before_widget'];
		echo str_replace('<div', '<nav', $args['before_widget'] );
		
		// if ( ! empty( $instance['title'] ) ) {
			// echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		// }
		// echo esc_html__( 'Hello, World!', 'text_domain' );
		
		echo createBreadcrumb();
		
		//* echo $args['after_widget'];		
		echo str_replace('div>', 'nav>', $args['after_widget'] );
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'ekilineBreadcrumb' );
});

function createBreadcrumb(){
	
    if ( is_home() || is_front_page() ) return;	
				
    $breadcrumb = '<li class="breadcrumb-item home"><a href="'. home_url() .'"> ' . __( 'Home', 'ekiline' ) . ' </a></li><!--.home-->';

    
    if ( is_page() || is_single() ) {

            if ( is_attachment() ){
				//variables para los attachments        
				$attachPost = get_post( get_the_ID() );
				$attachUrl = get_permalink( $attachPost->post_parent );
				$attachParent = get_the_title( $attachPost->post_parent );
            	                    
                // si es un adjunto, muestra el titulo de donde viene
                $breadcrumb .= '<li class="breadcrumb-item single-attachment"><a href="'.$attachUrl.'" title="Volver a  '.$attachParent.'" rel="gallery">'.$attachParent.'</a></li><!--.single-attachment--><li class="breadcrumb-item single-category-child">';                
                                
            } elseif ( is_page()  ) {
            	
				//Si es pagina y tiene herencia, padres.
				// 1) Se llama la variable global para hacer un loop de paginas.
    			global $post;
				// 2) confirmamos si tiene herencia, si no brinca al final (3)
				if ( $post->post_parent ) {
	               //se llama al padre de esta página
				    $parent_id  = $post->post_parent;
	               //establezco mi variable para crear una lista de las paginas superirores
				    $breadcrumbs = array();
	               //doy formato los items de este array.
				    while ( $parent_id ) {
				        $page = get_page( $parent_id );
				        $breadcrumbs[] = '<li class="breadcrumb-item post-parent"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li><!--.post-parent-->';
				        $parent_id  = $page->post_parent;
				    }
					//organizo el array para que el orden sea inverso
				    $breadcrumbs = array_reverse( $breadcrumbs );
					// creo un loop por cada loop
				    foreach ( $breadcrumbs as $crumb ) {
				        $breadcrumb .= $crumb;
				    }
					//cierro el HTML.
					$breadcrumb .= '<li class="breadcrumb-item post-childB">';
					
	                
	            } else {
				// 3) Final de loop
	                $breadcrumb .= '<li class="breadcrumb-item post-childA">';                	                                    
	            }		
                                    
            } elseif ( is_single() ) {

                $cats = get_the_category( get_the_ID() );
                $cat = array_shift($cats);
        	
				$breadcrumb .= '<li class="breadcrumb-item single-category">' . get_category_parents( $cat, true, '</li><!--.single-category--><li class="breadcrumb-item single-category-child">' );

			}

        $breadcrumb .= the_title('','</li><!--.single-category-child.post-child-->', false);

    }

    if ( is_archive() ) {
		// https://developer.wordpress.org/reference/functions/get_the_archive_title/
        $title = '';
	    if ( is_category() ) {

			$catName = single_term_title('',false);
            $catid = get_cat_ID( $catName );
			// diferenciar si hay categorías padre:  
			// https://wordpress.stackexchange.com/questions/11267/check-is-category-parent-or-not-from-its-id   
			$catobj = get_category($catid);
	        
	        if ($catobj->category_parent > 0){
				$breadcrumb .= '<li class="breadcrumb-item category-parent">' . get_category_parents( $catid, true, '</li><!--.category-parent--><li class="breadcrumb-item category-child">' );
		    } else {
				$breadcrumb .= '<li class="breadcrumb-item category-child">' . get_category_parents( $catid, false, '' );
		    }
	        
	        
	    } elseif ( is_tag() ) {
	        $title = '<li class="breadcrumb-item tag">' . single_tag_title( '', false );
	    } elseif ( is_author() ) {
	        $title = '<li class="breadcrumb-item author">' . '<span class="vcard">' . get_the_author() . '</span>';
	    } elseif ( is_year() ) {
	        $title = '<li class="breadcrumb-item year">' . get_the_date( 'Y' );
	    } elseif ( is_month() ) {
	        $title = '<li class="breadcrumb-item month">' . get_the_date( 'F Y' );
	    } elseif ( is_day() ) {
	        $title = '<li class="breadcrumb-item day">' . get_the_date( 'F j, Y' );
	    } elseif ( is_post_type_archive() ) {
	        $title = '<li class="breadcrumb-item ptArchive">' . post_type_archive_title( '', false );
	    } elseif ( is_tax() ) {
	        $tax = get_taxonomy( get_queried_object()->taxonomy );
	        $title = '<li class="breadcrumb-item tax">' . sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
	    } 

        $breadcrumb .= $title .'</li><!--.category-child.tag.author.year.month.day.ptArchive.tax-->';

    }    
    
	if ( is_search() ) {
        $breadcrumb .= '<li class="breadcrumb-item search">' . __( 'Search ', 'ekiline' ) . '</li><!--.search-->';
    }
    
	if ( is_404() ) {
        $breadcrumb .= '<li class="breadcrumb-item 404">' . __( 'Not found ', 'ekiline' ) .'</li><!--.404-->';
    }

	echo '<ul class="breadcrumb">' . $breadcrumb . '</ul>';
					
}

	// <ol class="breadcrumb">
		// <li class="breadcrumb-item"> <a href="#">Home</a> </li>
		// <li class="breadcrumb-item"> <a href="#">Library</a> </li>
		// <li class="breadcrumb-item active" aria-current="page"> Data </li>
	// </ol>
