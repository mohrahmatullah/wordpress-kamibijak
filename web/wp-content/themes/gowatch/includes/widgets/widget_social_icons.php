<?php

class airkit_widget_social_icons extends WP_Widget
{
	function __construct()
	{
        $widget_ops = array( 'classname' => 'airkit_widget_social_icons' , 'description' => esc_html__( 'Display a list of Social Icons (links must be set in Theme Options)' , 'gowatch' ) );
        parent::__construct( 'airkit_widget_social_icons' ,  esc_html__( 'Social Icons' , 'gowatch' ) , $widget_ops );		
	}

	function widget( $args, $instance )
	{
		$defaults = array(
			'title'  => '',
			'style'  => 'background', 
			'labels' => 'n',
			'rss'    => 'y',
		);

		extract( $args );

		echo airkit_var_sanitize( $before_widget );
		if ( ! empty( $instance['title'] ) ) { echo airkit_var_sanitize( $args['before_title'], 'the_kses' ) . wp_kses_post( $instance['title'] ) . $args['after_title']; };
		echo airkit_Compilator::social_buttons_element( $instance );
		echo airkit_var_sanitize( $after_widget );
	}

	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		$instance['title'] = isset( $new_instance['title'] ) ? $new_instance['title'] : '';		
		$instance['style'] = isset( $new_instance['style'] ) ? $new_instance['style'] : 'background';
		$instance['labels'] = isset( $new_instance['labels'] ) ? $new_instance['labels'] : 'n';
		$instance['rss'] = isset( $new_instance['rss'] ) ? $new_instance['rss'] : 'n';		

		return $instance;

	}

	function form( $instance )
	{
		$title = isset($instance['title']) ? $instance['title'] : '';
		$style = isset( $instance['style'] ) ? $instance['style'] : 'background';
		$labels = isset( $instance['labels'] ) ? $instance['labels'] : 'n';
		$rss = isset( $instance['rss'] ) ? $instance['rss'] : 'n';

		?>

		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		    <?php esc_html_e( 'Title', 'gowatch' ); ?>: 
		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		  </label>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>">
		    <?php esc_html_e( 'Style', 'gowatch' ); ?>:
		  </label>
		  <select id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" class="widefat">
			    <option value="background" 
			            <?php selected( 'background', $style ) ?>>
			    <?php esc_html_e( 'Background', 'gowatch' ); ?>
			    </option>			  
			    <option value="bordered" 
			            <?php selected( 'bordered', $style ) ?>>
			    <?php esc_html_e( 'Bordered', 'gowatch' ); ?>
			    </option>
				 <option value="iconed" 
				          <?php selected( 'iconed', $style ) ?>>
				  <?php esc_html_e( 'Iconed', 'gowatch' ); ?>
				</option>
			</select>
		</p>
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'labels' ) ); ?>">
		    <?php esc_html_e( 'Show labels', 'gowatch' ); ?>:
		  </label>
		  <select id="<?php echo esc_attr( $this->get_field_id( 'labels' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'labels' ) ); ?>" class="widefat">
			    <option value="y" 
			            <?php selected( 'y', $labels ) ?>>
			    <?php esc_html_e( 'Yes', 'gowatch' ); ?>
			    </option>			  
			    <option value="n" 
			            <?php selected( 'n', $labels ) ?>>
			    <?php esc_html_e( 'No', 'gowatch' ); ?>
			    </option>
			</select>
		</p>	
		<p>
		  <label for="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>">
		    <?php esc_html_e( 'Show rss', 'gowatch' ); ?>:
		  </label>
		  <select id="<?php echo esc_attr( $this->get_field_id( 'rss' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'rss' ) ); ?>" class="widefat">
			    <option value="y" 
			            <?php selected( 'y', $rss ) ?>>
			    <?php esc_html_e( 'Yes', 'gowatch' ); ?>
			    </option>			  
			    <option value="n" 
			            <?php selected( 'n', $rss ) ?>>
			    <?php esc_html_e( 'No', 'gowatch' ); ?>
			    </option>
			</select>
		</p>								
		<?php

	}

}

?>