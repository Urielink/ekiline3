<?php
/**
 * Los menus preestablecidos
 * Default menus top and primary
 *
 * @package ekiline
 */


/**
 * Agregar logotipo a menu
 * Adding logo image to navbar-brand:
 **/
 
function logoTheme() {
    //variables de logotipo
    $logoHor = get_theme_mod( 'ekiline_logo_max' );
    $logoIcono = get_site_icon_url();
    
    if ( $logoHor && !$logoIcono ) {
        echo '<img class="img-fluid" src="' . $logoHor . '" alt="' . get_bloginfo( 'name' ) . '"/>';
    } elseif ( !$logoHor && $logoIcono ) {
        echo '<img class="brand-icon" src="' . $logoIcono . '" alt="' . get_bloginfo( 'name' ) . '"/>' . get_bloginfo( 'name' );
    } elseif ( $logoHor && $logoIcono ) {
        echo '<img class="img-fluid d-none d-md-block" src="' . $logoHor . '" alt="' . get_bloginfo( 'name' ) . '"/>
        <span class="d-block d-md-none"><img class="brand-icon" src="' . $logoIcono . '" alt="' . get_bloginfo( 'name' ) . '"/>' . get_bloginfo( 'name' ) . '</span>';
    } else {
        echo get_bloginfo( 'name' );
    } 
}


/**
 * Todos los menus
 * Se complementa con acciones preestablecidas en customizer.php
 * Works with customizer.php
 **/

function ekilineNavbar($navPosition){

	if ( has_nav_menu( $navPosition ) ){
		
		// invertir color (class css)
        $inverseMenu = 'navbar-light bg-light ';		
		if( true === get_theme_mod('ekiline_inversemenu') ) : $inverseMenu = 'navbar-dark bg-dark ';  endif;
				
		// Variables por cada tipo de menu: configurcion y distribucion de menu	    						
		if ($navPosition == 'top'){
			$actions = get_theme_mod('ekiline_topmenuSettings'); 
			$styles = get_theme_mod('ekiline_topmenuStyles'); 
		}
		if ($navPosition == 'primary'){
			$actions = get_theme_mod('ekiline_primarymenuSettings');
			$styles = get_theme_mod('ekiline_primarymenuStyles'); 
		}
		if ($navPosition == 'modal'){
			$actions = get_theme_mod('ekiline_modalNavSettings');
			$styles = ''; // estos estilos se invocan en el fragmento de modal al final
		}				
		
		//Clases css por configuración de menu
		if ($actions == '0') {
		    $navAction = 'static-top';
	    } elseif ($actions == '1') {
	        $navAction = 'fixed-top'; 
	    } elseif ($actions == '2') {
	        $navAction = 'fixed-bottom'; 
	    } elseif ($actions == '3') {
	        $navAction = 'navbar-sticky'; 
	    }	
				
		//Clases css por estilo de menu
		/*tipos de animacion: .zoom, .newspaper, .move-horizontal, .move-from-bottom, .unfold-3d, .zoom-out, .left-aside, .right-aside */
		if ($styles == '0') {
		    $navAlign = 'mr-auto ';
			$navHelper = '';
	    } else if ($styles == '1') {
	        $navAlign = ''; 
			$navHelper = ' justify-content-md-center ';
	    } else if ($styles == '2') {
	        $navAlign = 'ml-auto '; 
			$navHelper = '';
	    }
		
		// Clases css para mostrar el boton del modal
		if ($navPosition != 'modal'){ $expand = 'navbar-expand-md '; } else { $expand = ' '; }
		
		// Clases reunidas para <nav>
		$navClassCss = 'navbar '. $inverseMenu . $expand . $navPosition . '-navbar ' . $navAction;
		
		// variables para boton modal
		$dataToggle = 'collapse';
		$dataTarget = '.navbar-collapse.'.$navPosition;				
		if ($navPosition == 'modal'): $dataToggle = 'modal'; $dataTarget = '#navModal'; endif; 
			
		//argumentos para personalizar el callback del menu: valores en blanco = top.

        $wpnmCont = '';
	    $wpnmContCss = '';
		$wpnmContId = '';

		if ($navPosition == 'primary') {
	        $wpnmCont = 'div';
	        $wpnmContCss = 'collapse navbar-collapse'.$navPosition.$navHelper;
	        $wpnmContId = 'navbar-collapse-in';
		}
		if ($navPosition == 'top' || $navPosition == 'primary') {
		$wpNavMenuArgs = array(
	                        'menu'              => $navPosition,
	                        'theme_location'    => $navPosition,
	                        'depth'             => 2,                        
	                        'container'         => $wpnmCont,
	                        'container_class'   => $wpnmContCss,
	                        'container_id'      => $wpnmContId,                        
	                        'menu_class'        => 'navbar-nav '.$navAlign,                        
	                        'menu_id'           => $navPosition.'-menu',
	                        'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
	                        'walker'            => new WP_Bootstrap_Navwalker()
                        );	
		}
		 ?>

			<nav id="site-navigation-<?php echo $navPosition; ?>"  class="<?php echo $navClassCss;?>">
			    <div class="container">
		
		            <h2><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php logoTheme(); ?></a></h2>
	
					<?php if ( $navPosition == 'primary' || $navPosition == 'modal' ) { ?> 
					<span class="navbar-text d-none d-sm-block"><?php echo get_bloginfo( 'description' ); ?></span> 
					<?php } ?>
										
		            <button class="navbar-toggler collapsed" type="button" data-toggle="<?php echo $dataToggle; ?>" data-target="<?php echo $dataTarget; ?>">
		      			<!--span class="navbar-toggler-icon"></span--><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
		            </button>

			        <?php if ($navPosition == 'top') { ?>
			        	
				        <div id="navbar-collapse-out" class="collapse navbar-collapse <?php echo $navPosition; ?><?php echo $navHelper;?>">
			
						<span class="navbar-text d-none d-sm-block"><?php echo get_bloginfo( 'description' ); ?></span>        	
								        
			    	        <?php wp_nav_menu( $wpNavMenuArgs ); ?>			
			    	            	
			    			<?php dynamic_sidebar( 'navwidget-nw1' ); ?>     
				        
				        </div>
				        
		        	<?php } elseif ($navPosition == 'primary') { ?>	
		        		
	                    <?php wp_nav_menu( $wpNavMenuArgs ); ?>        
	                                       	                    
	            		<?php dynamic_sidebar( 'navwidget-nw2' ); ?>     
		        			        
		        	<?php } ?>		        
			    </div><!-- .container -->         
			</nav><!-- .site-navigation -->        

	<?php } //endif;

}

/*
 * Fragmento para crear un menu con madal
 */

function ekiline_modalMenuBottom(){
	if ( !has_nav_menu( 'modal' ) )	return;	
	//tipos de animacion: .zoom, .newspaper, .move-horizontal, .move-from-bottom, .unfold-3d, .zoom-out, .left-aside, .right-aside		
	switch ( get_theme_mod('ekiline_modalNavStyles') ) {
	    case 0 : $showModal = ''; break;
	    case 1 : $showModal = 'move-from-bottom '; break;
	    case 2 : $showModal = 'left-aside '; break;
	    case 3 : $showModal = 'right-aside '; break;
	}
	//argumentos para ejecutar el menu
	$wpNavMenuArgs = array(
                'menu'              => 'modal',
                'theme_location'    => 'modal',
                'depth'             => 2,
                'container'         => 'nav',
                'container_class'   => 'modal-body',
                'container_id'      => '',
                'menu_class'        => 'navbar-nav',
                'menu_id'           => 'modal-menu',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker()
            );
			
	{ //template ?> 
<div id="navModal" class="modal fade <?php echo $showModal;?>" tabindex="-1" role="dialog" aria-labelledby="navModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="navModalLabel"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<?php wp_nav_menu( $wpNavMenuArgs ); ?>    			
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php } // fin template

}
add_action( 'wp_footer', 'ekiline_modalMenuBottom', 0 );

