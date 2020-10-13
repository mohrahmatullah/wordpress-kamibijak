<?php 
/**
 * The template for displaying events
 *
 * @package WordPress
 * @subpackage goWatch
 * @since goWatch 1.0
 */

global $airkit_is_ajax_loading;

$airkit_sidebar = airkit_Compilator::build_sidebar( 'single', $post->ID );


$airkit_meta = get_post_meta( $post->ID, 'event', true );
$airkit_day  = get_post_meta( $post->ID, 'day', true );
$airkit_day  = ( isset( $airkit_day ) && abs( $airkit_day ) !== 0 ) ? abs($airkit_day) : NULL;
// Get the start day
if ( isset( $airkit_day ) ) {

	$airkit_start_day = date('d M Y', $airkit_day);

} else{

	$airkit_start_day = esc_html__('Date not set', 'gowatch');

}

// Get the event end day
if ( isset( $airkit_meta['event-end'] ) ) {

	$airkit_end_day = date('d M Y', strtotime($airkit_meta['event-end']));

} else{

	$airkit_end_day = esc_html__('End day not set', 'gowatch');

}
// Get the start time
if ( isset( $airkit_meta['start-time'] ) ) {

	$airkit_start_time = esc_attr($airkit_meta['start-time']);

} else{

	$airkit_start_time = esc_html__('Time not set', 'gowatch');

}
// Get the end time
if ( isset( $airkit_meta['end-time'] ) ) {

	$airkit_end_time = esc_attr($airkit_meta['end-time']);

} else{

	$airkit_end_time = esc_html__('Time not set', 'gowatch');

}
// Get the event days
if ( isset( $airkit_meta['event-days'] ) ) {

	$airkit_end_days = esc_attr($airkit_meta['event-days']);

} else{

	$airkit_end_days = esc_html__('Days not set not set', 'gowatch');

}
// Get the event repeat
if ( isset( $airkit_meta['event-enable-repeat'] ) ) {

	$airkit_repeat = esc_attr($airkit_meta['event-enable-repeat']);

} else{

	$airkit_repeat = esc_html__('Repeat not set', 'gowatch');

}
// Get the event tematic
if ( isset( $airkit_meta['theme'] ) ) {

	$airkit_tematic = esc_attr($airkit_meta['theme']);

} else{

	$airkit_tematic = esc_html__('Tematic not set', 'gowatch');

}
// Get the event person
if ( isset( $airkit_meta['person'] ) ) {

	$airkit_person = esc_attr($airkit_meta['person']);

} else{

	$airkit_person = esc_html__('Person not set', 'gowatch');

}
// Get the event map
if ( isset( $airkit_meta['map'] ) ) {

	$airkit_map = $airkit_meta['map'];

} else{

	$airkit_map = esc_html__('Map not set', 'gowatch');

}
// Get the event venue
if ( isset( $airkit_meta['venue'] ) ) {

	$airkit_venue = esc_attr($airkit_meta['venue']);

} else{

	$airkit_venue = esc_html__('Venue not set', 'gowatch');

}

?>

<div id="primary" >
	<div id="content" role="main">
		<div class="row">
			<?php echo airkit_var_sanitize( $airkit_sidebar['left'], 'true' ); ?>
			<div class="ts-single-post <?php echo airkit_var_sanitize( $airkit_sidebar['content_class'], 'esc_attr' ); ?>">
				<article <?php airkit_element_attributes( array('class' => get_post_class('airkit_singular') ), array_merge( $options, array('element' => 'article') ), $post->ID ) ?>>
                	<?php airkit_progress_scroll(); ?>                    					
					<header class="post-header">
						<div class="event-map">
							<?php echo airkit_var_sanitize( $airkit_map, 'the_kses' ); ?>
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-7 col-lg-7">
								<h1 class="page-title"><?php the_title(); ?>
									<?php edit_post_link( esc_html__( 'Edit', 'gowatch' )); ?>
								</h1>
							</div>
							<div class="col-sm-12 col-md-5 col-lg-5">
								<div class="event-time">
									<i class="icon-time"></i>
									<span  itemprop="startDate" datetime="<?php echo airkit_var_sanitize( $airkit_start_time, 'the_kses' ) ?>">
										<?php echo airkit_var_sanitize( $airkit_start_time, 'the_kses' ); ?>
									</span>
									-
									<span itemprop="endDate" datetime="<?php echo airkit_var_sanitize( $airkit_end_time, 'the_kses' ) ?>">
										<?php echo airkit_var_sanitize( $airkit_end_time, 'the_kses' ); ?>
									</span>
								</div>
							</div>
							<!-- hide from options -->
							<div class="col-md-12 col-lg-12">
								<ul class="event-meta">
									<li class="event-start-date">
										<span class="meta"><?php esc_html_e('start date','gowatch'); ?></span>
										<span role="start-date"><?php echo airkit_var_sanitize( $airkit_start_day, 'the_kses' ); ?></span>
									</li>
									<li class="event-end-date">
										<span class="meta"><?php esc_html_e('end date','gowatch'); ?></span>
										<span role="end-date"><?php echo airkit_var_sanitize( $airkit_end_day, 'the_kses' ); ?></span>
									</li>
									<li class="event-venue">
										<span class="meta"><?php esc_html_e('venue','gowatch'); ?></span>
										<span itemprop="location" role="venue"><?php echo airkit_var_sanitize( $airkit_venue, 'the_kses' ); ?></span>
									</li>
									<li class="event-sharing">
										<span class="meta"><?php esc_html_e('share','gowatch'); ?></span>
										<?php airkit_single_sharing(); ?>					
									</li>
									<?php if ( $airkit_repeat !== 1 ): ?>
									<li class="repeat">
										<span role="repeat"><i class="icon-recursive"></i></span>
									</li>
									<?php endif ?>
								</ul>
							</div>										
						</div>
					</header><!-- .post-header -->

					<div class="post-content">
						<?php the_content(); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:', 'gowatch' ) . '</span>', 'after' => '</div>' ) ); ?>
					</div><!-- .post-content -->

					<!-- Start the rest of the event meta -->
					<ul itemprop="tickets" itemscope itemtype="http://data-vocabulary.org/Offer" class="event-meta-details">
						<?php if ( isset( $airkit_meta['person'] ) && trim( $airkit_meta['person'] ) != ''): ?>
							<li>
								<span itemprop="organizer"><?php echo esc_html__('Host:','gowatch'); ?></span> 
								<?php echo airkit_var_sanitize( $airkit_meta['person'], 'the_kses' ); ?>
							</li>
						<?php endif ?>
						<?php if ( isset( $airkit_meta['price'] ) && trim( $airkit_meta['price'] ) != '' ): ?>
							<li>
								<span itemprop="price"><?php echo esc_html__('Price:','gowatch'); ?></span> 
								<?php echo airkit_var_sanitize( $airkit_meta['price'], 'the_kses' ); ?>
							</li>
						<?php endif ?>
						<?php if ( isset( $airkit_meta['ticket-url'] ) && trim( $airkit_meta['ticket-url'] ) != '' ): ?>
							<li>
								<span><?php echo esc_html__('Tickets:','gowatch'); ?></span> 
								<?php echo '<a itemprop="offerurl" href="'.esc_url($airkit_meta['ticket-url']).'" target="_blank">' . esc_url($airkit_meta['ticket-url']).'</a>'; ?>
							</li>
						<?php endif ?>
					</ul>

					<footer class="post-footer">
						<?php echo airkit_PostMeta::tags( $post->ID, array( 'single' => 'y' ) ); ?>
						<?php
							airkit_PostMeta::author_box( $post );
							echo airkit_PostMeta::single_related( $post->ID );
						
							comments_template( '', true );
						?>
					</footer>
				</article><!-- #post-<?php the_ID(); ?> -->

				<!-- Ad area 2 -->
				<?php if( airkit_option_value('advertising','ad_area_2') != '' ): ?>
					<div class="container text-center airkit_advertising-container">
						<?php echo airkit_option_value('advertising','ad_area_2'); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php  echo airkit_var_sanitize( $airkit_sidebar['right'], 'true' ); ?>
		</div>
	</div>
</div>