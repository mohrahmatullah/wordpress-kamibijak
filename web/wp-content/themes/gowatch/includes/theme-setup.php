<?php
define('AIRKIT_THEME_VERSION', time());

function gowatch_activation_settings($theme)
{
    $header = '[{"settings":{"address":"","custom-classes":"","name":"","equal-height":"n","vertical-align":"top","sticky":"n","box-shadow":"n","carousel":"n","expand":"n","fullscreen":"n","scroll-button":"n","reveal-effect":"none","reveal-delay":"delay-500","custom-css":"","element-type":"row","text-color":"rgba(0,0,0,1)","text-align":"auto","bg-color":"rgba(255,255,255,1)","bg-video-mp":"","bg-video-webm":"","bg-img":"","bg-x":"left","bg-y":"top","bg-attachement":"fixed","bg-repeat":"no-repeat","bg-size":"auto","parallax":"n","slider-bg":"none","mask":"n","mask-color":"rgba(221,221,221,1)","mask-gradient-color":"rgba(221,221,221,1)","mask-opacity":"1","gradient-type":"radial","border-top":"n","border-top-width":"1","border-top-color":"rgba(221,221,221,1)","border-right":"n","border-right-width":"1","border-right-color":"rgba(221,221,221,1)","border-bottom":"y","border-bottom-width":"1","border-bottom-color":"rgba(221,221,221,0.29)","border-left":"n","border-left-width":"1","border-left-color":"rgba(221,221,221,1)","margin-top":"0","margin-bottom":"40","padding-top":"40","padding-bottom":"40"},"columns":[{"settings":{"address":"","custom-classes":"","name":"","size":"12","reveal-effect":"none","reveal-delay":"delay-500","columns-small":"12","columns-medium":"12","columns-xsmall":"12","element-type":"column","text-color":"#000000","bg-color":"#ffffff","text-align":"auto","bg-video-mp":"","bg-video-webm":"","bg-img":"","bg-x":"left","bg-y":"top","bg-attachement":"fixed","bg-repeat":"no-repeat","bg-size":"no-repeat","parallax":"n","mask":"n","mask-color":"#DDDDDD","mask-gradient-color":"#DDDDDD","mask-opacity":"1","gradient-type":"radial","border-top":"n","border-top-width":"1","border-top-color":"#DDDDDD","border-right":"n","border-right-width":"1","border-right-color":"#DDDDDD","border-bottom":"n","border-bottom-width":"1","border-bottom-color":"#DDDDDD","border-left":"n","border-left-width":"1","border-left-color":"#DDDDDD","margin-top":"0","margin-bottom":"0","padding-top":"0","padding-right":"0","padding-bottom":"0","padding-left":"0","gutter-right":"20","gutter-left":"20","custom-css":"","lg":"y","md":"y","sm":"y","xs":"y"},"elements":[{"address":"","custom-classes":"","admin-label":"Logo","element-icon":"icon-logo","align":"text-center","element-type":"logo","lg":"y","md":"y","sm":"y","xs":"y"},{"address":"","custom-classes":"","admin-label":"Spacer","element-icon":"icon-resize-vertical","height":"25","element-type":"spacer","lg":"y","md":"y","sm":"y","xs":"y"},{"address":"","custom-classes":"","admin-label":"Menu","element-icon":"icon-menu","menu-id":"","element-type":"menu","styles":"horizontal","font-type":"std","font":{"family":"Open Sans","weight":"normal","size":"14","style":"normal","letter":"0","line":"Inherit","decor":"None","transform":"None"},"custom-colors":"n","bg-color":"rgba(255,255,255,1)","bg-color-hover":"rgba(248,248,248,1)","text-color":"rgba(221,221,221,1)","text-color-hover":"rgba(255,255,255,1)","submenu-bg-color":"rgba(255,255,255,1)","submenu-bg-color-hover":"rgba(248,248,248,1)","submenu-text-color":"rgba(255,255,255,1)","submenu-text-color-hover":"rgba(255,255,255,1)","text-align":"center","icons":"y","description":"y","lg":"y","md":"y","sm":"y","xs":"y"}]}]}]';

    $header = json_decode( $header, true );

    $old_header = get_option( 'gowatch_header' );

    if ( empty( $old_header ) ) {

        update_option( 'gowatch_header', $header );
    }

    $old_templates = get_option( 'gowatch_header_templates' );

    if ( empty( $old_templates ) ) {

        $header_templates = array(
            'default' => array(
                'name'     => esc_html__('Default template', 'gowatch'),
                'elements' => $header
            )
        );

        update_option( 'gowatch_header_templates', $header_templates );
    }

    $footer = '[{"settings":{"address":"","custom-classes":"","name":"","equal-height":"n","vertical-align":"top","sticky":"n","box-shadow":"n","carousel":"n","expand":"n","fullscreen":"n","scroll-button":"n","reveal-effect":"none","reveal-delay":"delay-500","custom-css":"","element-type":"row","text-color":"rgba(0,0,0,1)","text-align":"auto","bg-color":"rgba(246,246,246,1)","bg-video-mp":"","bg-video-webm":"","bg-img":"","bg-x":"left","bg-y":"top","bg-attachement":"fixed","bg-repeat":"no-repeat","bg-size":"auto","parallax":"n","slider-bg":"none","mask":"n","mask-color":"rgba(221,221,221,1)","mask-gradient-color":"rgba(221,221,221,1)","mask-opacity":"1","gradient-type":"radial","border-top":"n","border-top-width":"1","border-top-color":"rgba(231,231,231,0.8)","border-right":"n","border-right-width":"1","border-right-color":"rgba(221,221,221,1)","border-bottom":"n","border-bottom-width":"1","border-bottom-color":"rgba(221,221,221,1)","border-left":"n","border-left-width":"1","border-left-color":"rgba(221,221,221,1)","margin-top":"40","margin-bottom":"0","padding-top":"40","padding-bottom":"40"},"columns":[{"settings":{"address":"","custom-classes":"","name":"","size":"12","reveal-effect":"none","reveal-delay":"delay-500","columns-small":"12","columns-medium":"12","columns-xsmall":"12","element-type":"column","text-color":"rgba(0,0,0,1)","bg-color":"rgba(255,255,255,0)","text-align":"auto","bg-video-mp":"","bg-video-webm":"","bg-img":"","bg-x":"left","bg-y":"top","bg-attachement":"fixed","bg-repeat":"no-repeat","bg-size":"auto","parallax":"n","mask":"n","mask-color":"rgba(221,221,221,1)","mask-gradient-color":"rgba(221,221,221,1)","mask-opacity":"1","gradient-type":"radial","border-top":"n","border-top-width":"1","border-top-color":"rgba(221,221,221,1)","border-right":"n","border-right-width":"1","border-right-color":"rgba(221,221,221,1)","border-bottom":"n","border-bottom-width":"1","border-bottom-color":"rgba(221,221,221,1)","border-left":"n","border-left-width":"1","border-left-color":"rgba(221,221,221,1)","margin-top":"0","margin-bottom":"0","padding-top":"0","padding-right":"0","padding-bottom":"0","padding-left":"0","gutter-right":"20","gutter-left":"20","custom-css":"","lg":"y","md":"y","sm":"y","xs":"y"},"elements":[{"address":"","custom-classes":"","admin-label":"Text","element-icon":"icon-text","text":"<p>Copyright 2017 <a href=\"https:\/\/touchsize.com\/\" target=\"_blank\">TouchSize<\/a>. All rights reserved.<\/p>","element-type":"text","lg":"y","md":"y","sm":"y","xs":"y"}]}]}]';

    $footer = json_decode( $footer, true );

    $old_footer = get_option( 'gowatch_footer' );

    if ( empty( $old_footer ) ) {

        update_option( 'gowatch_footer', $footer );
    }

    $old_templates = get_option( 'gowatch_footer_templates' );

    if ( empty( $old_templates ) ) {

        $footer_templates = array(
            'default' => array(
                'name'     => esc_html__( 'Default template', 'gowatch' ),
                'elements' => $footer
            )
        );

        update_option( 'gowatch_footer_templates', $footer_templates );
    }

    $shortcodes = array(
       'map'  => esc_html__( 'Map', 'gowatch' ),
       'icon' => esc_html__( 'Icon', 'gowatch' ),
       'tab' => esc_html__( 'Tabs', 'gowatch' ),
       'toggle' => esc_html__( 'Toggle', 'gowatch' ),
       'social_buttons' => esc_html__( 'Social icons', 'gowatch' ),
       'sidebar' => esc_html__( 'Sidebar', 'gowatch' ),
       'featured_area' => esc_html__( 'Featured area', 'gowatch' ),
       'grid' => esc_html__( 'Grid articles', 'gowatch' ),
       'big' => esc_html__( 'Big posts articles', 'gowatch' ),
       'list_view' => esc_html__( 'List view articles', 'gowatch' ),
       'numbered-list' => esc_html__( 'Numbered list view articles', 'gowatch' ),
       'thumbnail' => esc_html__( 'Thumbnail view articles', 'gowatch' ),
       'mosaic' => esc_html__( 'Mosaic view articles', 'gowatch' ),
       'timeline' => esc_html__( 'Timeline view articles', 'gowatch' ),
       'super' => esc_html__( 'Super posts articles', 'gowatch' ),
       'category' => esc_html__( 'Category view articles', 'gowatch' ),
       'small-articles' => esc_html__( 'Small view articles', 'gowatch' ),
       'pricing_tables' => esc_html__( 'Pricing tables', 'gowatch' ),
       'slider' => esc_html__( 'Slider', 'gowatch' ),
       'gallery' => esc_html__( 'Gallery', 'gowatch' ),
       'testimonials' => esc_html__( 'Testimonials', 'gowatch' ),
       'callaction' => esc_html__( 'Call to action', 'gowatch' ),
       'delimiter' => esc_html__( 'Delimiter', 'gowatch' ),
       'title' => esc_html__( 'Title', 'gowatch' ),
       'spacer' => esc_html__( 'Spacer', 'gowatch' ),
       'buttons' => esc_html__( 'Button', 'gowatch' ),
       'contact_form' => esc_html__( 'Contact form', 'gowatch' ),
       'image_carousel' => esc_html__( 'Image carousel', 'gowatch' ),
       'listed_features' => esc_html__( 'Listed features', 'gowatch' ),
       'features_block' => esc_html__( 'Icon boxes', 'gowatch' ),
       'counter' => esc_html__( 'Counter', 'gowatch' ),
       'list_products' => esc_html__( 'Products grid', 'gowatch' ),
       'banner' => esc_html__( 'Banner', 'gowatch' ),
       'ribbon' => esc_html__( 'Ribbon banner', 'gowatch' ),
       'timeline-features' => esc_html__( 'Timeline features', 'gowatch' ),
       'posts_carousel' => esc_html__( 'Posts carousel', 'gowatch' ),
       'count_down' => esc_html__( 'Countdown timer', 'gowatch' ),
       'powerlink' => esc_html__( 'Powerlink', 'gowatch' ),
       'calendar' => esc_html__( 'Event calendar', 'gowatch' ),
       'alert' => esc_html__( 'Alert box', 'gowatch' ),
       'skills' => esc_html__( 'Skills', 'gowatch' ),
       'chart_pie' => esc_html__( 'Pie chart', 'gowatch' ),
       'chart_line' => esc_html__( 'Line chart', 'gowatch' ),
       'boca' => esc_html__( 'Boca slider', 'gowatch' ),
       'nona' => esc_html__( 'Nona slider', 'gowatch' ),
       'list_users' => esc_html__( 'List users', 'gowatch' ),
    );

    update_option( 'gowatch_shortcodes', $shortcodes );

    // Set the active airkit theme to this one
    update_option( 'airkit_last_active_theme', 'gowatch' );
}

add_action('after_switch_theme', 'gowatch_activation_settings');

if ( function_exists( 'add_theme_support' ) ) {

	/*
	 * Makes gowatch available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( 'gowatch', get_template_directory() . '/languages' );

	// Enables the navigation menu ability
	add_theme_support('menus');

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Enables post-thumbnail support
	add_theme_support( 'post-thumbnails', array( 'video', 'post', 'page', 'ts_teams', 'feature-blocks', 'portfolio', 'ts_testimonials', 'product', 'event', 'ts-gallery' ) );

	add_theme_support( 'post-formats', array( 'video', 'gallery', 'image', 'audio' ) );

}

function airkit_after_setup_theme()
{
   /*
     * Makes gowatch available for translation.
     *
     * Translations can be added to the /languages/ directory.
     */
    load_theme_textdomain( 'gowatch', get_template_directory() . '/languages' );

    // Enables the navigation menu ability
    add_theme_support('menus');

    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Enables post-thumbnail support
    add_theme_support( 'post-thumbnails', array( 'video', 'post', 'page', 'ts_teams', 'feature-blocks', 'portfolio', 'ts_testimonials', 'product', 'event', 'ts-gallery' ) );

    add_theme_support( 'post-formats', array( 'video', 'gallery', 'image', 'audio' ) );

    add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'airkit_after_setup_theme' );

if ( ! function_exists( '_wp_render_title_tag' ) ) {

    function airkit_slug_render_title()
    {
        ?>
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <?php
    }

    add_action( 'wp_head', 'airkit_slug_render_title' );

}


// This theme uses wp_nav_menu()
function register_gowatch_menu() {
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary' , 'gowatch' )
	));
}

add_action( 'init', 'register_gowatch_menu' );

// Verify if more than one page exists
function show_posts_nav() {
	global $wp_query;
	return ( $wp_query->max_num_pages > 1 );
}

/**
* Render image gallery from attached images to post
*/
if ( ! function_exists( 'airkit_post_attached_images' ) ) {

    function airkit_post_attached_images( $post_ID, $size = 'grid' ){

        /*check the meta data where the attached image ids are stored*/

        if ( metadata_exists( 'post', $post_ID, '_post_image_gallery' ) ) {

            $product_image_gallery = get_post_meta( $post_ID, '_post_image_gallery', true );

            $img_id_array = array_filter( explode( ',', $product_image_gallery ) );
        }

        if(isset($img_id_array) && is_array($img_id_array)){
            foreach ($img_id_array as $value) {
                $attachments[$value] = $value; // create attachments array in hte format that will work for us
            }
        }
        if( isset($attachments) && count($attachments) > 0 ){

            if( is_singular() ) {
                ?>
                    <h4 class="gallery-format-title">
                        <i class="icon-gallery"></i>
                        <?php esc_html_e( 'Image gallery', 'gowatch' ); ?>
                        <sup class="attachments-count"> ( <?php echo count( $attachments ); ?> ) </sup>
                    </h4>
                <?php 
            }

            $additional_items = ''; /*in this string we will store the images that are left after loading the number of images defined in $images_to_show_first var*/
            $counter = 0; ?>
            <ul class="attached-images row cols-by-4">
                <?php
                foreach($attachments as $att_id => $attachment) {
                    $full_img_url = wp_get_attachment_url($att_id);
                    $title = get_the_title($att_id);

                    $thumbnail_url = aq_resize( $full_img_url, '500', '300', true, false ); //resize img, Return an array containing url, width, and height.

                    $src = esc_url( $thumbnail_url[0] );

            ?>
                    <li class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                        <a href="<?php echo esc_url($full_img_url); ?>" data-fancybox="group-<?php echo airkit_var_sanitize( $post_ID, 'esc_attr' ); ?>">                     
                            <img src="<?php echo airkit_var_sanitize( $src, 'esc_url' ); ?>"  data-original="<?php echo airkit_var_sanitize( $src, 'esc_url' ); ?>" alt="" data-width="<?php echo esc_attr($thumbnail_url[1]); ?>" data-height="<?php echo esc_attr($thumbnail_url[2]); ?>" />
                        </a>
                    </li>

             <?php } ?>
         </ul>
        <?php }
    }
}

add_action('media_buttons',  'gowatch_toggle_editor');

function gowatch_toggle_editor() {

    global $post, $wp_version;

    if ( version_compare($wp_version, '5.0', '<=') ) {


      $state = 'enabled';

      if (isset($post)) {

          if ($post->post_type === 'page') {

              $use_template = get_post_meta($post->ID, 'ts_use_template', true);

              if( $use_template == '' ){
                  add_post_meta($post->ID, 'ts_use_template', '0', true);
                  $use_template = 0;
              }

              if ((int)$use_template === 1) {
                  $builder_status = 'enabled';
              } else {
                  $builder_status = 'disabled';
              }

              $button = '<div class="icon-blocks" id="ts-toggle-layout-builder" data-state="'.$builder_status.'">' . esc_html__('Toggle Layout Builder', 'gowatch') . '</div>';
  ?>
              <script>
              jQuery(document).ready(function($) {

                  var hide_editor = function(button) {

                      $('#postcustom').find('input[value="ts_use_template"]').closest('td').siblings('td').find('textarea').val(1);

                      $('#content-tmce').hide();
                      $('#insert-media-button').hide();
                      $('#content-html').hide();
                      $('#wp-content-editor-container').hide();
                      $('#airkit_layout_id').show();
                      $('#ts_page_options').hide();
                      $('#post-status-info').hide();
                      $('#ts-import-export').show();
                      $('#airkit_sidebar').hide();
                      button.attr('data-state', 'enabled');
                  };

                  var show_editor = function(button) {
                      $('#postcustom').find('input[value="ts_use_template"]').closest('td').siblings('td').find('textarea').val(0);

                      $('#content-tmce').show();
                      $('#content-html').show();
                      $('#wp-content-editor-container').show();
                      $('#post-status-info').show();
                      $('#airkit_layout_id').hide();
                      $('#ts_page_options').show();
                      $('#ts-import-export').hide();
                      $('#airkit_sidebar').show();
                      $('#insert-media-button').show();
                      button.attr('data-state', 'disabled');
                  };

                  <?php if ( $builder_status === 'enabled' ): ?>
                      var button = $('#ts-toggle-layout-builder');
                      hide_editor(button);
                      $('#airkit_layout_id').show();
                      $('#ts_page_options').hide();
                      $('#airkit_sidebar').hide();
                      $('#ts-import-export').show();
                  <?php else: ?>
                      var button = $('#ts-toggle-layout-builder');
                      show_editor(button);
                      $('#airkit_layout_id').hide();
                      $('#ts_page_options').show();
                      $('#airkit_sidebar').show();
                      $('#ts-import-export').hide();
                  <?php endif; ?>

                  // Toggle Layout builder
                  $("#ts-toggle-layout-builder").toggle(function() {
                      var button = $(this);
                      <?php if ($builder_status === 'enabled'): ?>
                          show_editor(button);
                      <?php else: ?>
                          hide_editor(button);
                      <?php endif; ?>

                  }, function() {
                      var button = $(this);
                      <?php if ($builder_status === 'enabled'): ?>
                          hide_editor(button);
                      <?php else: ?>
                          show_editor(button);
                      <?php endif; ?>
                  });
              });
              </script>

  <?php
              if( current_user_can('manage_options') ) return $button;
          }
      } else {
          return '';
      }
    }
}

if ( function_exists( 'load_child_theme_textdomain' ) ){
    load_child_theme_textdomain( 'gowatch' );
}

/**
 * Function to add the builder button in the top bar for WP5.0+
 * @param type !function_exists('airkit_add_builder_button') 
 * @return type
 */
if( !function_exists('airkit_add_builder_button') ) {

    global $wp_version;
    if ( version_compare($wp_version, '5.0') >= 0 ) {
      add_filter('admin_footer', 'airkit_add_builder_button');
    }


    function airkit_add_builder_button()
    {
      global $post;

      if( get_post_type( $post ) !== 'page' ) return false;
      // Check if builder is being used
      $use_template = get_post_meta($post->ID, 'ts_use_template', true);

      if( $use_template == '' ){
          add_post_meta($post->ID, 'ts_use_template', '0', true);
          $use_template = 0;
      }

      if ((int)$use_template === 1) {
          $builder_status = 'enabled';
      } else {
          $builder_status = 'disabled';
      }

      $buider_text = $builder_status == 'enabled' ? 'Disable Layout Builder' : 'Activate Layout Builder';

      $button = '<div class="icon-blocks airkit_builder_btn" id="ts-toggle-layout-builder" style="display: none;" data-post-id="' . esc_attr($post->ID) . '" data-state="' . esc_attr($builder_status) . '">' . esc_html( $buider_text ) . '</div>';

      echo $button;
    }
}

add_filter ('admin_body_class', 'airkit_admin_body_classes');
function airkit_admin_body_classes ($classes) {

  global $wp_version;
  
  if (version_compare($wp_version, '5.0') >= 0)
    $classes .= ' wp5 ';

  return $classes;

}


function airkit_verify_ls(){

    // Check if key exists in database
    $key_status = get_option('gowatch_license_status');
    $key_verification = get_option('gowatch_key_last_verification');

    if( empty($key_status) ) {
        // Set the new verification
        update_option('gowatch_key_last_verification', strtotime('+31 days', strtotime(date('Y-m-d'))));
        update_option('gowatch_license_status', 'pending');
    } else {
        $key = get_option('gowatch_key');
        $verification = wp_remote_get( 'https://touchsize.com/verify/?code=' . esc_attr($key) );
        if ( strpos( strtolower( $verification['body'] ), 'is valid' ) !== false ) {
            if ( strpos( strtolower( $verification['body'] ), 'gowatch' ) !== false ) {
                update_option('gowatch_license_status', 'valid');
            } else {
                delete_option('gowatch_key');
            }
        }
    }
}
add_action( 'admin_notices', 'airkit_verify_ls' );
function airkit_ls_notice() {
    $key_verification = get_option('gowatch_key_last_verification');
    $ls_status = get_option('gowatch_license_status');
    if( $ls_status == 'valid' ) return;
    ?>
    <div class="notice notice-error key-notice">
        <h3><?php esc_html_e( 'You need to activate goWatch', 'gowatch' ) ?></h3>
        <?php if( !airkit_verify_ls_activation() ): ?>
            <p>
                <?php echo esc_attr__( 'To use or keep using this product, you will have to register your license. Please make sure you add and validate your license before ', 'gowatch' ) . '<strong>' . date('M d, Y', $key_verification) . '</strong>' . esc_html__( ' or the theme options will not work after that date.' ); ?>
            </p>
        <?php else: ?>
            <p>
                <?php echo esc_attr__( 'The period for activating the product has passed. The theme options have been deactivated.', 'gowatch' ); ?>
            </p>
        <?php endif; ?>
        <p>Don't know where to find your license key? <a href="https://help.touchsize.com/knowledgebase/how-to-get-your-themeforest-purchase-key/" target="_blank">Here is a tutorial</a>.</p>
        <p>
            <strong><?php esc_html_e( 'To activate please paste the purchase code and click save', 'gowatch' ); ?></strong>
            <input size="60" placeholder="ex: b32b82-432vbb2-3284v234824b23842" type="text" name="airkit-license-code" id="airkit-license-code" autocomplete="off" />
            <a href="#" id="airkit-license-saver" class="button button-primary"><?php esc_html_e( 'Save License Code', 'gowatch' ); ?></a>
        </p>
    </div>
    <?php
}
add_action( 'admin_notices', 'airkit_ls_notice' );

function airkit_verify_ls_activation(){
    $key_verification = get_option('gowatch_key_last_verification');
    $key_status = get_option('gowatch_license_status');
    if( strtotime(date('Y-m-D')) < $key_verification || $key_status == 'valid' ) {
        $out = false;
    } else {
        $out = true;
    }

    return $out;
}


function airkit_save_ls_code()
{   
    $license = esc_attr(trim($_POST['license']));
    if( !empty($license) ) {
        $status = 'success';
        $message = 'Key Saved Sucessfully';
        update_option('gowatch_key', $license);

        // Make the confirmation
        $admin_email = get_option('admin_email');

        $response = wp_remote_post( 'https://touchsize.com/red-area/activate.php', array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => array( 'theme' => 'goWatch', 'url' => home_url(), 'license' => $license, 'email' => $admin_email ),
            'cookies' => array()
            )
        );

    } else {
        $status = 'error';
        $message = 'There was no key entered';
    }
    $response = array('status' => $status, 'message' => $message);
    wp_send_json( $response );
    die();
}

add_action('wp_ajax_airkit_save_ls_code', 'airkit_save_ls_code');


?>