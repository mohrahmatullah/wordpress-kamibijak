<?php

get_header();

$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
$user_id = $author->ID;
$profile_url = get_frontend_dashboard_url();

wp_redirect( $profile_url . '?user=' . $user_id );
exit;

$pht_attr = array();
$pht_style = airkit_option_value('layout', 'pht_style');
$pht_bg = airkit_option_value('layout', 'pht_bg');
$pht_bg_url = airkit_Compilator::get_attachment_field($pht_bg);

$pht_attr['class'] = 'class="airkit_page-header';

if ( $pht_style == 'bg' && !empty( $pht_bg_url ) ) {
    $pht_attr[] = 'data-parallax="y" style="background-image: url('. esc_url($pht_bg_url) .')"';
    $pht_attr['class'] .= ' has-background';
}

$pht_attr['class'] .= '"'; //close class attribute

?>
<div id="main" class="row">
    <div <?php echo implode(' ', $pht_attr); ?>>
		<div class="container">
			<div class="page-header-wrapper">
				<div class="page-header-inner <?php if ( !empty($pht_bg_url) ) echo esc_attr('airkit_scroll-text-fade'); ?>">
					<h1 class="archive-title author-title">
						<?php echo sprintf( esc_html__( 'All posts by: %s', 'gowatch' ), '<span>' . get_the_author() . '</span>' ); ?>
					</h1>
				</div>
			</div>
		</div>
    </div><!-- /.airkit_page-header -->
	<div class="container airkit-archive-content">
		<?php
			if ( $wp_query->have_posts() ) {

				$wp_query->the_post(); 
				airkit_author_box( $post );
			}			
		?>
		<div class="row">
			<?php echo airkit_Compilator::archive( 'author' ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>