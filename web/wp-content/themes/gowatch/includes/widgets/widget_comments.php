<?php
    class airkit_widget_comments extends WP_Widget {

        function __construct() {
            $widget_ops = array( 'classname' => 'airkit_widget_comments' , 'description' => esc_html__( 'Comments' , 'gowatch' ) );
            parent::__construct( 'widget_touchsize_comments' ,  esc_html__( 'Comments' , 'gowatch' ) , $widget_ops );
        }

        function widget( $args , $instance ) {

            /* prints the widget*/
            extract($args, EXTR_SKIP);

            if( isset( $instance['title'] ) ){
                $title = $instance['title'];
            }else{
                $title = '';
            }

            if( isset( $instance['nr_comments'] ) ){
                $nr_comments = $instance['nr_comments'];
            }else{
                $nr_comments = 0;
            }

            echo airkit_var_sanitize( $before_widget, 'the_kses' );

            if( !empty( $title ) ){
                echo airkit_var_sanitize( $before_title . $title . $after_title, 'the_kses' );
            }

        ?>
            
            <div class="widget-container">
                <?php
                    $args = array(
                        'number' => $nr_comments,
                        'status' => 'approve'
                    );

                    $comments = get_comments( $args );

                    if( !empty( $comments ) && is_array( $comments ) ){
                        echo '<ul class="widget-items">';
                        /* list comments */
                        foreach($comments as $comment) {

                            /* get post info */
                            $post = get_post( $comment->comment_post_ID );

                            /* get user info */
                            $user = get_users( array( 'include' => $comment->user_id ) );
                            $user_url = '';

                            /* get user ulr */
                            if( !empty( $user ) ){
                                $user_url = $user[0]->user_url;
                            }

                            /* author comment */
                            if( $comment->comment_author_url != ''){
                                /* get author url */
                                $author_url = '<a href="' . $comment->comment_author_url . '">' . mb_substr( $comment->comment_author , 0 , 15 );

                                if( strlen( $comment->comment_author ) > 15 ){
                                    $author_url .=  '...</a>';
                                }else{
                                    $author_url .= '</a>';
                                }
                            }else{
                                /* create user url */
                                if( $user_url != '' ){
                                    $author_url = '<a href="' . $user_url . '">' . mb_substr( $comment->comment_author , 0 , 15 );
                                    if( strlen( $comment->comment_author ) > 15 ){
                                        $author_url .=  '...</a>';
                                    }else{
                                        $author_url .= '</a>';
                                    }
                                }else{
                                    $author_url = mb_substr( $comment->comment_author , 0 , 15 );
                                    if( strlen( $comment->comment_author ) > 15 ){
                                        $author_url .=  '...';
                                    }
                                }
                            }
                ?>
                            <li>
                                <article class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <a class="entry-img" href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment -> comment_ID; ?>">
                                            <?php echo airkit_get_avatar( $comment, 'thumbnail' );  ?>
                                        </a>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <h4>
                                            <a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>">
                                                <?php
                                                    echo strip_tags( mb_substr( $comment->comment_content , 0 , 45 ) );
                                                    if( strlen ( strip_tags ( $comment->comment_content ) ) > 45 ){
                                                        echo ' ...';
                                                    }
                                                ?>
                                            </a>
                                        </h4>
                                        <div class="widget-meta">
                                            <ul>
                                                <li class="entry-author"><?php echo airkit_var_sanitize( $author_url, 'the_kses' ); ?></li>
                                                    <?php
                                                        $comment_time = date_i18n(get_option( 'date_format' ), strtotime($comment->comment_date) );
                                                    ?>
                                                <li class="entry-time">
                                                    <time datetime="<?php echo date('Y-m-d',strtotime($comment->comment_date)); ?>"><?php echo airkit_var_sanitize( $comment_time, 'esc_attr' ); ?></time>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                            </li>
                <?php
                        }
                        echo '</ul>';
                    }else{
                        echo '<p>' . esc_html__( 'There are no comments' , 'gowatch' ) . '</p>';
                    }
                ?>
                </div>
            <?php

            echo airkit_var_sanitize( $after_widget, 'the_kses' );
        }

        function update( $new_instance, $old_instance) {

            /*save the widget*/
            $instance = $old_instance;
            $instance['title']              = strip_tags( $new_instance['title'] );
            $instance['nr_comments']        = strip_tags( $new_instance['nr_comments'] );

            return $instance;
        }

        function form($instance) {

            /* widget form in backend */
            $instance       = wp_parse_args( (array) $instance, array( 'title' => '' ,  'nr_comments' => 10 ) );
            $title          = strip_tags( $instance['title'] );
            $nr_comments    = strip_tags( $instance['nr_comments'] );
    ?>

            <p>
                <label for="<?php echo airkit_var_sanitize( $this->get_field_id('title'), 'esc_attr' ); ?>"><?php esc_html_e('Title','gowatch') ?>:
                    <input class="widefat" id="<?php echo airkit_var_sanitize( $this->get_field_id('title'), 'esc_attr' ); ?>" name="<?php echo airkit_var_sanitize($this->get_field_name('title'), 'esc_attr' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo airkit_var_sanitize( $this->get_field_id('nr_comments'), 'esc_attr' ); ?>"><?php esc_html_e( 'Number of comments' , 'gowatch' ); ?>:
                    <input class="widefat digit" id="<?php echo airkit_var_sanitize( $this->get_field_id('nr_comments'), 'esc_attr' ); ?>" name="<?php echo airkit_var_sanitize( $this->get_field_name('nr_comments'), 'esc_attr' ); ?>" type="text" value="<?php echo esc_attr( $nr_comments ); ?>" />
                </label>
            </p>
    <?php
        }
    }
?>