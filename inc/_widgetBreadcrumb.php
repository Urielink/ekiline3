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
				
    $breadcrumb = '<li class="breadcrumb-item home1-OK"><a href="'. home_url() .'"> ' . __( 'Home', 'ekiline' ) . ' </a></li>';

    if ( is_category() || is_single() ) {
        
        if( is_category() ) {
            	
			$catName = single_term_title('',false);
            $catid = get_cat_ID( $catName );
    	
			$breadcrumb .= '<li class="breadcrumb-item category2A">' . get_category_parents( $catid, true, '</li><li class="breadcrumb-item category2b">' ) . '</li>';


        } 
        
        if ( is_single() ) {
                
            if ( is_attachment() ){
				//variables para los attachments        
				$attachPost = get_post( get_the_ID() );
				$attachUrl = get_permalink( $attachPost->post_parent );
				$attachParent = get_the_title( $attachPost->post_parent );
            	                    
                // si es un adjunto, muestra el titulo de donde viene
                $breadcrumb .= '<li class="breadcrumb-item single3attachment4"><a href="'.$attachUrl.'" title="Volver a  '.$attachParent.'" rel="gallery">'.$attachParent.'</a></li>';                
                                
            } else {
            	
                $cats = get_the_category( get_the_ID() );
                $cat = array_shift($cats);
        	
				$breadcrumb .= '<li class="breadcrumb-item category2">' . get_category_parents( $cat, true, '</li><li class="breadcrumb-item category2b">' ) . '</li>';
                    
                // // si no es un adjunto, entonces muestra la categoría del post
                // $breadcrumb .= '<li class="breadcrumb-item single3">';
                // // se debe hacer un llamado en particular para mostrar solo la primer categoria del array (por ello se usa array_shift).
                // $breadcrumb .= '<a href="' . esc_url( get_category_link( $cat->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'Ver todo en %s', 'ekiline' ), $cat->name ) ) . '">'. $cat->name .'</a>';
                // $breadcrumb .= '</li>';
                                    
            }
            
            $breadcrumb .= the_title('<li class="breadcrumb-item single4">','</li>', false);
        }            
        
    } elseif ( is_page() ) {
            
        if (is_attachment()){                
            $breadcrumb .= '<li class="breadcrumb-item page5attachment6"><a href="'.$attachUrl.'" title="Volver a '.$attachParent.'" rel="gallery">'.$attachParent.'</a></li>';                
        }            
        
        $breadcrumb .= the_title('<li class="breadcrumb-item page5">','</li>', false);
        
    } elseif ( is_archive() ) {
		// https://developer.wordpress.org/reference/functions/get_the_archive_title/
        $title = '';
	    if ( is_category() ) {
	        $title = single_cat_title( '', false );
	    } elseif ( is_tag() ) {
	        $title = single_tag_title( '', false );
	    } elseif ( is_author() ) {
	        $title = '<span class="vcard">' . get_the_author() . '</span>';
	    } elseif ( is_year() ) {
	        $title = get_the_date( 'Y' );
	    } elseif ( is_month() ) {
	        $title = get_the_date( 'F Y' );
	    } elseif ( is_day() ) {
	        $title = get_the_date( 'F j, Y' );
	    } elseif ( is_post_type_archive() ) {
	        $title = post_type_archive_title( '', false );
	    } elseif ( is_tax() ) {
	        $tax = get_taxonomy( get_queried_object()->taxonomy );
	        $title = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
	    } 

        $breadcrumb .= '<li class="breadcrumb-item archive13">' . $title .'</li>';
    }    
    elseif ( is_search() ) {
        $breadcrumb .= '<li class="breadcrumb-item search12">' . __( 'Search ', 'ekiline' ) . '</li>';
    }
    elseif ( is_404() ) {
        $breadcrumb .= '<li class="breadcrumb-item 404">' . __( 'Not found ', 'ekiline' ) .'</li>';
    }

	echo '<ul class="breadcrumb">' . $breadcrumb . '</ul>';
					
}

	// <ol class="breadcrumb">
		// <li class="breadcrumb-item"> <a href="#">Home</a> </li>
		// <li class="breadcrumb-item"> <a href="#">Library</a> </li>
		// <li class="breadcrumb-item active" aria-current="page"> Data </li>
	// </ol>
