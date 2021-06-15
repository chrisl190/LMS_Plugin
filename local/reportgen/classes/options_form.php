<?php

/**
 * Options form.
 * @package    local_reportgen_source_options_form
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen;

global $CFG;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

use moodleform;
use stdClass;

class options_form extends moodleform {

    public function definition() {
        $mform = $this->_form;
        $mform->addElement('header', 'optionsheading', 'Options Page');

        //Storing the name from each source.
        $sourceclasses = (new export_all_data)->get_source_classes();
        foreach ($sourceclasses as $sourceclass) {
            $informationsources[] = $sourceclass->get_information();
        }

        //Adding the checkbox buttons to the form.
        foreach ($informationsources as $source) {
            $mform->addElement('advcheckbox', $source['name'], $source['displayname']);
            $mform->setDefault($source['name'], 0);
        }

        $this->add_action_buttons();
    }

    /**
     * Creates array which stores all of the error which is then returned.
     * @param $data
     * @param $files
     * @return array|stdClass
     */

    function validation($data, $files) {
        //Making sure a checkbox has been selected.
        $errors = parent::validation($data, $files);
        if(isset($_POST['checkbox_name']) && $_POST['checkbox_name']="")
            return $errors;
    }
}

