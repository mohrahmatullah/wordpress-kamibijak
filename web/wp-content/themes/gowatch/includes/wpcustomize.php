<?php
/**
 *
 * Theme Options Customize
 *
**/

function airkit_customize_register( $wp_customize ) {

    $prefix = 'gowatch_options';

    require_once ( get_template_directory() . '/includes/class.options.php' );

    // Get colors from Theme Options
    $colors = airkit_Options::get_options('fields', 'colors');

    $wp_customize->add_panel( 'panel_' . $prefix, array(
        'title' => esc_html__( 'Theme Options', 'gowatch' ),
        'priority' => '30',
    ));

    $wp_customize->add_section( 'gowatch_colors', array(
        'title' => esc_html__( 'Colors','gowatch' ),
        'panel' => 'panel_' . $prefix,
    ));

    foreach ( $colors as $key => $color ) {

        if ( isset( $color['field'] ) && $color['field'] == 'option_block' ) {

            continue;

        }

        $wp_customize->add_setting(
            $prefix . '[colors][' . $color['id'] . ']', 
            wp_parse_args(
                array(
                    'default'   => $color['std'],
                    'transport' => 'refresh',
                    'type'      => 'option',
                    'sanitize_callabck' => 'sanitize_hex_color',
                    'sanitize_js_callback' => 'sanitize_hex_color',
                )
            )
        );

        $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, $prefix . '[colors][' . $color['id'] . ']', array(
            'label'    => $color['name'],
            'section'  => 'gowatch_colors',
            'settings' => $prefix . '[colors][' . $color['id'] . ']',
        )));
    }
}

add_action('customize_register', 'airkit_customize_register');
