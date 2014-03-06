<?php

require_once 'Control/Control.php';

class Member extends Control
{
    function disconnexion()
    {
        if(isset($_SESSION['pseudo_member']))
        {
            unset($_SESSION['pseudo_member']);
            session_destroy();
        }
    }
    
    public function displayMenuProfil()
    {
        
    }
    
    public function editProfil()
    {
        
    }
    
    public function seeMyComments()
    {
        
    }
}

