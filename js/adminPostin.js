/**
 * Ekiline for WordPress Theme, Copyright 2018 Uri Lazcano. Ekiline is distributed under the terms of the GNU GPL. http://ekiline.com
 * 
 * adminPostin.js
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
 * Pase de datos
 * https://www.w3schools.com/js/tryit.asp?filename=tryjson_array_nested
 * https://www.w3schools.com/js/js_json_arrays.asp
 * https://www.codesd.com/item/dynamically-updating-a-tinymce-4-listbox.html
 * https://thewebsitedev.com/dynamic-content-tinymce/
 *
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button10', function(editor, url) {
    	        	
        editor.addButton('custom_mce_button10', {
            //icon: false,
            // title : 'Entries module',
            // title : editor.getLang('ekiline_tinymce.modcat'),
            // image: editor.getLang('ekiline_tinymce.themePath')+'/img/ico-insert.png',
            title : ekiTinyL10n.modcat,
            image: ekiTinyL10n.themePath+'/img/ico-insert.png',
            onclick: function (e) {
            	
            	// console.log(my_plugin);
            	// console.log(my_cats);

                editor.windowManager.open({
                	
                    // title: editor.getLang('ekiline_tinymce.modcat'),
                    title: ekiTinyL10n.modcat,
                    minWidth: 500,
                    minHeight: 100,

                    body: [
						{
				            type   : 'label',
				            name   : 'description',
				            // text   : 'Choose category and format to show a list of entries.'
				            // text   : editor.getLang('ekiline_tinymce.modcatdesc')
				            text   : ekiTinyL10n.modcatdesc
						},                    
	                    {
	                    	type   : 'listbox', 
	                    	name   : 'catids',
	                    	// obtengo los datos desde mi función. 
						    'values' : tinyCatList						    
	                	},
	                    {
	                    	type   : 'listbox', 
	                    	name   : 'format',
	                        'values': [
								{
		                        	// text	: 'Default list',
		                        	// text	: editor.getLang('ekiline_tinymce.default'),
		                        	text	: ekiTinyL10n.default,
		                        	value	: ''
		                    	},
								{
		                        	// text	: 'Block modules',
		                        	// text	: editor.getLang('ekiline_tinymce.block'),
		                        	text	: ekiTinyL10n.block,
		                        	value	: ' format="block"'
			                    },
								{
		                        	text	: ekiTinyL10n.block + ' ' + ekiTinyL10n.showcol2,
		                        	value	: ' format="block" columns="2"'
			                    },
								{
		                        	text	: ekiTinyL10n.block + ' ' + ekiTinyL10n.showcol3,
		                        	value	: ' format="block" columns="3"'
			                    },
								{
		                        	text	: ekiTinyL10n.block + ' ' + ekiTinyL10n.showcol4,
		                        	value	: ' format="block" columns="4"'
			                    },			                    
								{
		                        	// text	: 'Carousel slider',
		                        	// text	: editor.getLang('ekiline_tinymce.carousel'),
		                        	text	: ekiTinyL10n.carousel,
		                        	value	: ' format="carousel"'
		                    	},
								{
		                        	text	: ekiTinyL10n.carousel + ' ' + ekiTinyL10n.showcol2,
		                        	value	: ' format="carousel" columns="2"'
			                    },			                    
								{
		                        	text	: ekiTinyL10n.carousel + ' ' + ekiTinyL10n.showcol3,
		                        	value	: ' format="carousel" columns="3"'
			                    },			                    
								{
		                        	text	: ekiTinyL10n.carousel + ' ' + ekiTinyL10n.showcol4,
		                        	value	: ' format="carousel" columns="4"'
			                    },			                    		                    	
								{
		                        	text	: ekiTinyL10n.showcards,
		                        	value	: ' format="cards"'
		                    	},
								{
		                        	text	: ekiTinyL10n.showimagecards,
		                        	value	: ' format="imagecards"'
		                    	},
								{
		                        	text	: ekiTinyL10n.noformat,
		                        	value	: ' format="none"'
		                    	}
	                        ]   			    
	                	},
						{
				            type   : 'textbox',
				            name   : 'amount',
				            value  : 5,
				            // label   : 'Set the amount of posts'
				            // label   : editor.getLang('ekiline_tinymce.amount')
				            label   : ekiTinyL10n.amount
						}						                    

                	],                    	
                    onsubmit: function (e) {
                        editor.insertContent(' [modulecategoryposts catid="'+ e.data.catids +'" limit="'+ e.data.amount +'"'+ e.data.format +']<br><br>' );
                    }
                    
                }); //editor.windowManager.open
                
            }
        });
        
    });
        
} )( jQuery );
