<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ekiline
 */

/**
 * Crear un widget .
 * https://codex.wordpress.org/Widgets_API
 * https://www.cssigniter.com/extending-wordpress-core-3rd-party-widgets/
 *
 */

class Ekiline_Comments extends WP_Widget {

	/**
	 * 1) Registrar el widget // Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'ekiline_comments', // Base ID
			esc_html__( 'Ekiline comments', 'ekiline' ), // Name
			array( 'description' => esc_html__( 'Enhanced comments filter it and show', 'ekiline' ), ) // Args
		);
	}

	/**
	 * 2) Mostrarlo en el front // Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		
	/** 
	 * Para sobrescribir un widget, en este caso ekiline, agrega opciones css y tipo de muestreo,
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
	        'before_widget' => '<section id="'. $args['widget_id'] .'" class="'. $css_style .' widget '. $args['widget_id'] .'">',
	        'after_widget'  => '</section>',
	        'before_title'  => $args['before_title'],
	        'after_title'  => $args['after_title']
	    );  		
		
		echo $args['before_widget'];
		
		// condicion: si el titulo está vacio no mostrar HTML
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		
		// echo esc_html__( 'Hello, World!', 'ekiline' );
		// llamar la función que crea el widget.
		$showfrom = apply_filters( 'widget_title', $instance['showfrom'] );
		$comnum = apply_filters( 'widget_title', $instance['comnum'] );
		echo createwidget_ekilineComments($showfrom,$comnum);
		
		echo $args['after_widget'];
	}

	/**
	 * 3) Formulario de parametros // Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 * Agrego los filtros para mostrar los comentarios.
	 */
	public function form( $instance ) {
		
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '' ; // esc_html__( 'Add title', 'ekiline' ) ;
		// de donde mostrar los comentarios y límite
		$showfrom = ! empty( $instance['showfrom'] ) ? $instance['showfrom'] : 0 ;
		$comnum = ! empty( $instance['comnum'] ) ? $instance['comnum'] : 5 ;
?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'ekiline' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
	</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'showfrom' ) ); ?>"><?php esc_attr_e( 'Show from post id, comma separated:', 'ekiline' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'showfrom' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'showfrom' ) ); ?>" type="text" value="<?php echo esc_attr( $showfrom ); ?>">
	</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'comnum' ) ); ?>"><?php esc_attr_e( 'Limit comments:', 'ekiline' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'comnum' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comnum' ) ); ?>" type="number" value="<?php echo esc_attr( $comnum ); ?>">
	</p>
	
<?php 
	}

	/**
	 * 4) Depurar los campos de llenado // Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['showfrom'] = ( ! empty( $new_instance['showfrom'] ) ) ? sanitize_text_field( $new_instance['showfrom'] ) : '';
		$instance['comnum'] = ( ! empty( $new_instance['comnum'] ) ) ? sanitize_text_field( $new_instance['comnum'] ) : '';

		return $instance;
	}

} // class Ekiline_Comments



/**
 * 5) Registrar el widget en la DB // register Ekiline_Comments widget
 */
function register_ekiline_comments() {
    register_widget( 'Ekiline_Comments' );
}
add_action( 'widgets_init', 'register_ekiline_comments' );



/**
 * 6) Crear una función para ejecutar el widget.
 */
function createwidget_ekilineComments($showfrom,$comnum){
// Pasar argumentos para ejecutar widget	 
?>	
<style>
.commentlist {
    max-height: 400px;
    overflow-x: hidden;
    overflow-y: scroll;
}
/*.commentlist img{margin-right:10px;}
.commentlist p{margin:0px;}
.commentlist ul li{list-style:none;}*/
</style>
<ul class="commentlist list-unstyled">
<?php
	//print_r($showfrom);
	//Gather comments for a specific page/post 
	$comments = get_comments(array(
	  //'post_id' 			=> $showfrom, //Obtener comentarios solo de un post, 1148
		'post__in' 			=> $showfrom, //Obtener comentarios de varios posts
		'status' 			=> 'approve' //Change this to the type of comments to be displayed
	));

	//Display the list of comments
	wp_list_comments(array(
        //'style'				=> 'ol', //Formato ul,ol,div
		'per_page'			=> $comnum, //10, //Allow comment pagination
		'callback'          => 'style_ekilineComments', // darle estilo a los comentarios con ayuda de una función.
		'avatar_size'       => 64,
		'reverse_top_level' => false //Show the oldest comments at the top of the list
	), $comments);
		
?>
</ul>
<?php
}

/**
 * 7) Darle diseño a cada campo.
 */
function style_ekilineComments($comment, $args, $depth) {
	
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }?>
    
    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>">
    
    <?php if ( 'div' != $args['style'] ) { ?>    	
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body row mb-2 px-md-3">
    <?php } ?>
    
    		<div class="col col-md-1 col-sm-2 col-3 text-center">    
	        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'], '', '', array('class' => 'rounded-circle img-fluid')  ); ?>
	        </div>

			<div class="rounded bg-white col-md-11 col-sm-10 col-9">
		        <?php comment_text(); ?>
	
	        	<?php comment_reply_link( array_merge( $args, array( 
	        					// 'before' => '<div class="btn btn-danger">',
	        					// 'after' => '</div>',
	                            // 'reply_text' => __('Respondele!','ekiline'),
	                            'add_below' => $add_below, 
	                            'depth'     => $depth, 
	                            'max_depth' => $args['max_depth']
	                        ))); ?>
			</div>

        
        <?php if ( 'div' != $args['style'] ) { ?>
        	
        </div>
        
        <?php }
		
}
