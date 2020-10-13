<?php
/**
 * Start output buffering
 *
 * This is needed for redirecting to post when a new post has made
 *
 */
function tszf_buffer_start() {
    ob_start();
}

add_action( 'init', 'tszf_buffer_start' );

/**
 * Format the post status for user dashboard
 *
 * @param string $status
 * @author TouchSize
 */
function tszf_show_post_status( $status ) {

    if ( $status == 'publish' ) {

        $title = __( 'Live', 'gowatch' );
        $fontcolor = '#33CC33';
    } else if ( $status == 'draft' ) {

        $title = __( 'Offline', 'gowatch' );
        $fontcolor = '#bbbbbb';
    } else if ( $status == 'pending' ) {

        $title = __( 'Awaiting Approval', 'gowatch' );
        $fontcolor = '#C00202';
    } else if ( $status == 'future' ) {
        $title = __( 'Scheduled', 'gowatch' );
        $fontcolor = '#bbbbbb';

    } else if ( $status == 'private' ) {
        $title = __( 'Private', 'gowatch' );
        $fontcolor = '#bbbbbb';
    }

    $show_status = '<span style="color:' . $fontcolor . ';">' . $title . '</span>';
    echo apply_filters( 'tszf_show_post_status', $show_status, $status );
}

/**
 * Format the post status for user dashboard
 *
 * @param string $status
 * @author TouchSize
 */
function tszf_admin_post_status( $status ) {

    if ( $status == 'publish' ) {

        $title = __( 'Published', 'gowatch' );
        $fontcolor = '#009200';
    } else if ( $status == 'draft' || $status == 'private' ) {

        $title = __( 'Draft', 'gowatch' );
        $fontcolor = '#bbbbbb';
    } else if ( $status == 'pending' ) {

        $title = __( 'Pending', 'gowatch' );
        $fontcolor = '#C00202';
    } else if ( $status == 'future' ) {
        $title = __( 'Scheduled', 'gowatch' );
        $fontcolor = '#bbbbbb';
    }

    echo '<span style="color:' . $fontcolor . ';">' . $title . '</span>';
}

/**
 * Upload the files to the post as attachemnt
 *
 * @param <type> $post_id
 */
function tszf_upload_attachment( $post_id ) {
    if ( !isset( $_FILES['tszf_post_attachments'] ) ) {
        return false;
    }

    $fields = (int) tszf_get_option( 'attachment_num' );

    for ($i = 0; $i < $fields; $i++) {
        $file_name = basename( $_FILES['tszf_post_attachments']['name'][$i] );

        if ( $file_name ) {
            if ( $file_name ) {
                $upload = array(
                    'name' => $_FILES['tszf_post_attachments']['name'][$i],
                    'type' => $_FILES['tszf_post_attachments']['type'][$i],
                    'tmp_name' => $_FILES['tszf_post_attachments']['tmp_name'][$i],
                    'error' => $_FILES['tszf_post_attachments']['error'][$i],
                    'size' => $_FILES['tszf_post_attachments']['size'][$i]
                );

                tszf_upload_file( $upload );
            }//file exists
        }// end for
    }
}

/**
 * Get the attachments of a post
 *
 * @param int $post_id
 * @return array attachment list
 */
function tszf_get_attachments( $post_id ) {
    $att_list = array();

    $args = array(
        'post_type' => 'attachment',
        'numberposts' => -1,
        'post_status' => null,
        'post_parent' => $post_id,
        'order' => 'ASC',
        'orderby' => 'menu_order'
    );

    $attachments = get_posts( $args );

    foreach ($attachments as $attachment) {
        $att_list[] = array(
            'id' => $attachment->ID,
            'title' => $attachment->post_title,
            'url' => wp_get_attachment_url( $attachment->ID ),
            'mime' => $attachment->post_mime_type
        );
    }

    return $att_list;
}

/**
 * Remove the mdedia upload tabs from subscribers
 *
 * @package Touchsize Frontend Submission
 * @author TouchSize
 */
function tszf_unset_media_tab( $list ) {
    if ( !current_user_can( 'edit_posts' ) ) {
        unset( $list['library'] );
        unset( $list['gallery'] );
    }

    return $list;
}

add_filter( 'media_upload_tabs', 'tszf_unset_media_tab' );

/**
 * Get the registered post types
 *
 * @return array
 */
function tszf_get_post_types() {
    $post_types = get_post_types();

    foreach ($post_types as $key => $val) {
        if ( $val == 'attachment' || $val == 'revision' || $val == 'nav_menu_item' ) {
            unset( $post_types[$key] );
        }
    }

    return $post_types;
}

/**
 * Get lists of users from database
 *
 * @return array
 */
function tszf_list_users() {
    global $wpdb;

    $users = $wpdb->get_results( "SELECT ID, user_login from $wpdb->users" );

    $list = array();

    if ( $users ) {
        foreach ($users as $user) {
            $list[$user->ID] = $user->user_login;
        }
    }

    return $list;
}

/**
 * Retrieve or display list of posts as a dropdown (select list).
 *
 * @return string HTML content, if not displaying.
 */
function tszf_get_pages( $post_type = 'page' ) {
    global $wpdb;

    $array = array( '' => __( '-- select --', 'gowatch' ) );
    $pages = get_posts( array('post_type' => $post_type, 'numberposts' => -1) );
    if ( $pages ) {
        foreach ($pages as $page) {
            $array[$page->ID] = esc_attr( $page->post_title );
        }
    }

    return $array;
}

/**
 * Edit post link for frontend
 *
 * @param string $url url of the original post edit link
 * @param int $post_id
 * @return string url of the current edit post page
 */
function tszf_edit_post_link( $url, $post_id ) {

    // On Edit post, show form that is currently set to active.
    $form_id = get_frontend_submission_active_id();
    $form_settings = tszf_get_form_settings( $form_id );

    // Edit post in backend if in dashboard, or is admin.
    if ( is_admin() || isset( $form_settings['post_type'] ) && get_post_type( $post_id ) != $form_settings['post_type'] ) {

       return $url;

    }

    $override = tszf_get_option( 'override_editlink', 'tszf_general', 'yes' );

    if ( $override == 'yes' ) {

        $url = '';

        if ( tszf_get_option( 'enable_post_edit', 'tszf_dashboard', 'yes' ) == 'yes' ) {

            // $edit_page = (int) tszf_get_option( 'edit_page_id', 'tszf_general' );
            // Get Edit post URL from Frontend add post page
            $url = get_frontend_submit_url();

            $url = wp_nonce_url( $url . '?action=edit&pid=' . $post_id, 'tszf_edit' );

        }
    }

    return $url;
}

add_filter( 'get_edit_post_link', 'tszf_edit_post_link', 10, 2 );

/*
 * returns URL of page with user-add-post template.
 */
function get_frontend_submit_url() {

    // global $wpdb;

    // $add_post_id = $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_value FROM ". esc_sql( $wpdb->postmeta ) ." WHERE meta_value = %s LIMIT 1", 'user-add-post.php' ), ARRAY_A);

    $submit_id = get_frontend_submission_page_id();
    $url_submit = get_page_link( $submit_id );

    return $url_submit;

}

/*
 * returns URL of page with user-add-post template.
 */
function get_frontend_submission_page_id() {

    global $wpdb;

    $add_post_id = $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_value FROM ". esc_sql( $wpdb->postmeta ) ." WHERE meta_value = %s LIMIT 1", 'user-add-post.php' ), ARRAY_A);

    $page_id = isset( $add_post_id[0]['post_id'] ) ?  $add_post_id[0]['post_id'] : NULL;

    return $page_id;

}



function get_frontend_submission_active_id() {

    return airkit_option_value( 'general', 'frontend_submission_form' );

}


/*
 * returns URL of page with user-add-post template.
 */
function get_frontend_registration_url( $get = 'url' ) {

    global $wpdb;

    $add_post_id = $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_value FROM ". esc_sql( $wpdb->postmeta ) ." WHERE meta_value = %s LIMIT 1", 'user-login-register.php' ), ARRAY_A);
    $url_submit = isset( $add_post_id[0]['post_id'] ) ? get_page_link( $add_post_id[0]['post_id'] ) : esc_url( home_url( '/' ) );    

    if( $get === 'url' ) {

        return $url_submit;

    } elseif( $get === 'id' && isset($add_post_id[0]['post_id']) ) {

        return $add_post_id[0]['post_id'];
        
    }

}

function get_frontend_registration_active_id() {

    return airkit_option_value( 'general', 'frontend_registration_form' );

}


/*
 * returns URL of page with User Frontend Dashboard.
 */
function get_frontend_dashboard_url() {

    global $wpdb;

    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'user-profile.php'
    ));

    $url_dashboard = isset( $pages[0]->ID ) ? get_page_link( $pages[0]->ID ) : esc_url( home_url( '/' ) );    

    return $url_dashboard;

}


function is_this_form_active( $form_id, $form_type = 'submit' ) {

    if( 'submit' == $form_type ) {

        $active_form_id  = get_frontend_submission_active_id();

    } elseif( 'register' == $form_type ) {
        
        $active_form_id = get_frontend_registration_active_id();

    }


    if( $active_form_id == $form_id ) {

        return true;

    }

    return false;

}

/**
 * Create HTML dropdown list of Categories.
 *
 * @package WordPress
 * @uses Walker
 */
class TSZF_Walker_Category_Multi extends Walker {

    /**
     * @see Walker::$tree_type
     * @var string
     */
    var $tree_type = 'category';

    /**
     * @see Walker::$db_fields
     * @var array
     */
    var $db_fields = array('parent' => 'parent', 'id' => 'term_id');

    /**
     * @see Walker::start_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $category Category data object.
     * @param int $depth Depth of category. Used for padding.
     * @param array $args Uses 'selected' and 'show_count' keys, if they exist.
     */
    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $pad = str_repeat( '&nbsp;', $depth * 3 );

        $cat_name = apply_filters( 'list_cats', $category->name, $category );
        $output .= "\t<option class=\"level-$depth\" value=\"" . $category->term_id . "\"";
        if ( in_array( $category->term_id, $args['selected'] ) )
            $output .= ' selected="selected"';
        $output .= '>';
        $output .= $pad . $cat_name;
        if ( $args['show_count'] )
            $output .= '&nbsp;&nbsp;(' . $category->count . ')';
        $output .= "</option>\n";
    }

}

/**
 * Category checklist walker
 *
 */
class TSZF_Walker_Category_Checklist extends Walker {

    var $tree_type = 'category';
    var $db_fields = array('parent' => 'parent', 'id' => 'term_id'); //TODO: decouple this

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='children'>\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "$indent</ul>\n";
    }

    function start_el( &$output, $category, $depth = 0, $args = array(), $current_object_id = 0 ) {
        extract( $args );
        if ( empty( $taxonomy ) )
            $taxonomy = 'category';

        if ( $taxonomy == 'category' )
            $name = 'category';
        else
            $name = $taxonomy;

        $class = isset( $args['class'] ) ? $args['class'] : '';
        $output .= "\n<li id='{$taxonomy}-{$category->term_id}'>" . '<label class="selectit"><input class="'. $class . '" value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>';
    }

    function end_el( &$output, $category, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }

}

/**
 * Displays checklist of a taxonomy
 *
 * @param int $post_id
 * @param array $selected_cats
 */
function tszf_category_checklist( $post_id = 0, $selected_cats = false, $attr = array(), $class = null ) {
    require_once ABSPATH . '/wp-admin/includes/template.php';

    $walker       = new TSZF_Walker_Category_Checklist();

    $exclude_type = isset( $attr['exclude_type'] ) ? $attr['exclude_type'] : 'exclude';
    $exclude      = explode( ',', $attr['exclude'] );
    $tax          = $attr['name'];

    $args = array(
        'taxonomy' => $tax,
    );

    if ( $post_id ) {
        $args['selected_cats'] = wp_get_object_terms( $post_id, $tax, array('fields' => 'ids') );
    } elseif ( $selected_cats ) {
        $args['selected_cats'] = $selected_cats;
    } else {
        $args['selected_cats'] = array();
    }

    $args['class'] = $class;

    $categories = (array) get_terms( $tax, array(
        'hide_empty'  => false,
        $exclude_type => (array) $exclude,
        'orderby'     => isset( $attr['orderby'] ) ? $attr['orderby'] : 'name',
        'order'       => isset( $attr['order'] ) ? $attr['order'] : 'ASC',
    ) );

    echo '<ul class="tszf-category-checklist">';
    printf( '<input type="hidden" name="%s" value="0" />', $tax );
    echo call_user_func_array( array(&$walker, 'walk'), array($categories, 0, $args) );
    echo '</ul>';
}

/**
 * Get all the image sizes
 *
 * @return array image sizes
 */
function tszf_get_image_sizes() {
    $image_sizes_orig = get_intermediate_image_sizes();
    $image_sizes_orig[] = 'full';
    $image_sizes = array();

    foreach ($image_sizes_orig as $size) {
        $image_sizes[$size] = $size;
    }

    return $image_sizes;
}

function tszf_allowed_extensions() {
    $extesions = array(
        'images' => array('ext' => 'jpg,jpeg,gif,png', 'label' => __( 'Images', 'gowatch' )),
        'video'  => array('ext' => 'mp4,mpeg,mpeg4', 'label' => __( 'Videos', 'gowatch' )),
    );

    return apply_filters( 'tszf_allowed_extensions', $extesions );
}

/**
 * Adds notices on add post form if any
 *
 * @param string $text
 * @return string
 */
function tszf_addpost_notice( $text ) {
    $user = wp_get_current_user();

    if ( is_user_logged_in() ) {
        $lock = ( $user->tszf_postlock == 'yes' ) ? 'yes' : 'no';

        if ( $lock == 'yes' ) {
            return $user->tszf_lock_cause;
        }
    }

    return $text;
}

add_filter( 'tszf_addpost_notice', 'tszf_addpost_notice' );


/**
 * Associate attachemnt to a post
 *
 * @param type $attachment_id
 * @param type $post_id
 */
function tszf_associate_attachment( $attachment_id, $post_id ) {
    wp_update_post( array(
        'ID' => $attachment_id,
        'post_parent' => $post_id
    ) );
}

/**
 * Get user role names
 *
 * @global WP_Roles $wp_roles
 * @return array
 */
function tszf_get_user_roles() {
    global $wp_roles;

    if ( !isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    return $wp_roles->get_names();
}

/**
 * User avatar wrapper for custom uploaded avatar
 *
 * @param string $avatar
 * @param mixed $id_or_email
 * @param int $size
 * @param string $default
 * @param string $alt
 * @return string image tag of the user avatar
 */
function tszf_get_avatar( $avatar, $id_or_email, $size, $default, $alt ) {

    if ( is_numeric( $id_or_email ) ) {
        $user = get_user_by( 'id', $id_or_email );
    } elseif ( is_object( $id_or_email ) ) {
        if ( $id_or_email->user_id != '0' ) {
            $user = get_user_by( 'id', $id_or_email->user_id );
        } else {
            return $avatar;
        }
    } else {
        $user = get_user_by( 'email', $id_or_email );
    }

    if ( !$user ) {
        return $avatar;
    }

    // see if there is a user_avatar meta field
    $user_avatar = get_user_meta( $user->ID, 'user_avatar', true );
    if ( empty( $user_avatar ) ) {
        return $avatar;
    }

    return sprintf( '<img src="%1$s" alt="%2$s" height="%3$s" width="%3$s" class="avatar">', esc_url( $user_avatar ), $alt, $size );
}

add_filter( 'get_avatar', 'tszf_get_avatar', 99, 5 );

function tszf_update_avatar( $user_id, $attachment_id ) {

    $upload_dir = wp_upload_dir();
    $relative_url = wp_get_attachment_url( $attachment_id );

    if ( function_exists( 'wp_get_image_editor' ) ) {
        // try to crop the photo if it's big
        $file_path = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $relative_url );

        // as the image upload process generated a bunch of images
        // try delete the intermediate sizes.
        $ext = strrchr( $file_path, '.' );
        $file_path_w_ext = str_replace( $ext, '', $file_path );
        $small_url = $file_path_w_ext . '-avatar' . $ext;
        $relative_url = str_replace( $upload_dir['basedir'], $upload_dir['baseurl'], $small_url );

        $editor = wp_get_image_editor( $file_path );

        if ( !is_wp_error( $editor ) ) {
            $editor->resize( 100, 100, true );
            $editor->save( $small_url );

            // if the file creation successfull, delete the original attachment
            if ( file_exists( $small_url ) ) {
                wp_delete_attachment( $attachment_id, true );
            }
        }
    }

    // delete any previous avatar
    $prev_avatar = get_user_meta( $user_id, 'user_avatar', true );

    if ( !empty( $prev_avatar ) ) {
        $prev_avatar_path = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $prev_avatar );

        if ( file_exists( $prev_avatar_path ) ) {
            unlink( $prev_avatar_path );
        }
    }

    // now update new user avatar
    update_user_meta( $user_id, 'user_avatar', $relative_url );
}

function tszf_admin_role() {
    return apply_filters( 'tszf_admin_role', 'manage_options' );
}


/**
 * Show custom fields in post content area
 *
 * @global object $post
 * @param string $content
 * @return string
 */
function tszf_show_custom_fields( $content ) {
    global $post;


    $show_custom = tszf_get_option( 'cf_show_front', 'tszf_general' );
    $show_caption = tszf_get_option( 'image_caption', 'tszf_general' );

    $form_id = get_post_meta( $post->ID, '_tszf_form_id', true );

    if ( !$form_id ) {
        return $content;
    }

    $html = '<ul class="tszf_customs">';

    $form_vars = tszf_get_form_fields( $form_id );
    $meta = array();

    if ( $form_vars ) {
        foreach ($form_vars as $attr) {
            // Verify if custom field is theme custom field and exclude it
            $theme_custom_fields = array( 'video_upload', 'video_embed', 'video_url', 'tab_content', 'airkit_post_type', 'airkit_gallery' );
            if ( isset( $attr['is_meta'] ) && $attr['is_meta'] == 'yes' && !in_array( $attr['name'], $theme_custom_fields ) ) {

                $meta[] = $attr;
            }
        }

        if ( !$meta ) {
            return $content;
        }


        foreach ($meta as $attr) {

            $field_value = get_post_meta( $post->ID, $attr['name'] );

            $return_for_no_cond = 0;

            if ( isset ( $attr['tszf_cond']['condition_status'] ) && $attr['tszf_cond']['condition_status'] == 'yes' ) {

                foreach ( $attr['tszf_cond']['cond_field'] as $field_key => $cond_field_name ) {

                    //check if the condintal field is a taxonomuy
                    if ( taxonomy_exists( $cond_field_name ) ) {
                        $post_terms = wp_get_post_terms( $post->ID , $cond_field_name, true );
                        $cond_field_value = array();

                        if ( is_array( $post_terms ) ) {
                            foreach( $post_terms as $term_key => $term_array ) {
                                $cond_field_value[] = $term_array->term_id;
                            }
                        }
                        //$cond_field_value = isset($post_terms[0]) ? $post_terms[0]->term_id : '';
                    } else {
                        $cond_field_value = get_post_meta( $post->ID, $cond_field_name, 'true' );
                    }

                    if ( isset( $attr['tszf_cond']['cond_option'][$field_key] ) ) {

                        if ( is_array( $cond_field_value ) ) {

                            if ( !in_array( $attr['tszf_cond']['cond_option'][$field_key], $cond_field_value ) ) {
                                $return_for_no_cond = 1;
                            }

                        } else {

                            if ( $attr['tszf_cond']['cond_option'][$field_key] != $cond_field_value ) {
                                $return_for_no_cond = 1;
                            }
                        }

                    }
                }
            }

            if ( $return_for_no_cond == 1 ) {
                continue;
            }

            if( !count( $field_value ) ) {
                continue;
            }

            if ( $attr['input_type'] == 'hidden' ) {
                continue;
            }

            //var_dump( $attr );

            if ( $attr['input_type'] == 'image_upload' || $attr['input_type'] == 'file_upload' ) {

                $image_html = '<li><label>' . $attr['label'] . ':</label> ';


                if ( $field_value ) {

                    foreach ($field_value as $attachment_id) {
                        if ( $attr['input_type'] == 'image_upload' ) {
                            $thumb = wp_get_attachment_image( $attachment_id, 'thumbnail' );
                        } else {
                            $thumb = get_post_field( 'post_title', $attachment_id );
                        }

                        $full_size = wp_get_attachment_url( $attachment_id );

                        if( $thumb ) {
                            $image_html .= sprintf( '<a href="%s">%s</a> ', $full_size, $thumb );

                            if ( $show_caption == 'on' ) {
                                $post_detail = get_post( $attachment_id );
                                if( !empty( $post_detail->post_title ) ) {
                                    $image_html .= '<br /><label>' . __( 'Title', 'gowatch' ) . ':</label> <span class="image_title">' . esc_html( $post_detail->post_title ) . '</span>';
                                }
                                if( !empty( $post_detail->post_excerpt ) ) {
                                    $image_html .= '<br /><label>' . __( 'Caption', 'gowatch' ) . ':</label> <span class="image_caption">' . esc_html( $post_detail->post_excerpt ) . '</span>';
                                }
                                if( !empty( $post_detail->post_content ) ) {
                                    $image_html .= '<br /><label>' . __( 'Description', 'gowatch' ) . ':</label> <span class="image_description">' . esc_html( $post_detail->post_content ) . '</span>';
                                }
                            }
                        }
                    }
                }

                $html .= $image_html . '</li>';

            } elseif ( $attr['input_type'] == 'map' ) {

                ob_start();
                tszf_content_map_post($attr['name'], $post->ID);
                $html .= ob_get_clean();

            } elseif ( $attr['input_type'] == 'address') {

                include_once TSZF_ROOT . '/includes/countries.php';

                $address_html = '';

                if ( isset ( $field_value[0] ) ) {

                    foreach ( $field_value[0] as $field_key => $value ) {

                        if ( $field_key == 'country_select' ) {
                            if ( isset ( $countries[$value] ) ) {
                                $value = $countries[$value];
                            }
                        }
                        $address_html .= '<li><label>' . $attr['address'][$field_key]['label'] . ': </label> ';
                        $address_html .= ' '.$value.'</li>';
                    }

                }

                $html = $address_html;

            } else {

                $value = get_post_meta( $post->ID, $attr['name'] );

                $new = implode( ', ', $value );

                if( $new ) {
                    $html .= sprintf( '<li><label>%s :</label>%s</li>', $attr['label'], make_clickable( $new ) );
                }
            }
        }
    }

    // var_dump( $attr );
    $html .= '</ul>';

    return $content . $html;
}

add_filter( 'the_content', 'tszf_show_custom_fields' );

/**
 * Map display
 *
 * @param string $meta_key
 * @param int $post_id
 * @param array $args
 */
function tszf_map_build( $location, $post_id = null, $args = array(), $meta_key = '' ) {
    global $post;

    // compatibility
    if ( $post_id ) {
        tszf_content_map_post( $location, $post_id, $args );
        return;
    }

    $default = array('width' => 450, 'height' => 250, 'zoom' => 12);
    $args = wp_parse_args( $args, $default );

    list( $def_lat, $def_long ) = explode( ',', $location );
    $def_lat = $def_lat ? $def_lat : 0;
    $def_long = $def_long ? $def_long : 0;
    ?>

    <div class="google-map" style="margin: 10px 0; height: <?php echo airkit_var_sanitize( $args['height'], 'esc_attr' ); ?>px; width: <?php echo airkit_var_sanitize( $args['width'], 'esc_attr' ); ?>px;" id="tszf-map-<?php echo airkit_var_sanitize( $meta_key . $post->ID, 'esc_attr' ); ?>"></div>

    <script type="text/javascript">
        jQuery(function($){
            var curpoint = new google.maps.LatLng(<?php echo airkit_var_sanitize( $def_lat, 'true' ); ?>, <?php echo airkit_var_sanitize( $def_long, 'true' ); ?>);

            var gmap = new google.maps.Map( $('#tszf-map-<?php echo airkit_var_sanitize( $meta_key . $post->ID, 'true' ); ?>')[0], {
                center: curpoint,
                zoom: <?php echo airkit_var_sanitize( $args['zoom'], 'true' ); ?>,
                mapTypeId: window.google.maps.MapTypeId.ROADMAP
            });

            var marker = new window.google.maps.Marker({
                position: curpoint,
                map: gmap,
                draggable: false
            });

        });
    </script>
    <?php
}

/**
 * Map for users
 *
 * @param string $meta_key
 * @param int $user_id
 * @param array $args
 */
function tszf_map_build_user( $meta_key, $user_id = null, $args = array() ) {
    $location = get_user_meta( $user_id, $meta_key, true );
    tszf_map_build( $location, null, $args, $meta_key );
}

/**
 * Map post posts
 *
 * @global object $post
 * @param string $meta_key
 * @param int $post_id
 * @param array $args
 */
function tszf_content_map_post( $meta_key, $post_id = null, $args = array() ) {
    global $post;

    if ( !$post_id ) {
        $post_id = $post->ID;
    }

    $location = get_post_meta( $post_id, $meta_key, true );
    tszf_map_build( $location, null, $args, $meta_key );
}

function tszf_meta_display( $atts ) {
    global $post;

    $name = '';
    $type = 'normal';
    $size = 'thumbnail';
    $height = 250;
    $width = 450;
    $zoom = 12;

    extract( $atts );


    if ( empty( $name ) ) {
        return;
    }

    if ( $type == 'image' || $type == 'file' ) {
        $images = get_post_meta( $post->ID, $name );

        if ( $images ) {
            $html = '';
            foreach ($images as $attachment_id) {

                if ( $type == 'image' ) {
                    $thumb = wp_get_attachment_image( $attachment_id, $size );
                } else {
                    $thumb = get_post_field( 'post_title', $attachment_id );
                }

                $full_size = wp_get_attachment_url( $attachment_id );
                $html .= sprintf( '<a href="%s">%s</a> ', $full_size, $thumb );
            }

            return $html;
        }

    } elseif ( $type == 'map' ) {
        ob_start();
        tszf_map_build( $name, $post->ID, array('width' => $width, 'height' => $height, 'zoom' => $zoom ) );
        return ob_get_clean();

    } elseif ( $type == 'repeat' ) {
        return implode( '; ', get_post_meta( $post->ID, $name ) );
    } else {
        return implode( ', ', get_post_meta( $post->ID, $name ) );
    }
}


/**
 * Get the value of a settings field
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 * @return mixed
 */
function tszf_get_option( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}

function tszf_has_shortkey( $shortkey = '', $post_id = false ) {

    $post_to_check = ( $post_id == false ) ? get_post( get_the_ID() ) : get_post( $post_id );

    if ( !$post_to_check ) {
        return false;
    }

    // false because we have to search through the post content first
    $found = false;

    // if no short code was provided, return false
    if ( !$shortkey ) {
        return $found;
    }

    // check the post content for the short code
    if ( stripos( $post_to_check->post_content, '[' . $shortkey ) !== false ) {
        // we have found the short code
        $found = true;
    }

    return $found;
}

/**
 * Get attachment ID from a URL
 *
 * @link http://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/ Original Implementation
 *
 * @global type $wpdb
 * @param type $attachment_url
 * @return type
 */
function tszf_get_attachment_id_from_url( $attachment_url = '' ) {

    global $wpdb;
    $attachment_id = false;

    // If there is no url, return.
    if ( '' == $attachment_url )
        return;

    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();

    // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
    if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

        // If this is the URL of an auto-generated thumbnail, get the URL of the original image
        $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

        // Remove the upload path base directory from the attachment URL
        $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

        // Finally, run a custom database query to get the attachment ID from the modified attachment URL
        $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
    }

    return $attachment_id;
}

/**
 * Non logged in users tag autocomplete
 *
 * @global object $wpdb
 */
function tszfe_ajax_tag_search() {
    global $wpdb;

    $taxonomy = sanitize_key( $_GET['tax'] );
    $tax = get_taxonomy( $taxonomy );
    if ( !$tax ) {
        wp_die( 0 );
    }

    $s = wp_unslash( $_GET['q'] );

    $comma = _x( ',', 'tag delimiter', 'gowatch' );
    if ( ',' !== $comma )
        $s = str_replace( $comma, ',', $s );
    if ( false !== strpos( $s, ',' ) ) {
        $s = explode( ',', $s );
        $s = $s[count( $s ) - 1];
    }

    $s = trim( $s );
    if ( strlen( $s ) < 2 )
        wp_die(); // require 2 chars for matching

    $results = $wpdb->get_col( $wpdb->prepare( "SELECT t.name FROM $wpdb->term_taxonomy AS tt INNER JOIN $wpdb->terms AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = %s AND t.name LIKE (%s)", $taxonomy, '%' . wpdb::esc_like( $s ) . '%' ) );

    echo join( $results, "\n" );
    wp_die();
}

add_action( 'wp_ajax_nopriv_ajax-tag-search', 'tszfe_ajax_tag_search' );

/**
 * Option dropdown helper
 *
 * @param array $options
 * @param string $selected
 * @return string
 */
function tszf_dropdown_helper( $options, $selected = '' ) {
    $string = '';

    foreach ($options as $key => $label) {
        $string .= sprintf( '<option value="%s"%s>%s</option>', esc_attr( $key ), selected( $selected, $key, false ), $label );
    }

    return $string;
}


/**
 * Include a template file
 *
 * Looks up first on the theme directory, if not found
 * lods from plugins folder
 *
 * @param string $file file name or path to file
 */
function tszf_load_template( $file, $args = array() ) {
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $child_theme_dir = get_stylesheet_directory() . '/includes/frontend-submission/templates/';
    $parent_theme_dir = get_template_directory() . '/includes/frontend-submission/templates/';
    $tszf_dir = TSZF_ROOT . '/templates/';

    if ( file_exists( $child_theme_dir . $file ) ) {

        include $child_theme_dir . $file;

    } else if ( file_exists( $parent_theme_dir . $file ) ) {

        include $parent_theme_dir . $file;

    } else {
        include $tszf_dir . $file;
    }
}

/**
 * Helper function for formatting date field
 *
 * @param string $date
 * @param bool $show_time
 * @return string
 */
function tszf_get_date( $date, $show_time = false ) {
    if ( empty( $date ) ) {
        return;
    }
    $date = strtotime( $date );

    if ( $show_time ) {
        $format = get_option( 'date_format' ) . ' ' . get_option( 'time_format' );
    } else {
        $format = get_option( 'date_format' );
    }
    $format = 'M j, Y';

    return date_i18n( $format, $date );
}

/**
 * Helper function for converting a normal date string to unix date/time string
 *
 * @param string $date
 * @param int $gmt
 * @return string
 */
function tszf_date2mysql( $date, $gmt = 0 ) {
    if (empty( $date ) ) {
        return;
    }
    $time = strtotime( $date );

    return ( $gmt ) ? gmdate( 'Y-m-d H:i:s', $time ) : gmdate( 'Y-m-d H:i:s', ( $time + ( get_option( 'timezone_string' ) * 3600 ) ) );
}

/**
 * Get form fields from a form
 *
 * @param  int $form_id
 * @return array
 */
function tszf_get_form_fields( $form_id ) {
    $fields = get_children(array(
        'post_parent' => $form_id,
        'post_status' => 'publish',
        'post_type'   => 'tszf_input',
        'numberposts' => '-1',
        'orderby'     => 'menu_order',
        'order'       => 'ASC',
    ));

    $form_fields = array();

    foreach ( $fields as $key => $content ) {

        $field = maybe_unserialize( $content->post_content );

        $field['id'] = $content->ID;

        $form_fields[] = $field;
    }

    return $form_fields;
}

add_action( 'wp_ajax_tszf_get_child_cat', 'tszf_get_child_cats' );
add_action( 'wp_ajax_nopriv_tszf_get_child_cat', 'tszf_get_child_cats' );

/**
 * Returns child category dropdown on ajax request
 */
function tszf_get_child_cats() {

    $parentCat = $_POST['catID'];
    $field_attr = $_POST['field_attr'];
    $taxonomy = $_POST['field_attr']['name'];

    $terms = null;
    $result = '';

    if ( $parentCat < 1 )
        die( $result );

    if ( $terms = get_categories( 'taxonomy='.$taxonomy.'&child_of=' . $parentCat . '&hide_empty=0' ) ) {
        $field_attr['parent_cat'] = $parentCat;
        if( is_array($terms) ){
            foreach( $terms as $key => $term ){
                $terms[$key] = (array)$term;
            }
        }
        $result .= TSZF_Render_Form::init()->taxnomy_select( '', $field_attr );
    } else {
        die( '' );
    }

    die( $result );
}

/**
 * Returns form setting value
 * @param  init $form_id
 * @param  boolen $status
 * @return array
 */
function tszf_get_form_settings( $form_id, $status = true ) {
    return get_post_meta( $form_id, 'tszf_form_settings', $status );
}

/**
 * Get the subscription page url
 *
 * @return string
 */
/*function tszf_get_subscription_page_url() {
    $page_id = tszf_get_option( 'subscription_page', 'tszf_payment' );

    return get_permalink( $page_id );
}
*/
/**
 * Clear the buffer
 *
 * prevents ajax breakage and endless loading icon. A LIFE SAVER!!!
 *
 * @return void
 */
function tszf_clear_buffer() {
    ob_clean();
}

/**
 * Check if the license has been expired
 *
 * @return boolean
 */
function tszf_is_license_expired() {
    if ( in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) ) {
        return false;
    }

    $license_status = get_option( 'tszf_license_status' );

    // seems like this wasn't activated at all
    if ( ! isset( $license_status->update ) ) {
        return false;
    }

    // if license has expired more than 15 days ago
    $update    = strtotime( $license_status->update );
    $threshold = strtotime( '+15 days', $update );

    // printf( 'Validity: %s, Threshold: %s', date( 'd-m-Y', $update), date( 'd-m-Y', $threshold ) );

    if ( time() >= $threshold ) {
        return true;
    }

    return false;
}
