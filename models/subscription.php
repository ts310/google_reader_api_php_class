<?php

class Subscription extends Model {
    
    public $table = 'subscriptions';
    public $columns = array(
        'id' => 'CHAR(255)',
        'title' => 'CHAR(255)',
        'sortid' => 'CHAR(255)',
        'firstitemmsec' => 'INTEGER(4)'
    );
}
