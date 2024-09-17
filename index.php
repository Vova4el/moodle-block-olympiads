<?php

require_once('../../config.php');

// Проверяем, что пользователь авторизован
require_login();
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/olympiads/index.php'));
$PAGE->set_title(get_string('olympiadlist', 'block_olympiads'));
$PAGE->set_heading(get_string('olympiadlist', 'block_olympiads'));

// Проверяем права доступа
if (!has_capability('moodle/site:manageblocks', $context)) {
    print_error('nopermissions', 'error', '', 'manage olympiads');
}
global $DB;

// Обработка удаления
$id = optional_param('id', 0, PARAM_INT);

if ($id) {
    $DB->delete_records('block_olympiads_olympiads', array('id' => $id));
    redirect(new moodle_url('/blocks/olympiads/index.php'), get_string('olympiaddeleted', 'block_olympiads'));
}
// Получаем данные об олимпиадах

$olympiads = $DB->get_records('block_olympiads_olympiads');

// Создаем таблицу
$table = new html_table();
$table->head = array(
    get_string('name', 'block_olympiads'),
    get_string('description', 'block_olympiads'),
    get_string('startdate', 'block_olympiads'),
    get_string('enddate', 'block_olympiads'),
    get_string('actions', 'block_olympiads')
);

// Заполняем таблицу данными
foreach ($olympiads as $olympiad) {
    // URL для редактирования
    $row = new html_table_row();
    $edit_url = new moodle_url('/blocks/olympiads/add_edit.php', ['id' => $olympiad->id]);
    $edit_icon = $OUTPUT->pix_icon('t/editstring', get_string('edit'));
    $edit_link = html_writer::link($edit_url, $edit_icon, ['title' => get_string('edit')]);
    // URL для удаления с подтверждением
    $delete_url = new moodle_url('/blocks/olympiads/index.php', ['id' => $olympiad->id, 'confirmdelete' => 1]);
    $delete_icon = $OUTPUT->pix_icon('t/delete', get_string('delete'));
    $delete_link = html_writer::link($delete_url, $delete_icon, [
        'title' => get_string('delete'),
        'onclick' => 'return confirm("'.get_string('confirmdelete', 'block_olympiads').'")'
    ]);
    $row->cells = array(
        $olympiad->name,
        $olympiad->description,
        userdate($olympiad->startdate),
        userdate($olympiad->enddate),
        $edit_link . ' ' . $delete_link
    );

    $table->data[] = $row;
}

// Отображаем таблицу
echo $OUTPUT->header();
echo html_writer::tag('h2', get_string('olympiadlist', 'block_olympiads'));
echo html_writer::table($table);
echo $OUTPUT->footer();

