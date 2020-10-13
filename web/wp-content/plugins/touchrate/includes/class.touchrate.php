<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://touchsize.com
 * @since      1.0.0
 *
 * @package    touchrate
 * @subpackage touchrate/includes
 */
class TouchRate {

	public static $tablename;

	function __construct()
	{
		global $wpdb;

		self::$tablename = $wpdb->prefix . 'touchrate';

		// include scripts for front end
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts') );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts') );

		// Do ajax request
		add_action( 'wp_ajax_touchrate_set_rating', array( &$this, 'set_rating'), 10, 2 );
		add_action( 'wp_ajax_nopriv_touchrate_set_rating', array( &$this, 'set_rating'), 10, 2 );

	}

	public static function create_table_touchrate()
	{
		global $wpdb;

		$tablename = self::$tablename;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $tablename (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			post_id smallint(5) NOT NULL,
			user_id smallint(50) NOT NULL,
			rating int(50) NOT NULL,
			rate_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			update_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			UNIQUE KEY id (id),
			UNIQUE KEY post_user (post_id,user_id),
			KEY post_id (post_id),
			KEY user_id (user_id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	public function load_scripts()
	{

		$localize_data = array(
			'post_ID'    	   => get_the_ID(),
			'alert_message'    => esc_html__('Please login to rate!', 'touchrate'),
			'ajaxurl'    	   => admin_url('admin-ajax.php'),
			'ajax_nonce' 	   => wp_create_nonce( "touchrate-nonce" )
		);

		
		wp_enqueue_style('touchrate-styles', plugins_url('assets/css/styles.css', TS_TR__FILE__));

		wp_enqueue_script('touchrate-scripts', plugins_url('assets/js/touchrate.js', TS_TR__FILE__), array('jquery'), array(), true);

		// Localize variables
		wp_localize_script( 'touchrate-scripts', 'touchrate', $localize_data );

	}

	public function load_admin_scripts()
	{
		if ( is_admin() ) {
			wp_enqueue_style('touchrate-admin-styles', plugins_url('assets/css/admin-styles.css', TS_TR__FILE__));
		}
	}

	public function set_rating()
	{
		check_ajax_referer( 'touchrate-nonce', 'security' );

		global $wpdb;

		$post_ID     = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
		$user_ID 	 = (int)get_current_user_id();
		$rating      = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
		$tablename 	 = self::$tablename;

		if ( $rating == 0 || $user_ID == 0 ) {
			$response = array(
			    'status' => '204',
			    'message' => 'No response',
			);

			// normally, the script expects a json respone
			header( 'Content-Type: application/json; charset=utf-8' );
			echo json_encode( $response );

			exit;
		}

		$rate_date   = current_time( 'mysql' );
		$update_date = current_time( 'mysql' );

		$sql = $wpdb->prepare(
			"INSERT INTO $tablename
			(post_id, user_id, rating, rate_date, update_date) VALUES (%d, %d, %s, %s, %s)
			ON DUPLICATE KEY UPDATE rating = %3\$s, update_date = '%5\$s';",
			$post_ID,
			$user_ID,
			$rating,
			$rate_date,
			$update_date
		);

		$result = $wpdb->query( $sql );

		$response = array(
			'status' => '200',
			'message' => 'OK',
			'rating_avg' => $this->get_rating_average($post_ID)
		);

		// normally, the script expects a json respone
		header( 'Content-Type: application/json; charset=utf-8' );
		echo json_encode( $response );

		exit;

	}

	public function get_rate_form( $post_ID )
	{
		$output = '';

		// Get the average vote number and check if user has voted for this post
		$average = $this->get_rating_average( $post_ID );
		$user_vote = $this->check_user_voted( $post_ID );

		// Add the .touchrate-voted class to the container
		$vote_class = !empty( $user_vote ) ? ' touchrate-voted ' : '';

		$output .= "
			<div class=\"touchrate-container{$vote_class}\">
				<ul class=\"touchrate-stars\" data-rating=\"{$average}\" data-id=\"{$post_ID}\"></ul>
				<span class=\"touchrate-average\"><i>{$average}</i>/5</span>
			</div>";
		
		return $output;
	}

	public function get_rating_average( $post_ID )
	{
		global $wpdb;

		$tablename = self::$tablename;
		$sql_select = $wpdb->prepare( "SELECT AVG(rating) as rating FROM {$tablename} WHERE post_id = %s;", $post_ID );

		$sql_results = $wpdb->get_row( $sql_select, ARRAY_N );

		return number_format( $sql_results[0], 1 );

	}

	public function get_rating_star( $post_ID )
	{

		// Check if user voted, use the full icon or outline icon if not
		$user_vote = $this->check_user_voted( $post_ID );

		if ( !empty( $user_vote ) ) {
			$rate_icon = ' icon-star-full ';
		} else {
			$rate_icon = ' icon-star ';
		}

		// Add the .touchrate-voted class to the container
		$vote_class = !empty( $user_vote ) ? ' touchrate-voted ' : '';

		$average = $this->get_rating_average( $post_ID );
		$content = $average > 0 ? '<i>' . $average . '</i>/5' : 'N/A';

		return '<span class="touchrate-average' . $vote_class . $rate_icon . '">' . $content . '</span>';
	}

	public function get_toprated_posts( $args = array() )
	{

		// Get top rated posts
		global $wpdb;

		$tablename = self::$tablename;

		// Defaults
		$_where = array(); $where = '';
		$limit = isset($args['posts_per_page']) ? $args['posts_per_page'] : get_option('posts_per_page');

		if ( $limit == '-1' ) {
			$limit = 9999;
		}

		$sql_select = $wpdb->prepare( "
				SELECT post_id AS ID, AVG(rating) AS rating
				FROM {$tablename}
				GROUP BY post_id
				ORDER BY rating DESC
				LIMIT %d
			",
			$limit
		);

		$sql_results = $wpdb->get_results( $sql_select );

		return $sql_results;

	}

	public function get_toprated_post_ids( $sql_results )
	{
		$post_ids = array();

		if ( is_array($sql_results) ) {
			foreach ($sql_results as $key => $post) {
				array_push($post_ids, $post->ID);
			}
		}

		return $post_ids;
	}

	public function check_user_voted( $post_ID )
	{

		// Check if current user voted function, returns the results (table entry with the vote)
		global $wpdb;

		$tablename = self::$tablename;

		$user_ID = get_current_user_id();

		$sql_select = $wpdb->prepare( "SELECT * FROM {$tablename} WHERE post_id = %s AND user_id = %d", $post_ID, $user_ID );

		$sql_results = $wpdb->get_results( $sql_select );

		return $sql_results;

	}


}

/**
 * Function to show the rating form or number
 * @param type $post_ID 
 * @param type|string $type 
 * @return type
 */
function touch_rate( $post_ID, $type = 'form' )
{
	$touchrate = new TouchRate();

	if ( $type == 'number' ) {

		$result = $touchrate->get_rating_star( $post_ID );

	} else {

		$result = $touchrate->get_rate_form( $post_ID );

	}

	// Return the result on need
	return $result;

}

?>