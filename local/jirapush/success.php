<?php

/**
 * Page showing a successful push to JIRA Cloud.
 * @package    local_reportgen_success
 * @author     2021 Christopher Logan <clogan20@qub.ac.uk>
 */

global $CFG, $PAGE, $OUTPUT;
require_once(__DIR__.'/../../config.php');

$PAGE->set_pagelayout('standard');

$PAGE->set_context(context_system::instance());

// Set URL.
$url = new moodle_url('/local/jirapush/runtask.php');

$PAGE->set_url($url);

echo $OUTPUT->header();
$task = new \local_jirapush\task\push_to_api();
$task->execute();

//Message of success when API successfully pushes to JIRA Cloud.
echo $OUTPUT->notification(get_string('notifysuccess', 'local_jirapush'), 'notifysuccess');

echo $OUTPUT->single_button($url, get_string('return', 'local_jirapush'));

echo $OUTPUT->footer();




