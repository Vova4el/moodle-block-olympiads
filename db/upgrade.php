<?php


function xmldb_block_olympiads_upgrade($oldversion): bool
{
    global $DB, $CFG;

    $result = true;
    $dbman = $DB->get_manager();
    if ($oldversion < 2024091500) {
        error_log('Starting upgrade to version 2024091500');
        if ($oldversion < 2024091503) {
            error_log('Starting upgrade to version 2024091501');
            // Define table block_olympiads_olympiads to be created.
            $table = new xmldb_table('block_olympiads_olympiads');

            // Adding fields to table block_olympiads_olympiads.
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('name', XMLDB_TYPE_CHAR, '10', null, null, null, null);
            $table->add_field('startdate', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
            $table->add_field('enddate', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

            // Adding keys to table block_olympiads_olympiads.
            $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

            // Conditionally launch create table for block_olympiads_olympiads.
            if (!$dbman->table_exists($table)) {
                $dbman->create_table($table);
                error_log('Table block_olympiads_olympiads created');
            } else {
                error_log('Table block_olympiads_olympiads already exists');
            }

            // Olympiads savepoint reached.
            upgrade_block_savepoint(true, 2024091503, 'olympiads');
        }

        error_log('Finished upgrade to version 2024091500');
    }
    return $result;
}
