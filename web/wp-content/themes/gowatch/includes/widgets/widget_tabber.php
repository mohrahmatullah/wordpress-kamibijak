<?php
class airkit_widget_tabber extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'airkit_widget_tabber' , 'description' => esc_html__( " Get tabber posts." , 'gowatch' ) );
        parent::__construct( 'widget_touchsize_tabber' , esc_html__( 'Tabber posts' , 'gowatch' ) , $widget_ops );
    }

    function widget( $args , $instance ){

        /* Extract args to variables */
        extract( $args, EXTR_SKIP );

        // Localize $instance array with missing defaults. see widget_update method @airkit_Widgets.
        extract( airkit_Widgets::widget_update( $instance ) );

		$args = array(
			'post_type'      => $customPost,
			'posts_per_page' => $nr_posts,
			'post_status'    => 'publish'

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

		$args['order'] = 'DESC';

		$storagePosts = array();

		foreach( array('latest', 'liked', 'shared') as $tab ){

			switch($tab) {
				case 'latest':
					$posts = get_posts($args);
					$storagePosts['latest'] = !empty($posts) && is_array($posts) && !is_wp_error($posts) ? $posts : array();
					break;

				case 'liked':
					$args['meta_key'] = 'airkit_likes';
					$args['orderby']  = 'meta_value_num';
					$posts = get_posts($args);
					$storagePosts['liked'] = !empty($posts) && is_array($posts) && !is_wp_error($posts) ? $posts : array();
					break;

				case 'shared':
					$args['meta_key'] = 'airkit_social_count';
					$args['orderby']  = 'meta_value_num';
					$posts = get_posts($args);
					$storagePosts['shared'] = !empty($posts) && is_array($posts) && !is_wp_error($posts) ? $posts : array();
					break;
			}

		}

		$args = array('number' => 10, 'orderby' => 'count', 'order' => 'DESC');

		$storageHtml = array();

		echo airkit_var_sanitize($before_widget, 'the_kses');

        echo (!empty($title) ? airkit_var_sanitize($before_title . $title . $after_title, 'the_kses') : '');

        $count = 0;

        foreach( $storagePosts as $tab => $arrayPosts ): ?>
        	<?php ob_start(); ob_clean() ?>
	        	<ul class="widget-items row <?php echo ' widget-columns-' . $columns; ?>">
		        	<?php foreach( $arrayPosts as $post ){
		            	$count++;
		            	echo airkit_Widgets::widget( $instance, $post, array( 'count' => $count ) );
		        	}
                    ?>
	            </ul>
            <?php $storageHtml[$tab] = ob_get_clean() ?>
	    <?php endforeach; ?>
	    <div class="ts-tab-container" data-display="horizontal">
		    <ul class="nav nav-tabs" role="tablist">
		    	<li class="active">
		    		<a href="#<?php echo 'ts-latest-'. $this->id ?>" role="tab" ><?php esc_html_e('Latest', 'gowatch'); ?></a>
		    	</li>
		    	<li>
		    		<a href="#<?php echo 'ts-liked-'. $this->id ?>" role="tab" ><?php esc_html_e('Top liked', 'gowatch'); ?></a>
		    	</li>
		    	<li>
		    		<a href="#<?php echo 'ts-shared-'. $this->id ?>" role="tab" ><?php esc_html_e('Top shared', 'gowatch'); ?></a>
		    	</li>
		    </ul>
		    <div class="tab-content">
		    	<div class="tab-pane active" id="<?php echo 'ts-latest-'. $this->id ?>">
		    		<?php echo (!empty($storageHtml['latest']) ? $storageHtml['latest'] : esc_html__('No posts', 'gowatch')) ?>
		    	</div>
		    	<div class="tab-pane" id="<?php echo 'ts-liked-'. $this->id ?>">
		    		<?php echo (!empty($storageHtml['liked']) ? $storageHtml['liked'] : esc_html__('No posts', 'gowatch')) ?>
		    	</div>
		    	<div class="tab-pane" id="<?php echo 'ts-shared-'. $this->id ?>">
		    		<?php echo (!empty($storageHtml['shared']) ? $storageHtml['shared'] : esc_html__('No posts', 'gowatch')) ?>
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