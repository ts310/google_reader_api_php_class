<?php

require_once './lib/basic.php';
require_once './lib/config.php';
require_once './lib/google_reader.php';

$db = new SQLiteDatabase('greader.db');

$sql = 'SELECT name FROM sqlite_master WHERE type=\'table\' ORDER BY name;';
$result = $db->query($sql);
while ($result->valid()) {
    $row = $result->current();
    debug($row);
    $result->next();
}

$sql = "
BEGIN;
CREATE TABLE subscriptions (
    id INTEGER(4) PRIMARY KEY,
    title CHAR(255),
    feed_id CHAR(255),
    sortid CHAR(255),
    firsttimemsec INTEGER(4)
);
COMMIT;
";
$db->query($sql);
