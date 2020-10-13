<?php
class airkit_widget_instagram extends WP_Widget {

	function __construct() {
		parent::__construct(
			'airkit_instagram_feed',
			esc_html__( 'Instagram Widget', 'gowatch' ),
			array(
				'classname'                   => 'airkit_instagram_widget',
				'description'                 => esc_html__( 'Displays your latest Instagram photos', 'gowatch' ),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {

		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$username = empty( $instance['username'] ) ? '' : $instance['username'];
		$limit = empty( $instance['number'] ) ? 9 : $instance['number'];
		$size = empty( $instance['size'] ) ? 'large' : $instance['size'];
		$target = empty( $instance['target'] ) ? '_self' : $instance['target'];
		$link = empty( $instance['link'] ) ? '' : $instance['link'];
		$per_row = empty( $instance['per_row'] ) ? '3' : $instance['per_row'];
		$layout = empty( $instance['layout'] ) ? 'grid' : $instance['layout'];
		$likes = empty( $instance['likes'] ) ? 'n' : $instance['likes'];
		$caption = empty( $instance['caption'] ) ? 'n' : $instance['caption'];

		echo airkit_var_sanitize( $args['before_widget'], 'the_kses' );

		if ( ! empty( $title ) ) { echo airkit_var_sanitize( $args['before_title'], 'the_kses' ) . wp_kses_post( $title ) . $args['after_title']; };

		if ( $username != '' ) {

			$media_array = $this->scrape_instagram( $username );

			if ( is_wp_error( $media_array ) ) {

				echo wp_kses_post( $media_array->get_error_message() );

			} else {

				$ul_attr = '';
				$ul_class = 'widget-list instagram_widget_list ';
				// if( $ )
				switch( $per_row ) {
					case '1':
						$ul_class .= 'ts-one-post';
					break;					
					case '3':
						$ul_class .= 'ts-three-posts';
					break;
					case '4' : 
						$ul_class .= 'ts-four-posts';
					break;
					case '10': 
						$ul_class .= 'ts-ten-posts';
					break;
					default:
						$ul_class .= 'ts-three-posts';
				}

				if( 'grid' == $layout ) {

					$ul_class .= ' ts-instagram-grid ';

				}elseif( 'mosaic' == $layout ) {

					$ul_class .= ' ts-instagram-mosaic ';

				}elseif( 'carousel' == $layout ) {

					$ul_class .= ' ts-instagram-carousel ';
					$ul_attr = 'data-per-row="'. $per_row .'"';

					wp_enqueue_script(
						'gowatch-slick',
						get_template_directory_uri() . '/js/slick.js',
						array( 'jquery' ),
						AIRKIT_THEME_VERSION,
						true
					);						
				}

				// slice list down to required limit
				$media_array = array_slice( $media_array, 0, $limit );
				?>
				<ul class="<?php echo esc_attr( $ul_class ); ?>" <?php echo airkit_var_sanitize( $ul_attr, 'true' ) ?>>
					<?php
						foreach ( $media_array as $item ) {
							$likes_out = '';
							$caption_out = '';

							if( 'y' == $likes ) {
								$likes_out = '<p class="instagram_likes">
												<span class="likes_count"><i class="icon-big-heart"></i>' . $item['likes'] . '</span>
										  	  </p>';
							}

							if( 'y' == $caption ) {

								$caption_out = '<p class="instagram_caption">' . $item['description'] . '</p>';								

							}

							echo '<li>
									<div class="relative">
										<a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'" >
											<img '. Airkit_Images::lazy_img( $item[$size] ) .'  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"/>
										</a>
										'. $likes_out .'
										'. $caption_out .'
									</div>
								</li>';						
						}
					?>					
				</ul>
				<?php
			}
		}

		echo airkit_var_sanitize( $args['after_widget'], 'the_kses' );
	}

	function form( $instance ) {

		$instance = wp_parse_args( 
						(array) $instance, 
						array( 
							'title'    => esc_html__( 'Instagram', 'gowatch' ), 
							'username' => '', 
							'size'     => 'large', 
							'number'   => 9, 
							'target'   => '_self',
							'per_row'  => 3,
							'layout'   => 'grid',
							'likes'    => 'n',
							'caption'  => 'n',
							) 
						);

		$title    = $instance['title'];
		$username = $instance['username'];
		$number   = absint( $instance['number'] );
		$size     = $instance['size'];
		$target   = $instance['target'];
		$per_row  = $instance['per_row'];
		$layout   = $instance['layout'];
		$likes    = $instance['likes'];
		$caption  = $instance['caption'];
		?>
			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
			    <?php esc_html_e( 'Title', 'gowatch' ); ?>: 
			    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			  </label>
			</p>
			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>">
			    <?php esc_html_e( 'Username', 'gowatch' ); ?>: 
			    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
			  </label>
			</p>
			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
			    <?php esc_html_e( 'Number of photos', 'gowatch' ); ?>: 
			    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" value="<?php echo esc_attr( $number ); ?>" min="1" max="12" />
			    <div class="desc"><?php echo esc_html__( 'This widget allows you to extract an maximum amount of 12 images. This limit is enforced by Instagram API restrictions and there is no way to avoid it without Instagram permission.', 'gowatch' ); ?></div>
			  </label>
			</p>

			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'per_row' ) ); ?>">
			    <?php esc_html_e( 'Images per row', 'gowatch' ); ?>:
			  </label>
			  <select id="<?php echo esc_attr( $this->get_field_id( 'per_row' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'per_row' ) ); ?>" class="widefat">
			    <option value="1" 
			            <?php selected( '1', $per_row ) ?>>
			    <?php esc_html_e( '1', 'gowatch' ); ?>
			    </option>			  
			    <option value="3" 
			            <?php selected( '3', $per_row ) ?>>
			    <?php esc_html_e( '3', 'gowatch' ); ?>
			    </option>
				 <option value="4" 
				          <?php selected( '4', $per_row ) ?>>
				  <?php esc_html_e( '4', 'gowatch' ); ?>
				</option>
				<option value="10" 
				        <?php selected( '10', $per_row ) ?>>
				<?php esc_html_e( '10', 'gowatch' ); ?>
				</option>
			</select>
			</p>


			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>">
			    <?php esc_html_e( 'Layout', 'gowatch' ); ?>:
			  </label>
			  <select id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" class="widefat">
			    <option value="grid" 
			            <?php selected( 'grid', $layout ) ?>>
			    <?php esc_html_e( 'Grid', 'gowatch' ); ?>
			    </option>
				 <option value="mosaic" 
				          <?php selected( 'mosaic', $layout ) ?>>
				  <?php esc_html_e( 'Mosaic', 'gowatch' ); ?>
				</option>
				 <option value="carousel" 
				          <?php selected( 'carousel', $layout ) ?>>
				  <?php esc_html_e( 'Carousel', 'gowatch' ); ?>
				</option>				
			</select>
			</p>

			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>">
			    <?php esc_html_e( 'Photo size', 'gowatch' ); ?>:
			  </label>
			  <select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" class="widefat">
			    <option value="thumbnail" 
			            <?php selected( 'thumbnail', $size ) ?>>
			    <?php esc_html_e( 'Thumbnail', 'gowatch' ); ?>
			    </option>
				 <option value="small" 
				          <?php selected( 'small', $size ) ?>>
				  <?php esc_html_e( 'Small', 'gowatch' ); ?>
				</option>
				<option value="large" 
				        <?php selected( 'large', $size ) ?>>
				<?php esc_html_e( 'Large', 'gowatch' ); ?>
				</option>
				<option value="original" 
				        <?php selected( 'original', $size ) ?>>
				<?php esc_html_e( 'Original', 'gowatch' ); ?>
				</option>
			</select>
			</p>
			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>">
			    <?php esc_html_e( 'Open links in', 'gowatch' ); ?>:
			  </label>
			  <select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">
			    <option value="_self" 
			            <?php selected( '_self', $target ) ?>>
			    <?php esc_html_e( 'Current window (_self)', 'gowatch' ); ?>
			    </option>
			  <option value="_blank" 
			          <?php selected( '_blank', $target ) ?>>
			  <?php esc_html_e( 'New window (_blank)', 'gowatch' ); ?>
			</option>
			</select>
			</p>

			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'likes' ) ); ?>">
			    <?php esc_html_e( 'Show likes', 'gowatch' ); ?>:
			  </label>
			  <select id="<?php echo esc_attr( $this->get_field_id( 'likes' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'likes' ) ); ?>" class="widefat">
			    <option value="y" 
			            <?php selected( 'y', $likes ) ?>>
			    <?php esc_html_e( 'Yes', 'gowatch' ); ?>
			    </option>
				 <option value="n" 
				          <?php selected( 'n', $likes ) ?>>
				  <?php esc_html_e( 'No', 'gowatch' ); ?>
				</option>
			</select>
			</p>

			<p>
			  <label for="<?php echo esc_attr( $this->get_field_id( 'caption' ) ); ?>">
			    <?php esc_html_e( 'Show caption', 'gowatch' ); ?>:
			  </label>
			  <select id="<?php echo esc_attr( $this->get_field_id( 'caption' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'caption' ) ); ?>" class="widefat">
			    <option value="y" 
			            <?php selected( 'y', $caption ) ?>>
			    <?php esc_html_e( 'Yes', 'gowatch' ); ?>
			    </option>
				 <option value="n" 
				          <?php selected( 'n', $caption ) ?>>
				  <?php esc_html_e( 'No', 'gowatch' ); ?>
				</option>
			</select>
			<div class="desc">
				<?php echo esc_html__( 'Caption is only visible when you set one column layout.', 'gowatch' ); ?>
			</div>
			</p>
		<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = trim( strip_tags( $new_instance['username'] ) );
		$instance['number'] = ! absint( $new_instance['number'] ) ? 9 : $new_instance['number'];
		$instance['size'] = ( ( $new_instance['size'] == 'thumbnail' || $new_instance['size'] == 'large' || $new_instance['size'] == 'small' || $new_instance['size'] == 'original' ) ? $new_instance['size'] : 'large' );
		$instance['target'] = ( ( $new_instance['target'] == '_self' || $new_instance['target'] == '_blank' ) ? $new_instance['target'] : '_self' );
		$instance['per_row'] = $new_instance['per_row'];
		$instance['layout'] = $new_instance['layout'];
		$instance['likes'] = $new_instance['likes'];
		$instance['caption'] = $new_instance['caption'];
		return $instance;
	}

	// based on https://gist.github.com/cosmocatalano/4544576
	function scrape_instagram( $username ) {

		$username = strtolower( $username );
		$username = str_replace( '@', '', $username );

		$instagram_transient = get_transient( 'instagram-a5-'.sanitize_title_with_dashes( $username ) );

		if ( false === $instagram_transient || empty( $instagram_transient ) ) {

			$remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );

			if ( is_wp_error( $remote ) )
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'gowatch' ) );

			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'gowatch' ) );

			$shards = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], TRUE );

			// echo "<pre>";
			// var_dump($insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']);
			// echo "</pre>";

			if ( ! $insta_array )
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'gowatch' ) );

			if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'gowatch' ) );
			}

			if ( ! is_array( $images ) )
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'gowatch' ) );

			$instagram = array();

			foreach ( $images as $image ) {

				
				$image = $image['node'];

				$image['thumbnail_src'] = preg_replace( '/^https?\:/i', '', $image['thumbnail_src'] );
				$image['display_url'] = preg_replace( '/^https?\:/i', '', $image['display_url'] );

				// handle both types of CDN url
				if ( ( strpos( $image['thumbnail_src'], 's640x640' ) !== false ) ) {
					$image['thumbnail'] = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
					$image['small'] = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
				} else {
					$urlparts = wp_parse_url( $image['thumbnail_src'] );
					$pathparts = explode( '/', $urlparts['path'] );
					array_splice( $pathparts, 3, 0, array( 's160x160' ) );
					$image['thumbnail'] = '//' . $urlparts['host'] . implode( '/', $pathparts );
					$pathparts[3] = 's320x320';
					$image['small'] = '//' . $urlparts['host'] . implode( '/', $pathparts );
				}

				$image['large'] = $image['thumbnail_src'];

				if ( $image['is_video'] == true ) {
					$type = 'video';
				} else {
					$type = 'image';
				}

				$caption = esc_html__( 'Instagram Image', 'gowatch' );
				if ( ! empty( $image['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
					$caption = $image['edge_media_to_caption']['edges'][0]['node']['text'];
				}

				$instagram[] = array(
					'description'   => $caption,
					'link'		  	=> trailingslashit( '//instagram.com/p/' . $image['shortcode'] ),
					'time'		  	=> $image['taken_at_timestamp'],
					'comments'	  	=> $image['edge_media_to_comment']['count'],
					'likes'		 	=> $image['edge_liked_by']['count'],
					'thumbnail'	 	=> $image['thumbnail'],
					'small'			=> $image['small'],
					'large'			=> $image['large'],
					'original'		=> $image['display_url'],
					'type'		  	=> $type
				);			
			}		

			$instagram_transient = ts_enc_string( serialize( $instagram ), 'on' );

			// do not set an empty transient - should help catch private or empty accounts
			if ( ! empty( $instagram_transient ) ) {								

				set_transient( 'instagram-a5-'.sanitize_title_with_dashes( $username ), $instagram_transient, HOUR_IN_SECONDS*2 );

			}
		} 

		if ( ! empty( $instagram_transient ) && function_exists('ts_enc_string') ) {

			return unserialize( ts_enc_string( $instagram_transient, 'decode' ) );

		} else {

			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'gowatch' ) );

		}
	}

	function images_only( $media_item ) {

		if ( $media_item['type'] == 'image' )
			return true;

		return false;
	}
}
