<?php

abstract class Control
{
    protected $data;
    protected $error;
    
    public function __construct() {
        $this->data = array();
        $this->error = array();
    }
    
    public function loadView($view) {
        try {
            include 'View/' . $view . '.phtml';
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}

