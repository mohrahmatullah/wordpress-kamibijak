<?php
get_header();

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
					<h1 class="archive-title">
						<?php echo esc_html__( 'Tagged as: ', 'gowatch' ); ?><?php echo '<span>' . single_tag_title( '', false ) . '</span>'; ?>
					</h1>
				</div>
			</div>
		</div>
    </div><!-- /.airkit_page-header -->
	<div class="container airkit-archive-content">
		<div class="row">
			<?php echo airkit_Compilator::archive( 'tags' ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>