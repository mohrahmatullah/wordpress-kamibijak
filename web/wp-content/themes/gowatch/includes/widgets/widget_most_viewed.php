<?php
class airkit_widget_most_viewed extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'airkit_widget_most_viewed' , 'description' => esc_html__( " Get posts that have the most views." , 'gowatch' ) );
        parent::__construct( 'widget_touchsize_most_viewed' , esc_html__( "Most viewed posts" , 'gowatch' ) , $widget_ops );
    }

    function widget( $args, $instance ) {

        /* Extract args to variables */
        extract( $args, EXTR_SKIP );

        // Localize $instance array with missing defaults. see widget_update method @airkit_Widgets.
        extract( airkit_Widgets::widget_update( $instance ) );

        $by_time 	= isset($instance['by_time']) && ($instance['by_time'] === 't' || $instance['by_time'] === 'm' || $instance['by_time'] === 'w') ? $instance['by_time'] : 't';

        $args = array(
			'post_type' => $customPost,
			'posts_per_page' =>$nr_posts,

		);

		if(sizeof($taxonomies)){
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $taxonomies
				)
			);
		}

		$args['meta_key'] = 'airkit_views';
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'DESC';

		if( $by_time === 'w' ) $args['w'] = date('W');
        
		if( $by_time === 'm' ) {

            $args['date_query'] = array(
                         'after' => '-30 days',
                         'column' => 'post_date',
                         );

        }

		$class_columns = ($columns === '1') ? '' : ($columns === '2') ? 'col-lg-6 col-md-6 col-sm-12' : 'col-lg-12 col-md-12 col-sm-12';
		$count = 0;

		$recent = new WP_Query( $args );

		echo airkit_var_sanitize($before_widget, 'the_kses');

		echo (!empty($title) ? $before_title . $title . $after_title : '');


        if( is_array($recent->posts) && !empty($recent->posts) ){
        	$post_count = $recent->post_count; ?>
            <ul class="widget-items row <?php echo ' widget-columns-' . $columns; ?>"><?php $i = 1;
                foreach($recent->posts as $post){
                	$count++;
                	echo airkit_Widgets::widget( $instance, $post, array( 'count' => $count ) );
				} ?>
          	</ul><?php
        }

       	wp_reset_postdata();
        echo airkit_var_sanitize($after_widget, 'the_kses');
	}


    function update( $new_instance, $old_instance) {

        /*save the widget*/
        $instance = $old_instance;

        $instance = airkit_Widgets::widget_update( $new_instance );

        $instance['by_time']  = isset($new_instance['by_time']) ? strip_tags($new_instance['by_time']) : 'w';

		return $instance;
    }

    function form($instance) {

		$by_time = isset($instance['by_time']) && ($instance['by_time'] === 't' || $instance['by_time'] === 'm' || $instance['by_time'] === 'w') ? $instance['by_time'] : 't';

		echo airkit_Widgets::form_post_fields( $instance, $this );

		?>
     
        <p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id('by_time'), 'esc_attr'); ?>"><?php esc_html_e('Period','gowatch') ?>:
            	<select name="<?php echo airkit_var_sanitize($this->get_field_name('by_time'), 'esc_attr'); ?>">
            		<option <?php selected($by_time, 'w', true); ?>value="w"><?php esc_html_e('Weekly', 'gowatch'); ?></option>
            		<option <?php selected($by_time, 'm', true); ?>value="m"><?php esc_html_e('Monthnum', 'gowatch'); ?></option>
            		<option <?php selected($by_time, 't', true); ?>value="t"><?php esc_html_e('All time', 'gowatch'); ?></option>
            	</select>
            </label>
        </p>				
	<?php
    
    }

}

?>