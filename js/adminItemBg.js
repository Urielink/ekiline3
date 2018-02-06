/**
 * adminEditor.js
 *
 * Dic 15 2017, layouts o grid:
 * Casos de estudio
 * https://stackoverflow.com/questions/24695323/tinymce-listbox-onsubmit-giving-object-object-rather-than-value
 * https://stackoverflow.com/questions/23476463/wordpress-tinymce-add-a-description-to-a-popup-form
 * 
 * Oficial tinyMce.
 * https://www.tinymce.com/docs/advanced/creating-custom-dialogs/
 * https://www.tinymce.com/docs/demo/custom-toolbar-listbox/
 * 
 * Ejemplo de dialogo
 * https://jsfiddle.net/aeutaoLf/2/
 *
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button4', function(editor, url) {
    	
        editor.addButton('custom_mce_button4', {
            //icon: false,
            //text: 'B4 Cols',
            //title : 'Add background',
            title : editor.getLang('ekiline_tinymce.addbackground'),
            image: '../wp-content/themes/ekiline/img/ico-bg.png',
            onclick: function (e) {
            	
            	// reconocer el objeto seleccionado.
                var trackitem =  tinymce.activeEditor.selection.getNode();
                // declarar la variable de color por default (vacia para elementos sin estilo)
            	var color = '';
                // declarar la variable de imagen de fondo por default (vacia para elementos sin estilo)
            	var bgimg = '';
            	
            	/**
            	 * reconocer si existe color en los elementos seleccionados.
            	 * http://jsfiddle.net/DCaQb/
            	 * reconocer si tiene estilos
            	 * https://stackoverflow.com/questions/1318076/jquery-hasattr-checking-to-see-if-there-is-an-attribute-on-an-element
            	 */
            	
//				var attr = $( trackitem ).attr('style');				
//				if (typeof attr !== typeof undefined && attr !== false) {

				var bgex = $( trackitem ).css('background-color');	
				// console.log( bgex );				
				// si el elemento no es transaparente, entonces necesita reconocer el color de fondo.
				if ( bgex != 'transparent' && bgex != 'rgba(0, 0, 0, 0)' ) {
					
				   // console.log( 'si hay estilos' );

	            	var x = $(trackitem).css('background-color');
				    // console.log(x);
	           	    hexc(x);
				    // console.log(color);
	
					function hexc(colorval) {
					    var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
					    delete( parts[0]);
					    for (var i = 1; i <= 3; ++i) {
					        parts[i] = parseInt(parts[i]).toString(16);
					        if (parts[i].length == 1) parts[i] = '0' + parts[i];
					    }
					    color = '#' + parts.join('');
					}

				} 
				
				var imgex = $( trackitem ).css('background-image');	
				//console.log( imgex );				
				
				if ( imgex != '' && imgex != 'none' ) {
					    bgimg = imgex.replace('url("','').replace('")','');
				}

            	
                editor.windowManager.open({
                	
                    //title: 'Choose a background color or set an image',
		            title : editor.getLang('ekiline_tinymce.choosebgcolor'),
                    minWidth: 500,
                    minHeight: 100,

                    body: [
                    // item 1, el selector de color: cachamos el valor de color en un campo de texto oculto.
                    // https://laubsterboy.com/blog/2014/07/wordpress-editor-custom-buttons-dialog-windows/
						{
                        	type	: 'textbox',
                        	name	: 'bgvalue',
                        	id		: 'bgselect',
                        	value	: color ,
                    	},
				        {
				            type	: 'colorpicker',
				            name	: 'colorpicker',
				            id		: 'colorInput',	
				            value	: color,
                        	onchange : function(e) {
                        		
                        		// declaro la variable que me da el color
                        		var selected = this.value();
                    			var txtColor = jQuery('#bgselect');

                        		jQuery( function($){
	                                e.preventDefault();
		                                txtColor.val( selected );	                        		                 					                        		
                        		});     
                        		                   		
                        	}
                        	
							// onchange: function() { 
								// console.log( this.value() ); 
							// }		            
				            
				        },

						/** item 2, el selector de imagen
						 * explorar: https://stackoverflow.com/questions/32705935/wordpress-tinymce-window-manager-upload-button-not-adding-url-to-text-field
						 * http://archive.tinymce.com/wiki.php/API3:method.tinymce.dom.DOMUtils.setStyle
						 * https://www.tinymce.com/docs-3x/api/dom/class_tinymce.dom.Selection.html/#selection
						 * https://www.tinymce.com/docs-3x/reference/configuration/Configuration3x@selector/
						 * https://jsfiddle.net/aeutaoLf/2/
						 * ***** https://stackoverflow.com/questions/26263597/open-access-wp-media-library-from-tinymce-plugin-popup-window 
						 * https://wordpress.org/support/topic/using-media-upload-with-tinymce/ 
						 * **/

						// Item 2, cachamos el valor de la imagen (url) en un campo de texto oculto.
						{
                        	type	: 'textbox',
                        	//subtype	: 'hidden',
                        	name	: 'url',
                        	id		: 'imageVal',
                        	value	: bgimg
                    	},
                    	{
                        	type	: 'button',
                        	name	: 'image',
                        	//text	: 'Image',
				            text : editor.getLang('ekiline_tinymce.image'),                        	
                        	onclick	: function(e) {

	                            jQuery( function($){
	
	                                var frame;
	
	                                // ADD IMAGE LINK
	                                e.preventDefault();

	                                // If the media frame already exists, reopen it.
	                                if ( frame ) {
	                                    frame.open();
	                                    return;
	                                }
	
	                                // Create a new media frame
	                                frame = wp.media({
	                                    //title	: 'Choose background image',
	                                    title	: editor.getLang('ekiline_tinymce.choosebgimg'),
	                                    button	: {
	                                      //text	: 'Choose'
	                                      text	: editor.getLang('ekiline_tinymce.choose')
	                                    },
	                                    multiple: false  // Set to true to allow multiple files to be selected
	                                });
	
	                                // When an image is selected in the media frame...
	                                frame.on( 'select', function() {
	
	                                    // Get media attachment details from the frame state
	                                    var attachment = frame.state().get('selection').first().toJSON();
                            			var hidden = jQuery('#imageVal');
                            			
		                                hidden.val( attachment.url );
							
	                                });
	                                // Finally, open the modal on click
	                                frame.open();
	                        });
                        
	                        return false;
	                        
	                        }
	                    },
// fin item 2, inicia el estilo de fondo.		        
	                    {
	                        type: 'listbox', 
	                        name: 'bgstyle', 
	                        //label: 'Background style', 
	                        label: editor.getLang('ekiline_tinymce.bgstyle'),
	                        'values': [
								{
		                        	// text	: 'Pattern',
		                        	text	: editor.getLang('ekiline_tinymce.pattern'),
		                        	value	: ''
		                    	},
								{
		                        	// text	: 'Simple',
		                        	text	: editor.getLang('ekiline_tinymce.simple'),
		                        	value	: 'bg-single'
		                    	},
								{
		                        	// text	: 'Responsive',
		                        	text	: editor.getLang('ekiline_tinymce.responsive'),
		                        	value	: 'bg-responsive'
		                    	},
								{
		                        	// text	: 'Fixed',
		                        	text	: editor.getLang('ekiline_tinymce.fixed'),
		                        	value	: 'bg-responsive-fix'
		                    	},
								{
		                        	// text	: 'Parallax',
		                        	text	: editor.getLang('ekiline_tinymce.parallax'),
		                        	value	: 'bg-responsive-delay'
		                    	},
	                        ]
	                    },                      	
                	],                    	
                    onsubmit: function (e) {
                        //editor.insertContent( '<div style="min-width:100px;height:50px;background-color:' + e.data.colorpicker + ';"> color: ' + e.data.colorpicker + ' </div>' );
                        
                        //http://archive.tinymce.com/wiki.php/API3:method.tinymce.dom.DOMUtils.setAttrib
                        //tinymce.activeEditor.dom.setAttrib( tinymce.activeEditor.dom.select('div'), 'style', 'background-color:' + e.data.colorpicker );
                        
                        // obtener el elemento donde esta el cursor http://archive.tinymce.com/wiki.php/api4:class.tinymce.dom.Selection
                        //alert(tinymce.activeEditor.selection.getNode().nodeName);

                        //v1//tinymce.activeEditor.dom.setAttrib(tinymce.activeEditor.selection.getNode(), 'style', 'background-color:' + e.data.colorpicker );
                        //tinymce.activeEditor.dom.setStyle( tinymce.activeEditor.selection.getNode(), 'background-color' + e.data.colorpicker );
                        
                        //v2 > bueno: http://archive.tinymce.com/wiki.php/API3:method.tinymce.dom.DOMUtils.setStyle
                        
                        //var trackitem =  tinymce.activeEditor.selection.getNode();
                        
                        // console.log(e.data.bgvalue);
                        // console.log(e.data.url);
                        // console.log(e.data.bgstyle);
                                                                        
                        if (e.data.bgvalue !== null && e.data.bgvalue !== '' && e.data.bgvalue !== 'none'){
                        	tinymce.activeEditor.dom.setStyle( trackitem , 'background-color', e.data.bgvalue );
                        } else {
                        	tinymce.activeEditor.dom.setStyle( trackitem , 'background-color', '' );
                        }
                       
                        if (e.data.url !== null && e.data.url !== '' && e.data.url !== 'none'){
	                        tinymce.activeEditor.dom.setStyle( trackitem , 'background-image', 'url('+ e.data.url +')' );
	                        tinymce.activeEditor.dom.addClass( trackitem , e.data.bgstyle );
                        } else {
	                        tinymce.activeEditor.dom.setStyle( trackitem , 'background-image', '' );                        	
                        }
                        
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
    });
} )( jQuery );