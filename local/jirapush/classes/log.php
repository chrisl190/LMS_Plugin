<?php
/**
 * Logging system for JIRA Push plugin.
 * Note: Not finished yet. Hasn't been completed due to time restrictions.
 * @package    local_jirapush_log
 * @author     2021 Christopher Logan <clogan20@qub.ac.uk>
 */
namespace local_jirapush;

use coding_exception;
use dml_exception;
use moodle_exception;

defined('MOODLE_INTERNAL') || die();

class log {
    const STATUS_FAILURE = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_INVALID = 2;
    const STATUS_ANY = -1;

    private static $validstatus = [self::STATUS_FAILURE, self::STATUS_SUCCESS, self::STATUS_INVALID];

    private static $lastcount;

    /**
     * Add a log entry.
     * @param int $status - self::STATUS_FAILURE | self::STATUS_SUCCESS
     * @param api_request $apirequest
     * @param int $objecttypeid
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    public static function add($status, api_request $apirequest, int $objecttypeid) {
        global $DB;

        if (!in_array($status, self::$validstatus, true)) {
            throw new coding_exception('Invalid status: {$status}');
        }

        $insert = (object)[
            'objectTypeId' => $objecttypeid,
            'attributes' => $apirequest->export_attributes_data(),
        ];


        $DB->insert_record('mdl_log', $insert, false);
    }

    /**
     * Clear logs.
     * @throws dml_exception
     */
    public static function clear() {
        global $DB;
        $DB->delete_records('mdl_log', []);
    }

    /**
     * Get logs.
     * @param $page
     * @param int $perpage
     * @param null $from
     * @param null $to
     * @param int $status
     * @return array
     * @throws dml_exception
     */
    public static function get(&$page, $perpage = 30, $from = null, $to = null, $status = self::STATUS_ANY) : array {
        global $DB;
        $wheres = [];
        $params = [];
        if ($from) {
            $wheres[] = 'l.timestamp >= :from';
            $params['from'] = $from;
        }
        if ($to) {
            $wheres[] = 'l.timestamp < :to';
            $params['to'] = $to + DAYSECS;
        }
        if ((int)$status !== self::STATUS_ANY) {
            $wheres[] = 'l.status = :status';
            $params['status'] = $status;
        }
        $where = '';
        if ($wheres) {
            $where = 'WHERE '.implode(' AND ', $wheres);
        }
        $sql = "SELECT userid FROM {log}
            $where";
        self::$lastcount = $DB->count_records_sql('SELECT COUNT(1)'.$sql, $params);
        $start = $page * $perpage;
        if ($start > self::$lastcount) {
            $start = 0;
            $page = 0;
        }
        return $DB->get_records_sql( $params, $start, $perpage);
    }


    /**
     * Get last record.
     * @return mixed
     */
    public static function last_count() {
        return self::$lastcount;
    }

}