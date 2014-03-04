<?php

abstract class Control
{
    protected $data;
    
    public function __construct() {
        $data = array();
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

