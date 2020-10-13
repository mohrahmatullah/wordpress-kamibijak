<?php

add_action( 'wp_enqueue_scripts', 'gowatch_child_enqueue_styles' );

function gowatch_child_enqueue_styles() {
    wp_enqueue_style( 'gowatch-child-style', get_stylesheet_directory_uri() . '/style.css', array('gowatch-style','gowatch-bootstrap'));
}

?>