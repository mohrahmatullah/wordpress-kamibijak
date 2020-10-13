<?php

add_action( 'add_meta_boxes', 'airkit_event_add_custom_box' );
add_action( 'save_post', 'airkit_event_save_post' );

function airkit_event_add_custom_box()
{
    add_meta_box(
        'event',
        esc_html__('Settings event','gowatch'),
        'airkit_event_options_custom_box',
        'event'
    );
}

function airkit_event_options_custom_box($post)
{
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ts_event_nonce' );
    $event = get_post_meta($post->ID, 'event', TRUE);
    $day = get_post_meta($post->ID, 'day', TRUE);

    if( !$day ){
        $day = '';
    }else{
        if( !empty($day) ){
            $day = date('Y-m-d', $day);
        }
    }

    if ( !$event ) {
        $event = array();
        $event['start-time'] = '';
        $event['end-time'] = '';
        $event['event-days'] = '';
        $event['event-repeat'] = '';
        $event['event-enable-repeat'] = 'n';
        $event['forever'] = 'n';
        $event['event-end'] = '';
        $event['theme'] = '';
        $event['person'] = '';
        $event['map'] = '';
        $event['free-paid'] = '';
        $event['ticket-url'] = '';
        $event['price'] = '';
        $event['venue'] = '';
    }

    echo '<table>
            <tr valign="top">
                <td width="35%">' . esc_html__('Start day','gowatch') . '</td>
                <td>
                    <input size="60" type="text" id="day-start" value="'. esc_attr($day) .'" name="day" />
                    <label class="airkit-option-description" for="day-start">' . esc_html__('Enter the date when the event starts in the following format: YYYY-MM-DD Eg: 2020-12-25', 'gowatch') . '</label>
                </td>
            </tr>
            <tr valign="top">
                <td>' . esc_html__('End day','gowatch') . '</td>
                <td>
                    <input size="60" type="text" id="day-end" value="'. esc_attr($event['event-end']) .'" name="event[event-end]" />
                    <label class="airkit-option-description" for="day-end">' . esc_html__('Enter the date when the event ends in the following format: YYYY-MM-DD Eg: 2020-12-30', 'gowatch') . '</label>
                </td>
            </tr>
            <tr valign="top">
                <td>' . esc_html__('Start time','gowatch') . '</td>
                <td>
                    <input size="60" type="text" id="time-start" value="'. esc_attr($event['start-time']) .'" name="event[start-time]" />
                    <label class="airkit-option-description" for="time-start">' . esc_html__('Enter the hour when the event starts in the following format: HH:MM. Eg: 11:25', 'gowatch') . '</label>
                </td>
            </tr>
            <tr valign="top">
                <td>' . esc_html__('End time','gowatch') . '</td>
                <td>
                    <input size="60" type="text" id="time-end" value="'. esc_attr($event['end-time']) .'" name="event[end-time]" />
                    <label class="airkit-option-description" for="time-end">' . esc_html__('Enter the hour when the event ends in the following format: HH:MM. Eg: 11:30', 'gowatch') . '</label>
                </td>
            </tr>
            <tr valign="top">
                <td>' . esc_html__('Repeat event','gowatch') . '</td>
                <td>
                    <select id="event-repeat" name="event[event-enable-repeat]">
                        <option ' . selected($event['event-enable-repeat'], 'y', false) . ' value="y">' . esc_html__('Yes','gowatch') . '</option>
                        <option ' . selected($event['event-enable-repeat'], 'n', false) . ' value="n">' . esc_html__('No','gowatch') . '</option>
                    </select>
                    <label class="airkit-option-description" for="event-repeat">' . esc_html__('Choose wether your event will repeat over a certain period.', 'gowatch') . '</label>
                </td>
            </tr>
            <tr class="ts-event-repeat-time">
                <td>' . esc_html__('Change event repeat','gowatch') . '</td>
                <td>
                    <select id="repeat-period" name="event[event-repeat]">
                        <option ' . selected($event['event-repeat'], '1', false) . ' value="1">' . esc_html__('Weekly','gowatch') . '</option>
                        <option ' . selected($event['event-repeat'], '2', false) . ' value="2">' . esc_html__('Monthly','gowatch') . '</option>
                        <option ' . selected($event['event-repeat'], '3', false) . ' value="3">' . esc_html__('Yearly','gowatch') . '</option>
                    </select>
                    <label class="airkit-option-description" for="repeat-period">' . esc_html__('Choose the event repeat time', 'gowatch') . '</label>
                </td>
            </tr>
            <tr valign="top">
                <td>' . esc_html__('Add your event subject here','gowatch') . '</td>
                <td>
                    <input size="60" type="text" id="event-subject" value="'. esc_attr($event['theme']) .'" name="event[theme]" />
                    <label class="airkit-option-description" for="event-subject">' . esc_html__('Write down the event subject in here. Something that describes what will happen there.', 'gowatch') . '</label>
                </td>
            </tr>
            <tr valign="top">
                <td>' . esc_html__('Person','gowatch') . '</td>
                <td>
                    <input size="60" type="text" id="event-person" value="'. esc_attr($event['person']) .'" name="event[person]" />
                    <label class="airkit-option-description" for="event-person">' . esc_html__('The name of the person who is responsible for this event and who can be contacted for any information.', 'gowatch') . '</label>
                </td>
            </tr>
            <tr valign="top">
                <td>' . esc_html__('Map','gowatch') . '</td>
                <td>
                    <textarea name="event[map]" id="event-map" cols="60" rows="5">' . $event['map'] . '</textarea>
                    <label class="airkit-option-description" for="event-map">' . esc_html__('Insert your iframe code in the textarea with the map/any other embed to show users where to come.', 'gowatch') . '</label>
                </td>
            </tr>
            <tr valign="top">
                <td>' . esc_html__('Free or paid','gowatch') . '</td>
                <td>
                    <select id="event-payment" class="ts-free-paid" name="event[free-paid]">
                        <option ' . selected($event['free-paid'], 'paid', false) . ' value="paid">' . esc_html__('Paid','gowatch') . '</option>
                        <option ' . selected($event['free-paid'], 'free', false) . ' value="free">' . esc_html__('Free','gowatch') . '</option>
                    </select>
                    <label class="airkit-option-description" for="event-payment">' . esc_html__('Is the event with free entrance or there is a fee?', 'gowatch') . '</label>
                </td>
            </tr>
            <tr class="ts-event-price-url">
                <td>' . esc_html__('Price','gowatch') . '</td>
                <td>
                    <input size="60" type="text" id="event-price" value="'. esc_attr($event['price']) .'" name="event[price]" />
                    <label class="airkit-option-description" for="event-price">' . esc_html__('If your event has a entry price, insert the price here (with the currency as well)', 'gowatch') . '</label>
                </td>
            </tr>
            <tr class="ts-event-price-url">
                <td>' . esc_html__('Ticket buy URL','gowatch') . '</td>
                <td>
                    <input size="60" id="event-ticket-link" type="text" value="'. esc_attr($event['ticket-url']) .'" name="event[ticket-url]" />
                    <label class="airkit-option-description" for="event-ticket-link">' . esc_html__('Insert a link where the users can buy tickets from.', 'gowatch') . '</label>
                </td>
            </tr>
            <tr valign="top">
                <td>' . esc_html__('Venue','gowatch') . '</td>
                <td>
                    <input size="60" type="text" id="event-venue" value="'. esc_attr($event['venue']) .'" name="event[venue]" />
                    <label class="airkit-option-description" for="event-venue">' . esc_html__('Insert an event venue: where it will happen, details of the location.', 'gowatch') . '</label>
                </td>
            </tr>
        </table>
        <script>


            jQuery(document).ready(function(){
                // The pricing part
                jQuery(".ts-free-paid").change(function(){
                    if( jQuery(this).val() == "free" ){
                        jQuery(".ts-event-price-url").css("display", "none");
                    }else{
                        jQuery(".ts-event-price-url").css("display", "");
                    }
                });

                if( jQuery(".ts-free-paid").val() == "free" ){
                    jQuery(".ts-event-price-url").css("display", "none");
                }else{
                    jQuery(".ts-event-price-url").css("display", "");
                }

                jQuery("#event-repeat").change(function(){
                    if( jQuery(this).val() == "n" ){
                        jQuery(".ts-event-repeat-time").css("display", "none");
                    }else{
                        jQuery(".ts-event-repeat-time").css("display", "");
                    }
                });

                if( jQuery("#event-repeat").val() == "n" ){
                    jQuery(".ts-event-repeat-time").css("display", "none");
                }else{
                    jQuery(".ts-event-repeat-time").css("display", "");
                }
            });
        </script>
        ';

}

function airkit_event_save_post($post_ID)
{
    global $post;

    if ( isset($post->post_type) && @$post->post_type != 'event' ) {
        return;
    }

    if (!isset( $_POST['ts_event_nonce'] ) ||
        !wp_verify_nonce( $_POST['ts_event_nonce'], plugin_basename( __FILE__ ) )
    ) return;

    if( !current_user_can( 'edit_post', $post_ID ) ) return;

    // array containing filtred slides
    $event = array();

    if( isset( $_POST['day'] ) ){
        $day = $_POST['day'];
    }else{
        $day = '';
    }

    if ( isset( $_POST['event'] ) && is_array( $_POST['event'] ) && !empty( $_POST['event'] )  ) {
        $t = $_POST['event'];
        $event['day'] = isset($day) ? esc_attr($day) : '';
        $event['start-time'] = isset($t['start-time']) ? esc_attr($t['start-time']) : '';
        $event['end-time'] = isset($t['end-time']) ? esc_attr($t['end-time']) : '';
        $event['event-enable-repeat'] = (isset($t['event-enable-repeat']) && ($t['event-enable-repeat'] == 'y' || $t['event-enable-repeat'] == 'n')) ? $t['event-enable-repeat'] : 'n';
        $event['event-end'] = isset($t['event-end']) ? $t['event-end'] : '';
        $event['event-repeat'] = (isset($t['event-repeat']) && ($t['event-repeat'] == '1' || $t['event-repeat'] == '2' || $t['event-repeat'] == '3')) ? $t['event-repeat'] : '';
        $event['theme'] = isset($t['theme']) ? esc_attr($t['theme']) : '';
        $event['person'] = isset($t['person']) ? esc_attr($t['person']) : '';
        $event['map'] = isset($t['map']) ? $t['map'] : '';
        $event['free-paid'] = (isset($t['free-paid']) && ($t['free-paid'] == 'free' || $t['free-paid'] == 'paid')) ? $t['free-paid'] : '';
        $event['ticket-url'] = isset($t['ticket-url']) ? esc_attr($t['ticket-url']) : '';
        $event['price'] = isset($t['price']) ? esc_attr($t['price']) : '';
        $event['venue'] = isset($t['venue']) ? esc_attr($t['venue']) : '';

    } else {
        $event['day'] = '';
        $event['start-time'] = '';
        $event['end-time'] = '';
        $event['event-days'] = '';
        $event['event-repeat'] = '';
        $event['event-enable-repeat'] = 'n';
        $event['forever'] = 'n';
        $event['event-end'] = 'n';
        $event['theme'] = '';
        $event['person'] = '';
        $event['map'] = '';
        $event['price'] = '';
        $event['ticket-url'] = '';
        $event['free-paid'] = '';
        $event['venue'] = '';

    }

    update_post_meta($post_ID, 'event', $event);
    update_post_meta($post_ID, 'day', strtotime($day));
}


add_action( 'add_meta_boxes', 'airkit_videos_add_custom_box' );

function airkit_videos_add_custom_box()
{
    add_meta_box(
        'video',
        esc_html__('Insert Video', 'gowatch'),
        'airkit_videos_options_custom_box',
        'video'
    );
}

function airkit_videos_options_custom_box($post)
{
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ts_videos_nonce' );
    $meta = get_post_meta( $post->ID, 'airkit_post_settings', true );

    $single_styles = array(
        'std'      => esc_html__( 'Default', 'gowatch'),
        'style1'   => esc_html__( 'Single style 1, video top', 'gowatch' ),
        'style2'   => esc_html__( 'Single style 2, video fullwidth', 'gowatch' ),
    );

    airkit_Fields::selectMeta( 'airkit_post_settings', 'single_style', $single_styles, airkit_Fields::get_value( 'single_style', $meta ), 'Select your video single style', esc_html__('Use this to select the single video page style.', 'gowatch' ) );

    airkit_Fields::textareaText( 'airkit_post_settings', 'subtitle', airkit_Fields::get_value( 'subtitle', $meta, '' ), 'Add subtitle', esc_html__( 'Add subtitle to post','gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'title', airkit_Fields::get_value( 'title', $meta ), 'Show title for this post', esc_html__('If set to yes, this option will show the title of the post on this specific post','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'img', airkit_Fields::get_value( 'img', $meta ), 'Show featured image', esc_html__('If set to yes, this option will show the featured image of the post on this specific post.','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'views', airkit_Fields::get_value( 'views', $meta ), 'Show views for this post', esc_html__( 'If set to yes, this option will show the views of the post on this specific post.', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'date', airkit_Fields::get_value( 'date', $meta ), 'Show date for this post', esc_html__( 'If set to yes, this option will show the date of the post on this specific post.', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'author', airkit_Fields::get_value( 'author', $meta ), 'Show author for this post', esc_html__( 'If set to yes, this option will show the author of the post on this specific post.', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'sharing', airkit_Fields::get_value( 'sharing', $meta ), 'Show social sharing for this post', esc_html__('If set to yes, this option will show the social sharing buttons of the post on this specific post', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'breadcrumbs', airkit_Fields::get_value( 'breadcrumbs', $meta ), 'Show breadcrumbs for this post.', esc_html__('Display breadcrumbs','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'post-tags', airkit_Fields::get_value( 'tags', $meta ), 'Show tags for this post.', esc_html__( 'Display tags', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'author-box', airkit_Fields::get_value( 'author-box', $meta ), 'Show author box for this post', esc_html__('If set to yes, this option will show the author box of the post on this specific post','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'pagination', airkit_Fields::get_value( 'pagination', $meta ), 'Show pagination posts for this post.', esc_html__('If set to yes, this option will show the pagination of the post on this specific post.','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'related', airkit_Fields::get_value( 'related', $meta ), 'Show related articles for this post', esc_html__('If set to yes, this option will show the related articles of the post on this specific post','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'sticky_sidebar', airkit_Fields::get_value( 'sticky_sidebar', $meta ), 'Show sticky sidebar', esc_html__( 'If set to yes, this option will make sticky sidebar', 'gowatch' ) );
    
    airkit_video_sources($post->ID);

}

function airkit_video_sources( $post_ID )
{
    $post = get_post($post_ID);
    $post_type = get_post_type($post->ID);
    $frontend_active_id = get_frontend_submission_active_id();
    $frontend_settings = tszf_get_form_settings( $frontend_active_id );

    if ( isset($frontend_settings['post_type']) && $frontend_settings['post_type'] !== $post_type ): ?>

        <?php
            $ajax_nonce = wp_create_nonce( "video-image" );

            $video_url = get_post_meta( $post->ID, 'video_url', true );
            $video_embed = get_post_meta( $post->ID, 'video_embed', true );
            $video_upload = get_post_meta( $post->ID, 'video_upload', true );

            $type = 'external';

            if( isset( $video_url ) && !empty( $video_url ) ) {
                $type = 'external';
            }
            if( isset( $video_embed ) && !empty( $video_embed ) ) {
                $type = 'embedded';
            }
            if( isset( $video_upload ) && !empty( $video_upload ) ) {
                $type = 'uploaded';
            }
        ?>

        <div class="airkit_video-source">
            <ul class="ts-select-source nav nav-tabs" role="tablist">
                <li data-type="external"<?php echo ($type == 'external' ? ' class="active"' : ''); ?>>
                    <a href="#external" role="tab" data-toggle="tab"><?php esc_html_e( 'Use video URL', 'gowatch' ); ?></a>
                </li>
                <li data-type="uploaded"<?php echo ($type == 'uploaded' ? ' class="active"' : ''); ?>>
                    <a href="#uploaded" role="tab" data-toggle="tab"><?php esc_html_e( 'Upload video', 'gowatch' ); ?></a>
                </li>
                <li data-type="embedded"<?php echo ($type == 'embedded' ? ' class="active"' : ''); ?>>
                    <a href="#embedded" role="tab" data-toggle="tab"><?php esc_html_e( 'Use EMBEDDED code', 'gowatch' ); ?></a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane <?php echo ($type == 'external' ? 'active' : ''); ?>" id="external">
                    <textarea id="video_url" class="ts-empty-click" name="video_url" cols="60" rows="5"><?php echo $video_url; ?></textarea>
                    <div class="description">
                        <?php 
                        esc_html_e('Insert your external video URL here. All services supported by WordPress are available. 
                                    You can check the list here', 'gowatch'); ?>: 
                                    <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"><?php esc_html_e('Source List', 'gowatch'); ?></a>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane <?php echo ($type == 'uploaded' ? ' active' : ''); ?>" id="uploaded">
                    <table>
                        <tr>
                            <td>
                                <input type="text" value="<?php esc_url( $video_upload ) ?>" name="video_upload"  id="custom-type-upload-videos"/>
                                <input type="button" class="button" id="select-custom-type-video" value="Upload" />
                                <input type="hidden" value="" id="select-custom_media_id" />
                            </td>
                        </tr>
                    </table>
                    <br><br>
                    <div class="description">
                        <?php esc_html_e('Upload your video here. We would recommend using MP4 file format for best compatibility', 'gowatch'); ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane <?php echo ($type == 'embedded' ? ' active' : ''); ?>" id="embedded">
                    <textarea name="video_embed" cols="60" rows="5"><?php echo ( $type == 'embedded' ? $video_embed : '' ) ?></textarea>
                    <br><br>
                    <div class="ts-option-description"><?php esc_html_e('Insert your embed code here. You can take videos from anywhere you want, embeds provided from anywhere. NOTE: Not all services could work properly (video resizing). If you tried a service and there was a problem with it, please report this on our help desk.', 'gowatch'); ?></div>
                </div>
                <div>
                    <input style="display: none;" class="button-secondary" id="ts-get-featured-image" type="button" value="<?php esc_html_e('Get featured image', 'gowatch'); ?>" />
                </div>
                <div style="display: none;" class="ts-remove-featured">
                    <a id="ts-remove-featured-image" data-post-id="<?php echo airkit_var_sanitize( $post->ID, 'esc_attr' ); ?>" href="#"><?php esc_html_e('Remove featured image', 'gowatch'); ?></a>
                </div>
                <input type="hidden" name="selected-type" value="<?php echo esc_attr( $type ); ?>">
                <?php wp_nonce_field( plugin_basename( __FILE__ ), 'ts_videos_nonce' ); ?>
            </div>
        </div>
        <script>
            jQuery(document).ready(function(){
                // jQuery('.ts-select-source > li.active > a').tab('show');

                jQuery( '.ts-select-source > li' ).click(function(e){
                    
                    e.preventDefault();

                    var toggle = jQuery(this).find('>a').attr('href');
                    jQuery( this ).addClass('active').siblings().removeClass('active');
                    jQuery( toggle ).addClass('active').siblings().removeClass('active');

                    setTimeout(function(){

                        jQuery('div[role="tabpanel"]').each(function(){

                            if( jQuery(this).hasClass('active') ){
                                jQuery('.ts-tab-active').val('');
                                jQuery(this).find('.ts-tab-active').val('1');
                            }

                        });

                        if( jQuery('.ts-select-source > li:first-child').hasClass('active') ){
                            jQuery('#ts-get-featured-image').css('display', '');
                        }else{
                            jQuery('#ts-get-featured-image').css('display', 'none');
                        }   

                    }, 100);

                    jQuery('[name="selected-type"]').val(jQuery(this).data('type'));
                });

                if( jQuery('.ts-select-source > li:first-child').hasClass('active') ){

                    jQuery('#ts-get-featured-image').css('display', '');

                } else {

                    jQuery('#ts-get-featured-image').css('display', 'none');
                }

                jQuery('#ts-get-featured-image').on('click', function(event){
                    event.preventDefault();
                    var link = jQuery('#video_url').val();

                    jQuery( '#ts-builder-elements-modal-preloader' ).show();

                    jQuery.post(ajaxurl, 'action=ts_video_image&link=' + link + '&post_id=<?php echo airkit_var_sanitize( $post->ID, 'esc_attr' ); ?>&nonce=<?php echo airkit_var_sanitize( $ajax_nonce, 'the_kses' ); ?>', function( response ){
                        response = jQuery.parseJSON( response );
                        setTimeout(function(){
                            jQuery('#postimagediv .inside .ts-image-extern').remove();
                            jQuery('#postimagediv .inside').prepend('<p class="hide-if-no-js ts-image-extern" data-attachment-id="' + response.attachment_id + '"><a href="#"><img src="' + response.url + '"/></a></p>');
                            jQuery('#postimagediv .inside a#set-post-thumbnail').hide();
                            jQuery('#_thumbnail_id').val( response.attachment_id );
                            if( jQuery('#remove-post-thumbnail').length == 0 ){
                                jQuery('#postimagediv .inside').append(jQuery('.ts-remove-featured').html());
                            }

                            jQuery( '#ts-builder-elements-modal-preloader' ).hide();
                        }, 500);
                    });
                });

                jQuery(document).on('click', '#ts-remove-featured-image', function(event){
                    event.preventDefault();
                    var postId = jQuery(this).attr('data-post-id');

                    data = {
                        action  : 'tsRemoveSetFeaturedImageFromPost',
                        nonce   : '<?php echo airkit_var_sanitize( $ajax_nonce, 'the_kses' ); ?>',
                        make    : 'remove',
                        postId  : postId
                    };

                    jQuery.post(ajaxurl, data, function(response) {
                        if( response ) {
                            jQuery('#postimagediv .inside a#set-post-thumbnail').show();
                            jQuery('#ts-remove-featured-image').remove();
                            jQuery('.ts-image-extern').remove();
                        }
                    });
                });            
            });
        </script>    
        
    <?php endif;
}

function airkit_save_video_sources( $post_ID )
{
    global $post;

    $post_type = get_post_type($post_ID);
    $post_format = get_post_format($post_ID);

    $post_types = array('video', 'post');

    // Check if post type is included in allowed types
    if ( ! in_array($post_type, $post_types) ) return;

    // Check if is post and post format is video
    if ( $post_type === 'post' && $post_format !== 'video' ) return;

    if (!isset( $_POST['ts_videos_nonce'] ) ||
        !wp_verify_nonce( $_POST['ts_videos_nonce'], plugin_basename( __FILE__ ) )
    ) return;

    if( !current_user_can( 'edit_post', $post_ID ) ) return;
    
    $type = 'external';
    $allowed_types = array(
        'external',
        'embedded',
        'uploaded'
    );

    $external = '';
    $embedded = '';
    $uploaded = '';

    if( isset( $_POST['selected-type'] ) && in_array( $_POST['selected-type'], $allowed_types ) ){

        $type = $_POST['selected-type'];

        if ( isset( $_POST['video_url'] ) && !empty( $_POST['video_url'] ) ) {
            $external = $_POST['video_url'];
        }

        if ( isset( $_POST['video_embed'] ) && !empty( $_POST['video_embed'] ) ) {
            $embedded = $_POST['video_embed'];   
        }

        if ( isset( $_POST['video_upload'] ) && !empty( $_POST['video_upload'] ) ) {
            $uploaded = $_POST['video_upload'];
        }
        
        update_post_meta( $post_ID, 'video_url', esc_url( $external ) );
        update_post_meta( $post_ID, 'video_embed', $embedded );
        update_post_meta( $post_ID, 'video_upload', esc_url( $uploaded ) );
        update_post_meta( $post_ID, 'video_type', $type );

    }

}

add_action( 'add_meta_boxes', 'airkit_teams_add_custom_box' );
add_action( 'save_post', 'airkit_teams_save_post' );

function airkit_teams_add_custom_box()
{
    add_meta_box(
        'ts_member',
        esc_html__('About Team Member','gowatch'),
        'airkit_teams_options_custom_box',
        'ts_teams'
    );

    add_meta_box(
        'ts_member_networks',
        esc_html__('Social Networks','gowatch'),
        'airkit_teams_social_networks_custom_box',
        'ts_teams'
    );
}

function airkit_teams_options_custom_box($post)
{
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ts_teams_nonce' );
    $teams = get_post_meta($post->ID, 'ts_member', TRUE);

    if (!$teams) {
        $teams = array();
        $teams['about_member'] = '';
        $teams['position'] = '';
        $teams['team-user'] = '';
    }

    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => '',
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => array(),
        'include'      => array(),
        'exclude'      => array(),
        'orderby'      => 'login',
        'order'        => 'ASC',
        'offset'       => '',
        'search'       => '',
        'number'       => '',
        'count_total'  => false,
        'fields'       => 'all',
        'who'          => ''
    );
    $users = get_users($args);
    $html = '';

    if( isset($users) && is_array($users) && count($users) > 0 ){
        $none = ($teams['team-user'] == 'none' || $teams['team-user'] == '') ? ' selected="selected"' : '';
        $html .= '<select name="teams[team-user]">
                    <option' . $none . ' value="none">' . esc_html__('None','gowatch') . '</option>';
        foreach($users as $user){
            if( is_object($user) && isset($user->ID, $user->user_login) ){
                if( $teams['team-user'] == $user->ID ) $selected = ' selected="selected"';
                else $selected = '';
                $html .= '<option' . $selected . ' value="' . $user->ID . '">' . $user->user_login . '</option>';
            }
        }
        $html .= '</select>';
    }

    echo '<table>
        <tr valign="top">
            <td>' . esc_html__('Short information','gowatch') . '</td>
            <td>
                <textarea name="teams[about_member]" cols="60" rows="5">'.esc_attr($teams['about_member']).'</textarea>
            </td>
        </tr>
        <tr>
            <td>' . esc_html__('Title','gowatch') . '</td>
            <td>
                <input type="text" name="teams[position]" value="'.esc_attr($teams['position']).'" />
            </td>
        </tr>
        <tr>
            <td>' . esc_html__('Link team member to a user','gowatch') . '</td>
            <td>
                ' . balanceTags($html, true) . '
            </td>
        </tr>
        </table>';

}

function airkit_teams_social_networks_custom_box($post)
{
    $teams = get_post_meta( $post->ID, 'ts_member', true );

    $arraySocials = ['facebook', 'twitter', 'linkedin', 'email', 'skype', 'github', 'dribble', 'lastfm', 'linkedin', 'tumblr', 'vimeo', 'wordpress', 'yahoo', 'youtube', 'flickr', 'pinterest', 'instagram'];

    $teams  = ( isset( $teams ) && !empty( $teams ) ) ? $teams : array();

    echo '<table class="socials-admin">';

        foreach( $arraySocials as $social ){

            if( !isset( $teams[$social] ) ){

                $teams[ $social ] = '';

            }

            if( $social == 'email' ){

                $icon = 'mail';

            }elseif( $social == 'dribble' ){

                $icon = 'dribbble';

            }elseif( $social == 'youtube' ){

                $icon = 'video';

            }else{

                $icon = NULL;

            }

            echo    '<tr>
                        <td>
                            <i alt="'. $social .'" class="icon-'. (isset($icon) ? $icon : $social) .'"></i>
                        </td>
                        <td>
                            <input type="text" name="teams['. $social .']" value="'. $teams[$social] .'" />
                        </td>
                    </tr>';
        }

    echo '</table>';

}

function airkit_teams_save_post($post_ID)
{
    global $post;

    if ( isset($post->post_type) && @$post->post_type != 'ts_teams' ) {
        return;
    }

    if (!isset( $_POST['ts_teams_nonce'] ) ||
        !wp_verify_nonce( $_POST['ts_teams_nonce'], plugin_basename( __FILE__ ) )
    ) return;

    if( !current_user_can( 'edit_post', $post_ID ) ) return;

    // array containing filtred slides
    $teams = array();

    $arraySocials = ['facebook', 'twitter', 'linkedin', 'email', 'skype', 'github', 'dribble', 'lastfm', 'linkedin', 'tumblr', 'vimeo', 'wordpress', 'yahoo', 'youtube', 'flickr', 'pinterest', 'instagram'];

    if ( isset( $_POST['teams'] ) && is_array( $_POST['teams'] ) && !empty( $_POST['teams'] )  ) {

        $t = $_POST['teams'];

        $teams['about_member'] = isset($t['about_member']) ? wp_kses_post($t['about_member']) : '';
        $teams['position']     = isset($t['position']) ? sanitize_text_field($t['position']) : '';
        $teams['team-user']    = isset($t['team-user']) ? sanitize_text_field($t['team-user']) : '';

        foreach($t as $key => $value){

            if( in_array($key, $arraySocials) ){
                $teams[$key] = esc_url_raw($value);
            }
        }

    } else {
        $teams['about_member'] = '';
        $teams['position']     = '';
        $teams['team-user']    = '';
        foreach($arraySocials as $social){
            $teams[$social] = '';
        }
    }

    update_post_meta( $post_ID, 'ts_member', $teams );
}

add_action( 'add_meta_boxes', 'airkit_portfolio_add_custom_box' );
add_action( 'save_post', 'airkit_portfolio_save_postdata' );

function airkit_portfolio_add_custom_box()
{
    add_meta_box(
        'ts_portfolio',
        'Portfolio',
        'airkit_portfolio_custom_box',
        'portfolio'
    );
}

function airkit_portfolio_custom_box( $post )
{
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ts_portfolio_nonce' );
    $portfolio_items = get_post_meta($post->ID, 'ts_portfolio', TRUE);
    $portfolio_details = get_post_meta($post->ID, 'ts_portfolio_details', TRUE);

    echo '
    <h4>' . esc_html__( 'Portfolio details','gowatch' ) . '</h4>
    <table width="450"><tr class="portfolio-client">
                <td>' . esc_html__( 'Client','gowatch' ) . '</td>
                <td>
                    <input type="text" class="client" name="portfolio_details[client]" value="'.@$portfolio_details['client'].'" style="width: 100%" />
                </td>
            </tr>
            <tr class="portfolio-services">
                <td>' . esc_html__( 'Services','gowatch' ) . '</td>
                <td>
                    <input type="text" class="services" name="portfolio_details[services]" value="'.@$portfolio_details['services'].'" style="width: 100%" />
                </td>
            </tr>
            <tr class="portfolio-client-url">
                <td>' . esc_html__( 'Project URL','gowatch' ) . '</td>
                <td>
                    <input type="text" class="client_url" name="portfolio_details[project_url]" value="'.@$portfolio_details['project_url'].'" style="width: 100%" />
                </td>
            </tr></table><br><br>';
    echo '<input type="button" class="button" id="add-item" value="' .esc_html__('Add New Portfolio Item','gowatch'). '" /><br/>';
    echo '<ul id="portfolio-items">';

    $portfolio_editor = '';

    if (!empty($portfolio_items)) {
        $index = 0;
        foreach ($portfolio_items as $portfolio_item_id => $portfolio_item) {
            $index++;
            $is_image = ($portfolio_item['item_type'] == 'i') ? 'checked="checked"' : '';
            $is_video = ($portfolio_item['item_type'] == 'v') ? 'checked="checked"' : '';

            $id = $portfolio_item['item_id'];

            $portfolio_editor .= '
            <li class="portfolio-item">
            <div class="sortable-meta-element"><span class="tab-arrow icon-up"></span> <span class="portfolio-item-tab">'.($portfolio_item['slide_title'] ? $portfolio_item['slide_title'] : 'Slide ' . $index).'</span></div>
            <table class="hidden">
            <tr>
                <td>' . esc_html__( 'Item type','gowatch' ) . '</td>
                <td>
                    <label for="item-type-image-'.$id.'">
                        <input type="radio" class="item-type-image" name="portfolio['.$id.'][item_type]" value="i" checked="checked" id="item-type-image-'.$id.'" '.$is_image.'/> Image
                    </label>
                    <label for="item-type-video-'.$id.'">
                        <input type="radio" class="item-type-video" name="portfolio['.$id.'][item_type]" value="v" id="item-type-video-'.$id.'" '.$is_video.'/> Video
                    </label>
                </td>
            </tr>
            <tr>
                <td>' . esc_html__( 'Title','gowatch' ) . '</td>
                <td>
                    <input type="text" class="slide_title" name="portfolio['.$id.'][slide_title]" value="'.$portfolio_item['slide_title'].'" style="width: 100%" />
                </td>
            </tr>
            <tr class="portfolio-embed '.( $is_image ? 'hidden' : '' ).'">
                <td valign="top">' . esc_html__( 'Embed/Video URL<br/>(<a href="http://codex.wordpress.org/Embeds#Can_I_Use_Any_URL_With_This.3F" target="_blank">supported sites</a>)','gowatch' ) . '</td>
                <td>
                    <textarea name="portfolio['.$id.'][embed]" cols="60" rows="5">'.$portfolio_item['embed'].'</textarea>
                </td>
            </tr>
            <tr class="portfolio-description '.( $is_video ? 'hidden' : '' ).'">
                <td valign="top">' . esc_html__( 'Description','gowatch' ) . '</td>
                <td>
                    <textarea class="slide_description" name="portfolio['.$id.'][description]" cols="60" rows="5">'.$portfolio_item['description'].'</textarea>
                </td>
            </tr>
            <tr class="portfolio-image-url '.( $is_video ? 'hidden' : '' ).'">
                <td>' . esc_html__( 'Image URL','gowatch' ) . '</td>
                <td>
                    <input type="text" class="slide_url" name="portfolio['.$id.'][item_url]" value="'.$portfolio_item['item_url'].'" />
                    <input type="hidden" class="slide_media_id" name="portfolio['.$id.'][media_id]" value="'.$portfolio_item['media_id'].'" />
                    <input type="button" id="upload-'.$id.'" class="button ts-upload-slide" value="' .esc_html__( 'Upload','gowatch' ). '" />
                </td>
            </tr>
            <tr class="portfolio-redirect-url '.( $is_video ? 'hidden' : '' ).'">
                <td>' . esc_html__( 'Redirect to URL','gowatch' ) . '</td>
                <td>
                    <input type="text" class="redirect_to_url" name="portfolio['.$id.'][redirect_to_url]" value="'.$portfolio_item['redirect_to_url'].'" style="width: 100%" />
                </td>
            </tr>
            <tr>
                <td></td><td><input type="button" class="button button-primary remove-item" value="'.esc_html__('Remove','gowatch').'" /></td>
            </tr>
            </table>

            </li>';
        }
    }

    echo airkit_var_sanitize($portfolio_editor, 'true');

    echo '</ul>';

    echo '<script id="portfolio-items-template" type="text/template">';
    echo '<li class="portfolio-item">
    <div class="sortable-meta-element"><span class="tab-arrow icon-up"></span> <span class="portfolio-item-tab">Slide {{slide-number}}</span></div>
    <table>
        <tr>
            <td>' . esc_html__( 'Item type','gowatch' ) . '</td>
            <td>
                <label for="item-type-image-{{item-id}}">
                    <input type="radio" class="item-type-image" name="portfolio[{{item-id}}][item_type]" value="i" checked="checked" id="item-type-image-{{item-id}}"/> Image
                </label>
                <label for="item-type-video-{{item-id}}">
                    <input type="radio" class="item-type-video" name="portfolio[{{item-id}}][item_type]" value="v" id="item-type-video-{{item-id}}" /> Video
                </label>
            </td>
        </tr>
        <tr>
            <td>' . esc_html__( 'Title','gowatch' ) . '</td>
            <td>
                <input type="text" class="slide_title" name="portfolio[{{item-id}}][slide_title]" value="" style="width: 100%" />
            </td>
        </tr>
        <tr class="portfolio-embed hidden">
            <td valign="top">' . esc_html__( 'Embed/Video URL<br/>(<a href="http://codex.wordpress.org/Embeds#Can_I_Use_Any_URL_With_This.3F" target="_blank">supported sites</a>)','gowatch' ) . '</td>
            <td>
                <textarea name="portfolio[{{item-id}}][embed]" cols="60" rows="5"></textarea>
            </td>
        </tr>
        <tr class="portfolio-description">
            <td valign="top">' . esc_html__( 'Description','gowatch' ) . '</td>
            <td>
                <textarea class="slide_description" name="portfolio[{{item-id}}][description]" cols="60" rows="5"></textarea>
            </td>
        </tr>
        <tr class="portfolio-image-url">
            <td>' . esc_html__( 'Image URL','gowatch' ) . '</td>
            <td>
                <input type="text" class="slide_url" name="portfolio[{{item-id}}][item_url]" value="" />
                <input type="hidden" class="slide_media_id" name="portfolio[{{item-id}}][media_id]" value="" />
                <input type="button" id="upload-{{item-id}}" class="button ts-upload-slide" value="' .esc_html__( 'Upload','gowatch' ). '" />
            </td>
        </tr>
        <tr class="portfolio-redirect-url">
            <td>' . esc_html__( 'Redirect to URL','gowatch' ) . '</td>
            <td>
                <input type="text" class="redirect_to_url" name="portfolio[{{item-id}}][redirect_to_url]" value="" style="width: 100%" />
            </td>
        </tr>
        <tr>
            <td></td><td><input type="button" class="button button-primary remove-item" value="'.esc_html__('Remove','gowatch').'" /></td>
        </tr>
    </table></li>';

    echo '</script>';
?>
    <script>
    jQuery(document).ready(function($) {
        var portfolio_items = $("#portfolio-items > li").length;

        // sortable portfolio items
        $("#portfolio-items").sortable();
        //$("#portfolio-items").disableSelection();

        $(document).on('change', '.slide_title', function(event) {
            event.preventDefault();
            var _this = $(this);
            _this.closest('.portfolio-item').find('.portfolio-item-tab').text(_this.val());
        });

        // Content type switcher
        $(document).on('click', '.item-type-image', function(event) {
            var _this = $(this);
            _this.closest('table').find('.portfolio-embed').hide();
            _this.closest('table').find('.portfolio-description').show();
            _this.closest('table').find('.portfolio-image-url').show();
            _this.closest('table').find('.portfolio-redirect-url').show();
        });

        $(document).on('click', '.item-type-video', function(event) {
            var _this = $(this);
            _this.closest('table').find('.portfolio-embed').show();
            _this.closest('table').find('.portfolio-description').hide();
            _this.closest('table').find('.portfolio-image-url').hide();
            _this.closest('table').find('.portfolio-redirect-url').hide();
        });

        // Media uploader
        var items = $('#portfolio-items'),
            slideTempalte = $('#portfolio-items-template').html(),
            custom_uploader = {};

        if (typeof wp.media.frames.file_frame == 'undefined') {
            wp.media.frames.file_frame = {};
        }

        $(document).on('click', '#add-item', function(event) {
            event.preventDefault();
            portfolio_items++;
            var sufix = new Date().getTime();
            var item_id = new RegExp('{{item-id}}', 'g');
            var item_number = new RegExp('{{slide-number}}', 'g');

            var template = slideTempalte.replace(item_id, sufix).replace(item_number, portfolio_items);
            items.append(template);
        });

        $(document).on('click', '.remove-item', function(event) {
            event.preventDefault();
            $(this).closest('li').remove();
            portfolio_items--;
        });


        $(document).on('click', '.ts-upload-slide', function(e) {
            e.preventDefault();

            var _this     = $(this),
                target_id = _this.attr('id'),
                media_id  = _this.closest('li').find('.slide_media_id').val();

            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader[target_id]) {
                custom_uploader[target_id].open();
                return;
            }

            //Extend the wp.media object
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

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader[target_id].on('select', function() {
                var attachment = custom_uploader[target_id].state().get('selection').first().toJSON();
                var item = _this.closest('table');

                item.find('.slide_url').val(attachment.url);
                item.find('.slide_media_id').val(attachment.id);
            });

            //Open the uploader dialog
            custom_uploader[target_id].open();
        });
    });
    </script>
<?php
}

// saving slider
function airkit_portfolio_save_postdata( $post_ID )
{
    global $post;

    if ( isset($post->post_type) && @$post->post_type != 'portfolio' ) {
        return;
    }

    if ( ! isset( $_POST['ts_portfolio_nonce'] ) ||
         ! wp_verify_nonce( $_POST['ts_portfolio_nonce'], plugin_basename( __FILE__ ) )
    ) return;

    if( !current_user_can( 'edit_post', $post_ID ) ) return;

    // array containing filtred items
    $portfolio_items = array();

    if ( isset( $_POST['portfolio'] ) ) {
        if ( is_array( $_POST['portfolio'] ) && !empty( $_POST['portfolio'] ) ) {
            foreach ( $_POST['portfolio'] as $item_id => $portfolio_item ) {

                $p = array();
                $p['item_id']   = $item_id;

                $p['item_type'] = isset($portfolio_item['item_type']) ?
                                esc_attr($portfolio_item['item_type']) : '';

                $p['item_type'] = isset($portfolio_item['item_type']) &&
                                ( $portfolio_item['item_type'] === 'i' || $portfolio_item['item_type'] === 'v' ) ?
                                $portfolio_item['item_type'] : 'i';

                $p['slide_title'] = isset($portfolio_item['slide_title']) ?
                                esc_textarea($portfolio_item['slide_title']) : '';

                $p['embed'] = isset($portfolio_item['embed']) ?
                            esc_textarea($portfolio_item['embed']) : '';

                $p['description'] = isset($portfolio_item['description']) ?
                                esc_textarea($portfolio_item['description']) : '';

                $p['item_url'] = isset($portfolio_item['item_url']) ?
                                esc_url($portfolio_item['item_url']) : '';

                $p['media_id'] = isset($portfolio_item['media_id']) ?
                                esc_attr($portfolio_item['media_id']) : '';

                $p['redirect_to_url'] = isset($portfolio_item['redirect_to_url']) ?
                                    esc_url($portfolio_item['redirect_to_url']) : '';

                $portfolio_items[] = $p;
            }
        }
    }
    if(isset($_POST['portfolio_details'])){
        $portfolio_details = $_POST['portfolio_details'];
    }

    update_post_meta( $post_ID, 'ts_portfolio', $portfolio_items );
    update_post_meta( $post_ID, 'ts_portfolio_details', $portfolio_details );
}


// Create boxes for audio post format

add_action( 'add_meta_boxes', 'airkit_audio_post_add_custom_box' );
function airkit_audio_post_add_custom_box()
{
	add_meta_box(
        'audio_embed',
        esc_html__('Audio embed', 'gowatch'),
        'airkit_audio_post_options_custom_box',
        'post'
    );
}

function airkit_audio_post_options_custom_box($post)
{
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'ts_audio_nonce' );
	$audio_post = get_post_meta($post->ID, 'audio_embed' , TRUE);

	if (!$audio_post) {
		$audio_post = '';
	}

	echo '<table>
		<tr valign="top">
			<td>' . esc_html__('Audio embed code', 'gowatch') . '</td>
			<td>
				<textarea name="audio_embed" cols="60" rows="5">'.esc_attr(@$audio_post).'</textarea>
			</td>
		</tr>
		</table>';

}
// saving audio post embed data
function airkit_audio_post_postdata( $post_ID )
{
	global $post;

    if ( isset($post->post_type) && @$post->post_type != 'post' ) {
        return;
    }

	if (!isset( $_POST['ts_audio_nonce'] ) ||
		!wp_verify_nonce( $_POST['ts_audio_nonce'], plugin_basename( __FILE__ ) )
	) return;


	// array containing filtred slides

    $audio_embed_code = $_POST['audio_embed'];
    update_post_meta( $post_ID, 'audio_embed', $audio_embed_code );
}
add_action( 'save_post', 'airkit_audio_post_postdata' );


/**************************************************************************
 ************** Select layouts for posts and pages ************************
 *************************************************************************/

add_action( 'add_meta_boxes', 'airkit_layout_custom_boxes' );
add_action( 'save_post', 'airkit_layout_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function airkit_layout_custom_boxes() {
    $screens = array( 'page' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'airkit_layout_id',
            esc_html__( 'Custom Layout', 'gowatch' ),
            'airkit_layout_selector_custom_box',
            $screen
        );

    }
    
    // Add the header and footer meta box
    add_meta_box(
        'airkit_header_and_footer',
        esc_html__( 'Header & Footer', 'gowatch' ),
        'airkit_header_and_footer_custom_box',
        'page',
        'normal',
        'high'
    );
    // Add the page options meta box
    add_meta_box(
        'ts_page_options',
        esc_html__( 'Page options', 'gowatch' ),
        'airkit_page_options_custom_box',
        'page',
        'normal',
        'high'
    );
    // Add the post options meta box
    add_meta_box(
        'ts_post_options',
        esc_html__( 'Post options', 'gowatch' ),
        'airkit_post_options_custom_box',
        'post',
        'normal',
        'high'
    );
    // Add the post type gallery options meta box
    add_meta_box(
        'ts_post_options',
        esc_html__( 'Post options', 'gowatch' ),
        'airkit_post_options_custom_box',
       'ts-gallery',
        'normal',
        'high'
    );

    $sidebar_screens = array( 'page', 'post', 'portfolio', 'product', 'video', 'event', 'ts-gallery' );

    foreach ($sidebar_screens as $screen) {
        add_meta_box(
            'airkit_sidebar',
            esc_html__( 'Layout', 'gowatch' ),
            'airkit_sidebar_custom_box',
            $screen,
            'side',
            'low'
        );
    }
}

/* Prints the box content */
function airkit_layout_selector_custom_box( $post )
{
    $template_id = airkit_Template::get_template_info('page', 'id');
    $template_name = airkit_Template::get_template_info('page', 'name');

    echo airkit_Options::gowatch_template_modals( 'page', $template_id, $template_name );

    airkit_layout_wrapper( airkit_Template::edit( $post->ID ) );
}

function airkit_page_options_custom_box( $post )
{
    $meta = get_post_meta( $post->ID, 'airkit_post_settings', true );

    airkit_Fields::logicMetaRadio('airkit_post_settings', 'title', airkit_Fields::get_value( 'title', $meta ), 'Show title for this post', esc_html__('If set to yes, this option will show the title of the post on this specific post','gowatch') );

    airkit_Fields::logicMetaRadio('airkit_post_settings', 'breadcrumbs', airkit_Fields::get_value( 'breadcrumbs', $meta ), 'Show breadcrumbs for this page.', esc_html__('Display breadcrumbs','gowatch') );

    airkit_Fields::logicMetaRadio('airkit_post_settings', 'meta', airkit_Fields::get_value( 'meta', $meta ), 'Show meta for this post', esc_html__('If set to yes, this option will show the meta of the post on this specific post','gowatch') );

    airkit_Fields::logicMetaRadio('airkit_post_settings', 'sharing', airkit_Fields::get_value( 'sharing', $meta ), 'Show social sharing for this post', esc_html__('If set to yes, this option will show the social sharing buttons of the post on this specific post','gowatch') );

    airkit_Fields::logicMetaRadio('airkit_post_settings', 'img', airkit_Fields::get_value( 'img', $meta ), 'Show featured image for this post', esc_html__('If set to yes, this option will show the featured image of the post on this specific post','gowatch') );

    airkit_Fields::logicMetaRadio('airkit_post_settings', 'author', airkit_Fields::get_value( 'author', $meta ), 'Show author box for this post', esc_html__('If set to yes, this option will show the author box of the post on this specific post','gowatch') );

}

function airkit_post_options_custom_box( $post )
{
    $meta       = get_post_meta( $post->ID, 'airkit_post_settings', true );
    $post_type  = get_post_type( $post->ID );
    $taxonomy   = airkit_Compilator::get_tax( get_post_type( $post->ID ) );
    $terms      = wp_get_post_terms( $post->ID, $taxonomy );

    $category_terms = array();
    $category_terms['n'] = esc_html__( 'None', 'gowatch' );

    $enable = array(
        'y' => esc_html__( 'Yes', 'gowatch'),
        'n' => esc_html__( 'No', 'gowatch'),
    );

    $dropcap = array(
        'std'      => esc_html__( 'Default', 'gowatch'),
        'n'        => esc_html__( 'Disabled', 'gowatch' ),
        'subtitle' => esc_html__( 'Enable for subtitle', 'gowatch' ),
        'content'  => esc_html__( 'Enable for content', 'gowatch' ),
    );

    foreach ($terms as $key => $term) {
        
        $category_terms[$term->term_id] = $term->name;
    }

    airkit_Fields::selectMeta( 'airkit_post_settings', 'primary_category', $category_terms, airkit_Fields::get_value( 'primary_category', $meta ), 'Primary category', esc_html__('Select the primary category. Determinate which category is the most important and would show in frontend.', 'gowatch' ) );

    airkit_Fields::textareaText( 'airkit_post_settings', 'subtitle', airkit_Fields::get_value( 'subtitle', $meta, '' ), 'Add subtitle', esc_html__( 'Add subtitle to post','gowatch' ) );

    airkit_Fields::selectMeta( 
        'airkit_post_settings', //group
        'subscribers_only', //id
        array(
            'n' => esc_html__('No', 'gowatch'),
            'y' => esc_html__('Yes', 'gowatch'),
        ), //options
        airkit_Fields::get_value( 'subscribers_only', $meta ), //value
        'Visible only for subscribers', //option title
        esc_html__('If this option is enabled, only logged in users will be able to see this post.', 'gowatch' ) //desc
    );

    airkit_Fields::selectMeta( 'airkit_post_settings', 'dropcap', $dropcap, airkit_Fields::get_value( 'dropcap', $meta ), 'Dropcap', esc_html__('If enabled, this option will make first character big.', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'title', airkit_Fields::get_value( 'title', $meta ), 'Show title for this post', esc_html__('If set to yes, this option will show the title of the post on this specific post','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'img', airkit_Fields::get_value( 'img', $meta ), 'Show featured image', esc_html__('If set to yes, this option will show the featured image of the post on this specific post.','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'likes', airkit_Fields::get_value( 'likes', $meta ), 'Show likes for this post', esc_html__( 'If set to yes, this option will show the likes of this specific post.', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'views', airkit_Fields::get_value( 'views', $meta ), 'Show views for this post', esc_html__( 'If set to yes, this option will show the views of the post on this specific post.', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'date', airkit_Fields::get_value( 'date', $meta ), 'Show date for this post', esc_html__( 'If set to yes, this option will show the date of the post on this specific post.', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'featured_box', airkit_Fields::get_value( 'featured_box', $meta ), 'Show featured articles box in post content', esc_html__( 'If set to yes, this option will add automatically add a box with 3 latest featured articles after the third paragraph of your content.', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'author', airkit_Fields::get_value( 'author', $meta ), 'Show author for this post', esc_html__( 'If set to yes, this option will show the author of the post on this specific post.', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'sharing', airkit_Fields::get_value( 'sharing', $meta ), 'Show social sharing for this post', esc_html__('If set to yes, this option will show the social sharing buttons of the post on this specific post', 'gowatch' ) );


    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'breadcrumbs', airkit_Fields::get_value( 'breadcrumbs', $meta ), 'Show breadcrumbs for this post', esc_html__('Display breadcrumbs','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'post-tags', airkit_Fields::get_value( 'tags', $meta ), 'Show tags for this post', esc_html__( 'Display tags', 'gowatch' ) );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'author-box', airkit_Fields::get_value( 'author-box', $meta ), 'Show author box for this post', esc_html__('If set to yes, this option will show the author box of the post on this specific post','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'pagination', airkit_Fields::get_value( 'pagination', $meta ), 'Show pagination posts for this post', esc_html__('If set to yes, this option will show the pagination of the post on this specific post.','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'related', airkit_Fields::get_value( 'related', $meta ), 'Show related articles for this post', esc_html__('If set to yes, this option will show the related articles of the post on this specific post','gowatch') );

    airkit_Fields::logicMetaRadio( 'airkit_post_settings', 'sticky_sidebar', airkit_Fields::get_value( 'sticky_sidebar', $meta ), 'Show sticky sidebar', esc_html__( 'If set to yes, this option will make sticky sidebar', 'gowatch' ) );

    airkit_video_sources( $post->ID );

}

add_action( 'show_user_profile', 'airkit_user_extra_profile_fields' );
add_action( 'edit_user_profile', 'airkit_user_extra_profile_fields' );

function airkit_user_extra_profile_fields( $user ) {
    $options = airkit_option_value('social');
    $user_settings = get_the_author_meta( 'airkit_user_settings', $user->ID );
    $social_names = array(
        'facebook' => 'Facebook',
        'skype' => 'Skype',
        'github' => 'GitHub',
        'dribbble' => 'Dribbble',
        'lastfm' => 'Last.fm',
        'tumblr' => 'Tumblr',
        'twitter' => 'Twitter',
        'vimeo' => 'Vimeo',
        'wordpress' => 'WordPress',
        'yahoo' => 'Yahoo',
        'youtube' => 'YouTube',
        'flickr' => 'Flickr',
        'pinterest' => 'Pinterest',
        'instagram' => 'Instagram',
        'snapchat' => 'Snapchat',
        'vk' => 'VK',
        'reddit' => 'reddit',
    );
?>
 
<?php if ( is_admin() ): ?>
    
    <h3><?php echo esc_html__( 'Media', 'gowatch' ); ?></h3>

    <?php 
        $user_settings['avatar'] = isset( $user_settings['avatar'] ) && ($user_settings['avatar'] != '') ? $user_settings['avatar'] : 0;
        $user_settings['cover'] = isset( $user_settings['cover'] ) && ($user_settings['cover'] != '') ? $user_settings['cover'] : 0;
        wp_nonce_field( 'user_profile_media_upload', 'user_profile_media_upload_nonce' );

        echo airkit_Fields::upload(
            array(    
                'name'  => esc_html__( 'Avatar ', 'gowatch' ),            
                'id'    => 'airkit_user_avatar',
                'std'   => '',
            ), 
            array('airkit_user_avatar' => $user_settings['avatar'])
        );

        echo airkit_Fields::upload(
            array(    
                'name'  => esc_html__( 'Profile Cover ', 'gowatch' ),            
                'id'    => 'airkit_user_cover',
                'std'   => '',
            ), 
            array('airkit_user_cover' => $user_settings['cover'])
        );

    ?>

<?php else: ?>

    <legend><?php echo esc_html__( 'Media', 'gowatch' ); ?></legend>

    <ul class="tszf-form row">

        <?php wp_nonce_field( 'user_profile_media_upload', 'user_profile_media_upload_nonce' ); ?>

        <li class="col-lg-4">
            <div class="tszf-label">
                <label for="airkit_user_avatar"><?php esc_html_e('Avatar', 'gowatch') ?></label>
            </div>
            <div class="tszf-fields">
                <input type="file" name="airkit_user_avatar" id="airkit_user_avatar" multiple="false" />
                <?php if ( isset( $user_settings['avatar'] ) ) : ?>
                    <figure class="tszf-image-wrap">
                        <?php echo wp_get_attachment_image(airkit_Compilator::get_attachment_field($user_settings['avatar'], 'id'), array(100, 100)); ?>
                    </figure>
                <?php endif; ?>
            </div>
            <div class="tszf-description">
                <?php esc_html_e('Upload your profile avatar.', 'gowatch'); ?>
            </div>
        </li>
        <li class="col-lg-4">
            <div class="tszf-label">
                <label for="airkit_user_cover"><?php esc_html_e('Profile Cover', 'gowatch') ?></label>
            </div>
            <div class="tszf-fields">
                <input type="file" name="airkit_user_cover" id="airkit_user_cover" multiple="false" />
                <?php if ( isset( $user_settings['cover'] ) ) : ?>
                    <figure class="tszf-image-wrap">
                        <?php echo wp_get_attachment_image(airkit_Compilator::get_attachment_field($user_settings['cover'], 'id'), array(100, 100)); ?>
                    </figure>
                <?php endif; ?>
            </div>
            <div class="tszf-description">
                <?php esc_html_e('Upload your profile cover image. We recommend to upload image with minimum size 1900px x 300px.', 'gowatch'); ?>
            </div>
        </li>
    
    </ul>

<?php endif ?>

<?php if( is_admin() ): ?>
    <h3><?php echo esc_html__( 'Social networks', 'gowatch' ); ?></h3>
    <table class="form-table">

        <?php foreach ($options as $key => $social): ?>
            
            <?php 

                if ( 'email' == $key || 'sharing-single-block' == $key || 'social_sharing_items' == $key ) {
                    continue;
                }

                if ( !isset( $user_settings[ 'user_social_' . $key ] ) ) {

                    $user_settings[ 'user_social_' . $key ] = ' ';

                }
            ?>

            <tr>
                <th><label for="airkit_user_<?php echo esc_attr( $key ); ?>"><?php echo airkit_var_sanitize( $social_names[$key], 'the_kses' ); ?></label></th>
            
                <td>
                    <input type="text" name="airkit_user_settings[<?php echo esc_attr( 'user_social_' . $key ) ?>]" id="airkit_user_<?php echo esc_attr( $key ); ?>" value="<?php echo isset($user_settings['user_social_' . $key]) ? esc_attr( $user_settings['user_social_' . $key . ''] ) : ''; ?>" class="regular-text" /><br />
                    <p class="description"><?php printf( esc_html__('Please enter your %s link.', 'gowatch'), $social_names[$key] ); ?></p>
                </td>
            </tr>
                
        <?php endforeach ?>
 
    </table>

<?php else: // Output for Frontend Dashboard ?>

    <legend><?php echo esc_html__( 'Social networks', 'gowatch' ); ?></legend>     
    <ul class="tszf-form row">

        <?php foreach ($options as $key => $social): ?>
            
            <?php 

                if ( 'email' == $key || 'sharing-single-block' == $key || 'social_sharing_items' == $key ) {
                    continue;
                }

                if ( !isset( $user_settings[ 'user_social_' . $key ] ) || !isset( $social_names[$key] ) ) {
                    continue;
                    $user_settings[ 'user_social_' . $key ] = '';

                }
            ?>

            <li class="col-lg-4">
                <div class="tszf-label">
                    <label for="airkit_user_<?php echo esc_attr( $key ); ?>"><?php echo airkit_var_sanitize( $social_names[$key], 'the_kses' ); ?></label>
                </div>
                <div class="tszf-fields">
                    <input type="text" name="airkit_user_settings[<?php echo esc_attr( 'user_social_' . $key ) ?>]" id="airkit_user_<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $user_settings['user_social_' . $key . ''] ); ?>" class="regular-text" />
                </div>
                <div class="tszf-description">
                    <?php printf( esc_html__('Please enter your %s link.', 'gowatch'), $social_names[$key] ); ?>
                </div>
            </li> 
                
        <?php endforeach ?>
    
    </ul>
<?php endif; ?>
<?php

}

add_action( 'personal_options_update', 'airkit_user_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'airkit_user_save_extra_profile_fields' );
 
function airkit_user_save_extra_profile_fields( $user_id ) {
 
    $user_settings = get_the_author_meta( 'airkit_user_settings', $user_id );

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    // Get and save page options meta box options
    $form_settings = @$_POST['airkit_user_settings'];

    // Check that the nonce is valid, and the user can edit this post.
    if ( 
        isset( $_POST['user_profile_media_upload_nonce'] ) 
        && wp_verify_nonce( $_POST['user_profile_media_upload_nonce'], 'user_profile_media_upload' )
    ) {

        // The nonce was valid and the user has the capabilities, it is safe to continue.
        $avatar = isset($user_settings['avatar']) ? $user_settings['avatar'] : '';
        $cover  = isset($user_settings['cover']) ? $user_settings['cover'] : '';

        $form_settings['avatar'] = $avatar;
        $form_settings['cover'] = $cover;
         
        // These files need to be included as dependencies when on the front end.
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        $a_attach_id = airkit_Compilator::get_attachment_field($avatar, 'id');
        $c_attach_id = airkit_Compilator::get_attachment_field($cover, 'id');

        // Let WordPress handle the upload.

        // this is uses for front-end only
        if ( is_array($_FILES) && ! empty($_FILES) ) {
            foreach ($_FILES as $key => $file) {
                $attach_id = media_handle_upload($key, $user_id);
                $image_attributes = wp_get_attachment_image_src($attach_id);
                $attach_url = $image_attributes[0];

                if ( !is_wp_error($attach_id) ) {
                    $_key = str_replace('airkit_user_', '', $key);
                    $form_settings[$_key] = implode('|', array($attach_id, $attach_url));
                }
            }
        }

        // for admin panel
        if ( ! empty($_POST['airkit_user_avatar']) ) {
            $form_settings['avatar'] = $_POST['airkit_user_avatar'];
        }

        if ( ! empty($_POST['airkit_user_cover']) ) {
            $form_settings['cover'] = $_POST['airkit_user_cover'];
        }

    }

    update_user_meta( absint( $user_id ), 'airkit_user_settings', wp_kses_post( $form_settings ) );
}

function airkit_header_and_footer_custom_box( $post )
{
    $header_footer = get_post_meta( $post->ID, 'airkit_header_and_footer', true );
    $breadcrumbs = get_option('gowatch_single_post', array('breadcrumbs' => 'y'));
    $breadcrumbs_clean = (isset($breadcrumbs['breadcrumbs']) && $breadcrumbs['breadcrumbs'] === 'y' ) ? 0 : 1;

    if( isset($header_footer['breadcrumbs']) ){
    	$disable_breadcrumbs = ( $header_footer['breadcrumbs'] === 1 ) ? 'checked="checked"' : '';
    }else{
        $disable_breadcrumbs = ($breadcrumbs_clean === 1) ? 'checked="checked"' : '';
    }

    if ( $header_footer ) {
        $disable_header = ( isset($header_footer['disable_header']) && $header_footer['disable_header'] === 1 ) ? 'checked="checked"' : '';
        $disable_footer = ( isset($header_footer['disable_footer']) && $header_footer['disable_footer'] === 1 ) ? 'checked="checked"' : '';
        $enable_preloader = ( isset($header_footer['enable_preloader']) && $header_footer['enable_preloader'] === 1 ) ? 'checked="checked"' : '';

    } else {
        $disable_header = '';
        $disable_footer = '';
        $enable_preloader = '';
    }

    echo '<p>
            <label class="switch" for="ts-disable-header">
              <input id="ts-disable-header" class="switch-input" name="ts_header_footer[disable_header]" type="checkbox" value="1" '.$disable_header.'>
              <span class="switch-label" data-on="'. esc_html__('Yes','gowatch') . '" data-off="' . esc_html__('No','gowatch') . '"></span>
              <span class="switch-handle"></span>
            </label>
            '.esc_html__('Disable header', 'gowatch').'
            <div class="ts-option-description">
				'.esc_html__('This options will disable the default global header. You can use it if you want to create a custom header for this page using the layout builder. Global (default) header options are in a tab in the theme options panel. (in the menu on the left, last icon).', 'gowatch').'
            </div>
        </p>
        <p>
            <label class="switch" for="ts-disable-footer">
              <input id="ts-disable-footer" class="switch-input" type="checkbox" name="ts_header_footer[disable_footer]" value="1" '.$disable_footer.'>
              <span class="switch-label" data-on="'. esc_html__('Yes','gowatch') . '" data-off="' . esc_html__('No','gowatch') . '"></span>
              <span class="switch-handle"></span>
            </label>
            '.esc_html__('Disable footer', 'gowatch').'
            <div class="ts-option-description">
				'.esc_html__('This options will disable the default global footer. You can use it if you want to create a custom footer for this page using the layout builder. Global (default) footer options are in a tab in the theme options panel. (in the menu on the left, last icon).', 'gowatch').'
            </div>
        </p>
        <p>
            <label class="switch" for="ts-force-preloader">
              <input id="ts-force-preloader" class="switch-input" type="checkbox" name="ts_header_footer[enable_preloader]" value="1" '.$enable_preloader.'>
              <span class="switch-label" data-on="'. esc_html__('Yes','gowatch') . '" data-off="' . esc_html__('No','gowatch') . '"></span>
              <span class="switch-handle"></span>
            </label>
            '.esc_html__('Enable Preloader', 'gowatch').'
            <div class="ts-option-description">
                '.esc_html__('Force preloader for this page', 'gowatch').'
            </div>
        </p>
        <p>
            <label class="switch" for="ts-disable-breadcrumbs">
              <input id="ts-disable-breadcrumbs" class="switch-input" type="checkbox" name="ts_header_footer[breadcrumbs]" value="1" '.$disable_breadcrumbs.'>
              <span class="switch-label" data-on="'. esc_html__('Yes','gowatch') . '" data-off="' . esc_html__('No','gowatch') . '"></span>
              <span class="switch-handle"></span>
            </label>
            '.esc_html__('Disable breadcrumbs', 'gowatch').'
            <div class="ts-option-description">
				'.esc_html__('Hide the breadcrumbs in this page', 'gowatch').'
            </div>
        </p>';


}

/* When the post is saved, saves our custom data */
function airkit_layout_save_postdata( $post_ID ) {

	$post_types = array( 'page', 'post', 'portfolio', 'product', 'video', 'event', 'ts-gallery' );

	// First we need to check if the current user is authorised to do this action.
	if ( in_array(get_post_type($post_ID), $post_types) ) {

		if ( ! current_user_can( 'edit_page', $post_ID ) ) {
			return $post_ID;
		}

		if ( ! current_user_can( 'edit_post', $post_ID ) ) {
			return $post_ID;
		}

		// Secondly we need to check if the user intended to change this value.
		if ( ! isset( $_POST['airkit_layout_nonce_filed'] ) || ! wp_verify_nonce( @$_POST['airkit_layout_nonce_filed'], 'airkit_layout_nonce' ) ) return $post_ID;

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_ID;

		// Thirdly we can save the value to the database
		$post_ID = @$_POST['post_ID'];
		$sidebar = @$_POST['airkit_sidebar'];

		$new_sidebar_options = array(
			'position' => '',
			'size' => ''
		);

		if ( is_array( $sidebar ) &&
			 isset( $sidebar['position'] ) &&
			 isset( $sidebar['size'] ) &&
             isset( $sidebar['id'] )
			) {

			$valid_positions = array( 'none', 'left', 'right', 'std' );
			$valid_sizes = array( '1-3', '1-4', 'std' );

			if ( in_array( $sidebar['position'], $valid_positions ) ) {
				$new_sidebar_options['position'] = $sidebar['position'];
			} else {
				$new_sidebar_options['position'] = 'none';
			}

			if ( in_array( $sidebar['size'], $valid_sizes ) ) {
				$new_sidebar_options['size'] = $sidebar['size'];
			} else {
				$new_sidebar_options['size'] = '1-4';
			}

            $sidebars = ( $sidebars = get_option( 'gowatch_sidebars' ) ) && is_array( $sidebars ) ? $sidebars : array();
            $sidebars = array_merge( array( 'main' => esc_html__( 'Main Sidebar', 'gowatch' ), 'footer1' => esc_html__( 'Footer 1', 'gowatch' ), 'footer2' => esc_html__( 'Footer 2', 'gowatch' ), 'footer3' => esc_html__( 'Footer 3', 'gowatch' ), 'footer4' => esc_html__( 'Footer 4', 'gowatch' ) ), $sidebars );

            if ( array_key_exists( $sidebar['id'], $sidebars ) || $sidebar['id'] == 'main' ) {
                $new_sidebar_options['id'] = $sidebar['id'];
            } else {
                $new_sidebar_options['id'] = 'std';
            }

			update_post_meta( $post_ID, 'airkit_sidebar', $new_sidebar_options );
		}

		// Get and save header meta box options
        $header_footer = @$_POST['ts_header_footer'];

        $header_footer_options = array(
            'disable_header' => 0,
            'disable_footer' => 0,
            'enable_preloader' => 0,
            'breadcrumbs' => 0
        );

        if ( isset($header_footer['disable_header']) ) {
            $header_footer_options['disable_header'] = 1;
        }

        if ( isset($header_footer['disable_footer']) ) {
            $header_footer_options['disable_footer'] = 1;
        }

        if ( isset($header_footer['enable_preloader']) ) {
            $header_footer_options['enable_preloader'] = 1;
        }

        if ( isset($header_footer['breadcrumbs']) ) {
            $header_footer_options['breadcrumbs'] = 1;
        }

        update_post_meta( $post_ID, 'airkit_header_and_footer', $header_footer_options );


		// Get and save page options meta box options
        $airkit_page_settings = @$_POST['airkit_page_settings'];

        update_post_meta( $post_ID, 'airkit_page_settings', $airkit_page_settings );

        // Get and save page options meta box options
        $airkit_post_settings = @$_POST['airkit_post_settings'];

        update_post_meta( $post_ID, 'airkit_post_settings', $airkit_post_settings );
	}

    // Save video sources
    airkit_save_video_sources( $post_ID );
}

function airkit_get_layout_type( $post_ID = 0 )
{
	$layout_type = get_post_meta( $post_ID, 'airkit_layout_id', true );
}

function airkit_sidebar_custom_box( $post ) {

	$sidebar = get_post_meta( $post->ID, 'airkit_sidebar', true );

    $position = ! empty( $sidebar['position'] ) ? $sidebar['position'] : 'std';
    $sidebar_id = ! empty( $sidebar['id'] ) ? $sidebar['id'] : 'std';
    $size = ! empty( $sidebar['size'] ) ? $sidebar['size'] : 'std';

	$pos = array(
        'std'   => esc_html__( 'Default', 'gowatch' ),
		'none'  => esc_html__( 'None', 'gowatch' ),
		'left'  => esc_html__( 'Left', 'gowatch' ),
		'right' => esc_html__( 'Right', 'gowatch' )
	);

    $pos_options = '';
    foreach ( $pos as $key => $name ) {

        $pos_options .= '<option value="' . $key . '"' . selected( $position, $key, false ) . '>' . $name . '</option>';
    }

    $sidebars = ( $sidebars = get_option( 'gowatch_sidebars' ) ) && is_array( $sidebars ) ? $sidebars : array();
    $sidebar_options =  '<option value="std"' . selected( $sidebar_id, 'std', false ) . '>' . esc_html__( 'Default', 'gowatch' ) . '</option>
                        <option value="main"' . selected( $sidebar_id, 'main', false ) . '>' . esc_html__( 'Main sidebar', 'gowatch' ) . '</option>';

    foreach ( $sidebars as $id => $name ) {

        $sidebar_options .= '<option value="' . $id . '"' . selected( $sidebar_id, $id, false ) . '>' . $name . '</option>';
    }

    echo
        '<div id="airkit_sidebar_position"><p><strong>' . esc_html__( 'Sidebar position', 'gowatch' ) . '</strong></p>
		    <ul id="page-sidebar-position-selector" data-selector="#page-sidebar-position" class="imageRadioMetaUl perRow-2 ts-custom-selector">
               <li><img src="' . get_template_directory_uri() . '/images/options/std_pos_sidebar.png" data-option="std" class="image-radio-input"></li>
		       <li><img src="' . get_template_directory_uri() . '/images/options/none.png" data-option="none" class="image-radio-input"></li>
		       <li><img src="' . get_template_directory_uri() . '/images/options/left_sidebar.png" data-option="left" class="image-radio-input"></li>
		       <li><img src="' . get_template_directory_uri() . '/images/options/right_sidebar.png" data-option="right" class="image-radio-input"></li>
		    </ul>
			<select name="airkit_sidebar[position]" id="page-sidebar-position" class="hidden">' .
                $pos_options .
			'</select>
        </div>
		<div id="airkit_sidebar_size">
            <p><strong>' . esc_html__( 'Sidebar size', 'gowatch' ) . '</strong></p>
            <select id="airkit_sidebar_size" name="airkit_sidebar[size]">
                <option value="std"' . selected( $size, 'std', false ) . '>' . esc_html__( 'Default', 'gowatch' ) . '</option>
                <option value="1-3"' . selected( $size, '1-3', false ) . '>1/3</option>
                <option value="1-4"' . selected( $size, '1-4', false ) . '>1/4</option>
            </select>
		</div>
        <div id="airkit_sidebar_sidebars">
            <p><strong>' . esc_html__( 'Sidebar name', 'gowatch' ) . '</strong></p>
            <select name="airkit_sidebar[id]">' .
                $sidebar_options .
            '</select>
        </div>' .
         wp_nonce_field( 'airkit_layout_nonce', 'airkit_layout_nonce_filed' );

}//end function airkit_sidebar_custom_box


//Add the box import/export to page
function airkit_custom_box_import_export() {

	add_meta_box( 'ts-import-export', 'Import/Export options', 'airkit_html_custom_box_import_export', 'page' );

}
add_action('add_meta_boxes', 'airkit_custom_box_import_export');

/***********/

function airkit_html_custom_box_import_export($post) {

    if( !function_exists('ts_enc_string') ) {
        echo ('The plugin "TouchCodes" is required.');
        return;
    }

    $settings = get_post_meta( $post->ID, 'ts_template', true );
    $settings = ts_enc_string(serialize($settings));

    echo '<table>
            <tr>
                <td><h4>' . esc_html__('Export options', 'gowatch') . '</h4>
                    <div class="ts-option-description">
                        ' . esc_html__('This is the export data. Copy this into another page import field and you should get the same builder elements and arrangement.', 'gowatch') . '
                    </div>

                    <textarea name="export_options" cols="60" rows="5">' . $settings . '</textarea>
                </td>
            </tr>
            <tr>
                <td><h4>' . esc_html__('Import options', 'gowatch') . '</h4>
                    <div class="ts-option-description">
                        ' . sprintf( esc_html__('This is the import data field. %s BE CAUTIONS, changing anythig here will result in breaking all your page elements and arrangement. Please save your previous data before proceding. %s', 'gowatch'), '<b style="color: #Ff0000;">', '</b>' ) . '
                    </div>
                    <textarea name="import_options" cols="60" rows="5"></textarea>
                </td>
            </tr>
        </table>';

}

function airkit_import_export_save_postdata( $post_ID ) {

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_ID;

    if( !function_exists('ts_enc_string') ) return $post_ID;

    if ( 'page' == get_post_type($post_ID) && ! current_user_can( 'edit_page', $post_ID ) ) {
          return $post_ID;
    } elseif( ! current_user_can( 'edit_post', $post_ID ) ) {
        return $post_ID;
    }

    if( isset($_POST['import_options']) && $_POST['import_options'] != '' ){

        $import_export = unserialize(ts_enc_string($_POST['import_options'], 'decode'));

        update_post_meta($post_ID, 'ts_template', $import_export);
    }

}
add_action( 'save_post', 'airkit_import_export_save_postdata' );

// Adding the post rating box here
add_action( 'add_meta_boxes', 'airkit_post_rating_add_custom_box' );
add_action( 'save_post', 'airkit_post_rating_save_postdata' );

function airkit_post_rating_add_custom_box()
{
    add_meta_box(
        'ts_post_rating',
        'Post rating',
        'airkit_post_rating_custom_box',
        'post'
    );
}

function airkit_post_rating_custom_box( $post )
{
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ts_post_rating_nonce' );
    $rating_items = get_post_meta($post->ID, 'ts_post_rating', TRUE);
    $enable_rating = get_post_meta( $post->ID, 'enable_rating', true );

    $hidden_button = '';
    $checked = '';


    if( 'n' == $enable_rating || empty( $enable_rating ) ) {
        $hidden_button = 'hidden';
    } elseif( 'y' == $enable_rating ) {
        $checked = ' checked="checked"';
    }


    echo '<br/><label for="enable-rating"><input type="checkbox" id="enable-rating" name="enable_rating" '. $checked .'/>'. esc_html__( 'Enable Ratings for this post', 'gowatch' ) .'</label><br/>';
    echo '<ul id="rating-items">';

    $rating_editor = '';

    if (!empty($rating_items)) {
        $index = 0;
        foreach ($rating_items as $rating_item_id => $rating_item) {
            $index++;

            $rating_editor .= '
            <li class="rating-item">
            <div class="sortable-meta-element"><span class="tab-arrow icon-down"></span><span class="rating-item-tab ts-multiple-item-tab">'.($rating_item['rating_title'] ? $rating_item['rating_title'] : 'Rating ' . $index).'</span></div>
                <table class="hidden">
                    <tr>
                        <td>
                            Rating name<br>
                            <input type="text" class="rating_title" name="rating['.$rating_item_id.'][rating_title]" value="'.$rating_item['rating_title'].'" style="width: 100%" />
                        </td>
                        <td>
                            Rating score<br>
                            <select name="rating['.$rating_item_id.'][rating_score] " id="rating_score">
                                <option value="1" ' . selected( $rating_item['rating_score'] , 1 , false) . ' >1</option>
                                <option value="2" ' . selected( $rating_item['rating_score'] , 2  , false) . '>2</option>
                                <option value="3" ' . selected( $rating_item['rating_score'] , 3  , false) . '>3</option>
                                <option value="4" ' . selected( $rating_item['rating_score'] , 4  , false) . '>4</option>
                                <option value="5" ' . selected( $rating_item['rating_score'] , 5  , false) . '>5</option>
                                <option value="6" ' . selected( $rating_item['rating_score'] , 6  , false) . '>6</option>
                                <option value="7" ' . selected( $rating_item['rating_score'] , 7  , false) . '>7</option>
                                <option value="8" ' . selected( $rating_item['rating_score'] , 8  , false) . '>8</option>
                                <option value="9" ' . selected( $rating_item['rating_score'] , 9  , false) . '>9</option>
                                <option value="10" ' . selected( $rating_item['rating_score'] , 10 , false) . '>10</option>
                            </select>
                        </td>
                        <td>&nbsp;<br><input type="button" class="button button-primary remove-item" value="'.esc_html__('Remove', 'gowatch').'" /></td>
                    </tr>
                </table>
            </li>';
        }
    } else{
        echo esc_html__('Sorry, no rating items were found. Please add some.', 'gowatch');
    }

    echo airkit_var_sanitize( $rating_editor, 'the_kses' );

    echo '</ul>';
    echo '<br/><input type="button" class="button button-primary '. $hidden_button .'" id="add-item" value="' .esc_html__('Add New rating Item', 'gowatch'). '" /><br/><br/>';
    echo '<script id="rating-items-template" type="text/template">';
    echo '<li class="rating-item ts-multiple-add-list-element">
    <div class="sortable-meta-element"><span class="tab-arrow icon-up"></span><span class="rating-item-tab ts-multiple-item-tab">' . esc_html__('Rating', 'gowatch') . ' {{slide-number}}</span></div>
        <table>
            <tr>
                <td>
                    ' . esc_html__('Rating name', 'gowatch') . '<br>
                    <input type="text" class="rating_title" name="rating[{{item-id}}][rating_title]" value="" style="width: 100%" />
                </td>
                <td>
                    ' . esc_html__('Rating score', 'gowatch') . '<br>
                    <select name="rating[{{item-id}}][rating_score]" id="rating_score">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </td>
                <td>&nbsp;<br><input type="button" class="button button-primary remove-item" value="'.esc_html__('Remove', 'gowatch').'" /></td>
            </tr>
        </table>
    </li>';
    echo '</script>';
?>
    <script>
    jQuery(document).ready(function($) {
        var rating_items = $("#rating-items > li").length;

        // sortable rating items
        $("#rating-items").sortable();
        //$("#rating-items").disableSelection();

        $(document).on('change', '.slide_title', function(event) {
            event.preventDefault();
            var _this = $(this);
            _this.closest('.rating-item').find('.rating-item-tab').text(_this.val());
        });

        // Media uploader
        var items = $('#rating-items'),
            slideTempalte = $('#rating-items-template').html();

        $(document).on('click', '#add-item', function(event) {
            event.preventDefault();
            rating_items++;
            var sufix = new Date().getTime();
            var item_id = new RegExp('{{item-id}}', 'g');
            var item_number = new RegExp('{{slide-number}}', 'g');

            var template = slideTempalte.replace(item_id, sufix).replace(item_number, rating_items);
            items.append(template);
        });

        $(document).on('click', '.remove-item', function(event) {
            event.preventDefault();
            $(this).closest('li').remove();
            rating_items--;
        });

        $(document).on('click', '#enable-rating', function(e){
            $('#add-item').toggle(200);
        });

    });
    </script>
<?php
}

// saving slider
function airkit_post_rating_save_postdata( $post_ID )
{
    global $post;

    if ( is_object($post) && @$post->post_type != 'post' ) {
        return;
    }

    if ( ! isset( $_POST['ts_post_rating_nonce'] ) ||
         ! wp_verify_nonce( $_POST['ts_post_rating_nonce'], plugin_basename( __FILE__ ) )
    ) return;

    if( !current_user_can( 'edit_post', $post_ID ) ) return;

    // array containing filtred items
    $rating_items = array();

    if ( isset( $_POST['rating'] ) ) {
        if ( is_array( $_POST['rating'] ) && !empty( $_POST['rating'] ) ) {
            foreach ( $_POST['rating'] as $item_id => $rating_item ) {

                $p = array();
                $p['item_id']   = $item_id;


                $p['rating_title'] = isset($rating_item['rating_title']) ?
                                esc_textarea($rating_item['rating_title']) : '';

                $p['rating_score'] = isset($rating_item['rating_score']) ?
                            esc_textarea($rating_item['rating_score']) : '';

                $rating_items[] = $p;
            }
        }
    }

    if( isset( $_POST['enable_rating'] ) ){
        $enable_rating = $_POST['enable_rating'] == 'on' ? 'y' : 'n';
        update_post_meta( $post_ID, 'enable_rating', $enable_rating );
    }

    update_post_meta( $post_ID, 'ts_post_rating', $rating_items );
}

$airkit_taxs = array( 'category', 'portfolio_categories', 'videos_categories', 'gallery_categories', 'event_categories', 'ts_teams' ) ;

foreach ( $airkit_taxs as $tax ) {

    add_action( $tax . '_add_form_fields', 'airkit_category_form_custom_field_add', 10 );
    add_action( $tax . '_edit_form_fields', 'airkit_category_form_custom_field_edit', 10, 2 );
    add_action( 'created_' . $tax, 'airkit_category_form_custom_field_save', 10, 2 );
    add_action( 'edited_' . $tax, 'airkit_category_form_custom_field_save', 10, 2 );
}

/*
 * Custom fields for add term screen.
 */
function airkit_category_form_custom_field_add( $taxonomy )
{

    $primary_text = airkit_option_value( 'colors', 'primary_color' );

    airkit_Fields::upload( 
                array(    
                    'name'  => esc_html__( 'Thumbnail ', 'gowatch' ),            
                    'id'    => 'term-thumbnail',
                    'std'   => '',
                ), 
                array() 
            );

}

/*
 * Custom fields for update term screen
 */
function airkit_category_form_custom_field_edit( $tag, $taxonomy ) {

    $thumbnail = '';
    $primary_text = $term_color = airkit_option_value( 'colors', 'primary_color' );

    $gowatch_options = get_option( 'gowatch_options' );

    $term_options = array();

    if( isset( $gowatch_options['term_options'] ) && !empty( $gowatch_options['term_options'] ) ) {

        $term_options = $gowatch_options['term_options'];

    }

    if( !empty( $term_options ) ) {

        $thumbnail = $term_options[ $tag->term_id ]['term-thumbnail'];

    }


    airkit_Fields::upload( 
                array(    
                    'name'  => esc_html__( 'Thumbnail ', 'gowatch' ),            
                    'id'    => 'term-thumbnail',
                    'std'   => '',
                ),
                array( 'term-thumbnail' => $thumbnail ) 
            ); 
}

/*
 * Save term color & thumbnail under gowatch_options array
 */

function airkit_category_form_custom_field_save( $term_id, $tt_id ) {

    $gowatch_options = get_option( 'gowatch_options' );

    $term_options = array();

    if( isset( $gowatch_options['term_options'] ) && !empty( $gowatch_options['term_options'] ) ) {

        $term_options = $gowatch_options['term_options'];

    }

    // $term = get_term( $term_id, $_POST['taxonomy'] );

    if ( isset( $_POST['term-thumbnail'] ) ) {

        $term_options[ $term_id ]['term-thumbnail'] = $_POST['term-thumbnail'];

    }

    // Update gowatch term options array.
    $gowatch_options['term_options'] = $term_options;
    update_option( 'gowatch_options', $gowatch_options );

}