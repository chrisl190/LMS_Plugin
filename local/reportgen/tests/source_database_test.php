<?php

/**
 * Unit tests for the source_database class.
 *
 * @package    local_reportgen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author 2020 Christopher Logan <clogan20@qub.ac.uk>
 */

use local_reportgen\source\source_database;

defined('MOODLE_INTERNAL') || die();
global $CFG;


class source_database_test extends advanced_testcase
{
    /**
     * Test setup.
     */
    public function setUp(){
        $this->resetAfterTest();
    }

    /**
     * Test DBname in the public method get_data() in the source_database class.
     */
    public function test_dbName_get_data() {
        global $CFG;

        $instance = new source_database();
        $data = $instance->get_data();
        $dbname = $data['data']['dbname'];

        $this->assertEquals($dbname, $CFG->dbname);
    }

    /**
     * Test DBtype in the public method get_data() in the source_database class.
     */
    public function test_dbtype_get_data() {
        global $CFG;

        $instance = new source_database();
        $data = $instance->get_data();
        $dbname = $data['data']['dbtype'];

        $this->assertEquals($dbname, $CFG->dbtype);
    }

    /**
     * Test DBhost in the public method get_data() in the source_database class.
     */
    public function test_dbhost_get_data() {
        global $CFG;

        $instance = new source_database();
        $data = $instance->get_data();
        $dbname = $data['data']['dbhost'];

        $this->assertEquals($dbname, $CFG->dbhost);
    }

    /**
     * Test DBlibrary in the public method get_data() in the source_database class.
     */
    public function test_dblibrary_get_data() {
        global $CFG;

        $instance = new source_database();
        $data = $instance->get_data();
        $dbname = $data['data']['dblibrary'];

        $this->assertEquals($dbname, $CFG->dblibrary);
    }

    /**
     * Test the is_enabled function for the database source.
     */
    public function test_is_enabled_database() {
        // All sources are disabled by default.
        $instance = new source_database();
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
    public function test_get_name_database(){
        $instance = new source_database();
        $data = $instance->get_data();
        $source = $data['source'];
        $checkname = $instance->get_name();
        $this->assertEquals($checkname, $source);

    }

}
