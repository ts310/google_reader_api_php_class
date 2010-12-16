<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^E_DEPRECATED);

define('ROOT', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);
define('LIB', ROOT . DS . 'lib' . DS);

require_once LIB . 'basic.php';
require_once LIB . 'config.php';
require_once LIB . 'google_reader.php';

$googleReader = new GoogleReader;
$googleReader->connectWithAccount(GOOGLE_EMAIL, GOOGLE_PASSWD);

header('Content-type: text/html; charset=utf8;');
?>
<html>
<head>
<link href="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" 
    rel="stylesheet" />
<link href="style.css" rel="stylesheet" />
</head>
<body>
<h1>Google Reader API client class</h1>
<ul>
    <li><a href="#subscriptions">Subscriptions</a></li>
    <li><a href="#tags">Tags</a></li>
    <li><a href="#reading_list">Reading List</a></li>
    <li><a href="#unreadcounts">Unread counts</a></li>
</ul>
<h2 id="subscriptions">Subscriptions</h2>
<div class="block">
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>title</th>
                <th>sortid</th>
                <th>firstitemmsec</th>
                <th>categories</th>
            </tr>
        </thead>
        <?php $json = $googleReader->fetch(); ?>
        <?php if (!empty($json['subscriptions'])): ?>
        <tbody>
            <?php foreach ($json['subscriptions'] as $item): ?>
            <tr>
                <td><?php echo $item['id'] ?></td>
                <td><?php echo $item['title'] ?></td>
                <td><?php echo $item['sortid'] ?></td>
                <td><?php echo $item['firstitemmsec'] ?></td>
                <td>
                    <?php if (!empty($item['categories'])): ?>
                    <?php foreach ($item['categories'] as $category): ?>
                    <a href="#" title="<?php echo $category['id'] ?>" 
                    class="category"><?php echo $category['label'] ?></a>
                    <?php endforeach ?>
                    <?php endif ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <?php endif ?>
    </table>
</div>
<h2 id="tags">Tags</h2>
<div class="block">
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>title</th>
                <th>sortid</th>
            </tr>
        </thead>
        <?php $json = $googleReader->fetch('tags'); //debug($json); ?>
        <?php if (!empty($json['tags'])): ?>
        <tbody>
            <?php foreach ($json['tags'] as $item): ?>
            <tr>
                <td><?php echo $item['id'] ?></td>
                <td><?php echo (isset($item['title']) ? $item['title'] : 'N/A') ?></td>
                <td><?php echo $item['sortid'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <?php endif ?>
    </table>
</div>
<h2 id="reading_list">Reading-list</h2>
<div class="block">
    <div>
        <?php $json = $googleReader->fetch('reading-list'); //debug($json); ?>
        <?php if (!empty($json['items'])): ?>
        <?php foreach ($json['items'] as $item): ?>
        <dl>
            <dt>crawlTimeMsec</dt>
            <dd><?php echo $item['crawlTimeMsec'] ?></dd>
            <dt>id</dt>
            <dd><?php echo $item['id'] ?></dd>
            <dt>title</dt>
            <dd><?php echo $item['title'] ?></dd>
            <dt>categories</dt>
            <dd>
                <?php if (!empty($item['categories'])): ?>
                <?php foreach ($item['categories'] as $category): ?>
                <a href="#" title="" 
                class="category"><?php echo $category ?></a>
                <?php endforeach ?>
                <?php endif ?>
            </dd>
            <dt>published</dt>
            <dd><?php echo $item['published'] ?></dd>
            <dt>updated</dt>
            <dd><?php echo $item['updated'] ?></dd>
            <dt>summary</dt>
            <dd><?php echo $item['summary']['content'] ?></dd>
        </dl>
        <?php endforeach ?>
        <?php endif ?>
    </div>
</div>
<h2 id="unreadcounts">Unread</h2>
<div class="block">
    <table> 
        <thead>
            <tr>
                <th>id</th>
                <th>count</th>
                <th>newestItemTimestampUsec</th>
            </tr>
        </thead>
        <?php $json = $googleReader->fetch('unread'); //debug($json); ?>
        <?php if (!empty($json['unreadcounts'])): ?>
        <tbody>
            <?php foreach ($json['unreadcounts'] as $item): ?>
            <tr>
                <td><?php echo $item['id'] ?></td>
                <td><?php echo $item['count'] ?></td>
                <td><?php echo $item['newestItemTimestampUsec'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <?php endif ?>
    </table>
</div>
</body>
</html>
