<?php
/*
 | Class for handling images related business
 */

class Airkit_Images
{
	public $imageSizes = array();
	protected $requestedSize;

	public function __construct()
	{

		$this->set_image_sizes_defaults();

		// default requested size (fallback)
		$this->requestedSize = 'gowatch_grid';

		add_action( 'after_setup_theme', array( &$this, 'action_set_post_thumbnail_size' ) );
		add_action( 'after_setup_theme', array( &$this, 'action_add_image_sizes' ) );
		add_filter( 'post_thumbnail_html', array( &$this, 'filter_post_thumbnail_html' ) );
		add_filter( 'wp_get_attachment_image_attributes', array( &$this, 'filter_lazy_image_attributes' ), 10, 3 );
		add_filter( 'post_thumbnail_size', array( &$this, 'filter_save_requested_thumbnail_size' ) );
	}

	/*
	 | Define default image sizes.
	 */
	public function set_image_sizes_defaults()
	{
		$theme_set_sizes = airkit_option_value( 'sizes' );
		$imageSizeOptions = isset( $theme_set_sizes ) && $theme_set_sizes != '' ? airkit_option_value( 'sizes' ) : array();
		
		$imageSizesDefaults = [
			// This are just default values, once users edit image sizes in theme options and then save options, this options will be automatically overwritten.

			// Aspect Ration 1:1
			'gowatch_small' => [
				'width'  => '160',
				'height' => '160',
				'mode'   => 'crop'
			],
			// Aspect Ration 16:9
			'gowatch_grid' => [
				'width'  => '640',
				'height' => '360',
				'mode'   => 'crop'
			],
			// Aspect Ration 16:9
			'gowatch_grid_masonry' => [
				'width'  => '640',
				'height' => '360',
				'mode'   => 'resize'
			],
			// Aspect Ration 16:9
			'gowatch_wide' => [
				'width'  => '700',
				'height' => '394',
				'mode'   => 'crop'
			],
			// Aspect Ration 16:9
			'gowatch_single' => [
				'width'  => '1280',
				'height' => '720',
				'mode'   => 'resize'
			],			
		];

		if( isset( $imageSizeOptions ) ) {

			$this->imageSizes = array();

			$this->imageSizes = array_merge( $imageSizesDefaults, $imageSizeOptions );

		} else {

			$this->imageSizes = array();

			$this->imageSizes = $imageSizesDefaults;
			
		}

	}

	// class, attr
	public static function lazy_background( $image_url )
	{
		if( 'y' == airkit_option_value( 'general', 'enable_imagesloaded' ) ){
			return 'data-original="'. $image_url .'"';
		}
	}

	/*
	 | Set theme image sizes.
	 */
	public function action_add_image_sizes()
	{
		if ( is_array( $this->imageSizes ) && ! empty( $this->imageSizes ) ) {

			// Loop through imageSizes and add_image_size for each.
			foreach ( $this->imageSizes as $name => $sizes ) {

				$crop = $sizes['mode'] == 'crop' ? true : false;

				add_image_size( $name, (int)$sizes['width'], (int)$sizes['height'], $crop );

			}
		}

	}

	/*
	 | Set post thumbnail size. (edit post screen)
	 */
	public function action_set_post_thumbnail_size()
	{
    	set_post_thumbnail_size( 400, 400, TRUE );
	}

	/*
	 | Filters 'the_post_thumbnail'. Use later for adding gif placeholder or any additional output.
	 */
	public function filter_post_thumbnail_html( $html, $post_ID = null, $post_thumbnail_id = null, $size = null, $attr = null )
	{
		return $html;
	}

	/*
  	 | Save requested thumbnail size. This value is used to retrieve lazyload placeholder with this size.
	 */
	 public function filter_save_requested_thumbnail_size( $size )
	 {
	 	$this->requestedSize = $size;
	 	return $size;
	 }

	/*
	 | Checks if lazyload is enabled and add needed data attributes and classes.
	 | Should check for placeholder and use palceholder if present.
	 */
	public function filter_lazy_image_attributes( $attr, $attachment, $size = '' )
	{

		if( is_admin() ) return $attr;

        if ( function_exists('is_amp_endpoint') && is_amp_endpoint() ) return $attr;
        
		// Define image classes that should not be affected by lazyload
		$ignoreLazyLoad = [ 'custom-logo', 'lazy-ignor' /*, ...define your classes here */ ];

		/*
		 | Checks if image has one of classes that are ignored by lazyload
		 */
		$isImageLazyIgnored = !empty( array_intersect( $ignoreLazyLoad , explode( ' ', $attr['class'] ) ) );

		if( $isImageLazyIgnored ) 
			return $attr;

		/*
 		 | Check mime type
		 */
		global $post;

		$mime_type = get_post_mime_type( $attachment->ID );

		if( 'image/gif' == $mime_type ) {
			if ( get_the_post_thumbnail_url( $post->ID, 'full' ) ) {
				$attr['src'] = get_the_post_thumbnail_url( $post->ID, 'full' );
			}
		}

		if( 'y' == airkit_option_value( 'general', 'enable_imagesloaded' ) ){

		    $attr['data-original'] = $attr['src'];

		    if( isset( $attr['srcset'] ) ) {

		    	$attr['data-original-set'] = $attr['srcset'];

		    }

		    if ( isset( $attr['alt'] ) && empty( $attr['alt'] ) && isset( $post->ID ) ) {
		    	$attr['alt'] = get_the_title( $post->ID );
		    }

		    $attr['class'] .= ' lazy ' ;

		    // Unset 'src', 'srcset', 'sizes' attributes.
		    unset( $attr['src'], $attr['srcset'] );

		    // Check if placeholder is set.
		    $placeholder = airkit_option_value( 'styles', 'lazy_placeholder' );

			if( !empty( $placeholder ) && isset($placeholder_metadata['width']) && isset($placeholder_metadata['height']) ) {

				$placeholder_url = airkit_Compilator::get_attachment_field( $placeholder, 'url', $this->requestedSize );
				$placeholder_metadata = airkit_Compilator::get_attachment_field( $placeholder, 'metadata', $this->requestedSize );
				$placeholder_srcset = wp_calculate_image_srcset( array( $placeholder_metadata['width'], $placeholder_metadata['height']), $placeholder_url, $placeholder_metadata );

				//Placeholder URL
				$attr['src'] = $placeholder_url;

				if ( isset($attr['sizes']) ) {
					$attr['srcset'] = $placeholder_srcset;
				}

	        }
	    }
	    
	    return $attr;
	}

	/**
	 * Get featured image.
	 * @param int post Id
	 * @param array options
	 *
	 * options['resize'] char   This parameter is used when providing a hard-coded size for image. 
	 *							If is set, assume to also provide next parameters:
	 *  -> options['w']  int    Width
	 *  -> options['h']  int    Height
	 *  -> options['c']  bool   Crop parameter. If true, images will be cropped, otherwise will be resized.
	 *
	 * options['url']  char     If set to 'y' , only url of image will be returned (instead of img tag)
	 */
	static function featimage( $post_ID, $options = array() ) 
	{
		$image = '';
		$url = '';	
		$size = '';
		$gif_output = '';

		// Get lazyload placeholder
		$placeholder = airkit_option_value( 'styles', 'lazy_placeholder' );
		// Set placeholder_img index in options
		$options['placeholder_img'] = '';

		if( !empty( $placeholder ) ) {

			//Placeholder URL
			$options['placeholder_img'] = airkit_Compilator::get_attachment_field( $placeholder );
        }

		if( has_post_thumbnail( $post_ID ) ) {
			
			$url = wp_get_attachment_url( get_post_thumbnail_id( $post_ID ) );
			
			/*
			 * $options['att_id'].
			 * Used in @lazy_img to set width & height attributes
			 */
			$options['att_id'] = get_post_thumbnail_id( $post_ID );

			$image = '<img ' . self::lazy_img( $url, $options ) . ' alt="' . esc_attr( get_the_title($post_ID) ) . '" />';				

		} 

		/*
		 * Return URL instead of <img>
		 */
		if( isset( $options['url'] ) && 'y' === $options['url'] ) {

			$url = self::resize_img( $url, $options );
			
			return $url;
		}

  		/*
  		 * Return <img>
  		 */
		return $image;
	}

	/**
     * Lazyload placeholder
     * @param string $url Image url
     * @param Array $options Element options that have been passed to @featimage.
	 */
	static function lazy_img( $img_url = '', $options = array() )
	{	
		//Is lazyload enabled.
		$lazyload_enabled = airkit_option_value( 'general', 'enable_imagesloaded' );
		
		// Get lazyload placeholder
		if ( !isset($options['placeholder_img']) ) {
			
			$size =  'gowatch_grid';

			if( isset( $options['size'] ) ) {
				$size = $options['size'];
			}
			$placeholder = airkit_option_value( 'styles', 'lazy_placeholder' );
			$options['placeholder_img'] = airkit_Compilator::get_attachment_field( $placeholder, 'url', $size );

		}

		// Placeholder SRC
		$placeholder_src = !empty( $options['placeholder_img'] ) ? 'src="'. self::resize_img( $options['placeholder_img'], $options ) .'"' : '';

        /*
		 * Resize image URL.
         */

	    $img_url = self::resize_img( $img_url, $options );

        if( $lazyload_enabled == 'y' ){

        	$src = 'class="lazy" ' . $placeholder_src . ' data-original="'. esc_url( $img_url ) .'"';

        } else {

            $src = 'src="'. esc_url( $img_url ) .'"';
        }


        return $src;        
	}


	/**
	 * Returns resized images depending on passed $options.
	 * @param String img_url Original image url.
	 * @param Array 
	 */

	static function resize_img( $img_url, $options )
	{
		if( isset( $options['resize'] ) && 'y' === $options['resize'] ) {

			$w = isset( $options['w'] ) ? $options['w'] : 9999;
			$h = isset( $options['h'] ) ? $options['h'] : 9999;
			$c = isset( $options['c'] ) ? $options['c'] : false;

			$img_url = aq_resize( $img_url, $w, $h, $c, true );

		}

		return esc_url( $img_url );
	}	
}