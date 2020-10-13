<?php
/*
 | This class ensures BuddyPress Compatibility
 */

 class Airkit_BP_Extend 
 {

 	// Holds user's favorite posts.
 	public $favorites_query;
 	// Holds user's posts.
 	public $posts_query;
 	// Holds options for generating post views
 	public $view_options;
 	// frontend dashboard instance.
 	protected $fd;

 	public function __construct()
 	{
 		// No cheating, if BuddyPress is not installed, this class should not instantiate.
 		if( !self::is_bp_active() ) return new WP_Error( 'Please make sure to install and activate BuddyPress' );

 		// Extend BuddyPress Member profile tabs.
		add_action( 'bp_setup_nav', array( &$this, 'action_add_profile_tabs' ), 100 );

		// Filter author_url to redirect to BuddyPress profile.
		add_filter( 'author_link', array( &$this, 'filter_author_link' ), 10, 3 );

		// This array contains options for airkit_Compilator::view_article method.
		$this->view_options = [
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
		]; 

 	}

 	// Interface for setting frontend_dashboard fields to achieve BuddyPress Compatibility.
 	public function override_frontend_dashboard()
 	{	
 		global $bp;

		// Get favorites_query and posts_query from TSZF_Frontend_Dashboard class.
		$this->fd = new TSZF_Frontend_Dashboard();
		// Assign post types
		$this->fd->post_type = array( 'post', 'video', 'gallery' );		
		// Assign userdata from current user
		if( $bp->displayed_user->userdata ) {
			$this->fd->userdata = $bp->displayed_user->userdata;
		} else {
			$this->fd->userdata = wp_get_current_user();
		}

		$this->favorites_query = $this->fd->favorites_query();
		$this->posts_query     = $this->fd->dashboard_query( $this->fd->post_type );
 	}

 	/*
 	 | Create nav items 'Posts' and 'Favorites'
 	 */
 	public function action_add_profile_tabs()
 	{
 		global $bp;

 		if( class_exists('TSZF_Frontend_Dashboard') ) {
 			$this->override_frontend_dashboard();
 		}

 		// Create 'Posts' tab.
	    bp_core_new_nav_item(
	        array(
	            'name'                => esc_html__('Posts', 'gowatch'),
	            'slug'                => 'posts',
	            'screen_function'     => array( &$this, 'profile_posts' ),
	            'default_subnav_slug' => 'Posts',
	            'position'            => 25
	        )
	    );

	    // Create 'Favorites' tab.
	    bp_core_new_nav_item(
	        array(
	            'name'                => esc_html__('Favorite posts', 'gowatch'),
	            'slug'                => 'favorites',
	            'screen_function'     => array( &$this, 'profile_favorites' ),
	            'default_subnav_slug' => 'Favorite Posts',
	            'position'            => 26
	        )
	    );

 	}

 	/*
	 | Filter author link to redirect to BuddyPress member page.
 	 */
 	 public function filter_author_link( $link, $author_id, $author_nicename )
 	 {
 	 	
 	 	if( $author_id != -1 ) {

 	 		$author = get_the_author_meta( $author_id );

 	 		$link = bp_core_get_userlink( $author_id, false, true );			

 	 	}

 	 	return $link;
 	 }

 	/*
	 | Register screen for 'Posts' tab.
 	 */

 	public function profile_posts()
 	{
	    add_action( 'bp_template_content', array( &$this, 'profile_posts_screen' ) );
	    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
 	}
 	/*
	 | Register screen for 'Favorites' tab.
 	 */

 	public function profile_favorites()
 	{
	    add_action( 'bp_template_content', array( &$this, 'profile_favorites_screen' ) );
	    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
 	} 	

 	/*
	 | Render 'Posts' tab screen
 	 */
 	public function profile_posts_screen()
 	{
 		global $bp;

        /*
         * Show posts by this author.
         */
        if( isset( $this->posts_query->posts ) && !empty( $this->posts_query->posts ) ) {
            echo '<div class="row">';
            echo airkit_Compilator::view_articles( $this->view_options, $this->posts_query );
            echo '</div>';
        } else {
            echo '<p>'. esc_html__( 'Nothing Found', 'gowatch' ) .'</p>';
        }
 	}

 	/*
	 | Render 'Favorites' tab screen
 	 */
 	public function profile_favorites_screen()
 	{
        /*
         * Show favorite posts of this user.
         */
        if( isset( $this->favorites_query->posts ) && !empty( $this->favorites_query->posts ) ) {
            echo '<div class="row">';
            echo airkit_Compilator::view_articles( $this->view_options, $this->favorites_query );
            echo '</div>';
        } else {
            echo '<p>'. esc_html__( 'Nothing Found', 'gowatch' ) .'</p>';
        }
 	}

 	/*
 	 | Return array of overwrited links for user element ['dashboard_url', 'favorites_url', 'settings_url']
 	 */
 	 public function overwrite_user_permalinks()
 	 {
 	 	global $bp;
 	 	
 	 	return [
			$bp->members->nav->profile['link'],
			$bp->members->nav->posts['link'],
			$bp->members->nav->favorites['link'],
			$bp->members->nav->settings['link'], 	 		
 	 	];
 	 }


 	// Shorthand for function_exists('bp_is_active').
 	public function is_bp_active()
 	{
 		return function_exists('bp_is_active');
 	}

 }