<?php
/**
 * Post related form templates
 *
 * @package Touchsize Frontend Submission
 */
class TSZF_Admin_Template_Post extends TSZF_Admin_Template {

    public static function post_title( $field_id, $label, $values = array() ) {

        ?>
        <li class="post_title">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'post_title' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'post_title', false, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function post_content( $field_id, $label, $values = array() ) {

        $image_insert_name  = sprintf( '%s[%d][insert_image]', self::$input_name, $field_id );
        $image_insert_value = isset( $values['insert_image'] ) ? $values['insert_image'] : 'yes';
        $word_restriction_name = sprintf( '%s[%d][word_restriction]', self::$input_name, $field_id );
        $word_restriction_value = isset( $values['word_restriction'] ) && is_numeric( $values['word_restriction'] ) ? $values['word_restriction'] : '';
        ?>
        <li class="post_content">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'textarea' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'post_content' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'post_content', false, $values ); ?>
                <?php self::common_textarea( $field_id, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Enable Image Insertion', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][insert_image]", 'no' ); ?>
                            <input type="checkbox" name="<?php echo airkit_var_sanitize( $image_insert_name, 'esc_attr' ); ?>" value="yes"<?php checked( $image_insert_value, 'yes' ); ?> />
                            <?php _e( 'Enable image upload in post area', 'gowatch' ); ?>
                        </label>
                    </div>

                    <label><?php _e( 'Word Restriction', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <input type="text" class="smallipopInput" 
                                               name="<?php echo airkit_var_sanitize( $word_restriction_name, 'esc_attr' ) ?>" 
                                               value="<?php echo airkit_var_sanitize( $word_restriction_value, 'esc_attr' ); ?>" 
                                               title="<?php esc_attr_e( 'Numebr of words the author to be restricted in', 'gowatch' ); ?>" 
                                                />
                        </label>
                    </div>
                </div> <!-- .tszf-form-rows -->

                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function post_excerpt( $field_id, $label, $values = array() ) {
        ?>
        <li class="post_excerpt">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'textarea' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'post_excerpt' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'post_excerpt', false, $values ); ?>
                <?php self::common_textarea( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function post_tags( $field_id, $label, $values = array() ) {
        ?>
        <li class="post_tags">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'text' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'post_tags' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'tags', false, $values ); ?>
                <?php self::common_text( $field_id, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function featured_image( $field_id, $label, $values = array() ) {
        $max_file_name = sprintf( '%s[%d][max_size]', self::$input_name, $field_id );
        $max_file_value = $values ? $values['max_size'] : '1024';
        $help = esc_attr( __( 'Enter maximum upload size limit in KB', 'gowatch' ) );
        ?>
        <li class="featured_image">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'image_upload' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'featured_image' ); ?>
            <?php self::hidden_field( "[$field_id][count]", '1' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'featured_image', false, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Max. file size', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" 
                                       name="<?php  echo airkit_var_sanitize( $max_file_name, 'esc_attr' ); ?>" 
                                       value="<?php echo airkit_var_sanitize( $max_file_value, 'esc_attr' ); ?>" 
                                       title="<?php echo airkit_var_sanitize( $help, 'esc_attr' ); ?>" 
                                       />
                </div> <!-- .tszf-form-rows -->
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function post_category( $field_id, $label, $values = array() ) {
        ?>
        <li class="post_category">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'post_category' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, 'category', false, $values ); ?>
                <?php self::conditional_field( $field_id, $values ); ?>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }

    public static function taxonomy( $field_id, $label, $taxonomy = '', $values = array() ) {
        $type_name          = sprintf( '%s[%d][type]', self::$input_name, $field_id );
        $order_name         = sprintf( '%s[%d][order]', self::$input_name, $field_id );
        $orderby_name       = sprintf( '%s[%d][orderby]', self::$input_name, $field_id );
        $exclude_type_name  = sprintf( '%s[%d][exclude_type]', self::$input_name, $field_id );
        $exclude_name       = sprintf( '%s[%d][exclude]', self::$input_name, $field_id );
        $woo_attr_name      = sprintf( '%s[%d][woo_attr]', self::$input_name, $field_id );
        $woo_attr_vis_name  = sprintf( '%s[%d][woo_attr_vis]', self::$input_name, $field_id );

        $type_value         = $values ? esc_attr( $values['type'] ) : 'select';
        $order_value        = $values ? esc_attr( $values['order'] ) : 'ASC';
        $orderby_value      = $values ? esc_attr( $values['orderby'] ) : 'name';
        $exclude_type_value = $values ? esc_attr( $values['exclude_type'] ) : 'exclude';
        $exclude_value      = $values ? esc_attr( $values['exclude'] ) : '';
        $woo_attr_value     = $values ? esc_attr( $values['woo_attr'] ) : 'no';
        $woo_attr_vis_value = $values ? esc_attr( $values['woo_attr_vis'] ) : 'no';
        ?>
        <li class="taxonomy <?php echo airkit_var_sanitize( $taxonomy, 'esc_attr' ); ?> tszf-conditional">
            <?php self::legend( $label, $values, $field_id ); ?>
            <?php self::hidden_field( "[$field_id][input_type]", 'taxonomy' ); ?>
            <?php self::hidden_field( "[$field_id][template]", 'taxonomy' ); ?>

            <div class="tszf-form-holder">
                <?php self::common( $field_id, $taxonomy, false, $values ); ?>

                <div class="tszf-form-rows">
                    <label><?php _e( 'Type', 'gowatch' ); ?></label>
                    <select name="<?php echo airkit_var_sanitize( $type_name, 'esc_attr' ); ?>">
                        <option value="select"<?php selected( $type_value, 'select' ); ?>><?php _e( 'Dropdown', 'gowatch' ); ?></option>
                        <option value="multiselect"<?php selected( $type_value, 'multiselect' ); ?>><?php _e( 'Multi Select', 'gowatch' ); ?></option>
                        <option value="checkbox"<?php selected( $type_value, 'checkbox' ); ?>><?php _e( 'Checkbox', 'gowatch' ); ?></option>
                        <option value="text"<?php selected( $type_value, 'text' ); ?>><?php _e( 'Text Input', 'gowatch' ); ?></option>
                        <option value="ajax"<?php selected( $type_value, 'ajax' ); ?>><?php _e( 'Ajax', 'gowatch' ); ?></option>
                    </select>
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Order By', 'gowatch' ); ?></label>
                    <select name="<?php echo airkit_var_sanitize( $orderby_name, 'esc_attr' ); ?>">
                        <option value="name"<?php selected( $orderby_value, 'name' ); ?>><?php _e( 'Name', 'gowatch' ); ?></option>
                        <option value="id"<?php selected( $orderby_value, 'id' ); ?>><?php _e( 'Term ID', 'gowatch' ); ?></option>
                        <option value="slug"<?php selected( $orderby_value, 'slug' ); ?>><?php _e( 'Slug', 'gowatch' ); ?></option>
                        <option value="count"<?php selected( $orderby_value, 'count' ); ?>><?php _e( 'Count', 'gowatch' ); ?></option>
                        <option value="term_group"<?php selected( $orderby_value, 'term_group' ); ?>><?php _e( 'Term Group', 'gowatch' ); ?></option>
                    </select>
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Order', 'gowatch' ); ?></label>
                    <select name="<?php echo airkit_var_sanitize( $order_name, 'esc_attr' ); ?>">
                        <option value="ASC"<?php selected( $order_value, 'ASC' ); ?>><?php _e( 'ASC', 'gowatch' ); ?></option>
                        <option value="DESC"<?php selected( $order_value, 'DESC' ); ?>><?php _e( 'DESC', 'gowatch' ); ?></option>
                    </select>
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Selection Type', 'gowatch' ); ?></label>
                    <select name="<?php echo airkit_var_sanitize( $exclude_type_name, 'esc_attr' ) ?>">
                        <option value="exclude"<?php selected( $exclude_type_value, 'exclude' ); ?>><?php _e( 'Exclude', 'gowatch' ); ?></option>
                        <option value="include"<?php selected( $exclude_type_value, 'include' ); ?>><?php _e( 'Include', 'gowatch' ); ?></option>
                        <option value="child_of"<?php selected( $exclude_type_value, 'child_of' ); ?>><?php _e( 'Child of', 'gowatch' ); ?></option>
                    </select>
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'Selection terms', 'gowatch' ); ?></label>
                    <input type="text" class="smallipopInput" 
                                       name="<?php echo airkit_var_sanitize( $exclude_name, 'esc_attr' ); ?>" 
                                       title="<?php esc_html_e( 'Enter the term IDs as comma separated (without space) to exclude/include in the form.', 'gowatch' ); ?>" 
                                       value="<?php echo airkit_var_sanitize( $exclude_value, 'esc_attr' ); ?>" 
                                       />
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows">
                    <label><?php _e( 'WooCommerce Attribute', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][woo_attr]", 'no' ); ?>
                            <input type="checkbox" class="woo_attr" 
                                                   name="<?php echo airkit_var_sanitize( $woo_attr_name, 'esc_attr' ); ?>" 
                                                   value="yes"<?php checked( $woo_attr_value, 'yes' ); ?>
                                                   />
                            <?php _e( 'This taxonomy is a WooCommerce attribute', 'gowatch' ); ?>
                        </label>
                    </div>
                </div> <!-- .tszf-form-rows -->

                <div class="tszf-form-rows<?php echo airkit_var_sanitize( $woo_attr_value == 'no' ? ' tszf-hide' : '', 'esc_attr'); ?>">
                    <label><?php _e( 'Visibility', 'gowatch' ); ?></label>

                    <div class="tszf-form-sub-fields">
                        <label>
                            <?php self::hidden_field( "[$field_id][woo_attr_vis]", 'no' ); ?>
                            <input type="checkbox" name="<?php echo airkit_var_sanitize( $woo_attr_vis_name, 'esc_attr' ); ?>" value="yes"<?php checked( $woo_attr_vis_value, 'yes' ); ?> />
                            <?php _e( 'Visible on product page', 'gowatch' ); ?>
                        </label>
                    </div>
                </div> <!-- .tszf-form-rows -->

                <?php self::conditional_field( $field_id, $values ); ?>
                <div class="tszf-options">
                    <?php

                    $tax = get_terms( $taxonomy,  array(
                        'orderby'    => 'count',
                        'hide_empty' => 0
                    ) );

                    $tax = is_array( $tax ) ? $tax : array();

                    foreach($tax as $tax_obj) {
                      ?>
                        <div>
                            <input type="hidden" value="<?php echo airkit_var_sanitize( $tax_obj->name, 'esc_attr' );?>" 
                                                 data-taxonomy="yes" 
                                                 data-term-id="<?php echo airkit_var_sanitize( $tax_obj->term_id, 'esc_attr' );?>"  
                                                 data-type="option">
                            <input type="hidden" value="<?php echo airkit_var_sanitize( $tax_obj->term_id, 'esc_attr' );?>" 
                                                 data-taxonomy="yes" 
                                                 data-term-id="<?php echo airkit_var_sanitize( $tax_obj->term_id, 'esc_attr' );?>"  
                                                 data-type="option_value">
                        </div>
                      <?php
                    }
                    ?>
                </div>
            </div> <!-- .tszf-form-holder -->
        </li>
        <?php
    }


    /**
     * Drop Down portion
     * @param array $param
     */
    public static function render_drop_down_portion( $param = array( 'names_to_hide' => array( 'name' => '', 'value' => '' ),'names_to_show' => array( 'name' => '', 'value' => '' ),'option_to_chose' => array('name' => '', 'value' => '' ) ) ) {
        empty( $param['option_to_chose']['value'] ) ? ( $param['option_to_chose']['value'] = 'all' ) : '';

        ?>
        <div class="tszf-form-rows">
            <label>
                <input type="radio" 
                       name="<?php echo airkit_var_sanitize( $param['option_to_chose']['name'], 'esc_attr' );  ?>" 
                       value="<?php echo _e('all','gowatch'); ?>" <?php echo ( ( $param['option_to_chose']['value'] == 'all' )?'checked':'' ); ?> 
                       />
                <?php esc_html_e( 'Show All', 'gowatch' ); ?>
            </label>
        </div>
        <div class="tszf-form-rows">
            <label>
                <input type="radio" 
                       name="<?php echo airkit_var_sanitize( $param['option_to_chose']['name'], 'esc_attr' );  ?>" 
                       value="<?php echo _e('hide','gowatch'); ?>" <?php echo ( ( $param['option_to_chose']['value'] == 'hide' )?'checked':'' ); ?>  
                       />
                <?php esc_html_e( 'Hide These Countries', 'gowatch' ); ?>
            </label>
            <select name="<?php echo airkit_var_sanitize( $param['names_to_hide']['name'], 'esc_attr' );?>" 
                    class="tszf-country_to_hide" 
                    multiple 
                    data-placeholder="<?php esc_attr_e( 'Chose Country to hide from List', 'gowatch' ); ?>">
            </select>
        </div>

        <div class="tszf-form-rows">
            <label>
                <input type="radio" name="<?php echo airkit_var_sanitize( $param['option_to_chose']['name'], 'esc_attr' );  ?>" 
                                    value="<?php echo _e('show','gowatch'); ?>" <?php echo ( ( $param['option_to_chose']['value'] == 'show' )?'checked':'' ); ?>  /><?php _e( 'Show These Countries', 'gowatch' ); ?>
            </label>
            <select name="<?php echo airkit_var_sanitize( $param['names_to_show']['name'], 'esc_attr' );?>" 
                    class="tszf-country_to_hide" 
                    multiple 
                    data-placeholder="<?php esc_attr_e( 'Add Country to List', 'gowatch' ); ?>">
            </select>
        </div>

        <script>
            (function($){
                $(document).ready(function(){
                    var hide_field_name = '<?php echo airkit_var_sanitize( $param['names_to_hide']['name'], 'true' );?>';
                    var hide_field_value = JSON.parse('<?php echo json_encode($param['names_to_hide']['value']);?>');
                    var show_field_name = '<?php echo airkit_var_sanitize( $param['names_to_show']['name'], 'true' );?>';
                    var show_field_value = JSON.parse('<?php echo json_encode($param['names_to_show']['value']);?>');
                    var countries = window.tszf_countries_list;
                    var hide_field_option_string = '';
                    var show_field_option_string = '';

                    for(country in countries){
                        hide_field_option_string = hide_field_option_string + '<option value="'+ countries[country].code +'" '+ (( $.inArray(countries[country].code,hide_field_value) != -1 )?'selected':'') +'>'+ countries[country].name +'</option>';
                        show_field_option_string = show_field_option_string + '<option value="'+ countries[country].code +'" '+ (( $.inArray(countries[country].code,show_field_value) != -1 )?'selected':'') +'>'+ countries[country].name +'</option>';
                    }

                    jQuery('select[name="'+ hide_field_name +'"]').html(hide_field_option_string);
                    jQuery('select[name="'+ show_field_name +'"]').html(show_field_option_string);
                    jQuery('select[name="'+ hide_field_name +'"],select[name="'+ show_field_name +'"]').chosen({allow_single_deselect:true});
                })

            }(jQuery))

        </script>
        <?php
    }

}
