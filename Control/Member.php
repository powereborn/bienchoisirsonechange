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
    
    public function confirm()
    { 
        $this->data = $this->loadModel("ModelMember","confirmSubscribe");
        
        $this->loadView("confirm_subscribe");
    }
    
    public function cancel()
    {
        $this->data = $this->loadModel("ModelMember","cancelSubscribe");
        
        $this->loadView("cancel_subscribe");
    }
}

