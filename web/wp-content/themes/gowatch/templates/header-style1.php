<?php
/**
 * The template for displaying Header Style 1
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

// Custom menu options
$menu_options = array(
	'styles' => 'horizontal',
	'bg-color' => 'transparent',
	'bg-color-hover' => 'transparent',
	'text-color' => '#000000',
	'text-color-hover' => airkit_get_color('primary_color'),
	'submenu-bg-color' => '#ffffff',
	'submenu-bg-color-hover' => airkit_get_color('primary_color'),
	'submenu-text-color' => '#030303',
	'submenu-text-color-hover' => airkit_get_color('primary_text_color_hover'),
	'font-type' => 'std',
	'icons' => 'n',
	'description' => 'n',
	'text-align' => 'center',
	'submenu-alignment' => 'left',
	'menu-id' => $menu_slug,
);

echo '<h1 class="hidden">'. get_bloginfo('name') .'</h1>';
?>
<div class="airkit_header-style1">
	<div class="container">
		<div class="row">
			<div class="airkit_table-content">
				<?php
					echo airkit_Compilator::social_buttons_element( array('text-align' => 'left', 'style' => 'iconed', 'labels' => 'n', 'columns' => 'col-md-4 col-sm-4 cell-item') );
					echo airkit_Compilator::logo_element( array('align' => 'text-center', 'columns' => 'col-md-4 col-sm-4 cell-item') );
					echo airkit_Compilator::searchbox_element( array('align' => 'right', 'columns' => 'col-md-4 col-sm-4 cell-item') );
				?>
			</div>
			<?php echo airkit_Compilator::menu_element($menu_options); ?>
		</div>
	</div>
</div>