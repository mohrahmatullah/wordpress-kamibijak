<?php 

if( !class_exists( 'airkit_widget_list_categories' ) ) {

	class airkit_widget_list_categories extends WP_Widget {

		function __construct() {

	        $widget_ops = array( 'classname' => 'airkit_widget_list_categories' , 'description' => esc_html__( " List categories for selected post type." , 'gowatch' ) );
	        parent::__construct( 'airkit_widget_list_categories' , esc_html__( 'List categories' , 'gowatch' ) , $widget_ops );

		}


		function widget( $args, $instance ) {

			// Extract widget args.
			extract( $args, EXTR_SKIP );
			// Default values for instance
			$defaults = array(

				'title'      => '',
				'count'      => 'y',
				'customPost' => 'post',
				'taxonomy'   => 'category',
				'taxonomies' => array(),
				'image'      => 'y',

			);

			// Extract instance
			extract( array_merge( $defaults, $instance ) );

		    $element = '<ul class="list-categories">';

			$post_type = isset( $instance['customPost'] ) ? $instance['customPost'] : 'post';

			/* Get taxonomy name depending on selected post type */
			$taxonomy  = $instance['taxonomy'];

			if( !empty( $instance[ 'taxonomies' ] ) ) {

				$categories = $instance[ 'taxonomies' ];

				foreach ( $categories as $cat ) {

					/* Get term object for current category */	
					$term = get_term_by( 'slug', $cat, $taxonomy );

					/* Get term thumbnail */
					$thumbnail = get_term_meta( $term->term_id, 'airkit_tax_thumbnail', true );
					$thumbnail_url = airkit_Compilator::get_attachment_field( $thumbnail );
					
					/* Get term link */
					$term_url = get_term_link( $term, $taxonomy );

					$term_img = '';
					$image_class = '';

					if( 'y' == $image && !empty( $thumbnail_url ) ) {

						$term_img = '<img '. Airkit_Images::lazy_img( $thumbnail_url, array( 'size' => 'thumbnails' ) ) .'>';
						$image_class = ' has-image';
					}

					/* Build the output for current category */
					$element .= '
		        				<li class="item '. $image_class .'">
	        						<a href="'. esc_url( $term_url ) .'" class="entry-title">
		        						'. $term_img .'
		        						' . esc_attr( $term->name ) . '
		        						<span class="count">'. esc_attr( $term->count ) .'</span>
	        						</a>
		        				</li>';
				}

			}

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

	        $instance['title']      = isset( $new_instance['title']) ? strip_tags($new_instance['title']) : '';
			$instance['customPost'] = isset( $new_instance['customPost']) ? $new_instance['customPost']: '';
			$instance['taxonomy']   = isset( $new_instance['taxonomy']) ? $new_instance['taxonomy'] : '';
			$instance['taxonomies'] = isset( $new_instance['taxonomies']) ? $new_instance['taxonomies'] : '';
			$instance['image']      = isset( $new_instance['image'] )   ? $new_instance['image'] : '';

			return $instance;
		}

		function form( $instance ) {

        	$title       = isset( $instance['title'] )      ? strip_tags( $instance['title'] ) : '';
			$customPost  = isset( $instance['customPost'] ) ? $instance['customPost'] : '';
			$taxonomy    = isset( $instance['taxonomy'] )   ? $instance['taxonomy'] : '';
			$taxonomies  = isset( $instance['taxonomies'] ) ? $instance['taxonomies'] : array();

			$image    = isset( $instance['image'] )   ? $instance['image'] : '';

			$allowedPostTypes = array(
				'post' => array(
					'category' => esc_html__('Category', 'gowatch'),
					'post_tag' => esc_html__('Post tag', 'gowatch') ,
				),
				'video' => array(
					'videos_categories' => esc_html__('Video category','gowatch'),
					'post_tag' => esc_html__('Video tag', 'gowatch') ,
				),
				'ts-gallery' => array(
					'gallery_categories' => esc_html__('Gallery category','gowatch'),
				 	'post_tag' => esc_html__('Gallery tag', 'gowatch') ,
				),
			);

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
	            <label for="<?php echo airkit_var_sanitize( $this->get_field_id('image'), 'esc_attr' ); ?>"><?php esc_html_e('Show image','gowatch') ?>:</label>
	        	<select name="<?php echo airkit_var_sanitize( $this->get_field_name('image'), 'esc_attr' ); ?>">
	        		<option <?php selected( $image, 'y', true ); ?> value="y"><?php esc_html_e( 'Yes', 'gowatch' ); ?></option>
	        		<option <?php selected( $image, 'n', true ); ?> value="n"><?php esc_html_e( 'No', 'gowatch' ); ?></option>
	        	</select>
	        </p>
			<div class="ts-content-taxonomy">
				<p>
					<label for="<?php echo airkit_var_sanitize( $this->get_field_name('customPost'), 'esc_attr' ) ?>">
						<?php esc_html_e("Select post type",'gowatch') ?>:
					</label>
					<select name="<?php echo airkit_var_sanitize( $this->get_field_name("customPost"), 'esc_attr' ) ?>" class="ts-widget-custom-post">
						<option value=''><?php esc_html_e("Select item",'gowatch') ?></option>
						<?php foreach($allowedPostTypes as $custom_post => $value): ?>
							<option value="<?php echo airkit_var_sanitize( $custom_post, 'esc_attr' ) ?>"<?php selected($custom_post, $customPost) ?>>
								<?php echo airkit_var_sanitize( $custom_post, 'esc_attr' ) ?>
							</option>
						<?php endforeach ?>
					</select>
				</p>
				<div class="ts-taxonomy" data-taxonomy="<?php echo airkit_var_sanitize( $this->get_field_name('taxonomy'), 'esc_attr' ) ?>">
					<?php if( !empty($taxonomy) && !empty($customPost) ): ?>
						<p>
							<label ><?php esc_html_e('Select post taxonomy','gowatch') ?>:
								<select class="ts-select-taxonomy widefat multiple-select" name="<?php echo airkit_var_sanitize( $this->get_field_name('taxonomy'), 'esc_attr' ) ?>">
									<option value=""><?php esc_html_e('Select taxonomy','gowatch') ?></option>
									<?php foreach( $allowedPostTypes[$customPost] as $taxonomyisArray => $textUser ): ?>
										<option value="<?php echo airkit_var_sanitize( $taxonomyisArray, 'esc_attr' ) ?>" <?php selected($taxonomyisArray, $taxonomy) ?>>
											<?php echo airkit_var_sanitize( $textUser, 'esc_attr' ) ?>
										</option>
									<?php endforeach ?>
								</select>
							</label>
						</p>
					<?php endif ?>
				</div>
				<div class="ts-taxonomies" data-taxonomies="<?php echo airkit_var_sanitize( $this->get_field_name('taxonomies'), 'esc_attr' ) ?>">
					<?php if( !empty($taxonomy) && !empty($customPost) ): ?>
						<?php
							$terms = get_terms($taxonomy, array('hide_empty' => false)) ?>
						<?php if( !empty($terms) && is_array($terms) && !is_wp_error($terms) ): ?>
							<label><?php echo ($taxonomy == 'post_tag' ? esc_html__('Select post tag', 'gowatch') :  esc_html__('Select post terms', 'gowatch')) ?>:
								<select multiple name="<?php echo airkit_var_sanitize( $this->get_field_name('taxonomies'), 'esc_attr' ) ?>[]" class="widefat multiple-select">
									<?php foreach( $terms as $term ): ?>
										<option value="<?php echo airkit_var_sanitize( $term->slug, 'esc_attr' ) ?>"<?php echo (in_array($term->slug, $taxonomies) ? ' selected="selected"' : '') ?>>
											<?php echo airkit_var_sanitize( $term->name, 'esc_attr' ); ?>
										</option>
									<?php endforeach ?>
								</select>
							</label>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>

			<?php

		}

	}

}