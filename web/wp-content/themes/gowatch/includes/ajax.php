<?php
/*
 * No camelCase please.
 */
function airkit_edit_template_element() {
	check_ajax_referer( 'builder-nonce', 'nonce' );

	airkit_BuilderSettings::modal_fields( $_POST['elementType'] );

	die();
}

add_action('wp_ajax_airkit_edit_template_element', 'airkit_edit_template_element');


function airkit_get_icons() {
	check_ajax_referer( 'builder-nonce', 'nonce' );

	$icons = get_option( 'gowatch_icons', array() );

	$icons = explode(',', $icons);

	$selected = isset( $_POST['selected'] ) ? $_POST['selected'] : '';

	$list = '';
	$keys = '';

	foreach ( $icons as $val ) {

		$list .= '<li data-filter="'. $val .'">
					<i class="'. $val .' clickable-element" data-option="'. $val .'"></i>
			  </li>';
			  
		$keys .= '<option '. selected( $selected, $val, false ) .' value="'. $val .'"></option>';

	}

	$options = array(

		'list' => $list,
		'val'  => $keys
	);

	echo json_encode( $options );

	die();
}

add_action('wp_ajax_airkit_get_icons', 'airkit_get_icons');

function gowatch_setDataAd(){

    check_ajax_referer('security', 'nonce');

    if ( !isset($_POST['key']) || !is_numeric(intval($_POST['key'])) || empty($_POST['event']) ) die();

    $event = $_POST['event'];

    $t_key = ( isset( $_POST['key'] ) && $_POST['key'] !== '0' )  ? $_POST['key'] : '';


    if ( $event == 'clicks' ) {
    	$current_clicks = get_post_meta( (int)$_POST['key'], 'ad_served_clicks', true );
    	update_post_meta( (int)$_POST['key'], 'ad_served_clicks', (int)$current_clicks + 1 );

    } elseif ( $event == 'views' ) {

    	$current_views = get_post_meta( (int)$_POST['key'], 'ad_served_views', true );
    	update_post_meta( (int)$_POST['key'], 'ad_served_views', (int)$current_views + 1 );

    }
}
add_action('wp_ajax_gowatch_setDataAd', 'gowatch_setDataAd');
add_action('wp_ajax_nopriv_gowatch_setDataAd', 'gowatch_setDataAd');

function airkit_save_touchsize_news() {
	check_ajax_referer( 'airkit_save_touchsize_news', 'token' );

	header('Content-Type: application/json');

	$last_update = time();
	$options = get_option('gowatch_red_area', array());

	$news = @$_POST['news'];
	$parsed_news = array();
	$allowed_html = array('a', 'br', 'em', 'strong', 'img');

	if ( is_array($news) && ! empty($news) ) {
		foreach ($news as $news_id => $n) {
			$parsed_news[] = '<li><a href="' . esc_url($n['url']) . '" target="_blank">' . wp_kses($n['title'], $allowed_html) . '</a><em>' .   $n['date'] . '</em>
				<img src="' . esc_url($n['image']) . '" /><p>' . wp_kses($n['excerpt'], $allowed_html) . '</p>
			</li>';
		}
	}

	if ( ! empty( $parsed_news ) ) {
		$parsed_news = '<ul>' . implode( "\n", $parsed_news ) . '</ul>';
	}

	$alerts = @$_POST['alerts'];

	if ( is_array( $alerts ) && ! empty( $alerts ) ) {
		if ( isset($alerts['id']) && isset($alerts['message']) ) {
			$parsed_alerts['id'] = $alerts['id'];
			$parsed_alerts['message'] = stripslashes($alerts['message']);
		} else {
			$parsed_alerts['id'] = 0;
			$parsed_alerts['message'] = '';
		}
	}

	$options['news']  = $parsed_news;
	$options['alert'] = $parsed_alerts;
	$options['time']  = time();

	if ( ! isset($options['hidden_alerts']) ) {
		$options['hidden_alerts'] = array();
	}

	update_option('gowatch_red_area', $options);

	$data = array(
		'status'  => 'ok',
		'message' => esc_html__( 'Saved', 'gowatch')
	);

	echo json_encode($data);
	die();
}

add_action('wp_ajax_airkit_save_touchsize_news', 'airkit_save_touchsize_news');

function airkit_hide_touchsize_alert() {
	check_ajax_referer( 'remove-gowatch-alert', 'token' );

	header('Content-Type: application/json');

	$options = get_option('gowatch_red_area', array(
		'news' => '',
		'alert' => array(
			'id' => 0,
			'message' => ''
		),
		'hidden_alerts' => array(),
		'time' => time()
	));

	$alert_id = sanitize_text_field( $_POST['alertID'] );

	if ( ! in_array( $alert_id, $options['hidden_alerts'], true ) ) {

		array_push( $options['hidden_alerts'], $alert_id );
	}

	update_option('gowatch_red_area', $options);

	$data = array(
		'status'  => 'ok',
		'message' => esc_html__( 'Saved', 'gowatch')
	);

	echo json_encode($data);
	die();
}

add_action('wp_ajax_airkit_hide_touchsize_alert', 'airkit_hide_touchsize_alert');

//========================================================================
// Save/Edit templates ===================================================
// =======================================================================

// Load template
function airkit_load_template() {
	header( 'Content-Type: application/json' );

	$template_id = @$_GET['template_id'];
	$location    = @$_GET['location'];

	$result = airkit_Template::load_template( $location, $template_id );

	echo json_encode( $result );

	die();
}

add_action('wp_ajax_airkit_load_template', 'airkit_load_template');

// Save blank template
function airkit_save_layout() {
	// if not administrator, kill WordPress execution and provide a message
	if ( ! is_admin() ) {

		return false;
	}

	$location    = @$_POST['location'];
	$mode		 = @$_POST['mode'];

	$content = json_decode( wp_unslash( $_POST['data'] ), true );


	if ( isset( $content['post_id'] ) ) {

		$_POST['post_id'] = $content['post_id'];

		update_post_meta( $content['post_id'], 'ts_use_template', 1 );
	}

	$_POST['content'] = $content['content'];

	unset( $_POST['data'] );

	$data = array( 'status' => 'ok', 'message' => '' );
	$response = airkit_Template::save( $mode, $location );

	if ( ! $response ) {

		$data['status'] = 'error';
		$data['message'] = esc_html__( 'Cannot save this template', 'gowatch' );
	}

	wp_send_json( $data );
}

add_action('wp_ajax_airkit_save_layout', 'airkit_save_layout');

// Remove template
function airkit_remove_template() {
	// if not administrator, kill WordPress execution and provide a message
	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}

	header('Content-Type: application/json');
	// check_ajax_referer( 'remove-gowatch-alert', 'token' );

	$template_id = @$_POST['template_id'];
	$location    = @$_POST['location'];

	$result = airkit_Template::delete( $location, $template_id );

	if ( $result ) {

		$data = array(
			'status' => 'removed',
			'message' => ''
		);

	} else {

		$data = array(
			'status' => 'error',
			'message' => esc_html__('Cannot delete this template', 'gowatch')
		);
	}

	echo json_encode($data);
	die();
}

add_action('wp_ajax_airkit_remove_template', 'airkit_remove_template');

function airkit_load_all_templates() {
	$location = @$_POST['location'];
	$templates = airkit_Template::get_all_templates( $location );

	$edit = '';
	if ( $templates ) {

		foreach ( $templates as $template_id => $template ) {

			$remove_template = '';

			if ( $template_id !== 'default' ) {

				$remove_template = '<a href="#" data-template-id="' . esc_attr( $template_id ) . '" data-location="' . esc_attr( $location ) . '" class="ts-remove-template icon-delete">' . esc_html__( 'remove', 'gowatch' ) . '</a>';
			}

			$edit .= '<tr>
						<td><input type="radio" name="template_id" value="' . esc_attr($template_id) . '" id="' . esc_attr($template_id) . '"/></td>
						<td>
							<label for="' . $template_id . '">' . $template['name'] . '
							</label>
						</td>
						<td>' .
							$remove_template .
						'</td>
					</tr>';
		}
	}

	echo airkit_var_sanitize( $edit, 'the_kses' );
	die();
}

add_action('wp_ajax_airkit_load_all_templates', 'airkit_load_all_templates');

function airkit_toggle_layout_builder() {
	// if not administrator, kill WordPress execution and provide a message
    if ( !current_user_can( 'manage_options' ) ) return false;

	$post_ID = (int)$_POST['post_id'];
	$state  = @$_POST['state'];

	$valid_states = array(
		'enable' => 1,
		'disable' => 0
	);

	if ( array_key_exists($state, $valid_states) ) {
		update_post_meta((int)$post_ID, 'ts_use_template', $valid_states[$state]);
	}

	wp_send_json( 'Switched to ' . $state, null );

	die();
}

add_action('wp_ajax_airkit_toggle_layout_builder', 'airkit_toggle_layout_builder');

/**
 * AJAX Set as featured.
 */
function airkit_update_features() {

    $nonce = $_POST['nonce_featured'];

    if ( !wp_verify_nonce( $nonce, 'extern_request_die' ) ) return false;
    if ( !current_user_can( 'manage_options' ) ) return false;

    $post_ID = ( isset( $_POST['value_checkbox'] ) && (int)$_POST['value_checkbox'] !== 0 ) ? (int)$_POST['value_checkbox'] : NULL;
    $value_checkbox = ( isset( $_POST['checked'] ) && $_POST['checked'] !== '' && ( $_POST['checked'] == 'yes' || $_POST['checked'] == 'no' ) ) ? $_POST['checked'] : 'no';

    if( isset( $post_ID ) ){

       update_post_meta( $post_ID, 'featured', $value_checkbox );

    }

    die();
}

if( is_admin() ) {

    add_action('wp_ajax_airkit_update_features', 'airkit_update_features');
    add_action('wp_ajax_nopriv_airkit_update_features', 'airkit_update_features');

}

/**
 * Delete front-end posts
 */
if ( !function_exists('airkit_remove_post') ) {

	function airkit_remove_post() {

	    $nonce = $_POST['security'];

	    if ( !wp_verify_nonce( $nonce, 'ajax_delete_video' ) ) return false;

	    $post_ID = sanitize_text_field( $_POST['post_id'] );
	    $post_title = get_the_title( $post_ID );

	    $deleted_post = wp_delete_post( $post_ID, false );


	    if ( !is_wp_error( $deleted_post ) ) {

	    	$return['alert'] 	= 'success';
		    $return['label'] 	= esc_html__( 'Deleted', 'gowatch' );
		    $return['icon'] 	= 'icon-flag';
		    $return['message']  = sprintf( esc_html__( 'You have successfully deleted %s', 'gowatch' ), '<strong>' . esc_html( $post_title ) . '</strong>' );
		    $return['redirect'] = home_url('/');;

	    } else {

	    	$return['alert'] = 'error';
		    $return['label'] = esc_html__( 'Delete', 'gowatch' );
		    $return['icon'] = 'icon-error';
		    $return['message'] = sprintf( esc_html__( 'There was an error deleting %s', 'gowatch' ), '<strong>' . esc_html( $post_title ) . '</strong>' );

	    }

	    wp_send_json( $return, false );

	    die();
	}

	if( is_admin() ) {

	    add_action('wp_ajax_airkit_remove_post', 'airkit_remove_post');
	    add_action('wp_ajax_nopriv_airkit_remove_post', 'airkit_remove_post');

	}
}

/*
 * AJAX Set Active Frontend Form .
 */
function airkit_set_active_form() {

    $nonce = $_POST['admin_nonce'];
    if ( !wp_verify_nonce( $nonce, 'extern_request_die' ) ) return false;
    if ( !current_user_can( 'manage_options' ) ) return false;

    $form_id = isset( $_POST['form_id'] ) ? $_POST['form_id'] : NULL;
    $form_type = isset( $_POST['form_type'] ) ? $_POST['form_type'] : NULL;

    if( isset( $form_id ) ) {

    	if( $form_type == 'submit' ) {

        	airkit_update_option( 'general', 'frontend_submission_form', $form_id );    	

        } elseif( $form_type == 'register' ) {

        	airkit_update_option( 'general', 'frontend_registration_form', $form_id );    	

        }

    }

    die();

}

if( is_admin() ) {
    add_action('wp_ajax_airkit_set_active_form', 'airkit_set_active_form');
}


//function generate random likes for all posts
function airkit_generate_like_callback() {

   check_ajax_referer( 'like-generate', 'nonce' );

    if ( ! current_user_can( 'manage_options' ) ) return false;

    global $wpdb;

    $sql = $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type != %s", 'attachment' );

    $posts = $wpdb->get_results( $sql, ARRAY_N );

    if( isset( $posts ) && is_array( $posts ) && ! empty( $posts ) ){

        foreach ( $posts as $id ) {

        	if ( $_POST['todo'] == 'generate' ) {

        		$rand_likes = rand( 50, 100 );
        		$rand_view  = rand( 2, 5 );

        		update_post_meta( $id[0], 'airkit_views', $rand_likes * $rand_view );

        	} else {

        		$rand_likes = 0;
        	}

        	update_post_meta( $id[0], 'airkit_likes', $rand_likes );	
        }

    }

    echo '<div class="ts-succes-like">' . esc_html__( 'Done !', 'gowatch' ) . '</div>';

    die();
}

add_action('wp_ajax_ts_generate_like', 'airkit_generate_like_callback');

//function generate the pagination read more
function airkit_pagination_callback() {

    if ( ! isset( $_POST['args'], $_POST['paginationNonce'], $_POST['loop'] ) ) die();

	if ( !defined('TSZ_DEMO') && TSZ_DEMO != true ) {
	    check_ajax_referer( 'pagination-read-more', 'paginationNonce' );
	}

    $args = airkit_Compilator::build_str( $_POST['args'], 'decode' );

    $loop = is_numeric( $_POST['loop'] ) ? (int)$_POST['loop'] : 0;

    if ( ! is_array( $args ) ) die();

    if( isset( $args['options'] ) && is_array( $args['options'] ) ) {

        $options = $args['options'];
        $options['loop'] = $loop;
        unset( $args['options'] );
    }

    if ( isset( $options ) && is_array( $options ) ) {

    	$args['posts_per_page'] = isset( $args['posts_per_page'] ) ? (int)$args['posts_per_page'] : (isset($options['posts-limit']) ? (int)$options['posts-limit'] : 0);
        $offset = isset( $args['offset'] ) ? (int)$args['offset'] : 0;

        if ( 0 == $args['posts_per_page'] ) {

            $args['posts_per_page'] = get_option('posts_per_page');
        }

        if ( 0 < $loop ) {

            $args['offset'] = $offset + ( $args['posts_per_page'] * $loop );
        }

        if ( 0 == $loop ) {

            $args['offset'] = $offset + $args['posts_per_page'];
        }

    	$args['post_status'] = 'publish';

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {

        	if( $options['post-type'] === 'event' ) {

        		$options['ajax-load-more'] = true;

        		echo airkit_Compilator::events_element( $options, $query );

        	} elseif ( $options['post-type'] === 'product' ) {

        		$options['ajax-load-more'] = true;
        		$options['query'] = $query;

        		echo airkit_Compilator::list_products_element( $options );        		

        	} else {

            	echo airkit_Compilator::view_articles( $options, $query, false );

            }

        } else {

           echo '0';
           
        }
    }

    die();
}

add_action('wp_ajax_ts_pagination', 'airkit_pagination_callback');
add_action('wp_ajax_nopriv_ts_pagination', 'airkit_pagination_callback');

function airkit_set_share_callback() {

	check_ajax_referer( 'security', 'ts_security' );

	if( isset($_POST['postId'], $_POST['social']) ){

		$post_ID = ((int)$_POST['postId'] !== 0) ? (int)$_POST['postId'] : '';
		$all_social = array('facebook', 'twitter', 'gplus', 'linkedin', 'tumblr', 'pinterest');
		$social = (in_array($_POST['social'], $all_social)) ? $_POST['social'] : '';

		if( isset($_COOKIE['ts-syncope-social-' . $social . '-id-' . $post_ID]) ){
			echo '-1';
		}else{
			$count_social = get_post_meta($post_ID, 'airkit_social_' . $social, true);
			$total = 0;

			foreach($all_social as $socialName){
				$countSocial = get_post_meta($post_ID, 'airkit_social_' . $socialName, true);
				if( isset($countSocial) && !empty($countSocial) ){
					$total += (int)$countSocial;
				}
			}

			if( isset($count_social) && (int)$count_social > 0 ){
				$count_total = (int)$count_social + 1;
				$total = (int)$total + 1;
				update_post_meta($post_ID, 'airkit_social_' . $social, $count_total);
				update_post_meta($post_ID, 'airkit_social_count', $total);
			}else{
				update_post_meta($post_ID, 'airkit_social_' . $social, 	1);
				$total = (int)$total + 1;
				update_post_meta($post_ID, 'airkit_social_count', $total);
			}
			setcookie('ts-syncope-social-' . $social . '-id-' . $post_ID, 1, time() + 86400 * 7);
			echo (int)$count_social + 1;
		}
	}

    die();
}
add_action('wp_ajax_ts_set_share', 'airkit_set_share_callback');
add_action('wp_ajax_nopriv_ts_set_share', 'airkit_set_share_callback');

function airkit_delete_custom_icon() {

	check_ajax_referer( 'feature_nonce', 'nonce' );

	$options = get_option('gowatch_icons');

	if( isset($_POST['icon']) && !empty($_POST['icon']) ){

		if( !empty($options['custom-icon']) ){

			$removeKey = '';

			foreach($options['custom-icon'] as $item => $value){

				if( !empty($value['classes']) ){

					$classes = explode(',', $value['classes']);
					$classKey = '';

					foreach($classes as $key => $class){
						if( $class == $_POST['icon'] ) $classKey = $key;
					}

					unset($classes[$classKey]);
					$options['custom-icon'][$item]['classes'] = implode(',', $classes);

					$css = preg_replace('/.'. $_POST['icon'] .'::before *\{[\s\S]*?\}{1}/', '', $value['css']);
					$options['custom-icon'][$item]['css'] = $css;

					$classesGeneral = explode(',', $options['icons']);
					$classKeyGeneral = '';

					foreach($classesGeneral as $keyGeneral => $classGeneral){
						if( $classGeneral == $_POST['icon'] ) $classKeyGeneral = $keyGeneral;
					}

					unset($classesGeneral[$classKeyGeneral]);

					$options['icons'] = implode(',', $classesGeneral);

				}

				if( $options['custom-icon'][$item]['classes'] == '' ){
					foreach($value['ids'] as $idAttachment){
						wp_delete_attachment($idAttachment, true);
					}

					unset($options['custom-icon'][$item]);
				}

			}

		}
	}

	if( isset($_POST['key']) && isset($options['custom-icon'][$_POST['key']]) ){

		foreach($options['custom-icon'][$_POST['key']]['ids'] as $idAttachment){
			wp_delete_attachment($idAttachment, true);
		}

		$generalClasses = explode(',', $options['icons']);
		$removeClasses = explode(',', $options['custom-icon'][$_POST['key']]['classes']);

		$delete = array_intersect($generalClasses, $removeClasses);

		foreach($delete as $keyForDelete => $class ){
			unset($generalClasses[$keyForDelete]);
		}

		$options['icons'] = implode(',', $generalClasses);

		unset($options['custom-icon'][$_POST['key']]);

	}

	$result = update_option('gowatch_icons', $options, false);

	if( $result ){
		echo 'ok';
	}

    die();
}
add_action('wp_ajax_airkit_delete_custom_icon', 'airkit_delete_custom_icon');

function airkit_get_terms() {

	if( !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'extern_request_die') ) return;

	$terms = get_terms($_POST['taxonomy'], array('hide_empty' => false));
	$terms = !empty($terms) && is_array($terms) && !is_wp_error($terms) ? $terms : array();
	?>
	<p>
		<label>
			<?php echo ($_POST['taxonomy'] == 'post_tag' ? esc_html__('Select post tag', 'gowatch') :  esc_html__('Select post terms', 'gowatch')) ?>:
			<select class="widefat multiple-select" name="<?php echo airkit_var_sanitize($_POST['name'], 'esc_attr') ?>[]" multiple>
				<?php foreach( $terms as $term ): ?>
					<option value="<?php echo airkit_var_sanitize( $term->slug, 'esc_attr' ) ?>">
						<?php echo airkit_var_sanitize( $term->name, 'esc_attr' ); ?>
					</option>
				<?php endforeach ?>
			</select>
		</label>
	</p>
	<?php

	die();
}

function airkit_get_taxonomies() {

	if( !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'extern_request_die') ) return;

	if( isset($_POST['postType']) && !empty($_POST['postType']) && isset($_POST['name']) && !empty($_POST['name']) ):

		$allowedPostTypes = array(
			'post' => array(
				'category' => esc_html__('Category', 'gowatch'),
				'post_tag' => esc_html__('Post tag', 'gowatch') ,
			),
			'video' => array(
				'videos_categories' => esc_html__('Video category','gowatch'),
				'post_tag' => esc_html__('Video tag', 'gowatch') ,
			),
		);

		if( isset($allowedPostTypes[$_POST['postType']]) ): ?>
			<p>
				<label ><?php esc_html_e('Select post taxonomy','gowatch') ?>:
					<select class="ts-select-taxonomy widefat multiple-select" name="<?php echo airkit_var_sanitize( $_POST['name'], 'esc_attr' ) ?>">
						<option value=""><?php esc_html_e('Select taxonomy','gowatch') ?></option>
						<?php foreach( $allowedPostTypes[$_POST['postType']] as $taxonomy => $textUser ): ?>
							<option value="<?php echo airkit_var_sanitize( $taxonomy, 'esc_attr' ) ?>">
								<?php echo airkit_var_sanitize( $textUser, 'esc_attr' ) ?>
							</option>
						<?php endforeach ?>
					</select>
				</label>
			</p>
		<?php endif ?>
	<?php endif;

	die();
}

function airkit_actions_ajax_widgets() {
    add_action('wp_ajax_ts_get_taxonomy', 'airkit_get_taxonomies');
    add_action('wp_ajax_airkit_get_terms', 'airkit_get_terms');
}
add_action( 'widgets_init', 'airkit_actions_ajax_widgets' );

function airkit_search_content() {
	header('Content-Type: application/json');
	$result = array();

	$args = array();

	$args['s'] = (isset($_POST['search'])) ? $_POST['search'] : '';
	$args['post_type'] = array('post', 'ts-gallery', 'video', 'portfolio');
	$args['orderby'] = 'ID';
	$args['order'] = 'DESC';
	add_filter('posts_search', 'airkit_search_by_title_only', 500, 2);

	$the_query = new WP_Query($args);
	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		$result[] = array( 'id' => get_the_ID(), 'title' => get_the_title() );
	endwhile;

	wp_reset_postdata();

	echo json_encode($result);
	die();
}

add_action('wp_ajax_airkit_search_content', 'airkit_search_content');

function airkit_search_by_title_only( $search, &$wp_query ) {
    global $wpdb;
    if ( empty( $search ) ) {
        return $search;
    }

    $q = $wp_query->query_vars;
    $n = ! empty( $q['exact'] ) ? '' : '%';
    $search = '';
    $searchand = '';
    foreach ( (array) $q['search_terms'] as $term ) {
        $term = esc_sql( $wpdb->esc_like($term) );
        $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
        $searchand = ' AND ';
    }
    if ( ! empty( $search ) ) {
        $search = " AND ({$search}) ";
        if ( ! is_user_logged_in() )
            $search .= " AND ($wpdb->posts.post_password = '') ";
    }
    return $search;
}

function airkit_get_video() {

	check_ajax_referer( 'security', 'nonce' );

	if( ! isset($_POST['url']) ) die();

	echo wp_oembed_get($_POST['url']);

	die();
}

add_action('wp_ajax_airkit_get-video', 'airkit_get_video');
add_action('wp_ajax_nopriv_airkit_get-video', 'airkit_get_video');


function airkit_instagram_embed() {

	$post_url = $_POST['the_url'];

	$post_embed = wp_oembed_get( $post_url );
	
	echo airkit_var_sanitize( $post_embed, 'the_kses' );

	die();
}
add_action('wp_ajax_gowatch-instagram-embed', 'airkit_instagram_embed');
add_action('wp_ajax_nopriv_gowatch-instagram-embed', 'airkit_instagram_embed');

function airkit_video_image_callback() {
    check_ajax_referer('video-image', 'nonce');
    $post_ID = (isset($_POST['post_id']) && (int)$_POST['post_id'] !== 0) ? (int)$_POST['post_id'] : NULL;
    $video_url = (isset($_POST['link'])) ? esc_url($_POST['link']) : '';

    if( isset($post_ID) && $video_url !== '' ):

        $video_id = '';
        if( strlen(trim($video_url)) > 0 ):

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

        $jsonEncode = array( 'url' => wp_get_attachment_url($attachment->ID), 'attachment_id' => $attachment->ID );

        echo json_encode( $jsonEncode );
    endif;

    die();
}

add_action('wp_ajax_ts_video_image', 'airkit_video_image_callback');

if ( !function_exists( 'airkit_insert_video_content' ) ) {

	function airkit_insert_video_content() {

		// Check the ajax referer
		// If the check fails, proccess will stop immediately
		check_ajax_referer( 'ajax_airkit_insert_video_content', 'security' );

		// If post_id index not isset in $_POST, stop proccess (die)
		if ( ! isset($_POST['post_id']) ) die();

		$post_ID = $_POST['post_id'];
		$data = array();

		$airkit_img_src 		= wp_get_attachment_url( get_post_thumbnail_id( $post_ID ) );
		$airkit_video_type 		= get_post_meta( $post_ID, 'video_type', true );
		$airkit_external_video 	= get_post_meta( $post_ID, 'video_url', true );
		$airkit_embedded_video 	= get_post_meta( $post_ID, 'video_embed', true );
		$airkit_uploaded_video 	= get_post_meta( $post_ID, 'video_upload', true );


		if( 'external' === $airkit_video_type && !empty( $airkit_external_video ) ){
			
			$airkit_video = wp_oembed_get( $airkit_external_video, array( 'width' => 1340, 'height' => 754 ) ) ;

		} elseif( 'embedded' === $airkit_video_type && !empty( $airkit_embedded_video ) ){
			
			$airkit_video = apply_filters( 'the_content', $airkit_embedded_video );

		} elseif ( 'uploaded' === $airkit_video_type && !empty( $airkit_uploaded_video ) ) {

			$airkit_atts = array(
				'src'      => esc_url( $airkit_uploaded_video ),
				'poster'   => $airkit_img_src,
				'width'    => 1340,
				'height'   => 754,
			);

			$airkit_video = wp_video_shortcode( $airkit_atts );

		}

		if ( !isset($airkit_video) ) {
			$data['response'] = '-1';
		} else {
			$data['response'] = '1';
			$data['frame'] = $airkit_video;
		}

		wp_send_json($data);
	}

}

add_action('wp_ajax_airkit_insert_video_content', 'airkit_insert_video_content');
add_action('wp_ajax_nopriv_airkit_insert_video_content', 'airkit_insert_video_content');

function airkit_add_to_favorite() {

	// Check the ajax referer
	// If the check fails, proccess will stop immediately
	check_ajax_referer( 'ajax_airkit_add_to_favorite', 'security' );

	// If post_id index not isset in $_POST, stop proccess (die)
	if ( ! isset($_POST['post_id']) ) die();

	$aFavs = $return = array();
	$user_ID = get_current_user_id();
	$post_ID = $_POST['post_id'];

	// Get user favorites meta as string
	$favorites = get_user_meta( $user_ID, 'favorites', true );

	// If favorites meta not empty, explode string with "|"
	if ( '' !== $favorites ) {
		$aFavs = explode('|', $favorites); // Array
	}

	// If exists post_id in favorites meta, remove this from favorites
	if ( in_array( $post_ID, $aFavs ) ) {

		foreach ( $aFavs as $key => $fav_id ) {

			if ( $post_ID == $fav_id ) {
				unset($aFavs[$key]); // remove
			}

		}

		$favorites = implode('|', $aFavs); // string

		$return['alert'] = 'warning';
		$return['label'] = esc_html__( 'Favorite', 'gowatch' );
		$return['icon'] = 'icon-heart';
		$return['message'] = sprintf( esc_html__( 'You have successfully removed %s from favorites', 'gowatch' ), '<strong>' . get_the_title( $post_ID ) . '</strong>' );

	} else {

		// Push new post_id in favorites meta array
		array_push($aFavs, $post_ID);
		$favorites = implode('|', $aFavs);

		$return['alert'] = 'success';
		$return['label'] = esc_html__( 'Unfavorite', 'gowatch' );
		$return['icon'] = 'icon-big-heart';
		$return['message'] = sprintf( esc_html__( 'You have successfully added %s to favorites', 'gowatch' ), '<strong>' . get_the_title( $post_ID ) . '</strong>' );

	}

	// Update the user meta
	if ( update_user_meta( absint( $user_ID ), 'favorites', $favorites ) ) {

		if ( $return['alert'] == 'success' ) {
			$return['response'] = '1';
		} else {
			$return['response'] = '0';
		}
		
	} else {

		// If updating failed or has an error
		$return['response'] = '-1';
	}

	wp_send_json($return);

}

add_action('wp_ajax_airkit_add_to_favorite', 'airkit_add_to_favorite');

function airkit_report_video() {

	// Check the ajax referer
	// If the check fails, proccess will stop immediately
	check_ajax_referer( 'ajax_report_video', 'security' );

	// If post_id index not isset in $_POST, stop proccess (die)
	if ( ! isset($_POST['post_id']) ) die();
	
	$user_ID = get_current_user_id();
	$post_ID = $_POST['post_id'];
	$action = $_POST['type'];

	$email = airkit_option_value('social', 'email');

	if ( $action == 'validate' ) {
		
		if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
			$update_meta = update_post_meta( $post_ID, 'airkit_reported', 2 );

			$return['alert'] = 'success';
			$return['label'] = esc_html__( 'Validated', 'gowatch' );
			$return['icon'] = 'icon-tick';
			$return['message'] = sprintf( esc_html__( 'You have successfully validated %s', 'gowatch' ), '<strong>' . get_the_title( $post_ID ) . '</strong>' );
		}

	} else {

		$update_meta = add_post_meta( $post_ID, 'airkit_reported', 1 );
		if ( !$update_meta ) {
			$update_meta = update_post_meta( $post_ID, 'airkit_reported', 1 );
		}

		$return['alert'] = 'success';
		$return['label'] = esc_html__( 'Reported', 'gowatch' );
		$return['icon'] = 'icon-flag';
		$return['message'] = sprintf( esc_html__( 'You have successfully reported %s', 'gowatch' ), '<strong>' . get_the_title( $post_ID ) . '</strong>' );

	}


	// Update the user meta
	if ( !is_wp_error( $update_meta ) ) {

		$return['response'] = '1';
		$message = 'This video on your website was reported. Please have a look and validate it: ' . get_the_permalink($post_ID);
		wp_mail( $email, 'A video on your website was reported', $message);
		
	} else {

		// If updating failed or has an error
		$return['response'] = '-1';
	}

	wp_send_json($return);

}

add_action('wp_ajax_airkit_report_video', 'airkit_report_video');


function airkit_search_live_results() {

	// Check the ajax referer
	// If the check fails, proccess will stop immediately
	if ( !defined('TSZ_DEMO') && TSZ_DEMO != true ) {
		check_ajax_referer( 'ajax_airkit_search_live_results', 'security' );
	}

	$data = $_POST;

	//when search keyword is empty and event type is search
	if ( empty( $data['search_keyword'] ) ) {
		$return['response'] = '0';
		wp_send_json($return);
		die();
	}

	$options = array(
		'element-type' => 'small-articles',
		'reveal-effect' => 'none',
		'behavior' => 'normal',
		'per-row' => '2',
		'small-posts' => 'n',
		'featimg' => 'y',
		'meta' => 'n',
		'custom-columns' => 'col-lg-6 col-md-6 col-sm-12',
	);

	// Start the Query
	$args = array(
		'post_status'	=> 'publish',
		'posts_per_page' => '10',
		'post_type' => array( 'post', 'page', 'video', 'ts-gallery', 'ts-portfolio' ),
	);

	if ( !empty( $data['search_keyword'] ) ) {
		$args['s'] = $data['search_keyword'];
	}

	$search_query = new WP_Query( $args );
    $airkit_found_posts = $search_query->found_posts;

    if ( !$search_query ) {
    	$return['response'] = '-1';
    	wp_send_json($return);
    	die();
    }
	
	// Retrieve the plural or single form based on the amount.
	$return['found_posts'] = sprintf( _n( 'We have found %s result', 'We have found %s results', intval($airkit_found_posts), 'gowatch' ), '<strong>' . number_format_i18n( $airkit_found_posts ) . '</strong>' );

	$return['event_type'] = $data['event_type'];

	if ( $airkit_found_posts > 0 ) {

		$return['response'] = '1';
		$return['posts'] = $search_query->posts;
		$return['view_articles_html'] = airkit_Compilator::view_articles( $options, $search_query );

	} else {

		$return['response'] = '0';
	}


	wp_send_json($return);

}

add_action('wp_ajax_nopriv_airkit_search_live_results', 'airkit_search_live_results');
add_action('wp_ajax_airkit_search_live_results', 'airkit_search_live_results');


if( !function_exists('airkit_load_next_post') ) {

	function airkit_load_next_post(){

		if ( !defined('TSZ_DEMO') && TSZ_DEMO != true ) {
			check_ajax_referer( 'load_next_post_nonce', 'loadNextNonce' );
		}

		if( !isset( $_POST['post_id'] ) ) die();

		$data = array();
		$post_ID = $_POST['post_id'];

		global $airkit_is_ajax_loading;
			   $airkit_is_ajax_loading = true;

		global $post;

		// Store the existing post object for later so we don't lose it
		$oldGlobal = $post;

		// Rewrite global post object
		$post = get_post( $post_ID );
		$post_type = $post->post_type;
		$previous_post = get_previous_post();

		$args = array(
			'post_type'      => $post_type,
			'p'              => $previous_post->ID,
			'no_found_rows'  => true,
			'posts_per_page' => 1,
			'post_status'    => 'publish',
		);

        $query = new WP_Query( $args );

        if ( $post_ID && $previous_post ) {

	        if ( $query->have_posts() ) {
	        	
	        	while ( $query->have_posts() ) : $query->the_post();

				    get_template_part('templates/'. $post_type .'');

					// Async load scripts
					airkit_ajax_content_scripts( $previous_post->ID, true );
	        	
	        	endwhile;

	        }

        } else {

    		$data['message'] = '<div class="no-more-post-alert text-center container in">';
    		$data['message'] .= '<div><p><i class="icon-attention"></i>' . esc_html__('No more posts to load.', 'gowatch') . '</p></div>';
    		$data['message'] .= '</div>';

    		echo airkit_var_sanitize( $data['message'], 'the_kses' );

    	}

    	wp_reset_postdata();

    	die();

	}

	add_action( 'wp_ajax_nopriv_airkit_load_next_post', 'airkit_load_next_post' );
	add_action( 'wp_ajax_airkit_load_next_post', 'airkit_load_next_post' );
	
}

if ( !function_exists( 'airkit_set_post_views' ) ) {

    function airkit_set_post_views($post_ID)
    {
        $post_ID = isset( $post_ID ) && is_int($post_ID) ? $post_ID : (int)$_POST['post_ID'];

        $count_key = 'airkit_views';

        $count = get_post_meta($post_ID, $count_key, true);

        if ( $count == '' ) {

            $count = 0;
            delete_post_meta( $post_ID, $count_key );
            add_post_meta( $post_ID, $count_key, '0' );

        } else {

            $count++;
            update_post_meta( $post_ID, $count_key, $count );
        }

        // wp_send_json( array( 'status'=> 'ok', 'data' => 'Succes! View added!' ) );
        die();
    }
}

add_action('wp_ajax_airkit_set_post_views', 'airkit_set_post_views');
add_action('wp_ajax_nopriv_airkit_set_post_views', 'airkit_set_post_views');


function airkit_add_to_playlist() {

	// Check the ajax referer
	// If the check fails, proccess will stop immediately
	check_ajax_referer( 'ajax_airkit_playlist_nonce', 'security' );

	// If post_id or playlist_id index not isset in $_POST, stop proccess (die)
	if ( ! isset($_POST['post_id']) || ! isset($_POST['playlist_id']) ) die();

	$response = array(
		'status' => 'ok',
		'message' => ''
	);

	$user_ID = get_current_user_id();
	$post_ID = $_POST['post_id'];
	$playlist_ID = $_POST['playlist_id'];

	if ( ! empty($post_ID) && ! empty($playlist_ID) ) {

		$post_ids = get_post_meta( $playlist_ID, '_post_ids', true );

		if ( is_array($post_ids) ) {

			if ( in_array($post_ID, $post_ids) ) {
				// Remove post id if exists in array
				$key = array_search($post_ID, $post_ids);
				unset($post_ids[$key]);

				$response['status'] = 'remove';
				$response['message'] = sprintf(esc_html__('%s has been removed from %s playlist', 'gowatch'), get_the_title($post_ID), get_the_title($playlist_ID));
			}
			else {
				// Push post id onto the end of array
				array_push( $post_ids, $post_ID );

				$response['message'] = sprintf(esc_html__('%s has been added to %s playlist', 'gowatch'), get_the_title($post_ID), get_the_title($playlist_ID));
			}
		}
		else {
			$post_ids = array($post_ID);
			
			$response['message'] = sprintf(esc_html__('%s has been added to %s playlist', 'gowatch'), get_the_title($post_ID), get_the_title($playlist_ID));
		}

		update_post_meta( $playlist_ID, '_post_ids', $post_ids );

		airkit_playlist_update_thumbnail( $playlist_ID, $post_ids );
	}
	else {
		$response['status'] = 'error';
		$response['message'] = esc_html__('Something wrong!', 'gowatch');
	}

	wp_send_json($response);

}

// Set playlist post thumbnail depends on last added post
function airkit_playlist_update_thumbnail( $playlist_ID, $post_ids ) {

	$post_ID = null;
	$thumbnail_id = null;
	$post_thumbnail_id = get_post_thumbnail_id( $playlist_ID );

	if ( ! empty($post_ids) ) {
		$post_ID = end($post_ids); // Get last post ID
		$thumbnail_id = get_post_thumbnail_id( $post_ID ); // Get thumbnail id
	}

	// If is empty, set post thumbnail of last added post (if exists)
	if ( empty($post_thumbnail_id) ) {
		set_post_thumbnail( $playlist_ID, $thumbnail_id ); // Set playlist thumbnail
	}
	// Check if playlist thumbnail id is not equal with last post thumbnail id, then update post thumbnail
	// user can remove post (from which we extracted the thumbnail), and we need to set new thumbnail
	else {
		if ( $post_thumbnail_id !== $thumbnail_id ) {
			delete_post_thumbnail( $playlist_ID ); // Delete playlist thumbnail
			set_post_thumbnail( $playlist_ID, $thumbnail_id ); // Set playlist thumbnail
		}
	}

}

function airkit_create_playlist() {

	// Check the ajax referer
	// If the check fails, proccess will stop immediately
	check_ajax_referer( 'ajax_airkit_playlist_nonce', 'security' );

	$user_ID = get_current_user_id();

	$response = array(
		'status' => 'ok',
		'message' => '',
	);

	if ( $_POST['playlist_title'] == '' ) {
		$response['status'] = 'error';
		$response['message'] = esc_html__('Please insert title for playlist', 'gowatch');

		wp_send_json($response);
		exit;
	}

	$post_data = array(
	    'post_type' => 'playlist',
		'post_title' => $_POST['playlist_title'],
		'post_status' => 'publish',
		'post_author' => $user_ID,
	);

	$new_post_ID = wp_insert_post( $post_data );

	if ( $new_post_ID ) {
		$response['playlist_id'] = $new_post_ID;
		$response['playlist_title'] = get_the_title($new_post_ID);
		$response['message'] = sprintf(esc_html__('%s has been created', 'gowatch'), get_the_title($new_post_ID));
	}
	else {
		$response['status'] = 'error';
		$response['message'] = esc_html__('The playlist was not created!', 'gowatch');
	}

	wp_send_json($response);
}


function airkit_playlist_actions() {

	$response = array(
		'status' => 'ok',
		'message' => '',
	);

	if ( !isset($_POST['playlist_id']) )
		return;

	$playlist_ID = $_POST['playlist_id'];
	$post_ids	 = get_post_meta( $playlist_ID, '_post_ids', true );
	$user_ID 	 = get_current_user_id();
	$action_name = isset($_POST['action_name']) && !empty($_POST['action_name']) ? $_POST['action_name'] : '';
	$to_repeat 	 = isset($_POST['repeat']) && !empty($_POST['repeat']) ? $_POST['repeat'] : 'false';
	$shuffle 	 = isset($_POST['shuffle']) && !empty($_POST['shuffle']) ? $_POST['shuffle'] : 'false';
	$actions 	 = array();

	if ( $action_name !== 'remove' ) {
		// Check the ajax referer
		// If the check fails, proccess will stop immediately
		check_ajax_referer( 'ajax_airkit_playlist_nonce', 'security' );
	}

	if ( $action_name == 'repeat' ) {
		if ( $to_repeat == 'false' ) {
			$to_repeat = 'true';
		} else {
			$to_repeat = 'false';
		}
	} elseif ( $action_name == 'shuffle' ) {
		if ( $shuffle == 'false' ) {
			$shuffle = 'true';
		} else {
			$shuffle = 'false';
		}
	}

	$actions['repeat'] = $to_repeat;
	$actions['shuffle'] = $shuffle;

	if ( $action_name == 'repeat' || $action_name == 'shuffle' ) {
		update_user_meta( $user_ID, '_playlist_actions', $actions);
	}

	if ( $action_name == 'remove' ) {

		// Check the ajax referer
		// If the check fails, proccess will stop immediately
		check_ajax_referer( 'ajax_airkit_remove_playlist_nonce', 'security' );

		// Remove playlist 
		wp_delete_post( $playlist_ID, true );

		// Delete meta
		delete_post_meta( $playlist_ID, '_post_ids', $post_ids );
	}

	$response['actions'] = $actions;
	$response['action_name'] = $action_name;

	wp_send_json($response);

	exit;
}

add_action('wp_ajax_airkit_add_to_playlist', 'airkit_add_to_playlist');
add_action('wp_ajax_airkit_create_playlist', 'airkit_create_playlist');
add_action('wp_ajax_airkit_playlist_actions', 'airkit_playlist_actions');