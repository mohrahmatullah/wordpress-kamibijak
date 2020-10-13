<?php
    class airkit_widget_tweets extends WP_Widget {

        function __construct() {
            $widget_ops = array( 'classname' => 'airkit_widget_tweets', 'description' => 'Display Latest tweets' );
            parent::__construct( 'widget_touchsize_tweets' ,  esc_html__('Latest tweets','gowatch') , $widget_ops );
        }

        function form($instance) {
            if( isset($instance['title']) ){
                $title = esc_attr($instance['title']);
            }else{
                $title = null;
            }

            if( isset($instance['number']) ){
                $number = esc_attr($instance['number']);
            }else{
                $number = 10;
            }

            if( isset($instance['username']) ){
                $username = esc_attr($instance['username']);
            }else{
                $username = null;
            }
            ////////////////////
            if( isset($instance['consumerKey']) ){
                $consumerKey = esc_attr($instance['consumerKey']);
            }else{
                $consumerKey = null;
            }

            if( isset($instance['consumerSecret']) ){
                $consumerSecret = esc_attr($instance['consumerSecret']);
            }else{
                $consumerSecret = null;
            }

            if( isset($instance['accessToken']) ){
                $accessToken = esc_attr($instance['accessToken']);
            }else{
                $accessToken = null;
            }
            if( isset($instance['accessTokenSecret']) ){
                $accessTokenSecret = esc_attr($instance['accessTokenSecret']);
            }else{
                $accessTokenSecret = null;
            }

            /////////////////////
            if( isset($instance['dynamic']) ){
                $dynamic = esc_attr( $instance['dynamic'] );
            }else{
                $dynamic = '';
            }

            if( isset($instance['columns']) ){
                $columns = esc_attr( $instance['columns'] );
            }else{
                $columns = '1';
            }

            if( isset($instance['followus']) ){
                $followus = esc_attr( $instance['followus'] );
            }else{
                $followus = '';
            }
        ?>
         <p>
          <label for="<?php echo airkit_var_sanitize($this->get_field_id( 'title' ), 'esc_attr' ); ?>"><?php esc_html_e( 'Title' , 'gowatch' ); ?>:</label>
          <input class="widefat" id="<?php echo airkit_var_sanitize($this->get_field_id( 'title' ), 'esc_attr' ); ?>" name="<?php echo airkit_var_sanitize($this->get_field_name( 'title' ), 'esc_attr' ); ?>" type="text" value="<?php echo airkit_var_sanitize($title, 'esc_attr' ); ?>" />
        </p>
        <p>
          <label for="<?php echo airkit_var_sanitize($this->get_field_id( 'username' ), 'esc_attr'); ?>"><?php esc_html_e( 'Twitter User Name' , 'gowatch' ); ?>:</label>
          <input class="widefat" id="<?php echo airkit_var_sanitize($this->get_field_id( 'username' ), 'esc_attr'); ?>" name="<?php echo airkit_var_sanitize($this->get_field_name( 'username' ), 'esc_attr'); ?>" type="text" value="<?php echo airkit_var_sanitize($username, 'esc_attr'); ?>" />
        </p>
        <p>
          <label for="<?php echo airkit_var_sanitize($this->get_field_id( 'number' ), 'esc_attr'); ?>"><?php esc_html_e( 'Number of latest tweets to show' , 'gowatch' ); ?>:</label>
          <input id="<?php echo airkit_var_sanitize($this->get_field_id( 'number' ), 'esc_attr'); ?>"  size="3" name="<?php echo airkit_var_sanitize($this->get_field_name('number'), 'esc_attr'); ?>" type="text" value="<?php echo airkit_var_sanitize($number, 'esc_attr'); ?>" />
        </p>

        <p class="twitter-columns-select">
            <label for="<?php echo airkit_var_sanitize($this->get_field_id('columns'), 'esc_attr'); ?>"><?php esc_html_e('Columns','gowatch') ?>:
                <select name="<?php echo airkit_var_sanitize($this->get_field_name('columns'), 'esc_attr'); ?>">
                    <option <?php selected($columns, '1', true); ?>value="1"> 1 </option>
                    <option <?php selected($columns, '2', true); ?>value="2"> 2 </option>
                    <option <?php selected($columns, '3', true); ?>value="3"> 3 </option>
                </select>
            </label>                    
        </p>       

        <p class="twitter-animated">
            <label for="<?php echo airkit_var_sanitize($this->get_field_id( 'dynamic' ), 'esc_attr'); ?>"><?php esc_html_e( 'Animated' , 'gowatch' ); ?>:</label>
            <input type="checkbox" id="<?php echo airkit_var_sanitize($this->get_field_id( 'dynamic' ), 'esc_attr'); ?>"  <?php checked( $dynamic , true ); ?>  name="<?php echo airkit_var_sanitize($this->get_field_name( 'dynamic' ), 'esc_attr'); ?>"  value="1" />
        </p>

        <p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id( 'followus' ), 'esc_attr'); ?>"><?php esc_html_e( 'Show follow us' , 'gowatch' ); ?>:</label>
            <input type="checkbox" id="<?php echo airkit_var_sanitize($this->get_field_id( 'followus' ), 'esc_attr'); ?>"  <?php checked( $followus , true ); ?>  name="<?php echo airkit_var_sanitize($this->get_field_name( 'followus' ), 'esc_attr'); ?>"  value="1" class="twitter-animate"/>
        </p>

        <p>
            <span class="hint"><?php echo sprintf(esc_html__( 'Now you need to do it to create an application in %s https://dev.twitter.com/apps %s and fill the requirements there. Once finished you will have your consumer key, consumer secret, access token and access token secret.' , 'gowatch' ), '<a href="https://dev.twitter.com/apps">', '</a>' ); ?></span>

        </p>

        <p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id( 'consumerKey' ), 'esc_attr'); ?>"><?php esc_html_e( 'Consumer key' , 'gowatch' ); ?>:</label>
            <input id="<?php echo airkit_var_sanitize($this->get_field_id( 'consumerKey' ), 'esc_attr'); ?>"   name="<?php echo airkit_var_sanitize($this->get_field_name('consumerKey'), 'esc_attr'); ?>" type="text" value="<?php echo airkit_var_sanitize($consumerKey, 'esc_attr'); ?>" />
        </p>

        <p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id( 'consumerSecret' ), 'esc_attr'); ?>"><?php esc_html_e( 'Consumer secret' , 'gowatch' ); ?>:</label>
            <input id="<?php echo airkit_var_sanitize($this->get_field_id( 'consumerSecret' ), 'esc_attr'); ?>"   name="<?php echo airkit_var_sanitize($this->get_field_name('consumerSecret'), 'esc_attr'); ?>" type="text" value="<?php echo airkit_var_sanitize($consumerSecret, 'esc_attr'); ?>" />
        </p>

        <p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id( 'accessToken' ), 'esc_attr'); ?>"><?php esc_html_e( 'Access token' , 'gowatch' ); ?>:</label>
            <input id="<?php echo airkit_var_sanitize($this->get_field_id( 'accessToken' ), 'esc_attr'); ?>"   name="<?php echo airkit_var_sanitize($this->get_field_name('accessToken'), 'esc_attr'); ?>" type="text" value="<?php echo airkit_var_sanitize($accessToken, 'esc_attr'); ?>" />
        </p>

        <p>
            <label for="<?php echo airkit_var_sanitize($this->get_field_id( 'accessTokenSecret' ), 'esc_attr' ); ?>"><?php esc_html_e( 'Access token secret' , 'gowatch' ); ?>:</label>
            <input id="<?php echo airkit_var_sanitize($this->get_field_id( 'accessTokenSecret' ), 'esc_attr' ); ?>"   name="<?php echo airkit_var_sanitize($this->get_field_name('accessTokenSecret'), 'esc_attr' ); ?>" type="text" value="<?php echo airkit_var_sanitize($accessTokenSecret, 'esc_attr' ); ?>" />
        </p>

        <script>
            jQuery(document).ready(function(){

                if( jQuery('.twitter-columns-select select').val() !== '1'  ) {
                    jQuery('.twitter-animated').hide();
                } else {
                    jQuery('.twitter-animated').show();
                }

                jQuery('.twitter-columns-select select').change(function(event) {

                    if( jQuery(this).val() !== '1'  ) {
                        jQuery('.twitter-animated').hide();
                    } else {
                        jQuery('.twitter-animated').show();
                    }

                });

            });
        </script>

        <?php
        }

        function update( $new_instance, $old_instance) {
            $instance = $old_instance;

            $instance['title']      = strip_tags($new_instance['title']);
            $instance['number']     = strip_tags($new_instance['number']);
            $instance['username']   = strip_tags($new_instance['username']);
            $instance['dynamic']   = isset( $new_instance['dynamic'] ) ? 1 : 0;
            $instance['columns']   = isset( $new_instance['columns'] ) ? (int)$new_instance['columns'] : 1;
            $instance['followus']   = isset( $new_instance['followus'] ) ? 1 : 0;


            $instance['consumerKey']   = strip_tags($new_instance['consumerKey']);
            $instance['consumerSecret']   = strip_tags($new_instance['consumerSecret']);
            $instance['accessToken']   = strip_tags($new_instance['accessToken']);
            $instance['accessTokenSecret']   = strip_tags($new_instance['accessTokenSecret']);
            return $instance;
        }

        function widget( $args, $instance ) {
            $title                     = apply_filters( 'widget_title', $instance['title'] );
            $username                  = trim($instance['username']);
            $limit                     = (isset($instance['number']) && is_numeric($instance['number'])) ? $instance['number'] : 5;
            $oauth_access_token        = trim($instance['accessToken']);
            $oauth_access_token_secret = trim($instance['accessTokenSecret']);
            $consumer_key              = trim($instance['consumerKey']);
            $consumer_secret           = trim($instance['consumerSecret']);
            $dynamic                   = (isset($instance['dynamic']) && absint($instance['dynamic']) == 1) ? 'dynamic' : 'static';
            $columns                   = isset( $instance['columns'] ) ? (int)$instance['columns'] : 1;
            $followus                  = (isset($instance['followus']) && absint($instance['followus']) == 1) ? 'yes' : 'no';

            echo airkit_var_sanitize($args['before_widget'], 'the_kses');

            if ( ! empty( $title ) ) {
                echo airkit_var_sanitize($args['before_title'] . $title . $args['after_title'], 'the_kses');
            }

            // Get the tweets.
            $timelines = $this->twitter_timeline( $username, $limit, $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret );

            if ( isset( $timelines ) && is_array( $timelines ) && ! empty( $timelines ) ) {

                // Add links to URL and username mention in tweets.
                $patterns = array( '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '/@([A-Za-z0-9_]{1,15})/' );
                $replace = array( '<a href="$1">$1</a>', '<a href="http://twitter.com/$1">@$1</a>' );

                $followus_html = '';
                if($followus != 'no'){
                    $followus_html =    '<div class="twitter-follow">
                                            <i class="icon-twitter"></i>
                                            <a href="http://twitter.com/' . $username . '" target="_blank">
                                                ' . esc_html__('Follow us', 'gowatch') . ' <b>@' . $username . '</b>
                                            </a>
                                        </div>';

                }

                $col_class = airkit_Compilator::get_column_class( $columns );
                $clear = airkit_Compilator::get_clear_class( $columns );

                $html = '<div class="airkit_twitter-container ' . $dynamic . '">
                            <ul class="widget-items row ' .  $clear . '">';

                foreach ( $timelines as $timeline ) {
                    $result = preg_replace($patterns, $replace, $timeline->text);

                    $html .=    '<li class="'. $col_class .'">
                                    <div class="tweet-entry">
                                        <i class="icon-twitter"></i>
                                        <a class="tweet-author" href="http://twitter.com/' . $timeline->user->screen_name . '" target="_blank">@' . $timeline->user->screen_name . '</a>
                                        <div class="tweet-content">' . $result . '</div>
                                        <time class="tweet-date">' . $this->tweet_time($timeline->created_at) . '</time>
                                    </div>
                                </li>';
                }

                $html .=    '</ul>
                            ' . $followus_html . '
                        </div>';

                echo airkit_var_sanitize($html, 'the_kses');

            } else {
                esc_html_e( 'Error fetching feeds. Please verify the Twitter settings in the widget.', 'gowatch' );
            }

            echo airkit_var_sanitize($args['after_widget'], 'the_kses');
        }

        function twitter_timeline( $username, $limit, $oauth_access_token, $oauth_access_token_secret, $consumer_key, $consumer_secret ) {

            if ( false === ( $timeline = get_transient( 'ts-twitter-' . sanitize_title_with_dashes( $username ) ) ) ) {

                require_once get_template_directory() . '/includes/widgets/TwitterAPIExchange.php';

                /** Set access tokens here - see: https://dev.twitter.com/apps/ */
                $settings = array(
                    'oauth_access_token'        => $oauth_access_token,
                    'oauth_access_token_secret' => $oauth_access_token_secret,
                    'consumer_key'              => $consumer_key,
                    'consumer_secret'           => $consumer_secret
                );

                $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
                $getfield = '?screen_name=' . $username . '&count=' . $limit;
                $request_method = 'GET';

                $twitter_instance = new TwitterAPIExchange( $settings );

                $query = $twitter_instance
                    ->setGetfield( $getfield )
                    ->buildOauth( $url, $request_method )
                    ->performRequest();

                $timeline = json_decode( $query );

                // do not set an empty transient - should help catch private or empty accounts
                if ( ! empty( $timeline ) ) {

                    set_transient( 'ts-twitter-' . sanitize_title_with_dashes( $username ), $timeline, MINUTE_IN_SECONDS * 20 );
                }

            }

            return $timeline;
        }

        function tweet_time( $time ) {
            // Get current timestamp.
            $now = strtotime( 'now' );

            // Get timestamp when tweet created.
            $created = strtotime( $time );

            // Get difference.
            $difference = $now - $created;

            // Calculate different time values.
            $minute = 60;
            $hour = $minute * 60;
            $day = $hour * 24;
            $week = $day * 7;

            if ( is_numeric( $difference ) && $difference > 0 ) {

                // If less than 3 seconds.
                if ( $difference < 3 ) {
                    return esc_html__( 'right now', 'gowatch' );
                }

                // If less than minute.
                if ( $difference < $minute ) {
                    return floor( $difference ) . ' ' . esc_html__( 'seconds ago', 'gowatch' );;
                }

                // If less than 2 minutes.
                if ( $difference < $minute * 2 ) {
                    return esc_html__( 'about 1 minute ago', 'gowatch' );
                }

                // If less than hour.
                if ( $difference < $hour ) {
                    return floor( $difference / $minute ) . ' ' . esc_html__( 'minutes ago', 'gowatch' );
                }

                // If less than 2 hours.
                if ( $difference < $hour * 2 ) {
                    return esc_html__( 'about 1 hour ago', 'gowatch' );
                }

                // If less than day.
                if ( $difference < $day ) {
                    return floor( $difference / $hour ) . ' ' . esc_html__( 'hours ago', 'gowatch' );
                }

                // If more than day, but less than 2 days.
                if ( $difference > $day && $difference < $day * 2 ) {
                    return esc_html__( 'yesterday', 'gowatch' );;
                }

                // If less than year.
                if ( $difference < $day * 365 ) {
                    return floor( $difference / $day ) . ' ' . esc_html__( 'days ago', 'gowatch' );
                }

                // Else return more than a year.
                return esc_html__( 'over a year ago', 'gowatch' );
            }
        }

    }

?>