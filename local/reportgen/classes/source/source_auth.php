<?php

/**
 * Authentication details source
 * @package    local_reportgen_source_source_auth
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\source;

use coding_exception;
use dml_exception;

class source_auth extends source_base
{
    /**
     * Overriding base function.
     * @return array
     * @throws coding_exception
     * @throws dml_exception
     */
    public function get_data() {
        $data = [
            'authenticationdetails' => $this->get_authentication_details(),
        ];
        return ['source' => 'Authentication Details', 'data' => $data];
    }

    /**
     * Used for registering if checkbox is selected in options form.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $enabled = (bool) get_config('reportgen', 'auttypes');
        return $enabled;
    }

    /**
     * Returns the source for the sub heading on the report.
     * @return mixed|string
     * @throws coding_exception
     * @throws dml_exception
     */
    public function get_name() {
        $data = $this->get_data();
        if(isset($data)){
            return $data['source'];
        } else {
            throw new coding_exception('Missing or invalid source');
        }
    }

    /**
     * Getting the auth details description for the options page.
     * @return array
     * @throws coding_exception
     */
    public function get_information() {
        $informationsources = ['name' => 'auttypes', 'displayname' => get_string("auttypes", "local_reportgen")];
        return $informationsources;
    }


    /**
     * Used to add the data to the Mustache template.
     * @return mixed
     * @throws coding_exception
     * @throws dml_exception
     */
    public function render() {
        global $OUTPUT;
        $data = $this->get_data();
        return $OUTPUT->render_from_template('local_reportgen/source_report', $data);
    }

    /**
     * Identifies if any authentication is used on the site.
     * @return mixed|string
     * @throws coding_exception
     * @throws dml_exception
     */
    private function get_authentication_details() {
        global $DB;
        $authmethods = $DB->get_field('config', 'value', ['name' => 'auth']);
        $authmethods = $authmethods ?? get_string('noAuth', 'local_reportgen');
        return $authmethods;
    }
}
