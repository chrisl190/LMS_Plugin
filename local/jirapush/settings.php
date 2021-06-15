<?php

/**
 * Settings page
 * @package   local_jirapush_settings
 * @copyright 2021 Christopher Logan <clogan20@qub.ac.uk>
 */

defined('MOODLE_INTERNAL') || die();

if($hassiteconfig) {

    $settings = new admin_settingpage('local_jirapush', new lang_string('pluginname', 'local_jirapush'));

    $settings->add(new admin_setting_heading('settings_header', get_string('header', 'local_jirapush'), ''));

    // Enabled.
    $settings->add(new admin_setting_configcheckbox('local_jirapush/enabled', new lang_string('enabled', 'local_jirapush'),
        '', 0));

    // Service URL.
    $settings->add(new admin_setting_configtext('local_jirapush/url', new lang_string('url', 'local_jirapush'),
        new lang_string('required', 'local_jirapush'), '', PARAM_URL));

    // REST API key.
    $settings->add(new admin_setting_configpasswordunmask('local_jirapush/apikey', new lang_string('apikey', 'local_jirapush'),
        new lang_string('required', 'local_jirapush'), ''));

    // Object schema key.
    $settings->add(new admin_setting_configtext('local_jirapush/objectschemakey', new lang_string('objectschemakey', 'local_jirapush'),
        new lang_string('required', 'local_jirapush'), ''));

    // Object type name.
    $settings->add(new admin_setting_configtext('local_jirapush/objecttypename', new lang_string('objecttypename', 'local_jirapush'),
        new lang_string('required', 'local_jirapush'), ''));

    $ADMIN->add('localplugins', $settings);

}