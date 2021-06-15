<?php

/**
 * Show log attempts for the API
 * Note: Not finished yet. Hasn't been completed due to time constraints.
 * @package    local_jirapush_log
 * @author     2021 Christopher Logan <clogan20@qub.ac.uk>
 */

use local_jirapush\log;

require_once(__DIR__.'/../../config.php');
global $PAGE;

// Handle filter params.
$status = optional_param('status', log::STATUS_ANY, PARAM_INT);
$from = optional_param('from', 0, PARAM_INT);
$to = optional_param('to', 0, PARAM_INT);
$page = optional_param('page', 0, PARAM_INT);
$perpage = optional_param('perpage', 30, PARAM_INT);

$url = new moodle_url('/local/jirapush/log.php');
if ($status !== log::STATUS_ANY) {
    $url->param('status', $status);
}
else if ($from) {
    $url->param('from', $from);
}
else if ($to) {
    $url->param('to', $to);
}
else if ($page) {
    $url->param('page', $page);
}
else if ($perpage !== 30) {
    $url->param('perpage', $perpage);
}

// Security check.
require_login();
$logs = log::get($page, $perpage, $from, $to, $status);
if ($logs) {
    $table = new html_table();
    $table->caption = get_string('title', 'local_jirapush');
    $table->head = [
        get_string('status', 'local_jirapush'),
        get_string('datetime', 'local_jirapush'),
        get_string('user'),
        get_string('error', 'local_jirapush'),
    ];
    $statuses = [
        log::STATUS_SUCCESS => get_string('success','local_jirapush'),
        log::STATUS_FAILURE => get_string('failure', 'local_jirapush'),
        log::STATUS_INVALID => get_string('invalid', 'local_jirapush'),
    ];
    $format = get_string('strftimedatetime', 'langconfig');
    foreach ($logs as $log) {
        $row = [
            $statuses[$log->status],
            userdate($log->timestamp, $format),
            format_string($log->coursename),
            fullname($log),
            $log->errormessage,
            $log->fullrequest,
            $log->fullresponse,
        ];
        $table->data[] = $row;
    }
}

echo $OUTPUT->header();
$form->display();

//Output table to page
if ($table) {
    $paging = $OUTPUT->paging_bar(log::last_count(), $page, $perpage, $PAGE->url);
    echo $paging;
    echo html_writer::table($table);
    echo $paging;
} else {
    echo '<p>'.get_string('nologs', 'local_jirapush');
}

$clearurl = new moodle_url($PAGE->url, ['clear' => 1]);
echo $OUTPUT->single_button($clearurl, get_string('clearlogs', 'local_jirapush'));

echo $OUTPUT->footer();



