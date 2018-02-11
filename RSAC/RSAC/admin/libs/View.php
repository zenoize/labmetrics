<?php

class View
{
    function __construct()
    {

    }

    public function render($name, $noInclude = false)
    {
        if ($noInclude == true) {
            require (file_exists("core/". $name . ".php"))?"core/". $name . ".php":"plugins/".$name.".php";
        } else {
            require 'core/header.php';
            require (file_exists("core/". $name . ".php"))?"core/". $name . ".php":"plugins/".$name.".php";
            require 'core/footer.php';
        }
    }

    public function renderfooter()
    {
        require 'core/footer.php';
    }

    public function renderheader()
    {
        require 'core/header.php';
    }
}
