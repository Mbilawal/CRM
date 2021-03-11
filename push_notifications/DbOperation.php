<?php

class DbOperation
{
    //Database connection link
    private $con;

    //Class constructor
    function __construct()
    {
        
        
    }


    //getting a specified token to send push to selected device
    public function getToken($token){
        return array($token);        
    }

    
}
?>