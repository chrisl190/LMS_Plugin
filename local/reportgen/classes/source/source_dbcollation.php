<?php

/**
 * Db collation details source
 * @package    local_reportgen_source_source_dbcollation
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\source;

use coding_exception;
use dml_exception;

class source_dbcollation extends source_base
{
    /**
     * Overriding base function.
     * @return array
     */
    public function get_data() {
        $data = [
            'dbcollation' => $this->get_DB_collation(),
        ];
        return ['source' => 'Database Collation Details', 'data' => $data];
    }

    /**
     * Used for registering if checkbox is selected in options form.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $enabled = (bool) get_config('reportgen', 'DBcollation');
        return $enabled;
    }

    /**
     * Returns the source for the sub heading on the report.
     * @return mixed|string
     * @throws coding_exception
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
     * Getting the database collation description for the options page.
     * @return array
     * @throws coding_exception
     */
    public function get_information() {
        $informationsources = ['name' => 'dbcollation', 'displayname' => get_string("dbcollation", "local_reportgen")];

        return $informationsources;
    }


    /**
     * Used to add the data to the Mustache template.
     * @return mixed
     */
    public function render() {
        global $OUTPUT;
        $data = $this->get_data();
        return $OUTPUT->render_from_template('local_reportgen/source_report', $data);
    }


    /**
     * Gathers the Database collation information.
     * @return mixed
     */
    private function get_DB_collation() {
        global $CFG;
        return $CFG->dboptions['dbcollation'];
    }
}
