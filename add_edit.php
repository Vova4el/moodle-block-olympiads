<?php
// Файл: add_edit.php
require_once('../../config.php');
require_once('form/olympiad_form.php');
// Убедимся, что пользователь авторизован
require_login();
// Получаем контекст системы
$context = context_system::instance();
// Настройка страницы
$PAGE->set_url(new moodle_url('/blocks/olympiads/add_edit.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('editolympiad', 'block_olympiads'));
$PAGE->set_heading(get_string('editolympiad', 'block_olympiads'));
// Проверяем права доступа (при необходимости)
if (!has_capability('moodle/site:manageblocks', $context)) {
    print_error('nopermissions', 'error', '', 'manage olympiads');
}
// Инициализация формы
$mform = new olympiad_form();

if ($mform->is_cancelled()) {
    // Если форма была отменена
    redirect(new moodle_url('/blocks/olympiads/index.php'));
} else if ($data = $mform->get_data()) {
    // Если данные были отправлены и валидны
    // Сохраняем данные в БД
    $record = new stdClass();
    $record->name = $data->name;
    $record->description = $data->description;
    $record->startdate = $data->startdate;
    $record->enddate = $data->enddate;

    // Вставляем данные в таблицу
    $DB->insert_record('block_olympiads', $record);

    redirect(new moodle_url('/blocks/olympiads/index.php'), get_string('olympiadsaved', 'block_olympiads'));
}

// Отображаем форму
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
