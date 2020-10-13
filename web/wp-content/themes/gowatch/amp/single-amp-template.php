<?php 
	$post = $this->get( 'post' );
	$post_format = get_post_format($post->ID);
	$content_max_width = absint( $this->get( 'content_max_width' ) );
?>
<!doctype html>
<html amp <?php echo AMP_HTML_Utils::build_attributes_string( $this->get( 'html_tag_attributes' ) ); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<?php

		if ( $post_format == 'gallery' ) {

			echo '<script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>';

		} elseif ( $post_format == 'video' ) {

			$video = get_post_meta( $post->ID, 'video_embed', TRUE );

			if( strpos( $video, 'youtu' ) ) {
				echo '<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>';
			} elseif ( strpos( $video , 'vimeo' ) ) {
				echo '<script async custom-element="amp-vimeo" src="https://cdn.ampproject.org/v0/amp-vimeo-0.1.js"></script>';
			}

		} elseif ( $post_format == 'audio' ) {
		
			$audio = get_post_meta( $post->ID, 'audio_embed', TRUE );

			if ( strpos( $audio , 'soundcloud' ) ) {
				echo '<script async custom-element="amp-soundcloud" src="https://cdn.ampproject.org/v0/amp-soundcloud-0.1.js"></script>';
			}

		}

	?>

	<?php do_action( 'amp_post_template_head', $this ); ?>

	<style amp-custom>
		<?php $this->load_parts( array( 'style' ) ); ?>
		<?php do_action( 'amp_post_template_css', $this ); ?>
	</style>
</head>

<body class="<?php echo esc_attr( $this->get( 'body_class' ) ); ?>">

<div class="amp-wp-content">

	<?php $this->load_parts( array( 'header-bar' ) ); ?>

	<article class="amp-wp-article">

		<header class="amp-wp-article-header">
			<h1 class="amp-wp-title"><?php echo wp_kses_data( $this->get( 'post_title' ) ); ?></h1>
			<?php $this->load_parts( apply_filters( 'amp_post_article_header_meta', array( 'meta-author', 'meta-time' ) ) ); ?>
		</header>

		<?php if ( $post_format == 'video' ): ?>
			
		<?php endif ?>
		<?php $this->load_parts( array( 'featured-image' ) ); ?>

		<div class="amp-wp-article-content">
			<?php echo airkit_var_sanitize( $this->get( 'post_amp_content' ), 'true' ); // amphtml content; no kses ?>
		</div>

		<?php if ( $post_format == 'gallery' ): ?>
			<?php
				$airkit_images = get_post_meta(get_the_ID(), '_post_image_gallery', true);
				$airkit_attachments = array_filter( explode( ',', $airkit_images ) );

				if( isset( $airkit_attachments ) && count( $airkit_attachments ) > 0 ) :
			?>
				<amp-carousel width="<?php echo esc_attr($content_max_width); ?>" height="480" layout="responsive" type="slides">
					<?php foreach ($airkit_attachments as $attachment_id): ?>
						<?php $img_src = wp_get_attachment_image_src($attachment_id, 'full'); ?>
					    <amp-img src="<?php echo esc_url($img_src[0]) ?>" width="<?php echo esc_attr($img_src[1]) ?>" height="<?php echo esc_attr($img_src[2]) ?>" layout="responsive"></amp-img>
					<?php endforeach ?>
				</amp-carousel>
			<?php endif; ?>
		<?php endif ?>

		<footer class="amp-wp-article-footer">
			<?php $this->load_parts( apply_filters( 'amp_post_article_footer_meta', array( 'meta-taxonomy', 'meta-comments-link' ) ) ); ?>
		</footer>

	</article>

	<?php $this->load_parts( array( 'footer' ) ); ?>
	
</div>

<?php do_action( 'amp_post_template_footer', $this ); ?>

</body>
</html>