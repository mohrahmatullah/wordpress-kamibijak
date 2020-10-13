<?php
class airkit_widget_popular extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'airkit_widget_popular' , 'description' => esc_html__( " Get popular posts." , 'gowatch' ) );
        parent::__construct( 'widget_touchsize_popular' , esc_html__( "Most popular posts" , 'gowatch' ) , $widget_ops );
    }

    function widget( $args , $instance ){

        /* Extract args to variables */
		extract( $args, EXTR_SKIP );

		// Localize $instance array with missing defaults. see widget_update method @airkit_Widgets.
		extract( airkit_Widgets::widget_update( $instance ) );

		$args = array(
			'post_type' => $customPost,
			'posts_per_page' =>$nr_posts,

		);

		$taxonomies = airkit_Widgets::sanitize_array( $taxonomies );

		if( !empty($taxonomies) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $taxonomies
				)
			);
		}

		// /*** By views ***/
		$args['meta_key'] = 'airkit_views';
		$args['orderby']  = 'meta_value_num';

		$storagePosts = array();
		$storageShared = array();

		$args['order'] = 'DESC';

		$today = getdate();
		$oneMonthAgoDate = date( "Y-m-d", strtotime("-1 month") );
		$oneWeekAgoDate = date( "Y-m-d", strtotime("-1 week") );

		foreach( array('w', 'monthnum', 'all')  as $time ){

			switch ($time) {
				case 'w':
					$args['date_query'] = array(
							array(
								'after'     => $oneWeekAgoDate,
								'before'    => [
									'year'  => $today['year'],
									'month' => $today['mon'],
									'day'   => $today['mday'],
								],
								'inclusive' => true,
							),
						);					
					break;

				case 'monthnum':
					unset($args['date_query']);
					$args['date_query'] = array(
							array(
								'after'     => $oneMonthAgoDate,
								'before'    => [
									'year'  => $today['year'],
									'month' => $today['mon'],
									'day'   => $today['mday'],
								],
								'inclusive' => true,
							),
						);					
					break;

				case 'all':
					unset( $args['date_query'] );
					break;
			}		

			$posts = get_posts( $args );

			$storagePosts[ $time ] = !empty($posts) ? $posts : array();

		}

		foreach( $storagePosts as $time => $posts ){

			if( !empty($posts) ){
				foreach( $posts as $key => $post ){
					$storageShared[$time][$key] = (int)get_post_meta($post->ID, 'airkit_social_count', true) + (int)get_post_meta($post->ID, 'airkit_views', true) + (int)get_post_meta($post->ID, 'airkit_likes', true);
				}

				if( !empty($storageShared[$time]) ) arsort($storageShared[$time]);

			}else{
				$storageShared[$time] = array();
			}
		}

		echo airkit_var_sanitize($before_widget, 'the_kses');

        echo (!empty($title) ? airkit_var_sanitize($before_title . $title . $after_title, 'the_kses') : '');

        $storageHtml = array();
        $count = 0;

        foreach( $storageShared as $time => $timePosts ): ?>
        	<?php ob_start();
				  ob_clean();
				  $count = 0;
				   ?>
        	<ul class="widget-items row <?php echo ' widget-columns-' . $columns; ?>">
	        	<?php foreach( $timePosts as $keyStoragePosts => $countShared ): ?>
	            	<?php $count++;
	            		echo airkit_Widgets::widget( $instance, $storagePosts[$time][$keyStoragePosts], array( 'count' => $count ) );
	             endforeach; ?>
            </ul>
            <?php $storageHtml[$time] = ob_get_clean(); ?>
	    <?php endforeach; ?>
	    <div class="ts-tab-container" data-display="horizontal">
		    <ul class="nav nav-tabs" role="tablist">
		    	<li class="active">
		    		<a href="#<?php echo 'ts-last-week-'. $this->id ?>" role="tab" ><?php esc_html_e('Last week', 'gowatch'); ?></a>
		    	</li>
		    	<li>
		    		<a href="#<?php echo 'ts-last-month-'. $this->id ?>" role="tab" ><?php esc_html_e('Last month', 'gowatch'); ?></a>
		    	</li>
		    	<li>
		    		<a href="#<?php echo 'ts-all-time-'. $this->id ?>" role="tab" ><?php esc_html_e('All time', 'gowatch'); ?></a>
		    	</li>
		    </ul>
		    <div class="tab-content">
		    	<div class="tab-pane active" id="<?php echo 'ts-last-week-'. $this->id ?>">
		    		<?php echo airkit_var_sanitize($storageHtml['w'], 'the_kses') ?>
		    	</div>
		    	<div class="tab-pane" id="<?php echo 'ts-last-month-'. $this->id ?>">
		    		<?php echo airkit_var_sanitize($storageHtml['monthnum'], 'the_kses') ?>
		    	</div>
		    	<div class="tab-pane" id="<?php echo 'ts-all-time-'. $this->id ?>">
		    		<?php echo airkit_var_sanitize($storageHtml['all'], 'the_kses') ?>
		    	</div>
		   	</div>
		</div>
        <?php echo airkit_var_sanitize($after_widget, 'the_kses');
	}


    function update( $new_instance, $old_instance) {

        /*save the widget*/
        $instance = $old_instance;

		$instance = airkit_Widgets::widget_update( $new_instance );

		return $instance;
    }

    function form( $instance ) {

    	echo airkit_Widgets::form_post_fields( $instance, $this );

    }



}

?>