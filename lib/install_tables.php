<?php

$db = new SQLiteDatabase('greader.db');

$tables = array();
$tables['subscriptions'] = '
    CREATE TABLE subscriptions (
        id INTEGER(4) PRIMARY KEY,
        title CHAR(255),
        feed_id CHAR(255),
        sortid CHAR(255),
        firsttimemsec INTEGER(4)
    );
';

debug($tables);

// Check existing tables
$existingTables = array();
$sql = 'SELECT name FROM sqlite_master WHERE type=\'table\' ORDER BY name;';
$result = $db->query($sql);
while ($result->valid()) {
    $row = $result->current();
    $existingTables[] = $row['name'];
    $result->next();
}

debug($existingTables);

if (count($tables) > 0) {
    foreach ($tables as $table => $script) {
        if (!in_array($table, $existingTables)) {
            $sql = 'BEGIN;';
            $sql .= $script;
            $sql .= 'COMMIT';
            $db->query($sql);
        }
    }
}
