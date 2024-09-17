<?php
// Файл: form/olympiad_form.php
require_once("$CFG->libdir/formslib.php");


class olympiad_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

        // Добавляем скрытое поле для идентификатора
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        // Поле для названия олимпиады
        $mform->addElement('text', 'name', get_string('name', 'block_olympiads'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');

        // Поле для описания олимпиады
        $mform->addElement('textarea', 'description', get_string('description', 'block_olympiads'), 'wrap="virtual" rows="10" cols="50"');
        $mform->setType('description', PARAM_TEXT);

        // Поле для даты начала олимпиады
        $mform->addElement('date_selector', 'startdate', get_string('startdate', 'block_olympiads'));
        $mform->addRule('startdate', null, 'required', null, 'client');

        // Поле для даты окончания олимпиады
        $mform->addElement('date_selector', 'enddate', get_string('enddate', 'block_olympiads'));
        $mform->addRule('enddate', null, 'required', null, 'client');

        // Кнопки отправки и отмены
        $this->add_action_buttons();
    }
}
