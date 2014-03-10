<?php

include 'Control/Control.php';

/** Requête Ajax **/

class Ajax extends Control
{
    function displayTest() 
    {
        $this->data = $this->loadModel("ModelDisplayTest","displayTest");
        
        $this->loadView("displayTest");
    }
    
    /** Se connecter et s'inscrire **/
    function connexion()
    {
        
    }
    
    function subscribe()
    {
        echo json_encode($this->loadModel("ModelMember","subscribe"));
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