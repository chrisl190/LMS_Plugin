<?php

/**
 * Generate form.
 * @package    local_reportgen_generate_form
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen;

global $CFG;

require_once($CFG->libdir . '/formslib.php');

use moodleform;

defined('MOODLE_INTERNAL') || die();

class generate_form extends moodleform {

    public function definition() {
        $mform = $this->_form;
        $mform->addElement('static', '', '', get_string("description", "local_reportgen"));
        $mform->addElement('button', 'generate', get_string("generate", "local_reportgen"));
        $mform->addElement('button', 'confirm', get_string("confirm", "local_reportgen"));
    }
}