<?php 
/*
Template Name: Single Post
*/

get_header();

$airkit_main_classes 	= array('airkit_single-post airkit_single-main');
$airkit_main_classes[] 	= ( 'y' == airkit_single_option( 'sticky_sidebar' ) ) ? 'sticky-sidebars-enabled' : '';
$meta = get_post_meta( $post->ID, 'airkit_post_settings', true );
$theme_post_types = array('post', 'video', 'ts-gallery', 'ts-event', 'ts_teams', 'portfolio');

?>

<!-- Ad area 1 -->
<?php
	if( airkit_option_value('advertising','ad_area_1') != '' ) {
		echo '<div class="container text-center airkit_advertising-container">' . airkit_option_value('advertising','ad_area_1') . '</div>';
	}
?>

<div class="single-content <?php echo implode(' ', $airkit_main_classes); ?>">
	<?php
		if ( have_posts() ) {

			while ( have_posts() ):

				the_post();

				$post_type = get_post_type( get_the_ID() );
				$post_format = get_post_format( get_the_ID() );


				// Do the redirect for video post format
				if( in_array($post_type, $theme_post_types) ) {
					get_template_part('templates/' . $post_type);
				} else {
					get_template_part('templates/post');
				}

			endwhile;
		}
	?>
</div>


<?php
	get_footer(); 
?>
