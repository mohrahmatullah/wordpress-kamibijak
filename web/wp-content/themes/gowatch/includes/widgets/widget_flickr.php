<?php
class airkit_widget_flickr extends WP_Widget {
    function __construct() {

        /* Constructor */
        $widget_ops = array('classname' => 'airkit_widget_flickr_photos', 'description' => esc_html__( 'Flickr Photos' , 'gowatch' ) );
        parent::__construct('widget_touchsize_flickrwidget', esc_html__( 'Flickr Photos' , 'gowatch' ), $widget_ops);
    }

    function widget($args, $instance) {

        /* prints the widget */
        extract($args, EXTR_SKIP);
        
        $id = empty($instance['id']) ? '&nbsp;' : apply_filters('widget_id', $instance['id']);
        $title = empty($instance['title']) ? esc_html__('Photo Gallery','gowatch') : apply_filters('widget_title', $instance['title']);
        $number = empty($instance['number']) ? 9 : apply_filters('widget_number', $instance['number']);     
        $showing = empty($instance['showing']) ? '&nbsp;' : apply_filters('widget_showing', $instance['showing']);

        echo airkit_var_sanitize( $before_widget, 'the_kses' );
        if( strlen( $title ) > 0 ){
            echo airkit_var_sanitize( $before_title . $title . $after_title, 'the_kses' );
        }
?>
        <div class="flickr clearfix">
            <script type="text/javascript" src="https://flickr.com/badge_code_v2.gne?count=<?php echo airkit_var_sanitize($number, 'esc_attr'); ?>&amp;display=<?php echo airkit_var_sanitize($showing, 'esc_attr'); ?>&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo airkit_var_sanitize($id, 'esc_attr'); ?>"></script>
        <div class="clear"></div>
        </div>
<?php
        echo airkit_var_sanitize($after_widget, 'the_kses');
    }

    function update($new_instance, $old_instance) {

        /* save the widget */
        $instance = $old_instance;
        $instance['id'] = strip_tags($new_instance['id']);
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = strip_tags($new_instance['number']);
        $instance['showing'] = strip_tags($new_instance['showing']);

        return $instance;
    }

    function form($instance) {
        
        /* widgetform in backend */
        $instance = wp_parse_args( (array) $instance, array('title' => '',  'id' => '', 'number' => '' , 'showing' => '') );
        $id = strip_tags($instance['id']);
        $title = strip_tags($instance['title']);
        $number = strip_tags($instance['number']);
        $showing = strip_tags($instance['showing']);
?>
        <p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id('title'), 'esc_attr'); ?>"><?php esc_html_e('Title','gowatch') ?>:
                <input class="widefat" id="<?php echo airkit_var_sanitize($this->get_field_id('title'), 'esc_attr'); ?>" name="<?php echo airkit_var_sanitize($this->get_field_name('title'), 'esc_attr'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id('id'), 'esc_attr'); ?>">Flickr ID (<a target='_blank' href="http://www.idgettr.com">idGettr</a>):
                <input class="widefat" id="<?php echo airkit_var_sanitize($this->get_field_id('id'), 'esc_attr'); ?>" name="<?php echo airkit_var_sanitize($this->get_field_name('id'), 'esc_attr'); ?>" type="text" value="<?php echo esc_attr($id); ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id('number'), 'esc_attr'); ?>"><?php esc_html_e('Number of photos','gowatch') ?>:
                <input class="widefat" id="<?php echo airkit_var_sanitize($this->get_field_id('number'), 'esc_attr'); ?>" name="<?php echo airkit_var_sanitize($this->get_field_name('number'), 'esc_attr'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id('showing'), 'esc_attr'); ?>"><?php esc_html_e('Showing Method','gowatch') ?>:
                <select size="1" name="<?php echo airkit_var_sanitize($this->get_field_name('showing'), 'esc_attr'); ?>">
                    <option value="random"<?php if(esc_attr($showing) =='random'){echo 'selected';}?>><?php esc_html_e('Random Photo','gowatch'); ?></option>
                    <option value="latest"<?php if(esc_attr($showing) =='latest'){echo 'selected';}?>><?php esc_html_e('Latest Photo','gowatch') ?></option>
                </select>
            </label>
        </p>
<?php
    }
}
?>