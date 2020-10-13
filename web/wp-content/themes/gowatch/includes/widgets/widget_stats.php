<?php 

if( !class_exists( 'airkit_widget_stats' ) ) {

	class airkit_widget_stats extends WP_Widget {

		function __construct() {

	        $widget_ops = array( 'classname' => 'airkit_widget_stats' , 'description' => esc_html__( "Show website statistics about total ulpoaded posts and total views." , 'gowatch' ) );
	        parent::__construct( 'airkit_widget_stats' , esc_html__( 'Website stats' , 'gowatch' ) , $widget_ops );

		}


		function widget( $args, $instance ) {

			global $wpdb;

			// Extract widget args.
			extract( $args, EXTR_SKIP );
			// Default values for instance
			$defaults = array(

				'title'      => '',
				'style'      => 'inline',

			);

			// Extract instance
			extract( array_merge( $defaults, $instance ) );

			// Get all video posts (CPT Videos and post format Video) stats: total uploads, total views
			$sql = $wpdb->prepare("

				SELECT

					COUNT(posts.ID) as posts_count,
					SUM((SELECT meta.meta_value FROM $wpdb->postmeta as meta WHERE meta.post_id = posts.ID AND meta.meta_key = 'airkit_views' LIMIT 1)) as posts_views

				FROM $wpdb->posts as posts
				WHERE (
					posts.ID IN (
						SELECT p.ID FROM $wpdb->posts as p
				        LEFT JOIN $wpdb->term_relationships as tr
				        	ON tr.object_id = p.ID
				        LEFT JOIN $wpdb->term_taxonomy as tt
				        	ON tr.term_taxonomy_id = (
				        		SELECT term_taxonomy_id FROM $wpdb->term_taxonomy
			        			WHERE term_id = (
			        				SELECT term_id 
			        				FROM $wpdb->terms 
			        				WHERE slug = %s
			        			)
				        	)
				        WHERE p.post_status = 'publish' 
				        AND p.post_type = 'post'
				        AND tt.taxonomy = 'post_format'
				        GROUP BY p.ID
					)

				) OR (
					posts.ID IN (
						SELECT v.ID 
						FROM $wpdb->posts as v 
						WHERE v.post_type = 'video' 
						AND v.post_status = 'publish'
					)
				)

			",
				'post-format-video'
			);

			$video_posts = $wpdb->get_results($sql);

		    $element = '<ul class="list-stats style-'. $instance['style'] .'">';
				$element .= '<li><span>'. esc_html__('Uploaded videos', 'gowatch') .'</span><strong>'. number_format($video_posts[0]->posts_count, 0, '', ' ') .'</strong></li>';
				$element .= '<li><span>'. esc_html__('Total views', 'gowatch') .'</span><strong>'. number_format($video_posts[0]->posts_views, 0, '', ' ') .'</strong></li>';
			$element .= '</ul>';

			echo airkit_var_sanitize( $before_widget, 'the_kses' );

			if( !empty( $title ) ) {

				echo airkit_var_sanitize( $before_title . $title . $after_title, 'the_kses' );

			}

			echo airkit_var_sanitize( $element, 'the_kses' );

			echo airkit_var_sanitize( $after_widget, 'the_kses' );

		}

		function update( $new_instance, $old_instance ) {

	        /*save the widget*/
	        $instance = $old_instance;

	        $instance['title'] = isset( $new_instance['title']) ? strip_tags($new_instance['title']) : '';
			$instance['style'] = isset( $new_instance['style']) ? $new_instance['style']: '';

			return $instance;
		}

		function form( $instance ) {

        	$title  = isset( $instance['title'] ) ? strip_tags( $instance['title'] ) : '';
			$style  = isset( $instance['style'] ) ? $instance['style'] : '';
		?>
	        <p>
	            <label for="<?php echo airkit_var_sanitize( $this->get_field_id('title'), 'esc_attr' ); ?>"><?php esc_html_e( 'Title', 'gowatch' ); ?>:

	                <input class="widefat" id="<?php echo airkit_var_sanitize( $this->get_field_id('title'), 'esc_attr' ); ?>" 
	                       name="<?php echo airkit_var_sanitize( $this->get_field_name('title'), 'esc_attr' ); ?>" 
	                       type="text" 
	                       value="<?php echo esc_attr( $title ); ?>" />

	            </label>
	        </p>
	        <p>
	            <label for="<?php echo airkit_var_sanitize( $this->get_field_id('style'), 'esc_attr' ); ?>"><?php esc_html_e('Style','gowatch') ?>:</label>
	        	<select name="<?php echo airkit_var_sanitize( $this->get_field_name('style'), 'esc_attr' ); ?>">
	        		<option <?php selected( $style, 'inline', true ); ?> value="inline"><?php esc_html_e( 'Inline', 'gowatch' ); ?></option>
	        		<option <?php selected( $style, 'block', true ); ?> value="block"><?php esc_html_e( 'Block', 'gowatch' ); ?></option>
	        	</select>
	        </p>

		<?php

		}

	}

}