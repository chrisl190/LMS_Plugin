<?php

/**
 * Database details source
 * @package    local_reportgen_source_source_database
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\source;
use coding_exception;
use dml_exception;

class source_database extends source_base
{

    /**
     * Overriding base function.
     * @return array
     * @throws dml_exception
     */
    public function get_data() {
        $data = [
            'dbname' => $this->get_db_name(),
            'dbsize' => $this->get_db_size(),
            'dbtype' => $this->get_db_type(),
            'dbhost' => $this->get_db_host(),
            'dblibrary' => $this->get_db_library(),
            'filedirusage' => $this->get_filedir_Usage(),
        ];
        return ['source' => 'Database Details', 'data' => $data];
    }

    /**
     * Used for registering if checkbox is selected in options form.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $enabled = (bool) get_config('reportgen', 'DBdetails');
        return $enabled;
    }

    /**
     * Returns the source for the sub heading on the report.
     * @return mixed|string
     * @throws coding_exception
     * @throws dml_exception
     */
    public function get_name() {
        $data = $this->get_data();
        if(isset($data)){
            return $data['source'];
        } else {
            throw new coding_exception('Missing or invalid source');
        }
    }

    /**
     * Getting the database details description for the options page.
     * @return array
     * @throws coding_exception
     */
    public function get_information() {
        $informationsources = ['name' => 'dbdetails', 'displayname' => get_string("dbdetails", "local_reportgen")];

        return $informationsources;
    }


    /**
     * Used to add the data to the Mustache template.
     * @return mixed
     * @throws dml_exception
     */
    public function render() {
        global $OUTPUT;
        $data = $this->get_data();
        return $OUTPUT->render_from_template('local_reportgen/source_report', $data);
    }


    /**
     * Gathers the name of the Database.
     * @return mixed
     */
    private function get_DB_name() {
        global $CFG;
        return $CFG->dbname;
    }

    /**
     * Gathers the size of the Database.
     * @return string
     * @throws dml_exception
     */
    private function get_DB_size() {
        global $DB;
        $sql = "SELECT table_name AS table_name,
                      ROUND(((data_length + index_length) / 1024 / 1024), 2) AS table_size
                  FROM information_schema.TABLES
                 WHERE table_schema = :databasename
              ORDER BY (data_length + index_length) DESC;";

        $params = ['databasename' => $this->get_DB_name()];
        $records = $DB->get_records_sql($sql, $params);
        $total = 0;

        foreach ($records as $record) {
            $total += (float) $record->table_size;
        }
        return $total . " MB"; // Total is in MB
    }

    /**
     * Gathers type of Database.
     * @return mixed
     */
    private function get_db_type() {
        global $CFG;
        return $CFG->dbtype;
    }

    /**
     * Gathers host of Database.
     * @return mixed
     */
    private function get_db_host() {
        global $CFG;
        return $CFG->dbhost;
    }

    /**
     * Gathers Database Library.
     * @return mixed
     */
    private function get_db_library() {
        global $CFG;
        return $CFG->dblibrary;
    }

    /**
     * Gathers the File Directory Usage of the Database.
     * @return mixed
     * @throws dml_exception
     */
    private function get_filedir_Usage() {
        global $DB;
        $fileDir = $DB->get_field_sql('SELECT SUM(filesize) FROM {files}');
        return $fileDir . " MB";
    }
}
