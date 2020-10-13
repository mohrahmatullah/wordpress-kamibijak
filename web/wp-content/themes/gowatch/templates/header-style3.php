<?php
/**
 * The template for displaying Header Style 3
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

$header_options = airkit_option_value('header_settings', 'options');

// Custom menu options
$menu_options = array(
	'styles' => 'horizontal',
	'bg-color' => '#2a2a2a',
	'bg-color-hover' => airkit_get_color('primary_color'),
	'text-color' => '#ffffff',
	'text-color-hover' => airkit_get_color('primary_text_color_hover'),
	'submenu-bg-color' => '#ffffff',
	'submenu-bg-color-hover' => airkit_get_color('primary_color'),
	'submenu-text-color' => '#030303',
	'submenu-text-color-hover' => airkit_get_color('primary_text_color_hover'),
	'font-type' => 'std',
	'icons' => 'n',
	'description' => 'n',
	'text-align' => 'left',
	'add-search' => 'y',
	'append-search' => 'append',
	'submenu-alignment' => 'left',
	'menu-id' => $menu_slug,
);

echo '<h1 class="hidden">'. get_bloginfo('name') .'</h1>';
?>
<div class="airkit_header-style3">
	<div class="container">
		<div class="row">
			<div class="airkit_table-content">
				<?php
					echo airkit_Compilator::logo_element( array('align' => 'text-left', 'columns' => 'col-md-3 col-sm-3 cell-item') );
					echo airkit_Compilator::advertising_element( array('columns' => 'col-md-9 col-sm-9 cell-item', 'advertising' => $header_options['header3_banner']) );
				?>
			</div>
			<?php echo airkit_Compilator::menu_element($menu_options); ?>
		</div>
	</div>
</div>