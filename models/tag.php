<?php

class Tag extends Model {

    public $table = 'Tags';
    public $columns = array(
        'id' => 'CHAR(255)',
        'title' => 'CHAR(255)',
        'sortid' => 'CHAR(255)',
        'firstitemmsec' => 'INTEGER(4)'
    );
}
