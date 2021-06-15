<?php

/**
 * @package    local_reportgen_writer_pdf_output
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\writer;

use coding_exception;
use local_reportgen\export_all_data;
use local_reportgen\output\view;

global $CFG;
require_once($CFG->libdir.'/pdflib.php');


class pdf_output {

    /**
     * Used to to generate the PDF from the created mustache templates.
     * @return string
     * @throws coding_exception
     */
    public function export_to_pdf() {
        global $PAGE;
        //Render the page.
        $output = $PAGE->get_renderer('local_reportgen');

        $exportalldataobj = new export_all_data();
        $alldata = $exportalldataobj->generate();
        $viewwidget = new view($alldata);
        $html = $output->render($viewwidget);

        return $html;
    }
}
