<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 * @link https://make.wordpress.org/themes/2012/04/06/updating-custom-backgrounds-and-custom-headers-for-wordpress-3-4/
 *
 * @package ekiline
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses ekiline_header_style()
 */
 
add_action( 'after_setup_theme', 'ekiline_custom_header_setup' );

function ekiline_custom_header_setup() {
	add_theme_support( 'custom-header', 
    	apply_filters( 'ekiline_custom_header_args', array(
            'default-image'          => get_parent_theme_file_uri('/img/ekiline-pattern.png'),
    		'default-text-color'     => '000000',
    		'width'                  => 1680,
    		'height'                 => 1050,
    		'flex-height'            => true,
    		'wp-head-callback'       => 'ekiline_header_style',
    	   )
        ) 
    );
    register_default_headers( array(
        'default-image' => array(
            'url'           => '%s/img/ekiline-pattern.png',
            'thumbnail_url' => '%s/img/ekiline-pattern.png',
            'description'   => __( 'Default Header Image', 'ekiline' ),
        ),
    ) );   
}

if ( ! function_exists( 'ekiline_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see ekiline_custom_header_setup().
 */
    function ekiline_header_style() {
    	$header_text_color = get_header_textcolor();
    
    	/*
    	 * If no custom options for text are set, let's bail.
    	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
    	 */
    	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
    		return;
    	}
    
    	// If we get this far, we have custom styles. Let's do this.
    	?>
    	<style>
    	<?php
    		// Has the text been hidden?
    		if ( ! display_header_text() ) :
    	?>
    		.site-title, .site-description, .cover-title, .cover-description { position: absolute; clip: rect(1px, 1px, 1px, 1px); }
    	<?php
    		// If the user has set a custom color for the text use that.
    		else :
    	?>
    		.site-title, .site-title a, .site-description, .cover-title, .cover-title a, .cover-description, .site-branding.jumbotron, .inner.cover, .video-text { color: #<?php echo esc_attr( $header_text_color ); ?>; }
    		
    	<?php endif; ?>
    	</style>
    	<?php
    }
endif;  // ekiline_admin_header_image

/**
 * Header de Ekiline, se habilita con la existencia de una imagen, 
 * y permite establecer un formato de portada completa o de altura variable.
 * trabaja en conjunto con customizer.php
 *
 * Ekiline theming: Advanced header fucntion.
 * Works by choosing an image, and setting it in customizer. 
 */

function ekiline_addCssHeader() {
	$headerImage = get_header_image();
	if ( is_single() || is_page() ) {		
		$medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
		// si tiene imagen
		if ( has_post_thumbnail() ) $headerImage = $medium_image_url[0];
	}
	if ( is_category() ) {
		$cat_id = get_query_var('cat');
		$cat_data = get_option("category_$cat_id");
		// si tiene imagen
		if ( $cat_data['img'] ) $headerImage = $cat_data['img'];
	}		
    $rangeHead = get_theme_mod('ekiline_range_header');
	if ( $rangeHead == '0' ) $rangeHead = '30';
	$setVideo = get_theme_mod('ekiline_video');

	$extracss = '';
	if ( is_front_page() && empty( $setVideo ) ) $extracss .= '.cover-wrapper,.jumbotron{height:' . $rangeHead . 'vh;}';
	if ( is_front_page() && !empty( $setVideo ) ) $extracss .= '.cover-wrapper-inner,.cover-header,.cover-footer{position:relative;}.cover-container{position: absolute;z-index:100;left: 0;right: 0;height:100%;}';
	if ( get_header_image() ) $extracss .= '.cover-wrapper,.jumbotron{background-image:url("' . $headerImage . '");}';		
			    	
    // wp_add_inline_style( 'ekiline-style', $extracss );
    echo '<style id="ekiline-inline-header" media="all">'.$extracss.'</style>'."\n";
        
}
// add_action( 'wp_enqueue_scripts', 'ekiline_addCssHeader'); 
add_action('wp_head','ekiline_addCssHeader', 100);

function customHeader(){

	//datos del sitio
    $siteName = get_bloginfo( 'name', 'display' );
    $siteDescription = '<i>' . get_bloginfo( 'description', 'display'  ) . '</i>';
    // agregar brand image // add brand image
    $coverLogo = get_theme_mod( 'ekiline_logo_min' );            
    if ( $coverLogo ) $coverLogo = '<img class="cover-header-brand author img-fluid" src="' . get_theme_mod( 'ekiline_logo_min' ) . '" alt="' . get_bloginfo( 'name' ) . '"/>';
	//variables para la información del tema
	$headerSwitch = 'site-branding jumbotron m-0';
	$headerTitle = '<a href="'.esc_url( home_url( '/' ) ).'" rel="home">'.$siteName.'</a>';
	// semantica html por posicion de objetos
	$tagHead = 'header';
	$tagTitle = 'h1';
	if ( has_nav_menu( 'top' ) ) $tagHead = 'div'; $tagTitle = 'h2';
	
	//Personalizaciones
    $rangeHead = get_theme_mod('ekiline_range_header');
	$setVideo = get_theme_mod('ekiline_video');
    // Permitir el uso de HTML a la vista // Alllow html on output
    // https://blog.templatetoaster.com/wordpress-wp-kses/
    $headerText = get_theme_mod( 'ekiline_headertext', '' );
    	$headerText = wp_kses_post( $headerText );            	
	
	// Condiciones
	if ( is_front_page() && true === get_theme_mod('ekiline_showFrontPageHeading') ){		
		if ( $rangeHead == '100' ) $headerSwitch = 'inner cover';
	}
	else if ( is_single() && true === get_theme_mod('ekiline_showEntryHeading') || is_page() && true === get_theme_mod('ekiline_showPageHeading') ) {
		$siteDescription = $headerTitle . ' '. $siteDescription;
		$headerTitle = get_the_title();
	}
	else if ( is_category() && true === get_theme_mod('ekiline_showCategoryHeading') ){
		$siteDescription = $headerTitle . ' ' . $siteDescription;
		$headerTitle = single_cat_title('', false);
	}
	else if ( get_post_type( get_the_ID() ) == 'product' && !is_front_page() ){
		//cancelar si es producto de woocommerce
		return;
	}
	else return;		
	// Header y cambios
	{ ?>
		
		<<?php echo $tagHead; ?> id="masthead" class="site-header">
	
		<?php if ( is_front_page() && $rangeHead == '100' ) { ?>
			<div class="cover-wrapper">
		      <div class="cover-wrapper-inner">
		        <div class="cover-container">
		        	
		          <div class="cover-header clearfix">
		            <div class="inner">
		              <?php echo $coverLogo; ?>
		              <div class="nav cover-header-nav justify-content-md-end justify-content-center">El menu</div>		              
		            </div>
		          </div>
		          
		<?php } ;?>
		
		          <div class="<?php echo $headerSwitch;?>">
		

				    	<?php 
				    	if( $headerText && is_front_page() ) {
				    		 echo $headerText ; 
						} else { ?>		
							<<?php echo $tagTitle; ?> class="site-title entry-title"><?php echo $headerTitle ;?></<?php echo $tagTitle; ?>>                              														
					    	<p class="site-description"> <?php echo $siteDescription ;?> </p>				    		
				    	<?php } ?>
			    	
			    	
		
				  </div>
		
		<?php if ( is_front_page() && $rangeHead == '100' ) { ?>
			
		          <div class="cover-footer text-right">
		            <div class="inner">
		             <small class="author">&copy; Copyright <?php echo $siteName ;?></small>
		            </div>
		          </div>
			       
		        </div>

			<?php if ( ! empty( $setVideo ) ) { ?>                 
                <!--[if lt IE 9]><script>document.createElement("video");</script><![endif]-->
				<div class="video-media embed-responsive embed-responsive-16by9">
                    <video autoplay loop poster="<?php echo get_header_image() ;?>" id="bgvid">
                        <source src="<?php echo $setVideo ;?>" type="video/mp4">
                    </video>
                    <button id="vidpause" class="btn btn-secondary btn-sm"><?php echo __( 'Pause', 'ekiline' ) ;?></button>
                </div>
            <?php } ?>


			  </div><!-- cover-wrapper-inner -->
		    </div><!-- cover-wrapper -->	    
		<?php } ;?>

		</<?php echo $tagHead; ?>><!-- #masthead -->
		
		
	<?php }
	
} // Fin customHeader();
 

function ekiline_addJsHeader() {
	
	if ( is_front_page() && get_theme_mod('ekiline_video') ){
	
	{ ?>
<script>
    var vid = document.getElementById("bgvid");
    pauseButton = document.getElementById("vidpause");
    
    if (window.matchMedia("(prefers-reduced-motion)").matches) {
        vid.removeAttribute("autoplay");
        vid.pause();
        pauseButton.innerHTML = "<?php echo __( 'Pause', 'ekiline' ); ?>";
    }
    
    function vidFade() {
        vid.classList.add("stopfade");
    }
    
    vid.addEventListener("ended", function() {
        vid.pause();
        vidFade();
    });
    
    pauseButton.addEventListener("click", function() {
        vid.classList.toggle("stopfade");
        if (vid.paused) {
            vid.play();
            pauseButton.innerHTML = "<?php echo __( 'Pause', 'ekiline' ); ?>";
        } else {
            vid.pause();
            pauseButton.innerHTML = "<?php echo __( 'Play', 'ekiline' ); ?>";
        }
    });
</script> 
	<?php }
	
	}

}
add_action( 'wp_footer', 'ekiline_addJsHeader', 110 );
