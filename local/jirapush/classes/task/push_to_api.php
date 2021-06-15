<?php

/**
 * Push to API task
 * @package    local_jirapush_task_push_to_api
 * @author     2021 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_jirapush\task;

use coding_exception;
use \core\task\scheduled_task;
use local_jirapush\api;
use local_reportgen\writer\json_output;
use moodle_exception;

defined('MOODLE_INTERNAL') || die();

class push_to_api extends scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     * @return string
     * @throws coding_exception
     */
    public function get_name() {
        return get_string('pushtoapitask', 'local_jirapush');
    }

    /**
     * Execute the task.
     * Throw exceptions on errors (the job will be retried).
     * @throws moodle_exception
     * @throws coding_exception
     */
    public function execute() {
        // Export data from local_reportgen using JSON output writer.
        $jsonoutput = new json_output();
        $data = $jsonoutput->export_to_json();

        $api = new api();
        $api->send($data);
    }
}
