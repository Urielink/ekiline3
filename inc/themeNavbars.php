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

	$navTop = get_theme_mod('ekiline_topmenuSettings');
    $navMain = get_theme_mod('ekiline_primarymenuSettings');
    $navMod = get_theme_mod('ekiline_modalNavSettings');
	
	if ($navTop || $navMain || $navMod == '0') {
	    $navAction = ' static-top';
    } else if ($navTop || $navMain || $navMod == '1') {
        $navAction = ' fixed-top'; 
    } else if ($navTop || $navMain || $navModp == '2') {
        $navAction = ' fixed-bottom'; 
    } else if ($navTop || $navMain || $navMod == '3') {
        $navAction = ' navbar-sticky'; 
    }	
    
	if( true === get_theme_mod('ekiline_inversemenu') ){
	    $inverseMenu = 'navbar-dark bg-dark'; 
    } else {
        $inverseMenu = 'navbar-light bg-light';
    }
	
	$navTopStyle = get_theme_mod('ekiline_topmenuStyles');
	$navMainStyle = get_theme_mod('ekiline_primarymenuStyles');
	$navModStyle = get_theme_mod('ekiline_modalNavStyles');
	
	if ($navTopStyle || $navMainStyle || $navModStyle == '0') {
	    $navAlign = ' mr-auto';
		$navHelper = '';
	    $showModal = '';
    } else if ($navTopStyle || $navMainStyle || $navModStyle == '1') {
        $navAlign = ''; 
		$navHelper = ' justify-content-md-center';
        $showModal = 'move-from-bottom'; 
    } else if ($navTopStyle || $navMainStyle || $navModStyle == '2') {
        $navAlign = ' ml-auto'; 
		$navHelper = '';
        $showModal = 'left-aside'; 
    } else if ($navTopStyle || $navMainStyle || $navModStyle == '3') {
        $showModal = 'right-aside'; 
    } 		
	
	// if ( has_nav_menu( $navPosition ) || has_nav_menu( $navPosition ) || has_nav_menu( $navPosition ) ){
// 
		// if ($navPosition == 'top') : echo 'menu superior'; endif;
		// if ($navPosition == 'primary') : echo 'menu normal'; endif;
		// if ($navPosition == 'modal') : echo 'menu modal'; endif;
// 		
	// }

	if ( has_nav_menu( $navPosition ) || has_nav_menu( $navPosition ) || has_nav_menu( $navPosition ) ){
	
		if ( has_nav_menu( 'top' ) ) : ?>
		
		<nav id="site-navigation-top"  class="navbar <?php echo $inverseMenu;?> navbar-expand-md top-navbar<?php echo $navAction;?>">
		    <div class="container">
	
	            <h2><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php logoTheme(); ?></a></h2>
	                        
	            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse.top">
	      			<!--span class="navbar-toggler-icon"></span--><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
	            </button>
	
		        
		        <div id="navbar-collapse-out" class="collapse navbar-collapse top<?php echo $navHelper;?>">
	
				<span class="navbar-text d-none d-sm-block"><?php echo get_bloginfo( 'description' ); ?></span>        	
		        
	    	        <?php wp_nav_menu( 
	                        array(
	        	                'menu'              => 'top',
	        	                'theme_location'    => 'top',
	        	                'depth'             => 2,
	        	                'container'         => '',
	        	                'menu_class'        => 'navbar-nav'.$navAlign,
	        	                'menu_id'           => 'top-menu',
	                            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
	        	                'walker'            => new WP_Bootstrap_Navwalker()
	    	                )
	    	              ); ?>
	    	
	    			<?php dynamic_sidebar( 'navwidget-nw1' ); ?>     
		        
		        </div>
		    </div><!-- .container -->         
		</nav><!-- .site-navigation -->         
		<?php endif; 
	
	}	
	
	
	
} 
