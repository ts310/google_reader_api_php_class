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

$json = $googleReader->fetch();

$Subscription = new Subscription;

if ($Subscription->tableExists()) {
    $Subscription->drop();
}
$Subscription->createTable();

if (!empty($json['subscriptions'])) {
    foreach($json['subscriptions'] as $item) {
        debug($item);
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
