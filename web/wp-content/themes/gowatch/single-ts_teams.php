<?php
get_header();

/* Team single page */

$airkit_teams = get_post_meta($post->ID, 'ts_member', TRUE);

$airkit_teams  = !empty($airkit_teams) ? $airkit_teams : array();

$airkit_option_social = get_option( 'gowatch_social' );

$airkit_description = isset($airkit_teams['about_member']) ? apply_filters('the_content', $airkit_teams['about_member']) : '';

$airkit_socials = array('facebook', 'linkedin', 'gplus', 'email', 'skype', 'github', 'dribble', 'lastfm', 'linkedin', 'tumblr', 'twitter', 'vimeo', 'wordpress', 'yahoo', 'youtube', 'flickr', 'pinterest', 'instagram');


$airkit_term_ids = wp_get_post_terms($post->ID, 'teams', array('fields' => 'ids') );

if( is_array( $airkit_term_ids ) && !empty( $airkit_term_ids ) ){

	$airkit_args = array(
		'post_type'    => 'ts_teams',
		'post__not_in' => array($post->ID),
		'tax_query'    => array(
	        array(
	            'taxonomy' => 'teams',
	            'field'    => 'id',
	            'terms'    => $airkit_term_ids
	        )
	    ),
		'posts_per_page' => 3
	);

	$airkit_query = new WP_Query( $airkit_args );

	$airkit_options = array();

	$airkit_options['per-row'] = 3;
	$airkit_options['remove-gutter'] = 'n';
	$airkit_options['carousel'] = 'n';
	$airkit_options['category'] = '';

	if( $airkit_query->have_posts() ){

		$airkit_related_teams = airkit_Compilator::teams_element( $airkit_options, $airkit_query );

	}
}

$airkit_author_id = (isset($airkit_teams['team-user']) && absint($airkit_teams['team-user']) > 0) ? absint($airkit_teams['team-user']) : '';

if( $airkit_author_id !== '' ){

	$airkit_args = array(
		'author' => $airkit_author_id,
	);

	$airkit_query_author = new WP_Query($airkit_args);

	$airkit_archive_options = get_option( 'gowatch_options' );

	$airkit_view_options = ! empty( $airkit_archive_options['layout'][ 'author' ] ) ? $airkit_archive_options['layout'][ 'author' ] : array();
	$airkit_view_options['small-posts'] = 'n';
	$airkit_view_options['behavior'] = 'normal';
	$airkit_view_options['reveal-effect'] = 'none';
	$airkit_view_options['reveal-delay'] = 'delay-n';
	$airkit_view_options['gutter-space'] = '40';

	if( $airkit_query_author->have_posts() ){

		$airkit_author_posts = airkit_Compilator::view_articles( $airkit_view_options, $airkit_query_author );

	}
}

?>
<div id="primary" class="ts-team-single">
	<div id="content" role="main">
		<div class="container team-general">
			<div class="row">
				<div class="col-sm-3 col-md-3 text-left">
					<div class="member-thumb">
						<?php
							the_post_thumbnail();
							airkit_overlay_effect_type();	
						?>
					</div>
					<?php
						// If user linked to a profile, show link to user's dashboard
						if( $airkit_author_id !== '' )	{

							$airkit_profile_url = get_author_posts_url( $airkit_author_id );

							echo '<a href="'. esc_url( $airkit_profile_url ) .'" class="view-profile">'. esc_html__( 'View Profile', 'gowatch' ) .'</a>';
						}
					?>
				</div>
				<div class="col-sm-9 col-md-9">
					<div class="member-content">
						<div class="member-name">
							<?php 
								echo airkit_PostMeta::title( $post->ID, array( 'wrap' => 'h1', 'class' => 'post-title', 'url' => 'n', 'single' => 'y' ) );
								echo airkit_PostMeta::categories( $post->ID, array( 'wrap-class' => 'team-categories', 'single' => 'y' ) ); 
							?>
						</div>
						<span class="position"><?php echo esc_attr( $airkit_teams['position'] ); ?></span>
						<p class="author-short-description"><?php echo airkit_var_sanitize( $airkit_description, 'the_kses' ); ?></p>
						<hr>
						<div class="airkit_social-icons background">
							<ul>
								<?php if( !empty( $airkit_teams ) ) : ?>

									<?php foreach( $airkit_teams as $airkit_key => $airkit_social ) : ?>

										<?php if( in_array( $airkit_key, $airkit_socials ) && !empty( $airkit_social ) ) : ?>
											<?php

												if( $airkit_key == 'email' ){

												    $airkit_icon = 'mail';

												}elseif( $airkit_key == 'dribble' ){

												    $airkit_icon = 'dribbble';

												}elseif( $airkit_key == 'youtube' ){

												    $airkit_icon = 'video';

												}else{

												    $airkit_icon = NULL;

												}
											?>
											<li>
												<a href="<?php echo esc_url( $airkit_social ); ?>">												   
													<i class="icon-<?php echo ( isset($airkit_icon) ? $airkit_icon : $airkit_key ) ?>"></i>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
						<br><br>
						<div class="post-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container related-members">

			<?php 

				if( isset( $airkit_author_posts ) ) {

					echo '<h3 class="author-articles"><i class="icon-pistachio"></i>' . esc_html__('Author articles', 'gowatch') . '</h3>';
					echo '<div class="row">';
					echo airkit_var_sanitize( $airkit_author_posts, 'true' ); 
					echo '</div>';
				}


				if( isset( $airkit_related_teams ) ):
			?>
				<h3> <i class="icon-user"></i><?php esc_html_e('Related members', 'gowatch'); ?></h3>
				<div class="row">
					<?php  echo airkit_var_sanitize( $airkit_related_teams, 'true' ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>
<?php get_footer(); ?>