<?php

require_once('../../config.php');
require_login();

// Настройка страницы
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/olympiads/student_view.php'));
$PAGE->set_title(get_string('olympiadlist', 'block_olympiads'));
$PAGE->set_heading(get_string('olympiadlist', 'block_olympiads'));

// Подключаем файл стилей
$PAGE->requires->css('/blocks/olympiads/styles.css');

// Получаем олимпиады из базы данных
global $DB, $OUTPUT;
$olympiads = $DB->get_records('block_olympiads_olympiads');

// Подготавливаем данные для шаблона
$olympiads_data = [];
foreach ($olympiads as $olympiad) {
    $olympiads_data[] = [
        'name' => $olympiad->name,
        'description' => $olympiad->description,
        'startdate' => userdate($olympiad->startdate),
        'enddate' => userdate($olympiad->enddate),
        'image' => $OUTPUT->image_url('1', 'block_olympiads'), // путь к изображению
        'signupurl' => new moodle_url('/blocks/olympiads/signup.php', ['id' => $olympiad->id])
    ];
}


// Передаем данные в шаблон
$template_data = [
    'olympiads' => $olympiads_data
];

// Отображаем шаблон
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('block_olympiads/olympiads', $template_data);
echo $OUTPUT->footer();
