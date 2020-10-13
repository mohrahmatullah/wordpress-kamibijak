<?php
/**
 * The template for displaying Header Style 4
 *
 * @package WordPress
 * @subpackage goWatch
 * @since goWatch 1.0
 */

$menu_name = 'primary';
$locations = get_theme_mod( 'nav_menu_locations' );
$menu_id = isset($locations[ $menu_name ]) ? $locations[ $menu_name ] : '';
$menu = wp_get_nav_menu_object($menu_id);
$menu_slug = is_object($menu) ? $menu->slug : '';
$random_ID = airkit_rand_string();
$ajax_nonce = wp_create_nonce( 'ajax_airkit_search_live_results' );

$header_options = airkit_option_value('header_settings', 'options');
$class = '';

// Custom menu options
$menu_options = array(
	'styles' => 'horizontal',
	'bg-color' => 'transparent',
	'bg-color-hover' => 'transparent',
	'text-color' => '#2a2a2a',
	'text-color-hover' => airkit_get_color('primary_color'),
	'submenu-bg-color' => '#212121',
	'submenu-bg-color-hover' => '#292929',
	'submenu-text-color' => '#FFFFFF',
	'submenu-text-color-hover' => '#f8f8f8',
	'font-type' => 'std',
	'icons' => 'n',
	'description' => 'y',
	'text-align' => 'left',
	'submenu-alignment' => 'left',
	'add-search' => 'n',
	'menu-id' => $menu_slug,
	'columns' => 'col-md-7 cell-item',
);

if ( isset($header_options['header4_sticky']) && 'y' == $header_options['header4_sticky'] ) {
	$class = 'is-sticky';
}

echo '<h1 class="hidden">'. get_bloginfo('name') .'</h1>';
?>
<div class="airkit_header-style4 <?php echo esc_attr($class); ?>">
	<div id="search-outer">
		<div class="container">
			<div class="searchbox">
				<form method="get" id="<?php echo esc_attr($random_ID) ?>" class="searchbox-live-results-form" role="search" action="<?php echo home_url( '/' ) ?>">
					<input type="hidden" name="wpnonce" value="<?php echo esc_attr($ajax_nonce) ?>">
					<div class="input-group">
						<input  class="input" 
								name="s" 
								type="text" 
								id="keywords-<?php echo esc_attr($random_ID) ?>" 
								placeholder="<?php echo esc_html__( 'Search here', 'gowatch' ) ?>"/>
						<div class="input-group-btn">
							<span class="ajax-loader"><img src="<?php echo get_template_directory_uri() . '/images/ajax-loader.gif' ?>" alt="Loader"></span>
						</div>
					</div>
				</form>
				<div class="ajax-live-results"></div>
			</div>
		</div>
		<a href="#" class="search-close" data-target="#search-outer"><i class="icon-close"></i></a>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="airkit_table-content">
				<?php
					echo airkit_Compilator::logo_element( array('align' => 'text-left', 'columns' => 'cell-item') );
					echo airkit_Compilator::menu_element($menu_options);
					echo airkit_Compilator::social_buttons_element( array( 'columns' => 'col-md-4 cell-item', 'labels' => 'n', 'text-align' => 'right', 'style' => 'iconed' ) );
				?>
				<div class="cell-item">
					<div class="searchbox">
						<a href="#" class="search-trigger" data-target="#search-outer"><i class="icon-search"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>