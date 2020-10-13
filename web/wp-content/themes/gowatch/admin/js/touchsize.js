jQuery(document).ready(function($){

	jQuery( 'a.debug-report' ).click( function() {

		var report = '';

		jQuery( '.airkit-system-status table thead, .airkit-system-status tbody' ).each( function() {

			var label;

			if ( jQuery( this ).is( 'thead' ) ) {

				label = jQuery( this ).find( 'th:eq(0)' ).data( 'export-label' ) || jQuery( this ).text();
				report = report + '\n### ' + jQuery.trim( label ) + ' ###\n\n';

			} else {

				jQuery( 'tr', jQuery( this ) ).each( function() {

					var label           = jQuery( this ).find( 'td:eq(0)' ).data( 'export-label' ) || jQuery( this ).find( 'td:eq(0)' ).text(),
					    theName         = jQuery.trim( label ).replace( /(<([^>]+)>)/ig, '' ), // Remove HTML.
					    theValueElement = jQuery( this ).find( 'td:eq(2)' ),
					    theValue,
					    valueArray,
					    output,
					    tempLine;

					if ( jQuery( theValueElement ).find( 'img' ).length >= 1 ) {
						theValue = jQuery.trim( jQuery( theValueElement ).find( 'img' ).attr( 'alt' ) );
					} else {
						theValue = jQuery.trim( jQuery( this ).find( 'td:eq(2)' ).text() );
					}
					valueArray = theValue.split( ', ' );

					if ( valueArray.length > 1 ) {

						// If value have a list of plugins ','
						// Split to add new line.
						output   = '';
						tempLine = '';
						jQuery.each( valueArray, function( key, line ) {
							tempLine = tempLine + line + '\n';
						});

						theValue = tempLine;
					}

					report = report + '' + theName + ': ' + theValue + '\n';
				});

			}
		});
		try {
			jQuery( '#debug-report' ).slideDown();
			jQuery( '#debug-report textarea' ).val( report ).focus().select();
			jQuery( this ).parent().fadeOut();
			return false;
		} catch ( e ) {
		}

		return false;
	});

	jQuery('#airkit-license-saver').on('click', function(event){

		event.preventDefault();

		var item = jQuery(this);

		item.html('Saving...');
		var license = $('#airkit-license-code').val();

		var data = {
			action: 'airkit_save_ls_code',
			license: license
		};

		$.post(ajaxurl, data, function(data, textStatus, xhr) {
			if (data.status == 'success'){
				item.html('Success! Closing in 3 seconds...').removeClass('button-primary').addClass('disabled').css('background','#00ba01 !important');
				setTimeout(function(){
					jQuery('.key-notice').remove();

				},4000);
			} else {
				item.html('Error!');
			}
		}, 'json');

		return false;
	});

	jQuery(document).on('change', '#ts-feed', function(){
		var selectedItem = jQuery(this).val();

		jQuery('.selector-item').addClass('hidden');

		jQuery('#for-' + selectedItem).removeClass('hidden');
	});

	jQuery(document).on('click', '.ts-select-all-videos', function(){

		console.log(jQuery(this).attr('checked'));
		if( jQuery(this).attr('checked') == 'checked' ){
			jQuery('.available-import-item').attr('checked', 'checked');
		} else {
			jQuery('.available-import-item').removeAttr('checked');
		}
	});

	// Import button triggered
	jQuery( document ).on( 'click', '.ts-import-start', function() {
		jQuery(this).hide();
		jQuery(this).before('Import process started. Please wait!');
	});

	// Trigger options.
	jQuery( document ).on( 'change', '.airkit_trigger-options', function() {
		airkit_triggerOptions();
	});

	jQuery( '.airkit_trigger-options' ).each( function() {
		airkit_triggerOptions();
	});

	// Show / hide options sidebars in layout tab global options.
	jQuery(document).on('change', '.ts-sidebar-display', function(){
		airkit_sidebar( jQuery(this) );
	});

	// Show/hide custom editor for header and footer
	jQuery(document).on('change', '#ts-predefined-style', function(){

		var location = jQuery('#save-header-footer').attr('data-location');
		var selector = '.' + location + '-options__' + jQuery(this).val();

		jQuery(selector).removeClass('hidden');
		jQuery(selector).siblings().addClass('hidden');

	});

	jQuery('.ts-sidebar-display').each(function(){
		airkit_sidebar( jQuery(this) );
	});

	jQuery('.import-selector').click(function(){
		var selected = jQuery(this).attr('data-import-select');
		jQuery(this).parent().parent().find('#demo-style option[value="' + selected + '"]').attr('selected','selected').siblings().removeAttr('selected');
		jQuery(this).addClass('selected').siblings().removeClass('selected');
	});

	jQuery(document).on('click', '.typography-toggler', function(){
		jQuery(this).prev().slideToggle();
	});

	if ( jQuery('[name="logo_type"]').length > 0 ) {

		airkit_logo( jQuery('[name="logo_type"]').val() );

		jQuery(document).on('change', '[name="logo_type"]', function() {

			airkit_logo( jQuery(this).val() );
		});
	}

	if ( jQuery('[name="font"]').length > 0 ) {
		google_fonts();
	}

	jQuery(document).on('change', '[name="airkit_post_settings[bg_type]"]', function(){
		airkit_backgroundType();
	});

	airkit_backgroundType();

    jQuery("#ts-slider-source").change(function(){
        if( jQuery(this).val() == "custom-slides" ){
        	jQuery("#ts_slides").removeClass('hide-if-js');
            jQuery("#ts_slides").css("display", "");
            jQuery("#ts-slider-nr-of-posts").css("display", "none");
        }else{
        	jQuery("#ts_slides").removeClass('hide-if-js');
            jQuery("#ts_slides").css("display", "none");
            jQuery("#ts-slider-nr-of-posts").css("display", "");
        }
    });

    if( jQuery("#ts-slider-source").val() == "custom-slides" ){
    	jQuery("#ts_slides").removeClass('hide-if-js');
        jQuery("#ts_slides").css("display", "");
        jQuery("#ts-slider-nr-of-posts").css("display", "none");
    } else {
    	jQuery("#ts_slides").removeClass('hide-if-js');
        jQuery("#ts_slides").css("display", "none");
        jQuery("#ts-slider-nr-of-posts").css("display", "");
    }

	jQuery(document).on('click', '.ts-show-options', function(event){
		event.preventDefault();
		if( jQuery(this).next().hasClass('active') ){
			jQuery(this).parent().find('.ts-hide-options').css('display', 'none');
			jQuery(this).next().css('display', 'none').removeClass('active');
			jQuery(this).show();
		}else{
			jQuery(this).next().css('display', '').addClass('active');
			jQuery(this).parent().find('.ts-hide-options').css('display', '');
			jQuery(this).hide();
		}
	});

	jQuery(document).on('click', '.ts-hide-options', function(){
		jQuery(this).parent().find('.ts-show-options').trigger('click');
	});

	jQuery('.ts-type-font').change(function(){
	    var fontOption = jQuery(this).parent('div').find('.ts-font-options-parent').html();
	    if( jQuery(this).val() == 'google' ){
	        jQuery(this).parent('div').find('.ts-google-fonts').css('display', '');
	        jQuery(this).parent('div').find('.ts-google-fonts').find('.ts-font-options').remove();
	        jQuery(this).parent('div').find('.ts-google-fonts').find('.ts-font-name').after(fontOption);
	        jQuery(this).parent('div').find('.ts-custom-font').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-custom-font').find('.ts-font-options').remove();
	        jQuery(this).parent('div').find('.ts-logo-image').css('display', 'none');
	    }else if( jQuery(this).val() == 'custom_font' ){
	        jQuery(this).parent('div').find('.ts-google-fonts').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-custom-font').find('.ts-font-options').remove();
	        jQuery(this).parent('div').find('.ts-custom-font').css('display', '').prepend(fontOption);
	        jQuery(this).parent('div').find('.ts-google-fonts').find('.ts-font-options').remove();
	        jQuery(this).parent('div').find('.ts-logo-image').css('display', 'none');
	    }else if( jQuery(this).val() == 'image' ){
	        jQuery(this).parent('div').find('.ts-google-fonts').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-custom-font').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-logo-image').css('display', '');
	    }else{
	        jQuery(this).parent('div').find('.ts-google-fonts').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-custom-font').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-font-options-parent').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-logo-image').css('display', 'none');
	    }
	});
	jQuery('.ts-type-font').each(function(){
	    var fontOption = jQuery(this).parent('div').find('.ts-font-options-parent').html();
	    if( jQuery(this).val() == 'google' ){
	        jQuery(this).parent('div').find('.ts-google-fonts').css('display', '');
	        jQuery(this).parent('div').find('.ts-google-fonts').find('.ts-font-options').remove();
	        jQuery(this).parent('div').find('.ts-custom-font').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-google-fonts').find('.ts-font-name').after(fontOption);
	        jQuery(this).parent('div').find('.ts-logo-image').css('display', 'none');
	    }else if( jQuery(this).val() == 'custom_font' ){
	        jQuery(this).parent('div').find('.ts-google-fonts').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-custom-font').find('.ts-font-options').remove();
	        jQuery(this).parent('div').find('.ts-custom-font').css('display', '').prepend(fontOption);
	        jQuery(this).parent('div').find('.ts-logo-image').css('display', 'none');
	    }else if( jQuery(this).val() == 'image' ){
	        jQuery(this).parent('div').find('.ts-google-fonts').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-custom-font').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-logo-image').css('display', '');
	    }else{
	        jQuery(this).parent('div').find('.ts-google-fonts').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-custom-font').css('display', 'none');
	        jQuery(this).parent('div').find('.ts-logo-image').css('display', 'none');
	    }
	});

	jQuery('#ts_submit_button').click(function(){
	    jQuery('.ts-font-options-parent').each(function(){
	        jQuery(this).remove();
	    });
	});

	if ( $('#ts-theme-bg-picker').length ) {
		$('#ts-theme-bg-picker').hide();
		$('#ts-theme-bg-picker').farbtastic("#theme-bg-color");

		$("#theme-bg-color").click(function(e){
			e.stopPropagation();
			$('#ts-theme-bg-picker').show();
		});

		$('body').click(function() {
			$('#ts-theme-bg-picker').hide();
		});
	}

	if ( $('#ts-primary-picker').length ) {
		$('#ts-primary-picker').hide();
		$('#ts-primary-picker').farbtastic("#ts-primary-color");

		$("#ts-primary-color").click(function(e){
			e.stopPropagation();
			$('#ts-primary-picker').show();
		});

		$('body').click(function() {
			$('#ts-primary-picker').hide();
		});
	}

	if ( $('.colors-section-picker-div').length ) {
		airkit_restartColorPicker();
	}

	if ( $('#ts-secondary-picker').length ) {
		$('#ts-secondary-picker').hide();
		$('#ts-secondary-picker').farbtastic("#ts-secondary-color");

		$("#ts-secondary-color").click(function(e){
			e.stopPropagation();
			$('#ts-secondary-picker').show();
		});

		$('body').click(function() {
			$('#ts-secondary-picker').hide();
		});
	}

	/************************************
	 * Theme options
	 ************************************/

	/**
	 * Theme background customization
	 */

	airkit_backgroundOptions( $('#ts-theme_custom_bg') );

	function airkit_backgroundOptions( such ) {

		if ( such.val() == 'pattern' ) {

			jQuery('[name="theme_bg_pattern"]').closest('.ts-option-line').show();
			jQuery('#ts-theme_bg_color').closest('.ts-option-line').hide();
			jQuery('[name="bg_image"]').closest('.ts-option-line').hide();

		} else if ( such.val() == 'color' ) {

			jQuery('[name="theme_bg_pattern"]').closest('.ts-option-line').hide();
			jQuery('[name="bg_image"]').closest('.ts-option-line').hide();
			jQuery('#ts-theme_bg_color').closest('.ts-option-line').show();

		} else if ( such.val() == 'image' ) {

			jQuery('[name="theme_bg_pattern"]').closest('.ts-option-line').hide();
			jQuery('[name="bg_image"]').closest('.ts-option-line').show();
			jQuery('#ts-theme_bg_color').closest('.ts-option-line').hide();

		} else {

			jQuery('#ts-patterns-option').hide();
			jQuery('[name="theme_bg_pattern"]').closest('.ts-option-line').hide();
			jQuery('[name="bg_image"]').closest('.ts-option-line').hide();
			jQuery('#ts-theme_bg_color').closest('.ts-option-line').hide();

		}
	}

	$('#ts-theme_custom_bg').change(function(event) {

		airkit_backgroundOptions( jQuery(this) );

	});

	/**
	 * Overlay stripes/dotts effect for images
	*/

	var airkit_overlay_effect = $('#overlay-effect-for-images option:selected').val();

	if (airkit_overlay_effect == 'y') {
		$('#overlay-effects').show();
	} else {
		$('#overlay-effects').css({'display':'none'});
	}

	$('#overlay-effect-for-images').change(function(event) {
		var airkit_overlay_effect = $(this).find('option:selected').val();
		if (airkit_overlay_effect == 'y') {
			$('#overlay-effects').show();
		} else {
			$('#overlay-effects').css({'display':'none'});
		}
	});

	/**
	 * Theme logo
	 */
	var airkit_logo_style = $('.ts-logo-type option:selected').val();
	airkit_setLogoStyle( airkit_logo_style );

	$('.ts-logo-type').change(function(event) {
		var selected_style = $(this).find('option:selected').val();
		airkit_setLogoStyle(selected_style);
	});

	function airkit_setLogoStyle (style) {
		if (style === 'image') {
			$('#ts-logo-fonts').css({'display':'none'});
			$('#ts-logo-image').show();
		} else {
			$('#ts-logo-fonts').show();
			$('#ts-logo-image').css({'display':'none'});
		}
	}

	/**
	 * Typography - Headings styles
	 */
	var airkit_headings_style = $('.ts-typo-headings option:selected').val();
	airkit_setHeadingsStyle( airkit_headings_style );

	$('.ts-typo-headings').change(function(event) {
		var selected_style = $(this).find('option:selected').val();
		airkit_setHeadingsStyle(selected_style);
	});

	function airkit_setHeadingsStyle (style) {
		var tags = ['h1', 'h2', 'h3', 'h4', 'h5'];

		if (style === 'std') {

			$('#ts-typo-headings-gfonts').css({'display':'none'});

			$('#custom-font').css({'display':'none'});

			jQuery(tags).each(function(i, tag){
				jQuery('#ts-typo-headings-' + tag + '-gfonts').closest('tr').css({'display': 'none'});
			});

		}else if (style === 'custom_font') {
			$('#ts-typo-headings-gfonts').css({'display':'block'});
			$('#fontchanger-headings').css({'display':'none'});
			$('.headings-subset-types').css({'display':'none'});
			$('#custom-font').css({'display':''});
			$('#headings-demo').css({'display':'none'});
			$('#headings-preview').css({'display':'none'});
			$('.logo-text-preview').css({'display':'none'});

			jQuery(tags).each(function(i, tag){
				jQuery('#ts-typo-headings-' + tag + '-gfonts').closest('tr').css({'display': 'none'});
			});

		} else {
			$('#ts-typo-headings-gfonts').css({'display':'none'});
			$('#custom-font').css({'display':'none'});
			$('#fontchanger-headings').css({'display':'block'});
			$('.headings-subset-types').css({'display':'block'});
			$('#headings-demo').css({'display':'block'});
			$('#headings-preview').css({'display':'block'});
			$('.logo-text-preview').css({'display':'block'});

			jQuery(tags).each(function(i, tag){
				jQuery('#ts-typo-headings-' + tag + '-gfonts').closest('tr').css({'display': ''});
			});
		}
	}

	/**
	 * Typography - Primary text styles
	 */
	var airkit_primary_text_style = $('.ts-typo-primary_text option:selected').val();
	airkit_setPrimaryTextStyle( airkit_primary_text_style );

	$('.ts-typo-primary_text').change(function(event) {
		var selected_style = $(this).find('option:selected').val();
		airkit_setPrimaryTextStyle(selected_style);
	});

	function airkit_setPrimaryTextStyle (style) {
		if (style === 'std') {
			$('#ts-typo-primary_text-gfonts').css({'display':'none'});
			$('#custom-primary-font').css({'display':'none'});

		} else if(style === 'custom_font') {
			$('#ts-typo-primary_text-gfonts').css({'display':'block'});
			$('#fontchanger-primary_text').css({'display':'none'});
			$('#custom-primary-font').css({'display':'block'});
			$('.primary_text-subset-types').css({'display':'none'});
			$('.primary-preview').css({'display':'none'});
			$('#primary_text-demo').css({'display':'none'});
			$('#primary_text-preview').css({'display':'none'});
		} else{
			$('#ts-typo-primary_text-gfonts').show();
			$('#fontchanger-primary_text').css({'display':'block'});
			$('.primary_text-subset-types').css({'display':'block'});
			$('#custom-primary-font').css({'display':'none'});
			$('.primary-preview').css({'display':'block'});
			$('#primary_text-demo').css({'display':'block'});
			$('#primary_text-preview').css({'display':'block'});
		}
	}

	/**
	 * Typography - Secondary text styles
	 */
	var airkit_secondary_text_style = $('.ts-typo-secondary_text option:selected').val();
	airkit_setSecondaryTextStyle( airkit_secondary_text_style );

	$('.ts-typo-secondary_text').change(function(event) {
		var selected_style = $(this).find('option:selected').val();
		airkit_setSecondaryTextStyle(selected_style);
	});

	function airkit_setSecondaryTextStyle (style) {
		if (style === 'std') {
			$('#ts-typo-secondary_text-gfonts').css({'display':'none'});
			$('#custom-secondary-font').css({'display':'none'});
		} else if(style === 'custom_font'){
			$('#ts-typo-secondary_text-gfonts').show();
			$('#custom-secondary-font').css({'display':'block'});
			$('#fontchanger-secondary_text').css({'display':'none'});
			$('.logo-secundary-preview').css({'display':'none'});
			$('#secondary_text-demo').css({'display':'none'});
		} else {
			$('#ts-typo-secondary_text-gfonts').show();
			$('#custom-secondary-font').css({'display':'none'});
			$('#fontchanger-secondary_text').css({'display':'block'});
			$('.logo-secundary-preview').css({'display':'block'});
			$('#secondary_text-demo').css({'display':'block'});
		}
	}

	/**
	 * Single post - Enable related posts
	 */
	var airkit_related_posts = $('.ts-related-posts option:selected').val();
	airkit_setRelatedPosts( airkit_related_posts );

	$('.ts-related-posts').change(function(event) {
		var related_posts = $(this).find('option:selected').val();
		airkit_setRelatedPosts( related_posts );
	});

	function airkit_setRelatedPosts (style) {
		if (style === 'n') {
			$('#ts-related-posts-options').css({'display':'none'});
		} else {
			$('#ts-related-posts-options').show();
		}
	}


	$('#enable_facebook_box').change(function(event) {
		if ( $(this).val() === 'y' ) {
			$('#facebook_page').removeClass('hidden');
		} else {
			$('#facebook_page').addClass('hidden');
		}
	});


	// Get ptterns
	$('#ts-get-patterns').on('click', function(event) {
		event.preventDefault();

		var such = $(this),
			data = {
				action : 'ts_get_patterns',
				nonce  : gowatchAdmin.Nonce
			};

		$.post(ajaxurl, data, function(data) {
			such.before(data);
			such.remove();
		});
	});

	jQuery(document).on('click', '.ts-select-pattern li', function(e){
		e.preventDefault();

		$('.ts-select-pattern').find('.selected').removeClass('selected');

		$(this).addClass('selected');

		var such = $(this),
			file = such.find('img').data('option'),
			url = such.find('img').attr('src');

		if ( $('.ts-preview-pattern').length == 0 ) {
			$('[name="theme_bg_pattern"]').before('<img src="' + url + '" class="ts-preview-pattern">');
		} else {
			$('.ts-preview-pattern').attr('src', url);
		}

		$('[name="theme_bg_pattern"]').val(file);

	});

	/**
	 * Create new sidebar
	 */
	$('#ts_add_sidebar').on('click', function(event) {
		event.preventDefault();
		var sidebar_name = $('#airkit_sidebar_name').val();

		var data = {
			action: 'ts_add_sidebar',
			airkit_sidebar_name: sidebar_name
		};

		$.post(ajaxurl, data, function(data, textStatus, xhr) {
			if (data.success == 1) {
				var html = '<div><span class="dynamic-sidebar">'+data.sidebar.name+'</span><span><a href="#" class="ts-remove-sidebar" id="'+data.sidebar.id+'">Delete</a></span></div>';
				$('#airkit_sidebar_name').val('');
				$('#ts-sidebars').append($(html));
			} else {
				alert(data.message);
			}
		}, 'json');
	});

	/**
	 * Removing sidebar
	 */
	$(document).on('click', '.ts-remove-sidebar', function(event) {
		event.preventDefault();
		var sidebar = $(this);
		var sidebar_id = sidebar.attr('id');

		var data = {
			action: 'ts_remove_sidebar',
			airkit_sidebar_id: sidebar_id
		};

		$.post(ajaxurl, data, function(data, textStatus, xhr) {
			if (data.result == 1){
				sidebar.parent().parent().remove();
			}
		}, 'json');
	});

	// Show/Hide options for sidebar

	jQuery('#page-sidebar-position').change(function(){
		var position_val = jQuery(this).val();
		if ( position_val != 'none' ) {
			jQuery('#airkit_sidebar_size').show();
			jQuery('#airkit_sidebar_sidebars').show();
		} else{
			jQuery('#airkit_sidebar_size').hide();
			jQuery('#airkit_sidebar_sidebars').hide();
		}
		//jQuery('#page-sidebar-position').trigger('change');
	});
	if ( jQuery('#page-sidebar-position').val() != 'none' ) {
		jQuery('#airkit_sidebar_size').show();
		jQuery('#airkit_sidebar_sidebars').show();
	} else{
		jQuery('#airkit_sidebar_size').hide();
		jQuery('#airkit_sidebar_sidebars').hide();
	}

    // Options > Layouts > Blog page
    var blogDisplayMode = $('.blog-last-posts-display-mode-options>div'),
    blogDisplayModeFirstElement = $(".blog-last-posts-display-mode").find('option:first').val(),

    // Options > Layouts > Category
    categoryDisplayMode = $('.category-last-posts-display-mode-options>div'),
    categoryDisplayModeFirstElement = $(".category-last-posts-display-mode").find('option:first').val(),

    // Options > Layouts > Author
    authorDisplayMode = $('.author-last-posts-display-mode-options>div'),
    authorDisplayModeFirstElement = $(".author-last-posts-display-mode").find('option:first').val(),

    // Options > Layouts > Search
    searchDisplayMode = $('.search-last-posts-display-mode-options>div'),
    searchDisplayModeFirstElement = $("#search-last-posts-display-mode").find('option:first').val(),

    // Options > Layouts > Archive
    archiveDisplayMode = $('.archive-last-posts-display-mode-options>div'),
    archiveDisplayModeFirstElement = $(".archive-last-posts-display-mode").find('option:first').val(),

    // Options > Layouts > Tags
    tagsDisplayMode = $('.tags-last-posts-display-mode-options>div'),
    tagsDisplayModeFirstElement = $(".tags-last-posts-display-mode").find('option:first').val();

	// Show selected element from builderElements and hide the rest
	function airkit_makeSelected (builderElements, selected) {
		$.each(builderElements, function(index, el) {
			var element = $(el);
			if (element.hasClass(selected)) {
				element.removeClass('hidden');
			} else {
				if( ! element.hasClass('hidden')) {
					element.addClass('hidden');
				}
			}
		});
	}

    $(document).on("change", ".blog-last-posts-display-mode", function(event) {
        var selected = 'last-posts-' + $(this).val();
        airkit_makeSelected(blogDisplayMode, selected);
    });

    $(document).on("change", ".category-last-posts-display-mode", function(event) {
        var selected = 'last-posts-' + $(this).val();
        airkit_makeSelected(categoryDisplayMode, selected);
    });

    $(document).on("change", ".author-last-posts-display-mode", function(event) {
        var selected = 'last-posts-' + $(this).val();
        airkit_makeSelected(authorDisplayMode, selected);
    });

    $(document).on("change", ".search-last-posts-display-mode", function(event) {
        var selected = 'last-posts-' + $(this).val();
        airkit_makeSelected(searchDisplayMode, selected);
    });

    $(document).on("change", ".archive-last-posts-display-mode", function(event) {
        var selected = 'last-posts-' + $(this).val();
        airkit_makeSelected(archiveDisplayMode, selected);
    });

    $(document).on("change", ".tags-last-posts-display-mode", function(event) {
        var selected = 'last-posts-' + $(this).val();
        airkit_makeSelected(tagsDisplayMode, selected);
    });

	jQuery('.display-layout-options').click(function(){
		jQuery(this).toggleClass('opened');
		jQuery(this).next().toggleClass('hidden');
	});

    var airkit_uploader = {};

    $( document ).on( 'click', '.ts-upload-file, .airkit_edit-image', function( e ) {
        e.preventDefault();

        if ( typeof wp.media.frames.file_frame == 'undefined' ) {

            wp.media.frames.file_frame = {};
        }


        var that = $( this ),
        	type  = that.data( 'media-type' ),
        	multiple = that.hasClass( 'airkit_edit-image' ) ? false : that.data( 'multiple' ),
        	parentOption = '';

        if ( that.hasClass( 'ts-upload-file' ) ) {

        	parentOption = that.parent().parent();

        } else {

        	parentOption = that.closest( '.airkit_selected-imgs' ).parent().parent();
        }

        // Extend the wp.media object
        airkit_uploader = wp.media({
            title: 'Choose item',
            button: {
                text: 'Choose item'
            },
            multiple: multiple
        });

		airkit_uploader.on( 'open', function() {

			var selection = airkit_uploader.state().get( 'selection' ),
				media_id = '';

			if ( that.hasClass( 'airkit_edit-image' ) ) {

				media_id = that.closest( 'li.image' ).data( 'id' );

			} else {

				media_id = parentOption.find( '.airkit_stock-attachments' ).val();
			}

			var attachment = wp.media.attachment( media_id );

			attachment.fetch();

		    selection.add( attachment );
	    });

        // When a file is selected, grab the URL and set it as the text field's value
        airkit_uploader.on( 'select', function() {

            var attachments = airkit_uploader.state().get( 'selection' ).toJSON(),
            	data = [];

            if ( ! that.hasClass( 'airkit_edit-image' ) ) {

            	for ( var i = 0; i < attachments.length; i++ ) {

            		if( 'video' == type ) {

            			var url = attachments[ i ].url;

            		} else {

	            		if ( typeof attachments[ i ].sizes.thumbnail == 'undefined' ) {

	            			var url = attachments[ i ].sizes.full.url;

	            		} else{

	            			var url = attachments[ i ].sizes.thumbnail.url;
	            		}

            		}

            	    data.push( attachments[ i ].id + '|' + url );
            	}

            } else {

            	var data = parentOption.find( '.airkit_stock-attachments' ).val().split( ',' ),
            		old_item = that.closest( 'li.image' ).data( 'id' ) + '|' + that.closest( 'li.image' ).data( 'url' ),
            		index = jQuery.inArray( old_item, data );

            		if ( typeof attachments[0].sizes.thumbnail == 'undefined' ) {

            			var new_item = attachments[0].id + '|' + attachments[0].sizes.full.url;

            		} else{

            			var new_item = attachments[0].id + '|' + attachments[0].sizes.thumbnail.url;

            		}            		


            	if ( index !== -1 ) {

            		data[ index ] = new_item;
            	}

            	parentOption.find( '.airkit_selected-imgs' ).html( '' );
            }

            var joined = data.join( ',' );


            if ( multiple == false ) {

            		if( 'video' == type ) {

            			var url = attachments[0].url;

            		} else {

	            		if ( typeof attachments[0].sizes.thumbnail == 'undefined' ) {

	            			var url = attachments[0].sizes.full.url;

	            		} else{

	            			var url = attachments[0].sizes.thumbnail.url;
	            		}

            		}
            	parentOption.find( '.ts-file-url' ).val( url );
            }

            parentOption.find( '.airkit_stock-attachments' ).val( joined );

            airkit_buildPreviewImgs();
        });

        //Open the uploader dialog
        airkit_uploader.open();
    });

	$(document).on('click', '.ts-remove-alert', function(event) {
		event.preventDefault();

		var alert = $(this).closest('.updated'),
			token = $(this).attr('data-token'),
			alertID = $(this).attr('data-alets-id'),
			data = {};

		data['action'] = 'airkit_hide_touchsize_alert';
		data['token'] = token;
		data['alertID'] = alertID;

		alert.fadeOut('slow');

		$.post( ajaxurl, data, function(data, textStatus, xhr) {
			if (data.status === 'ok') {
				alert.remove();
			}
		});
	});

	$(document).on('click', '.uploader-meta-field', function(event) {
        event.preventDefault();
        var this_element_ID = '#' + jQuery(this).attr('data-element-id');
        if (typeof wp.media.frames.file_frame == 'undefined') {
            wp.media.frames.file_frame = {};
        }

        var _this     = $(this),
            target_id = _this.attr('id'),
            media_id  = _this.closest('div').find(this_element_ID + '-media-id').val();

        //If the uploader object has already been created, reopen the dialog
        if (gowatch_custom_uploader[target_id]) {
            gowatch_custom_uploader[target_id].open();
            return;
        }

        //Extend the wp.media object
        gowatch_custom_uploader[target_id] = wp.media.frames.file_frame[target_id] = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            library: {
                type: 'image'
            },
            multiple: false,
            selection: [media_id]
        });

        //When a file is selected, grab the URL and set it as the text field's value
        gowatch_custom_uploader[target_id].on('select', function() {

            var attachment = gowatch_custom_uploader[target_id].state().get('selection').first().toJSON();
            var options = _this.closest('div');

            options.find(this_element_ID + '-input-field').val(attachment.url);
            options.find(this_element_ID + '-media-id').val(attachment.id);

            return;
        });

        //Open the uploader dialog
        gowatch_custom_uploader[target_id].open();
	});

    var hexDigits = new Array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");

    //Function to convert rgb format to hex color
    function rgb2hex(rgb) {
        rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
    }

    function hex(x) {
        return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
    }

	targetselect = jQuery("#page-sidebar-position");
    jQuery("#page-sidebar-position-selector li img").click(function(){
        custom_selectors(jQuery(this), targetselect);
        jQuery('#page-sidebar-position').trigger('change');
    });

    jQuery(document).on( 'click','.builder-element-icon-trigger-btn', function( e ) {

    	e.preventDefault();

		var $el = jQuery(this).parent().parent(),
			icons_container = $el.find('.ts-icons-container .builder-icon-list'),
			icons_select = icons_container.next('select'),
			icons = 'empty';

	if( !jQuery(this).hasClass('defined-icons-y') && icons_container.children('li').length == 0 ) {
	 	/*
		 * Only perform request to get the icons if there are no icons already appended. 
		 * Used to avoid duplicating icons, for items added with DUPLICATE. ( this elements already have icons ).
	 	 */		

		/*
		 * Add preloader class.
		 */
		 icons_container.addClass('loading');


		 /*
		  * @response
		  * obj containing .list - Icons list for image select.
		  *				   .val  - Options for select.
		  */

	        var data = {
	            action: 'airkit_get_icons',
	            nonce : gowatch.nonce,
	            selected: icons_select.attr( 'selected-value' ),
	        };    	 

	        jQuery.post(
	            gowatch.ajaxurl,
	            data,
	            function( response ) {

	            	icons = JSON.parse( response );
	            	icons_container.append( icons.list ).removeClass('loading');
	            	icons_select.append( icons.val );

	            }
	        );   

	    }

	        jQuery(this).parent().next().slideToggle();
    });



    jQuery( document ).on( 'click','.builder-icon-list li i', function( e ) {
    	e.preventDefault();

        jQuery(this).closest('.ts-icons-container').parent().find('.builder-element-icon-trigger-btn').find('i').remove();
        jQuery(this).closest('.ts-icons-container').parent().find('.builder-element-icon-trigger-btn').append("<i class='" + jQuery(this).attr('data-option') + "'></i>");
        jQuery(this).closest('.ts-icons-container').slideToggle();
    });

	jQuery(document).on('click', '.sortable-meta-element', function(event) {
	    event.preventDefault();
	    var arrow = jQuery(this).find('.tab-arrow');
	    if (arrow.hasClass('icon-down')) {
	        arrow.removeClass('icon-down').addClass('icon-up');
	    } else if (arrow.hasClass('icon-up')) {
	        arrow.removeClass('icon-up').addClass('icon-down');
	    }
	    jQuery(this).next().slideToggle();

	    if( jQuery(this).next().hasClass('hidden') ){
	    	jQuery(this).next().removeClass('hidden').addClass('active');
	    }else{
	    	jQuery(this).next().removeClass('active').addClass('hidden');
	    }

		var thisElem = jQuery(this).parent().attr('id');
		var thisContainer = jQuery(this).parent().parent().attr('id');

		jQuery('#'+thisContainer+' > li').not('#'+thisElem).each(function(){
			var allItems = jQuery(this).children('div:not(.sortable-meta-element)');
			jQuery(allItems).slideUp();
		});
	});

	// Remove item
	jQuery(document).on('click', '.remove-item', function(event) {
	    event.preventDefault();
	    jQuery(this).closest('li').remove();
	});

    jQuery('#ts_editor_default').remove();

	jQuery('#ts-generate-likes, #ts-reset-likes').click(function(){

		var such = jQuery(this);

		jQuery('.ts-succes-like').css('display', 'none');

		if ( jQuery('.ts-wait').length == 0 ) {
			such.after('<div style="display:none;" class="ts-wait">Please wait<span class="ts-wait-dots" style="font-size:30px;margin-left:5px;"></span></div>')
		}

		jQuery('.ts-wait').css('display', '');

		var count = 0;

		var dots = setInterval(function(){

		  count++;

		  jQuery('.ts-wait-dots').text(new Array(count % 10).join('.'));

		}, 500);

		var todo = jQuery(this).attr('id') == 'ts-reset-likes' ? 'reset' : 'generate';

		jQuery.post(ajaxurl, "action=ts_generate_like&nonce=" + gowatchAdmin.LikeGenerate + '&todo=' + todo, function(response){

			window.clearInterval(dots);

			jQuery('.ts-wait').remove();

			such.after(response);
		});
	});

	$(document).on('click', '.ts-remove-font', function(event) {
		event.preventDefault();

		var such = $(this),
			id   = such.data('id'),
			data;

		data = {
			action : 'ts_remove_font',
			nonce  : gowatchAdmin.Nonce,
			id     : id
		};

		$.post( ajaxurl, data, function(data) {

			if ( data.family ) {
				jQuery('.ts-select-fonts').find('[value="' + data.family + '"]').remove();
			}

			such.closest('.ts-item-font').remove();
		});
	});
	// Trigger AJAX Request for resetting options.
	jQuery( '[name="reset-settings"]' ).click(function(){

		var such = jQuery(this);

		jQuery( '.ts-succes-reset' ).css( 'display', 'none' );

		if ( jQuery( '.ts-wait' ).length == 0 ) {

			such.after( '<div style="display:none;" class="ts-wait">Please wait<span class="ts-wait-dots" style="font-size:30px;margin-left:5px;"></span></div>' );
		}

		jQuery( '.ts-wait' ).css( 'display', '' );

		var count = 0;

		var dots = setInterval( function() {

		  count++;

		  jQuery( '.ts-wait-dots' ).text( new Array( count % 10 ).join( '.' ) );

		}, 500 );

		jQuery.post( ajaxurl, "action=airkit_reset_settings&nonce=" + gowatchAdmin.Nonce, function( response ) {

			window.clearInterval( dots );

			jQuery( '.ts-wait' ).remove();

			such.after( response );
		});
	});

	// AJAX Flush transient
    jQuery('[name="fonts_transient"]').click(function(){

        var such = jQuery(this);

        such.addClass('btn-warning');
        such.val('Please wait');

        if ( jQuery( '.ts-wait' ).length == 0 ) {

            such.after( '<div style="display:none;" class="ts-wait">Please wait<span class="ts-wait-dots" style="font-size:30px;margin-left:5px;"></span></div>' );
        }

        jQuery.post( ajaxurl, "action=airkit_flush_fonts_transient&nonce=" + gowatchAdmin.Nonce, function( response ) {
            // success
            such.removeClass('btn-warning').addClass('btn-success');
            such.val('Done');
            jQuery( '.ts-wait' ).remove();

        });        
    });

    // AJAX Reinstall forms
    jQuery('[name="reinstall_forms"]').click(function(){

        var such = jQuery(this);

        such.addClass('btn-warning');
        such.val('Please wait');

        if ( jQuery( '.ts-wait' ).length == 0 ) {

            such.after( '<div style="display:none;" class="ts-wait">Please wait<span class="ts-wait-dots" style="font-size:30px;margin-left:5px;"></span></div>' );
        }

        jQuery.post( ajaxurl, "action=airkit_reinstall_forms&nonce=" + gowatchAdmin.Nonce, function( response ) {
            // success
            var response = JSON.parse( response );
            if( response.status == 'done' ) {
	            such.removeClass('btn-warning').addClass('btn-success');
	            such.val('Done');
            } else if( response.status == 'error' ) {
	            such.removeClass('btn-warning').addClass('btn-danger');
	            such.val('Error. See console.');
	            console.log('reinstall forms error:');
	            console.log( response.error );
            }

            jQuery( '.ts-wait' ).remove();

        });        
    });    

});


// Mega menu scripts
( function($) {

	var megaMenu = {

		recalcTimeout : false,

		change : function() {

			$('.airkit_menu-show-posts').change( function() {
				megaMenu.showOptionsPosts();
				megaMenu.recalc();
			});

			$('.airkit_menu-item-type').change( function() {
				megaMenu.recalc();
			});

			megaMenu.showOptionsPosts();
		},

		showOptionsPosts : function() {

			$('.airkit_menu-show-posts').each( function() {

				if ( $(this).val() == 'y' ) {

					$(this).closest('.menu-item').find('.airkit_depend-show-posts').show();

				} else {

					$(this).closest('.menu-item').find('.airkit_depend-show-posts').hide();
				}
			});
		},

		recalcInit: function() {

            $(document).on( 'mouseup', '.menu-item-bar', function(event, ui) {

				if ( ! $(event.target).is('a') ) {

					clearTimeout( megaMenu.recalcTimeout );
					megaMenu.recalcTimeout = setTimeout( megaMenu.recalc, 500 );
				}
			});
		},

		recalc : function() {

			var type = '',
				showPosts = 'n',
				menuItems = $('#menu-to-edit .menu-item');

			menuItems.each( function(i) {

				var item = $(this);

				item.find('.item-type, .airkit_container-options-post').hide();

				type = item.find('.airkit_menu-item-type').val();


				if ( item.hasClass('menu-item-depth-0') ) {

					type = item.find('.airkit_menu-item-type').val();

					if ( type == 'default' ) {

						item.find('.item-type-default').show();	

						item.find('.airkit_container-options-post').show();

						item.addClass('menu-item-is-default');
		

						if ( item.hasClass('menu-item-category') ) {

							showPosts = item.find('.airkit_menu-show-posts').val();
						}

					} else if ( type == 'mega' ) {

						item.find('.item-type-mega').show();						
						item.addClass('menu-item-is-mega');


					} else {

						item.find('.item-type-tabs').show();
					}

				} else if ( item.hasClass('menu-item-depth-1') ) {

					if ( type == 'default' || type == 'custom' ) {

						item.find('.item-type-default').show();		

						if ( showPosts == 'y' ) {

							/*item.find('.item-type-error').show();*/
						}

					}else if ( type == 'mega' ) {

						/*item.find('.item-type-column').show();*/

					} else if ( type == 'tabs' ) {

						/*item.find('.item-type-tab').show();*/
					}

				} else {

					if ( type == 'tabs' ) {

						item.find('.item-type-column').show();

					} else {

						item.find('.item-type-default').show();

						if ( showPosts == 'y' ) {

							// item.find('.item-type-error').show();
						}
					}
				}

				/* Add col classes  */				

				if(!item.is('.menu-item-depth-0'))
				{
					var checkItem = menuItems.filter(':eq('+(i-1)+')');
					
					if(checkItem.is('.menu-item-is-mega') || checkItem.is('.menu-item-is-column') )
					{
						item.addClass('menu-item-is-column');
					}
					else
					{
						item.removeClass('menu-item-is-column');
						// megaMenuCheckbox.attr('checked','');
					}
				}

			});
		},

		// Clone the menu-item for creating our megamenu
		addItemToMenu : function( menuItem, processMethod, callback ) {

			var menu = $('#menu').val(),
				nonce = $('#menu-settings-column-nonce').val();

			processMethod = processMethod || function(){};
			callback = callback || function(){};

			params = {
				'action': 'airkit_ajax_switch_menu_walker',
				'menu': menu,
				'menu-settings-column-nonce': nonce,
				'menu-item': menuItem
			};

			$.post( ajaxurl, params, function( menuMarkup ) {

				var ins = $('#menu-instructions');

				processMethod( menuMarkup, params );

				if( ! ins.hasClass('menu-instructions-inactive') && ins.siblings().length ) {

					ins.addClass('menu-instructions-inactive');
				}

				megaMenu.change();

				callback();
			});
		}
	};

	$( function() {

		megaMenu.change();
		megaMenu.recalcInit();
		megaMenu.showOptionsPosts();
		megaMenu.recalc();

		if ( typeof wpNavMenu != 'undefined' ) {

			wpNavMenu.addItemToMenu = megaMenu.addItemToMenu;
		}
 	});

})(jQuery);


jQuery(document).ready( function() {

	/**
	 * Make post featured.
	 */
	jQuery(".featured").click(function() {

		var nonce_featured = gowatchAdmin.Nonce;
		var value_checkbox = jQuery(this).val();
		var this_feature = jQuery(this);

		if(jQuery(this).is(":checked")){
			var checked = "yes";
		}else{
			var checked = "no";
		}
		jQuery.ajax({
            url: ajaxurl,
            type : "POST",
            data : "action=airkit_update_features&value_checkbox=" + value_checkbox + "&checked=" + checked + '&nonce_featured=' + nonce_featured,
            beforeSend:function(xhr){
            			jQuery('.saved_ajax').remove();
						this_feature.after('<p class="save_ajax">Saving...</p>');
			},
			success:function(results){
				jQuery('.save_ajax').remove();
				this_feature.after('<p class="saved_ajax">Saved !</p>');
				object = {
				   func: function() {
				   		jQuery('.saved_ajax').hide(1000);
				   }
				}
				setTimeout( function() { object.func() } , 2000);

			}
		});
	});

	/**
	 * AJAX Set Active Frontend Form .
	 */

	jQuery( '.form-active-toggle' ).on('click', function(e){
		e.preventDefault();

		var $this = jQuery(this);

		if( $this.hasClass('active') ) return;

		var adminNonce = gowatchAdmin.Nonce;
		var formID = $this.attr('data-form-id');
		var formType = $this.attr('data-type');

		jQuery.ajax({
            url: ajaxurl,
            type : "POST",
            data : "action=airkit_set_active_form&form_id=" + formID + '&form_type='+ formType +'&admin_nonce=' + adminNonce,
            beforeSend:function(xhr){
			},
			success:function(results){
				$this.parents('.wp-list-table').find('.form-active-toggle.active i').attr('class', 'icon-close');
				$this.parents('.wp-list-table').find('.form-active-toggle.active ').removeClass('active');				
				$this.addClass('active');
				$this.find('i').addClass('icon-tick').removeClass('icon-close');

			}
		});	

		return false;
	});

	airkit_postFormatBoxes();

});

function airkit_postFormatBoxes(){

	var metaboxes = {

		'gallery' : '#ts-gallery-images',
		'video' : '#video_embed',
		'audio': '#audio_embed',

	},

	toggle = function( selected ) {

		jQuery.each( metaboxes, function( index, val ) {

			if ( jQuery(val).is('textarea') ) return false;

			if( index !== selected ) {

				jQuery( val ).hide();

			} else {

				jQuery( val ).show();

			}
		});

	}

	/* Toggle post format metaboxes */
	toggle( jQuery('.post-format:checked').attr('value') );

	jQuery('.post-format').click(function(){
		toggle( jQuery(this).attr('value') );
	});

}

function airkit_uploadImageSocial(){
	custom_uploader = {};
    if (typeof wp.media.frames.file_frame == 'undefined') {
        wp.media.frames.file_frame = {};
    }

    jQuery('.ts-upload-social-image').click(function(e) {
        e.preventDefault();
        var _this     = jQuery(this),
        target_id = _this.attr('id'),
        media_id  = _this.parent().find('[data-role="media-id"]').val();

        if (custom_uploader[target_id]) {
            custom_uploader[target_id].open();
            return;
        }

        custom_uploader[target_id] = wp.media.frames.file_frame[target_id] = wp.media({
            title: 'Choose Image',
            button: {
              text: 'Choose Image'
            },
            library: {
              type: 'image'
            },
            multiple: false,
            selection: [media_id]
        });

        custom_uploader[target_id].on('select', function() {
            var attachment = custom_uploader[target_id].state().get('selection').first().toJSON();
            var slide = _this.parent().parent();
            slide.find('[data-role="media-url"]').val(attachment.url);
            slide.find('[data-role="media-id"]').val(attachment.id);
            return;
        });

        custom_uploader[target_id].open();
    });
}
//airkit_uploadImageSocial();

    // upload files
    function airkit_upload_files(id_button, id_input_hidden, input_value_attachment, text_button, id_div_preview, library){

    	var gowatch_custom_uploader = {};

        jQuery(id_button).click(function(e) {
            e.preventDefault();

            if (typeof wp.media.frames.file_frame == 'undefined') {
                wp.media.frames.file_frame = {};
            }

            var _this     = jQuery(this),
                target_id = _this.attr('id'),
                media_id  = _this.closest('td').find(id_input_hidden).val();

            if (gowatch_custom_uploader[target_id]) {
                gowatch_custom_uploader[target_id].open();
                return;
            }

            gowatch_custom_uploader[target_id] = wp.media.frames.file_frame[target_id] = wp.media({
                title: text_button,
                button: {
                    text: text_button
                },
                library: {
                    type: library
                },
                multiple: false,
                selection: [media_id]
            });

            gowatch_custom_uploader[target_id].on('select', function() {

                var attachment = gowatch_custom_uploader[target_id].state().get('selection').first().toJSON();
                var options = _this.closest('table');

                options.find(input_value_attachment).val(attachment.url);
                options.find(id_input_hidden).val(attachment.id);

                if ( typeof(id_div_preview) !== 'undefined' ) {

	                if( typeof(jQuery(id_div_preview)) !== 'undefined' ){
						var img = jQuery("<img>").attr('src', attachment.url).attr('style', 'max-width:400px');
                        jQuery(id_div_preview).html(img);

					}
				}

                return;
            });

            gowatch_custom_uploader[target_id].open();

        });
	}

	//headings upload font
	airkit_upload_files('#upload_svg','#file_svg','#atachment-svg','Choose font','image');
	airkit_upload_files('#upload_eot','#file_eot','#atachment-eot','Choose font','image');
	airkit_upload_files('#upload_woff','#file_woff','#atachment-woff','Choose font','image');
	airkit_upload_files('#upload_ttf','#file_ttf','#atachment-ttf','Choose font','image');

	//primary upload font
	airkit_upload_files('#upload_primary_svg','#file_primary_svg','#atachment-primary-svg','Choose font','image');
	airkit_upload_files('#upload_primary_eot','#file_primary_eot','#atachment-primary-eot','Choose font','image');
	airkit_upload_files('#upload_primary_woff','#file_primary_woff','#atachment-primary-woff','Choose font','image');
	airkit_upload_files('#upload_primary_ttf','#file_primary_ttf','#atachment-primary-ttf','Choose font','image');

	//primary upload font
	airkit_upload_files('#upload_secondary_svg','#file_secondary_svg','#atachment-secondary-svg','Choose font','image');
	airkit_upload_files('#upload_secondary_eot','#file_secondary_eot','#atachment-secondary-eot','Choose font','image');
	airkit_upload_files('#upload_secondary_woff','#file_secondary_woff','#atachment-secondary-woff','Choose font','image');
	airkit_upload_files('#upload_secondary_ttf','#file_secondary_ttf','#atachment-secondary-ttf','Choose font','image');

	airkit_upload_files('#select-custom-type-video','#select-custom_media_id','#custom-type-upload-videos','Upload video','image');


	// Add new items in builder-element
	jQuery( document ).on( 'click', '.ts-multiple-add-button', function( e ) {
		
		var container = jQuery( this ).closest( '.airkit_block-items' ),
			newId = new Date().getTime(),
			regexId = new RegExp( '{id}', 'g' ),
			regexSlideNr = new RegExp( '{slide-nr}', 'g' ),
			tmpl = container.find( '.airkit_tmpl' ).html(),
			nrOfSlides = container.find( '.airkit_created-items > li' ).length + 1,
			newItemHtml = tmpl.replace( regexId, newId ).replace( regexSlideNr, nrOfSlides );

		container.find( '.airkit_created-items' ).append( newItemHtml );

		jQuery('[data-sortable="true"]').sortable({items : 'li', handle: '.sortable-meta-element'});

		airkit_triggerOptions();

		initColorpicker();
	});

	// Duplicate item
	jQuery( document ).on( 'click', '.ts-multiple-item-duplicate, .airkit_remove-item', function( e ) {
        e.preventDefault();

        var item = jQuery( this ).closest( 'li' );

        if ( jQuery( this ).hasClass( 'airkit_remove-item' ) ) {

        	var check = confirm( 'Are you sure you want to remove this item?' );

        	if ( false == check ) return;

        	item.remove();

        	return;
        }

        var ulSortable = jQuery( this ).closest( '.airkit_block-items' ).find( '.airkit_created-items' ),
        	newId =  new Date().getTime(),
        	oldId = item.find( '[name]' ).eq(0).attr( 'name' ).split( '[' )[1].replace( ']', '' );
        	//newItemHtml = item.html().replace( new RegExp( oldId, 'g' ), newId );

       	ulSortable.append( item.clone()/*'<li>' + newItemHtml + '</li>'*/ );

       	ulSortable.find( 'li:last-child' ).find( '[name]' ).each( function() {

       		jQuery( this ).attr( 'name', jQuery( this ).attr( 'name' ).replace( oldId, newId ) );

       		var id = jQuery( this ).attr( 'id' );

       		// For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
       		if ( typeof id !== typeof undefined && id !== false ) {

       		 	jQuery( this ).attr( 'id', id.replace( oldId, newId ) );
       		}
       	});

       	ulSortable.find( 'li:last-child' ).find( '.airkit_slide-nr' ).text( ulSortable.children().length );

        jQuery('[data-sortable="true"]').sortable({items : 'li', handle: '.sortable-meta-element'});

        airkit_triggerOptions();

        initColorpicker();
    });

//show/hide the button 'Generate likes' in 'GENERAL OPTIONS' depending of option 'Enable likes'
function airkit_generalOptionsButtonLikes(){
    var option_display_mode = jQuery('.enable-likes');
    jQuery(option_display_mode).change(function(){
        if( jQuery(this).val() === 'n' ){
            jQuery(this).parent().parent().parent().find('.icons-likes').closest('tr').css('display', 'none');
            jQuery(this).parent().parent().parent().find('.generate-likes').closest('tr').css('display', 'none');
        }else{
        	jQuery(this).parent().parent().parent().find('.icons-likes').closest('tr').css('display', '');
            jQuery(this).parent().parent().parent().find('.generate-likes').closest('tr').css('display', '');
        }
    });

    if( jQuery(option_display_mode).val() === 'n' ){
        jQuery(option_display_mode).parent().parent().parent().find('.icons-likes').closest('tr').css('display', 'none');
        jQuery(option_display_mode).parent().parent().parent().find('.generate-likes').closest('tr').css('display', 'none');
    }else{
        jQuery(option_display_mode).parent().parent().parent().find('.icons-likes').closest('tr').css('display', '');
        jQuery(option_display_mode).parent().parent().parent().find('.generate-likes').closest('tr').css('display', '');
    }
}
airkit_generalOptionsButtonLikes();

jQuery('#save-header-footer').on('click', function() {
    window.builderDataChanged = false;
});

var geocoder;
var map, mapLat, mapLng, latlng;

function initialize()
{
	if ( jQuery( '#map-canvas' ).length == 0 ) return;

	geocoder = new google.maps.Geocoder();

	mapLat = jQuery('#ts-latitude').val();
	mapLng = jQuery('#ts-longitude').val();

	if( typeof(mapLat) !== 'undefined' && typeof(mapLng) !== 'undefined' && mapLat.length > 0 && mapLng.length > 0 ){
		latlng = new google.maps.LatLng(mapLat, mapLng);
	} else {
		latlng = new google.maps.LatLng(-34.397, 150.644);
	}

	var mapOptions = {
    	zoom: 13,
    	center: latlng
    }

	map = new google.maps.Map( document.getElementById( 'map-canvas' ), mapOptions );

	var marker = new google.maps.Marker({
		map: map,
		position: latlng
	});

	return map;
}

function codeAddress() {
	var address = document.getElementById( 'address' ).value;

	geocoder.geocode( { 'address': address}, function(results, status) {

		if (status == google.maps.GeocoderStatus.OK) {

			map.setCenter(results[0].geometry.location);
			var marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location
			});
		    jQuery('#ts-latitude').val(map.getCenter().lat());
				jQuery('#ts-longitude').val(map.getCenter().lng());
		}
  });
}

function airkit_sliderPips()
{
	jQuery( '.airkit_slider' ).each( function() {

		var that = jQuery( this );

		that.slider({
		    range: "min",
		    min: that.data( 'min' ),
		    max: that.data( 'max' ),
		    value: that.parent().find( '.airkit_slider-input' ).val(),
		    step: that.data( 'step' ),
		    slide: function( event, ui ) {

		     	that.parent().find( '.airkit_slider-input' ).val( ui.value );

		    }
		});
	});
}


function airkit_restartColorPicker(){

    jQuery('.colors-section-picker-div').each(function(){
    	jQuery(this).farbtastic(jQuery(this).prev());
    });

    jQuery('.colors-section-picker-div').hide();

    jQuery(".colors-section-picker").click(function(e){
        e.stopPropagation();
        jQuery(jQuery(this).next()).show();
    });

    jQuery('body').click(function() {
        jQuery('.colors-section-picker-div').hide();
    });
}

var delay = (function(){
    var timer = 0;
     return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

jQuery( document ).on( 'keyup', '.airkit_search-icon', function() {

    var _this = jQuery( this );

    delay( function() {

        var filterDivs = jQuery( _this ).closest( '.ts-option-line, .ts-icons-container' ).find( '.airkit_custom-selector li' );


        if ( _this.val() == '' ) {

            filterDivs.slideDown( 300 );

        } else {

            var show = filterDivs.filter( function () { 

                return ( jQuery( this ).attr( 'data-filter' ).toLowerCase().indexOf( _this.val().toLowerCase() ) > -1 );

            });
                
            filterDivs.not( show ).hide( 200 );

            show.show( 300 );            
        }

    }, 300 );
});

jQuery('.ts-upload').click(function(event){
	var uploader = null,
		_this = jQuery(this);

	if (typeof wp.media.frames.file_frame == 'undefined') {
		wp.media.frames.file_frame = {};
	}

	if(uploader){
		uploader.open();
		return;
	}

	uploader = wp.media({
		title: 'Select the custom icon file (Allowed: eot, svg, ttf, woff, css)',
		button: {
			text: 'Use this file'
		},
		multiple: false
	});

	uploader.on('select', function(){
		var attachment = uploader.state().get('selection').first().toJSON();
		_this.parent().find('[type="hidden"]').val(attachment.id);
		_this.parent().find('[type="text"]').val(attachment.url);
	});

	uploader.open();
});



jQuery('.ts-delete-icon').click(function(){

	var data = {},
		removeIcon = jQuery(this).parent().find('li.selected');

	data['action'] = 'airkit_delete_custom_icon';
	data['nonce']  = gowatchAdmin.Nonce;
	data['icon']   = removeIcon.attr('data-icon');

	jQuery.post(ajaxurl, data, function(response) {
		if( response == 'ok' ){
			if( removeIcon.closest('.builder-icon-list').find('li').length == 1 ){
				removeIcon.closest('.ts-icon-custom').remove();
			}else{
				removeIcon.removeClass('selected').next().addClass('selected');
				removeIcon.remove();
			}
		}
	});
});

jQuery('.ts-delete-icons').click(function(){

	var data = {},
		_this = jQuery(this);

	data['action'] = 'airkit_delete_custom_icon';
	data['nonce']  = gowatchAdmin.Nonce;
	data['key']   = jQuery(this).attr('data-key');

	jQuery.post(ajaxurl, data, function(response){
		if( response == 'ok' ){
			_this.parent().remove();
		}
	});
});

jQuery('.ts-show-icon').click(function(){
	jQuery(this).parent().find('.ts-icon-container').toggle();
	jQuery(this).parent().find('.ts-delete-icon').toggle();
	jQuery(this).parent().find('.ts-delete-icons').toggle();
});

jQuery('.ts-icon-container, .ts-delete-icon, .ts-delete-icons').hide();

if( jQuery('.publish-changes').length > 0 ){
	jQuery(window).bind('keydown', function(event){
	    if( event.ctrlKey || event.metaKey ){
	        if( String.fromCharCode( event.which ).toLowerCase() == 's'){
	        	event.preventDefault();
	        	jQuery('.publish-changes').click();
	        }
	    }
	});
}

jQuery(document).on('change', '.ui-dialog #ts-layout, .ui-dialog #ts-rows', function(){

	airkit_mosaicNumberOfPosts();

});

function airkit_mosaicNumberOfPosts(){
	/*
	 * This function re-calculates min, max, and step for slider, when picking max number of posts for mosaic view.
	 * Call on select change, modal open.
	 */

	if( jQuery('.ui-dialog #airkit_posts-limit + .airkit_slider').length > 0 ) {

		var mosaicSlider = jQuery('.ui-dialog #airkit_posts-limit + .airkit_slider'),
			mosaicLayout = jQuery('.ui-dialog #ts-layout');


		if ( mosaicLayout.val() == 'square' || mosaicLayout.val() == 'style-5' ) {

			mosaicSlider.slider('option', 'min', 5);
			mosaicSlider.slider('option', 'max', 50);
			mosaicSlider.slider('option', 'step', 5);

		} else if( mosaicLayout.val() == 'rectangles' ) {

			var multiplyBy = jQuery('.ui-dialog #ts-rows').val();

			mosaicSlider.slider('option', 'min', 3 * multiplyBy );
			mosaicSlider.slider('option', 'max', 30 * multiplyBy );
			mosaicSlider.slider('option', 'step', 3 * multiplyBy );

		} else if ( mosaicLayout.val() == 'style-3' || mosaicLayout.val() == 'style-4' ) {

			mosaicSlider.slider('option', 'min', 3);
			mosaicSlider.slider('option', 'max', 60);
			mosaicSlider.slider('option', 'step', 3);

		}


		mosaicSlider.slider("value", mosaicSlider.slider("value")); //force the view refresh, re-setting the current value
		mosaicSlider.slider('option','slide')
		       .call(mosaicSlider,null,{ handle: jQuery('.ui-slider-handle', mosaicSlider), value: mosaicSlider.slider("value") });	 
	}

}

jQuery(document).on('click', '.media-modal-close, .media-toolbar', function(event){

	event.preventDefault();
	if( jQuery('#ts_editor_id').length > 0 ){
		tinymce.get('ts_editor_id').setContent(tinymce.get('ts_editor_id').getContent());
	}
});

// Custom selectors
function custom_selectors( selector, targetselect ) {
    selector_option = jQuery(selector).attr('data-option');
    jQuery(selector).closest('ul.ts-custom-selector').find('.selected').removeClass('selected');
    jQuery(targetselect).find('option[selected="selected"]').removeAttr('selected');
    jQuery(targetselect).find('option[value="' + selector_option + '"]').attr('selected','selected');
    jQuery(selector).closest('li').addClass('selected');
}

jQuery( document ).on( 'click', '.clickable-element', function() {

   	var select         = jQuery( this ).closest( 'div' ).find( '.airkit_select-options' ),
   		newValueSelect = jQuery( this ).attr( 'data-option' );

   	jQuery( this ).closest( 'ul' ).find( '.selected' ).removeClass( 'selected' );

   	jQuery( this ).closest( 'li' ).addClass( 'selected' );

   	select.find( 'option[selected="selected"]' ).removeAttr( 'selected' );
   	select.find( 'option[value="' + newValueSelect + '"]' ).attr( 'selected', 'selected' );
});

function airkit_iconSelector()
{
	jQuery( '.builder-element-icon-toggle' ).each( function() {

	    var selectedOptionVal = jQuery( this ).parent().find( 'option:selected' ).attr( 'value' );

	    if ( selectedOptionVal != '' && jQuery( this ).find( 'i.' + selectedOptionVal ).length == 0 ) {

	        jQuery( this ).find( 'a' ).append( "<i class='" + selectedOptionVal + "'></i>" ); //add to button the selected icon
	    }

	    jQuery( this ).parent().find( '[data-filter="' + selectedOptionVal + '"]' ).addClass( 'selected' );
	});
}
airkit_iconSelector();

function airkit_imgSelector()
{
	jQuery( '.imageRadioMetaUl' ).each( function() {

		var val = jQuery( jQuery( this ).data( 'selector' ) ).val();

		jQuery( this ).find( 'li.selected' ).removeClass( 'selected' );

		jQuery( this ).find( '.image-radio-input' ).each( function() {

			if ( val == jQuery( this ).data( 'option' ) ) {

				jQuery( this ).closest( 'li' ).addClass( 'selected' );
			}
		});

		jQuery( jQuery( this ).data( 'selector' ) ).trigger( 'change' );
	});
}

airkit_imgSelector();

jQuery( document ).on( 'click', '.image-radio-input', function() {

	jQuery(this).parent().parent().find('.selected').removeClass('selected');
	jQuery(this).addClass('selected');

	select = jQuery( jQuery(this).closest( '.imageRadioMetaUl' ).data( 'selector' ) );

	select.find( 'option[value="' + jQuery( this ).data( 'option' ) + '"]' ).attr( 'selected', 'selected' );
	select.trigger( 'change' );
});


// Show selected element from elementOptions and hide the rest
function airkit_makeSelected (elementOptions, selected) {
    jQuery.each(elementOptions, function(index, el) {
        var element = jQuery(el);
        if (element.hasClass(selected)) {
            element.removeClass('hidden');
        } else {
            if(!element.hasClass('hidden')) {
                element.addClass('hidden');
            }
        }
    });
}

jQuery(document).on('change', '.ts-widget-custom-post', function(){

	jQuery(this).closest('.ts-content-taxonomy').find('.ts-taxonomy').html('');
	jQuery(this).closest('.ts-content-taxonomy').find('.ts-taxonomies').html('');

	if( jQuery(this).val() !== ''){

		var data     = {},
			_this    = jQuery(this),
			name     = _this.closest('.ts-content-taxonomy').find('.ts-taxonomy').attr('data-taxonomy'),
			postType = _this.val();

		data = {
			action   : 'ts_get_taxonomy',
			name     : name,
			postType : postType,
			nonce    : gowatchAdmin.Nonce
		};

		jQuery.post(ajaxurl, data, function(data) {
			_this.closest('.ts-content-taxonomy').find('.ts-taxonomy').html(data);
		});

	}

});

jQuery(document).on('change', '.ts-select-taxonomy', function(){

	jQuery(this).closest('.ts-content-taxonomy').find('.ts-taxonomies').html('');

	if( jQuery(this).val() !== ''){
		var data     = {},
			_this    = jQuery(this),
			name     = _this.closest('.ts-content-taxonomy').find('.ts-taxonomies').attr('data-taxonomies'),
			taxonomy = _this.val();

		data = {
			action   : 'airkit_get_terms',
			name     : name,
			taxonomy : taxonomy,
			nonce    : gowatchAdmin.Nonce
		};

		jQuery.post(ajaxurl, data, function(data) {
			_this.closest('.ts-content-taxonomy').find('.ts-taxonomies').html(data);
		});

	}
});

function airkit_backgroundType()
{
	var val = jQuery('.meta_title_bg_type input:checked').val();

	if ( val == 'yes' ) {
		jQuery('[name="airkit_post_settings[bg_color]"]').closest('.meta-box-option').show();
		jQuery('[name="airkit_post_settings[img_url]"], [name="airkit_post_settings[bg_y]"], [name="airkit_post_settings[bg_x]"], [name="airkit_post_settings[bg_repeat]"], [name="airkit_post_settings[bg_size]"]').closest('.meta-box-option').hide();
	} else {
		jQuery('[name="airkit_post_settings[bg_color]"]').closest('.meta-box-option').hide();
		jQuery('[name="airkit_post_settings[img_url]"], [name="airkit_post_settings[bg_y]"], [name="airkit_post_settings[bg_x]"], [name="airkit_post_settings[bg_repeat]"], [name="airkit_post_settings[bg_size]"]').closest('.meta-box-option').show();
	}
}

function airkit_logo( val )
{
	if ( val == 'image' ) {

		jQuery('[name="logo_url"]').closest('.ts-option-line').show();
		jQuery('[name="retina_logo"]').closest('.ts-option-line').show();
		jQuery('[name="logo_text"]').closest('.ts-option-line').hide();
		jQuery('[name="font"]').closest('.ts-option-line').hide();

	} else {

		jQuery('[name="logo_url"]').closest('.ts-option-line').hide();
		jQuery('[name="retina_logo"]').closest('.ts-option-line').hide();
		jQuery('[name="logo_text"]').closest('.ts-option-line').show();
		jQuery('[name="font"]').closest('.ts-option-line').show();

	}
}

function airkit_layout( select )
{
	select.find('option').each(function(){
		select.closest('.ts-block-options').find('.ts-' + jQuery(this).val() + '-option').hide();
	});

	jQuery('.ts-' + select.val() + '-option').show();
}

function airkit_sidebar( select )
{
	if ( select.val() == 'none' ) {
		select.closest('.ts-block-options').find('.ts-sidebar-option').hide();
	} else {
		select.closest('.ts-block-options').find('.ts-sidebar-option').show();
	}
}

function airkit_buildPreviewImgs()
{
	jQuery( '.airkit_stock-attachments' ).each( function() {

		var data = jQuery( this ).val(),
			sortableUl = jQuery( this ).parent().find( '.airkit_selected-imgs' ),
			type = jQuery( this ).parent().find( '.ts-upload-file' ).attr( 'data-media-type' );

		if ( 'video' == type ) {

			var url = data.split( '|' );

			jQuery(this).parent().find('.ts-file-url').val( url[1] );

			return;
		} 

		if ( ! sortableUl.hasClass( 'airkit_has-sortable' ) ) {

			sortableUl.html( '' );
		}

		if ( data != '' ) {

			var parentThis = jQuery( this ).parent(),
				items = data.split( ',' );

			for ( var i = 0; i < items.length; i++ ) {

				var idUrl = items[i].split( '|' );

				sortableUl.append('\
					<li class="image" data-id="' + idUrl[0] + '" data-url="' + idUrl[1] + '">\
						<img src="' + idUrl[1] + '" />\
						<ul class="actions">\
							<li class="airkit_delete-image"><a href="#" class="icon-close" title="Delete image"></a></li>\
							<li class="airkit_edit-image"><a href="#" class="icon-brush" title="Edit image"></a></li>\
						</ul>\
					</li>'
				);

				if ( jQuery( this ).parent().parent().find( '.ts-file-url' ).length > 0 ) {

					jQuery( this ).parent().parent().find( '.ts-file-url' ).val( idUrl[1] );
				}
			}
		}
	});

	if( jQuery( '.airkit_has-sortable' ).length ){
		jQuery( '.airkit_has-sortable' ).sortable({
			items: 'li.image',
			cursor: 'move',
			scrollSensitivity:40,
			forcePlaceholderSize: true,
			forceHelperSize: false,
			helper: 'clone',
			opacity: 0.65,
			placeholder: 'wc-metabox-sortable-placeholder',

			start: function( event, ui ) {

				ui.item.css( 'background-color', '#f6f6f6' );
			},

			stop: function( event, ui ) {

				ui.item.removeAttr( 'style' );
			},

			update: function( event, ui ) {

				var data = [];

				ui.item.closest( '.airkit_selected-imgs' ).find( 'li.image' ).each( function() {

					data.push( jQuery( this ).data( 'id' ) + '|' + jQuery( this ).data( 'url' ) );
				});

				ui.item.closest( '.ts-option-line' ).find( '.airkit_stock-attachments' ).val( data.join( ',' ) );
			}
		});
	}
}

airkit_buildPreviewImgs();


jQuery(document).on( 'click', '.airkit_delete-image', function( e ) {
	e.preventDefault();

	var answer = window.confirm( 'Do you really want to remove this item?' );

	if ( ! answer ) return;

	container = jQuery( this ).closest( '.airkit_selected-imgs' );

	jQuery( this ).closest( 'li.image' ).remove();

	var data = [];

	container.find( 'li.image' ).each( function() {

		data.push( jQuery( this ).data( 'id' ) + '|' + jQuery( this ).data( 'url' ) );
	});

	container.closest( '.ts-option-line' ).find( '.airkit_stock-attachments' ).val( data.join( ',' ) );
});


jQuery(document).on('keyup', '.ts-file-url', function(){

	/*
	 * Clear .airkit_stock-attachments input, when .ts-file-url file input is cleared
	 */	

	if( jQuery(this).val() == '' ) {

		jQuery(this).parent().find('.airkit_stock-attachments').val('');

	}

});


function airkit_triggerOptions()
{
	jQuery( '.airkit_trigger-options' ).each( function() {

		var such = jQuery( this ),
			name = such.attr( 'name' ).replace( '][', '-' ).replace( '[', '-' ).replace( ']', '' ),
			class_selected = 'airkit_' + name + '-' + such.val(),
			parent = jQuery( 'body' );

		if ( 1 == such.closest( '.airkit_element-settings' ).length ) {

			parent = such.closest( '.airkit_element-settings' );
		}

		such.find( 'option' ).each( function() {

			parent.find( '.' + 'airkit_' + name + '-' + jQuery( this ).attr( 'value' ) ).closest( '.ts-option-line, .airkit_block-items' ).each( function() {

				var classes = jQuery( this ).attr( 'class' ),
					display = 'none';

				if ( typeof classes != 'undefined' && classes != '' ) {

					classes = classes.split( ' ' );

					if ( jQuery( this ).hasClass( 'airkit_revert-trigger' ) ) {

						if ( jQuery.inArray( class_selected, classes ) == -1 ) {

							display = '';
						}

					} else {

						if ( jQuery.inArray( class_selected, classes ) !== -1 ) {

							display = '';
						}
					}
				}

				jQuery( this ).css( 'display', display );
			});
		});
	});
}

function initColorpicker()
{
	if ( jQuery( '.airkit_colorpicker' ).length == 0 ) return false;

    jQuery( '.airkit_colorpicker' ).colorpicker({
        format: 'rgba',
        align: 'left',
        component: '.input-group-addon, input[type="text"]',
    });
}

jQuery(window).load(function(){
	initColorpicker();
	jQuery('.airkit_sortable-items').sortable({items : 'li', handle: '.sortable-meta-element'});
});

// jQuery's clone() method works in most cases, but it fails to copy the value of textareas and select elements. This patch replaces jQuery's clone() method with a wrapper that fills in the
// values after the fact.
(function (original) {
  jQuery.fn.clone = function () {
    var result           = original.apply(this, arguments),
        my_textareas     = this.find('textarea').add(this.filter('textarea')),
        result_textareas = result.find('textarea').add(result.filter('textarea')),
        my_selects       = this.find('select').add(this.filter('select')),
        result_selects   = result.find('select').add(result.filter('select'));

    for (var i = 0, l = my_textareas.length; i < l; ++i) jQuery(result_textareas[i]).val(jQuery(my_textareas[i]).val());
    for (var i = 0, l = my_selects.length;   i < l; ++i) {
      for (var j = 0, m = my_selects[i].options.length; j < m; ++j) {
        if (my_selects[i].options[j].selected === true) {
          result_selects[i].options[j].selected = true;
        }
      }
    }
    return result;
  };
}) (jQuery.fn.clone);


function shortcode_modal( type, titleModal )
{
	jQuery( '#ts-builder-elements-modal-preloader' ).show();

	var data = {
			action : 'airkit_theme_shortcodes',
			nonce  : gowatchAdmin.Nonce,
			type   : type
		};

	jQuery.post( ajaxurl, data, function( response ) {

		jQuery( '#airkit_builder-settings-shortcode .modal-dialog' ).html( response );

		jQuery( '#airkit_builder-settings-shortcode' ).dialog({
		    width: 860,
		    height: 600,
		    title: 'Add shortcode ' + titleModal,
		    buttons: [
		        {
		            text: 'Insert shortcode',
		            class: 'airkit_save-shortcode',
		            icons: {
		                primary: 'icon-save'
		            },
		            click: function() {

		            	airkit_insertShortcode();
		            	jQuery( this ).dialog( 'close' );
		            }
		        },
		        {
		            text: 'Cancel',
		            class: 'airkit_cancel-shortcode',
		            icons: {
		                primary: 'icon-cancel'
		            },
		            click: function() {
		                jQuery( this ).dialog( 'close' );
		            }
		        }
		    ],

		    show: {
		        effect: 'fadeIn',
		        duration: 250,
		    },

		    hide: {
		        effect: 'fadeOut',
		        duration: 200,
		    },

		    close: function( event, ui ) {

		        jQuery( '#airkit_builder-settings-shortcode .airkit_modal-body' ).html( '' );
		        jQuery('.ui-dialog').find( '.ui-dialog-titlebar .airkit_tabs' ).remove();
		    },

		    open: function( event, ui ) {

		        initColorpicker();

		        if ( jQuery( '#map-canvas' ).length > 0 ) {

		            var map = initialize();
		            google.maps.event.trigger( map, 'resize' );
		            codeAddress();
		        }

                // Move tabs to modal header
                var parentModal = jQuery( '#airkit_builder-settings-shortcode' ).parent('.ui-dialog');

                if( parentModal.find( '.ui-dialog-titlebar .airkit_tabs' ).length == 0 ) {
                	
                    jQuery( '#airkit_builder-settings-shortcode .airkit_tabs' ).appendTo( parentModal.find('.ui-dialog-titlebar') );

                }		        

                airkit_sliderPips();

                //re-calc slider values for mosaic no.of posts
                airkit_mosaicNumberOfPosts();                
		    },

		    resizeStop: function( event, ui ) {

		        if ( jQuery( '#map-canvas' ).length > 0 ) {

		            google.maps.event.trigger( map, 'resize' );
		        }
		    }
		});

		// Restart select plugin.
		airkit_multipleSelect();

		// Hide unneeded fields
		airkit_triggerOptions();

		jQuery( '.airkit_save-shortcode, .airkit_cancel-shortcode' ).find( 'span' ).removeClass( 'ui-button-icon-primary ui-icon' );
		jQuery( '.airkit_tabs > li:first-child' ).trigger( 'click' );
		jQuery( '#ts-builder-elements-modal-preloader' ).hide();
	});
}

jQuery( document ).on( 'click', '.airkit_tabs > li', function() {

    if ( jQuery( this ).hasClass( 'airkit_selected' ) ) return;

    jQuery( this ).closest( 'ul' ).find( '.airkit_selected' ).removeClass( 'airkit_selected' );

    jQuery( this ).addClass( 'airkit_selected' );

    jQuery( '.airkit_tabs-content > div' ).hide().eq( jQuery( this ).index() ).show();
});

function airkit_insertShortcode()
{
	var settings = airkit_getValuesByNames( '#airkit_builder-settings-shortcode .airkit_element-settings' ),
		attrs = '',
		content = '';

	for ( var prop in settings ) {

		if ( jQuery.isPlainObject( settings[ prop ] ) ) {

			for ( var prop1 in settings[ prop ] ) {

				var attrs1 = '';
					content2 = '';

				attrs1 = '[item item-type="' + settings['element-type'] + '"' + ' id="' + prop1 + '" ';

				for ( var prop2 in settings[ prop ][ prop1 ] ) {

					// Rewrite attibutes if tab element
					if ( settings['element-type'] == 'tab' || settings['element-type'] == 'listed_features' || settings['element-type'] == 'pricing_tables' || settings['element-type'] == 'feature_blocks' || settings['element-type'] == 'timeline-features' || settings['element-type'] == 'toggle' ) {

						if ( prop2 != 'text' ) {

							attrs1 = attrs1 + prop2 + '="' + settings[ prop ][ prop1 ][ prop2 ] + '" ';

						} else {

							content2 = settings[ prop ][ prop1 ][ prop2 ];
						}
					}
				}

				content = content + attrs1 +  ']' + content2 + '[/item]';
			}

		} else {

			var attrVal = settings[ prop ];
		}

		if ( prop != '' ) {

			attrs = attrs + prop + '="' + attrVal + '" ';
		}
	}

	var shortcode = '[ts_' + settings['element-type'] + ' ' + attrs + ']' + content + '[/ts_' + settings['element-type'] + ']';

	tinyMCE.activeEditor.selection.setContent( shortcode );
}

function airkit_getValuesByNames( container )
{
    var settings = {};

    jQuery( container ).find( '[name]' ).each( function() {

        var name = jQuery( this ).attr( 'name' ),
            value = jQuery( this ).val();

        if ( name.indexOf( '[' ) > -1 ) {

            // Dismember attribute name in keys for insert in array. For exemple x[y] to be attrsHasJson = { 'x' : { 'y' : { value of y } } }.
            var explode = name.split( '[' );

            if ( ! jQuery.isEmptyObject( explode ) ) {

                // Clean array values of ']'.
                jQuery.map( explode, function( val, i ) {explode[ i ] = val.replace( ']', '' );});

                if ( explode.length == 2 ) {

                    if ( ! settings.hasOwnProperty( explode[0] ) ) {

                        settings[ explode[0] ] = {};
                    }

                    settings[ explode[0] ][ explode[1] ] = value;

                } else {

                    if ( ! settings.hasOwnProperty( explode[0] ) ) {

                        settings[ explode[0] ] = {};
                    }

                    if ( ! settings[ explode[0] ].hasOwnProperty( explode[1] ) ) {

                        settings[ explode[0] ][ explode[1] ] = {};
                    }

                    settings[ explode[0] ][ explode[1] ][ explode[2] ] = value;
                }
            }

        } else {

            settings[ name ] = null == value ? '' : value;
        }

    });

    return settings;
}

function airkit_multipleSelect()
{
    jQuery( 'select.ts-custom-select-input' ).each( function() {

        var select_placeholder = jQuery( this ).attr( 'data-placeholder' );

        jQuery( this ).find( 'option[value="0"]' ).removeAttr( 'selected' );

        jQuery( this ).css( {'width':'380px'} ).select2({
            placeholder: select_placeholder,
            allowClear: true
        });
    });
}

jQuery( document ).on( 'change', 'select.ts-custom-select-input', function() {

    var value = jQuery( this ).val();

    if ( typeof( value ) == null || typeof( value ) == 'undefined' || jQuery.isEmptyObject( value ) ) return;

    if ( value.indexOf( '0' ) >= 0 ) {

        var id = jQuery( this ).parent().find( "div[class*='select2-container']" ).attr( 'id' ).replace( 's2id_', '' ),
            element = jQuery('#' + id);

        var selected = [];

        element.find( "option[value!='0']" ).each( function( i, e ) {

            selected[ selected.length ] = jQuery( e ).attr( 'value' );
        });

        element.select2( 'val', selected );

        jQuery( this ).find( 'option[value="0"]' ).hide();
    }

});


/**	 WordPress 5.0+ Fixes **/
jQuery(window).load(function(){

	if ( jQuery('body').hasClass('wp5') ) {
		var builderToggleButton = jQuery('.airkit_builder_btn'),
			builderState = builderToggleButton.attr('data-state');

		jQuery('div.edit-post-header-toolbar').append(builderToggleButton.fadeIn(800));

		// Check if we should hide default editor or show
		if ( builderState == 'enabled' ) {
			airkit_editor_toggler('disabled', false );
		} else {
			airkit_editor_toggler('enabled', false );
		}

		// Do the switch
		jQuery(document).on('click', '.airkit_builder_btn', function(){
			airkit_editor_toggler( jQuery(this).attr('data-state'), true );
		});


		// Function for switching between builder states
		function airkit_editor_toggler(state, doAjax = true) {

			console.log(state);

			// Do the stuff for enabling the builder
			if ( state == 'disabled' ) {

				// Hide Gutenberg Elements part
				jQuery('.editor-block-list__layout').hide();

				// Show Touch Builder Part instead of Gutenberg
				jQuery('#airkit_layout_id').addClass('touch-builder-active');

				// Set use template to the right option
				$('#postcustom').find('input[value="ts_use_template"]').closest('td').siblings('td').find('textarea').val(1);

				if ( doAjax == true ) {
					var data = {
							action : 'airkit_toggle_layout_builder',
							post_id : jQuery('.airkit_builder_btn').attr('data-post-id'),
							state: 'enable',
							nonce  : gowatchAdmin.Nonce
						};

					jQuery.post(ajaxurl, data, function(data) {
						console.log('Touch Builder was Enabled');
					});

					// Set the enabled status in the button
					jQuery('.airkit_builder_btn').attr('data-state', 'enabled');

					jQuery('.airkit_builder_btn').html('Disable Layout Builder');
				}

				// Show the Custom Layout Meta Box
				jQuery('#airkit_layout_id').show();
				jQuery('#ts_page_options').hide();
				jQuery('#ts-import-export').show();
                jQuery('#airkit_sidebar').hide();

			} else {
				// Do the stuff for disabling the editor

				// Hide Gutenberg Elements part
				jQuery('.editor-block-list__layout').show();

				// Show Touch Builder Part instead of Gutenberg
				jQuery('#airkit_layout_id').removeClass('touch-builder-active');

				$('#postcustom').find('input[value="ts_use_template"]').closest('td').siblings('td').find('textarea').val(0);

				if ( doAjax == true ) {
					var data = {
							action : 'airkit_toggle_layout_builder',
							post_id : jQuery('.airkit_builder_btn').attr('data-post-id'),
							state: 'disable',
							nonce  : gowatchAdmin.Nonce
						};

					jQuery.post(ajaxurl, data, function(data) {
						console.log('Touch Builder was Disabled');
					});

					// Set the disabled status in the button
					jQuery('.airkit_builder_btn').attr('data-state', 'disabled');

					jQuery('.airkit_builder_btn').html('Activate Layout Builder');
				}

				jQuery('#airkit_layout_id').hide();
				jQuery('#ts_page_options').show();
				jQuery('#ts-import-export').hide();
                jQuery('#airkit_sidebar').show();

			}

		}
	}

});
