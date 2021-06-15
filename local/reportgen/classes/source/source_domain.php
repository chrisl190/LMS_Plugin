<?php

/**
 * Domain details source
 * @package    local_reportgen_source_source_domain
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\source;

use coding_exception;
use dml_exception;

class source_domain extends source_base
{
    /**
     * Overriding base function.
     * @return array
     */
    public function get_data() {
        $data = [
            'domainname' => $this->get_domain(),
            'url' => $this->get_url(),
        ];
        return ['source' => 'Domain Name and URL Details', 'data' => $data];
    }

    /**
     * Used for registering if checkbox is selected in options form.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $enabled = (bool) get_config('reportgen', 'domain');
        return $enabled;
    }

    /**
     * Returns the source for the sub heading on the report.
     * @return mixed|string
     * @throws \coding_exception
     */
    public function get_name() {
        $data = $this->get_data();
        if(isset($data)){
            return $data['source'];
        } else {
            throw new \coding_exception('Missing or invalid source');
        }
    }

    /**
     * Getting the domain details description for the options page.
     * @return array
     * @throws coding_exception
     */
    public function get_information() {
        $informationsources = ['name' => 'domain', 'displayname' => get_string("domain", "local_reportgen")];

        return $informationsources;
    }


    /**
     * Used to add the data to the Mustache template.
     * @return mixed
     */
    public function render() {
        global $OUTPUT;
        $data = $this->get_data();
        return $OUTPUT->render_from_template('local_reportgen/source_report', $data);
    }


    /**
     * This get the domain name of the site.
     * @return string
     */
    private function get_domain() {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $link = "https";
        else
            $link = "http";
        $link .= "://";
        //Add the host(domain name).
        $link .= $_SERVER['HTTP_HOST'];

        return $link;
    }

    /**
     * This get the url of the site.
     * @return string
     */
    private function get_url() {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $link = "https";
        else
            $link = "http";
        $link .= "://";
        //Add the host(domain name).
        $link .= $_SERVER['HTTP_HOST'];
        //Add the requested resource location to the URL
        $link .= $_SERVER['REQUEST_URI'];

        return $link;
    }
}

