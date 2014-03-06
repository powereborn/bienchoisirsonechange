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
    
    /** Se connecter et s'inscrire **/
    function connexion()
    {
        
    }
    
    function subscribe()
    {
        
    }
    
    /** Update des listes déroulantes des listes des pays et des listes des universités **/
    function listCountries()
    {
        $_POST['continent'];
    }
    
    function listUniversities()
    {
        $_POST['continent'];
        $_POST['country'];
    }
}