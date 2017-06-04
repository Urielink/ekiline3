/**
 * ekiline Theme scripts.
 * (http://stackoverflow.com/questions/11159860/how-do-i-add-a-simple-jquery-script-to-wordpress)
 */

	jQuery(document).ready(function($){

	
	/** RUTAS RELATIVAS AL TEMA
	 *  Optimización, estilos dinámicos después de la carga
	 * 	Busco el head, y tambien si existe un 'link' y guardo el estilo en una variable para insertarlo.
	 *  apoyo: http://stackoverflow.com/questions/805384/how-to-apply-inline-and-or-external-css-loaded-dynamically-with-jquery
	 *  Advertencia: Esta función se coordina con inc/extras.php, el orden de los scripts y este archivo.
	 */
		
		function miCss(archivoCss){

			var templateUrl = thepath.themePath;
			
			var $head = $("head");
			var $wpcss = $head.find("style[id='ekiline-inline']"); 
			var $cssinline = $head.find("style:last");
			var $ultimocss = $head.find("link[rel='stylesheet']:last");
			var linkCss = "<link rel='stylesheet' href='"+ templateUrl + archivoCss +"' type='text/css' media='screen'>";
	
	        // En caso de de encontrar una etiqueta de estilo ó link ó nada inserta el otro estilo css, 

			if ($wpcss.length){ 
					$wpcss.before(linkCss); 
				} else if ($cssinline.length){ 
					$cssinline.before(linkCss); 
				} else if ($ultimocss.length){ 
					$ultimocss.before(linkCss); 
				} else { 
					$head.append(linkCss); 
				}

			
		}
		
			miCss('/css/bootstrap.min.css');
			miCss('/css/font-awesome.min.css');
			miCss('/css/ekiline-layout.css');
			miCss('/style.css');
			//en caso de explorer
			if(/*@cc_on!@*/false){ miCss('/style.css'); }		


	/**  RUTAS ABSOLUTAS EXTERNAS AL TEMA
	 * Optimización, cargar scripts externos despúes de la carga informativa
	 * Advertencia: Esta función se coordina con inc/extras.php, el orden de los scripts y este archivo.
	 */

//			function extCss(archivoCss){
//				
//				var $head = $("head");
//				var $wpcss = $head.find("style[id='ekiline-inline']"); 
//				var $cssinline = $head.find("style:last");
//				var $ultimocss = $head.find("link[rel='stylesheet']:last");
//				var linkCss = "<link rel='stylesheet' href='"+ archivoCss +"' type='text/css' media='screen'>";
//		
//		        // En caso de de encontrar una etiqueta de estilo ó link ó nada inserta el otro estilo css, 
//
//				if ($wpcss.length){ 
//						$wpcss.before(linkCss); 
//					} else if ($cssinline.length){ 
//						$cssinline.before(linkCss); 
//					} else if ($ultimocss.length){ 
//						$ultimocss.before(linkCss); 
//					} else { 
//						$head.append(linkCss); 
//					}
//
//				
//			}
//			
//			var gfontUrl = gfpath.googlePath;
//			extCss( gfontUrl );		
		
			
			
		
		// El preload
	    setTimeout(function(){
	        $('#pageLoad').fadeOut(500);
	    }, 600);			          
			
		
/*		
		var desfaseItem = '.carousel';
		var desfaseItem = '.destacado-estilo';
		var desfaseDerecho = '.thumb';
		var apareceItem = '.entry-title';
		var textoLoco = '#carrusel-homeslide .carousel-caption h1';
		
		
			
	    //desfasa la imagen de fondo
		
	    $(window).bind("load resize scroll",function(e) {
	        var y = $(window).scrollTop();

	        $( desfaseItem ).filter(function() {
	            return $(this).offset().top < (y + $(window).height()) &&
	            $(this).offset().top + $(this).height() > y;
	        }).css('background-position', 'center ' + parseInt(y / -2) + 'px');        

	        $( desfaseDerecho ).filter(function() {
	            return $(this).offset().top < (y + $(window).height()) &&
	            $(this).offset().top + $(this).height() > y;
	        }).css('background-position', 'right ' + parseInt(y / 2) + 'px');                
	        
	    });

	    // aparece los elementos a medida del scroll
	    $(window).scroll( function(){

	        // Por cada imagen 
	        $( apareceItem ).each( function(i){

	            var bottom_of_object = $(this).offset().top + $(this).outerHeight();
	            var bottom_of_window = $(window).scrollTop() + $(window).height();

	            // Si esta en el lugar fade in 
	            if( bottom_of_window > bottom_of_object ){
	                $(this).animate({'opacity':'1'},500);
	            }            

	        }); 

	    }); 
	    
	    // Hacer un texto a desproporcion
	    var size = ['16px', '24px', '32px', '40px', '44px'];
	    var weight = ['100', '300', '700', '900'];
	    $(textoLoco).each(function(){
	        $(this).html($(this).text().split(' ').map(function(v){
	            return '<span style="font-size:'+size[Math.floor(Math.random()*size.length)]+';font-weight:'+weight[Math.floor(Math.random()*weight.length)]+'">'+v+'</span>';
	        }).join(' '));
	    });
	    
	    // affix al menu
	    $('#secondary').affix({
	    	  offset: {
	    	    top: 100,
	    	    bottom: function () {
	    	      return (this.bottom = $('.footer').outerHeight(true))
	    	    }
	    	  }
	    	});	 
	    
	    $('#secondary').on('affix.bs.affix', function () {
	        $('#primary').addClass('col-md-offset-3')
	    });
	    $('#secondary').on('affix-top.bs.affix', function () {
	        $('#primary').removeClass('col-md-offset-3')
	    });
*/

		// Lazyload para imagenes
//		$('img').lazyload({ 
//			threshold : 200,
//		    //placeholder : 'apple-touch-icon.png',
//		    effect : "fadeIn" 
//		});	    
		
		// Carrusel: impedir que avance automaticamente
		
        $('.carousel').carousel({ interval: false });     
		

	    if ( $('#masthead').length ) {
	    	
	    	//console.log ('si header');
	    	//console.log ( $('#masthead').height() );
	    	
	    	$('.top-navbar.navbar-affix').affix({
		        offset: {
		          top: $('#masthead').height()
		        }
		    });

	    } else {
	    	
//	    	console.log ('no header');
//	    	console.log ( $('.top-navbar.navbar-affix').height() );

	    	$('.top-navbar.navbar-affix').affix({
		        offset: {
		          top: $('.top-navbar').height()
		        }
		    });	    	
	    	
	    }
	    

	    // Carrusel con swipe
	    $('.carousel').carousel({
	    	  swipe: 30 // percent-per-second, default is 50. Pass false to disable swipe
	    	});	  
	    



		/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
		 * 
		 *	Alerta en el formulario de comentarios
		 *	Ejercicio original: http://stackoverflow.com/questions/33440243/wordpress-change-comment-error-message
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/			
					
			    /**
			     *  Modal de validaciones.
			     *  1) la estructura de la caja (base bootstrap)
			     *  2) el arreglo para ver las alertas
			     *  3) el arreglo para ver el submit
			     *  4) eliminar el rastro de los modals (este normalmente se acumula si se invoca.)
			     * 
			     */        
			           
			        var modalAbre = '<div class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-body">\
			                                <button type="button" class="close" data-dismiss="modal">&times;</button>';
			        var msjlAlerta = '<h4 class="text-center">¡Ups! olvidaste un dato</h4><p class="text-center">Por favor llena todos los campos.</p>';  
			        var msjConfirma = '<h4 class="text-center">¡Gracias por tu mensaje!</h4><p class="text-center">Lo revisaremos.</p>';  
			        var modalCierra = '</div></div></div></div>';             
			  
			        
			        $('#commentform').submit(function() {
			            
			            // modal + mensaje
			            var modalbox = modalAbre + msjlAlerta + modalCierra; 
		            	var valEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;	            	
			            
			            // si no estan llenos suelta la alerta
			            if ( $.trim( $("#comment").val() ) === "" || $.trim( $("#author").val() ) === "" || $.trim($("#email").val() ) === "" || valEmail.test( $("#email").val() ) === false || $.trim($("#url").val()) === "" ) {
			            	
	            			$( modalbox ).modal('show');
	            			
			                return false;
			                		            
			        	} else {

				            // modal + mensaje
				            var modalbox = modalAbre + msjConfirma + modalCierra;    
				            // el formulario ok suelta la confirmación          
				            $( modalbox ).modal("show");   
				            // cuando el usuario cierre la ventana, envialo a la otra página. 
				            // $( 'body' ).on('hidden.bs.modal', function(){
				              // window.location.href = 'gracias.html';    
				            // });             		            
			            }
			            
			        });		           
			        
			        // Borrar registro del modal
			        $( 'body' ).on('hidden.bs.modal', function(){
			          $( '.modal, .modal-backdrop' ).remove();
			        });         	    
	    
			    	
	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * 
	 *	Agregar clases en items del core de wordpress
	 *	Widgets que no requieren ser sobreescritos (overide)
	 * 
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * **/		
			
		$( '.widget_rss ul' ).addClass( 'list-group' );		
		$( '.widget_rss ul li' ).addClass( 'list-group-item' );		
		//$( '.widget_meta ul, .widget_recent_entries ul, .widget_archive ul, .widget_categories ul, .widget_nav_menu ul, .widget_pages ul' ).addClass( 'nav' );
		//$( '.widget_recent_comments ul#recentcomments' ).css( 'list-style', 'none').css( 'padding-left', '0' );
		//$( '.widget_recent_comments ul#recentcomments li' ).css( 'padding', '5px 15px');		
		$( '#calendar_wrap, .calendar_wrap' ).addClass( 'table-responsive');
		$( 'table#wp-calendar' ).addClass( 'table table-striped');
		$( '.widget_text select, .widget_archive select, .widget_categories select' ).addClass( 'form-control');
		$( '.widget_recent_comments ul' ).addClass('list-group');
		$( '.widget_recent_comments ul li' ).addClass( 'list-group-item');		
//		$( '.widget_recent_entries ul' ).addClass( 'media-list');		
//		$( '.widget_recent_entries ul li' ).addClass( 'media');		
//		$( '.widget_recent_entries ul li .post-date' ).addClass( 'badge');		
		$( '.widget_recent_comments ul li' ).addClass( 'list-group-item');		
		$( '.nav-links' ).addClass( 'pager');		
		$( '.nav-links .nav-next' ).addClass( 'next');		
		$( '.nav-links .nav-previous' ).addClass( 'previous');		
			   
		
		/** 
		 * experimento array de rutas
		 * http://api.jquery.com/JQuery.each/
		 */

//		var obj = {
//				  "handler1": "rutahandler1",
//				  "handler2": "rutahandler2"
//				};		

//		$.each( obj, function( key, value ) {
//				// alert( key + ": " + value );
//
//			var $head = $("head");
//			var $wpcss = $head.find("style[id='ekiline-inline']"); 
//			var $cssinline = $head.find("style:last");
//			var $ultimocss = $head.find("link[rel='stylesheet']:last");
//			var linkCss = "<link id='"+ key +"' rel='stylesheet' href='"+ value +"' type='text/css' media='screen'>";
//
//	        // En caso de de encontrar una etiqueta de estilo ó link ó nada inserta el otro estilo css, 
//
//			if ($wpcss.length){ 
//					$wpcss.before(linkCss); 
//				} else if ($cssinline.length){ 
//					$cssinline.before(linkCss); 
//				} else if ($ultimocss.length){ 
//					$ultimocss.before(linkCss); 
//				} else { 
//					$head.append(linkCss); 
//				}		
//		
//			
//			
//		});
		
			
	    

	}); 			
			