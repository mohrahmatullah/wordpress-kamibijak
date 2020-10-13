<?php
class airkit_widget_advertising extends WP_Widget {

	function __construct() {
		parent::__construct(
			'airkit_advertising',
			esc_html__( 'Advertising', 'gowatch' ),
			array(
				'classname'                   => 'airkit_advertising',
				'description'                 => esc_html__( 'Displays your advertising code', 'gowatch' ),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {

		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$advertising_code = empty( $instance['advertising_code'] ) ? '' : $instance['advertising_code'];

		echo airkit_var_sanitize( $args['before_widget'], 'the_kses' );

		if ( ! empty( $title ) ) { echo airkit_var_sanitize( $args['before_title'], 'the_kses' ) . wp_kses_post( $title ) . $args['after_title']; };

		if ( $advertising_code != '' ) {

			echo airkit_var_sanitize( $advertising_code, 'true' );

		}

		echo airkit_var_sanitize( $args['after_widget'], 'the_kses' );
	}

	function form( $instance ) {

		$instance = wp_parse_args( 
			(array) $instance, 
			array( 
				'title'    => esc_html__( 'Advertising', 'gowatch' ), 
				'advertising_code' => '', 
			) 
		);

		$title    = $instance['title'];
		$advertising_code = $instance['advertising_code'];
		?>
			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
			    <?php esc_html_e( 'Title', 'gowatch' ); ?>: 
			    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			  </label>
			</p>
			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'advertising_code' ) ); ?>">
			    <?php esc_html_e( 'Advertising code', 'gowatch' ); ?>: 
			    <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'advertising_code' ) ); ?>" rows="5" name="<?php echo esc_attr( $this->get_field_name( 'advertising_code' ) ); ?>"><?php echo esc_attr( $advertising_code ); ?></textarea>
			  </label>
			</p>
			<p class="desc">
				<?php echo esc_html__( 'Insert your advertising code above.', 'gowatch' ); ?>
			</p>
		<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['advertising_code'] = $new_instance['advertising_code'];
		return $instance;
	}

}
