<?php

abstract class Model
{
    protected $data;
    
    protected $connection;
    
    public function __construct() {
        require_once 'utils/mysql.php';
        
        $this->data = array();
        $this->connection = $connection;
    }
}
