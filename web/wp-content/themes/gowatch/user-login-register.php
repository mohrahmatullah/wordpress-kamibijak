<?php

/**
 * Template Name: Front-end - Login.
 */

$airkit_sidebar = airkit_Compilator::build_sidebar( 'page', get_the_ID() ); 


/*
 * If user is already logged in, redirect to User Frontend dashboard page.
 */

if( is_user_logged_in() ) {

	$user_dashboard_url = get_frontend_dashboard_url();

	wp_redirect( $user_dashboard_url );
	exit();

}


// Action submit / edit.

$action = 'submit';

if( ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) || isset( $_GET['pid'] ) ) {

	$action = 'edit';

	$edit_id = $_GET['pid'];

}

// Get the ID of active frontend submission form.
$active_registration_form_id  = airkit_option_value( 'general', 'frontend_registration_form' );

// Create render_form instance.
$frontend_register =  new TSZF_Frontend_Form_Profile();

get_header();

$active_tab = isset( $_GET['action'] ) ? airkit_var_sanitize( $_GET['action'], 'the_kses' ) : 'login';

$airkit_breadcrumbs = get_post_meta( $post->ID, 'airkit_header_and_footer', true );

if ( isset( $airkit_breadcrumbs['breadcrumbs'] ) && $airkit_breadcrumbs['breadcrumbs'] == 0 && airkit_option_value( 'single', 'page_breadcrumbs' ) == 'y' && ! is_front_page() ) : ?>
	<div class="airkit_breadcrumbs breadcrumbs-single-post container">
		<?php echo airkit_breadcrumbs(); ?>
	</div>
<?php endif; ?>

<section id="main" class="ts-register-page">
	<div class="container">
		<div class="row">
			<?php echo airkit_var_sanitize( $airkit_sidebar['left'], 'true' ); ?>
			<div class="<?php echo esc_attr( $airkit_sidebar['content_class'] ); ?>">
				<div id="content" role="main">	
					<div class="airkit_frontend-forms airkit_register-page ">
						<div class="row">
							<div class="col-lg-6">
								<div class="placeholder <?php if( $active_tab == 'signup' ) echo 'active'; ?>">
									<h3>
										<?php echo esc_html__( 'Don\'t Have an account ?', 'gowatch' ); ?>
									</h3>

									<div class="description"><?php echo esc_html__( 'It is easy to create an account here. Just enter your details and hit the enter button.', 'gowatch' ); ?></div>

									<a class="toggle-form toggle-register" href="#">
										<?php echo esc_html__( 'Sign up', 'gowatch' ); ?>
									</a>
								</div>
								<div class="form-container register-form <?php if( $active_tab == 'signup' ) echo 'active'; ?>">
									<?php
										// Add content before form (inside).
										$frontend_register->before_form( '<h4 class="form-title">' . esc_html__( 'Sign up', 'gowatch' ) . '</h4>', true );
										echo airkit_var_sanitize( $frontend_register->form_handler( array( 'id' => $active_registration_form_id, 'type' => 'registration' ) ), 'true' );
									?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="placeholder <?php if( $active_tab == 'login' ) echo 'active'; ?>">
									<h3><?php echo esc_html__( 'Already registered?', 'gowatch' ); ?></h3>

									<div class="description"><?php echo esc_html__( 'Have an account? Use the login form here to enter your profile.', 'gowatch' ); ?></div>
									
									<a class="toggle-form toggle-login" href="#">
										<?php echo esc_html__( 'Log In', 'gowatch' ); ?>
									</a>
								</div>							
								<div class="form-container login-form <?php if( $active_tab == 'login' || $active_tab == 'lostpassword' ) echo 'active'; ?> visible">
									<?php 
										$login_form = new TSZF_Login();
										echo airkit_var_sanitize( $login_form->login_form(), 'true' );

										// Lost password form.
										get_template_part( 'includes/frontend-submission/templates/lost-pass-form' );

									 ?>
								 </div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<?php echo airkit_var_sanitize( $airkit_sidebar['right'], 'true' ); ?>
		</div>
	</div>
</section>

<?php
get_footer(); 

