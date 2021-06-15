<?php

/**
 * @package    local_reportgen_output_view
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\output;

use local_reportgen\export_all_data;
use renderable;
use stdClass;
use templatable;
use renderer_base;

defined('MOODLE_INTERNAL') || die();

/**
 * Page renderable
 */
class view implements renderable, templatable {
    private $report;

    /**
     * Constructor
     */
    public function __construct($report) {
        $this->report = $report;
    }

    /**
     * Create an array for the data, which is used for the mustache template source_report.
     * @param renderer_base $output
     * @return array|stdClass
     */
    public function export_for_template(renderer_base $output) {
        $exportalldata = new export_all_data();
        $sources = $exportalldata->get_source_classes();

        $sourcemappings = [];

        foreach ($sources as $source) {
            $sourcemappings[$source->get_name()] = $source;
        }

        $sourceshtml = [];

        foreach ($this->report as $sourcedata){
            $sourcename = $sourcedata['source'];
            $s = $sourcemappings[$sourcename] ?? null;

            if (!$s) {
                continue; // No source class found.
            }

            $sourcehtml = $s->render($sourcedata);
            $sourceshtml[] = (object)['sourceHTML' => $sourcehtml];
        }

        $data = (object)[
            'sourcesHTML' => new \ArrayIterator($sourceshtml),
        ];

        return $data;
    }
}