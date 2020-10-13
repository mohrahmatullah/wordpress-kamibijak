/*jshint devel:true */
/*global ajaxurl */

;(function($) {

    var $formEditor = $('ul#tszf-form-editor');

    var Editor = {
        init: function() {

            $(function() {
                $('.tszf-ms-color').wpColorPicker();
            });

            // make it sortable
            this.makeSortable();

            this.tooltip();
            this.tabber();
            this.showHideHelp();

            var this_obj = this;
            // Form Settings
            $('#tszf-metabox-settings').on('change', 'select[name="tszf_settings[redirect_to]"]', this.settingsRedirect);
            $('#tszf-metabox-settings-update').on('change', 'select[name="tszf_settings[edit_redirect_to]"]', this.settingsRedirect);
            $('select[name="tszf_settings[redirect_to]"]').change();
            $('select[name="tszf_settings[edit_redirect_to]"]').change();

            // Form settings: Guest post
            $('#tszf-metabox-settings').on('change', 'input[type=checkbox][name="tszf_settings[guest_post]"]', this.settingsGuest);
            $('input[type=checkbox][name="tszf_settings[guest_post]"]').trigger('change');

            // From settings: User details
            $('#tszf-metabox-settings').on('change', 'input[type=checkbox][name="tszf_settings[guest_details]"]', this.settingsGuestDetails);
            // $('input[type=checkbox][name="tszf_settings[guest_details]"]').trigger('change');

            // collapse all
            $('button.tszf-collapse').on('click', this.collpaseEditFields);

            // add field click
            $('.tszf-form-buttons').on('click', 'button', this.addNewField);

            // remove form field
            $('#tszf-form-editor').on('click', '.tszf-remove', this.removeFormField);

            // on change event: meta key
            $('#tszf-form-editor').on('change', 'li.custom-field input[data-type="label"]', this.setMetaKey);

            // on change event: checkbox|radio fields
            $('#tszf-form-editor').on('change', '.tszf-form-sub-fields input[type=text]', function() {
                var self = $(this),
                    value = self.closest('div').find('input[data-type=option_value]').val();

                if ( value === '' ) {
                    var replace_val = self.closest('div').find('input[data-type=option]').val();
                    self.siblings('input[type=checkbox], input[type=radio]').val(replace_val);
                } else {
                   self.siblings('input[type=checkbox], input[type=radio]').val(value);
                }


            });

            // on change event: checkbox|radio fields
            $('#tszf-form-editor').on('click', 'input[type=checkbox].multicolumn', function() {
                // $(this).prev('input[type=checkbox], input[type=radio]').val($(this).val());
                var $self = $(this),
                    $parent = $self.closest('.tszf-form-rows');

                if ($self.is(':checked')) {
                    $parent.next().hide().next().hide();
                    $parent.siblings('.column-names').show();
                } else {
                    $parent.next().show().next().show();
                    $parent.siblings('.column-names').hide();
                }
            });

            jQuery('#tszf-form-editor').on('change', 'select[data-select-tab-action]', function(){
                var $self = $(this);

                if( $self.val() === 'end' ) {
                    $self.parents('li.tab_content').addClass('last-tab');
                }
            });

            if( jQuery('select[data-select-tab-action]').length ) {
                jQuery('select[data-select-tab-action]').each(function(){
                    if( $(this).val() == 'end' ) {
                        $(this).parents('li.tab_content').addClass('last-tab');
                    }
                })
            }

            // jQuery('#tszf-form-editor > li.tab_content').nextUntil('.tab_content').css('margin-left', '30px');
            // jQuery('#tszf-form-editor > li.tab_content').last().nextAll('li').css('margin-left', '0');

            // on change event: checkbox|radio fields
            $('#tszf-form-editor').on('click', 'input[type=checkbox].retype-pass', function() {
                // $(this).prev('input[type=checkbox], input[type=radio]').val($(this).val());
                var $self = $(this),
                    $parent = $self.closest('.tszf-form-rows');

                if ($self.is(':checked')) {
                    $parent.next().show().next().show();
                } else {
                    $parent.next().hide().next().hide();
                }
            });

            // woo attribute
            $('#tszf-form-editor').on('click', 'input[type=checkbox].woo_attr', function() {
                var $self = $(this),
                    $parent = $self.closest('.tszf-form-rows');

                if ($self.is(':checked')) {
                    $parent.next().show();
                } else {
                    $parent.next().hide();
                }
            });

            // toggle form field
            $('#tszf-form-editor').on('click', '.tszf-toggle', this.toggleFormField);

            // clone and remove repeated field
            $('#tszf-form-editor').on('click', 'img.tszf-clone-field', this.cloneField);
            $('#tszf-form-editor').on('click', 'img.tszf-remove-field', this.removeField);
            $('#tszf-form-editor').on('click', '.tszf-value-handelar', this.showValueField);

            //on change enable expiration check status
            this.changeExpirationFieldVisibility(':checkbox#tszf-enable_post_expiration')
            $('.tszf-metabox-post_expiration').on('change',':checkbox#tszf-enable_post_expiration',this.changeExpirationFieldVisibility);
            //on change expiration type drop down
            //$('.tszf-metabox-post_expiration').on('change','select#tszf-expiration_time_type',this.setTimeExpiration);

            this_obj.changeMultistepVisibility( $('.tszf_enable_multistep_section :input[type="checkbox"]') );
            $('.tszf_enable_multistep_section :input[type="checkbox"]').click(function(){
                this_obj.changeMultistepVisibility( $(this) );
            });

            //when changing the post type from the drop down
            $(document).on( 'change', ':input[name="tszf_settings[post_type]"]', function() {
                $('.attributes_holder, .tszf-custom-tax-btn', '.tszf-taxonomies-holder ' ).hide();
                $( '.attributes_holder.' + $(this).val() + ', .tszf-custom-tax-btn.' + $(this).val(),'.tszf-taxonomies-holder ').show();
            } );
        },

        changeMultistepVisibility : function( target ){
            if(target.is(':checked')){
                $('.tszf_multistep_content').show();
            }else{
                $('.tszf_multistep_content').hide();
            }
        },

        showValueField: function() {
            var self = $(this),
                field = self.closest('div').find( 'input[data-type=option_value], span.tszf-option-value');

            if ( self.is(':checked') ) {
                field.show();
            } else {
                field.hide();
            }

        },

        showHideHelp: function() {
            var childs = $('ul#tszf-form-editor').children('li');

            if ( !childs.length) {
                $('.tszf-updated').show();
            } else {
                $('.tszf-updated').hide();
            }
        },

        makeSortable: function() {
            $formEditor = $('ul#tszf-form-editor');

            if ($formEditor) {
                $formEditor.sortable({
                    placeholder: "ui-state-highlight",
                    handle: '> .tszf-legend',
                    distance: 5
                });
            }
        },

        addNewField: function(e) {
            e.preventDefault();

            var $self = $(this),
                $formEditor = $('ul#tszf-form-editor'),
                name = $self.data('name'),
                type = $self.data('type'),
                data = {
                    name: name,
                    type: type,
                    order: $formEditor.find('li').length + 1,
                    action: 'tszf_form_add_el'
                };

            // console.log($self, data);

            // check if these are already inserted
            var oneInstance = ['post_title', 'post_content', 'post_excerpt', 'featured_image',
                'user_login', 'first_name', 'last_name', 'nickname', 'user_email', 'user_url',
                'user_bio', 'password', 'user_avatar'];

            if ($.inArray(name, oneInstance) >= 0) {
                if( $formEditor.find('li.' + name).length ) {
                    alert('You already have this field in the form');
                    return false;
                }
            }

            $('.tszf-loading').removeClass('hide');
            $.post(ajaxurl, data, function(res) {
                $formEditor.append(res);

                // re-call sortable
                Editor.makeSortable();

                // enable tooltip
                Editor.tooltip();

                $('.tszf-loading').addClass('hide');
                Editor.showHideHelp();
            });
        },

        removeFormField: function(e) {
            e.preventDefault();

            if (confirm('are you sure?')) {

                $(this).closest('li').fadeOut(function() {
                    $(this).remove();

                    Editor.showHideHelp();
                });
            }
        },

        toggleFormField: function(e) {
            e.preventDefault();

            $(this).closest('li').find('.tszf-form-holder').slideToggle('fast');
        },

        cloneField: function(e) {
            e.preventDefault();

            var $div = $(this).closest('div');
            var $clone = $div.clone();
            // console.log($clone);

            //clear the inputs
            $clone.find('input').val('');
            $clone.find(':checked').attr('checked', '');
            $div.after($clone);
        },

        removeField: function() {
            //check if it's the only item
            var $parent = $(this).closest('div');
            var items = $parent.siblings('.tszf-clone-field').andSelf().length;

            if( items > 1 ) {
                $parent.remove();
            }
        },

        setMetaKey: function() {
            var $self = $(this),
                val = $self.val().toLowerCase().split(' ').join('_').split('\'').join(''),
                $metaKey = $(this).closest('.tszf-form-rows').next().find('input[type=text]');

            val = val.replace(/[^a-z0-9]|\s+|\r?\n|\r/gmi, "_");

            if ($metaKey.length && !$metaKey.val()) {
                $metaKey.val(val);
            }
        },

        tooltip: function() {
            $('.smallipopInput').smallipop({
                preferredPosition: 'right',
                theme: 'black',
                popupOffset: 0,
                triggerOnClick: true
            });
        },

        collpaseEditFields: function(e) {
            e.preventDefault();

            $('ul#tszf-form-editor').children('li').find('.tszf-form-holder').slideToggle();
        },

        settingsGuest: function (e) {
            e.preventDefault();

            var table = $(this).closest('table');

            if ( $(this).is(':checked') ) {
                table.find('tr.show-if-guest').show();
                table.find('tr.show-if-not-guest').hide();

                $('input[type=checkbox][name="tszf_settings[guest_details]"]').trigger('change');

            } else {
                table.find('tr.show-if-guest').hide();
                table.find('tr.show-if-not-guest').show();
            }
        },

        settingsGuestDetails: function (e) {
            e.preventDefault();

            var table = $(this).closest('table');

            if ( $(this).is(':checked') ) {
                table.find('tr.show-if-details').show();
            } else {
                table.find('tr.show-if-details').hide();
            }
        },

        settingsRedirect: function(e) {
            e.preventDefault();

            var $self = $(this),
                $table = $self.closest('table'),
                value = $self.val();

            switch( value ) {
                case 'post':
                    $table.find('tr.tszf-page-id, tr.tszf-url, tr.tszf-same-page').hide();
                    break;

                case 'page':
                    $table.find('tr.tszf-page-id').show();
                    $table.find('tr.tszf-same-page').hide();
                    $table.find('tr.tszf-url').hide();
                    break;

                case 'url':
                    $table.find('tr.tszf-page-id').hide();
                    $table.find('tr.tszf-same-page').hide();
                    $table.find('tr.tszf-url').show();
                    break;

                case 'same':
                    $table.find('tr.tszf-page-id').hide();
                    $table.find('tr.tszf-url').hide();
                    $table.find('tr.tszf-same-page').show();
                    break;
            }
        },

        tabber: function() {
            // Switches option sections
            $('.group').hide();
            $('.group:first').fadeIn();

            $('.group .collapsed').each(function(){
                $(this).find('input:checked').parent().parent().parent().nextAll().each(
                function(){
                    if ($(this).hasClass('last')) {
                        $(this).removeClass('hidden');
                        return false;
                    }
                    $(this).filter('.hidden').removeClass('hidden');
                });
            });

            $('.nav-tab-wrapper a:first').addClass('nav-tab-active');

            $('.nav-tab-wrapper a').click(function(evt) {
                $('.nav-tab-wrapper a').removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active').blur();
                var clicked_group = $(this).attr('href');
                $('.group').hide();
                $(clicked_group).fadeIn();
                evt.preventDefault();
            });
        },

        setTimeExpiration: function(e){
            var timeArray = {
                'day' : 30,
                'month' : 12,
                'year': 100
            };
            $('#tszf-expiration_time_value').html('');
            var timeVal = e.target?$(e.target).val():$(e).val();
            for(var time = 1; time <= timeArray[timeVal]; time++){
                $('#tszf-expiration_time_value').append('<option value="'+ time +'" >'+ time +'</option>');
            }
        },

        changeExpirationFieldVisibility : function(e){
            console.log(e);
            var checkbox_obj = e.target? $(e.target):$(e);
            checkbox_obj.is(':checked')?$('.tszf_expiration_field').show():$('.tszf_expiration_field').hide();
        }
    };

    // on DOM ready
    $(function() {
        Editor.init();
    });

})(jQuery);