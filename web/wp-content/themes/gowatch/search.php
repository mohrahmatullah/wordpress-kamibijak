<?php

get_header();

$airkit_found_posts = airkit_query( 'found_posts' );

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
					<h1 class="archive-title searchcount">
					<?php echo sprintf( _n( 'We have found %s result for: %s', 'We have found %s results for: %s', $airkit_found_posts, 'gowatch' ), number_format_i18n( $airkit_found_posts ) , '<span>' . get_search_query() . '</span>' ); ?> 				
					</h1>
				</div>
			</div>
		</div>
    </div><!-- /.airkit_page-header -->
	<div class="container airkit-archive-content">
		<?php if ( isset( $airkit_found_posts ) && $airkit_found_posts == 0 ) : ?>
			<h3 class="searchpage"><?php echo esc_html__('Strange. We have nothing on this.','gowatch'); ?></h3>
			<span class="subsearch"><?php echo esc_html__('Please do another search, and try to provide more details on what you are looking for.','gowatch'); ?></span>
		<?php endif; ?>

		<div class="row">
			<?php echo airkit_Compilator::searchbox_element( array( 'style' => 'input' ) ); ?>
			<?php echo airkit_Compilator::archive( 'search' ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>