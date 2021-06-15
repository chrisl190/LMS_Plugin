<?php

/**
 * Course details source
 * @package    local_reportgen_source_source_course
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

namespace local_reportgen\source;

use coding_exception;
use dml_exception;

class source_course extends source_base {

    /**
     * Overriding base function.
     * @return array
     * @throws dml_exception
     */
    public function get_data() {
        $data = [
            'numberofcourses' => $this->get_number_of_courses(),
            'categories' => $this->get_course_categories(),
            'popularcourse' => $this->get_popular_course_id(),
        ];
        return ['source' => 'Course Details', 'data' => $data];
    }

    /**
     * Used for registering if checkbox is selected in options form.
     * @return bool
     * @throws dml_exception
     */
    public function is_enabled() {
        $enabled = (bool) get_config('reportgen', 'courseDetails');
        return $enabled;
    }

    /**
     * Returns the source for the sub heading on the report.
     * @return mixed|string
     * @throws coding_exception
     * @throws dml_exception
     */
    public function get_name() {
        $data = $this->get_data();
        if(isset($data)){
            return $data['source'];
        } else {
            throw new coding_exception('Missing or invalid source');
        }
    }

    /**
     * Used to add the data to the Mustache template.
     * @return mixed
     * @throws dml_exception
     */
    public function render() {
        global $OUTPUT;
        $data = $this->get_data();
        return $OUTPUT->render_from_template('local_reportgen/source_report', $data);
    }

    /**
     * Getting the course details description for the options page.
     * @return array
     * @throws coding_exception
     */
    public function get_information() {
        $informationsources = ['name' => 'coursedetails', 'displayname' => get_string("coursedetails", "local_reportgen")];
        return $informationsources;
    }


    /**
     * Gathers the number of courses on the site.
     * @return int
     * @throws dml_exception
     */
    private function get_number_of_courses() {
        global $DB;
        $sql = "SELECT COUNT(*) FROM {course}";
        return $DB->count_records_sql($sql);
    }

    /**
     * Displays name of all the course categories.
     * @return mixed
     * @throws dml_exception
     */
    private function get_course_categories() {
        global $DB;
        $category = $DB->get_field_sql(" SELECT category.name  AS Category,
                                                    DATE_FORMAT(FROM_UNIXTIME(firstaccess),'%Y-%m-%d') AS CourseFirstAccess,
                                                    DATE_FORMAT(FROM_UNIXTIME(lastaccess),'%Y-%m-%d') AS CourseLastAccess,
                                                    course.fullname AS Course
                                                    ,(SELECT shortname FROM mdl_role WHERE id=en.roleid) AS ROLE
                                                FROM mdl_course AS course
                                                JOIN mdl_course_categories as category ON course.category
                                                JOIN mdl_enrol AS en ON en.courseid = course.id
                                                JOIN mdl_user_enrolments AS ue ON ue.enrolid = en.id
                                                JOIN mdl_user AS user2 ON ue.userid = user2.id");
        return $category;
    }

    /**
     * Displays the name of the most popular course id.
     * @return mixed
     * @throws dml_exception
     */
    private function get_popular_course_id() {
        global $DB;
        $popular = $DB->get_field_sql ("SELECT c.id, c.fullname, COUNT(*) AS enrolments
                                              FROM mdl_course c
                                              JOIN (SELECT DISTINCT e.courseid, ue.id AS userid
                                              FROM {user_enrolments} ue
                                              JOIN {enrol} e ON e.id = ue.enrolid) ue ON ue.courseid = c.id
                                          GROUP BY c.id");
        return $popular;
    }
}