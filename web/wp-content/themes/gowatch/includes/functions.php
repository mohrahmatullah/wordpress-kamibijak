<?php
/* Theme main functions.
 * Check for !function_exists
 * ! No camelCase please.
 */

// Minimum required version.

add_action( 'after_switch_theme', 'airkit_check_theme_setup' );
function airkit_check_theme_setup(){

  // Compare versions.
  if ( version_compare(phpversion(), '5.6.0', '<') ) :

  // Theme not activated info message.
  add_action( 'admin_notices', 'airkit_requirements_admin_notice' );
  function airkit_requirements_admin_notice() {
  ?>
    <div class="update-nag">
      <?php _e( 'You need to update your PHP version to run this theme.', 'gowatch' ); ?> <br />
      <?php _e( 'Actual version is:', 'gowatch' ) ?> <strong><?php echo phpversion(); ?></strong>, <?php _e( 'required is', 'gowatch' ) ?> <strong><?php echo '5.6.0'; ?></strong>
    </div>
  <?php
  }

  // Switch back to previous theme.
  switch_theme( $old_theme->stylesheet );
    return false;

  endif;
}

if ( !function_exists('airkit_my_menu') ) {
    function airkit_my_menu() {

      register_nav_menu('primary', esc_html__( 'Primary Menu', 'gowatch' ));
      register_nav_menu('secondary', esc_html__( 'Secondary Menu', 'gowatch' ));
    }
}
add_action( 'init', 'airkit_my_menu' );

// Add Async Attributes to Theme Scripts
function airkit_add_async_attribute($tag, $handle) {
    // add script handles to the array below
    $scripts_to_async = array(); // array('my-js-handle', 'another-handle')

    if ( count($scripts_to_async) ) {
        foreach($scripts_to_async as $async_script) {
            if ($async_script === $handle) {
                return str_replace(' src', ' async="async" src', $tag);
            }
        }
    }

    return $tag;
}
add_filter('script_loader_tag', 'airkit_add_async_attribute', 10, 2);

// Add custom logo compatibility
add_theme_support( 'custom-logo', array(
    'height'      => 120,
    'width'       => 500,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array( 'site-title', 'site-description' ),
) );

add_filter( 'the_title', 'airkit_sanitize_titles', 10, 2 );

function airkit_sanitize_titles( $title, $id = null ) {

    $allowed_html = array(
        'em' => array(),
        'strong' => array(),
        'b' => array(),
        'i' => array(),
    );

    $defaultTitle = wp_kses( $title, $allowed_html );

    return $defaultTitle;
}

add_action( 'admin_bar_menu', 'airkit_add_bar_menu', 999 );

function airkit_add_bar_menu( $wp_admin_bar ) {

    if ( ! is_super_admin()
         || ! is_object( $wp_admin_bar ) 
         || ! function_exists( 'is_admin_bar_showing' ) 
         || ! function_exists('ts_enc_string')
         || ! is_admin_bar_showing() ) {
        return;
    }
    /* Add goWatch Options menu to admin menu. */
    $wp_admin_bar->add_node( 
        array(
            'id'    => 'gowatch_options',
            'title' => esc_html__( 'goWatch Options', 'gowatch' ),
            'href'  => home_url() . '/wp-admin/themes.php?page=gowatch'
        )
    );
    /* Add header and Footer submenus. */
    $wp_admin_bar->add_node( 
        array(
            'parent' => 'gowatch_options',
            'id'     => 'gowatch_header',
            'title'  => esc_html__( 'Header', 'gowatch' ),
            'href'   => home_url() . '/wp-admin/themes.php?page=gowatch_header'
        )
    );

    $wp_admin_bar->add_node( 
        array(
            'parent' => 'gowatch_options',
            'id'     => 'gowatch_footer',
            'title'  => esc_html__( 'Footer', 'gowatch' ),
            'href'   => home_url() . '/wp-admin/themes.php?page=gowatch_footer'
        )
    );    
 

    $wp_admin_bar->add_node( 
        array(
            'parent' => 'gowatch_options',
            'id'     => 'gowatch_separator',
            'title'  => esc_html__( '---------------', 'gowatch' ),
            'href'   => '#'
        )
    );

    /* Add theme options Tabs */

    $tabs = array(
        'general'    => esc_html__( 'General', 'gowatch' ),
        'styles'     => esc_html__( 'Styles', 'gowatch' ),
        'colors'     => esc_html__( 'Colors', 'gowatch' ),
        'sizes'      => esc_html__( 'Image sizes', 'gowatch' ),
        'layout'     => esc_html__( 'Archive layouts', 'gowatch' ),
        'typography' => esc_html__( 'Typography', 'gowatch' ),
        'single'     => esc_html__( 'Single post', 'gowatch' ),
        'social'     => esc_html__( 'Social', 'gowatch' ),
        'sidebar'    => esc_html__( 'Add sidebars', 'gowatch' ),
        'import'     => esc_html__( 'Import/Export', 'gowatch' ),
        'advertising'=> esc_html__( 'Advertising', 'gowatch' ),
        'update'     => esc_html__( 'Theme Update', 'gowatch' ),
        'support'    => esc_html__( 'Support', 'gowatch' ),
        'frontend'   => esc_html__( 'User Frontend', 'gowatch' ),
    );

    if ( class_exists('Ts_Custom_Post') ) {

        $tabs = array_merge( $tabs, array( 'css' => esc_html__( 'Custom CSS', 'gowatch' ) ) );

    }

    foreach ( $tabs as $key => $value ) {
        $wp_admin_bar->add_node( 
            array(
                'parent' => 'gowatch_options',
                'id'     => 'gowatch_' . $key,
                'title'  => $value,
                'href'   => home_url() . '/wp-admin/themes.php?page=gowatch&tab='. $key 
            )
        );         
    }
}

if ( ! function_exists( 'airkit_option_value' ) ) {

    function airkit_option_value( $key, $option = '', $secondary = '' , $return = true ) {
        $options = get_option( 'gowatch_options' );

        if( empty( $option ) && isset($options[ $key ]) ) {

            return $options[ $key ];

        }

        $out = isset( $options[ $key ][ $option ] ) ? $options[ $key ][ $option ] : '';

        if ( $secondary != '' ) {
            $out = $options[ $key ][ $option ][ $secondary ];
        }

        if ( $return ) {

            return $out;

        } else {

            echo airkit_var_sanitize( $out, 'the_kses' );
        }
    }
}

if ( ! function_exists( 'airkit_update_option' ) ) {
    /**
     * Helper function used to programatically update option value.
     *
     * @param string $where Options section (general, styles, etc..)
     * @param string $option Option key that must be updated.
     * @param mixed $value Value that will be set to $options[ $where ][ $option ]. (eg: $options['styles']['main_color'] = $value)
     */
    function airkit_update_option( $where, $option, $value  ) {

        $options = get_option( 'gowatch_options' );

        $options[ $where ][ $option ] = $value;

        update_option( 'gowatch_options', $options );

    }
}

if ( ! function_exists( 'airkit_single_option' ) ) {

    function airkit_single_option( $option, $default = '', $parent ='' ) {
        global $post;

        $meta = get_post_meta( $post->ID, 'airkit_post_settings', true );

        if ( isset( $meta[ $option ] ) && 'std' !== $meta[ $option ] ) {

            $result =  $meta[ $option ];

        } else {

            $options = get_option( 'gowatch_options' );

            if ( !empty( $parent ) ) {

                $result =  airkit_PostMeta::get_std( $parent , $options['single'], $default );           

            } else {

                $result =  isset( $options['single'][ $option ] ) ? $options['single'][ $option ] : $default;

            }

        }
        return $result;
    }
}

if ( ! function_exists( 'airkit_convert_to_hours' ) ) {

    function airkit_convert_to_hours($time, $format = '%dh %02dmin') {

        // Remove 'min', 'h', 'H' from variable $time
        if ( strpos( $time, 'min' ) || strpos( $time, 'h' ) || strpos( $time, 'H' ) ) {

            $time = str_replace( array('min', 'h', 'H'), '', $time );
        }

        if ( $time < 60 ) {
            return $time . ' ' . esc_html__( 'min', 'gowatch' );
        }

        $hours = floor($time / 60);
        $minutes = ($time % 60);

        if ( $minutes == 0 ) {
            $format = '%d h';
        }

        return sprintf($format, $hours, $minutes);
    }

}


if ( ! function_exists( 'airkit_touchsize_comment' ) ) {

    function airkit_touchsize_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        $is_sticky = get_comment_meta( $comment->comment_ID, 'sticky', true );

        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
        ?>
            <li class="post pingback">
                <p><?php esc_html_e( 'Pingback:', 'gowatch' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'gowatch' ), '<span class="edit-link">', '</span>' ); ?></p>
        <?php
                break;

            default :
        ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment">
                    <footer class="comment-meta">
                        <div class="comment-author vcard">
                            <?php
                                $avatar_size = 50;
                                if ( '0' != $comment->comment_parent )
                                    $avatar_size = 30;

                                echo airkit_get_avatar( $comment->comment_author_email, $avatar_size );
                                printf( '<span class="fn">%s</span>', get_comment_author_link() );
                            ?>
                        </div><!-- .comment-author .vcard -->

                        <div class="comment-metadata">
                            <?php
                                if ( 'y' == airkit_option_value('general','enable_human_time') ) {
                                    $comment_date = airkit_time_to_human_time( get_comment_date() );
                                } else {
                                    $comment_date = get_comment_date();
                                }
                                printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                    esc_url( get_comment_link( $comment->comment_ID ) ),
                                    get_comment_time( 'c' ),
                                    /* translators: 1: date, 2: time */
                                    $comment_date
                                );
                                
                                edit_comment_link( esc_html__( 'Edit', 'gowatch' ), '<span class="edit-link">', '</span>' );

                                if ( $is_sticky ) {
                                    printf('<span class="is-sticky-label"><i class="icon-star-full"></i> %s</span>', esc_html__('Sticky', 'gowatch'));
                                }
                            ?>
                        </div>

                    </footer>

                    <div class="comment-content">
                        <?php comment_text(); ?>

                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'gowatch' ); ?></em>
                            <br />
                        <?php endif; ?>
                    </div>


                    <div class="reply">
                        <?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'gowatch' ) . '<i class="icon-arrow-stroke-left"></i>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </div><!-- .reply -->

                </article><!-- #comment-## -->

        <?php
                break;

        endswitch;
    }

}

add_action( 'admin_init', 'airkit_comment_custom_action_save');

function airkit_comment_custom_action_save() {

    // wp_reset_vars( array('action') );
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    $comment_ID = isset($_GET['c']) ? absint( $_GET['c'] ) : false;

    if ( $comment_ID ) {

        switch( $action ) {

            case 'stickycomment'    :
            case 'unstickycomment'  :

                $noredir = isset($_REQUEST['noredir']);

                if ( !$comment = get_comment($comment_ID) ) {
                    comment_footer_die( esc_html__( 'Invalid comment ID.', 'gowatch' ) . sprintf(' <a href="%s">' . esc_html__('Go back', 'gowatch') . '</a>.', 'comment.php') );
                }

                if ( !current_user_can( 'edit_comment', $comment->comment_ID ) ) {
                    comment_footer_die( esc_html__('You are not allowed to edit comments on this post.', 'gowatch') );
                }

                if ( '' != wp_get_referer() && ! $noredir && false === strpos(wp_get_referer(), 'comment.php') ) {
                    $redir = wp_get_referer();
                } elseif ( '' != wp_get_original_referer() && ! $noredir ) {
                    $redir = wp_get_original_referer();
                } elseif ( in_array( $action, array( 'stickycomment', 'unstickycomment' ) ) ) {
                    $redir = admin_url('comment.php?p=' . absint( $comment->comment_post_ID ) );
                } else {
                    $redir = admin_url('comment.php');
                }

                $redir = remove_query_arg( array('stickied', 'unstickied'), $redir );

                switch ($action) {

                    case 'stickycomment' :
                        update_comment_meta($comment_ID, 'sticky', 1);
                        $redir = add_query_arg( array('stickied' => '1'), $redir );
                        break;

                    case 'unstickycomment' :
                        update_comment_meta($comment_ID, 'sticky', 0);
                        $redir = add_query_arg( array('unstickied' => '1'), $redir );
                        break;
                }

                wp_redirect( $redir );
                die;

                break;

            case 'editcomment' :

                // $redir = admin_url('comment.php?c=' . absint( $comment->comment_post_ID ) );
                // wp_redirect( $redir );
                // die;
                break;

            default:
                wp_die( esc_html__('Unknown action.', 'gowatch') );

        } // end switch

    }
}

add_filter('comment_row_actions', 'airkit_comment_custom_action', 10, 2);

function airkit_comment_custom_action($actions, $comment) {

    $sticky_nonce = esc_html( '_wpnonce=' . wp_create_nonce( "approve-comment_$comment->comment_ID" ) );

    $url = "admin.php?c=$comment->comment_ID";
    $sticky_url =  admin_url($url . "&action=stickycomment&$sticky_nonce");
    $unsticky_url = admin_url($url . "&action=unstickycomment&$sticky_nonce");

    if ( ! get_comment_meta( $comment->comment_ID, 'sticky', true) ) {
        $actions['sticking'] = "<a href='$sticky_url' class='vim-a'>" . _x( 'Sticky', 'noun', 'gowatch' ) . '</a>';
    } else {
        $actions['unsticking'] = "<a href='$unsticky_url' class='vim-u'>" . _x( 'Unsticky', 'noun', 'gowatch' ) . '</a>';
    }

    return $actions;
}

add_action( 'pre_get_comments' , 'preprocess_comment_handler' );

function preprocess_comment_handler( $commentdata ) {
    //some code
    // echo "<pre>";
    // var_dump($commentdata);
    // echo "</pre>";

    return $commentdata;
}

add_filter( 'body_class', 'airkit_add_body_classes' );

function airkit_add_body_classes( $classes ) {

    $options = get_option('gowatch_options');

    $theme_styles = $options['styles'];
    $theme_general  = $options['general'];
    $theme_single  = $options['single'];

    $classes[] = 'gowatch';

    if ( $theme_styles[ 'boxed_layout' ] == 'y' ) {
        $classes[] = ' ts-boxed-layout ';
    }

    // Check if the image background is set
    if ( $theme_styles[ 'theme_custom_bg' ] == 'image' && $theme_styles[ 'bg_image' ] != '' ) {
        $classes[] = 'ts-has-image-background';
    }

    if ( isset($theme_general[ 'enable_imagesloaded' ] ) && $theme_general[ 'enable_imagesloaded' ] == 'y' ) {
        $classes[] = 'ts-imagesloaded-enabled';
    }

    if ( isset( $theme_general[ 'enable_sticky_menu' ] ) && $theme_general[ 'enable_sticky_menu' ] == 'y' ) {
        $classes[] = 'ts-sticky-menu-enabled';
    }

    if ( isset($theme_styles[ 'grayscale_img_view' ]) && $theme_styles[ 'grayscale_img_view' ] == 'y' ) {
        $classes[] = 'airkit_grayscale-images';
    }

    if( isset($theme_single['autoload_next']) && 'y' == $theme_single['autoload_next'] ) {
        $classes[] = 'airkit_autoload-next-post';
    }

    if( isset($theme_single['article_progress']) && 'y' == $theme_single['article_progress'] && is_single() ) {
        $classes[] = 'has-progress-bar';
    }

    if( isset($theme_styles['play_button_position']) && 'center' == $theme_styles['play_button_position'] && 'simple' == $theme_styles['play_button_style'] ) {
        $classes[] = 'simple-button-style';
    }

    if( isset($theme_styles['play_button_position']) && 'center' == $theme_styles['play_button_position'] ) {
        $classes[] = 'center-button-style';
    }
    if( isset($theme_styles['play_button_position']) && 'disable' == $theme_styles['play_button_position'] ) {
        $classes[] = 'disabled-button-style';
    }

    if ( isset($_GET['playlist_ID']) ) {
        $classes[] = 'playlist-enabled';
    }
            
    // Return all the classes
    return $classes;
}

//Insert ads after second paragraph of single post content.
add_filter( 'the_content', 'airkit_insert_post_ads' );

if ( ! function_exists( 'airkit_insert_post_ads' ) ) {   

    function airkit_insert_post_ads( $content ) {

        $featured_box = airkit_single_option( 'featured_box' );

        if ( !is_single() || $featured_box == 'n' || get_post_type( get_the_ID() ) != 'post' ) {
            return $content;
        }

        // Set up query vars to get last 3 featured articles
        $query_args = array( 
            'post_type'      => 'post',
            'post_status'    => 'published',
            'order'          => 'DESC',
            'posts_per_page' => 3,
            'meta_query'     => array(
                array(
                    'key'     => 'featured',
                    'value'   => 'yes',
                    'compare' => '=',
                ),
            )
        );
        // Get the featured posts
        $query = new WP_Query( $query_args );

        if ( $query->post_count != 0 ) {

            // Set the options for showcasing featured posts
            $options = array(
                'element-type'  => 'small-articles',
                'reveal-effect' => 'none',
                'behavior'      => 'normal',
            );

            $articles_content = airkit_Compilator::view_articles( $options, $query );

            // Generate the content box to show in front-end
            $ad_code = '<div class="inline-featured">
                            <h5><i class="icon-star-full"></i> ' . esc_html__('Featured articles', 'gowatch') . '</h5>
                            <div class="row">' . $articles_content . '</div>
                        </div>';

            $amp_preview = function_exists('is_amp_endpoint') && is_amp_endpoint();

            if ( is_single() && ! is_admin() && is_main_query() && !$amp_preview ) {

                return airkit_insert_after_paragraph( $ad_code, 3, $content );
                
            }
            
        }

        return $content;
    }
     
    // Parent Function that makes the magic happen
     
    function airkit_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
        $closing_p = '</p>';
        $paragraphs = explode( $closing_p, $content );

        if ( count($paragraphs) > 3 ) {

            foreach ($paragraphs as $index => $paragraph) {

                if ( trim( $paragraph ) ) {
                    $paragraphs[$index] .= $closing_p;
                }

                if ( $paragraph_id == $index + 1 ) {
                    $paragraphs[$index] .= $insertion;
                }
            }

            return implode( '' , $paragraphs );
        } else {
            return $content;
        }
        
        
    }

}


// Custom post gallery filter
add_filter( 'post_gallery', 'airkit_post_gallery_shortcode', 10, 3 );

function airkit_post_gallery_shortcode( $output = '', $atts, $instance ) {
    global $post, $wp_locale;

    static $galleries = array();
    static $instance = 0;
    $instance++;
    $count = count($galleries);


    // We do this for posts format gallery
    // Make first gallery from content as featured image carousel
    // Onther galleries include in post content
    if ( is_array( $atts ) && array_key_exists( 'include', $atts ) && !in_array( $atts['include'], $galleries) ) {
        array_push($galleries, $atts['include']);
    }

    if ( 'gallery' == get_post_format($post->ID) ) {

        // We have only one gallery in post content
        if ( $count === 1 && $instance % $count === 0 ) {
            unset($atts[0]);
            return ' ';
        } elseif ( $count > 1 && $instance % $count === 1 ) {
            unset($atts[0]);
            return ' ';
        }
    }

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $atts['orderby'] ) ) {
        $atts['orderby'] = sanitize_sql_orderby( $atts['orderby'] );

        if ( !$atts['orderby'] )
            unset( $atts['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'wraptag'    => 'div',
        'itemtag'    => 'figure',
        'icontag'    => 'div',
        'captiontag' => 'figcaption',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => '',
        'gallery_style' => 'list',
    ), $atts));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {

        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array(
            'include' => $include,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $order,
            'orderby' => $orderby
        ) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }

    } elseif ( !empty($exclude) ) {

        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array(
            'post_parent' => $id, 
            'exclude' => $exclude, 
            'post_status' => 'inherit', 
            'post_type' => 'attachment', 
            'post_mime_type' => 'image', 
            'order' => $order, 
            'orderby' => $orderby
        ) );

    } else {

        $attachments = get_children( array(
            'post_parent' => $id, 
            'post_status' => 'inherit', 
            'post_type' => 'attachment', 
            'post_mime_type' => 'image', 
            'order' => $order, 
            'orderby' => $orderby
        ) );

    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment ) {
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        }

        return $output;
    }

    $wraptag = tag_escape($wraptag);
    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';
    $selector = "gallery-{$post->ID}";
    $thumbnails = '';
    $style = '';

    if ( 'list' == $gallery_style ) {
        $size = 'gowatch_grid';
    }

    if ( 'grid' == $gallery_style ) {
        $size = 'gowatch_grid_masonry';

        $style = "<style type='text/css' scoped>
            @media (min-width: 768px) {
                #{$selector} .gallery-item {
                    float: {$float};
                    width: {$itemwidth}%;
                }
                #{$selector} .gallery-item:nth-child({$columns}n+1) {
                    clear: left;
                }
            }

            @media (max-width: 768px) {
                #{$selector} .gallery-item {
                    float: {$float};
                    width: 50%;
                }
                #{$selector} .gallery-item:nth-child(2n+1) {
                    clear: left;
                }
            }

            @media (max-width: 480px) {
                #{$selector} .gallery-item {
                    float: none;
                    width: 100%;
                }
            }
        </style>";
    }

    $carousel_nav = ('carousel' == $gallery_style) ? "
        <ul class=\"carousel-nav\">
            <li class=\"carousel-nav-left\"><i class=\"icon-left\"></i></li>
            <li class=\"carousel-nav-show-thumbnails\"><i class=\"icon-squares\"></i></li>
            <li class=\"carousel-nav-right\"><i class=\"icon-right\"></i></li>
        </ul>" : '';

    $output = apply_filters(
        'gallery_style',
        "{$style}
        <div id='$selector' class='gallery galleryid-{$id} airkit_post-gallery {$gallery_style}-post-gallery ". ('grid' == $gallery_style ? 'gallery-masonry' : '') ."'>
            {$carousel_nav}
            <{$wraptag} class='gallery-items'>"
    );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {

        $caption = wptexturize($attachment->post_excerpt);
        $description = wptexturize($attachment->post_content);
        $title = get_the_title($id);
        $sharing = airkit_PostMeta::sharing( $attachment->ID, array('tooltip-popover' => 'n', 'is_attachment' => true) );
        $image_full = wp_get_attachment_image_src( $id, 'full' );
        $src_full = esc_attr($image_full[0]);

        $link = isset($atts['link']) && 'file' == $atts['link'] ? '<a href="'. $src_full .'" title="'. $caption .'" data-fancybox="group">'. wp_get_attachment_image( $id, $size ) .'</a>' : '<a href="'. get_attachment_link( $id ) .'">'. wp_get_attachment_image( $id, $size ) .'</a>';

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "<{$icontag} class='gallery-icon ". ( 'list' == $gallery_style ? 'img_parallaxer' : '' ) ."' ". ( 'list' == $gallery_style ? "data-parallax='{\"y\": 25}'" : "" ) .">
                        $link
                    </{$icontag}>";

        if ( $captiontag && ( trim($attachment->post_excerpt) || $title ) ) {
            $output .= "
                <{$captiontag} class='gallery-caption ". ( 'list' == $gallery_style ? 'img_parallaxer' : '' ) ."' ". ( 'list' == $gallery_style ? "data-parallax='{\"y\": -20}'" : "" ) .">
                    <h4 class='title'>". $title ."</h4>
                    ". (!empty($caption) ? "<p class='caption'>" . $caption . "</p>" : "") ."
                    ". (!empty($description) ? "<p class='description'>". $description ."</p>" : "") ."
                    ". $sharing ."
                </{$captiontag}>";
        }

        $output .= "</{$itemtag}>";

        // Thumbnails for carousel style
        if ( 'carousel' == $gallery_style && $i == 0 ) {
            $thumbnails .= "<div class='gallery-nav-thumbnails'><div class='inner-gallery'>";
        }
        if ( 'carousel' == $gallery_style ) {
            $thumbnails .= "<{$itemtag} class='thumbnail-item'>". wp_get_attachment_image( $id, 'thumbnail' ) ."</{$itemtag}>";
        }
        if ( 'carousel' == $gallery_style && $i == count($attachments) - 1 ) {
            $thumbnails .= '</div><button class="btn-close-thumbnails"><i class="icon-close"></i></button>';
            $thumbnails .= "</div>";
        }

        $i++;
    }

    $output .= "
            </{$wraptag}>\n
            {$thumbnails}
        </div>\n <!-- / {$selector} -->";

    return $output;
}

add_action('print_media_templates', function(){

  // define your backbone template;
  // the "tmpl-" prefix is required,
  // and your input field should have a data-setting attribute
  // matching the shortcode name
  ?>
  <script type="text/html" id="tmpl-airkit_post-gallery-setting">
    <label class="setting">
      <span><?php esc_html_e('Gallery Style', 'gowatch'); ?></span>
      <select data-setting="gallery_style">
        <option value="list"><?php esc_html_e('List','gowatch') ?></option>
        <option value="grid"><?php esc_html_e('Grid','gowatch') ?></option>
        <option value="carousel"><?php esc_html_e('Carousel','gowatch') ?></option>
      </select>
    </label>
  </script>

  <script>

    jQuery(document).ready(function(){

        // add your shortcode attribute and its default value to the
        // gallery settings list; $.extend should work as well...
        _.extend(wp.media.gallery.defaults, {
            gallery_style: 'list',
        });

        // merge default gallery settings template with yours
        wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
            template: function(view){
                return wp.media.template('gallery-settings')(view)
                    + wp.media.template('airkit_post-gallery-setting')(view);
            }
        });

    });

  </script>
  <?php

});


function airkit_layout_wrapper( $elements ) {
    if( airkit_verify_ls_activation() ) {echo 'Builder disabled because you did not activate the license.'; return;}
    echo '<script id="dragable-row-tpl" type="text/x-handlebars-template">
    <ul class="layout_builder_row">
        <li class="row-editor">
            <ul class="row-editor-options">
                <li>
                    <a href="#" class="add-column">' . esc_html__( '+', 'gowatch' ) . '</a>
                    <a href="#" class="predefined-columns"><img src="'.get_template_directory_uri().'/images/options/columns_layout.png" alt=""></a>
                    <ul class="add-column-settings">
                        <li>
                         <a href="#" data-add-columns="#dragable-column-tpl"><img src="'.get_template_directory_uri().'/images/options/columns_layout_column.png" alt=""></a>
                     </li>
                     <li>
                         <a href="#" data-add-columns="#dragable-column-tpl-half"><img src="'.get_template_directory_uri().'/images/options/columns_layout_halfs.png" alt=""></a>
                     </li>
                     <li>
                         <a href="#" data-add-columns="#dragable-column-tpl-thirds"><img src="'.get_template_directory_uri().'/images/options/columns_layout_thirds.png" alt=""></a>
                     </li>
                     <li>
                         <a href="#" data-add-columns="#dragable-column-tpl-four-halfs"><img src="'.get_template_directory_uri().'/images/options/columns_layout_one_four.png" alt=""></a>
                     </li>
                     <li>
                         <a href="#" data-add-columns="#dragable-column-tpl-one_three"><img src="'.get_template_directory_uri().'/images/options/columns_layout_one_three.png" alt=""></a>
                     </li>
                     <li>
                         <a href="#" data-add-columns="#dragable-column-tpl-four-half-four"><img src="'.get_template_directory_uri().'/images/options/columns_layout_four_half_four.png" alt=""></a>
                     </li>
                 </ul>
             </li>
         </ul>
    </li>
    <li class="builder-row-actions">
        <ul class="row-actions-list">
            <li class="row-toggle-options"><a href="#"><i class="icon-block"></i> '. esc_html__( 'Options', 'gowatch' ) .' </a></li>
            <li class="row-action-edit edit-row-settings" data-element-type="row">
                <a href="#" class="edit-row icon-settings"></i>' . esc_html__('Edit', 'gowatch') . '</a>
                <span class="airkit_element-settings" style="display:none;"></span>
            </li>                    
            <li class="row-action-remove"><a href="#" class="remove-row">' . esc_html__( 'delete', 'gowatch' ) . '</a></li>
            <li class="row-action-move"><a href="#" class="move">' . esc_html__( 'move', 'gowatch' ) . '</a></li>    
            <li class="row-action-import airkit_import-element"><a href="#">' . esc_html__( 'Import Row', 'gowatch' ) . '</a></li>
            <li class="row-action-export airkit_export-row"><a href="#">' . esc_html__( 'Export', 'gowatch' ) . '</a></li>
        </ul>
    </li>
</ul>
</script>';

echo
    '<script id="dragable-element-tpl" type="text/x-handlebars-template">
        <li>
            <i class="element-icon icon-empty"></i>
            <span class="element-name">' . esc_html__('Empty', 'gowatch') . '</span>
            <span class="edit icon-edit" data-tooltip="'.esc_html__('Edit this element', 'gowatch') . '" data-element-type="empty">' .
                esc_html__('Edit', 'gowatch') .
                '<span class="airkit_element-settings" style="display:none;"></span>
            </span>
            <span class="delete icon-delete" data-tooltip="'.esc_html__('Remove this element', 'gowatch').'"></span>
            <span class="clone icon-duplicate" data-tooltip="'.esc_html__('Clone this element', 'gowatch').'"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__('Export this element', 'gowatch') . '"></span>
        </li>
    </script>';
    // Template for adding a 12 column
echo '<script id="dragable-column-tpl" type="text/x-handlebars-template">
<li data-size="12" data-element-type="column" class="columns12">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">12/12</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
</script>';
    // Template for splitting the content in 2 halfs
echo '<script id="dragable-column-tpl-half" type="text/x-handlebars-template">
<li data-size="6" data-element-type="column" class="columns6">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/2</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "6"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>        
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
<li data-size="6" data-element-type="column" class="columns6">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/2</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "6"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
</script>';
    // Template for splitting the content in 3 columns
echo '<script id="dragable-column-tpl-thirds" type="text/x-handlebars-template">
<li data-size="4" data-element-type="column" class="columns4">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/3</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "4"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
<li data-size="4" data-element-type="column" class="columns4">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/3</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "4"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
<li data-size="4" data-element-type="column" class="columns4">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/3</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "4"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
</script>';
    // Template for splitting the content 4 + 8
echo '<script id="dragable-column-tpl-one_three" type="text/x-handlebars-template">
<li data-size="4" data-element-type="column" class="columns4">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/3</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "4"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
<li data-size="8" data-element-type="column" class="columns8">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">2/3</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "8"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
</script>';
    // Template for splitting the content in one fourth to one half and one fourth
echo '<script id="dragable-column-tpl-four-half-four" type="text/x-handlebars-template">
<li data-size="3" data-element-type="column" class="columns3">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/4</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "3"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
<li data-size="6" data-element-type="column" class="columns6">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/2</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "6"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
<li data-size="3" data-element-type="column" class="columns3">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/4</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "3"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
</script>';
    // Template for splitting the content in four columns
echo '<script id="dragable-column-tpl-four-halfs" type="text/x-handlebars-template">
<li data-size="3" data-element-type="column" class="columns3">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/4</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "3"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
<li data-size="3" data-element-type="column" class="columns3">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/4</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "3"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
<li data-size="3" data-element-type="column" class="columns3">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/4</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "3"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
<li data-size="3" data-element-type="column" class="columns3">
    <div class="column-header">
        <span class="minus icon-left" data-tooltip="'.esc_html__('Reduce column size', 'gowatch').'"></span>
        <span class="column-size" data-tooltip="'.esc_html__('The size of the column within container', 'gowatch').'">1/4</span>
        <span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
        <span class="delete-column icon-delete" data-tooltip="'.esc_html__('Remove this column', 'gowatch').'"></span>
        <span class="clone icon-duplicate ts-clone-column" data-tooltip="'.esc_html__('Clone this column', 'gowatch').'"></span>
        <span class="edit-column icon-edit" data-element-type="column" data-tooltip="'.esc_html__('Edit this column', 'gowatch').'">
            <span class="airkit_element-settings" style="display:none;">{"element-type":"column", "size": "3"}</span>
        </span>
        <span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
            <span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
            <span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export column with content', 'gowatch' ) . '"></span>
            <span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Column', 'gowatch').'"></span>
        </span>   
    </div>
    <ul class="elements">
    </ul>
    <span class="add-element">'.esc_html__('Add element', 'gowatch').'</span>
</li>
</script>';


echo '<div class="builder-section-container">
<!-- Edit Content Strucutre -->
<div style="clear: both"></div>
<a href="#" data-location="content" class="app red-ui-button add-top-row">' . esc_html__( 'Add row to the top', 'gowatch' ) . '</a><br/><br/>
<div class="layout_builder" id="section-content">';

    echo airkit_var_sanitize($elements, 'the_kses');

    echo '
</div>
<div style="clear: both"></div>
<br>
<a href="#" data-location="content" class="app red-ui-button add-bottom-row">'. esc_html__( 'Add row to the bottom', 'gowatch' ) . '</a>
<a href="#" data-location="content" class="app red-ui-button publish-changes" style="float: right;"><i class="icon-save"></i> '. esc_html__( 'Save Layout Settings', 'gowatch' ) . '</a>
<div style="clear: both"></div>
</div>
<div class="ts-is-hidden airkit_modal ts-all-elements">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-close"></i></button>
        <h4 class="modal-title" id="ts-builder-elements-modal-label" data-elements-title="Builder elements" data-element-title="Builder element">Builder elements</h4>
    </div>
    <div class="builder">
        <table cellpadding="10">
            <tr>
                <td>
                    <label for="ts-element-type">'. esc_html__('Select the element type', 'gowatch') .'</label>
                    <div class="builder-element-search">
                        <input type="text" class="airkit_modal-search" placeholder="'. esc_html__( 'Seach element', 'gowatch' ) .'" autofocus/>
                        <i class="icon-search"></i>
                    </div>                    
                </td>
            </tr>
            <tr>
                <td>

                    <ul class="ts-tab-elements">
                        <li data-ts-tab="ts-all-tab">
                            '. esc_html__('All', 'gowatch') .'
                        </li>
                        <li data-ts-tab="ts-post-tab">
                            '. esc_html__('Post listing', 'gowatch') .'
                        </li>
                        <li data-ts-tab="ts-content-tab">
                            '. esc_html__('Content elements', 'gowatch') .'
                        </li>
                        <li data-ts-tab="ts-media-tab">
                            '. esc_html__('Media elements', 'gowatch') .'
                        </li>
                        <li data-ts-tab="ts-blocks-tab">
                            '. esc_html__('Blocks', 'gowatch') .'<sup>'. esc_html__('New', 'gowatch') .'</sup>
                        </li>
                    </ul>
                    <div class="builder-element-array">
                        <ul class="airkit_elements-container">
                            <li data-ts-tab-element="ts-content-tab" class="icon-logo" data-element-type="logo">
                                <span>'. esc_html__( 'Logo', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-user" data-element-type="user">
                                <span>'. esc_html__( 'User element', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-social" data-element-type="social-buttons">
                                <span>'. esc_html__( 'Social buttons', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-search" data-element-type="searchbox">
                                <span>'. esc_html__( 'Search box', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-menu" data-element-type="menu">
                                <span>'. esc_html__( 'Menu', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-sidebar" data-element-type="sidebar">
                                <span>'. esc_html__( 'Sidebar', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="accordion">
                                <span>'. esc_html__( 'Article accordion', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="grid">
                                <span>'. esc_html__( 'Grid articles', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="list_view">
                                <span>'. esc_html__( 'List articles', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="numbered_list_view">
                                <span>'. esc_html__( 'Numbered list articles', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="thumbnail">
                                <span>'. esc_html__( 'Thumbnails articles', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="mosaic">
                                <span>'. esc_html__( 'Mosaic articles', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="timeline">
                                <span>'. esc_html__( 'Timeline articles', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="big">
                                <span>'. esc_html__( 'Big articles', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="super">
                                <span>'. esc_html__( 'Super articles', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="category">
                                <span>'. esc_html__( 'Category articles', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="category-grids">
                                <span>'. esc_html__( 'Category grids', 'gowatch' ) .' </span>
                            </li> 
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="list-categories">
                                <span>'. esc_html__( 'List categories', 'gowatch' ) .' </span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-clipboard" data-element-type="small-articles">
                                <span>'. esc_html__( 'Small articles', 'gowatch' ) .' </span>
                            </li>
                            <!-- end Post listing -->'.
                            ( class_exists( 'Ts_Custom_Post' ) ? '
                                <li data-ts-tab-element="ts-post-tab" class="icon-text" data-element-type="events">
                                    <span>'. esc_html__( 'List Events', 'gowatch' ) .'</span>
                                </li>
                                <li data-ts-tab-element="ts-content-tab" class="icon-team" data-element-type="teams">
                                    <span>'. esc_html__( 'Teams', 'gowatch' ) .'</span>
                                </li>' : ''
                                ) .'

                            <li data-ts-tab-element="ts-post-tab" class="icon-dollar" data-element-type="pricing-tables">
                                <span>'. esc_html__( 'Pricing tables', 'gowatch' ) .'</span>
                            </li>

                            <li data-ts-tab-element="ts-post-tab" class="icon-dollar" data-element-type="pricelist">
                                <span>'. esc_html__( 'Pricelist', 'gowatch' ) .'</span>
                            </li>

                            <li data-ts-tab-element="ts-content-tab" class="icon-desktop" data-element-type="slider">
                                <span>'. esc_html__( 'Slider', 'gowatch' ) .'</span>
                            </li>

                            <li data-ts-tab-element="ts-media-tab" class="icon-gallery" data-element-type="gallery">
                                <span>'. esc_html__( 'Gallery', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-comments" data-element-type="testimonials">
                                <span>'. esc_html__( 'Testimonials', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-direction" data-element-type="callaction">
                                <span>'. esc_html__( 'Call to action', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-money" data-element-type="advertising">
                                <span>'. esc_html__( 'Advertising', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-all-tab" class="icon-empty" data-element-type="empty">
                                <span>'. esc_html__( 'Empty', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-delimiter" data-element-type="delimiter">
                                <span>'. esc_html__( 'Delimiter', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-font" data-element-type="title">
                                <span>'. esc_html__( 'Title', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-media-tab" class="icon-video" data-element-type="video">
                                <span>'. esc_html__( 'Video', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-media-tab" class="icon-image" data-element-type="image">
                                <span>'. esc_html__( 'Image', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-resize-vertical" data-element-type="spacer">
                                <span>'. esc_html__( 'Spacer', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-button" data-element-type="buttons">
                                <span>'. esc_html__( 'Button', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-mail" data-element-type="contact-form">
                                <span>'. esc_html__( 'Contact form', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-featured-area" data-element-type="featured-area">
                                <span>'. esc_html__( 'Featured area', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-code" data-element-type="shortcodes">
                                <span>'. esc_html__( 'Shortcodes', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-text" data-element-type="text" id="icon-text">
                                <span>'. esc_html__( 'Text', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-media-tab" class="icon-coverflow" data-element-type="image-carousel">
                                <span>'. esc_html__( 'Image carousel', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-flag" data-element-type="icon">
                                <span>'. esc_html__( 'Icon', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-list" data-element-type="listed-features">
                                <span>'. esc_html__( 'Listed features', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-tick" data-element-type="features-block">
                                <span>'. esc_html__( 'Icon box', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-users" data-element-type="list-users">
                                <span>'. esc_html__( 'List users', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-time" data-element-type="counter"><span>'. esc_html__( 'Counter', 'gowatch' ) .' </span></li>

                            '.
                            ( class_exists( 'WooCommerce' ) ? '
                               <li data-ts-tab-element="ts-post-tab" class="icon-basket" data-element-type="list-products">
                                    <span>' . esc_html__('List products', 'gowatch') . '</span>
                                </li>
                                <li data-ts-tab-element="ts-content-tab" class="icon-basket" data-element-type="cart">
                                    <span>' . esc_html__('Shopping cart', 'gowatch') . '</span>
                                </li>' : ''
                            ) .'

                            <li data-ts-tab-element="ts-content-tab" class="icon-clients" data-element-type="clients">
                                <span>'. esc_html__( 'Clients', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-facebook" data-element-type="facebook-block">
                                <span>'. esc_html__( 'Facebook Like Box', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-pin" data-element-type="map">
                                <span>'. esc_html__( 'Map', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-link-ext" data-element-type="banner">
                                <span>'. esc_html__( 'Banner', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-resize-full" data-element-type="toggle">
                                <span>'. esc_html__( 'Toggle', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-tabs" data-element-type="tab">
                                <span>'. esc_html__( 'Tabs', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-code" data-element-type="breadcrumbs">
                                <span>'. esc_html__( 'Breadcrumbs', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-ribbon" data-element-type="ribbon">
                                <span>'. esc_html__( 'Ribbon banner', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-parallel" data-element-type="timeline-features">
                                <span>'. esc_html__( 'Timeline features', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-megaphone" data-element-type="count-down">
                                <span>'. esc_html__( 'Counter down', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-ticket" data-element-type="powerlink">
                                <span>'. esc_html__( 'Powerlink', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-calendar" data-element-type="calendar">
                                <span>'. esc_html__( 'Calendar', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-attention" data-element-type="alert">
                                <span>'. esc_html__( 'Alert', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-pencil-alt" data-element-type="skills">
                                <span>'. esc_html__( 'Skills', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-chart" data-element-type="chart-line">
                                <span>'. esc_html__( 'Chart line', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-chart" data-element-type="chart-pie">
                                <span>'. esc_html__( 'Chart pie', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-empty" data-element-type="boca">
                                <span>'. esc_html__( 'Boca slider posts', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-empty" data-element-type="nona">
                                <span>'. esc_html__( 'Nona slider posts', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-post-tab" class="icon-empty" data-element-type="grease">
                                <span>'. esc_html__( 'Grease slider posts', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-analysis" data-element-type="instance">
                                <span>'. esc_html__( 'Instance', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-media-tab" class="icon-analysis" data-element-type="mosaic-images">
                                <span>'. esc_html__( 'Mosaic images', 'gowatch' ) .'</span>
                            </li>
                            <li data-ts-tab-element="ts-content-tab" class="icon-analysis airkit_import-element" data-element-type="import">
                                <span>'. esc_html__( 'Import', 'gowatch' ) .'</span>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>';

}


//=============== Styles Tab ==============================

if ( ! function_exists( 'airkit_get_color' ) ) {

    function airkit_get_color( $val ) {
        $colors = ( $colors = get_option( 'gowatch_options' ) ) ? $colors['colors'] : '';

        return isset( $colors[ $val ] ) ? $colors[ $val ] : '';
    }
}

if ( ! function_exists( 'airkit_custom_background' ) ) {

    function airkit_custom_background() {
        $styles = ( $styles = get_option( 'gowatch_options' ) ) ? $styles['styles'] : '';

        $styles['bg_image'] = explode( '|', $styles['bg_image'] );
        $styles['bg_image'] = $styles['bg_image'][0];
        $styles['bg_image'] = wp_get_attachment_url( $styles['bg_image'] );

        if ( $styles['theme_custom_bg'] == 'n' ) return;

        switch ( $styles['theme_custom_bg'] ) {

            case 'N':

                $css = '';
            break;

            case 'pattern':
                $css = "background: url(" . get_template_directory_uri() . '/images/patterns/' . esc_attr( $styles['theme_bg_pattern'] ) . ");\n";
            break;

            case 'image':
                $css = "background: url(" . esc_url( $styles['bg_image'] ) . ") no-repeat top center;\n";
            break;

            case 'color':
                $css = "background-color: " . esc_attr( $styles['theme_bg_color'] ) . ";\n";
            break;

            default:
                $css = '';
            break;
        }

        if ( ! empty( $css ) ) {

            return "body {\n" . $css . "\n}";

        } else {

            return;
        }
    }
}

if ( ! function_exists( 'airkit_overlay_effect_type' ) ) {

    function airkit_overlay_effect_type( $echo = true ) {
        $effect = airkit_option_value( 'styles', 'overlay_effect' );

        if ( $effect == 'n' ) return;

        $effect_type = 'dots' == $effect ? 'dotted' : 'stripes';
        $return = '<span class="' . $effect_type . '"></span>';

        if ( $echo ) {
            echo force_balance_tags($return);
        } else {
            return force_balance_tags($return);
        }
    }
}

if ( ! function_exists( 'airkit_get_logo' ) ) {

    function airkit_get_logo( $effect = '', $return_attr = false ) {
        $logo = airkit_option_value( 'styles', 'logo' );

        if ( $return_attr ) {
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $image_attr = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            
            return $image_attr;
        }

        // Check if 4.5 and can use that logo     
        if ( function_exists( 'the_custom_logo' ) ) {
            $custom_logo = str_replace('custom-logo-link', 'custom-logo-link logo ' . $effect, get_custom_logo() );
            // Show the logo from the customizer
            if ( $custom_logo != '' && $logo['type'] !== 'google' ) {
                
                if ( $logo['retina'] == 'y' ) {

                    // get the retina image width and half it
                    preg_match_all('@width="([^"]+)"@', $custom_logo, $retina_image);
                    $retina_image_width = array_pop( $retina_image );
                    if ( isset( $retina_image[0] ) && !empty( $retina_image[0] ) ) {

                        $retinaWidth = $retina_image_width[0]/2;

                        $custom_logo = airkit_str_replace_first($retina_image_width[0], $retinaWidth, $custom_logo, 2);

                        // get the retina image height and half it
                        preg_match_all('@height="([^"]+)"@', $custom_logo, $retina_image);
                        $retina_image_height = array_pop( $retina_image );
                        airkit_str_replace_first($retina_image_height[0], $retina_image_height[0]/2, $custom_logo, 2);
                    }
                }

                return $custom_logo;

            } else {

                return '<h1 class="gowatch-text-logo"><a href="'. esc_url( home_url('/') ) . '" class="logo custom_logo_text">' . get_bloginfo('name') . '</a></h1>'; 
            }
        }
    }
}

if ( ! function_exists( 'airkit_get_custom_fonts_css' ) ) {

    add_filter( 'wp_image_editors', 'airkit_change_graphic_lib' );

    function airkit_change_graphic_lib( $array ) {
        return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
    }

    function airkit_get_custom_fonts_css() {
        $options = get_option( 'gowatch_options' );
        $fonts = $options['typography'];

        if ( $options['styles']['logo']['type'] == 'google' ) {

            $fonts['logo'] = $options['styles']['logo']['font'];
        }
        // Extrat only fonts.
        $extract = $fonts;

        unset( $extract['extra'] );
        unset( $extract['custom'] );

        if ( empty( $extract ) ) return;

        $custom = isset( $fonts['custom'] ) && is_array( $fonts['custom'] ) ? wp_list_pluck( $fonts['custom'], 'family' ) : array();
        $out = '';

        foreach ( $extract as $font ) {
            if ( isset( $font ) && $font !== '' ) {

                $font['line'] = isset( $font['line'] ) && $font['line'] != 'Inherit' ? $font['line'] . 'px' : 'inherit';

                $out .=
                        $font['class_css'] . '{' .
                            ( $font['size'] > 0 ? 'font-size:' . $font['size'] . 'px;' : '' ) .
                            'font-family: "' . sanitize_text_field( $font['family'] ) . '";' .
                            'font-weight: ' . sanitize_text_field( $font['weight'] ) . ';' .
                            'font-style: ' . $font['style'] . ';' .
                            'letter-spacing: ' . $font['letter'] . 'em;' .
                            'text-decoration: ' . $font['decor'] . ';' .
                            'text-transform: ' . $font['transform'] . ';' .
                            'line-height: ' . $font['line'] . ';
                        }';

                if ( ! array_key_exists( $font['family'], $custom ) ) continue;

                $out .= "@font-face{
                    font-family:" . $font['family'] . ";
                    src: url('" . esc_url( $fonts['custom'][ $font['family'] ]['files']['eot'] ) . "');
                    src: url('" . esc_url( $fonts['custom'][ $font['family'] ]['files']['eot'] ) . "?#iefix') format('embedded-opentype'),
                    " . esc_url( $fonts['custom'][ $font['family'] ]['files']['woff'] ) . "
                    " . esc_url( $fonts['custom'][ $font['family'] ]['files']['ttf'] ) . "
                    " . esc_url( $fonts['custom'][ $font['family'] ]['files']['svg'] ) . "
                }";

            }
        }

        $out .= '@media (max-width: 768px) {
            h1 {
                font-size: 40px;
                line-height: 1.35em;
            }
            h2 {
                font-size: 32px;
                line-height: 1.25em;
            }
            h3 {
                font-size: 24px;
                line-height: 1.25em;
            }
            h4 {
                font-size: 22px;
                line-height: 1.22em;
            }
        }';

        echo airkit_var_sanitize( $out, 'true' );
    }
}

function airkit_remove_cssjs_ver( $src ) {
    if ( strpos( $src, '?ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'airkit_remove_cssjs_ver', 1000 );
add_filter( 'script_loader_src', 'airkit_remove_cssjs_ver', 1000 );

function airkit_str_replace_first( $needle, $replace, $haystack ) {
    $pos = strpos($haystack, $needle);
    if ($pos !== false) {
        $newstring = substr_replace($haystack, $replace, $pos, strlen($needle));
    }
    
    return $newstring;
}


//================== Single post Tab ==================================================

if ( ! function_exists('airkit_single_display_tags') ) {

    function airkit_single_display_tags() {
        $single = get_option('gowatch_single_post', array('post_tags' => 'Y'));

        if ($single['post_tags'] === 'y') {
            return true;
        } else {
            return false;
        }
    }
}

//================== Styling functions ==================================================
if ( ! function_exists('airkit_rgba_opacity') ) {

    function airkit_rgba_opacity( $color, $p ) {

        if ( strpos( $color, 'rgba' ) != -1 ) {

            $color = str_replace(array('rgba(', ')', ' '), '', $color);   
             
            $arr = explode(',', $color);

            if ( count($arr) > 1 ) {

                return 'rgba('. $arr[0] .', '. $arr[1] .', '. $arr[2] .', '. $p .')';
            }


        } elseif( strpos( $color, '#' ) != -1 ) {
            // is hex color.
            return airkit_rgba_opacity( airkit_hex2rgb( $color, $p ), $p );
        }

           
        return $color;
   }
}

if ( ! function_exists('airkit_hex2rgb') ) {

    function airkit_hex2rgb( $hex, $p ) {
     $hex = str_replace("#", "", $hex);

     if ( strlen($hex) == 3 ) {

      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));

      } else {

          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));

      }
    $rgb = 'rgba(' . $r.','. $g.','. $b.', '.$p . ')';

       return $rgb; // returns an array with the rgba values
   }
}

if ( !function_exists( 'airkit_is_color_light' ) ) {
    function airkit_is_color_light( $color ) {

        if ( strpos('#', $color) !== false ) {
            //if HEX color given, transform it to rgba. 
            $color = airkit_hex2rgb( $color, '1' );

        }
        //remove rgba(), get only values

        $color = str_replace( array( 'rgba(', ')' ), '', $color );

        $rgba = explode( ',', $color );

        //we need only values located at [0], [1], [2].

        $R = absint( $rgba[0] );
        $G = absint( $rgba[1] );
        $B = absint( $rgba[2] );
        $A = absint( $rgba[3] );

        $brightness_rel = ( max($R, $G, $B) + min($R, $G, $B) ) / 510.0; // HSL algorithm

        if ( $brightness_rel >= 0.8 ) {

            return true;

        } else {

            return false;

        }
    }    
}

if ( !function_exists('airkit_is_color_transparent') ) {
    function airkit_is_color_transparent( $color ) {
        if ( strpos('#', $color) !== false ) {
            //if HEX color given, transform it to rgba. 
            $color = airkit_hex2rgb( $color, '1' );

        }
        //remove extra characters (including spaces).
        $color = str_replace( array( 'rgba(', ')', ' ' ), '', $color );
        $rgba = explode( ',', $color );  

        if ( isset( $rgba[3] ) && '0' === $rgba[3] ) {
            return true;
        } else {
            return false;
        }
    }
}

add_action( 'admin_notices', 'airkit_get_alert' );

if ( ! function_exists( 'airkit_get_alert' ) ) {

    function airkit_get_alert() {

        // Red area part
        $red_area = get_option( 'gowatch_red_area', array() );

        if ( isset( $red_area['alert']['id'], $red_area['alert']['message'] ) ) {

            if ( $red_area['alert']['id'] !== 0 && ! empty( $red_area['alert']['message'] ) ) {

                if ( is_array( $red_area['hidden_alerts'] ) ) {

                    if ( ! in_array( $red_area['alert']['id'], $red_area['hidden_alerts'] ) ) {

                        echo
                            '<div class="updated notice is-dismissible">
                                <p>' .
                                    $red_area['alert']['message'] .
                                    '<button type="button" class="notice-dismiss ts-remove-alert"  data-token="' . wp_create_nonce( 'remove-pandella-alert' ) . '" data-alets-id="' . $red_area['alert']['id'] . '"><span class="screen-reader-text">Dismiss this notice.</span></button>' . 
                                '</p>
                            </div><br/>';
                    }
                }
            }
        }


        // Debugging:
        // 1. Delete theme versions transient (uncomment line below)
        // delete_site_transient( 'update_themes' );
        // 2. Request new version of themes
        // wp_update_themes();
        $updates = get_theme_updates();

        $current = wp_get_theme();

        if ( isset( $updates[ 'gowatch' ] ) && version_compare( $current->Version, $updates['gowatch']->update['new_version'], '<' ) ) {

            echo
                '<div class="updated">
                    <h3>' . esc_html__('Attention', 'gowatch') . '!</h3>
                    <p>' . esc_html__( 'You are using an old version of the theme. To ensure maximum compatibility and bugs fixed please keep the theme up to date.Do not forget that changes done directly in the theme files will be lost, use only Custom CSS areas and child themes if you wish to make changes.', 'gowatch' ) .
                        '<br><br><a href="' . network_admin_url( 'update-core.php' ) . '" class="button button-primary">' . esc_html__( 'Update now', 'gowatch' ) . '</a>
                    </p>
                </div><br><br>';
        }

        $update_options = get_option( 'gowatch_options' );

        $update_options = isset( $update_options['update'] ) ? $update_options['update'] : array();

        if  ( empty( $update_options['envato_token'] ) ) 
        {
            echo
                '<div class="updated">

                    <h3>' . esc_html__( 'Set your update token', 'gowatch' ) . '</h3>
                    <p>' .
                        esc_html__( 'To make sure you receive update notifications and to be able to update directly from the Dashboard please add your Envato Market Token.', 'gowatch' ) .
                        '<br><a class="button button-primary" href="' . admin_url( 'themes.php?page=gowatch&tab=update' ) . '">' .
                            esc_html__( 'Set Token', 'gowatch' ) .
                        '</a> ' .
                        '<a href="#" class="ts-remove-alert button-secondary" data-token="' . wp_create_nonce( 'remove-gowatch-alert' ) . '" data-alets-id="empty-envato-info">' .
                            esc_html__( 'Hide notice', 'gowatch' ) .
                        '</a>
                    </p>
                </div><br/>';
        } 
        if  ( !function_exists( 'ts_enc_string' )  )  {

            echo
                '<div class="updated">
                    <i class="icon-attention" style="font-size: 48px;color:#ff0000;"></i>
                    <h3>' . esc_html__( 'TouchCodes Not Installed or Activated', 'gowatch' ) . '</h3>
                    <p>' .
                        esc_html__( 'The theme requires TouchCodes plugin to run properly. It is included in the package with the theme and it takes only a couple of clicks to install.', 'gowatch' ) .
                        '<br><br/><a class="button button-primary" href="' . admin_url( 'themes.php?page=gowatch-install-plugins' ) . '">' .
                            esc_html__( 'Go Activate TouchCodes', 'gowatch' ) .
                        '</a>
                    </p>
                </div><br/>';
        }
    }
}

$update_options = get_option( 'gowatch_options' );

if ( isset( $update_options['update'] ) ) {

    load_template( trailingslashit( get_template_directory() ) . 'includes/updater/class-airkit-envato-api.php' );
    load_template( trailingslashit( get_template_directory() ) . 'includes/updater/class-airkit-updater.php' );
}

if ( ! function_exists('airkit_update_redarea') ) {
    function airkit_update_redarea() {
        $option = get_option('gowatch_red_area', array());

        if (isset($option['time']) ) {

            $current_time = time();

            if ( ($current_time - (int)$option['time']) >= 3600 ) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}


if ( ! function_exists('airkit_theme_styles_rewrite') ) {
    
    function airkit_theme_styles_rewrite() {
        // Get thene background color
        $theme = wp_get_theme();
        $nameTheme = (isset($theme) && is_object($theme)) ? $theme->name : '';
        $versionTheme = (isset($theme) && is_object($theme)) ? $theme->version : '';

        $siteWidth = airkit_option_value( 'styles', 'site_width' );

        // Start of inline styles buffer
        ob_start();
        ob_clean();   
        ?>
            /*************** Theme:  <?php echo airkit_var_sanitize($nameTheme, 'esc_attr' ); ?> *************/
            /*************** Theme Version:  <?php echo airkit_var_sanitize($versionTheme, 'esc_attr' ); ?> ************/
            /*
            --------------------------------------------------------------------------------
                1. GENERAL COLOR
            --------------------------------------------------------------------------------
            */

            @media (min-width: 1200px) {
                .container, .ts-mega-menu .ts_is_mega_div{
                    max-width: <?php echo airkit_var_sanitize($siteWidth, 'esc_attr'); ?>px;
                }  
            }          
            
            body{
                color: <?php echo airkit_get_color('general_text_color'); ?>;
            }
            .airkit_search-filter-form {
                color: <?php echo airkit_get_color('general_text_color'); ?>;
            }
            .event-list-cal-excerpt,
            .airkit_frontend-dashboard .tszf-author .author-stats > li > strong {
                color: <?php echo airkit_get_color('general_text_color'); ?>;
            }
            #event-list-cal a{
                color: <?php echo airkit_get_color('general_text_color'); ?>;
            }
            .gbtr_minicart_wrapper {
                color: <?php echo airkit_get_color('general_text_color'); ?>;
            }
            .woocommerce #content div.product form.cart .variations label,
            .woocommerce div.product form.cart .variations label,
            .woocommerce-page #content div.product form.cart .variations label,
            .woocommerce-page div.product form.cart .variations label{
                color: <?php echo airkit_get_color('general_text_color'); ?>;
            }
            .airkit_search-filter-form input[type="submit"] {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .airkit_frontend-forms .submit input[type="submit"] {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .airkit_frontend-forms .submit input[type="submit"]:hover {
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .logged-in-video input[type="submit"] {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .logged-in-video input[type="submit"]:hover {
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .user-element .user-upload:hover {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .video-is-sticky .sticky-video-closer {
                background: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .video-is-sticky .sticky-video-closer:hover {
                background: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }
            .tszf-fields .bar {
                background: <?php echo airkit_get_color('primary_color'); ?>;
            }

            #add-to-playlist-modal .modal-footer #airkit-create-playlist {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            #add-to-playlist-modal .modal-footer #airkit-create-playlist:hover {
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }

            .widget article .entry-categories > li > a {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .widget article .entry-categories > li > a:hover {
                color: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }
            .widget_product_search input[type="submit"],
            #searchform input[type="submit"] {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }

            .vast-skip-button {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .vast-skip-button:hover {
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }

            .widget-title::after {
            background: <?php echo airkit_get_color('primary_color'); ?>;
            }
    
            .airkit_register-page {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }

            .video-js .vjs-play-progress,
            .video-js .vjs-slider-bar {
                background: <?php echo airkit_get_color('primary_color'); ?> !important;
            }

            .airkit_search-filter-form input[type="submit"]:hover,
            #searchform input[type="submit"]:hover {
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .airkit_comment-rating .whole{
                color: <?php echo airkit_get_color('secondary_color'); ?>;
            }

            .airkit_comment-rating .rover{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            article .airkit_sharing.views-sharing-button li a:hover,
            article:hover .airkit_sharing.views-sharing-button li:first-child a{
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }

            .content-toggler span:hover {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }

            /*
            --------------------------------------------------------------------------------
                2. LINK COLOR
            --------------------------------------------------------------------------------
            */
            a{
                color: <?php echo airkit_get_color('link_color'); ?>;
            }
            a:hover, a:focus{
                color: <?php echo airkit_get_color('link_color_hover'); ?>;
            }
            .post-navigator ul li a:hover div,
            .widget a:hover,
            .playlist-panel .playlist-repeat:hover,
            .playlist-panel .playlist-shuffle:hover {
                color: <?php echo airkit_get_color('link_color_hover'); ?>;
            }
            .post-navigator ul li a div{
                color: <?php echo airkit_get_color('link_color'); ?>;
            }
            .post-navigator ul li a:hover div{
                color: <?php echo airkit_get_color('link_color_hover'); ?>;
            }
            .woocommerce .woocommerce-breadcrumb a {
                color: <?php echo airkit_get_color('link_color'); ?>;   
            }
            .woocommerce .woocommerce-breadcrumb a:hover,
            .commentlist > li .comment .comment-reply-link:hover {
                color: <?php echo airkit_get_color('link_color_hover'); ?>;   
            }
            article .entry-categories > li:not(:last-child)::after {
                background-color: <?php echo airkit_get_color('link_color'); ?>;
            }

            /*
            --------------------------------------------------------------------------------
                3. PRIMARY COLOR
            --------------------------------------------------------------------------------
            */
            ::-moz-selection {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background: <?php echo airkit_get_color('primary_color'); ?>;
            }

            ::selection {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .joyslider .entry-category a,
            .ts-vertical-gallery .inner-gallery-container .bx-wrapper .bx-controls-direction a::before{
                background: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .airkit_page-header:not(.has-background) .archive-title span {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .airkit_page-loading .airkit_ball .airkit_inner-ball {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .primary_color {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .btn-primary {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .btn-primary:hover,
            .btn-primary:active,
            .btn-primary:focus {
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }

            .airkit_page-header.has-background .archive-title span {
                border-bottom: 3px solid <?php echo airkit_get_color('primary_color'); ?>;
            }
            .ts-big-countdown .time-remaining > li > span,
            article .entry-meta-category,
            article .entry-category > li > a {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            article .entry-category > li > a:hover{
                color: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }
            .trigger-caption .button-trigger-cap{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .tweet-author,
            .tweet-entry .icon-twitter,
            .tweet-entry .tweet-data a{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .block-title-border-square-center .block-title-container::before,
            .block-title-border-square-left .block-title-container::before{
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .gbtr_dynamic_shopping_bag .ts-cart-close:hover {
                color: <?php echo airkit_get_color('primary_color'); ?>;
                border-color: <?php echo airkit_rgba_opacity( airkit_get_color('primary_color'), '0.3' ); ?>;
            } 

            .post-content blockquote::before,
            .post-content blockquote::after,
            .comment-content blockquote::before,
            .comment-content blockquote::after            {
                color: rgba(70, 70, 70, 0.5);
            }

            .inline-featured{
                border-top: 4px solid <?php echo airkit_get_color('primary_color'); ?>;
            }
            .inline-featured h5 i{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }


            .joyslider .entry-category a:hover{
                background: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }

            .menu-open .trigger-menu.close-menu{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .menu-open .trigger-menu.close-menu:hover{
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .joyslider .slide-preview:hover{
                border-bottom-color: <?php echo airkit_get_color('primary_color'); ?>;;
            }
            .nav-container ul.carousel-nav > li,
            .carousel-wrapper ul.carousel-nav > li:hover,
            .image-carousel ul.carousel-nav > li,
            .airkit_post-gallery.format-gallery-carousel.carousel-post-gallery .carousel-nav > li {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }

            .nav-container ul.carousel-nav > li:hover,
            .image-carousel ul.carousel-nav > li:hover,
            .airkit_post-gallery.format-gallery-carousel.carousel-post-gallery .carousel-nav > li:hover {
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .carousel-wrapper .slick-dots .nav-dot:hover,
            .carousel-wrapper .slick-dots .slick-active .nav-dot{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .carousel-wrapper .slick-dots .nav-dot{
                border-color: <?php echo airkit_get_color('primary_color'); ?>;   
            }

            .gallery-pagination-dot-selected{
                background: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .airkit_post-gallery.carousel-post-gallery .carousel-nav .carousel-nav-show-thumbnails.active {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .ts-video-fancybox span{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .ts-video-fancybox:hover span{
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }
            .single .post-meta .post-meta-actions .entry-meta-rating .touchrate-container,
            .single .post-meta .post-meta-actions .airkit-single-likes {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .single .post-meta .post-meta-actions .airkit-single-likes a,
            .single .post-meta .post-meta-actions .airkit-single-likes .touchsize-likes .touchsize-likes-icon {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .airkit_add-to-favorite .btn-add-to-favorite.active .btn-icon-wrap,
            .airkit_add-to-playlist .btn-add-to-playlist.active .btn-icon-wrap,
            #add-to-playlist-modal .modal-body ul li.active,
            .playlist-panel .playlist-repeat.active,
            .playlist-panel .playlist-shuffle.active {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .playlist-panel .playlist-item.active figure::after {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .playlist-view .playlist-remove {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .playlist-view .playlist-remove:hover {
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .tags-container a.tag:hover, .tags-container a[rel="tag"]:hover, .woocommerce .tagcloud a:hover {
                color: <?php echo airkit_get_color('primary_color'); ?>;
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .touchrate-average.touchrate-voted::before {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .ts-pricing-view article.featured{
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .airkit_menu[class*="menu-element-"] .navbar-default .dropdown-menu .entry-categories li a {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .woocommerce .product-view article .add_to_cart_button,
            .woocommerce .product-view article .product_type_variable {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .airkit_menu[class*="menu-element-"] .navbar-default .dropdown-menu .entry-categories li a:hover {
                color: <?php echo airkit_get_color('primary_color'); ?>;
                background-color: transparent;
            }
            .airkit_footer-style4 .widget_nav_menu li.menu-item a:hover {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .airkit_header-style4 .airkit_horizontal-menu .navbar-nav > li > a:hover::before,
            .airkit_header-style4 .airkit_horizontal-menu .navbar-nav > li.current-menu-ancestor > a::before {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .airkit_slider.vertical-slider .entry-categories li a,
            .airkit_slider.stream .slider-item .entry-categories li a,
            .airkit_nona-slider .nona-article .entry-categories li a,
            .airkit_grease-slider article .entry-categories a,
            .airkit_tilter-slider header .entry-content .entry-categories > li a,
            .ts-featured-area.style-3 .feat-area-thumbs .entry-categories > li a,
            .ts-featured-area.style-3 .feat-area-slider .entry-categories > li a {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .ts-featured-area.style-3 .feat-area-thumbs .thumb-item.slick-current .thumb-progress-bar {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .airkit_tilter-slider header .entry-content .entry-categories > li a:hover,
            .ts-featured-area.style-2 .feat-area-main article .entry-categories a:hover {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            
            .ts-pricing-view article .read-more,
            .ts-pricing-view .featured .read-more:hover {
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            article .read-more {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }

            .ts-pricing-view .featured .read-more,
            .ts-pricing-view article .read-more:hover{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }

            .airkit_powerlink .entry-content:hover .button {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .airkit_powerlink .entry-content:hover {
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .woocommerce span.onsale-after,
            .woocommerce-page span.onsale-after{
                border-bottom: 10px solid <?php echo airkit_get_color('primary_color_hover'); ?>;
            }
            .single-post-navigation .navigation > li > a:hover,
            .single-ts-gallery .entry-meta .entry-category > li > a:hover{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .ts-big-countdown li i {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .single-event .event-meta > li.delimiter,
            .single-event .event-meta > li.repeat{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .event-list-cal-single{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .flickr_badge_image:hover a img{
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            body.gowatch .wp-playlist-light .wp-playlist-playing,
            body.gowatch .mejs-controls .mejs-time-rail .mejs-time-current{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            
            .timeline-view article::after {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;   
            }

            .timeline-view article header .neighborhood .entry-meta-date {
                color: <?php echo airkit_get_color( 'primary_color' ); ?>;
            }

            .bxslider .controls-direction span a{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .bx-wrapper .bx-pager.bx-default-pager a.active{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            
            .ts-team-single .view-profile {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;   
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .instagram_widget_list .slick-dots .slick-active .nav-dot {
                background-color: <?php echo airkit_rgba_opacity( airkit_get_color('primary_color'), '0.5'); ?>;   
            }

            /* WooCommerce */
            .woocommerce .woocommerce-message,
            .woocommerce-page .woocommerce-message {
                color: <?php echo airkit_get_color('primary_color') ?>;
            }

            .woocommerce-nav .nav li.is-active a {
                background-color: <?php echo airkit_get_color('primary_color') ?>;   
                color: <?php echo airkit_get_color('primary_text_color') ?>;
            }

            .woocommerce span.onsale,
            .woocommerce-page span.onsale,
            .woocommerce #content div.product .woocommerce-tabs ul.tabs li{
                background: <?php echo airkit_get_color('primary_color') ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a::after,
            .woocommerce div.product .woocommerce-tabs ul.tabs li.active a::after,
            .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a::after,
            .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a::after{
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .woocommerce #content .woocommerce-result-count{
                color: <?php echo airkit_get_color('primary_color'); ?>;
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
            .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range,
            .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
            .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .woocommerce .widget_layered_nav_filters ul li a,
            .woocommerce-page .widget_layered_nav_filters ul li a{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .woocommerce #content .quantity .minus:hover,
            .woocommerce .quantity .minus:hover,
            .woocommerce-page #content .quantity .minus:hover,
            .woocommerce-page .quantity .minus:hover,
            .woocommerce #content .quantity .plus:hover,
            .woocommerce .quantity .plus:hover,
            .woocommerce-page #content .quantity .plus:hover,
            .woocommerce-page .quantity .plus:hover{
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .woocommerce #content input.button.alt,
            .woocommerce #respond input#submit.alt,
            .woocommerce a.button.alt,
            .woocommerce button.button.alt,
            .woocommerce input.button.alt,
            .woocommerce-page #content input.button.alt,
            .woocommerce-page #respond input#submit.alt,
            .woocommerce-page button.button.alt
            .woocommerce-page a.button.alt,
            .woocommerce-page input.button.alt{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .woocommerce #content input.button,
            .woocommerce #respond input#submit,
            .woocommerce a.button,
            .woocommerce button.button,
            .woocommerce input.button,
            .woocommerce-page #content input.button,
            .woocommerce-page #respond input#submit,
            .woocommerce-page a.button,
            .woocommerce-page button.button,
            .woocommerce-page input.button,
            .woocommerce .woocommerce-error .button,
            .woocommerce .woocommerce-info .button,
            .woocommerce .woocommerce-message .button,
            .woocommerce-page .woocommerce-error .button,
            .woocommerce-page .woocommerce-info .button,
            .woocommerce-page .woocommerce-message .button{
                background: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .woocommerce #content input.button:hover,
            .woocommerce #respond input#submit:hover,
            .woocommerce a.button:hover,
            .woocommerce button.button:hover,
            .woocommerce input.button:hover,
            .woocommerce-page #content input.button:hover,
            .woocommerce-page #respond input#submit:hover,
            .woocommerce-page a.button:hover,
            .woocommerce-page button.button:hover,
            .woocommerce-page input.button:hover{
                background: <?php echo airkit_get_color('primary_color_hover') ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .woocommerce #content input.button.alt:hover,
            .woocommerce #respond input#submit.alt:hover,
            .woocommerce a.button.alt:hover,
            .woocommerce button.button.alt:hover,
            .woocommerce input.button.alt:hover,
            .woocommerce-page #content input.button.alt:hover,
            .woocommerce-page #respond input#submit.alt:hover,
            .woocommerce-page a.button.alt:hover,
            .woocommerce-page button.button.alt:hover,
            .woocommerce-page input.button.alt:hover{
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?> !important;
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }
            .woocommerce .woocommerce-info,
            .woocommerce-page .woocommerce-info,
            .woocommerce .woocommerce-message,
            .woocommerce-page .woocommerce-message{
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .woocommerce .woocommerce-error,
            .woocommerce-page .woocommerce-error{
                border-color: #a80023;
            }
            .woocommerce .widget_price_filter .price_slider_amount .button{
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
            }
            .woocommerce .widget_price_filter .price_slider_amount .button:hover{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .woocommerce .woocommerce-error::before,
            .woocommerce-page .woocommerce-error::before{
                color: #a80023;
            }
            .woocommerce .woocommerce-info::before,
            .woocommerce-page .woocommerce-info::before,
            .woocommerce .woocommerce-message::before,
            .woocommerce-page .woocommerce-message::before{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .woocommerce .product-view article .added_to_cart
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .woocommerce .product-view article .add_to_cart_button:hover,
            .woocommerce .product-view article .added_to_cart:hover,
            .woocommerce .product-view article .ajax_add_to_cart:hover,
            .woocommerce .product-view article .product_type_variable:hover {
                color: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }

            .single-product .product-slider.slider-thumbs .slick-current {
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .single-product .product-images .slider-nav .slick-arrow:hover {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .woocommerce .share-options li[data-social="show-more"] a::before{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;                
            }

            .block-title-lineariconcenter .block-title-container i[class^="icon"]{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .ts-clients-view div[data-tooltip]:hover::before {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .ts-clients-view div[data-tooltip]:hover::after {
                border-top-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .airkit_search-filter-form input[type="text"]:focus,
            .searchbox input[type="text"]:focus {
                border-bottom-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .searchbox input.searchbutton:hover + i.icon-search,
            .airkit_search-filter-form .search-filter-form .form-group-selector > span i[class^="icon"] {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .airkit_search-filter-form .input-group-btn button.dropdown-toggle {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .airkit_search-filter-form .input-group-btn button.dropdown-toggle:hover {
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .airkit_search-filter-form .input-group-btn.open button.dropdown-toggle {
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
            }
            .airkit_search-filter-form .input-group-btn.open button.dropdown-toggle:hover {
                background-color: <?php echo airkit_get_color('secondary_color_hover'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color_hover'); ?>;
            }
            .airkit_search-filter-form p.ajax-results strong,
            .archive-title strong {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .search-no-results .searchpage,
            .search .attention{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            #commentform .form-submit input[type="submit"]{
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            #commentform .form-submit input[type="submit"]:hover {
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            #add-to-playlist-modal #create-playlist-form > button:hover {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            #commentform label .required,
            #commentform .comment-notes .required {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .ts-pagination-more {
                background: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .ts-pagination-more:not(.loading):hover{
                background: <?php echo airkit_get_color('primary_color_hover'); ?>;
                border-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .ts-pagination-more .spinner {
                border-left: 3px solid <?php echo airkit_get_color('primary_color'); ?>;
                border-right: 3px solid <?php echo airkit_get_color('primary_color'); ?>;
            }
            .ts-ball-scale-pulse {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .ts-callaction a.continue {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .block-title-lineafter .block-title-container .the-title::after,
            .block-title-smallcenter .block-title-container .the-title::after {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .ts-testimonials .carousel-wrapper .carousel-nav > li:hover {
                border-color:  <?php echo airkit_get_color('primary_color'); ?>;
            }

            .ts-testimonials article .entry-author:hover a {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .post-navigator ul li a{
                border-top-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .post-navigator ul li a:hover{
                border-top-color: <?php echo airkit_get_color('secondary_color'); ?>;
            }
            .block-title-linerect .block-title-container::before{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .delimiter.iconed::before{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .block-title-leftrect .block-title-container::before{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            a.tag:hover, a[rel="tag"]:hover{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .airkit_article-accordion article .bs-toggle,
            .airkit_article-accordion article .entry-meta-categories li,
            .ts-toggle-box .toggle-heading i{
                color: <?php echo airkit_get_color('primary_color'); ?>;   
            }

            #instagram_widget li header{
                background-color: <?php echo airkit_rgba_opacity( airkit_get_color('primary_color'), '0.8' ); ?>;   
            }

            button.contact-form-submit,
            #nprogress .bar,
            .article-progress-bar {
                background: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            button.contact-form-submit:hover,
            button.contact-form-submit:focus{
                background: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .widget .ts-tab-container .nav-tabs > li.active a {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .comment-form input:focus,
            .comment-form textarea:focus,
            .contact-form input:focus,
            .contact-form textarea:focus,
            #add-to-playlist-modal #create-playlist-form > input:focus {
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            #nprogress .spinner-icon {
                border-top-color: <?php echo airkit_get_color('primary_color'); ?>;
                border-left-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .ts-pagination ul .page-numbers {
                background-color: <?php echo airkit_option_value('styles', 'theme_bg_color'); ?>;
                color: <?php echo airkit_get_color('general_text_color'); ?>;
            }
            .ts-pagination ul .page-numbers.current,
            .ts-pagination ul .page-numbers.current:hover,
            .ts-pagination ul .page-numbers.current:focus {
                background-color: rgba(70, 70, 70, 0.08);
                color: <?php echo airkit_get_color('general_text_color'); ?>;
            }

            .btn.active{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .mCS-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
                background: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .mCS-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar:hover,
            .mCS-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{
                background: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }

            .ts-tab-container .nav-tabs > li.active a,
            .ts-tab-container .nav-tabs > li.active a:hover,
            .ts-tab-container .nav-tabs > li.active a:focus {
                box-shadow: inset 0 2px 0 <?php echo airkit_get_color('primary_color'); ?>;
            }

            .ts-tab-container .nav-tabs > li.active a, 
            .ts-tab-container .nav-tabs > li.active a:hover, 
            .ts-tab-container .nav-tabs > li.active a:focus,
            .woocommerce div.product .woocommerce-tabs ul.tabs li.active a {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .ts-tab-container.display-vertical .nav-tabs > li.active a,
            .ts-tab-container.display-vertical .nav-tabs > li.active a:hover,
            .ts-tab-container.display-vertical .nav-tabs > li.active a:focus {
                box-shadow: inset 2px 0 0 <?php echo airkit_get_color('primary_color'); ?>;
            }

            .ts-tab-container.display-vertical .nav-tabs > li a:hover {
                box-shadow: inset 2px 0 0 <?php echo airkit_get_color('secondary_color'); ?>;
            }

            .widget .ts-tab-container .nav-tabs > li a:hover,
            .widget .ts-tab-container .nav-tabs > li a:focus,
            .widget .ts-tab-container .nav-tabs > li a:active,
            .widget .ts-tab-container .nav-tabs > li.active a:hover {
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
                box-shadow: none;
            }

            .ts-tags-container > a::after,
            .ts-tags-container a.tag:hover{
                background: <?php echo airkit_get_color('primary_color'); ?>;
            }

            article .is-sticky-div {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .post-content .event-meta-details li i{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .post-author-box .author-articles .author-posts a {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .post-author-box .author-articles .author-posts a:hover {
                color: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }

            .ts-get-calendar.ts-next:hover, .ts-get-calendar.ts-prev:hover {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }

            .ts-event-title a{
                background: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .ts-small-countdown .time-remaining li > span{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }

            .timeline-view header .entry-meta::before{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                border-color: #fff;
            }

            .ts-iconbox-bordered figure figcaption .btn,
            .ts-iconbox-background figure figcaption .btn{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .ts-iconbox-bordered figure figcaption .btn:hover,
            .ts-iconbox-background figure figcaption .btn:hover{
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover'); ?>;
            }
            .airkit_article-accordion .panel-heading .entry-icon{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .single .post-rating .rating-items li .rating-title::before{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .ts-pagination-more{
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .ts-pagination-more::before, .ts-pagination-more::after, .ts-pagination-more span::before, .ts-pagination-more span::after{
                background: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .nav-fillslide a.prev .wrap-icon, .nav-fillslide a.next .wrap-icon {
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: #555;
            }
            .nav-fillslide h3 {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .searchbox.style-icon .search-trigger i.icon-search:hover,
            .searchbox.style-icon .search-close:hover{
                color: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }
            .searchbox .searchbutton {
                background-color: transparent;
                color: inherit;
            }
            .searchbox .searchbutton:hover {
                color: <?php echo airkit_get_color('primary_color'); ?>;
                background-color: transparent;
            }
            .searchbox .hidden-form-search .search-close{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            
            .ts-select-by-category li.active a,
            .ts-select-by-category li.active a {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .archive-title:after {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            #mc4wp_email:active,
            #mc4wp_email:focus{
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .mc4wp-form input[type="submit"]{
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
            }
            .mc4wp-form input[type="submit"]:hover{
                color: <?php echo airkit_get_color('secondary_text_color_hover'); ?>;
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
            }
            .post-tags .tags-container a[rel="tag"]{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .post-tags .tags-container a[rel="tag"]:hover{
                color: <?php echo airkit_get_color('primary_color_hover'); ?>;
            }
            .flickity-page-dots .dot.is-selected{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .fotorama__thumb-border{
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .ts-post-nav .post-nav-content  >  span{
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .mosaic-view article:hover .ts-hover{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            .commentlist > li .comment .comment-metadata .is-sticky-label,
            .is-sticky-div {
                background: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }

            .teams article:hover{
                color: <?php echo airkit_get_color('primary_text_color'); ?>;   
                background: <?php echo airkit_get_color('primary_color'); ?>;                
            }

            .teams article:hover .entry-title{
                color: <?php echo airkit_get_color('primary_text_color'); ?>;   
            }

            .widget_nav_menu .nav-pills > li.active > a, 
            .widget_nav_menu .nav-pills > li.active > a:hover, 
            .widget_nav_menu .nav-pills > li.active > a:focus{
                color: <?php echo airkit_get_color('primary_color'); ?>;    
            }

            .gbtr_dynamic_shopping_bag .count{
                background-color: <?php echo airkit_get_color('primary_color'); ?>;   
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }   
                     
            .gbtr_dynamic_shopping_bag .gbtr_minicart_wrapper a.button {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;   
                color: <?php echo airkit_get_color('primary_text_color'); ?>;                
            }   
            .gbtr_dynamic_shopping_bag .gbtr_minicart_wrapper a.button:hover {
                background-color: <?php echo airkit_get_color('primary_color_hover'); ?>;
                color: <?php echo airkit_get_color('primary_text_color_hover') ?>;
            }
            
            .airkit_tilter-slider ul li.tilter-slider--progress span.progress {
                background-color: #fff;
            }

            .airkit_pricelist .pricelist-item .price,
            .fancybox-slide .pricelist-details .content-wrap-extended .price {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }

            article .image-holder a.post-format-link,
            .single-video .featured-image .vjs-big-play-button,
            .single-format-video .featured-image .vjs-big-play-button,
            .airkit_list-categories .item .entry-title {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            article .image-holder:hover a.post-format-link,
            article .image-holder a.post-format-link:hover {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                box-shadow: 0px 3px 12px <?php echo airkit_rgba_opacity( airkit_get_color('primary_color_hover'), '0.9' ); ?>;
            }
            .single-video .video-figure-content .vjs-big-play-button:hover,
            .single-video .video-figure-content:hover .vjs-big-play-button,
            .single-format-video .vjs-big-play-button:hover,
            .single-format-video .video-figure-content:hover .vjs-big-play-button {
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                box-shadow: 0px 8px 20px <?php echo airkit_rgba_opacity( airkit_get_color('primary_color_hover'), '0.95' ); ?>;
            }
            article.airkit_view-article .entry-content-footer::after,
            .airkit_list-categories figure figcaption .entry-content-footer::after {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .tszf-author-tabs .nav li > a:hover {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .tszf-author-tabs .nav li.active > a::after,
            .tszf-author-tabs .nav li > a:hover::after {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .tszf-form .tszf-multistep-progressbar ul.tszf-step-wizard li.active-step {
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .tszf-form .tszf-multistep-progressbar ul.tszf-step-wizard li.active-step::after {
                border-left-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .tszf-author-tabs .nav li.ts-item-tab-settings.active > a,
            .airkit_frontend-dashboard .tszf-author-sort-posts .dropdown-menu > li.active > a,
            .airkit_frontend-forms .tszf-submit input[type="submit"] {
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .airkit_frontend-forms .tszf-submit input[type="submit"]:hover {
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
                background-color: transparent;
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .airkit_frontend-dashboard .tszf-user-name .social a:hover {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                border-color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .user-element .user-dropdown li.add-post a {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .user-element .user-dropdown li.add-post a:hover {
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
                background-color: <?php echo airkit_get_color('primary_color'); ?>;
                border-style: solid;
            }

            /*
            --------------------------------------------------------------------------------
                4. SECONDARY COLOR
            --------------------------------------------------------------------------------
            */
            .post-edit-link{
                color: <?php echo airkit_get_color('secondary_color'); ?>;
            }
            .post-edit-link:hover{
                color: <?php echo airkit_get_color('secondary_color_hover'); ?>;
                border-color: <?php echo airkit_get_color('secondary_color_hover'); ?>;
            }
            .ts-big-countdown .time-remaining > li > div{
                color: <?php echo airkit_get_color('secondary_color'); ?>;
            }
            .single-event .event-time{
                color: <?php echo airkit_get_color('secondary_color'); ?>;
            }
            article .image-holder .is-featured,
            .airkit_tilter-slider article .is-featured,
            .post-rating-circular .circular-content {
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
            }
            article .image-holder .is-featured::before,
            .post-rating-circular::before {
                border-right-color: <?php echo airkit_get_color('secondary_color'); ?>;
            }
            .big-view .image-right .image-holder .is-featured::before,
            .big-view > .image-mosaic:nth-child(2n) .image-holder .is-featured::before {
                border-left-color: <?php echo airkit_get_color('secondary_color_hover'); ?>;
            }
            .event-list-cal th {
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
                border-color: <?php echo airkit_get_color('secondary_color_hover'); ?>;
                text-shadow: 1px 1px 0 <?php echo airkit_get_color('secondary_color_hover'); ?>;
            }
            .event-list-cal td.today .event-list-cal-day{
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
                text-shadow: 1px 1px 0px <?php echo airkit_get_color('secondary_color_hover'); ?>;
            }
            .widget_list_events .widget-meta .date-event .day{
                color: <?php echo airkit_get_color('secondary_color'); ?>;
            }


            .ts-team-single  .team-categories > li {
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
            }
            
            .woocommerce #content .quantity .minus,
            .woocommerce .quantity .minus,
            .woocommerce-page #content .quantity .minus,
            .woocommerce-page .quantity .minus,
            .woocommerce #content .quantity .plus,
            .woocommerce .quantity .plus,
            .woocommerce-page #content .quantity .plus,
            .woocommerce-page .quantity .plus{
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
            }

            .woocommerce #content div.product p.price,
            .woocommerce #content div.product span.price,
            .woocommerce div.product p.price,
            .woocommerce div.product span.price,
            .woocommerce-page #content div.product p.price,
            .woocommerce-page #content div.product span.price,
            .woocommerce-page div.product p.price,
            .woocommerce-page div.product span.price {
                color: <?php echo airkit_get_color('secondary_color'); ?>;
            }

            .product-view .product span.price ins,
            .product-view .product span.price > span.amount {
                color: <?php echo airkit_get_color('secondary_color'); ?>;
            }

            .ts-callaction a.continue:hover{
                background-color: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
            }

            .ts-pagination ul .page-numbers:hover{
                background: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('primary_text_color'); ?>;
            }
            .purchase-btn{
                color: <?php echo airkit_get_color('secondary_color'); ?>;
            }
            .purchase-btn:hover{
                background: <?php echo airkit_get_color('secondary_color'); ?>;
            }
            .ts-small-countdown .time-remaining li > i{
                color: <?php echo airkit_get_color('secondary_color'); ?>;
            }
            .ts-events-calendar tr td.calendar-day-head{
                background: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;
            }
            .mosaic-images article.button-link header::after,
            .mosaic-images article.button-link .entry-title{
                background: <?php echo airkit_get_color('secondary_color'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;                
            }

            .mosaic-images article.button-link .entry-title:hover{
                background: <?php echo airkit_get_color('secondary_color_hover'); ?>;
                color: <?php echo airkit_get_color('secondary_text_color'); ?>;                
            }

            .ts-featured-area.style-3 .feat-area-thumbs .thumb-item.slick-current header .image-holder::before {
                background-color: <?php echo airkit_rgba_opacity( airkit_get_color('secondary_color'), '0.5' ); ?>;
            }

            /*
            --------------------------------------------------------------------------------
                5. META COLOR
            --------------------------------------------------------------------------------
            */
            .ts-gallery .post-meta .entry-meta-description,
            .single-ts-gallery .post-date .entry-meta-date > li.meta-month,
            .airkit_post-gallery.list-post-gallery .gallery-item .gallery-caption .caption {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .archive-desc p,
            footer .related .related-list .related-content .ts-view-entry-meta-date,
            .airkit_list-users article header span {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .single-event .event-meta > li span.meta{
                color: <?php echo airkit_get_color('meta_color'); ?>;
                font-size: 13px;
            }
            .widget_list_events .widget-meta .date-event .month{
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .ts-team-single .member-content .position{
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }

            .single-post-navigation .navigation i[class*="icon"],
            .single-post-navigation .navigation > li > a > span {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .post-author-box .author-articles h6 {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }

            .airkit_sharing .entry-meta-description,
            .airkit_add-to-favorite .btn-add-to-favorite .entry-meta-description,
            .airkit_add-to-playlist .btn-add-to-playlist .entry-meta-description {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .airkit_sharing .btn-share span.btn-icon-wrap,
            .airkit_add-to-favorite .btn-add-to-favorite,
            .airkit_add-to-playlist .btn-add-to-playlist {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }

            .single .page-subtitle{
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .single .single-meta-sidebar .inner-aside .entry-post-comments a{
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .search-results .searchcount{
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }

            .time-remaining li span{
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }

            .airkit_single-post [class*="term-"] .widegt .touchsize-likes .touchsize-likes-count{
                color: <?php echo airkit_get_color('meta_color'); ?>;   
            }

            .entry-meta,
            .comment-metadata {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .airkit_article-accordion .entry-meta-date{
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .teams article .article-excerpt{
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .post-meta li,
            .post-meta li a,
            .entry-meta a,
            .mosaic-view.mosaic-style-4 article header .entry-meta a {
                color: <?php echo airkit_get_color('meta_color'); ?>;   
            }
            .post-meta li a:hover,
            .entry-meta li a:hover,
            .mosaic-view.mosaic-style-4 article header .entry-meta a:hover,
            .airkit_menu .navbar-default .dropdown-menu article .entry-meta li a:hover {
                color: <?php echo airkit_get_color('primary_color'); ?>;   
            }

            .ts-single-page .page-meta .entry-meta-date,
            .airkit_single-post .post-meta .entry-meta-author > span, 
            .airkit_single-post [class*="term-"] .post-meta .entry-meta-date,
            .playlist-panel .playlist-count,
            .playlist-panel .playlist-repeat,
            .playlist-panel .playlist-shuffle {
                color: <?php echo airkit_get_color('meta_color'); ?>;      
            }
            
            .nav-fillslide div span {
                color: <?php echo airkit_get_color('meta_color'); ?>;
                border-color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .nav-fillslide p {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .widget .count-item,
            .widget-meta li a {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .single-ts-gallery .inner-gallery-container .overlay-effect .entry-overlay .entry-controls > li > a,
            .ts-gallery-element .overlay-effect .entry-overlay .entry-controls > li > a{
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .single-ts-gallery .single_gallery1 .entry-controls > li > a,
            .ts-gallery-element .entry-controls > li > a {
                border-color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .single-ts-gallery .entry-category > li > a {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .single-ts-gallery .inner-gallery-container .overlay-effect .entry-overlay .social-sharing > li > a,
            .ts-gallery-element .overlay-effect .entry-overlay .social-sharing > li > a {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }

            .timeline-view article .entry-meta {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .timeline-view article .entry-meta .entry-month {
                color: <?php echo airkit_get_color('primary_color'); ?>;
            }
            .airkit_menu .navbar-default .dropdown-menu article .entry-meta li a:hover {
                color: <?php echo airkit_get_color('meta_color'); ?>;
                background-color: transparent;
            }

            .airkit_single-post [class*="term-"] .widget .touchsize-likes .touchsize-likes-count::before {
                color: <?php echo airkit_get_color('meta_color'); ?>;   
            }

            .airkit_pricelist .pricelist-item.has-icon .img-wrap i[class*="icon"] {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .product_meta > span,
            .product_meta > span a {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }
            .airkit_frontend-dashboard .tszf-author .author-stats {
                color: <?php echo airkit_get_color('meta_color'); ?>;
            }

            /*
            --------------------------------------------------------------------------------
                6. VIEWS COLOR
            --------------------------------------------------------------------------------
            */
            .post-tags .tags-container a[rel="tag"]:hover{
                background-color: transparent;
            }

            .entry-excerpt,
            .airkit_pricelist .pricelist-item .description,
            .airkit_frontend-dashboard .tszf-author .author-description {
                color: <?php echo airkit_get_color('excerpt_color'); ?>;
            }
        
            article .entry-title,
            .airkit_pricelist .pricelist-item .content-wrap .title {
                color: <?php echo airkit_get_color('title_color'); ?>;
            }
                
            article .entry-title a:hover,
            .airkit_listed-features .icon-box-card .title a:hover,
            .airkit_menu .navbar-default .dropdown-menu li article .entry-title a:hover,
            .airkit_pricelist .pricelist-item .content-wrap a:hover .title {
                color: <?php echo airkit_get_color('title_color_hover'); ?>;
            }


            /*
            --------------------------------------------------------------------------------
                7. MENU COLOR
            --------------------------------------------------------------------------------
            */

            /* Sticky menu colors  */
            .airkit_menu.affix,
            .airkit_menu[class*="menu-element-"].affix .navbar-default .navbar-collapse {
                background-color: <?php echo airkit_option_value( 'general', 'sticky_menu_bg_color' ); ?> !important;
            }

            .airkit_menu.affix .navbar-default .navbar-nav > li > a{
                color: <?php echo airkit_option_value( 'general', 'sticky_menu_text_color' ); ?> !important;
            }

            .airkit_menu.affix .navbar-default .navbar-nav > li > a:hover{
                color: <?php echo airkit_option_value( 'general', 'sticky_menu_text_color_hover' ); ?> !important;
                background-color: <?php echo airkit_option_value( 'general', 'sticky_menu_bg_color_hover' ); ?>!important;
            }

            .airkit_menu.affix[class*="menu-element-"] .navbar-default .navbar-collapse,
            .airkit_menu.affix[class*="menu-element-"] .navbar-default .navbar-collapse > ul > li,
            .airkit_sidebar-menu.affix[class*="menu-element-"] .navbar-default{
                background-color: <?php echo airkit_option_value( 'general', 'sticky_menu_bg_color' ); ?> !important;
            }

        
            .airkit_menu.affix[class*="menu-element-"] .navbar-default .navbar-nav > li,
            .airkit_menu.affix[class*="menu-element-"] .navbar-default .navbar-nav > li > a{
                background-color: <?php echo airkit_option_value( 'general', 'sticky_menu_bg_color' ); ?> !important;
                color: <?php echo airkit_option_value( 'general', 'sticky_menu_text_color' ); ?> !important;
            }
            .airkit_menu.affix[class*="menu-element-"] .navbar-default .navbar-nav > li:hover,
            .airkit_menu.affix[class*="menu-element-"] .navbar-default .navbar-nav > li > a:hover{
                background-color: <?php echo airkit_option_value( 'general', 'sticky_menu_bg_color_hover' ); ?>!important;
                color: <?php echo airkit_option_value( 'general', 'sticky_menu_text_color_hover' ); ?> !important;
            }

            /* Font sizes options */
            @media screen and (min-width: 960px) {
                /* Single post title sizes */
                .entry-title.post-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'single_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'single_title_size' ) + 8; ?>px;
                }
                .entry-title.page-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'page_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'page_title_size' ) + 8; ?>px;
                }
                .entry-title.single-gallery-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'gallery_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'gallery_title_size' ) + 8; ?>px;
                }
                .entry-title.single-video-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'video_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'video_title_size' ) + 8; ?>px;
                }
                .grid-view article .entry-title,
                .airkit_post-gallery.grid-post-gallery .gallery-caption .title {
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'grid_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'grid_title_size' ) + 6; ?>px;
                }
                .col-lg-8 .grid-view article .entry-title {
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'grid_title_size' ) - 3; ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'grid_title_size' ); ?>px;
                }
                .list-view article .entry-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'list_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'list_title_size' ) + 6; ?>px;
                }
                .thumbnail-view article .entry-title,
                .airkit_menu-articles article .entry-title {
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'thumbnail_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'thumbnail_title_size' ) + 6; ?>px;
                }
                .thumbnail-view.cols-by-6 article .entry-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'thumbnail_title_size' ) - 5; ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'thumbnail_title_size' ) + 1; ?>px;
                }
                .col-lg-12 .thumbnail-view.cols-by-2 article .entry-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'thumbnail_title_size' ) + 3; ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'thumbnail_title_size' ) + 8; ?>px;
                }
                .col-lg-9 .thumbnail-view article .entry-title,
                .col-lg-8 .thumbnail-view article .entry-title,
                .col-lg-7 .thumbnail-view article .entry-title {
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'thumbnail_title_size' ) - 2; ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'thumbnail_title_size' ) + 1; ?>px;
                }
                .site-section.airkit_expanded-row .thumbnail-view article .entry-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'thumbnail_title_size' ) + 8; ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'thumbnail_title_size' ) + 12; ?>px;
                }
                .mosaic-view article .entry-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'mosaic_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'mosaic_title_size' ) + 6; ?>px;
                }
                .mosaic-view.mosaic-style-3 .is-big article .entry-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'mosaic_title_size' ) + 12; ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'mosaic_title_size' ) + 18; ?>px;
                }

                .timeline-view article .entry-title,
                .timeline-view article header .neighborhood .entry-post-date time {
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'timeline_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'timeline_title_size' ) + 6; ?>px;
                }
                /* Big posts view */
                .big-view .big-posts-entry article .entry-title,
                .airkit_post-gallery.list-post-gallery .gallery-caption .title {
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'bigpost_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'bigpost_title_size' ) + 6; ?>px;
                }
                .col-lg-8 .big-view .big-posts-entry article .entry-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'bigpost_title_size' ) - 3; ?>px;
                }
                .col-lg-6 .big-view .big-posts-entry article .entry-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'bigpost_title_size' ) - 12; ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'bigpost_title_size' ) - 12; ?>px;
                }

                .super-view article > header .entry-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'super_title_size' ); ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'super_title_size' ) + 6; ?>px;
                }

                .airkit_expanded-row .mosaic-view:not(.mosaic-rectangles) article .entry-title{
                    font-size: <?php echo airkit_option_value( 'typography', 'extra', 'mosaic_title_size' ) + 4; ?>px;
                    line-height: <?php echo airkit_option_value( 'typography', 'extra', 'mosaic_title_size' ) + 6; ?>px;
                    max-height: 2.1em;
                }
            }
            <?php
                echo airkit_get_custom_fonts_css();
                echo airkit_custom_background();
                echo airkit_term_colors();
            ?>

            /* --- Custom CSS Below ----  */
            <?php echo airkit_inline_style() ?>
            
        <?php
        // Get all custom generated styles from theme options in variable
        $airkit_custom_generated_styles = ob_get_clean();
        
        wp_add_inline_style( 'gowatch-style', $airkit_custom_generated_styles );
    }
}

if ( ! function_exists('airkit_inline_style') ) {

    function airkit_inline_style() {
        $option = airkit_option_value( 'css', 'custom_css' );

        if( function_exists('bp_is_active') ) {
            $option .= '
                #buddypress #item-nav .item-list-tabs {
                    position: relative;
                    border-bottom: 1px solid rgba(60, 60, 60, 0.08);
                    text-align: left;
                }
                #buddypress #item-nav .item-list-tabs > ul > li {
                    display: inline-block;
                    position: relative;
                    border-color: rgba(60, 60, 60, 0.08);
                    border-style: solid;
                    border-right-width: 1px;
                    border-top-width: 1px;
                    float: none;
                }
                #buddypress #item-nav .item-list-tabs > ul > li:first-child {
                    border-left-width: 1px;
                }
                #buddypress #item-nav .item-list-tabs > ul > li a {
                    border-radius: 0;
                    margin: 0;
                    font-weight: bold;
                    text-align: center;
                    padding: 0.5em 1em;
                    border: none;
                    outline: 0;
                    color: inherit;
                    padding: .8em 2.5em;

                    -webkit-transition: box-shadow .3s ease;
                    -o-transition: box-shadow .3s ease;
                    transition: box-shadow .3s ease;
                }
                #buddypress #item-body {
                    padding: 20px;
                    border: 1px solid rgba(60, 60, 60, 0.08);
                    border-top-color: transparent;
                    margin-top: -1px;
                }
                #buddypress #item-nav .item-list-tabs > ul > li.selected a,
                #buddypress #item-nav .item-list-tabs > ul > li.selected a:hover,
                #buddypress #item-nav .item-list-tabs > ul > li.selected a:focus {
                    outline: 0;
                    background-color: transparent;
                    color: '. airkit_get_color('primary_color') .';
                    box-shadow: inset 0 2px 0 '. airkit_get_color('primary_color') .';
                }
                #buddypress #item-nav .item-list-tabs > ul > li a:hover {
                    outline: 0;
                    background-color: transparent;
                    box-shadow: inset 0 2px 0 '. airkit_get_color('secondary_color') .';
                }
                #buddypress #subnav ul > li {
                    margin-right: 5px;
                }
                #buddypress #subnav ul > li a {
                    background-color: #e1e1e1;
                    color: #5a5a5a;
                }
                #buddypress #subnav ul > li a:hover,
                #buddypress #subnav ul > li.selected a {
                    background-color: '. airkit_get_color('secondary_color') .';
                    color: '. airkit_get_color('secondary_text_color') .';
                }
            ';
        }

        return stripslashes( $option );
    }

}


if ( ! function_exists('airkit_has_sidebar') ) {
    function airkit_has_sidebar( $post_ID, $options = array() ) {
        // Get post type
        $airkit_post_type = get_post_type( $post_ID );
        $post_types = array('post', 'video', 'ts-gallery', 'event');

        $build = isset($options['build-sidebar']) ? $options['build-sidebar'] : true;

        if ( in_array( $airkit_post_type, $post_types ) ) {
            $airkit_post_type = 'single';
        }

        $airkit_sidebar = airkit_Compilator::build_sidebar( $airkit_post_type, $post_ID, $build );

        if ( isset( $airkit_sidebar['left'] ) && $airkit_sidebar['left'] != '' ) {
            $option = 'left';
        } elseif ( isset( $airkit_sidebar['right'] ) && $airkit_sidebar['right'] != '' ) {
            $option = 'right';
        } else {
            $option = 'none';
        }

        return $option;
    }
}

/* register sidebars */
if ( function_exists( 'register_sidebar' ) ) {

    register_sidebar( array(
        'name' => esc_html__( 'Main Sidebar', 'gowatch' ),
        'id' => 'main',
        'before_widget' => '<div id="%1$s" class="widget ts_widget %2$s"><div class="widget-content">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h6 class="widget-title airkit_sidebar_title"><span>',
        'after_title'   => '</span></h6><div class="widget-delimiter"></div>'
    ));
    // Footer 1 sidebar
    register_sidebar( array(
        'name' => esc_html__( 'Footer 1', 'gowatch' ),
        'id' => 'footer1',
        'before_widget' => '<div id="%1$s" class="widget ts_widget %2$s"><div class="widget-content">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h6 class="widget-title airkit_sidebar_title"><span>',
        'after_title'   => '</span></h6><div class="widget-delimiter"></div>'
    ));
    // Footer 2 sidebar
    register_sidebar( array(
        'name' => esc_html__( 'Footer 2', 'gowatch' ),
        'id' => 'footer2',
        'before_widget' => '<div id="%1$s" class="widget ts_widget %2$s"><div class="widget-content">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h6 class="widget-title airkit_sidebar_title"><span>',
        'after_title'   => '</span></h6><div class="widget-delimiter"></div>'
    ));
    // Footer 3 sidebar
    register_sidebar( array(
        'name' => esc_html__( 'Footer 3', 'gowatch' ),
        'id' => 'footer3',
        'before_widget' => '<div id="%1$s" class="widget ts_widget %2$s"><div class="widget-content">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h6 class="widget-title airkit_sidebar_title"><span>',
        'after_title'   => '</span></h6><div class="widget-delimiter"></div>'
    ));
    // Footer 4 sidebar
    register_sidebar( array(
        'name' => esc_html__( 'Footer 4', 'gowatch' ),
        'id' => 'footer4',
        'before_widget' => '<div id="%1$s" class="widget ts_widget %2$s"><div class="widget-content">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<h6 class="widget-title airkit_sidebar_title"><span>',
        'after_title'   => '</span></h6><div class="widget-delimiter"></div>'
    ));

    /**
     * Dynamic sidebars initialization
     */
    add_action('init', 'airkit_init_dynamic_sidebars');

    function airkit_init_dynamic_sidebars() {
        $sidebars = ( $sidebars = get_option('gowatch_sidebars') ) && is_array( $sidebars ) ? $sidebars : array();

        if ( ! empty( $sidebars ) ) {

            foreach ( $sidebars as $id => $sidebar ) {

                $sidebar_class = '';

                register_sidebar(
                    array(
                        'id'            => $id,
                        'name'          => $sidebar,
                        'before_widget' => '<div id="%1$s" class="widget ts_widget ' . $sidebar_class . ' %2$s"><div class="widget-content">',
                        'after_widget'  => '</div></div>',
                        'before_title'  => '<h6 class="widget-title airkit_sidebar_title"><span>',
                        'after_title'   => '</span></h6><div class="widget-delimiter"></div>',
                    )
                );

            }
        }
    }
}


function airkit_get_views( $post_ID, $show = true ) {

    $count = get_post_meta($post_ID, 'airkit_views', true);

    if ( $count == '' ) {
        // airkit_set_post_views($post_ID);
        $count = 0;
    }

    if ( $show == true ) {
        echo (int)$count;
    } else {
        return $count;
    }
}

function airkit_get_reading_time( $post_ID, $echo = false ) {
    // Words per minute
    $wpm = 300;

    $rtContent = get_post_field('post_content', $post_ID);
    $strippedContent = strip_shortcodes($rtContent);
    $stripTagsContent = strip_tags($strippedContent);
    $wordCount = str_word_count($stripTagsContent);
    $readingTime = ceil($wordCount / $wpm);

    if ( $readingTime <= 1 ) {
        $readingTime = 1;
    }

    if ( $echo ) {
        echo (float)$readingTime;
    } else {
        return (float)$readingTime;
    }

}


if( function_exists('ts_enc_string') ) {

    /*
     * Add 'Featured' column for admin posts listings.
     */
    function airkit_add_custom_true( $columns ) {

        $add_column_for = array( 'video', 'ts-gallery', 'post', 'event' );

        $post_type = get_post_type(get_the_ID());

        if ( in_array( $post_type , $add_column_for ) ) {

            $columns['featured_article'] = 'Featured';

        }

        return $columns;
    }

    add_filter('manage_posts_columns', 'airkit_add_custom_true', 10, 1);



    /*
     * 'Featured' column template.
     */
    add_action('manage_posts_custom_column', 'airkit_columns_content_featured', 10, 2);

    function airkit_columns_content_featured( $columnName, $post_ID ) {

        $add_column_for = array( 'video', 'ts-gallery', 'post', 'event' );

        $post_type = get_post_type( $post_ID );

        if ( in_array( $post_type, $add_column_for ) && $columnName == 'featured_article' ) {

            $meta_values = get_post_meta( $post_ID, 'featured', true );
            $selected = $meta_values == 'yes' ? 'checked' : '';

            echo '<input type="checkbox"'. $selected .' name="featured_article" class="featured" value="'. $post_ID .'">';
            echo '<input type="hidden" value="updateFeatures" />';

        }
    }
}

//get the pagination in single item
if ( !function_exists( 'airkit_get_pagination_next_previous' ) ) {

    function airkit_get_pagination_next_previous() {

        $next_post = get_next_post();
        $prev_post = get_previous_post();
        
        if ( ! empty($prev_post) || ! empty($next_post) ): ?>
            
            <nav class="single-post-navigation">

                <ul class="navigation">
                    
                    <?php if ( !empty( $prev_post ) ) :  ?>
                        <li class="airkit_post-nav">        
                            <a class="page-prev" href="<?php echo get_permalink($prev_post->ID, false); ?>">
                                <i class="icon-left"></i>
                                <span><?php echo esc_html_e('Previous post', 'gowatch'); ?></span>
                                <h4><?php echo get_the_title( $prev_post->ID ) ?></h4>
                            </a>        
                        </li>
                    <?php endif; ?>
                    <?php if ( !empty( $next_post ) ) : ?>
                        <li class="airkit_post-nav">        
                            <a class="page-next" href="<?php echo get_permalink( $next_post->ID, false ); ?>">
                                <i class="icon-right"></i>
                                <span><?php esc_html_e('Next post','gowatch') ?></span>
                                <h4><?php echo get_the_title( $next_post->ID ) ?></h4>
                            </a>        
                        </li>
                    <?php endif; ?>    

                </ul>

            </nav>

        <?php

        endif;

    } //end function airkit_get_pagination_next_previous()
}

function airkit_breadcrumbs() {

    global $post;

    if ( is_front_page() ) {
        return;
    }

    // Settings
    $separator          = '<i class="icon-right-arrow"></i>';
    $breadcrums_id      = 'airkit_breadcrumbs';
    $breadcrums_class   = 'airkit_breadcrumbs';
    $home_title         = esc_html__('Home', 'gowatch');
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $post_type    = get_post_type( $post->ID );

    switch ($post_type) {
        case 'video':
            $custom_taxonomy = 'videos_categories';
            break;
        
        case 'ts-gallery':
            $custom_taxonomy = 'gallery_categories';
            break;
        
        case 'ts-portfolio':
            $custom_taxonomy = 'portfolios';
            break;
        
        case 'post':
            $custom_taxonomy = 'cat';
            break;
        
        default:
            $custom_taxonomy = 'cat';
            break;
    }
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type($post->ID);
              
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end($category);
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }

}

function airkit_get_comment_count( $post_ID ) {

    if (airkit_option_value('general', 'comment_system') == 'facebook' ) {

        return '<fb:comments-count href="' . get_permalink($post_ID) .'"></fb:comments-count>';

    } else {

        return get_comments_number($post_ID);

    }
    
}

add_action( 'wp_ajax_ts_draw_calendar', 'airkit_draw_calendar_callback' );
add_action( 'wp_ajax_nopriv_ts_draw_calendar', 'airkit_draw_calendar_callback' );

function airkit_draw_calendar_callback( $month_layout = NULL, $year_layout = NULL, $size_layout = NULL, $nonce_layout = NULL ) {

    if ( isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'security') ) {
        return;
    }

    if ( isset($nonce_layout) && !wp_verify_nonce($nonce_layout, 'security') ) {
        return;
    }

    if (isset($_POST['tsYear'], $_POST['tsMonth']) ) {
        $month = (int)$_POST['tsMonth'];
        if ( strlen($month) == 1 ) $month = '0' . $month;
        $year = (int)$_POST['tsYear'];
        $class_size = (isset($_POST['size']) && ($_POST['size'] == 'ts-big-calendar' || $_POST['size'] == 'ts-small-calendar')) ? $_POST['size'] : 'ts-big-calendar';
    }

    if ( isset($month_layout, $year_layout, $size_layout) ) {
        $month = $month_layout;
        $year = $year_layout;
        $class_size = $size_layout;
    }

    $month_prev = ($month == 1) ? 12 : $month - 1;
    $month_next = ($month == 12) ? 1 : $month + 1;
    $year_next = ($month == 12) ? $year + 1 : $year;
    $year_prev = ($month == 1) ? $year - 1 : $year;
    if ( strlen($month_prev) == 1 ) $month_prev = '0' . $month_prev;
    if ( strlen($month_next) == 1 ) $month_next = '0' . $month_next;
    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));

    $calendar = '<h3 class="ts-calendar-title">'. date('F', mktime(0, 0, 0, $month, 10)) . '<span> ' . $year . '</span>' . '</h3>';
    $calendar .= '<a class="ts-get-calendar ts-prev" data-month="' . $month_prev . '" data-year="' . $year_prev . '" href="#">' . esc_html__('Prev month', 'gowatch') . '</a><a class="ts-get-calendar ts-next" data-month="' . $month_next . '" data-year="' . $year_next . '" href="#">' . esc_html__('Next month', 'gowatch') . '</a>';
    $calendar .= '<table cellpadding="0" cellspacing="0" class="ts-events-calendar ' . $class_size . '">';

    $headings = array(esc_html__('Sunday', 'gowatch'), esc_html__('Monday', 'gowatch'), esc_html__('Tuesday', 'gowatch'), esc_html__('Wednesday', 'gowatch'), esc_html__('Thursday', 'gowatch'), esc_html__('Friday', 'gowatch'), esc_html__('Saturday', 'gowatch'));

    $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

    $events = array();
    $args = array(
        'post_type'      => 'event',
        'posts_per_page' => -1,
        );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) { $query->the_post();

            $day = get_post_meta(get_the_ID(), 'day', true);
            $day = (isset($day) && (int)$day !== 0) ? date('Y-m-d', (int)$day) : NULL;

            if ( isset($day) ) {

                $permalink = get_permalink(get_the_ID());
                $title     = get_the_title(get_the_ID());
                $excerpt   = get_the_excerpt();

                $post_meta = get_post_meta(get_the_ID(), 'event', true);
                $start_end = (isset($post_meta['start-time'], $post_meta['end-time'])) ? $post_meta['start-time'] . ' - ' . $post_meta['end-time'] : '';
                $repeat    = (isset($post_meta['event-enable-repeat']) && ($post_meta['event-enable-repeat'] == 'y' || $post_meta['event-enable-repeat'] == 'n')) ? $post_meta['event-enable-repeat'] : '';
                $repeat_in = (isset($post_meta['event-repeat']) && ($post_meta['event-repeat'] == '1' || $post_meta['event-repeat'] == '2' || $post_meta['event-repeat'] == '3') ) ? $post_meta['event-repeat'] : '';
                $end_day   = (isset($post_meta['event-end']) &&  (int)strtotime($post_meta['event-end']) !== 0) ? $post_meta['event-end'] : '';

                $date_start = date_create($day);
                $date_end   = date_create($end_day);
                $event_days = date_diff($date_start, $date_end);
                $event_days = $event_days->days + 1;
                $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));

                if ( $post_meta['event-enable-repeat'] == 'n' ) {
                    for ($i = 0; $i < 3; $i++) {
                        for ($k = 0; $k < $event_days; $k++) {
                            if ( isset($events[date('Y-m-d', strtotime($day) + ($k * 86400))]) ) {
                                if ( !in_array( array('title' => $title, 'permalink' => $permalink, 'excerpt' => $excerpt, 'start-end' => $start_end, 'repeat' => $repeat, 'repeat_in' => $repeat_in, 'event-end' => $end_day), $events[date('Y-m-d', strtotime($day) + ($k*86400))] ) ) {

                                    array_push($events[date('Y-m-d', strtotime($day) + ($k*86400))], array(
                                        'title'     => $title,
                                        'permalink' => $permalink,
                                        'excerpt'   => $excerpt,
                                        'start-end' => $start_end,
                                        'repeat'    => $repeat,
                                        'repeat_in' => $repeat_in,
                                        'event-end' => $end_day
                                        ));
                                }
                            } else {
                                $events[date('Y-m-d', strtotime($day) + ($k*86400) )] = array(array(
                                    'title'     => $title,
                                    'permalink' => $permalink,
                                    'excerpt'   => $excerpt,
                                    'start-end' => $start_end,
                                    'repeat'    => $repeat,
                                    'repeat_in' => $repeat_in,
                                    'event-end' => $end_day
                                    ));
                            }
                        }
                    }
                }
                if ( $post_meta['event-enable-repeat'] == 'y' && $post_meta['event-repeat'] == '1' ) {
                    for ($i=0; $i < 500; $i++) {
                        if ( isset($events[date('Y-m-d', strtotime($day) + 86400 * 7 * $i)]) ) {
                            if ( !in_array(array('title' => $title, 'permalink' => $permalink, 'excerpt' => $excerpt, 'start-end' => $start_end, 'repeat' => $repeat, 'repeat_in' => $repeat_in, 'event-end' => $end_day), $events[date('Y-m-d', strtotime($day) + 86400 * 7 * $i)]) ) {
                                array_push($events[date('Y-m-d', strtotime($day) + 86400 * 7 * $i)], array(
                                    'title'     => $title,
                                    'permalink' => $permalink,
                                    'excerpt'   => $excerpt,
                                    'start-end' => $start_end,
                                    'repeat'    => $repeat,
                                    'repeat_in' => $repeat_in,
                                    'event-end' => $end_day
                                    ));
                            }
                        } else {
                            $events[date('Y-m-d', strtotime($day) + 86400 * 7 * $i)] = array(array(
                                'title'     => $title,
                                'permalink' => $permalink,
                                'excerpt'   => $excerpt,
                                'start-end' => $start_end,
                                'repeat'    => $repeat,
                                'repeat_in' => $repeat_in,
                                'event-end' => $end_day
                                ));
                        }
                        for ($k=1; $k < $event_days; $k++) {
                            if ( isset($events[date('Y-m-d', strtotime($day) + (86400 * 7)* $i + ($k*86400) )]) ) {
                                if ( !in_array( array('title' => $title, 'permalink' => $permalink, 'excerpt' => $excerpt, 'start-end' => $start_end, 'repeat' => $repeat, 'repeat_in' => $repeat_in, 'event-end' => $end_day), $events[date('Y-m-d', strtotime($day) + (86400 * 7)* $i + ($k*86400) )]) ) {
                                    array_push($events[date('Y-m-d', strtotime($day) + (86400 * 7)* $i + ($k*86400) )], array(
                                        'title'     => $title,
                                        'permalink' => $permalink,
                                        'excerpt'   => $excerpt,
                                        'start-end' => $start_end,
                                        'repeat'    => $repeat,
                                        'repeat_in' => $repeat_in,
                                        'event-end' => $end_day
                                        ));
                                }
                            } else {
                                $events[date('Y-m-d', strtotime($day) + (86400 * 7)* $i + ($k*86400) )] = array(array(
                                    'title'     => $title,
                                    'permalink' => $permalink,
                                    'excerpt'   => $excerpt,
                                    'start-end' => $start_end,
                                    'repeat'    => $repeat,
                                    'repeat_in' => $repeat_in,
                                    'event-end' => $end_day
                                    ));
                            }
                        }
                    }
                }
                if ( $post_meta['event-enable-repeat'] == 'y' && $post_meta['event-repeat'] == '2' ) {
                    for ($i=0; $i < 500; $i++) {
                        if ( isset($events[date('Y-m-d', strtotime("+".$i." month",strtotime($day)))]) ) {
                            if ( !in_array( array('title' => $title, 'permalink' => $permalink, 'excerpt' => $excerpt, 'start-end' => $start_end, 'repeat' => $repeat, 'repeat_in' => $repeat_in, 'event-end' => $end_day), $events[date('Y-m-d', strtotime("+".$i." month",strtotime($day)))]) ) {
                                array_push($events[date('Y-m-d', strtotime("+".$i." month",strtotime($day)))], array(
                                    'title'     => $title,
                                    'permalink' => $permalink,
                                    'excerpt'   => $excerpt,
                                    'start-end' => $start_end,
                                    'repeat'    => $repeat,
                                    'repeat_in' => $repeat_in,
                                    'event-end' => $end_day
                                    ));
                            }
                        } else {
                            $events[date('Y-m-d', strtotime("+".$i." month",strtotime($day)))] = array(array(
                                'title'     => $title,
                                'permalink' => $permalink,
                                'excerpt'   => $excerpt,
                                'start-end' => $start_end,
                                'repeat'    => $repeat,
                                'repeat_in' => $repeat_in,
                                'event-end' => $end_day
                                ));
                        }
                        for ($k=1; $k < $event_days; $k++) {
                            $current_date = date('Y-m-d', strtotime("+".$i." month",strtotime($day)));
                            if ( isset($events[date('Y-m-d', strtotime("+".$k." days",strtotime($current_date )))]) ) {
                                if ( !in_array( array('title' => $title, 'permalink' => $permalink, 'excerpt' => $excerpt, 'start-end' => $start_end, 'repeat' => $repeat, 'repeat_in' => $repeat_in, 'event-end' => $end_day), $events[date('Y-m-d', strtotime("+".$k." days",strtotime($current_date )))]) ) {
                                    array_push($events[date('Y-m-d', strtotime("+".$k." days",strtotime($current_date )))], array(
                                        'title'     => $title,
                                        'permalink' => $permalink,
                                        'excerpt'   => $excerpt,
                                        'start-end' => $start_end,
                                        'repeat'    => $repeat,
                                        'repeat_in' => $repeat_in,
                                        'event-end' => $end_day
                                        ));
                                }
                            } else {
                                $events[date('Y-m-d', strtotime("+".$k." days",strtotime($current_date )))] = array(array(
                                    'title'     => $title,
                                    'permalink' => $permalink,
                                    'excerpt'   => $excerpt,
                                    'start-end' => $start_end,
                                    'repeat'    => $repeat,
                                    'repeat_in' => $repeat_in,
                                    'event-end' => $end_day
                                    ));
                            }
                        }
                    }
                }
                if ( $post_meta['event-enable-repeat'] == 'y' && $post_meta['event-repeat'] == '3' ) {
                    for ($i=0; $i < 500; $i++) {
                        if ( isset($events[date('Y-m-d', strtotime("+".$i." year",strtotime($day)))]) ) {
                            if ( !in_array( array('title' => $title, 'permalink' => $permalink, 'excerpt' => $excerpt, 'start-end' => $start_end, 'repeat' => $repeat, 'repeat_in' => $repeat_in, 'event-end' => $end_day), $events[date('Y-m-d', strtotime("+".$i." year",strtotime($day)))]) ) {
                                array_push($events[date('Y-m-d', strtotime("+".$i." year",strtotime($day)))], array(
                                    'title'     => $title,
                                    'permalink' => $permalink,
                                    'excerpt'   => $excerpt,
                                    'start-end' => $start_end,
                                    'repeat'    => $repeat,
                                    'repeat_in' => $repeat_in,
                                    'event-end' => $end_day
                                    ));
                            }
                        } else {
                            $events[date('Y-m-d', strtotime("+".$i." year",strtotime($day)))] = array(array(
                                'title'     => $title,
                                'permalink' => $permalink,
                                'excerpt'   => $excerpt,
                                'start-end' => $start_end,
                                'repeat'    => $repeat,
                                'repeat_in' => $repeat_in,
                                'event-end' => $end_day
                                ));
                        }
                        for ($k=1; $k < $event_days; $k++) {
                            $current_date = date('Y-m-d', strtotime("+".$i." year",strtotime($day)));
                            if ( isset($events[date('Y-m-d', strtotime("+".$k." days",strtotime($current_date )))]) ) {
                                if ( !in_array( array('title' => $title, 'permalink' => $permalink, 'excerpt' => $excerpt, 'start-end' => $start_end, 'repeat' => $repeat, 'repeat_in' => $repeat_in, 'event-end' => $end_day), $events[date('Y-m-d', strtotime("+".$k." days",strtotime($current_date )))]) ) {
                                    array_push($events[date('Y-m-d', strtotime("+".$k." days",strtotime($current_date )))], array(
                                        'title'     => $title,
                                        'permalink' => $permalink,
                                        'excerpt'   => $excerpt,
                                        'start-end' => $start_end,
                                        'repeat'    => $repeat,
                                        'repeat_in' => $repeat_in,
                                        'event-end' => $end_day
                                        ));
                                }
                            } else {
                                $events[date('Y-m-d', strtotime("+".$k." days",strtotime($current_date )))] = array(array(
                                    'title'     => $title,
                                    'permalink' => $permalink,
                                    'excerpt'   => $excerpt,
                                    'start-end' => $start_end,
                                    'repeat'    => $repeat,
                                    'repeat_in' => $repeat_in,
                                    'event-end' => $end_day
                                    ));
                            }
                        }
                    }
                }

                if ( $repeat == 'y' && $repeat_in == '1' ) {
                    $day_next = strtotime($day);

                    for($i = 0; $i < $event_days; $i++) {
                        $start_day = date('Y-m-d', $day_next + (86400 * $i));

                        if ( isset($events[$start_day]) ) {
                            if ( in_array(array('title' => $title, 'permalink' => $permalink, 'excerpt' => $excerpt, 'start-end' => $start_end, 'repeat' => $repeat, 'repeat_in' => $repeat_in, 'event-end' => $end_day), $events[$start_day]) ) {

                                array_push($events[$start_day], array(
                                    'title'     => $title,
                                    'permalink' => $permalink,
                                    'excerpt'   => $excerpt,
                                    'start-end' => $start_end,
                                    'repeat'    => $repeat,
                                    'repeat_in' => $repeat_in,
                                    'event-end' => $end_day
                                    )
                                );
                            }

                        } else {
                            $events[$start_day] = array(array(
                                'title'     => $title,
                                'permalink' => $permalink,
                                'excerpt'   => $excerpt,
                                'start-end' => $start_end,
                                'repeat'    => $repeat,
                                'repeat_in' => $repeat_in,
                                'event-end' => $end_day
                                )
                            );
                        }
                    }
                }
            }
        }
    }

    $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
    $days_in_this_week = 1;
    $day_counter = 0;
    $dates_array = array();

    $calendar .= '<tr class="ts-calendar-row">';

    for($x = 0; $x < $running_day; $x++):
        $calendar .= '<td class="ts-calendar-day-np">&nbsp;</td>';
    $days_in_this_week++;
    endfor;

    for($list_day = 1; $list_day <= $days_in_month; $list_day++) :
        $calendar .= '<td class="ts-calendar-day">';

    $calendar .= '<div class="ts-day-number">' . $list_day . '</div>';
    if ( strlen($list_day) == 1 ) $list_day = '0'.$list_day;
    $event_day = $year . '-' . $month . '-' . $list_day;

    if (isset($events[$event_day]) ) {
        foreach($events[$event_day] as $event) {
            $calendar .= '<div class="ts-event-title"><a href="'.$event['permalink'].'">' . $event['title'] . '</a>';
            $calendar .= '<div class="ts-event-details-hover"><div class="ts-event-time">'.$event['start-end'].'</div>';
            $calendar .= '<div class="ts-event-excerpt">'.$event['excerpt'].'</div></div></div>';
            if ( $event['repeat'] == 'y' && $event['repeat_in'] == '1' ) {
                $events[date('Y-m-d', strtotime($event_day) + 86400 * 7)] = array($event);
            }
            if ( $event['repeat'] == 'y' && $event['repeat_in'] == '2' ) {
                $events[date('Y-m-d', strtotime($event_day) + 86400 * $days_in_month)] = array($event);
            }
            if ( $event['repeat'] == 'y' && $event['repeat_in'] == '3' ) {
                $events[date('Y-m-d', strtotime($event_day) + 86400 * date("z", mktime(0,0,0,12,31,$year)) + 1)] = array($event);
            }
        }
    }
    else {
        $calendar .= str_repeat('', 2);
    }
    $calendar.= '</td>';
    if ($running_day == 6):
        $calendar.= '</tr>';
    if (($day_counter + 1) != $days_in_month):
        $calendar.= '<tr class="calendar-row">';
    endif;
    $running_day = -1;
    $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
    endfor;

    if ($days_in_this_week < 8):
        for($x = 1; $x <= (8 - $days_in_this_week); $x++):
            $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
        endfor;
        endif;

        $calendar.= '</tr>';

        $calendar.= '</table>';

        $calendar = str_replace('</td>','</td>'."\n",$calendar);
        $calendar = str_replace('</tr>','</tr>'."\n",$calendar);

        if (isset($_POST['tsYear'], $_POST['tsMonth']) ) {
            echo airkit_var_sanitize($calendar, 'the_kses');
        } else {
            return $calendar;
        }

        die();
    }

    function airkit_attachment_field_url( $form_fields, $post ) {

        $form_fields['ts-image-url'] = array(
            'label' => 'Image url',
            'input' => 'text',
            'value' => get_post_meta($post->ID, 'ts-image-url', true),
            'helps' => '',
            );

        return $form_fields;
    }
    add_filter( 'attachment_fields_to_edit', 'airkit_attachment_field_url', 10, 2 );

    function airkit_attachment_field_url_save( $post, $attachment ) {
        if ( isset( $attachment['ts-image-url'] ) )
            update_post_meta($post['ID'], 'ts-image-url', $attachment['ts-image-url']);
        return $post;
    }

    add_filter('attachment_fields_to_save', 'airkit_attachment_field_url_save', 10, 2);

    add_filter( 'wp_title', 'airkit_filter_wp_title' );
/**
 * Filters the page title appropriately depending on the current page
 *
 * This function is attached to the 'wp_title' fiilter hook.
 *
 * @uses    get_bloginfo()
 * @uses    is_home()
 * @uses    is_front_page()
 */
function airkit_filter_wp_title( $title ) {
    global $page, $paged;

    if ( is_feed() )
        return $title;

    $site_description = get_bloginfo( 'description' );

    $filtered_title = (is_singular() && !is_front_page()) ? $title . ' | ' . get_bloginfo( 'name' ) : '';
    $filtered_title .= (!empty($site_description) && (is_home() || is_front_page())) ? get_bloginfo( 'name' ) . ' | ' . $site_description : ' ';
    $filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( esc_html__( 'Page %s', 'gowatch' ), max( $paged, $page ) ) : '';

    return $filtered_title;
}

function airkit_get_rating( $post_ID ) {

    if ( is_numeric($post_ID) ) {
        $rating_items = get_post_meta($post_ID, 'ts_post_rating', TRUE);
        if ( isset($rating_items) && is_array($rating_items) && !empty($rating_items) ) {
            $total = '';
            foreach($rating_items as $rating) {
                $total += $rating['rating_score'];
            }
            if ( $total > 0 ) {
                $round = intval($total) / count($rating_items);
                $result = round($round, 1);

                if ( is_int($round) ) {
                    if ( $round == 10 ) return $result;
                    else return $result . '.0';
                } else {
                    return $result;
                }
            } else {
                return;
            }
        }
    } else {
        return;
    }

}

function airkit_var_sanitize($content, $method = 'true') {

    switch ($method) {

        case 'sanitize_title':
        return sanitize_title($content);
        break;

        case 'sanitize_text':
        return sanitize_text_field($content);
        break;

        case 'sanitize_html_class':
        return sanitize_html_class($content);
        break;

        case 'balanceTags':
        return balanceTags($content, true);
        break;

        case 'esc_attr':
        return esc_attr($content, true);
        break;

        case 'esc_url':
        return esc_url($content);
        break;

        case 'esc_js':
        return esc_js($content);
        break;

        case 'true':
        return $content;
        break;

        case 'esc_url_raw':
        return esc_url_raw($content);
        break;

        case 'absint':
        return absint($content);
        break;

        case 'esc_textarea':
        return esc_url_raw($content);
        break;

        case 'the_kses':

        $default_attribs = array(
            'id' => array(),
            'class' => array(),
            'title' => array(),
            'style' => array(),
            'src'   => array(),
            'alt'   => array(),
            'title'   => array(),
            'data'    => array(),
            'rel'     => array(),
            'width'   => array(),
            'height'  => array(),
            'data-mce-id' => array(),
            'data-mce-style' => array(),
            'data-mce-bogus' => array(),
            'data-original'  => array(),
            'data-element-type' => array(),
            'data-sortable'     => array(),
            'data-size'         => array(),
            'data-ts-tab'       => array(),
            'data-location'     => array(),
            'data-add-columns'  => array(),
            'data-template-id'  => array(),
            'data-subsets'      => array(),
            'data-id'           => array(),
            'data-variants'     => array(),
            'data-dismiss'      => array(),
            'data-toggle'       => array(),
            'data-target'       => array(),
            'data-modal'        => array(),
            'data-import-select'=> array(),
            'data-token'        => array(),
            'data-alets-id'     => array(),
            'data-element-id'   => array(),
            'data-option'       => array(),
            'data-role'         => array(),
            'data-filter'       => array(),
            'data-icon'         => array(),
            'data-key'          => array(),
            'data-taxonomy'     => array(),
            'data-taxonomies'   => array(),
            'data-media-type'   => array(),
            'data-url'          => array(),
            'data-placeholder'  => array(),
            'data-videoid'      => array(),
            'data-trackid'      => array(),
            'data-visual'       => array(),
            'data-href'         => array(),
            'data-numposts'     => array(),
            'data-original-title' => array(),
            'data-element'      => array(),
            'data-social'       => array(),
            'data-nav-type'     => array(),
            'data-counter-type' => array(),
            'data-tooltip'      => array(),
            'data-header-align' => array(),
            'data-role'         => array(),
            'data-fullscreen'   => array(),
            'data-width'        => array(),
            'data-height'       => array(),
            'data-small-header' => array(),
            'data-adapt-container-width' => array(),
            'data-hide-cover'   => array(),
            'data-show-facepile'=> array(),
            'data-show-posts'   => array(),
            'data-demo-id'      => array(),
            'data-nonce'        => array(),
            'data-import-select'=> array(),
            'data-attachment_id'=> array(),
            'data-add-columns'  => array(),
            'data-selector'     => array(),
            'data-cols'     => array(),
            'data-scroll'     => array(),
            'data-autoplay'     => array(),
            'data-delay'     => array(),
            'data-scroll-btn'     => array(),
            'data-target'     => array(),
            'data-action'     => array(),
            'data-parallax'     => array(),
            'data-animation'     => array(),
            'data-slide-title'     => array(),
            'data-slide-meta-date'     => array(),
            'data-thumb'     => array(),
            'data-title'     => array(),
            'data-time'     => array(),
            'data-img-sm'     => array(),
            'data-img-lg'     => array(),
            'data-show'     => array(),
            'data-bar-color'     => array(),
            'data-percent'     => array(),
            'data-percentage'  => array(),
            'data-address' => array(),
            'data-lat' => array(),
            'data-lng' => array(),
            'data-type' => array(),
            'data-style' => array(),
            'data-zoom' => array(),
            'data-type-ctrl' => array(),
            'data-zoom-ctrl' => array(),
            'data-scale-ctrl' => array(),
            'data-scroll' => array(),
            'data-draggable' => array(),
            'data-marker' => array(),
            'data-loop' => array(),
            'data-args' => array(),
            'data-value' => array(),
            'data-placeholder' => array(),
            'data-media-type'  => array(),
            'data-multiple'    => array(),
            'data-min'         => array(),
            'data-max'         => array(),
            'data-step'        => array(),
            'data-element-title' => array(),
            'data-elements-title' => array(),
            'data-filter-by'     => array(),
            'data-original'      => array(),
            'data-bar-size'      => array(),
            'data-type'          => array(),
            'data-post-id'       => array(),
            'data-attachment-id' => array(),
            'data-on'            => array(),
            'data-off'           => array(),
            'data-add-columns'   => array(),
            'data-ts-tab'        => array(),
            'data-ts-tab-element'=> array(),
            'data-month'         => array(),
            'data-year'          => array(), 
            'data-date'          => array(),
            'data-time'          => array(),
            'data-product_id'    => array(),
            'data-parent'        => array(),
            'data-state'         => array(),
            'data-show-faces'    => array(),
            'data-show-border'   => array(),
            'data-url'           => array(),
            'data-display'       => array(),
            'data-spy'           => array(),
            'data-ride'          => array(),
            'data-slide'         => array(),
            'data-slide-to'      => array(),
            'data-sequence'      => array(),
            'data-auto'          => array(),
            'data-original-title'=> array(),
            'data-content'       => array(),
            'data-slide-index'   => array(),
            'data-fancybox-group'=> array(),
            'data-fancybox-start'=> array(),
            'data-thumb'         => array(),
            'data-thumbcaption'  => array(),
            'data-parallax'      => array(),
            'data-cols'          => array(),
            'data-role'          => array(),
            'data-slick-index'   => array(),
            'data-lazy'          => array(),
            'data-direction'     => array(),
            'data-stop'          => array(),
            'data-scope'         => array(),
            'data-ingredient-id' => array(),
            'data-step-id'       => array(),
            'data-ajax-nonce'    => array(),
            'data-placement'     => array(),
            'data-label-for'     => array(),

            'aria-expanded'      => array(), 
            'aria-controls'      => array(),   
            
            'value'              => array(),
            'selected'           => array(),
            'checked'            => array(),
            'multiple'           => array(),
            'type'               => array(),
            'src'                => array(),
            'method'             => array(),
            'action'             => array(),      
            'datetime'           => array(),      
            //schema
            'itemscope'          => array(),
            'itemprop'           => array(),
            'itemtype'           => array(),
            'itemid'             => array(),
            'content'            => array(),
            'property'           => array(),
        );

        $allowed_tags = array(
            'article'       => $default_attribs,
            'header'        => $default_attribs,
            'section'       => $default_attribs,
            'figure'        => $default_attribs,
            'figcaption'    => $default_attribs,
            'div'           => $default_attribs,
            'span'          => $default_attribs,
            'p'             => $default_attribs,
            'img'           => $default_attribs,
            'a'             => array_merge( $default_attribs, array(
                'href' => array(),
                'target' => array('_blank', '_top'),
            ) ),
            'u'             => $default_attribs,
            'i'             => $default_attribs,
            'q'             => $default_attribs,
            'b'             => $default_attribs,
            'ul'            => $default_attribs,
            'ol'            => $default_attribs,
            'li'            => $default_attribs,
            'br'            => $default_attribs,
            'hr'            => $default_attribs,
            'select'        => $default_attribs,
            'option'        => $default_attribs,
            'textarea'      => $default_attribs,
            'strong'        => $default_attribs,
            'blockquote'    => $default_attribs,
            'del'           => $default_attribs,
            'strike'        => $default_attribs,
            'em'            => $default_attribs,
            'code'          => $default_attribs,
            'br'            => $default_attribs,
            'table'         => $default_attribs,
            'tr'            => $default_attribs,
            'td'            => $default_attribs,
            'th'            => $default_attribs,
            'label'         => $default_attribs,
            'input'         => $default_attribs,
            'style'         => $default_attribs,
            'aside'         => $default_attribs,
            'iframe'        => $default_attribs,
            'video'         => $default_attribs,
            'audio'         => $default_attribs,
            'h1'            => $default_attribs,
            'h2'            => $default_attribs,
            'h3'            => $default_attribs,
            'h4'            => $default_attribs,
            'h5'            => $default_attribs,
            'h6'            => $default_attribs,
            'script'        => $default_attribs,
            'form'          => $default_attribs,
            'button'        => $default_attribs,
            'meta'          => $default_attribs,
            'time'          => $default_attribs,
            'pre'           => $default_attribs,
        );

        return $content = wp_kses( $content, $allowed_tags );

        break;


    }

}

add_filter( 'safe_style_css', 'airkit_filter_style_css' );

function airkit_filter_style_css( $styles ) {
    $styles[] = 'display';
    $styles[] = 'background-position';
    $styles[] = 'background-size';
    $styles[] = 'background-image';

    return $styles;
}


function airkit_rand_string( $num = 10, $type='all' ){
    switch($type){

        case 'all':
           $char = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        break;

        case '0-9':
           $char = "0123456789";
        break;

        case 'a-b':
           $char = "abcdefghijklmnopqrstuvwxyz";
        break;

        case 'A-B':
           $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        break;
    }

    $string = substr(str_shuffle($char), 0, $num);

    return $string;
}

function airkit_excerpt( $optionLength, $post_ID, $showSubtitle = 'show-subtitle', $echo  = true ) {

    if ( is_string($optionLength) && !is_numeric($optionLength) ) {
        $ln = airkit_option_value('general', $optionLength);
    } else {
        $ln = absint($optionLength);
    }

    $subtitle = get_post_meta($post_ID, 'airkit_post_settings', true);
    $subtitle = (isset($subtitle['subtitle']) && $subtitle['subtitle'] !== '' && is_string($subtitle['subtitle'])) ? esc_attr($subtitle['subtitle']) : '';

    if ( $showSubtitle == 'show-subtitle' && isset($subtitle) && !empty($subtitle) ) {

        if ( !empty($subtitle) && strlen(strip_tags(strip_shortcodes($subtitle))) > intval($ln) ) {

            $result =  mb_substr( strip_tags( html_entity_decode( strip_shortcodes($subtitle) ) ), 0, intval($ln) ) . '...';

        } else {

            $result =  strip_tags( html_entity_decode( strip_shortcodes($subtitle) ) );

        }

    } else {

        $postExcerpt = get_post_field('post_excerpt', $post_ID);
        $postContent = get_post_field('post_content', $post_ID);

        if ( !empty( $postExcerpt ) ) {

            if (strlen(strip_tags(strip_shortcodes($postExcerpt))) > intval($ln) ) {

                $result =  mb_substr(strip_tags(strip_shortcodes($postExcerpt)), 0, intval($ln)) . '...';

            } else {

                $result =  strip_tags(strip_shortcodes($postExcerpt));

            }

        } else {

            if (strlen(strip_tags(strip_shortcodes($postContent))) > intval($ln) ) {

                $result =  mb_substr(strip_tags(strip_shortcodes($postContent)), 0, intval($ln)) . '...';

            } else {

                $result =  strip_tags(strip_shortcodes($postContent));

            }
        }
    }

    if ( $echo == true ) {

        echo airkit_var_sanitize( $result, 'the_kses' );

    } else {

        return $result;

    }
}

function airkit_hover_style( $post_ID, $options = array() ) {
    
    // When we have title position over image then don't show overlay effect
    if ( isset( $options['title-position'] ) && 'over-image' == $options['title-position'] ) {
        return;
    }

    $output         = '';
    $classes        = array( 'overlay-effect' );
    $hover_style    = airkit_option_value( 'styles', 'hover_style' );
    $post_img_url   = get_the_post_thumbnail_url( $post_ID, 'gowatch_small' );

    $classes[]      = 'y' === $hover_style ? ' has-overlay-effect' : '';


    // Build output
    $output .= '<div class="'. esc_attr(implode(' ', $classes)) .'">';

    if ( 'n' === $hover_style ) {

        $output .= '<a href="'. get_the_permalink() .'" class="overlay-link darken"></a>';

    } else {

        $output .= '<a href="'. get_the_permalink() .'" class="overlay-link darken"></a>';

        $output .= '
            <ul class="overlay-sharing">
                <li class="share-item">
                    <a class="facebook" title="' . esc_html__('Share on facebook','gowatch') . '" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=' . esc_url($post_img_url) . '"><i class="icon-facebook"></i></a>
                </li>
                <li class="share-item">
                    <a class="icon-twitter" title="' . esc_html__('Share on twitter','gowatch') . '" target="_blank" href="http://twitter.com/home?status=' . urlencode( get_the_title() ) . '+' . esc_url($post_img_url) . '"></a>
                </li>
                <li class="share-item">
                    <a class="icon-gplus" title="' . esc_html__('Share on Google+','gowatch') . '" target="_blank" href="https://plus.google.com/share?url=' . esc_url( get_the_permalink() ) . '" ></a>
                </li>                
            </ul>';
    }

    $output .= '</div>';

    return force_balance_tags( $output );


}


if ( !function_exists( 'airkit_post_format_icon' ) ) {

    function airkit_post_format_icon( $post_ID ) {

        $format_icons = array(
            // Post formats 
            'gallery' => 'icon-gallery',
            'video'   => 'icon-video',
            'audio'   => 'icon-music',
            'image'   => 'icon-image',
            'post'    => 'icon-edit',
            // Custom post types
            'event'   => 'icon-event',
            'ts_teams' =>  'icon-user',
            'ts-gallery' => 'icon-gallery',
        );

        $format = (string)get_post_format( $post_ID );
        $type = (string)get_post_type( $post_ID );

        $icon = '';

        if ( 'post' === $type ) {

            /* Get icon depdending on format */

            if ( array_key_exists( $format, $format_icons ) ) {

                $icon = $format_icons[ $format ];

            }

        } else {

            /* Get icon depending on post type */
            if ( array_key_exists( $type, $format_icons ) ) {

                $icon =  $format_icons[ $type ] ;

            }

        }

        $out = '';

        if ( !empty( $icon ) ) {
            $out = '<a href="'. get_the_permalink() .'" class="post-format-icon"><span class="'. $icon .'"></span></a>';
        }

        return $out;

    }    

}


function airkit_password_post() {
    global $post;
    $formPassword = '<div class="row">
    <div class="col-xs-12 col-md-8 col-md-offset-2">
        <form class="protected-post-form text-center" action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">
            <p class="lead protected-message">' . esc_html__('Enter the password below, to view this protected post', 'gowatch') . '</p>
            <div class="form-group">
                <input type="password" name="post_password" class="form-control" id="ts-password-post" placeholder="' . esc_html__( 'Enter password', 'gowatch' ) . '">
            </div>
            <input class="btn medium" type="submit" name="Submit" value="' . esc_html__('Submit', 'gowatch') . '" />
        </form>
    </div>
</div>';

return $formPassword;
}
add_filter('the_password_form', 'airkit_password_post');


add_action( 'tgmpa_register', 'airkit_register_required_plugins' );
function airkit_register_required_plugins() {

    $plugins = array(

        // Include a required plugin.
        array(
            'name'               => 'TouchCodes',// The plugin name.
            'slug'               => 'touchcodes',// The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/required-plugins/touchcodes.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.1.0.', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            ),

        array(
            'name'               => 'TouchRate',// The plugin name.
            'slug'               => 'touchrate',// The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/required-plugins/touchrate.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.0.0.', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            ),

        array(
            'name'               => 'Touch Video Ads',// The plugin name.
            'slug'               => 'touchvideoads',// The plugin slug (typically the folder name).
            'source'             => get_template_directory_uri() . '/required-plugins/touch-video-ads.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.0.1.', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            ),

        array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => false,
            ),
        array(
            'name'      => 'MailChimp for WordPress',
            'slug'      => 'mailchimp-for-wp',
            'required'  => false,
            ),

);

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     *
     * Some of the strings are wrapped in a sprintf(), so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id'           => 'gowatch',                  // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                           // Default absolute path to pre-packaged plugins.
        'menu'         => 'gowatch-install-plugins',  // Menu slug.
        'parent_slug'  => 'themes.php',                 // Parent menu slug.
        'capability'   => 'edit_theme_options',         // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                         // Show admin notices or not.
        'dismissable'  => true,                         // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                           // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                        // Automatically activate plugins after installation or not.
        'message'      => '',                           // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'gowatch' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'gowatch' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'gowatch' ), // %s = plugin name.
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'gowatch' ),
            'notice_can_install_required'     => _n_noop(
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'gowatch'
            ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop(
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'gowatch'
            ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop(
                'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
                'gowatch'
            ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop(
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                'gowatch'
            ), // %1$s = plugin name(s).
            'notice_ask_to_update_maybe'      => _n_noop(
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'gowatch'
            ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop(
                'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
                'gowatch'
            ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop(
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'gowatch'
            ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop(
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'gowatch'
            ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop(
                'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
                'gowatch'
            ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'gowatch'
                ),
            'update_link'                     => _n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'gowatch'
                ),
            'activate_link'                   => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'gowatch'
                ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'gowatch' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'gowatch' ),
            'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'gowatch' ),
            'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'gowatch' ),  // %1$s = plugin name(s).
            'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'gowatch' ),  // %1$s = plugin name(s).
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'gowatch' ), // %s = dashboard link.
            'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'gowatch' ),

            'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            )
);

tgmpa( $plugins, $config );
}

add_action('after_setup_theme', 'airkit_theme_custom_posts');

function airkit_theme_custom_posts()
{
    $custom_posts = array( 'gallery', 'event', 'video', 'teams', 'portfolio' );
    update_option( 'theme-custom-posts', $custom_posts );

    if( class_exists( 'Ts_Custom_Post' ) ) {

        Ts_Custom_Post::add_custom_post_type( 'playlist', array(
            'show_ui'               => false,
            'show_in_menu'          => false,
            'public'                => true,
            'publicly_queryable'    => true,
            'query_var'             => true,
            'supports'              => array('thumbnail'),
        ) );

    }
}

function airkit_all_animations( $output = 'effect' ) {

    if ( $output == 'effect' ) {

        return array(
            'none' => esc_html__('None', 'gowatch'),
            'bounceIn' => esc_html__('Bounce In', 'gowatch'),
            'bounceInDown' => esc_html__('Bounce In Down', 'gowatch'),
            'bounceInRight' => esc_html__('Bounce In Right', 'gowatch'),
            'bounceInUp' => esc_html__('Bounce In Up', 'gowatch'),
            'bounceInLeft' => esc_html__('Bounce In Left', 'gowatch'),
            'fadeInDownShort' => esc_html__('Fade In Down Short', 'gowatch'),
            'fadeInUpShort' => esc_html__('Fade In Up Short', 'gowatch'),
            'fadeInLeftShort' => esc_html__('Fade In Left Short', 'gowatch'),
            'fadeInRightShort' => esc_html__('Fade In Right Short', 'gowatch'),
            'fadeInDown' => esc_html__('Fade In Down', 'gowatch'),
            'fadeInUp' => esc_html__('Fade In Up', 'gowatch'),
            'fadeInLeft' => esc_html__('Fade In Left', 'gowatch'),
            'fadeInRight' => esc_html__('Fade In Right', 'gowatch'),
            'fadeIn' => esc_html__('Fade In', 'gowatch'),
            'growIn' => esc_html__('Grow In', 'gowatch'),
            'shake' => esc_html__('Shake', 'gowatch'),
            'shakeUp' => esc_html__('Shake Up', 'gowatch'),
            'rotateIn' => esc_html__('Rotate In', 'gowatch'),
            'rotateInUpLeft' => esc_html__('Rotate In Up Left', 'gowatch'),
            'rotateInDownLeft' => esc_html__('Rotate In Down Left', 'gowatch'),
            'rotateInUpRight' => esc_html__('Rotate In Up Right', 'gowatch'),
            'rotateInDownRight' => esc_html__('Rotate In Down Right', 'gowatch'),
            'rollIn' => esc_html__('Roll In', 'gowatch'),
            'wiggle' => esc_html__('Wiggle', 'gowatch'),
            'swing' => esc_html__('Swing', 'gowatch'),
            'tada' => esc_html__('Tada', 'gowatch'),
            'wobble' => esc_html__('Wobble', 'gowatch'),
            'pulse' => esc_html__('Pulse', 'gowatch'),
            'lightSpeedInRight' => esc_html__('Light Speed In Right', 'gowatch'),
            'lightSpeedInLeft' => esc_html__('Light Speed In Left', 'gowatch'),
            'flip' => esc_html__('Flip', 'gowatch'),
            'flipInX' => esc_html__('Flip In X', 'gowatch'),
            'flipInY' => esc_html__('Flip In Y', 'gowatch')
        );

    }

    return array(
        'none'       => '0s',
        'delay-250'  => '0.25s',
        'delay-500'  => '0.5s',
        'delay-750'  => '0.75s',
        'delay-1000' => '1.0s',
        'delay-1250' => '1.25s',
        'delay-1500' => '1.5s',
        'delay-1750' => '1.75s',
        'delay-2000' => '2s',
        'delay-2500' => '2.5s',
        'delay-3000' => '3s' ,
        'delay-3500' => '3.5s'
    );
}


function airkit_import_icon() {

    if ( !isset($_POST['ts-svg']) || empty($_POST['ts-svg']) || empty($_POST['ts-eot']) || empty($_POST['ts-ttf']) || empty($_POST['ts-woff']) || empty($_POST['ts-css']) ) return;

    if ( $contentCss = wp_remote_get(wp_get_attachment_url($_POST['ts-css'])) ) {

        $contentCss = $contentCss['body'];

        $indentificator = uniqid();

        $fontWeight = preg_match("/font-weight:\s*[\'\"A-z0-9]+;/", $contentCss, $matches);
        $fontWeight = isset($matches[0]) ? explode(':', $matches[0]) : '';
        $fontWeight = is_array($fontWeight) ? trim($fontWeight[1]) : 'normal;';

        $fontStyle = preg_match("/font-style:\s*[\'\"A-z0-9]+;/", $contentCss, $matches);
        $fontStyle = isset($matches[0]) ? explode(':', $matches[0]) : '';
        $fontStyle = is_array($fontStyle) ? trim($fontStyle[1]) : 'normal;';

        $contentCss = preg_replace("/\@font-face\s*\{[\n\s\S]*?\}/", '', $contentCss);// remove all font-face

        $contentCss = preg_replace("/font-family:\s*[\'\"A-z0-9]+;/i", 'font-family: ts-family-'. $indentificator .';', $contentCss);

        $contentCss = preg_replace("/icon/", 'ts-icon-'. $indentificator, $contentCss);

        preg_match_all('/((?=\.)*ts-icon-'. $indentificator .'-)\w+.*(?=::before)/', $contentCss, $classes);

        $classes = implode(',', $classes[0]);
        update_option('test-icon', $contentCss);
        $customIcon = array(
            'ids' => array(
                'svg'  => $_POST['ts-svg'],
                'eot'  => $_POST['ts-eot'],
                'css'  => $_POST['ts-css'],
                'woff' => $_POST['ts-woff'],
                'ttf'  => $_POST['ts-ttf']
                ),
            'classes'     => $classes,
            'css'         => str_replace('\\', '\\\\', $contentCss),
            'font-weight' => $fontWeight,
            'font-style'  => $fontStyle,
            'font-family' => 'ts-family-'. $indentificator,
            );

        $options = get_option('gowatch_icons');
        array_push($options['custom-icon'], $customIcon);

        $_POST['gowatch_icons']['icons'] .= ','. $classes;
        $_POST['gowatch_icons']['custom-icon'] = $options['custom-icon'];
    }

}
add_action( 'admin_init', 'airkit_import_icon');

function airkit_get_style_custom_icon_admin() {
    $options = get_option('gowatch_icons');
    $icons = isset($options['custom-icon']) && !empty($options['custom-icon']) ? $options['custom-icon'] : '';

    if ( !empty($icons) ) {

        echo '<style>';
        foreach($icons as $value) {

            echo    "@font-face {
                font-family: '". $value['font-family'] ."';
                src: url('". wp_get_attachment_url($value['ids']['eot']) ."');
                src: url('". wp_get_attachment_url($value['ids']['eot']) ."#iefix') format('embedded-opentype'),
                url('". wp_get_attachment_url($value['ids']['woff']) ."') format('woff'),
                url('". wp_get_attachment_url($value['ids']['ttf']) ."') format('truetype'),
                url('". wp_get_attachment_url($value['ids']['svg']) ."#fontello') format('svg');
                font-weight: ". $value['font-weight'] ."
                font-style: ". $value['font-style'] ."
            }". $value['css'];
        }
        echo '</style>';
    }

}
add_action('admin_head', 'airkit_get_style_custom_icon_admin');

function airkit_author_box( $post, $options = array() )
{

    // Don't show author box if author description is empty
    $meta_descriptions = get_the_author_meta('description');
    if ( $meta_descriptions == '' ) {
        return false;
    }

    $airkit_post_type = get_post_type( $post->ID );    

    $attr = array(
        'author' => $post->post_author,
        'post__not_in' => array( $post->ID ),
        'posts_per_page' => 3,
        'post_type' => $airkit_post_type
    );

    $view_opts = array(
        'element-type'    => 'small-articles',
        'reveal-effect'   => 'none',
        'reveal-delay'    => 'none',
        'per-row'         => 3,
        'behavior'        => 'normal',
        'featimg'         => 'y',
        'excerpt'         => 'n',
        'small-posts'     => 'n',
        'meta'            => 'y',
        'exclude_meta'    => array('author'),
        'gutter-space'    => '40',
    );

    if ( airkit_has_sidebar( $post->ID, $options ) !== 'none' ) {
        $attr['posts_per_page'] = 2;
        $view_opts['per-row'] = 2;
    }

    $author_posts_query = new WP_Query( $attr );

    ?>
    <div class="post-author-box"> 
        <div class="author-box-content">

            <div class="inner-author">

                <a class="author-avatar" href="<?php echo get_author_posts_url($post->post_author) ?>"><?php echo airkit_get_avatar(get_the_author_meta( 'ID' ), 100); ?></a>

                <?php if (strlen(get_the_author_meta('user_url')) != '') { ?>

                    <h5 class="author-title"><?php the_author_link(); ?></h5>

                <?php } else { ?>

                    <h5 class="author-title"><a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php the_author_link(); ?></a></h5>

                <?php } ?>

                <p class="author-description"><?php the_author_meta('description'); ?></p>

                <?php if (strlen(get_the_author_meta('user_url')) != '') { ?>

                    <p class="author-website"><?php esc_html_e('Website:','gowatch'); ?> <a href="<?php the_author_meta('user_url');?>"><?php the_author_meta('user_url');?></a></p>
                    
                <?php } ?>

                <?php if ( get_the_author_meta('airkit_user_settings') ): $author_socials = get_the_author_meta('airkit_user_settings'); ?>
                    
                    <ul class="author-socials">

                        <?php foreach ($author_socials as $key => $social) {

                            if ( '' !== $social ) {

                                $social_name = '';
                                $escaped_exception = array( 'skype', 'whatsup', 'snapchat', 'telegram' );

                                if ( 'user_social_youtube' == $key ) {
                                    $social_name = str_replace('user_social_youtube', 'video', $key);
                                } else {
                                    $social_name = str_replace('user_social_', '', $key);
                                }

                                if ( in_array( $social_name, $escaped_exception ) ) {

                                    echo '<li data-social-name="'. esc_attr( $social_name ) .'"><a href="'. esc_attr( $social ) .'" target="_blank"><i class="icon-'. esc_attr( $social_name ) .'"></i></a></li>';

                                } else {

                                    echo '<li data-social-name="'. esc_attr( $social_name ) .'"><a href="'. esc_url( $social ) .'" target="_blank"><i class="icon-'. esc_attr( $social_name ) .'"></i></a></li>';

                                }

                            }

                        }
                        ?>
                        
                    </ul>

                <?php endif ?>

            </div>
            <?php if( !empty( $author_posts_query->posts ) && !is_page() && !is_author() ): ?>
                <div class="author-articles">
                    <h6><?php echo esc_html__( 'More from', 'gowatch' ); ?> <a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php the_author_link(); ?></a></h6>

                     <div class="row">    
                        <?php 
                            echo airkit_Compilator::view_articles( $view_opts, $author_posts_query );
                        ?>
                     </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

function ts_disable_redirect_canonical( $redirect_url ) {

    if ( is_paged() && is_singular() ) $redirect_url = false; return $redirect_url;
    
}
add_filter('redirect_canonical','ts_disable_redirect_canonical');

// Add button socials to single product.
function airkit_sharing_single_product() { ?>
    <div class="product-sharing-options text-center">
        <?php airkit_single_sharing( array('heading' => 'y', 'label' => 'y', 'tooltip-popover' => 'n', 'style' => 'button-sharing') ); ?>
    </div>
    <?php
}

add_action( 'woocommerce_after_single_product_summary', 'airkit_sharing_single_product', 15 );

function airkit_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => '<i class="icon-right-arrow"></i>',
            'wrap_before' => '<div class="container"><nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav></div>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'gowatch' ),
        );
}
add_filter( 'woocommerce_breadcrumb_defaults', 'airkit_woocommerce_breadcrumbs' );

/** to change the position of excerpt **/
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 16 );


// Handle cart in header fragment for ajax add to cart
add_filter('add_to_cart_fragments', 'airkit_woocommerce_minicart_fragments');

if ( !function_exists( 'airkit_woocommerce_minicart_fragments' ) ) {

    function airkit_woocommerce_minicart_fragments( $fragments ) {       

        global $woocommerce;        
        ob_start();

        $minicart_items_class = '';
        if ($woocommerce->cart->cart_contents_count == 0) { 
            $minicart_items_class = 'no-items';
        }
        ?>

        <div class="woocommerce gbtr_dynamic_shopping_bag">
            <div class="gbtr_little_shopping_bag_wrapper">
                <div class="gbtr_little_shopping_bag">
                    <div class="overview">
                        <div class="minicart_items <?php echo esc_attr( $minicart_items_class ) ?>">
                            <i class="icon-shopping63"></i>
                            <span class="count">
                                <?php echo airkit_var_sanitize( $woocommerce->cart->cart_contents_count, 'esc_attr' ); ?>
                            </span>
                        </div>                    
                    </div>
                </div>
                <div class="gbtr_minicart_wrapper">
                    <span class="ts-cart-close icon-close"></span>
                    <h4><?php echo esc_html__('My shopping basket','gowatch') ; ?> </h4>                
                    <div class="gbtr_minicart">
                    <?php                                    
                    echo '<ul class="cart_list">';                                        
                        if (sizeof($woocommerce->cart->cart_contents)>0) : 

                            foreach ( $woocommerce->cart->cart_contents as $cart_item_key => $cart_item ) :
                            
                                $_product = $cart_item['data'];                                            
                                if ($_product->exists() && $cart_item['quantity']>0) :  
                                    $gbtr_product_title = $_product->get_title();
                                    $gbtr_short_product_title = (strlen( $gbtr_product_title ) > 28) ? substr( $gbtr_product_title, 0, 25 ) . '...' : $gbtr_product_title;                                                                      
                                    echo '<li class="cart_list_product">
                                                    <a class="cart_list_product_img" href="'. get_permalink( $cart_item['product_id'] ) .'"> ' 
                                                        . $_product->get_image() .
                                                    '</a>
                                                    <div class="cart_list_product_title">'.
                                                        apply_filters( 'woocommerce_cart_item_remove_link', 
                                                                        sprintf( '<a href="%s" class="remove" title="%s" data-product_id="%s">&times;</a>', 
                                                        /* href */      esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), 
                                                        /* title */     esc_html__( 'Remove this item', 'gowatch' ),
                                                        /* prod_id */   esc_attr( $cart_item['product_id'] )
                                                                         ), 
                                                                        $cart_item_key ) 
                                                        . '<a href="'. get_permalink( $cart_item['product_id'] ) . '" class="cart-item-title">' 
                                                        . apply_filters( 'woocommerce_cart_widget_product_title', $gbtr_short_product_title, $_product ) 
                                                        . '</a>'
                                                        . '<span class="cart_list_product_quantity"> ('. $cart_item['quantity'] .')</span>' 
                                                        . '<span class="cart_list_product_price">'. woocommerce_price( $_product->get_price() ) .'</span>
                                                    </div>
                                                    <div class="clr"></div>
                                                </li>';                                         
                                endif;                                        
                            endforeach;
                                    
                            echo ' <li class="minicart_total_checkout">
                                <h5>'. esc_html__('Cart subtotal:','gowatch') .' <span>'. $woocommerce->cart->get_cart_total() .'</span></h5>
                            </li>
                            <li class="clr">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <a href="'. esc_url( $woocommerce->cart->get_cart_url() ) .'" class="button gbtr_minicart_cart_btn">'. esc_html__('View Cart','gowatch') .'</a>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <a href="'. esc_url( $woocommerce->cart->get_checkout_url() ) .'" class="button gbtr_minicart_checkout_btn">'. __('Checkout','gowatch') .'</a>
                                    </div>
                                </div>
                            </li>';

                        else:

                            echo '<li class="empty">' .__('No products in the cart.','gowatch').'</li>'; 

                        endif;                                    

                    echo '</ul>';                                    
                    ?>                                                                        
    
                    </div>
                </div>
                
            </div>
        </div>
        

        <?php       
        $fragments['.gbtr_dynamic_shopping_bag'] = ob_get_clean();      
        return $fragments;
    }
}

if ( ! function_exists( 'airkit_query' ) ) {

    function airkit_query( $field = '' ) {
        global $post, $wp_query;

        $out = '';

        if ( $field == 'name' ) {

            $out = $wp_query->queried_object->name;

        } else {

            if ( empty( $field ) ) {

                return $wp_query;

            } else {

                if ( isset( $wp_query->{$field} ) ) {

                    return $wp_query->{$field};

                } else {

                    return $wp_query;
                }
            }
        }

        return empty( $out ) ? $wp_query : $out;
    }
}

if ( !function_exists( 'airkit_progress_scroll' ) ) {

    function airkit_progress_scroll() {
        global $post;
            
        if ( 'y' === airkit_single_option( 'article_progress' ) ){
        
            echo '<div id="progress-bar-id-'. $post->ID .'" class="article-progress-bar"></div><div class="progress-bar-backface"></div>';

        }

    }

}


if ( !function_exists( 'airkit_single_sharing' ) ) {

    function airkit_single_sharing( $options = array() ) {

        if ( 'n' !== airkit_single_option( 'sharing' ) && is_singular() && ! is_page() || is_page() && 'n' !== airkit_single_option( 'page_sharing' ) ) {

            echo airkit_PostMeta::sharing( get_the_ID(), $options );

        }

    }

}

/* Post class helper  
 * adds helper classes to post_class.
 */

if ( !function_exists('airkit_filter_post_class') ) {

    function airkit_filter_post_class( $classes ) {

        global $post;
        $placeholder = airkit_option_value( 'styles', 'lazy_placeholder' );
        $mime_type = get_post_mime_type( get_post_thumbnail_id( $post->ID ) );

        /* Is thumbnail disabled or no thumbnail set, add hidden-thumbnail class */
        if ( 'n' === airkit_single_option( 'img' ) || !has_post_thumbnail( $post->ID ) ) {

            $classes[] = 'no-thumbnail';
        }

        if ( 'y' === airkit_single_option( 'comments_toggle', 'y' ) ) {
            $classes[] = 'comments-toggle';
        }

        if ( 'n' !== airkit_single_option( 'dropcap', 'n' ) ) {

            $apply_for = airkit_single_option( 'dropcap', 'n' );
            $classes[] = 'dropcap-' . $apply_for;

        }    

        if( 'y' === airkit_single_option( 'progress_bar' ) ) {

            $classes[] = 'article-has-scroll';

        }

        if ( empty( $placeholder ) ) {
            
            $classes[] = 'no-lazy-placeholder';
        } else {

            $classes[] = 'has-lazy-placeholder';
        }

        if ( 'image/gif' == $mime_type ) {

            $classes[] = 'mime-type-gif';
        }

        if ( is_sticky( $post->ID ) ) {
            
            $classes[] = 'sticky';
        }
        
        /* Return a string of classes */

        return $classes;
    }
}

add_filter( 'post_class', 'airkit_filter_post_class' );


/**
 *
 * AMP(Accelerate Mobile Pages) Settings
 *
**/

/**
 * Custom Template
 *
 * If you want complete control over the look and feel of your AMP content, you can override the default template using the 
 * @amp_post_template_file filter 
 * and pass it the path to a custom template
 */
add_filter( 'amp_post_template_file', 'airkit_amp_set_custom_template', 10, 3 );

function airkit_amp_set_custom_template( $file, $type, $post ) {

    if ( 'single' === $type ) {
        $file = get_template_directory() . '/amp/single-amp-template.php';
    }

    return $file;
}


/**
 * Custom Style Path
 *
 */
add_filter( 'amp_post_template_file', 'airkit_amp_set_custom_style_path', 10, 3 );

function airkit_amp_set_custom_style_path( $file, $type, $post ) {

    if ( 'style' === $type ) {
        $file = get_template_directory() . '/amp/style.php';
    }
    return $file;
}

if( !function_exists( 'airkit_category_header_image' ) ) {

    function airkit_category_header_image(){

        global $wp_query;

        // Look for term_id in queried object.
        $term = $wp_query->get_queried_object();
        $term_thumbnail = '';

        // If is term, get term's background image.
        if( isset( $term->term_id ) ) {

            $term_thumbnail = get_term_meta( $term->term_id, 'airkit_tax_thumbnail', true );

        }

        // If term has no image, get image from options.
        if( !empty( $term_thumbnail ) ) {

            $pht_bg_url = airkit_Compilator::get_attachment_field( $term_thumbnail );

        } else {

            $pht_bg = airkit_option_value( 'layout', 'pht_bg' );
            $pht_bg_url = airkit_Compilator::get_attachment_field( $pht_bg );

        }

        return $pht_bg_url;

    }

}

if( !function_exists( 'airkit_single_opengraph' ) ) {

    function airkit_single_opengraph( $post_ID ) {

        $post_type = get_post_type( $post_ID );

        $post_thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id( $post_ID ) );

        echo '<meta property="og:image" content="' . airkit_var_sanitize( $post_thumbnail_url, 'esc_url' ) . '"/>';
        echo '<meta property="og:title" content="'. esc_attr( get_the_title() ) .'" />';
        if( has_excerpt( $post_ID ) ) {
            echo '<meta property="og:description" content="'. esc_attr( get_the_excerpt() ) .'" />';
        }
        echo '<meta property="og:url" content="'. get_the_permalink() .'" />';

        if( 'event' == $post_type ) {
            echo '<meta property="og:type" content="event:event" />';
        } elseif( 'portfolio' == $post_type ) {
            echo '<meta property="og:type" content="creativeWork:workExample" />';            
        }

    }

}

/*
 |
 | Add Custom post types support in tag.php template.
 |
 */
if( !function_exists('airkit_add_custom_types') ) {

    function airkit_add_custom_types( $query ) {

        if( is_tag() && $query->is_main_query() ) {

            $post_types = get_post_types();
            $query->set( 'post_type', $post_types );

        }
    }
    // add_filter( 'pre_get_posts', 'airkit_add_custom_types' );
}

// add_filter( 'pre_get_posts', 'airkit_io_cpt_search' );
/**
 * This function modifies the main WordPress query to include an array of 
 * post types instead of the default 'post' post type.
 *
 * @param object $query  The original query.
 * @return object $query The amended query.
 */
function airkit_io_cpt_search( $query ) {
    
    if ( $query->is_search() ) {
        $query->set( 'post_type', array( 'post', 'ts-gallery', 'video', 'portfolio' ) );
    }
    
    return $query;
}


if( !function_exists('airkit_filter_title_decoration') ) {

    function airkit_filter_title_decoration( $title, $id = null ){

        if( is_admin() && !wp_doing_ajax() ) return $title;

        $decoratedWords = airkit_option_value( 'styles', 'word_items' );

        $titleWords = explode( ' ', $title );

        foreach ( $titleWords as $titleWord ) {

            if( is_array( $decoratedWords ) ) {
                
                foreach ( $decoratedWords as $key => $wordAndDecoration ) {     

                    // remove unneeded characters
                    $word = preg_replace( '/[&#,.\';0-9 ]/', '', trim( stripslashes( $wordAndDecoration['word'] ) ) );
                    $filtered_titleWord = preg_replace( '/[&#,.\';0-9 ]/', '', $titleWord );

                    $decoration = $wordAndDecoration['word-decoration'];

                    // If word is not in title, move to next one.
                    if( $word != $filtered_titleWord ) continue;
                    // apply decoration
                    $decorated = airkit_decorate_word( $titleWord, $decoration );
                    // replace word with decorated one
                    $title = str_replace( $titleWord, $decorated, $title );

                }
            }

        }


        return $title;
    }

    add_filter( 'the_title', 'airkit_filter_title_decoration' );
    
}

/**
 * Given an word and a decoration type, functon will return this word wrapped in corresponding tag for given decoration type.
 * @param string word
 * @param string decoration type
 *
 * @return string decorated word.
 */
if( !function_exists('airkit_decorate_word') ) {

    function airkit_decorate_word( $word, $decoration ){

        $decoratedWord = $word;

        switch( $decoration ) {

            case 'b' :
                $decoratedWord = '<b>' . $word . '</b>';
            break;
            case 'i' :
                $decoratedWord = '<i>' . $word . '</i>';
            break;
            case 'bi' :
                $decoratedWord = '<b><i>' . $word . '</i></b>';
            break;      
            case 'u' :
                $decoratedWord = '<u>' . $word . '</u>';
            break;                  
        }

        return $decoratedWord;

    }

}

/**
 * Generate term colors output
 */

if( !function_exists('airkit_term_colors') ) {

    function airkit_term_colors() {

        $taxs = array( 'category', 'videos_categories', 'gallery_categories' );

        $term_options = airkit_option_value( 'term_options' );

        $cat_styles = '';

        $slugs = array();

        foreach ( $taxs as $tax ) {

            $tags = get_terms( $tax );

            foreach ( $tags as $tag ) {

                if ( !is_object( $tag ) || in_array( $tag->slug, $slugs ) ) {
                    continue;
                }

                if( isset( $term_options[ $tag->term_id ]['term-color'] ) ){
                    // Read term color
                    $term_color = $term_options[ $tag->term_id ]['term-color'];
                    // Add any needed styles below.
                    $cat_styles .= '.entry-categories > li.term-'. $tag->slug . ' a{
                        color: '.  $term_color .';
                    }';

                    $cat_styles .= '
                    .mosaic-rectangles .entry-categories > li.term-' . $tag->slug . ' a,
                    .mosaic-square .entry-categories > li.term-' . $tag->slug . ' a,
                    .mosaic-style-3 .entry-categories > li.term-' . $tag->slug . ' a,
                    .thumbnail-view .over-image .entry-categories > li.term-' . $tag->slug . ' a,
                    .airkit_slider.vertical-slider .entry-categories li.term-'. $tag->slug .' a,
                    .airkit_nona-slider .nona-article .entry-categories li.term-'. $tag->slug .' a,
                    .airkit_slider.stream .slider-item .entry-categories li.term-'. $tag->slug .' a,
                    .airkit_tilter-slider header .entry-content .entry-categories > li.term-' . $tag->slug . ' a,
                    .ts-featured-area.style-3 .feat-area-thumbs .entry-categories > li.term-' . $tag->slug . ' a {
                        color: '. (airkit_is_color_light($term_color) ? '#333' : '#fff') .';
                        background-color: '. $term_color .';
                    }';
                }

            }
        }

        return $cat_styles;
    }

}


/**
 * Filter for subscribers only post content
 */
if( !function_exists('airkit_check_subscribers_only') ) {

    function airkit_check_subscribers_only( $content ) {

        global $post;

        $apply_for = array( 'post', 'video', 'ts-gallery', 'event', 'portfolio' );

        if( is_singular() && in_array( $post->post_type, $apply_for ) ) {
            // check if post is visible only for subscribers, and if user is not logged in, show login form
            if( 'y' == airkit_single_option( 'subscribers_only' ) && !is_user_logged_in() || 'y' == airkit_option_value( 'single', 'video_subscribers_only' ) && !is_user_logged_in() ){
                $content = '<div class="airkit_frontend-forms">';
                $content .= '<div class="inner-form">';
                $content .= '<h3 class="col-lg-12">'. 
                                sprintf( esc_html__( 'You must be %slogged in%s to read this article.', 'gowatch' ), '<a href="'. wp_login_url( get_permalink() ) .'">', '</a>' ) 
                            .'</h3>';
                $content .= '</div>';
                $content .= '</div>';
            }

        }

        echo $content;
    }

}


if ( !function_exists('airkit_woocommerce_version_check') ) {
    
    function airkit_woocommerce_version_check( $version = '2.1', $compare = ">=" ) {

        if ( class_exists('WooCommerce') ) {
            global $woocommerce;

            if( version_compare( $woocommerce->version, $version, $compare ) ) {
                return true;
            }
        }

        return false;
    }

}


/**
 *
 * Add action for single page content (above|below)
 *
 */
add_action( 'airkit_above_single_content', 'airkit_above_single_content', 10 );

function airkit_above_single_content() {

    // content goes here

}

add_action( 'airkit_below_single_content', 'airkit_below_single_content', 10 );

function airkit_below_single_content() {
    global $post;

    echo '<div class="below-single-content">';

    wp_link_pages( array(
        'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:', 'gowatch' ) . '</span>',
        'after' => '</div>' )
    );
    
    echo airkit_PostMeta::tags( $post->ID, array( 'single' => 'y' ) );

    echo '</div>';


}


/**
 *
 * Add action for single page content (Related posts|Featured posts|Posts from same category)
 *
 */
add_action( 'airkit_related_posts', 'airkit_related_posts', 10 );

function airkit_related_posts() {
    global $post, $show_inline;

    $show_inline = false;

    echo airkit_PostMeta::single_related( $post->ID );
    echo airkit_PostMeta::single_featured( $post->ID );
    echo airkit_PostMeta::single_posts_from_same_category( $post->ID );
}


/**
 *
 * Build featured image for single page / post view article
 *
 */
if ( ! function_exists('airkit_featured_image') ) {
    
    function airkit_featured_image( $options = array(), $exclude = array() )
    {
        global $post;
        $output = '';

        // Only for single page
        if ( isset($options['is-single']) && $options['is-single'] ) {
            
            // Options
            $options['show-img']        = airkit_single_option( 'img' );
            $options['thumbnail-url']   = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
            $video_embed = get_post_meta( $post->ID, 'video_embed', TRUE );
            $video_URL = airkit_extract_iframe_src($video_embed);
            $audio_embed = get_post_meta( $post->ID, 'audio_embed', TRUE );
            $caption_align = 'text-left';

            $post_format = get_post_format( $post->ID ) ? : 'standard';

            $figure_attributes['class'][] = 'featured-image';

            /**
             *
             * HTML for featured image
             *
            */
            
            // Post format: Standard & Image
            if ( 'standard' == $post_format || 'image' == $post_format ) {

                $output .= '<figure '. airkit_element_attributes( $figure_attributes, array(), $post->ID, false ) .'>';
                    
                    $output .= airkit_PostMeta::post_rating( $post->ID );

                    // Start tag for lighbox anchor
                    if ( 'y' === airkit_option_value( 'general', 'enable_lightbox' ) ) {
                        $output .= '<a href="' . esc_url( $options['thumbnail-url'] ) . '" data-fancybox="' . $post->ID . '">';
                    }

                    // Post thumbnail
                    $output .= get_the_post_thumbnail( $post->ID, 'gowatch_single');
                    // Overlay effect
                    $output .= airkit_overlay_effect_type(false);

                    // End tag for lightbox anchor
                    if ( 'y' === airkit_option_value( 'general', 'enable_lightbox' ) ) {
                        $output .= '</a>';
                    }

                $output .= '</figure>';
                
            }

            // Post format: Video
            if ( 'video' == $post_format ) {

                $output .= '<figure '. airkit_element_attributes( $figure_attributes, array(), $post->ID, false ) .'>';
                    
                    if ( empty($video_URL) ) {

                        $output .= airkit_PostMeta::post_rating( $post->ID );

                        // Start tag for lighbox anchor
                        if ( 'y' === airkit_option_value( 'general', 'enable_lightbox' ) ) {
                            $output .= '<a href="' . esc_url( $options['thumbnail-url'] ) . '" data-fancybox="' . $post->ID . '">';
                        }

                        // Post thumbnail
                        $output .= get_the_post_thumbnail( $post->ID, 'gowatch_single');
                        // Overlay effect
                        $output .= airkit_overlay_effect_type(false);

                        // End tag for lightbox anchor
                        if ( 'y' === airkit_option_value( 'general', 'enable_lightbox' ) ) {
                            $output .= '</a>';
                        }

                    } else {
                        $output .= '<div class="embedded_videos">' . apply_filters( 'the_content', $video_embed ) . '</div>';
                    }

                $output .= '</figure>';
                
            }

            // Post format: Gallery
            if ( 'gallery' == $post_format ) {

                if ( has_shortcode( $post->post_content, 'gallery' ) ) {
                    
                    $galleries = get_post_galleries( $post->ID, false );
                    $gallery_ids = explode(',', $galleries[0]['ids']);

                    $output .= '
                        <div id="post-format-galleryid-'. $post->ID .'" class="airkit_post-gallery format-gallery-carousel carousel-post-gallery">
                            <ul class="carousel-nav">
                                <li class="carousel-nav-left"><i class="icon-left"></i></li>
                                <li class="carousel-nav-right"><i class="icon-right"></i></li>
                            </ul>
                            <div class="gallery-items">';

                    $i = 0;

                    foreach ( $gallery_ids as $key => $id ) {

                        $attachment = get_post($id);
                        $caption = wptexturize($attachment->post_excerpt);
                        $description = wptexturize($attachment->post_content);
                        $title = get_the_title($id);
                        $image_full = wp_get_attachment_image_src( $id, 'full' );
                        $src_full = esc_attr($image_full[0]);

                        $link = '<a href="'. $src_full .'" title="'. $caption .'" data-fancybox="group">'. wp_get_attachment_image( $id, 'gowatch_single' ) .'</a>';

                        $output .= '<figure class="gallery-item">';
                        $output .= '<div class="gallery-icon">'. $link .'</div>';

                        if ( ( trim($attachment->post_excerpt) || $title ) ) {
                            $output .= '
                                <figcaption class="gallery-caption">
                                    <h4 class="title">'. $title .'</h4>
                                    '. (!empty($caption) ? '<p class="caption">' . $caption . '</p>' : '') .'
                                    '. (!empty($description) ? '<p class="description">'. $description .'</p>' : '') .'
                                </figcaption>';
                        }

                        $output .= '</figure>';

                        $i++;
                    }

                    $output .= '
                            </div>
                        </div><!-- / post-format-galleryid-'. $post->ID .' -->';

                } else {

                    $output .= '<figure '. airkit_element_attributes( $figure_attributes, array(), $post->ID, false ) .'>';
                        
                        $output .= airkit_PostMeta::post_rating( $post->ID );

                        // Start tag for lighbox anchor
                        if ( 'y' === airkit_option_value( 'general', 'enable_lightbox' ) ) {
                            $output .= '<a href="' . esc_url( $options['thumbnail-url'] ) . '" data-fancybox="' . $post->ID . '">';
                        }

                        // Post thumbnail
                        $output .= get_the_post_thumbnail( $post->ID, 'gowatch_single');
                        // Overlay effect
                        $output .= airkit_overlay_effect_type(false);

                        // End tag for lightbox anchor
                        if ( 'y' === airkit_option_value( 'general', 'enable_lightbox' ) ) {
                            $output .= '</a>';
                        }

                    $output .= '</figure>';

                }

            }

            // Post format: Audio
            if ( 'audio' == $post_format ) {

                $output .= '<figure '. airkit_element_attributes( $figure_attributes, array(), $post->ID, false ) .'>';
                    
                    if ( empty( $audio_embed ) ) {
                        
                        $output .= airkit_PostMeta::post_rating( $post->ID );

                        // Start tag for lighbox anchor
                        if ( 'y' === airkit_option_value( 'general', 'enable_lightbox' ) ) {
                            $output .= '<a href="' . esc_url( $options['thumbnail-url'] ) . '" data-fancybox="' . $post->ID . '">';
                        }

                        // Post thumbnail
                        $output .= get_the_post_thumbnail( $post->ID, 'gowatch_single');
                        // Overlay effect
                        $output .= airkit_overlay_effect_type(false);

                        // End tag for lightbox anchor
                        if ( 'y' === airkit_option_value( 'general', 'enable_lightbox' ) ) {
                            $output .= '</a>';
                        }

                    } else {
                        $output .= '<div class="embedded_audio">' . apply_filters( 'the_content', $audio_embed ) . '</div>';
                    }

                $output .= '</figure>';
                
            }


            // Don't show featured image for password protected posts
            if( !post_password_required() ) {

                // If Show featured image from Single options is set to Yes
                // and post has thumbnail
                if ( 'y' === $options['show-img'] && has_post_thumbnail( $post->ID ) ) {

                    echo force_balance_tags( $output );

                }

            }

        }

        // Only for view articles
        if ( isset($options['is-view-article']) && $options['is-view-article'] ) {

            // Define variables
            $figure_attributes = array();
            $element_type   = isset( $options['element-type'] ) ? $options['element-type'] : '';
            $title_position = isset( $options['title-position'] ) ? $options['title-position'] : 'below-image';
            $enable_featimg = isset( $options['featimg'] ) ? $options['featimg'] : 'y';
            $image_size     = airkit_Compilator::view_get_image_size( $options );
            $has_feat_img   = 'y' == $enable_featimg && has_post_thumbnail( $post->ID ) ? true : false;
            $allow_post_thumbnail = airkit_Compilator::view_get_allowed_post_thumbnail( $options );
            $ignore_element = array('playlist');

            // for mosaic view
            if ( 'mosaic' == $element_type ) {
                $layout_mosaic  = isset( $options['layout'] ) ? $options['layout'] : 'rectangles';

                if ( 'style-4' !== $layout_mosaic ) {
                    $exclude[] = 'hover_style';
                }
            }

            if ( ! in_array($element_type, $ignore_element) && $has_feat_img ) {

                $output .= '
                    <figure '. airkit_element_attributes( $figure_attributes, array_merge( $options, array('element' => 'figure') ), $post->ID, false ) . '>'

                        . ( ! in_array('post_format', $exclude) ? airkit_PostMeta::post_format ( $post->ID, array('url' => 'y') ) : '' )
                        . ( 'big' == $element_type ? '<div class="big-holder"></div>' : '' )
                        . ( ! in_array('post_is_featured', $exclude) ? airkit_PostMeta::post_is_featured( $post->ID ) : '' )
                        . ( ! in_array('post_rating', $exclude) ? airkit_PostMeta::post_rating( $post->ID ) : '' )

                        . ( in_array( $element_type, $allow_post_thumbnail ) ? sprintf( '<a href="%s" title="%s">%s</a>', get_the_permalink(), get_the_title(), get_the_post_thumbnail( $post->ID, $image_size ) ) : '')

                        . ( ! in_array('overlay_effect', $exclude) ? airkit_overlay_effect_type(false) : '' )
                        . ( ! in_array('post_link', $exclude ) ? '<a href="'. get_the_permalink() .'" class="post-link"></a>' : '' )
                        . ( ! in_array('hover_style', $exclude) ? airkit_hover_style( $post->ID, $options ) : '' )
                        . ( ! in_array('post_sticky', $exclude) ? airkit_PostMeta::post_is_sticky( $post->ID ) : '' )

                    . '</figure>';
                
            }

            // For Playlist view articles
            if ( $element_type == 'playlist' ) {

                // Get posts from playlist
                $post_ids   = get_post_meta( $post->ID, '_post_ids', true );
                $ajax_nonce = wp_create_nonce( 'ajax_airkit_remove_playlist_nonce' );
                $playlist_posts_count = 0;

                if ( is_array($post_ids) ) {
                    $playlist_posts_count = count($post_ids);
                    // Get ID of last added post in playlist
                    $last_post_ID = end($post_ids);
                }

                if ( isset($last_post_ID) ) {
                    $redirect_url = add_query_arg( array('playlist_ID' => $post->ID), get_permalink($last_post_ID) );
                } else {
                    $redirect_url = '#';
                }

                $output .= '
                    <figure '. airkit_element_attributes( $figure_attributes, array_merge( $options, array('element' => 'figure') ), $post->ID, false ) . '>'

                        . ( ! in_array('post_link', $exclude ) ? '<a href="'. esc_url($redirect_url) .'" class="post-link"></a>' : '' )
                        . ( sprintf( '<span class="playlist-blur-img">%s</span>', get_the_post_thumbnail( $post->ID, $image_size ) ) )
                        . ( current_user_can('delete_post', $post->ID) ? sprintf( '<button id="button-remove-playlist-%1$s" class="playlist-remove" title="%2$s" data-playlist-id="%1$s" data-ajax-nonce="%3$s"><i class="icon-delete"></i></button>', $post->ID, esc_html__('Remove playlist', 'gowatch'), $ajax_nonce ) : '' )

                        . '<figcaption>'
                        . '<div class="playlist-caption">'

                            . ( sprintf( '<span class="playlist-count"><i class="icon-list-add"></i> %d</span>', (int)$playlist_posts_count ) )
                            . ( sprintf( '<a class="playlist-thumbnail" href="%s" title="%s">%s</a>', esc_url($redirect_url), get_the_title(), get_the_post_thumbnail( $post->ID, $image_size ) ) )

                        . '</div>'
                        . '</figcaption>'

                    . '</figure>';
            }

            echo force_balance_tags( $output );
            
        }

    }

}


/**
 *
 * Build post view entry content
 *
 */
if ( ! function_exists('airkit_entry_content') ) {
    
    function airkit_entry_content( $options = array(), $exclude = array() )
    {
        global $post;

        // Declare variables
        $output         = '';
        $classes        = array();
        $exclude_meta   = isset( $options['exclude_meta'] ) ? $options['exclude_meta'] : array();
        $title_position = isset( $options['title-position'] ) ? $options['title-position'] : 'below-image';
        $post_content   = isset( $options['exc'] ) ? $options['exc'] : 'excerpt';
        $element_type   = isset( $options['element-type'] ) ? $options['element-type'] : '';
        $meta           = isset( $options['meta'] ) ? $options['meta'] : 'y';
        $excerpt        = isset( $options['excerpt'] ) ? $options['excerpt'] : '';
        $excerpt_length = airkit_Compilator::view_excerpt_length( $options );
        $classes[]      = 'above-image' === $title_position ? 'entry-content-above' : 'entry-content-below';
        $ignore_element = array('playlist');

        // for mosaic view
        if ( 'mosaic' == $element_type ) {
            $layout_mosaic  = isset( $options['layout'] ) ? $options['layout'] : 'rectangles';
            $sizes          = airkit_PostMeta::mosaic_sizes( $options ); // Get sizes for mosaic
        }


        if ( ! in_array($element_type, $ignore_element) ) {
            
            $output .= '<header ' . airkit_element_attributes( array('class' => $classes), $options, $post->ID, false ) . '><div class="entry-content">';

                if ( 'timeline' == $element_type ) {
                    $output .= '<div class="neighborhood">';
                }

                // Show categories
                if( ! in_array('categories', $exclude) && 'y' === $meta ) {
                    $output .= airkit_PostMeta::categories( $post->ID, array( 'wrap-class' => 'entry-categories' ) );
                }

                // Show title
                if ( ! in_array('title', $exclude) ) {
                    $output .= airkit_PostMeta::title( $post->ID, array('wrap' => 'h2') ); 
                }

                if ( 'below-image' === $title_position ) {

                    // Show excerpt
                    if ( ! in_array('excerpt', $exclude) && 'y' == $excerpt ) {

                        if ( 'excerpt' === $post_content ) {
                            $output .= '<div class="entry-excerpt" itemprop="description">'
                                    . airkit_excerpt( $excerpt_length, $post->ID, 'show-excerpt', false )
                                    . '</div>';
                        } else {
                            $output .= '<div class="post-content" itemprop="description">' . apply_filters( 'the_content', $post->post_content ) . '</div>';
                        }

                    }

                }

                // for mosaic view
                if( 'mosaic' == $element_type && 'style-4' === $layout_mosaic ) {

                    if( ! in_array('excerpt', $exclude) && $sizes['size'] === 'big' ) {

                        $output .= '<div class="entry-excerpt" itemprop="description">'
                                . airkit_excerpt( $excerpt_length, $post->ID, 'show-excerpt', false )
                                . '</div>';

                    }

                }

                // for list articles and timeline
                if ( 'list_view' == $element_type || 'timeline' == $element_type ) {

                    $output .= '<div class="entry-excerpt" itemprop="description">'
                            . airkit_excerpt( $excerpt_length, $post->ID, 'show-excerpt', false )
                            . '</div>';

                }

                // for timeline view
                if ( 'timeline' == $element_type ) {
                    $output .= '
                        <div class="over-fence">
                            <div class="entry-post-date">
                                <time>'. get_post_time( 'H:i', true, null, true ) .'</time>
                            </div>
                            <div class="entry-meta-date">'. get_post_time( 'd M, Y', true, null, true ) .'</div>
                        </div>';
                }

                if ( 'timeline' == $element_type ) {
                    $output .= '</div><!-- .neighborhood -->';
                }

                
            $output .= '</div><!-- /.entry-content -->';

            $output .= '<div class="entry-content-footer">';

            // Show microdata Schema.org
            if ( ! in_array('microdata', $exclude) ) {
                $output .= airkit_PostMeta::microdata( $options );
            }

            if( ! in_array('meta', $exclude) && 'y' === $meta ) {
                $output .= airkit_PostMeta::the_meta( $post->ID, $options, $exclude_meta );
            }

            $output .= '</div><!-- /.entry-content-footer -->';

            $output .= '</header>';

        }

        if ( $element_type == 'playlist' ) {

            $output .= '<header ' . airkit_element_attributes( array('class' => $classes), $options, $post->ID, false ) . '><div class="entry-content">';

            // Get posts from playlist
            $post_ids = get_post_meta( $post->ID, '_post_ids', true );

            if ( is_array($post_ids) ) {
                // Get ID of last added post in playlist
                $last_post_ID = end($post_ids);
            }

            if ( isset($last_post_ID) ) {
                $redirect_url = add_query_arg( array('playlist_ID' => $post->ID), get_permalink($last_post_ID) );
            } else {
                $redirect_url = '#';
            }

            // Show title
            if ( ! in_array('title', $exclude) ) {
                $output .= airkit_PostMeta::title( $post->ID, array('wrap' => 'h2', 'url_link' => $redirect_url) ); 
            }

            // Play all button
            $output .= '<a href="'. esc_url($redirect_url) .'" class="play-all btn btn-primary small" itemprop="url"><span>'. esc_html__('Play all', 'gowatch') .'</span></a>';

            // Show microdata Schema.org
            if ( ! in_array('microdata', $exclude) ) {
                $output .= airkit_PostMeta::microdata( $options );
            }

            $output .= '</div><!-- /.entry-content -->';

            $output .= '</header>';
            
        }

        echo force_balance_tags( $output );
        
    }

}


function airkit_extract_iframe_src( $iframe ) {

    $url = $iframe;

    if ( airkit_is_html($iframe) ) {
        preg_match('/src="([^"]+)"/', $iframe, $match);
    }

    if ( isset($match[1]) ) {
        $url = $match[1];
    }

    return $url;
}

function airkit_is_html( $string ) {
    return preg_match("/<[^<]+>/", $string, $m) != 0;
}

function airkit_element_attributes( $attributes = array(), $options = array(), $post_ID = null, $echo = true ) {

    global $post;

    $atts = '';
    $element = isset($options['element']) ? $options['element'] : '';
    $element_type = isset( $options['element-type'] ) ? $options['element-type'] : '';
    $allow_post_thumbnail = airkit_Compilator::view_get_allowed_post_thumbnail( $options );

    if ( 'article' === $element ) {
        
        // Article classes
        $article_classes = array();

        $article_classes[]  = isset( $options['classes'] ) ? $options['classes'] : '';
        $article_classes[]  = isset( $options['is-view-article'] ) && $options['is-view-article'] === true ? 'airkit_view-article' : '';
        $article_classes[]  = isset( $options['text-align'] ) ? 'text-'.$options['text-align'] : 'text-left';
        $article_classes[]  = isset( $options['title-position'] ) ? $options['title-position'] : 'below-image';
        $article_classes[]  = isset( $options['exc'] ) ? 'show-' . $options['exc'] : '';
        $article_classes[]  = isset( $options['hover-style'] ) ? 'effect-' . $options['hover-style'] : 'effect-always';
        $article_classes[]  = isset( $options['meta'] ) && 'n' == $options['meta'] ? 'hide-post-meta' : '';
        $article_classes[]  = isset( $options['excerpt'] ) && 'n' == $options['excerpt'] ? 'hidden-excerpt' : '';
        $article_classes[]  = ( isset( $options['featimg'] ) && 'y' !== $options['featimg'] ) || !has_post_thumbnail( $post_ID ) ? 'no-image' : 'has-image';
        $article_classes[]  = airkit_Compilator::child_effect( $options );

        // Pass all post article classes
        $attributes['class'][] = trim( implode( ' ', array_filter($article_classes) ) );

        // Microdata Schema.org
        $stdata = airkit_PostMeta::microdata(array('data' => true));

        if ( isset($options['is-single']) && $options['is-single'] === true ) {

            $single_feat_img = airkit_single_option( 'img' );
            
            $attributes['class'][] = 'single-article';

            if ( 'y' == $single_feat_img && has_post_thumbnail($post_ID) ) {
                $attributes['class'][] = 'has-featured-img';
            } else {
                $attributes['class'][] = 'hidden-featured-img';
            }
        }

        $attributes['data-post-id'] = $post_ID;

    } elseif ( 'post-row' === $element ) {

        $attributes['class'][] = 'post-details-row';

        // Check if autload_next post is enabled
        if( 'y' == airkit_option_value( 'single', 'autoload_next' ) ) {
            $attributes['class'][] = 'airkit_singular';
            $attributes['data-nonce'] = esc_attr(wp_create_nonce("load_next_post_nonce"));
            $attributes['data-id'] = esc_attr($post_ID);
            $attributes['data-url'] = esc_url( get_the_permalink($post_ID) );

        }

    } elseif ( 'figure' === $element ) {
        
        $attributes['class'][] = 'image-holder';

        // Add image as background-image for specific post view elements
        if ( !in_array( $element_type, $allow_post_thumbnail ) ) {

            $enabled_lazy = airkit_option_value( 'general', 'enable_imagesloaded' );
            $img_size = isset($options['img_size']) && ! empty($options['img_size']) ? $options['img_size'] : airkit_Compilator::view_get_image_size( $options );
            $options['background-img'] = isset( $options['background-img'] ) ? $options['background-img'] : 'y';

            $thumbnail_id       = get_post_thumbnail_id( $post_ID );
            $mime_type          = get_post_mime_type( $thumbnail_id );
            $size               = 'image/gif' == $mime_type ? 'full' : $img_size;
            $img_attr           = wp_get_attachment_image_src($thumbnail_id, $size);

            if ( 'y' == $options['background-img'] ) {
                $attributes['class'][] = 'has-background-img';
            }

            if ( 'y' == $enabled_lazy ) {
                $attributes['class'][] = 'lazy';

                // Get data original
                $attributes[] = Airkit_Images::lazy_background( $img_attr[0] );

                // get placeholder
                $placeholder = airkit_option_value( 'styles', 'lazy_placeholder' );

                if( !empty( $placeholder ) ) {
                    $placeholder_url = airkit_Compilator::get_attachment_field( $placeholder, 'url', $img_size );

                    $attributes['style'] = 'background-image: url('. esc_url( $placeholder_url ) .');';
                }

            } else {

                $attributes['style'] = 'background-image: url('. esc_url( $img_attr[0] ) .');';
            }

        }

    }

    // Pass all rendered attributes
    $atts = airkit_Compilator::render_atts($attributes);

    if ( 'article' === $element ) {
        // Add schema attributes for article
        $atts = $atts . $stdata['article'];
    }

    if ( $echo ) {
        echo trim($atts);
    } else {
        return trim($atts);
    }

}


/**
 * Convert the timestamp to human time (time ago)
 */
function airkit_time_to_human_time( $datetime, $now = 0 ) {

    $timestamp = strtotime($datetime);

    // Set up an array of time intervals.
    $intervals = array(
        60 * 60 * 24 * 365 => esc_html__( 'year', 'gowatch' ),
        60 * 60 * 24 * 30  => esc_html__( 'month', 'gowatch' ),
        60 * 60 * 24 * 7   => esc_html__( 'week', 'gowatch' ),
        60 * 60 * 24       => esc_html__( 'day', 'gowatch' ),
        60 * 60            => esc_html__( 'hour', 'gowatch' ),
        60                 => esc_html__( 'minute', 'gowatch' ),
        1                  => esc_html__( 'second', 'gowatch' ),
    );

    // Get the current time if a reference point has not been provided.
    if ( 0 === $now ) {
        $now = time();
    }

    // Make sure the timestamp to check predates the current time reference point.
    if ( $timestamp > $now ) {
        throw new \Exception( 'Timestamp postdates the current time reference point' );
    }

    // Calculate the time difference between the current time reference point and the timestamp we're comparing.
    $time_difference = (int) abs( $now - $timestamp );

    // Check the time difference against each item in our $intervals array. When we find an applicable interval,
    // calculate the amount of intervals represented by the the time difference and return it in a human-friendly
    // format.
    foreach ( $intervals as $interval => $label ) {

        // If the current interval is larger than our time difference, move on to the next smaller interval.
        if ( $time_difference < $interval ) {
            continue;
        }

        // Our time difference is smaller than the interval. Find the number of times our time difference will fit into
        // the interval.
        $time_difference_in_units = round( $time_difference / $interval );

        if ( $time_difference_in_units <= 1 ) {
            $time_ago = sprintf( 'one %s ago',
                $label
            );
        } else {
            $time_ago = sprintf( '%s %ss ago',
                $time_difference_in_units,
                $label
            );
        }

        return $time_ago;
    }
}


/**
 * Used to display advertising insteaf of post
 */
if( !function_exists('airkit_advertising_loop') ) {

    function airkit_advertising_loop( $options ){

        $ad_type = isset( $options['ad-type'] ) ? $options['ad-type'] : 'grid';
        $advertising = '';

        if( 'grid' == $ad_type ) {

            $advertising = airkit_option_value( 'advertising', 'ad_area_grid' );

        } elseif( 'list' == $ad_type ) {

            $advertising = airkit_option_value( 'advertising', 'ad_area_list' );

        }

        if( !isset( $advertising ) || empty( $advertising ) || false == $advertising ) return;

        // check if ads are enabled for this listing.
        if( isset( $options['enable-ads'] ) && 'y' == $options['enable-ads'] ) {

            $step = isset( $options['ads-step'] ) ? (int) $options['ads-step'] : 4;

            $per_row = isset( $options['per-row'] ) ? $options['per-row'] : 1;

            $columns_class = airkit_Compilator::get_column_class( $per_row );

            $i = $options['i'];

            if( $i % $step == 0 ) {
                // open scroll container if needed
                airkit_Compilator::open_scroll_container( $options );

                echo '<div class="airkit_advertising-loop '. esc_attr( $columns_class ) .'">';
                echo airkit_var_sanitize( stripslashes( $advertising ), 'true' );
                echo '</div>';
                // Close scroll container if needed
                airkit_Compilator::close_scroll_container( $options );

                airkit_Compilator::$options['i']++;
            }
        }
    }
}

/**
 * Description
 * @param type !function_exists('airkit_advertising_loop') 
 * @return type
 */
if( !function_exists('airkit_import_selectors') ) {

    function airkit_import_selectors()
    {
    ?>
                <form method="post">

                    <div style="background-color: #F5FAFD; margin:10px 0;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;">
                        <p>
                            Before starting the import process, to make sure you get all the info from the demo and you get no errors, please make sure you have the following plugins activated:
                            <ul style="padding-left: 20px;list-style-position: inside;list-style-type: square;}">
                                <li>TouchCodes</li>
                                <li>TouchRate</li>
                                <li>Touch Video Ads</li>
                                <li>WooCommerce</li>
                                <li>MailChimp Plugin</li>
                            </ul>
                            Also, we strongly recommend you to change your server configuration for execution times and memory limits:
                            <ul style="padding-left: 20px;list-style-position: inside;list-style-type: square;}">
                                <li>memory_limit 256MB</li>
                                <li>max_execution_time 300</li>
                                <li>upload_max_filesize 32MB</li>
                            </ul>
                        </p>
                        <p class="tie_message_hint"><?php esc_html_e('Importing demo data : post, pages, images, theme settings, ... is the easiest way to setup your theme. It will
                        allow you to quickly edit everything instead of creating content from scratch. When you import the data following things will happen:', 'gowatch'); ?></p>

                          <ul style="padding-left: 20px;list-style-position: inside;list-style-type: square;}">
                              <li><?php esc_html_e('No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified .', 'gowatch'); ?></li>
                              <li><?php esc_html_e('No WordPress settings will be modified .', 'gowatch'); ?></li>
                              <li><?php esc_html_e('Posts, pages, some images, some widgets and menus will get imported .', 'gowatch'); ?></li>
                              <li><?php esc_html_e('Images will be downloaded from our server, these images are copyrighted and are for demo use only .', 'gowatch'); ?></li>
                              <li><?php esc_html_e('Please click import only once and wait, it can take a couple of minutes', 'gowatch'); ?></li>
                          </ul>
                     </div>
                    <h3><?php esc_html_e('Import Demo Data', 'gowatch'); ?></h3>
                    <div class="ts-importer-wrap" data-demo-id="1"  data-nonce="<?php echo wp_create_nonce('ts-demo-code'); ?>">


                    <label for="demo-style"><?php esc_html_e('Choose the demo you want to import', 'gowatch' ); ?>:</label>
                    <div class="import-selector-container">
                        <img class="import-selector selected" data-import-select="gowatch1" src="<?php echo get_template_directory_uri(); ?>/import/demo-files/community.jpg" alt="Community Demo" />
                        <img class="import-selector" data-import-select="gowatch2" src="<?php echo get_template_directory_uri(); ?>/import/demo-files/vlog.jpg" alt="Vlog Demo" />
                        <img class="import-selector" data-import-select="gowatch3" src="<?php echo get_template_directory_uri(); ?>/import/demo-files/boxed.jpg" alt="Boxed Demo" />
                        <img class="import-selector" data-import-select="gowatch4" src="<?php echo get_template_directory_uri(); ?>/import/demo-files/dark.jpg" alt="Dark Demo" />
                    </div>
                    <select id="demo-style" name="demo-style" class="hidden">
                        <option value="gowatch1">Community Demo</option>
                        <option value="gowatch2">Vlog Demo</option>
                        <option value="gowatch3">Boxed demo</option>
                        <option value="gowatch4">Dark Demo</option>
                    </select>
                    <input type="hidden" name="demononce" value="<?php echo wp_create_nonce('ts-demo-code'); ?>" />
                    <input name="reset" class="panel-save button-primary ts-import-start" type="submit" value="Import Demo Data" />
                    <input type="hidden" name="action" value="demo-data" />

                    <br />
                    <br />
                    <div class="ts-importer-message clear">
                        <?php

                        // Check if we have the right action
                        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

                        // Do the importing
                        if( 'demo-data' == $action && check_admin_referer('ts-demo-code' , 'demononce')){
                            $airkit_Importer = new Ts_Importer();
                            $airkit_Importer->process_imports('gowatch');
                        } ?>
                    </div>
                </form>
                <h3><?php esc_html_e('Reset theme settings to defaults', 'gowatch'); ?></h3>
                <input type="button" name="reset-settings" class="button" value="<?php esc_html_e( 'Reset settings', 'gowatch' ); ?>">

            </div>
    <?php
    }
}


if ( ! function_exists('airkit_get_avatar') ) {
    function airkit_get_avatar($id_or_email, $size)
    {
        if ( ! is_numeric($id_or_email) ) {
            $user = get_user_by('email', $id_or_email);
        } else {
            $user = get_user_by('id', $id_or_email);
        }
        if ( !is_object( $user ) ) {
            $id_or_email = get_the_author_meta( 'ID' );
        }

        $user_settings = get_the_author_meta( 'airkit_user_settings', $id_or_email );

        if ( !isset($user_settings['avatar']) || empty($user_settings['avatar']) ) {
            $user_avatar = get_avatar( $id_or_email, $size );
        } else {
            $user_avatar = wp_get_attachment_image( airkit_Compilator::get_attachment_field($user_settings['avatar'], 'id'), array($size, $size) );
        }

        return force_balance_tags($user_avatar);
    }
}

function gowatch_video_ads( $post_ID ) {

    if ( !class_exists( 'TouchVideoAds' ) ) return;

    // Get the ads we need
    $adStorage = array(
        'video' => array(),
        'text'  => array(),
        'image' => array()
    );

    $available_ads = array();

    // Get the current posts taxonomies
    $terms = wp_get_object_terms( $post_ID, 'videos_categories' );
    if ( !empty($terms) && !is_wp_error($terms) ) {
        foreach ( $terms as $category ) {
            $categories[] = $category->slug;
        }
    }
    $terms = wp_get_object_terms( $post_ID, 'post_tag' );
    if ( !empty($terms) && !is_wp_error($terms) ) {
        foreach ( $terms as $tag ) {
            $tags[] = $tag->slug;
        }
    }

    $post_terms['categories'] = isset($categories) ? $categories : array();
    $post_terms['tags'] = isset($tags) ? $tags : array();
    $post_terms['id'] = $post_ID;

    $ad_args = array(
        'posts_per_page'   => -1,
        'post_status'      => 'publish',
        'post_type'        => 'touch-video-ads',
        'meta_key'         => 'ad_status',
        'meta_value'       => 'y',
    );

    $video_ads = get_posts($ad_args);

    // Get all video ads
    foreach ($video_ads as $banner) {
            
        $meta_array = TouchVideoAds::$video_ad_options;
        // update_post_meta( $banner->ID, 'ad_served_views', 10 );

        // Iterate through all banners to create an array with them and all their data
        foreach ($meta_array as $key => $field) {
            $available_ads[ $banner->ID ][ $field['id'] ] = get_post_meta( $banner->ID, $field['id'], true ); 
        }

        // Add the ID of the banner
        $available_ads[ $banner->ID ][ 'banner_id' ] = $banner->ID;

    }

    // If no ads are available, return false
    if ( !is_array( $available_ads ) ) return false;

    // Filter ads only that fit the criteria
    $available_ads =  array_filter($available_ads, function($ad) use ($post_terms) {
        if ( $ad['ad_criteria'] == 'category' ) {
            $fits_criteria = array_intersect( explode(',', airkit_filter_csv($ad['ad_criteria_category'] ) ), $post_terms['categories'] );
            if ($fits_criteria) return $ad;
        } elseif ( $ad['ad_criteria'] == 'tag' ) {
            $fits_criteria = array_intersect( explode(',', airkit_filter_csv( $ad['ad_criteria_tag'] ) ), $post_terms['tags'] );
            if ($fits_criteria) return $ad;
        } elseif ( $ad['ad_criteria'] == 'id' ) {
            $fits_criteria = in_array( $post_terms['id'], explode(',', airkit_filter_csv( $ad['ad_criteria_id'] ) ) );
            if ($fits_criteria) return $ad;
        } else {
            return $ad;
        }
    });

    // Check if ad should be excluded for this post ID or the max views are reached
    $available_ads =  array_filter($available_ads, function($k) use ($post_ID) {

        // Check if post id is NOT int the excluded list
        $excluded_ids = ( $k['ad_exclude_id'] != '' ) ? explode( ',', airkit_filter_csv( $k['ad_exclude_id'] ) ) : array();

        // Check if counter is still OK
        if ( $k['ad_count_mode'] == 'views' ) {
            $check_limit = ( $k['ad_served_views'] < $k['ad_max_views'] ) ? true : false;
        } else {
            $check_limit = ( $k['ad_served_clicks'] < $k['ad_max_clicks'] ) ? true : false;
        }
        return !in_array( $post_ID, $excluded_ids) && $check_limit;
    });



    /** 
        Sort the ads for each type
    */

    $preroll_ads = array_filter($available_ads, function($k) use ($post_ID) {
        return $k['video_ad_type'] == 'preroll';
    });
    shuffle( $preroll_ads );

    // Filter text ads to get the remaining ones that match our criteria
    $text_ads = array_filter($available_ads, function($k) use ($post_ID) {
        return $k['video_ad_type'] == 'textover';
    });
    shuffle( $text_ads );

    $image_ads = array_filter($available_ads, function($k) use ($post_ID) {
        return $k['video_ad_type'] == 'imageover';
    });
    shuffle( $image_ads );

    // Prepare ad information
    if ( $preroll_ads && is_array( $preroll_ads ) ) {
        $adStorage['video'] = $preroll_ads[0];

        // Fix URL for video
        $adStorage['video']['preroll_video_file'] = airkit_Compilator::get_attachment_field( $adStorage['video']['preroll_video_file'], 'video-url' );
    }
    if ( $text_ads && is_array( $text_ads ) ) {
        // We can have move in one video, iterate and create the ads array
        foreach ($text_ads as $key => $value) {
            array_push($adStorage, $value);
        }
    }
    if ( $image_ads && is_array( $image_ads ) ) {
        // We can have move in one video, iterate and create the ads array
        foreach ($image_ads as $key => $value) {
            $value['ad_image'] = airkit_Compilator::get_attachment_field( $value['ad_image'], 'url', 'full' );
            array_push($adStorage, $value);
        }
    }

    return $adStorage;

}
/*
 * Filter comma separated values (csv). Trim new lines and whitespaces
 */
if( !function_exists('airkit_filter_csv') ) {

    function airkit_filter_csv( $string  = '' ){
        //remove newlines
        $string = str_replace("\n", '', $string);
        // replace whitespaces with commas
        $string = str_replace( ' ', ',', $string );

        return $string;

    }

}

if( !function_exists('airkit_single_video_player') ) {

    function airkit_single_video_player( $post_ID, $options = array() ) {

        $post_format  = get_post_format( $post_ID );
        $video_url    = get_post_meta( $post_ID, 'video_url', true);
        $video_embed  = get_post_meta( $post_ID, 'video_embed', true);
        $video_upload = get_post_meta( $post_ID, 'video_upload', true);

        // Check if we should enable the sticky video option
        $sticky_class = airkit_option_value( 'single', 'video_sticky' ) == 'y' ? 'should-stick' : '';

        // Check the type of video
        if ( $video_url != '' ) {
            // Check if is YouTube or vimeo
            if ( strpos( $video_url, 'youtu' ) > 0 ) {

                $videoType = 'youtube';

            } elseif ( strpos( $video_url, 'vimeo' ) > 0 ) {

                $videoType = 'vimeo';

            } else {
                $videoType = 'external';
            }

            $videopath = $video_url;

        } elseif ( $video_embed != '' ) {

            $videoType = 'embed';
            $videopath = get_post_meta( $post_ID, 'video_embed', true);

        } else {

            $videoType = 'HTML5';
            if ( is_numeric( $video_upload ) ) {
                $videopath = wp_get_attachment_url( $video_upload );
            } else {
                $videopath = $video_upload;
            }

        }

        // Create the fallback for old themes
        $old_themes_video = get_post_meta( $post_ID, 'ts-video', true );
        if ( !empty( $old_themes_video ) ) {
            if ( 'url' == $old_themes_video['type'] ) {

                $videoType = 'youtube';
                $videopath = $old_themes_video['video'];

            } elseif ( 'upload' == $old_themes_video['type'] ) {

                $videoType = 'HTML5';
                $videopath = $old_themes_video['video'];

            } elseif ( 'embed' == $old_themes_video['type'] ) {

                $videoType = 'embed';
                $videopath = $old_themes_video['video'];

            }
        }

        // Check if a custom meta key was added and use it for embeds
        if ( '' !== airkit_option_value('single', 'video_custom_key') ) {
            
            $custom_meta_key = airkit_option_value('single', 'video_custom_key');
            $custom_video_embed_url = get_post_meta( $post_ID, $custom_meta_key, true);

            // Check if is YouTube or vimeo
            if ( strpos( $custom_video_embed_url, 'youtu' ) > 0 ) {

                $videoType = 'youtube';

            } elseif ( strpos( $custom_video_embed_url, 'vimeo' ) > 0 ) {

                $videoType = 'vimeo';

            } else {
                $videoType = 'external';
            }

            $videopath = $custom_video_embed_url;

        }

        // Check if option to search through content is activated and show the iframe from there
        if ( 'y' == airkit_option_value('single', 'video_from_content') && $videopath == '' ) {
            $videoType = 'embed';
            $videopath = airkit_find_oembed_videos();
        }

        // Check if no video source if available
        if ( $videopath == '' ) {
            return esc_html__('No video source available.', 'gowatch');
        }


        $videopath = $post_format != 'video' ? $videopath : get_post_meta( $post_ID, 'video_embed', true);
        $source_tag = '';
        $conf = array();
        $conf['ads'] = gowatch_video_ads( $post_ID );
        $data_attr = 'data-setup=\'{

                                "techOrder": 
                                    [
                                        "html5", "'. $videoType .'",
                                        "flash"
                                    ], 
                                "sources":
                                [
                                    { 
                                        "type": "video/'. $videoType .'", 
                                        "src": "'. $videopath .'"
                                    }
                                ],
                                "youtube": { 
                                    "rel": 0,
                                    "ytControls": "1",
                                    "autoplay": 0
                                     }
                            }\'';

        if ( $videoType == 'HTML5' ) {
            $data_attr = '';
            $source_tag = '<source src="'.  $videopath .'" type="video/mp4">';
        }

        $additional_styles = '';
        $additional_styles = isset( $options['width'] ) ? 'width: ' . (int)$options['width'] : 880;

        // Create player for HTML5, YouTube and vimeo embeds
        if ( $videoType == 'HTML5' || $videoType == 'youtube' || $videoType == 'vimeo' ) {

            $video = '<div class="gowatch-video-player embedded_videos ' . $sticky_class . '">
                        <video id="videosingle-' . get_the_ID() . '"
                        class="video-js vjs-default-skin videosingle" 
                        controls
                        preload="auto" 
                        width="' . $additional_styles . '"
                        height="495"    
                        poster="'. get_the_post_thumbnail_url( $post_ID, 'gowatch_single' ) .'"
                        '. trim(preg_replace('/\s\s+/', ' ', $data_attr)) .'>
                        '. $source_tag .'
                        </video>
                        <span class="sticky-video-closer"><i class="icon-close"></i></span>
                    </div>';

            $video .= '<span class="tsz-gowatch-config hidden">'. json_encode( $conf ) .'</span>';

        } elseif ( $videoType == 'external' ) {

            // Create the player for oEmbed URLs
            $video = '<div class="embedded_videos ' . $sticky_class . '">' . wp_oembed_get( $videopath ) . '<span class="sticky-video-closer"><i class="icon-close"></i></span></div>';

        } elseif ( $videoType == 'embed' ) {
            // Create the player for embed codes (iframes) from other websites
            $video = '<div class="embedded_videos ' . $sticky_class . '">' . airkit_var_sanitize( $videopath, 'true' ) . '<span class="sticky-video-closer"><i class="icon-close"></i></span></div>';

        }

        return $video;
    }

}
if ( !function_exists( 'airkit_embed_generate' ) ) {

    function airkit_embed_generate(){

        if( is_admin() ) return;

        $current_url = esc_url( home_url( add_query_arg( NULL, NULL ) ) );

        if ( preg_match( "#^http.*\/embed\/\d{1,}#i", $current_url ) ) {

            $array_id = explode( '/', $current_url );
            $post_id = end( $array_id );

            if( ! is_numeric( $post_id ) ) return;

            $args = array(
                'post_type'      => 'video',
                'p'              => $post_id,
                'posts_per_page' => 1
            );

            $embed = get_posts( $args );

            if ( ! isset( $embed[0]->ID ) ) return;

            $video_types = array( 'video_url', 'video_embed', 'video_upload' );

            foreach ($video_types as $value) {

                $meta_val = get_post_meta( $embed[0]->ID, $value, true );
                if ( $meta_val != ''  ) {
                    $video_type = $value;
                    $video = $meta_val;
                }

            }

            // Fix for uploaded videos
            if ( $video_type == 'video_upload' ) {
                $video = wp_get_attachment_url( $video );
            }

            $meta = get_post_meta( $embed[0]->ID, $video_type, true );

            $poster = wp_get_attachment_url( get_post_thumbnail_id( $embed[0]->ID, 'full' ) );


            if ( $video_type != 'video_embed' ) {

                echo
                    '<div id="videoframe" class="video-frame"></div>
                    <script src="https://content.jwplatform.com/libraries/4r6XfcLg.js"></script>
                    <script>
                    var playerInstance = jwplayer("videoframe");

                    playerInstance.setup({
                        file: "' . $video . '",
                        image: "' . $poster . '",
                        width: 640,
                        height: 380,
                        title: "' . $embed[0]->post_title . '"
                    });
                </script>';

            } else if ( $video_type == 'video_embed' ) {

                echo airkit_var_sanitize( $video );

            } else {

                esc_html_e( 'No video', 'gowatch' );
            }
            
            exit;
        }

        
    }
}

add_action('init', 'airkit_embed_generate');

// functions.php
 
add_action( 'init', 'gowatch_exclude_playlists_search', 99 );
 
/**
 * This function is used for excluding the playlist from search
 *
 * @author  Joe Sexton <joe@webtipblog.com>
 */
function gowatch_exclude_playlists_search() {
    global $wp_post_types;
 
    if ( post_type_exists( 'playlist' ) ) {
 
        // exclude from search results
        $wp_post_types['playlist']->exclude_from_search = true;
    }
}


/**
 * Description
 * @param type !function_exists('airkit_retrieve_oembed_thumbnail') 
 * @return type
 */
if( !function_exists('airkit_retrieve_oembed_thumbnail') ) {

    function airkit_retrieve_oembed_thumbnail( $post_ID )
    {

        $video_url = isset( $_POST['video_url'] ) ? $_POST['video_url'] : NULL;

        if( 'y' == airkit_option_value('single', 'auto_thumbnails') && get_post_type( $post_ID ) && strlen(trim($video_url)) > 0 ):

            if( strpos($video_url, 'vimeo') > 0 ) {

                global $wp_filesystem;

                if( empty($wp_filesystem) ) {
                    require_once( ABSPATH .'/wp-admin/includes/file.php' );
                    WP_Filesystem();
                }

                $video_id = str_replace(array('http://vimeo.com/', 'https://vimeo.com/'), '', $video_url);
                $contents = $wp_filesystem->get_contents("http://vimeo.com/api/v2/video/$video_id.php");

                $hash = unserialize($contents);

                $video_thumbnail = $hash[0]['thumbnail_large'];

            }elseif( strpos($video_url, 'youtube' ) > 0 || strpos( $video_url, 'youtu.be' ) > 0 ) {

                preg_match( "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches );

                $video_thumbnail = 'http://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';

                $headers = get_headers( $video_thumbnail );

                if ( strpos($headers[0], '404' ) ) {

                    $video_thumbnail = 'http://img.youtube.com/vi/' . $matches[1] . '/0.jpg';
                }

            }elseif( strpos($video_url, 'dailymotion' ) > 0 ) {
                $video_id = strtok(wp_basename($video_url), '_');
                $video_thumbnail =  "https://api.dailymotion.com/video/$video_id?fields=thumbnail_large_url";
                $resp = wp_remote_get($video_thumbnail, array('sslverify' => false));
                $response = wp_remote_retrieve_body($resp);
                $result = json_decode($response);
                $video_thumbnail = $result->thumbnail_large_url;
            } else {
                return;
            }
        else:
           return;
        endif;

        delete_post_meta( $post_ID, '_thumbnail_id' );

        media_sideload_image( $video_thumbnail, $post_ID, get_the_title( $post_ID ) );

        $attachments = get_posts(
            array(
                'post_type'   =>'attachment',
                'numberposts' => 1,
                'order'       => 'DESC'
            ));

        $attachment = isset( $attachments[0] ) ? $attachments[0] : '';

        set_post_thumbnail( $post_ID, $attachment->ID );
    }

    // Add after a post is addded into the database
    add_action( 'wp_insert_post', 'airkit_retrieve_oembed_thumbnail' );
}


/**
 * Description
 * @param type !function_exists('this') 
 * @return type
 */
if( !function_exists('airkit_find_oembed_videos') ) {

    function airkit_find_oembed_videos( $type = 'embed' ) {

        global $post;

        if ( $post && $post->post_content ) {

            global $shortcode_tags;
            // Make a copy of global shortcode tags - we'll temporarily overwrite it.
            $theme_shortcode_tags = $shortcode_tags;

            // The shortcodes we're interested in.
            $shortcode_tags = array(
                'video' => $theme_shortcode_tags['video'],
                'embed' => $theme_shortcode_tags['embed']
            );
            // Get the absurd shortcode regexp.
            $video_regex = '#' . get_shortcode_regex() . '#i';

            // Restore global shortcode tags.
            $shortcode_tags = $theme_shortcode_tags;

            $pattern_array = array( $video_regex );

            // Get the patterns from the embed object.
            if ( ! function_exists( '_wp_oembed_get_object' ) ) {
                include ABSPATH . WPINC . '/class-oembed.php';
            }
            $oembed = _wp_oembed_get_object();
            $pattern_array = array_merge( $pattern_array, array_keys( $oembed->providers ) );

            // Or all the patterns together.
            $pattern = '#(' . array_reduce( $pattern_array, function ( $carry, $item ) {
                if ( strpos( $item, '#' ) === 0 ) {
                    // Assuming '#...#i' regexps.
                    $item = substr( $item, 1, -2 );
                } else {
                    // Assuming glob patterns.
                    $item = str_replace( '*', '(.+)', $item );
                }
                return $carry ? $carry . ')|('  . $item : $item;
            } ) . ')#is';

            // Simplistic parse of content line by line.
            $lines = explode( "\n", $post->post_content );
            foreach ( $lines as $line ) {
                $line = trim( $line );
                if ( preg_match( $pattern, $line, $matches ) ) {
                    if ( $type == 'url' ) {
                        return $matches[0];
                    }
                    if ( strpos( $matches[0], '[' ) === 0 ) {
                        $ret = do_shortcode( $matches[0] );
                    } else {
                        $ret = wp_oembed_get( $matches[0] );
                    }
                    return $ret;
                }
            }
        }
    }
}

/**
 * Description
 * @param type !function_exists('airkit_remove_firstvideo_content') 
 * @return type
 */
if( !function_exists('airkit_remove_firstvideo_content') ) {

    function airkit_remove_firstvideo_content( $content )
    {
        $content = get_the_content( get_the_ID() );

        $first_media = airkit_find_oembed_videos('url');

        $content = str_replace($first_media, '', $content);

        return $content;
    }

    if ( 'y' == airkit_option_value('single', 'video_from_content') ) {
        add_filter('the_content', 'airkit_remove_firstvideo_content');
    }
}


/**
 * Description
 * @param type !function_exists('airkit_no_results') 
 * @return context
 */
if( !function_exists('airkit_no_results') ) {

    function airkit_no_results()
    {
        return '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">' . esc_html__( 'No results found.', 'gowatch' ) . '</div>';
    }
}


/**
 * Description
 * @param type !function_exists('airkit_post_user_actions') 
 * @return type
 */
if( !function_exists('airkit_post_user_actions') ) {

    function airkit_post_user_actions()
    {
        if ( is_user_logged_in() ) {


            // Edit button
            if ( get_current_user_id() == get_the_author_meta( 'ID' ) && 'yes' == tszf_get_option( 'enable_post_edit', 'tszf_dashboard' ) || is_admin() ) {

                $url = get_frontend_submit_url();
                $url = wp_nonce_url( $url . '?action=edit&pid=' . get_the_ID(), 'tszf_edit' );
                echo '<a class="post-event-links icon-edit" href="'.$url.'">' . esc_html__('Edit', 'gowatch') . '</a>';

            }

            // Delete button
            if ( get_current_user_id() == get_the_author_meta( 'ID' ) && 'yes' == tszf_get_option( 'enable_post_del', 'tszf_dashboard' ) || is_admin() ) {
                $delete_nonce = wp_create_nonce( 'ajax_delete_video' );
                echo '<a class="post-event-links delete-video icon-delete" href="#" data-post-id="' . get_the_ID() . '" data-ajax-nonce="' . $delete_nonce . '">' . esc_html__('Delete', 'gowatch') . '</a>';

            }


            // Report button
            if ( get_post_meta( get_the_ID(), 'airkit_reported', true) == 2 ) {

                echo '<span class="post-event-links icon-tick" data-post-id="' .  get_the_ID() . '">Video was reviewed by admin</span>';

            } elseif( get_post_meta( get_the_ID(), 'airkit_reported', true) == 1 ) {

                // Add the validate button on need
                if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
                    $report_nonce = wp_create_nonce( 'ajax_report_video' );
                    echo '<a href="#" class="post-event-links report-video validate icon-tick" data-ajax-nonce="' . $report_nonce . '" data-post-id="' .  get_the_ID() . '">' . esc_html__('Validate video', 'gowatch') . '</a>';
                } else {
                    echo '<span class="post-event-links icon-attention" data-post-id="' .  get_the_ID() . '">' . esc_html__('Video was reported', 'gowatch') . '</span>';
                }

            } else {

                $report_nonce = wp_create_nonce( 'ajax_report_video' );
                echo '<a href="#" class="post-event-links report-video icon-flag" data-ajax-nonce="' . $report_nonce . '" data-post-id="' .  get_the_ID() . '">' . esc_html__('Report video', 'gowatch') . '</a>';

            }
            
        }
    }
}

/**
 * Function to verify if the videos are visible for logged in users only
 * @param type !function_exists('gowatch_video_subscribers_only') 
 * @return type
 */
if( !function_exists('gowatch_video_subscribers_only') ) {

    function gowatch_video_subscribers_only()
    {
        if ( 'y' == airkit_option_value('single', 'video_subscribers_only') || 'y' == airkit_single_option( 'subscribers_only' ) ) {
            
            if (  !is_user_logged_in() ) {
                return true;
            }

        }

        return false;
    }
}


function gowatch_post_type_tags_fix($request) {
    if ( isset($request['tag']) && !isset($request['post_type']) )
    $request['post_type'] = 'any';
    return $request;
} 
add_filter('request', 'gowatch_post_type_tags_fix');