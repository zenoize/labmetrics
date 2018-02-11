<?php

/*
	Publisher: Jamie Nichols
	Date: 5/21/2014

	Name: Error
	Type: Controller
	Function: Link model functions to the view 
	as well as render the view it's self.
	*/
error_reporting(0);
class Error extends Controller
{ //Define the class as a controller
    function __construct()
    { //Call the constructor which runs when the class is loaded
        parent::__construct();//Call the main controller class constructor
    }

    /** Following functions will render pages **/
    function index()
    { //Define the main index function that runs when calling main page
        //add all variables to view
        $this->view->css = array('error/bin/css/style.css'); //Set css files that will be included in header
        $this->view->render('error/views/index'); //Render main content
    }
}