<?php

defined('MOODLE_INTERNAL') || die();
global $CFG;

require_once($CFG->dirroot.'local/reportgen/lang/languages/english.php');


class LanguageFactory {
    public static function create($language) {
        $supportedLanguages = LanguageFactory::getSupportedLanguages();
        return $supportedLanguages[$language]->newInstance();
    }

    public static function getDefault() {
        $supportedLanguages = LanguageFactory::getSupportedLanguages();
        reset($supportedLanguages);
        return current($supportedLanguages)->newInstance();
    }

    private static function getSupportedLanguages() {
        return array(
            'english' => new EnglishLanguage(),
        );
    }
}