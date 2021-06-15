<?php

/**
 * Unit tests for the source_theme class.
 *
 * @package    local_reportgen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author 2020 Christopher Logan <clogan20@qub.ac.uk>
 */

use local_reportgen\source\source_theme;

defined('MOODLE_INTERNAL') || die();
global $CFG;


class source_theme_test extends advanced_testcase
{
    /**
     * Test setup.
     */
    public function setUp(){
        $this->resetAfterTest();
    }

    /**
     * Test the is_enabled function for the theme source.
     */
    public function test_is_enabled_theme() {
        // All sources are disabled by default.
        $instance = new source_theme();
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
    public function test_get_name_theme(){
        $instance = new source_theme();
        $data = $instance->get_data();
        $source = $data['source'];
        $checkname = $instance->get_name();
        $this->assertEquals($checkname, $source);

    }
}

