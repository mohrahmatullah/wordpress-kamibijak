<?php

get_header();

if ( is_day() ) :

	$airkit_archive_title = get_the_date();

elseif ( is_month() ) :

	$airkit_archive_title = get_the_date( 'F Y' );

elseif ( is_year() ) :

	$airkit_archive_title = get_the_date( 'Y' );

else :

	$airkit_archive_title = airkit_query( 'name' );

endif;


$pht_attr = array();
$pht_style = airkit_option_value('layout', 'pht_style');
$pht_bg_url = airkit_category_header_image();

$pht_attr['class'] = 'class="airkit_page-header';

if ( $pht_style == 'bg' && !empty( $pht_bg_url ) ) {

    $pht_attr[] = 'data-parallax="y" style="background-image: url('. esc_url( $pht_bg_url ) .')"';
    $pht_attr['class'] .= ' has-background';

}

$pht_attr['class'] .= '"'; //close class attribute

?>
<div id="main" class="row">
    <div <?php echo implode(' ', $pht_attr); ?>>
		<div class="container">
			<div class="page-header-wrapper">
				<div class="page-header-inner <?php if ( !empty($pht_bg_url) ) echo esc_attr('airkit_scroll-text-fade'); ?>">
					<h1 class="archive-title">
						<?php echo airkit_var_sanitize( $airkit_archive_title, 'the_kses' ); ?>
					</h1>
					<div class="archive-desc">
						<?php echo category_description( get_cat_ID( single_cat_title( '', false ) ) ); ?>
					</div>
				</div>
			</div>
		</div>
    </div><!-- /.airkit_page-header -->
	<div class="container airkit-archive-content">
		<div class="row">
			<?php echo airkit_Compilator::archive( 'archive' ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>

