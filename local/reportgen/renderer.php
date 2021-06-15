<?php

/**
 * Renderer Page
 * @package    local_reportgen_renderer
 * @author     2020 Christopher Logan <clogan20@qub.ac.uk>
 */

use local_reportgen\output\view;

defined('MOODLE_INTERNAL') || die();

class local_reportgen_renderer extends plugin_renderer_base
{
    /**
     * Render months page
     * @param view $view
     * @return string HTML for page
     * @throws moodle_exception
     */
    public function render_view($view): string {
        $data = $view->export_for_template($this);
        return $this->render_from_template('local_reportgen/view', $data);
    }
}