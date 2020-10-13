<?php
$options = airkit_Compilator::$options;

$title = isset( $options['title'] ) ? esc_attr($options['title']) : '';
$date  = isset( $options['date']  ) ? esc_attr($options['date']) : NULL;
$time  = isset( $options['hours'] ) ? esc_attr($options['hours']) : NULL;
$style = isset( $options['style'] ) ? esc_attr($options['style']) : '';

// Set the class for the style
if ( $style == 'big' ) {
	$airkit_countdown_class = 'ts-big-countdown';
} else{
	$airkit_countdown_class = 'ts-small-countdown';
}

if ( $date !== NULL && $time !== NULL) {
    ?>
    <div class="col-md-12 col-lg-12">
	    <div class="ts-countdown <?php echo airkit_var_sanitize($airkit_countdown_class, 'esc_attr'); ?>">
			<h4 class="countdown-title"><?php if( isset($title) ) echo airkit_var_sanitize($title, 'esc_attr'); ?></h4>
			<ul class="time-remaining" data-date="<?php echo airkit_var_sanitize($date, 'esc_attr') ?>" data-time="<?php echo airkit_var_sanitize($time, 'esc_attr') ?>">
				<li>
					<div class="ts-days time">0</div>
					<span><?php esc_html_e('day', 'gowatch'); ?></span>
				</li>

				<li>
					<div class="ts-hours time">0</div>
					<span><?php esc_html_e('hou', 'gowatch'); ?></span>
				</li>
				<li>
					<div class="ts-minutes time">0</div>
					<span><?php esc_html_e('min', 'gowatch'); ?></span>
				</li>
				<li>
					<div class="ts-seconds time">0</div>
					<span><?php esc_html_e('sec', 'gowatch'); ?></span>
				</li>
			</ul>
		</div>
    </div>
	<?php
}
?>
