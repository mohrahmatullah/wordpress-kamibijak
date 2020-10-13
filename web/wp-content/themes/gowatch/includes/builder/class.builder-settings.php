<?php

class airkit_BuilderSettings
{
    static $repeat_set = array();

    static function get_icons()
    {
        $icons = get_option( 'gowatch_icons', array() );

        if ( empty( $icons ) ) {

            return array();
        }

        return explode( ',', $icons );
    }

    static function get_setting( $pull )
    {
        if ( empty( self::$repeat_set ) ) {

            self::$repeat_set = array(

                'target' => array(
                    'name'    => esc_html__( 'Link target', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        '_self'  => esc_html__( 'Open is same tab', 'gowatch' ),
                        '_blank' => esc_html__( 'Open link in new tab', 'gowatch' )
                    ),
                    'id'       => 'target',
                    'std'      => '_blank'
                ),

                'icon' => array(
                    'name'    => esc_html__( 'Choose an icon', 'gowatch' ),
                    'field'   => 'list_select',
                    'options' => self::get_icons(),
                    'id'      => 'icon',
                    'std'     => 'icon-noicon'
                ),

                'icon-color' => array(
                    'name'  => esc_html__( 'Choose an icon color', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'font-color',
                    'std'   => '#777'
                ),

                'carousel' => array(
                    'name'    => esc_html__( 'Enable carousel', 'gowatch' ),
                    'desc'    => esc_html__( 'If enabled, it will create a sliding carousel', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' )
                    ),
                    'id'       => 'carousel',
                    'std'      => 'n',
                    'class_select' => 'airkit_trigger-options',
                ),

                'bg-video-mp' => array(
                    'name'       => esc_html__( 'Upload a video MP4 format for background', 'gowatch' ),
                    'desc'       => esc_html__( 'Add a background video. We strongly recommend to use muted videos, since there is no way to stop, pause or mute a background video.', 'gowatch' ),
                    'field'      => 'upload',
                    'media-type' => 'video',
                    'multiple'   => 'false',
                    'id'         => 'bg-video-mp',
                    'std'        => ''
                ),

                'bg-video-webm' => array(
                    'name'       => esc_html__( 'Upload a video WebM format for background', 'gowatch' ),
                    'desc'       => esc_html__( 'Add a background video. We strongly recommend to use muted videos, since there is no way to stop, pause or mute a background video.', 'gowatch' ),
                    'field'      => 'upload',
                    'multiple'   => 'false',
                    'media-type' => 'video',
                    'id'         => 'bg-video-webm',
                    'std'        => ''
                ),

                'margin-top' => array(
                    'name'  => esc_html__( 'Margin top', 'gowatch' ),
                    'desc'  => esc_html__( 'This will add spacing above the element, outside it.', 'gowatch' ),
                    'field' => 'input',
                    'type'  => 'number',
                    'id'    => 'margin-top',
                    'std'   => 0
                ),

                'margin-bottom' => array(
                    'name'  => esc_html__( 'Margin bottom', 'gowatch' ),
                    'desc'  => esc_html__( 'This will add spacing below the element, outside it.', 'gowatch' ),
                    'field' => 'input',
                    'type'  => 'number',
                    'id'    => 'margin-bottom',
                    'std'   => 0
                ),

                'padding-top' => array(
                    'name'  => esc_html__( 'Padding top', 'gowatch' ),
                    'desc'  => esc_html__( 'This will add spacing in the top part of the element, inside it, so that the number of pixes you specify here is left as spacing.', 'gowatch' ),
                    'field' => 'input',
                    'type'  => 'number',
                    'id'    => 'padding-top',
                    'std'   => 0
                ),

                'padding-right' => array(
                    'name'  => esc_html__( 'Padding right', 'gowatch' ),
                    'desc'  => esc_html__( 'This will add spacing on right side of the element, inside it, so that the number of pixes you specify here is left as spacing.', 'gowatch' ),
                    'field' => 'input',
                    'type'  => 'number',
                    'id'    => 'padding-right',
                    'std'   => 0
                ),

                'padding-bottom' => array(
                    'name'  => esc_html__( 'Padding bottom', 'gowatch' ),
                    'desc'  => esc_html__( 'This will add spacing in the bottom part of the element, inside it, so that the number of pixes you specify here is left as spacing.', 'gowatch' ),
                    'field' => 'input',
                    'type'  => 'number',
                    'id'    => 'padding-bottom',
                    'std'   => 0
                ),

                'padding-left' => array(
                    'name'  => esc_html__( 'Padding left', 'gowatch' ),
                    'desc'  => esc_html__( 'This will add spacing on left side of the element, inside it, so that the number of pixes you specify here is left as spacing.', 'gowatch' ),
                    'field' => 'input',
                    'type'  => 'number',
                    'id'    => 'padding-left',
                    'std'   => 0
                ),

                'border-top' => array(
                    'name'    => esc_html__( 'Border top', 'gowatch' ),
                    'desc'    => esc_html__( 'If enabled, it will add a border at the top is the element with the options you select below', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' )
                    ),
                    'id'           => 'border-top',
                    'std'          => 'n',
                    'class_select' => 'airkit_trigger-options'
                ),

                'border-top-width' => array(
                    'name'  => esc_html__( 'Border top width', 'gowatch' ),
                    'desc'  => esc_html__( 'Select the width (size) of the border top. You can set anything from 1 to 15.', 'gowatch' ),
                    'field' => 'slider_drag',
                    'min'   => 1,
                    'max'   => 15,
                    'step'  => 1,
                    'id'    => 'border-top-width',
                    'std'   => 1,
                    'class' => 'airkit_border-top-y'
                ),

                'border-top-color' => array(
                    'name'  => esc_html__( 'Border top color', 'gowatch' ),
                    'desc'  => esc_html__( 'Select a color you want your border top to be.', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'border-top-color',
                    'std'   => '#DDDDDD',
                    'class' => 'airkit_border-top-y'
                ),

                'border-right' => array(
                    'name'    => esc_html__( 'Border right', 'gowatch' ),
                    'desc'    => esc_html__( 'If enabled, it will add a border at the right side of the element with the options you select below', 'gowatch' ),
                    'field'   => 'select',
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' )
                    ),
                    'id'           => 'border-right',
                    'std'          => 'n',
                    'class_select' => 'airkit_trigger-options'
                ),

                'border-right-width' => array(
                    'name'  => esc_html__( 'Border right width', 'gowatch' ),
                    'desc'  => esc_html__( 'Select the width (size) of the border right. You can set anything from 1 to 15.', 'gowatch' ),
                    'field' => 'slider_drag',
                    'min'   => 1,
                    'max'   => 15,
                    'step'  => 1,
                    'id'    => 'border-right-width',
                    'std'   => 1,
                    'class' => 'airkit_border-right-y'
                ),

                'border-right-color' => array(
                    'name'  => esc_html__( 'Border right color', 'gowatch' ),
                    'desc'  => esc_html__( 'Select a color you want your border top to be.', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'border-right-color',
                    'std'   => '#DDDDDD',
                    'class' => 'airkit_border-right-y'
                ),

                'border-bottom' => array(
                    'name'    => esc_html__( 'Border bottom', 'gowatch' ),
                    'desc'    => esc_html__( 'If enabled, it will add a border at the bottom of the element with the options you select below', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' )
                    ),
                    'id'           => 'border-bottom',
                    'std'          => 'n',
                    'class_select' => 'airkit_trigger-options'
                ),

                'border-bottom-width' => array(
                    'name'  => esc_html__( 'Border bottom width', 'gowatch' ),
                    'desc'  => esc_html__( 'Select the width (size) of the border bottom. You can set anything from 1 to 15.', 'gowatch' ),
                    'field' => 'slider_drag',
                    'min'   => 1,
                    'max'   => 15,
                    'step'  => 1,
                    'id'    => 'border-bottom-width',
                    'std'   => 1,
                    'class' => 'airkit_border-bottom-y'
                ),

                'border-bottom-color' => array(
                    'name'  => esc_html__( 'Border bottom color', 'gowatch' ),
                    'desc'  => esc_html__( 'Select a color you want your border top to be.', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'border-bottom-color',
                    'std'   => '#DDDDDD',
                    'class' => 'airkit_border-bottom-y'
                ),

                'border-left' => array(
                    'name'    => esc_html__( 'Border left', 'gowatch' ),
                    'desc'    => esc_html__( 'If enabled, it will add a border at the right side of the element with the options you select below', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' )
                    ),
                    'id'           => 'border-left',
                    'std'          => 'n',
                    'class_select' => 'airkit_trigger-options'
                ),

                'border-left-width' => array(
                    'name'  => esc_html__( 'Border left width', 'gowatch' ),
                    'desc'  => esc_html__( 'Select the width (size) of the border left. You can set anything from 1 to 15.', 'gowatch' ),
                    'field' => 'slider_drag',
                    'min'   => 1,
                    'max'   => 15,
                    'step'  => 1,
                    'id'    => 'border-left-width',
                    'std'   => 1,
                    'class' => 'airkit_border-left-y'
                ),

                'border-left-color' => array(
                    'name'  => esc_html__( 'Border left color', 'gowatch' ),
                    'desc'  => esc_html__( 'Select a color you want your border top to be.', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'border-left-color',
                    'std'   => '#DDDDDD',
                    'class' => 'airkit_border-left-y'
                ),

                'text-color' => array(
                    'name'  => esc_html__( 'Text color', 'gowatch' ),
                    'desc'  => esc_html__( 'Choose a text color for the content of this element. Note that not all colors inside will be changed, as most come from theme options and other element settings. This affects mostly texts.', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'text-color',
                    'std'   => '#000000'
                ),

                'bg-color' => array(
                    'name'  => esc_html__( 'Choose background color', 'gowatch' ),
                    'desc'  => esc_html__( 'Add a background color to this element. Note that this will only affect this element.', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'bg-color',
                    'std'   => '#ffffff'
                ),

                'text-align' => array(
                    'name'    => esc_html__( 'Text align', 'gowatch' ),
                    'desc'    => esc_html__( 'You can select the align of the text inside this column. Keep in mind that some element aligns are hardcoded and you cannot change them.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'left'   => esc_html__( 'Left', 'gowatch' ),
                        'center' => esc_html__( 'Center', 'gowatch' ),
                        'right'  => esc_html__( 'Right', 'gowatch' ),
                    ),
                    'id'      => 'text-align',
                    'std'     => 'left'
                ),

                'parallax' => array(
                    'name'    => esc_html__( 'Enable image parallax', 'gowatch' ),
                    'desc'    => esc_html__( 'If you have a background image set, this will add subtle parallax efect for the background image of this specifc row.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' )
                    ),
                    'id'       => 'parallax',
                    'std'      => 'n'
                ),

                'bg-img' => array(
                    'name'       => esc_html__( 'Upload background image', 'gowatch' ),
                    'desc'       => esc_html__( 'If you want to add a background image to this element, please upload it or select one from the media library.', 'gowatch' ),
                    'field'      => 'upload',
                    'media-type' => 'image',
                    'multiple'   => 'false',
                    'id'         => 'bg-img',
                    'std'        => ''
                ),

                'bg-x' => array(
                    'name'    => esc_html__( 'Background position X axis', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'left'   => esc_html__( 'Left', 'gowatch' ),
                        'center' => esc_html__( 'Center', 'gowatch' ),
                        'right'  => esc_html__( 'Right', 'gowatch' ),
                    ),
                    'id'       => 'bg-x',
                    'std'      => 'left'
                ),

                'bg-y' => array(
                    'name'    => esc_html__( 'Background position Y axis', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'top'    => esc_html__( 'Top', 'gowatch' ),
                        'center' => esc_html__( 'Center', 'gowatch' ),
                        'bottom' => esc_html__( 'Bottom', 'gowatch' ),
                    ),
                    'id'       => 'bg-y',
                    'std'      => 'top'
                ),

                'bg-attachement' => array(
                    'name'    => esc_html__( 'Background attachment', 'gowatch' ),
                    'desc'    => esc_html__( 'Choose your background attachment style. You can make it static or scroll align with the website. For more info, please search the web about the background attachment option.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'fixed'  => esc_html__( 'Fixed', 'gowatch' ),
                        'scroll' => esc_html__( 'Scroll', 'gowatch' )
                    ),
                    'id'       => 'bg-attachement',
                    'std'      => 'fixed'
                ),

                'bg-repeat' => array(
                    'name'    => esc_html__( 'Background repeat', 'gowatch' ),
                    'desc'    => esc_html__( 'You can choose to repeat the background for this specific element.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'repeat'    => esc_html__( 'Repeat', 'gowatch' ),
                        'no-repeat' => esc_html__( 'No repeat', 'gowatch' ),
                        'repeat-x'  => esc_html__( 'Horizontaly', 'gowatch' ),
                        'repeat-y'  => esc_html__( 'Verticaly', 'gowatch' )
                    ),
                    'id'       => 'bg-repeat',
                    'std'      => 'no-repeat'
                ),

                'bg-size' => array(
                    'name'    => esc_html__( 'Background size', 'gowatch' ),
                    'desc'    => esc_html__( 'If you are using a background image, select the background size that you want. You can have it auto so it will keep the image size that you have uploaded or set it cover, so it makes sure that image will fill the row vertically and horizontally. Keep in mind that the second option could crop bits of your image and will not always show 100% the part of the image you want. You can also set it to contain, so the image will be scaled to the container size such that both its width and its height can fit inside the content area', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'auto'  => esc_html__( 'Auto', 'gowatch' ),
                        'cover' => esc_html__( 'Cover', 'gowatch' ),
                        'contain' => esc_html__( 'Contain', 'gowatch' ),
                    ),
                    'id'  => 'bg-size',
                    'std' => 'no-repeat'
                ),

                'mask' => array(
                    'name'    => esc_html__( 'Enable background mask', 'gowatch' ),
                    'desc'    => esc_html__( 'If enabled, this will add a subtle overlay effect to the background settings. It is recommended to be used with background image.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'y'        => esc_html__( 'Color', 'gowatch' ),
                        'n'        => esc_html__( 'No mask', 'gowatch' ),
                        'gradient' => esc_html__( 'Gradient', 'gowatch' )
                    ),
                    'id'           => 'mask',
                    'std'          => 'n',
                    'class_select' => 'airkit_trigger-options'
                ),

                'mask-color' => array(
                    'name'  => esc_html__( 'Background mask color #1', 'gowatch' ),
                    'desc'  => esc_html__( 'If you use a single tone mask style, you can select the color of it here.', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'mask-color',
                    'std'   => '#DDDDDD',
                    'class' => 'airkit_mask-y airkit_mask-gradient'
                ),

                'mask-gradient-color' => array(
                    'name'  => esc_html__( 'Background mask color #2', 'gowatch' ),
                    'desc'  => esc_html__( 'If you use a gradient tone mask style, you can select the secondary color of it here.', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'mask-gradient-color',
                    'std'   => '#DDDDDD',
                    'class' => 'airkit_mask-gradient'
                ),

                'gradient-type' => array(
                    'name'    => esc_html__( 'Background mask gradient style', 'gowatch' ),
                    'desc'    => esc_html__( 'If you selected the gradient style for the background mask, you can choose the style of it here from the available options', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'radial'        => esc_html__( 'Radial (from center to corners)', 'gowatch' ),
                        'top-to-bottom' => esc_html__( 'From top to bottom', 'gowatch' ),
                        'left-to-right' => esc_html__( 'From left to right', 'gowatch' ),
                        'corner-top'    => esc_html__( 'From top left corner to bottom right corner', 'gowatch' ),
                        'corner-bottom' => esc_html__( 'From bottom left corner to top right corner', 'gowatch' )
                    ),
                    'id'       => 'gradient-type',
                    'std'      => 'radial',
                    'class'    => 'airkit_mask-gradient'
                ),

                'per-row' => array(
                    'name'    => esc_html__( 'Number of elements per row', 'gowatch' ),
                    'desc'    => esc_html__( 'Choose the number of elements you want to use per line. For example, if you want a grid of 3 items choose the 3 columns layout', 'gowatch' ),
                    'field'   => 'img_selector',
                    'options' => array(
                        1 => 1,
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        6 => 6
                    ),
                    'img' => array(
                        1 => 'per_row_1.png',
                        2 => 'per_row_2.png',
                        3 => 'per_row_3.png',
                        4 => 'per_row_4.png',
                        6 => 'per_row_6.png',
                    ),
                    'id'       => 'per-row',
                    'std'      => 2
                ),

                'pagination' => array(
                    'name'    => esc_html__( 'Enable pagination', 'gowatch' ),
                    'desc'    => esc_html__( 'Choose a pagination style for your content. You can select from none which will show only the number of posts you want to extract or use number pagination, load more button or infinite scrolling. When you activate a style of pagination, it will show the next number of posts as the default number you selected', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'none'      => esc_html__( 'None', 'gowatch' ),
                        'numeric'   => esc_html__( 'Number pagination', 'gowatch' ),
                        'load-more' => esc_html__( 'Load more button', 'gowatch' ),
                        'infinite'  => esc_html__( 'Infinite scrolling', 'gowatch' )
                    ),
                    'id'    => 'pagination',
                    'std'   => 'none',
                    'class' => 'airkit_behavior-normal airkit_behavior-masonry airkit_scroll-n airkit_small-posts-n',
                    'class_select' => 'airkit_trigger-options',
                ),

                'styling' => array(
                    'name'    => esc_html__( 'View background/border styling', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'none'     => esc_html__( 'None', 'gowatch' ),
                        'border'   => esc_html__( 'Border', 'gowatch' ),
                        'bg-color' => esc_html__( 'Background color', 'gowatch' )
                    ),
                    'id'           => 'styling',
                    'std'          => 'none',
                    'class_select' => 'airkit_trigger-options'
                ),

                'bg-color' => array(
                    'name'  => esc_html__( 'Choose background color', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'bg-color',
                    'std'   => '#ffffff',
                    'class' => 'airkit_styling-bg-color'
                ),

                'border-color' =>  array(
                    'name'  => esc_html__( 'Choose border color', 'gowatch' ),
                    'field' => 'input_color',
                    'id'    => 'border-color',
                    'std'   => '#DDDDDD',
                    'class' => 'airkit_styling-border'
                ),

                'gutter-space' => array(
                    'name'    => esc_html__( 'Gutter space', 'gowatch' ),
                    'desc'    => esc_html__( 'Gutter space means the space between the elements (columns) that are used. Depending on the white spacing you want for your website, choose a style that fits you best', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'n' => esc_html__( 'None', 'gowatch' ),
                        '10'  => '10',
                        '20'  => '20',
                        '30'  => '30',
                        '40'  => '40',
                        '50'  => '50',
                        '60'  => '60'
                    ),
                    'id'      => 'gutter-space',
                    'std'     => '40'
                ),

                'small-posts' => array(
                    'name'    => esc_html__( 'Enable small posts', 'gowatch' ),
                    'desc'    => esc_html__( 'If this option is enabled, only the first article will have the default post view you selected. The rest will be shown below as small articles. This is used best for categories or post lists you want to create.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' )
                    ),
                    'id'    => 'small-posts',
                    'std'   => 'n',
                    'class' => 'airkit_pagination-none'
                ),

                'excerpt' => array(
                    'name'    => esc_html__( 'Show post excerpt', 'gowatch' ),
                    'desc'    => esc_html__( 'You can remove the preview text used in views if you don\'t need it or if you do not like it', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' )
                    ),
                    'id'      => 'excerpt',
                    'std'     => 'y'
                ),

                'meta' => array(
                    'name'    => esc_html__( 'Show post meta', 'gowatch' ),
                    'desc'    => esc_html__( 'You can choose to show or to hide your meta details for your articles. Meta values include date, author, categories, tags and other article details.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' )
                    ),
                    'id'       => 'meta',
                    'std'      => 'y'
                ),

                'posts-limit' => array(
                    'name'  => esc_html__( 'Posts to extract', 'gowatch' ),
                    'desc'  => esc_html__( 'This is the number of posts that will be extracted from the database and shown in total. If you use pagination, this will be the default posts number and on each new iteration this number of posts will be extracted again.', 'gowatch' ),
                    'field' => 'input',
                    'type'  => 'number',
                    'id'    => 'posts-limit',
                    'std'   => 4
                ),

                'featured' => array(
                    'name'    => esc_html__( 'Show only featured', 'gowatch' ),
                    'desc'    => esc_html__( 'The theme has a featured option available, letting you choose your featured or preferred posts. You can find that option when you check the posts list in the WordPress Dashboard.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' )
                    ),
                    'id'       => 'featured',
                    'std'      => 'n'
                ),

                'post__not_in' => array(
                    'name'  => esc_html__( 'Exclude post IDs', 'gowatch' ),
                    'desc'  => esc_html__( 'If you want to exclude some posts IDs from the query, insert the ID here, separated by commas. Eg: 1,2,3,4', 'gowatch' ),
                    'field' => 'input',
                    'type'  => 'text',
                    'id'    => 'post__not_in',
                    'std'   => ''
                ),

                'offset' => array(
                    'name'  => esc_html__( 'Exclude first posts from query', 'gowatch' ),
                    'desc'  => esc_html__( 'If you want to disable the first number of posts from a query, enter the number you want to be excluded. For example, if you have 3 articles shown above in another element and you have the same query below, but you don\'t want to have duplicates - just set this option to 3, and the first 3 will be excluded from the list', 'gowatch' ),
                    'field' => 'input',
                    'type'  => 'number',
                    'id'    => 'offset',
                    'std'   => 0
                ),

                'orderby' => array(
                    'name'    => esc_html__( 'Order posts by', 'gowatch' ),
                    'desc'    => esc_html__( 'Choose your order criteria. You can sort your articles by date, number or comments, views or likes', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'date'     => esc_html__( 'Date', 'gowatch' ),
                        'comments' => esc_html__( 'Comments', 'gowatch' ),
                        'views'    => esc_html__( 'Views', 'gowatch' ),
                        'likes'    => esc_html__( 'Likes', 'gowatch' ),
                        'rating'   => esc_html__( 'Rating', 'gowatch' ),
                    ),
                    'id'       => 'orderby',
                    'std'      => 'date'
                ),

                'order' => array(
                    'name'    => esc_html__( 'Order direction', 'gowatch' ),
                    'desc'    => esc_html__( 'Choose your order direction. You can sort your articles in an ascending or a descending way depending of the order by option above', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'ASC'  => esc_html__( 'Ascending', 'gowatch' ),
                        'DESC' => esc_html__( 'Descending', 'gowatch' )
                    ),
                    'id'       => 'order',
                    'std'      => 'DESC'
                ),

                'post-type' => array(
                    'name'    => esc_html__( 'Choose your posts type', 'gowatch' ),
                    'desc'    => esc_html__( 'Here you can choose the post type you want to showcase here. Note that you can\'t have different posts types in the same query, so only one will be shown.', 'gowatch' ),
                    'field'   => 'select',
                    'options' => array(
                        'post'       => esc_html__( 'Posts', 'gowatch' ),
                        'video'      => esc_html__( 'Videos', 'gowatch' ),
                        'ts-gallery' => esc_html__( 'Galleries', 'gowatch' ),
                        'portfolio'  => esc_html__( 'Portfolio', 'gowatch' ),
                    ),
                    'id'           => 'post-type',
                    'std'          => 'post',
                    'class_select' => 'airkit_trigger-options'
                ),

                'taxonomies' => array(
                    'name'          => esc_html__( 'Choose taxonomy', 'gowatch' ),
                    'desc'          => esc_html__( 'Here you can choose one taxonomy from all public registered taxonomies on your website.', 'gowatch' ),
                    'field'         => 'select',
                    'options'       => get_taxonomies( array( 'public' => true ) ),
                    'id'            => 'taxonomy',
                    'std'           => '',
                    'class_select'  => 'airkit_trigger-options'
                ),

                'category' => array(
                    'name'         => esc_html__( 'Choose your posts categories', 'gowatch' ),
                    'desc'         => esc_html__( 'These are the post categories you added on your website and that have at least one post assigned to them. Choose the ones you want to showcase posts from.', 'gowatch' ),
                    'field'        => 'select',
                    'options'      => wp_list_pluck( get_categories( array( 'hide_empty' => 1, 'show_option_all' => '' ) ), 'cat_name', 'slug' ),
                    'id'           => 'category',
                    'class_select' => 'ts-custom-select-input',
                    'multiple'     => true,
                    'std'          => '',
                    'class'        => 'airkit_post-type-post'
                ),

                'gallery_categories' => array(
                    'name'         => esc_html__( 'Choose your gallery categories', 'gowatch' ),
                    'desc'         => esc_html__( 'These are the gallery categories you added on your website and that have at least one post assigned to them. Choose the ones you want to showcase posts from.', 'gowatch' ),
                    'field'        => 'select',
                    'options'      => wp_list_pluck( get_categories( array( 'hide_empty' => 1, 'taxonomy' => 'gallery_categories' ) ), 'cat_name', 'slug' ),
                    'id'           => 'gallery_categories',
                    'class_select' => 'ts-custom-select-input',
                    'multiple'     => true,
                    'std'          => '',
                    'class'        => 'airkit_post-type-ts-gallery'
                ),

                'videos_categories' => array(
                    'name'         => esc_html__( 'Choose your video categories', 'gowatch' ),
                    'desc'         => esc_html__( 'These are the posts categories you added on your website and that have at least one post assigned to them. Choose the ones you want to showcase posts from.', 'gowatch' ),
                    'field'        => 'select',
                    'options'      => wp_list_pluck( get_categories( array( 'hide_empty' => 1, 'taxonomy' => 'videos_categories' ) ), 'cat_name', 'slug' ),
                    'id'           => 'videos_categories',
                    'class_select' => 'ts-custom-select-input',
                    'multiple'     => true,
                    'std'          => '',
                    'class'        => 'airkit_post-type-video'
                ),

                'portfolio_categories' => array(
                    'name'         => esc_html__( 'Choose your portfolio categories', 'gowatch' ),
                    'desc'         => esc_html__( 'These are the portfolio categories you added on your website and that have at least one post assigned to them. Choose the ones you want to showcase posts from.', 'gowatch' ),
                    'field'        => 'select',
                    'options'      => wp_list_pluck( get_categories( array( 'hide_empty' => 1, 'taxonomy' => 'portfolio-categories' ) ), 'cat_name', 'slug' ),
                    'id'           => 'portfolio-categories',
                    'class_select' => 'ts-custom-select-input',
                    'multiple'     => true,
                    'std'          => '',
                    'class'        => 'airkit_post-type-portfolio'
                ),

                'tags' => array(
                    'name'         => esc_html__( 'Narrow query by tags', 'gowatch' ),
                    'desc'         => esc_html__( 'If you want to get posts that by a tag, write them down separated by commas.', 'gowatch' ),
                    'field'        => 'input',
                    'type'         => 'text',
                    'id'           => 'tags',
                    'std'          => '',
                ),

                'reveal-effect' => array(
                    'name'         => esc_html__( 'Reveal effect', 'gowatch' ),
                    'desc'         => esc_html__( 'If you want this element to appear on the website with an effect when the elements gets in the viewport (browser visible area), choose an effect from below', 'gowatch' ),
                    'field'        => 'select',
                    'options'      => airkit_all_animations( 'effect' ),
                    'id'           => 'reveal-effect',
                    'std'          => 'none',
                    'class_select' => 'airkit_trigger-options'
                ),

                'reveal-delay' => array(
                    'name'    => esc_html__( 'Reveal effect delay', 'gowatch' ),
                    'field'   => 'select',
                    'options' => airkit_all_animations( 'delay' ),
                    'id'      => 'reveal-delay',
                    'std'     => 'delay-500',
                    'class'   => 'airkit_reveal-effect-none airkit_revert-trigger'
                ),

                'behavior' =>  array(
                    'name'    => esc_html__( 'Articles behavior', 'gowatch' ),

                    'desc'    => esc_html__( 'You can choose your articles to be shown with a specific behavior. Note that if you want a pagination, this option will not work properly and you have to disable one of them. You can set your posts to be shown in a carousel option, arrange them in a masonry (find the space) way, use a horizontal scroll option which adds a scroll bar at the bottom of the view or use category filters which will create a tabs effect', 'gowatch' ),
                    'field'   => 'img_selector',

                    'options' => array(
                        'normal'   => 'normal',
                        'carousel' => 'carousel',
                        'masonry'  => 'masonry',
                        'scroll'   => 'scroll',
                        'filters'  => 'filters'

                    ),

                    'img' => array(
                        'normal'   => 'behavior_none.png',
                        'carousel' => 'behavior_carousel.png',
                        'masonry'  => 'behavior_masonry.png',
                        'scroll'   => 'behavior_scroll.png',
                        'filters'  => 'behavior_tabs.png'
                    ),

                    'id'           => 'behavior',
                    'std'          => 'normal',
                    'class_select' => 'airkit_trigger-options'
                ),

                'carousel-nav' => array(
                    'name' => esc_html__( 'Carousel navigation type', 'gowatch'),
                    'field'   => 'select',
                    'options' => array(
                        'none'   => esc_html__( 'None', 'gowatch' ),
                        'arrows' => esc_html__( 'Arrows', 'gowatch' ),
                        'dots'   => esc_html__( 'Dots', 'gowatch' ),
                        'dots-arrows' => esc_html__( 'Dots and Arrows', 'gowatch' ),
                    ),
                    'id'       => 'carousel-nav',
                    'std'      => 'arrows',
                    'class'    => 'airkit_behavior-carousel airkit_carousel-y'
                ),

                'carousel-scroll' => array(
                    'name' => esc_html__( 'Slides to scroll', 'gowatch'),
                    'field'   => 'select',
                    'options' => array(
                        'by-col' => esc_html__( 'Column By Column', 'gowatch' ),
                        'by-row' => esc_html__( 'Full row', 'gowatch' ),
                    ),
                    'id'       => 'carousel-scroll',
                    'std'      => 'by-col',
                    'class'    => 'airkit_behavior-carousel airkit_carousel-y'
                ),
                                                
                'carousel-autoplay' => array(
                    'name' => esc_html__( 'Enable carousel autoplay', 'gowatch'),
                    'field'   => 'select',
                    'options' => array(
                        'y' => 'Yes',
                        'n' => 'No',
                    ),
                    'id'       => 'carousel-autoplay',
                    'std'      => 'n',
                    'class'    => 'airkit_behavior-carousel airkit_carousel-y'
                ),

                'enable-ads' => array(
                    'name' => esc_html__( 'Enable advertising', 'gowatch'),
                    'field'   => 'select',
                    'options' => array(
                        'y' => esc_html__( 'Yes', 'gowatch' ),
                        'n' => esc_html__( 'No', 'gowatch' ),
                    ),
                    'id'       => 'enable-ads',
                    'std'      => 'n',
                    'class_select'    => 'airkit_trigger-options'                    
                ),

                'ads-step' => array(
                    'name'  => esc_html__( 'Advertising step', 'gowatch'),
                    'desc'  => esc_html__( 'Show advertising instead of each this number post:', 'gowatch' ),
                    'id'    => 'ads-step',
                    'field' => 'slider_drag',
                    'min'   => 2,
                    'max'   => 20,
                    'step'  => 1,
                    'std'   => 4,
                    'class' => 'airkit_enable-ads-y'                    
                ),
        
            );
        }

        return self::$repeat_set[ $pull ];
    }

    static function row()
    {

        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Row ID', 'gowatch' ),
                        'desc'  => esc_html__( 'You can set a specific ID to this row. This can be used to style elements or to create anchor links.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'name',
                        'std'   => ''
                    ),

                    array(
                        'name'    => esc_html__( 'Set columns to equal heights', 'gowatch' ),
                        'desc'    => esc_html__( 'If enabled this option will find the biggest column (in height) and set all the other columns inside this row to have the same height.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'equal-height',
                        'std'      => 'n'
                    ),

                    array(
                        'name'    => esc_html__( 'Row content vertical align', 'gowatch' ),
                        'desc'    => esc_html__( 'If your elements have different heights and you want to center them vertically inside this row, you can enable this option. Note that this is an experimental option, might conflict with some plugins/layouts', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'top'    => esc_html__( 'Top', 'gowatch' ),
                            'middle' => esc_html__( 'Middle', 'gowatch' ),
                            'bottom' => esc_html__( 'Bottom', 'gowatch' ),
                        ),
                        'id'      => 'vertical-align',
                        'std'     => 'top'
                    ),

                    array(
                        'name'    => esc_html__( 'Make row sticky (fixed)', 'gowatch' ),
                        'desc'    => esc_html__( 'If enabled, it will fix the row at the top of the browser window after you scroll below it. Very useful to create sticky headers with menus and logos inside it. Note that only one sticky row can be used per page.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'      => 'sticky',
                        'std'     => 'n',
                        'class_select' => 'airkit_trigger-options',
                    ),

                    array(
                        'name'    => esc_html__( 'Enable Smart Sticky behavior', 'gowatch' ),
                        'desc'    => esc_html__( 'If enabled, row will have Smart Sticky behavior, which means hiding the element automatically when a user starts scrolling down the page and bringing it back when a user scrolls up.', 'gowatch' ),                        
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'      => 'smart-sticky',
                        'std'     => 'n',
                        'class'   => 'airkit_sticky-y',
                    ),

                    array(
                        'name'    => esc_html__( 'Expand row content', 'gowatch' ),
                        'desc'    => esc_html__( 'If enabled all the content inside will go from one edge of the screen to another. If you are using the boxed layout it will only extend to the box edges', 'gowatch' ),
                        'field'   => 'img_selector',
                        'options' => array(
                            'n' => esc_html__( 'No', 'gowatch' ),
                            'y' => esc_html__( 'Yes', 'gowatch' ),                         
                        ),
                        'img' => array(
                            'n' => 'expand_row_no.png',
                            'y' => 'expand_row_yes.png',
                            
                        ),
                        'id'       => 'expand',
                        'std'      => 'n'
                    ),

                    array(
                        'name'    => esc_html__( 'Make row fullscreen', 'gowatch' ),
                        'desc'    => esc_html__( 'If enabled, this will make this row to have the height of the browser window. Once you set it to fullscreen it will resize the row so that it fits the screen of the user. This will not expand your content horizontally though', 'gowatch' ),
                        'field'   => 'img_selector',
                        'options' => array(
                            'n' => esc_html__( 'No', 'gowatch' ),
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                        ),
                        'img' => array(
                            'n' => 'fullscreen_row_no.png',
                            'y' => 'fullscreen_row_yes.png',
                        ),
                        'id'  => 'fullscreen',
                        'std' => 'n'
                    ),

                    array(
                        'name'    => esc_html__( 'Add a box shadow', 'gowatch' ),
                        'desc'    => esc_html__( 'If you enable this option, it will add a subtle box shadow inside the row edges', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'      => 'box-shadow',
                        'std'     => 'n'
                    ),

                    array(
                        'name'    => esc_html__( 'Convert row columns to carousel', 'gowatch' ),
                        'desc'    => esc_html__( 'All columns you add will be converted to a full row and each column will represent a carousel item', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'      => 'carousel',
                        'std'     => 'n',
                        'class_select' => 'airkit_trigger-options',
                    ),

                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-scroll' ),
                    self::get_setting( 'carousel-autoplay' ),                     


                    array(
                        'name'    => esc_html__( 'Add scroll down button', 'gowatch' ),
                        'desc'    => esc_html__( 'This will add a small buttom at the bottom of the row that will show the users to scroll down and once clicked, it will scroll the browser window just below the row bottom edge', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'      => 'scroll-button',
                        'std'     => 'n'
                    ),

                    array(
                        'name'         => esc_html__( 'Reveal effect', 'gowatch' ),
                        'desc'         => esc_html__( 'If you want this row to appear on the website with an effect when the elements gets in the viewport (browser visible area), choose an effect from below', 'gowatch' ),
                        'field'        => 'select',
                        'options'      => airkit_all_animations( 'effect' ),
                        'id'           => 'reveal-effect',
                        'std'          => 'none',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'    => esc_html__( 'Reveal delay', 'gowatch' ),
                        'field'   => 'select',
                        'options' => airkit_all_animations( 'delay' ),
                        'id'      => 'reveal-delay',
                        'std'     => 'delay-500',
                        'class'   => 'airkit_reveal-effect-none airkit_revert-trigger'
                    ),

                    array(
                        'name'  => esc_html__( 'Custom CSS', 'gowatch' ),
                        'desc'  => esc_html__( 'The code you insert below will be added to the row\'s style attribute. You do not need to add any style tags, only the CSS attributes', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'custom-css',
                        'std'   => ''
                    )
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    self::get_setting( 'text-align' ),


                    array(
                        'name'  => esc_html__( 'Choose row background color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'bg-color',
                        'std'   => 'rgba(255, 255, 255, 0)'
                    ),


                    self::get_setting( 'margin-top' ),
                    self::get_setting( 'margin-bottom' ),

                    self::get_setting( 'padding-top' ),
                    self::get_setting( 'padding-bottom' ),

                    self::get_setting( 'bg-video-mp' ),
                    self::get_setting( 'bg-video-webm' ),

                    self::get_setting( 'bg-img' ),
                    self::get_setting( 'bg-x' ),
                    self::get_setting( 'bg-y' ),
                    self::get_setting( 'bg-attachement' ),
                    self::get_setting( 'bg-repeat' ),
                    self::get_setting( 'bg-size' ),
                    self::get_setting( 'parallax' ),


                    array(
                          'name'    => esc_html__( 'Enable background parallax elements', 'gowatch' ),
                          'nadescme'    => esc_html__( 'If enabled it will let add multiple elements (images) as background and animate them with an amazing parallax effect.', 'gowatch' ),
                          'field' => 'select',
                          'options' => array(
                              'y' => esc_html__( 'Yes', 'gowatch' ),
                              'n' => esc_html__( 'No', 'gowatch' )
                          ),
                          'id'      => 'parallax-images',
                          'std'     => 'n',
                          'class_select'   => 'airkit_trigger-options'
                    ),


                    array(
                        'name'     => esc_html__( 'Add parallax image', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'parallax-images-items',
                        'sortable' => 'true',
                        'class'    => 'airkit_parallax-images-y',
                        'std'      => array(),
                        'options'  => array(

                            array(
                                'name'       => esc_html__( 'Select your parallax image', 'gowatch' ),
                                'field'      => 'upload',
                                'media-type' => 'image',
                                'multiple'   => 'false',
                                'id'         => 'image',
                                'std'        => '',
                            ),

                            array(
                                'name'  => esc_html__( 'Position X', 'gowatch' ),
                                'field' => 'input',
                                'desc'  => 'Insert your position of item from the left of the row, including the measurement system. Ex: 100px',
                                'type'  => 'text',
                                'id'    => 'parallax-position-x',
                                'std'   => 0
                            ),

                            array(
                                'name'  => esc_html__( 'Position Y', 'gowatch' ),
                                'field' => 'input',
                                'desc'  => 'Insert your position of item from the top of the row, including the measurement system. Ex: 100px',
                                'type'  => 'text',
                                'id'    => 'parallax-position-y',
                                'std'   => 0
                            ),

                            array(
                                'name'  => esc_html__( 'Animation direction', 'gowatch' ),
                                'field' => 'select',
                                'options' => array(
                                    'vertical'   => esc_html__( 'Vertical', 'gowatch' ),
                                    'horizontal' => esc_html__( 'Horizontal', 'gowatch' )
                                ),
                                'id'    => 'parallax-direction',
                                'std'   => 'vertical'
                            ),

                            array(
                                'name'  => esc_html__( 'Parallax speed', 'gowatch' ),
                                'field' => 'input',
                                'desc'  => 'Insert your speed ratio for making the parallax effect. Recommended use: -3 to 3. Ex: 2.1 or -1.1',
                                'type'  => 'text',
                                'id'    => 'parallax-speed',
                                'std'   => 1.5
                            ),

                        )
                    ),

                    array(
                          'name'    => esc_html__( 'Enable background slider', 'gowatch' ),
                          'nadescme'    => esc_html__( 'If enabled it will let you create a slider with custom slides and captions that will be set as background for the elements you add in this row.', 'gowatch' ),
                          'field' => 'select',
                          'options' => array(
                              'y' => esc_html__( 'Yes', 'gowatch' ),
                              'n' => esc_html__( 'No', 'gowatch' )
                          ),
                          'id'      => 'slider-bg',
                          'std'     => 'n',
                          'class_select'   => 'airkit_trigger-options'
                    ),

                    array(
                        'name' => esc_html__( 'Slider navigation type', 'gowatch'),
                        'field'   => 'select',
                        'options' => array(
                            'none'   => esc_html__( 'None', 'gowatch' ),
                            'arrows' => esc_html__( 'Arrows', 'gowatch' ),
                            'dots'   => esc_html__( 'Dots', 'gowatch' ),
                            'dots-arrows' => esc_html__( 'Dots and Arrows', 'gowatch' ),
                        ),
                        'id'       => 'slider-nav',
                        'std'      => 'arrows',
                        'class'    => 'airkit_slider-bg-y'
                    ),
                          
                    array(
                        'name' => esc_html__( 'Enable Autoplay for slider', 'gowatch'),
                        'field'   => 'select',
                        'options' => array(
                            'y' => 'Yes',
                            'n' => 'No',
                        ),
                        'id'       => 'slider-autoplay',
                        'std'      => 'n',
                        'class'    => 'airkit_slider-bg-y'
                    ),                 

                    array(
                        'name'     => esc_html__( 'Add new item', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'class'    => 'airkit_slider-bg-y',
                        'std'      => array(),
                        'options'  => array(

                            array(
                                'name'       => esc_html__( 'Slide image', 'gowatch' ),
                                'field'      => 'upload',
                                'media-type' => 'image',
                                'multiple'   => 'false',
                                'id'         => 'image',
                                'std'        => '',
                            ),

                            array(
                                'name'  => esc_html__( 'Add title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add your caption here', 'gowatch' ),
                                'field' => 'textarea',
                                'id'    => 'text',
                                'std'   => ''
                            ),

                            self::get_setting( 'text-align' ),
                            self::get_setting( 'text-color' ),

                            array(
                                'name'  => esc_html__( 'Button 1 Text', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'button1',
                                'std'   => ''
                            ),
                            array(
                                'name'  => esc_html__( 'Button 1 redirect URL', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'url1',
                                'std'   => ''
                            ),
                            array(
                                'name'  => esc_html__( 'Button 2 Text', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'button2',
                                'std'   => ''
                            ),
                            array(
                                'name'  => esc_html__( 'Button 2 redirect URL', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'url2',
                                'std'   => ''
                            ),
                            array(
                                'name'  => esc_html__( 'Buttons border/background color', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'button-bg-color',
                                'std'   => 'rgba(255, 255, 255, 1)'
                            ),
                            array(
                                'name'  => esc_html__( 'Background button text color', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'button-text-color',
                                'std'   => 'rgba(0, 0, 0, 1)'
                            ),
                        )
                    ),

                    self::get_setting( 'mask' ),
                    self::get_setting( 'mask-color' ),
                    self::get_setting( 'mask-gradient-color' ),
                    self::get_setting( 'gradient-type' ),

                    self::get_setting( 'border-top' ),
                    self::get_setting( 'border-top-width' ),
                    self::get_setting( 'border-top-color' ),

                    self::get_setting( 'border-bottom' ),
                    self::get_setting( 'border-bottom-width' ),
                    self::get_setting( 'border-bottom-color' ),                 

                    self::get_setting( 'border-left' ),
                    self::get_setting( 'border-left-width' ),
                    self::get_setting( 'border-left-color' ),

                    self::get_setting( 'border-right' ),
                    self::get_setting( 'border-right-width' ),
                    self::get_setting( 'border-right-color' ),

                )
            )
        );
    }

    static function column()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Column ID', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'name',
                        'std'   => ''
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'size',
                        'std'   => 12,
                    ),

                    array(
                        'name'         => esc_html__( 'Reveal effect', 'gowatch' ),
                        'field'        => 'select',
                        'options'      => airkit_all_animations( 'effect' ),
                        'id'           => 'reveal-effect',
                        'std'          => 'none',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'    => esc_html__( 'Reveal delay', 'gowatch' ),
                        'field'   => 'select',
                        'options' => airkit_all_animations( 'delay' ),
                        'id'      => 'reveal-delay',
                        'std'     => 'delay-500',
                        'class'   => 'airkit_reveal-effect-none airkit_revert-trigger'
                    ),

                    array(
                        'name'  => esc_html__( 'Column width on tablet landscape', 'gowatch' ),
                        'desc'  => esc_html__( 'You can set different column widths on different screen sizes.', 'gowatch' ),
                        'field' => 'slider_drag',
                        'id'    => 'columns-medium',
                        'min'   => 2,
                        'max'   => 12,
                        'step'  => 1,
                        'std'   => 12,
                    ),                 

                    array(
                        'name'  => esc_html__( 'Column width on tablet portrait', 'gowatch' ),
                        'desc'  => esc_html__( 'You can set different column widths on different screen sizes.', 'gowatch' ),
                        'field' => 'slider_drag',
                        'min'   => 2,
                        'max'   => 12,
                        'step'  => 1,
                        'id'    => 'columns-small',
                        'std'   => 12,
                    ),

                    array(
                        'name'  => esc_html__( 'Column width on mobile portrait', 'gowatch' ),
                        'desc'  => esc_html__( 'You can set different column widths on different screen sizes.', 'gowatch' ),
                        'field' => 'slider_drag',
                        'id'    => 'columns-xsmall',
                        'min'   => 2,
                        'max'   => 12,
                        'step'  => 1,
                        'std'   => 12,
                    ),
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    self::get_setting( 'text-color' ),

                    array(
                        'name'  => esc_html__( 'Choose background color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'bg-color',
                        'std'   => 'rgba(255, 255, 255, 0)'
                    ),

                    self::get_setting( 'text-align' ),

                    self::get_setting( 'bg-video-mp' ),
                    self::get_setting( 'bg-video-webm' ),

                    self::get_setting( 'bg-img' ),
                    self::get_setting( 'bg-x' ),
                    self::get_setting( 'bg-y' ),
                    self::get_setting( 'bg-attachement' ),
                    self::get_setting( 'bg-repeat' ),
                    self::get_setting( 'bg-size' ),
                    self::get_setting( 'parallax' ),

                    self::get_setting( 'mask' ),
                    self::get_setting( 'mask-color' ),
                    self::get_setting( 'mask-gradient-color' ),
                    self::get_setting( 'gradient-type' ),

                    self::get_setting( 'border-top' ),
                    self::get_setting( 'border-top-width' ),
                    self::get_setting( 'border-top-color' ),

                    self::get_setting( 'border-bottom' ),
                    self::get_setting( 'border-bottom-width' ),
                    self::get_setting( 'border-bottom-color' ),

                    self::get_setting( 'border-left' ),
                    self::get_setting( 'border-left-width' ),
                    self::get_setting( 'border-left-color' ),

                    self::get_setting( 'border-right' ),
                    self::get_setting( 'border-right-width' ),
                    self::get_setting( 'border-right-color' ),             

                    self::get_setting( 'margin-top' ),
                    self::get_setting( 'margin-bottom' ),

                    self::get_setting( 'padding-top' ),
                    self::get_setting( 'padding-bottom' ),
                    self::get_setting( 'padding-left' ),
                    self::get_setting( 'padding-right' ),

                    array(
                        'name'  => esc_html__( 'Gutter right', 'gowatch' ),
                        'desc'  => esc_html__( 'Columns have a default spacing to the right and left side of 20px. You can modify it to anything you need. (Not to be mistaked as padding, that is additional spacing)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'gutter-right',
                        'std'   => 20
                    ),

                    array(
                        'name'  => esc_html__( 'Gutter left', 'gowatch' ),
                        'desc'  => esc_html__( 'Columns have a default spacing to the right and left side of 20px. You can modify it to anything you need. (Not to be mistaked as padding, that is additional spacing)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'gutter-left',
                        'std'   => 20
                    ),

                    array(
                        'name'  => esc_html__( 'Custom CSS', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'custom-css',
                        'std'   => ''
                    )
                )
            )
        );
    }

    static function menu()
    {

        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Menu', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-menu'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose your menu', 'gowatch' ),
                        'field'   => 'select',
                        'options' => wp_list_pluck( wp_get_nav_menus(), 'name', 'slug' ),
                        'id'      => 'menu-id',
                        'std'     => ''
                    ),
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    array(
                        'name'    => esc_html__( 'Choose menu style', 'gowatch' ),
                        'desc'    => esc_html__( 'The theme has different menu styles available for you to choose from. Make sure the containers you add them into have enough space.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'horizontal' => esc_html__( 'Horizontal menu', 'gowatch' ),
                            'vertical'   => esc_html__( 'Vertical menu', 'gowatch' ),
                            'fullscreen' => esc_html__( 'Fullscreen menu', 'gowatch' ),
                            'logo'       => esc_html__( 'Menu with logo in the middle', 'gowatch' ),
                            'sidebar'    => esc_html__( 'Sidebar menu', 'gowatch' ),
                        ),
                        'id'           => 'styles',
                        'class_select' => 'airkit_trigger-options',
                        'std'          => 'horizontal',
                    ),

                    array(
                        'name'    => esc_html__( 'Show Submenu decoration', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y'     => esc_html__( 'Yes', 'gowatch' ),
                            'n'     => esc_html__( 'No', 'gowatch' ),
                        ),
                        'id'      => 'submenu-decoration',
                        'std'     => 'n',
                    ),

                    array(
                        'name'    => esc_html__( 'Show Menu label for toggle', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y'     => esc_html__( 'Yes', 'gowatch' ),
                            'n'     => esc_html__( 'No', 'gowatch' ),
                        ),
                        'id'           => 'label',
                        'class_select' => 'airkit_trigger-options',
                        'std'          => 'n',
                        'class'    => 'airkit_styles-fullscreen airkit_styles-sidebar',
                    ),

                    array(
                        'name'    => esc_html__( 'Upload custom logo', 'gowatch' ),
                        'field'      => 'upload',
                        'media-type' => 'image',
                        'multiple'   => 'false',
                        'id'         => 'custom-logo',
                        'class'    => 'airkit_styles-logo',
                    ),

                    array(
                        'name'    => esc_html__( 'Choose text font option', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'std'     => esc_html__( 'Standard font', 'gowatch' ),
                            'google'  => esc_html__( 'Google fonts', 'gowatch' )
                        ),
                        'id'           => 'font-type',
                        'std'          => 'std',
                        'class_select' => 'airkit_trigger-options',
                    ),

                    array(
                        'name'  => esc_html__( 'Choose the text options', 'gowatch' ),
                        'field' => 'typography',
                        'id'    => 'font',
                        'std'   => array(
                            'family'    => 'Open Sans',
                            'weight'    => 'normal',
                            'size'      => 14,
                            'style'     => 'normal',
                            'letter'    => 0,
                            'line'      => 'inherit',
                            'decor'     => 'none',
                            'transform' => 'none'
                        ),
                        'class' => 'airkit_styles-logo airkit_font-type-google'
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'custom-colors',
                        'std'   => 'y'
                    ),

                    // Menu Colors
                    array(
                        'name'  => esc_html__( 'Menu background color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'bg-color',
                        'std'   => 'rgba(255, 255, 255, 0)',
                        'class' => 'airkit_custom-colors-y'
                    ),

                    array(
                        'name'  => esc_html__( 'Menu background color on hover', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'bg-color-hover',
                        'std'   => 'rgba(255, 255, 255, 0)',
                        'class' => 'airkit_custom-colors-y'
                    ),

                    array(
                        'name'  => esc_html__( 'Menu text color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'text-color',
                        'std'   => '#000000',
                        'class' => 'airkit_custom-colors-y'
                    ),

                    array(
                        'name'  => esc_html__( 'Menu text color on hover', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'text-color-hover',
                        'std'   => '#000000',
                        'class' => 'airkit_custom-colors-y'
                    ),

                    array(
                        'name'  => esc_html__( 'Submenu background color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'submenu-bg-color',
                        'std'   => '#ffffff',
                        'class' => 'airkit_custom-colors-y'
                    ),

                    array(
                        'name'  => esc_html__( 'Submenu background color on hover', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'submenu-bg-color-hover',
                        'std'   => '#f8f8f8',
                        'class' => 'airkit_custom-colors-y'
                    ),

                    array(
                        'name'  => esc_html__( 'Submenu text color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'submenu-text-color',
                        'std'   => '#000000',
                        'class' => 'airkit_custom-colors-y'
                    ),

                    array(
                        'name'  => esc_html__( 'Submenu text color on hover', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'submenu-text-color-hover',
                        'std'   => '#000000',
                        'class' => 'airkit_custom-colors-y'
                    ),
                    //colors end.

                    self::get_setting( 'text-align' ),

                    array(
                        'name'    => esc_html__( 'Show icons in this menu', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'      => 'icons',
                        'std'     => 'y'
                    ),
                    array(
                        'name'    => esc_html__( 'Submenu alignment', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'center' => esc_html__( 'Center', 'gowatch' ),
                            'left'   => esc_html__( 'Left', 'gowatch' )
                        ),
                        'id'      => 'submenu-alignment',
                        'std'     => 'center'
                    ),

                    array(
                        'name'    => esc_html__( 'Show description in this menu', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'      => 'description',
                        'std'     => 'y'
                    ),


                    array(
                        'name' => esc_html__( 'Add logo to menu', 'gowatch' ),
                        'desc'  => esc_html__( 'If this option is set to yes, an logo element will be added to this menu', 'gowatch' ),
                        'field' => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'add-logo',
                        'std'      => 'n',
                        'class_select' => 'airkit_trigger-options',
                    ),

                    array(
                        'name' => esc_html__( 'Where would you like to add logo element ?', 'gowatch' ),
                        'desc'  => esc_html__( 'You may add selected element before or after the menu.', 'gowatch' ),
                        'field' => 'select',
                        'options' => array(
                            'prepend' => esc_html__( 'Before menu', 'gowatch' ),
                            'append'  => esc_html__( 'After menu', 'gowatch' )
                        ),
                        'id'       => 'append-logo',
                        'std'      => 'prepend',
                        'class' => 'airkit_add-logo-y',                     
                    ),

                    array(
                        'name' => esc_html__( 'Add search element to menu', 'gowatch' ),
                        'desc'  => esc_html__( 'If this option is set to yes, an search element will be added to this menu', 'gowatch' ),
                        'field' => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'add-search',
                        'std'      => 'n',
                        'class_select' => 'airkit_trigger-options',                     
                    ),

                    array(
                        'name' => esc_html__( 'Where would you like to add Search element ?', 'gowatch' ),
                        'desc'  => esc_html__( 'You may add selected element before or after the menu.', 'gowatch' ),
                        'field' => 'select',
                        'options' => array(
                            'prepend' => esc_html__( 'Before menu', 'gowatch' ),
                            'append'  => esc_html__( 'After menu', 'gowatch' )
                        ),
                        'id'       => 'append-search',
                        'std'      => 'prepend',
                        'class' => 'airkit_add-search-y',                     
                    ),

                    /*
                     * Must check if WooCommerce class exists.
                     */
                    ( class_exists('WooCommerce') ? 
                            array(
                                'name' => esc_html__( 'Add WooCommerce cart to menu', 'gowatch' ),
                                'desc'  => esc_html__( 'If this option is set to yes, WooCommerce cart will be added to this menu', 'gowatch' ),
                                'field' => 'select',
                                'options' => array(
                                    'y' => esc_html__( 'Yes', 'gowatch' ),
                                    'n' => esc_html__( 'No', 'gowatch' )
                                ),
                                'id'       => 'add-cart',
                                'std'      => 'n',
                                'class_select' => 'airkit_trigger-options',                     
                            )

                        : false
                    ),  

                    ( class_exists('WooCommerce') ? 

                        array(
                            'name' => esc_html__( 'Where would you like to add Cart element ?', 'gowatch' ),
                            'desc'  => esc_html__( 'You may add selected element before or after the menu.', 'gowatch' ),
                            'field' => 'select',
                            'options' => array(
                                'prepend' => esc_html__( 'Before menu', 'gowatch' ),
                                'append'  => esc_html__( 'After menu', 'gowatch' )
                            ),
                            'id'       => 'append-cart',
                            'std'      => 'prepend',
                            'class' => 'airkit_add-cart-y',                     
                        )

                        : false
                    ),

                )
            )
        );
    }

    static function logo()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Logo', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-logo'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose logo alignment', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'text-left'   => esc_html__( 'Left', 'gowatch' ),
                            'text-center' => esc_html__( 'Center', 'gowatch' ),
                            'text-right'  => esc_html__( 'Right', 'gowatch' )
                        ),
                        'id'      => 'align',
                        'std'     => 'text-left'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                    
                )
            )
        );
    }

    static function user()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'User element', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-user'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose alignment for user element', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'text-left'   => esc_html__( 'Left', 'gowatch' ),
                            'text-right'  => esc_html__( 'Right', 'gowatch' ),
                            'text-center' => esc_html__( 'Center', 'gowatch' )
                        ),
                        'id'      => 'align',
                        'std'     => 'text-left'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                    
                )
            )
        );
    }

    static function social_buttons()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Social buttons', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-social'
                    ),

                    self::get_setting( 'text-align' ),

                    array(
                        'name'    => esc_html__( 'Social buttons style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'background' => esc_html__( 'Small, with background colors', 'gowatch' ),
                            'bordered'   => esc_html__( 'Big, with border', 'gowatch' ),
                            'iconed'     => esc_html__( 'Icons only', 'gowatch' ),
                        ),
                        'id'      => 'style',
                        'std'     => 'background',
                    ),

                    array(
                        'name'    => esc_html__( 'Show social button labels', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'      => 'labels',
                        'std'     => 'n',
                    ),


                    array(
                        'name'    => esc_html__( 'Show RSS Button', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'      => 'rss',
                        'std'     => 'y',
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                    
                )
            )
        );
    }

    static function searchbox()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Search box', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-search'
                    ),

                    array(
                       'name'    => esc_html__( 'Choose search element style', 'gowatch' ),
                       'field'   => 'select',
                       'options' => array(
                           'icon'   => esc_html__( 'Icon', 'gowatch' ),
                           'input'  => esc_html__( 'Input field', 'gowatch' ),
                       ),
                       'id'      => 'style',
                       'std'     => 'icon'
                    ),

                    array(
                       'name'    => esc_html__( 'Enable Live search results?', 'gowatch' ),
                       'field'   => 'select',
                       'options' => array(
                           'y'   => esc_html__( 'Yes', 'gowatch' ),
                           'n'  => esc_html__( 'No', 'gowatch' ),
                       ),
                       'id'      => 'live_results',
                       'std'     => 'y'
                    ),

                    array(
                       'name'    => esc_html__( 'Choose search element alignment', 'gowatch' ),
                       'field'   => 'select',
                       'options' => array(
                           'left'   => esc_html__( 'Left', 'gowatch' ),
                           'right'  => esc_html__( 'Right', 'gowatch' ),
                           'center' => esc_html__( 'Center', 'gowatch' )
                       ),
                       'id'      => 'align',
                       'std'     => 'text-left'
                   )
                )
            )
        );
    }

    static function clients()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Clients block', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-clients'
                    ),

                    self::get_setting( 'per-row' ),

                    self::get_setting( 'carousel' ),
                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-autoplay' ),                

                    array(
                        'name'     => esc_html__( 'Add new item', 'gowatch' ),
                        'field'    => 'tmpl',
                        'options'  => array(

                            array(
                                'name'  => esc_html__( 'Title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'       => esc_html__( 'Set a client image', 'gowatch' ),
                                'field'      => 'upload',
                                'media-type' => 'image',
                                'multiple'   => 'false',
                                'id'         => 'image',
                                'std'        => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Enter client URL here', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'url',
                                'std'   => ''
                            ),

                            self::get_setting( 'reveal-effect' ),
                            self::get_setting( 'reveal-delay' ),                          
                        ),
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array()
                    )
                )
            )
        );
    }

    static function features_block()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Icon box', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-featured-area'
                    ),

                    self::get_setting( 'per-row' ),

                    array(
                        'name'    => esc_html__( 'Enable gutter (spacing) between icon boxes', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'gutter',
                        'std'      => 'y'
                    ),

                    array(
                        'name'     => esc_html__( 'Add new item', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array(),
                        'options'  => array(

                            array(
                                'name'  => esc_html__( 'Item title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            self::get_setting( 'icon' ),
                            self::get_setting( 'icon-color' ),

                            array(
                                'name'  => esc_html__( 'Title color', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'title-color',
                                'std'   => 'rgba(0,0,0,1)',
                                'desc'  => esc_html__( 'Choose color for the title inside icon box', 'gowatch' ),
                            ),

                            array(
                                'name'  => esc_html__( 'Text color', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'text-color',
                                'std'   => 'rgba(0,0,0,0.8)',
                                'desc'  => esc_html__( 'Choose color for the text inside icon box', 'gowatch' ),
                            ),

                            self::get_setting( 'bg-color' ),

                            array(
                                'name'  => esc_html__( 'Text color on hover', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'text-color-hover',
                                'std'   => 'rgba(255,255,255,1)',
                                'desc'  => esc_html__( 'Choose color for the text on icon box hover', 'gowatch' ),
                            ),

                            array(
                                'name'  => esc_html__( 'Add your text here', 'gowatch' ),
                                'field' => 'textarea',
                                'id'    => 'text',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add your URL here', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'url',
                                'std'   => ''
                            ),

                            self::get_setting( 'reveal-effect' ),
                            self::get_setting( 'reveal-delay' )
                        )
                    )
                )
            )
        );
    }

    static function listed_features()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Listed features', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-list'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose icon alignment', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'above-title'  => esc_html__( 'Above title', 'gowatch' ),
                            'text-left'  => esc_html__( 'Left', 'gowatch' ),
                            'text-right' => esc_html__( 'Right', 'gowatch' )
                        ),
                        'id'       => 'align',
                        'std'      => 'text-left'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose styling option', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'none'       => esc_html__( 'None', 'gowatch' ),
                            'border'     => esc_html__( 'Border', 'gowatch' ),
                            'background' => esc_html__( 'Background', 'gowatch' )
                        ),
                        'id'           => 'color-style',
                        'std'          => 'none',
                        'class_select' => 'airkit_trigger-options'
                    ),               

                    array(
                        'name'     => esc_html__( 'Add new item', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array(),
                        'options'  => array(

                            self::get_setting( 'icon' ),
                            self::get_setting( 'icon-color' ),

                            array(
                                'name'  => esc_html__( 'Add title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add title URL here', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'url',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add your text here', 'gowatch' ),
                                'field' => 'textarea',
                                'id'    => 'text',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Border color', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'border-color',
                                'std'   => '#DDDDDD',
                                'class' => 'airkit_color-style-border',
                            ),                 

                            array(
                                'name'  => esc_html__( 'Background color', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'bg-color',
                                'std'   => '#ffffff',
                                'class' => 'airkit_color-style-background',
                            ), 

                            array(
                                'name'         => esc_html__( 'Reveal effect', 'gowatch' ),
                                'field'        => 'select',
                                'options'      => airkit_all_animations( 'effect' ),
                                'id'           => 'reveal-effect',
                                'std'          => 'none',
                                'class_select' => 'airkit_trigger-options'
                            ),

                            array(
                                'name'    => esc_html__( 'Reveal delay', 'gowatch' ),
                                'field'   => 'select',
                                'options' => airkit_all_animations( 'delay' ),
                                'id'      => 'reveal-delay',
                                'std'     => 'delay-500',
                                'class'   => 'airkit_reveal-effect-none airkit_revert-trigger'
                            )
                        )
                    )
                )
            )
        );
    }

    static function icon()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Icon', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-tick'
                    ),

                    self::get_setting( 'icon' ),
                    self::get_setting( 'icon-color' ),

                    array(
                        'name'  => esc_html__( 'Set an icon size in pixels', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'icon-size',
                        'std'   => 25
                    ),

                    array(
                        'name'    => esc_html__( 'Choose your icon align', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'left'   => esc_html__( 'Left', 'gowatch' ),
                            'center' => esc_html__( 'Center', 'gowatch' ),
                            'right'  => esc_html__( 'Right', 'gowatch' )
                        ),
                        'id'      => 'icon-align',
                        'std'     => 'left'
                    ),
                    
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                    
                )
            )
        );
    }

    static function sidebar()
    {

        $main = array( 'main' => esc_html__( 'Main Sidebar', 'gowatch' ), 'footer1' => esc_html__( 'Footer 1', 'gowatch' ), 'footer2' => esc_html__( 'Footer 2', 'gowatch' ), 'footer3' => esc_html__( 'Footer 3', 'gowatch' ), 'footer4' => esc_html__( 'Footer 4', 'gowatch' ) );

        $sidebars = get_option( 'gowatch_sidebars', array() );

        $sidebars = array_merge( $main, $sidebars );

        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Sidebar', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-sidebar'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose sidebar', 'gowatch' ),
                        'field'   => 'select',
                        'options' => $sidebars,
                        'id'      => 'sidebar-id',
                        'std'     => 'main'
                    ),

                    array(
                        'name'    => esc_html__( 'Make sidebar sticky within container', 'gowatch' ),
                        'desc'    => esc_html__( 'This will only work properly if within new row, with only a full row columns. If you place columns above or below, there might be errors on stick.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'      => 'sidebar-sticky',
                        'std'     => 'n'
                    )
                )
            )
        );
    }

    static function testimonials()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Testimonials', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-comments',
                    ),

                    self::get_setting( 'per-row' ),

                    self::get_setting( 'carousel' ),
                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-scroll' ),
                    self::get_setting( 'carousel-autoplay' ),                 

                    array(
                        'name' => esc_html__( 'Choose testimonials block style', 'gowatch' ),
                        'field' => 'select',
                        'options' => array(
                            'no-image'    => esc_html__( 'No image', 'gowatch' ),
                            'image-above' => esc_html__( 'Image above content', 'gowatch' ),
                            'image-left'  => esc_html__( 'Image to the left of content', 'gowatch' ),
                            'image-below' => esc_html__( 'Image below content', 'gowatch' ),
                        ),
                        'id'       => 'style',
                        'std'      => 'image-above',
                        'class_select' => 'airkit_trigger-options',
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                  

                    array(
                        'name'     => esc_html__( 'Add new testimonial', 'gowatch' ),
                        'field'    => 'tmpl',
                        'options'  => array(

                            array(
                                'name'       => esc_html__( 'User image', 'gowatch' ),
                                'field'      => 'upload',
                                'media-type' => 'image',
                                'multiple'   => 'false',
                                'id'         => 'image',
                                'std'        => '',
                                'class'      => 'airkit_style-no-image airkit_revert-trigger'
                            ),

                            array(
                                'name'  => esc_html__( 'Add your text here', 'gowatch' ),
                                'field' => 'textarea',
                                'id'    => 'text',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add person name', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'name',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add company name', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'company',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add your URL here', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'url',
                                'std'   => ''
                            ),
                        ),
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array()
                    )
                )
            ),
        );
    }

    static function callaction()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Call to action', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-direction'
                    ),

                    array(
                        'name'  => esc_html__( 'Call to action Text', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'text',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Button Text', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'button-text',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Button Link', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'link',
                        'std'   => ''
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                  
                )
            )
        );
    }

    static function advertising()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Advertising element', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-money'
                    ),

                    array(
                        'name'  => esc_html__( 'Insert your advertising code in the textarea below', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'advertising',
                        'std'   => ''
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                     
                )
            )
        );
    }

    static function delimiter()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Delimiter', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-delimiter'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose delimiter style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'dotsslash'         => esc_html__( 'Dotsslash', 'gowatch' ),
                            'doubleline'        => esc_html__( 'Double line', 'gowatch' ),
                            'lines'             => esc_html__( 'Lines', 'gowatch' ),
                            'squares'           => esc_html__( 'Squares', 'gowatch' ),
                            'line'              => esc_html__( 'Line', 'gowatch' ),
                            'gradient'          => esc_html__( 'Gradient', 'gowatch' ),
                            'iconed icon-close' => esc_html__( 'Line with cross', 'gowatch' ),
                            'small-line'        => esc_html__( 'Small 100px line', 'gowatch' ),
                        ),
                        'id'     => 'type',
                        'std'    => 'doubleline'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose delimiter color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'color',
                        'std'   => '#FFFFFF'
                    )
                )
            )
        );
    }

    static function title()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Title', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-font'
                    ),

                    self::get_setting( 'icon' ),

                    array(
                        'name'  => esc_html__( 'Title', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'title',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Subtitle', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'subtitle',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Link', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'link',
                        'std'   => ''
                    ),

                    self::get_setting( 'target' )
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    array(
                        'name'    => esc_html__( 'Choose title style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'simpleleft' => esc_html__( 'Title aligned left', 'gowatch' ),
                            'lineafter' => esc_html__( 'Title aligned left with circle and line after', 'gowatch' ),
                            'leftrect' => esc_html__( 'Title aligned left with rectangular left', 'gowatch' ),
                            'simplecenter' => esc_html__( 'Title aligned center', 'gowatch' ),
                            'smallcenter' => esc_html__( 'Small Title aligned center', 'gowatch' ),
                            'linerect' => esc_html__( 'Title aligned center with line and rectangular below', 'gowatch' ),
                            '2lines' => esc_html__( 'Title aligned center with 2 lines before and after', 'gowatch' ),
                            'lineariconcenter' => esc_html__( 'Title aligned center with linear icon after', 'gowatch' ),
                            'with-subtitle-above' => esc_html__( 'Title with subtitle above', 'gowatch' ),
                            'align-right' => esc_html__( 'Title aligned right', 'gowatch' ),
                            'brackets' => esc_html__( 'Title in brackets', 'gowatch' ),
                            'with-small-line-below' => esc_html__( 'Title with small line below', 'gowatch' ),
                            'with-double-line' => esc_html__( 'Title with double line after', 'gowatch' ),
                            'with-bold-line-after' => esc_html__( 'Title with bold line after', 'gowatch' ),
                            'border-square-left' => esc_html__( 'Title with bordered square left', 'gowatch' ),
                            'border-square-center' => esc_html__( 'Title with bordered square center', 'gowatch' ),
                            'kodak' => esc_html__( 'Title kodak style centered', 'gowatch' ),
                        ),
                        'id'       => 'style',
                        'std'      => 'simpleleft',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'  => esc_html__( 'Letter spacing', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'letter-spacer',
                        'std'   => 0
                    ),

                    array(
                        'name'  => esc_html__( 'Choose title color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'title-color',
                        'std'   => airkit_get_color( 'general_text_color' )
                    ),

                    array(
                        'name'  => esc_html__( 'Choose subtitle color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'subtitle-color',
                        'std'   => airkit_get_color( 'general_text_color' )
                    ),

                    array(
                        'name'    => esc_html__( 'Choose title heading type', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h5' => 'H5',
                            'h6' => 'H6',
                        ),
                        'id'       => 'size',
                        'std'      => 'h3',
                        'class'    => 'airkit_style-smallcenter airkit_revert-trigger',
                    ),

                    array(
                        'name'    => esc_html__( 'Choose subtitle font size', 'gowatch' ),
                        'field'   => 'input',
                        'type'    => 'number',
                        'id'      => 'subtitle-size',
                        'std'     => 14
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 
                )
            )
        );
    }

    static function video()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Video', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-video'
                    ),

                    array(
                        'name'    => esc_html__( 'Enable lightbox mode', 'gowatch' ),
                        'desc'    => esc_html__( 'If yes is selected, it will only show a button. When clicked, it will show the video in a modal box.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'           => 'lightbox',
                        'std'          => 'n',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'  => esc_html__( 'Title', 'gowatch' ),
                        'desc'  => esc_html__( 'Add a title/description for your video.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'title',
                        'std'   => '',
                        'class' => 'airkit_lightbox-y'
                    ),

                    array(
                        'name'  => esc_html__( 'Add your URL here.', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'embed',
                        'std'   => '',
                        'esc'   => array( 'airkit_Template', 'esc_text' )
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 

                    array(
                        'name'  => esc_html__( 'Custom CSS', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'custom-css',
                        'std'   => ''
                    )
                )
            )
        );
    }

    static function image()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Image', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-image'
                    ),

                    array(
                        'name'       => esc_html__( 'Upload you image in the media library and select it', 'gowatch' ),
                        'field'      => 'upload',
                        'media-type' => 'image',
                        'multiple'   => 'false',
                        'id'         => 'image-url',
                        'std'        => ''
                    ),

                    array(
                        'name'    => esc_html__( 'Image align', 'gowatch' ),
                        'desc'    => esc_html__( 'Choose the alignment of you image. If the image is smaller than the container, it will be contained to the dimensions of it. If it is smaller, it will be aligned to the selected position.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'left'   => esc_html__( 'Left', 'gowatch' ),
                            'center' => esc_html__( 'Center', 'gowatch' ),
                            'right'  => esc_html__( 'Right', 'gowatch' )
                        ),
                        'id'       => 'align',
                        'std'      => 'left'
                    ),

                    array(
                        'name'  => esc_html__( 'Add a link to the image', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'forward-url',
                        'std'   => ''
                    ),

                    self::get_setting( 'target' ),

                    array(
                        'name'    => esc_html__( 'Use retina image', 'gowatch' ),
                        'desc'    => esc_html__( 'This option will make you image 2x smaller. Note that this option uses the get_image_size() PHP function and some server can have it deactivated. If you get a notice, contact your hosting provider.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'retina',
                        'std'      => 'n'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),

                    array(
                        'name'  => esc_html__( 'Custom CSS', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'custom-css',
                        'std'   => ''
                    )
                )
            )
        );
    }

    static function spacer()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Spacer', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-resize-vertical'
                    ),

                    array(
                        'name'  => esc_html__( 'Spacer height', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'height',
                        'std'   => 30
                    )
                )
            )
        );
    }

    static function facebook_block()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Facebook', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-facebook'
                    ),

                    array(
                        'name'  => esc_html__( 'Insert the URL of your Facebook Page', 'gowatch' ),
                        'desc'  => 'ex: http://facebook.com/touchsize',
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'url',
                        'std'   => ''
                    ),

                    array(
                        'name'    => esc_html__( 'Hide cover photo', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'cover',
                        'std'      => 'false'
                    )
                )
            )
        );
    }

    static function counter()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Counters', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-time'
                    ),

                    array(
                        'name'  => esc_html__( 'Text', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'counters-text',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Count percent (%)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'counters-precents',
                        'std'   => 100
                    ),

                    self::get_setting( 'text-color' ),

                    array(
                        'name'    => esc_html__( 'Display track bar', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'with-track-bar'    => esc_html__( 'With track bar', 'gowatch' ),
                            'without-track-bar' => esc_html__( 'Without track bar', 'gowatch' )
                        ),
                        'id'           => 'track-bar',
                        'std'          => 'with-track-bar',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'  => esc_html__( 'Track bar color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'track-bar-color',
                        'std'   => '#000',
                        'class' => 'airkit_track-bar-with-track-bar'
                    ),

                    array(
                        'name'    => esc_html__( 'Select icon', 'gowatch' ),
                        'field'   => 'list_select',
                        'options' => self::get_icons(),
                        'id'      => 'icon',
                        'std'     => 'heart',
                        'class'   => 'airkit_track-bar-without-track-bar'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )
                )
            )
        );
    }

    static function buttons()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Button', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-button'
                    ),

                    array(
                        'name'  => esc_html__( 'Button text', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'text',
                        'std'   => 'Text button'
                    ),

                    array(
                        'name'  => esc_html__( 'URL', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'url',
                        'std'   => ''
                    ),

                    self::get_setting( 'target' ),

                    array(
                        'name'    => esc_html__( 'Choose button size', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'big'    => esc_html__( 'Big', 'gowatch' ),
                            'medium' => esc_html__( 'Medium', 'gowatch' ),
                            'small'  => esc_html__( 'Small', 'gowatch' ),
                            'xsmall' => esc_html__( 'xSmall', 'gowatch' )
                        ),
                        'id'      => 'size',
                        'std'     => 'medium'
                    ),
                    
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    self::get_setting( 'icon' ),

                    array(
                        'name'    => esc_html__( 'Choose icon align inside the button', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'left-of-text'  => esc_html__( 'Left of text', 'gowatch' ),
                            'right-of-text' => esc_html__( 'Right of text', 'gowatch' ),
                            'above-text'    => esc_html__( 'Above Text', 'gowatch' )
                        ),
                        'id'      => 'icon-align',
                        'std'     => 'left-of-text'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose button align in container', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'text-left'    => esc_html__( 'Left', 'gowatch' ),
                            'text-right'   => esc_html__( 'Right', 'gowatch' ),
                            'text-center'  => esc_html__( 'Center', 'gowatch' )
                        ),
                        'id'      => 'button-align',
                        'std'     => 'text-left'
                    ),

                    self::get_setting( 'text-color' ),

                    array(
                        'name'  => esc_html__( 'Button text color on hover', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'text-hover-color',
                        'std'   => '#FFFFFF'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose button style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'border-button'     => esc_html__( 'Border button', 'gowatch' ),
                            'background-button' => esc_html__( 'Background button', 'gowatch' ),
                            'ghost-button'      => esc_html__( 'Ghost button', 'gowatch' )
                        ),
                        'id'           => 'mode-display',
                        'std'          => 'background-button',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose border color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'border-color',
                        'std'   => '#DDDDDD',
                        'class' => 'airkit_mode-display-border-button airkit_mode-display-ghost-button'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose background color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'bg-color',
                        'std'   => '#ffffff',
                        'class' => 'airkit_mode-display-background-button'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose background color on hover', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'bg-hover-color',
                        'std'   => '#f1f1f1',
                        'class' => 'airkit_mode-display-background-button airkit_mode-display-ghost-button'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose border color on hover', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'border-hover-color',
                        'std'   => '#f1f1f1',
                        'class' => 'airkit_mode-display-border-button'
                    )
                )
            )
        );
    }

    static function contact_form()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Contact form', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-mail'
                    ),

                    array(
                        'name'    => esc_html__( 'Disable email icon', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'hide-icon',
                        'std'      => 'n'
                    ),

                    array(
                        'name'    => esc_html__( 'Disable name field', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'hide-name',
                        'std'      => 'n'
                    ),

                    array(
                        'name'    => esc_html__( 'Disable email field', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'hide-email',
                        'std'      => 'n'
                    ),

                    array(
                        'name'    => esc_html__( 'Disable subject field', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'hide-subject',
                        'std'      => 'n'
                    ),

                    array(
                        'name'    => esc_html__( 'Disable text field', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'hide-text',
                        'std'      => 'n'
                    ),

                    array(
                        'name'     => esc_html__( 'Add New Field', 'gowatch' ),
                        'field'    => 'tmpl',
                        'options'  => array(

                            array(
                                'name'    => esc_html__( 'Choose your type field', 'gowatch' ),
                                'field'   => 'select',
                                'options' => array(
                                    'select'   => esc_html__( 'Select', 'gowatch' ),
                                    'input'    => esc_html__( 'Input', 'gowatch' ),
                                    'textarea' => esc_html__( 'Textarea', 'gowatch' )
                                ),
                                'id'           => 'type',
                                'std'          => 'Input',
                                'class_select' => 'airkit_trigger-options'
                            ),

                            array(
                                'name'    => esc_html__( 'Make field required', 'gowatch' ),
                                'field'   => 'select',
                                'options' => array(
                                    'y' => esc_html__( 'Yes', 'gowatch' ),
                                    'n' => esc_html__( 'No', 'gowatch' )
                                ),
                                'id'       => 'required',
                                'std'      => 'Input'
                            ),

                            array(
                                'name'  => esc_html__( 'Field title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Write your options here in the following field(ex: option1/option2/options3/...)', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'options',
                                'std'   => '',
                                'class' => 'airkit_type-select'
                            )
                        ),
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array()
                    )
                )
            )
        );
    }

    static function featured_area()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Featured area', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-featured-area'
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),
                )
            ),
            
            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(
                    array(

                        'name'    => esc_html__( 'Layout', 'gowatch' ),
                        'desc'    => esc_html__( 'Choose featured area style', 'gowatch' ),
                        'field'   => 'img_selector',
                        'options' => array(
                            'style-1' => 'One big post, three small',
                            'style-2' => 'One big post, four small',
                            'style-3' => 'Big post with thumbnails',
                        ),
                        'img' => array(
                            'style-1' => 'feat_area_1.png',
                            'style-2' => 'feat_area_2.png',
                            'style-3' => 'feat_area_3.png',

                        ),
                        'id'  => 'style',
                        'std' => 'style-1',                     
                    ),
                ),             
            ),
        );
    }

    static function shortcodes()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Shortcode', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-code'
                    ),

                    array(
                        'name'    => esc_html__( 'Remove default container column paddings', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'paddings',
                        'std'      => 'n'
                    ),

                    array(
                        'name'  => esc_html__( 'Insert your shortcode', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'shortcodes',
                        'std'   => ''
                    )
                )
            )
        );
    }

    static function image_carousel()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Image carousel', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow'
                    ),

                    array(
                        'name'  => esc_html__( 'Maximum carousel height (px)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'carousel-height',
                        'std'   => 400
                    ),

                    array(
                        'name'       => esc_html__( 'Choose images', 'gowatch' ),
                        'field'      => 'upload',
                        'media-type' => 'image',
                        'multiple'   => 'true',
                        'sortable'   => 'true',
                        'id'         => 'bg-image',
                        'std'        => ''
                    )
                )
            )
        );
    }

    static function grid()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Grid view articles', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),
                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),

                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),

                    self::get_setting( 'pagination' ),            
                    self::get_setting( 'small-posts' ),                      
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    self::get_setting( 'behavior' ),
                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-scroll' ),
                    self::get_setting( 'carousel-autoplay' ),
                    self::get_setting( 'per-row' ),

                    array(
                        'name'    => esc_html__( 'Enable featured image', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'featimg',
                        'std'      => 'y'
                    ),

                    self::get_setting( 'enable-ads' ),
                    self::get_setting( 'ads-step' ),

                    self::get_setting( 'styling' ),
                    self::get_setting( 'bg-color' ),
                    self::get_setting( 'border-color' ),
                    self::get_setting( 'excerpt' ),
                    self::get_setting( 'meta' ),
                    self::get_setting( 'gutter-space' ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                    
                )
            )
        );
    }

    static function list_view()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'List view articles', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),

                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),

                    self::get_setting( 'pagination' )
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    array(
                        'name'    => esc_html__( 'Post excerpt style', 'gowatch' ),
                        'desc'    => esc_html__( 'You can remove the preview text used in List view if you don\'t need it, or you can choose what to display as preview text for the posts. If you choose to display excerpt, the excerpt (generated or defined) of the post will be displayed. If you choose to display content, entire content of the post will be displayed. If you choose Hide option, nor excerpt or content will be displayed.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'excerpt' => esc_html__( 'Show excerpt', 'gowatch' ),
                            'content' => esc_html__( 'Show content', 'gowatch' ),
                            'hide'    => esc_html__( 'Hide', 'gowatch' )
                        ),
                        'id'      => 'exc',
                        'std'     => 'excerpt'
                    ),
                    
                    self::get_setting( 'enable-ads' ),
                    self::get_setting( 'ads-step' ),    

                    self::get_setting( 'meta' ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 
                )
            )
        );
    }

    static function numbered_list_view()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Numbered list view articles', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),

                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),

                    self::get_setting( 'pagination' )
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(   
                    self::get_setting( 'per-row' ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 
                )
            )
        );
    }

    static function thumbnail()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Thumbnail articles', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),

                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),

                    self::get_setting( 'pagination' ),
                    self::get_setting( 'small-posts' ),                 

                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    self::get_setting( 'behavior' ),
                    /* Get carousel settings fields */
                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-scroll' ),
                    self::get_setting( 'carousel-autoplay' ),                 
                    self::get_setting( 'per-row' ),

                    self::get_setting( 'enable-ads' ),
                    self::get_setting( 'ads-step' ),  

                    array(
                        'name'    => esc_html__( 'Choose title position', 'gowatch' ),
                        'desc'    => esc_html__( 'Select your title position for you grid posts. You can either have it above the image of above the excerpt. Note that sometimes title may change the position of the meta: date, categories, author as well.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'over-image'  => esc_html__( 'Over image', 'gowatch' ),
                            'below-image' => esc_html__( 'Below image', 'gowatch' )
                        ),
                        'id'       => 'title-position',
                        'std'      => 'below-image',
                        'class_select' => 'airkit_trigger-options',
                    ),

                    array(
                        'name' => esc_html__( 'How to display content', 'gowatch' ),
                        'desc' => esc_html__( 'If you choose to always show content, posts title, categories and other meta will be always visible. If you choose to show content on hover, posts meta will be visible only when user hovers an article', 'gowatch' ),
                        'field' => 'select',
                        'options' => array(
                            'show-always' => esc_html__( 'Display always', 'gowatch' ),
                            'show-hover'  => esc_html__( 'Display on hover', 'gowatch' ),
                        ),
                        'id'  => 'content-hover',
                        'std' => 'show-always',
                        'class' => 'airkit_title-position-over-image',
                    ),

                    self::get_setting( 'styling' ),
                    self::get_setting( 'bg-color' ),
                    self::get_setting( 'border-color' ),
                    self::get_setting( 'meta' ),
                    self::get_setting( 'gutter-space' ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                    
                )
            )
        );
    }

    static function big()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Big posts articles', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),
                    
                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),

                    self::get_setting( 'pagination' ),
                    self::get_setting( 'small-posts' ),                 

                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    array(
                        'name'    => esc_html__( 'Choose split layout', 'gowatch' ),
                        'desc'    => esc_html__( 'You can select the split size for your big posts layout. You can have the image smaller with more attention to the title and excerpt or go the other way and have a bigger space for images.', 'gowatch' ),
                        'field'   => 'img_selector',
                        'options' => array(
                            '1-3' => '1/3',
                            '1-2' => '1/2',
                            '3-4' => '3/4'
                        ),
                        'img' => array(
                            '1-3' => 'big_posts_13.png',
                            '1-2' => 'big_posts_12.png',
                            '3-4' => 'big_posts_34.png'
                        ),
                        'id'           => 'content-split',
                        'std'          => 'normal',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose image position', 'gowatch' ),
                        'desc'    => esc_html__( 'You can select the positioning of the image for this element. You can align the image on left and content on the right or the other way. The mosaic option will show one post with image left and the next one with image right', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'left'   => esc_html__( 'Image left, content right', 'gowatch' ),
                            'right'  => esc_html__( 'Image right, content left', 'gowatch' ),
                            'mosaic' => esc_html__( 'Mosaic - alternate other options', 'gowatch' )
                        ),
                        'id'       => 'image-position',
                        'std'      => 'left'
                    ),

                    array(
                        'name'    => esc_html__( 'Content horizontal align', 'gowatch' ),
                        'desc'    => esc_html__( 'You can select the text alignment within the big post text section.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'left'   => esc_html__( 'Align left', 'gowatch' ),
                            'center'  => esc_html__( 'Align center', 'gowatch' ),
                        ),
                        'id'       => 'text-align',
                        'std'      => 'left'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose posts behavior', 'gowatch' ),
                        'desc'    => esc_html__( 'You can choose to activate the carousel option so that each post will be a new slide', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'none'      => esc_html__( 'None', 'gowatch' ),
                            'carousel'  => esc_html__( 'Carousel', 'gowatch' ),
                        ),
                        'id'  => 'behavior',
                        'std' => 'none',
                        'class_select' => 'airkit_trigger-options',
                    ),

                    /* Get carousel settings fields */
                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-autoplay' ),

                    self::get_setting( 'enable-ads' ),
                    self::get_setting( 'ads-step' ),                      

                    self::get_setting( 'styling' ),
                    self::get_setting( 'bg-color' ),
                    self::get_setting( 'border-color' ),
                    self::get_setting( 'meta' ),
                    self::get_setting( 'excerpt' ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                    
                )
            )
        );
    }

    static function super()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Super posts articles', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),
                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),
          
                    self::get_setting( 'pagination' ),
                    self::get_setting( 'small-posts' ),                 

                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(
                    self::get_setting( 'per-row' ),

                     array(
                        'name'    => esc_html__( 'Choose posts behavior', 'gowatch' ),

                        'desc'    => esc_html__( 'Choose your posts behavior - you can have them just shown, or you can activate the carousel. If carousel is selected your articles will show up in a line with arrows for navigation. ', 'gowatch' ),
                        'field'   => 'img_selector',

                        'options' => array(
                            'normal'   => 'normal',
                            'carousel' => 'carousel',
                            'filters'  => 'filters'

                        ),

                        'img' => array(
                            'normal'   => 'behavior_none.png',
                            'carousel' => 'behavior_carousel.png',
                            'filters'  => 'behavior_tabs.png'
                        ),

                        'id'           => 'behavior',
                        'std'          => 'normal',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    /* Get carousel settings fields */
                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-scroll' ),
                    self::get_setting( 'carousel-autoplay' ),                          
                    
                    self::get_setting( 'gutter-space' ),
                    self::get_setting( 'meta' ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                         
                )
            )
        );
    }

    static function category()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Category view articles', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),

                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    array(
                        'name'    => esc_html__( 'Style', 'gowatch' ),
                        'desc'    => esc_html__( 'Choose style for category view', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'style-1' => esc_html__( 'Style 1', 'gowatch' ),
                            'style-2' => esc_html__( 'Style 2', 'gowatch' ),
                            'style-3' => esc_html__( 'Style 3', 'gowatch' )
                        ),
                        'id'       => 'style',
                        'std'      => 'style-1',
                    ),                 
                    self::get_setting( 'meta' ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ) 

                )
            )
        );
    }

    static function category_grids()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Category grids', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),

                    self::get_setting( 'per-row' ),

                    array(
                        'name'  => esc_html__( 'Posts to extract', 'gowatch' ),
                        'desc'  => esc_html__( 'This is the number of posts that will be displayed for each individual category you have selected.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'posts-limit',
                        'std'   => 4
                    ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Category heading', 'gowatch' ),
                'options' => array(
                    
                    array(
                        'name'    => esc_html__( 'Show category title and description', 'gowatch' ),
                        'desc'    => esc_html__( 'If enabled, it will show the category title with link to the archive page.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'show-title',
                        'std'      => 'y',
                        'class_select' => 'airkit_trigger-options'
                    ),  

                    array(
                        'name'  => esc_html__( 'Letter spacing', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'letter-spacer',
                        'std'   => 0,
                        'class' => 'airkit_show-title-y'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose title color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'title-color',
                        'std'   => airkit_get_color( 'general_text_color' ),
                        'class' => 'airkit_show-title-y'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose subtitle color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'subtitle-color',
                        'std'   => airkit_get_color( 'general_text_color' ),
                        'class' => 'airkit_show-title-y'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose title heading type', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h5' => 'H5',
                            'h6' => 'H6',
                        ),
                        'id'       => 'size',
                        'std'      => 'h3',
                        'class'    => 'airkit_show-title-y'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose title style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'simpleleft' => esc_html__( 'Title aligned left', 'gowatch' ),
                            'lineafter' => esc_html__( 'Title aligned left with circle and line after', 'gowatch' ),
                            'leftrect' => esc_html__( 'Title aligned left with rectangular left', 'gowatch' ),
                            'simplecenter' => esc_html__( 'Title aligned center', 'gowatch' ),
                            'smallcenter' => esc_html__( 'Small Title aligned center', 'gowatch' ),
                            'linerect' => esc_html__( 'Title aligned center with line and rectangular below', 'gowatch' ),
                            '2lines' => esc_html__( 'Title aligned center with 2 lines before and after', 'gowatch' ),
                            'lineariconcenter' => esc_html__( 'Title aligned center with linear icon after', 'gowatch' ),
                            'with-subtitle-above' => esc_html__( 'Title with subtitle above', 'gowatch' ),
                            'align-right' => esc_html__( 'Title aligned right', 'gowatch' ),
                            'brackets' => esc_html__( 'Title in brackets', 'gowatch' ),
                            'with-small-line-below' => esc_html__( 'Title with small line below', 'gowatch' ),
                            'with-double-line' => esc_html__( 'Title with double line after', 'gowatch' ),
                            'with-bold-line-after' => esc_html__( 'Title with bold line after', 'gowatch' ),
                            'border-square-left' => esc_html__( 'Title with bordered square left', 'gowatch' ),
                            'border-square-center' => esc_html__( 'Title with bordered square center', 'gowatch' ),
                            'kodak' => esc_html__( 'Title kodak style centered', 'gowatch' ),
                        ),
                        'id'       => 'style',
                        'std'      => 'simpleleft',
                        'class'    => 'airkit_show-title-y'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ) 

                )
            )
        );
    }

    static function list_categories()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'List categories', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),

                    array(
                        'name'      => esc_html__( 'Layout style', 'gowatch' ),
                        'field'     => 'select',
                        'id'        => 'layout-style',
                        'options'   => array(
                            'over-image' => esc_html__('Text over image','gowatch'),
                            'below-image' => esc_html__('Text below image','gowatch'),
                        ),
                        'std'       => 'over-image'
                    ),
                    
                    self::get_setting( 'per-row' ),

                )
            ),
        );
    }

    static function small_articles()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Small articles', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),

                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),
                    self::get_setting( 'pagination' ),
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    self::get_setting( 'per-row' ),

                     array(
                        'name'    => esc_html__( 'Choose post behavior', 'gowatch' ),

                        'desc'    => esc_html__( 'Choose your posts behavior - you can have them just shown, or you can activate the carousel. If carousel is selected your articles will show up in a line with arrows for navigation. ', 'gowatch' ),
                        'field'   => 'img_selector',

                        'options' => array(
                            'normal'   => 'normal',
                            'carousel' => 'carousel',
                            'filters'  => 'filters'

                        ),

                        'img' => array(
                            'normal'   => 'behavior_none.png',
                            'carousel' => 'behavior_carousel.png',
                            'filters'  => 'behavior_tabs.png'
                        ),

                        'id'           => 'behavior',
                        'std'          => 'normal',
                        'class_select' => 'airkit_trigger-options'
                    ),              

                    /* Get carousel settings fields */
                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-scroll' ),
                    self::get_setting( 'carousel-autoplay' ),            
                     
                    self::get_setting( 'meta' ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                                
                   
                )
            )
        );
    }    

    static function timeline()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Timeline view articles', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),

                    self::get_setting( 'meta' ),

                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),
                    self::get_setting( 'pagination' ),           

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),   
                )
            )
        );
    }

    static function mosaic()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Mosaic view articles', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),
                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'portfolio_categories' ),
                    self::get_setting( 'tags' ),

                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),
                    self::get_setting( 'pagination' )
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(


                    array(
                            'name'    => esc_html__( 'Choose post behavior', 'gowatch' ),

                            'desc'    => esc_html__( 'Choose your posts behavior - you can have them just shown, or you can activate the carousel. If carousel is selected your articles will show up in a line with arrows for navigation.', 'gowatch' ),
                            'field'   => 'img_selector',

                            'options' => array(
                                'normal'   => 'normal',
                                'carousel' => 'carousel',
                                'scroll'   => 'scroll',
                                'filters'  => 'filters'

                            ),

                            'img' => array(
                                'normal'   => 'behavior_none.png',
                                'carousel' => 'behavior_carousel.png',
                                'scroll'   => 'behavior_scroll.png',
                                'filters'  => 'behavior_tabs.png'
                            ),

                            'id'           => 'behavior',
                            'std'          => 'normal',
                            'class_select' => 'airkit_trigger-options'
                    ),

                    /* Get carousel settings fields */
                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-autoplay' ),                 

                    array(
                        'name'    => esc_html__( 'Choose style of images', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'rectangles' => esc_html__( 'Rectangles', 'gowatch' ),
                            'square'     => esc_html__( 'Squares', 'gowatch' ),
                            'style-3'    => esc_html__( 'Style 3', 'gowatch' ),
                            'style-4'    => esc_html__( 'Style 4', 'gowatch' ),
                            'style-5'    => esc_html__( 'Style 5', 'gowatch' ),
                        ),
                        'id'           => 'layout',
                        'std'          => 'rectangles',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose number of rows', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            2 => 2,
                            3 => 3
                        ),
                        'id'       => 'rows',
                        'std'      => 'y',
                        'class'    => 'airkit_layout-rectangles'
                    ),

                    array(
                        'name'  => esc_html__( 'Posts to extract', 'gowatch' ),
                        'desc'  => esc_html__( 'This is the number of posts that will be extracted from the database and shown in total. If you use pagination, this will be the default posts number and on each new iteration this number of posts will be extracted again.', 'gowatch' ),
                        'field' => 'slider_drag',
                        'type'  => 'number',
                        'id'    => 'posts-limit',
                        'min'   => 6,
                        'max'   => 60,
                        'step'  => 6,
                        'std'   => 6,
                    ),                 

                    array(
                        'name'    => esc_html__( 'Enable spacing between posts', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'gutter',
                        'std'      => 'y'
                    ),

                    array(
                        'name'    => esc_html__( 'How to display post content', 'gowatch' ),
                        'desc'    => esc_html__( 'If you choose Display always, post title, categories and excerpt will be always visible. If you choose to display them on hover, they will only show up when user hovers the article.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'always' => esc_html__( 'Display always', 'gowatch' ),
                            'hover'  => esc_html__( 'Display on hover', 'gowatch' ),
                        ),
                        'id'           => 'hover-style',
                        'std'          => 'always',
                        'class'        => 'airkit_layout-style-4 airkit_revert-trigger',
                    ),                 

                    self::get_setting( 'meta' ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),
                )
            )
        );
    }

    static function teams()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Team members', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-team'
                    ),

                    array(
                        'name'         => esc_html__( 'Choose your members category', 'gowatch' ),
                        'field'        => 'select',
                        'options'      => wp_list_pluck( get_categories( array( 'hide_empty' => 1, 'taxonomy' => 'teams' ) ), 'cat_name', 'slug' ),
                        'id'           => 'category',
                        'class_select' => 'ts-custom-select-input',
                        'multiple'     => true,
                        'std'          => ''
                    ),

                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'per-row' ),
                    self::get_setting( 'carousel' ),
                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-scroll' ),
                    self::get_setting( 'carousel-autoplay' ),                      

                    array(
                        'name'    => esc_html__( 'Remove spacing (gutter) between articles', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'remove-gutter',
                        'std'      => 'n'
                    ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                    
                )
            )
        );
    }

    static function map()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Map', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-pin'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                  

                    array(
                        'field' => 'render_map'
                    ),

                    array(
                        'name'  => esc_html__( 'Map width', 'gowatch' ),
                        'desc'  => esc_html__( 'Enter the width number ( percent ). Eg: 100%', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'width',
                        'attr'  => 'max="100"',
                        'std'   => 100
                    ),

                    array(
                        'name'  => esc_html__( 'Map height', 'gowatch' ),
                        'desc'  => esc_html__( 'Enter the height number ( px ) Eg: 400px', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'height',
                        'std'   => 300
                    ),

                    array(
                        'name'  => esc_html__( 'Latitude', 'gowatch' ),
                        'desc'  => esc_html__( 'Latitude automatically generated from the address entered above.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'latitude',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Longitude', 'gowatch' ),
                        'desc'  => esc_html__( 'Longitude automatically generated from the address entered above.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'longitude',
                        'std'   => ''
                    ),

                    array(
                        'name'    => esc_html__( 'Map type', 'gowatch' ),
                        'desc'    => esc_html__( 'For details read the documentation from Google ', 'gowatch' ) . '<a href="https://developers.google.com/maps/documentation/javascript/maptypes#MapTypes" target="_blank">' . esc_html__( 'read documentation', 'gowatch' ) . '</a>',
                        'field'   => 'select',
                        'options' => array(
                            'ROADMAP'   => esc_html__( 'Roadmap', 'gowatch' ),
                            'SATELLITE' => esc_html__( 'Satellite', 'gowatch' ),
                            'HYBRID'    => esc_html__( 'Hybrid', 'gowatch' ),
                            'TERRAIN'   => esc_html__( 'Terrain', 'gowatch' )
                        ),
                        'id'      => 'type',
                        'std'     => 'ROADMAP'
                    ),

                    array(
                        'name'    => esc_html__( 'Map style', 'gowatch' ),
                        'desc'    => esc_html__( 'For details read the documentation from Google ', 'gowatch' ) . '<a href="https://developers.google.com/maps/documentation/javascript/maptypes#MapTypes" target="_blank">' . esc_html__( 'read documentation', 'gowatch' ) . '</a>',
                        'field'   => 'select',
                        'options' => array(
                            'map-style-default'          => esc_html__( 'Default', 'gowatch' ),
                            'map-style-essence'          => esc_html__( 'Essence', 'gowatch' ),
                            'map-style-subtle-grayscale' => esc_html__( 'Subtle grayscale', 'gowatch' ),
                            'map-style-shades-of-grey'   => esc_html__( 'Shades of grey', 'gowatch' ),
                            'map-style-purple'           => esc_html__( 'Purple', 'gowatch' ),
                            'map-style-best-ski-pros'    => esc_html__( 'Best ski pros', 'gowatch' )
                        ),
                        'id'      => 'style',
                        'std'     => 'ROADMAP'
                    ),

                    array(
                        'name'  => esc_html__( 'Map zoom', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'zoom',
                        'std'   => 11
                    ),

                    array(
                        'name'    => esc_html__( 'Map type control', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'false' => esc_html__( 'Disable', 'gowatch' ),
                            'true'  => esc_html__( 'Enable', 'gowatch' )
                        ),
                        'id'      => 'control',
                        'std'     => 'true'
                    ),

                    array(
                        'name'    => esc_html__( 'Map zoom control', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'false' => esc_html__( 'Disable', 'gowatch' ),
                            'true'  => esc_html__( 'Enable', 'gowatch' )
                        ),
                        'id'      => 'zoom-control',
                        'std'     => 'true'
                    ),

                    array(
                        'name'    => esc_html__( 'Map scale control', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'false' => esc_html__( 'Disable', 'gowatch' ),
                            'true'  => esc_html__( 'Enable', 'gowatch' )
                        ),
                        'id'      => 'scale-control',
                        'std'     => 'false'
                    ),

                    array(
                        'name'    => esc_html__( 'Map scroll wheel', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'false' => esc_html__( 'Disable', 'gowatch' ),
                            'true'  => esc_html__( 'Enable', 'gowatch' )
                        ),
                        'id'      => 'scroll-wheel',
                        'std'     => 'true'
                    ),

                    array(
                        'name'    => esc_html__( 'Draggable directions', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'false' => esc_html__( 'Disable', 'gowatch' ),
                            'true'  => esc_html__( 'Enable', 'gowatch' )
                        ),
                        'id'      => 'draggable-direction',
                        'std'     => 'true'
                    ),

                    array(
                        'name'    => esc_html__( 'Marker icon', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'map-marker-icon-default' => esc_html__( 'Use default', 'gowatch' ),
                            'map-marker-icon-upload'  => esc_html__( 'Upload icon', 'gowatch' )
                        ),
                        'id'           => 'marker-icon',
                        'std'          => 'map-marker-icon-default',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'       => esc_html__( 'Upload custom marker icon', 'gowatch' ),
                        'field'      => 'upload',
                        'media-type' => 'image',
                        'id'         => 'marker-img',
                        'std'        => '',
                        'class'      => 'airkit_marker-icon-map-marker-icon-upload'
                    )
                )
            )
        );
    }

    static function banner()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Banner', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-link-ext'
                    ),

                    array(
                        'name'       => esc_html__( 'Choose banner image', 'gowatch' ),
                        'field'      => 'upload',
                        'media-type' => 'image',
                        'id'         => 'img',
                        'std'        => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Set banner height', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'height',
                        'std'   => 400
                    ),

                    array(
                        'name'  => esc_html__( 'Add your title', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'title',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Add banner text', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'description',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Add text button', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'button-title',
                        'std'   => 'Go to'
                    ),

                    array(
                        'name'  => esc_html__( 'Add URL for button', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'button-url',
                        'std'   => ''
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    array(
                        'name'    => esc_html__( 'Choose button align', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'left'   => esc_html__( 'Left', 'gowatch' ),
                            'right'  => esc_html__( 'Right', 'gowatch' ),
                            'center' => esc_html__( 'Center', 'gowatch' ),
                        ),
                        'id'  => 'text-align',
                        'std' => 'center'
                    ),                 

                    self::get_setting( 'bg-color' ),
                    self::get_setting( 'text-color' ),

                    array(
                        'name'  => esc_html__( 'Choose text color for button', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'button-text-color',
                        'std'   => '#FFFFFF'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose background color for button', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'button-background',
                        'std'   => '#000000'
                    ),
                
                )
            )            
        );
    }

    static function toggle()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Toggle', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-resize-full'
                    ),

                    array(
                        'name'  => esc_html__( 'Add title', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'title',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Add text', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'description',
                        'std'   => ''
                    ),

                    array(
                        'name'    => esc_html__( 'Default toggle state', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'open'   => esc_html__( 'Open', 'gowatch' ),
                            'closed' => esc_html__( 'Closed', 'gowatch' )
                        ),
                        'id'       => 'state',
                        'std'      => 'closed'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 
                )
            )
        );
    }

    static function tab()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Tab', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-tabs'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose tab style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'horizontal' => esc_html__( 'Horizontal', 'gowatch' ),
                            'vertical'   => esc_html__( 'Vertical', 'gowatch' )
                        ),
                        'id'       => 'mode',
                        'std'      => 'horizontal'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 

                    array(
                        'name'     => esc_html__( 'Add new tab', 'gowatch' ),
                        'field'    => 'tmpl',
                        'options'  => array(

                            array(
                                'name'  => esc_html__( 'Add title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add content', 'gowatch' ),
                                'field' => 'textarea',
                                'id'    => 'text',
                                'std'   => ''
                            )
                        ),
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array()
                    )
                )
            )
        );
    }

    static function cart()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Shopping cart', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-basket'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose shopping cart alignment', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'left'   => esc_html__( 'Left', 'gowatch' ),
                            'center' => esc_html__( 'Center', 'gowatch' ),
                            'right'  => esc_html__( 'Right', 'gowatch' ),
                        ),
                        'id'      => 'align',
                        'std'     => 'left'
                    )
                )
            )
        );
    }

    static function timeline_features()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Timeline features', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-parallel'
                    ),

                    array(
                        'name'     => esc_html__( 'Add new timeline feature', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array(),
                        'options'  => array(

                            array(
                                'name'  => esc_html__( 'Add title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add content', 'gowatch' ),
                                'field' => 'textarea',
                                'id'    => 'text',
                                'std'   => ''
                            ),

                            array(
                                'name'       => esc_html__( 'Add image', 'gowatch' ),
                                'field'      => 'upload',
                                'media-type' => 'image',
                                'id'         => 'image',
                                'std'        => ''
                            ),

                            array(
                                'name'    => esc_html__( 'Choose image alignment', 'gowatch' ),
                                'field'   => 'select',
                                'options' => array(
                                    'left'  => esc_html__( 'Left', 'gowatch' ),
                                    'right' => esc_html__( 'Right', 'gowatch' )
                                ),
                                'id'      => 'align',
                                'std'     => 'left'
                            ),

                            self::get_setting( 'reveal-effect' ),
                            self::get_setting( 'reveal-delay' )
                        )
                    )
                )
            )
        );
    }

    static function ribbon()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Ribbon banner', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-ribbon'
                    ),

                    array(
                        'name'  => esc_html__( 'Add title', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'title',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Add content', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'text',
                        'std'   => ''
                    ),

                    array(
                        'name'    => esc_html__( 'Choose icon', 'gowatch' ),
                        'field'   => 'list_select',
                        'options' => self::get_icons(),
                        'id'      => 'button-icon',
                        'std'     => ''
                    ),

                    array(
                        'name'       => esc_html__( 'Choose background image', 'gowatch' ),
                        'field'      => 'upload',
                        'media-type' => 'image',
                        'id'         => 'image',
                        'std'        => ''
                    ),                 

                    array(
                        'name'  => esc_html__( 'Button text', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'button-text',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Button URL', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'button-url',
                        'std'   => ''
                    ),

                    self::get_setting( 'target' ),

                    array(
                        'name'    => esc_html__( 'Choose button size', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'big' => esc_html__( 'Big', 'gowatch' ),
                            'medium' => esc_html__( 'Medium', 'gowatch' ),
                            'small'  => esc_html__( 'Small', 'gowatch' ),
                            'xsmall' => esc_html__( 'xSmall', 'gowatch' )
                        ),
                        'id'      => 'button-size',
                        'std'     => 'medium'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    self::get_setting( 'text-color' ),

                    array(
                        'name'  => esc_html__( 'Choose ribbon background color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'background',
                        'std'   => '#FFFFFF'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose ribbon alignment', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'ribbon-left'   => esc_html__( 'Left', 'gowatch' ),
                            'ribbon-center' => esc_html__( 'Center', 'gowatch' ),
                            'ribbon-right'  => esc_html__( 'Right', 'gowatch' ),
                        ),
                        'id'      => 'align',
                        'std'     => 'ribbon-left'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose button alignment', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'text-left'   => esc_html__( 'Left', 'gowatch' ),
                            'text-center' => esc_html__( 'Center', 'gowatch' ),
                            'text-right'  => esc_html__( 'Right', 'gowatch' ),
                        ),
                        'id'      => 'button-align',
                        'std'     => 'text-left'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose button style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'border-button'     => esc_html__( 'Border button', 'gowatch' ),
                            'background-button' => esc_html__( 'Background button', 'gowatch' )
                        ),
                        'id'      => 'button-mode-display',
                        'std'     => 'background-button',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose button background color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'button-background-color',
                        'std'   => '#FFFFFF',
                        'class' => 'airkit_button-mode-display-background-button'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose button background color on hover', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'background-hover-color',
                        'std'   => '#333333',
                        'class' => 'airkit_button-mode-display-background-button'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose button border color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'button-border-color',
                        'std'   => '#FFFFFF',
                        'class' => 'airkit_button-mode-display-border-button'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose button border color on hover', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'border-hover-color',
                        'std'   => '#333333',
                        'class' => 'airkit_button-mode-display-border-button'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose button text color', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'button-text-color',
                        'std'   => '#333333'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose button text color on hover', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'text-hover-color',
                        'std'   => '#FFFFFF'
                    )
                )
            )
        );
    }

    static function count_down()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Countdown timer', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-megaphone'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose countdown style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'small' => esc_html__( 'Small', 'gowatch' ),
                            'big'   => esc_html__( 'Big', 'gowatch' )
                        ),
                        'id'       => 'style',
                        'std'      => 'small'
                    ),

                    array(
                        'name'  => esc_html__( 'Add title', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'title',
                        'std'   => ''
                    ),

                    array(
                        'name'  => 'Date: (yyyy/mm/dd)',
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'date',
                        'std'   => ''
                    ),

                    array(
                        'name'  => 'Time: (hh:mm)',
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'hours',
                        'std'   => ''
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                    
                )
            )
        );
    }

    static function powerlink()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Powerlink', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-ticket'
                    ),

                    array(
                        'name'       => esc_html__( 'Choose image URL', 'gowatch' ),
                        'field'      => 'upload',
                        'media-type' => 'image',
                        'id'         => 'image',
                        'std'        => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Add title', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'title',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Add Button text', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'button-text',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Add Button URL', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'button-url',
                        'std'   => ''
                    ),
                    
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                    
                )
            )
        );
    }

    static function calendar()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Calendar', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-calendar'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose calendar cell size', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'big'   => esc_html__( 'Big', 'gowatch' ),
                            'small' => esc_html__( 'Small', 'gowatch' )
                        ),
                        'id'       => 'size',
                        'std'      => 'small'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),
                )
            )
        );
    }

    static function alert()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Alert', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-attention'
                    ),

                    self::get_setting( 'icon' ),

                    array(
                        'name'  => esc_html__( 'Add title', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'title',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Add text', 'gowatch' ),
                        'field' => 'textarea',
                        'id'    => 'text',
                        'std'   => ''
                    ),

                    self::get_setting( 'bg-color' ),
                    self::get_setting( 'text-color' ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                   
                )
            )
        );
    }

    static function skills()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Skills', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-pencil-alt'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose skills style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'horizontal' => esc_html__( 'Horizontal', 'gowatch' ),
                            'vertical'   => esc_html__( 'Vertical', 'gowatch' )
                        ),
                        'id'       => 'display-mode',
                        'std'      => 'horizontal'
                    ),

                    array(
                        'name'     => esc_html__( 'Add new item', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array(),
                        'options'  => array(

                            array(
                                'name'  => esc_html__( 'Add title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add percentage', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'number',
                                'id'    => 'percentage',
                                'std'   => 86
                            ),

                            array(
                                'name'  => esc_html__( 'Add color', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'color',
                                'std'   => '#777'
                            )
                        )
                    )
                )
            )
        );
    }

    static function accordion()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Article accordion', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-clipboard'
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' )
                )
            )
        );
    }

    static function chart_line()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Line chart', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-chart'
                    ),

                    array(
                        'name'  => esc_html__( 'Labels in format :"label1,label2,label3,..."', 'gowatch' ),
                        'desc'  => esc_html__( 'Write the labels you will use for your chart. These are the labels standing at the bottom of the chart.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'label',
                        'std'   => ''
                    ),

                    array(
                        'name'  => esc_html__( 'Add title', 'gowatch' ),
                        'desc'  => esc_html__( 'Add a description for your chart.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'title',
                        'std'   => ''
                    ),

                    array(
                        'name'    => esc_html__( 'Show lines across the chart', 'gowatch' ),
                        'desc'    => esc_html__( 'Do you want the chart to have lines in the background? It is easier for the eye to look up for information.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'    => 'scaleShowGridLines',
                        'std'   => 'false'
                    ),

                    array(
                        'name'  => esc_html__( 'Color of the grid lines', 'gowatch' ),
                        'desc'  => esc_html__( 'Change the color of the grid lines.', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'scaleGridLineColor',
                        'std'   => '#f7f7f7'
                    ),

                    array(
                        'name'  => esc_html__( 'Width of the grid lines (INTEGER)', 'gowatch' ),
                        'desc'  => esc_html__( 'The lines in the background can be very thin or thick. You decide the way you need them.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'scaleGridLineWidth',
                        'std'   => 1
                    ),

                    array(
                        'name'    => esc_html__( 'Show horizontal lines (except X axis)', 'gowatch' ),
                        'desc'    => esc_html__( 'Choose wether you want horizontal lines.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'    => 'scaleShowHorizontalLines',
                        'std'   => 'true'
                    ),

                    array(
                        'name'    => esc_html__( 'Show vertical lines (except Y axis)', 'gowatch' ),
                        'desc'    => esc_html__( 'Choose wether you want vertical lines.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'    => 'scaleShowVerticalLines',
                        'std'   => 'true'
                    ),

                    array(
                        'name'    => esc_html__( 'The line is curved between points', 'gowatch' ),
                        'desc'    => esc_html__( 'Do you want the lines (you will add the values below) to be curved between the value points or just straight lines.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'    => 'bezierCurve',
                        'std'   => 'true'
                    ),

                    array(
                        'name'  => esc_html__( 'Tension of the bezier curve between points (0.1 - 1)', 'gowatch' ),
                        'desc'  => esc_html__( 'How curved do you want the lines to be bended.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'bezierCurveTension',
                        'std'   => 0.4
                    ),

                    array(
                        'name'    => esc_html__( 'Show a dot for each point', 'gowatch' ),
                        'desc'    => esc_html__( 'You can add dots for the values in your chart.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'    => 'pointDot',
                        'std'   => 'true'
                    ),

                    array(
                        'name'  => esc_html__( 'Radius of each point dot in pixels (INTEGER)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'pointDotRadius',
                        'std'   => 4
                    ),

                    array(
                        'name'  => esc_html__( 'Pixel width of point dot stroke (INTEGER)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'pointDotStrokeWidth',
                        'std'   => 1
                    ),

                    array(
                        'name'  => esc_html__( 'Amount extra to add to the radius to cater for hit detection outside the drawn point (INTEGER)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'pointHitDetectionRadius',
                        'std'   => 20
                    ),

                    array(
                        'name'    => esc_html__( 'Show a stroke for datasets', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'    => 'datasetStroke',
                        'std'   => 'true'
                    ),

                    array(
                        'name'  => esc_html__( 'Pixel width of dataset stroke (INTEGER)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'datasetStrokeWidth',
                        'std'   => 2
                    ),

                    array(
                        'name'    => esc_html__( 'Fill the dataset with a colour', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'    => 'datasetFill',
                        'std'   => 'true'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 

                    array(
                        'name'     => esc_html__( 'Add New Line', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array(),
                        'options'  => array(

                            array(
                                'name'  => esc_html__( 'Title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Fill color', 'gowatch' ),
                                'desc'  => esc_html__( 'Choose a color to fill the value dataset with.', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'fillColor',
                                'std'   => '#ffffff'
                            ),

                            array(
                                'name'  => esc_html__( 'Stroke color', 'gowatch' ),
                                'desc'  => esc_html__( 'Choose a stroke color.', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'strokeColor',
                                'std'   => '#ffffff'
                            ),

                            array(
                                'name'  => esc_html__( 'Point color', 'gowatch' ),
                                'desc'  => esc_html__( 'Choose a color for the points of the values on the chart.', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'pointColor',
                                'std'   => '#ffffff'
                            ),

                            array(
                                'name'  => esc_html__( 'Point stroke color', 'gowatch' ),
                                'desc'  => esc_html__( 'Choose a stroke (border) color', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'pointStrokeColor',
                                'std'   => '#ffffff'
                            ),

                            array(
                                'name'  => esc_html__( 'Point highlight fill', 'gowatch' ),
                                'desc'  => esc_html__( 'The fill color of the point on the chart.', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'pointHighlightFill',
                                'std'   => '#777'
                            ),

                            array(
                                'name'  => esc_html__( 'Point highlight stroke', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'pointHighlightStroke',
                                'std'   => '#ffffff'
                            ),

                            array(
                                'name'  => esc_html__( 'Data in format 25,35,45,...', 'gowatch' ),
                                'desc'  => esc_html__( 'Set the values for this line. Make sure you add the values in the exact order as the labels above. For example if you have the labels: label1,label2,label3 here you set the values for them in the same order: valueForLabelOne,valueForLabelTwo,valueForLabelThree', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'data',
                                'std'   => ''
                            ),
                        )
                    )
                )
            )
        );
    }

    static function chart_pie()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Pie chart', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-chart'
                    ),

                    array(
                        'name'    => esc_html__( 'Show a stroke on each segment', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'    => 'segmentShowStroke',
                        'std'   => 'true',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'  => esc_html__( 'The color of each segment stroke', 'gowatch' ),
                        'field' => 'input_color',
                        'id'    => 'segmentStrokeColor',
                        'std'   => '#fff',
                        'class' => 'airkit_segmentShowStroke-true'
                    ),

                    array(
                        'name'  => esc_html__( 'The width of each segment stroke (INTEGER)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'segmentStrokeWidth',
                        'std'   => 2,
                        'class' => 'airkit_segmentShowStroke-true'
                    ),

                    array(
                        'name'  => esc_html__( 'The percentage of the chart that we cut out of the middle (INTEGER)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'percentageInnerCutout',
                        'std'   => 50,
                    ),

                    array(
                        'name'  => esc_html__( 'Amount of animation steps (INTEGER)', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'animationSteps',
                        'std'   => 100,
                    ),

                    array(
                        'name'    => esc_html__( 'Animate the rotation of the Doughnut', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'    => 'animateRotate',
                        'std'   => 'true',
                        'class' => 'airkit_mode-pie'
                    ),

                    array(
                        'name'    => esc_html__( 'Animate scaling the Doughnut from the centre', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'true'  => esc_html__( 'Yes', 'gowatch' ),
                            'false' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'    => 'animateScale',
                        'std'   => 'false',
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 

                    array(
                        'name'     => esc_html__( 'Add New Item', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array(),
                        'class'    => 'airkit_mode-pie',
                        'options'  => array(

                            array(
                                'name'  => esc_html__( 'Label', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Value (INTEGER)', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'number',
                                'id'    => 'value',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Section background color', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'color',
                                'std'   => '#777'
                            ),

                            array(
                                'name'  => esc_html__( 'Section background color on hover', 'gowatch' ),
                                'field' => 'input_color',
                                'id'    => 'highlight',
                                'std'   => '#777'
                            ),
                        )
                    )
                )
            )
        );
    }

    static function gallery()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Gallery', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-gallery'
                    ),

                    array(
                        'name'  => esc_html__( 'Choose gallery style', 'gowatch' ), 
                        'field'   => 'select',
                        'options' => array(
                            'masonry'    => esc_html__( 'Masonry', 'gowatch' ),
                            'horizontal' => esc_html__( 'Horizontal scroll', 'gowatch' ),
                            'carousel' => esc_html__( 'Carousel', 'gowatch' ),
                        ),
                        'id'       => 'style',
                        'std'      => 'masonry',
                        'class_select' => 'airkit_trigger-options',
                    ),

                    'per-row' => array(
                        'name'    => esc_html__( 'Number of elements per row', 'gowatch' ),
                        'desc'    => esc_html__( 'Choose the number of elements you want to use per line. For example, if you want a grid of 3 items choose the 3 columns layout', 'gowatch' ),
                        'field'   => 'img_selector',
                        'options' => array(
                            1 => 1,
                            2 => 2,
                            3 => 3,
                            4 => 4,
                            6 => 6
                        ),
                        'img' => array(
                            1 => 'per_row_1.png',
                            2 => 'per_row_2.png',
                            3 => 'per_row_3.png',
                            4 => 'per_row_4.png',
                            6 => 'per_row_6.png',
                        ),
                        'id'       => 'per-row',
                        'std'      => 2,
                        'class'    => 'airkit_style-masonry'
                    ),

                    array(
                        'name'       => esc_html__( 'Upload images', 'gowatch' ),
                        'field'      => 'upload',
                        'media-type' => 'image',
                        'multiple'   => 'true',
                        'id'         => 'images',
                        'std'        => ''
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Image sizes', 'gowatch' ),
                'options' => array(
                    array(
                        'name'    => esc_html__( 'Width', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'      => 'width',
                        'std'     => '1000',
                    ),

                    array(
                        'name'    => esc_html__( 'Height', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'      => 'height',
                        'std'     => '650',
                        'class'   => 'airkit_style-horizontal'
                    ), 
                ),             
            ),         
        );
    }

    static function nona()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Nona post slider', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-gallery'
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Image sizes', 'gowatch' ),
                'options' => array(
                    array(
                        'name'  => esc_html__( 'Width', 'gowatch' ),
                        'desc'  => esc_html__( 'In this field you may set custom width for slider images.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'      => 'width',
                        'std'     => '800',
                    ),

                    array(
                        'name'  => esc_html__( 'Height', 'gowatch' ),
                        'desc'  => esc_html__( 'In this field you may set custom height for slider images.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'      => 'height',
                        'std'     => '450',
                    ), 
                ),             
            ),         
        );
    }

    static function boca()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Boca post slider', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-gallery'
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 
                )
            )
        );
    }

    static function grease()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Grease post slider', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-gallery'
                    ),

                    self::get_setting( 'post-type' ),
                    self::get_setting( 'category' ),
                    self::get_setting( 'gallery_categories' ),
                    self::get_setting( 'videos_categories' ),
                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),

                    array(
                        'name'    => esc_html__( 'Choose slider style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'zoom-in'   => esc_html__( 'ZoomIn Effect', 'gowatch' ),
                            'classic' => esc_html__( 'Classic', 'gowatch' ),
                        ),
                        'id'      => 'style',
                        'std'     => 'zoom-in'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                 
                )
            ),
            
        );
    }

    static function breadcrumbs()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Breadcrumbs', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-gallery'
                    )
                )
            )
        );
    }

    static function text()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Text', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-text'
                    ),

                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' ),                  

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'text',
                        'std'   => '',
                        'esc'   => array( 'airkit_Template', 'esc_text' )
                    ),
                )
            )
        );
    }

    static function pricing_tables()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Pricing tables', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-dollar'
                    ),

                    self::get_setting( 'per-row' ),
                    self::get_setting( 'gutter-space' ),

                    array(
                        'name'     => esc_html__( 'Add new item', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array(),
                        'options'  => array(

                            array(
                                'name'  => esc_html__( 'Add title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ), 

                            array(
                                'name'  => esc_html__( 'Add price', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'price',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add description', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'description',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add features', 'gowatch' ),
                                'desc'  => esc_html__( 'Add pricing table features, one per line', 'gowatch' ),
                                'field' => 'textarea',
                                'id'    => 'items',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add period', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'period',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Button URL', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'button-url',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Button text', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'button-text',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Set as featured (most popular)', 'gowatch' ),
                                'field'   => 'select',
                                'options' => array(
                                    'y' => esc_html__( 'Yes', 'gowatch' ),
                                    'n' => esc_html__( 'No', 'gowatch' )
                                ),
                                'id'    => 'featured',
                                'std'   => 'n'
                            ),

                            self::get_setting( 'reveal-effect' ),
                            self::get_setting( 'reveal-delay' ),
                        )
                    )
                )
            ),
        );
    } 

    static function pricelist()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Pricelist', 'gowatch' ),
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-dollar'
                    ),

                    self::get_setting( 'per-row' ),

                    array(
                        'name'    => esc_html__( 'Pricelist items style', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'image' => esc_html__( 'Item with image', 'gowatch' ),
                            'icon'  => esc_html__( 'Item with icon', 'gowatch' ),
                            'none'  => esc_html__( 'Item with text only', 'gowatch' ),
                        ),
                        'id'      => 'style',
                        'std'     => 'image',
                        'class_select' => 'airkit_trigger-options'
                    ),                 

                    array(
                        'name'     => esc_html__( 'Add new item', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array(),
                        'options'  => array(

                            array(
                                'name'  => esc_html__( 'Item title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'    => esc_html__( 'Choose an icon', 'gowatch' ),
                                'field'   => 'list_select',
                                'options' => self::get_icons(),
                                'id'      => 'icon',
                                'std'     => 'icon-noicon',
                                'class'   => 'airkit_style-icon'
                            ),

                            array(
                                'name'       => esc_html__( 'Upload image for this item', 'gowatch' ),
                                'field'      => 'upload',
                                'media-type' => 'image',
                                'multiple'   => 'false',
                                'id'         => 'image',
                                'std'        => '',
                                'class'      => 'airkit_style-image'
                            ),                         

                            array(
                                'name'  => esc_html__( 'Add description for this item', 'gowatch' ),
                                'field' => 'textarea',
                                'id'    => 'text',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add price for this item', 'gowatch' ),
                                'field' => 'input',
                                'id'    => 'price',
                                'type'  => 'text',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Enable modal for this item', 'gowatch' ),
                                'desc'  => esc_html__( 'When you click on item the modal will appear with extended content.', 'gowatch' ),
                                'field'   => 'select',
                                'options' => array(
                                    'y' => esc_html__( 'Yes', 'gowatch' ),
                                    'n' => esc_html__( 'No', 'gowatch' )
                                ),
                                'id'    => 'modal',
                                'std'   => 'n'
                            ),

                            array(
                                'name'  => esc_html__( 'Extended content for item', 'gowatch' ),
                                'field' => 'textarea',
                                'id'    => 'extended-text',
                                'std'   => '',
                            ),

                            array(
                                'name'  => esc_html__( 'Add your URL here', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'url',
                                'std'   => ''
                            ),

                            self::get_setting( 'reveal-effect' ),
                            self::get_setting( 'reveal-delay' ),
                        )
                    )
                )
            )
        );
    }


    static function slider()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Slider', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-desktop'
                    ),

                    array(
                        'name'    => esc_html__( 'Choose slider type', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'tilter-slider'     => esc_html__( 'Tilter slider', 'gowatch' ),
                            'flexslider'        => esc_html__( 'Flex slider', 'gowatch' ),
                            'slicebox'          => esc_html__( 'Slicebox', 'gowatch' ),
                            'bxslider'          => esc_html__( 'bxSlider', 'gowatch' ),
                            'parallax'          => esc_html__( 'Parallax slider', 'gowatch' ),
                            'stream'            => esc_html__( 'Stream slider', 'gowatch' ),
                            'corena'            => esc_html__( 'Corena slider', 'gowatch' ),
                            'klein'             => esc_html__( 'Klein slider', 'gowatch' ),
                            'vertical-slider'   => esc_html__( 'Vertical thumbs slider', 'gowatch' ),
                            'mambo'             => esc_html__( 'Mambo slider', 'gowatch' ),
                        ),
                        'id'           => 'type',
                        'std'          => 'flexslider',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'    => esc_html__( 'Slider source', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'latest-posts'       => esc_html__( 'Latest posts', 'gowatch' ),
                            'latest-galleries'   => esc_html__( 'Latest galleries', 'gowatch' ),
                            'latest-videos'      => esc_html__( 'Latest videos', 'gowatch' ),
                            'custom-slides'      => esc_html__( 'Custom slides', 'gowatch' ),
                        ),
                        'id'           => 'source',
                        'std'          => 'latest-posts',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    array(
                        'name'  => esc_html__( 'Posts to extract', 'gowatch' ),
                        'desc'  => esc_html__( 'This is the number of posts that will be extracted from the database and shown in total. If you use pagination, this will be the default posts number and on each new iteration this number of posts will be extracted again.', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'    => 'posts-limit',
                        'std'   => 4,
                        'class' => 'airkit_source-custom-slides airkit_revert-trigger'
                    ),

                    array(
                        'name'         => esc_html__( 'Tilt Hover Effect', 'gowatch' ),
                        'desc'         => esc_html__( 'Hover animations with a fancy tilt effect for each slide items.', 'gowatch' ),
                        'field'        => 'select',
                        'options'      => array(
                            'y'        => esc_html__('Yes','gowatch'),
                            'n'        => esc_html__('No','gowatch'),
                        ),
                        'id'           => 'tilt-hover-effect',
                        'std'          => 'y',
                        'class'        => 'airkit_type-tilter-slider'
                    ),

                    array(
                        'name'    => esc_html__( 'Show only featured posts', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'featured',
                        'std'      => 'n',
                        'class'   => 'airkit_source-custom-slides airkit_revert-trigger'
                    ),

                    array(
                        'name'     => esc_html__( 'Add new item', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'class'    => 'airkit_source-custom-slides',
                        'std'      => array(),
                        'options'  => array(

                            array(
                                'name'  => esc_html__( 'Add title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add slide URL', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'url',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Add Title for slide URL', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'url-title',
                                'std'   => ''
                            ),                         

                            array(
                                'name'  => esc_html__( 'Add content', 'gowatch' ),
                                'field' => 'textarea',
                                'id'    => 'text',
                                'std'   => ''
                            ),

                            self::get_setting( 'text-align' ),

                            array(
                                'name'       => esc_html__( 'Choose your slide image', 'gowatch' ),
                                'field'      => 'upload',
                                'media-type' => 'image',
                                'multiple'   => 'false',
                                'id'         => 'image-url',
                                'std'        => '',
                            )
                        )
                    )
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Image sizes', 'gowatch' ),
                'options' => array(

                    array(
                        'name'    => esc_html__( 'Width for large screens', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'      => 'width',
                        'std'     => '1200',
                    ),

                    array(
                        'name'    => esc_html__( 'Height for large screens', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'      => 'height',
                        'std'     => '450',
                    ), 

                    array(
                        'name'    => esc_html__( 'Width for small screens', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'      => 'width-sm',
                        'std'     => '400',
                    ),

                    array(
                        'name'    => esc_html__( 'Height for small screens', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'number',
                        'id'      => 'height-sm',
                        'std'     => '280',
                    ),                 
                ),             
            ),
        );
    }    

    static function events()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Events', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-text'
                    ),

                    array(
                        'name'         => esc_html__( 'Choose event category', 'gowatch' ),
                        'field'        => 'select',
                        'options'      => wp_list_pluck( get_categories( array( 'hide_empty' => 1, 'taxonomy' => 'event_categories' ) ), 'cat_name', 'slug' ),
                        'id'           => 'event_categories',
                        'class_select' => 'ts-custom-select-input',
                        'multiple'     => true,
                        'std'          => ''
                    ),

                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'featured' ),
                    self::get_setting( 'post__not_in' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'posts_per_page' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'order' ),
                    self::get_setting( 'pagination' ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                         
                )
            )
        );
    }

    static function list_products() 
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'List products', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    array(
                        'name'         => esc_html__( 'Choose product categories', 'gowatch' ),
                        'desc'         => esc_html__( 'Choose the categories that you want to showcase products from.', 'gowatch' ),
                        'field'        => 'select',
                        'options'      => wp_list_pluck( get_categories( array( 'hide_empty' => 0, 'taxonomy' => 'product_cat', 'pad_counts' => true ) ), 'cat_name', 'slug' ),
                        'id'           => 'product_cat',
                        'class_select' => 'ts-custom-select-input',
                        'multiple'     => true,
                        'std'          => ''
                    ),
                    
                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'orderby' ),
                    self::get_setting( 'offset' ),
                    self::get_setting( 'order' ),
                    self::get_setting( 'pagination' )
                )
            ),

            'styles' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Styles', 'gowatch' ),
                'options' => array(

                    array(
                        'name'    => esc_html__( 'Choose products behavior', 'gowatch' ),
                        'desc'    => esc_html__( 'Choose your posts behavior - you can have them just shown, or you can activate the carousel. If carousel is selected your articles will show up in a line with arrows for navigation. If masonry bahevior is selected - your articles will be arranged in to fit it. Be aware that activating the masonry option the crop settings for image sizes tab will be overwritten.', 'gowatch' ),
                        'field'   => 'img_selector',
                        'options' => array(
                            'normal'   => 'normal',
                            'carousel' => 'carousel',
                            'masonry'  => 'masonry',

                        ),
                        'img' => array(
                            'normal'   => 'behavior_none.png',
                            'carousel' => 'behavior_carousel.png',
                            'masonry'  => 'behavior_masonry.png',
                        ),

                        'id'           => 'behavior',
                        'std'          => 'normal',
                        'class_select' => 'airkit_trigger-options'
                    ),

                    self::get_setting( 'carousel-nav' ),
                    self::get_setting( 'carousel-scroll' ),
                    self::get_setting( 'carousel-autoplay' ),                   

                    self::get_setting( 'per-row' ),
                    self::get_setting( 'reveal-effect' ),
                    self::get_setting( 'reveal-delay' )                    
                )
            )
        );        
    }

    static function list_users() 
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'List users', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-users',
                    ),

                    array(
                        'name'         => esc_html__( 'Criteria', 'gowatch' ),
                        'desc'         => esc_html__( 'Users will show by specific criteria that you have selected.', 'gowatch' ),
                        'field'        => 'select',
                        'options'      => array(
                            'latest'       => esc_html__('Latest','gowatch'),
                            'most-posts'   => esc_html__('Number of posts','gowatch'),
                            'top-rated'    => esc_html__('Top rated','gowatch'),
                            'most-liked'   => esc_html__('Most liked','gowatch'),
                        ),
                        'id'           => 'criteria',
                        'std'          => 'latest'
                    ),
                    
                    self::get_setting( 'posts-limit' ),
                    self::get_setting( 'per-row' ),
                )
            ),

        );        
    }

    static function mosaic_images()
    {
        return array(

            'general' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'General', 'gowatch' ),
                'options' => array(

                    array(
                        'name'  => esc_html__( 'Admin label', 'gowatch' ),
                        'field' => 'input',
                        'type'  => 'text',
                        'id'    => 'admin-label',
                        'std'   => esc_html__( 'Mosaic images', 'gowatch' )
                    ),

                    array(
                        'name'  => '',
                        'field' => 'input',
                        'type'  => 'hidden',
                        'id'    => 'element-icon',
                        'std'   => 'icon-coverflow',
                    ),

                    array(
                        'name'    => esc_html__( 'Choose style of images', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'rectangles' => esc_html__( 'Rectangles', 'gowatch' ),
                            'square'     => esc_html__( 'Squares', 'gowatch' ),
                            'style-3'    => esc_html__( 'Style 3', 'gowatch' )
                        ),
                        'id'           => 'layout',
                        'std'          => 'rectangles',
                    ),            

                    array(
                        'name'    => esc_html__( 'Enable spacing between posts', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'       => 'gutter',
                        'std'      => 'y'
                    ),

                    array(
                        'name'    => esc_html__( 'How to display post content', 'gowatch' ),
                        'desc'    => esc_html__( 'If you choose Display always, post title, categories and excerpt will be always visible. If you choose to display them on hover, they will only show up when user hovers the article.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'always' => esc_html__( 'Display always', 'gowatch' ),
                            'hover'  => esc_html__( 'Display on hover', 'gowatch' ),
                        ),
                        'id'           => 'hover-style',
                        'std'          => 'always',
                    ),                  


                    array(
                        'name'    => esc_html__( 'How to display titles', 'gowatch' ),
                        'desc'    => esc_html__( 'Choose how to display titles. If you choose Titles with link option, the titles will be used as link. If you choose Convert titles to buttons, the titles will be displayed as buttons with URL.', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'title'   => esc_html__( 'Titles with link', 'gowatch' ),
                            'button'  => esc_html__( 'Convert titles to buttons', 'gowatch' ),
                        ),
                        'id'           => 'link-style',
                        'std'          => 'title',
                    ),                 

                    array(
                        'name'     => esc_html__( 'Add new item', 'gowatch' ),
                        'field'    => 'tmpl',
                        'id'       => 'items',
                        'sortable' => 'true',
                        'std'      => array(),
                        'options'  => array(

                            array(
                                'name'       => esc_html__( 'Upload image', 'gowatch' ),
                                'field'      => 'upload',
                                'media-type' => 'image',
                                'multiple'   => 'false',
                                'id'         => 'image',
                                'std'        => '',
                            ),

                            array(
                                'name'  => esc_html__( 'Add title', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'title',
                                'std'   => ''
                            ),

                            array(
                                'name'  => esc_html__( 'Redirect URL', 'gowatch' ),
                                'field' => 'input',
                                'type'  => 'text',
                                'id'    => 'url',
                                'std'   => ''
                            ),

                            self::get_setting( 'target' ),
                        )
                    ),


                ),
            ),
        );
    }

    static function general( $settings, $type, $show = true )
    {

        if ( $type == 'import' ) return $settings;

        $settings['general']['options'] = array_merge( $settings['general']['options'], array(

                array(
                    'name'  => '',
                    'field' => 'input',
                    'type'  => 'hidden',
                    'id'    => 'element-type',
                    'std'   => $type
                )
            )
        );

        $settings['general']['options'] = array_merge( $settings['general']['options'], array(

            array(
                'name'  => esc_html__( 'Custom classes', 'gowatch' ),
                'field' => 'input',
                'type'  => 'text',
                'id'    => 'custom-classes',
                'std'   => ''
            )

        ) );

        $settings = array_merge( $settings, array(

            'responsive' => array(
                'field'   => 'tab',
                'title'   => esc_html__( 'Responsiveness', 'gowatch' ),
                'options' => array(

                    array(
                        'name'    => esc_html__( 'Show on large devices', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'  => 'lg',
                        'std' => 'y'
                    ),

                    array(
                        'name'    => esc_html__( 'Show on tablet landscape', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'  => 'md',
                        'std' => 'y'
                    ),

                    array(
                        'name'    => esc_html__( 'Show on tablet portrait', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'  => 'sm',
                        'std' => 'y'
                    ),

                    array(
                        'name'    => esc_html__( 'Show on mobile', 'gowatch' ),
                        'field'   => 'select',
                        'options' => array(
                            'y' => esc_html__( 'Yes', 'gowatch' ),
                            'n' => esc_html__( 'No', 'gowatch' )
                        ),
                        'id'  => 'xs',
                        'std' => 'y'
                    ),
                )
            )
        ) );

        if ( ! $show ) {

            $settings['general']['options'] = array_merge( array(

                array(
                    'name'  => 'Allow adderess input to pass validation in temlate class',
                    'field' => 'input',
                    'type'  => 'text',
                    'id'    => 'address',
                    'std'   => ''
                )

            ), $settings['general']['options'] );
        }

        return $settings;
    }

    static function modal_fields( $type )
    {

        if ( empty( $type ) ) {

            echo esc_html__( 'Element type is empty.', 'gowatch' );

            return;
        }

        $blocks = call_user_func( array( __CLASS__, str_replace( '-', '_', $type ) ) );

        $blocks = self::general( $blocks, $type );

        $li = '';
        $content = '';

        echo
            '<div class="airkit_element-settings">';

                foreach ( $blocks as $block ) {

                    $li .= '<li>' . $block['title'] . '</li>';

                    ob_start(); ob_clean();

                        echo '<div class="airkit_tab-content">';

                            foreach ( $block['options'] as $field ) {

                                if ( ! isset( $field['field'] ) ) continue;

                                if ( method_exists( __CLASS__, $field['field'] ) ) {

                                    call_user_func( array( __CLASS__, $field['field'] ) );

                                } else {

                                    call_user_func( array( 'airkit_Fields', $field['field'] ), $field, array() );
                                }
                            }

                        echo '</div>';

                    $content .= ob_get_clean();
                }

                echo '
                <ul class="airkit_tabs">' . $li . '</ul>
                <div class="airkit_tabs-content">' . $content . '</div>
            </div>';
    }

    static function render_map()
    {   ?>
        <style type="text/css">
            html, body, #map-canvas {
                width: 100%;
                height: 360px;
                margin: 0px;
                padding: 0px
            }
            #panel {
                z-index: 5;
                background-color: #fff;
                padding: 5px;
            }
        </style>
        <div id="panel" style="width:100%;">
            <input id="address" type="text" placeholder="<?php esc_html_e( 'Enter your address', 'gowatch' ); ?>" name="address">
            <input class="ts-secondary-button airkit_find-address" type="button" value="<?php esc_html_e( 'Find address', 'gowatch' ) ?>" onclick="codeAddress()">
        </div>

        <div id="map-canvas"></div>
        <?php
    }
}

// End.