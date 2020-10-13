<?php
class airkit_widget_latest_posts extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'airkit_widget_latest_posts' , 'description' => esc_html__( " Get latest posts posts." , 'gowatch' ) );
        parent::__construct( 'widget_touchsize_latest_posts' , esc_html__( 'Latest posts' , 'gowatch' ) , $widget_ops );
    }

    function widget( $args , $instance ){

        /* Extract args to variables */
		extract( $args, EXTR_SKIP );

		// Localize $instance array with missing defaults. see widget_update method @airkit_Widgets.
		extract( airkit_Widgets::widget_update( $instance ) );

		// Any additional actions below.
		$useTab = isset($instance['tab']) ? $instance['tab'] : 'n';

		$args = array( 
				'orderby'        => 'count', 
				'order'          => 'DESC', 
				'post_type'      => $customPost,
				'posts_per_page' => $nr_posts, 
				'post_status'    => 'publish'
			);

		$storagePosts = array();

		if( $useTab == 'y' ){

			if( !empty($taxonomies) ){

				foreach ($taxonomies as $term ){

					$args['tax_query'] = array(
						array(
							'taxonomy' => $taxonomy,
							'field'    => 'slug',
							'terms'    => $term
						)
					);

					$termInfo = get_term_by( 'slug', $term, $taxonomy );
					$storagePosts[$termInfo->name] = get_posts($args);
				}
			}

		}else{

			if( !empty($taxonomies) ){

				$args['tax_query'] = array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'slug',
						'terms'    => $taxonomies
					)
				);

			}

		}

		echo airkit_var_sanitize($before_widget, 'the_kses' );

        echo (!empty( $title ) ? airkit_var_sanitize( $before_title . $title . $after_title, 'the_kses' ) : '');

        if( $useTab == 'y' ): $i = 0;

	        ob_start(); 
	        ob_clean();

	        foreach( $storagePosts as $titleTab => $arrayPosts ): ?>

	    		<div class="tab-pane<?php echo ($i == 0 ? ' active' : '') ?>" id="<?php echo 'oxf-'. sanitize_html_class($titleTab) .'-'. $this->id ?>">
		        	<?php $this->getHtmlPosts($arrayPosts, $instance) ?>
		        </div>

		        <?php 

		        $i++;
		        endforeach; 
		        $content = ob_get_clean();

		       ?>
		    <div class="ts-tab-container" data-display="horizontal">
			    <ul class="nav nav-tabs" role="tablist">
			    	<?php $k = 0; ?>
			    	<?php foreach( $storagePosts as $titleTab => $arrayPosts ): ?>
					    <li<?php echo ($k == 0 ? ' class="active"' : '') ?>>
		        			<a href="#oxf-<?php echo sanitize_html_class($titleTab) ?>-<?php echo airkit_var_sanitize($this->id, 'esc_attr') ?>" role="tab" ><?php echo airkit_var_sanitize( $titleTab, 'esc_attr' ) ?></a>
		        		</li>
		        		<?php $k++; ?>
			    	<?php endforeach; ?>
			    </ul>
			    <div class="tab-content">
			    	<?php echo airkit_var_sanitize( $content, 'the_kses' ) ?>
			   	</div>
			</div>
		<?php else:

			$queryPosts = get_posts( $args );

			$this->getHtmlPosts( $queryPosts, $instance );

		 endif; 
		 
		 echo airkit_var_sanitize( $after_widget, 'the_kses' );
	}


    function update( $new_instance, $old_instance ) {

        /*save the widget*/
        $instance = $old_instance;
		$instance = airkit_Widgets::widget_update( $new_instance );

		$instance['tab']   = $new_instance['tab'] ? $new_instance['tab'] : 'n';

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

    function form( $instance ) {			

		$tab = isset( $instance['tab'] ) ? $instance['tab'] : 'n';

		echo airkit_Widgets::form_post_fields( $instance, $this );

		?>

    	<p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id('tab'), 'esc_attr' ); ?>"><?php esc_html_e('Show tabs','gowatch') ?>:
            	<select name="<?php echo airkit_var_sanitize($this->get_field_name('tab'), 'esc_attr' ); ?>">
            		<option<?php selected($tab, 'y', true); ?> value="y"><?php esc_html_e('Yes', 'gowatch'); ?></option>
            		<option<?php selected($tab, 'n', true); ?> value="n"><?php esc_html_e('No', 'gowatch'); ?></option>
            	</select>
            </label>
        </p>
			
		<?php
    }

    function getHtmlPosts($arrayPosts, $instance){

		$columns = isset($instance['columns']) && ($instance['columns'] === '1' || $instance['columns'] === '2') ? $instance['columns'] : '1';
		
    	?>
		<?php if( !empty($arrayPosts) ) : $count = 0 ?>
			<ul class="widget-items row <?php echo ' widget-columns-' . $columns; ?>">
	        	<?php foreach( $arrayPosts as $postCategory ){
	            	 	$count++; 
	            	 	echo airkit_Widgets::widget( $instance, $postCategory, array( 'count' => $count ) );
	            	 } 
	            ?>
	        </ul>
        <?php else: ?>
        	<?php esc_html_e('No post found', 'gowatch') ?>
        <?php endif ?>
    	<?php
    }
}
?>