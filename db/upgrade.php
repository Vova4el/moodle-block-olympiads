<?php
function xmldb_block_olympiads_upgrade($oldversion): bool
{
    global $DB, $CFG;
    $result = true;
    $dbman = $DB->get_manager();
    if ($oldversion < 2024091703) {
        // Define field id to be added to block_olympiads_olympiads.
        $table = new xmldb_table('block_olympiads_olympiads');
        // Define field description to be added to block_olympiads_olympiads.
        if (!$dbman->field_exists($table, 'description')) {
            $field = new xmldb_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null);
            $dbman->add_field($table, $field);
        }
        // Olympiads savepoint reached.
        upgrade_block_savepoint(true, 2024091703, 'olympiads');
    }
    return $result;
}
