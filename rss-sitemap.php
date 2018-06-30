<?php
/**
 * ekiline Custom RSS Template - Feedname
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ekiline
 */

// Número de posts que se muestran en este feed
$postCount = 5;

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

// Declarar el header
header('Content-Type: text/xml; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'."\n";
do_action('rss2_ns');
?>

<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" 
		xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<!-- homePage -->
	<url>
		<loc><?php echo esc_url( home_url( '/' ) ) ;?></loc>
		<lastmod><?php echo date( "Y-m-d\TH:i:s", current_time( 'timestamp', 0 ) ) . $timeZone; ?></lastmod>
		<changefreq>monthly</changefreq>		
		<priority>1.0</priority>
	</url>    	
<!-- Posts -->
    <?php foreach( $posts as $post ){ ?>
<?php 
//Prioridad de las páginas
$priority = '0.8';
$pfreq = 'weekly';
$ptype = explode( ' ', $post->post_type ) ;
if ($ptype[0] == 'page'){ $priority = '0.5'; $pfreq = 'monthly'; }
?>    	
    <?php echo "\n"; ?>
        <url>
			<loc><?php the_permalink(); ?></loc>
			<lastmod><?php echo mysql2date('Y-m-d\TH:i:s', get_post_time('Y-m-d H:i:s', true), false) . $timeZone; ?></lastmod>
			<changefreq><?php echo $pfreq ;?></changefreq>		
			<priority><?php echo $priority ;?></priority>
        </url>
    <?php } ?>

</urlset>