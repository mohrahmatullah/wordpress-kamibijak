<?php
$featured_image = $this->get( 'featured_image' );
$post = $this->get( 'post' );
$post_format = get_post_format($post->ID);
$content_max_width = absint( $this->get( 'content_max_width' ) );
$amp_html = '';

if ( $post_format == 'video' ) {
	$video = get_post_meta( $post->ID, 'video_embed', TRUE );

	if ( preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video, $match) ) {

		$amp_html = '<amp-youtube data-videoid="'. $match[1] .'" layout="responsive" width="'. esc_attr($content_max_width) .'" height="320"></amp-youtube>';

	} elseif ( preg_match_all( '~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $video, $math) ) {

		$amp_html = '<amp-vimeo data-videoid="'. $math[1][0] .'" layout="responsive" width="'. esc_attr($content_max_width) .'" height="320"></amp-vimeo>';

	}

} elseif ( $post_format == 'audio' ) {

	$audio = get_post_meta( $post->ID, 'audio_embed', TRUE );

	if ( preg_match( '%(?:soundcloud.com)/(?:tracks/)([0-9]+)%i' , $audio, $math ) ) {

		$amp_html = '<amp-soundcloud height=320 layout="fixed-height" data-trackid="'. $math[1] .'" data-visual="true"></amp-soundcloud>';

	}

} else {

	$amp_html = $featured_image['amp_html'];
	
}

if ( !$amp_html ) {
	return;
}

$caption = $featured_image['caption'];

?>
<figure class="amp-wp-article-featured-image wp-caption">
	<?php echo airkit_var_sanitize( $amp_html, 'true' ); // amphtml content; no kses ?>
	<?php if ( $caption ) : ?>
		<p class="wp-caption-text">
			<?php echo wp_kses_data( $caption ); ?>
		</p>
	<?php endif; ?>
</figure>