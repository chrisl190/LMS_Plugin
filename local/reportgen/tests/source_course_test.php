<?php

/**
 * Unit tests for the source_course class.
 *
 * @package    local_reportgen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author 2020 Christopher Logan <clogan20@qub.ac.uk>
 */

use local_reportgen\source\source_course;

defined('MOODLE_INTERNAL') || die();
global $CFG;


class source_course_test extends advanced_testcase
{
    /**
     * Test setup.
     */
    public function setUp(){
        $this->resetAfterTest();
    }

    /**
     * Test numberOfCourses in the public method get_data() in the source_course class.
     */
    public function test_no_of_courses_get_data() {
        global $DB;
        $instance = new \local_reportgen\source\source_course();
        $data = $instance->get_data();

        $dbname = $data['data']['numberofcourses'];

        $sql = "SELECT COUNT(*) FROM {course}";
        $result = $DB->count_records_sql($sql);

        $this->assertEquals($dbname, $result);
    }


    /**
     * Test the is_enabled function for the course source.
     */
    public function test_is_enabled_course() {
        // All sources are disabled by default.
        $instance = new source_course();
        $checkenabled = $instance->is_enabled();
        $this->assertFalse($checkenabled);

        // Then we'll enable the plugin by doing set_config passing in the plugin name, the setting name.
        $checkenabled = set_config("reportgen", "test");
        //This time it'll be true instead of false as the plugin should be enabled
        $this->assertTrue($checkenabled);
    }

    /**
     * Test the get_name function
     */
    public function test_get_name_course(){
        $instance = new source_course();
        $data = $instance->get_data();
        $source = $data['source'];
        $checkname = $instance->get_name();
        $this->assertEquals($checkname, $source);

    }

}
