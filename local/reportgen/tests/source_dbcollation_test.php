<?php

/**
 * Unit tests for the source_dbcollation class.
 *
 * @package    local_reportgen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author 2020 Christopher Logan <clogan20@qub.ac.uk>
 */

use local_reportgen\source\source_dbcollation;

defined('MOODLE_INTERNAL') || die();
global $CFG;


class source_dbcollation_test extends advanced_testcase
{
    /**
     * Test setup.
     */
    public function setUp(){
        $this->resetAfterTest();
    }

    /**
     * Test DBcollation in the public method get_data() in the source_dbcollation class.
     */
    public function test_dbcollation_get_data() {
        global $CFG;

        $instance = new source_dbcollation();
        $data = $instance->get_data();
        $dbname = $data['data']['dbcollation'];

        $this->assertEquals($dbname, $CFG->dboptions['dbcollation']);
    }

    /**
     * Test the is_enabled function for the dbcollation source.
     */
    public function test_is_enabled_dbcollation() {
        // All sources are disabled by default.
        $instance = new source_dbcollation();
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
    public function test_get_name_dbcollation(){
        $instance = new source_dbcollation();
        $data = $instance->get_data();
        $source = $data['source'];
        $checkname = $instance->get_name();
        $this->assertEquals($checkname, $source);

    }
}

