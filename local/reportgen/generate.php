<?php

/**
 * Generate page
 * @package    local_reportgen_generate
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

use local_reportgen\writer\pdf_output;

global $CFG, $PAGE, $OUTPUT;
require_once(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/pdflib.php');

$url = new moodle_url('/local/reportgen/generate.php');
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');

$PAGE->set_context(context_system::instance());

$confirmed = optional_param('confirmed', false, PARAM_BOOL);
$download = optional_param('download', false, PARAM_BOOL);

//Generating the report as a PDF.
if ($download) {
    $output = new pdf_output();
    $report = $output->export_to_pdf();

    $pdf = new pdf();
    $pdf->addPage();
    $pdf->writeHTML($report);
    $pdf->Output('Report.pdf', 'D'); //D for download
    die();
}

if ($confirmed) {
    echo $OUTPUT->header();
    $exportalldataobj = new \local_reportgen\export_all_data();

    //Message of success when generated PDF.
    echo $OUTPUT->notification(get_string('notifysuccess', 'local_reportgen'), 'notifysuccess');

    //Redirecting to a new url to download the PDF when user confirms.
    $PAGE->requires->js_call_amd('local_reportgen/redirect', 'init', []);
    echo $OUTPUT->footer();
    die();
}
echo $OUTPUT->header();

//Confirmation asking user if they definitely want to generate PDF.
echo $OUTPUT->confirm(
    get_string('description', 'local_reportgen'),
    new moodle_url('/local/reportgen/generate.php', ['confirmed' => 1]),
    new moodle_url('/'));

echo $OUTPUT->footer();


