<?php

class TSZF_render_form_element extends TSZF_Render_Form {

    /**
     * Prints a repeatable field
     *
     * @param array $attr
     * @param int|null $post_id
     */
    public static function repeat( $attr, $post_id, $type, $form_id, $class, $obj) {

        $add    = TSZF_ASSET_URI .  '/images/add.png';
        $remove = TSZF_ASSET_URI .  '/images/remove.png';
        ?>

        <div class="tszf-fields <?php echo ' tszf_'.$attr['name'].'_'.$form_id; ?>">
            <div class="repeat-field-container">
                <?php

                $items = $post_id ? explode( self::$separator, $obj->get_meta( $post_id, $attr['name'], $type, true ) ) : array();
                
                $index = 0;
                $pills = '';

                // If we already have some items, do this:
                if ( $items ) {

                    foreach ( $items as $item ) {
                        //All inputs except last must be hidden.
                        $style = '';

                        $pair = explode( '{-}', $item );

                        $value = isset( $pair[0] ) ? $pair[0] : '';
                        $text  = isset( $pair[1] ) ? $pair[1] : '';

                        if( $index < count( $items ) - 1 ): 

                            $style = 'style="display: none;"';
                            // Render the pill.
                            $pills .= '<div class="repeat-pill" data-label-for="'. esc_attr( $index ) .'" title="'. esc_attr( 'Remove', '' ) .'">
                                            <span class="value"> '. esc_attr( $text ) .'</span>
                                            <span class="remove icon-close"></span>
                                        </div>';
                        endif;

                        ?>
                        <div data-label-index="<?php echo esc_attr( $index ); ?>" <?php echo airkit_var_sanitize( $style, 'the_kses' ); ?>>
                            <input id="tszf-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>"
                                   class="repeatable-input"
                                   type="text"
                                   data-required="<?php echo airkit_var_sanitize( $attr['required'], 'true' ); ?>"
                                   data-type="text"<?php $obj->required_html5( $attr ); ?>
                                   name="<?php echo esc_attr( $attr['name'] ); ?>[]"
                                   placeholder="<?php echo esc_attr( $attr['placeholder'] ); ?>"
                                   value="<?php echo esc_attr( $item ) ?>"
                                   size="<?php echo esc_attr( $attr['size'] ) ?>"
                                   />
                        </div>
                    <?php 

                    $index++;

                    } 

                    echo airkit_var_sanitize( $pills, 'the_kses' );

                } else { 
                    //If we dont' have items (usually when adding new post)
                ?>

                    <div data-label-index="<?php echo esc_attr( $index ); ?>">
                        <input id="tszf-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>"
                               class="repeatable-input"
                               type="text"
                               data-required="<?php echo airkit_var_sanitize( $attr['required'], 'true' ) ?>"
                               data-type="text"<?php $obj->required_html5( $attr ); ?>
                               name="<?php echo esc_attr( $attr['name'] ); ?>[]"
                               placeholder="<?php echo esc_attr( $attr['placeholder'] ); ?>"
                               value="<?php echo esc_attr( $attr['default'] ) ?>"
                               size="<?php echo esc_attr( $attr['size'] ) ?>"
                               />
                    </div>

                <?php } ?>

            </div>
            <span class="tszf-help"><?php echo stripslashes( $attr['help'] ); ?></span>
        </div>
    <?php

    }

    /**
     * Returns a random string
     * return string
     */

    public static function get_rand_str() {

        return substr( str_shuffle( 'abcdefghijklmnopqrstuvxyz'), 0, 5 );

    }


    /**
     * Prints a date field
     *
     * @param array $attr
     * @param int|null $post_id
     */
    public static function date( $attr, $post_id, $type, $form_id, $obj ) {

        $value = $post_id ? $obj->get_meta( $post_id, $attr['name'], $type, true ) : '';

        $enable_past = isset ( $attr['enable_past_time'] ) && $attr['enable_past_time'] == 'yes' ? 'y' : 'n';
        ?>

        <?php
        // if date field is assigned as publish date
        if ( isset ( $attr['is_publish_time'] ) && $attr['is_publish_time'] == 'yes' ) {
            ?>
            <input type="hidden" name="tszf_is_publish_time" value="<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>" />
            <?php
        }
        ?>
        <div class="tszf-fields">
            <input id="tszf-date-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>"
                   type="text"
                   class="datepicker <?php echo ' tszf_'.$attr['name'].'_'.$form_id; ?>"
                   data-required="<?php echo airkit_var_sanitize( $attr['required'], 'true' ) ?>"
                   data-type="text"<?php $obj->required_html5( $attr ); ?>
                   name="<?php echo esc_attr( $attr['name'] ); ?>"
                   value="<?php echo esc_attr( $value ) ?>"
                   data-past="<?php echo esc_attr($enable_past); ?>"
                   size="30"
                   />
            <span class="tszf-help"><?php echo stripslashes( $attr['help'] ); ?></span>
        </div>
        <script type="text/javascript">
            jQuery(function($) {
                var dateToday = new Date(); 
                <?php if ( $attr['time'] == 'yes' ) { ?>
                $("#tszf-date-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>").datetimepicker({ dateFormat: '<?php echo airkit_var_sanitize( $attr["format"], 'true' ); ?>' });
                <?php } else { ?>
                $("#tszf-date-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>").datepicker({ dateFormat: '<?php echo airkit_var_sanitize( $attr["format"], 'true' ); ?>', <?php if( $enable_past == 'n' ): ?> minDate: dateToday <?php endif; ?> });
                <?php } ?>
            });
        </script>

    <?php
    }

    /**
     * Prints a file upload field
     *
     * @param array $attr
     * @param int|null $post_id
     */
    public static function file_upload( $attr, $post_id, $type, $form_id, $obj ) {
        $allowed_ext = '';
        $extensions = tszf_allowed_extensions();

        if ( is_array( $attr['extension'] ) ) {
            foreach ($attr['extension'] as $ext) {
                $allowed_ext .= $extensions[$ext]['ext'] . ',';
            }
        } else {
            $allowed_ext = '*';
        }

        $uploaded_items = $post_id ? $obj->get_meta( $post_id, $attr['name'], $type, false ) : array();
        ?>

        <div class="tszf-fields">
            <div id="tszf-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>-upload-container">
                <div class="tszf-attachment-upload-filelist" data-type="file" data-required="<?php echo airkit_var_sanitize( $attr['required'], 'true' ); ?>">
                    <a id="tszf-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>-pickfiles" 
                       data-form_id="<?php echo airkit_var_sanitize( $form_id, 'true' ); ?>" 
                       class="button file-selector <?php echo ' tszf_'.$attr['name'].'_'.$form_id; ?>" href="#">
                       <i class="icon-upload"></i>
                       <?php _e( 'Select File(s)', 'gowatch' ); ?>
                    </a>

                    <ul class="tszf-attachment-list thumbnails">
                        <?php
                        if ( $uploaded_items ) {
                            foreach ($uploaded_items as $attach_id) {
                                echo TSZF_Upload::attach_html( $attach_id, $attr['name'] );
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div><!-- .container -->

            <span class="tszf-help"><?php echo stripslashes( $attr['help'] ); ?></span>

        </div> <!-- .tszf-fields -->

        <?php echo '<script type="text/javascript">'; ?>
            jQuery(function($) {
                new TSZF_Uploader( 'tszf-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>-pickfiles', 
                                   'tszf-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>-upload-container', 
                                    <?php  echo airkit_var_sanitize( $attr['count'], 'true' ); ?>, 
                                    '<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>', 
                                    '<?php echo airkit_var_sanitize( $allowed_ext, 'true' ); ?>', 
                                    <?php  echo airkit_var_sanitize( $attr['max_size'], 'true' ); ?>);
            });
        <?php echo '</script>'; ?>
    <?php
    }

    /**
     * Prints a map field
     *
     * @param array $attr
     * @param int|null $post_id
     */
    public static function map( $attr, $post_id, $type, $form_id, $classname, $obj ) {

        $value = $post_id ? $obj->get_meta( $post_id, $attr['name'], $type, true ) : '';
        $type = $attr['show_lat'] == 'yes' ? 'text' : 'hidden';
        if ( empty( $value ) ) {
            $value = ',';
        }

        if ( $post_id ) {
            list( $def_lat, $def_long ) = explode( ',', $value );
        } else {
            list( $def_lat, $def_long ) = explode( ',', $attr['default_pos'] );
        }
        ?>

        <div class="tszf-fields <?php echo ' tszf_'.$attr['name'].'_'.$form_id; ?>">
            <input id="tszf-map-lat-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>" type="<?php echo airkit_var_sanitize( $type, 'true' ); ?>" data-required="<?php echo airkit_var_sanitize( $attr['required'], 'true' ) ?>" data-type="text" <?php $obj->required_html5( $attr ); ?> name="<?php echo esc_attr( $attr['name'] ); ?>" value="<?php echo esc_attr( $value ) ?>" size="30" />

            <?php if ( $attr['address'] == 'yes' ) { ?>
                <input id="tszf-map-add-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>" type="text" value="" name="find-address" placeholder="<?php _e( 'Type an address to find', 'gowatch' ); ?>" size="30" />
                <button class="tszf-button button" id="tszf-map-btn-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>"><?php _e( 'Find Address', 'gowatch' ); ?></button>
            <?php } ?>

            <div class="google-map" style="margin: 10px 0; height: 250px; width: 450px;" id="tszf-map-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>"></div>
            <span class="tszf-help"><?php echo stripslashes( $attr['help'] ); ?></span>
        </div>
        <script type="text/javascript">

            (function($) {
                $(function() {
                    var def_zoomval = <?php echo airkit_var_sanitize( $attr['zoom'], 'true' ); ?>;
                    var def_longval = <?php echo ( $def_long ? $def_long : 0 ); ?>;
                    var def_latval = <?php  echo ( $def_lat ? $def_lat : 0 ); ?>;
                    var curpoint = new google.maps.LatLng(def_latval, def_longval),
                        geocoder   = new window.google.maps.Geocoder(),
                        $map_area = $('#tszf-map-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>'),
                        $input_area = $( '#tszf-map-lat-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>' ),
                        $input_add = $( '#tszf-map-add-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>' ),
                        $find_btn = $( '#tszf-map-btn-<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>' );

                    autoCompleteAddress();

                    $find_btn.on('click', function(e) {
                        e.preventDefault();
                        geocodeAddress( $input_add.val() );
                    });

                    var gmap = new google.maps.Map( $map_area[0], {
                        center: curpoint,
                        zoom: def_zoomval,
                        mapTypeId: window.google.maps.MapTypeId.ROADMAP
                    });

                    var marker = new window.google.maps.Marker({
                        position: curpoint,
                        map: gmap,
                        draggable: true
                    });

                    window.google.maps.event.addListener( gmap, 'click', function ( event ) {
                        marker.setPosition( event.latLng );
                        updatePositionInput( event.latLng );
                    } );

                    window.google.maps.event.addListener( marker, 'drag', function ( event ) {
                        updatePositionInput(event.latLng );
                    } );

                    function updatePositionInput( latLng ) {
                        $input_area.val( latLng.lat() + ',' + latLng.lng() );
                    }

                    function updatePositionMarker() {
                        var coord = $input_area.val(),
                            pos, zoom;

                        if ( coord ) {
                            pos = coord.split( ',' );
                            marker.setPosition( new window.google.maps.LatLng( pos[0], pos[1] ) );

                            zoom = pos.length > 2 ? parseInt( pos[2], 10 ) : 12;

                            gmap.setCenter( marker.position );
                            gmap.setZoom( zoom );
                        }
                    }

                    function geocodeAddress( address ) {
                        geocoder.geocode( {'address': address}, function ( results, status ) {
                            if ( status == window.google.maps.GeocoderStatus.OK ) {
                                updatePositionInput( results[0].geometry.location );
                                marker.setPosition( results[0].geometry.location );
                                gmap.setCenter( marker.position );
                                gmap.setZoom( 15 );
                            }
                        } );
                    }

                    function autoCompleteAddress(){
                        if (!$input_add) return null;

                        $input_add.autocomplete({
                            source: function(request, response) {
                                // TODO: add 'region' option, to help bias geocoder.
                                geocoder.geocode( {'address': request.term }, function(results, status) {
                                    response(jQuery.map(results, function(item) {
                                        return {
                                            label     : item.formatted_address,
                                            value     : item.formatted_address,
                                            latitude  : item.geometry.location.lat(),
                                            longitude : item.geometry.location.lng()
                                        };
                                    }));
                                });
                            },
                            select: function(event, ui) {

                                $input_area.val(ui.item.latitude + ',' + ui.item.longitude );

                                var location = new window.google.maps.LatLng(ui.item.latitude, ui.item.longitude);

                                gmap.setCenter(location);
                                // Drop the Marker
                                setTimeout( function(){
                                    marker.setValues({
                                        position    : location,
                                        animation   : window.google.maps.Animation.DROP
                                    });
                                }, 1500);
                            }
                        });
                    }

                });
            })(jQuery);
        </script>

    <?php
    }

    /**
     * Prints an Country List
     *
     * @param array $attr
     * @param int $post_id
     * @param string $type
     * @param @form_id
     */
    public static function country_list( $attr, $post_id, $type = 'post', $form_id = null, $classname, $obj ){
        $list_visibility_option = $attr['country_list']['country_list_visibility_opt_name'];
        $country_select_hide_list = isset( $attr['country_list']['country_select_hide_list'] ) && is_array( $attr['country_list']['country_select_hide_list'] )?$attr['country_list']['country_select_hide_list']:array();
        $country_select_show_list = isset( $attr['country_list']['country_select_show_list'] ) && is_array( $attr['country_list']['country_select_show_list'] )?$attr['country_list']['country_select_show_list']:array();
        if ( $obj->is_meta( $attr ) ) {
            $sel_val = $obj->get_meta( $post_id, $attr['name'], $type );
        }
        $value = !empty( $sel_val ) ? $sel_val : ( isset( $attr['country_list']['name'] ) ? $attr['country_list']['name'] : '' );

        ?>
        <div class="tszf-fields">
            <select name="<?php echo airkit_var_sanitize( $attr['name'], 'true' ); ?>">

            </select>
            <script>
                var field_name = '<?php echo airkit_var_sanitize( $attr['name'], 'true' );?>';
                var countries = window.tszf_countries_list;
                var banned_countries = JSON.parse('<?php echo json_encode($country_select_hide_list); ?>');
                var allowed_countries = JSON.parse('<?php echo json_encode($country_select_show_list); ?>');
                var list_visibility_option = '<?php echo airkit_var_sanitize( $list_visibility_option, 'true' ); ?>';
                var sel_country = '<?php echo !empty( $value ) ? $value : '' ; ?>';

                var option_string = '<option value="">Select Country</option>';
                if( list_visibility_option == 'hide' ){
                    for(country in countries){
                        if( jQuery.inArray(countries[country].code,banned_countries) != -1 ){
                            continue;
                        }
                        option_string = option_string + '<option value="'+ countries[country].code +'" ' + ( sel_country == countries[country].code ? 'selected':'' ) + ' >'+ countries[country].name +'</option>';
                    }
                }else if ( list_visibility_option == 'show' ) {
                    for(country in countries){
                        if( jQuery.inArray(countries[country].code,allowed_countries) != -1 ){
                            option_string = option_string + '<option value="'+ countries[country].code +'" ' + ( sel_country == countries[country].code ? 'selected':'' ) + ' >'+ countries[country].name +'</option>';
                        }

                    }
                }else {
                    for (country in countries) {
                        option_string = option_string + '<option value="'+ countries[country].code +'" ' + ( sel_country == countries[country].code ? 'selected':'' ) + ' >'+ countries[country].name +'</option>';
                    }
                }

                jQuery('select[name="'+ field_name +'"]').html(option_string);
            </script>
        </div>
    <?php

    }

    public static function numeric_text( $attr, $post_id, $type = 'post', $form_id = null, $classname, $obj ) {
        // checking for user profile username
        $username = false;
        $taxonomy = false;

        if ( $post_id ) {

            if ( $obj->is_meta( $attr ) ) {
                $value = $obj->get_meta( $post_id, $attr['name'], $type );
            } else {

                // applicable for post tags
                if ( $type == 'post' && $attr['name'] == 'tags' ) {
                    $post_tags = wp_get_post_tags( $post_id );
                    $tagsarray = array();
                    foreach ($post_tags as $tag) {
                        $tagsarray[] = $tag->name;
                    }

                    $value = implode( ', ', $tagsarray );
                    $taxonomy = true;
                } elseif ( $type == 'post' ) {
                    $value = get_post_field( $attr['name'], $post_id );
                } elseif ( $type == 'user' ) {
                    $value = get_user_by( 'id', $post_id )->$attr['name'];

                    if ( $attr['name'] == 'user_login' ) {
                        $username = true;
                    }
                }
            }
        } else {
            $value = $attr['default'];

            if ( $type == 'post' && $attr['name'] == 'tags' ) {
                $taxonomy = true;
            }
        }

        $numeric_field_id = $attr['name'];

        ?>

        <div class="tszf-fields tszf-numeric_text_holder">

            <input class="textfield<?php echo airkit_var_sanitize( $obj->required_class( $attr ), 'true' );  echo ' tszf_'.$attr['name'].'_'.$form_id; ?>"
                   id="<?php echo airkit_var_sanitize( $numeric_field_id, 'true' ); ?>"
                   type="number"
                   min="<?php echo airkit_var_sanitize( $attr['min_value_field'], 'true' );?>"
                   max="<?php echo airkit_var_sanitize( $attr['max_value_field'], 'true' ); ?>"
                   step="<?php echo airkit_var_sanitize( $attr['step_text_field'], 'true' ); ?>"
                   data-required="<?php echo airkit_var_sanitize( $attr['required'], 'true' ) ?>"
                   data-type="text"<?php $obj->required_html5( $attr ); ?>
                   name="<?php echo esc_attr( $attr['name'] ); ?>"
                   placeholder="<?php echo esc_attr( $attr['placeholder'] ); ?>"
                   value="<?php echo esc_attr( $value ) ?>"
                   size="<?php echo esc_attr( $attr['size'] ) ?>" <?php echo ( $username ? 'disabled' : '' ); ?> 
                   />
            <span class="tszf-help"><?php echo stripslashes( $attr['help'] ); ?></span>
            <script>
                jQuery(function($) {
                    $("#<?php echo airkit_var_sanitize( $numeric_field_id, 'true' );?>").keydown(function (e) {
                        // Allow: backspace, delete, tab, escape, minus enter and . backspace = 8,delete=46,tab=9,enter=13,.=190,escape=27, minus = 189
                        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 189]) !== -1 ||
                            
                            (e.keyCode == 65 && e.ctrlKey === true) ||
                            
                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                            
                            return;
                        }
                        // Ensure that it is a number and stop the keypress
                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                            e.preventDefault();
                        }
                    });
                });
            </script>
        </div>

    <?php
    }

    /**
     * Prints an address field
     *
     * @param array $attr
     * @param int $post_id
     * @param string $type
     * @param @form_id
     */
    public static function address_field( $attr, $post_id, $type = 'post', $form_id = null, $classname, $obj ){
        // checking for user profile username
        $username = false;
        $taxonomy = false;

        if ( $post_id ) {

            if ( $obj->is_meta( $attr ) ) {
                $value = $obj->get_meta( $post_id, $attr['name'], $type );
            } else {

                // applicable for post tags
                if ( $type == 'post' && $attr['name'] == 'tags' ) {
                    $post_tags = wp_get_post_tags( $post_id );
                    $tagsarray = array();
                    foreach ($post_tags as $tag) {
                        $tagsarray[] = $tag->name;
                    }

                    $value = implode( ', ', $tagsarray );
                    $taxonomy = true;
                } elseif ( $type == 'post' ) {
                    $value = get_post_field( $attr['name'], $post_id );
                } elseif ( $type == 'user' ) {
                    $value = get_user_by( 'id', $post_id )->$attr['name'];

                    if ( $attr['name'] == 'user_login' ) {
                        $username = true;
                    }
                }
            }
        } else {
            //$value = $attr['default'];

            if ( $type == 'post' && $attr['name'] == 'tags' ) {
                $taxonomy = true;
            }
        }
        ?>
        <div class="tszf-fields">
            <span class="tszf-help"><?php echo stripslashes( $attr['help'] ); ?></span>
        </div>
        <div class="clear"></div>

        <?php

        $address_fields_meta = isset( $value ) ? $value : array();
        $country_select_hide_list = isset( $attr['address']['country_select']['country_select_hide_list'] ) ? $attr['address']['country_select']['country_select_hide_list'] : array();
        $country_select_show_list = isset( $attr['address']['country_select']['country_select_show_list'] ) ? $attr['address']['country_select']['country_select_show_list'] : array();
        $list_visibility_option = $attr['address']['country_select']['country_list_visibility_opt_name'];

        foreach( $attr['address'] as $each_field => $field_array ){

            ?>
            <div class="tszf-address-field">
                <?php

                if ( isset( $field_array['checked'] ) && !empty( $field_array['checked'] ) ) {
                    ?>
                    <div class="tszf-label">
                        <label><?php echo airkit_var_sanitize( $field_array['label'], 'true' ); ?></label>
                        <span class="required"><?php echo ( isset( $field_array['required'] ) && !empty($field_array['required']) ) ? '*' : ''; ?></span>
                    </div>

                    <div class="tszf-fields">
                        <?php
                        if ( in_array($field_array['type'], array( 'text', 'hidden', 'email', 'password') ) ) {
                            ?>
                        <input type="<?php echo airkit_var_sanitize( $field_array['type'], 'true' ); ?>"
                               name="<?php  echo airkit_var_sanitize( $attr['name'], 'true' ) . '[' . $each_field . ']'; ?>"
                               value="<?php echo isset( $address_fields_meta[$each_field] )?esc_attr($address_fields_meta[$each_field]):$field_array['value']; ?>"
                               placeholder="<?php echo airkit_var_sanitize( $field_array['placeholder'], 'true' );?>"
                               class="textfield"
                               size="40" <?php echo isset( $field_array['required'] ) && !empty( $field_array['required'] ) ? 'required' : ''; ?> />
                        <?php
                        } elseif ( in_array($field_array['type'],array('textarea','select') ) ){
                        echo '<'.$field_array['type'].' name="'. $attr['name'] . '[' . $each_field . ']' . '" '.( isset( $field_array['required'] ) && !empty( $field_array['required'] ) ? 'required' : '').'>';
                        echo '</'.$field_array['type'].'>';

                        if ( $each_field == 'country_select' ) {

                        $address_fields_meta['country_select'] = isset($address_fields_meta['country_select'])?$address_fields_meta['country_select']:$field_array['value'];
                        ?>
                            <script>
                                var field_name        = '<?php echo airkit_var_sanitize( $attr['name'], 'true' ) . '[' . $each_field . ']' ; ?>';
                                var countries         = window.tszf_countries_list;
                                var banned_countries  = JSON.parse('<?php echo json_encode( $country_select_hide_list ) ?>');
                                var allowed_countries = JSON.parse('<?php echo json_encode( $country_select_show_list ); ?>');
                                var list_visibility_option = '<?php echo airkit_var_sanitize( $list_visibility_option, 'true' ); ?>';
                                var option_string     = '<option value="">Select Country</option>';
                                var sel_country = '<?php echo isset($address_fields_meta['country_select'])?$address_fields_meta['country_select']:''; ?>';


                                if ( list_visibility_option == 'hide' ) {
                                    for (country in countries){
                                        if ( jQuery.inArray(countries[country].code,banned_countries) != -1 ){
                                            continue;
                                        }
                                        option_string = option_string + '<option value="'+ countries[country].code +'" ' + ( sel_country == countries[country].code ? 'selected':'' ) + ' >'+ countries[country].name +'</option>';
                                    }
                                } else if( list_visibility_option == 'show' ) {
                                    for (country in countries){
                                        if ( jQuery.inArray(countries[country].code,allowed_countries) != -1 ) {
                                            option_string = option_string + '<option value="'+ countries[country].code +'" ' + ( sel_country == countries[country].code ? 'selected':'' ) + ' >'+ countries[country].name +'</option>';
                                        }

                                    }
                                } else {
                                    for (country in countries){
                                        option_string = option_string + '<option value="'+ countries[country].code +'" ' + ( sel_country == countries[country].code ? 'selected':'' ) + ' >'+ countries[country].name +'</option>';
                                    }
                                }

                                jQuery('select[name="'+ field_name +'"]').html(option_string);
                            </script>
                        <?php
                        }

                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }

    }

    /**
     * fieldset start
     * @param $attr
     * @param $post_id
     * @param string $type
     * @param null $form_id
     */
    public static function step_start( $attr, $post_id, $type = 'post', $form_id = null, $multiform_start, $enable_multistep, $obj ) {

        if ( $obj->multiform_start == 1 && !empty( $obj->multiform_start ) ) {
            ?>

            </fieldset>
        <?php
        } else{
            $obj->multiform_start = 1;
        }

        if ( !empty( $enable_multistep ) ) {
            ?>
            <fieldset class="tszf-multistep-fieldset">
                <legend>
                    <?php echo airkit_var_sanitize( $attr['label'], 'true' );?>
                </legend>
                <button class="tszf-multistep-prev-btn btn btn-primary"><?php echo airkit_var_sanitize( $attr['step_start']['prev_button_text'], 'true' ); ?></button>
                <button class="tszf-multistep-next-btn btn btn-primary"><?php echo airkit_var_sanitize( $attr['step_start']['next_button_text'], 'true' ); ?></button>

        <?php
        }
        //return $obj->multiform_start;
    }


    /**
     * Prints really simple captcha
     *
     * @param array $attr
     * @param int|null $post_id
     */
    public static function really_simple_captcha( $attr, $post_id, $form_id ) {

        if ( $post_id ) {
            return;
        }

        if ( !class_exists( 'ReallySimpleCaptcha' ) ) {
            ?>
            <div class="tszf-fields <?php  echo ' tszf_'.$attr['name'].'_'.$form_id; ?>">
                <?php
                _e( 'Error: Really Simple Captcha plugin not found!', 'gowatch' );
                ?>
            </div>
            <?php
            return;
        }



        $captcha_instance = new ReallySimpleCaptcha();
        $word = $captcha_instance->generate_random_word();
        $prefix = mt_rand();
        $image_num = $captcha_instance->generate_image( $prefix, $word );
        ?>
        <div class="tszf-fields <?php  echo ' tszf_'.$attr['name'].'_'.$form_id; ?>">
            <img src="<?php echo plugins_url( 'really-simple-captcha/tmp/' . $image_num ); ?>" alt="Captcha" />
            <input type="text" name="rs_captcha" value="" />
            <input type="hidden" name="rs_captcha_val" value="<?php echo airkit_var_sanitize( $prefix, 'true' ); ?>" />
        </div>
    <?php
    }

    /**
     * Prints a action hook
     *
     * @param array $attr
     * @param int $form_id
     * @param int|null $post_id
     * @param array $form_settings
     */
    public static function action_hook( $attr, $form_id, $post_id, $form_settings ) {

        if ( !empty( $attr['label'] ) ) {
            do_action( $attr['label'], $form_id, $post_id, $form_settings );
        }
    }

    /**
     * Prints a HTML field
     *
     * @param array $attr
     */
    public static function toc( $attr, $post_id, $form_id ) {
        if ( $post_id ) {
            return;
        }
        ?>
        <div class="tszf-label">
            &nbsp;
        </div>

        <div data-required="yes" data-type="radio" class="tszf-fields <?php echo ' tszf_'.$attr['name'].'_'.$form_id; ?>">

            <textarea rows="10" cols="40" disabled="disabled" name="toc"><?php echo airkit_var_sanitize( $attr['description'], 'true' ); ?></textarea>
            <label>
                <input type="checkbox" name="tszf_accept_toc" required="required" /> <?php echo airkit_var_sanitize( $attr['label'], 'true' ); ?>
            </label>
        </div>
    <?php
    }

}