<?php
class airkit_widget_touchsize_facebook extends WP_Widget
{

  function __construct()
  {
    $widget_ops = array('classname' => 'airkit_widget_touchsize_facebook', 'description' => 'This is a Facebook like box and posts widget.' );
    parent::__construct('airkit_widget_touchsize_facebook', 'Facebook Like & Feed', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$pageurl = isset( $instance['pageurl'] ) ? esc_attr( $instance['pageurl'] ) : '';
	$showfaces = isset( $instance['showfaces'] ) ? esc_attr( $instance['showfaces'] ) : '';
	$showstream = isset( $instance['showstream'] ) ? esc_attr( $instance['showstream'] ) : '';
	//$showheader = isset( $instance['showheader'] ) ? esc_attr( $instance['showheader'] ) : '';					
	$likebox_height = isset( $instance['likebox_height'] ) ? esc_attr( $instance['likebox_height'] ) : '';						
?>
  <p>
  <label for="<?php echo airkit_var_sanitize( $this->get_field_id('title'), 'esc_attr' ); ?>">
	 <?php esc_html_e('Title:','gowatch');?>  
	  <input class="upcoming" id="<?php echo airkit_var_sanitize( $this->get_field_id('title'), 'esc_attr' ); ?>" size='40' name="<?php echo airkit_var_sanitize( $this->get_field_name('title'), 'esc_attr' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
  </label>
  </p> 
  <p>
  <label for="<?php echo airkit_var_sanitize( $this->get_field_id('pageurl'), 'esc_attr' ); ?>">
	  <?php esc_html_e('Page URL:','gowatch');?> 
	  <input class="upcoming" id="<?php echo airkit_var_sanitize( $this->get_field_id('pageurl'), 'esc_attr' ); ?>" size='40' name="<?php echo airkit_var_sanitize( $this->get_field_name('pageurl'), 'esc_attr' ); ?>" type="text" value="<?php echo esc_attr($pageurl); ?>" />
	<br />
      <small><?php esc_html_e('Please enter your page url. Example: https://www.facebook.com/touchsize','gowatch');?>
	</small><br />
  </label>
  </p> 
  <p>
  <label for="<?php echo airkit_var_sanitize( $this->get_field_id('showfaces'), 'esc_attr' ); ?>">
	  <?php esc_html_e('Show Faces:','gowatch');?>
	  <select id="<?php echo airkit_var_sanitize( $this->get_field_id('showfaces'), 'esc_attr' ); ?>" name="<?php echo airkit_var_sanitize( $this->get_field_name('showfaces'), 'esc_attr' ); ?>">
			<option <?php if($showfaces == 'true'){echo 'selected';}?> value="true"><?php esc_html_e('Yes','gowatch');?></option>
			<option <?php if($showfaces == 'false'){echo 'selected';}?> value="false"><?php esc_html_e('No','gowatch');?></option>
      </select>
  </label>
  </p>  
  <p>
  <label for="<?php echo airkit_var_sanitize( $this->get_field_id('showstream'), 'esc_attr' ); ?>">
	  <?php esc_html_e('Show Stream:','gowatch');?> 
	   <select id="<?php echo airkit_var_sanitize( $this->get_field_id('showstream'), 'esc_attr' ); ?>" name="<?php echo airkit_var_sanitize( $this->get_field_name('showstream'), 'esc_attr' ); ?>" style="width:225px">
			<option <?php if($showstream == 'true'){echo 'selected';}?> value="true"><?php esc_html_e('Yes','gowatch');?></option>
			<option <?php if($showstream == 'false'){echo 'selected';}?> value="false"><?php esc_html_e('No','gowatch');?></option>
      </select>
  </label>
  </p> 
  
  <p>
  <label for="<?php echo airkit_var_sanitize( $this->get_field_id('likebox_height'), 'esc_attr' ); ?>">
	  <?php esc_html_e('Like Box Height:','gowatch');?>
	  <input class="upcoming" id="<?php echo airkit_var_sanitize( $this->get_field_id('likebox_height'), 'esc_attr' ); ?>" size='2' name="<?php echo airkit_var_sanitize( $this->get_field_name('likebox_height'), 'esc_attr' ); ?>" type="text" value="<?php echo esc_attr($likebox_height); ?>" />
  </label>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['pageurl'] = $new_instance['pageurl'];
	$instance['showfaces'] = $new_instance['showfaces'];	
	$instance['showstream'] = $new_instance['showstream'];
	$instance['showheader'] = $new_instance['showheader'];	
	$instance['likebox_height'] = $new_instance['likebox_height'];			
    return $instance;
  }
 
	function widget($args, $instance)
	{
		
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$pageurl = empty($instance['pageurl']) ? ' ' : apply_filters('widget_title', $instance['pageurl']);
		$showfaces = empty($instance['showfaces']) ? ' ' : apply_filters('widget_title', $instance['showfaces']);
		$showstream = empty($instance['showstream']) ? ' ' : apply_filters('widget_title', $instance['showstream']);
		$showheader = empty($instance['showheader']) ? ' ' : apply_filters('widget_title', $instance['showheader']);													
		$likebox_height = empty($instance['likebox_height']) ? ' ' : apply_filters('widget_title', $instance['likebox_height']);													
		
		echo airkit_var_sanitize( $before_widget, 'the_kses' );	
		// WIDGET display CODE Start
		if (!empty($title))
			echo airkit_var_sanitize( $before_title, 'the_kses' );
			echo airkit_var_sanitize( $title, 'the_kses' );
			echo airkit_var_sanitize( $after_title, 'the_kses' );
			global $wpdb, $post;?>
			<?php	
			if($likebox_height == ' ' || $likebox_height == ''){$likebox_height = '315';}
			?>         

			<div class="fb-like-box" data-href="<?php echo airkit_var_sanitize( $pageurl, 'esc_url' );?>" data-width="340" data-height="<?php echo airkit_var_sanitize($likebox_height);?>" data-adapt-container-width="true" data-show-faces="<?php echo airkit_var_sanitize( $showfaces, 'esc_attr' );?>" data-header="false" data-stream="<?php echo airkit_var_sanitize( $showstream, 'esc_attr' );?>" data-show-border="false"></div>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
	<?php echo airkit_var_sanitize( $after_widget, 'the_kses' );
		}
		
	}