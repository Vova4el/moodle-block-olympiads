<?php
defined('MOODLE_INTERNAL') || die();
class block_olympiads extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_olympiads');
    }

    public function specialization() {
        if (isset($this->config->title)) {
            $this->title = format_string($this->config->title, true, ['context' => $this->context]);
        } else {
            $this->title = get_string('defaulttitle', 'block_olympiads');
        }
    }

    public function get_content() {
        global $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = $this->get_olympiads_list();
        $this->content->footer = '';

        return $this->content;
    }


    public function applicable_formats() {
        return [
            'my' => true,
            'site-index' => true,
            'course-view' => true,
            'mod' => false,
        ];
    }

    private function get_olympiads_list() {
        global $DB;

        $olympiads = $DB->get_records('block_olympiads_olympiads');
        $output = '';

        foreach ($olympiads as $olympiad) {
            $output .= html_writer::tag('div', $olympiad->name . ' - ' . $olympiad->startdate . ' to ' . $olympiad->enddate, ['class' => 'olympiad-item']);
        }

        return $output;
    }
}