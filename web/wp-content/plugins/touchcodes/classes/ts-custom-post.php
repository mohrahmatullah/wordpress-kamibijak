<?php
/**
*  Register custom posts.
*/
class Ts_Custom_Post
{

	private static $theme_options;

	function __construct()
	{



		$last_active_theme = get_option('airkit_last_active_theme');

		if ( empty( $last_active_theme ) ) {
			$last_active_theme = strtolower( wp_get_theme()->get('Name') );

			// Update the database to keep track of last active theme
			update_option('airkit_last_active_theme', $last_active_theme);
		}

		self::$theme_options = get_option( $last_active_theme . '_options' );

		// Do the basic events

		self::get_theme_options();
		self::register_all_post_type();

		register_activation_hook( __FILE__, array( $this, 'register_all_post_type' ) );

	}

	static function get_theme_options()
	{
		// Get theme options if available
		$general_theme_options = get_option( 'airkit_last_active_theme' ) . '_options';

		// Set the class $theme_options to get the general tab
		self::$theme_options = self::$theme_options['general'];

	}

	static function register_all_post_type()
	{
		$custom_posts = get_option( 'theme-custom-posts' );

		if ( isset( $custom_posts ) && is_array( $custom_posts ) && ! empty( $custom_posts ) ) {

		    foreach ( $custom_posts as $custom_post ) {

		    	// Check if method exists and then fire the hook
		    	if( method_exists('Ts_Custom_Post', 'register_post_type_' . $custom_post) )  {

			        add_action( 'init', array( __CLASS__,  'register_post_type_' . $custom_post ) );
		    	}

		    	if( method_exists('Ts_Custom_Post', $custom_post . '_taxonomy') )  {
		    		
		            add_action( 'init', array( __CLASS__, $custom_post . '_taxonomy' ), 0 );

		    	}
		    	if( method_exists('Ts_Custom_Post', $custom_post . '_messages') )  {
			        add_filter( 'post_messages', array( __CLASS__, $custom_post . '_messages' ) );
			    }
		    }
		}
	}

    static function register_post_type_recipe()
    {

        $slug = isset( self::$theme_options['slug_recipe'] ) ? self::$theme_options['slug_recipe'] : 'recipe';

        $labels = array(
            'name'               => __( 'Recipe', 'touchcodes' ),
            'singular_name'      => __( 'Recipe', 'touchcodes' ),
            'add_new'            => __( 'Add New', 'touchcodes' ),
            'add_new_item'       => __( 'Add New Recipe', 'touchcodes' ),
            'edit_item'          => __( 'Edit Recipe', 'touchcodes' ),
            'new_item'           => __( 'New Recipe', 'touchcodes' ),
            'all_items'          => __( 'All Recipes', 'touchcodes' ),
            'view_item'          => __( 'View Recipe', 'touchcodes' ),
            'search_items'       => __( 'Search Recipes', 'touchcodes' ),
            'not_found'          => __( 'No recipes found', 'touchcodes' ),
            'not_found_in_trash' => __( 'No recipes found in Trash', 'touchcodes' ),
            'parent_item_colon'  => '',
            'menu_name'          => __( 'Recipes', 'touchcodes' ),
        );

        $args = array(
            'labels'     => $labels,
            'public'     => true,
            'supports'   => array( 'title', 'thumbnail', 'author', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
            'menu_icon'  => plugins_url( 'touchcodes/images/custom.recipe.png' ),
            'taxonomies' => array( 'post_tag', 'recipe_categories' ),
            'rewrite'    => array( 'slug' => $slug )
        );

        register_post_type( 'ts-recipe', $args );
    }

    static function recipe_taxonomy()
    {

        $slug = isset( self::$theme_options['slug_recipe_taxonomy'] ) ? self::$theme_options['slug_recipe_taxonomy'] : 'recipe-category';

        $labels = array(
            'name'              => __( 'Recipe categories','touchcodes' ),
            'singular_name'     => __( 'Recipes','touchcodes' ),
            'search_items'      => __( 'Search Recipes','touchcodes' ),
            'popular_items'     => __( 'Popular Recipes','touchcodes' ),
            'all_items'         => __( 'All Recipes','touchcodes' ),
            'parent_item'       => __( 'Parent Recipes','touchcodes' ),
            'parent_item_colon' => __( 'Parent Recipes:','touchcodes' ),
            'edit_item'         => __( 'Edit Recipe','touchcodes' ),
            'update_item'       => __( 'Update Recipe','touchcodes' ),
            'add_new_item'      => __( 'Add New Recipes','touchcodes' ),
            'new_item_name'     => __( 'New Recipe Name','touchcodes' ),
        );

        register_taxonomy( 'recipe_categories', array( 'recipe_categories' ), array(
            'hierarchical' => true,
            'labels'       => $labels,
            'show_ui'      => true,
            'query_var'    => true,
            'rewrite'      => array( 'slug' => $slug )
        ));
    }

    static function recipe_messages( $messages )
    {
          global $post, $post_ID;

          $messages['ts_recipe'] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => sprintf( __( 'Recipe updated. <a href="%s">View recipe</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
            2 => __( 'Custom field updated.', 'touchcodes' ),
            3 => __( 'Custom field deleted.', 'touchcodes' ),
            4 => __( 'Recipe updated.', 'touchcodes' ),
            /* translators: %s: date and time of the revision */
            5 => isset( $_GET['revision'] ) ? sprintf( __( 'Recipe restored to revision from %s', 'touchcodes' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6 => sprintf( __( 'Recipe published. <a href="%s">View recipe</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
            7 => __( 'Recipe saved.', 'touchcodes' ),
            8 => sprintf( __( 'Recipe submitted. <a target="_blank" href="%s">Preview recipe</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url( get_permalink( $post_ID ) ) ) ) ),
            9 => sprintf( __( 'Recipe scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview recipe</a>', 'Recipe' ),
          // translators: Publish box date format, see http://php.net/date
          date_i18n( __( 'M j, Y @ G:i','touchcodes' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
            10 => sprintf( __( 'Recipe draft updated. <a target="_blank" href="%s">Preview recipe</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url( get_permalink( $post_ID ) ) ) ) ),
          );

          return $messages;
    }

	static function register_post_type_gallery()
	{

	    $slug = isset( self::$theme_options['slug_gallery'] ) ? self::$theme_options['slug_gallery'] : 'gallery';

	    $labels = array(
	        'name'               => __( 'Gallery', 'touchcodes' ),
	        'singular_name'      => __( 'Gallery', 'touchcodes' ),
	        'add_new'            => __( 'Add New', 'touchcodes' ),
	        'add_new_item'       => __( 'Add New Gallery', 'touchcodes' ),
	        'edit_item'          => __( 'Edit Gallery', 'touchcodes' ),
	        'new_item'           => __( 'New Gallery', 'touchcodes' ),
	        'all_items'          => __( 'All Galleries', 'touchcodes' ),
	        'view_item'          => __( 'View Gallery', 'touchcodes' ),
	        'search_items'       => __( 'Search Galleries', 'touchcodes' ),
	        'not_found'          => __( 'No galleries found', 'touchcodes' ),
	        'not_found_in_trash' => __( 'No galleries found in Trash', 'touchcodes' ),
	        'parent_item_colon'  => '',
	        'menu_name'          => __( 'Galleries', 'touchcodes' ),
	    );

	    $args = array(
	        'labels'     => $labels,
	        'public'     => true,
	        'supports'   => array( 'title', 'thumbnail', 'author', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
	        'menu_icon'  => plugins_url( 'touchcodes/images/custom.gallery.png' ),
	        'taxonomies' => array( 'post_tag', 'gallery_categories' ),
	        'rewrite'    => array( 'slug' => $slug )
	    );

	    register_post_type( 'ts-gallery', $args );
	}

	static function gallery_taxonomy()
	{

	    $slug = isset( self::$theme_options['slug_gallery_taxonomy'] ) ? self::$theme_options['slug_gallery_taxonomy'] : 'gallery-category';

	    $labels = array(
	        'name'              => __( 'Gallery categories','touchcodes' ),
	        'singular_name'     => __( 'Galleries','touchcodes' ),
	        'search_items'      => __( 'Search Galleries','touchcodes' ),
	        'popular_items'     => __( 'Popular Galleries','touchcodes' ),
	        'all_items'         => __( 'All Galleries','touchcodes' ),
	        'parent_item'       => __( 'Parent Galleries','touchcodes' ),
	        'parent_item_colon' => __( 'Parent Galleries:','touchcodes' ),
	        'edit_item'         => __( 'Edit Gallery','touchcodes' ),
	        'update_item'       => __( 'Update Gallery','touchcodes' ),
	        'add_new_item'      => __( 'Add New Galleries','touchcodes' ),
	        'new_item_name'     => __( 'New Gallery Name','touchcodes' ),
	    );

	    register_taxonomy( 'gallery_categories', array( 'gallery_categories' ), array(
	        'hierarchical' => true,
	        'labels'       => $labels,
	        'show_ui'      => true,
	        'query_var'    => true,
	        'rewrite'      => array( 'slug' => $slug )
	    ));
	}

	static function gallery_messages( $messages )
	{
	  	global $post, $post_ID;

	  	$messages['ts_gallery'] = array(
	    	0 => '', // Unused. Messages start at index 1.
	    	1 => sprintf( __( 'Gallery updated. <a href="%s">View gallery</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
	    	2 => __( 'Custom field updated.', 'touchcodes' ),
	    	3 => __( 'Custom field deleted.', 'touchcodes' ),
	    	4 => __( 'Gallery updated.', 'touchcodes' ),
	    	/* translators: %s: date and time of the revision */
	    	5 => isset( $_GET['revision'] ) ? sprintf( __( 'Gallery restored to revision from %s', 'touchcodes' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	    	6 => sprintf( __( 'Gallery published. <a href="%s">View gallery</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
	    	7 => __( 'Gallery saved.', 'touchcodes' ),
	    	8 => sprintf( __( 'Gallery submitted. <a target="_blank" href="%s">Preview gallery</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url( get_permalink( $post_ID ) ) ) ) ),
	    	9 => sprintf( __( 'Gallery scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview gallery</a>', 'Gallery' ),
	      // translators: Publish box date format, see http://php.net/date
	      date_i18n( __( 'M j, Y @ G:i','touchcodes' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
	    	10 => sprintf( __( 'Gallery draft updated. <a target="_blank" href="%s">Preview gallery</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url( get_permalink( $post_ID ) ) ) ) ),
	  	);

	  	return $messages;
	}

	static function register_post_type_event()
	{

	    $slug = isset( self::$theme_options['slug_event'] ) ? self::$theme_options['slug_event'] : 'event';

	    $labels = array(
	        'name'               => __( 'Events', 'touchcodes' ),
	        'singular_name'      => __( 'Event', 'touchcodes' ),
	        'add_new'            => __( 'Add New', 'touchcodes' ),
	        'add_new_item'       => __( 'Add New Event', 'touchcodes' ),
	        'edit_item'          => __( 'Edit Event', 'touchcodes' ),
	        'new_item'           => __( 'New Event', 'touchcodes' ),
	        'all_items'          => __( 'All Events', 'touchcodes' ),
	        'view_item'          => __( 'View Event', 'touchcodes' ),
	        'search_items'       => __( 'Search Events', 'touchcodes' ),
	        'not_found'          => __( 'No events found', 'touchcodes' ),
	        'not_found_in_trash' => __( 'No events found in Trash', 'touchcodes' ),
	        'parent_item_colon'  => '',
	        'menu_name'          => __( 'Events', 'touchcodes' ),
	    );

	    $args = array(
	        'labels'     => $labels,
	        'public'     => true,
	        'supports'   => array( 'title', 'thumbnail', 'author', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
	        'menu_icon'  => plugins_url( 'touchcodes/images/custom.event.png' ),
	        'taxonomies' => array( 'post_tag', 'event_categories' ),
	        'rewrite'    => array( 'slug' => $slug )
	    );

	    register_post_type( 'event', $args );
	}

	static function event_taxonomy()
	{

	    $slug = isset( self::$theme_options['slug_event_taxonomy'] ) ? self::$theme_options['slug_event_taxonomy'] : 'event-category';

	    $labels = array(
	        'name'              => __( 'Event categories', 'touchcodes' ),
	        'singular_name'     => __( 'Event category', 'touchcodes' ),
	        'search_items'      => __( 'Search Events', 'touchcodes' ),
	        'popular_items'     => __( 'Popular Events', 'touchcodes' ),
	        'all_items'         => __( 'All Events', 'touchcodes' ),
	        'parent_item'       => __( 'Parent Events', 'touchcodes' ),
	        'parent_item_colon' => __( 'Parent Events:', 'touchcodes' ),
	        'edit_item'         => __( 'Edit Event', 'touchcodes' ),
	        'update_item'       => __( 'Update Event', 'touchcodes' ),
	        'add_new_item'      => __( 'Add New Events', 'touchcodes' ),
	        'new_item_name'     => __( 'New Event Name', 'touchcodes' ),
	    );

	     register_taxonomy( 'event_categories', array( 'event_categories' ), array(
	        'hierarchical' => true,
	        'labels'       => $labels,
	        'show_ui'      => true,
	        'query_var'    => true,
	        'rewrite'      => array( 'slug' => $slug )
	    ));
	}

	static function event_messages( $messages )
	{
	  global $post, $post_ID;

	  	$messages['ts_event'] = array(
		    0 => '', // Unused. Messages start at index 1.
		    1 => sprintf( __( 'Event updated. <a href="%s">View event</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
		    2 => __( 'Custom field updated.', 'touchcodes' ),
		    3 => __( 'Custom field deleted.', 'touchcodes' ),
		    4 => __( 'Event updated.', 'touchcodes' ),
		    /* translators: %s: date and time of the revision */
		    5 => isset( $_GET['revision'] ) ? sprintf( __( 'Event restored to revision from %s', 'touchcodes' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		    6 => sprintf( __( 'Event published. <a href="%s">View event</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
		    7 => __( 'Event saved.', 'touchcodes' ),
		    8 => sprintf( __( 'Event submitted. <a target="_blank" href="%s">Preview event</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url( get_permalink( $post_ID ) ) ) ) ),
		    9 => sprintf( __( 'Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>', 'event' ),
		      // translators: Publish box date format, see http://php.net/date
		      date_i18n( __( 'M j, Y @ G:i','touchcodes' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		    10 => sprintf( __( 'Event draft updated. <a target="_blank" href="%s">Preview event</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url(get_permalink( $post_ID ) ) ) ) ),
	  	);

	  	return $messages;
	}


	static function video_taxonomy()
	{

	    $slug = isset( self::$theme_options['slug_video_taxonomy'] ) ? self::$theme_options['slug_video_taxonomy'] : 'videos_categories';

		$labels = array(
		    'name'              => __( 'Video categories','touchcodes' ),
		    'singular_name'     => __( 'Video category','touchcodes' ),
		    'search_items'      => __( 'Search Videos','touchcodes' ),
		    'popular_items'     => __( 'Popular Videos','touchcodes' ),
		    'all_items'         => __( 'All Videos','touchcodes' ),
		    'parent_item'       => __( 'Parent Videos','touchcodes' ),
		    'parent_item_colon' => __( 'Parent Videos:','touchcodes' ),
		    'edit_item'         => __( 'Edit Videos','touchcodes' ),
		    'update_item'       => __( 'Update Videos','touchcodes' ),
		    'add_new_item'      => __( 'Add New Videos','touchcodes' ),
		    'new_item_name'     => __( 'New Videos Name','touchcodes' ),
		);

		register_taxonomy( 'videos_categories', array( 'videos_categories' ), array(
		    'hierarchical' => true,
		    'labels'       => $labels,
		    'show_ui'      => true,
		    'query_var'    => true,
		    'rewrite'      => array( 'slug' => $slug ),
		));
	}

	static function register_post_type_video()
	{

	    $slug = isset( self::$theme_options['slug_video'] ) ? self::$theme_options['slug_video'] : 'video';

		$labels = array(
			'name'               => __( 'Videos', 'touchcodes' ),
			'singular_name'      => __( 'Video', 'touchcodes' ),
			'add_new'            => __( 'New Video', 'touchcodes' ),
			'add_new_item'       => __( 'Add New Video', 'touchcodes' ),
			'edit_item'          => __( 'Edit Video', 'touchcodes' ),
			'new_item'           => __( 'New Video', 'touchcodes' ),
			'all_items'          => __( 'All Videos', 'touchcodes' ),
			'view_item'          => __( 'View Video', 'touchcodes' ),
			'search_items'       => __( 'Search Videos', 'touchcodes' ),
			'not_found'          => __( 'No video found', 'touchcodes' ),
			'not_found_in_trash' => __( 'No video found in Trash', 'touchcodes' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Videos', 'touchcodes' )
		);

		$args = array(
			'labels'       => $labels,
			'map_meta_cap' => true,
			'public'       => true,
			'supports'     => array( 'title', 'thumbnail', 'author', 'editor', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
			'menu_icon'    => plugins_url( 'touchcodes/images/custom.video.png' ),
			'taxonomies'   => array( 'videos_categories', 'post_tag' ),
	        'rewrite'      => array( 'slug' => $slug ),
		);

		register_post_type( 'video', $args );
	}

	static function video_messages( $messages )
	{
	  global $post, $post_ID;

	  	$messages['video'] = array(
		    0 => '', // Unused. Messages start at index 1.
		    1 => sprintf( __( 'Information about video updated. <a href="%s">View video</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
		    2 => __( 'Custom field updated.', 'touchcodes' ),
		    3 => __( 'Custom field deleted.', 'touchcodes' ),
		    4 => __( 'Video updated.', 'touchcodes' ),
		    /* translators: %s: date and time of the revision */
		    5 => isset( $_GET['revision'] ) ? sprintf( __( 'Videos restored to revision from %s', 'touchcodes' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		    6 => sprintf( __( 'Video published. <a href="%s">View video</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
		    7 => __( 'Video saved.', 'touchcodes' ),
		    8 => sprintf( __( 'Video submitted. <a target="_blank" href="%s">Preview Video</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url( get_permalink( $post_ID ) ) ) ) ),
		    9 => sprintf( __( 'Video scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview video</a>', 'touchcodes' ),
		      // translators: Publish box date format, see http://php.net/date
		      date_i18n( __( 'M j, Y @ G:i', 'touchcodes' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		    10 => sprintf( __( 'Video draft updated. <a target="_blank" href="%s">Preview video</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url(get_permalink( $post_ID ) ) ) ) ),
	  	);

	  	return $messages;
	}

	static function register_post_type_teams()
	{

	    $slug = isset( self::$theme_options['slug_teams'] ) ? self::$theme_options['slug_teams'] : 'ts-teams';

		$labels = array(
			'name'               => __( 'Team members', 'touchcodes' ),
			'singular_name'      => __( 'Team member', 'touchcodes' ),
			'add_new'            => __( 'New Member', 'touchcodes' ),
			'add_new_item'       => __( 'Add New Member', 'touchcodes' ),
			'edit_item'          => __( 'Edit Member', 'touchcodes' ),
			'new_item'           => __( 'New Member', 'touchcodes' ),
			'all_items'          => __( 'All Members', 'touchcodes' ),
			'view_item'          => __( 'View Member', 'touchcodes' ),
			'search_items'       => __( 'Search Members', 'touchcodes' ),
			'not_found'          =>  __( 'No members found', 'touchcodes' ),
			'not_found_in_trash' => __( 'No members found in Trash', 'touchcodes' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Teams', 'touchcodes' )
		);

		$args = array(
			'labels'    => $labels,
			'public'    => true,
			'supports'  => array( 'title', 'thumbnail', 'editor' ),
			'menu_icon' => plugins_url( 'touchcodes/images/custom.team.png' ),
	        'rewrite'   => array( 'slug' => $slug )
		);

		register_post_type( 'ts_teams', $args );
	}

	static function teams_messages( $messages )
	{
	  global $post, $post_ID;

	  	$messages['ts_teams'] = array(
		    0 => '', // Unused. Messages start at index 1.
		    1 => sprintf( __( 'Information about team member updated. <a href="%s">View member</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
		    2 => __( 'Custom field updated.', 'touchcodes' ),
		    3 => __( 'Custom field deleted.', 'touchcodes' ),
		    4 => __( 'Member updated.', 'touchcodes' ),
		    /* translators: %s: date and time of the revision */
		    5 => isset($_GET['revision']) ? sprintf( __( 'Member restored to revision from %s', 'touchcodes' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		    6 => sprintf( __( 'Member published. <a href="%s">View member</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
		    7 => __( 'Member saved.', 'touchcodes' ),
		    8 => sprintf( __( 'Member submitted. <a target="_blank" href="%s">Preview member</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url( get_permalink( $post_ID ) ) ) ) ),
		    9 => sprintf( __( 'Member scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview member</a>', 'touchcodes' ),
		      // translators: Publish box date format, see http://php.net/date
		      date_i18n( __( 'M j, Y @ G:i','touchcodes' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		    10 => sprintf( __( 'Member draft updated. <a target="_blank" href="%s">Preview member</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url( get_permalink( $post_ID ) ) ) ) ),
	  	);

	  	return $messages;
	}

	static function teams_taxonomy()
	{

	    $slug = isset( self::$theme_options['slug_teams_taxonomy'] ) ? self::$theme_options['slug_teams_taxonomy'] : 'teams-category';

	    register_taxonomy(
	        'teams',
	        'ts_teams',
	        array(
	            'label'        => __( 'Team categories','touchcodes' ),
	            'rewrite'      => array( 'slug' => $slug ),
	            'hierarchical' => true
	        )
	    );
	}

	static function register_post_type_portfolio()
	{

	    $slug = isset( self::$theme_options['slug_portfolio'] ) ? self::$theme_options['slug_portfolio'] : 'portfolio';

		$labels = array(
			'name'               => __( 'Portfolio', 'touchcodes' ),
			'singular_name'      => __( 'Portfolio', 'touchcodes' ),
			'add_new'            => __( 'Add New Item', 'touchcodes' ),
			'add_new_item'       => __( 'Add New Item', 'touchcodes' ),
			'edit_item'          => __( 'Edit Item', 'touchcodes' ),
			'new_item'           => __( 'New Item', 'touchcodes' ),
			'all_items'          => __( 'All Items', 'touchcodes' ),
			'view_item'          => __( 'View Item', 'touchcodes' ),
			'search_items'       => __( 'Search items', 'touchcodes' ),
			'not_found'          => __( 'No items found', 'touchcodes' ),
			'not_found_in_trash' => __( 'No items found in Trash', 'touchcodes' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Portfolio', 'touchcodes' )
		);

		$args = array(
			'labels'        => $labels,
			'public'        => true,
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
			'menu_icon'     => plugins_url( 'touchcodes/images/custom.portfolio.png' ),
			'menu_position' => 4,
	        'rewrite'       => array( 'slug' => $slug )
		);

		register_post_type( 'portfolio', $args );
	}

	static function portfolio_messages( $messages )
	{
	  global $post, $post_ID;

	  	$messages['portfolio'] = array(
		    0 => '', // Unused. Messages start at index 1.
		    1 => sprintf( __( 'Portfolio Item updated. <a href="%s">View Portfolio Item</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
		    2 => __( 'Custom field updated.', 'touchcodes' ),
		    3 => __( 'Custom field deleted.', 'touchcodes' ),
		    4 => __( 'Portfolio Item updated.', 'touchcodes' ),
		    /* translators: %s: date and time of the revision */
		    5 => isset( $_GET['revision'] ) ? sprintf( __( 'Slider restored to revision from %s', 'touchcodes' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		    6 => sprintf( __( 'Portfolio Item published. <a href="%s">View Portfolio Item</a>', 'touchcodes' ), esc_url( get_permalink( $post_ID ) ) ),
		    7 => __( 'Portfolio Item saved.', 'touchcodes' ),
		    8 => sprintf( __( 'Portfolio Item submitted. <a target="_blank" href="%s">Preview Portfolio Item</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url( get_permalink( $post_ID ) ) ) ) ),
		    9 => sprintf( __( 'Portfolio Item scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Portfolio Item</a>', 'slider' ),
		      // translators: Publish box date format, see http://php.net/date
		      date_i18n( __( 'M j, Y @ G:i','touchcodes' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		    10 => sprintf( __( 'Portfolio Item draft updated. <a target="_blank" href="%s">Preview Portfolio Item</a>', 'touchcodes' ), esc_url( add_query_arg( 'preview', 'true', esc_url( get_permalink( $post_ID ) ) ) ) ),
	  	);

	  	return $messages;
	}

	static function portfolio_taxonomy()
	{

	    $slug = isset( self::$theme_options['slug_portfolio_taxonomy'] ) ? self::$theme_options['slug_portfolio_taxonomy'] : 'portfolio-categories';

	    register_taxonomy(
	        'portfolio-categories',
	        'portfolio',
	        array(
	            'label'        => __( 'Portfolio categories','touchcodes' ),
	            'rewrite'      => array( 'slug' => $slug ),
	            'hierarchical' => true
	        )
	    );
	}

	/**
	* Register theme-custom custom post types.
	*/
	static function add_custom_post_type( $slug, $atts ) {

		register_post_type( $slug, $atts );

	}

}