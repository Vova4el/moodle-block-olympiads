<?php
function xmldb_block_olympiads_upgrade($oldversion): bool
{
    global $DB, $CFG;
    $result = true;
    $dbman = $DB->get_manager();
    if ($oldversion < 2024091900) {


        // Define table block_olympiads_registrations to be created.
        $table = new xmldb_table('block_olympiads_registrations');

        // Adding fields to table block_olympiads_registrations.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('olympiadid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table block_olympiads_registrations.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for block_olympiads_registrations.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        // Olympiads savepoint reached.
        upgrade_block_savepoint(true, 2024091900, 'olympiads');
    }
    return $result;
}
