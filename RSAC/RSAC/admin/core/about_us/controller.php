<?php

/*
	Publisher: Jamie Nichols
	Date: 5/21/2014

	Name: Index
	Type: Controller
	Function: Link model functions to the view 
	as well as render the view it's self.
	*/

class Index extends Controller
{ //Define the class as a controller
    function __construct()
    { //Call the constructor which runs when the class is loaded
        parent::__construct(); //Call the main controller class constructor
    }

    /** Following functions will render pages **/
    function index()
    { //Define the main index function that runs when calling main page
        $this->view->css = array('index/bin/css/style.css'); //Set css files for include
        $this->view->js = array('index/bin/js/script.js');  //Set javascript files for include
        $this->view->render('index/views/index'); //Render main content
    }
}