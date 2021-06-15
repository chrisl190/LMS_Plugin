<?php

/**
 * View Page
 * @package   local_reportgen_view
 * @copyright 2020 Christopher Logan <clogan20@qub.ac.uk>
 */

use local_reportgen\export_all_data;
use local_reportgen\output\view;

require_once(__DIR__.'/../../config.php');
global $CFG, $PAGE;

$url = new moodle_url('/local/reportgen/view.php');
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');

$PAGE->set_context(context_system::instance());

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('viewresult', 'local_reportgen'));

// Render the page.
$output = $PAGE->get_renderer('local_reportgen');

// Generate the report and get the data for it.
$exportalldataobj = new export_all_data();
$alldata = $exportalldataobj->generate();

$viewwidget = new view($alldata);

echo $output->render($viewwidget);

echo $OUTPUT->single_button(new moodle_url('/local/reportgen/generate.php'), get_string('export', 'local_reportgen'));

echo $OUTPUT->footer();
