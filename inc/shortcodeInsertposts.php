<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Ekiline: Importar un listado de entradas de alguna categoria, se genera un loop. 
 * Ekiline: Insert a list of posts everywhere, it generates a loop
 * @link https://css-tricks.com/snippets/wordpress/run-loop-on-posts-of-specific-category/ 
 * @link http://code.tutsplus.com/tutorials/create-a-shortcode-to-list-posts-with-multiple-parameters--wp-32199
 * Especial atencion en el uso de ob_start();
 * @link http://wordpress.stackexchange.com/questions/41012/proper-use-of-output-buffer
 * @link https://developer.wordpress.org/reference/functions/query_posts/
 * @link https://codex.wordpress.org/Shortcode_API
 * @link https://wordpress.stackexchange.com/questions/96646/creating-wp-query-with-posts-with-specific-category
 * //16 ene 2018 WP update method.
 * @link https://developer.wordpress.org/reference/functions/get_terms/
 * @link https://developer.wordpress.org/reference/functions/get_the_category/
 * 
 * $args = array( 'orderby' => 'slug', 'parent' => 0, 'exclude' => '1' ); 
 * $cats = get_terms( 'category', $args ); 
 * foreach ( $cats as $cat ) {
 * 	echo '<p><a href="' . get_term_link( $cat ) . '" rel="bookmark">' . $cat->name . '</a><br>' . $cat->term_id . ' ' . $cat->description  . '</p>'; 
 * }
 * 
 * @package ekiline
 */

 

function ekiline_addpostlist($atts, $content = null) {
    
    extract(shortcode_atts(array('catid'=>'','limit'=>'5', 'format'=>'default', 'sort'=>'DES', 'columns'=>''), $atts));
	
	//Enero 2018, existe un roblema cuando este modulo se inserta en un mismo articulo de una misma categoría.
	//Debe excluirse del loop para que no se cicle: post__not_in : https://codex.wordpress.org/Class_Reference/WP_Query
	// $exclude = '';
	// if( is_single() || is_category() ){
		// global $wp_query;
		// echo $wp_query->post->ID . ' es single o es categoria';
		//$exclude = $wp_query->post->ID;
	// }
	
    // Por el formato es que cambia el tipo de contenido (default, block or carousel).
    // Content type changes with format value
        
    ob_start(); // abre 
    
            /***
			 * Declarar las variables invoca las cotegorias necesarias WP_Query(), se puede llamar mediante 2 métodos:
             * $query_string = '';
             * $nuevoLoop = new WP_Query($query_string . '&cat='.$catid.'&posts_per_page='.$limit.'&order='.$sort );
             * $nuevoLoop = new WP_Query(array( 'category_name' => $catid, 'posts_per_page' => $limit, 'order' => $sort ));
			 * 
			 ***/
            $nuevoLoop = new WP_Query(array( 'cat' => $catid, 'posts_per_page' => $limit, 'order' => $sort ));
            
            // obtiene la cuenta de los posts
            // count posts
            $post_counter = 0; 
            $count = '';   
                                
            if ( $nuevoLoop->have_posts() ) {              
                    
                if ($format == 'default'){         
                
                    echo '<div class="clearfix modpostlist-'.$format.'">';   
                    
                        while ( $nuevoLoop->have_posts() ) :
                              $nuevoLoop->the_post(); 
                                    $post_counter++;  
                                    
                                        // trae la parte del template - get template part 
                                        get_template_part( 'template-parts/content', get_post_format() );
                                        
                                        // por cada 3 posts agrega un elemento (Puedes prescindir de esto) -  Add an HR
                                        if ($post_counter == 2):{ echo '<hr>'; } 
                                                // resetea el contador
                                                $post_counter = 0; 
                                        endif; 
                        endwhile;
                            
                    echo '</div>';
                
                } else if ($format == 'block'){
                            
                         $colCount='';
						 $colClass='';
						 $container='';
						
                         if ($columns == '2' ) {
	                     	 $format .= ' row';
                             $colCount='2';
							 $colClass='col-md-6';
                         } elseif ($columns == '3' ) {
	                     	 $format .= ' row';
                             $colCount='3';
							 $colClass='col-md-4';
                         } elseif ($columns == '4' ) {
	                     	 $format .= ' row';
                             $colCount='4';
							 $colClass='col-md-3';
                         }
                    
                                                                                                    
                        echo '<div class="clearfix modpostlist-'.$format.'">'; 
                        
                            while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post();                                 
                            
                            $count++;

                			if ($columns > '1' && $columns < '5') echo '<div class="'.$colClass.'">';

                                get_template_part( 'template-parts/content', 'block' );

                			if ($columns > '1' && $columns < '5') echo '</div>';
                                
                                // por cada 3 posts agrega un divisor, necesario para mantener alineaciones
                                //if ($count == 3) : echo '<div class="col-divider"></div>'; $count = 0;  endif;
                                if ($count == $colCount ) : echo '<div class="col-divider"></div>'; $count = 0;  endif;
                                                                
                            endwhile;
                                
                        echo '</div>';
                    
                } else if ($format == 'cards'){
                            						 
                        echo '<div class="clearfix modpostlist-'.$format.' card-columns">'; 
                        
                            while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post();                                 

                                get_template_part( 'template-parts/content', 'card' );

                            endwhile;
                                
                        echo '</div>';
                    
                } else if ($format == 'imagecards'){
                            						 
                        echo '<div class="clearfix modpostlist-'.$format.' card-columns">'; 
                        
                            while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post();                                 

                                get_template_part( 'template-parts/content', 'overcard' );

                            endwhile;
                                
                        echo '</div>';
                    
                } else if ($format == 'carousel'){

					 $carShow = '';$colshow='';
	                 if ($columns > '1') $carShow = ' carousel-multiple';   
					 if ($columns == '2') : $colshow='col-sm-6'; elseif ($columns == '3') : $colshow='col-sm-4'; elseif ($columns == '4') : $colshow='col-sm-3'; endif;
					 $modId = rand(10, 100);
					                     
	                // Limpiar las comas de las categorias para asignar un ID general.    
	                // Clean ids commas to asign an id    
	                    $catid = ekiline_cleanspchar($catid);                 
	                
	                    echo '<div id="carousel-module-'.$modId.'" class="modpostlist-'.$format.' carousel slide '.$carShow.'" data-interval="false">';
	                
	                // Indicadores  Bootstrap
	                    echo '<ol class="carousel-indicators">';
		                        while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post();								
	                            $count = $nuevoLoop->current_post + 0;
	                            if ($count == '0') : $countclass = 'active' ; elseif ($count !='0') : $countclass = '' ; endif; 
		                            echo '<li data-target="#carousel-module-'.$modId.'" data-slide-to="'.$count.'" class="'.$countclass.'"></li>';									
		                        endwhile;
	                    echo '</ol>' ;  
						                
					// Contenedor de posts
	                    echo '<div class="carousel-inner" role="listbox">';   
	
	                    
	                // ITEMS
	                    while( $nuevoLoop->have_posts() ) : $nuevoLoop->the_post();                                 
	                        $count = $nuevoLoop->current_post + 0;
	                        if ($count == '0') : $countclass = 'active' ; elseif ($count !='0') : $countclass = '' ; endif;                                 
							
	                            // trae la parte del template para personalizar
	                            echo '<div class="carousel-item '. $countclass .'">';
									// en caso de mostrar columnas abre nuevo div
									if ($columns > '1') echo '<div class="'.$colshow.'">';
									
                                get_template_part( 'template-parts/content', 'carousel' );
	                                
									// en caso de mostrar columnas cierra nuevo div
									if ($columns > '1') echo '</div>';
									
	                            echo '</div>';
	                    endwhile;
	
	                // Controles        
	                    echo '</div>
	                          <a class="carousel-control-prev" href="#carousel-module-'.$modId.'" role="button" data-slide="prev">
	                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	                            <span class="sr-only">Previous</span>
	                          </a>
	                          <a class="carousel-control-next" href="#carousel-module-'.$modId.'" role="button" data-slide="next">
	                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
	                            <span class="sr-only">Next</span>
	                          </a>
	                          </div>';                                                              
                }

                
            } //.if $nuevoLoop
                        
    
            wp_reset_postdata(); // resetea la peticion
        
        
    $insertarItem = ob_get_clean(); // cierra
    
    return $insertarItem;       

}
add_shortcode('modulecategoryposts', 'ekiline_addpostlist');

 