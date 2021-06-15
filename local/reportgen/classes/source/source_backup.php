<?php

/**
 * Backup details source
 * @package    local_reportgen_source_source_backup
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\source;
use coding_exception;
use dml_exception;

class source_backup extends source_base
{
    /**
     * Overriding base function.
     * @return array
     * @throws coding_exception
     * @throws dml_exception
     */
    public function get_data() {
        $data = [
            'coursebackup' => $this->auto_backup_enabled_message(),
            'coursebackupsday' => $this->auto_backups_day(),
            'coursebackupshour' => $this->auto_backups_hour(),
            'coursebackupsmin' => $this->auto_backups_min(),
            'coursebackupsstorage' => $this->auto_backups_storage(),
            'coursebackupslocation' => $this->auto_backups_location(),
        ];
        return ['source' => 'Backup Details', 'data' => $data];
    }

    /**
     * Used for registering if checkbox is selected in options form.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $enabled = (bool) get_config('reportgen', 'BackupDetails');
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
            throw new \coding_exception('Missing or invalid source');
        }
    }

    /**
     * Getting the backup details description for the options page.
     * @return array
     * @throws coding_exception
     */
    public function get_information() {
        $informationsources = ['name' => 'backupdetails', 'displayname' => get_string("backupdetails", "local_reportgen")];
        return $informationsources;
    }


    /**
     * Used to add the data to the Mustache template.
     * @return mixed
     * @throws coding_exception
     * @throws dml_exception
     */
    public function render() {
        global $OUTPUT;
        $data = $this->get_data();
        return $OUTPUT->render_from_template('local_reportgen/source_report', $data);
    }


    /**
     * Checks if auto_backup is enabled which is then used in functions below as a check.
     * @return mixed
     * @throws dml_exception
     */
    private function check_auto_backup_enabled() {
        global $DB;
        $enabled = $DB->get_field('config_plugins', 'value', ['name' => 'backup_auto_active']);
        //$enabled = get_config('reportgen', 'backup_auto_active');
        return $enabled;
    }

    /**
     * Displays a message saying whether auto backups are enabled.
     * @return string
     * @throws coding_exception
     * @throws dml_exception
     */
    private function auto_backup_enabled_message() {
        global $DB;
        $enabled = $DB->get_field('config_plugins', 'value', ['name' => 'backup_auto_active']);
        if ($enabled == 0) return get_string('nobackups', 'local_reportgen');

        return get_string('backups', 'local_reportgen');
    }

    /**
     * Gathers details of whats days backup is schedule, if enabled.
     * @return mixed|string
     * @throws coding_exception
     * @throws dml_exception
     */
    private function auto_backups_day() {
        global $DB;
        $enabled = $this->check_auto_backup_enabled();

        if ($enabled > 0){
            $day = $DB->get_field('config_plugins', 'value', ['name' => 'backup_auto_weekdays']);
            if($day == 0000000) return get_string('nodays', 'local_reportgen');
            return $day;
        }
        return '';
    }

    /**
     * Gathers details of what hour backup is schedule, if enabled.
     * @return mixed|string
     * @throws dml_exception
     */
    private function auto_backups_hour() {
        global $DB;
        $enabled = $this->check_auto_backup_enabled();

        if ($enabled > 0) {
            $hour = $DB->get_field('config_plugins', 'value', ['name' => 'backup_auto_hour']);
            return $hour;
        }
        return '';
    }

    /**
     * Gathers details of what minute backup is schedule, if enabled.
     * @return mixed|string
     * @throws dml_exception
     */
    private function auto_backups_min() {
        global $DB;
        $enabled = $this->check_auto_backup_enabled();

        if ($enabled > 0) {
            $min = $DB->get_field('config_plugins', 'value', ['name' => 'backup_auto_minute']);
            return $min;
        }
        return '';
    }

    /**
     * Gathers details of storage details, if enabled.
     * @return string
     * @throws coding_exception
     * @throws dml_exception
     */
    private function auto_backups_storage() {
        global $DB;
        $enabled = $this->check_auto_backup_enabled();

        if ($enabled > 0) {
            $storage = $DB->get_field('config_plugins', 'value', ['name' => 'backup_auto_storage']);
            if($storage == 0) return get_string('storage0', 'local_reportgen');
            else if ($storage == 1) return get_string('storage0', 'local_reportgen');
            else if ($storage == 1) return get_string('storage0', 'local_reportgen');
            return 'Invalid value';
        }
        return '';
    }

    /**
     * Gathers details of location details, if enabled.
     * @return mixed|string
     * @throws dml_exception
     */
    private function auto_backups_location() {
        global $DB;
        $enabled = $this->check_auto_backup_enabled();

        if ($enabled > 0){
            $location = $DB->get_field('config_plugins', 'value', ['name' => 'backup_auto_destination']);

            return $location;
        }
        return '';
    }

}
