<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 * Info: https://developer.wordpress.org/reference/functions/add_editor_style/
 *
 * @package ekiline
 */

if( true === get_theme_mod( 'ekiline_bootstrapeditor', true ) ) {
 
	/**
	 * Añadir estilos css al editor de wordpress (no requiere una función):
	 * Add styles to wordpress admin editor
	 */
	
	add_editor_style('editor-style.css'); 
	
	/*Existe un problema en el editor, cachea el estilo, entonces
	 * es necesario forzar el refresh con este script:
	 * https://wordpress.stackexchange.com/questions/33318/forcing-reload-of-editor-style-css
	 **/
	
	
	/**
	 * Añadir los tipos de estilo que se requieren para trabajar con bootstrap:
	 * http://www.wpbeginner.com/wp-tutorials/how-to-add-custom-styles-to-wordpress-visual-editor/ 
	 */
	 
	//Registro mi menu de estilos 
	//Register Ekiline styles 
	
	function ekiline_bootstrap_styles($buttons) {
	    array_unshift($buttons, 'styleselect');
	    return $buttons;
	}
	add_filter('mce_buttons_3', 'ekiline_bootstrap_styles');
	
	/*
	* Genero mi callback
	* Add my callback
	*/
	
	function ekiline_mce_before( $init_array ) {  
	
	/**
	 * La definición de estilos se agrega con arreglos, cada arreglo equivale a un objeto y este puede anidarse
	 * Define the style_formats array
	 * Each array child is a format with it's own settings
	 * Notice that each array has title, block, classes, and wrapper arguments
	 * Title is the label which will be visible in Formats menu
	 * Block defines whether it is a span, div, selector, or inline style
	 * Classes allows you to define CSS classes
	 * Wrapper whether or not to add a new block-level element around any selected elements
	 * Auxiliar: https://github.com/bostondv/bootstrap-tinymce-styles/blob/master/bootstrap-tinymce-styles.php
	 * Permitir data-atts http://mawaha.com/allowing-data-attributes-in-wordpress-posts/ ,
	 * https://codex.wordpress.org/TinyMCE_Custom_Styles,
	 * http://www.lmhproductions.com/52/wordpress-tincymce-editor-removes-attributes/,
	 * **https://getunderskeleton.com/wordpress-custom-styles-dropdown/
	 */
	
	    $style_formats = array(      
	    
	/**        array(  
	            'title' => __('Columns', 'ekiline'),  
	            'items' => array(                
	                array(  
	                    'title' => __('Columns container', 'ekiline'),  
	                    'block' => 'div',  
	                    'classes' => 'row',
	                    'wrapper' => true,
	                ),
	                array(  
	                    'title' => __('2 columns', 'ekiline'),  
	                    'block' => 'div',  
	                    'classes' => 'col-sm-6',
	                ),
	                array(  
	                    'title' => __('3 columns', 'ekiline'),  
	                    'block' => 'div',  
	                    'classes' => 'col-sm-4',
	                ),
	                array(  
	                    'title' => __('4 columns', 'ekiline'),  
	                    'block' => 'div',  
	                    'classes' => 'col-sm-3',
	                ),
	                array(  
	                    'title' => __('6 columns', 'ekiline'),  
	                    'block' => 'div',  
	                    'classes' => 'col-sm-2',
	                ),              
	            ),            
	        ), 
	**/        
	        array(
	            'title' => __( 'Typography', 'ekiline' ),
	            'items' => array(
	                array(
	                    'title'     => __( 'Small Text', 'ekiline' ),
	                    'inline'    => 'small',
	                ),
	                array(
	                    'title'     => __( 'Highlight', 'ekiline' ),
	                    'inline'    => 'mark',
	                ),
	                array(
	                    'title'     => __( 'Delete', 'ekiline' ),
	                    'inline'    => 'del',
	                ),               
	                array(
	                    'title'     => __( 'Insert', 'ekiline' ),
	                    'inline'    => 'ins',
	                ),
	                array(
	                    'title'     => __( 'Abbreviation', 'ekiline' ),
	                    'inline'    => 'abbr',
	                ),
	                array(
	                    'title'     => __( 'Initialism', 'ekiline' ),
	                    'inline'    => 'abbr',
	                    'classes'   => 'initialism',
	                ),
	                array(
	                    'title'     => __( 'Cite', 'ekiline' ),
	                    'inline'    => 'cite',
	                ),
	                array(
	                    'title'     => __( 'User Input', 'ekiline' ),
	                    'inline'    => 'kbd',
	                ),
	                array(
	                    'title'     => __( 'Variable', 'ekiline' ),
	                    'inline'    => 'var',
	                ),
	                array(
	                    'title'     => __( 'Sample Output', 'ekiline' ),
	                    'inline'    => 'samp',
	                ),
	                array(
	                    'title'     => __( 'Address', 'ekiline' ),
	                    'format'    => 'address',
	                    'wrapper'   => true,
	                ),
	                array(
	                    'title'     => __( 'Code Block', 'ekiline' ),
	                    'format'    => 'pre',
	                    'wrapper'   => true,
	                ),
	            ),
	        ),
	
	        array(
	            'title' => __( 'Big text', 'ekiline' ),
	            'items' => array(
	                array(
	                    'title'     => __( 'Lead Text <p>', 'ekiline' ),
	                    'selector'  => 'p,span',
	                    'classes'   => 'lead',
	                ),
	                array(
	                    'title'     => __( 'Display 1', 'ekiline' ),
	                    'selector'  => 'p,h1,h2,h3,h4',
	                    'classes'   => 'display-1',
	                ),                           
	                array(
	                    'title'     => __( 'Display 2', 'ekiline' ),
	                    'selector'  => 'p,h1,h2,h3,h4',
	                    'classes'   => 'display-2',
	                ),                           
	                array(
	                    'title'     => __( 'Display 3', 'ekiline' ),
	                    'selector'  => 'p,h1,h2,h3,h4',
	                    'classes'   => 'display-3',
	                ),                           
	                array(
	                    'title'     => __( 'Display 4', 'ekiline' ),
	                    'selector'  => 'p,h1,h2,h3,h4',
	                    'classes'   => 'display-4',
	                ),                           
	            ),
	        ),
	        
			array(
	            'title' => __( 'Colors', 'ekiline' ),
	            'items' => array(

			        array(
			            'title' => __( 'Text colors', 'ekiline' ),
			            'items' => array(
			                array(
			                    'title'     => __( 'Primary', 'ekiline' ),
			                    'inline'    => 'span',
			                    'classes'   => 'text-primary',
			                ),
			                array(
			                    'title'     => __( 'Secondary', 'ekiline' ),
			                    'inline'    => 'span',
			                    'classes'   => 'text-secondary',
			                ),
			                array(
			                    'title'     => __( 'Success', 'ekiline' ),
			                    'inline'    => 'span',
			                    'classes'   => 'text-success',
			                ),
			                array(
			                    'title'     => __( 'Danger', 'ekiline' ),
			                    'inline'    => 'span',
			                    'classes'   => 'text-danger',
			                ),
			                array(
			                    'title'     => __( 'Warning', 'ekiline' ),
			                    'inline'    => 'span',
			                    'classes'   => 'text-warning',
			                ),
			                array(
			                    'title'     => __( 'Info', 'ekiline' ),
			                    'inline'    => 'span',
			                    'classes'   => 'text-info',
			                ),
			                array(
			                    'title'     => __( 'Light', 'ekiline' ),
			                    'inline'    => 'span',
			                    'classes'   => 'text-light',
			                ),
			                array(
			                    'title'     => __( 'Dark', 'ekiline' ),
			                    'inline'    => 'span',
			                    'classes'   => 'text-dark',
			                ),
			                array(
			                    'title'     => __( 'Muted', 'ekiline' ),
			                    'inline'    => 'span',
			                    'classes'   => 'text-muted',
			                ),
			            ),
			        ),
			
			        array(
			            'title' => __( 'Background colors', 'ekiline' ),
			            'items' => array(
			                array(
			                    'title'     => __( 'Primary', 'ekiline' ),
			                    'selector'     => 'div',
			                    'classes'   => 'bg-primary',
			                ),
			                array(
			                    'title'     => __( 'Secondary', 'ekiline' ),
			                    'selector'     => 'div',
			                    'classes'   => 'bg-secondary',
			                ),
			                array(
			                    'title'     => __( 'Success', 'ekiline' ),
			                    'selector'     => 'div',
			                    'classes'   => 'bg-success',
			                ),
			                array(
			                    'title'     => __( 'Danger', 'ekiline' ),
			                    'selector'     => 'div',
			                    'classes'   => 'bg-danger',
			                ),
			                array(
			                    'title'     => __( 'Warning', 'ekiline' ),
			                    'selector'     => 'div',
			                    'classes'   => 'bg-warning',
			                ),
			                array(
			                    'title'     => __( 'Info', 'ekiline' ),
			                    'selector'     => 'div',
			                    'classes'   => 'bg-info',
			                ),
			                array(
			                    'title'     => __( 'Light', 'ekiline' ),
			                    'selector'     => 'div',
			                    'classes'   => 'bg-light',
			                ),
			                array(
			                    'title'     => __( 'Dark', 'ekiline' ),
			                    'selector'     => 'div',
			                    'classes'   => 'bg-dark',
			                ),
			            ),
			        ),
	            
				),
			),
	        
			array(
	            'title' => __( 'Buttons', 'ekiline' ),
	            'items' => array(
	            
			        array(
			            'title' => __( 'Solid buttons', 'ekiline' ),
			            'items' => array(
			                array(
			                    'title'     => __( 'Primary', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-primary',
			                ),
			                array(
			                    'title'     => __( 'Secondary', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-secondary',
			                ),
			                array(
			                    'title'     => __( 'Success', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-success',
			                ),
			                array(
			                    'title'     => __( 'Danger', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-danger',
			                ),
			                array(
			                    'title'     => __( 'Warning', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-warning',
			                ),
			                array(
			                    'title'     => __( 'Info', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-info',
			                ),
			                array(
			                    'title'     => __( 'Light', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-light',
			                ),
			                array(
			                    'title'     => __( 'Dark', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-dark',
			                ),
			            ),
			        ),
			        
			        array(
			            'title' => __( 'Outline buttons', 'ekiline' ),
			            'items' => array(
			                array(
			                    'title'     => __( 'Primary', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-outline-primary',
			                ),
			                array(
			                    'title'     => __( 'Secondary', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-outline-secondary',
			                ),
			                array(
			                    'title'     => __( 'Success', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-outline-success',
			                ),
			                array(
			                    'title'     => __( 'Danger', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-outline-danger',
			                ),
			                array(
			                    'title'     => __( 'Warning', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-outline-warning',
			                ),
			                array(
			                    'title'     => __( 'Info', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-outline-info',
			                ),
			                array(
			                    'title'     => __( 'Light', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-outline-light',
			                ),
			                array(
			                    'title'     => __( 'Dark', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-outline-dark',
			                ),
			            ),
			        ),
			        
			        array(
			            'title' => __( 'Button variables', 'ekiline' ),
			            'items' => array(
			                array(
			                    'title'     => __( 'Link', 'ekiline' ),
			                    'inline'    => 'a',
			                    'classes'   => 'btn btn-link',
			                ),
			                array(
			                    'title'     => __( 'Large', 'ekiline' ),
			                    'selector'  => '.btn',
			                    'classes'   => 'btn-lg',
			                ),
			                array(
			                    'title'     => __( 'Small', 'ekiline' ),
			                    'selector'  => '.btn',
			                    'classes'   => 'btn-sm',
			                ),
			                array(
			                    'title'     => __( 'Block', 'ekiline' ),
			                    'selector'  => '.btn',
			                    'classes'   => 'btn-block',
			                ),
			                array(
			                    'title'        => __( 'Disabled', 'ekiline' ),
			                    'selector'  => '.btn',
			                    'classes'   => 'disabled',
			                    'attributes'   => array(
			                        'disabled' => 'disabled'
			                    ),
			                ),
			            ),
			        ),
			        
			        array(
			            'title' => __( 'Badge', 'ekiline' ),
			            'items' => array(
			                array(
			                    'title'     => __( 'Primary', 'ekiline' ),
			                    'inline'  => 'span',
			                    'classes'   => 'badge badge-primary',
			                ),
			                array(
			                    'title'     => __( 'Secondary', 'ekiline' ),
			                    'inline'  => 'span',
			                    'classes'   => 'badge badge-secondary',
			                ),
			                array(
			                    'title'     => __( 'Success', 'ekiline' ),
			                    'inline'  => 'span',
			                    'classes'   => 'badge badge-success',
			                ),
			                array(
			                    'title'     => __( 'Danger', 'ekiline' ),
			                    'inline'  => 'span',
			                    'classes'   => 'badge badge-danger',
			                ),
			                array(
			                    'title'     => __( 'Warning', 'ekiline' ),
			                    'inline'  => 'span',
			                    'classes'   => 'badge badge-warning',
			                ),
			                array(
			                    'title'     => __( 'Info', 'ekiline' ),
			                    'inline'  => 'span',
			                    'classes'   => 'badge badge-info',
			                ),
			                array(
			                    'title'     => __( 'Light', 'ekiline' ),
			                    'inline'  => 'span',
			                    'classes'   => 'badge badge-light',
			                ),
			                array(
			                    'title'     => __( 'Dark', 'ekiline' ),
			                    'inline'  => 'span',
			                    'classes'   => 'badge badge-dark',
			                ),                
			                array(
			                    'title'     => __( 'Pill', 'ekiline' ),
			                    'selector'  => 'span',
			                    'classes'   => 'badge-pill',
			                ),                
			            ),
			        ),				
				
				),
			),

	        array(
	            'title' => __( 'Alerts', 'ekiline' ),
	            'items' => array(
	                array(
	                    'title'     => __( 'Primary', 'ekiline' ),
	                    'block'     => 'div',
	                    'classes'   => 'alert alert-primary',
	                    'wrapper'   => true,
	                ),
	                array(
	                    'title'     => __( 'Secondary', 'ekiline' ),
	                    'block'     => 'div',
	                    'classes'   => 'alert alert-secondary',
	                    'wrapper'   => true,
	                ),
	                array(
	                    'title'     => __( 'Success', 'ekiline' ),
	                    'block'     => 'div',
	                    'classes'   => 'alert alert-success',
	                    'wrapper'   => true,
	                ),
	                array(
	                    'title'     => __( 'Danger', 'ekiline' ),
	                    'block'     => 'div',
	                    'classes'   => 'alert alert-danger',
	                    'wrapper'   => true,
	                ),
	                array(
	                    'title'     => __( 'Warning', 'ekiline' ),
	                    'block'     => 'div',
	                    'classes'   => 'alert alert-warning',
	                    'wrapper'   => true,
	                ),
	                array(
	                    'title'     => __( 'Info', 'ekiline' ),
	                    'block'     => 'div',
	                    'classes'   => 'alert alert-info',
	                    'wrapper'   => true,
	                ),
	                array(
	                    'title'     => __( 'Light', 'ekiline' ),
	                    'block'     => 'div',
	                    'classes'   => 'alert alert-light',
	                    'wrapper'   => true,
	                ),
	                array(
	                    'title'     => __( 'Dark', 'ekiline' ),
	                    'block'     => 'div',
	                    'classes'   => 'alert alert-dark',
	                    'wrapper'   => true,
	                ),
	            ),
	        ),
	        
	        array(
	            'title' => __( 'Grid', 'ekiline' ),
	            'items' => array(
	                array(
	                    'title'     => __( 'Set containers', 'ekiline' ),
	                    
						//valores anidados

				            'items' => array(
				                array(
				                    'title'     => __( 'container', 'ekiline' ),
				                    'selector'  => 'div',
				                    'classes'   => 'container',
				                ),
				                array(
				                    'title'     => __( 'container-fluid', 'ekiline' ),
				                    'selector'  => 'div',
				                    'classes'   => 'container-fluid',
				                ),
				                array(
				                    'title'     => __( 'Set rows', 'ekiline' ),
				                    // 'selector'  => 'div',
				                    // 'classes'   => 'row',
					                    // anidados
							            'items' => array(
							                array(
							                    'title'     => __( 'row', 'ekiline' ),
							                    'selector'  => 'div',
							                    'classes'   => 'row',
							                ),
							                // Horizontal
							                array(
							                    'title'     => __( 'justify-content-start', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'justify-content-start',
							                ),
							                array(
							                    'title'     => __( 'justify-content-center', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'justify-content-center',
							                ),
							                array(
							                    'title'     => __( 'justify-content-end', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'justify-content-end',
							                ),
							                array(
							                    'title'     => __( 'justify-content-around', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'justify-content-around',
							                ),
							                array(
							                    'title'     => __( 'justify-content-between', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'justify-content-between',
							                ),
							                //vertical
							                array(
							                    'title'     => __( 'align-items-start', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'align-items-start',
							                ),
							                array(
							                    'title'     => __( 'align-items-center', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'align-items-center',
							                ),
							                array(
							                    'title'     => __( 'align-items-end', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'align-items-end',
							                ),
							                // no margen
							                array(
							                    'title'     => __( 'no-gutters', 'ekiline' ),
							                    'selector'  => '.row',
							                    'classes'   => 'no-gutters',
							                ),
	         
						
							            ),	                    				                    				                    
					                    // fin anidados				                    				                    
				                ),            
			
				            ),	                    

						//fin de valores anidados
						
						
	                ),
	                array(
	                    'title'     => __( 'Set columns', 'ekiline' ),
	                    // anidados
			            'items' => array(
			            	//estandar
			                array(
			                    'title'     => __( 'col', 'ekiline' ),
			                    'selector'  => 'div',
			                    'classes'   => 'col',
			                ),
			                
			                //variable por display
			                array(
			                    'title'     => __( 'col-sm-*', 'ekiline' ),

			                    // anidados col-sm-*
					            'items' => array(
					            	//estandar
					                array(
					                    'title'     => __( 'col-sm-6', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'col-sm-6',
					                ),
					            	//estandar
					                array(
					                    'title'     => __( 'col-sm-auto', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'col-sm-auto',
					                ),
					
					            ),	                    				                    				                    
			                    // fin anidados	col-sm-*			                    
			                ),
			                array(
			                    'title'     => __( 'col-md-*', 'ekiline' ),

			                    // anidados col-md-*
					            'items' => array(
					            	//estandar
					                array(
					                    'title'     => __( 'col-md-4', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'col-md-4',
					                ),
					            	//estandar
					                array(
					                    'title'     => __( 'col-md-auto', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'col-md-auto',
					                ),
					
					            ),	                    				                    				                    
			                    // fin anidados col-md-*		                    
			                ),			     
			                array(
			                    'title'     => __( 'col-lg-*', 'ekiline' ),

			                    // anidados col-lg-*
					            'items' => array(
					            	//estandar
					                array(
					                    'title'     => __( 'col-lg-3', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'col-lg-3',
					                ),
					            	//estandar
					                array(
					                    'title'     => __( 'col-lg-auto', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'col-lg-auto',
					                ),
					
					            ),	                    				                    				                    
			                    // fin anidados col-lg-*		                    
			                ),
			                array(
			                    'title'     => __( 'col-xl-*', 'ekiline' ),

			                    // anidados col-xl-*
					            'items' => array(
					            	//estandar
					                array(
					                    'title'     => __( 'col-xl-3', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'col-xl-3',
					                ),
					            	//estandar
					                array(
					                    'title'     => __( 'col-xl-auto', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'col-xl-auto',
					                ),
					
					            ),	                    				                    				                    
			                    // fin anidados col-xl-*		                    
			                ),			                			                           
			                //fin variable por display			
			            ),	                    				                    				                    
	                    			                    
	                ),// fin Set Columns	
	                
	                array(
	                    'title'     => __( 'Column align/order', 'ekiline' ),
	                    // anidados
			            'items' => array(
			                //variable por align self
			                array(
			                    'title'     => __( 'align-self', 'ekiline' ),
					            'items' => array(				            
			                    // anidados align-self
					                array(
					                    'title'     => __( 'align-self-start', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'align-self-start',
					                ),
					                array(
					                    'title'     => __( 'align-self-center', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'align-self-center',
					                ),
					                array(
					                    'title'     => __( 'align-self-end', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'align-self-start',
					                ),
			                    // fin anidados	align-self			                    					
					            ),
			                ),//fin variable por align self
			                
			                //variable por order
			                array(
			                    'title'     => __( 'order', 'ekiline' ),
					            'items' => array(
					            	//estandar
					                array(
					                    'title'     => __( 'order-first', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'order-first',
					                ),					            
					                array(
					                    'title'     => __( 'order-last', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'order-last',
					                ),	
					                // por tamaño de columna
					                array(
					                    'title'     => __( 'order-sm-*', 'ekiline' ),
							            'items' => array(				            
							                array(
							                    'title'     => __( 'order-sm-first', 'ekiline' ),
							                    'selector'  => 'div',
							                    'classes'   => 'order-sm-first',
							                ),
							                array(
							                    'title'     => __( 'order-sm-last', 'ekiline' ),
							                    'selector'  => 'div',
							                    'classes'   => 'order-sm-last',
							                ),
							            ),
					                ),
					                array(
					                    'title'     => __( 'order-md-*', 'ekiline' ),
							            'items' => array(				            
							                array(
							                    'title'     => __( 'order-md-first', 'ekiline' ),
							                    'selector'  => 'div',
							                    'classes'   => 'order-md-first',
							                ),
							                array(
							                    'title'     => __( 'order-md-last', 'ekiline' ),
							                    'selector'  => 'div',
							                    'classes'   => 'order-md-last',
							                ),
							            ),
					                ),					                
					                array(
					                    'title'     => __( 'order-lg-*', 'ekiline' ),
							            'items' => array(				            
					                    // anidados order-sm
							                array(
							                    'title'     => __( 'order-lg-first', 'ekiline' ),
							                    'selector'  => 'div',
							                    'classes'   => 'order-lg-first',
							                ),
							                array(
							                    'title'     => __( 'order-lg-last', 'ekiline' ),
							                    'selector'  => 'div',
							                    'classes'   => 'order-lg-last',
							                ),
					                    // fin anidados	order-sm			                    					
							            ),
					                ),									
					                array(
					                    'title'     => __( 'order-xl-*', 'ekiline' ),
							            'items' => array(				            
					                    // anidados order-sm
							                array(
							                    'title'     => __( 'order-xl-first', 'ekiline' ),
							                    'selector'  => 'div',
							                    'classes'   => 'order-xl-first',
							                ),
							                array(
							                    'title'     => __( 'order-xl-last', 'ekiline' ),
							                    'selector'  => 'div',
							                    'classes'   => 'order-xl-last',
							                ),
					                    // fin anidados	order-sm			                    					
							            ),
					                ),
				                	//fin por tamaño de columna			                
					            ),
					            //fin variable order	
			                ),		                
			                //variable por offset
			                array(
			                    'title'     => __( 'offset', 'ekiline' ),
					            'items' => array(
					                // por tamaño de columna
					                array(
					                    'title'     => __( 'offset-sm-1', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'offset-sm-1',
					                ),
					                array(
					                    'title'     => __( 'offset-md-1', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'offset-md-1',
					                ),
					                array(
					                    'title'     => __( 'offset-lg-1', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'offset-lg-1',
					                ),
					                array(
					                    'title'     => __( 'offset-xl-1', 'ekiline' ),
					                    'selector'  => 'div',
					                    'classes'   => 'offset-xl-1',
					                ),
					                //fin por tamaño de columna			                					                					        	                    					
					            ),
			                ),//fin variable offset				                
			            ),	                    			                    
	                ),// fin Order Align Columns	
					// Medidas, margin padding etc…
	                array(
	                    'title'     => __( 'Measure', 'ekiline' ),
	                    // anidados
			            'items' => array(
			                //variable por margen
			                array(
			                    'title'     => __( 'margin', 'ekiline' ),
			                    // anidados margin
					            'items' => array(
					                array(
					                    'title'     => __( 'mt-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'mt-1',
					                ),
					                array(
					                    'title'     => __( 'mr-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'mr-1',
					                ),
					                array(
					                    'title'     => __( 'mb-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'mb-1',
					                ),
					                array(
					                    'title'     => __( 'ml-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'ml-1',
					                ),
					                array(
					                    'title'     => __( 'mx-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'mx-1',
					                ),
					                array(
					                    'title'     => __( 'my-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'my-1',
					                ),
					            ), // fin anidados	margin	
			                ),//fin variable por margen
			                //variable por padding
			                array(
			                    'title'     => __( 'padding', 'ekiline' ),
			                    // anidados padding
					            'items' => array(
					                array(
					                    'title'     => __( 'pt-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'pt-1',
					                ),
					                array(
					                    'title'     => __( 'pr-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'pr-1',
					                ),
					                array(
					                    'title'     => __( 'pb-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'pb-1',
					                ),
					                array(
					                    'title'     => __( 'pl-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'pl-1',
					                ),
					                array(
					                    'title'     => __( 'px-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'px-1',
					                ),
					                array(
					                    'title'     => __( 'py-1', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'py-1',
					                ),
					            ), // fin anidados	padding	
			                ),//fin variable por padding			                
			                //variable por width
			                array(
			                    'title'     => __( 'width', 'ekiline' ),
			                    // anidados width
					            'items' => array(
					                array(
					                    'title'     => __( 'w-25', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'w-25',
					                ),
					                array(
					                    'title'     => __( 'w-50', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'w-50',
					                ),
					                array(
					                    'title'     => __( 'w-75', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'w-75',
					                ),
					                array(
					                    'title'     => __( 'w-100', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'w-100',
					                ),
					                array(
					                    'title'     => __( 'mw-100', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'mw-100',
					                ),

					            ), // fin anidados	width	
			                ),//fin variable por width	
			                //variable por height
			                array(
			                    'title'     => __( 'height', 'ekiline' ),
			                    // anidados height
					            'items' => array(
					                array(
					                    'title'     => __( 'h-25', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'h-25',
					                ),
					                array(
					                    'title'     => __( 'h-50', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'h-50',
					                ),
					                array(
					                    'title'     => __( 'h-75', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'h-75',
					                ),
					                array(
					                    'title'     => __( 'h-100', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'h-100',
					                ),
					                array(
					                    'title'     => __( 'mh-100', 'ekiline' ),
					                    'selector'  => 'div,h1,h2,h3,h4,h5,h6,p,li,a',
					                    'classes'   => 'mh-100',
					                ),

					            ), // fin anidados	height	
			                ),//fin variable por height	
			            ),	                    				                    				                    
	                    			                    
	                ),// fin Medidas, margin padding etc…              
	                
	            ),
	        ),        

	        array(
	            'title' => __( 'Lists and tables', 'ekiline' ),
	            'items' => array(
	                array(
	                    'title'     => __( 'Unstyled List', 'ekiline' ),
	                    'selector'  => 'ul,ol',
	                    'classes'   => 'list-unstyled',
	                ),
	                array(
	                    'title'     => __( 'Inline List', 'ekiline' ),
	                    'selector'  => 'ul,ol',
	                    'classes'   => 'list-inline',
	                ),
	                array(
	                    'title'     => __( 'Inline list item', 'ekiline' ),
	                    'selector'  => 'li',
	                    'classes'   => 'list-inline-item',
	                ),
	                array(
	                    'title'     => __( 'Table', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table',
	                ),
	                array(
	                    'title'     => __( 'Table dark', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table-dark',
	                ),
	                array(
	                    'title'     => __( 'Table head light', 'ekiline' ),
	                    'selector'  => 'thead',
	                    'classes'   => 'thead-light',
	                ),
	                array(
	                    'title'     => __( 'Table head dark', 'ekiline' ),
	                    'selector'  => 'thead',
	                    'classes'   => 'thead-dark',
	                ),
	                array(
	                    'title'     => __( 'Table striped', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table-striped',
	                ),
	                array(
	                    'title'     => __( 'Table bordered', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table-bordered',
	                ),
	                array(
	                    'title'     => __( 'Table hoverable', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table-hover',
	                ),
	                array(
	                    'title'     => __( 'Table small', 'ekiline' ),
	                    'selector'  => 'table',
	                    'classes'   => 'table-sm',
	                ),
	            ),
	        ),

	        array(
	            'title' => __( 'Utilities', 'ekiline' ),
	            'items' => array(
	                array(
	                    'title'     => __( 'Float Left', 'ekiline' ),
	                    'selector'  => 'div, span, p',
	                    'classes'   => 'float-left',
	                ),
	                array(
	                    'title'     => __( 'Float Right', 'ekiline' ),
	                    'selector'  => 'div, span, p',
	                    'classes'   => 'float-right',
	                ),
	                array(
	                    'title'     => __( 'Clearfix', 'ekiline' ),
	                    'selector'  => 'div',
	                    'classes'   => 'clearfix',
	                ),            
	                array(
	                    'title'     => __( 'Blockquote', 'ekiline' ),
	                    'selector'  => 'blockquote',
	                    'classes'   => 'blockquote',
	                ),
	                array(
	                    'title'     => __( 'Reverse Blockquote', 'ekiline' ),
	                    'selector'  => 'blockquote',
	                    'classes'   => 'blockquote text-right',
	                ),
	                array(
	                    'title'     => __( 'Centered Blockquote', 'ekiline' ),
	                    'selector'  => 'blockquote',
	                    'classes'   => 'blockquote text-center',
	                ),
	                array(
	                    'title'     => __( 'Blockquote Footer', 'ekiline' ),
	                    'block'     => 'footer',
	                    'classes'   => 'blockquote-footer',
	                ),
	                array(
	                    'title'     => __( 'Rounded Image', 'ekiline' ),
	                    'selector'  => 'img',
	                    'classes'   => 'rounded',
	                ),
	                array(
	                    'title'     => __( 'Circle Image', 'ekiline' ),
	                    'selector'  => 'img',
	                    'classes'   => 'rounded-circle',
	                ),
	                array(
	                    'title'     => __( 'Thumbnail Image', 'ekiline' ),
	                    'selector'  => 'img',
	                    'classes'   => 'img-thumbnail',
	                ),
	                array(
	                    'title'     => __( 'Responsive Image', 'ekiline' ),
	                    'selector'  => 'img',
	                    'classes'   => 'img-fluid',
	                ),
	            ),
	        ),        	        
	        
        /** array(
	            'title' => __( 'Ekiline extra', 'ekiline' ),
	            'items' => array(
	                array(
	                    'title'     => __( 'Iframe modal', 'ekiline' ),
	                    'selector'  => 'a',
	                    'classes'   => 'modal-iframe',
	                ),
	                array(
	                    'title'     => __( 'Image modal', 'ekiline' ),
	                    'selector'  => 'a',
	                    'classes'   => 'modal-image',
	                ),
	                array(
	                    'title'     => __( 'Tooltip', 'ekiline' ),
	                    'selector'  => 'a',
	                    'classes'   => 'tooltip-default',
	                    'attributes' => array(
	                        'title' => 'Tooltip text'
	                    ),                                        
	                ),
	                array(
	                    'title'     => __( 'Popover', 'ekiline' ),
	                    'selector'  => 'a',
	                    'classes'   => 'popover-default',
	                    'attributes' => array(
	                        'title' => 'Popover Title',
	                        'data-content' => 'Popover Content',
	                    ),                                        
	                ),
	                array(
	                    'title'     => __( 'Popover dismiss', 'ekiline' ),
	                    'selector'  => 'a',
	                    'attributes' => array(
	                        'tabindex' => '0',
	                        'data-trigger' => 'focus',
	                    ),                                        
	                ),                                
	                array(
	                    'title'     => __( 'Popover Rich', 'ekiline' ),
	                    'selector'  => 'a',
	                    'classes'   => 'popover-rich',
	                    'attributes' => array(
	                        'title' => 'Popover Title',
	                    ),                                        
	                ),                                
	                array(
	                    'title'     => __( 'Show top', 'ekiline' ),
	                    'selector'  => 'a',
	                    'attributes' => array(
	                        'data-placement' => 'top'
	                    ),                                        
	                ),
	                array(
	                    'title'     => __( 'Show right', 'ekiline' ),
	                    'selector'  => 'a',
	                    'attributes' => array(
	                        'data-placement' => 'right'
	                    ),                                        
	                ),
	                array(
	                    'title'     => __( 'Show bottom', 'ekiline' ),
	                    'selector'  => 'a',
	                    'attributes' => array(
	                        'data-placement' => 'bottom'
	                    ),                                        
	                ),
	                array(
	                    'title'     => __( 'Show left', 'ekiline' ),
	                    'selector'  => 'a',
	                    'attributes' => array(
	                        'data-placement' => 'left'
	                    ),                                        
	                ),
	                array(  
	                    'title' => __('Hide content', 'ekiline'),  
	                    'block' => 'div',  
	                    'classes' => 'hide-content',
	                ),                                
	                                                
	            ),
	        ),	**/                        
	    
	    );  
	    
	    // Insertar los arreglos
	    // Insert the array, JSON ENCODED, into 'style_formats'
	    
	    $init_array['style_formats'] = json_encode( $style_formats );  
	    
	    return $init_array;  
	  
	} 
	// Se agrega el filtro para sobreescribir las ordenes en el editor TinyMCE
	// Attach callback to 'tiny_mce_before_init' 
	add_filter( 'tiny_mce_before_init', 'ekiline_mce_before' ); 
	
	
	/**
	 * Oct 11 2017, añadir tareas al tinymce:
	 * https://wordpress.stackexchange.com/questions/235020/how-to-add-insert-edit-link-button-in-custom-popup-tinymce-window 
	 * Otro estudio:
	 * https://jamesdigioia.com/add-button-pop-wordpresss-tinymce-editor/
	 * Un tutorial:
	 * https://dobsondev.com/2015/10/16/custom-tinymce-buttons-in-wordpress/
	 * Otro ejemplo más elaborado
	 * http://www.wpexplorer.com/wordpress-tinymce-tweaks/
	 * https://github.com/SufferMyJoy/dobsondev-wordpress-tinymce-example
	 **/
	 
	/**
	 * Add a custom button to tinymce editor
	 */
	add_action('admin_head', 'custom_mce_buttons');
 	function custom_mce_buttons() {
	    // Check if WYSIWYG is enabled
	    if ( get_user_option( 'rich_editing' ) == 'true' ) {
	        add_filter( 'mce_external_plugins', 'custom_tinymce_plugin' );
	        add_filter( 'mce_buttons_3', 'register_mce_buttons' );
	    }
	}
	
	
	// Add the path to the js file with the custom button function
	function custom_tinymce_plugin( $plugin_array ) {
	    // $plugin_array['custom_mce_button1'] = get_template_directory_uri() .'PATH_TO_THE_JS_FILE';
	    // $plugin_array['custom_mce_button2'] = get_template_directory_uri() .'PATH_TO_THE_OTHER_JS_FILE';
	    //$plugin_array['custom_mce_button1'] = get_template_directory_uri() .'/js/adminEditor.js';
	    $plugin_array['custom_mce_button2'] = get_template_directory_uri() .'/js/adminSubgrid.js';
	    $plugin_array['custom_mce_button3'] = get_template_directory_uri() .'/js/adminShowgrid.js';
	    $plugin_array['custom_mce_button4'] = get_template_directory_uri() .'/js/adminItemBg.js';
	    $plugin_array['custom_mce_button5'] = get_template_directory_uri() .'/js/adminMap.js';
	    $plugin_array['custom_mce_button6'] = get_template_directory_uri() .'/js/adminTabs.js';
	    $plugin_array['custom_mce_button7'] = get_template_directory_uri() .'/js/adminToggle.js';
	    $plugin_array['custom_mce_button8'] = get_template_directory_uri() .'/js/adminPops.js';
	    $plugin_array['custom_mce_button9'] = get_template_directory_uri() .'/js/adminShare.js';
	    $plugin_array['custom_mce_button10'] = get_template_directory_uri() .'/js/adminPostin.js';
	    // $plugin_array['custom_mce_button11'] = get_template_directory_uri() .'/js/adminFields.js';
	    $plugin_array['custom_mce_button12'] = get_template_directory_uri() .'/js/adminModal.js';
	    $plugin_array['custom_mce_button13'] = get_template_directory_uri() .'/js/adminLayout.js';
	    $plugin_array['custom_mce_button14'] = get_template_directory_uri() .'/js/adminCustom.js';
	    $plugin_array['custom_mce_button15'] = get_template_directory_uri() .'/js/adminFawfive.js';
	    return $plugin_array;
	}
	
	// Register and add new button in the editor
	function register_mce_buttons( $buttons ) {
	    //array_push( $buttons, 'custom_mce_button1' );
	    array_push( $buttons, 'custom_mce_button3, custom_mce_button2, custom_mce_button4, custom_mce_button6, custom_mce_button7, custom_mce_button8, custom_mce_button12, custom_mce_button10, custom_mce_button13, custom_mce_button14, custom_mce_button5, custom_mce_button9, custom_mce_button15' );
	    return $buttons;
	}
	
	// idioma: https://codex.wordpress.org/Plugin_API/Filter_Reference/mce_external_languages
	function ekiline_tinymce_add_locale($locales) {
	    $locales ['Ekiline-Tinymce'] = get_template_directory() . '/inc/ekiline-tinymce-langs.php';
	    return $locales;
	}
	add_filter('mce_external_languages', 'ekiline_tinymce_add_locale');
	
	
	/*
	 * Crear una lista dinámica de categorias existentes para shortcode 
	 * Pasar datos PHP al admin para el editor.
	 * https://codex.wordpress.org/Plugin_API/Filter_Reference/mce_external_plugins
	 * https://wordpress.stackexchange.com/questions/81895/how-to-list-categories-and-subcategories-in-json-format
	 */
	 
	// se invoca la funcion solo si está editando algun artículo.
	foreach ( array('post.php','post-new.php') as $hook ) {
	     add_action( "admin_head-$hook", 'my_admin_head' );
	}
	
	// Arreglo para incorporar el script al head.
	
		function my_admin_head() {
		// Prueba como la documentacion de wordpress.
	    //$plugin_url = plugins_url( '/', __FILE__ );
	
	    // mi arreglo para extraer los datos que necesito.
		//$args = array( 'orderby' => 'slug', 'parent' => 0, 'exclude' => '1' ); 
		$args = array( 'orderby' => 'name' ); 
		$cats = get_terms( 'category', $args ); 
		$list = array();
	
	    foreach ( $cats as $cat ) {
			$list[] = array(
				'text' =>	$cat->name,
				'value'	=>	$cat->term_id
			);
		}
		//var_dump($list);
		
		$json = wp_json_encode($list);
		
		// Prueba como la documentacion de wordpress.
		echo '<script type="text/javascript">'	."\n".
				// 'var my_plugin = { "url" : "'. $plugin_url .'" };'	."\n".
				'var tinyCatList =' . $json . ';'	."\n".
			 '</script>'."\n";
		}
		
		// agregar font awesome en admin solo en la edicion
		// https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
		function fontawesome_admin_style() {	
		    wp_register_style( 'fontawesome_admin_style', get_template_directory_uri() . '/css/fontawesome-all.min.css', false, '1.0.0' );
		    wp_enqueue_style( 'fontawesome_admin_style' );
		
			//la libreria de font awesome		    
			$extracss = '.mce-window.mce-container.mce-fontawesome-panel .mce-container-body.mce-abs-layout{overflow: hidden;}';
			//la interfaz de font awesome : font-family: Font Awesome 5 Free;
			$extracss .= '#iconCat-body ul{width:840px;max-width:840px;min-height:600px;}';
			$extracss .= '#iconCat-body ul,#iconCat-body ul li{padding:0px;margin:0px;}';
			$extracss .= '#iconCat-body ul li{text-align:center;padding:8px 0px 6px;width:40px;height:24px;cursor:pointer;float:left;}';
			$extracss .= '#iconCat-body ul li:hover{background-color:#f7f7f7;}';
			$extracss .= '#iconCat-body .fa,#iconCat-body .fas{font-family:"Font Awesome 5 Free";font-size:20px;font-weight: 900;}';
			$extracss .= '#iconCat-body .far {font-family:"Font Awesome 5 Free";font-size:20px;font-weight: 400;}';
			$extracss .= '#iconCat-body .fab {font-family:"Font Awesome 5 Brands";font-size:20px;}';		
			$extracss .= '#iconCat-body #icoDesc {position:fixed;top:37px;left:0px;right:0px;text-align:center;font-size:16px;background-color:#294350;color:#94f7ff;padding:4px;margin:0px;line-height:100%;}';		
		    wp_add_inline_style( 'wp-admin', $extracss );
		}
		add_action( 'admin_enqueue_scripts', 'fontawesome_admin_style');


}

//faltan botones
function wp_mce_buttons( $buttons ) {	
	$buttons[] = 'wp_page';
	return $buttons;
}
add_filter( 'mce_buttons_2', 'wp_mce_buttons' );

