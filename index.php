<?php

require_once './lib/basic.php';
require_once './lib/config.php';
require_once './lib/google_reader.php';

$googleReader = new GoogleReader;

header('Content-type: text/html; charset=utf8;');

//$data = $googleReader->fetchRequestWithURL("unread-count?output=json");
//debug(json_decode($data));

//$data = $googleReader->fetchRequestWithURL("user-info?output=json");
//debug(json_decode($data));

//$data = $googleReader->fetchRequestWithURL("tag/list?output=json");
//debug(json_decode($data));

$data = $googleReader->fetchRequestWithURL("subscription/list?output=json");
debug(json_decode($data));

$data = $googleReader->fetchRequestWithURL("stream/contents/user/-/state/com.google/reading-list");
debug(json_decode($data));

