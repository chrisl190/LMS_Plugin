<?php

/**
 * Run task manually page.
 * @package    local_jirapush_runtasks
 * @author     2021 Christopher Logan <clogan20@qub.ac.uk>
 */

require_once(__DIR__.'/../../config.php');
global $PAGE;

// Context.
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');

// Set URL.
$url = new moodle_url('/local/jirapush/success.php');
$PAGE->set_url($url);

$confirmed = optional_param('confirmed', false, PARAM_BOOL);

// Security check.
require_login();

echo $OUTPUT->header();

echo $OUTPUT->box('<p><b>Once a day, the REST API is scheduled to run. You can, however, run it manually right now by clicking the button below.</b></p>');

echo $OUTPUT->single_button($url, get_string('runtask', 'local_jirapush'));

echo $OUTPUT->footer();