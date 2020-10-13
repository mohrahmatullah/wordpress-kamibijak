<?php

// In case of a playlist post redirect to the first post from the playlist
$playlist_posts = get_post_meta( get_the_ID(), '_post_ids', true );

// Create link with first post
$link = get_the_permalink( $playlist_posts[0] ) . '?playlist_ID=' . get_the_ID();

// Redirect to the first post link
wp_redirect( $link );

?>