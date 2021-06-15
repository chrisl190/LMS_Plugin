<?php

/**
 * Version details source
 * @package    local_reportgen_source_source_version
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\source;
use coding_exception;
use dml_exception;

class source_version extends source_base
{
    /**
     * Overriding base function.
     * @return array
     */
    public function get_data() {
        $data = [
            'version' => $this->get_version(),
            'release' => $this->get_release(),
        ];

        return ['source' => 'Version Details', 'data' => $data];
    }

    /**
     * Used for registering if checkbox is selected in options form.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $enabled = (bool) get_config('reportgen', 'versionDetails');
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
     * Getting the version details description for the options page.
     * @return array
     * @throws coding_exception
     */
    public function get_information() {
        $informationsources =['name' => 'versiondetails', 'displayname' => get_string("versiondetails", "local_reportgen")];

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
     * Gathers the version number.
     * @return mixed
     */
    private function get_version() {
        global $CFG;
        return $CFG->version;
    }

    /**
     * Gathers the release details.
     * @return mixed
     */
    private function get_release() {
        global $CFG;
        return $CFG->release;
    }
}



