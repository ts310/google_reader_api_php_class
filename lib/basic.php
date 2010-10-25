<?php

function debug($obj) {
    $str = print_r($obj, true);
    $str = str_replace('<', '&lt;', str_replace('>', '&gt;', $str));
    echo sprintf('<pre>%s</pre>', $str);
}

