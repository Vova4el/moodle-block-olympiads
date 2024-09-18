<?php
require_once('../../config.php');
require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/olympiads/view_students.php'));
$PAGE->set_title(get_string('view_students', 'block_olympiads'));

global $DB, $OUTPUT;

// Получаем идентификатор олимпиады из параметров URL
$olympiadid = optional_param('id', 0, PARAM_INT);

// Проверяем, что ID олимпиады передан
if ($olympiadid) {

    // Получаем данные об олимпиадах

    $sql = "SELECT u.id, u.firstname, u.lastname, u.email FROM {user} u JOIN {block_olympiads_registrations} r ON r.userid = u.id WHERE r.olympiadid = :olympiadid";
    $students = $DB->get_records_sql($sql, ['olympiadid' => $olympiadid]);

    // Создаем таблицу
    $table = new html_table();
    $table->head = array(
        get_string('fullname', 'block_olympiads'),
        get_string('email', 'block_olympiads'),
    );

// Заполняем таблицу данными
if (!empty($students)) {
    foreach ($students as $student) {
        $fullname = $student->firstname . ' ' . $student->lastname;
        // URL для редактирования
        $row = new html_table_row();
        $row->cells = array(
            $fullname,
            $student->email,
        );

        $table->data[] = $row;
    }

    // Отображаем таблицу
    echo $OUTPUT->header();
    echo html_writer::table($table);
    echo $OUTPUT->footer();
} else {
    // Если студентов нет, отображаем сообщение
    echo $OUTPUT->header();
    echo get_string('no_students_found', 'block_olympiads');
    echo $OUTPUT->footer();
}
} else {
    redirect(new moodle_url('/blocks/olympiads'), get_string('missingid', 'block_olympiads'), 3);
}
