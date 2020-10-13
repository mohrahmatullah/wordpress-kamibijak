<header id="#top" class="amp-wp-header">
	<div>
		<a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>">
			<?php
				$custom_logo_id = get_theme_mod( 'custom_logo' );
				$image = wp_get_attachment_image_src( $custom_logo_id , array('220','90') );

				if ( $image ) : ?>
				<amp-img src="<?php echo esc_url( $image[0] ); ?>" width="<?php echo esc_attr($image[1]) ?>" height="<?php echo esc_attr($image[2]) ?>" class="amp-wp-site-logo"></amp-img>
			<?php endif; ?>
		</a>
		<a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>" class="goto-home">
			<?php echo esc_html_e('Home','gowatch'); ?>
		</a>
	</div>
</header>