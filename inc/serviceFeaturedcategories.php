<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *     // Jugar con urls https://wordpress.stackexchange.com/questions/29512/permalink-for-category-pages-and-posts
 *
 * @package ekiline 
 */


/**
 * Customizer: Funcion para obtener los ids de categorias // get categories IDs
 */
function ekiline_list_categories() {
  $cats = array();
  $cats[0] = __('All','ekiline');
  foreach ( get_categories() as $categories => $category ) {
    $cats[$category->term_id] = $category->name;
  }
  return $cats;
}

/**
 * Customizer: Función para elegir categorías predeterminadas // Frontpage featured categories.
 */

function ekiline_frontpage_featured( $query ) {
	if (!is_home()) return;
	$seleccion =  get_theme_mod('ekiline_featuredcategories');
	print_r($seleccion);
	// crear un string con lo seleccionado
	$str = implode(',', $seleccion);
	
	if ( $query->is_home() && $query->is_main_query() ) {
	 	 $query->set( 'cat', $str ); 
	} 
		
} 
add_action( 'pre_get_posts', 'ekiline_frontpage_featured' );

/***
 * Nuevo ejercicio, 
 * 1) extender la clase de selectores 
 * 2) Solo se debe definir el tipo de formulario en ekiline_theme_customizer
 * 3) se crea el arreglo para desplegar las categories
 * https://stackoverflow.com/questions/38481936/multi-select-category-wordpress-customizer-control
 **/
if (class_exists('WP_Customize_Control')){ 
	class ekiline_controlMultipleSelect extends WP_Customize_Control {
	
		// Establecer el tipo del control, el formulario
		public $type = 'multiple-select';
		// Crear el formulario
		public function render_content() {
			if ( empty( $this->choices ) ) return; ?>
		    <label>
		        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		        <select <?php $this->link(); ?> multiple="multiple" size="10">
		            <?php
		                foreach ( $this->choices as $value => $label ) {
		                    $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
		                    echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
		                }
		            ?>
		        </select>
		    </label>
		<?php }
	}
}


/**
 * Validar un multi-select
 */ 
function ekiline_sanitize_multipleselect( $input )
{
    $valid = ekiline_list_categories();
    foreach ($input as $value) {
        if ( !array_key_exists( $value, $valid ) ) return;
    }
    return $input;
}
