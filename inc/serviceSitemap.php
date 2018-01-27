<?php
/**
 * Function to automatically create a standard sitemap.xml
 * https://www.itsupportguides.com/knowledge-base/wordpress/wordpress-how-to-automatically-create-sitemap-xml-without-plugin/
 * https://blog.jallet.org/generer-un-fichier-sitemap-xml-sans-plugin-490.html
 * https://codex.wordpress.org/Filesystem_API
 * https://www.sitemaps.org/protocol.html
 * 
 * Ene añadir un botón que ejecute la tarea.
 * https://codex.wordpress.org/AJAX_in_Plugins
 * https://wordpress.stackexchange.com/questions/251584/how-to-make-custom-button-link-on-the-wordpress-admin-bar-run-by-ajax
 * https://wordpress.stackexchange.com/questions/210701/display-admin-notice-error-message-form-jquery-event
 * https://wptheming.com/2011/08/admin-notices-in-wordpress/
 * https://wordpress.stackexchange.com/questions/224485/how-to-pass-parameters-to-admin-notices
 * https://codex.wordpress.org/Plugin_API/Action_Reference/wp_ajax_(action)
 *
 * @package ekiline
 */

if( true === get_theme_mod('ekiline_sitemap') && is_admin() ) {
 
	// crear botón para admin. 
	add_action('admin_bar_menu', 'add_item', 80);
	
	function add_item( $admin_bar ){
		
	  global $pagenow;
	  $admin_bar->add_menu( array(
	  	'id'=>'ekiline-sitemap',
	  	'title'=>'Sitemap','href'=>'#',
		'meta' => array(
			'class' => 'advice',
			)
		)
	  );
	  
	}

	
	/* Crear la respuesta de actualización con ajax y jQuery */
	
	add_action( 'admin_footer', 'ekiline_sitemap_action_js' );
	
	function ekiline_sitemap_action_js() { ?>
	  <script type="text/javascript" >
	     jQuery("li#wp-admin-bar-ekiline-sitemap .ab-item").on( "click", function() {
	        var data = { 'action': 'ekiline_sitemap_write' };
	        /* since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php */
	        jQuery.post(ajaxurl, data, function(response) {
	           alert( response );
               //jQuery('#wpbody-content .wp-header-end').after('<div class="notice notice-success is-dismissible sitemap-notice"><p>'+response+'</p></div>');
	        });		        	                	
	      });
	      
	  </script> <?php
	}
	
	// function sitemap_notice_success() {
		// $class = 'notice notice-success is-dismissible';
		// $message = __( 'Sitemap created!', 'ekiline' );
		// printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
	// }
	// add_action( 'admin_notices', 'sitemap_notice_success' );

	
	/* Ejecutar la funcion en cada caso: */
	// con el adminbar
	add_action( 'wp_ajax_ekiline_sitemap_write', 'ekiline_sitemap_xml' );
	
	// Originalmente: en cada publicación de manera automática (es mejor que el cliente lo ejecute via manual)
	//add_action( 'publish_post', 'ekiline_sitemap_xml' ) ;
	//add_action( 'publish_page', 'ekiline_sitemap_xml' ) ;

} 


function ekiline_sitemap_xml() {

	$sitemap = '' ;
	
	$sitemapLimit = get_theme_mod('ekiline_sitemaplimit');
	
	if ( $sitemapLimit == '0' || null ){
		$sitemapLimit = '1';
	} else if ($sitemapLimit >= '200'){
		$sitemapLimit = '200';
	}
	
	// Adjust timezone to follow XMl standard
	if( str_replace( '-', '', get_option( 'gmt_offset' ) ) < 10 ) {
		$timeZone = '-0' . str_replace( '-', '', get_option( 'gmt_offset' ) ) ;
	} else {
		$timeZone = get_option( 'gmt_offset' ) ;
	}
	
	if( strlen( $timeZone ) == 3 ) {
		$timeZone = $timeZone . ':00' ;
	}
	
	// Select posts and pages
	$postsForSitemap = get_posts(array(
		//	'numberposts' => -1,
			'numberposts' => $sitemapLimit,
			'orderby' => 'modified',
			'post_type' => array( 'post','page' ),
			'order' => 'DESC'
	));
	
	// Sitemap header
	$sitemap .= '<?xml version="1.0" encoding="UTF-8"?>';
	/* $sitemap .= '<?xml-stylesheet type="text/xsl" href="' . esc_url( home_url( '/' ) ) . 'sitemap.xsl"?>' . "\n"; */
	$sitemap .= '<!-- Generated by Ekiline SEO Wordpress Theme (ekiline.com) -->' . "\n";
	$sitemap .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	// Generate homepage xml set
	$sitemap .= "\t" . '<url>' . "\n" . 
				"\t\t" . '<loc>' . esc_url( home_url( '/' ) ) .'</loc>' . 
				"\n\t\t" . '<lastmod>' . date( "Y-m-d\TH:i:s", current_time( 'timestamp', 0 ) ) . $timeZone . '</lastmod>' . 
				"\n\t\t" . '<changefreq>daily</changefreq>' . 
				"\n\t\t" . '<priority>1.0</priority>' . 
				"\n\t" . '</url>' . "\n" ;

	// Generate entry for each post/page
	foreach( $postsForSitemap as $post ){
		setup_postdata( $post ) ;
		$postdate = explode( ' ', $post->post_modified ) ;
		
		//set priority by type of post
		$priority = '0.8';
		$pfreq = 'weekly';
		$ptype = explode( ' ', $post->post_type ) ;
		if ($ptype[0] == 'page'){ $priority = '0.5'; $pfreq = 'monthly'; }
		
		$sitemap .= "\t" . '<url>' . "\n" . 
					"\t\t" . '<loc>' . get_permalink($post->ID) . '</loc>' . 
					"\n\t\t" . '<lastmod>' . $postdate[0] . 'T' . $postdate[1] . $timeZone . '</lastmod>' . 
					"\n\t\t" . '<changefreq>' . $pfreq . '</changefreq>' . 
					"\n\t\t" . '<priority>' . $priority . '</priority>' . 
					"\n\t" . '</url>' . "\n" ;
	}

	// Sitemap closing tag
	$sitemap .= '</urlset>' ;
	
	// Write sitemap.xml using WordPress file system class
	// See https ://wordpress.stackexchange.com/questions/120273/converting-fopen-fwrite-operations-to-wp-filesystem
	
	WP_Filesystem();
	global $wp_filesystem;
	
	$homedir = $wp_filesystem->abspath();
	$file = trailingslashit( $homedir ) . 'sitemap.xml';
	$wp_filesystem->put_contents( $file, $sitemap, FS_CHMOD_FILE );
	
    $response = __('Sitemap created successfully!', 'ekiline');
    echo $response;		
	
    wp_die(); /* this is required to terminate immediately and return a proper response */
}

//test


