<?php

/**
 * User Frontend Dashboard class
 *
 * @author TouchSize
 * @package Touchsize Frontend Submission
 */
class TSZF_Frontend_Dashboard {

    public $userdata;
    public $user_settings = array();
    public $active_tab;
    public $sortby;
    public $post_type;
    public $post_status;
    public $posts_per_page;
    public $profile_tabs;

    function __construct( $atts = array() )
    {
        if ( empty( $this->post_type ) ) {
            $this->post_type = array( 'post', 'video', 'ts-gallery' );
        }

        /*
         * User ID is stored in $_GET['user']. 
         * If it's not set, view current user profile.
         */
        $this->userdata = isset( $_GET['user'] ) ? get_userdata( $_GET['user'] ) : get_userdata( get_current_user_id() );
        
        if ( $this->userdata ) {
            $this->user_settings = get_the_author_meta( 'airkit_user_settings', $this->userdata->ID );
        }

        $this->posts_per_page = tszf_get_option( 'per_page', 'tszf_dashboard', 10 );
        $this->active_tab = isset( $_GET['active_tab'] ) ? $_GET['active_tab'] : 'home';
        $this->sortby = isset( $_GET['sortby'] ) ? $_GET['sortby'] : 'newest';
        $this->profile_tabs();

        add_filter( 'pre_get_document_title', array( $this, 'hack_wp_title_depends_active_tab' ) );
    }

    /**
     * Handle's user dashboard functionality
     * 
     * @return generated content
     */
    function build()
    {
        $this->post_listing( $this->post_type );

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * List's all the posts by the user
     *
     * @global object $wpdb
     */
    function post_listing( $post_type )
    {
        global $post;

        $pagenum = isset( $_GET['pagenum'] ) ? intval( $_GET['pagenum'] ) : 1;

        //delete post
        if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == "del" ) {
            $this->delete_post();
        }

        //show delete success message
        if ( isset( $_GET['msg'] ) && $_GET['msg'] == 'deleted' ) {
            echo '<div class="success airkit_alert alert-success">' . __( 'Post Deleted', 'gowatch' ) . '</div>';
        }

        // Limit number of posts to show on home profile page
        if ( $this->active_tab == 'home' ) {
            $this->posts_per_page = 3;
        }

        $original_post   = $post;
        $dashboard_query = $this->dashboard_query( $post_type );
        $most_popular_query = $this->dashboard_query( $post_type, array('sortby' => 'most_popular') );
        $favorites_query = $this->favorites_query();
        $playlists_query = $this->playlists_query();
        $post_type_obj   = get_post_type_object( $post_type );

        // Load dashboard template and localize variables.
        tszf_load_template( 'dashboard.php', array(
            'post_type'       => $post_type,
            'dashboard_query' => $dashboard_query,
            'popular_query'   => $most_popular_query,
            'favorites_query' => $favorites_query,
            'playlists_query' => $playlists_query,
            'post_type_obj'   => $post_type_obj,
            'post'            => $post,
            'pagenum'         => $pagenum,
            'userdata'        => $this->userdata,
            'is_my_profile'   => $this->is_my_profile(),
            'social_icons'    => $this->author_social(),
            'member_since'    => $this->member_since(),
            'active_tab'      => $this->active_tab,
        ) );

        wp_reset_postdata();
    }

    /**
     * Get author social newtworks
     * 
     * @return string
     */
    function author_social()
    {
        $social = '';
        
        $social_names = array(
            'facebook' => 'Facebook',
            'skype' => 'Skype',
            'github' => 'GitHub',
            'gplus' => 'Google+',
            'dribbble' => 'Dribbble',
            'lastfm' => 'Last.fm',
            'tumblr' => 'Tumblr',
            'twitter' => 'Twitter',
            'vimeo' => 'Vimeo',
            'wordpress' => 'WordPress',
            'yahoo' => 'Yahoo',
            'youtube' => 'YouTube',
            'flickr' => 'Flickr',
            'pinterest' => 'Pinterest',
            'instagram' => 'Instagram',
            'snapchat' => 'Snapchat',
            'vk' => 'VK',
            'reddit' => 'reddit',
        );

        if( !empty( $this->user_settings ) ) {

            foreach ( $this->user_settings as $key => $val ) {

                //Retrieve only social setting.

                if( !strpos( $key, 'social' ) || empty( $val ) )
                    continue;

                if ( strpos($key, 'youtube') ) {
                    $icon = 'icon-video';
                } else {
                    $icon = str_replace( 'user_social_', 'icon-', $key );
                }

                $title = $social_names[str_replace('user_social_', '', $key)];

                $social .= '<li><a href="'. esc_url( $val ) .'" title="'. esc_attr( $title ) .'"><i class="'. $icon .'"></i></a></li>';
                
            }

        }

        return $social;
    }

    /**
     * Get member since registered
     * 
     * @return string
     */
    function member_since()
    {
        $registered = $this->userdata->user_registered;
        $date = human_time_diff( strtotime( $registered ) ) . ' ' . esc_html__( 'ago', 'gowatch' );
        return $date;
    }

    function user_avatar($size = '150')
    {
        $user_avatar = airkit_get_avatar( $this->userdata->ID, $size );

        // Super admins/admins normally
        if ( current_user_can('manage_options') ) {
            $user_avatar .= '<a class="profile-change-img" href="'. esc_url( $this->profile_tabs['settings']['url'] ) .'" title="'. esc_html__('Change your avatar photo', 'gowatch') .'"><span><i class="icon-gallery"></i></span></a>';
        }

        echo force_balance_tags($user_avatar);
    }

    function user_cover()
    {
        $output = '<div class="tszf-author-cover">';

        if ( ! empty($this->user_settings['cover']) ) {
            $user_cover = wp_get_attachment_url( $this->user_settings['cover'] );
            $output = '<div class="tszf-author-cover" style="background-image: url('. esc_url($user_cover) .')">';
        }

        // Super admins/admins normally
        if ( current_user_can('manage_options') ) {
            $output .= '<a class="profile-change-img" href="'. esc_url( $this->profile_tabs['settings']['url'] ) .'" title="'. esc_html__('Change your cover photo', 'gowatch') .'"><span><i class="icon-gallery"></i> '. esc_html__('Change your cover photo', 'gowatch') .'</span></a>';
        }

        $output .= '</div><!-- /.tszf-author-cover -->';

        echo force_balance_tags($output);
    }

    /**
     * Delete a post
     * Only post author and editors has the capability to delete a post
     */
    function delete_post() 
    {
        $nonce = $_REQUEST['_wpnonce'];

        if ( !wp_verify_nonce( $nonce, 'tszf_del' ) ) {
            die( "Security check" );
        }

        //check, if the requested user is the post author
        $maybe_delete = get_post( $_REQUEST['pid'] );

        if ( ($maybe_delete->post_author == $this->userdata->ID) || current_user_can( 'delete_others_pages' ) ) {
            wp_delete_post( $_REQUEST['pid'] );

            //redirect
            $redirect = add_query_arg( array('msg' => 'deleted'), get_permalink() );
            wp_redirect( $redirect );
        } else {
            echo '<div class="error airkit_alert alert-success">' . __( 'You are not the post author. Cheeting huh!', 'gowatch' ) . '</div>';
        }
    }

    /**
     * Helper function, telling if i'm viewing my own profile.
     * 
     * @return bool
     */
    function is_my_profile()
    {
        $current_user_id = get_current_user_id();

        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'user-profile.php'
        ));

        if( is_object( $this->userdata ) && $this->userdata->ID === $current_user_id && $pages[0]->ID == get_the_ID() ) {
            return true;
        }

        return false;
    }

    /**
     * Returns WP_Query object containing user's favorite posts.
     */
    function favorites_query() 
    {

        $favorites = get_user_meta( $this->userdata->ID, 'favorites', true );

        if( !empty( $favorites ) ) {
            $favorites_ids = explode( '|', $favorites );
        }

        if ( empty($favorites_ids) ) {
            $favorites_ids = array(0);
        }

        $args = array(
            'post_type' => array( 'post', 'video', 'gallery' ),
            'orderby'   => 'ASC',
            'post__in'  => $favorites_ids,
            'posts_per_page' => $this->posts_per_page,
        );

        $args = $this->add_query_sort_var($args);
        
        return new WP_Query( $args );

    }

    /**
     * Returns WP_Query object containing user's playlists.
     */
    function playlists_query() 
    {
        $args = array(
            'post_type' => 'playlist',
            'author'    => $this->userdata->ID,
            'orderby'   => 'ASC',
            'posts_per_page' => $this->posts_per_page,
        );

        $args = $this->add_query_sort_var($args);
        
        return new WP_Query( $args );

    }
    /**
     * Returns WP_Query object containing user's posts.
     */
    function dashboard_query( $post_type, $options = array() )
    {
        if ( empty($this->post_status) ) {
            $this->post_status = array('draft', 'future', 'pending', 'publish', 'private');
        }

        $args = array(
            'author'         => $this->userdata->ID,
            'post_status'    => $this->post_status,
            'post_type'      => $post_type,
            'posts_per_page' => $this->posts_per_page,
        );

        $args = $this->add_query_sort_var($args, $options);

        $dashboard_query = new WP_Query( apply_filters( 'tszf_dashboard_query', $args ) );        

        return $dashboard_query;
    }

    /**
     * Posts views defaults options
     * 
     * @param array $options 
     * @return array
     */
    function views_options( $options = array() )
    {
        // Defaults
        $view_options = array(
            'element-type'    => 'thumbnail',
            'reveal-effect'   => 'none',
            'reveal-delay'    => 'none',
            'per-row'         => '3',
            'behavior'        => 'normal',
            'featimg'         => 'y',
            'title-position'  => 'below-image',
            'excerpt'         => 'y',
            'small-posts'     => 'n',
            'meta'            => 'y',
            'gutter-space'    => '40',
            'order-direction' => 'DESC',
            'order-by'        => 'ID',
            'post-type'       => $this->post_type,
        );

        return array_merge($view_options, $options);
    }

    /**
     * Playlist view defaults options
     * 
     * @param array $options 
     * @return array
     */
    function playlist_view_options( $options = array() )
    {
        // Defaults
        $view_options = array(
            'element-type'    => 'playlist',
            'reveal-effect'   => 'none',
            'reveal-delay'    => 'none',
            'per-row'         => '3',
            'behavior'        => 'normal',
            'featimg'         => 'y',
            'gutter-space'    => '40',
            'order-direction' => 'DESC',
            'order-by'        => 'ID',
            'post-type'       => 'playlist',
        );

        return array_merge($view_options, $options);
    }

    /**
     * Generate profile tabs
     * 
     * @return string
     */
    function profile_tabs()
    {
        $tabs = array(
            'home' => array(
                'title' => esc_html__('Home', 'gowatch'),
                'url' => remove_query_arg( 'sortby', add_query_arg( array('active_tab' => 'home') ) ),
                'class' => ('home' == $this->active_tab ? 'active' : ''),
            ),
            'posts' => array(
                'title' => esc_html__('Posts', 'gowatch'),
                'url' => remove_query_arg( 'sortby', add_query_arg( array('active_tab' => 'posts') ) ),
                'class' => ('posts' == $this->active_tab ? 'active' : ''),
            ),
            'favorites' => array(
                'title' => esc_html__('Favorites', 'gowatch'),
                'url' => remove_query_arg( 'sortby', add_query_arg( array('active_tab' => 'favorites') ) ),
                'class' => ('favorites' == $this->active_tab ? 'active' : ''),
            ),
            'playlists' => array(
                'title' => esc_html__('Playlists', 'gowatch'),
                'url' => remove_query_arg( 'sortby', add_query_arg( array('active_tab' => 'playlists') ) ),
                'class' => ('playlists' == $this->active_tab ? 'active' : ''),
            ),
            'about' => array(
                'title' => esc_html__('About', 'gowatch'),
                'url' => remove_query_arg( 'sortby', add_query_arg( array('active_tab' => 'about') ) ),
                'class' => ('about' == $this->active_tab ? 'active' : ''),
            ),
            'settings' => array(
                'title' => '<i class="icon-settings"></i>',
                'url' => remove_query_arg( 'sortby', add_query_arg( array('active_tab' => 'settings') ) ),
                'class' => 'ts-item-tab-settings ' . ('settings' == $this->active_tab ? 'active' : ''),
            ),
        );

        $this->profile_tabs = $tabs;
    }
     
    /**
     * Customize the title for the profile page, depends on active tab
     *
     * @param string $title The original title.
     * @return string The title to use.
     */
    function hack_wp_title_depends_active_tab( $title )
    {

        if ( ! $this->is_my_profile() ) {
            return;
        }

        if ( $this->active_tab == 'home' ) {
            $title = $this->userdata->user_nicename . ' - ' . get_bloginfo( 'name' );
        }
        elseif ( $this->active_tab == 'posts' ) {
            $title = $this->userdata->user_nicename . ' - ' . get_bloginfo( 'name' ) . ' | ' . esc_html__( 'Posts', 'gowatch' );
        }
        elseif ( $this->active_tab == 'favorites' ) {
            $title = $this->userdata->user_nicename . ' - ' . get_bloginfo( 'name' ) . ' | ' . esc_html__( 'Favorites', 'gowatch' );
        }
        elseif ( $this->active_tab == 'playlists' ) {
            $title = $this->userdata->user_nicename . ' - ' . get_bloginfo( 'name' ) . ' | ' . esc_html__( 'Playlists', 'gowatch' );
        }
        elseif ( $this->active_tab == 'about' ) {
            $title = $this->userdata->user_nicename . ' - ' . get_bloginfo( 'name' ) . ' | ' . esc_html__( 'About', 'gowatch' );
        }
        elseif ( $this->active_tab == 'settings' ) {
            $title = $this->userdata->user_nicename . ' - ' . get_bloginfo( 'name' ) . ' | ' . esc_html__( 'Settings', 'gowatch' );
        }

        return $title;
    }

    /**
     * Generate sortable dropdown
     */
    function sortby($exclude = array())
    {
        $sorts = array(
            'newest' => array(
                'title' => esc_html__('Newest', 'gowatch'),
            ),
            'oldest' => array(
                'title' => esc_html__('Oldest', 'gowatch'),
            ),
            'most_popular' => array(
                'title' => esc_html__('Most popular', 'gowatch'),
            ),
        );

        // Check if Plugin TouchRate is activated for theme
        if ( class_exists('TouchRate') ) {
            $sorts['top_rated'] = array(
                'title' => esc_html__('Top rated', 'gowatch'),
            );
        }

        if ( ! empty($exclude) ) {
            foreach ($sorts as $id => $value) {
                if ( in_array($id, $exclude) ) {
                    unset($sorts[$id]);
                }
            }
        }

        $output = '<div class="tszf-author-sort-posts text-right">';
        $output .= '<div class="inner-sort-posts">';
        $output .= '<button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="tszf-posts-sortby">
                <i class="icon-filter"></i>'. esc_html__('Sort by', 'gowatch') .'
            </button>';

        $output .= '<ul class="dropdown-menu" aria-labelledby="tszf-posts-sortby">';

            foreach ($sorts as $key => $item) {
                $sort_url = add_query_arg( array( 'active_tab' => $this->active_tab, 'sortby' => $key ) );
                $output .= '<li'. ($this->sortby == $key ? ' class="active"' : '') .'><a href="'. esc_url($sort_url) .'">'. $item['title'] .'</a></li>';
            }

        $output .= '</ul>';
        $output .= '</div></div>';

        echo force_balance_tags($output);
    }

    /**
     * Add sortable parameter to posts query
     * 
     * @param array $args 
     * @return array
     */
    function add_query_sort_var( $args, $options = array() )
    {
        extract($args);

        $sortby = isset($options['sortby']) ? $options['sortby'] : $this->sortby;

        switch ($sortby) {
            case 'most_popular':
                $args['meta_key'] = 'airkit_views';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
                break;

            case 'top_rated':
                $touchrate = new TouchRate();
                $top_rated = $touchrate->get_toprated_posts( $args );
                $top_rated_ids = $touchrate->get_toprated_post_ids( $top_rated );

                if ( 'favorites' == $this->active_tab ) {
                    foreach ($top_rated_ids as $key => $id) {
                        if ( in_array($id, $args['post__in']) ) {
                            $args['post__in'][] = $id;
                        }
                    }
                } else {
                    $args['post__in'] = $top_rated_ids;
                }

                $args['order']    = 'DESC';
                break;

            case 'oldest':
                $args['orderby']  = 'ID';
                $args['order']    = 'ASC';
                break;
        }

        return $args;
    }

    function get_total_posts_views()
    {
        $total = 0;
        $query = $this->dashboard_query($this->post_type);

        if ( $query->have_posts() ) {
            while( $query->have_posts() ) {
                $query->the_post();
                $total = $total + (int)get_post_meta(get_the_ID(), 'airkit_views', true);
            }
        }

        return number_format($total, 0);
    }

}