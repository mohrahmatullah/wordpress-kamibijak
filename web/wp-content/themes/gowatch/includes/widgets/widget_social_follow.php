<?php

class airkit_widget_social_follow extends WP_Widget
{
	function __construct()
	{
        $widget_ops = array( 'classname' => 'airkit_widget_social_follow' , 'description' => esc_html__( 'Display a list of Social Icons with number of followers' , 'gowatch' ) );
        parent::__construct( 'airkit_widget_social_follow' ,  esc_html__( 'Social Icons' , 'gowatch' ) , $widget_ops );		
	}

	function widget( $args, $instance )
	{
		$defaults = array(
			'title'  => '',
			'facebook'  => '',
			'facebook_link'  => '',
			'twitter'  => '',
			'twitter_link'  => '',
			'instagram'  => '',
			'instagram_link'  => '',
			'pinterest'  => '',
			'pinterest_link'  => '',
			'youtube'  => '',
			'youtube_link'  => '',
			'snapchat'  => '',
			'snapchat_link'  => '',
		);

		extract( $args );

		echo airkit_var_sanitize( $before_widget );
		if ( ! empty( $instance['title'] ) ) { echo airkit_var_sanitize( $args['before_title'], 'the_kses' ) . wp_kses_post( $instance['title'] ) . $args['after_title']; };
		$social_follows = array( 'facebook', 'twitter', 'instagram', 'pinterest', 'youtube', 'snapchat' );
		echo '<p>' . esc_html__('Make sure you don\'t miss anything, follow our social profiles from:', 'gowatch') . '</p>';
		echo '<ul class="social-follows">';
		foreach ($social_follows as $val) {
			if ( $instance[$val] ) {

				// Overwrite class name if YouTube is used
				if ( $val == 'youtube' ) {
					$class_name = 'video';
				} else{
					$class_name = $val;
				}

				echo '<li><a href="' . $instance[$val . '_link'] . '" class="icon-' . $class_name . '">' . $instance[$val] . '</a></li>';
			}
		}
		echo '</ul>';
		echo airkit_var_sanitize( $after_widget );
	}

	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		$instance['title'] = isset( $new_instance['title'] ) ? $new_instance['title'] : '';	
		$instance['facebook'] = isset( $new_instance['facebook'] ) ? $new_instance['facebook'] : '';	
		$instance['facebook_link'] = isset( $new_instance['facebook_link'] ) ? $new_instance['facebook_link'] : '';	
		$instance['twitter'] = isset( $new_instance['twitter'] ) ? $new_instance['twitter'] : '';	
		$instance['twitter_link'] = isset( $new_instance['twitter_link'] ) ? $new_instance['twitter_link'] : '';	
		$instance['instagram'] = isset( $new_instance['instagram'] ) ? $new_instance['instagram'] : '';	
		$instance['instagram_link'] = isset( $new_instance['instagram_link'] ) ? $new_instance['instagram_link'] : '';	
		$instance['pinterest'] = isset( $new_instance['pinterest'] ) ? $new_instance['pinterest'] : '';	
		$instance['pinterest_link'] = isset( $new_instance['pinterest_link'] ) ? $new_instance['pinterest_link'] : '';	
		$instance['youtube'] = isset( $new_instance['youtube'] ) ? $new_instance['youtube'] : '';	
		$instance['youtube_link'] = isset( $new_instance['youtube_link'] ) ? $new_instance['youtube_link'] : '';	
		$instance['snapchat'] = isset( $new_instance['snapchat'] ) ? $new_instance['snapchat'] : '';	
		$instance['snapchat_link'] = isset( $new_instance['snapchat_link'] ) ? $new_instance['snapchat_link'] : '';	

		return $instance;

	}

	function form( $instance )
	{
		$title = isset($instance['title']) ? $instance['title'] : '';
		$facebook = isset($instance['facebook']) ? $instance['facebook'] : '';
		$facebook_link = isset($instance['facebook_link']) ? $instance['facebook_link'] : '';
		$twitter = isset($instance['twitter']) ? $instance['twitter'] : '';
		$twitter_link = isset($instance['twitter_link']) ? $instance['twitter_link'] : '';
		$instagram = isset($instance['instagram']) ? $instance['instagram'] : '';
		$instagram_link = isset($instance['instagram_link']) ? $instance['instagram_link'] : '';
		$pinterest = isset($instance['pinterest']) ? $instance['pinterest'] : '';
		$pinterest_link = isset($instance['pinterest_link']) ? $instance['pinterest_link'] : '';
		$youtube = isset($instance['youtube']) ? $instance['youtube'] : '';
		$youtube_link = isset($instance['youtube_link']) ? $instance['youtube_link'] : '';
		$snapchat = isset($instance['snapchat']) ? $instance['snapchat'] : '';
		$snapchat_link = isset($instance['snapchat_link']) ? $instance['snapchat_link'] : '';

		?>

		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		    <?php esc_html_e( 'Title', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		  </label>
		</p>	

		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>">
		    <?php esc_html_e( 'Facebook followers', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'facebook_link' ) ); ?>">
		    <?php esc_html_e( 'Facebook link', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook_link' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook_link ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>">
		    <?php esc_html_e( 'Twitter followers', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'twitter_link' ) ); ?>">
		    <?php esc_html_e( 'Twitter link', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter_link' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter_link ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>">
		    <?php esc_html_e( 'Instagram followers', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'instagram_link' ) ); ?>">
		    <?php esc_html_e( 'Instagram link', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram_link' ) ); ?>" type="text" value="<?php echo esc_attr( $instagram_link ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>">
		    <?php esc_html_e( 'Pinterest followers', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>" type="text" value="<?php echo esc_attr( $pinterest ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'pinterest_link' ) ); ?>">
		    <?php esc_html_e( 'Pinterest link', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pinterest_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest_link' ) ); ?>" type="text" value="<?php echo esc_attr( $pinterest_link ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>">
		    <?php esc_html_e( 'YouTube followers', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'youtube_link' ) ); ?>">
		    <?php esc_html_e( 'YouTube Link', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube_link' ) ); ?>" type="text" value="<?php echo esc_attr( $youtube_link ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'snapchat' ) ); ?>">
		    <?php esc_html_e( 'Snapchat followers', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'snapchat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'snapchat' ) ); ?>" type="text" value="<?php echo esc_attr( $snapchat ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'snapchat_link' ) ); ?>">
		    <?php esc_html_e( 'Snapchat Link', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'snapchat_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'snapchat_link' ) ); ?>" type="text" value="<?php echo esc_attr( $snapchat_link ); ?>" />
		  </label>
		</p>
		<?php

	}

}

?>