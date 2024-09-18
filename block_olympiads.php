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
        global $CFG;

        if ($this->content !== null) {
            return $this->content;
        }

        // Создаем объект $this->content
        $this->content = new stdClass();

        // Ссылка для студентов на просмотр списка олимпиад
        $this->content->text = html_writer::link(
            new moodle_url('/blocks/olympiads/student_view.php'),
            get_string('view_olympiads', 'block_olympiads')
        );

        // Добавляем пустую строку с тегом <br>
        $this->content->text .= html_writer::tag('br', ''); // Исправлено

        // Ссылка для сотрудников на добавление/редактирование олимпиады
        $this->content->text .= html_writer::link(
            new moodle_url('/blocks/olympiads/add_edit.php'),
            get_string('addolympiad', 'block_olympiads')
        );

        return $this->content;
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
