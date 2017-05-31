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
        echo '<img class="img-responsive" src="' . $logoHor . '" alt="' . get_bloginfo( 'name' ) . '"/>';
    } elseif ( !$logoHor && $logoIcono ) {
        echo '<img class="brand-icon" src="' . $logoIcono . '" alt="' . get_bloginfo( 'name' ) . '"/>' . get_bloginfo( 'name' );
    } elseif ( $logoHor && $logoIcono ) {
        echo '<img class="img-responsive hidden-xs" src="' . $logoHor . '" alt="' . get_bloginfo( 'name' ) . '"/>
        <span class="visible-xs"><img class="brand-icon" src="' . $logoIcono . '" alt="' . get_bloginfo( 'name' ) . '"/>' . get_bloginfo( 'name' ) . '</span>';
    } else {
        echo get_bloginfo( 'name' );
    } 
}

/**
 * Top menu
 * Se complementa con acciones preestablecidas en customizer.php
 * Works with customizer.php
 **/

function topNavbar(){

	$navSet = get_theme_mod('ekiline_topmenuSettings');
	
	if ($navSet == '0') {
	    $navAction = ' navbar-static-top';
    } else if ($navSet == '1') {
        $navAction = ' navbar-fixed-top'; 
    } else if ($navSet == '2') {
        $navAction = ' navbar-fixed-bottom'; 
    } else if ($navSet == '3') {
        $navAction = ' navbar-affix'; 
    }	
    
	if( true === get_theme_mod('ekiline_inversemenu') ){
	    $inverseMenu = 'navbar-inverse'; 
    } else {
        $inverseMenu = 'navbar-default';
    }
	
		
	if ( has_nav_menu( 'top' ) ) : ?>
	
	<nav id="site-navigation-top"  class="navbar <?php echo $inverseMenu;?> top-navbar<?php echo $navAction;?>" role="navigation">
	    <div class="container">
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse.top">
	                <span class="sr-only">Toggle navigation</span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </button>
	            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php logoTheme(); ?></a>
	        </div>
	        
	        <div id="navbar-collapse-out" class="collapse navbar-collapse top">
				<p class="navbar-text hidden-xs"><?php echo get_bloginfo( 'description' ); ?></p>        	
	        
    	        <?php wp_nav_menu( 
                        array(
        	                'menu'              => 'top',
        	                'theme_location'    => 'top',
        	                'depth'             => 2,
        	                'container'         => '',
        	                'menu_class'        => 'nav navbar-nav navbar-right',
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



/**
 * Primary menu (wordpress default)
 * Este se activa dentro del contenedor general (#page)
 * This is wp default menu position, it appears inside general container (#page)
 **/

function primaryNavbar(){

    if( true === get_theme_mod('ekiline_inversemenu') ){
         $inverseMenu = 'navbar-inverse'; 
    } else {
         $inverseMenu = 'navbar-default';
    }
    	
    if ( has_nav_menu( 'primary' ) ) : ?>
    
            <nav id="site-navigation-primary"  class="navbar <?php echo $inverseMenu;?> primary-navbar" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse.primary">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php logoTheme(); ?></a>
                </div><!-- .navbar-header -->
                
    
                <!-- The WordPress Menu goes here -->
                <?php wp_nav_menu( array(
                        'menu'              => 'primary',
                        'theme_location'    => 'primary',
                        'depth'             => 2,
                        'container'         => 'div',
                            'container_class'   => 'collapse navbar-collapse primary',
                            'container_id'      => 'navbar-collapse-in',
                        'menu_class'        => 'nav navbar-nav',
                        'menu_id'           => 'main-menu',
                        'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'            => new WP_Bootstrap_Navwalker()
                        )
                      ); ?>                           
                
        		<?php dynamic_sidebar( 'navwidget-nw2' ); ?>     
        
            </nav><!-- .site-navigation -->		
            
    <?php endif;
}