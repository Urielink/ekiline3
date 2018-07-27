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

	    $args = array(
	        'before_widget' => '<nav id="%1$s" class="widget %2$s">',
	        'after_widget'  => '</nav>',
	    );     


		// outputs the content of the widget
		echo $args['before_widget'];
		//** echo str_replace('<div', '<nav', $args['before_widget'] );
		// if ( ! empty( $instance['title'] ) ) {
			// echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		// }
		// echo esc_html__( 'Hello, World!', 'text_domain' );
		
		echo createBreadcrumb();
		
		echo $args['after_widget'];		
		//** echo str_replace('div>', 'nav>', $args['after_widget'] );
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

function createBreadcrumb(){ ?>
		
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="#">Home</a>
				</li>
				<li class="breadcrumb-item">
					<a href="#">Library</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					Data
				</li>
			</ol>
		
<?php }
