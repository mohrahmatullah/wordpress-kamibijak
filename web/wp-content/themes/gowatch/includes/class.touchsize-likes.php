<?php
class airkit_Likes {

    function __construct()
    {
    	add_action('wp_ajax_touchsize-likes', array(&$this, 'ajax_callback'));
    	add_action('wp_ajax_nopriv_touchsize-likes', array(&$this, 'ajax_callback'));
	}

	function ajax_callback($post_ID){

		$options = get_option( 'touchsize_likes_settings' );
		if( !isset($options['zero_postfix']) ) $options['zero_postfix'] = '';
		if( !isset($options['one_postfix']) ) $options['one_postfix'] = '';
		if( !isset($options['more_postfix']) ) $options['more_postfix'] = '';

		if( isset($_POST['likes_id']) ) {
		    // Click event. Get and Update Count
			$post_ID = str_replace('touchsize-likes-', '', $_POST['likes_id']);
			echo airkit_var_sanitize($this->like_this($post_ID, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'update'), 'the_kses');
		} else {
		    // AJAXing data in. Get Count
			$post_ID = str_replace('touchsize-likes-', '', $_POST['post_id']);
			echo airkit_var_sanitize($this->like_this($post_ID, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix'], 'get'), 'the_kses');
		}

		exit;
	}

	function like_this($post_ID, $zero_postfix = false, $one_postfix = false, $more_postfix = false, $action = 'get'){

		if(!is_numeric($post_ID)) return;

		$zero_postfix = strip_tags($zero_postfix);
		$one_postfix = strip_tags($one_postfix);
		$more_postfix = strip_tags($more_postfix);
		$icon = airkit_option_value( 'general', 'like_icon' );
		$postfix = '';

		if ( airkit_option_value( 'general', 'like' ) == 'n' ) return;

		switch($action) {

			case 'get':
				$likes = get_post_meta($post_ID, 'airkit_likes', true);
				if( !$likes ){
					$likes = 0;
					add_post_meta($post_ID, 'airkit_likes', $likes, true);
				}

				if( $likes == 0 ) { $postfix = $zero_postfix; }
				elseif( $likes == 1 ) { $postfix = $one_postfix; }
				else { $postfix = $more_postfix; }

				if ( '' != $postfix ) {
					$postfix = '<span class="touchsize-likes-postfix">'. $postfix .'</span>';
				}

				return '<i class="touchsize-likes-icon '. $icon .'"></i><span class="touchsize-likes-count">'. $likes .'</span>';
				break;

			case 'update':
				$likes = get_post_meta($post_ID, 'airkit_likes', true);

				if( isset($_COOKIE['touchsize_likes_'. $post_ID]) ) return '<i class="touchsize-likes-icon '. $icon .'"></i><span class="touchsize-likes-count">' . $likes . '</span>';

				$likes++;
				update_post_meta($post_ID, 'airkit_likes', $likes);
				setcookie('touchsize_likes_'. $post_ID, $post_ID, time()*20, '/');

				if( $likes == 0 ) { $postfix = $zero_postfix; }
				elseif( $likes == 1 ) { $postfix = $one_postfix; }
				else { $postfix = $more_postfix; }

				return '<i class="touchsize-likes-icon '. $icon .'"></i><span class="touchsize-likes-count">'. $likes .'</span>';
				break;

		}
	}

	function do_likes ( $post_ID, $before, $after ) {

        $options = get_option( 'touchsize_likes_settings' );

		if( !isset($options['zero_postfix']) ) $options['zero_postfix'] = '';
		if( !isset($options['one_postfix']) ) $options['one_postfix'] = '';
		if( !isset($options['more_postfix']) ) $options['more_postfix'] = '';

		$output = $this->like_this($post_ID, $options['zero_postfix'], $options['one_postfix'], $options['more_postfix']);

		if ( empty($output) ) return;

  		$class = 'touchsize-likes';
  		$title = esc_html__('Like this', 'gowatch');

		if( isset($_COOKIE['touchsize_likes_'. $post_ID]) ){

			$class = 'touchsize-likes active';
			$title = esc_html__('You already like this', 'gowatch');
			
		}

		return $before .'<a href="#" class="'. $class .'" data-id="touchsize-likes-'. $post_ID .'" title="'. $title .'">'. $output .'</a>'. $after;
	}

}
global $airkit_likes;
$airkit_likes = new airkit_Likes();

function airkit_likes ( $post_ID, $before = '', $after = '', $echo = true ) {
	global $airkit_likes;

	if( $echo ) {

		echo airkit_var_sanitize($airkit_likes->do_likes($post_ID, $before, $after), 'the_kses');

	} else {

		return $airkit_likes->do_likes($post_ID, $before, $after);

	}
}
