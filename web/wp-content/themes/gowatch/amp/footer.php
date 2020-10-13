<?php $this->load_parts( array( 'related-posts' ) ); ?>
<footer class="amp-wp-footer">
	<div>
		<a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>">
			<?php
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				$image = wp_get_attachment_image_src( $custom_logo_id , array('220','90') );

				if ( $image ) : ?>
				<amp-img src="<?php echo esc_url( $image[0] ); ?>" width="<?php echo esc_attr($image[1]) ?>" height="<?php echo esc_attr($image[2]) ?>" class="amp-wp-site-logo"></amp-img>
			<?php endif; ?>
		</a>
		<p>&copy; <?php echo sprintf( esc_html__('%d %s. All rights reserved.', 'gowatch'), date('Y'), get_bloginfo('name') ); ?></p>
		<a href="#top" class="back-to-top"><?php _e( 'Back to top', 'gowatch' ); ?></a>
	</div>
</footer>