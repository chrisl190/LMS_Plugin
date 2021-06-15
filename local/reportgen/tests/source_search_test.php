<?php

/**
 * Unit tests for the source_search class.
 *
 * @package    local_reportgen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author 2020 Christopher Logan <clogan20@qub.ac.uk>
 */

use local_reportgen\source\source_search;

defined('MOODLE_INTERNAL') || die();
global $CFG;


class source_search_test extends advanced_testcase
{
    /**
     * Test setup.
     */
    public function setUp(){
        $this->resetAfterTest();
    }

    /**
     * Test the is_enabled function for the search source.
     */
    public function test_is_enabled_search() {
        // All sources are disabled by default.
        $instance = new source_search();
        $checkenabled = $instance->is_enabled();
        $this->assertFalse($checkenabled);

        // Then we'll enable the plugin by doing set_config passing in the plugin name, the setting name.
        $checkenabled = set_config("reportgen", "test");
        //This time it'll be true instead of false as the plugin should be enabled
        $this->assertTrue($checkenabled);
    }

    public function test_get_global_search_details()
    {
        global $DB;
        // Force our value to be 1.
        $record = $DB->get_record('config', ['name' => 'enableglobalsearch']);
        $value = $record->value = 1;
        $DB->update_record('config', $record);
        $this->assertEquals($value, 1);

        // Force our value to be 0.
        $value = $record->value = 0;
        $DB->update_record('config', $record);
        $this->assertEquals($value, 0);
    }

    /**
     * Test the get_name function
     */
    public function test_get_name_search(){
        $instance = new source_search();
        $data = $instance->get_data();
        $source = $data['source'];
        $checkname = $instance->get_name();
        $this->assertEquals($checkname, $source);

    }
}

