/* 
	Main scripting file
*/

var style = '';
var airkit_FancyBoxEnabled = false,
	infinite_loading = false,
	map, mapAddress, latlng, mapLat, mapLng, mapType, mapStyle, mapZoom,
	mapTypeCtrl, mapZoomCtrl, mapScaleCtrl, mapScroll, mapDraggable, mapMarker;

// Get all localized variables
var airkit_main_color = gowatch.main_color,
	airkit_images_loaded_active = gowatch.ts_enable_imagesloaded,
	airkit_logo_content = gowatch.airkit_logo_content,
	airkit_site_width = gowatch.airkit_site_width,
	airkit_facebook_id = gowatch.airkit_facebook_id,
	airkit_prevent_blocker = gowatch.prevent_adblock,
	airkit_blocker_html = gowatch.airkit_blocker_html,
	airkit_back_text = gowatch.back_text,
	airkit_close_results_text = gowatch.close_results_text,
	airkit_show_less = gowatch.show_less,
	airkit_show_more = gowatch.show_more;

(function ($, window, _) {

	"use strict"

	var win = $(window),
		$doc = $(document),
		$body = $('body');

	var AIRKIT = {
		init: function() {
			var self = this,
				obj;

			for (obj in self) {
				if ( self.hasOwnProperty(obj) ) {
					var _method = self[obj];

					if ( _method.selector !== undefined && _method.init !== undefined ) {
						if ( $(_method.selector).length > 0 ) {
							_method.init();
						}
					}
				}
			}
		},
		_CurrentReading: '', // Global
		documentFire: {
			selector: 'body',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				$('.single .post-rating .rating-items > li').each(function(){
					var bar_width = $(this).find('.bar-progress').data('bar-size');

					$(this).find('.bar-progress').css({width: bar_width+'%'});
				});

				$('.airkit_slider .slides > li:first-child').css('display','inline-block');

				$('.single').find('.post-details-row').first().addClass('current-reading');

				var post_ID = $('.single').find('.current-reading .single-article').attr('data-post-id');

				AIRKIT._CurrentReading = '[data-post-id="' + post_ID + '"]';
			}
		},
		eventHandler: {
			selector: 'body',
			init: function() {
				var self = this;
		
				self.click();
				self.rightClick();
				self.focus();
				self.blur();
			},
			click: function(){
				$doc.on('click', '*[data-toggle="popover"]', function(e){
					e.preventDefault();
					var data_placement = $(this).attr('data-placement');

					$(this).next('.popover').addClass(data_placement);
					$(this).next('.popover').toggleClass('in');
				});

			   	$doc.on('click', '.airkit_alert', function(){
			   		$(this).fadeOut(300);
			   		$(this).remove();
			   	});

			   	// Open cart element on click
				$doc.on('click', '.gbtr_dynamic_shopping_bag .overview', function(){
					$(this).closest('.gbtr_dynamic_shopping_bag').find('.gbtr_minicart_wrapper').toggleClass('visible');
				});

				$doc.on('click', '.gbtr_dynamic_shopping_bag .ts-cart-close', function(){
					$(this).closest('.gbtr_dynamic_shopping_bag').find('.gbtr_minicart_wrapper').toggleClass('visible');
				});

				$doc.on('click', '.ts-toggle-box .toggle-heading', function(){
					$(this).next().slideToggle('fast');
					$(this).parent().toggleClass('closed');;
				});

				$doc.on('click', '.ts-get-calendar', function(){
					var tsYear  = $(this).attr('data-year');
					var tsMonth = $(this).attr('data-month');
					var classSize = 'ts-big-calendar';

					if ( $(this).parent().find('.ts-events-calendar').hasClass('ts-small-calendar') ) {
						classSize = 'ts-small-calendar';
					}

					var tsCalendar = $(this).parent();
					var data = {};

					data = {
						action  : 'ts_draw_calendar',
						nonce   : gowatch.ts_security,
						tsYear  : tsYear,
						tsMonth : tsMonth,
						size    : classSize
					};

					$.post(gowatch.ajaxurl, data, function(response) {

						if( response ) {
							$(tsCalendar).html(response);
						}
					});

					return false;
				});

				$('.widget.ts_widget.widget_popular .nav-tabs li a, .widget.ts_widget.widget_tabber .nav-tabs li a, ul.nav-tabs li a').click(function(event) {
					event.preventDefault();

					var $$ = $(this),
						target =  $$.parent().index()+1;

						$$.closest('.ts-tab-container').find('li').removeClass('active');
						$$.closest('.ts-tab-container').find('.tab-content .tab-pane').removeClass('active');
						$$.parent('li').addClass('active');
						$$.parent().parent().next().find('div.tab-pane:nth-child('+target+')').addClass('active');

				});

				$doc.on('click', '.carousel-nav-show-thumbnails', function(){
					var this_id = $(this).parents('.airkit_post-gallery').attr('id');

					$('#'+this_id).find(this).toggleClass('active');
					$('#'+this_id).find('.gallery-nav-thumbnails').toggleClass('shown');

					return false;
				});

				// Toggle dropdown menu for user element
				$('.user-element > .user-image').on('click', function(e){
					e.preventDefault();
					e.stopPropagation();

					$(this).parents('.user-element').find('.user-dropdown').toggleClass('active');

					return false;
				});

				// Stop propagation when is click inside dropdown menu
				$('.user-element .user-dropdown').on('click', function(e){
					e.stopPropagation();
				});

				// Click outside close drodown menu
				$doc.click(function(e) {
					$('.user-element').find('.user-dropdown').removeClass('active');
				});

				$doc.on('click', '.btn-close-thumbnails', function(){
					$(this).parent().removeClass('shown');
					$(this).parent().parent().find('.carousel-nav-show-thumbnails').removeClass('active');
				});

				$doc.on('click', '[data-button-action="send-email"]', function(e){
					e.preventDefault();

					var subject = $(this).attr('data-subject'),
						post_title = $(this).attr('data-title'),
						post_link = $(this).attr('data-permalink'),
						link = 'mailto:?subject='+ subject +'&body='+ post_title + '%0D%0A'+ post_link;

					window.location.href = link;
				});

				$doc.on('click', '.single .featured-image .post-rating-circular', function(){
					$('html, body').animate({
				        scrollTop: $('[id^="post-rating"]').offset().top - 200
				    }, 800);
				})
			},
			rightClick: function() {
				if( gowatch.rightClick == 'y' ){
					$doc.on('contextmenu', function(e){
						return false;
					});
				}
			},
			focus: function() {
				$('.ts_widget #searchform input[type="text"]').focus(function() {
					$(this).closest('div').addClass('no-icon');
				});
			},
			blur: function() {
				$('.ts_widget #searchform input[type="text"]').blur(function() {

					if( $(this).val() === '' ) {
						$(this).closest('div').removeClass('no-icon');
					}
					
				});
			}
		},
		setLike: {
			selector: '.touchsize-likes',
			init: function() {
				var self = this,
					container = $(self.selector);

				$doc.on('click', self.selector, function() {

					var $$ = $(this), link, id, postfix;

					link = $$;
					if(link.hasClass('active')) return false;

					id = $$.attr('data-id'),
					postfix = link.find('.touchsize-likes-postfix').text();

					$.post(gowatch.ajaxurl, { action:'touchsize-likes', likes_id:id, postfix:postfix }, function(data){
						link.addClass('active');
						link.html(data).attr('title','You already like this');
					});

					return false;
				});
			}
		},
		setVideoAdStats: {
			init: function(update, key) {
				var self = this,
					container = $(self.selector);

				var such    = jQuery(container),
					adEvent = update;

				if ( typeof key == undefined ) {
					key = 0;
				}

				jQuery.post(gowatch.ajaxurl, {
					    'action'   : 'gowatch_setDataAd',
					    'nonce'    : gowatch.ts_security,
					    'key'      : key,
					    'event'    : adEvent
					}, 	function(data){

						}
				);
			}
		},
		addToFavorite: {
			selector: '.airkit_add-to-favorite',
			init: function() {
				var self = this,
					container = $(self.selector);

				container.find('.btn-add-to-favorite:not(.user-not-logged-in)').each(function(){

					$(this).on('click', function(e) {

						e.preventDefault();

						var $$ = $(this);
						var post_id = $$.attr('data-post-id');
						var nonce = $$.attr('data-ajax-nonce');

						$.post(gowatch.ajaxurl, {

							action: 'airkit_add_to_favorite',
							post_id: post_id,
							security: nonce

						}, function(data) {

							if ( data.response == '-1' ) return false;

							var $alert = '<div class="airkit_alert fixed-top-right alert-'+ data.alert +' alert-dismissible" role="alert"><button type="button" class="close"><span aria-hidden="true">&times</span></button><p>'+ data.message +'</p></div>';

							$body.find('.airkit_alert').remove();

							$($alert).appendTo('body');

							setTimeout(function(){
								$('.alert-'+ data.alert +'').addClass('in');
							}, 100);

							if ( data.response == '1' ) {

								$$.addClass('active');

							} else if ( data.response == '0' ) {

								$$.removeClass('active');

							}

							$$.find('.entry-meta-description').text(data.label);

							if ( data.icon == 'icon-big-heart' ) {
								$$.find('.entry-meta-description').fadeOut(250);
							}

							$$.attr('title', data.label);
							$$.find('.btn-icon-wrap').html('<i class="'+data.icon+'"></i>');

							setTimeout(function(){
								$('.alert-'+ data.alert +'').fadeOut(function(){
									$(this).remove();
								});
							}, 3500);

						});

					});

				})
			}
		},
		deleteVideo: {
			selector: '.delete-video',
			init: function() {
				var self = this,
					container = $(self.selector);

					container.on('click', function(e) {

						if (!confirm('Are you sure you want to delete this?')) {
						    return false;
						}

						e.preventDefault();

						var $$ = $(this),
						 	post_id = $$.attr('data-post-id'),
							nonce = $$.attr('data-ajax-nonce');

						$.post(gowatch.ajaxurl, {

							action: 'airkit_remove_post',
							post_id: post_id,
							security: nonce

						}, function(data) {

							if ( data.response == '-1' ) return false;

							var $alert = '<div class="airkit_alert fixed-top-right alert-'+ data.alert +' alert-dismissible" role="alert"><button type="button" class="close"><span aria-hidden="true">&times</span></button><p>'+ data.message +'</p></div>';

							$body.find('.airkit_alert').remove();

							$($alert).appendTo('body');

							setTimeout(function(){
								$('.alert-'+ data.alert +'').addClass('in');
							}, 100);

							setTimeout(function(){
								$('.alert-'+ data.alert +'').fadeOut(function(){
									$(this).remove();
								});
							}, 3500);

							jQuery('.airkit_alert').append(data);

							// Redirect the client if delete was successful
							setTimeout(function(){

								if ( data['redirect'] != '' ) {
									window.location.href = data['redirect'];
								}

							},1500);

						});

					});
			}
		},
		reportVideo: {
			selector: '.report-video',
			init: function() {
				var self = this,
					container = $(self.selector);

					container.on('click', function(e) {

						e.preventDefault();

						var $$ = $(this);
						var post_id = $$.attr('data-post-id');
						var nonce = $$.attr('data-ajax-nonce'),
							type = 'report';

						if ( $$.hasClass('validate') ) {
							type = 'validate';
						}

						$.post(gowatch.ajaxurl, {

							action: 'airkit_report_video',
							post_id: post_id,
							type: type,
							security: nonce

						}, function(data) {

							if ( data.response == '-1' ) return false;

							var $alert = '<div class="airkit_alert fixed-top-right alert-'+ data.alert +' alert-dismissible" role="alert"><button type="button" class="close"><span aria-hidden="true">&times</span></button><p>'+ data.message +'</p></div>';

							$body.find('.airkit_alert').remove();

							$($alert).appendTo('body');

							setTimeout(function(){
								$('.alert-'+ data.alert +'').addClass('in');
							}, 100);

							setTimeout(function(){
								$('.alert-'+ data.alert +'').fadeOut(function(){
									$(this).remove();
								});
							}, 3500);

							if ( $$.hasClass('validate') ) {
								jQuery($$).html('VIDEO WAS APPROVED').removeClass('report-video');
							} else {
								jQuery($$).html('VIDEO WAS REPORTED').removeClass('report-video');
							}

						});

					});
			}
		},
		addToPlaylist: {
			selector: '.airkit_add-to-playlist, .playlist-view',
			data: {
				post_id: '',
				security: '',
			},
			init: function() {
				var self = this,
					container = $(self.selector);

				self.data['post_id'] = container.find('.btn-add-to-playlist').attr('data-post-id');
				self.data['security'] = container.find('.btn-add-to-playlist').attr('data-ajax-nonce');

				// Add post to playlist
				$doc.on('click', '#add-to-playlist-modal .modal-body ul li', function(e) {
					self.callback_response(gowatch.please_wait);
					self.add_to_playlist( $(this) );

					e.stopPropagation();
					return false;
				});

				// Insert form to create playlist
				$doc.on('click', '#airkit-create-playlist', function(e){
					$(this).hide();
					$(this).next('#create-playlist-form').removeClass('hidden');

					e.stopPropagation();
					e.preventDefault();
					return false;
				});

				// Create playlists
				$doc.on('click', '#create-playlist-button', function(e){
					$(this).prop('disabled', true);
					self.callback_response(gowatch.please_wait);
					self.create_playlist();

					e.stopPropagation();
					return false;
				});

				// Remove playlist
				$('.playlist-remove').on('click', function(){
					var playlist_id = $(this).attr('data-playlist-id');
					var security_nonce = $(this).attr('data-ajax-nonce');

					self.data['post_id'] = playlist_id;
					self.data['security'] = security_nonce;

					if ( confirm(gowatch.confirm_remove) ) {
						self.remove_playlist(playlist_id);
				    }
				});
			},
			create_playlist: function() {
				var self = this;
				var playlist_title = $('#create-playlist-form').find('[name="playlist_title"]').val();

				$.post(gowatch.ajaxurl, {

					action: 'airkit_create_playlist',
					playlist_title: playlist_title,
					security: self.data['security']

				}, function(data) {

					self.callback_response(data.message);

					if ( data.status == 'ok' ) {
						// Check if we have list inside modal body
						if ( $('.add-to-playlist-modal').find('.modal-body').has('ul').length ) {
							$('.add-to-playlist-modal').find('.modal-body ul').prepend('<li><label><input type="radio" name="playlist_item" value="'+data.playlist_id+'"><i class="icon-empty"></i> '+data.playlist_title+'</label></li>');
						} else {
							$('.add-to-playlist-modal').find('.modal-body').html('<ul><li><label><input type="radio" name="playlist_item" value="'+data.playlist_id+'"><i class="icon-list-add"></i> '+data.playlist_title+'</label></li></ul>');
						}
					}

					$('#create-playlist-form').find('input').val('');
					$('#create-playlist-button').prop('disabled', false);
				});
			},
			add_to_playlist: function(clicked_elem) {

				var self = this;
				var val = clicked_elem.find('input[name="playlist_item"]').val();

				$.post(gowatch.ajaxurl, {

					action: 'airkit_add_to_playlist',
					post_id: self.data['post_id'],
					security: self.data['security'],
					playlist_id: val

				}, function(data) {

					self.callback_response(data.message);

					if ( data.status == 'ok' ) {
						clicked_elem.addClass('active');
						clicked_elem.find('i[class^="icon"]').removeClass('icon-square-outline').addClass('icon-tick');
					} else if ( data.status == 'remove' ) {
						clicked_elem.removeClass('active');
						clicked_elem.find('i[class^="icon"]').removeClass('icon-tick').addClass('icon-square-outline');
					}
				});
			},
			actions: function(element) {
				var self = this;
				var playlist_id = $(element).attr('data-playlist-id');
				var repeat = $(element).attr('data-action-repeat');
				var shuffle = $(element).attr('data-action-shuffle');
				var data = {
					action: 'airkit_playlist_actions',
					security: self.data['security'],
					playlist_id: playlist_id,
				};

				// We click to repeat button
				if ( typeof repeat !== 'undefined' ) {
					data['action_name'] = 'repeat';
					data['repeat'] = repeat;
				}

				// We click to shuffle button
				if ( typeof shuffle !== 'undefined' ) {
					data['action_name'] = 'shuffle';
					data['shuffle'] = shuffle;
				}

				$.post(gowatch.ajaxurl, data, function(data) {

					var actions = data.actions;

					if ( data.status == 'ok' ) {

						if ( data.action_name == 'repeat' ) {
							// Add/Remove class active
							if ( actions['repeat'] == 'true' ) {
								$(element).addClass('active');
							} else {
								$(element).removeClass('active');
							}

							// Update data attribute value
							$(element).attr('data-action-repeat', actions['repeat']);
						}
						else if ( data.action_name == 'shuffle' ) {
							// Add/Remove class active
							if ( actions['shuffle'] == 'true' ) {
								$(element).addClass('active');
							} else {
								$(element).removeClass('active');
							}

							// Update data attribute value
							$(element).attr('data-action-shuffle', actions['shuffle']);
						}
					}
				});
			},
			remove_playlist: function(playlist_id) {
				var self = this;

				$.post(gowatch.ajaxurl, {

					action: 'airkit_playlist_actions',
					security: self.data['security'],
					playlist_id: playlist_id,
					action_name: 'remove',

				}, function(data) {
					var url = window.location.href;

					if ( data.status == 'ok' ) {
						window.location = url;
					}
				});
			},
			callback_response: function(text) {
				$('.add-to-playlist-modal.in').find('span[aria-response]').html(text);
			}
		},
		playlistPanel: {
			selector: '.playlist-panel',
			init: function() {
				var self = this,
					container = $(self.selector),
					carousel = container.find('.playlist-panel-carousel');

				carousel.slick({
					arrows: true,
			        infinite: false,
			        draggable: true,
			        dots: false,
    				slidesToShow: 4,
				 	slidesToScroll: 4,
					prevArrow: container.find('.carousel-nav .carousel-nav-left'),
					nextArrow: container.find('.carousel-nav .carousel-nav-right'),
					// the magic
					responsive: [{

						    breakpoint: 1024,
						    settings: {
						        slidesToShow: 3,
						        slidesToScroll: 3
						    }

					    }, {

					      	breakpoint: 768,
					      	settings: {
					        	slidesToShow: 2,
					        	slidesToScroll: 2
					      	}

					    }, {

					      	breakpoint: 480,
				      		settings: {
					      	  	slidesToShow: 1,
					      	  	slidesToScroll: 1
					      	}

					    }
					]
				});

				// Go to active playlist item
				var currentIndex = carousel.find('.playlist-item.active').attr('data-slick-index');

				carousel.slick('slickGoTo', parseInt(currentIndex));

			    // Playlist repeat
			    container.find('.playlist-repeat, .playlist-shuffle').on('click', function(){
			    	AIRKIT.addToPlaylist.actions(this);
			    });
			}
		},
		stickyVideo: {
			selector: '.current-reading .gowatch-video-player.should-stick',
			init: function() {
				var self = this,
					container = $(self.selector);

					jQuery('.sticky-video-closer').on('click', function(){
						jQuery('.video-is-sticky.should-stick').removeClass('video-is-sticky should-stick');

						// Add back the default sizes
						jQuery('.gowatch-video-player > div').width( jQuery('.gowatch-video-player').width() );
						jQuery('.gowatch-video-player > div').height( jQuery('.gowatch-video-player').width() / (jQuery('.gowatch-video-player').width()/jQuery('.gowatch-video-player').height()) );
					});

					_listenerEvent('scroll', self, '_onScroll', [container]);

			},
			_onScroll: function(container) {

				if ( jQuery(window).width() > 768 ) {

					if ( !$(container).hasClass( 'should-stick' ) ) return;

					var topOffset = $(container).offset().top + $(container).outerHeight();

					var defaultSizeWidth = jQuery(container).children('div').width(),
					defaultSizeHeight = jQuery(container).children('div').height(),
					defaultSizeProportions = defaultSizeWidth / defaultSizeHeight,
					articleMargin = jQuery('.current-reading').offset().top + jQuery('.current-reading').outerHeight();


					if ( topOffset < $(window).scrollTop() && !$(container).hasClass( 'video-is-sticky' ) && $(window).scrollTop() < articleMargin ) {
						$(container).addClass( 'video-is-sticky' );

						jQuery(container.selector).width( defaultSizeWidth );
						jQuery(container.selector).height( defaultSizeHeight );
						
						jQuery(container.selector + ' > div').width( 350 );
						jQuery(container.selector + ' > div').height( 350 / defaultSizeProportions );

						// Check the top value
						if( jQuery('#header > div.airkit_header-style2').length > 0 || jQuery('#header > div.airkit_header-style4').length > 0 ) {
							jQuery('.gowatch-video-player > div').css('top', jQuery('#header div[class^="airkit_header"]').outerHeight());
						}

					} else if ( topOffset > $(window).scrollTop() && $(container).hasClass( 'video-is-sticky' ) ) {
						$(container).removeClass( 'video-is-sticky' );
						
						jQuery(container.selector + ' > div').width( jQuery(container.selector).width() );
						jQuery(container.selector + ' > div').height( jQuery(container.selector).width() / defaultSizeProportions );

						// Check the top value
						if( jQuery('#header > div.airkit_header-style2').length > 0 || jQuery('#header > div.airkit_header-style4').length > 0 ) {
							jQuery('.gowatch-video-player div').css('top', 0);
						}
					}

				}
			},
			_onStick: function(container) {

			},
			_onDeStick: function(container) {

			}

		},
		addViews: {
			selector: 'body',
			init: function() {
				var post_ID = gowatch.post_ID;
				if ( post_ID == '' ) return;
				setTimeout(function(){
					$.post(gowatch.ajaxurl, { action:'airkit_set_post_views', post_ID: post_ID }, function(data){
					});
				}, 1000)

			}
		},
		embedAndLink: {
			selector: '.popover-content-footer a',
			init: function() {

				var self = this,
					container = $(self.selector);

				jQuery( container ).click(function(){

					var targetDiv = jQuery(this).attr('data-action');

					jQuery('.' + targetDiv).removeClass('hidden').siblings('.embed-content').addClass('hidden');
					return false;
				});
			}
		},
		lazyLoad: {
			selector: '.lazy:not(.lazyloaded)',
			init: function() {
				var self = this,
					container = $(self.selector);

				if( ! $('.lazy').length || airkit_images_loaded_active == 'n' ) return;

				container.lazyload({
					threshold : 100,
					effect : "fadeIn",
					effect_speed: 500,
					skip_invisible: true,
					ignore: $('.airkit_menu-articles'),
				});
			},
			control: function(container, next) {
				next = next || false;

				if( ! container.find('.lazy').length || airkit_images_loaded_active == 'n' ) return;

				container.find(".lazy:not(.lazyloaded)").lazyload({
					threshold : 100,
					effect : "fadeIn",
					effect_speed: 500,
					skip_invisible: true,
				});

				// Load image for next selector
				if ( next ) {
					AIRKIT.lazyLoad.control(container);
				}
			}
		},
		equalHeightColumns: {
			selector: '.site-section[class*="airkit_vertical-"]',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				if( ! container.length > 0 ) {
					return;
				}
				container.each(function() {
					var $$ = $(this),
						target;
					var maxH = 0;

					//column selector depends on row type
					if( $$.hasClass('airkit_expanded-row') ) {

						target = '> .row > div';

					} else {

						target = '> .container > .row > div';

					}

					//find the columns
					$$.find(target).each(function(){

						var $column = $(this);
						//get the height of biggest column
						if( $column.find('> div').height() > maxH ) {

							maxH = $column.find('> div').outerHeight();

						} 

					});

					/* Vertical alignment */
					$$.find(target).each(function(){

						var $column = $(this),
							padding = 0,
							style = {};

						if( $$.hasClass('airkit_vertical-middle') ){

							padding = ( maxH - $column.find('> div').innerHeight() ) / 2;

							style = {
								'padding-top': padding,
								'padding-bottom': padding,					
							}

						} else if( $$.hasClass('airkit_vertical-top') && $$.hasClass('airkit_equal-height') ) {

							style = {
								'height': maxH,
							}

						} else if( $$.hasClass('airkit_vertical-bottom') ) {

							padding = maxH - $column.find('> div').innerHeight() ;

							style = {
								'padding-top': padding,					
							}

						}

						$column.css( style );

					});		
				});

			}
		},
		ajaxLoadMore: {
			selector: '.ts-pagination-more',
			init: function() {
				var self = this,
					container = $(self.selector);


				container.on('click', function(){
					self.control($(this));
				});
			},
			control: function(element) {
				var loop            = parseInt( element.attr('data-loop') );
				var args            = element.attr('data-args');
				var paginationNonce = element.find('input[type="hidden"]').val();
				var loadmoreButton  = element;
				var $container_wrap = element.prev();

				if( $container_wrap.is('div[class*="airkit_styling-"]') ){
					$container_wrap = $container_wrap.find('> div');
				}

				// Show preloader
				if( loadmoreButton.hasClass('ts-infinite-scroll') ) {
					$('#airkit_loading-preload').addClass('shown');
				}

				element.addClass('loading');

				loadmoreButton.attr('data-loop', loop + 1);

				$.post(gowatch.ajaxurl, {
						action         : 'ts_pagination',
						args           : args,
						paginationNonce: paginationNonce,
						loop           : loop

					},  function(data){

						if( data !== '0' ){

							if( $container_wrap.hasClass('ts-masonry-container') ){

								var data_content = $(data).appendTo($container_wrap);

								$container_wrap.isotope('appended', $(data_content));

								setTimeout(function(){
									$container_wrap.isotope('layout');
									AIRKIT.lazyLoad.control( $container_wrap );
								},1200);

							} else {

								setTimeout(function(){
									$(data).css('opacity', 0).appendTo($container_wrap).css('opacity', 1);
									AIRKIT.lazyLoad.control( $container_wrap );
								}, 1000);

							}


						} else { 

							loadmoreButton.remove();

						}

						// Hide the preloader
						setTimeout(function(){
							if( loadmoreButton.hasClass('ts-infinite-scroll') ) {
								$('#airkit_loading-preload').removeClass('shown');
							}

							element.addClass('loading-out');
						},800);

						setTimeout(function(){
							element.removeClass('loading-out loading');
						}, 1500)

					}
				);
			}
		},
		ajaxLoadNextPost: {
			selector: '.airkit_autoload-next-post .airkit_single-main',
			org_post_url: window.location.href,
			org_post_title: document.title,
			processing: false,
			init: function(){
				var self = this,
					container = $( self.selector );

				$doc.on('scroll', function(){
					self.location_change();
				});

				_listenerEvent('resize', self, '_onScroll', [container]);
				_listenerEvent('scroll', self, '_onScroll', [container]);

			},
			_onScroll: function( container ){
				//check if scrolled to the bottom of the article
				var self = this;

				if ( container.find('.airkit_singular').length <= 0 ) {
					return false;
				}

				var post = container.find('.airkit_singular').last(),
					term_id = container.find('.airkit_singular').first().attr('data-category-id'),
					scrollHeight = post.offset().top + post.outerHeight() - win.innerHeight();
					// Value that should be scrolled before next article starts loading

				if( !post.hasClass('next-loaded') ) {
					var scrollTop = win.scrollTop();
					var loadNextNonce = post.attr('data-nonce'),
						postId = post.attr('data-id'),
						tempId = postId;

					if( ( scrollTop >= scrollHeight ) && self.processing === false ) {

						// Prevent unwanted ajax calls on further scrollig
						if( postId == tempId ) {
							// show preloader
							$('#airkit_loading-preload').addClass('shown');

							$.ajax(gowatch.ajaxurl, {
								method: 'POST',
								data: {
									action: 'airkit_load_next_post',
									loadNextNonce: loadNextNonce,
									post_id: postId,
									term_id: term_id
								},
								beforeSend: function(){
									postId = null;
									self.processing = true;
								},
								success: function( response ){

									post.addClass('next-loaded');

									var $data = $(response);

									tempId = $data.attr('data-id');
									postId = tempId;

									post.after( response );

									// Reinit Scripts
									self.reinitScripts($data);

									setTimeout(function(){
										self.processing = false;	
									}, 500);	

									$('#airkit_loading-preload').removeClass('shown');

									// Initialize video player if single video
									if ( jQuery('body').hasClass('single-video') ) {
										var newVideoContainer = '#videosingle-' + postId;
										airkit_startVideoPlayer( newVideoContainer );
									}

								},
							})
						}
					}
				}
			},
			location_change: function() {
				var self = this,
					container = $(self.selector);
					
				var windowTop           = win.scrollTop(),
					windowBottom        = windowTop + win.height(),
					windowSize          = windowBottom - windowTop,
					setsInView          = [],
					pageChangeThreshold = 0.5,
					post_title,
					post_url;
					
				$('.airkit_autoload-next-post .airkit_singular').each( function() {
					var post 			= $(this),
						id				= post.data( 'id' ),
						setTop			= post.offset().top,
						setHeight		= post.outerHeight(true),
						setBottom		= 0,
						tmp_post_url	= post.data('url'),
						tmp_post_title	= post.find('.post-title').text();
					
					// Determine position of bottom of set by adding its height to the scroll position of its top.
					setBottom = setTop + setHeight;
					
					if ( setTop < windowTop && setBottom > windowBottom ) { // top of set is above window, bottom is below
						setsInView.push({'id': id, 'top': setTop, 'bottom': setBottom, 'post_url': tmp_post_url, 'post_title': tmp_post_title, 'alength' : setHeight });
					}
					else if( setTop > windowTop && setTop < windowBottom ) { // top of set is between top (gt) and bottom (lt)
						setsInView.push({'id': id, 'top': setTop, 'bottom': setBottom, 'post_url': tmp_post_url, 'post_title': tmp_post_title, 'alength' : setHeight });
					}
					else if( setBottom > windowTop && setBottom < windowBottom ) { // bottom of set is between top (gt) and bottom (lt)
						setsInView.push({'id': id, 'top': setTop, 'bottom': setBottom, 'post_url': tmp_post_url, 'post_title': tmp_post_title, 'alength' : setHeight });
					}
				});
				
				// Parse number of sets found in view in an attempt to update the URL to match the set that comprises the majority of the window
				if ( 0 === setsInView.length ) {
					post_url = self.org_post_url;
					post_title = self.org_post_title;

				} else if ( 1 === setsInView.length ) {

					var setData = setsInView.pop();
					post_url = setData.post_url;
					post_title = setData.post_title;

					if ( !container.find('.airkit_singular[data-id="'+ setData.id +'"]').hasClass('current-reading') ) {

						AIRKIT._CurrentReading = '[data-post-id="' + setData.id + '"]';

						container.find('.airkit_singular.current-reading').removeClass('current-reading');
						container.find('.airkit_singular[data-id="'+ setData.id +'"]').addClass('current-reading');

						if ( container.find(AIRKIT.articleProgressBar.selector).length ) {
							AIRKIT.articleProgressBar.init();
						}
					}
					
				} else {

					post_url = setsInView[0].post_url;
					post_title = setsInView[0].post_title;

					if ( !container.find('.airkit_singular[data-id="'+ setsInView[0].id +'"]').hasClass('current-reading') ) {

						AIRKIT._CurrentReading = '[data-post-id="' + setsInView[0].id + '"]';

						container.find('.airkit_singular.current-reading').removeClass('current-reading');
						container.find('.airkit_singular[data-id="'+ setsInView[0].id +'"]').addClass('current-reading');

						if ( container.find(AIRKIT.articleProgressBar.selector).length ) {
							AIRKIT.articleProgressBar.init();
						}

					}
				}

				$(AIRKIT._CurrentReading).find('.sticky-post-meta').fixer({scroll: false});

				self.updateURL(post_url, post_title);
			},
			updateURL : function(post_url, post_title) {
				if( window.location.href !== post_url ) {
					if ( post_url !== '' ) {
						history.replaceState( null, null, post_url );
						document.title = post_title;
					}
				}
			},
			reinitScripts: function(container) {
				// Reinit Sticky sidebar
				if ( $('.sidebar-is-sticky, .sticky-sidebars-enabled').length ) {
					AIRKIT_EL.sidebar.init();
				}

				if ( container.find(AIRKIT.ParallaxScroll.selector).length ) {
					AIRKIT.ParallaxScroll.init();
				}
				
				if ( container.find(AIRKIT.resizeVideo.selector).length ) {
					AIRKIT.resizeVideo.init();
				}

				if( container.find(AIRKIT.carousel.selector).length ){
					AIRKIT.carousel.init();
				}

				if( container.find(AIRKIT.postGalleryCarousel.selector).length ){
					AIRKIT.postGalleryCarousel.init();
				}

				if( container.find(AIRKIT.tabItem.selector).length ) {
					AIRKIT.tabItem.init();
				}

				if( container.find(AIRKIT_EL.featAreaSlider.selector).length ) {
					AIRKIT_EL.featAreaSlider.init();
				}

				if ( container.find(AIRKIT_EL.gallery.selector).length ) {
					AIRKIT_EL.gallery.init();
				}

				AIRKIT.addToFavorite.init();
				AIRKIT.lazyLoad.init();
			}
		},
		contactForm: {
			selector: '.contact-form',
			init: function() {
				var self = this,
					container = $(self.selector);

				container.find('.contact-form-require').each(function(){
					$(this).prev('label').attr('data-label', 'required');
				});
		
				container.find('.contact-form-submit').on('click', function(event) {
					event.preventDefault();
					self.control( $(this) );
				});
			},
			control: function(element) {

				var form         = element.closest('form'),
					name         = form.find('.contact-form-name'),
					email        = form.find('.contact-form-email'),
					subject      = form.find('.contact-form-subject'),
					message      = form.find('.contact-form-text'),
					emailRegEx   = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
					errors       = 0,
					custom_field = form.find('.ts_contact_custom_field'),
					required     = form.find('.contact-form-require'),
					data         = {};

				if( email.length ){

					if ( emailRegEx.test(email.val()) ) {

						email.removeClass('invalid');

					} else {

						email.addClass('invalid');
						errors = errors + 1;

					}

				}

				$( required ).each(function(){

					var $this = $( this );

					if ( $this.val().trim() !== '') {

						$this.removeClass('invalid');

					} else {

						$this.addClass('invalid');
						errors = errors + 1;

					}

				});


				if ( errors === 0 ) {

					data['action']  = 'airkit_contact_me';
					data['token']   = gowatch.contact_form_token;
					data['name']    = (name.length) ? name.val().trim() : ''
					data['from']    = (email.length) ? email.val().trim() : ''
					data['subject'] = (subject.length) ? subject.val().trim() : '';
					data['message'] = (message.length) ? message.val().trim() : '';
					data['custom_field'] = new Array();

					$(custom_field).each(function(i,val){

						var title = $(this).next().val();
						var value = $(this).val();
						var require = $(this).next().next().val();
						var new_item = {value : value, title: title, require: require};
						data['custom_field'].push(new_item);

					});

					// Disable button while sending the message.
					element.prop('disabled', true).removeClass('error').addClass('loading');
					element.find('> *:not(span)').remove();

					$.post(gowatch.ajaxurl, data, function(data, textStatus, xhr) {

						form.find('.contact-form-messages').html('');
						element.find('> span').text('');

						// console.log( data );

						if ( data !== '-1' ) {
							if ( data.status === 'ok' ){

								element.removeClass('loading').addClass('success');
								element.find('> span').text('Done');
								element.append('<i class="icon-tick"></i>');
								form.find("input, textarea").not(".contact-form-submit").val('');
								form.addClass('sent');

							} else {

								element.removeClass('loading').addClass('error');
								element.find('> span').text('Check again');
								element.append('<i class="icon-cancel"></i>');

								// Remove disable button if has errors to keep user send again
								element.prop('disabled', false);

							}

							if ( typeof data.token !== "undefined" ) {

								gowatch.contact_form_error = data.token;
							}

						} else {

							form.addClass('hidden');
							form.find('.contact-form-messages').html(gowatch.contact_form_error);
							element.prop('disabled', false);

						}
					});

				} else {

					// Remove disable button if has errors to keep user send again
					element.prop('disabled', false).removeClass('loading');

				}
			}
		},
		setScrollContainerWidth: {
			selector: '.scroll-container',
			init: function() {
				var self = this,
					container = $(self.selector);

				self._onResize( container );

				_listenerEvent('resize', self, '_onResize', [container]);
			},
			_onResize: function(container) {
				container.each(function(){
					var $$ = $(this);

					// Get the width of the parent.

					var elementParent = $$.closest('.airkit_article-views'),
						$parent = $(elementParent);

					var parentWidth = $(elementParent).width();

					// Check if grid or thumb view
					if ( ( $parent.hasClass('grid-view') || $parent.hasClass('thumbnail-view') ) ) {

						// Set the width of the scroller.
						if ( $parent.hasClass('airkit_gutter-n') ) {

							$$.css('width', parentWidth);

						} else {

							if( win.width() > 1024 ) {

								$$.css('width', parentWidth + 39);

							} else {

								/* Calculate additional spacing taht needs to be added to scroll container */
								/*Additional spacing =  Nr of articles * gutter. Don't hardcote 40 gutter, as it could be different, depending on settings.*/
								var sumGutters = $$.find('article').length * ( $$.find('article').parent().outerWidth() - $$.find('article').parent().width() );

								var widthForMobile = $$.find('article').length * parentWidth + sumGutters;

								$$.css( 'width', widthForMobile );

							}

						}

					} else {

						var sitePadding = 30;

						if( $parent.hasClass('mosaic-no-gutter') ) {
							sitePadding = 40;
						}
						
						if( !$parent.hasClass('mosaic-style-4') ) {
							$$.css('width', airkit_site_width - sitePadding);
						} else {
							$$.css('width', airkit_site_width );
						}
					}

					/*
					 * Set width for mosaic with scroll.
					 */
					if ( $parent.hasClass('mosaic-scroll') && win.width() < 960 ) {

						$$.css('width', 800);

					}

				});
			}
		},
		filters: {
			selector: '.ts-masonry-container',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				if( container.is('[class*="airkit_styling-"]') ) {
					// Read properties from container to apply them to parent

					var className = '',
						bg_color = 'transparent',
						border = 'none';

					var gutter = container.css('padding'),
						margin = container.css('margin');

					if( container.hasClass('airkit_styling-bg-color') )  {

						className = 'airkit_styling-bg-color';
						bg_color = container.css('background-color');
					}

					if( container.hasClass('airkit_styling-border') )  {

						className = 'airkit_styling-border';
						border = container.css('border');

					}

					if( container.hasClass(className) ) {

						container.css({
							'padding': '0',
							'background-color': 'transparent',
							'border': 'none',
							'margin': '0',
						});
					}

					container.removeClass(className).wrap('<div class="' + className + '"></div>').parent().css({
						'border': border,
						'padding': gutter,
						'background-color': bg_color,
						'margin': margin,
					});
				}

				container.isotope({
					itemSelector : '.item',
				});

				_listenerEvent('resize', self, '_onResize', [container]);
			},
			_onResize: function(container) {
				container.isotope('layout');
			}
		},
		carousel: {
			selector: '.carousel-wrapper, .slider-is-row-bg',
			init: function() {
				var self = this,
					container = $(self.selector);

				container.each(function(){
					self.build( $(this) );
				});

				self._onResize(container);

				_listenerEvent('resize', self, '_onResize', [container, true]);
			},
			build: function(container) {

				var $carousel = container.find('.carousel-container, .row-bg-slides'),
					$wrapper = container;

				var settings = {
					arrows: true,
					dots: true,
					slidesToShow: 3, 
					slidesToScroll: 1,
					autoplay: false,
					infinite: false,
					adaptiveHeight: false,
				};

				/*
				 *	read data attributes 
				 *	update settings container
				 */ 
				settings.slidesToShow = parseInt( $carousel.attr('data-cols') ) || 1;

				// 1 slide to show
				if ( win.width() <= 768 ) {
					settings.slidesToShow = 1;
				}

				var navType = $wrapper.attr('data-nav-type') || 'arrows';
				
				if( navType === 'dots' ) {

					settings.arrows = false;
					settings.dots = true;

				} else if( navType === 'arrows' ) {

					settings.dots = false;

				} else if( navType === 'none' ) {

					settings.dots = false;
					settings.arrows = false;

				}

				if( $carousel.attr('data-scroll') === 'by-row' ) {
					// If should scroll entire row, set slidesToScroll equal to number of items per row 
					settings.slidesToScroll = settings.slidesToShow;

				}

				if( $carousel.attr('data-autoplay') === 'y' || $wrapper.attr('data-autoplay') === 'y' ) {
					/* Check if autoplay is set enabled */
					settings.autoplay = true;
					settings.infinite = true;

				}
				if( $carousel.attr('data-adaptive') === 'y' ) {
					/* Check if autoplay is set enabled */
					settings.adaptiveHeight = true;

				}
				if( $carousel.attr('data-infinite') === 'y' ) {
					settings.infinite = true;

				}

				/*
				 | Adaptive height for testimonials carousel
				 */

				if( $carousel.closest('.ts-testimonials').length ) {
					settings.adaptiveHeight = true;
				}

				$carousel.slick({
					slidesToShow: settings.slidesToShow,
					slidesToScroll: settings.slidesToScroll, 
					arrows: settings.arrows,
					prevArrow: $wrapper.find('.carousel-nav .carousel-nav-left'),
					nextArrow: $wrapper.find('.carousel-nav .carousel-nav-right'),
					dots: settings.dots,
					useCSS: true,
					customPaging: function() {
						return '<span class="nav-dot"> </span>';
					},

					infinite: settings.infinite,
					autoplay: settings.autoplay,
					autoplaySpeed: 3000,
				    adaptiveHeight: settings.adaptiveHeight,

				});

				$carousel.on('beforeChange', function( event, slick, currentSlide, nextSlide ){
					AIRKIT.lazyLoad.control($carousel);
				});

			},
			_onResize: function(container, reinit) {
				var self = this;
				reinit = reinit || false;

				container.each(function(){
					var $$ = $(this);
					var $carousel = $$.find('.carousel-container, .row-bg-slides');

					if( $$.closest('.mosaic-view').length && win.width() <= 768 ) {

						if ( $carousel.hasClass('slick-initialized') ) {
							$carousel.slick('unslick');
							$carousel.find('.scroll-container').css('width', 'auto');
						}

						return;

					} else {
						if ( reinit ) {
							$carousel.find('.scroll-container').attr('');
							$carousel.slick('unslick');

							return self.build($$);
						}
					}
				});
			}
		},
		visibleBeforeAnimation: {
			selector: '.ts-counters, .ts-horizontal-skills > li, .ts-vertical-skills > li',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					var $$ = $(this);

					if ( $$.isOnScreen() ) {
						if ( $$.hasClass('ts-counters') ) {
							AIRKIT_EL.startCounters.init();
						} else if ( $$.parent().hasClass('ts-horizontal-skills') ) {
							$$.parent().countTo();
						} else if ( $$.parent().hasClass('ts-vertical-skills') ) {
							$$.parent().countTo();
						}
					};
				});

				_listenerEvent('scroll', self, '_onScroll', [container]);
			},
			_onScroll: function(container) {
				container.each(function(){
					var $$ = $(this);

					if ( $$.isOnScreen() ) {
						if ( ! $$.hasClass('shown') && $$.hasClass('ts-counters') ) {
							AIRKIT_EL.startCounters.init();
						} else if ( ! $$.parent().hasClass('shown') && $$.parent().hasClass('ts-horizontal-skills') ) {
							$$.parent().countTo();
						} else if ( ! $$.parent().hasClass('shown') && $$.parent().hasClass('ts-vertical-skills') ) {
							$$.parent().countTo();
						}
					};
				});
			}
		},
		resizeVideo: {
			selector: '.embedded_videos iframe',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				self.control(container);
				self.control($('.post-content iframe'));
				self.control($('.embedded_videos .wp-video'));
			},
			control: function(element) {

				element.each(function(){
					var $$ = $(this),
						iframe_width = $$.width(),
						iframe_height = $$.height(),
						iframe_proportion = iframe_width / iframe_height,
						iframe_parent_width = 1;

					if ( element.selector !== '.embedded_videos .wp-video' ) {
						if ( iframe_height > iframe_width){
							iframe_proportion = $$.attr('width') / $$.attr('height');
						}
					}

					if ( element.selector == '.embedded_videos iframe' ) {

						iframe_parent_width = $$.parents('[class^="embedded_"]').parent().width();

					} else if ( element.selector == '.post-content iframe' ) {

						iframe_parent_width = $$.parent().width();

					} else if ( element.selector == '.embedded_videos .wp-video' ) {

						iframe_parent_width = $$.parents('.embedded_videos').parent().width();

						$$.find('.wp-video-shortcode').css('width', iframe_parent_width);
						$$.find('.wp-video-shortcode').css('height', iframe_parent_width / iframe_proportion);

						setTimeout(function(){
							win.trigger('resize');
						}, 400);

					}

					$$.attr('width', iframe_parent_width);
					$$.attr('height', iframe_parent_width / iframe_proportion);

					$$.fadeIn(500);
				});
			}
		},
		fancyBox: {
			selector: '[data-fancybox]',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				if ( airkit_FancyBoxEnabled == true ) return;

				container.fancybox({
					image: {
						protect: true // protect images from downloading by right-click
					}
				});

				airkit_FancyBoxEnabled = true;
			}
		},
		siteSection: {
			selector: '.site-section',
			init: function() {
				var self = this,
					container = $(self.selector);

				self.scrollBtn(container);
				self.control(container);
				self.control($('section[class*="view"] article'));

				_listenerEvent('resize', self, '_onResize', [container]);
				_listenerEvent('scroll', self, 'control', [container]);
				_listenerEvent('scroll', self, 'control', [$('section[class*="view"] article')]);
			},
			control: function(container) {
				container.each(function(){
					if ( $(this).isOnScreen() && !$(this).hasClass('loaded') ) {
						$(this).addClass('loaded');
					}
				});
			},
			_onResize: function(container) {
				var windowHeight = win.height();
				
				container.each(function(){

					var $$ = $(this);

					if ( $body.hasClass('admin-bar') ) {
						windowHeight = win.height() - $('#wpadminbar').height();
					}

					if ( $$.parent().is('header#header') && $$.hasClass('airkit_fullscreen-row') ) {

						$body.addClass('airkit_fullscreen-hero-header');

					} else if ( $$.hasClass('airkit_fullscreen-row') ) {

						$$.css({
							'height' : windowHeight
						});

					}

				});
			},
			scrollBtn: function(container) {
				container.find('.ts-scroll-down-btn > a, .hero-header-scroll-btn > a').on('click', function(e){
					e.preventDefault();

					$('html, body').animate({

						scrollTop: $(this).parents('.site-section').outerHeight()

					}, 1000);
				});
			}
		},
		rowSticky: {
			selector: '.airkit_row-sticky',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function() {
					var $$  = $(this),
						offsetTop = $$.offset().top;

					if( $$.hasClass('airkit_smart-sticky') ) {

						offsetTop = offsetTop + $$.height();

					}

					$$.affix({
						offset: {
							top: offsetTop
						}
					});

					// Avoid sticky element bouncing when smart sticky option enabled.
					if( $$.hasClass('airkit_smart-sticky') ) {
						// Hide element before affixing
						$$.on('affix.bs.affix', function(){
							$$.addClass('smart-relative');
						});
						// Make element visible after affixing was done.
						$$.on('affixed.bs.affix', function(){
							setTimeout(function(){
								$$.removeClass('smart-relative');
							}, 450);
							
						});

					}

				});
			}
		},
		smartSticky: {
			selector: '.airkit_smart-sticky',
			init: function() {

				var self = this,
					container = $(self.selector);

					container.each(function() {

						var $$ = $(this),
							elementHeight = $$.height(),
							didScroll,
							delta = 5; //how much to scroll.

							self.lastScrollTop = 0;

							win.on( 'scroll', function(){
								didScroll = true;
							});

							setInterval(function() {

							    if ( didScroll ) {
							        self.hasScrolled( $$, delta, elementHeight );
							        didScroll = false;
							    }

							}, 250);

					});
			},
			hasScrolled: function( elem, delta, navbarHeight ) {

			    var st = win.scrollTop();
			    
			    // Make sure they scroll more than delta
			    if( Math.abs(self.lastScrollTop - st) <= delta )
			        return;

			    // If they scrolled down and are past the navbar, add class .smart-up.
			    if ( st > self.lastScrollTop && st > navbarHeight ){
			        // Scroll Down
			        elem.removeClass('smart-down').addClass('smart-up');

			    } else {
			        // Scroll Up
			        if( st + win.height() < $(document).height() ) {
			            elem.removeClass('smart-up').addClass('smart-down');
			        }
			    }
			    
			    self.lastScrollTop = st;
			}

		},
		getFrameSize: {
			control: function(container) {
				var frame = container,
					new_iframe_url = frame.attr('src').split('?feature=oembed'),
					videoLink = new_iframe_url[0],
					videoWidth = frame.width(),
					videoHeight = frame.height(),
					container = $(".video-figure-content").width(),
					calc = parseFloat(parseFloat(videoWidth/videoHeight).toPrecision(1)),
					frameHeight = parseInt(container/calc);

				var frameOptions = {
					iframe:frame,
					videourl:videoLink,
					iwidth:container,
					iheight:frameHeight
				}

				return frameOptions
			}
		},
		videoPlayAction: {
			selector: '.single-video, .single-format-video',
			init: function() {
				var self = this,
					container = $(self.selector);

				$body.on('click', '.airkit_video-open', function(){

					var $$ = $(this);
					var post_ID = $$.attr('data-post-id');
					var nonce = $$.attr('data-ajax-nonce');

					$$.addClass('is-clicked');

					$.post(gowatch.ajaxurl, {

						action: 'airkit_insert_video_content',
						post_id: post_ID,
						security: nonce

					}, function(data) {

						if ( data.response == '-1' ) {
							alert('Something wrong!');
							$$.removeClass('is-clicked');
							
							return;
						}

						var option = AIRKIT.getFrameSize.control( $(data.frame) );
						
						if ( option.videourl.indexOf('youtube') >= 0 ){

							var videoid = option.videourl.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)\/embed\/([^\s&]+)/);

							if ( videoid == null ) {
							   alert('Video [id] not available!');
							}

						} else if ( option.videourl.indexOf('vimeo') >= 0 ){

							var videoid = option.videourl.match(/(?:https?:\/{2})?(?:w{3}\.)?player\.vimeo\.com\/video\/([0-9]*)/);

							if ( videoid == null ) {
							   alert('Video [id] not available!');
							}
						} else {
							alert('No valid video url!');
						}

						option.iframe.attr("src",option.videourl+'?autoplay=1');

						$$.fadeOut();
						container.find('article[data-post-id="'+ post_ID +'"] > figure.featured-image img').hide();

						container.find('article[data-post-id="'+ post_ID +'"]').find('.embedded_videos').children().html( option.iframe ).fadeIn();

					});
					
				})
			}
		},
		scrollDownBtn: {
			selector: '#airkit_back-to-top',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.on('click',function() {
					$('html, body').stop().animate({
					   scrollTop: 0
					}, 500, function() {
						container.stop().animate({
							bottom: '-100px'
						}, 500);
					});
				});

				self._onScroll(container);

				$doc.on('scroll', function(){
					self._onScroll(container);
				});
			},
			_onScroll: function(container) {
				if ( win.width() > 768 ) {
					if ( win.scrollTop() > 200 ){
						container.stop().animate({
							bottom: '45px'
						}, 500);

					} else {

						container.stop().animate({
						   bottom: '-100px'
						}, 500);
					}
				}
			}
		},
		scrollTextFade: {
			selector: '.airkit_scroll-text-fade',
			init: function() {
				var self = this,
					container = $(self.selector);

				$doc.on('scroll', function(){
					self._onScroll(container);
				});
			},
			_onScroll: function(container) {
				var opacity = 1.3-(win.scrollTop() / 330);
				container.fadeTo(5, opacity);
			}
		},
		singlePostActions: {
			selector: '.post-affix',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.affix({
		            offset: {
		                top: container.closest('.airkit_single-post').offset().top,
		            }
		        });

		        /*
		         * Helper height var, used to add height if there is admin bar
		         */
		        var margin = 0;

		        if( $doc.scrollTop() > 0 ) {

		            //get margin if document is already scrolled
		            margin = AIRKIT.getStickyMargin.control();

		            /*
		             * Affix position If document is already scrolled on load
		             */
		            container.css({'top': margin});        
		        }

		        container.on( 'affix.bs.affix', function() {

		            //get margin when post-affix gets affixed.
		            margin = AIRKIT.getStickyMargin.control();

		            container.css({'top': margin});

		        });


		        container.on( 'affixed-top.bs.affix', function() {
		            //remove element affix.
		            $(this).css('top', 0 );

		        }); 
			}
		},
		getStickyMargin: {
			control: function() {
				var margin = 0;

				if( $body.hasClass('admin-bar') ) {

					if( win.width() >= 782 ) {
						margin += 30;
					} else if( win.width() >= 600 && win.width() < 782 ) {
						margin += 45;
					} else if ( win.width() < 600 ) {
						margin = 0;
					}

				}

				if( $('.airkit_menu.affix').length ) {
					margin += $('.airkit_menu.affix').height();
				}

				if(  $('#header .airkit_row-sticky').length  ) {
					margin += $('#header .airkit_row-sticky').height();
				}

				if(  $('.airkit_header-style2').length  ) {
					margin += $('.airkit_header-style2').height();
				}

				if(  $('.airkit_header-style4').length  ) {
					margin += $('.airkit_header-style4').height();
				}

				if(  $('.airkit_header-style5').length  ) {
					margin += $('.airkit_header-style5').height();
				}

				return margin;
			}
		},
		singleCommentsToggle: {
			selector: '.comments-toggle',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.find('.comments-title:not(.comments-closed)').on( 'click', function(e){

					e.preventDefault();

					//add class to rotate arrow icon
					var icon = $(this).find('i.comments-toggle');
						icon.toggleClass('active');

					//toggle comments list & comment form
					$(this).next('.commentlist').slideToggle(200);

					$('.comment-respond').slideToggle(200);

					if( $('.fb-comments').length > 0 ) {

						$('.fb-comments').slideToggle(200);

					}
					
				});
			}
		},
		flipSliderImages: {
			selector: '.airkit_slider .slides .slider-item, .airkit_tilter-slider .tilter-slides > article',
			init: function() {
				var self = this,
					container = $(self.selector);

				self._onResize(container);
				
				_listenerEvent('resize', self, '_onResize', [container]);
			},
			_onResize: function(container) {
				container.each(function(){

					var $$ = $(this),
						smSource = $$.attr('data-img-sm'),
						lgSource = $$.attr('data-img-lg'),
						img = $$.find('img'),
						newSource;

					if( win.width() <= 768  ) {
						newSource = smSource;
					} else {
						newSource = lgSource;
					}

					img.attr( 'src', newSource );
					img.attr( 'data-original', newSource );
				});
			}
		},
		toggleRegisterForms: {
			selector: '.airkit_register-page',
			init: function() {
				var self = this,
					container = $(self.selector);
			
				container.find('.toggle-form').on('click', function(e){

					e.preventDefault();

					var $$ = $(this),
						thisForm = $$.parent().next('.form-container'),
						thisPlaceholder = $$.parent(),
						thisColumn = $$.parent().parent();

					if( ! thisForm.hasClass('active') ) {
						
						$$.parents('.airkit_register-page').find('.form-container').removeClass('visible');

						$$.parents('.airkit_register-page').find('.form-container').not( thisForm ).removeClass('active');
						$$.parents('.airkit_register-page').find('.placeholder').not( thisPlaceholder ).addClass('active');

						thisForm.addClass('active');
						thisPlaceholder.removeClass('active');
						thisColumn.addClass('active-column').siblings().removeClass('active-column');
					}

					return false;
				});

				// Toggle Lostpassword form.
				$('.lostpassword-trigger').on('click', function(e){
					e.preventDefault();
					$('.airkit_register-page .login-form-inner').hide(300);
					$('.airkit_register-page .lost-password').show(500);
				});

				// Toggle login form
				$('.loginform-trigger').on('click', function(e){
					e.preventDefault();
					$('.airkit_register-page .lost-password').hide(300);
					$('.airkit_register-page .login-form-inner').show(500);
				});

				self._onResize(container);

				win.on('resize', function(){
					self._onResize(container);
				});
			},
			_onResize: function(container) {
				if ( win.width() > 1200 ) {
					// Calculate height for forms
					var wrapHeight = container.outerHeight();

				    container.find('.form-container').each(function(){
				        
				        $(this).height(wrapHeight);

				        $(this).mCustomScrollbar({
				            setHeight: wrapHeight + 60,
				            axis: 'y',
				            theme: "dark",
				            scrollInertia:75,
				        });            

				    });
				} else {
					container.find('.form-container').each(function(){
						$(this).css('height', 'auto');
					})
				}
			}
		},
		selectPostByCategory: {
			selector: '.ts-select-by-category',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					$(this).find('>li:first-child').trigger('click');

					var $wrap = $(this).closest('.airkit_article-views');

					$(this).children('li').click(function(evt){

						evt.preventDefault();

						var idCategory = $(this).attr('data-filter');
							

						$('.ts-select-by-category li').each(function(){
							if( $(this).hasClass('active') ){
								$(this).removeClass('active');
							}
						})

						$(this).addClass('active');

						var $container = $wrap.find('.filters-container');

						var filterStr = '[data-filter-by*="'+ idCategory +'"]';

						if( '*' == idCategory ) {

							filterStr = '*';

						}

						/* initialize isotope */
						$container.isotope();
						$container.isotope('layout');

						/* Apply filtering */
						if( $wrap.hasClass('mosaic-view') ) {
								
							/* Mosaic view filtering needs additional parameters. */
							$container.packery();
							
							$container.isotope({
								itemSelector: '.item',
								filter: filterStr,
								layoutMode: 'packery',

								/* FIlterBy: Items with filter-by attribute containing idCategory variable */
							});

						} else {

							$container.isotope({
								itemSelector: '.item',
								filter: filterStr,
								/* FIlterBy: Items with filter-by attribute containing idCategory variable */
							});

						}

						/* Load lazy images after arrange has completed */
						$container.on( 'arrangeComplete', function(){

							AIRKIT.lazyLoad.control( $container );

						});

						return false;
					});		
				});
			}
		},
		facebookRoot: {
			selector: '#fb-root',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=" + airkit_facebook_id;
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			}
		},
		facebookPagePlugin: {
			selector: '.facebook-page-plugin',
			init: function() {
				var self = this,
					container = $(self.selector);

					container.css('width', container.parent().width() + 'px');
			}
		},
		tabItem: {
			selector: '.ts-item-tab',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.on('click', function (e) {
				    e.preventDefault();

				    var id = $(this).find('a').attr('href'),
				        parent = $(this).closest('.ts-tab-container');

				    parent.find('.nav-tabs li.active').removeClass('active');
				    parent.find('.tab-content .tab-pane.active').removeClass('active');

				    $(this).addClass('active');
				    $(id).addClass('active');

				});
			}
		},
		scrollView: {
			selector: '.scroll-view',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.mCustomScrollbar({
				    horizontalScroll:true,
				    axis: 'x',
				    theme: "dark",
				    scrollInertia:75,
				    advanced:{
				        autoExpandHorizontalScroll:true
				    }, 
				    callbacks:{
				    	whileScrolling: function(){
				    		AIRKIT.lazyLoad.control( $(this) );
				    	}
				    }
				});

			}
		},
		scrollVertical: {
			selector: '.vertical-scroll',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.mCustomScrollbar({
				    axis: 'y',
				    theme: "dark",
				    scrollInertia: 175,
				    advanced:{
				        autoExpandHorizontalScroll:true
				    }, 
				    callbacks:{
				    	whileScrolling: function(){
				    		AIRKIT.lazyLoad.control( $(this) );
				    	}
				    }
				});

			}
		},
		TiltFx: {
			selector: '.airkit_tilter',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(pos, el){
					new TiltFx(el, [options]);
				});

				// Options for TiltFx Effect
				var options = {
					movement: {
						imgWrapper : {
							translation : {x: 0, y: 0, z: 0},
							rotation : {x: 0, y: 0, z: 0},
							reverseAnimation : {duration : 1200, easing : 'easeOutQuad'}
						},
						caption : {
							rotation : {x: 0, y: 0, z: 2},
							reverseAnimation : {duration : 1200, easing : 'easeOutQuad'}
						},
						lines : {
							translation : {x: 10, y: 10, z: [0,70]},
							rotation : {x: 0, y: 0, z: -2},
							reverseAnimation : {duration : 2000, easing : 'easeOutExpo'}
						},
					}
				}
			}
		},
		preventAdBlock: {
			selector: 'body',
			init: function() {
				var self = this;
		
				//prevent adblock
				if( airkit_prevent_blocker == 'y' ) {
					//Fuckadblock in less shitty way.
					var adBlockEnabled = false;
					var testAd = document.createElement('div');
						testAd.innerHTML = '&nbsp;';
						testAd.className = 'adsbox';

					document.body.appendChild(testAd);

					window.setTimeout(function() {

						if (testAd.offsetHeight === 0) {
						    adBlockEnabled = true;
						}

						testAd.remove();

						if( adBlockEnabled ) {
						  	// Create overlay
						  	var overlay = document.createElement('div');
						  		overlay.innerHTML = airkit_blocker_html;
						  		overlay.className = 'airkit_overlay-block';

					  		document.body.appendChild(overlay);
					  		document.body.classList.add('airkit_locked');

					  		//Remove the wrapper.
					  		document.getElementById('wrapper').remove();

						  	// Disable right click
						  	document.body.addEventListener('contextmenu', function(ev){
						  		ev.preventDefault();
						  		return false;
						  	});
						}

					}, 100);	
				}
			}
		},
		sharing: {
			selector: '.airkit_sharing',
			init: function() {
				var self = this,
					container = $(self.selector);

				// Count the share
				container.find('.share-options li').click(function(){
					var $$ = $(this),
				    	social = $$.attr('data-social'),
				    	postId = $$.attr('data-post-id'),
				    	elemClass = $$.children('a').attr('class');

				    var socialCount = $('.' + elemClass).find('.how-many');

				    var data = {
				            action      : 'ts_set_share',
				            ts_security : gowatch.ts_security,
				            postId      : postId,
				            social      : social
				        };

				    $.post(gowatch.ajaxurl, data, function(response){

				        if( response && response !== '-1' ){
				            $(socialCount).text(response);
				            $('.counted').each(function(){
				            	$(this).text(parseInt($(this).text()) + 1);
				            });
				        }
				    });
				});

				self._onResize(container);
				self.showForViews();
				
				_listenerEvent('resize', self, '_onResize', [container]);
			},
			_onResize: function( container ) {
				var width_container = 0;

				// Only for tooltip popover sharing
				if ( container.parent().hasClass('tooltip-sharing') ) {

					$('.tooltip-sharing').find('.share-options > li').each(function(){
						width_container += $(this).outerWidth() + 10;
					});

					if ( win.width() > 960 ) {
						$('.tooltip-sharing').find('.popover').css({"width" : ( width_container + 30 ) + 'px'});
					} else {
						$('.tooltip-sharing').find('.popover').css({"width" : ( (width_container / 2) + 30 ) + 'px'});
					}

				}
			},
			showForViews: function(){
				jQuery(document).on('hover', '.views-sharing-button', function(e){
					var clickedArticle = jQuery(this);
					clickedArticle.toggleClass('opened');
					
				});
				jQuery(document).on('click', '.views-sharing-button', function(e){
					return false;
				});
			}
		},
		infiniteLoading: {
			selector: '.ts-infinite-scroll',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				_listenerEvent('scroll', self, '_onScroll', [container]);
			},
			_onScroll: function(container) {
				container.each(function(){
					var $$ = $(this);
					
					if( $$.prev().offset().top + $$.parent().height() - 220 < win.scrollTop() + win.height() && infinite_loading == false ){

						infinite_loading = true;
						$$.trigger("click");

						setTimeout(function(){
							infinite_loading = false;
						}, 1000)
						
					}
				});
			}
		},
		articleProgressBar: {
			selector: '.article-progress-bar',
			init: function(){
				var self = this,
					container = $(self.selector);

				$(AIRKIT._CurrentReading).find(self.selector).TsProgressScroll({backgroundColor: airkit_main_color, height: '3px', position: 'fixed'});
			}
		},
		ParallaxScroll: {
	        /* PUBLIC VARIABLES */
	        selector: '.img_parallaxer',
	        showLogs: false,
	        round: 1000,

	        /* PUBLIC FUNCTIONS */
	        init: function() {
	            this._log("init");
	            if (this._inited) {
	                this._log("Already Inited");
	                this._inited = true;
	                return;
	            }
	            this._requestAnimationFrame = (function(){
	              return  window.requestAnimationFrame       || 
	                      window.webkitRequestAnimationFrame || 
	                      window.mozRequestAnimationFrame    || 
	                      window.oRequestAnimationFrame      || 
	                      window.msRequestAnimationFrame     || 
	                      function(/* function */ callback, /* DOMElement */ element){
	                          window.setTimeout(callback, 1000 / 60);
	                      };
	            })();
	            this._onScroll(true);
	        },

	        /* PRIVATE VARIABLES */
	        _inited: false,
	        _properties: ['x', 'y', 'z', 'rotateX', 'rotateY', 'rotateZ', 'scaleX', 'scaleY', 'scaleZ', 'scale'],
	        _requestAnimationFrame:null,

	        /* PRIVATE FUNCTIONS */
	        _log: function(message) {
	            if (this.showLogs) console.log("Parallax Scroll / " + message);
	        },
	        _onScroll: function(noSmooth) {
	            var scroll = $(document).scrollTop();
	            var windowHeight = $(window).height();
	            this._log("onScroll " + scroll);
	            $(this.selector).each($.proxy(function(index, el) {
	                var $el = $(el);
	                var properties = [];
	                var applyProperties = false;
	                var style = $el.data("style");
	                if (style == undefined) {
	                    style = $el.attr("style") || "";
	                    $el.data("style", style);
	                }
	                var datas = [$el.data("parallax")];
	                var iData;
	                for(iData = 2; ; iData++) {
	                    if($el.data("parallax"+iData)) {
	                        datas.push($el.data("parallax-"+iData));
	                    }
	                    else {
	                        break;
	                    }
	                }
	                var datasLength = datas.length;
	                for(iData = 0; iData < datasLength; iData ++) {
	                    var data = datas[iData];
	                    var scrollFrom = data["from-scroll"];
	                    if (scrollFrom == undefined) scrollFrom = Math.max(0, $(el).offset().top - windowHeight);
	                    scrollFrom = scrollFrom | 0;
	                    var scrollDistance = data["distance"];
	                    var scrollTo = data["to-scroll"];
	                    if (scrollDistance == undefined && scrollTo == undefined) scrollDistance = windowHeight;
	                    scrollDistance = Math.max(scrollDistance | 0, 1);
	                    var easing = data["easing"];
	                    var easingReturn = data["easing-return"];
	                    if (easing == undefined || !$.easing|| !$.easing[easing]) easing = null;
	                    if (easingReturn == undefined || !$.easing|| !$.easing[easingReturn]) easingReturn = easing;
	                    if (easing) {
	                        var totalTime = data["duration"];
	                        if (totalTime == undefined) totalTime = scrollDistance;
	                        totalTime = Math.max(totalTime | 0, 1);
	                        var totalTimeReturn = data["duration-return"];
	                        if (totalTimeReturn == undefined) totalTimeReturn = totalTime;
	                        scrollDistance = 1;
	                        var currentTime = $el.data("current-time");
	                        if(currentTime == undefined) currentTime = 0;
	                    }
	                    if (scrollTo == undefined) scrollTo = scrollFrom + scrollDistance;
	                    scrollTo = scrollTo | 0;
	                    var smoothness = data["smoothness"];
	                    if (smoothness == undefined) smoothness = 30;
	                    smoothness = smoothness | 0;
	                    if (noSmooth || smoothness == 0) smoothness = 1;
	                    smoothness = smoothness | 0;
	                    var scrollCurrent = scroll;
	                    scrollCurrent = Math.max(scrollCurrent, scrollFrom);
	                    scrollCurrent = Math.min(scrollCurrent, scrollTo);
	                    if(easing) {
	                        if($el.data("sens") == undefined) $el.data("sens", "back");
	                        if(scrollCurrent>scrollFrom) {
	                            if($el.data("sens") == "back") {
	                                currentTime = 1;
	                                $el.data("sens", "go");
	                            }
	                            else {
	                                currentTime++;
	                            }
	                        }
	                        if(scrollCurrent<scrollTo) {
	                            if($el.data("sens") == "go") {
	                                currentTime = 1;
	                                $el.data("sens", "back");
	                            }
	                            else {
	                                currentTime++;
	                            }
	                        }
	                        if(noSmooth) currentTime = totalTime;
	                        $el.data("current-time", currentTime);
	                    }
	                    this._properties.map($.proxy(function(prop) {
	                        var defaultProp = 0;
	                        var to = data[prop];
	                        if (to == undefined) return;
	                        if(prop=="scale" || prop=="scaleX" || prop=="scaleY" || prop=="scaleZ" ) {
	                            defaultProp = 1;
	                        }
	                        else {
	                            to = to | 0;
	                        }
	                        var prev = $el.data("_" + prop);
	                        if (prev == undefined) prev = defaultProp;
	                        var next = ((to-defaultProp) * ((scrollCurrent - scrollFrom) / (scrollTo - scrollFrom))) + defaultProp;
	                        var val = prev + (next - prev) / smoothness;
	                        if(easing && currentTime>0 && currentTime<=totalTime) {
	                            var from = defaultProp;
	                            if($el.data("sens") == "back") {
	                                from = to;
	                                to = -to;
	                                easing = easingReturn;
	                                totalTime = totalTimeReturn;
	                            }
	                            val = $.easing[easing](null, currentTime, from, to, totalTime);
	                        }
	                        val = Math.ceil(val * this.round) / this.round;
	                        if(val==prev&&next==to) val = to;
	                        if(!properties[prop]) properties[prop] = 0;
	                        properties[prop] += val;
	                        if (prev != properties[prop]) {
	                            $el.data("_" + prop, properties[prop]);
	                            applyProperties = true;
	                        }
	                    }, this));
	                }
	                if (applyProperties) {
	                    if (properties["z"] != undefined) {
	                        var perspective = data["perspective"];
	                        if (perspective == undefined) perspective = 800;
	                        var $parent = $el.parent();
	                        if(!$parent.data("style")) $parent.data("style", $parent.attr("style") || "");
	                        $parent.attr("style", "perspective:" + perspective + "px; -webkit-perspective:" + perspective + "px; "+ $parent.data("style"));
	                    }
	                    if(properties["scaleX"] == undefined) properties["scaleX"] = 1;
	                    if(properties["scaleY"] == undefined) properties["scaleY"] = 1;
	                    if(properties["scaleZ"] == undefined) properties["scaleZ"] = 1;
	                    if (properties["scale"] != undefined) {
	                        properties["scaleX"] *= properties["scale"];
	                        properties["scaleY"] *= properties["scale"];
	                        properties["scaleZ"] *= properties["scale"];
	                    }
	                    var translate3d = "translate3d(" + (properties["x"] ? properties["x"] : 0) + "px, " + (properties["y"] ? properties["y"] : 0) + "px, " + (properties["z"] ? properties["z"] : 0) + "px)";
	                    var rotate3d = "rotateX(" + (properties["rotateX"] ? properties["rotateX"] : 0) + "deg) rotateY(" + (properties["rotateY"] ? properties["rotateY"] : 0) + "deg) rotateZ(" + (properties["rotateZ"] ? properties["rotateZ"] : 0) + "deg)";
	                    var scale3d = "scaleX(" + properties["scaleX"] + ") scaleY(" + properties["scaleY"] + ") scaleZ(" + properties["scaleZ"] + ")";
	                    var cssTransform = translate3d + " " + rotate3d + " " + scale3d + ";";
	                    this._log(cssTransform);
	                    $el.attr("style", "transform:" + cssTransform + " -webkit-transform:" + cssTransform + " " + style);
	                }
	            }, this));
	            if(window.requestAnimationFrame) {
	                window.requestAnimationFrame($.proxy(this._onScroll, this, false));
	            }
	            else {
	                this._requestAnimationFrame($.proxy(this._onScroll, this, false));
	            }
	        }
	    },
	    postGalleryCarousel: {
	    	selector: '.carousel-post-gallery',
	    	init: function() {
	    		var self = this,
	    			container = $(self.selector);

    			self.build(container);
	    	},
	    	build: function(container) {
	    		var self = this;

	    		container.each(function(){
	    			var this_id = $(this).attr('id');
	    			var $this = $('#'+this_id);

	    			if ( !$this.hasClass('format-gallery-carousel') ) {

	    				if ( !$this.find('.gallery-items').hasClass('slick-initialized') ) {

	    					$this.find('.gallery-items').imgAdjustHeight();

			    			$this.find('.gallery-items').slick({
			    				slidesToShow: 1,
		    				 	slidesToScroll: 1,
								arrows: true,
						        infinite: false,
						        dots: true,
						        speed: 400,
						        adaptiveHeight: true,
						        asNavFor: $this.find('.gallery-nav-thumbnails .inner-gallery'),
								prevArrow: $this.find('.carousel-nav .carousel-nav-left'),
								nextArrow: $this.find('.carousel-nav .carousel-nav-right'),
								customPaging: function (slider, i) {
							        return  (i + 1) + '/' + slider.slideCount;
							    }
			    			});

			    			// Add height auto after slick init
		    				$this.find('.gallery-items .gallery-icon img').css('height', 'auto');

	    				}

	    				if ( !$this.find('.gallery-nav-thumbnails .inner-gallery').hasClass('slick-initialized') ) {
			    			$this.find('.gallery-nav-thumbnails .inner-gallery').slick({
			    				slidesToShow: false,
		    				 	slidesToScroll: 1,
		    				 	arrows: false,
		    				 	asNavFor: $this.find('.gallery-items'),
		    				 	focusOnSelect: true
			    			});
			    		}

		    			// Remove active class from all thumbnail slides
		    			$this.find('.gallery-item').removeClass('slick-active');

		    			// Set active class to first thumbnail slides
		    			$this.find('.gallery-item').eq(0).addClass('slick-active');

		    			// On before slide change match active thumbnail to current slide
		    			$this.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
		    			 	var mySlideNumber = nextSlide;
		    			 	$this.find('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
		    			 	$this.find('.slider-nav-thumbnails .slick-slide').eq(mySlideNumber).addClass('slick-active');

		    			 	setTimeout(function(){
			    			 	$this.find('.carousel-nav-show-thumbnails').removeClass('active');
			    			 	$this.find('.gallery-nav-thumbnails').removeClass('shown');
		    			 	}, 300);
		    			});

	    			} else {

	    				if ( !$this.find('.gallery-items').hasClass('slick-initialized') ) {

	    					// Add image height
	    					$this.find('.gallery-items').imgAdjustHeight();

			    			$this.find('.gallery-items').slick({
			    				slidesToShow: 1,
		    				 	slidesToScroll: 1,
								arrows: true,
						        infinite: false,
						        dots: false,
						        speed: 400,
						        adaptiveHeight: true,
								prevArrow: $this.find('.carousel-nav .carousel-nav-left'),
								nextArrow: $this.find('.carousel-nav .carousel-nav-right'),
			    			});


			    			// Add height auto after slick init
		    				$this.find('.gallery-items .gallery-icon img').css('height', 'auto');

			    		}

	    			}

	    		});

	    	}
	    },
	    header: {
	    	selector: '#header',
	    	init: function(){
	    		var self = this,
	    			container = $(self.selector);

    			if ( container.find('.airkit_header-style4, .airkit_header-style5') ){
    				var headerHeight = jQuery('.airkit_header-style4, .airkit_header-style5').outerHeight() + 60;
					var headerSizer = '<div class="header4sizer" style="height:'+headerHeight+'px;display:none;"></div>';

    				jQuery('.airkit_header-style4, .airkit_header-style5').before( headerSizer );
				}

	    		self._onScroll(container);
	    	},
	    	_onScroll: function(container) {
	    		win.on('scroll', function(){

	    			if ( win.scrollTop() >= 10 ) {

	    				container.find('.airkit_header-style2').addClass('fixed');

	    				if ( container.find('.airkit_header-style4.is-sticky, .airkit_header-style5.is-sticky').length ) {
	    					if ( jQuery('.header4sizer').is(':hidden') ){
		    					jQuery('.header4sizer').show();
	    					}
	    					container.find('.airkit_header-style4, .airkit_header-style5').addClass('fixed');
	    				}

	    			} else {

	    				container.find('.airkit_header-style2').removeClass('fixed');

	    				if ( container.find('.airkit_header-style4.is-sticky, .airkit_header-style5.is-sticky').length ) {
	    					if ( jQuery('.header4sizer').is(':visible') ){
		    					jQuery('.header4sizer').hide();
	    					}
	    					container.find('.airkit_header-style4, .airkit_header-style5').removeClass('fixed');
	    				}

	    			}
	    			
	    		});
	    	}
	    }
	} // end AIRKIT variable


	var AIRKIT_EL = {
		init: function() {
			var self = this,
				obj;

			for (obj in self) {
				if ( self.hasOwnProperty(obj) ) {
					var _method = self[obj];

					if ( _method.selector !== undefined && _method.init !== undefined ) {
						if ( $(_method.selector).length > 0 ) {
							_method.init();
						}
					}
				}
			}
		},
		twitterWidget: {
			selector: '.airkit_widget_tweets',
			init: function() {
				var self = this,
					container = $(self.selector);

				container.each(function() {
					//iterate through array or object
					var actioner = $(this).find('.airkit_twitter-container.dynamic .widget-items');
					self.cycleThru(actioner, 0);
				});
			},
			cycleThru: function(actioner, j) {
				var self = this,
					delay = 4000, //millisecond delay between cycles
					jmax = actioner.find("li").length;

				actioner.find("li:eq(" + j + ")").addClass('current')
					.css('display', 'block')
					.animate({opacity: 1}, 600)
					.animate({opacity: 1}, delay)
					.animate({opacity: 0}, 800, function(){
						if(j+1 === jmax){
							j=0;
						} else {
							j++;
						}

						$(this).css('display', 'none').animate({opacity: 0}, 10);
						self.cycleThru(actioner, j);
					});
			}
		},
		facebookModal: {
			selector: '#fbpageModal',
			init: function(t) {
				var self = this,
					container = $(self.selector),
					t = typeof t != 'undefined' ? t : 5,
					timeExe = t * 1000,
					closeBtn = container.find('button[data-dismiss="modal"]'),
					cookie = $.cookie('ts_fb_modal_cookie'),
					setTime = 360,
					liked_lifetime = 14; //(days)

				if( cookie != setTime && $.cookie('ts_fb_liked') !== 'y' ){

					container.delay(timeExe).queue(function() {

						$(this).hide();
						$(this).modal('show'); //calling modal() function
						$(this).dequeue();

					});

				} else {

					container.modal('hide');

				}

				//If you clicked on the close button, the function sends a cookie for 30 minutes which helps to not display modal at every recharge page
				closeBtn.on('click', function(){

					expireCookie(setTime, 'ts_fb_modal_cookie');

				});

				$('.ts-fb-modal .already-liked').click( function(){

					$.cookie( 'ts_fb_liked', 'y', { expires: liked_lifetime } );
					container.modal('hide');

				});
			}
		},
		flickrBadgeImage: {
			selector: '.flickr_badge_image',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				if( airkit_images_loaded_active == 'y' ) {

					container.each(function(){

						var img = $(this).find('img');

						img.attr( 'data-original', img.attr('src') );
						img.addClass('lazy');
						img.removeAttr('src');

						AIRKIT.lazyLoad.control( container );

					});

				}
			}
		},
		instagramWidget: {
			selector: '.ts-instagram-carousel',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				// container.find('[data-url]').on( 'click', function(){

				// 	var embed_url = $(this).data('url');

				// 	var data = {
				// 		action: 'gowatch-instagram-embed',
				// 		the_url: embed_url,
				// 	}

				// 	$.ajax({
				// 		type: 'POST',
				// 		cache: false,
				// 		data: data,
				// 		url: gowatch.ajaxurl,
				// 		success: function(data){
				// 			$.fancybox(data, {
				// 				padding: 0,
				// 			});
				// 		}
				// 	});
				// });
				var perRow = container.attr('data-per-row') | 1;

				if ( ! container.hasClass('slick-initialized') ) {
					container.each(function(){

						$(this).slick({
							slidesToShow: perRow,
							slidesToScroll: 1,
							arrows: false,
							dots: true,
							customPaging: function() {
								return '<span class="nav-dot"> </span>';
							},					
							infinite: true,
							autoplay: true,
							autoplaySpeed: 4000,
						});
					});
				}
			}
		},
		videoContentLimit: {
			selector: '.content-toggler span',
			init: function() {
				var self = this,
					container = $(self.selector);

				// Set/remove the height of the text content (description)
				container.click(function(){
					$('.post-content').toggleClass('less-content');

					var $$ = $(this),
						$icon = $$.find('i[class^="icon"]');

					// Set the right arrow classes
					var iconClass = $icon.attr('class');

					if ( iconClass == 'icon-down' ) {
						$icon.removeClass('icon-down').addClass('icon-up');
						$$.find('em').text(airkit_show_less);
					} else{
						$icon.removeClass('icon-up').addClass('icon-down');
						$$.find('em').text(airkit_show_more);
					}

				});
			}
		},
		startCounters: {
			selector: '.ts-counters',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					var $$ = $(this),
						$chart = $$.find('.chart'),
						$cnvSize = ($$.data('counter-type') == 'with-track-bar') ? 160 : 'auto',
						bar_color = $$.attr('data-bar-color'),
						track_color = '#fff';

					if( bar_color == 'transparent' ) track_color = false;

					$chart.easyPieChart({
						animate: 2000,
						scaleColor: false,
						barColor: bar_color,
						trackColor: track_color,
						size: $cnvSize,
						lineWidth: 5,
						lineCap: 'square',
						onStep: function(from, to, percent) {
							$(this.el).find('.percent').text(Math.round(percent)).css({
								"line-height": $cnvSize+'px',
								width: $cnvSize
							})
						}
					})
				});
			}
		},
		countDown: {
			selector: '.ts-countdown',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function() {
					var $this = $(this);
					setInterval( function(){ self.start( $this ) }, 1000);
				});
			},
			start: function(element) {
				// get date and time
				var countdown_data = element.find('.time-remaining'),
					date = countdown_data.data('date'),
					time = countdown_data.data('time');

				// get dom elements of the countdown
				var $days = element.find('.ts-days'),
					$hours = element.find('.ts-hours'),
					$minutes = element.find('.ts-minutes'),
					$seconds = element.find('.ts-seconds');

				// start the countdown
				var days, hours, minutes, seconds, sec_remaining, date_diff;

				var curr_date = new Date(),
					event_date = new Date(date + ' ' + time);

				if ( curr_date > event_date ) {
					element.remove();
					return;
				}

				date_diff =  Math.abs(Math.floor( (event_date - curr_date) / 1000));

				days = Math.floor( date_diff / (24*60*60) );
				sec_remaining = date_diff - days * 24*60*60;

				hours = Math.floor( sec_remaining / (60*60) );
				sec_remaining = sec_remaining - hours * 60*60;

				minutes = Math.floor( sec_remaining / (60) );
				sec_remaining = sec_remaining - minutes * 60;

				$days.text( days );
				$hours.text( hours );
				$minutes.text( minutes );
				$seconds.text( sec_remaining );
			}
		},
		googleMap: {
			selector: '.ts-map-create',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				var initialize = container.each(function(){

					var $$ = $(this);
					mapAddress = $$.attr('data-address');
					mapLat = $$.attr('data-lat');
					mapLng = $$.attr('data-lng');
					mapStyle = $$.attr('data-style');
					mapZoom = $$.attr('data-zoom');
					mapTypeCtrl = ($$.attr('data-type-ctrl') === 'true') ? true : false;
					mapZoomCtrl = ($$.attr('data-zoom-ctrl') === 'true') ? true : false;
					mapScaleCtrl = ($$.attr('data-scale-ctrl') === 'true') ? true : false;
					mapScroll = ($$.attr('data-scroll') === 'true') ? true : false;
					mapDraggable = ($$.attr('data-draggable') === 'true') ? true : false;
					mapMarker = $$.attr('data-marker');

					if( $$.attr('data-type') === 'ROADMAP' )
						mapType = google.maps.MapTypeId.ROADMAP
					else if( $$.attr('data-type') === 'HYBRID' )
						mapType = google.maps.MapTypeId.HYBRID
					else if( $$.attr('data-type') === 'SATELLITE' )
						mapType = google.maps.MapTypeId.SATELLITE
					else if( $$.attr('data-type') === 'TERRAIN' )
						mapType = google.maps.MapTypeId.TERRAIN
					else
						mapType = google.maps.MapTypeId.ROADMAP

					// How you would like to style the map.
					// This is where you would paste any style found on Snazzy Maps.
					if ( mapStyle === 'map-style-essence' ){
						style = [{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill"},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#7dcdcd"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]}]

					} else if( mapStyle === 'map-style-subtle-grayscale' ){
						style = [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]

					} else if( mapStyle === 'map-style-shades-of-grey' ){
						style = [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]}]

					} else if( mapStyle === 'map-style-purple' ){
						style = [{"featureType":"all","elementType":"all","stylers":[{"visibility":"simplified"},{"hue":"#bc00ff"},{"saturation":"0"}]},{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#e8b8f9"}]},{"featureType":"administrative.country","elementType":"labels","stylers":[{"color":"#ff0000"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#3e114e"},{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"},{"color":"#a02aca"}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"visibility":"simplified"},{"color":"#2e093b"}]},{"featureType":"landscape.natural","elementType":"labels.text","stylers":[{"color":"#9e1010"},{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"labels.text.fill","stylers":[{"color":"#ff0000"}]},{"featureType":"landscape.natural.landcover","elementType":"all","stylers":[{"visibility":"simplified"},{"color":"#58176e"}]},{"featureType":"landscape.natural.landcover","elementType":"labels.text.fill","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#a02aca"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#d180ee"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#a02aca"}]},{"featureType":"road.highway","elementType":"labels","stylers":[{"visibility":"off"},{"color":"#ff0000"}]},{"featureType":"road.highway","elementType":"labels.text","stylers":[{"color":"#a02aca"},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#cc81e7"},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"labels.text.stroke","stylers":[{"visibility":"simplified"},{"hue":"#bc00ff"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#6d2388"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#c46ce3"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#b7918f"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#280b33"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"simplified"},{"color":"#a02aca"}]}];

					} else if( mapStyle === 'map-style-best-ski-pros' ){
						style = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#2c3645"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#dcdcdc"}]},{"featureType":"landscape.man_made","elementType":"geometry.stroke","stylers":[{"color":"#476653"}]},{"featureType":"landscape.natural.landcover","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#93d09e"}]},{"featureType":"landscape.natural.terrain","elementType":"labels","stylers":[{"visibility":"on"},{"color":"#0d6f32"}]},{"featureType":"landscape.natural.terrain","elementType":"labels.text.stroke","stylers":[{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#62bf85"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#95c4a7"}]},{"featureType":"road","elementType":"labels.text","stylers":[{"color":"#334767"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"color":"#334767"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#b7b7b7"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"on"},{"color":"#364a6a"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"visibility":"on"}]},{"featureType":"transit.station.rail","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#535353"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#3fc672"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#4d6489"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]}]

					} else {
						style = '';
					}

					latlng = new google.maps.LatLng(mapLat, mapLng);

					var mapOptions = {
						zoom: parseInt(mapZoom),
						center: latlng,
						styles: style,
						zoomControl: mapZoomCtrl,
						scaleControl: mapScaleCtrl,
						mapTypeControl: mapTypeCtrl,
						scrollwheel: mapScroll,
						draggable: mapDraggable,
						mapTypeControlOptions: {
							style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
						},
						zoomControlOptions: {
							style: google.maps.ZoomControlStyle.SMALL
						},
						mapTypeId: mapType
					}
					var idElement = $$.attr('id');

					map = new google.maps.Map(document.getElementById(idElement), mapOptions);

					var marker = new google.maps.Marker({
						map: map,
						icon: mapMarker,
						position: latlng,
						title: mapAddress
					});
				});

				google.maps.event.addDomListener( window, "load", initialize );

			}
		},
		menu: {
			selector: '.airkit_menu',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				self.add('other');
				self.add('logo');
				self.updateClasses();
				self.responsiveClasses();
				self.alignMegaMenu();
				self.typeSidebar($('.airkit_toggle-menu'));

				_listenerEvent('resize', self, 'add', ['logo']);
				_listenerEvent('resize', self, 'updateClasses');
				_listenerEvent('resize', self, 'responsiveClasses');
				_listenerEvent('resize', self, 'alignMegaMenu');
			},
			add: function(element) {

				if ( element == 'logo' ) {
			    	/*
					 * On Large screen, add logo in the middle of menu items.
					 * On Small screens, in this theme, logo must be added right after menu toggle button.
			    	 */
			    	var menu = $('.airkit_menu-with-logo'),
			    		custom_menu_content;

			    	if ( ! menu.length > 0 ) return false;

			    	/* 	Check if custom logo option is enabled
			    		Done for menu with logo in the middle custom logo option 
		    		*/
			    	if ( menu.find('.custom-logo-image').length ) {
			    		console.log('Hi');
			    		var custom_logo_url = menu.find('.custom-logo-image').html();
			    		airkit_logo_content = airkit_logo_content.replace(/<img(.*?)src="(.*?)"(.*?)\/>/, '<img$1src="'+ custom_logo_url +'"$3/>');
			    		airkit_logo_content = airkit_logo_content.replace(/<img(.*?)srcset="(.*?)"(.*?)\/>/, '<img$1srcset="'+ custom_logo_url +' 660w"$3/>');
			    	}

			    	menu.find('.logo, li.menu-logo').remove();

			    	if ( win.width() > 768 ) {

			    		var items_count = menu.find('.navbar-nav > li').length,
			    		    middle  = Math.round( items_count / 2 );

		    		   	if ( menu.has('li.menu-logo').length == 0 ) {
							menu.find('.navbar-nav > li:nth-child(' + middle + ')').after( $('<li class="menu-logo">' + airkit_logo_content + '</li>') );
		    		    }

			    	} else {

			    		if ( menu.has('.logo').length == 0 ) {
							menu.find('.sb-menu-toggle').next('.navbar-default').prepend( $( airkit_logo_content ) );    		
			    		}

			    	}

			    } else if ( element == 'other' ) {

		    	    /*
		    		 * Add searchbox and cart to menu.
		    	     */

		    	    if( ! $('.airkit_add-to-menu').length > 0 ) return false;

	    	    	$('.airkit_add-to-menu').each(function(){

	    	    		var $$ = $(this),
	    	    			$menu = $$.closest('.airkit_menu'),
	    	    			appendMode = 'appendTo',
	    	    			appendClass = 'appended',
	    	    			destination = $menu;

	    	    		/*
	    				 * By default, elements will be appended to $menu,
	    				 * IF is set to add elements before the rest of menu items, change mode to PrependTo.
	    	    		 */
	    	    		if( $$.hasClass('airkit_prepend') ) {

	    	    			appendMode = 'prependTo';
	    	    			appendClass = 'prepended';

	    	    		}

	    	    		/**
	    	 			 * @var helperElementTypeClass contains class name that will be added to <li> as helper telling which type of element we're adding.
	    	    		 */
	    	    		var helperElementTypeClass = '';

	    	    		if( $$.hasClass('airkit_menu-logo') ) {

	    	    			helperElementTypeClass = 'menu-item-logo';

	    	    		} else if( $$.hasClass('airkit_menu-search') ) {

	    	    			helperElementTypeClass = 'menu-item-search';

	    	    		} else if( $$.hasClass('airkit_menu-cart') ) {

	    	    			helperElementTypeClass = 'menu-item-cart';

	    	    		}

	    	    		/*
	    				 * Add helper class telling that element was successfully added to menu.
	    	    		 */
	    	    		$$.removeClass('airkit_add-to-menu').addClass('airkit_added-to-menu');

	    	    		/*
	    	 			 * If is horizontal menu, elements should pe added as menu-items, inside the navbar. 
	    	 			 * In other menus they will be added after toggle icon
	    	    		 */

	    	    		 if( $menu.hasClass('airkit_horizontal-menu') ) {

	    	    		 	destination = $menu.find('.navbar-nav'); 
	    	    		 	$$.wrap('<li class="menu-item menu-item-' + appendClass + ' ' + helperElementTypeClass + '"> </li>');
	    	    		 	$$ = $$.parent();

	    	    		}

	    	    		$$[appendMode]( destination );   

	    	    	});

	    	    	/*
	    	    	 * Add specific class to first appended, and last prepended item. 
	    	    	 * This classes are used in css/style.css to add margin-left / right, to first / last element.
	    	    	 */
	    	    	$('.airkit_menu .navbar-nav li.menu-item-appended').first().addClass('first-appended');
	    	    	$('.airkit_menu .navbar-nav li.menu-item-prepended').last().addClass('last-prepended');

			    }
			},
			typeSidebar: function(container) {
				container.each(function(){
					var $menu = $(this),
						$child = $menu.find('.menu-item-has-children > a'),
						$trigger = $menu.find('.sb-menu-toggle'),
						// Repeating class names
						classes = {
							open: 'shown',
						};

					if( ! $menu.length || $menu.hasClass('binded') )  return;

					$menu.on( 'click', '.sb-menu-toggle', function(e){
						e.preventDefault();
						e.stopPropagation();

						$menu.addClass('binded');

						$menu.toggleClass( classes.open );

						$(this).toggleClass('menu-opens');

						if( $menu.hasClass( classes.open ) ) {

							$menu.trigger( 'open' );

						} else {

							$menu.trigger( 'close' );

						}

					});

					$child.on( 'click', function( evt ){
						
						// evt.preventDefault();
						evt.stopPropagation();
						//stop bootstrap default event.

						if( $menu.hasClass('hovermenu') ) return;

						// toggle open class to parent li.menu-item-has-children
						$(this).parent().toggleClass( classes.open );

						if( !$(this).parent().find(' .sub-menu--back').length ) {
							//add back button to submenu.
							$(this).parent().find(' > .dropdown-menu')
												 .prepend('<div class="sub-menu--back"><i class="icon-left-arrow-thin"></i><span>'+ airkit_back_text +'</span></div>')
												 .fadeIn(200);

							// theme custom : change color for close button on small screens
							$menu.find('.sb-menu-close').addClass('over-submenu');								 
						}

						AIRKIT.lazyLoad.control($menu);
					

						return false;

					});

					$child.parent().on( 'click', '.sub-menu--back', function(){

						// theme custom : change color for close button on small screens
						if( !$menu.find('.dropdown .dropdown.shown').length ) {
							$menu.find('.sb-menu-close').removeClass('over-submenu');
						}
						// remove open class from li.
						$(this).parent().parent().removeClass( classes.open );

						// remove back button.

						setTimeout(function(){
							$menu.find('.sb-menu-back').fadeOut(500)
					 	    .remove();	
						}, 300)

					});

					//Events

					//  On menu open:
					$menu.on( 'open', function(){

						// add close menu button
						$menu.find('.navbar').append('<span class="sb-menu-toggle sb-menu-close icon-close"></span>');		
						// add no scroll class to body
						$body.addClass('no-scroll');
						// add dark backface
						$menu.prepend('<div class="menu-dark-backface"></div>');
						
					});

					// On menu close:
					$menu.on( 'close', function(){

						// Add open class
						$menu.removeClass( classes.open );			
						// remove menu close button
						$menu.find( '.sb-menu-close' ).remove();

						$trigger.removeClass('menu-opens');

						/* Also close all open sub-menus */
						$menu.trigger( 'submenuClose' );
						// remove no scroll class from body
						$body.removeClass('no-scroll');
						// remove dark backface
						$('.menu-dark-backface').remove();

					});
					// On Submenu close:
					$menu.on( 'submenuClose', function(){

						//Close all open submenus
						$(this).find('.dropdown.shown').removeClass( classes.open );

						// remove all back buttons
						$menu.find( '.sub-menu--back' )
							 .fadeOut(200)
							 .remove();

					});

					// Close menu on ESC 
					$doc.keyup(function(e) {

					  if ( e.keyCode === 27 ) {
					  
					    $menu.trigger( 'close' );

					  }

					});

					// Close menu on document click;

					$menu.parent().on('click', '.menu-dark-backface', function(e){

						e.preventDefault();

						if( $menu.hasClass('shown') ) {

							$menu.trigger('close');

						}

						return false;

					});

				});
			},
			updateClasses: function() {
				if( win.width() <= 768 ) {

					$('.airkit_horizontal-menu, .airkit_vertical-menu').each(function(){

						var menu = $(this);
						// Buffer old classes, remove them, add new
						if( menu.hasClass('airkit_horizontal-menu') ) {
							menu.addClass('was-horizontal airkit_sidebar-menu').removeClass('airkit_horizontal-menu');
						}

						if( menu.hasClass('airkit_vertical-menu') ) {
							menu.addClass('was-vertical airkit_sidebar-menu').removeClass('airkit_vertical-menu');
						}			
					});

				} else {

					//remove toggle, remove classes, add old classes back
					$('.was-horizontal, .was-vertical').each(function(){
						// add old classes back, remove sidebar-related classes & elements
						var menu = $(this);

						if( menu.hasClass('was-horizontal') ) {
							menu.removeClass('was-horizotal airkit_sidebar-menu').addClass('airkit_horizontal-menu');
						}

						if( menu.hasClass('was-vertical') ) {
							menu.removeClass('was-vertical airkit_sidebar-menu').addClass('airkit_vertical-menu');
						}
						
						if ( !menu.hasClass('.airkit_sidebar-menu.shown') ) {
							$body.removeClass('no-scroll');
						}

						menu.find('.sub-menu--back').remove();
						menu.find('.dropdown.shown').removeClass( 'shown' );

					});
				}
			},
			responsiveClasses: function() {
				if( win.width() <= 768 ) {

					$('.airkit_horizontal-menu, .was-horizontal').removeClass('hovermenu').addClass('clickablemenu was-hovermenu');

				} else {

					if( $('.airkit_horizontal-menu, .was-horizontal').hasClass('was-hovermenu') ) {

						$('.airkit_horizontal-menu, .was-horizontal').removeClass('clickablemenu was-hovermenu').addClass('hovermenu');

					}

				}
			},
			alignMegaMenu: function() {
				if( win.width() > 768 ) {

					setTimeout(function(){

						if ( $('.airkit_horizontal-menu li.airkit_menu-tabs, .airkit_horizontal-menu li.airkit_is-mega').length > 0 ) {

							/* Create virtual container to align megamenu relatively to it. */
							var $container = $('<div class="container" id="mega-menu-alignment-helper"></div>').appendTo($body);

							$('.airkit_horizontal-menu li.airkit_menu-tabs, .airkit_horizontal-menu li.airkit_is-mega').each(function(){

									var $this = $(this),
										menu = $this.closest('.airkit_menu'),
										mega = $this.find('> .dropdown-menu'),
										elemWidth = $this.outerWidth(),
										offsetGutter = 40,
										elemOffset  = $this.offset().left + offsetGutter,
										windowWidth = win.width();

									if( $this.closest('.airkit_page-menu').length ) return;

									/* Get container left and right offset */									
									var containerOffsetLeft = Math.round( ( windowWidth - $container.outerWidth() ) / 2 ),
										containerOffsetRight = $container.outerWidth() + containerOffsetLeft;


									/* Detect elements that are outside container */
									if( elemOffset < containerOffsetLeft || elemOffset > containerOffsetRight  ) {
										
										$this.css("position", "relative");

										if( $this.closest('.airkit_horizontal-menu').length ) {
											//alignment should be done only for horizontal menus.
											
											if( elemOffset < containerOffsetLeft ) {
												/* if element is positioned to the left of ( any ) container */
												/* it's child mega menu should be positioned from the left  */							
												mega.css({
													'left' : '0',
													'right' : 'auto',
												});

											} else if( elemOffset > containerOffsetRight  ) {
												/* if element is positioned to the right of ( any ) container */
												/* element's child mega menu should be positioned from the right  */

												mega.css({
													'right' : '0',
													'left' : 'auto',
												});

											}
										}

										mega.width( $container.innerWidth() );

									} else {

										/* if element is positioned as 'inside' of container  */
										/* element's child mega mennu should be positioned in center  */
										mega.width( $container.innerWidth() - 40 );
										var result = Math.round( ( windowWidth - mega.width() ) / 2 ) - menu.offset().left;
										mega.css({'left': result});

									}
							
							});

							$container.remove();
							/* Remove virtual container after all .airkit_is-mega > .dropdown-menu elements are aligned */
							
						}
					}, 200);
				}
			}
		},
		gallery: {
			selector: '.airkit_gallery-content, .grid-post-gallery',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					var $$ = $(this);

					// 1. Masonry gallery
					if( $$.is('.gallery-masonry') ) {

						$$.find('.item, .gallery-item').imgAdjustHeight();

						$$.isotope({
							itemSelector: '.item, .gallery-item',
						});

						$$.find('.item img, .gallery-item img').css('height', 'auto');

						// 2. Horizontal scroll
					} else if( $$.is('.gallery-horizontal') ) {
						//will init using .scroll-view class. see @document ready callback.
					} else if ( $$.is('.gallery-carousel') ) {
						if ( ! $$.find('.gallery-content-items').hasClass('slick-initialized') ) {

							$$.find('.gallery-content-items').imgAdjustHeight();

							$$.find('.gallery-content-items').slick({
								arrows: true,
						        infinite: false,
						        draggable: true,
						        dots: true,
						        adaptiveHeight: true,
								prevArrow: $$.find('.carousel-nav .carousel-nav-left'),
								nextArrow: $$.find('.carousel-nav .carousel-nav-right'),
							});

							// Add height auto after slick init
		    				$$.find('.gallery-content-items img').css('height', 'auto');
						}
					}

					$$.find('.share-link').click(function(e){
						e.preventDefault();
						$$.find('.share-link').toggleClass('active');
						
					});
				});
			},
			_lazyFix: function() {
				var self = this,
					container = $(self.selector);

				container.each(function(){

					if ( $(this).find('.gallery-content-items').hasClass('slick-initialized') ) {
						AIRKIT.lazyLoad.control( $(this) );
					}

				});
			}
		},
		featAreaSlider: {
			selector: '.ts-featured-area.style-3',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					var $featarea = $(this),
						$main = $featarea.find('.feat-area-slider'),
						$thumbs = $featarea.find('.feat-area-thumbs');

					$main.slick({
						arrows: false,
						dots: false,
						slidesToShow: 1,
						asNavFor: $thumbs,
						fade: true,
						speed: 500,
						autoplay: true,
						autoplaySpeed: 4000
					});

					$main.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
						$thumbs.find('.thumb-item').removeClass('slick-active slick-current');
						$thumbs.find('.thumb-item[data-slick-index="' + $(slick.$slides[nextSlide]).attr('data-slick-index') + '"]').addClass('slick-active slick-current');
					})

					$thumbs.slick({
						arrows: false,
						dots: false,
						slidesToShow: 3,
						asNavFor: $main,
						pauseOnHover: false,
						focusOnSelect: true,
						responsive: [
							{
								breakpoint: 768,
								settings: {
									infinite: true,
									slidesToShow: 2,
								}
							},
						],
					});

					$thumbs.find('.post-link, header a').on('click', function(ev){
						ev.preventDefault();
						// return false;
					})

					$main.on('mouseover', function(){
						$thumbs.find('.slick-current .thumb-progress-bar').removeClass('loading').addClass('paused');
					}).on('mouseout', function(){
						$thumbs.find('.slick-current .thumb-progress-bar').removeClass('paused').addClass('loading');
					})
				});
			}
		},
		bocaSlider: {
			selector: '.ts-post-boca',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					var $slider = $(this).find('.boca-slides');

					$slider.slick({
						arrows: true,
				        infinite: false,
				        draggable: true,
						prevArrow: $slider.find('.customNavigation .ar-left'),
						nextArrow: $slider.find('.customNavigation .ar-right'),
						responsive: [
						 		{
						 			breakpoint: 992,
						 			settings: {
						 			draggable: true }
						 		},
						 		{
						 			breakpoint: 768,
						 			settings: {
									draggable: true }
						 		},
						 		{
						 			breakpoint:480,
						 			settings: {
						 			draggable: true }
						 		}
						 	]
					});

				});
			}
		},
		nonaSlider: {
			selector: '.airkit_nona-slider',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					var $$ = $(this),
						slider = $$.find('.ts-nona-slides'),
						slideNav = $$.find('.ts-slide-nav');

				     slider.slick({
				        slidesToShow: 1,
				        slidesToScroll: 1,
				        arrows: false,
				        speed: 500,
				        fade: true,
				        cssEase: 'linear',
				        adaptiveHeight:true,
				        draggable: true,
				    });

				    slideNav.slick({
				        slidesToShow: 4,
				        slidesToScroll: 1,
				        dots: false,
				        infinite: false,
				        centerMode: false,
				        lazyLoad: 'ondemand',
				        draggable: true,
				        arrows: false,
				        responsive: [
				             {
				                 breakpoint: 1200,
				                 settings: {
				                 slidesToShow: 3 }
				             },
				             {
				                 breakpoint: 992,
				                 settings: {
				                 slidesToShow: 2 }
				             },

				         ]
				    });	


				    slideNav.find('.nona-nav').on('click', function () {
				        var index = $(this).data('slick-index');
				        $(this).siblings('.slick-current').removeClass('slick-current');
				        $(this).addClass('slick-current');
				        $(this).parents('.ts-slide-nav').prev().slick('slickGoTo', index);
				    });

				});
			}
		},
		TilterSlider: {
			selector: '.airkit_tilter-slider',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					var $$ = $(this);
					var $slider = $$.find('.tilter-slides');

					var $arrows = '<nav class="tilter-slider--arrows"><a class="prev" href="javascript:void(0)"><span class="wrap-icon"></span></a><a class="next" href="javascript:void(0)"><span class="wrap-icon"></span></a></nav>';
					$$.append($arrows);
		    		$$.append('<button type="button" class="tilter-slider--pause"><i class="icon-pause"></i></button>');

					$slider.on('init reinit beforeChange', function( event, slick, currentSlide, nextSlide ){
				    	if ( slick.slideCount > 1 ) {
				    		$$.find('.tilter-slider-meta').find('.tilter-slider--progress').remove();
				    		$$.find('.tilter-slider-meta').prepend('<li class="tilter-slider--progress"><span class="progress"></span></li>');
				    	}
				    });

				    $slider.slick({
				        slidesToShow: 1,
				        slidesToScroll: 1,
				        arrows: true,
						autoplay: true,
						autoplaySpeed: 5500,
				        speed: 500,
				        fade: true,
				        cssEase: 'linear',
				        adaptiveHeight: true,
				        draggable: true,
				        centerMode: true,
				        mobileFirst: true,
				        pauseOnHover: false,
				        nextArrow: $('.airkit_tilter-slider .tilter-slider--arrows .prev'),
				        prevArrow: $('.airkit_tilter-slider .tilter-slider--arrows .next'),
				    });

					$$.on('click', '.tilter-slider--pause', function(){

						if ( !$(this).hasClass('paused') ) {
							$slider.slick('slickPause');
							$slider.slick('slickSetOption', 'autoplay', false);
							$slider.removeClass('slick-play').addClass('slick-pause');
							$(this).find('i').removeClass('icon-pause').addClass('icon-play-full');
						} else {
							$slider.slick('slickPlay');
							$slider.removeClass('slick-pause').addClass('slick-play');
							$(this).find('i').removeClass('icon-play-full').addClass('icon-pause');
						}

						$(this).toggleClass('paused');
					})

				});
			}
		},
		greaseSlider: {
			selector: '.airkit_grease-slider',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					self.build( $(this) );
				});
			},
			build: function(container) {
				var arrows = '<ul class="grease-arrows"><li class="left"><span class="icon-left-arrow"></span></li><li class="right"><span class="icon-right-arrow"></span></li></ul>';

				container.append(arrows);

				// Default Settings
				var settings = {
					slidesToShow: 3,
					slidesToScroll: 3,
					centerMode: true,
					focusOnSelect: true,
					infinite: true,
					arrows: true,
					dots: false,
					draggable : true,
					responsive: [
						{
							breakpoint: 1024,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 2,
								draggable: true,
							}
						},
						{
							breakpoint: 768,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
								draggable: true,
							}
						},
					],
					nextArrow: container.find('.grease-arrows .right'),
					prevArrow: container.find('.grease-arrows .left'),
				}

				// Change settings for Classic Style
				if ( container.hasClass('style-classic') ) {
					settings.centerMode = false;
				}

				container.find('.grease-items').slick(settings);
			},
			_lazyFix: function() {
				var self = this,
					container = $(self.selector);

				container.each(function(){

					if ( $(this).find('.grease-items').hasClass('slick-initialized') ) {

						AIRKIT.lazyLoad.control( $(this) );

					}

				});
			}
		},
		kleinSlider: {
			selector: '.airkit_slider.klein',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.find('.slides').each(function(){

					var $$ = $(this);

					if( $$.closest('.airkit_expanded-row') && win.width() > 960 ) {
						//align left slides
						var container = $('<div class="container" id="slider-align"></div>').appendTo('body'),
						    position  = 20 + ( container.outerWidth(true) - container.outerWidth() ) / 3;

						$$.find('.slider-caption-container.left').css({
							'left': position,
							'right': 'auto',
						});

						$$.find('.slider-caption-container.right').css({
							'right': position, 
							'left': 'auto',
						});				

						container.remove();
					}

					$$.slick({
						speed: 800,
						prevArrow: $(this).parent().find('.nav-arrows .ar-left'),
						nextArrow: $(this).parent().find('.nav-arrows .ar-right'),
						adaptiveHeight: false,
						autoplay: true,
						autoplaySpeed: 3800,
					});

					/* before, after SlideChange */
					$$.on('beforeChange', function(event, slick, currentSlide, nextSlide){
						/* Load next lazy image */
						AIRKIT.lazyLoad.control( $$ );
					});


				});
			}
		},
		mamboSlider: {
			selector: '.airkit_slider.mambo',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.find('.slides').each(function(){

					var $$ = $(this);
					var $navSlider = $(this).parent().find('.navSlides');
					console.log($navSlider);

					if( $$.closest('.airkit_expanded-row') && win.width() > 960 ) {
						//align left slides
						var container = $('<div class="container" id="slider-align"></div>').appendTo('body'),
						    position  = 20 + ( container.outerWidth(true) - container.outerWidth() ) / 3;

						$$.find('.slider-caption-container.left').css({
							'left': position,
							'right': 'auto',
						});

						$$.find('.slider-caption-container.right').css({
							'right': position, 
							'left': 'auto',
						});				

						container.remove();
					}

					$$.slick({
						speed: 300,
						prevArrow: $(this).parent().find('.nav-arrows .ar-left'),
						nextArrow: $(this).parent().find('.nav-arrows .ar-right'),
						adaptiveHeight: false,
					});

					$navSlider.slick({
					  slidesToShow: 4,
					  slidesToScroll: 1,
					  arrows: false,
					  focusOnSelect: true,
					  asNavFor: $$,
					  responsive: [
				 		{
				 			breakpoint: 992,
				 			settings: {
				 				slidesToShow: 3,
				 				slidesToScroll: 1,
				 			}
				 		},
				 		{
				 			breakpoint: 768,
				 			settings: {
				 				slidesToShow: 2,
				 				slidesToScroll: 1,
				 			}
				 		},
				 		{
				 			breakpoint:480,
				 			settings: {
				 				slidesToShow: 2,
				 				slidesToScroll: 1,
				 			}
				 		}
				 	]
					});

					/* before, after SlideChange */
					$$.on('beforeChange', function(event, slick, currentSlide, nextSlide){
						/* Load next lazy image */
						AIRKIT.lazyLoad.control( $$ );
					});


				});
			}
		},
		flexSlider: {
			selector: '.flexslider',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					var nav_control,
						nav_animation = $(this).attr('data-animation');

					if( $(this).hasClass('with-thumbs') ){
						nav_control = 'thumbnails';
					} else {
						nav_control = 'none';
					}

					$(this).flexslider({
						animation: nav_animation,
						controlNav: nav_control,
						prevText: "",
						nextText: "",
						smoothHeight: true,
					});
				});
			}
		},
		bxSlider: {
			selector: '.bxslider',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){
					var $$ = $(this).find("> ul"),
						caption = $$.find('.slider-caption');

					$$.bxSlider({
						auto: true,
						autoHover: true,
						mode: 'fade',
						pause: 5000,
						nextSelector: '#slider-next',
						prevSelector: '#slider-prev',
						nextText: '<i class="icon-right"></i>',
						prevText: '<i class="icon-left"></i>',
						speed: 1000,
						adaptiveHeight: true,
						responsive: true,
						onSliderLoad: function(){
							$$.children('li').eq(0).addClass('active-slide');
							caption.find('ul[class*="entry-"]').addClass('is-animated');
							caption.find('.slide-title').addClass('is-animated');
							caption.find('.excerpt').addClass('is-animated');
						},

						onSlideBefore: function(){
							caption.find('.slide-title').removeClass('is-animated');
							caption.find('.excerpt').removeClass('is-animated');
							caption.find('ul[class*="entry-"]').removeClass('is-animated');
						},

						onSlideAfter: function(currentSlide, totalSlides, currentSlideHtmlObject){
							container.find('.active-slide').removeClass('active-slide');
							$$.children('li').eq(currentSlideHtmlObject).addClass('active-slide');
							caption.find('.slide-title').addClass('is-animated');
							caption.find('.excerpt').addClass('is-animated');
							caption.find('ul[class*="entry-"]').addClass('is-animated');
						}
					});
				});
			}
		},
		joySlider: {
			selector: '.joyslider',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.JoySlider();
				container.find('.slides > li:first-child').css('display','inline-block');
				container.addClass('active');
			}
		},
		corenaSlider: {
			selector: '.corena-slider',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.JoySlider();
				container.addClass('active');
			}
		},
		verticalSlider: {
			selector: '.vertical-slider',
			init: function(refresh) {
				var self = this,
					container = $(self.selector);
		
				container.verticalSlider();
			}
		},
		productSlider: {
			selector: '.single-product .product-images',
			init: function() {
				var self = this,
					container = $(self.selector),
					$single = container.find('.slider-single'),
					$thumbs = container.find('.slider-thumbs');

				$single.slick({
					arrows: true,
					dots: false,
					slidesToShow: 1,
					slidesToScroll: 1,
					asNavFor: $thumbs,
					fade: true,
					prevArrow: container.find('.slider-nav .slider-nav-left'),
					nextArrow: container.find('.slider-nav .slider-nav-right'),
				});

				$thumbs.slick({
					arrows: false,
					dots: false,
					slidesToShow: 3,
					slidesToScroll: 1,
					asNavFor: $single,
					focusOnSelect: true,
					responsive: [
				 		{
				 			breakpoint: 992,
				 			settings: {
				 				slidesToShow: 3,
				 				slidesToScroll: 1,
				 			}
				 		},
				 		{
				 			breakpoint: 768,
				 			settings: {
				 				slidesToShow: 2,
				 				slidesToScroll: 1,
				 			}
				 		},
				 		{
				 			breakpoint:480,
				 			settings: {
				 				slidesToShow: 2,
				 				slidesToScroll: 1,
				 			}
				 		}
				 	]
				});

				container.on('beforeChange', function(event, slick, currentSlide, nextSlide){
					AIRKIT.lazyLoad.control(container);
				});
			}
		},
		imageCarousel: {
			selector: '.image-carousel',
			init: function() {
				var self = this,
					container = $(self.selector),
					width = 0;

				container.each(function(){
					self.build( $(this) );
				});

				container.find('ol > li').each(function(){
					var itemWidth = $(this).outerWidth() + 5;
					width += itemWidth;

					$(this).parent('ol').css({width: width+'px'});
				});
			},
			build: function(container) {
				var $slider = container.find('.image-carousel-items');

				$slider.on('init', function( event, slick ){
					AIRKIT.lazyLoad.control($slider);
				});

				if ( ! $slider.hasClass('slick-initialized') ) {

					$slider.slick({
						arrows: true,
				        infinite: true,
				        slidesToShow: 3,
				        variableWidth: true,
				        centerMode: true,
						prevArrow: container.find('.carousel-nav .carousel-nav-left'),
						nextArrow: container.find('.carousel-nav .carousel-nav-right'),
						responsive: [
					 		{
					 			breakpoint: 992,
					 			settings: {
					 			draggable: true }
					 		},
					 		{
					 			breakpoint: 768,
					 			settings: {
								draggable: true }
					 		},
					 		{
					 			breakpoint:480,
					 			settings: {
					 			draggable: true }
					 		}
					 	]
					});
				}
			}
		},
		articleAccordionCollapse: {
			selector: '.airkit_article-accordion',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.each(function(){

					var $$ = $(this);

					var hideInitial = $$.find('.panel-collapse.in').attr( 'aria-labelledby' );
					
					$('#' + hideInitial).hide();

					$$.find('.panel-heading').on('click', function(){
						var panelHeading = $(this);

							panelHeading.slideUp(400);
							$$.find('.panel-heading').not(this).slideDown(400);
					});

					$$.find('.show-heading').on('click', function(){
						var panelCollapse = $(this).closest('.panel-collapse'),
							panelHeading  = panelCollapse.attr( 'aria-labelledby' );

						panelCollapse.collapse('hide');
						$('#' + panelHeading).slideDown(400);
					});

				});
			}
		},
		mosaicStyle_4_Height: {
			selector: '.mosaic-style-4',
			init: function() {
				var self = this,
					container = $(self.selector);

				self._onResize(container);

				_listenerEvent('resize', self, '_onResize', [container]);
			},
			_onResize: function(container) {
				container.each(function(){

					$(this).children().each(function(){
						var $$ = $(this),
							sectionHeight = $$.find('article figure.image-holder').outerHeight();

						if( win.width() < 1024 ) {
							sectionHeight = 'auto';
						}

						$$.find('article header').css( 'height', sectionHeight );

					});

				});
			}
		},
		WooCommerce: {
			selector: '.single-product .woocommerce-tabs',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.addClass('ts-tab-container display-horizontal');
				container.find('.wc-tabs').addClass('nav nav-tabs').wrap('<div class="ts-tabs-nav"></div>');
			}
		},
		animatedParallaxImage: {
			selector: '.has-parallax-images',
			init: function() {
				var self = this,
					container = $(self.selector),
					items 	  = $(container).find('.airkit_image_parallax');

				$.each(items, function(){
					var elemRatio = $(this).attr('data-enllax-ratio');
					var elemDirection = $(this).attr('data-enllax-direction');
					$(this).enllax({
						ratio: elemRatio,
						direction: elemDirection
					});
				});
			}
		},
		searchBox: {
			selector: '#search-outer, .searchbox',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				self.LiveResults(container);

				container.find('.search-trigger').on('click', function(e){
					e.preventDefault();
					var target = $(this).attr('data-target');

					$doc.find(target).toggleClass('active');

					setTimeout(function(){
						$doc.find(target).find('[id^="keywords"]').focus();
					}, 100);
				});

				container.find('.search-close').on('click', function(e){
					e.preventDefault();
					var target = $(this).attr('data-target');
					
					$doc.find(target).removeClass('active');
					container.find('.ajax-live-results').removeClass('visible');
				});

				$body.keydown(function (e) {

					if( e.which == 27 ){
						var target = container.find('.search-close').attr('data-target');

						container.find(target).removeClass('active');
					}

				});
			},
			LiveResults: function(container) {
				var self = this;

				$doc.on( 'keydown', function ( e ) {
				    if ( e.keyCode === 27 ) { // ESC
				    	if ( container.find('.ajax-live-results').hasClass('visible') ) {
					        container.find('.ajax-live-results').removeClass('visible');
				    	}
				    }
				});

				$doc.on('click', '.ajax-live-results .close-btn', function(){
					container.find('.ajax-live-results').removeClass('visible');
				});

				container.each(function(){
					var $$ = $(this),
						$form = $$.find('form.searchbox-live-results-form'),
						$input_search_keyword = $$.find('input[name="s"]');

					if ( $form.length <= 0 ) return;

					var nonce = $$.find('input[name="wpnonce"]').val(),
						event_keyCode = 0;

					var not_allowed_keys = [9, 16, 17, 18, 27];

					//setup data array
					var data = {
						action: 'airkit_search_live_results',
						security: nonce,
						search_keyword: '',
						event_type: '',
					}

					$$.find('[id^="keywords"]').on('change keyup', function(event) {
						var access = false;
						event_keyCode = event.keyCode;

						$.each($form.serializeArray(), function(index, item){

							if ( item.name == 's' ) {
								data['search_keyword'] = item.value;
							}

						});

						//when user typing in search keyword input, show ajax loader
						//don't show ajax loader when keyCode = [Tab][Shift][Ctrl][Alt][Esc]
						if ( event.type == 'keyup' && event.target.name == 's' && !_.contains( not_allowed_keys, event_keyCode ) ) {
							data['event_type'] = 'search';
							$input_search_keyword.parent().addClass('loading');
						}

					});

					//user is "finished typing"
					$input_search_keyword.donetyping(function(){

						$(this).parent().removeClass('loading');

						//don't make request when keyCode = [Tab][Shift][Ctrl][Alt][Esc]
						if ( !_.contains( not_allowed_keys, event_keyCode ) ) {
							self.ajaxLiveResults($$, data);
						}
					}, 500);

				});
			},
			ajaxLiveResults: function(element, data) {
				var $ajax_posts = element.find('.ajax-live-results'),
					$input_search_keyword = element.find('input[name="s"]');

				$.post(gowatch.ajaxurl, data, function(data){

					element.find('.ajax-results').html(data.found_posts);

					//we have some posts to show
					if ( data.response == '1' ) {

			            if ( data['event_type'] == 'filter' ) {

							$ajax_posts.removeClass('visible');

						} else {

							$ajax_posts.addClass('visible');

							//append the articles HTML
							$ajax_posts.html('').append('<div class="row">' + data.view_articles_html + '</div><button type="button" class="close-btn"><i class="icon-close"></i> '+ airkit_close_results_text +'</button>');
						}


					} else {
						$ajax_posts.addClass('visible');
						$ajax_posts.html('<h5 class="nothing-message">'+ gowatch.nothing_msg +'</h5>');
					}

				}).done(function(){
					$input_search_keyword.parent().removeClass('loading');
					AIRKIT.lazyLoad.control(element);
					element.addClass('loaded');
				});
			}
		},
		videoFancybox: {
			selector: '.ts-video-fancybox.embed',
			init: function() {
				var self = this,
					container = $(self.selector);
		
				container.fancybox();
			}
		},
		singleVideo2Load: {
			selector: '.video-style-2 .video-figure-content',
			init: function() {
				var self = this,
					container = $(self.selector);
				
				jQuery(window).load(function(){
					jQuery( container ).addClass('loaded');
				});
			}
		},
		sidebar: {
			selector: '.ts-sidebar-element.sidebar-is-sticky, .sticky-sidebars-enabled #secondary, .archive-sticky-sidebar',
			init: function() {
				var self = this,
					container = $(self.selector);

				$('.sticky-sidebars-enabled #secondary').theiaStickySidebar({
			    	additionalMarginTop: AIRKIT.getStickyMargin.control() + 20,
			    	containerSelector: '.post-container',
			    	minWidth: 961,
			    });

				$('.ts-sidebar-element.sidebar-is-sticky').theiaStickySidebar({
					containerSelector: '.site-section',
			    	additionalMarginTop: AIRKIT.getStickyMargin.control() + 40,
			    	minWidth: 961,
			    });

				$('.archive-sticky-sidebar').theiaStickySidebar({
			    	additionalMarginTop: AIRKIT.getStickyMargin.control() + 20,
			    	minWidth: 961,
			    });
			}
		}

	} // end ELEMENTS variable
	
	window.AIRKIT = AIRKIT;
	window.AIRKIT_EL = AIRKIT_EL;

	$doc.ready(function() {
		AIRKIT.init();
		AIRKIT_EL.init();

		$('.sticky-post-meta').fixer();

	});

	win.load(function() {
		// Hide preloader
		if ( $('.airkit_page-loading').length ) {
			setTimeout(function() {
				$('.airkit_page-loading').addClass('shown');
			}, 900);
			setTimeout(function(){
				$('.airkit_page-loading').fadeOut(500);
			}, 1100);
		}

		if ( isMobile() == false ) {
			$body.addClass('desktop-version');
		};

		$body.addClass('window-loaded');

		if ( $(AIRKIT_EL.flexSlider.selector).length ) {
			AIRKIT_EL.flexSlider.init();
		}
	});

	/*
	 *
	 *	ProtoType functions
	 *
	 */
	$.fn.extend({
		fixer: function(options) {
			var defaults = {
			    gap: 0,
			    horizontal: false,
			    scroll: true,
			    isFixed: $.noop
			};

			options = $.extend({}, defaults, options);

			var hori = options.horizontal,
			    cssPos = hori ? 'left' : 'top',
			    myGutter = 60;

			var supportSticky = function(elem) {
			    var prefixes = ['', '-webkit-', '-moz-', '-ms-', '-o-'], prefix;
			    return false;
			};

			var control = function(elem) {
				var style = elem.style,
					$this = $(elem),
					$parent = $this.parent().parent();

				if ( $this.hasClass('sticky-post-meta') ) {
					$parent = $this.parent('.post-content');
				}

				if ( $this.hasClass('post-gallery-directions') ) {
					$parent = $this.parent('.airkit_post-gallery.list-post-gallery.is-visible');
				}

				if ( $parent.length <= 0 ) {
					return;
				}

			    var scrollPos = win[hori ? 'scrollLeft' : 'scrollTop'](),
			        elemSize = $this[hori ? 'outerWidth' : 'outerHeight'](),
			        parentPos = $parent.offset()[cssPos],
			        parentSize = $parent[hori ? 'outerWidth' : 'outerHeight']();

			    if (scrollPos >= parentPos - 1 && (parentSize + parentPos - myGutter) >= (scrollPos + elemSize)) {
			    	
			        style.position = 'relative';
			        style[cssPos] = (scrollPos - parentPos) + options.gap + 'px';
			        options.isFixed();
			        $this.addClass('is-sticky');

			    } else if (scrollPos < parentPos) {

			    	$this.removeClass('scrolled is-sticky');
			        style.position = 'relative';
			        style[cssPos] = 0;

			    } else {

			        style.position = 'relative';
			        style[cssPos] = parentSize - elemSize - myGutter + 'px';
			        $this.removeClass('is-sticky');

			    }
			}

		    return this.each(function() {
		        var elem = this,
		        	style = this.style;

		        if (supportSticky(this)) {

		            style[cssPos] = options.gap + 'px';
		            return;

		        }

		        if ( options.scroll ) {
			        win.on('scroll', function() { control(elem) });
		        } else {
		        	control(elem);
		        }
		    });
		},
		isOnScreen: function(){
			var viewport = {
				top : win.scrollTop(),
				left : win.scrollLeft()
			};
			
			viewport.right = viewport.left + win.width();
			viewport.bottom = viewport.top + win.height();

			var bounds = this.offset();
			bounds.right = bounds.left + this.outerWidth();
			bounds.bottom = bounds.top + this.outerHeight();

			return (!(viewport.bottom < bounds.top || viewport.top > bounds.bottom));
		},
		outerHTML: function(s) {
		    return s
		        ? this.before(s).remove()
		        : jQuery("<p>").append(this.eq(0).clone()).html();
		},
		countTo: function() {
			var element = this;

			function execute() {

				element.each(function(){

					var item = $(this).find('.countTo-item');

					item.each(function(){

						var current = $(this),
							percent = current.find('.skill-level').attr('data-percent');

						if ( !current.hasClass('is-animated') ) {
							current.find('.skill-title').css({'color' : 'inherit'});
							if( element.hasClass('ts-horizontal-skills') ){
								current.find('.skill-level').animate({'width' : percent+'%'}, 800);
							} else {
								current.find('.skill-level').animate({'height' : percent+'%'}, 800);
							}
							current.addClass('is-animated');
						}

						if ( current.hasClass('is-animated') && element.attr('data-percentage') == 'true' && current.find('.percent').length < 1 ) {
							current.append('<span class="percent">'+percent+'%'+'</span>');
							current.find('.percent').css({'left' : percent+'%'}).delay(1600).fadeIn();
						};

						if ( percent == 100 ) {
							item.addClass('full');
						};

					})

				})

			}

			execute();

			return this;
		},
		TsProgressScroll: function(options) {
		    // This is the easiest way to have default options.
		    var settings = $.extend({
		        backgroundColor: "#000",
		        height: '10px',
		    }, options);

		    var mySelector = this.selector;

		    this.each(function () {

		        win.scroll(function () {

		            var offsetTop = parseInt( $(this).scrollTop() );
		            var parentHeight = parseInt( $(mySelector).parents('.article-progress-enabled').height() - win.height() );
		            var parentOffset = $(mySelector).parents('.article-progress-enabled').offset();
		            var vscrollwidth = (offsetTop - parentOffset.top) / parentHeight * 100;

		            $(mySelector).css({width: vscrollwidth + '%'});

		        });

		        $(mySelector).css({
		            backgroundColor: settings.backgroundColor,
		            height: settings.height,
		        });

		    });

		    return this;
		},
		//
		// $('#element').donetyping(callback[, timeout=1000])
		// Fires callback when a user has finished typing. This is determined by the time elapsed
		// since the last keystroke and timeout parameter or the blur event--whichever comes first.
		//   @callback: function to be called when even triggers
		//   @timeout:  (default=1000) timeout, in ms, to to wait before triggering event if not
		//              caused by blur.
		//
		donetyping: function(callback,timeout){
		    timeout = timeout || 1e3; // 1 second default timeout
		    var timeoutReference,
		        doneTyping = function(el){
		            if (!timeoutReference) return;
		            timeoutReference = null;
		            callback.call(el);
		        };
		    return this.each(function(i,el){
		        var $el = $(el);
		        // Chrome Fix (Use keyup over keypress to detect backspace)
		        // thank you @palerdot
		        $el.is(':input') && $el.on('keyup keypress paste',function(e){
		            // This catches the backspace button in chrome, but also prevents
		            // the event from triggering too preemptively. Without this line,
		            // using tab/shift+tab will make the focused element fire the callback.
		            if (e.type=='keyup' && e.keyCode!=8) return;
		            
		            // Check if timeout has been set. If it has, "reset" the clock and
		            // start over again.
		            if (timeoutReference) clearTimeout(timeoutReference);
		            timeoutReference = setTimeout(function(){
		                // if we made it here, our timeout has elapsed. Fire the
		                // callback
		                doneTyping(el);
		            }, timeout);
		        }).on('blur',function(){
		            // If we can, fire the event since we're leaving the field
		            doneTyping(el);
		        });
		    });
		},
		imgAdjustHeight: function() {
 
			var element = this;
			var $images = element.find('img');

			if ( $images.length ) {

				return $images.each(function(){

					var $$ = $(this);
					var original_height = $$.attr('height');
					var original_width = $$.attr('width');
					var wrap_width = $$.outerWidth();
			 
					if ( original_height ) {

						var ajusted_height = wrap_width * original_height / original_width;

						$$.css('height', ajusted_height);
					}

				});

			}
		}
		
	});

})(jQuery, this, _);


/*
 *
 *	Helpers functions
 *
 */
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

function deleteCookie(cname) {
    document.cookie = cname + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
};

function expireCookie( minutes, content ) {
	var date = new Date();
	var m = minutes;
	date.setTime(date.getTime() + (m * 60 * 1000));
	jQuery.cookie(content, m, { expires: date, path:'/' });
}

function isMobile() {
	try{ document.createEvent("TouchEvent"); return true; }
	catch(e){ return false; }
}

function _listenerEvent(event, context, targetFunc, args) {

	var handler = executeFunctionByName(targetFunc, context, args); // Call function by name

	// Create the listener function
	if ( event == 'scroll' ) {

		handler = _.throttle(function(){
			executeFunctionByName(targetFunc, context, args);
		}, 250); // Maximum run of once per 250 milliseconds

	} else if ( event == 'resize' ) {

		handler = _.debounce(function() {
			executeFunctionByName(targetFunc, context, args);
		}, 50); // Maximum run of once per 50 milliseconds

	}

	window.addEventListener(event, handler, false);
}

function executeFunctionByName(functionName, context, args) {
	args = args || [];
	var namespaces = functionName.split(".");
	var func = namespaces.pop();

	for(var i = 0; i < namespaces.length; i++) {
		context = context[namespaces[i]];
	}

	return context[func].apply(context, args);
}


/**
	The resizing function for the video single page
*/
function singleVideoResize() {
	var iframe 		  = jQuery('.videosingle iframe');
		singleVideo   = jQuery('.videosingle video');

	if ( singleVideo.length == 0 && iframe.length == 0 ) return;

	// If it's an embed from YouTube or vimeo (iframe)
	if ( iframe.length > 0 ) {
		var width 		  = jQuery('.videosingle iframe').attr('width'),
			height 		  = jQuery('.videosingle iframe').attr('height'),
			proportion    = width / height,
			parentWidth   = jQuery('.videosingle iframe').parent().parent().parent().width();
			parentHeight  = parentWidth / proportion + 30;

		jQuery('.videosingle').width( parentWidth ).attr('width', parentWidth);
		jQuery('.videosingle').height( parentHeight ).attr('height', parentHeight);

	} else if ( singleVideo.length > 0 ) {
		// Code for MP4 uploads
		var proportion    = 1.777777777777778, //Harcoded the 16:9 format for the videos
			parentWidth   = jQuery('.videosingle video').parent().parent().width();
			parentHeight  = parentWidth / proportion;

		jQuery('.videosingle').width( parentWidth ).attr('width', parentWidth);
		jQuery('.videosingle').height( parentHeight ).attr('height', parentHeight);

	}

}

jQuery(window).on('load resize orientationChange', function(){
	singleVideoResize();
});

//end.