<?php

/**
 * Search details source
 * @package    local_reportgen_source_source_search
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */


namespace local_reportgen\source;

use coding_exception;
use dml_exception;

class source_search extends source_base
{

    /**
     * Overriding base function.
     * @return array
     * @throws coding_exception
     * @throws dml_exception
     */
    public function get_data() {
        $data = [
            'globalsearch' => $this->get_global_search_details(),
        ];
        return ['source' => 'Global Search Details', 'data' => $data];
    }

    /**
     * Used for registering if checkbox is selected in options form.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $enabled = (bool) get_config('reportgen', 'search');
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
     * Getting the search details description for the options page.
     * @return array
     * @throws coding_exception
     */
    public function get_information() {
        $informationsources =['name' => 'search', 'displayname' => get_string("searchdetails", "local_reportgen")];

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
     * Checks if global search has been enabled.
     * @return string
     * @throws coding_exception
     * @throws dml_exception
     */
    private function get_global_search_details() {
        global $DB;
        $sql = "SELECT value FROM {config} WHERE name = 'enableglobalsearch'";
        $record = $DB->get_record_sql($sql);

        if ($record && $record->value > 0) {
            return get_string('search', 'local_reportgen');
        } else {
            return get_string('nosearch', 'local_reportgen');
        }
    }
}
