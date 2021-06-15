<?php

/**
 * User details source
 * @package    local_reportgen_source_source_user
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\source;

use coding_exception;
use dml_exception;

class source_user extends source_base {

    /**
     * Overriding base function.
     * @return array
     * @throws dml_exception
     */
    public function get_data() {
        $data = [
            'totalusers' => $this->get_total_number_users(),
            'activeusers' =>$this->get_active_user(),
            'nologinusers' => $this->get_no_login_users(),
        ];
        return ['source' => 'User Details', 'data' => $data];
    }

    /**
     * Used for registering if checkbox is selected in options form.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $enabled = (bool) get_config('reportgen', 'userDetails');
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
     * Getting the user details description for the options page.
     * @return array
     * @throws coding_exception
     */
    public function get_information() {
        $informationsources =['name' => 'userdetails', 'displayname' => get_string("userdetails", "local_reportgen")];

        return $informationsources;
    }

    /**
     * Used to add the data to the Mustache template.
     * @return mixed
     * @throws dml_exception
     */
    public function render() {
        global $OUTPUT;
        $data = $this->get_data();
        return $OUTPUT->render_from_template('local_reportgen/source_report', $data);
    }


    /**
     * Get's the total number registered users on a site.
     * @return int
     * @throws dml_exception
     */
    private function get_total_number_users() {
        global $DB;

        $sql = "SELECT COUNT(*)
                  FROM {user}
                 WHERE (confirmed = 1
                   AND deleted <> 1)";
        return $DB->count_records_sql($sql);
    }

    /**
     * Get's the total number of only active users in the last 12 months on a site.
     * @return int
     * @throws dml_exception
     */
    private function get_active_user() {
        global $DB;
        $time = time() - YEARSECS;
        return $DB->count_records_select('user', 'firstaccess >=?', [$time]);
    }

    /**
     * Get's the number of users
     * @return mixed
     * @throws dml_exception
     */
    private function get_no_login_users() {
        global $DB;

        $sql = 'SELECT COUNT(*) FROM {user}
                 WHERE firstaccess = 0
                   AND deleted <> 1';

        $totalusers = $DB->count_records_sql($sql);
        return $totalusers;
    }
}

