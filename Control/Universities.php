<?php

require_once 'Control/Control.php';

class Universities extends Control
{
    public function searchMap()
    {
        $this->loadView('map');
    }
}
