<?php

/**
 * @package    local_reportgen_writer_pdf_output
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\writer;

use coding_exception;
use local_reportgen\export_all_data;

class json_output {
    /**
     * Used to to generate the PDF from the created mustache templates.
     * @return string
     * @throws coding_exception
     */
    public function export_to_json() {
        $exportalldataobj = new export_all_data();
        $alldata = $exportalldataobj->generate();
        return json_encode($alldata);
    }
}
