<?php

/**
 * Export all data.
 * @package    local_reportgen_export_all_data
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen;

class export_all_data {

    /**
     * Get's all of the different sources of information from local/reportgen/classes/source.
     * @return array
     */
    public function get_source_classes(): array {
        global $CFG;

        $sources = [];

        $pluginpath = $CFG->dirroot . '/local/reportgen';
        $sourcepaths = scandir( $pluginpath .  '/classes/source');

        foreach ($sourcepaths as $sourcepath){
            if(strpos($sourcepath,'_base.php') !== false){
                continue; // If it's the base class, skip.
            }

            if (strpos($sourcepath, 'source_') === false) {
                continue;
            }

            $sourcename = str_replace('.php', '', $sourcepath);
            $sourcename = '\\local_reportgen\\source\\' . $sourcename;

            //We have the source now, creating an instance of each source class.
            $sources[] = new $sourcename();
        }
        return $sources;
    }

    /**
     * Gathers all the relevant information and stores it to be passed to pdfOutput / API.
     * @return array
     */
    public function generate() {
        $datatotal = [];

        foreach ($this->get_source_classes() as $source){
            if(!$source->is_enabled()){
                continue; // Source is not enabled, skip.
            }

            $source = $source->get_data();
            $datatotal[] = $source;
        }
        return $datatotal;
    }
}