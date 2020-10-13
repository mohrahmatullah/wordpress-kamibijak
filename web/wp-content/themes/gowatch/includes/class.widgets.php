<?php 
/**
 *  Class generates HTML for widgets that use articles.
 */
if( !class_exists( 'airkit_Widgets' ) ) {

	class airkit_Widgets
	{

		public static $instance;

		/**
		 * Check for missing keys in $instance and add defaults.
		 * @return array containing missing keys and default values.
		 */
		public static function instance_extract_attrs( $instance )
		{

			/**
			 * Contains default values for widget attrs.
			 */
			$defaults = array(

				'style'    => 'thumb-below',
				'date'     => 'n',
				'likes'    => 'y',
				'views'    => 'n',
				'comments' => 'y',
				'columns'  => '1'

			);

			return array_merge( $defaults, $instance );

		}
		
		/**
 		 * Call inside a loop. Generates front-end output for provided $post.
 		 *
 		 * @param obj $instance | Widget instance object.
 		 * @param obj $post | WP Post object, current loop item.
 		 * @param array $options | Array containing any additional information, helpers, etc.

 		 * return string $html [buffered]
		 */
		public static function widget( $instance, $post, $options = array() )
		{

			$output = '';
			$article_classes = array();
			$figure_attributes = array();

			//Localize $instance variables.
			extract( self::instance_extract_attrs( $instance ) );

			$class_columns = ( $columns === '1' ) ? '' : ( $columns === '2' ) ? 'col-lg-6 col-md-6 col-sm-12' : 'col-lg-12 col-md-12 col-sm-12';
            
            // Used in numbered widget..
            $count = isset( $options['count'] ) ? $options['count'] : 1;

            $thumbnail_id		= get_post_thumbnail_id( $post->ID );
            $mime_type 			= get_post_mime_type( $thumbnail_id );

			if ( 'image/gif' == $mime_type ) {

				$img_size = 'full';

			} elseif ( $columns > 1 || 'title-right' == $style ) {

				$img_size = 'gowatch_small';

			} else {

				$img_size = 'gowatch_grid';
			}

			$article_classes[] = $style;

			ob_start();

			?>
                <li class="<?php echo airkit_var_sanitize( $class_columns, 'esc_attr' ); ?>">

					<article <?php airkit_element_attributes( array('class' => $article_classes), array_merge($options, array('element' => 'article')), $post->ID ) ?>>

						<?php

							if( 'title-above' === $style ) {

								echo airkit_PostMeta::title( $post->ID, array('wrap' => 'h2', 'class' => 'title') );

							}

							if( 'thumb-over' === $style || 'thumb-below' === $style || 'title-right' === $style || 'title-above' === $style ) {

								echo '<figure '. airkit_element_attributes( $figure_attributes, array_merge( $options, array('element' => 'figure', 'img_size' => $img_size ) ), $post->ID, false ) .'>';

				                    echo '<a href="'. get_the_permalink( $post->ID ) .'">';

			                     		if( isset( $options['rating'] ) && 'y' == $options['rating'] ) {
			                     			echo airkit_PostMeta::post_rating( $post->ID );
			                     		}

										airkit_overlay_effect_type();

				                   	echo '</a>';

	                           	echo '</figure>';

							}

						?>

                        <header>

                        	<?php if( $style == 'number' ) : ?>

                        		<span class="count-item"><?php echo airkit_var_sanitize($count, 'esc_attr' ); ?></span>

                        	<?php endif; ?>

                        	<div class="entry-content">
								<?php 

									if( 'title-above' !== $style ) {

	                           			echo airkit_PostMeta::categories( $post->ID );
	                           			echo airkit_PostMeta::title( $post->ID, array('wrap' => 'h3', 'class' => 'title') );
	                           			self::widget_meta( $instance, $post );

									} else {

										echo '<div class="entry-excerpt">';
											airkit_excerpt( 60, $post->ID, 'show-excerpt' );
										echo '</div>';

									}

								?>
                        	</div>
                        </header>
                        <?php 

	                        if( 'title-above' == $style ) {

	                        	self::widget_meta( $instance, $post );

	                        }

                        ?>
					</article>

                </li>
			<?php

			$output = ob_get_clean();

			return $output;

		}

		/**
	     * Widget Part: Widget Meta.
	     * @param object Widget instance
	     * @param numeric post id.
	     * @return Meta for given posts, depending on instance options.
		 */

		public static function widget_meta( $instance, $post )
		{	
			// Localize widget variables.
			extract( self::instance_extract_attrs( $instance ) );

			?>
				<div class="widget-meta">
					<ul class="list-inline">

						<?php

						if( $likes == 'y' ) {

							airkit_likes( $post->ID, '<li class="meta-likes">', '</li>' );
							
						}

						if( $date == 'y' ) : ?>

							<li class="meta-date">
								<?php $date_format = get_option('date_format');?>
								<span><?php echo get_the_date( $date_format, $post->ID ); ?></span>
							</li>

						<?php endif;

						if( $comments == 'y' ) : ?>

							<li class="red-comments">
							    <a href="<?php echo get_permalink( $post->ID ) . '#comments' ?>">
							        <i class="icon-comments"></i>
							        <span class="comments-count">
							            <?php echo airkit_var_sanitize( $post->comment_count, 'the_kses' ) . ' '; ?>
							        </span>
							    </a>
							</li>

						<?php endif;

						if( $views == 'y' ) : ?>

							<li class="meta-views">
							    <i class="icon-views-1"></i> <?php airkit_get_views($post->ID, true); ?>
							</li>

						<?php endif; ?>

					</ul>
				</div>	
			<?php			
		}

		/**
		 * Widget update
		 * @return array of instance fields with missing defaults set.
		 */

		public static function widget_update( $new_instance )
		{

			$defaults  = array(
				'title'      => '',
				'nr_posts'   => '',
				'customPost' => '',
				'taxonomy'   => '',
				'taxonomies' => self::sanitize_array( $new_instance['taxonomies'] ) ,
			);

			// Add styling defaults to $defaults array.
			$defaults = array_merge( $defaults, self::instance_extract_attrs( $new_instance ) );

			// Set missing defaults in $new_instance and return fulfilled array.
			return array_merge( $defaults, $new_instance );

		}

		public static function sanitize_array(  $array){

			if( is_array( $array ) && !empty( $array ) ){

				$sanitizeArray = array();

				foreach( $array as $value ){

					if( !empty($value) && $value !== -1 ){

						$sanitizeArray[] = $value;

					}
				}

				return $sanitizeArray;

			}else{

				return array();
				
			}
		}

		/**
	     * Render posts-related widgets options.
		 */

		public static function form_post_fields( $instance, &$instance_ref )
		{
			// Read instance values.

		        $title = isset($instance['title']) ? strip_tags($instance['title']) : '';
		       	$nr_posts = isset($instance['nr_posts']) ? strip_tags($instance['nr_posts']): '3';
				$customPost = isset($instance['customPost']) ? $instance['customPost'] : '';
				$taxonomy   = isset($instance['taxonomy']) ? $instance['taxonomy'] : '';
				$taxonomies = isset($instance['taxonomies']) ? $instance['taxonomies'] : array();
				$number = isset($instance['number']) && ($instance['number'] == 'y' || $instance['number'] == 'n') ? $instance['number'] : 'n';

				$style = isset($instance['style']) ? $instance['style'] : 'thumb-below';
				$date = isset($instance['date']) && ($instance['date'] == 'y' || $instance['date'] == 'n') ? $instance['date'] : 'n';
				$likes   = isset($instance['likes']) && ($instance['likes'] == 'y' || $instance['likes'] == 'n') ? $instance['likes'] : 'y';
				$views   = isset($instance['views']) && ($instance['views'] == 'y' || $instance['views'] == 'n') ? $instance['views'] : 'n';
				$comments = isset($instance['comments']) && ($instance['comments'] == 'y' || $instance['comments'] == 'n') ? $instance['comments'] : 'y';
				$columns 	= isset($instance['columns']) && ($instance['columns'] === '1' || $instance['columns'] === '2') ? $instance['columns'] : '1';			

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
				ob_start();
				?>
		        <p>
		            <label for="<?php echo airkit_var_sanitize($instance_ref->get_field_id('title'), 'esc_attr'); ?>"><?php esc_html_e('Title','gowatch') ?>:
		                <input class="widefat" id="<?php echo airkit_var_sanitize($instance_ref->get_field_id('title'), 'esc_attr'); ?>" name="<?php echo airkit_var_sanitize($instance_ref->get_field_name('title'), 'esc_attr'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		            </label>
		        </p>
		        
			    <p>
		            <label for="<?php echo airkit_var_sanitize($instance_ref->get_field_id('style'), 'esc_attr'); ?>"><?php esc_html_e('Article style','gowatch') ?>: </label>
		        	<select class="columns-toggle" name="<?php echo airkit_var_sanitize( $instance_ref->get_field_name('style'), 'esc_attr' ); ?>">
		        		<option <?php selected($style, 'thumb-below', true); ?> value="thumb-below"><?php esc_html_e('Thumbnail title below', 'gowatch'); ?></option>
		        		<option <?php selected($style, 'thumb-over', true); ?> value="thumb-over"><?php esc_html_e('Thumbnail title over', 'gowatch'); ?></option>
		        		<option <?php selected($style, 'title-right', true); ?> value="title-right"><?php esc_html_e('Thumbnail title right', 'gowatch'); ?></option>
		        		<option <?php selected($style, 'number', true); ?> value="number"><?php esc_html_e('Posts with numbers', 'gowatch'); ?></option>
		        		<option <?php selected($style, 'title-only', true); ?> value="title-only"><?php esc_html_e('Posts title', 'gowatch'); ?></option>
		        		<option <?php selected($style, 'title-above', true); ?> value="title-above"><?php esc_html_e('Posts title above image and description', 'gowatch'); ?></option>
		        	</select>
			    </p>


				<p>
		            <label for="<?php echo airkit_var_sanitize( $instance_ref->get_field_id('nr_posts'), 'esc_attr' ) ?>">
		            	<?php esc_html_e( 'Number of posts :' , 'gowatch' ); ?> 
		            </label>
		            <input class="widefat digit" id="<?php echo airkit_var_sanitize($instance_ref->get_field_id('nr_posts'), 'esc_attr') ?>" name="<?php echo airkit_var_sanitize($instance_ref->get_field_name('nr_posts'), 'esc_attr') ?>" type="text" value="<?php echo esc_attr($nr_posts) ?>" />
		        </p>

				<?php if( $style !== 'title-right' ): ?>
						<p class="select-columns">
				            <label for="<?php echo airkit_var_sanitize($instance_ref->get_field_name('columns'), 'esc_attr') ?>">
				            	<?php esc_html_e( 'Columns','gowatch' ) ?>:
				            </label>
				            <select name="<?php echo airkit_var_sanitize($instance_ref->get_field_name('columns'), 'esc_attr') ?>">
				            	<option value="1"<?php selected($columns, '1'); ?>>
				            		1 <?php esc_html_e( 'column' , 'gowatch' ) ?>
				            	</option>
				            	<option value="2"<?php selected($columns, '2'); ?>>
				            		2 <?php esc_html_e( 'columns' , 'gowatch' ) ?>
				            	</option>
				            </select>
				        </p>
			    	<?php endif; ?>

		        <p>
		            <label for="<?php echo airkit_var_sanitize($instance_ref->get_field_id('date'), 'esc_attr'); ?>"><?php esc_html_e('Show date','gowatch') ?>:</label>
		        	<select name="<?php echo airkit_var_sanitize($instance_ref->get_field_name('date'), 'esc_attr'); ?>">
		        		<option <?php selected($date, 'y', true); ?> value="y"><?php esc_html_e('Yes', 'gowatch'); ?></option>
		        		<option <?php selected($date, 'n', true); ?> value="n"><?php esc_html_e('No', 'gowatch'); ?></option>
		        	</select>
		        </p>

		        <p>
		            <label for="<?php echo airkit_var_sanitize($instance_ref->get_field_id('likes'), 'esc_attr'); ?>"><?php esc_html_e('Show likes','gowatch') ?>:</label>
		        	<select name="<?php echo airkit_var_sanitize($instance_ref->get_field_name('likes'), 'esc_attr'); ?>">
		        		<option <?php selected($likes, 'y', true); ?> value="y"><?php esc_html_e('Yes', 'gowatch'); ?></option>
		        		<option <?php selected($likes, 'n', true); ?> value="n"><?php esc_html_e('No', 'gowatch'); ?></option>
		        	</select>
		        </p>

		        <p>
		            <label for="<?php echo airkit_var_sanitize($instance_ref->get_field_id('views'), 'esc_attr'); ?>"><?php esc_html_e('Show views','gowatch') ?>:</label>
		        	<select name="<?php echo airkit_var_sanitize($instance_ref->get_field_name('views'), 'esc_attr'); ?>">
		        		<option <?php selected($views, 'y', true); ?> value="y"><?php esc_html_e('Yes', 'gowatch'); ?></option>
		        		<option <?php selected($views, 'n', true); ?> value="n"><?php esc_html_e('No', 'gowatch'); ?></option>
		        	</select>
		        </p>

		        <p>
		            <label for="<?php echo airkit_var_sanitize($instance_ref->get_field_id('comments'), 'esc_attr' ); ?>"><?php esc_html_e('Show comments','gowatch') ?>:</label>
		        	<select name="<?php echo airkit_var_sanitize($instance_ref->get_field_name('comments'), 'esc_attr' ); ?>">
		        		<option <?php selected($comments, 'y', true); ?> value="y"><?php esc_html_e('Yes', 'gowatch'); ?></option>
		        		<option <?php selected($comments, 'n', true); ?> value="n"><?php esc_html_e('No', 'gowatch'); ?></option>
		        	</select>
		        </p>                    

				<div class="ts-content-taxonomy">
					<p>
						<label for="<?php echo airkit_var_sanitize($instance_ref->get_field_name('customPost'), 'esc_attr' ) ?>">
							<?php esc_html_e("Select post type",'gowatch') ?>:
						</label>
						<select name="<?php echo airkit_var_sanitize($instance_ref->get_field_name("customPost"), 'esc_attr' ) ?>" class="ts-widget-custom-post">
							<option value=''><?php esc_html_e("Select item",'gowatch') ?></option>
							<?php foreach($allowedPostTypes as $custom_post => $value): ?>
								<option value="<?php echo airkit_var_sanitize($custom_post, 'esc_attr' ) ?>"<?php selected($custom_post, $customPost) ?>>
									<?php echo airkit_var_sanitize($custom_post, 'esc_attr' ) ?>
								</option>
							<?php endforeach ?>
						</select>
					</p>
					<div class="ts-taxonomy" data-taxonomy="<?php echo airkit_var_sanitize($instance_ref->get_field_name('taxonomy'), 'esc_attr' ) ?>">
						<?php if( !empty($taxonomy) && !empty($customPost) ): ?>
							<p>
								<label ><?php esc_html_e('Select post taxonomy','gowatch') ?>:
									<select class="ts-select-taxonomy widefat multiple-select" name="<?php echo airkit_var_sanitize($instance_ref->get_field_name('taxonomy'), 'esc_attr'); ?>">
										<option value=""><?php esc_html_e('Select taxonomy','gowatch') ?></option>
										<?php foreach( $allowedPostTypes[$customPost] as $taxonomyisArray => $textUser ): ?>
											<option value="<?php echo airkit_var_sanitize($taxonomyisArray, 'esc_attr') ?>" <?php selected($taxonomyisArray, $taxonomy) ?>>
												<?php echo airkit_var_sanitize($textUser, 'esc_attr') ?>
											</option>
										<?php endforeach ?>
									</select>
								</label>
							</p>
						<?php endif ?>
					</div>
					<div class="ts-taxonomies" data-taxonomies="<?php echo airkit_var_sanitize($instance_ref->get_field_name('taxonomies'), 'esc_attr') ?>">
						<?php if( !empty($taxonomy) && !empty($customPost) ): ?>
							<?php
								$terms = get_terms($taxonomy, array('hide_empty' => false)) ?>
							<?php if( !empty($terms) && is_array($terms) && !is_wp_error($terms) ): ?>
								<label><?php echo ($taxonomy == 'post_tag' ? esc_html__('Select post tag', 'gowatch') :  esc_html__('Select post terms', 'gowatch')) ?>:
									<select multiple name="<?php echo airkit_var_sanitize($instance_ref->get_field_name('taxonomies'), 'esc_attr') ?>[]" class="widefat multiple-select">
										<?php foreach( $terms as $term ): ?>
											<option value="<?php echo airkit_var_sanitize($term->slug, 'esc_attr') ?>"<?php echo (in_array($term->slug, $taxonomies) ? ' selected="selected"' : '') ?>>
												<?php echo airkit_var_sanitize($term->name, 'esc_attr'); ?>
											</option>
										<?php endforeach ?>
									</select>
								</label>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>

            <?php

            self::inject_script();

            $form = ob_get_clean();

            return $form;


		}

		public static function inject_script()
		{
			?>
	            <script>
	            	jQuery(document).ready(function(){
	            		jQuery('.ts-by-taxonomy').change(function(){
	            			if( jQuery(this).val() == 'post_tag' ){

	            				jQuery(this).closest('div').find('.ts-all-tags').css('display', '');
	            				jQuery(this).closest('div').find('.ts-all-category').css('display', 'none');

	            			}else if( jQuery(this).val() == 'category' ){

	            				jQuery(this).closest('div').find('.ts-all-category').css('display', '');
	            				jQuery(this).closest('div').find('.ts-all-tags').css('display', 'none');

	            				jQuery(this).closest('div').find('.ts-all-category select').each(function(){
	            					jQuery(this).css('display', 'none');
	            				});

	            				var custom_post = jQuery(this).closest('div').find('.ts-custom-posts').val();
	            				jQuery('.ts-terms-' + custom_post).css('display', '');

	            			}else{

	            				jQuery(this).closest('div').find('.ts-all-category').css('display', 'none');
	            				jQuery(this).closest('div').find('.ts-all-tags').css('display', 'none');

	            			}
	            		});

	            		jQuery('.ts-by-taxonomy').each(function(){

	            			if( jQuery(this).val() == 'post_tag' ){

	            				jQuery(this).closest('div').find('.ts-all-tags').css('display', '');
	            				jQuery(this).closest('div').find('.ts-all-category').css('display', 'none');

	            			}else if( jQuery(this).val() == 'category' ){

	            				jQuery(this).closest('div').find('.ts-all-category').css('display', '');
	            				jQuery(this).closest('div').find('.ts-all-tags').css('display', 'none');

	            				jQuery(this).closest('div').find('.ts-all-category select').each(function(){
	            					jQuery(this).css('display', 'none');
	            				});

	            				var custom_post = jQuery(this).closest('div').find('.ts-custom-posts').val();
	            				jQuery('.ts-terms-' + custom_post).css('display', '');

	            			}else{

	            				jQuery(this).closest('div').find('.ts-all-category').css('display', 'none');
	            				jQuery(this).closest('div').find('.ts-all-tags').css('display', 'none');
	            				
	            			}
	            		});

						jQuery('.ts-custom-posts').change(function(){
							var taxonomy = jQuery(this).closest('div').find('.ts-by-taxonomy').val();
							if( taxonomy == 'category' ){

								jQuery(this).closest('div').find('.ts-all-category select').each(function(){
									jQuery(this).css('display', 'none');
								});

	            				jQuery('.ts-terms-' + jQuery(this).val()).css('display', '');
							}
						});	
	            	});

					jQuery('.columns-toggle').change(function(){

						if( jQuery(this).val() === 'title-right' || jQuery(this).val() === 'title-above' ) {

							jQuery('.select-columns').hide();

						} else {

							jQuery('.select-columns').show();

						}
					});		            	
	            </script>
            <?php

		}
	}
}
