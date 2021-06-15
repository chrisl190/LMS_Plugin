<?php

/**
 * API task
 * @package    local_jirapush_api
 * @author     2021 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_jirapush;
use coding_exception;
use curl;
use dml_exception;
use moodle_exception;
use stdClass;

defined('MOODLE_INTERNAL') || die();

class api {
    private $config;

    /**
     * API constructor.
     * @throws dml_exception
     */
    public function __construct() { //pass in variables from report.
        $this->config = get_config('local_jirapush');
    }

    /**
     * Get an object schema by it's key.
     * @param string $objectschemakey Key name
     * @return stdClass Schema object
     * @throws moodle_exception
     */
    public function get_object_schema_by_name($objectschemakey): stdClass {
        $curl = new curl();

        // Need the API key to make the call.
        if(!$this->config->apikey) {
            throw new moodle_exception('Please enter REST API key', 'local_jirapush');
        }

        // Add our HTTP headers.
        $curl->setHeader([
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->config->apikey
        ]);

        // Make the API request.
        $url = 'https://insight-api.riada.io/rest/insight/1.0/objectschema/list';
        $response = $curl->get($url);
        $objectschemas = json_decode($response)->objectschemas;

        // Try find the object schema in the list of object schemas returned by the API.
        foreach ($objectschemas as $objectschema) {
            $name = $objectschema->objectSchemaKey;

            if ($name == $objectschemakey) {
                return $objectschema;
            }
        }

        // Schema wasn't found, throw an exception.
        throw new moodle_exception('Please enter Object Schema', 'local_jirapush');
    }

    /**
     * Get an object schema by it's type.
     * @param int $schemaid ID
     * @param string $objecttypename Type
     * @return stdClass
     * @throws moodle_exception
     */

    public function get_schema_object_type_by_name(int $schemaid, string $objecttypename): stdClass {
        $curl = new curl();

        // Need to have the API key to make the call.
        if(!$this->config->apikey) {
            throw new moodle_exception('Please enter REST API key', 'local_jirapush');
        }

        // Add our HTTP headers.
        $curl->setHeader([
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->config->apikey
        ]);

        // Make the API request.
        $url = "https://insight-api.riada.io/rest/insight/1.0/objectschema/$schemaid/objecttypes/flat";
        $response = $curl->get($url);
        $objecttypes = json_decode($response);

        // Try find the object type in the list of object types returned by the API.
        foreach ($objecttypes as $objecttype) {
            $name = $objecttype->name;

            if ($name == $objecttypename) {
                return $objecttype;
            }
        }

        // Object type wasn't found, throw an exception.
        throw new moodle_exception('Please enter Object Type', 'local_jirapush');
    }

    /**
     * Get an object schema by it's attribute.
     * @param int $objecttypeid
     * @return mixed
     * @throws moodle_exception
     */
    public function get_object_type_attributes(int $objecttypeid) {
        $curl = new curl();

        // We have to have the API key to make the call.
        if(!$this->config->apikey) {
            throw new moodle_exception('Please enter REST API key', 'local_jirapush');
        }

        // Add our HTTP headers.
        $curl->setHeader([
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->config->apikey
        ]);

        // Make the API request.
        $url = "https://insight-api.riada.io/rest/insight/1.0/objecttype/$objecttypeid/attributes";
        $response = $curl->get($url);
        $attributes = json_decode($response);

        return $attributes;
    }

    /**
     * Create the object schema.
     * @param int $objecttypeid
     * @param array $attributes
     * @param api_request $apirequest
     * @return array|mixed
     * @throws moodle_exception
     */
    public function create_object(int $objecttypeid, array $attributes, api_request $apirequest) {
        $curl = new curl();

        // We have to have the API key to make the call.
        if(!$this->config->apikey) {
            throw new moodle_exception('Please enter REST API key', 'local_jirapush');
        }

        // Add our HTTP headers.
        $curl->setHeader([
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->config->apikey
        ]);

        // Make the API request.
        $url = "https://insight-api.riada.io/rest/insight/1.0/object/create";

        $content = (object)[
            'objectTypeId' => $objecttypeid,
            'attributes' => $apirequest->export_attributes_data(),
        ];

        $content = json_encode($content);

        $response = $curl->post($url, $content);
        $attributes = json_decode($response);

        return $attributes;
    }

    /**
     * Send the request.
     * @param $data
     * @return bool
     * @throws dml_exception
     * @throws moodle_exception
     */
    public function send($data) : bool {
        $objectschema = $this->get_object_schema_by_name($this->config->objectschemakey);

        $objecttype = $this->get_schema_object_type_by_name($objectschema->id, $this->config->objecttypename);
        $attributes = $this->get_object_type_attributes($objecttype->id);
        $apirequest = new api_request($data, $attributes);

        $this->create_object($objecttype->id, $attributes, $apirequest);
        return false;

        global $CFG;
        $config = get_config('local_jirapush');
        $encodedcontent = json_encode($apirequest->data);

        $curl = new curl();
        if (!$config->apikey) {
            //If API Key are missing, throw an exception.
            throw new moodle_exception('No API Key', 'local_jirapush');
        }

        $curl->setHeader([
            'Content-Type: application/json',
            'Authorization: Bearer ' . $config->apikey
        ]);

        $config->url = 'https://insight-api.riada.io/rest/insight/1.0/objectschema/list';
        $response = $curl->get($config->url);

        if ($curl->error) {
            $this->add_to_log(log::STATUS_FAILURE, $curl->error, $encodedcontent, $response);
            return false;
        }

        //Checking against the HTTP status code 200.
        if (trim($response) == 200) {
            $this->add_to_log(log::STATUS_SUCCESS);
            return true;
        }

        // We have a response from the API that isn't empty.
        $respdecoded = json_decode($response);
        $message = '';
        if (!empty($respdecoded->Message)) {
            $message = $respdecoded->Message;
        }
        $this->add_to_log(log::STATUS_FAILURE, $message, $encodedcontent, $response);
        return false;
    }

    /**
     * Add to JIRA Push logging system.
     * @param $status
     * @param string $error
     * @param null $fullrequest
     * @param null $fullresponse
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    private function add_to_log($status, $error = '', $fullrequest = null, $fullresponse = null) {
        log::add();
    }

}
