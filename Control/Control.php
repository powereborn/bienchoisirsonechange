<?php

abstract class Control
{
    protected $data;
    protected $error;
    
    public function __construct() 
    {
        $this->data = array();
        $this->error = array();
    }
    
    public function loadModel($ModelName, $ActionName)
    {
        try {
            include 'Model/' . $ModelName . '.php';
            $Model = new $ModelName;
            
            return $Model->$ActionName();
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
        
        return false;
    }
    
    public function loadView($view)
    {
        try {
            include 'View/' . $view . '.phtml';
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}

