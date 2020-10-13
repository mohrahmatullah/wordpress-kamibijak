(function($) {
	"use strict";

	/* ==============================================
	HEADER AFFIX -->
	=============================================== */
	/* Activate sticky menu. Get last menu from header, which should be a horizontal menu. */
	var sticky = jQuery('.ts-sticky-menu-enabled header .airkit_horizontal-menu').last();

	if( sticky.length && jQuery(window).width() > 768 ) {

		sticky.affix({
		    offset: {
		      	top: sticky.offset().top,
		    }
		});

		if( sticky.hasClass('affix') ) {
			sticky.find('.navbar').addClass('container');
			sticky.parent().height( sticky.height() );			
		}
		
		sticky.on( 'affixed.bs.affix', function() {
			sticky.find('.navbar').addClass('container');
			sticky.parent().height( sticky.height() );
		});

		sticky.on( 'affixed-top.bs.affix', function() {
			sticky.find('.navbar').removeClass('container');
		});
	}
	

	/* ==============================================
	TABBED HOVER -->
	=============================================== */
	jQuery('.airkit_menu .nav-pills > li:first-child').find('a').tab('show');

  	jQuery('.airkit_menu .nav-pills > li ').hover( function(){

	    if ( jQuery(this).hasClass('hoverblock') ) {

	    	return;

	    } else {
	      	// jQuery(this).find('a').tab('show');
	      	//fb
	      	jQuery(this).addClass('active');
	      	jQuery(this).siblings().removeClass('active');
	      	var go = jQuery(this).find('a').attr('href'),
	      		pane = jQuery(this).closest('.airkit_menu').find(go)

	      		pane.addClass('active');
	      		pane.siblings().removeClass('active');

	    }
  	});

  	jQuery(document).ready(function(){

  		jQuery('.airkit_menu').each(function(){
	      	var go = jQuery(this).find('.nav-pills > li.active').find('a').attr('href'),
	      		pane = jQuery(this).find(go);

	      		pane.addClass('active');
	      		pane.siblings().removeClass('active');  		
  		});

  	});

  	jQuery('.nav-tabs > li').find('a').click( function() {

    	jQuery(this).parent().siblings().addClass('hoverblock');
  	});

	/* ==============================================
	MENU HOVER -->
	=============================================== */
	jQuery(".hovermenu").hoverIntent({
	    over: function() { 

			var menuItem = jQuery(this);

			if( jQuery(window).width() > 768 ) {
				jQuery(menuItem).children('.dropdown-menu').show();
				jQuery(menuItem).addClass('open');
			}

			AIRKIT.lazyLoad.control(menuItem);
		},
	    out: function() {
			var menuItem = jQuery(this);
			jQuery(menuItem).removeClass('open');

			if( jQuery(window).width() > 768 ) {
				jQuery(menuItem).children('.dropdown-menu').fadeOut(250);
			}
		},
	    selector: '.dropdown',
	    timeout: 500
	});

	/* ==============================================
	MENU CLICKABLE for HORIZONTAL -->
	=============================================== */
	jQuery('.airkit_horizontal-menu.clickablemenu .dropdown').each(function() {

		jQuery(this).click('show.bs.dropdown', function(e) {

		    var $dropdown = jQuery(this).find('.dropdown-menu'),
		    	orig_margin_top = parseInt( $dropdown.css('margin-top') );
		});
		
	});


	/* ==============================================
	MENU CLICKABLE for VERTICAL -->
	=============================================== */

	jQuery('.airkit_vertical-menu .navbar-nav > li.menu-item-has-children > a').on( 'click', function(e) {

		e.preventDefault();

		jQuery(this).parent().children('.dropdown-menu').hide();
		jQuery(this).parent().siblings('.open').removeClass('open');
		jQuery(this).parent().toggleClass('open');

		AIRKIT.lazyLoad.control(jQuery(this).parent());

	    return false;

	});

	jQuery('.airkit_vertical-menu .dropdown-menu li').click(function(e){

		e.stopPropagation();

	});

})(jQuery);
