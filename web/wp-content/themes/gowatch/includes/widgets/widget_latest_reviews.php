<?php

class airkit_widget_latest_reviews extends WP_Widget
{
	public function __construct() {
		parent::__construct(
			'airkit_latest_reviews',
			esc_html__( 'Latest Reviews', 'gowatch' ),
			array(
				'classname'                   => 'airkit_latest_reviews',
				'description'                 => esc_html__( 'List latest posts with ratings', 'gowatch' ),
				'customize_selective_refresh' => true
			)
		);
	}

    function widget( $args , $instance ){

        /* Extract args to variables */
		extract( $args, EXTR_SKIP );

		// Localize $instance array with missing defaults. see widget_update method @airkit_Widgets.
		extract( airkit_Widgets::widget_update( $instance ) );

		// Any additional actions below.
		$order_by = isset($instance['order_by']) ? $instance['order_by'] : 'date';

		$args = array( 
				'orderby'        => 'count', 
				'order'          => 'DESC', 
				'post_type'      => $customPost,
				'posts_per_page' => $nr_posts, 
				'post_status'    => 'publish'
			);

		if( 'date' == $order_by ) {
			$args['orderby'] = 'date';
		}

		$storagePosts = array();

		if( !empty($taxonomies) ){

			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $taxonomies
				)
			);

		}

		$args['meta_query'] = array(
			array(
				'key' => 'enable_rating',
				'value' => 'y',
				'compare' => '=',
				),
			);			

		echo airkit_var_sanitize($before_widget, 'the_kses' );

        echo (!empty( $title ) ? airkit_var_sanitize( $before_title . $title . $after_title, 'the_kses' ) : '');

		$queryPosts = get_posts( $args );

		$sorted_posts = $queryPosts;

		if( 'rating_desc' == $order_by || 'rating_asc' == $order_by ) {
			// Order posts by rating
			$sorted_posts = array();
			foreach ( $queryPosts as $post ) {
				
				$rating_avg = (float)airkit_get_rating( $post->ID );
				$post->rating_avg = $rating_avg;

				$sorted_posts[] = $post;

			}

			usort( $sorted_posts, function( $a, $b ) use ( $order_by ) {

				if( 'rating_desc' == $order_by ) {

					return $a->rating_avg < $b->rating_avg;

				} elseif( 'rating_asc' == $order_by ) {

					return $a->rating_avg > $b->rating_avg;

				}

			});			

		}

		$this->getHtmlPosts( $sorted_posts, $instance );

		 
		 echo airkit_var_sanitize( $after_widget, 'the_kses' );
	}


    public function update( $new_instance, $old_instance ) {

        /*save the widget*/
        $instance = $old_instance;
		$instance = airkit_Widgets::widget_update( $new_instance );

		$instance['order_by']   = $new_instance['order_by'] ? $new_instance['order_by'] : 'date';

		$instance['taxonomies'] = array();
		
		foreach( $new_instance['taxonomies'] as $terms ){

			if( $terms !== '' ){

				$instance['taxonomies'][] = $terms;

			}else{

				$instance['taxonomies'][] = '';

			}

		}

		$instance['tags'] = array();
		
		foreach( $new_instance['tags'] as $tags ){

			if( $tags !== '' ){

				$instance['tags'][] = $tags;

			}else{

				$instance['tags'][] = '';

			}
		}


		return $instance;
    }

    public function form( $instance ) {			

		$order_by = isset( $instance['order_by'] ) ? $instance['order_by'] : 'date';

		echo airkit_Widgets::form_post_fields( $instance, $this );

		?>

    	<p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id('order_by'), 'esc_attr' ); ?>"><?php esc_html_e('Order by','gowatch') ?>:
            	<select name="<?php echo airkit_var_sanitize($this->get_field_name('order_by'), 'esc_attr' ); ?>">
            		<option<?php selected($order_by, 'date'); ?> value="date"><?php esc_html_e('Newest', 'gowatch'); ?></option>
            		<option<?php selected($order_by, 'rating_desc'); ?> value="rating_desc"><?php esc_html_e('Rating descendent', 'gowatch'); ?></option>
            		<option<?php selected($order_by, 'rating_asc'); ?> value="rating_asc"><?php esc_html_e('Rating ascendent', 'gowatch'); ?></option>
            	</select>
            </label>
        </p>
			
		<?php
    }

    public function getHtmlPosts($arrayPosts, $instance){

		$columns = isset($instance['columns']) && ($instance['columns'] === '1' || $instance['columns'] === '2') ? $instance['columns'] : '1';
		
    	?>
		<?php if( !empty($arrayPosts) ) : $count = 0 ?>
			<ul class="widget-items row <?php echo ' widget-columns-' . $columns; ?>">
	        	<?php foreach( $arrayPosts as $postCategory ){
	            	 	$count++; 
	            	 	echo airkit_Widgets::widget( $instance, $postCategory, array( 'count' => $count, 'rating' => 'y' ) );
	            	 } 
	            ?>
	        </ul>
        <?php else: ?>
        	<?php esc_html_e('No post found', 'gowatch') ?>
        <?php endif ?>
    	<?php
    }


}
