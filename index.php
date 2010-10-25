<?php

ini_set('display_errors', 1);
error_reporting(E_ALL ^E_DEPRECATED);

define('ROOT', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
define('LIB', ROOT . DS . 'lib' . DS);
define('MODELS', ROOT . DS . 'models' . DS);

require_once LIB . 'basic.php';
require_once LIB . 'config.php';
require_once LIB . 'model.php';
require_once LIB . 'google_reader.php';
require_once MODELS . 'subscription.php';
require_once MODELS . 'tag.php';

header('Content-type: text/html; charset=utf8;');

$googleReader = new GoogleReader;

//$data = $googleReader->fetchRequestWithURL("unread-count?output=json");
//debug(json_decode($data));
//$data = $googleReader->fetchRequestWithURL("user-info?output=json");
//debug(json_decode($data));
//$data = $googleReader->fetchRequestWithURL("stream/contents/user/-/state/com.google/reading-list");
//debug(json_decode($data));

$data = $googleReader->fetchRequestWithURL("tag/list?output=json");
debug(json_decode($data, true));

$data = $googleReader->fetchRequestWithURL("subscription/list?output=json");
$json = json_decode($data, true);

$Subscription = new Subscription;

$Subscription->drop();
$Subscription->createTable();

if (!empty($json['subscriptions'])) {
    foreach($json['subscriptions'] as $item) {
        $Subscription->save(array(
            'id' => $item['id'],
            'title' => $item['title'],
            'sortid' => $item['sortid'],
            'firstitemmsec' => $item['firstitemmsec']
        ));
    }
}

$data = $Subscription->find('all');
debug($data);
