<?php

/**
 * Settings page
 * @package   local_reportgen_settings
 * @copyright 2020 Christopher Logan <clogan20@qub.ac.uk>
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    //Create a settings page in the local plugins page.
   $settings = new admin_settingpage('local_reportgen', new lang_string('pluginname', 'local_reportgen'));

    // Enabled.
    $settings->add(new admin_setting_configcheckbox('local_reportgen/enabled', new lang_string('enabled', 'local_reportgen'), '', 0));

    $ADMIN->add('localplugins', $settings);
}

