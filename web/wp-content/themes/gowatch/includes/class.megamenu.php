<?php

if ( ! class_exists( 'airkit_Is_Megamenu' ) ) {

	class airkit_Is_Megamenu
	{
		function __construct()
		{
			// exchange arguments and tell menu to use the ts walker for front end rendering
			add_filter( 'wp_nav_menu_args', array( &$this, 'modify_arguments' ), 100 );

			// exchange argument for backend menu walker
			add_filter( 'wp_edit_nav_menu_walker', array( &$this,'modify_backend_walker') , 100 );

			// save ts options
			add_action( 'wp_update_nav_menu_item', array( &$this, 'update_menu' ), 100, 3 );

			//hook into wordpress admin.php
			add_action('wp_ajax_airkit_ajax_switch_menu_walker', array( &$this, 'ajax_switch_menu_walker' ) );
		}

		function ajax_switch_menu_walker()
	    {
			if ( ! current_user_can( 'edit_theme_options' ) ) die( '-1' );

			check_ajax_referer( 'add-menu_item', 'menu-settings-column-nonce' );

			require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

			$item_ids = wp_save_nav_menu_items( 0, $_POST['menu-item'] );

			if ( is_wp_error( $item_ids ) ) die( '-1' );

			foreach ( (array)$item_ids as $menu_item_id ) {

				$menu_obj = get_post( $menu_item_id );

				if ( ! empty( $menu_obj->ID ) ) {

					$menu_obj = wp_setup_nav_menu_item( $menu_obj );
					$menu_obj->label = $menu_obj->title; // don't show "(pending)" in ajax-added items
					$menu_items[] = $menu_obj;
				}
			}

			if ( ! empty( $menu_items ) ) {

				$args = array(
					'after'       => '',
					'before'      => '',
					'link_after'  => '',
					'link_before' => '',
					'walker'      => new airkit_backend_walker
				);

				echo walk_nav_menu_tree( $menu_items, 0, (object)$args );
			}

			die( 'end' );
		}

		/**
		 * Replaces the default arguments for the front end menu creation with new ones
		 */
		function modify_arguments( $arguments )
		{
			$arguments['walker'] 		  = new airkit_Walker();
			$arguments['menu_class']	  = 'nav navbar-nav';

			return $arguments;
		}

		/**
		 * Tells wordpress to use our backend walker instead of the default one
		 */
		function modify_backend_walker($name)
		{
			return 'airkit_backend_walker';
		}

		/*
		 * Save and Update the Custom Navigation Menu Item Properties by checking all $_POST vars with the name of $check
		 * @param int $menu_id
		 * @param int $menu_item_db
		 */
		function update_menu( $menu_id, $menu_item_db )
		{
			$keys = array( 'type', 'posts', 'columns-posts', 'count-posts', 'icon', 'columns', 'useascontent', 'direction' );

			foreach ( $keys as $key ) {

				$value = isset( $_POST['menu-item-ts-' . $key ][ $menu_item_db ] ) ? $_POST['menu-item-ts-' . $key ][ $menu_item_db ] : '';			

				update_post_meta( $menu_item_db, '_menu-item-ts-' . $key, $value );
			}
		}
	}
}

if ( ! class_exists( 'airkit_Walker' ) ) {

	/**
	 * The ts walker is the frontend walker and necessary to display the menu, this is a advanced version of the wordpress menu walker
	 * @package WordPress
	 * @since 1.0.0
	 * @uses Walker
	 */
	class airkit_Walker extends Walker {

		/**
		 * @see Walker::$db_fields
		 * @todo Decouple this.
		 * @var array
		 */
		var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

		var $storage = array( 'nav-tabs' => '', 'content' => '', 'columns-inner-tabs' => '' );

		// Type of group items it can be category tabs, standard items, or megamenu.
		var $group = 'default';

		/**
		 * @see Walker::start_lvl()
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of page. Used for padding.
		 */
		function start_lvl( &$output, $depth = 0, $args = array() )
		{
			if ( 'tabs' == $this->group ) {

				if ( $depth >= 2 ) {

					$output .= '<ul class="sub-menu">';
				}

			} elseif ( 'mega' == $this->group ) {

				if ( $depth == 0 ) {

					$output .= '<ul class="dropdown-menu airkit_menu-tabs"><li><div class="airkit_menu-content"><ul class="row">';

				} else {

					$output .= '<ul class="sub-menu box">';
				}

			} else {

				$output .= '<ul class="dropdown-menu sub-menu">';
			}
		}

		/**
		 * @see Walker::end_lvl()
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of page. Used for padding.
		 */
		function end_lvl( &$output, $depth = 0, $args = array() )
		{
			if ( $this->group == 'tabs' ) {

				if ( $depth >= 2 ) {

					$output .= '</ul>';
				}

			} elseif ( $this->group == 'mega' ) {

				if ( $depth == 0 ) {

					$output .= '</ul></div></li></ul>';

				} else {

					$output .= '</ul>';
				}

			} else {

				$output .= '</ul>';
			}
		}

		/**
		 * @see Walker::start_el()
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param int $current_page Menu item ID.
		 * @param object $args
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 )
		{
			if ( $depth == 0 ) {

				$this->group = get_post_meta( $item->ID, '_menu-item-ts-type', true );
			}

			// We have category tabs.
			if ( $this->group == 'tabs' ) {

				if ( $depth == 0 ) {
					
					$this->storage['nav-tabs'] = '';
					$output .= $this->open_li( $item, $depth, $args ) . '{tabs}';
				}

				if ( $depth == 1 ) {

					$this->storage['nav-tabs'] .= $this->open_li( $item, $depth, $args, '</li>' );

					$this->storage['content'] .= $this->get_tab_content( $item, $depth );
				}

				if ( $depth == 2 ) {

					$this->storage['columns-inner-tabs'] .= $this->shortcode( $item );
				}

				if ( $depth > 2 ) {

					$output .= $this->open_li( $item, $depth, $args );
				}

			} elseif ( $this->group == 'mega' ) {

				$col = $depth == 1 ? ' ' . airkit_Compilator::get_column_class( get_post_meta( $item->ID, '_menu-item-ts-columns', true ) ) : '';
				$open_tag = $depth == 1 ? '<h5 class="mega-column-title">' : '';
				$closed_tag = $depth == 1 ? '</h5>' : '';

				$is_content = $depth == 2 && ( $is_content = get_post_meta( $item->ID, '_menu-item-ts-useascontent', true ) ) && ! empty( $is_content ) ? true : false;

				$output .= 	'<li id="menu-item-' . $item->ID . '" class="' . $this->classes( $item, $depth ) . $col . '">' .
								$open_tag .
									( $is_content ? '<div class="airkit_mega-content">' . do_shortcode( $item->post_content ) . '</div>' : $this->link( $item, $depth ) ) .
								$closed_tag;

			} else {

				$output .= $this->open_li( $item, $depth, $args );

				if ( $item->type == 'taxonomy' ) {

					$output .= $this->get_tab_content( $item, $depth, true );
				}
			}
		}

		function end_el( &$output, $item, $depth = 0, $args = array() )
		{
			if ( $this->group == 'tabs' ) {

				if ( $depth == 1 ) {

					$this->storage['content'] = str_replace( '{columns-inner-tabs}', $this->storage['columns-inner-tabs'], $this->storage['content'] );

					$this->storage['columns-inner-tabs'] = '';
				}

				if ( $depth == 0 ) {

					/*
					*	Build navigations tabs.
					* 	$this->storage['nav-tabs'] - contain all tabs.
					*/
					$tabs = '<ul class="dropdown-menu">
								<li>
									<div class="airkit_menu-content">
										<div class="tabbable row">
											<div class="col-md-3">
												<ul class="nav nav-pills nav-stacked">' .
													$this->storage['nav-tabs'] .
												'</ul>
											</div>
											<div class="col-md-9">
												<div class="tab-content">' .
													$this->storage['content'] .
												'</div>
											</div>
										</div>
									</div>
								</li>
							</ul>';

					$output = str_replace( '{tabs}', $tabs, $output );

					$this->storage['content'] = '';
				}

				if ( $depth == 0 || $depth > 2 ) {

					$output .= '</li>';
				}

			} else {

				$output .= '</li>';

				$output = str_replace( '{columns-inner-tabs}', '', $output );
			}
		}

		function open_li( $item, $depth, $args, $closed_li = '' )
		{
			if ( is_object( $args ) ) {

				$link_before = $args->link_before;
				$link_after = $args->link_after;

			} else {

				$link_before = '';
				$link_after = '';
			}

			return 	$link_before .
						'<li id="menu-item-' . $item->ID . '" class="' . $this->classes( $item, $depth ) . '">' .
							$this->link( $item, $depth ) .
						$closed_li .
					$link_after;
		}

		function description( $item )
		{

			if( $item->post_type == 'page' ) return;
			// When using wp_page_menu, post_type is always page. This is why in this case whe don't need page content as our item's description
			// When using wp_nav_menu, post_type is always nav_menu_item.

			$desc = '';
			
			if ( trim($item->post_content) != '' ) {

				$desc = '<span class="mega-menu-item-description">' . do_shortcode( $item->post_content ) . '</span>';
			}

			return $desc;
		}

		function link( $item, $depth )
		{
			$icon = ( $icon = get_post_meta( $item->ID, '_menu-item-ts-icon', true ) ) && $icon !== 'icon-noicon' ? '<i class="' . $icon . '"></i>' : '';

			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) . '"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) . '"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) . '"' : '';

			// When using wp_page_menu, $item->url is empty. But $item->ID stands for actual page ID, so we can retrieve page url using get_the_permalink.
			$href = isset( $item->url ) ? esc_url( $item->url ) : get_the_permalink( $item->ID );

			if ( 'tabs' == $this->group ) {

				if ( 0 == $depth ) {

					$attributes .= ' data-toggle="dropdown" class="dropdown-toggle"';
					// $href = '#';
				}

				if ( 1 == $depth ) {

					$attributes .= ' data-toggle="tab"';
					$href = '#airkit_content-' . $item->ID;
				}

			} elseif ( 'mega' == $this->group ) {

				if ( 0 == $depth ) {

					$attributes .= ' data-toggle="dropdown" class="dropdown-toggle"';
					$href = '#';
				}

			} else {

				if ( 0 == $depth ) {

					$attributes .= ' ';
				}
			}

			$open_a = 'mega' == $this->group && 1 == $depth ? '' : '<a href="' . $href . '" ' . $attributes . '>';
			$closed_a = 'mega' == $this->group && 1 == $depth ? '' : '</a>';

			return 	$open_a .
						$icon .
						( isset( $item->post_name ) && $item->post_name == 'language-switcher' || isset($item->post_title) ? $item->title :  $item->post_title ) .
						$this->description( $item ) .
					$closed_a;
		}

		function classes( $item, $depth )
		{
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$classes = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );

			if ( 'tabs' == $this->group ) {

				/*
				*	If is first li in hierarchy we need to check if we have dropdown full, with content ( columns, posts, shortcodes, etc ).
				*	Cases are: megamenu, category tabs, or we have item category with option 'show post' to yes.
				*	Other cases we will have ordinary link.
				*/

				if ( $depth == 0 && ( $this->group != 'default' || ( $item->type == 'taxonomy' && $this->group == 'default' && get_post_meta( $item->ID, '_menu-item-ts-posts', true ) == 'y' ) ) ) {

					$classes .= ' menu-item-has-children airkit_menu-full airkit_menu-tabs';

				}

				if ( 0 == $depth || 1 == $depth ) {

					$classes .= ' dropdown';
				}

			} elseif ( 'mega' == $this->group ) {

				if ( 0 == $depth ) {

					$classes .= ' airkit_is-mega airkit_menu-full dropdown';
				}

			} else {

				$classes .= ' airkit_menu-full dropdown simple';

				if ( $depth == 0 && ( ( !empty($this->group) && $this->group != 'default' ) || ( $item->type == 'taxonomy' && $this->group == 'default' && get_post_meta( $item->ID, '_menu-item-ts-posts', true ) == 'y' ) ) ) {

					$classes .= ' menu-item-has-children airkit_menu-tabs';

				} 

				if( $depth > 0 ) {

					$direction = get_post_meta( $item->ID, '_menu-item-ts-direction', true );
					if( empty( $direction ) ) {
						$direction = 'right';
					}

					$classes .= ' direction-' . $direction;
				}
			}

			return $classes;
		}

		function get_tab_content( $item, $depth, $tax = false )
		{
			$col = ( $col = get_post_meta( $item->ID, '_menu-item-ts-columns-posts', true ) ) && $col > 0 ? $col : 4;
			$set_posts = get_post_meta( $item->ID, '_menu-item-ts-posts', true );
			$attr = $tax ? 'class="dropdown-menu"' : 'id="airkit_content-' . $item->ID . '" class="tab-pane"';
			$article_classes = array('airkit_view-article');

			if ( $item->type == 'taxonomy' ) {

				$content = '';

				if ( $set_posts == 'y' ) {

					$post_type = airkit_Compilator::get_post_type( $item->object );

					$query = get_posts(
						array(
							'posts_per_page'      => ( ( $count = get_post_meta( $item->ID, '_menu-item-ts-count-posts', true ) ) && $count > 0 ? $count : 3 ),
							'ignore_sticky_posts' => 1,
							'post_type'           => $post_type,
							'tax_query'      => array(
								array(
									'taxonomy' => $item->object,
									'field'    => 'term_id',
									'terms'    => (array) $item->object_id,
								)
							)
						)
					);

					global $post;

					ob_start(); ob_clean();

						foreach ( $query as $post ): setup_postdata( $post );

							$article_classes[] =  airkit_Compilator::get_column_class( $col );

						?>

							<article <?php post_class( $article_classes ) ?>>
								<figure <?php airkit_element_attributes(array(), array('element' => 'figure', 'img_size' => 'gowatch_wide'), $post->ID) ?>>
									<?php
										airkit_overlay_effect_type();
										echo airkit_hover_style( $post->ID );
									?>
								</figure>
								<?php echo airkit_entry_content( array('meta' => 'n') ); ?>
							</article>

						<?php endforeach;

					$content = ob_get_clean();

					wp_reset_postdata();

					return '<div ' . $attr . '><div class="airkit_menu-articles airkit_gutter-20 cols-by-'. $col .'">' . $content . '{columns-inner-tabs}</div></div>';

				}


			} else {

				return '<div id="airkit_content-' . $item->ID . '" class="tab-pane">{columns-inner-tabs}</div>';
			}
		}

		function shortcode( $item )
		{
			$content = do_shortcode( $item->description );

			if ( empty( $content ) ) {

				return;
			}

			return '<div class="' . airkit_Compilator::get_column_class( get_post_meta( $item->ID, '_menu-item-ts-columns', true ) ) . '">' . $content . '</div>';
		}
	}
}


if ( ! class_exists( 'airkit_backend_walker' ) ) {
/**
 * Create HTML list of nav menu input items.
 * This walker is a clone of the wordpress edit menu walker with some options appended, so the user can choose to create mega menus
 *
 * @package tsFramework
 * @since 1.0
 * @uses Walker_Nav_Menu
 */
	class airkit_backend_walker extends Walker_Nav_Menu
	{
		/**
		 * @see Walker_Nav_Menu::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int $depth Depth of page.
		 */
		function start_lvl( &$output, $depth = 0, $args = array() ) {}

		/**
		 * @see Walker_Nav_Menu::end_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int $depth Depth of page.
		 */
		function end_lvl( &$output, $depth = 0, $args = array() ) {}

		/**
		 * @see Walker::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param int $current_page Menu item ID.
		 * @param object $args
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {

			ob_start();

			$item_id = $item->ID;

			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$has_children = '';

			if( isset( $args->walker->has_children ) && $args->walker->has_children ) {
				$has_children = ' menu-item-has-children';
			}

			$original_title = '';

			if ( 'taxonomy' == $item->type ) {

				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );

			} elseif ( 'post_type' == $item->type ) {

				$original_title = get_post( $item->object_id )->post_title;
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . ( $item->type == 'taxonomy' ? 'category' : $item->object  . ' menu-item-is-single' ),
				'menu-item-edit-' . ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ? 'active' : 'inactive'),
				$has_children
			);

			?>

			<li id="menu-item-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" class="<?php echo implode( ' ', $classes ); ?>">
				<dl class="menu-item-bar">
					<dt class="menu-item-handle">
						<span class="item-title"><?php echo esc_html( $item->title ); ?></span>
						<span class="item-controls">
							<span class="item-type item-type-default"><?php echo esc_html( $item->type_label ); ?></span>

							<span class="item-type item-type-column" style="display: none;"><?php esc_html_e('-- Is Column -- ', 'gowatch'); ?></span>
							<span class="item-type item-type-tabs" style="display: none;"><?php esc_html_e('-- Is Tabs -- ', 'gowatch'); ?></span>
							<span class="item-type item-type-tab" style="display: none;"><?php esc_html_e('-- Is Tab -- ', 'gowatch'); ?></span>
							<span class="item-type item-type-mega" style="display: none;"><?php esc_html_e('-- Is Mega Menu --', 'gowatch'); ?></span>
							<span class="item-type item-type-error" style="display: none;"><?php esc_html_e('-- Error --', 'gowatch'); ?></span>
							<a class="item-edit" id="edit-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" title="<?php esc_html_e('Edit Menu Item','gowatch'); ?>" href="<?php
								echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, esc_url(admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) )) );
							?>"><?php esc_html_e( 'Edit Menu Item','gowatch' ); ?></a>
						</span>
					</dt>
				</dl>

				<div class="menu-item-settings" id="menu-item-settings-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">

					<?php if( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
								<?php esc_html_e( 'URL','gowatch' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>

					<p class="description description-thin description-label">
						<label for="edit-menu-item-title-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
							<span class='ts_default_label'><?php esc_html_e( 'Navigation Label','gowatch' ); ?></span>
							<br />
							<input type="text" id="edit-menu-item-title-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>

					<p class="description description-thin description-title">
						<label for="edit-menu-item-attr-title-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
							<?php esc_html_e( 'Title Attribute','gowatch' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>

					<p class="field-link-target description description-thin">
						<label for="edit-menu-item-target-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
							<?php esc_html_e( 'Menu Link Target','gowatch' ); ?><br />
							<select id="edit-menu-item-target-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" class="widefat edit-menu-item-target" name="menu-item-target[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]">
								<option value="" <?php selected( $item->target, '' ); ?>><?php esc_html_e('Open in same window','gowatch'); ?></option>
								<option value="_blank" <?php selected( $item->target, '_blank'); ?>><?php esc_html_e('Open in new window','gowatch'); ?></option>
							</select>
						</label>
					</p>

					<p>
						<label for="edit-menu-item-classes-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
							<?php esc_html_e( 'Custom CSS Classes', 'gowatch' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" name="menu-item-classes[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo esc_attr( implode( ' ', $item->classes ) ); ?>" />
						</label>
					</p>

					<p class="airkit_item-description">
						<label for="edit-menu-item-description-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
							<?php esc_html_e( 'Description' ,'gowatch'); ?><br />
							<textarea id="edit-menu-item-description-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" class="widefat" rows="3" cols="20" name="menu-item-description[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]"><?php echo esc_html( $item->post_content ); ?></textarea>
						</label>
					</p>

					<?php
						$value = get_post_meta( $item->ID, '_menu-item-ts-useascontent', true );

						if ( $value != '' ) $value = ' checked="checked"';
					?>

					<p class="airkit_useas-content">
						<label for="edit-menu-item-ts-useascontent-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
							<input type="checkbox" id="edit-menu-item-ts-useascontent-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" class="menu-item-ts-useascontent" name="menu-item-ts-useascontent[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' );?>]"<?php echo airkit_var_sanitize( $value, 'esc_attr' ); ?>/>
							<span class='ts_long_desc'>
								<?php esc_html_e( 'Check to create text content. This will not display the item as a link. (Please dont remove the label text, WordPress will automatically remove the item.)', 'gowatch' ); ?>
							</span>
						</label>
					</p>

					<?php

						$this->icons( $item->ID );

						$this->type( $item );

						$this->category_settings( $item, $depth );

						$col = get_post_meta( $item->ID, '_menu-item-ts-columns', true );

						$direction = get_post_meta( $item->ID, '_menu-item-ts-direction', true );
					?>

					<p class="airkit_cols-number">
						<label for="edit-item-ts-columns-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
							<?php esc_html_e( 'Number of columns', 'gowatch' ); ?><br />
						</label>
						<select class="airkit_menu-item-columns" name="menu-item-ts-columns[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" id="edit-menu-item-ts-columns-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
							<option<?php selected( $col, 4 ); ?> value="4">1/4</option>							
							<option<?php selected( $col, 3 ); ?> value="3">1/3</option>
							<option<?php selected( $col, 2 ); ?> value="2">1/2</option>
							<option<?php selected( $col, 1 ); ?> value="1">Full</option>
						</select>
					</p>

					<p class="airkit_open-direction">
						<label for="edit-item-ts-direction-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
							<?php esc_html_e( 'Submenu open direction', 'gowatch' ); ?><br />
						</label>
						<select class="airkit_menu-item-direction" name="menu-item-ts-direction[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" id="edit-menu-item-ts-direction-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
							<option<?php selected( $direction, 'right' ); ?> value="right">
								<?php echo esc_html__( 'Right', 'gowatch' ); ?>
							</option>						
							<option<?php selected( $direction, 'left' ); ?>  value="left">
								<?php echo esc_html__( 'Left', 'gowatch' ); ?>
							</option>							
						</select>
					</p>					

					<div class="menu-item-actions description-wide submitbox">

						<?php if( 'custom' != $item->type ) : ?>
							<p class="link-to-original">
								<?php printf( esc_html__('Original: %s', 'gowatch'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
							</p>
						<?php endif; ?>

						<a class="item-delete submitdelete deletion" id="delete-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" href="<?php
						echo wp_nonce_url(
							add_query_arg(
								array(
									'action' => 'delete-menu-item',
									'menu-item' => $item_id,
								),
								remove_query_arg($removed_args, esc_url(admin_url( 'nav-menus.php' )) )
							),
							'delete-menu_item_' . $item_id
						); ?>"><?php esc_html_e('Remove','gowatch'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" href="<?php	echo add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, esc_url(admin_url( 'nav-menus.php' ) )) );
							?>#menu-item-settings-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">Cancel</a>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}

		function type( $item )
		{
			$taxonmies = array( 'category', 'videos_categories', 'portfolio_categories', 'ts_teams', 'gallery_categories' );
			$item_id = $item->ID;
			$type = ( $type = get_post_meta( $item_id, '_menu-item-ts-type', true ) ) ? $type : 'default';
			?>
			<p class="airkit_item-type">
				<label for="edit-item-ts-type-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
					<?php esc_html_e( 'Item type' ,'gowatch'); ?><br />
				</label>
				<select class="airkit_menu-item-type" name="menu-item-ts-type[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" id="edit-menu-item-ts-type-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
					<option<?php selected( $type, 'default' ); ?> value="default"><?php esc_html_e( 'Default', 'gowatch' ); ?></option>
					<option<?php selected( $type, 'mega' ); ?> value="mega"><?php esc_html_e( 'Megamenu', 'gowatch' ); ?></option>

					<?php if ( in_array( $item->object, $taxonmies ) ) : ?>
						<option<?php selected( $type, 'tabs' ); ?> value="tabs"><?php esc_html_e( 'Category tabs', 'gowatch' ); ?></option>
					<?php endif; ?>

				</select>
			</p>
			<?php
		}

		function category_settings( $item, $depth )
		{
			$taxonmies = array( 'category', 'videos_categories', 'portfolio_categories', 'ts_teams', 'gallery_categories' );

			if ( ! in_array( $item->object, $taxonmies ) ) return;

			$item_id = $item->ID;
			$set_posts = get_post_meta( $item_id, '_menu-item-ts-posts', true );
			$col_posts  = get_post_meta( $item_id, '_menu-item-ts-columns-posts', true );
			$count_posts  = get_post_meta( $item_id, '_menu-item-ts-count-posts', true );

			?>
			<div class="airkit_container-options-post">
				<p class="airkit_menu-container-show-posts description description-thin">
					<label for="edit-menu-item-ts-posts-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
						<?php esc_html_e( 'Show post' ,'gowatch'); ?><br />
					</label>
					<select class="airkit_menu-show-posts" name="menu-item-ts-posts[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" id="edit-menu-item-ts-posts-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
						<option<?php selected( $set_posts, 'y' ); ?> value="y"><?php esc_html_e( 'Yes', 'gowatch' ); ?></option>
						<option<?php selected( $set_posts, 'n' ); ?> value="n"><?php esc_html_e( 'No', 'gowatch' ); ?></option>
					</select>
					<input type="hidden" name="menu-item-taxonomy[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" value="<?php echo airkit_var_sanitize( $item->object, 'esc_attr' ); ?>">
				</p>

				<p class="airkit_depend-show-posts description description-thin">
					<label for="edit-menu-item-ts-columns-posts-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
						<?php esc_html_e( 'Posts per row', 'gowatch' ); ?><br />
					</label>
					<select name="menu-item-ts-columns-posts[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" id="edit-menu-item-ts-columns-posts-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
						<option<?php selected( $col_posts, 2 ); ?> value="2">2</option>
						<option<?php selected( $col_posts, 3 ); ?> value="3">3</option>
						<option<?php selected( $col_posts, 4 ); ?> value="4">4</option>
					</select>
				</p>

				<p class="airkit_depend-show-posts description description-thin">
					<label for="edit-menu-item-ts-count-posts-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
						<?php esc_html_e( 'Extract count', 'gowatch' ); ?><br />
					</label>
					<select name="menu-item-ts-count-posts[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" id="edit-menu-item-ts-count-posts-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
						<option<?php selected( $count_posts, 2 ); ?> value="2">2</option>
						<option<?php selected( $count_posts, 3 ); ?> value="3">3</option>
						<option<?php selected( $count_posts, 4 ); ?> value="4">4</option>
						<option<?php selected( $count_posts, 6 ); ?> value="6">6</option>
						<option<?php selected( $count_posts, 8 ); ?> value="8">8</option>
						<option<?php selected( $count_posts, 9 ); ?> value="9">9</option>
						<option<?php selected( $count_posts, 12 ); ?> value="12">12</option>
					</select>
				</p>
			</div>
			<?php
		}

		function icons( $item_id )
		{
			$icon = get_post_meta( $item_id, '_menu-item-ts-icon', true );
			$icons = get_option( 'gowatch_icons', array() );

			$icons_li = '';
			$icons_options = '';

			$icons = explode( ',', $icons );

			foreach ( $icons as $class ) {

			    if ( $icon === $class ) {

			    	$icons_li .= '<li class="selected" data-filter="'. $class .'"><i class="' . $class . ' clickable-element" data-option="' . $class . '"></i></li>';
			    	$icons_options .= '<option selected="selected" value="' . $class . '"></option>';

			    } else {

			    	$icons_options .= '<option value="' . $class . '"></option>';
			    	$icons_li .= '<li data-filter="'. $class .'"><i class="' . $class . ' clickable-element" data-option="' . $class . '"></i></li>';
			    }

			}
			?>

			<div class="field-icons description description-icons">
			    <p><?php esc_html_e( 'Select an icon', 'gowatch' ); ?></p>
				<div class="builder-element-icon-toggle">
				    <a href="#" class="red-ui-button builder-element-icon-trigger-btn" data-toggle="#menu-item-icon-selector-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>">
					    <i class="<?php echo airkit_var_sanitize( $icon, 'esc_attr' ); ?>"></i>
				   	</a>
				</div>
				<div class="ts-icons-container" style="display: none;">
					<label>
					    <input type="text" value="" class="airkit_search-icon" placeholder="<?php esc_html_e( 'Search icon', 'gowatch' ); ?>"/>
					    <i class="icon-search"></i>
					</label>
					<ul id="menu-item-ts-icon-selector-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" data-selector="#edit-menu-item-ts-icon-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" class="imageRadioMetaUl perRow-4 builder-icon-list airkit_custom-selector">

					    <?php echo airkit_var_sanitize( $icons_li, 'the_kses' ); ?>

					</ul>
					<select name="menu-item-ts-icon[<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>]" id="edit-menu-item-ts-icon-<?php echo airkit_var_sanitize( $item_id, 'esc_attr' ); ?>" class="hidden airkit_select-options">
					    <?php echo airkit_var_sanitize( $icons_options, 'the_kses' ); ?>
					</select>
		        </div>
			</div>			
			<?php
		}
	}
}

// END.