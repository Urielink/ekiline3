/**
 * Ekiline for WordPress Theme, Copyright 2018 Uri Lazcano. Ekiline is distributed under the terms of the GNU GPL. http://ekiline.com
 * 
 * adminFawfive.js
 *
 */

( function ( $ ) {
    tinymce.PluginManager.add('custom_mce_button15', function(editor, url) {
    	
        editor.addButton('custom_mce_button15', {
            //icon: false,
            title : 'FontAwesome',
            image: editor.getLang('ekiline_tinymce.themePath')+'/img/ico-faw.png',
            onclick: function (e) {
            	
//mi html previo CSS y HTML
				// var	uiCss = '<link rel="stylesheet" href="'+editor.getLang('ekiline_tinymce.themePath')+'/css/fontawesome-all.min.css" type="text/css" media="all" />'; 
				var	uiCss = '<link rel="stylesheet" href="'+editor.getLang('ekiline_tinymce.themePath')+'/css/fontawesome-all.min.css" media="all" />'; 
					// uiCss += '<style type="text/css">';
					uiCss += '<style>';
					uiCss += '.mce-window.mce-container.mce-fontawesome-panel .mce-container-body.mce-abs-layout{overflow: hidden;}';
					uiCss += '#iconCat-body ul{width:840px;max-width:840px;min-height:600px;list-style:none;}';
					uiCss += '#iconCat-body ul,#iconCat-body ul li{padding:0px;margin:0px;}';
					uiCss += '#iconCat-body ul li{text-align:center;padding:8px 0px 6px;width:40px;height:24px;cursor:pointer;float:left;}';
					uiCss += '#iconCat-body ul li:hover{background-color:#f7f7f7;}';
					uiCss += '#iconCat-body .fa,#iconCat-body .fas{font-family:"Font Awesome 5 Free";font-size:20px;font-weight: 900;}';
					uiCss += '#iconCat-body .far {font-family:"Font Awesome 5 Free";font-size:20px;font-weight: 400;}';
					uiCss += '#iconCat-body .fab {font-family:"Font Awesome 5 Brands";font-size:20px;}';		
					uiCss += '#iconCat-body #icoDesc {position:fixed;top:37px;left:0px;right:0px;text-align:center;font-size:16px;background-color:#294350;color:#94f7ff;padding:4px;margin:0px;line-height:100%;}';		
					uiCss += '</style>';
				
            	var uiFaw = '';
            	var uiFawS = '';
            	var uiFawR = '';
            	var uiFawB = '';
	
				var solid = 'address-book,address-card,adjust,align-center,align-justify,align-left,align-right,ambulance,american-sign-language-interpreting,anchor,angle-double-down,angle-double-left,angle-double-right,angle-double-up,angle-down,angle-left,angle-right,angle-up,archive,arrow-alt-circle-down,arrow-alt-circle-left,arrow-alt-circle-right,arrow-alt-circle-up,arrow-circle-down,arrow-circle-left,arrow-circle-right,arrow-circle-up,arrow-down,arrow-left,arrow-right,arrow-up,arrows-alt,arrows-alt-h,arrows-alt-v,assistive-listening-systems,asterisk,at,audio-description,backward,balance-scale,ban,barcode,bars,baseball-ball,basketball-ball,bath,battery-empty,battery-full,battery-half,battery-quarter,battery-three-quarters,bed,beer,bell,bell-slash,bicycle,binoculars,birthday-cake,blind,bold,bolt,bomb,book,bookmark,bowling-ball,braille,briefcase,bug,building,bullhorn,bullseye,bus,calculator,calendar,calendar-alt,calendar-check,calendar-minus,calendar-plus,calendar-times,camera,camera-retro,car,caret-down,caret-left,caret-right,caret-square-down,caret-square-left,caret-square-right,caret-square-up,caret-up,cart-arrow-down,cart-plus,certificate,chart-area,chart-bar,chart-line,chart-pie,check,check-circle,check-square,chess,chess-bishop,chess-board,chess-king,chess-knight,chess-pawn,chess-queen,chess-rook,chevron-circle-down,chevron-circle-left,chevron-circle-right,chevron-circle-up,chevron-down,chevron-left,chevron-right,chevron-up,child,circle,circle-notch,clipboard,clock,clone,closed-captioning,cloud,cloud-download-alt,cloud-upload-alt,code,code-branch,coffee,cog,cogs,columns,comment,comment-alt,comments,compass,compress,copy,copyright,credit-card,crop,crosshairs,cube,cubes,cut,database,deaf,desktop,dollar-sign,dot-circle,download,edit,eject,ellipsis-h,ellipsis-v,envelope,envelope-open,envelope-square,eraser,euro-sign,exchange-alt,exclamation,exclamation-circle,exclamation-triangle,expand,expand-arrows-alt,external-link-alt,external-link-square-alt,eye,eye-dropper,eye-slash,fast-backward,fast-forward,fax,female,fighter-jet,file,file-alt,file-archive,file-audio,file-code,file-excel,file-image,file-pdf,file-powerpoint,file-video,file-word,film,filter,fire,fire-extinguisher,flag,flag-checkered,flask,folder,folder-open,font,football-ball,forward,frown,futbol,gamepad,gavel,gem,genderless,gift,glass-martini,globe,golf-ball,graduation-cap,h-square,hand-lizard,hand-paper,hand-peace,hand-point-down,hand-point-left,hand-point-right,hand-point-up,hand-pointer,hand-rock,hand-scissors,hand-spock,handshake,hashtag,hdd,heading,headphones,heart,heartbeat,history,hockey-puck,home,hospital,hourglass,hourglass-end,hourglass-half,hourglass-start,i-cursor,id-badge,id-card,image,images,inbox,indent,industry,info,info-circle,italic,key,keyboard,language,laptop,leaf,lemon,level-down-alt,level-up-alt,life-ring,lightbulb,link,lira-sign,list,list-alt,list-ol,list-ul,location-arrow,lock,lock-open,long-arrow-alt-down,long-arrow-alt-left,long-arrow-alt-right,long-arrow-alt-up,low-vision,magic,magnet,male,map,map-marker,map-marker-alt,map-pin,map-signs,mars,mars-double,mars-stroke,mars-stroke-h,mars-stroke-v,medkit,meh,mercury,microchip,microphone,microphone-slash,minus,minus-circle,minus-square,mobile,mobile-alt,money-bill-alt,moon,motorcycle,mouse-pointer,music,neuter,newspaper,object-group,object-ungroup,outdent,paint-brush,paper-plane,paperclip,paragraph,paste,pause,pause-circle,paw,pen-square,pencil-alt,percent,phone,phone-square,phone-volume,plane,play,play-circle,plug,plus,plus-circle,plus-square,podcast,pound-sign,power-off,print,puzzle-piece,qrcode,question,question-circle,quidditch,quote-left,quote-right,random,recycle,redo,redo-alt,registered,reply,reply-all,retweet,road,rocket,rss,rss-square,ruble-sign,rupee-sign,save,search,search-minus,search-plus,server,share,share-alt,share-alt-square,share-square,shekel-sign,shield-alt,ship,shopping-bag,shopping-basket,shopping-cart,shower,sign-in-alt,sign-language,sign-out-alt,signal,sitemap,sliders-h,smile,snowflake,sort,sort-alpha-down,sort-alpha-up,sort-amount-down,sort-amount-up,sort-down,sort-numeric-down,sort-numeric-up,sort-up,space-shuttle,spinner,square,square-full,star,star-half,step-backward,step-forward,stethoscope,sticky-note,stop,stop-circle,stopwatch,street-view,strikethrough,subscript,subway,suitcase,sun,superscript,sync,sync-alt,table,table-tennis,tablet,tablet-alt,tachometer-alt,tag,tags,tasks,taxi,terminal,text-height,text-width,th,th-large,th-list,thermometer-empty,thermometer-full,thermometer-half,thermometer-quarter,thermometer-three-quarters,thumbs-down,thumbs-up,thumbtack,ticket-alt,times,times-circle,tint,toggle-off,toggle-on,trademark,train,transgender,transgender-alt,trash,trash-alt,tree,trophy,truck,tty,tv,umbrella,underline,undo,undo-alt,universal-access,university,unlink,unlock,unlock-alt,upload,user,user-circle,user-md,user-plus,user-secret,user-times,users,utensil-spoon,utensils,venus,venus-double,venus-mars,video,volleyball-ball,volume-down,volume-off,volume-up,wheelchair,wifi,window-close,window-maximize,window-minimize,window-restore,won-sign,wrench,yen-sign';
				var regular = 'address-book,address-card,arrow-alt-circle-down,arrow-alt-circle-left,arrow-alt-circle-right,arrow-alt-circle-up,bell,bell-slash,bookmark,building,calendar,calendar-alt,calendar-check,calendar-minus,calendar-plus,calendar-times,caret-square-down,caret-square-left,caret-square-right,caret-square-up,chart-bar,check-circle,check-square,circle,clipboard,clock,clone,closed-captioning,comment,comment-alt,comments,compass,copy,copyright,credit-card,dot-circle,edit,envelope,envelope-open,eye-slash,file,file-alt,file-archive,file-audio,file-code,file-excel,file-image,file-pdf,file-powerpoint,file-video,file-word,flag,folder,folder-open,frown,futbol,gem,hand-lizard,hand-paper,hand-peace,hand-point-down,hand-point-left,hand-point-right,hand-point-up,hand-pointer,hand-rock,hand-scissors,hand-spock,handshake,hdd,heart,hospital,hourglass,id-badge,id-card,image,images,keyboard,lemon,life-ring,lightbulb,list-alt,map,meh,minus-square,money-bill-alt,moon,newspaper,object-group,object-ungroup,paper-plane,pause-circle,play-circle,plus-square,question-circle,registered,save,share-square,smile,snowflake,square,star,star-half,sticky-note,stop-circle,sun,thumbs-down,thumbs-up,times-circle,trash-alt,user,user-circle,window-close,window-maximize,window-minimize,window-restore';
				var brands = '500px,accessible-icon,accusoft,adn,adversal,affiliatetheme,algolia,amazon,amazon-pay,amilia,android,angellist,angrycreative,angular,app-store,app-store-ios,apper,apple,apple-pay,asymmetrik,audible,autoprefixer,avianex,aviato,aws,bandcamp,behance,behance-square,bimobject,bitbucket,bitcoin,bity,black-tie,blackberry,blogger,blogger-b,bluetooth,bluetooth-b,btc,buromobelexperte,buysellads,cc-amazon-pay,cc-amex,cc-apple-pay,cc-diners-club,cc-discover,cc-jcb,cc-mastercard,cc-paypal,cc-stripe,cc-visa,centercode,chrome,cloudscale,cloudsmith,cloudversify,codepen,codiepie,connectdevelop,contao,cpanel,creative-commons,css3,css3-alt,cuttlefish,d-and-d,dashcube,delicious,deploydog,deskpro,deviantart,digg,digital-ocean,discord,discourse,dochub,docker,draft2digital,dribbble,dribbble-square,dropbox,drupal,dyalog,earlybirds,edge,elementor,ember,empire,envira,erlang,ethereum,etsy,expeditedssl,facebook,facebook-f,facebook-messenger,facebook-square,firefox,first-order,firstdraft,flickr,flipboard,fly,font-awesome,font-awesome-alt,font-awesome-flag,fonticons,fonticons-fi,fort-awesome,fort-awesome-alt,forumbee,foursquare,free-code-camp,freebsd,get-pocket,gg,gg-circle,git,git-square,github,github-alt,github-square,gitkraken,gitlab,gitter,glide,glide-g,gofore,goodreads,goodreads-g,google,google-drive,google-play,google-plus,google-plus-g,google-plus-square,google-wallet,gratipay,grav,gripfire,grunt,gulp,hacker-news,hacker-news-square,hips,hire-a-helper,hooli,hotjar,houzz,html5,hubspot,imdb,instagram,internet-explorer,ioxhost,itunes,itunes-note,jenkins,joget,joomla,js,js-square,jsfiddle,keycdn,kickstarter,kickstarter-k,korvue,laravel,lastfm,lastfm-square,leanpub,less,line,linkedin,linkedin-in,linode,linux,lyft,magento,maxcdn,medapps,medium,medium-m,medrt,meetup,microsoft,mix,mixcloud,mizuni,modx,monero,napster,nintendo-switch,node,node-js,npm,ns8,nutritionix,odnoklassniki,odnoklassniki-square,opencart,openid,opera,optin-monster,osi,page4,pagelines,palfed,patreon,paypal,periscope,phabricator,phoenix-framework,php,pied-piper,pied-piper-alt,pied-piper-pp,pinterest,pinterest-p,pinterest-square,playstation,product-hunt,pushed,python,qq,quinscape,quora,ravelry,react,rebel,red-river,reddit,reddit-alien,reddit-square,rendact,renren,replyd,resolving,rocketchat,rockrms,safari,sass,schlix,scribd,searchengin,sellcast,sellsy,servicestack,shirtsinbulk,simplybuilt,sistrix,skyatlas,skype,slack,slack-hash,slideshare,snapchat,snapchat-ghost,snapchat-square,soundcloud,speakap,spotify,stack-exchange,stack-overflow,staylinked,steam,steam-square,steam-symbol,sticker-mule,strava,stripe,stripe-s,studiovinari,stumbleupon,stumbleupon-circle,superpowers,supple,telegram,telegram-plane,tencent-weibo,themeisle,trello,tripadvisor,tumblr,tumblr-square,twitch,twitter,twitter-square,typo3,uber,uikit,uniregistry,untappd,usb,ussunnah,vaadin,viacoin,viadeo,viadeo-square,viber,vimeo,vimeo-square,vimeo-v,vine,vk,vnv,vuejs,weibo,weixin,whatsapp,whatsapp-square,whmcs,wikipedia-w,windows,wordpress,wordpress-simple,wpbeginner,wpexplorer,wpforms,xbox,xing,xing-square,y-combinator,yahoo,yandex,yandex-international,yelp,yoast,youtube,youtube-square';
		
			    var arraySol = solid.split(',');
			    var arrayReg = regular.split(',');
			    var arrayBra = brands.split(',');
			    
				for (i=0;i<arraySol.length;i++){
				     //console.log(arraySol[i]);         
				     uiFaw += $( '<div><li title="' + arraySol[i] + '"><i class="fas fa-' + arraySol[i] + '"><!--' + arraySol[i] + '--></i></li></div>' ).html();
				}    
			
				for (i=0;i<arrayReg.length;i++){
				     //console.log(arrayReg[i]);         
				     uiFaw += $( '<div><li title="' + arrayReg[i] + '"><i class="far fa-' + arrayReg[i] + '"><!--' + arrayReg[i] + '--></i></li></div>' ).html();
				}    
			
				for (i=0;i<arrayBra.length;i++){
				     //console.log(arrayBra[i]);         
				     uiFaw += $( '<div><li title="' + arrayBra[i] + '"><i class="fab fa-' + arrayBra[i] + '"><!--' + arrayBra[i] + '--></i></li></div>' ).html();
				}    
				uiFaw = uiCss + '<p id="icoDesc"></p><ul>'+ uiFaw +'</ul>'; 
				
// fin mi html previo            	

                editor.windowManager.open({
                	
                    title: editor.getLang('ekiline_tinymce.addfaw'),
                    // minWidth: 420,
                    // maxWidth: 840,
                    // minHeight: 400,
                    // maxHeight: 700,
                    width: 900,
                    height: 420,
				    autoScroll: true,
				    classes: 'fontawesome-panel',

                    body: [
						{
                        	type	: 'textbox',
                        	subtype	: 'hidden',
                        	name	: 'icon',
                        	id		: 'iconVal',
                        	value	: ''
                    	},
                    	//los iconos
		                {
		                    type	: 'container',
		                    name	: 'catalog',
		                    id		: 'iconCat',
		                    html	: uiFaw
		                },
                	],
                    	
                    onsubmit: function (e) {
                        editor.insertContent( '&nbsp;'+ e.data.icon+ '&nbsp;' );
                    },
                    
                }); //editor.windowManager.open
                
// cargado el contenido crea el contenido.
              
				$('ul li').on('click',function(e) {
			    	e.preventDefault(); //prevenir el click discriminado.
			    	$(this).css({'background' : '#0085ba','color' : '#FFFFFF','border-radius' : '2px','box-shadow' : '0px 2px 0px #006799'}).siblings().css({'background' : '','color' : '','border-radius' : '','box-shadow' : ''});
			    	
			    	//varibles:
			    	// mostrar el nombre del icono
		        	var icoNam = $(this).attr('title');
        			var nameSel = $('#icoDesc');
                        nameSel.html( icoNam );	                        		                 					                        		

			    	// valor para tinymce
		        	var show = $(this).html();
        			var icoSel = $('#iconVal');
                        icoSel.val( show );	                        		                 					                        		
				});   				

// fin de cargado el contenido                 
                
            }
        });
    });
} )( jQuery );
