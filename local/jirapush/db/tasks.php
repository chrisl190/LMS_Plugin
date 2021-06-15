<?php

/**
 * When API is scheduled to run.
 * @package    local_jirapush_db_tasks
 * @author     2021 Christopher Logan <clogan20@qub.ac.uk>
 */

defined('MOODLE_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => 'repository_onedrive\remove_temp_access_task',
        'blocking' => 0,
        'minute' => 'R',
        'hour' => '9',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ),
);
