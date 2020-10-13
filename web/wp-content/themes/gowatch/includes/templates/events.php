<?php

$options = airkit_Compilator::$options;

$post_meta = get_post_meta(get_the_ID(), 'event', true);

$repeat = (isset($post_meta['event-enable-repeat']) && ($post_meta['event-enable-repeat'] == 'n' || $post_meta['event-enable-repeat'] == 'y')) ? $post_meta['event-enable-repeat'] : 'n';

$free_paid = '';
$price = '';

if( isset($post_meta['free-paid']) ){
	if( $post_meta['free-paid'] == 'free' ){
		$free_paid = esc_html__('Free', 'gowatch');
	}else{
		if( isset($post_meta['ticket-url']) && !empty($post_meta['ticket-url']) ){
			$free_paid = '<a href="' . esc_url($post_meta['ticket-url']) . '" class="primary_color">' . esc_html__('BUY', 'gowatch') . '</a>';
		}
		$price = (isset($post_meta['price'])) ? $post_meta['price'] : '';
	}
}
$day = '';
$month = '';
$airkit_event_start_time = '';
$day_meta = get_post_meta(get_the_ID(), 'day', true);
if( isset($day_meta) && (int)$day_meta !== 0 ){
	$month = date("M", $day_meta);
	$day = date("j", $day_meta);
	$airkit_event_start_time = date("g a", $day_meta);
}
$parent_effect = airkit_Compilator::parent_effect( $options );
$article_class = airkit_Compilator::child_effect( $options );

?>
<div class="<?php echo airkit_var_sanitize( $parent_effect, 'esc_attr' ); ?>">
<article <?php post_class( $article_class ); ?> itemscope itemtype="https://schema.org/Event">
	<header>
		<ul class="entry-meta-date">
			<li class="meta-date" itemprop="startDate"><?php  echo airkit_var_sanitize( $day, 'esc_attr' ) ?></li>
			<li class="meta-month"><?php echo airkit_var_sanitize( $month, 'esc_attr' ); ?></li>
			<li class="meta-hour"><?php  echo airkit_var_sanitize( $airkit_event_start_time, 'esc_attr' ) ?></li>
		</ul>
		<div class="entry-content">
			<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<span class="block-price"><?php echo airkit_var_sanitize( $free_paid, 'the_kses' ); ?></span>
			<div class="entry-meta">
				<address class="entry-address" itemprop="location"><?php echo isset($post_meta['venue']) ? $post_meta['venue'] : ''; ?></address>
			</div>
		</div>
	</header>
	<section class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 image-holder">
			<?php
				echo get_the_post_thumbnail( $post->ID, 'gowatch_grid' );
			?>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 entry-excerpt">
			<?php airkit_excerpt(470, get_the_ID(), 'show-excerpt'); ?>
		</div>
	</section>
</article>
</div>