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
			'description' => __('Add bootstrap breadcrumb','ekiline'),
		);
		parent::__construct( 'ekilineBreadcrumb', __('Show breadcrumb','ekiline'), $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		
	/** 
	 * Para sobrescribir un widget, en este caso ekiline, agrega opciones css y tipo de mestreo,
	 * entonces es necesario llamar un widget, obteniendo su id y llamando el dato que necesitamos.
	 * 
	 **/	
    global $wp_registered_widgets;
    $widget_id = $args['widget_id'];
    $widget_obj = $wp_registered_widgets[$widget_id];
    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
    $widget_num = $widget_obj['params'][0]['number'];
	$css_style = $widget_opt[$widget_num]['css_style'];
		
	    $args = array(
	        'before_widget' => '<nav id="'. $args['widget_id'] .'" class="'. $css_style .' widget '. $args['widget_id'] .'">',
	        'after_widget'  => '</nav>',
	    );     

		// outputs the content of the widget
		 echo $args['before_widget'];
		// echo str_replace('<div', '<nav', $args['before_widget'] );
		
		// if ( ! empty( $instance['title'] ) ) {
			// echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		// }
		// echo esc_html__( 'Hello, World!', 'text_domain' );
		
		echo createBreadcrumb();
		
		 echo $args['after_widget'];		
		// echo str_replace('div>', 'nav>', $args['after_widget'] );
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

/**add_action( 'widgets_init', function(){
	register_widget( 'ekilineBreadcrumb' );
});**/ // esto no funciona en php5

function ekilineBreadcrumb_register_widgets() {
    register_widget( 'ekilineBreadcrumb' );
}
add_action( 'widgets_init', 'ekilineBreadcrumb_register_widgets' );

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
				// https://wordpress.stackexchange.com/questions/140362/wordpress-breadcrumb-depth
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
				
				if ( get_post_type( get_the_ID() ) != 'product'){
					//en caso de woocommerce
					$breadcrumb .= '<li class="breadcrumb-item single-category">' . get_category_parents( $cat, true, '</li><!--.single-category--><li class="breadcrumb-item single-category-child">');
				} else {
					$breadcrumb .= '<li class="breadcrumb-item single-category">';
				}


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
			// auxiliar para mostrar solo el padre
			$parentobj = $catobj->parent;
			
	        
	        if ($catobj->category_parent > 0){
	        	// este muestra toda una lista
				// $breadcrumb .= '<li class="breadcrumb-item category-parent">' . get_category_parents( $catid, true, '</li><!--.category-parent--><li class="breadcrumb-item category-child">' );
				$breadcrumb .= '<li class="breadcrumb-item category-parent">' . get_category_parents( $parentobj, true, '</li><!--.category-parent--><li class="breadcrumb-item category-child">' ). $catName;
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
	        $title = '<li class="breadcrumb-item tax">' . single_term_title( '', false );
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
