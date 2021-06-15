<?php

/**
 * API request
 * @package    local_jirapush_api_request
 * @author     2021 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_jirapush;

use moodle_exception;
use stdClass;

defined('MOODLE_INTERNAL') || die();

class api_request {
    public $data;
    public $attributes;

    /**
     * api_request constructor.
     * @param $data
     * @param $attributes
     */
    public function __construct($data, $attributes) { //pass in variables from report.
        $this->data = json_decode($data);
        $this->attributes = $attributes;
    }

    /**
     * Build the data for the attributes.
     * @return array
     * @throws moodle_exception
     */
    public function export_attributes_data(): array {
        return [
            $this->build_attribute_name(),
            $this->build_attribute_db_type(),
            $this->build_attribute_db_name(),
            $this->build_attribute_db_host(),
            $this->build_attribute_db_collation(),
            $this->build_attribute_reg_users(),
            $this->build_attribute_active_users(),
            $this->build_attribute_no_courses(),
            $this->build_attribute_filedir(),
            $this->build_attribute_wwwroot(),
            $this->build_attribute_local_cache(),
            $this->build_attribute_course_backup(),
            $this->build_attribute_course_backup_specified_dir(),
            $this->build_attribute_search_enabled(),
            $this->build_attribute_auth_methods(),
        ];
    }


    /**
     * Build the name attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_name(): object {
        $attributename = $this->get_attribute_by_name('Name');
        $datasourcedomain = $this->get_data_source('Domain Name and URL Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->domainname,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build db type attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_db_type(): object {
        $attributename = $this->get_attribute_by_name('DB Type');
        $datasourcedomain = $this->get_data_source('Database Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->dbtype,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build the db name attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_db_name(): object {
        $attributename = $this->get_attribute_by_name('DB Name');
        $datasourcedomain = $this->get_data_source('Database Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->dbname,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build db host attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_db_host(): object {
        $attributename = $this->get_attribute_by_name('DB Host');
        $datasourcedomain = $this->get_data_source('Database Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->dbhost,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build db collation attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_db_collation(): object {
        $attributename = $this->get_attribute_by_name('DB Collation');
        $datasourcedomain = $this->get_data_source('Database Collation Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->dbcollation,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build registered users attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_reg_users(): object {
        $attributename = $this->get_attribute_by_name('Number of Registered Users');
        $datasourcedomain = $this->get_data_source('User Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->totalusers,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build the active users attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_active_users(): object {
        $attributename = $this->get_attribute_by_name('Number of Active Users');
        $datasourcedomain = $this->get_data_source('User Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->activeusers,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build number of courses attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_no_courses(): object {
        $attributename = $this->get_attribute_by_name('Number of Courses');
        $datasourcedomain = $this->get_data_source('Course Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->numberofcourses,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build file directory size attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_filedir(): object {
        $attributename = $this->get_attribute_by_name('Filedir Usage');
        $datasourcedomain = $this->get_data_source('Database Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->filedirusage,
                ],
            ],
        ];

        return $attribute;
    }


    /**
     * Build the wwwroot attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_wwwroot(): object {
        $attributename = $this->get_attribute_by_name('wwwroot');
        $datasourcedomain = $this->get_data_source('Website and Data Files Location Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->wwwroot,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build local cache attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_local_cache(): object {
        $attributename = $this->get_attribute_by_name('Local Cache');
        $datasourcedomain = $this->get_data_source('Cache Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->cachedetails,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build the course backup attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_course_backup(): object {
        $attributename = $this->get_attribute_by_name('Course Backups Enabled');
        $datasourcedomain = $this->get_data_source('Backup Details');

        $coursebackup = $datasourcedomain->data->coursebackup;
        $backupsenabled = $coursebackup == get_string('nobackups', 'local_reportgen') ? false : true;

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $backupsenabled,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build the course backup specified directory attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_course_backup_specified_dir(): object {
        $attributename = $this->get_attribute_by_name('Course Backup Specified Dir');
        $datasourcedomain = $this->get_data_source('Backup Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->coursebackupslocation,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build the global search attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_search_enabled(): object {
        //Name of the attribute in JIRA Cloud.
        $attributename = $this->get_attribute_by_name('Global Search Enabled');
        //Name of the source in the reportgen get_data() function.
        $datasourcedomain = $this->get_data_source('Global Search Details');

        $globalsearch = $datasourcedomain->data->globalsearch;

        //Ensure the information is in a boolean format.
        $searchenabled = $globalsearch == get_string('nosearch', 'local_reportgen') ? false : true;

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $searchenabled,
                ],
            ],
        ];

        return $attribute;
    }

    /**
     * Build attribute authentication methods attribute.
     * @return object
     * @throws moodle_exception
     */
    private function build_attribute_auth_methods(): object {
        $attributename = $this->get_attribute_by_name('Auth Methods');
        $datasourcedomain = $this->get_data_source('Authentication Details');

        $attribute = (object)[
            'objectTypeAttributeId' => $attributename->id,
            "objectAttributeValues" => [
                (object)[
                    "value" => $datasourcedomain->data->authenticationdetails,
                ],
            ],
        ];

        return $attribute;
    }


    /**
     * Get data source by it's key name.
     * @param $name
     * @return stdClass
     * @throws moodle_exception
     */
    private function get_data_source($name): stdClass {
        foreach ($this->data as $source) {
            if ($source->source == $name) {
                return $source;
            }
        }

        throw new moodle_exception('Could not find data source', 'local_jirapush', $name);
    }

    /**
     * Get attribute by it's key name.
     * @param $name
     * @return stdClass
     * @throws moodle_exception
     */
    private function get_attribute_by_name($name): stdClass {
        foreach ($this->attributes as $attribute) {
            if ($attribute->name == $name) {
                return $attribute;
            }
        }

        throw new moodle_exception('Could not find attribute', 'local_jirapush', $name);
    }
}
