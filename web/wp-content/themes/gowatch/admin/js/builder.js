( function( $ ) {
    'use strict';
    $( document ).ready( function(jQuery) {

        $( document ).on( 'click', '.edit-row-settings, .edit-column, .layout_builder span.edit, .airkit_elements-container li', function( event ) {
            event.preventDefault();

            $( '.ts-all-elements' ).addClass( 'ts-is-hidden' );

            $( 'body' ).removeClass( 'ts-elements-modal-open airkit_modal-editor-open' );

            if ( 0 == $( this ).closest( '.airkit_elements-container' ).length ) {

                window.currentEditedElement = $( this ).hasClass( 'edit-row-settings' ) || $( this ).hasClass( 'edit-column' ) ? $( this ) : $( this ).closest( 'li' );
            }

            if ( $( this ).hasClass( 'airkit_import-element' ) ) return;

            $( '#ts-builder-elements-modal-preloader' ).show();

            var that = $( this ),
                elementType = $( this ).attr( 'data-element-type' ),
                strJson = that.children( '.airkit_element-settings' ).text(),
                settings = '' == strJson ? {} : JSON.parse( strJson );

            if ( 'text' == elementType ) {
                
                airkit_setFieldsValues( settings );
                // Check if nothing is defined as default and add something
                if ( typeof settings['admin-label'] == 'undefined' ) {
                    settings['admin-label'] = 'Text';
                    settings['text'] = '';
                }

                $( '.airkit_editor-modal' ).find( 'input[name="admin-label"]' ).val( settings['admin-label'] );

                closeDialog();

                if ( settings.hasOwnProperty( 'text' ) && settings.text != '' ) {

                    if ( tinymce.get( 'ts_editor_id' ) != null ) {

                        tinymce.get( 'ts_editor_id' ).setContent( settings.text );

                    } else {

                        jQuery('#ts_editor_id').html( settings.text );

                    }
                }

                $( '#ts-builder-elements-modal-preloader' ).hide();

                $( 'body' ).addClass( 'airkit_modal-editor-open' );
                $( '.airkit_editor-modal' ).removeClass( 'ts-is-hidden' );

                $( '.airkit_element-settings #ts-toggle-layout-builder' ).remove();

            } else {

                var data = {
                    action: 'airkit_edit_template_element',
                    nonce : gowatch.nonce,
                    elementType: elementType
                };

                $.post(
                    gowatch.ajaxurl,
                    data,
                    function( response ) {

                        $( '#airkit_builder-settings .airkit_modal-body' ).html( response );

                        airkit_setFieldsValues( settings );

                        var titleModal = $( response ).find( '[name="admin-label"]' ).val();

                        if ( '' == titleModal || 'undefined' == typeof( titleModal ) ) {

                            if ( 'column' == elementType || 'row' == elementType ) {

                                titleModal = elementType;

                            } else {

                                titleModal = $( '.airkit_elements-container' ).find( '[data-element-type="' + $( response ).find( '[name="element-type"]' ).val() + '"]' );
                            }
                        }

                        // Open the modal window (dialog) and set the title
                        airkit_openModal( titleModal, true );
                        $( 'body' ).addClass( 'ts-elements-modal-open' );

                        if ( 'row' == elementType || 'column' == elementType ) {

                            $( '.airkit_change-el' ).hide();

                        } else {

                            $( '.airkit_change-el' ).show();
                        }

                        $( '#ts-builder-elements-modal-preloader' ).hide();
                    }
                );
            }
        });

        $( document ).on( 'click', '.airkit_save-el', function( e ) {

            if ( $( '#airkit_builder-settings .airkit_export-options' ).length > 0 ) {

                currentEditedElement.replaceWith( $( '#airkit_builder-settings .airkit_export-options' ).val() );
                closeDialog();

                layout.init();

                return;
            }

            if( jQuery(this).closest('.ui-dialog').length )  {

                var modal_width  = jQuery(this).closest('.ui-dialog').width(),
                    modal_height = jQuery(this).closest('.ui-dialog').height() - jQuery(this).closest('.ui-dialog').find('.airkit_tabs').outerHeight(true);

                /* Save modal sizes */
                jQuery.cookie( 'airkit_size-settings', modal_width + ':' + modal_height, { expires: 30 } );
                
            }



            // Insert this all name of attr that has value json.
            var settings = {},
                container = 0 < $( this ).closest( '.airkit_editor-modal' ).length ? '.airkit_editor-modal' : '#airkit_builder-settings';

            // Insert this all name of attr that has value json.
            var container = 0 < $( this ).closest( '.airkit_editor-modal' ).length ? '.airkit_editor-modal' : '#airkit_builder-settings',
                settings = airkit_getValuesByNames( container + ' .airkit_element-settings' );

            closeDialog();

            var elementType = settings['element-type'];

            if ( 'text' == elementType ) {

                $( '.airkit_editor-modal' ).addClass( 'ts-is-hidden' );
                $( '.airkit_editor-modal' ).find( 'input[name="admin-label"]' ).val('Text');


                if( jQuery('#wp-ts_editor_id-wrap').hasClass('html-active') ) {
                    
                    settings.text = jQuery('#ts_editor_id').val();

                    // Set to null
                    jQuery('#ts_editor_id').html('');
                    
                } else {
                    settings.text = tinymce.get( 'ts_editor_id' ).getContent();
                    
                    // Set to null
                    tinymce.get( 'ts_editor_id' ).setContent( '' );
                    
                }

            }

            // If not empty settings, we stringify this object and put it as text in span.airkit_element-settings.
            if ( ! $.isEmptyObject( settings ) ) {

                currentEditedElement.find( '.airkit_element-settings' ).text( JSON.stringify( settings ) );
            }

            /*
             * Check if row is expanded or fullscreen, add coresponding class.
             */

            if( elementType == 'row' ) {

                if( settings.expand == 'y' || settings.fullscreen == 'y' ) {

                    currentEditedElement.closest('.layout_builder_row').attr('data-expanded', 'y');

                } else {

                    currentEditedElement.closest('.layout_builder_row').removeAttr('data-expanded');

                }

            }

            $( 'body' ).removeClass( 'ts-elements-modal-open airkit_modal-editor-open' );

            // If we have element row or column we do not have icon, admin label or text with name element.
            if ( elementType == 'row' || elementType == 'column' ) return;

            
            currentEditedElement.find( '.element-name' ).text( settings['admin-label'] );
            currentEditedElement.find( '.element-icon' ).attr( 'class', 'element-icon ' + settings['element-icon'] );
            currentEditedElement.find( '[data-element-type]' ).attr( 'data-element-type', elementType );


            e.preventDefault();
        });

        $( document ).on( 'click', '.airkit_change-el', function( e ) {

            e.preventDefault();

            $( 'body' ).removeClass( 'ts-elements-modal-open airkit_modal-editor-open' );
            $( '.airkit_editor-modal' ).addClass( 'ts-is-hidden' );

            setTimeout( function() {

                $( '.ts-all-elements' ).removeClass( 'ts-is-hidden' );

            }, 800 );
        });

        $( document ).on( 'click', '.airkit_cancel-el, .ui-dialog-titlebar-close', function( e ) {

            e.preventDefault();

            $( 'body' ).removeClass( 'ts-elements-modal-open airkit_modal-editor-open' );

            $( '.airkit_editor-modal' ).addClass( 'ts-is-hidden' );

            $( '[data-element-type="empty"]' ).closest( 'li' ).remove();
        });    
        
    });

    function airkit_setFieldsValues( settings )
    {
        var tmpl = $( '#airkit_builder-settings .airkit_tmpl' ).html(),
            fields = $( '#airkit_builder-settings .airkit_element-settings' );

        for ( var name in settings ) {

            if ( typeof settings[ name ] == 'object' ) {

                // Repopulate options filds that have attribute name in format name=x[y][z]. This means, what first object key is 'x', children of first key are 'y'...
                if ( ! $.isEmptyObject( settings[ name ] ) ) {

                    if ( fields.find( '[name="' + name + '"]' ).length > 0 ) {

                        fields.find( '[name="' + name + '"] option' ).each( function( i ) {

                            if ( $.inArray( $( this ).attr( 'value' ), settings[ name ] ) !== -1 || settings[ name ].hasOwnProperty( $( this ).attr( 'value' ) ) ) {

                                $( this ).attr( 'selected', 'selected' );
                            }
                        });

                    } else {

                        for ( var name2 in settings[ name ] ) {

                            if ( typeof settings[ name ][ name2 ] == 'object' ) {

                                /*
                                 * IF field is tmpl
                                 */

                                for ( var name3 in settings[ name ][ name2 ] ) {
                                    if ( fields.find( '[name="' + name + '[' + name2 + '][' + name3 + ']"]' ).length == 0 ) {

                                        var slideNr = parseInt( $( '.airkit_created-items > li' ).length ) + 1;

                                        $( '.' + name + '-multiple .airkit_created-items' ).append( tmpl.replace( new RegExp( '{id}', 'g' ), name2 ).replace( new RegExp( '{slide-nr}', 'g' ), slideNr ) );
                                    }

                                    fields.find( '[name="' + name + '[' + name2 + '][' + name3 + ']"]' ).val( settings[ name ][ name2 ][ name3 ] );
                                    
                                }

                            } else {

                                fields.find( '[name="' + name + '[' + name2 + ']"]' ).val( settings[ name ][ name2 ] );
                            }
                        }
                    }
                }

            } else {

                fields.find( '[name="' + name + '"]' ).val( settings[ name ] );

            }
        }

        // If we have selected images then we build them previews.
        airkit_buildPreviewImgs();

        // Start slider widget jquery ui.
        airkit_sliderPips();

        // Make selected img in image selector.
        airkit_imgSelector();

        // Make selected icons in icon selector.
        airkit_iconSelector();

        // Restart select plugin.
        airkit_multipleSelect();

        // Show / hide options wich depends each other.
        airkit_triggerOptions();

        // Set first tab active.
        $( '.airkit_tabs > li:first-child' ).trigger( 'click' );

        $( '#ts-builder-elements-modal-preloader' ).hide();

        $( '[data-sortable="true"]' ).sortable({ items : 'li', handle: '.sortable-meta-element, .image' });
    }

    function airkit_openModal( titleModal, show_buttons )
    {
        var buttons = [];

        if ( show_buttons ) {

            buttons = [
                {
                    text: 'Change element',
                    class: 'airkit_change-el',
                    icons: {
                        primary: 'icon-restart'
                    },
                    click: function() {
                        $( this ).dialog( 'close' );
                    }
                },
                {
                    text: 'Save',
                    class: 'airkit_save-el',
                    icons: {
                        primary: 'icon-save'
                    },
                    click: function() {
                        $( this ).dialog( 'close' );
                    }
                },
                {
                    text: 'Cancel',
                    class: 'airkit_cancel-el',
                    icons: {
                        primary: 'icon-cancel'
                    },
                    click: function() {
                        $( this ).dialog( 'close' );
                    }
                }
            ];
        }
    
        var modal_width = 800,
            modal_height = 600;

        if( typeof jQuery.cookie( 'airkit_size-settings' ) !== 'undefined' ) {

            var modal_size = jQuery.cookie( 'airkit_size-settings' ).split(':');

            modal_width = modal_size[0];
            modal_height = modal_size[1];

        }

        $( '#airkit_builder-settings' ).dialog({
            width: modal_width,
            height: modal_height,
            title: 'Edit ' + titleModal,
            buttons: buttons,

            show: {
                effect: 'fadeIn',
                duration: 250,
            },

            hide: {
                effect: 'fadeOut',
                duration: 200,
            },

            close: function( event, ui ) {

                $( '#airkit_builder-settings .airkit_modal-body' ).html( '' );
                $('.ui-dialog').find( '.ui-dialog-titlebar .airkit_tabs' ).remove();
                $('body').removeClass('ts-elements-modal-open');

                airkit_enableScrolling();
            },

            open: function( event, ui ) {
                initColorpicker();

                if ( $( '#map-canvas' ).length > 0 ) {

                    var map = initialize();
                    google.maps.event.trigger( map, 'resize' );
                    codeAddress();
                }

                // Move tabs to modal header
                var parentModal = jQuery( '#airkit_builder-settings' ).parent('.ui-dialog');

                if( parentModal.find( '.ui-dialog-titlebar .airkit_tabs' ).length == 0 ) {
                
                    $( '#airkit_builder-settings .airkit_tabs' ).appendTo( parentModal.find('.ui-dialog-titlebar') );

                }
                
                //re-calc slider values for mosaic no.of posts
                airkit_mosaicNumberOfPosts();
            },

            resizeStop: function( event, ui ) {

                if ( $( '#map-canvas' ).length > 0 ) {

                    google.maps.event.trigger( map, 'resize' );
                }
            }
        });

        // Restart select plugin.
        airkit_multipleSelect();

        $( '.airkit_change-el, .airkit_save-el, .airkit_cancel-el' ).find( 'span' ).removeClass( 'ui-button-icon-primary ui-icon' );
    }

    function closeDialog()
    {
        if ( $( '#airkit_builder-settings' ).hasClass( 'ui-dialog-content' ) ) {

            $( '#airkit_builder-settings' ).dialog( 'close' );
        }
    }


    // Search elements

    jQuery(document).on('keyup', '.builder-element-search .airkit_modal-search', function(){

        var $this = jQuery( this );

        delay( function() {

            var filterDivs = jQuery( $this ).closest( '.builder' ).find( '.airkit_elements-container li' );

            if ( $this.val() == '' ) {

                filterDivs.show( 300 );

            } else {

                var show = filterDivs.filter( function () { 

                    return ( jQuery( this ).find('> span').text().toLowerCase().indexOf( $this.val().toLowerCase() ) > -1 );

                });
                    
                filterDivs.not( show ).hide( 200 );

                show.show( 300 );
            }

        }, 300 );
    });


    var rowOptions = {
        connectWith :'.layout_builder_row',
        placeholder : 'ui-state-highlight',
        items : '>li:not(.empty-row, .row-editor, .builder-row-actions)',
        cancel: 'span.add-element, .layout_builder .edit, .layout_builder .delete'
    };

    var layout = {

        init: function() {

            $('.layout_builder').sortable({
                cancel: 'li a.row-editor, li a.add-column, li a.remove-row, li a.edit-row, .layout_builder .edit, .layout_builder .delete, span.add-element, span.delete-column',
                stop: function( event, ui ) {
                    window.builderDataChanged = true;
                }
            });

            $('.layout_builder_row').sortable( rowOptions );

            $('.elements').sortable({
                items : 'li',
                connectWith :'.elements',
                cancel: '.layout_builder .edit, .layout_builder .delete',
                stop: function( event, ui ) {

                    window.builderDataChanged = true;
                }
            });
        },

        validateAction : function() {

            if ( confirm( 'Are you sure?' ) === false ) {

                return false;

            } else {

                return true;
            }
        },

        columnSizeInfo : function (size) {

            switch( size ) {
                case 2:
                    size = '1/6';
                    break;
                case 3:
                    size = '1/4';
                    break;
                case 4:
                    size = '1/3';
                    break;
                case 5:
                    size = '5/12';
                    break;
                case 6:
                    size = '1/2';
                    break;
                case 7:
                    size = '7/12';
                    break;
                case 8:
                    size = '2/3';
                    break;
                case 9:
                    size = '3/4';
                    break;
                case 10:
                    size = '5/6';
                    break;
                case 11:
                    size = '11/12';
                    break;
                case 12:
                    size = '12/12';
                    break;
                default:
                    size = '';
            }

            return size;
        },

        // calculate the size of columns in a specific row
        rowSize : function( row ) {
            var sum = 0;

            row.find( '>li:not(.empty-row, .row-editor, .builder-row-actions)' ).each( function( index, element ) {

                sum += parseInt($(this).attr("data-size"), 10);
            });

            return sum;
        },

        // return the row of
        getElementRow : function( ui ) {

            return $( ui.item ).parent();

        },

        getSettings: function( el ) {

            var strJson = $( el ).find( '.airkit_element-settings' ).eq(0).text(),
                elementType = $( el ).find( '[data-element-type]' ).eq(0).data( 'element-type' ),
                settings = {};

            try {

                settings = JSON.parse( strJson );

            } catch( e ) {

                settings = {'element-type' : elementType};
            }

            return settings;
        },

        save: function ( location ) {

            var content = $( '#section-content>ul' ),
                templateData = {},
                template_id,
                template_name;

            if ( location === 'page' ) {

                template_id = $('#airkit_layout_id').find('#ts-template-id').val();
                template_name = $('#airkit_layout_id').find('#ts-template-name').text();

                templateData = {
                    'post_id': $('#post_ID').val(),
                    'content': [],
                    'template_id': template_id,
                    'template_name': template_name
                };

            } else {

                template_id = $('#ts-template-id').val();
                template_name = $('#ts-template-name').text();

                if (location === 'header') {

                    templateData = {
                        'gowatch_header': 1,
                        'content': [],
                        'template_id': template_id,
                        'template_name': template_name
                    };

                } else if (location === 'footer') {

                    templateData = {
                        'gowatch_footer': 1,
                        'content': [],
                        'template_id': template_id,
                        'template_name': template_name
                    };
                }
            }

            // iterate over the content rows
            $.each( content, function( index, row ) {

                var parsedRow = {};

                parsedRow.settings = layout.getSettings( row );
                parsedRow.columns = [];

                // select columns
                columns = $( row ).find( '>li:not(.row-editor, .builder-row-actions)' );

                // iterate over the columns
                $.each( columns, function( index, column ) {

                    var c = {};

                    c.settings = layout.getSettings( column );
                    c.elements = [];

                    var elements = $( column ).find( '.elements > li' );

                    // iterate over the column elements
                    $.each( elements, function( index, element ) {

                        c.elements.push( layout.getSettings( element ) );
                    });

                    parsedRow.columns.push( c );
                });

                // add row to the header
                templateData.content.push( parsedRow );
            });

            return templateData;
        }
    };

    layout.init();

    $(document).on('click','.publish-changes, .editor-post-publish-button' ,function(event) {
        event.preventDefault();


        // Do not trigger if builder is disabled
        if( jQuery('#ts-toggle-layout-builder').attr('data-state') == 'disabled' ) {
            return false;
        }

        var success = false,
            content,
            d = {};

        content = layout.save( 'page' );

        d.mode = 'update';
        d['location'] = 'page';
        d['data'] = JSON.stringify(content);

        jQuery.ajax({
            data: d,
            url: ajaxurl + '?action=airkit_save_layout',
            async: false,
            type: "POST"
        }).done(function(data) {

            if ( data.status === 'ok' ) {

                window.builderDataChanged = false;
                success = true;

                var n = noty({
                    layout: 'bottomCenter',
                    type: 'success',
                    timeout: 4000,
                    text: 'Options has been saved.'
                });

            } else {

                success = false;
                var n = noty({
                    layout: 'bottomCenter',
                    type: 'error',
                    timeout: 4000,
                    text: data.message
                });

            }

        }).fail(function(data) {
            success = false;
        });

        if (!success) {
            $("#ajax-loading").hide();
            $("#publish").removeClass("button-primary-disabled");

            var n = noty({
                layout: 'bottomCenter',
                type: 'error',
                timeout: 4000,
                text: data.message
            });

            return false;
        } else {
            return true;
        }
    });

    jQuery(document).on('click', '.builder-row-actions .row-toggle-options', function(event){
        event.preventDefault();
        jQuery(this).siblings().toggleClass('visible');
        return false;
    });

    jQuery(document).on('click', '.column-header .toggle-options', function(event){
        event.preventDefault();
        jQuery(this).toggleClass('no-tooltip');
        jQuery(this).children('span').toggle(200);
        return false;
    });    

    // Increase column size
    $(document).on('click', '.layout_builder_row span.plus', function(event) {
        event.preventDefault();

        var element = $(this).parent().parent(),
            row = element.parent(),
            current_size = parseInt(element.attr("data-size"), 10);

        current_size++;
        window.builderDataChanged = true;

        if (current_size <= 12 ) {

            element.find('.column-size').html(layout.columnSizeInfo(current_size));
            element.attr('class', 'columns' + current_size);
            element.attr("data-size", current_size);

            var strJson = $( this ).closest( 'li' ).find( '.column-header .airkit_element-settings' ).text(),
                settings = '' == strJson ? {} : JSON.parse( strJson );

            settings.size = current_size;

            $( this ).closest( 'li' ).find( '.column-header .airkit_element-settings' ).text( JSON.stringify( settings ) );

        } else {
            var n = noty({
                layout: 'bottomCenter',
                type: 'error',
                timeout: 4000,
                text: 'The the maximum value of column is 12'
            });
        }
    });

    // Decrease column size
    $(document).on('click', '.layout_builder_row span.minus', function(event) {
        event.preventDefault();

        var element = $( this ).parent().parent(),
            current_size = parseInt( element.attr( 'data-size' ), 10 );

        window.builderDataChanged = true;
        current_size--;

        if ( current_size >= 2 ) {

            element.find('.column-size').html(layout.columnSizeInfo(current_size));
            element.attr('class', 'columns' + current_size);
            element.attr("data-size", current_size);

            var strJson = $( this ).closest( 'li' ).find( '.column-header .airkit_element-settings' ).text(),
                settings = '' == strJson ? {} : JSON.parse( strJson );

            settings.size = current_size;

           $( this ).closest( 'li' ).find( '.column-header .airkit_element-settings' ).text( JSON.stringify( settings ) );

        } else {
            var n = noty({
                layout: 'bottomCenter',
                type: 'error',
                timeout: 4000,
                text: 'The minimum value of column is 2'
            });
        }
    });

    // Clone element
    $(document).on('click', '.layout_builder_row span.clone', function(event) {
        event.preventDefault();

        if ( $( this ).hasClass( 'ts-clone-column' ) ) {

            $( this ).closest( 'ul.layout_builder_row' ).append( $( this ).closest( 'li' ).clone() );

        } else {

            var element = $(this).parent();
            var element_html = $(this).parent().clone();
            $(element).parent().append(element_html);
        }

        layout.init();

        window.builderDataChanged = true;

    });

    $(document).on( 'click', '.airkit_export-element, .airkit_export-row', function( event ) {
        event.preventDefault();

        airkit_openModal( 'Export element', false );

        var exportHtml = '';

        if ( $( this ).hasClass( 'airkit_export-row' ) ) {

            exportHtml = $( this ).closest( '.layout_builder_row' )[0].outerHTML;

        } else {

            exportHtml = $( this ).closest( 'li' )[0].outerHTML;
        }

        $( '#airkit_builder-settings .airkit_modal-body' ).html( $( '.airkit_export-modal' ).html() );

        $( '#airkit_builder-settings .airkit_export-options' ).val( exportHtml );
    });

    $( document ).on( 'click', '.airkit_import-element', function( event ) {
        event.preventDefault();

        airkit_openModal( 'Import element', true );

        $( '#airkit_builder-settings .airkit_modal-body' ).html( $( '.airkit_export-modal' ).html() );

        $( '#airkit_builder-settings .airkit_export-options' ).val( '' );

        if ( $( this ).attr( 'data-element-type' ) == 'import' ) return;

        if ( $( this ).parent().hasClass( 'row-actions-list' ) ) {

            window.currentEditedElement = $( this ).closest( '.layout_builder_row' );

        } else {

            window.currentEditedElement = $( this ).closest( 'li' );
        }
    });

    // Add element
    $(document).on('click', '.layout_builder_row span.add-element', function(event) {
        event.preventDefault();

        var column   = $(this).parent(),
            element  = $('#dragable-element-tpl').html(),
            elements = column.find('.elements');

        elements.append(element);
        elements.sortable({items : 'li', connectWith :'.elements'});
        window.currentEditedElement = $(this).prev('ul.elements').find('li:last-child');

        $('.ts-all-elements').removeClass('ts-is-hidden');
        $('.ts-tab-elements li').first().trigger('click');
        $('body').addClass('ts-elements-modal-open');

        jQuery('.builder-element-search input[type="text"]').focus().val('')

        closeDialog();

        window.builderDataChanged = true;
    });

    $( document ).on( 'click', '.ts-tab-elements li', function() {

        var categoryTab = $(this).attr('data-ts-tab');
        $('.ts-tab-elements li.selected').removeClass('selected');
        $(this).addClass('selected');

        $('.builder-element-array li').each(function(){

            if( $(this).attr('data-ts-tab-element') == categoryTab ){
                $(this).css('display', '');
            }else{
                $(this).css('display', 'none');
            }

            if( categoryTab == 'ts-all-tab' ){
                $(this).css('display', '');
            }

        });
    });

    // ------ Rows section -------------------------------------------------------------

    // Inserting a row to the top
    $('.add-top-row').on('click', function(event) {
        event.preventDefault();
        var location    = "#section-" + $(this).attr('data-location'),
            rowSource   = $("#dragable-row-tpl").html(),
            template    = Handlebars.compile(rowSource),
            context     = {},
            rowTemplate = $(template(context));

        builderDataChanged = true;
        $(location).prepend(rowTemplate).sortable("refresh");
        $('.layout_builder_row').sortable(rowOptions);
    });

    // Inserting a row to the bottom
    $('.add-bottom-row').on('click', function(event) {
        event.preventDefault();
        var location    = "#section-" + $(this).attr('data-location'),
            rowSource   = $("#dragable-row-tpl").html(),
            template    = Handlebars.compile(rowSource),
            context     = {},
            rowTemplate = $(template(context));

        builderDataChanged = true;
        $(location).append(rowTemplate).sortable("refresh");
        $('.layout_builder_row').sortable(rowOptions);
    });

    // Publish th changes
    $('.publish-changes').on('click', function(event) {
        event.preventDefault();

        $('#ts-builder-elements-modal-preloader').show();

        var success = false,
            content,
            d = {};

        content = layout.save('page');
        d.mode = 'update';
        d['location'] = 'page';
        d['data'] = JSON.stringify(content);

        jQuery.ajax({
            data: d,
            url: ajaxurl + '?action=airkit_save_layout',
            async: false,
            type: "POST"
        }).done(function(data){

            $('#ts-builder-elements-modal-preloader').hide();

            if( data.status === 'ok' ){

                window.builderDataChanged = false;

                var n = noty({
                    layout: 'bottomCenter',
                    type: 'success',
                    timeout: 4000,
                    text: 'Options has been saved.'
                });

            }else{

                var n = noty({
                    layout: 'bottomCenter',
                    type: 'error',
                    timeout: 4000,
                    text: data.message
                });
            }

        }).fail( function( data ) {

            var n = noty({
                layout: 'bottomCenter',
                type: 'error',
                timeout: 4000,
                text: "Error! Template can't be saved"
            });

            $('#ts-builder-elements-modal-preloader').hide();

            window.builderDataChanged = true;

        });

    });

    // Remove row
    $(document).on('click', '.remove-row', function(event) {
        event.preventDefault();
        if( ! layout.validateAction()) return;
        $(this).closest('ul.layout_builder_row').remove();
        builderDataChanged = true;
    });

    // ------ Columns section ----------------------------------------------------------

    // Show predefined column layouts
    $(document).on('click', '.predefined-columns', function(event) {
        event.preventDefault();
        $(this).next().toggle();
    });
    // Predefined column options
    $(document).on('click', '.add-column-settings li a', function(event) {
        event.preventDefault();

        builderDataChanged = true;
        var $this = $(this),
            row = $this.closest('ul.layout_builder_row'),
            column_layout = $this.attr('data-add-columns'),
            column = $(column_layout).html();

            row.append(column);

            $('.elements').sortable({items : 'li', connectWith :'.elements', cancel: '.layout_builder .edit, .layout_builder .delete'});
            $('.add-column-settings').hide();
    });

    // Add column to the row
    $(document).on('click', '.add-column', function(event) {
        event.preventDefault();

        var $this = $(this),
            row = $this.closest('ul.layout_builder_row'),
            column = $('#dragable-column-tpl').html();
            row.append(column);
            $('.elements').sortable({items : 'li', connectWith :'.elements', cancel: '.layout_builder .edit, .layout_builder .delete'});
    });

    // Remove column
    $(document).on('click', '.layout_builder_row span.delete-column', function( e ) {
        e .preventDefault();

        if ( ! layout.validateAction() ) return;

        $( this ).closest( 'li' ).remove();

    });

    // Close the elements modal
    $( document ).on( 'click', '.airkit_modal .close, .airkit_button-close', function( e ) {
        e.preventDefault();

        $( this ).closest( '.airkit_modal' ).addClass( 'ts-is-hidden' );

        $( 'body' ).removeClass( 'ts-elements-modal-open airkit_modal-editor-open' );

        tinymce.get( 'ts_editor_id' ).setContent( '' );

        $( '[data-element-type="empty"]' ).closest( 'li' ).remove();
    });

    // Remove element
    $( document ).on( 'click', '.layout_builder_row span.delete', function( e ) {
        e.preventDefault();

        if( ! layout.validateAction() ) return;

        $( this ).parent().remove();

        builderDataChanged = true;
    });

    // ------ Layout section ----------------------------------------------------------

    // Create new layout
    $('#create-new-layout').on('click', function(event) {
        event.preventDefault();
        window.location.href = $(this).data('create-uri');
    });

    // Create Layout > Structure
    $('ul#layout-type label').on('click', function(event) {

        event.stopPropagation();
        $_this = $(this).parent();
        var layoutTypes = $_this.parent().find('li');

        $.each(layoutTypes, function(index, val) {
            var layout = $(val);
            if ( layout.hasClass('selected-layout') ) {
                layout.removeClass('selected-layout');
            }
        });

        if ( ! $_this.hasClass('selected-layout') ) {
            $_this.addClass('selected-layout');
        }
    });

    // Save template
    $(document).on('click', '#save-template', function(event) {
        event.preventDefault();
        layout.save();
    });

    // save header and footer
    $(document).on('click', '#save-header-footer', function(event) {
        event.preventDefault();
        var location = $(this).attr('data-location');

        var n,
            d = {},
            u = {};

        // Create the array with header and footer settings
        $('[name^="' + location + '"]').each(function() {
            var attributeName   = $(this).attr('name').toString();
            u[attributeName]    = $(this).val();
        });
        u = JSON.stringify( u );

        d.mode = 'update';
        d['location'] = location;
        d['predefined-style'] = $('#ts-predefined-style').val();
        d['options'] = u;
        d['data'] = JSON.stringify( layout.save( location ) );

        jQuery.ajax({
            data: d,
            url: ajaxurl + '?action=airkit_save_layout',
            async: false,
            type: "POST"
        }).done(function(e) {
            if ( e.status === 'ok' ) {
                n = noty({
                    layout: 'bottomCenter',
                    type: 'success',
                    timeout: 4000,
                    text: 'Template saved'
                });
            } else {
                n = noty({
                    layout: 'bottomCenter',
                    type: 'error',
                    timeout: 4000,
                    text: data.message
                });
            }
        }).fail(function(data) {
            n = noty({
                layout: 'bottomCenter',
                type: 'error',
                timeout: 4000,
                text: "Error! Template can't be saved"
            });
        });
    });

    // Save blank tempalte
    $(document).on('click', '#ts-save-blank-template-action', function(event) {

        event.preventDefault();

        var element = $(this);
        var closeModal = element.siblings('button').trigger("click");
        var template_id;
        var location = element.attr( 'data-location' );
        var template_name = $('#ts-blank-template-name').val();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action': 'airkit_save_layout',
                'mode': 'blank_template',
                'template_name': template_name,
                'location': location
            }
        }).done( function( data ) {

            var blankTemplateName = $('#ts-blank-template-name');

            if (data['status'] === 'ok') {
                $('#ts-template-id').val(data.template_id);
                $('#ts-template-name').text(blankTemplateName.val());
                $('.layout_builder').html('');
            } else {
                alert("Error");
            }

            blankTemplateName.val("");

        }).fail(function() {
            alert("Error");
        });

    });

    // Save as... tempalte
    $(document).on('click', '#ts-save-as-template', function( e ) {
        e.preventDefault();

        $( '#ts-save-template-modal' ).removeClass( 'ts-is-hidden' );
    });

    // Save as... tempalte action
    $( document ).on( 'click', '#ts-save-as-template-action', function( e ) {

        e.preventDefault();

        var element = $( this ),
            closeModal = element.siblings( 'button' ),
            template_name = $( '#ts-save-template-name' ).val(),
            location = element.attr( 'data-location' ),
            l = layout.save( location );

        var data = {
                action: 'airkit_save_layout',
                mode: 'save_as',
                template_name: template_name,
                location: location,
                data: JSON.stringify( l )
        };

        if ( typeof l['post_id'] !== "undefined" ) {

            data['post_id'] = l['post_id'];
        }

        if ( typeof l['gowatch_header'] !== "undefined" ) {

            data['gowatch_header'] = l['gowatch_header'];
        }

        if ( typeof l['gowatch_footer'] !== "undefined" ) {

            data['gowatch_footer'] = l['gowatch_footer'];
        }

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: data
        }).done( function( data ) {

            if ( data.status === 'ok' ) {

                $( '#ts-save-template-modal' ).addClass( 'ts-is-hidden' );

                var n = noty({
                    layout: 'bottomCenter',
                    type: 'success',
                    timeout: 4000,
                    text: 'Template has been saved.'
                });

            } else {

                alert( data.message );
            }

        }).fail( function() {

            alert( 'Error' );
        });
    });

    // Load template button
    $( document ).on( 'click', '#ts-load-template-button', function( e ) {

        e.preventDefault();

        var element = $( this );
        var location = element.attr( 'data-location' );
        var defaultTemplate;

        $( '#ts-builder-elements-modal-preloader' ).show();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            cache: false,
            data: {
                action: 'airkit_load_all_templates',
                location: location
            }
        }).done( function( data ) {

            $( '#ts-builder-elements-modal-preloader' ).hide();
            $( '#ts-layout-list' ).html( data );
            $( '#ts-load-template' ).removeClass( 'ts-is-hidden' );

        }).fail( function() {

            alert( 'Error' );
        });
    });

    // Load template action
    $( document ).on( 'click', '#ts-load-template-action', function( e ) {

        e.preventDefault();

        $( '#ts-load-template' ).addClass( 'ts-is-hidden' );
        $( '#ts-builder-elements-modal-preloader' ).show();

        var element = $( this );
        var template_id;
        var location = element.attr( 'data-location' );

        var template_id = element.closest( '.airkit_modal' ).find( 'input[type="radio"]:checked' ).val();

        $.ajax({
            url: ajaxurl,
            type: 'GET',
            dataType: 'json',
            data: { action: 'airkit_load_template', 'location': location, 'template_id': template_id }
        }).done( function( data ) {

            $( '#ts-builder-elements-modal-preloader' ).hide();

            $( '#ts-template-id' ).val( data['template_id'] );
            $( '#ts-template-name' ).text( data['name'] );
            $( '.layout_builder' ).html( data['elements'] );

            layout.init();

            var n = noty({
                layout: 'bottomCenter',
                type: 'success',
                timeout: 4000,
                text: 'Template has been loaded.'
            });

        }).fail( function() {

            alert( 'Error' );
        });
    });

    // Remove template
    $( document ).on( 'click', '.ts-remove-template', function( e ) {

        e.preventDefault();

        if ( ! layout.validateAction() ) return;

        var element = $( this );
        var template_id = element.attr( 'data-template-id' );
        var location = element.attr( 'data-location' );

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'airkit_remove_template',
                location: location,
                template_id: template_id
            }
        }).done( function( data ) {

            if ( data['status'] === 'removed' ) {

                element.closest( 'tr' ).fadeOut( 'slow' ).remove();

            } else {

                alert( data.message );
            }

        }).fail( function() {

            alert( 'Error' );
        });
    });

    $( '#publish' ).on( 'click', function() {
        window.builderDataChanged = false;
    });

    window.onbeforeunload = airkit_askUser;

    window.builderDataChanged = false;

    function airkit_askUser(){

        if (window.builderDataChanged == true) {
            return "The changes you made will be loast if you navigate away from this page";
        }

    }

    $( document ).scroll( function() {
        if ( $( '.airkit_colorpicker' ).is(':visible') ) {

            $( '.airkit_colorpicker' ).colorpicker( 'hide' );

        }
    });

    $( '#airkit_builder-settings' ).scroll( function() {
        $( '.airkit_colorpicker' ).colorpicker( 'hide' );
    });

    $( '#airkit_builder-settings' ).mouseenter( function() {

        airkit_disableScrolling();

    }).mouseleave( function() {

        airkit_enableScrolling();

    });

    function airkit_disableScrolling() {
        var x = window.scrollX;
        var y = window.scrollY;

        window.onscroll = function(){ window.scrollTo( x, y ); };
    }

    function airkit_enableScrolling() {
        window.onscroll = function() {};
    }

})( jQuery );
