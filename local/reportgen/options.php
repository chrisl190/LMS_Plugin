<?php

/**
 * Options Page
 * @package   local_reportgen_options
 * @copyright 2020 Christopher Logan <clogan20@qub.ac.uk>
 */

require_once(__DIR__.'/../../config.php');
global $CFG, $PAGE;
$PAGE->set_pagelayout('standard');

require_login();

$url = new moodle_url('/local/reportgen/options.php');

$PAGE->set_url($url);

$PAGE->set_context(context_system::instance());

$optionsform = new \local_reportgen\options_form();

if ($formdata = $optionsform->get_data()) {
    foreach ($formdata as $key => $value) {
        set_config($key, $value, 'reportgen');
    }
}

echo $OUTPUT->header();

echo $OUTPUT->box('<p><b>Pick the options you want to appear on the report, then press the "Save" button. Then you can choose how you want to view the report. It may be in the type of a PDF or a web page.</b></p>');

//Adding the Select and Deselect ALL buttons.
echo $OUTPUT->single_button('#', get_string("selectall", "local_reportgen"), 'post', ['class' => 'report-select-all singlebutton']);
echo $OUTPUT->single_button('#', get_string("deselectall", "local_reportgen"), 'post', ['class' => 'report-deselect-all singlebutton']);

$optionsform->display();

//Allows the user to generate the PDF.
echo $OUTPUT->single_button(new moodle_url('/local/reportgen/generate.php'), get_string('export', 'local_reportgen'));

//Allows the user to view on information on a webpage.
echo $OUTPUT->single_button(new moodle_url('/local/reportgen/view.php'), get_string('view', 'local_reportgen'));

$PAGE->requires->js_call_amd('local_reportgen/select_all', 'init', []);

echo $OUTPUT->footer();