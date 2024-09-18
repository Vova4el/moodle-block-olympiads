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

        // Добавляем пустую строку с тегом <br>
        $this->content->text .= html_writer::tag('br', ''); // Исправлено

        // Ссылка для сотрудников на редактирование олимпиад
        $this->content->text .= html_writer::link(
            new moodle_url('/blocks/olympiads/index.php'),
            get_string('olympiadlist', 'block_olympiads')
        );
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
}
