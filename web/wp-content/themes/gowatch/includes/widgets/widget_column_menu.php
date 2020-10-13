<?php
/**
 * Widget API: WP_Nav_Menu_Widget class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement the Custom Menu widget.
 *
 * @since 3.0.0
 *
 * @see WP_Widget
 */
class airkit_widget_column_menu extends WP_Widget {

	/**
	 * Sets up a new Custom Menu widget instance.
	 *
	 * @since 3.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array( 'classname' => 'airkit_widget_column_menu' , 'description' => esc_html__( "Show a custom menu in columns" , 'gowatch' ) );
        parent::__construct( 'widget_touchsize_column_menu' , esc_html__( "Column menu" , 'gowatch' ) , $widget_ops );
	}

	/**
	 * Outputs the content for the current Custom Menu widget instance.
	 *
	 * @since 3.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Custom Menu widget instance.
	 */
	public function widget( $args, $instance ) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;
		$nav_columns = ! empty( $instance['nav_columns'] ) ? sanitize_text_field( $instance['nav_columns'] ) : 2;
		$text_align = ! empty( $instance['text_align'] ) ? sanitize_text_field( $instance['text_align'] ) : 'text-left';

		if ( !$nav_menu )
			return;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo airkit_var_sanitize( $args['before_widget'], 'the_kses' );

		if ( !empty($instance['title']) )
			echo airkit_var_sanitize( $args['before_title'], 'the_kses' ) . airkit_var_sanitize( $instance['title'], 'the_kses' ) . airkit_var_sanitize( $args['after_title'], 'the_kses' );

		$nav_menu_args = array(
			'fallback_cb' 		=> '',
			'menu'        		=> $nav_menu,
			'menu_class'        => 'nav-columns-' . $nav_columns,
			'container_class'   => 'nav-columns-' . $nav_columns . ' ' . $text_align
		);

		/**
		 * Filters the arguments for the Custom Menu widget.
		 *
		 * @since 4.2.0
		 * @since 4.4.0 Added the `$instance` parameter.
		 *
		 * @param array    $nav_menu_args {
		 *     An array of arguments passed to wp_nav_menu() to retrieve a custom menu.
		 *
		 *     @type callable|bool $fallback_cb Callback to fire if the menu doesn't exist. Default empty.
		 *     @type mixed         $menu        Menu ID, slug, or name.
		 * }
		 * @param stdClass $nav_menu      Nav menu object for the current menu.
		 * @param array    $args          Display arguments for the current widget.
		 * @param array    $instance      Array of settings for the current widget.
		 */
		wp_nav_menu( $nav_menu_args );

		echo airkit_var_sanitize( $args['after_widget'], 'the_kses' );
	}

	/**
	 * Handles updating settings for the current Custom Menu widget instance.
	 *
	 * @since 3.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();

		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		if ( ! empty( $new_instance['nav_menu'] ) ) {
			$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		}
		if ( ! empty( $new_instance['nav_columns'] ) ) {
			$instance['nav_columns'] = (int) $new_instance['nav_columns'];
		}
		if ( ! empty( $new_instance['text_align'] ) ) {
			$instance['text_align'] = $new_instance['text_align'];
		}
		return $instance;
	}

	/**
	 * Outputs the settings form for the Custom Menu widget.
	 *
	 * @since 3.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 * @global WP_Customize_Manager $wp_customize
	 */
	public function form( $instance ) {
		global $wp_customize;
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		$columns = isset( $instance['nav_columns'] ) ? $instance['nav_columns'] : 2;
		$text_align = isset( $instance['text_align'] ) ? $instance['text_align'] : 'text-left';

		// Get menus
		$menus = wp_get_nav_menus();

		// If no menus exists, direct the user to go and create some.
		?>
		<p class="nav-menu-widget-no-menus-message" <?php if ( ! empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<?php
			if ( $wp_customize instanceof WP_Customize_Manager ) {
				$url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
			} else {
				$url = admin_url( 'nav-menus.php' );
			}
			?>
			<?php echo sprintf( esc_html__( 'No menus have been created yet.', 'gowatch' ) . '<a href="%s">Create some</a>.', esc_attr( $url ) ); ?>
		</p>
		<div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<p>
				<label for="<?php echo airkit_var_sanitize( $this->get_field_id( 'title' ), 'esc_attr' ); ?>"><?php esc_html_e( 'Title:', 'gowatch' ) ?></label>
				<input type="text" class="widefat" id="<?php echo airkit_var_sanitize( $this->get_field_id( 'title' ), 'esc_attr' ); ?>" name="<?php echo airkit_var_sanitize( $this->get_field_name( 'title' ), 'esc_attr' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label for="<?php echo airkit_var_sanitize( $this->get_field_id( 'nav_menu' ), 'esc_attr' ); ?>"><?php esc_html_e( 'Select Menu:', 'gowatch' ); ?></label>
				<select id="<?php echo airkit_var_sanitize( $this->get_field_id( 'nav_menu' ), 'esc_attr' ); ?>" name="<?php echo airkit_var_sanitize( $this->get_field_name( 'nav_menu' ), 'esc_attr' ); ?>">
					<option value="0"><?php echo esc_html__( '&mdash; Select &mdash;', 'gowatch' ); ?></option>
					<?php foreach ( $menus as $menu ) : ?>
						<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
							<?php echo esc_html( $menu->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo airkit_var_sanitize( $this->get_field_id( 'nav_columns' ), 'esc_attr' ); ?>"><?php esc_html_e( 'Select columns:', 'gowatch' ); ?></label>
				<select id="<?php echo airkit_var_sanitize( $this->get_field_id( 'nav_columns' ), 'esc_attr' ); ?>" name="<?php echo airkit_var_sanitize( $this->get_field_name( 'nav_columns' ), 'esc_attr' ); ?>">
					<option value="1" <?php selected( $columns, '1' ); ?> ><?php esc_html_e( '1 columns', 'gowatch' ); ?></option>
					<option value="2" <?php selected( $columns, '2' ); ?> ><?php esc_html_e( '2 columns', 'gowatch' ); ?></option>
					<option value="3" <?php selected( $columns, '3' ); ?> ><?php esc_html_e( '3 columns', 'gowatch' ); ?></option>
					<option value="4" <?php selected( $columns, '4' ); ?> ><?php esc_html_e( '4 columns', 'gowatch' ); ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo airkit_var_sanitize( $this->get_field_id( 'text_align' ), 'esc_attr' ); ?>"><?php esc_html_e( 'Set menu align:', 'gowatch' ); ?></label>
				<select id="<?php echo airkit_var_sanitize( $this->get_field_id( 'text_align' ), 'esc_attr' ); ?>" name="<?php echo airkit_var_sanitize( $this->get_field_name( 'text_align' ), 'esc_attr' ); ?>">
					<option value="text-left" <?php selected( $text_align, 'text-left' ); ?> ><?php esc_html_e( 'Left', 'gowatch' ); ?></option>
					<option value="text-center" <?php selected( $text_align, 'text-center' ); ?> ><?php esc_html_e( 'Center', 'gowatch' ); ?></option>
					<option value="text-right" <?php selected( $text_align, 'text-right' ); ?> ><?php esc_html_e( 'Right', 'gowatch' ); ?></option>
				</select>
			</p>
			<?php if ( $wp_customize instanceof WP_Customize_Manager ) : ?>
				<p class="edit-selected-nav-menu" style="<?php if ( ! $nav_menu ) { echo 'display: none;'; } ?>">
					<button type="button" class="button"><?php esc_html_e( 'Edit Menu', 'gowatch' ) ?></button>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}
}
