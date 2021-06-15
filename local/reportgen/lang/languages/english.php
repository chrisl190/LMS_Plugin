<?php

defined('MOODLE_INTERNAL') || die();
global $CFG;

require_once($CFG->dirroot.'/local/reportgen/lang/Language.php');

class EnglishLanguage extends Language {
    public $rtl;

    public function __construct($settings = array('rtl' => true)) {
        foreach ($settings as $setting => $value) {
            switch ($setting) {
                case 'rtl':
                    $rtl = $value;
                    break;
            }
        }
    }

    public function apply_language($pdf) {
        $pdf->setRTL(false);
    }

    public function reset_language($pdf) {
        $pdf->setRTL(false);
    }

    public function is_RTL() {
        return $this->rtl;
    }
}