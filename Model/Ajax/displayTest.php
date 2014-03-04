<?php

require_once 'Model/Model.php';

class ModelDisplayTest extends Model
{
    function displayTest() 
    {
        $data[] = "ii";
        
        return $data;
    }
}