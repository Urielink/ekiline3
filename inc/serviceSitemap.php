<?php
/**
 * Function to automatically create a standard sitemap.xml
 * https://www.itsupportguides.com/knowledge-base/wordpress/wordpress-how-to-automatically-create-sitemap-xml-without-plugin/
 * https://blog.jallet.org/generer-un-fichier-sitemap-xml-sans-plugin-490.html
 * https://codex.wordpress.org/Filesystem_API
 * https://www.sitemaps.org/protocol.html
 * 
 * Prueba, hacer sitemap con custom feed
 * http://www.wpbeginner.com/wp-tutorials/how-to-create-custom-rss-feeds-in-wordpress/
 * https://codex.wordpress.org/Customizing_Feeds
 * https://codex.wordpress.org/WordPress_Feeds#Site_comment_feed
 * https://codex.wordpress.org/Rewrite_API/add_feed
 * https://codex.wordpress.org/Rewrite_API/add_rewrite_rule
 *
 * @package ekiline
 */

if( true !== get_theme_mod('ekiline_sitemap') ) return;

/* Agregar el feed: sitemap y aplicar regla de sobreescritura en url */
function ekiline_sitemap_init(){
	add_feed('sitemap', 'ekiline_sitemap');
	add_rewrite_rule('^sitemap/?', '?feed=sitemap', 'top');
}
add_action('init', 'ekiline_sitemap_init');

/* Crear la función que crea el xml */
function ekiline_sitemap() {
	
	// Número de posts que se muestran en este feed
	$postCount = get_theme_mod('ekiline_sitemaplimit');
	
	if ( $postCount == '0' || null ){
		$postCount = '1';
	} else if ($postCount >= '200'){
		$postCount = '200';
	}
	
	// Ajustar la zona horaria y tiempo
	if( str_replace( '-', '', get_option( 'gmt_offset' ) ) < 10 ) {
		$timeZone = '-0' . str_replace( '-', '', get_option( 'gmt_offset' ) ) ;
	} else {
		$timeZone = get_option( 'gmt_offset' ) ;
	}
	if( strlen( $timeZone ) == 3 ) {
		$timeZone = $timeZone . ':00' ;
	}
	
	// Seleccionar el tipo de posts
	$arrayPosts = array( 'post','page' );
	
	// En caso de woocommerce
	if ( class_exists( 'WooCommerce' ) ) {
		$arrayPosts = array( 'post','page','product' );
	} 	
	
	// Crear el array
	$posts = get_posts(array(
		//	'numberposts' => -1, //ilimitado
			'numberposts' => $postCount,
			'orderby' => 'modified',
			'post_type' => $arrayPosts,
			'order' => 'DESC'
	));
	
	// Declarar el header y crear la plantilla.
	header('Content-Type: text/xml; charset='.get_option('blog_charset'), true);
	do_action('rss2_ns');	
	echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
	{ ?>
		
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?php echo esc_url( home_url( '/' ) ) ;?></loc>
		<lastmod><?php echo date( "Y-m-d\TH:i:s", current_time( 'timestamp', 0 ) ) . $timeZone; ?></lastmod>
		<changefreq>monthly</changefreq>		
		<priority>1.0</priority>
	</url>    	
<?php foreach( $posts as $post ){
	//Prioridad de las páginas
	$priority = '0.8';
	$pfreq = 'weekly';
	$ptype = explode( ' ', $post->post_type );
	if ($ptype[0] == 'page') : $priority = '0.5'; $pfreq = 'monthly'; endif; ?>    		
	<url>
		<loc><?php the_permalink(); ?></loc>
		<lastmod><?php echo mysql2date('Y-m-d\TH:i:s', get_post_time('Y-m-d H:i:s', true), false) . $timeZone; ?></lastmod>
		<changefreq><?php echo $pfreq ;?></changefreq>		
		<priority><?php echo $priority ;?></priority>
	</url>      
<?php } ?>

</urlset>
	
	<?php }

}



