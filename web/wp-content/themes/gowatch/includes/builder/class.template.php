<?php

class airkit_Template
{
	public static function get_column_size( $size = 2 )
	{
		switch( $size ) {
			case 2:
				$size = '1/6';
				break;
			case 3:
				$size = '1/4';
				break;
			case 4:
				$size = '1/3';
				break;
			case 5:
				$size = '5/12';
				break;
			case 6:
				$size = '1/2';
				break;
			case 7:
				$size = '7/12';
				break;
			case 8:
				$size = '2/3';
				break;
			case 9:
				$size = '3/4';
				break;
			case 10:
				$size = '5/6';
				break;
			case 11:
				$size = '11/12';
				break;
			case 12:
				$size = '12/12';
				break;
			default:
				$size = '';
		}

		return $size;
	}

	/**
	 * Return all templates
	 * @param  string $location header/footer/page
	 * @return array
	 */
	public static function get_all_templates( $location = 'header' ) {

		$valid_locations = array('header', 'footer', 'page');

		if ( in_array($location, $valid_locations) ) {
			$templates = get_option('gowatch_' . $location . '_templates', array());
			return $templates;
		} else {
			return array();
		}
	}

	public static function load_template( $location = 'header', $template_id = 'default')
	{
		$data = array(
			'name'     => '',
			'elements' => ''
		);

		$valid_locations = array( 'header', 'footer', 'page' );

		if ( in_array( $location, $valid_locations ) ) {

			$templates = get_option( 'gowatch_' . $location . '_templates', array() );

			if ( array_key_exists( $template_id, $templates ) ) {

				return array(
					'template_id' => $template_id,
					'name'        => $templates[$template_id]['name'],
					'elements'    => self::visual_editor($templates[$template_id]['elements'])
				);

			} else {

				return $data;
			}

		} else {

			return $data;
		}
	}

	public static function save( $action = 'blank_template', $location = 'header' )
	{
		$valid_actions   = array('blank_template', 'save_as', 'update');
		$valid_locations = array('header', 'footer', 'page');
		$template_id     = 'ts-template-' . time();



		$template_name = isset($_POST['template_name']) ? trim($_POST['template_name']) : '';
		$template_name = '' === $template_name ? esc_html__( 'New template ', 'gowatch' ) . date( 'd-m-Y' ) : $template_name;

		if ( in_array( $action, $valid_actions ) && in_array($location, $valid_locations) ) {

			if ($action === 'blank_template') {

				$templates = get_option( 'gowatch_' . $location . '_templates', array() );

				if ( is_array($templates) ) {

					$templates[ $template_id ] = array(
						'name' => $template_name,
						'elements' => array()
					);

				} else {
					$templates = array();
					$templates[$template_id] = array(
						'name' => $template_name,
						'elements' => array()
					);
				}

				$updated = update_option('gowatch_' . $location . '_templates', $templates);

			} else if ( $action === 'update' ) {

				$content = isset($_POST['content']) && is_array($_POST['content']) ? $_POST['content'] : array();

				$validated_content = self::validate_content( $content );

				if ( isset( $_POST['post_id'] ) ) {

					update_post_meta( (int)$_POST['post_id'], 'ts_template', $validated_content);

				} else {

					$lang = defined( 'ICL_LANGUAGE_CODE' ) ? '_' . ICL_LANGUAGE_CODE : '';
					$updated = update_option( 'gowatch_' . $location . $lang,  $validated_content );

					// Add the predefined header option
					$storage = get_option( 'gowatch_options', array() );
					$storage[$location . '_settings']['predefined-style'] = esc_attr( $_POST['predefined-style'] );
					$storage[$location . '_settings']['options'] = json_decode( stripslashes( $_POST['options'] ), true );

					// Save the header layout style
					$storage = update_option( 'gowatch_options', $storage );

				}

				if (isset($_POST['template_id'])) {
					$template_id = $_POST['template_id'];
				} else {
					$template_id = 'default';
				}

				update_option( 'gowatch_' . $location . '_template_id', $template_id );

				$templates = get_option( 'gowatch_' . $location . '_templates', array(), true );
				$templates[$template_id]['name'] = $template_name;
				$templates[$template_id]['elements'] = $validated_content;

				update_option( 'gowatch_' . $location . '_templates', $templates );

			} else {

				$content = ! empty( $_POST['content'] ) && is_array( $_POST['content'] ) ? $_POST['content'] : array();

				$validated_content = self::validate_content( $content );

				$templates = ( $t = get_option( 'gowatch_' . $location . '_templates' ) ) && is_array( $t ) ? $t : array();

				$templates[ $template_id ] = array(
					'name'     => $template_name,
					'elements' => $validated_content
				);

				update_option( 'gowatch_' . $location . '_templates', $templates );
			}

			return true;

		} else {

			return false;
		}
	}

	/**
	 * Edit template
	 * @param  string $template_id
	 * @return string
	 */
	public static function edit( $location = 'header' )
	{
		if ( $location === 'header' || $location === 'footer') {

			$lang = defined( 'ICL_LANGUAGE_CODE' ) ? '_' . ICL_LANGUAGE_CODE : '';

			$template = get_option( 'gowatch_' . $location . $lang );

			if ( empty( $template ) ) {

				$template_id = get_option( 'gowatch_' . $location . '_template_id', 'default' );
				$templates   = get_option( 'gowatch_' . $location . '_templates', array() );

				if ( isset( $templates[ $template_id ]['elements'] ) ) {
					$template = $templates[ $template_id ]['elements'];
				}
			}

		} else {

			$template = ( $template = get_post_meta( $location, 'ts_template', true ) ) && is_array( $template ) ? $template : array();

		}

		return self::visual_editor( $template );
	}


	/**
	 * Get tempalte name
	 * @param  string $location Header/Footer/Page
	 * @return string
	 */
	public static function get_template_info($location = 'header', $type = 'id') {

		$template_id = get_option( 'gowatch_' . $location . '_template_id', 'default', true );
		$templates = get_option( 'gowatch_' . $location . '_templates', array(), true );

		if ($type === 'id') {
			return $template_id;
		} else {
			if (isset($templates[$template_id]['name'])) {
				return $templates[$template_id]['name'];
			} else {
				return esc_html__('Template', 'gowatch');
			}
		}
	}

	public static function visual_editor( $template = array() ) {

		$new_structure = '';

		if ( ! is_array( $template ) && empty( $template ) ) return;

		$parsed_rows = array();

		array_walk_recursive( $template, function( &$val, $key ) {

			$val = str_replace( '&quot;', '"', $val );

		});

		// Travers tempalte rows
		foreach ( $template as $row_id => $row ) {

			// checK if we have rows in this section
			if ( empty( $row['columns'] ) || ! is_array( $row['columns'] ) ) continue;

			$uri = get_template_directory_uri();

			$row_start =
			'<ul class="layout_builder_row">
				<li class="row-editor">
					<ul class="row-editor-options">
						<li>
							<a href="#" class="add-column">+</a>
							<a href="#" class="predefined-columns"><img src="' . $uri . '/images/options/columns_layout.png" alt=""></a>
							<ul class="add-column-settings">
							   	<li>
                                   	<a href="#" data-add-columns="#dragable-column-tpl">
                                   		<img src="' . $uri . '/images/options/columns_layout_column.png" alt="">
                                   	</a>
                               	</li>
                               	<li>
                                   	<a href="#" data-add-columns="#dragable-column-tpl-half">
                                   		<img src="' . $uri . '/images/options/columns_layout_halfs.png" alt="">
                                   	</a>
                               	</li>
                               	<li>
                                   	<a href="#" data-add-columns="#dragable-column-tpl-thirds">
                                   		<img src="' . $uri . '/images/options/columns_layout_thirds.png" alt="">
                                   	</a>
                               	</li>
                               	<li>
                                   	<a href="#" data-add-columns="#dragable-column-tpl-four-halfs">
                                  		<img src="' . $uri . '/images/options/columns_layout_one_four.png" alt="">
                                  	</a>
                               	</li>
                               	<li>
                                   	<a href="#" data-add-columns="#dragable-column-tpl-one_three">
                                   		<img src="' . $uri . '/images/options/columns_layout_one_three.png" alt="">
                                   	</a>
                               	</li>
                               	<li>
                                   	<a href="#" data-add-columns="#dragable-column-tpl-four-half-four">
                                   		<img src="' . $uri . '/images/options/columns_layout_four_half_four.png" alt="">
                                   	</a>
                               </li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="builder-row-actions">
					<ul class="row-actions-list">
						<li class="row-toggle-options"><a href="#"><i class="icon-block"></i> '. esc_html__( 'Options', 'gowatch' ) .' </a></li>					
						<li class="edit-row-settings" data-element-type="row">
							<a href="#" class="edit-row icon-settings">' . esc_html__( 'Edit', 'gowatch' ) . '</a>
							<span class="airkit_element-settings" style="display:none;">' . json_encode( $row['settings'] ) . '</span>
						</li>						
						<li class="row-action-remove"><a href="#" class="remove-row">' . esc_html__( 'delete', 'gowatch' ) . '</a></li>
						<li class="row-action-move"><a href="#" class="move">' . esc_html__( 'move', 'gowatch' ) . '</a></li>				
						<li class="row-action-export airkit_export-row"><a href="#">' . esc_html__( 'Export', 'gowatch' ) . '</a></li>
						<li class="row-action-import airkit_import-element"><a href="#">' . esc_html__( 'Import Row', 'gowatch' ) . '</a></li>
					</ul>
				</li>';

			$row_end   = '</ul>';

			$parsed_columns = array();

			// travers each row and parse columns
			foreach ( $row['columns'] as $column_index => $column ) {

				$settings_column = $column['settings'];

				if ( isset( $settings_column['elements'] ) ) {

					unset( $settings_column['elements'] );
				}

				$column_start =
				'<li class="columns' . $column['settings']['size'] . '" data-size="' . $column['settings']['size'] . '">
					<div class="column-header">
						<span class="minus icon-left" data-tooltip="Reduce column size"></span>
						<span class="column-size" data-tooltip="The size of the column within container">' . self::get_column_size( $column['settings']['size'] ) . '</span>
						<span class="plus icon-right" data-tooltip="' . esc_html__('Add column size', 'gowatch') . '"></span>
						<span class="delete-column icon-delete" data-tooltip="' . esc_html__('Remove this column', 'gowatch') . '"></span>
						<span class="clone icon-duplicate ts-clone-column" data-tooltip="' . esc_html__('Clone this column', 'gowatch') . '"></span>
						<span class="edit-column icon-edit" data-tooltip="' . esc_html__('Edit this column', 'gowatch') . '" data-element-type="column">
							<span class="airkit_element-settings" style="display:none;">' . json_encode( $settings_column ) . '</span>
						</span>
						<span class="toggle-options icon-settings" data-tooltip="'. esc_html__( 'Other options', 'gowatch' ) .'">
							<span class="drag-column icon-drag" data-tooltip="' . esc_html__('Drag this column', 'gowatch') . '"></span>
							<span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__( 'Export', 'gowatch' ) . '"></span>
							<span class="icon-download airkit_import-element" data-tooltip="'.esc_html__('Import Row', 'gowatch').'"></span>
						</span>
					</div>
					<ul class="elements">';

						$column_end = '</ul><span class="add-element">' . esc_html__( 'Add element', 'gowatch' ) . '</span>
					</li>';

				$elements = '';

				if ( ! empty( $column['elements'] ) ) {

					foreach ( $column['elements'] as $element ) {

						$elements .=
								'<li>
									<i class="element-icon ' . $element['element-icon'] . '"></i>
									<span class="element-name">' . ( empty( $element['admin-label'] ) ? $element['element-name'] : $element['admin-label'] ) . '</span>
								 	<span class="edit icon-edit" data-tooltip="Edit this element" data-element-type="' . $element['element-type'] . '">' .
								 		esc_html__( 'Edit', 'gowatch' ) .
								 		'<span class="airkit_element-settings" style="display:none;">' . json_encode( $element, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG ) . '</span>
								 	</span>
									<span class="delete icon-delete" data-tooltip="' . esc_html__( 'Remove this element', 'gowatch' ) . '"></span>
									<span class="clone icon-duplicate" data-tooltip="' . esc_html__( 'Clone this element', 'gowatch' ) . '"></span>
									<span class="icon-upload airkit_export-element" data-tooltip="' . esc_html__('Export', 'gowatch') . '"></span>
								</li>';
					}
				}

				$parsed_columns[] = $column_start . "\n" . $elements . "\n" . $column_end . "\n";
			}

			$parsed_rows[] = $row_start . implode( "\n", $parsed_columns ) . $row_end;
		}

		return implode( "\n", $parsed_rows );
	}

	public static function validate_content( $content = array() )
	{
		if ( ! is_array( $content ) ) return array();

		/*
		 | Store validated content.
		 */
		$validated = array();

		/*
		 | Loop through rows
		 */
		foreach ( $content as $row_id => $row ) {

			/*
			 | If row is empty, move to next one.
			 */
			if ( empty( $row ) || ! is_array( $row ) ) continue;

			$filtered_row = array();

			/*
			 | Validated row settings.
			 */
			$filtered_row['settings'] = self::validate( $row['settings'] );

			if ( isset( $row['columns'] ) && is_array( $row['columns'] ) ) {
				/*
				 | Loop trough row's columns
				 */
				foreach ( $row['columns'] as $column_id => $column ) {

					/*
					 | Validated column settings.
					 */					
					$filtered_row['columns'][ $column_id ]['settings'] = self::validate( $column['settings'] );

					if ( ! empty( $column['elements'] ) && is_array( $column['elements'] ) ) {

						/*
						 | Loop trough column's elements.
						 */
						foreach ( $column['elements'] as $element ) {

							if ( ! empty( $element ) ) {
								/*
								 | Validated element settings.
								 */
								$filtered_row['columns'][ $column_id ]['elements'][] = self::validate( $element );
							}
						}
					}
				}

				array_push( $validated, $filtered_row );
			}
		}

		return $validated;
	}

	static function validate( $dirty )
	{
		if ( empty( $dirty['element-type'] ) ) return array();

		$blocks = airkit_BuilderSettings::general( call_user_func( array( 'airkit_BuilderSettings', str_replace( '-', '_', $dirty['element-type'] ) ) ), $dirty['element-type'], false );

		$valid = array();

		foreach ( $blocks as $block ) {

			foreach ( $block['options'] as $item ) {

				if ( empty( $item['id'] ) ) continue;

				if ( isset( $dirty[ $item['id'] ] ) ) {

					if ( isset( $item['esc'] ) ) {

						$value = call_user_func( $item['esc'], $dirty[ $item['id'] ] );

					} else {

						if ( $item['field'] == 'select' || $item['field'] == 'img_selector' ) {

							if ( $item['field'] == 'select' && ! empty( $item['multiple'] ) ) {

								if ( ! empty( $dirty[ $item['id'] ] ) ) {

									$value = is_array( $dirty[ $item['id'] ] ) ? $dirty[ $item['id'] ] : array();
									$slug_std = array_keys( $item['options'] );

									$value = array_intersect_key( array_combine( $slug_std, $slug_std ), array_combine( $value, $value ) );

								} else {

									$value = array();
								}

							} else {

								$value = ! is_array( $dirty[ $item['id'] ] ) && array_key_exists( $dirty[ $item['id'] ], $item['options'] ) ? $dirty[ $item['id'] ] : $item['std'];
							}


						} elseif ( $item['field'] == 'typography' ) {

							$value = self::validate_font( $dirty[ $item['id'] ], $item['std'] );

						} elseif ( $item['field'] == 'tmpl' ) {

							$value = $dirty[ $item['id'] ];

						} elseif( $item['field'] == 'textarea' && $item['id'] == 'advertising' ) {

							$value = $dirty[ $item['id'] ];
							
						} else {

							$validHtmlTags = array(
											    'br' => array(),
											    'em' => array(),
											    'strong' => array(),
											    'i' => array(),
											    'a' => array(),
											);

							$value = wp_kses( $dirty[ $item['id'] ], $validHtmlTags );
						}
					}

				} else {

					$value = $item['std'];
				}

				$valid[ $item['id'] ] = $value;
			}
		}

		return $valid;
	}

	public static function validate_font( $dirty, $std )
	{
		if ( empty( $dirty ) || ! is_array( $dirty ) ) return $std;

		$valid = array();

		foreach ( $std as $key => $value ) {

			$valid[ $key ] = array_key_exists( $key, $dirty ) ? sanitize_text_field( $dirty[ $key ] ) : $value;
		}

		return $valid;
	}

	public static function esc_text( $str )
	{
		return $str;
	}

	/**
	 * Delete a template
	 */
	public static function delete( $location = 'header', $template_id = 'default')
	{
		if ( $template_id === 'default' ) {
			return false;
		}

		if ( in_array( $location, array('header', 'footer', 'page') ) ) {

			$templates = get_option( 'gowatch_' . $location . '_templates', array(), true );

			if ( array_key_exists($template_id, $templates) && $template_id !== 'default' ) {

				unset($templates[$template_id]);
				update_option('gowatch_' . $location . '_templates', $templates);

				return true;

			} else {
				return false;
			}

		} else {
			return false;
		}
	}
}