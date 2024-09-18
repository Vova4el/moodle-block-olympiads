<?php


require_once('../../config.php');
require_login();

// Настройка страницы
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/olympiads/student_view.php'));
$PAGE->set_title(get_string('regist_ol', 'block_olympiads'));

// Подключаем файл стилей
$PAGE->requires->css('/blocks/olympiads/styles2.css');
// Получаем олимпиады из базы данных
global $DB, $OUTPUT;
// Получаем идентификатор олимпиады из параметров URL (если есть)
$olympiadid = optional_param('id', 0, PARAM_INT);

// Если передан идентификатор, загружаем данные для редактирования
if ($olympiadid) {
// Проверяем, существует ли запись с таким идентификатором в базе данных
    if ($record = $DB->get_record('block_olympiads_olympiads', ['id' => $olympiadid])) {
        // Форматируем даты
        $formatted_startdate = userdate($record->startdate, '%d.%m.%Y');
        $formatted_enddate = userdate($record->enddate, '%d.%m.%Y');
        $regist_data = [
            'name' => $record->name,
            'description' => $record->description,
            'startdate' => $formatted_startdate,
            'enddate' => $formatted_enddate,
            'image' => $OUTPUT->image_url('1', 'block_olympiads'), // путь к изображению
            'signupurl' => '/blocks/olympiads/signup.php?id=' . $olympiadid . '&action=signup'
        ];
        // Проверяем, была ли отправлена форма для записи
        if (optional_param('action', '', PARAM_TEXT)) {
            // Добавляем запись в таблицу с регистрацией
            $registration = new stdClass();
            $registration->userid = $USER->id; // ID текущего пользователя
            $registration->olympiadid = $olympiadid;
            $action = optional_param('action', '', PARAM_TEXT);
            // Проверяем, существует ли уже запись о регистрации
            if (!$DB->record_exists('block_olympiads_registrations', ['userid' => $USER->id, 'olympiadid' => $olympiadid])) {
                $DB->insert_record('block_olympiads_registrations', $registration);
                $message = get_string('registration_success', 'block_olympiads');
            } else {
                $message = get_string('already_registered', 'block_olympiads');
            }

            // Перенаправляем с сообщением
            redirect(new moodle_url('/blocks/olympiads/signup.php', ['id' => $olympiadid]), $message, 3);
        }
    } else {
        // Если запись с таким ID не найдена, перенаправляем на главную страницу
        redirect(new moodle_url('/'), get_string('invalidid', 'block_olympiads'), 3);
    }
} else {
    // Если ID не передан, перенаправляем на главную страницу
    redirect(new moodle_url('/'), get_string('missingid', 'block_olympiads'), 3);
}


// Отображаем шаблон
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('block_olympiads/registration_ol', $regist_data);
echo $OUTPUT->footer();

