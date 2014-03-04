<?php

include 'Control/Control.php';

/** Requête Ajax **/

class Ajax extends Control
{
    function displayTest() 
    {
        include 'Model/Ajax/displayTest.php';
        
        $ModelDisplayTest = new ModelDisplayTest();
        
        $this->data = $ModelDisplayTest->displayTest();
        
        $this->loadView("displayTest");
    }
}