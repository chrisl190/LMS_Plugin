<?php

/**
 * Base source
 * @package    local_reportgen_source_source_base
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\source;

use dml_exception;

/**
 * All these functions will be inherited and overridden by the different sources.
 * @return array
 *@package local_reportgen\source
 */
abstract class source_base {
    public function get_data() {
        return ['source' => '', 'data' => ''];
    }

    /**
     * Used for the options page checkbox.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $sourcename = 'default';
        $enabled = (bool) get_config('reportgen', "{$sourcename}");
        return $enabled;
    }

    /**
     * Allows the data to used in the mustache templates.
     * @param $sourcedata
     * @return mixed
     */
    public function render() {
        global $OUTPUT;
        $data = $this->get_data();
        return $OUTPUT->render_from_template("local_reportgen/source_report", $data);
    }

    /**
     * Used for sub header in Report.
     * @return string
     */
    public function get_name() {
        $data = $this->get_data();
        if(isset($data)){
            return $data['source'];
        } else {
            throw new coding_exception('Missing or invalid source');
        }
    }
}