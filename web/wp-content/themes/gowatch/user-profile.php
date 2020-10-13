<?php

/**
 * Template Name: Front-end - User Profile.
 */


/*
 * If user is not logged in and we're not viewing someone's profile, redirect to Register /  Login page.
 */

if( !is_user_logged_in() && !isset( $_GET['user'] ) ) {

	$user_registration_url = get_frontend_registration_url();

	wp_redirect( $user_registration_url );
	exit();

}

/*
 * Create Frontend Dashboard instance.
 */
 
$frontend_dashboard = new TSZF_Frontend_Dashboard();

get_header();

$airkit_breadcrumbs = get_post_meta( $post->ID, 'airkit_header_and_footer', true );

// Show breadcrumbs.
if ( isset( $airkit_breadcrumbs['breadcrumbs'] ) && $airkit_breadcrumbs['breadcrumbs'] == 0 && airkit_option_value( 'single', 'page_breadcrumbs' ) == 'y' && ! is_front_page() ) : ?>
	<div class="airkit_breadcrumbs breadcrumbs-single-post container">
		<?php echo airkit_breadcrumbs(); ?>
	</div>
<?php endif; ?>

<section id="main" class="ts-single-post airkit_frontend-dashboard airkit_frontend-forms">
	<div id="content" role="main">	
		<?php
			/*
			 * Render user frontend dashboard.
			 * Template location: includes/frontend-submission/templates/dashboard.
			 */
	    	echo airkit_var_sanitize( $frontend_dashboard->build(), 'true' );

		?>
	</div>
</section>

<?php
get_footer(); 

