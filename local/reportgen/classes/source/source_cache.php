<?php

/**
 * Cache details source
 * @package    local_reportgen_source_source_cache
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\source;

use coding_exception;
use dml_exception;

class source_cache extends source_base {

    /**
     * Overriding base function.
     * @return array
     */
    public function get_data() {
        $data = [
            'cachedetails' => $this->get_cache(),
        ];
        return ['source' => 'Cache Details', 'data' => $data];
    }

    /**
     * Used for registering if checkbox is selected in options form.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $enabled = (bool) get_config('reportgen', 'lcache');
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
     * Getting the cache details description for the options page.
     * @return array
     * @throws coding_exception
     */
    public function get_information() {
        $informationsources =['name' => 'lcache', 'displayname' =>get_string("lcache", "local_reportgen")];

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
     * Gets location of local cache memory.
     * @return array
     */
    private function get_cache() {
        global $CFG;
        return $CFG->localcachedir;
    }
}
