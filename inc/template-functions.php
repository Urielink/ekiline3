<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ekiline
 */

/**
 * Limpiar los caracteres especiales para otras funciones del tema
 * Clean special characters for more ekiline addons or customs.
 */
 
function ekiline_cleanspchar($text) {

    setlocale(LC_ALL, 'en_US.UTF8');
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $alias = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $text);
    $alias = strtolower(trim($alias, '-'));
    $alias = preg_replace("/[\/_|+ -]+/", "-", $alias);

    while (substr($alias, -1, 1) == "-") {
        $alias = substr($alias, 0, -1);
    }
    while (substr($alias, 0, 1) == "-") {
        $alias = substr($alias, 1, 100);
    }

    return $alias;
}

/**
 * Creamos nuevos tamaños de imagen para varios elmentos.
 * Add new image sizes
 * @link https://developer.wordpress.org/reference/functions/add_image_size/
 */
add_action( 'after_setup_theme', 'ekiline_theme_setup' );
function ekiline_theme_setup() {
    add_image_size( 'horizontal-slide', 960, 540, array( 'left', 'top' ) );
    add_image_size( 'vertical-slide', 540, 960, array( 'center', 'top' ) );
    add_image_size( 'square', 540, 540, array( 'center', 'top' ) );
}
 
add_filter( 'image_size_names_choose', 'ekiline_custom_sizes' );
function ekiline_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'horizontal-slide' => __( 'Horizontal carousel', 'ekiline' ),
        'vertical-slide' => __( 'Vertical carousel', 'ekiline'  ),
        'square' => __( 'Squares', 'ekiline'  )
    ) );
}

/**
 * Agregar otras clases css al body para conocer el tipo de contenido.
 * Add custom css class to the array of body classes.
 */
 
function ekiline_body_css( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	//Page Slug Body Class
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	
	// Theming: Ekiline services, Wireframe mode active, show bootstrap divs
	if( true === get_theme_mod('ekiline_wireframe') ){
        $classes[] = 'wf-ekiline';
	}
		
	return $classes;
}
add_filter( 'body_class', 'ekiline_body_css' );



/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function ekiline_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ekiline_pingback_header' );


/**
 * Customizer: Add theme colors (customizer.php).
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/wp_head
 */
 
function ekiline_csscolors() {
        
// Variables de color // Color values
    $bgcolor = '#'.get_background_color();
    $texto = get_option('text_color');
    $enlaces = get_option('links_color');
    $modulos = get_option('module_color');
    $menu = get_option('menu_color');
    $mgradient = get_option('menu_gradient');
    $footer = get_option('footer_color');
    $inverse = get_theme_mod('ekiline_inversemenu');
    // custom rounded elements
    $rangeLmnts = get_theme_mod('ekiline_range_lmnts');
        
    // Si no existen colores, añadir estos // add default value
    if ( !$texto ) : $texto = '#333333'; endif;
    if ( !$enlaces ) : $enlaces = '#337ab7'; endif;
    if ( !$modulos ) : $modulos = '#eeeeee'; endif;
    if ( !$footer ) : $footer = '#eeeeee'; endif;
    if ( $inverse ) : $inverse = '#ffffff;' ; endif;
        
    // Estilos en linea // inline styles
    $miestilo = '
        body{ color:'.$texto.'; }
        a:hover,a:focus,a:active{ color:'.$enlaces.';opacity:.6; }
        .page-title, .jumbotron .entry-title{color:'.$texto.';}
        .navbar.navbar-light.bg-light { background-color:'.$menu.' !important;}
        .navbar.navbar-dark.bg-dark { background-color:'.$menu.' !important;}
        .navbar-light .navbar-brand, .navbar-light .navbar-nav > li > a{ color:'.$texto.'; }
        .navbar-dark .navbar-brand, .navbar-dark .navbar-nav > li > a, a, h1 a, h2 a, h3 a, .pagination>li>a{ color:'.$enlaces.'; }
        .dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover,
        .navbar-light .navbar-nav .show .dropdown-menu>.active>a, .navbar-light .navbar-nav .show .dropdown-menu>.active>a:focus, .navbar-light .navbar-nav .show .dropdown-menu>.active>a:hover,.bg-link{background-color:'.$enlaces.';}
        .pagination>.active>span,.pagination>.active>span:hover{background-color:'.$enlaces.';border-color:'.$enlaces.';}
        .site-footer { background-color: '.$footer.';}         
        .cat-thumb{background:url("'.get_site_icon_url().'") no-repeat center center / 100px;}
        .toggle-sidebars.left-on #secondary,.toggle-sidebars.right-on #third,.bg-footer{background:'.$footer.';}
        #secondary{border-right:1px solid '.$modulos.';} #third{border-left:1px solid '.$modulos.';} 
        .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{border: 1px solid '.$modulos.';}
        .modal-header, .nav-tabs{border-bottom: 1px solid '.$modulos.';} hr, .modal-footer{border-top: 1px solid '.$modulos.';}
        #pageLoad {width: 100%;height: 100%;position: fixed;text-align: center;z-index: 5000;top: 0;left: 0;right: 0;background-color:'.$bgcolor.';}  
        .breadcrumb, .bg-module{ background-color:'.$modulos.'; }
        .carousel-indicators li,.popover-title,.popover,.tooltip-inner,.modal-content,.progress,.alert,.thumbnail,.container .jumbotron,.container-fluid .jumbotron,.label,.navbar-toggle .icon-bar,.navbar-toggle,.nav-tabs-justified > li > a,.nav-pills > li > a,.nav-tabs.nav-justified > li > a,.input-group-addon.input-lg,.input-group-addon.input-sm,.input-group-addon,.input-group-sm > .form-control,.input-group-sm > .input-group-addon,.input-group-sm > .input-group-btn > .btn,.input-group-lg > .form-control,.input-group-lg > .input-group-addon,.input-group-lg > .input-group-btn > .btn,.form-control,.input-sm,.form-group-sm .form-control,.input-lg,.form-group-lg .form-control,.btn,.btn-lg,.btn-group-lg > .btn,.btn-sm,.btn-group-sm > .btn,.btn-sm,.btn-group-xs > .btn,.dropdown-menu,.pagination,.breadcrumb{border-radius:'.$rangeLmnts.'px;}        
        .nav-tabs > li > a{border-radius: '.$rangeLmnts.'px '.$rangeLmnts.'px 0px 0px;}
        .pagination-sm .page-item:first-child .page-link{border-top-left-radius: '.$rangeLmnts.'px;border-bottom-left-radius: '.$rangeLmnts.'px}
        .pagination-sm .page-item:last-child .page-link{border-top-right-radius: '.$rangeLmnts.'px;border-bottom-right-radius: '.$rangeLmnts.'px}
        ';
    // En caso de utilizar dos colores en el menú // if uses 2nd menu color    
    if ( $mgradient != '' ){
        $miestilo .= '
        .navbar-light, .navbar-dark{
            background-image: -webkit-linear-gradient(top, '.$menu.' 0%, '.$mgradient.' 100%);
            background-image: -o-linear-gradient(top, '.$menu.' 0%, '.$mgradient.' 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from('.$menu.'), to('.$mgradient.'));
            background-image: linear-gradient(to bottom, '.$menu.' 0%, '.$mgradient.' 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="'.$menu.'", endColorstr="'.$mgradient.'", GradientType=0);}              
        .navbar-light .navbar-nav > .show > a, .navbar-light .navbar-nav > .active > a,
        .navbar-dark .navbar-nav > .show > a, .navbar-dark .navbar-nav > .active > a {
            background-image: -webkit-linear-gradient(top, '.$mgradient.' 0%, '.$menu.' 100%);
            background-image: -o-linear-gradient(top, '.$mgradient.' 0%, '.$menu.' 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from('.$mgradient.'), to('.$menu.'));
            background-image: linear-gradient(to bottom, '.$mgradient.' 0%, '.$menu.' 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="'.$mgradient.'", endColorstr="'.$menu.'", GradientType=0);}';
    } else {
        $miestilo .= '.navbar-light, .navbar-dark{background-color:'.$menu.';background-image: none;}
        .navbar-light .navbar-nav > .active > a, .navbar-light .navbar-nav > .active > a:focus, .navbar-light .navbar-nav > .active > a:hover, .navbar-light .navbar-nav > .current-menu-ancestor > a {background-color:rgba(0,0,0,.1)}
        .navbar-dark .navbar-nav > .active > a, .navbar-dark .navbar-nav > .active > a:focus, .navbar-dark .navbar-nav > .active > a:hover, .navbar-dark .navbar-nav > .current-menu-ancestor > a {background-color:rgba(0,0,0,.3)}
        ';
                
    }        

    echo '<style id="ekiline-inline" type="text/css" media="all">'.$miestilo.'</style>'."\n";

}
add_action('wp_head','ekiline_csscolors');


/**
 * Customizer: 
 * Establecer el ancho en cada pagina
 * Set CSS class width on #page
 **/

function ekiline_pagewidth() {
    
    if ( is_front_page() || is_home() ){
        echo get_theme_mod( 'ekiline_anchoHome', 'container' );
    }
    elseif ( is_single() || is_page() || is_search() || is_404() ){
        echo get_theme_mod( 'ekiline_anchoSingle', 'container' );
    }        
    elseif ( is_archive() || is_category() ){
        echo get_theme_mod( 'ekiline_anchoCategory', 'container' );
    }    
        
}

/**
 * Theming: 
 * Personalizar el formulario de busqueda
 * Override search form HTML
 **/
 
function ekiline_search_form( $form ) {
    
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
                <label class="screen-reader-text" for="s">' . esc_html__( 'Search Results for: %s', 'ekiline' ) . '</label>
                <div class="input-group">
                    <input class="form-control" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_html__( 'Search Results for:', 'ekiline' ) . '"/>
                    <span class="input-group-btn"><button class="btn btn-secondary" type="submit" id="searchsubmit"><i class="fa fa-search"></i> '. esc_attr__( 'Search', 'ekiline' ) .'</button></span>
                </div>
            </form>';

    return $form;
}

add_filter( 'get_search_form', 'ekiline_search_form' );


/**
 * Theming: 
 * Modificar el extracto
 * Excerpt override
 * @link https://codex.wordpress.org/Function_Reference/the_excerpt
 *
 **/

// Excerpt lenght 
function ekiline_excerpt_length( $length ) {
    
    $cutexcerpt = get_theme_mod('ekiline_cutexcerpt','');
    
    if (!$cutexcerpt){ $cutexcerpt = 20; }
    
    return $cutexcerpt;
}
add_filter( 'excerpt_length', 'ekiline_excerpt_length', 999 );

// Excerpt Button 
function ekiline_excerpt_button( $more ) {
    return '<p><a class="read-more btn btn-secondary" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read more', 'ekiline' ) . '</a></p>';
}
add_filter( 'excerpt_more', 'ekiline_excerpt_button' );


/**
 * Theming: Use a loader.
 **/
 

function ekiline_loader(){
             
    $loader = '<div id="pageLoad"><small class="loadtext">';
            if (get_site_icon_url()) {
                $loader .= '<img class="loadicon" src="'. get_site_icon_url() .'" alt="'. site_url() .'" width="100" height="100"/>'; 
            }
    $loader .= '<br/><noscript>'. __('Javascript is disabled','ekiline') .'</noscript>';
    $loader .= '<br/>'. __('Loading...','ekiline') .'</small></div>';    
    
    if( true === get_theme_mod('ekiline_loader') ){
        echo $loader;
    }
} 


/** 
 * Theming: 
 * Remover los shortcodes existentes en el extracto
 * Excerpt override and Remove [shortcode] items in excerpt: 
 * @link https://wordpress.org/support/topic/stripping-shortcodes-keeping-the-content
 * @link http://wordpress.stackexchange.com/questions/112010/strip-shortcode-from-excerpt 
 * @link **https://wordpress.org/support/topic/how-to-enable-shortcodes-in-excerpts
 * Enero 2018, este arreglo cicla algunos elementos. Es necesario verificar el resto.
 **/

// function wp_trim_excerpt_do_shortcode($text) {
	// $raw_excerpt = $text;
	// if ( '' == $text ) {
		// $text = get_the_content('');
// 
		// $text = do_shortcode( $text ); 
// 
		// $text = apply_filters('the_content', $text);
		// $text = str_replace(']]>', ']]>', $text);
		// $text = strip_tags($text);
		// $excerpt_length = apply_filters('excerpt_length', 55);
		// $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		// $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		// if ( count($words) > $excerpt_length ) {
			// array_pop($words);
			// $text = implode(' ', $words);
			// $text = $text . $excerpt_more;
		// } else {
			// $text = implode(' ', $words);
		// }
	// }
	// return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
// }
// remove_filter('get_the_excerpt', 'wp_trim_excerpt');
// add_filter('get_the_excerpt', 'wp_trim_excerpt_do_shortcode');

/**
 * Theming: 
 * Paginacion para pages aplica solo en internas
 * Next and prevoius links for pages
 * @link https://codex.wordpress.org/Next_and_Previous_Links
 *
 **/

function ekiline_pages_navigation(){
    
    $thePages = '';
    $pagelist = get_pages('sort_column=menu_order&sort_order=asc');
    $pages = array();
    foreach ($pagelist as $page) {
       $pages[] += $page->ID;
    }

    $current = array_search(get_the_ID(), $pages);
    $prevID = (isset($pages[$current-1])) ? $pages[$current-1] : '';
    $nextID = (isset($pages[$current+1])) ? $pages[$current+1] : '';
    
    if (!empty($prevID)) {
        $thePages .= '<li class="previous page-item">';
        $thePages .= '<a class="page-link" href="'. get_permalink($prevID) .'" title="'. get_the_title($prevID) .'">'. __( '&larr; Previous', 'ekiline' ) .'</a>';
        $thePages .= "</li>";
    }
    if (!empty($nextID)) {
        $thePages .= '<li class="next page-item">';
        $thePages .= '<a class="page-link" href="'. get_permalink($nextID) .'" title="'. get_the_title($nextID) .'">'. __( 'Next &rarr;', 'ekiline' ) .'</a>';
        $thePages .= "</li>";      
    }
    
    $thePages = '<ul class="pagination pagination-sm justify-content-center">'.$thePages.'</ul>';
    
    if (!is_front_page()){
        echo $thePages;
    }
} 

/**
 * Theming: 
 * Paginacion para entradas o singles
 * Next and prevoius links for posts in archive or category
 * @link https://codex.wordpress.org/Next_and_Previous_Links
 * @link https://digwp.com/2016/10/wordpress-post-navigation-redux/
 *
 **/

function ekiline_posts_navigation( $args = array() ) {
    $navigation = '';
 
    // Don't print empty markup if there's only one page.
    if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {
        $args = wp_parse_args( $args, array(
            'prev_text'          => __( 'Older posts', 'ekiline' ),
            'next_text'          => __( 'Newer posts', 'ekiline' ),
            'screen_reader_text' => __( 'Posts navigation', 'ekiline' ),
        ) );
 
        $next_link = get_previous_posts_link( $args['next_text'] . ' <span class="fa fa-angle-right"></span>' );
        $prev_link = get_next_posts_link( '<span class="fa fa-angle-left"></span> ' . $args['prev_text'] );
 
        if ( $prev_link ) {
            $navigation .= '<li class="previous page-item page-link">' . $prev_link . '</li>';
        }
 
        if ( $next_link ) {
            $navigation .= '<li class="next page-item page-link">' . $next_link . '</li>';
        }
        
        $navigation = '<ul class="pagination justify-content-center">'.$navigation.'</ul>';
 
        $navigation = _navigation_markup( $navigation, 'posts-navigation', $args['screen_reader_text'] );
    }
 
    echo $navigation;
}

/**
 * Theming: 
 * Paginacion para listados
 * Paginate links
 * @link https://codex.wordpress.org/Function_Reference/paginate_links
 * @link https://brinidesigner.com/wordpress-custom-pagination-for-bootstrap/
 **/

function ekiline_archive_pagination() {
    
    global $wp_query;
    $big = 999999999;
    $pagination = '';
    
    $pages = paginate_links(array(
                'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                'format' => '?page=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $wp_query->max_num_pages,
                'prev_next' => false,
                'type' => 'array',
                'prev_next' => TRUE,
                'prev_text' => __( '&larr; Previous', 'ekiline' ),
                'next_text' => __( 'Next &rarr;', 'ekiline' ),
            ));
            
    if (is_array($pages)) {
        
        $current_page = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
        
        $pagination .= '<ul class="pagination">';
        
        foreach ($pages as $i => $page) {
            //27 10 17 add CSS B4 pagination
            $page = str_replace( 'page-numbers', 'page-link', $page );			
			
            if ($current_page == 1 && $i == 0) {
                
                $pagination .= "<li class='page-item active'>$page</li>";
                
            } else {
                
                if ($current_page != 1 && $current_page == $i) {
                    
                    $pagination .= "<li class='page-item active'>$page</li>";
                    
                } else {
                    
                    $pagination .= "<li class='page-item'>$page</li>";
                    
                }
            }
            
        }
        
        $pagination .= '</ul>';
        
    }
    
    echo $pagination;
   
}


/**
 * Widgets: Set top widgets (header.php #25)
 **/

if ( ! function_exists ( 'topWidgets' ) ) {
    
	function topWidgets(){
		if ( is_active_sidebar( 'toppage-w1' ) ) {
		    return '<div class="row top-widgets">'.dynamic_sidebar( 'toppage-w1' ).'</div>';
		}
	}
}

/**
 * Customizer: Disable all media comments (customizer.php#371).
 **/
 
if( true === get_theme_mod('ekiline_mediacomment') ){
         
     function filter_media_comment_status( $open, $post_id ) {
        $post = get_post( $post_id );
        if( $post->post_type == 'attachment' ) {
            return false;
        }
        return $open;
    }
    add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );

}


/** Boton en menu con popwindow
 * https://codex.wordpress.org/Plugin_API/Action_Reference/wp_before_admin_bar_render
 * https://codex.wordpress.org/Javascript_Reference/ThickBox
 * Y con estilos agregados.
 * https://codex.wordpress.org/Function_Reference/wp_add_inline_style
 * https://gist.github.com/corvannoorloos/43980115659cb5aee571
 * https://wordpress.stackexchange.com/questions/36394/wp-3-3-how-to-add-menu-items-to-the-admin-bar
 * https://wordpress.stackexchange.com/questions/266318/how-to-add-custom-submenu-links-in-wp-admin-menus
 */

function ekiline_bar() {

	global $wp_admin_bar;

	// if ( !is_admin_bar_showing() )
		// return;	
	
		$wp_admin_bar->add_menu( array(
			'id' => 'goekiline',
			'title' => __( 'FundMe', 'ekiline'),
			// 'href' => 'http://ekiline.com/fondeo/?TB_iframe=true&width=600&height=550',
			'href' => 'http://ekiline.com/fondeo/',
			'meta' => array( 
				'class' => 'gold',
				'target' => '_blank'
				//'onclick' => 'jQuery(this).addClass("thickbox");'
				),
	        'parent' => 'top-secondary'		
		) );
		
} 
add_action('admin_bar_menu', 'ekiline_bar', 0 ); 


/* subitem https://wordpress.stackexchange.com/questions/66498/add-menu-page-with-different-name-for-first-submenu-item 
 * http://wpsites.net/wordpress-admin/add-top-level-custom-admin-menu-link-in-dashboard-to-any-url/
 * https://developer.wordpress.org/reference/functions/add_ menu_page/
 * https://wordpress.stackexchange.com/questions/1039/adding-an-arbitrary-link-to-the-admin-menu
 * // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
 */

// add_action( 'admin_menu', 'register_ekiline_menu_page' );
// function register_ekiline_menu_page() {
  // add_menu_page( 
  	// 'Ekiline Menu Page Title', 
  	// __( 'FundMe', 'ekiline'), 
  	// //'manage_options', 
  	// 'edit_posts', 
  	// 'themes.php?theme=ekiline',
  	// '', 
  	// 'dashicons-carrot', 
  	// null );
// }

// add_action( 'admin_footer', 'ekiline_menu_page_js' );
// function ekiline_menu_page_js() { 
	// echo "<script type='text/javascript'>\n";
	// //echo "jQuery('li#toplevel_page_themes-theme-ekiline a').addClass('gold thickbox').attr('href', 'http://ekiline.com/fondeo/?TB_iframe=true&width=600&height=550').attr('target', '_blank');";
	// echo "jQuery('li#toplevel_page_themes-theme-ekiline a').addClass('gold').attr('href', 'http://ekiline.com/fondeo/').attr('target', '_blank');";
	// echo "\n</script>";
// }

function ekiline_theme_page() {
    add_theme_page( 
    	'Ekiline Menu Page Title', 
    	__( 'About Ekiline', 'ekiline'), 
    	'edit_posts', 
    	'ekiline_options', 
    	'theme_html_page',
    	'dashicons-chart-pie'
	);
}
add_action( 'admin_menu', 'ekiline_theme_page' );
 
function theme_html_page() { ?>
<div class="wrap">
	<h1><span class="dashicons dashicons-layout" aria-hidden="true"></span> <?php echo __('About Ekiline for Wordpress','ekiline'); ?></h1>
    
	<div id="welcome-panel" class="welcome-panel">
		
		<div class="welcome-panel-content">
	
			<h2><?php echo __('Gracias por utilizar este tema!','ekiline'); ?></h2>
			<hr />
			<p class="about-description">Aqui encontraras enlaces de apoyo para la personalizacion de tu sitio.</p>
				
			<div class="welcome-panel-column-container">
				<div class="welcome-panel-column">
					<h3>Obten la version definitiva</h3>
					<a class="button button-primary button-hero" href="<?php echo __('http://ekiline.com/docs/','ekiline'); ?>">Solo $250 mxn</a>
					<p>o, <a href="<?php echo __('http://ekiline.com/fondeo/','ekiline'); ?>"> fondea el desarrollo</a></p>
				</div>
				<div class="welcome-panel-column">
					<h3>Documentacion</h3>
					<ul>
						<li><a href="http://localhost:8888/wtdv/wp-admin/post.php?post=2&amp;action=edit" class="welcome-icon welcome-edit-page">Edita tu pagina de inicio</a></li>
						<li><a href="http://localhost:8888/wtdv/wp-admin/post-new.php?post_type=page" class="welcome-icon welcome-add-page">Agrega paginas adicionales</a></li>
						<li><a href="http://localhost:8888/wtdv/" class="welcome-icon welcome-view-site">Ver tu sitio</a></li>
					</ul>
				</div>
				<div class="welcome-panel-column welcome-panel-last">
					<h3>Mas acciones</h3>
					<ul>
						<li><div class="welcome-icon welcome-widgets-menus">Gestiona <a href="http://localhost:8888/wtdv/wp-admin/widgets.php">widgets</a> o <a href="http://localhost:8888/wtdv/wp-admin/nav-menus.php">menus</a></div></li>
						<li><a href="http://localhost:8888/wtdv/wp-admin/options-discussion.php" class="welcome-icon welcome-comments">Activa o desactiva los comentarios</a></li>
						<li><a href="https://codex.wordpress.org/First_Steps_With_WordPress" class="welcome-icon welcome-learn-more">Aprende mas de como comenzar</a></li>
					</ul>
				</div>
			</div>			
	
	
		</div>
	</div>    
    
</div>
<?php }


function ekiline_admin_styles() {
	// if ( !is_super_admin() )
		// return;	
	$extracss = '.gold a::before { content: "\f511";} .gold a{ background-color: #58aa03 !important; } .gold:hover a{ background-color: #ffb900 !important; color: #fff !important; } .gold:hover a::before { content: "\f339"; color: #fff !important; }'; 				    
	$extracss .= '.advice a::before { content: "\f325";} .advice a { background-color: #ff7e00 !important; } .advice:hover a { background-color: #ff7e00 !important; color: #fff !important; } .advice:hover a::before { content: "\f325"; color: #fff !important; }'; 				    
	$extracss .= 'a.gold{ background-color: #58aa03 !important; } a.gold:hover{ background-color: #ffb900 !important; color: #fff !important; } a.gold:hover .dashicons-carrot::before {content: "\f339";color: #fff !important;}'; 				    
    wp_add_inline_style( 'wp-admin', $extracss );
    wp_add_inline_style( 'ekiline-style', $extracss );
}
add_action( 'admin_enqueue_scripts', 'ekiline_admin_styles' );
add_action( 'wp_enqueue_scripts', 'ekiline_admin_styles' );

