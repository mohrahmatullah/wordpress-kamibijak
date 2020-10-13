<?php

class airkit_Fields
{
	// Function for creating a logic meta box option
	public static function logicMetaRadio( $parentName, $name, $val, $title, $description = '', $show_default = true )
	{
		?>
		<div class="meta-box-option meta_title_<?php echo esc_attr($name);?>">
			<h4 class="meta-box-option-title"><?php echo esc_attr($title); ?></h4>
			<div class="meta-box-option-input">
				<label for="<?php echo esc_attr($parentName); ?>['<?php echo esc_attr($name); ?>']"></label>
				<input type="radio" name="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]" value="y" <?php checked( $val, 'y', true ); ?> id="<?php echo esc_attr($parentName.'-'.$name.'-y'); ?>" /> <label class="ts-logic-label" for="<?php echo esc_attr($parentName.'-'.$name.'-y'); ?>"><?php esc_html_e('Yes', 'gowatch'); ?></label>
				<input type="radio" name="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]" value="n" <?php checked( $val, 'n', true ); ?> id="<?php echo esc_attr($parentName.'-'.$name.'-n'); ?>" /> <label class="ts-logic-label" for="<?php echo esc_attr($parentName.'-'.$name.'-n'); ?>"><?php esc_html_e('No', 'gowatch'); ?></label>
				<?php if ( $show_default ) : ?>
					<input type="radio" name="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]" value="std" <?php checked( $val, 'std', true ); ?> id="<?php echo esc_attr($parentName.'-'.$name.'-std'); ?>" /> <label class="ts-logic-label" for="<?php echo esc_attr($parentName.'-'.$name.'-std'); ?>"><?php esc_html_e('Default', 'gowatch'); ?></label>
				<?php endif; ?>
			</div>
			<div class="meta-box-option-desc">
				<?php echo esc_attr($description); ?>
			</div>
		</div>
		<?php
	}

	// Function for creating an upload input for meta box option

	public static function uploaderMeta($parentName, $name, $defaultValue = '', $title, $description = ''){

		$parentName = htmlspecialchars($parentName);
		$name = htmlspecialchars($name);
		$defaultValue = htmlspecialchars($defaultValue);
		$title = htmlspecialchars($title);
		$description = htmlspecialchars($description);

		$meta_value = get_post_meta(get_the_ID(), $parentName, true);
		$element_value = (isset($meta_value[$name])) ? htmlspecialchars($meta_value[$name]) : '';
		?>
		<div class="meta-box-option meta_title_<?php echo esc_attr($name);?>">
			<h4 class="meta-box-option-title"><?php echo esc_attr($title); ?></h4>
			<div class="meta-box-option-input">
				<label for="<?php echo esc_attr($parentName); ?>['<?php echo esc_attr($name); ?>']"></label>
				<input type="text" name="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>][url]" id="<?php echo esc_attr($parentName); ?>-<?php echo esc_attr($name); ?>-input-field" class="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]" value="<?php echo @$element_value['url'];?>"/>
				<input type="hidden" name="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>][media_id]" id="<?php echo esc_attr($parentName); ?>-<?php echo esc_attr($name); ?>-media-id" value="<?php echo @$element_value['media_id'];?>"/>
				<input type="button" data-element-id="<?php echo esc_attr($parentName); ?>-<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]-submit" id="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]-upload" class="button-primary uploader-meta-field <?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]-uploade-button" value="<?php esc_html_e( 'Upload', 'gowatch' ); ?>" />
			</div>
			<div class="meta-box-option-desc">
				<?php echo esc_attr($description); ?>
			</div>
		</div>
		<?php
	}

	public static function inputText( $parentName, $name, $default = '', $title, $desc = '', $color = false )
	{
		$meta = get_post_meta( get_the_ID(), $parentName, true );
		$default = isset( $meta[ $name ] ) ? $meta[ $name ] : $default;
		$class = $color ? ' class="colors-section-picker"' : '';

		?>
		<div class="meta-box-option">
			<h4 class="meta-box-option-title"><?php echo esc_attr( $title ); ?></h4>
			<div class="meta-box-option-input">
				<input type="text" name="<?php echo esc_attr( $parentName ); ?>[<?php echo esc_attr( $name ); ?>]" value="<?php echo esc_attr( $default ); ?>"<?php echo esc_attr( $class ); ?>/>
				<?php if ( $color ) : ?>
					<div class="colors-section-picker-div" id=""></div>
				<?php endif; ?>
			</div>
			<div class="meta-box-option-desc">
				<?php echo esc_attr( $desc ); ?>
			</div>
		</div>
		<?php
	}

	public static function upload_media( $parentName, $name, $default = '', $title, $desc = '' )
	{
		$meta = get_post_meta( get_the_ID(), $parentName, true );
		$default = isset( $meta[ $name ] ) ? $meta[ $name ] : $default;
		?>
		<div class="meta-box-option">
			<h4 class="meta-box-option-title"><?php echo esc_attr( $title ); ?></h4>
			<div class="meta-box-option-input">
				<input type="text" name="<?php echo esc_attr( $parentName ); ?>[<?php echo esc_attr( $name ); ?>]" value="<?php echo esc_attr( $default ); ?>" class="image_url" value="<?php echo esc_attr( $default ); ?>">
				<input type="button" class="button-primary gowatch_select_image" value="<?php esc_html_e( 'Upload', 'gowatch' ); ?>">
				<input type="hidden" value="" class="image_media_id" />
			</div>
			<div class="meta-box-option-desc">
				<?php echo esc_attr( $desc ); ?>
			</div>
		</div>
		<?php
	}

	public static function textareaText($parentName, $name, $defaultValue = '', $title, $description = '')
	{

		$parentName = htmlspecialchars($parentName);
		$name = htmlspecialchars($name);
		$defaultValue = htmlspecialchars($defaultValue);
		$title = htmlspecialchars($title);
		$description = htmlspecialchars($description);

		$meta_value = get_post_meta(get_the_ID(), $parentName, true);
		$element_value = (isset($meta_value[$name])) ? htmlspecialchars($meta_value[$name]) : '';
		?>
		<div class="meta-box-option meta_title_<?php echo esc_attr($name);?>">
			<h4 class="meta-box-option-title"><?php echo esc_attr($title); ?></h4>
			<div class="meta-box-option-input">
				<label for="<?php echo esc_attr($parentName); ?>['<?php echo esc_attr($name); ?>']"></label>
				<textarea cols="35" name="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]" id="<?php echo esc_attr($parentName); ?>-<?php echo esc_attr($name); ?>-input-field" class="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]"><?php echo @$element_value; ?></textarea>
			</div>
			<div class="meta-box-option-desc">
				<?php echo esc_attr($description); ?>
			</div>
		</div>
		<?php
	}

	// Function for creating radio images inputs
	public static function radioImageMeta($parentName, $name, $values, $perRow, $defaultValue = '', $title, $description = '')
	{
		$meta_value = get_post_meta(get_the_ID(), $parentName, true);

		if( isset($meta_value[$name]) && $meta_value[$name] == '' ){
			$the_meta_value = $parentName . '[' . $name . ']';
			add_post_meta(get_the_ID(), $the_meta_value, $defaultValue);

			$element_value = $defaultValue;

		}else{
			$element_value = (isset($meta_value[$name])) ? htmlspecialchars($meta_value[$name]) : $defaultValue;
		}
		?>
		<div class="meta-box-option meta_title_<?php echo esc_attr($name);?>">
			<h4 class="meta-box-option-title"><?php echo esc_attr($title); ?></h4>
			<div class="meta-box-option-input">
				<ul class="imageRadioMetaUl perRow-<?php echo esc_attr($perRow); ?>">
					<?php foreach ($values as $key => $value): ?>
						<li>
							<img src="<?php echo esc_url($value); ?>" alt="<?php echo esc_attr($key); ?>" class="image-radio-input <?php if($element_value == $key ){ echo ' selected' ;} ?>" data-value="<?php echo esc_attr($key); ?>" />
							<input type="radio" data-value="<?php echo esc_attr($key); ?>" class="hidden-input" name="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]" value="<?php echo esc_attr($key); ?>" <?php checked( $element_value, $key, true ); ?> />
						</li>
					<?php endforeach ?>
				</ul>
			</div>
			<div class="meta-box-option-desc">
				<?php echo esc_attr($description); ?>
			</div>
		</div>
		<?php
	}
	// Function for creating selects

	public static function selectMeta($parentName, $name, $values, $defaultValue = '', $title, $description = '')
	{

		$parentName = htmlspecialchars($parentName);
		$name = htmlspecialchars($name);
		$defaultValue = htmlspecialchars($defaultValue);
		$title = htmlspecialchars($title);
		$description = htmlspecialchars($description);

		$meta_value = get_post_meta( get_the_ID(), $parentName, true );

		if ( isset( $meta_value[ $name ] ) && $meta_value[ $name ] == '' ) {

			$the_meta_value = $parentName . '[' . $name . ']';

			add_post_meta( get_the_ID(), $the_meta_value, $defaultValue );
			$element_value = $defaultValue;

		}else{
			$element_value = isset( $meta_value[ $name ] ) ? $meta_value[ $name ] : $defaultValue;
		}

		?>
		<div class="meta-box-option meta_title_<?php echo esc_attr( $name ); ?>">
			<h4 class="meta-box-option-title"><?php echo airkit_var_sanitize( $title, 'the_kses' ); ?></h4>
			<div class="meta-box-option-input">
				<select name="<?php echo esc_attr($parentName); ?>[<?php echo esc_attr($name); ?>]" id="">
					<?php foreach ( $values as $key => $value ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $element_value, $key ); ?>><?php echo esc_attr( $value ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="meta-box-option-desc">
				<?php echo esc_attr($description); ?>
			</div>
		</div>
		<?php
	}

	public static function get_value( $option, $meta, $return = 'std' )
	{
		return isset( $meta[ $option ] ) ? $meta[ $option ] : $return;
	}

	public static function select( $input, $values )
	{

		$default = self::get_std( $input, $values );

		$attr = '';

		if ( ! empty( $input['multiple'] ) ) {

			$attr .= ' data-placeholder="' . esc_attr( $input['name'] ) . '" multiple';
		}

		$class_select = ! empty( $input['class_select'] ) ? ' class="' . $input['class_select'] . '"' : '';

		if( !is_string( $default ) ) {

			$default = '';

		}

		?>

		<div class="ts-option-line<?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<div class="col-lg-5 col-md-5">
				<?php echo esc_html( $input['name'] ); ?>
			</div>
			<div class="col-lg-7 col-md-7">
				<select name="<?php echo esc_attr( $input['id'] ); ?>" id="ts-<?php echo self::id( $input['id'] ); ?>"<?php echo airkit_var_sanitize( $class_select . $attr, 'the_kses' ); ?>>

					<?php if ( ! empty( $input['multiple'] ) ) : ?>
						<option value="0"><?php esc_html_e( 'All', 'gowatch' ); ?></option>
					<?php endif; ?>

					<?php foreach ( $input['options'] as $key => $title ) : ?>

						<option<?php selected( $default, $key ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $title ); ?></option>

					<?php endforeach; ?>

				</select>
				<?php if ( isset( $input['desc'] ) ) : ?>
					<span class="description"><?php echo airkit_var_sanitize( $input['desc'], 'the_kses' ); ?></span>
				<?php endif; ?>
			</div>
		</div>

		<?php
	}

	public static function input( $input, $values )
	{
		$default = self::get_std( $input, $values );

		$default = stripslashes( $default );

		$class = $input['type'] == 'button' ? ' class="button-secondary"' : '';
		$attr = isset( $input['attr'] ) ? ' ' . $input['attr'] : '';

		?>
		<?php if ( ! empty( $input['name'] ) ) : ?>
			<div class="ts-option-line<?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
				<div class="col-lg-5 col-md-5">

					<?php echo esc_html( $input['name'] ); ?>

				</div>
				<div class="col-lg-7 col-md-7">
		<?php endif; ?>

		<input name="<?php echo esc_attr( $input['id'] ); ?>" type="<?php echo esc_attr( $input['type'] ); ?>" value="<?php echo esc_attr( $default ); ?>" id="ts-<?php echo self::id( $input['id'] ); ?>"<?php echo esc_attr( $class ) . $attr; ?>>

		<?php if ( isset( $input['desc'] ) ) : ?>
			<span class="description">
				<?php echo airkit_var_sanitize( $input['desc'], 'the_kses' ); ?>
			</span>
		<?php endif; ?>

		<?php if ( ! empty( $input['name'] ) ) : ?>
				</div>
			</div>
		<?php endif;
	}
	public static function the_value( $input, $values )
	{
		$default = self::get_std( $input, $values );

		$default = stripslashes( $default );

		$class = $input['type'] == 'button' ? ' class="button-secondary"' : '';
		$attr = isset( $input['attr'] ) ? ' ' . $input['attr'] : '';

		?>
		<?php if ( ! empty( $input['name'] ) ) : ?>
			<div class="ts-option-line<?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
				<div class="col-lg-5 col-md-5">

					<?php echo esc_html( $input['name'] ); ?>

				</div>
				<div class="col-lg-7 col-md-7">
		<?php endif; ?>

		<?php echo esc_attr( $default ); ?>

		<?php if ( isset( $input['desc'] ) ) : ?>
			<span class="description">
				<?php echo airkit_var_sanitize( $input['desc'], 'the_kses' ); ?>
			</span>
		<?php endif; ?>

		<?php if ( ! empty( $input['name'] ) ) : ?>
				</div>
			</div>
		<?php endif;
	}

	public static function textarea( $input, $values )
	{
		$default = self::get_std( $input, $values );

		?>

		<div class="ts-option-line<?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<div class="col-lg-5 col-md-5">

				<?php echo esc_html( $input['name'] ); ?>

			</div>
			<div class="col-lg-7 col-md-7">
				<textarea name="<?php echo esc_attr( $input['id'] ); ?>" rows="5" cols="50" id="ts-<?php echo self::id( $input['id'] ); ?>"><?php echo airkit_var_sanitize( stripcslashes($default), 'true' ); ?></textarea>

				<?php if ( isset( $input['desc'] ) ) : ?>
					<span class="description">
						<?php echo airkit_var_sanitize( $input['desc'], 'the_kses' ); ?>
					</span>
				<?php endif; ?>

			</div>
		</div>
	<?php
	}

	public static function code_area( $input, $values )
	{
		$default = self::get_std( $input, $values );

		?>

		<div class="ts-code-area <?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<div class="col-lg-12">

				<?php echo esc_html( $input['name'] ); ?>

			</div>
			<div class="col-lg-12">
				<textarea name="<?php echo esc_attr( $input['id'] ); ?>" id="ts-<?php echo self::id( $input['id'] ); ?>" cols="70" rows="30">
					<?php echo stripcslashes($default); ?>					
				</textarea>

				<?php if ( isset( $input['desc'] ) ) : ?>
					<span class="description">
						<?php echo airkit_var_sanitize( $input['desc'], 'the_kses' );  ?>
					</span>
				<?php endif; ?>

			</div>
		</div>
	<?php
	}

	public static function input_color( $input, $values )
	{
		$default = self::get_std( $input, $values );

		?>

		<div class="ts-option-line<?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<div class="col-lg-5 col-md-5">
				<?php echo esc_html( $input['name'] ); ?>
			</div>
			<div class="col-lg-7 col-md-7">
				<div class="airkit_colorpicker input-group colorpicker-component">
					<input type="text" name="<?php echo esc_attr( $input['id'] ); ?>" value="<?php echo esc_attr( $default ); ?>" id="ts-<?php echo self::id( $input['id'] ); ?>"/>
					<span class="input-group-addon"><i></i></span>
				</div>
				<?php if ( isset( $input['desc'] ) ) : ?>
					<span class="description">
						<?php echo airkit_var_sanitize( $input['desc'], 'the_kses' );  ?>
					</span>
				<?php endif; ?>

			</div>
		</div>
	<?php
	}

	public static function upload( $input, $values )
	{
		$default = self::get_std( $input, $values );

		$sortable = '';
		$attr_multiple = 'false';

		$media_type = isset( $input['media-type'] ) ? $input['media-type'] : 'image';

		if ( isset( $input['multiple'] ) && 'true' == $input['multiple'] ) {

			$sortable = ' airkit_has-sortable';
			$attr_multiple = 'true';
		}
		?>
		<div class="ts-option-line<?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<div class="col-lg-5 col-md-5">
				<?php echo esc_html( $input['name'] ); ?>
			</div>
			<div class="col-lg-7 col-md-7">

				<div id="image-carousel">
					<ul class="carousel_images airkit_selected-imgs<?php echo esc_attr( $sortable ); ?>"></ul>
				</div>

				<?php if ( ! isset( $input['multiple'] ) || 'false' == $input['multiple'] ) : ?>
					<input type="text" name="<?php echo esc_attr( $input['id'] ); ?>" class="ts-file-url" value="" id="<?php echo self::id( $input['id'] ); ?>"/>
				<?php endif; ?>

				<input type="button" class="button-primary ts-upload-file" value="<?php esc_html_e( 'Upload', 'gowatch' ); ?>" data-media-type="<?php echo strip_tags( $media_type ); ?>" data-multiple="<?php echo esc_attr( $attr_multiple ); ?>">

				<input type="hidden" class="airkit_stock-attachments" value="<?php echo strip_tags( $default ); ?>" name="<?php echo esc_attr( $input['id'] ); ?>">

				<?php if ( isset( $input['desc'] ) ) : ?>
					<span class="description">
						<?php echo airkit_var_sanitize( $input['desc'], 'the_kses' );  ?>
					</span>
				<?php endif; ?>

			</div>
		</div>
	<?php
	}

	public static function subsets( $input, $values )
	{
		$default = self::get_std( $input, $values );

		$subsets = array(
			'latin'        => 'latin',
			'latin-ext'    => 'latin-ext',
			'menu'         => 'menu',
			'greek'        => 'greek',
			'greek-ext'    => 'greek-ext',
			'cyrillic'     => 'cyrillic',
			'cyrillic-ext' => 'cyrillic-ext',
			'vietnamese'   => 'vietnamese',
			'arabic'       => 'arabic',
			'khmer'        => 'khmer',
			'lao'          => 'lao',
			'tamil'        => 'tamil',
			'bengali'      => 'bengali',
			'hindi'        => 'hindi',
			'hindi'        => 'hindi',
			'korean'       => 'korean'
		);

		?>
		<div class="ts-option-line">
			<div class="col-lg-5 col-md-5">
				<?php echo esc_html( $input['name'] ); ?>
			</div>
			<div class="col-lg-7 col-md-7">

				<?php
					foreach ( $subsets as $subset ) {
						$checked = in_array( $subset, $default ) ? ' checked="checked"' : '';
						echo '<input' . $checked . ' type="checkbox" value="' . $subset . '" id="subset-' . $subset . '" name="' . $input['id'] . '[]"><label for="subset-' . $subset . '">' . $subset . '</label>&nbsp;&nbsp;&nbsp;';
					}
				?>

				<?php if ( isset( $input['desc'] ) ) : ?>
					<span class="description">
						<?php echo airkit_var_sanitize( $input['desc'], 'the_kses' );  ?>
					</span>
				<?php endif; ?>

			</div>
		</div>
	<?php
	}

	public static function typography( $input, $values )
	{
		$default = self::get_std( $input, $values );

		$familys = self::get_fonts( $input );

		$weights = array(
			'normal'  => esc_html__( 'Normal', 'gowatch' ),
			'bold'    => esc_html__( 'Bold', 'gowatch' ),
			'bolder'  => esc_html__( 'Bolder', 'gowatch' ),
			'lighter' => esc_html__( 'Lighter', 'gowatch' ),
			100       => 100,
			200       => 200,
			300       => 300,
			400       => 400,
			500       => 500,
			600       => 600,
			700       => 700,
			800       => 800,
			900       => 900
		);

		$styles = array(
			'normal'  => esc_html__( 'Normal', 'gowatch' ),
			'italic'  => esc_html__( 'Italic', 'gowatch' ),
			'inherit' => esc_html__( 'Inherit', 'gowatch' )
		);

		$decors = array(
			'none'         => esc_html__( 'None', 'gowatch' ),
			'blink'        => esc_html__( 'Blink', 'gowatch' ),
			'inherit'      => esc_html__( 'Inherit', 'gowatch' ),
			'underline'    => esc_html__( 'Underline', 'gowatch' ),
			'overline'     => esc_html__( 'Overline', 'gowatch' ),
			'line-through' => esc_html__( 'Line through', 'gowatch' )
		);

		$transforms = array(
			'none'         => esc_html__( 'None', 'gowatch' ),
			'inherit'      => esc_html__( 'Inherit', 'gowatch' ),
			'capitalize'   => esc_html__( 'Capitalize', 'gowatch' ),
			'uppercase'    => esc_html__( 'Uppercase', 'gowatch' ),
			'lowercase'    => esc_html__( 'Lowercase', 'gowatch' )
		);

		$class_css = isset( $input['std']['class_css'] ) ? $input['std']['class_css'] : $default['class_css'];

		?>
		<div class="ts-option-line<?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<div class="col-lg-5 col-md-5">
				<?php echo esc_html( $input['name'] ); ?>
			</div>
			<div class="col-lg-7 col-md-7 airkit_typography-options">

				<span class="description">
					<?php esc_html_e('Font family', 'gowatch'); ?>
				</span>
				<select name="<?php echo esc_attr( $input['id'] ); ?>[family]" class="ts-select-fonts">
					<?php

						foreach ( $familys as $family ) {
							echo '<option' . selected( $family, $default['family'], false ) . ' value="' . $family . '">' . $family . '</option>';
						}

					?>
				</select>

				<span class="description">
					<?php esc_html_e('Font weight', 'gowatch'); ?>
				</span>
				<select name="<?php echo esc_attr( $input['id'] ); ?>[weight]">
					<?php

						foreach ( $weights as $key => $weight ) {
							echo '<option' . selected( $key, $default['weight'], false ) . ' value="' . $key . '">' . $weight . '</option>';
						}

					?>
				</select>

				<span class="description">
					<?php esc_html_e('Font size', 'gowatch'); ?>
				</span>
				<select name="<?php echo esc_attr( $input['id'] ); ?>[size]">
					<?php

						$sizes = range( 4, 180 );

						foreach ( $sizes as $size ) {
							echo '<option' . selected( $size, $default['size'], false ) . ' value="' . $size . '">' . $size . ' px</option>';
						}

					?>
				</select>

				<div class="airkit_typography-more hidden">
					<span class="description">
						<?php esc_html_e('Font style', 'gowatch'); ?>
					</span>
					<select name="<?php echo esc_attr( $input['id'] ); ?>[style]">
						<?php
							foreach ( $styles as $key => $style ) {
								echo '<option' . selected( $key, $default['style'], false ) . ' value="' . $key . '">' . $style . '</option>';
							}
						?>
					</select>


					<span class="description">
						<?php esc_html_e('Letter spacing', 'gowatch'); ?>
					</span>
					<select name="<?php echo esc_attr( $input['id'] ); ?>[letter]">
						<?php

							$letters = range( -0.1, 0.1, 0.01 );

							foreach ( $letters as $letter ) {
								echo '<option' . selected( $letter, $default['letter'], false ) . ' value="' . $letter . '">' . $letter . ' em</option>';
							}

						?>
					</select>

					<span class="description">
						<?php esc_html_e('Line height.', 'gowatch'); ?>
					</span>
					<select name="<?php echo esc_attr( $input['id'] ); ?>[line]">
						<?php
							$lines = array();
							$lines['inherit'] = esc_html__( 'Inherit', 'gowatch' );
							$lines = array_merge( $lines, range( 4, 180 ) );

							foreach ( $lines as $key => $line ) {
								$px = $key != 'inherit' ? ' px' : '';
								echo '<option' . selected( $line, $default['line'], false ) . ' value="' . $line . '">' . $line . $px . '</option>';
							}

						?>
					</select>

					<span class="description">
						<?php esc_html_e('Text decoration.', 'gowatch'); ?>
					</span>
					<select name="<?php echo esc_attr( $input['id'] ); ?>[decor]">
						<?php

							foreach ( $decors as $decor ) {
								echo '<option' . selected( $decor, $default['decor'], false ) . ' value="' . $decor . '">' . $decor . '</option>';
							}

						?>
					</select>

					<span class="description">
						<?php esc_html_e('Text transform', 'gowatch'); ?>
					</span>
					<select name="<?php echo esc_attr( $input['id'] ); ?>[transform]">
						<?php

							foreach ( $transforms as $transform ) {
								echo '<option' . selected( $transform, $default['transform'], false ) . ' value="' . $transform . '">' . $transform . '</option>';
							}

						?>
					</select>
				</div>
				<em class="typography-toggler"><i class="icon-down"></i><?php esc_html_e('Toggle more', 'gowatch'); ?></em>
				<?php if ( ! empty( $class_css ) ) :  ?>
					<input name="<?php echo esc_attr( $input['id'] ); ?>[class_css]" value="<?php echo esc_attr( $class_css ); ?>" type="hidden">
				<?php endif; ?>

				<?php if ( isset( $input['desc'] ) ) : ?>
					<span class="description">
						<?php echo airkit_var_sanitize( $input['desc'], 'the_kses' );  ?>
					</span>
				<?php endif; ?>

			</div>
		</div>
	<?php
	}

	public static function get_fonts( $input )
	{
		if ( false === ( $fonts = get_transient( 'ts-fonts' ) ) ) {

			$key_api = ! empty( $input['google_fonts_key'] ) ? $input['google_fonts_key'] : 'AIzaSyBHh7VPOKMPw1oy6wsEs8FNtR5E8zjb-7A';

			$url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $key_api;

			$response = wp_remote_get( $url, array( 'decompress' => false ) );

			$body = json_decode( wp_remote_retrieve_body( $response ), true );
			$fonts = array();

			// Storage of all global options.
			$storage = get_option( 'gowatch_options', array() );

			// Define all custom fonts.
			$customs = array(

					array(
						'family' => 'Arial',
						'type'   => 'std'
						),
					array(
						'family' => 'Times New Roman',
						'type'   => 'std'
						),					
					array(
						'family' => 'Tahoma',
						'type'   => 'std'
						),					
					array(
						'family' => 'Georgia',
						'type'   => 'std'
						),					
					array(
						'family' => 'Comic Sans',
						'type'   => 'std'
						),					
					array(
						'family' => 'Verdana',
						'type'   => 'std'
						),					

				);

			// Fill var $fonts with custom fonts.
			foreach ( $customs as $custom ) {
				$fonts[ $custom['family'] ] = $custom['family'];
			}

			// Fill var $fonts with google fonts.
			foreach ( $body['items'] as $font ) {
				$fonts[ $font['family'] ] = $font['family'];
			}

			set_transient( 'ts-fonts', $fonts, 48 * HOUR_IN_SECONDS );
		}

		return $fonts;
	}

	public static function list_select( $input, $values )
	{
		$default = isset( $values[ $input['id'] ] ) ? $values[ $input['id'] ] : $input['std'];

		//if this field is set to 'y', a list of items for picker should be provided in $input['options'];
		$defined_list = isset( $input['defined-icons'] ) ? $input['defined-icons'] : 'n';
		?>
		<div class="ts-option-line<?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<div class="col-lg-5 col-md-5">
				<?php echo esc_html( $input['name'] ); ?>
			</div>
			<div class="col-lg-7 col-md-7">
				<div class="builder-element-icon-toggle">
				    <a href="#" class="builder-element-icon-trigger-btn defined-icons-<?php echo esc_attr( $defined_list ); ?>"></a>
				</div>
				<div class="ts-icons-container">
					<label>
					    <input type="text" value="" class="airkit_search-icon" placeholder="<?php esc_html_e( 'Search icon', 'gowatch' ); ?>"/>
					    <i class="icon-search"></i>
					</label>
					<ul class="imageRadioMetaUl perRow-3 builder-icon-list airkit_custom-selector" data-selector="#ts-<?php echo esc_attr( $input['id'] ); ?>">
		            	<?php 

			            	if( $defined_list == 'y' ) {

				            	foreach ( $input['options'] as $val ) {

										echo '<li data-filter="'. $val .'">
												<i class="'. $val .' clickable-element" data-option="'. $val .'"></i>
										  </li>';

								}

							}

		            	?>
		            </ul>

		            <select name="<?php echo esc_attr( $input['id'] ); ?>" id="ts-<?php echo esc_attr( $input['id'] ); ?>" class="hidden airkit_select-options" selected-value="<?php echo esc_attr( $default ); ?>">
		            	<?php foreach ( $input['options'] as $val ) : ?>

		            		<option<?php selected( $default, $val ); ?> value="<?php echo esc_attr( $val ); ?>"></option>

		            	<?php endforeach; ?>
		            </select>
		        </div>
		        <?php if ( isset( $input['desc'] ) ) : ?>
		        	<span class="description"><?php echo airkit_var_sanitize( $input['desc'], 'the_kses' );  ?></span>
		        <?php endif; ?>
			</div>
		</div>

		<?php
	}

	public static function block_fields( $input, $values )
	{
		?>
		<div class="ts-option-line">
			<div class="col-lg-5 col-md-5">
				<?php echo esc_html( $input['name'] ); ?>
			</div>
			<div class="col-lg-7 col-md-7 ts-block-options">
				<?php
					foreach ( $input['fields'] as $field ) {

						if ( is_array( $field['field'] ) ) {
							// Add custom function from this class or another.
							call_user_func( $field['field'], $field, $values );

						} else {

							call_user_func( array( __CLASS__, $field['field'] ), $field, $values );
						}
					}
			 	?>

				<?php if ( isset( $input['desc'] ) ) : ?>
					<span class="description"><?php echo airkit_var_sanitize( $input['desc'], 'the_kses' );  ?></span>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	public static function slider_drag( $input, $values )
	{

		$default = isset( $values[ $input['id'] ] ) ? $values[ $input['id'] ] : $input['std'];
		$attr = '';

		$attr .= 'data-min="' . $input['min'] . '"';
		$attr .= ' data-max="' . $input['max'] . '"';
		$attr .= ' data-step="' . $input['step'] . '"';
		?>
		<div class="ts-option-line <?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<div class="col-lg-5 col-md-5">
				<?php echo esc_html( $input['name'] ); ?>
			</div>
			<div class="col-lg-7 col-md-7">
				<input type="text" name="<?php echo strip_tags( $input['id'] ); ?>" id="airkit_<?php echo strip_tags( $input['id'] ); ?>" value="<?php echo strip_tags( $default ); ?>" readonly class="airkit_slider-input" />
				<div class="airkit_slider" <?php echo airkit_var_sanitize( $attr, 'the_kses' ); ?> ></div>

				<?php if ( isset( $input['desc'] ) ) : ?>
					<span class="description"><?php echo airkit_var_sanitize( $input['desc'], 'the_kses' );  ?></span>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	public static function option_block( $info )
	{
		?>
		<div class="ts-option-line">
			<h4 class="option-block-title">
				<?php echo esc_html( $info['title'] ); ?>
			</h4>
			<div class="option-block-description">
				<?php echo esc_html( $info['subtitle'] ); ?>
			</div>
		</div>
		<?php
	}

	public static function img_selector( $input, $values )
	{
		$uri = get_template_directory_uri() . '/images/options/';
		$default = self::get_std( $input, $values );

		?>
		<div class="ts-option-line<?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<div class="col-lg-5 col-md-5">
				<?php echo esc_html( $input['name'] ); ?>
			</div>
			<div class="col-lg-7 col-md-7 ts-block-options">
				<ul class="imageRadioMetaUl perRow-4" data-selector="#ts-<?php echo self::id( $input['id'] ); ?>">
					<?php foreach ( $input['img'] as $option_value => $img ) : ?>
						<li<?php echo( $option_value == $default ? ' class="selected"' : '' ); ?>>
							<img class="image-radio-input clickable-element" data-option="<?php echo strip_tags( $option_value ); ?>" src="<?php echo esc_url( $uri . $img ); ?>">
						</li>
					<?php endforeach; ?>
	            </ul>
				<select class="hidden<?php echo ( isset( $input['class_select'] ) ? ' ' . $input['class_select'] : '' ); ?>" name="<?php echo strip_tags( $input['id'] ); ?>" id="ts-<?php echo self::id( $input['id'] ); ?>">
					<?php foreach ( $input['options'] as $key => $title ) : ?>

						<option<?php selected( $default, $key ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $title ); ?></option>

					<?php endforeach; ?>
				</select>

				<?php if ( isset( $input['desc'] ) ) : ?>
					<span class="description"><?php echo airkit_var_sanitize( $input['desc'], 'the_kses' );  ?></span>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	public static function tmpl( $input, $values )
	{
		$id = $input['id'];

		foreach ( $input['options'] as $key => $field ) {

			$input['options'][ $key ]['id'] = $input['id'] .'[{id}][' . $field['id'] . ']';

			if ( isset( $field['class_select'] ) && 'airkit_trigger-options' == $field['class_select'] ) {

				$name = $field['id'];

				foreach ( $field['options'] as $option_val => $option_name ) {

					array_walk_recursive( $input, function( &$val, $key ) use ( $option_val, $name, $id ) {

						$class = 'airkit_' . $name . '-' . $option_val;

						if ( 'class' == $key && false !== strpos( $val, $class ) ) {

							$val = str_replace( $class, 'airkit_' . $id . '-{id}-' . $name . '-' . $option_val, $val );
						}
					});
				}
			}
		}

		?>
		<div class="airkit_block-items <?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?> <?php echo $input['id'].'-multiple'; ?>">
			<ul class="airkit_created-items" data-sortable="<?php echo esc_html( $input['sortable'] ); ?>"></ul>
			<script type="text/template" class="airkit_tmpl">
				<li>
					<div class="sortable-meta-element">
						<span class="tab-arrow icon-down"></span>
						<span class="ts-multiple-item-tab"><?php esc_html_e( 'Item', 'gowatch' ); ?>: <span class="airkit_slide-nr">{slide-nr}</span></span>
					</div>
					<div class="airkit_item-content hidden">
						<?php

							foreach ( $input['options'] as $field ) {

								call_user_func( array( 'airkit_Fields', $field['field'] ), $field, array() );
							}
						?>
						<input type="button" class="ts-secondary-button airkit_remove-item" value="<?php esc_html_e( 'Remove', 'gowatch' ); ?>" />
						<a href="#" class="ts-secondary-button ts-multiple-item-duplicate">
							<?php esc_html_e( 'Duplicate Item', 'gowatch' ); ?>
						</a>
					</div>
				</li>
			</script>
			<input type="button" class="button ts-multiple-add-button" value="<?php echo esc_html( $input['name'] ); ?>" />
		</div>
		<?php
	}

	/**
	 * TMPL field for words option.
	 */

	public static function words_tmpl( $input, $values )
	{
		$id = $input['id'];

		$fieldValues = self::get_std( $input, $values );

		/*
		 * Complete the $default array with missing keys from $input['options'];
		 */
		foreach ( $input['options'] as $key => $option ) {

			if( array_key_exists( $key , $fieldValues ) ) {

				continue;

			} else {

				$fieldValues[ $key ] = '';

			}
		}


		foreach ( $input['options'] as $key => $field ) {

			$input['options'][ $key ]['id'] = $input['id'] .'[{id}][' . $field['id'] . ']';

			if ( isset( $field['class_select'] ) && 'airkit_trigger-options' == $field['class_select'] ) {

				$name = $field['id'];

				foreach ( $field['options'] as $option_val => $option_name ) {

					array_walk_recursive( $input, function( &$val, $key ) use ( $option_val, $name, $id ) {

						$class = 'airkit_' . $name . '-' . $option_val;

						if ( 'class' == $key && false !== strpos( $val, $class ) ) {

							$val = str_replace( $class, 'airkit_' . $id . '-{id}-' . $name . '-' . $option_val, $val );
						}
					});
				}
			}
		}	

		?>
		<div class="airkit_block-items<?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<ul class="airkit_created-items" data-sortable="<?php echo esc_html( $input['sortable'] ); ?>">
				<?php foreach( $fieldValues as $key => $value ): 
				if( !empty( $value ) && !empty( $key ) ):
				?>			
					<li>
						<input type="hidden" name="<?php echo esc_attr( $input['id'] ); ?>[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( $key ); ?>" />
						<div class="sortable-meta-element">
							<span class="tab-arrow icon-down"></span>
							<span class="ts-multiple-item-tab">
								<?php echo esc_attr( $value['word'] ); ?>
							</span>
						</div>
						<div class="airkit_item-content hidden">
							<?php
								foreach ( $input['options'] as $field ) {
									// Assign actual ID,
									$field['id'] = str_replace( '{id}', $key, $field['id'] );
									call_user_func( array( 'airkit_Fields', $field['field'] ), $field, $value );
								}
							?>
							<input type="button" class="ts-secondary-button airkit_remove-item" value="<?php esc_html_e( 'Remove', 'gowatch' ); ?>" />
							<a href="#" class="ts-secondary-button ts-multiple-item-duplicate">
								<?php esc_html_e( 'Duplicate Item', 'gowatch' ); ?>
							</a>							
						</div>
					</li>				
				<?php 
					endif;
				endforeach; ?>				
			</ul>
			<script type="text/template" class="airkit_tmpl">
				<li>
					<div class="sortable-meta-element">
						<span class="tab-arrow icon-down"></span>
						<span class="ts-multiple-item-tab"><?php esc_html_e( 'Item', 'gowatch' ); ?>: <span class="airkit_slide-nr">{slide-nr}</span></span>
					</div>
					<div class="airkit_item-content hidden">
						<?php
							foreach ( $input['options'] as $field ) {
								call_user_func( array( 'airkit_Fields', $field['field'] ), $field, array() );
							}
						?>
						<input type="button" class="ts-secondary-button airkit_remove-item" value="<?php esc_html_e( 'Remove', 'gowatch' ); ?>" />
						<a href="#" class="ts-secondary-button ts-multiple-item-duplicate">
							<?php esc_html_e( 'Duplicate Item', 'gowatch' ); ?>
						</a>
					</div>
				</li>
			</script>
			<input type="button" class="button ts-multiple-add-button" value="<?php echo esc_html( $input['name'] ); ?>" />
		</div>
		<?php
	}

	/*
	 * Sortable, without Add new / Duplicate / Remove features.
	 */
	public static function simple_tmpl( $input, $values )
	{		
		$default = self::get_std( $input, $values );

		/*
		 * Complete the $default array with missing keys from $input['options'];
		 */
		foreach ( $input['options'] as $key => $option ) {

			if( array_key_exists( $key , $default ) ) {

				continue;

			} else {

				$default[ $key ] = '';

			}
		}

		?>
		<div class="airkit_sortable-items <?php echo ( isset( $input['class'] ) ? ' ' . $input['class'] : '' ); ?>">
			<ul class="airkit_created-items ">
				<?php foreach( $default as $key => $value ): 
					if( isset($input['options'][ $key ]) ) {
						$item = $input['options'][ $key ];				
					} else {
						continue;
					}
				?>			
					<li>
						<input type="hidden" name="<?php echo esc_attr( $input['id'] ); ?>[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( $key ); ?>" />
						<div class="sortable-meta-element">
							<span class="tab-arrow icon-down"></span>
							<span class="ts-multiple-item-tab"><?php echo esc_attr( $item['title'] ); ?></span>
						</div>
						<div class="airkit_item-content hidden">
							<?php
								foreach ( $item['items'] as $field ) {
									call_user_func( array( 'airkit_Fields', $field['field'] ), $field, $values );

								}
							?>
						</div>
					</li>				
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}

	public static function get_std( $input, $values )
	{

		if ( strpos( $input['id'], '[' ) !== false ) {

			// Clean key of '[';
			$ex = explode( '[', $input['id'] );


			// Clean values of ']'
			array_walk( $ex, function( &$value, $key ) {

				$value = str_replace( ']', '', $value );

			});

			$search = '';
			$make = false;

			foreach ( $ex as $key ) {


				if ( isset( $values[ $key ] ) ) {

					$search = $values[ $key ];
					$make = true;

				}
				   

				if ( isset( $search[ $key ] )  ) {

					$search = $search[ $key ];

				}

			}


			$default = $make ? $search : $input['std'];

		} else {

			$default = isset( $values[ $input['id'] ] ) && ! empty( $values[ $input['id'] ] ) ? $values[ $input['id'] ] : $input['std'];
		}

		return $default;
	}

	public static function id( $id )
	{
		if ( strpos( $id, '[' ) === false ) return $id;

		return str_replace( '[', '-', str_replace( ']', '', $id ) );
	}
}
?>