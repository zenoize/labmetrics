<?php/*	Publisher: Jamie Nichols	Date: 5/21/2014	Name: Login	Type: Controller	Function: Link model functions to the view 	as well as render the view it's self.	*/class Users extends Controller{ //Define the class as a controller    function __construct()    { //Call the constructor which runs when the class is loaded        parent::__construct(); //Call the main controller class constructor    }    /** Following functions will render pages **/    function login()    { //Define the main index function that runs when calling main page        //add all variables to view		        $this->view->error = $this->model->catchErrors();        $this->view->css = array('users/bin/css/login.css'); //Set css files for include        $this->view->js = array('users/bin/js/login.js'); //Set javascript files for include        $this->view->render('users/views/login'); //Render main content    }	function register()    { //Define the main index function that runs when calling main page        //add all variables to view        $this->view->css = array('users/bin/css/register.css'); //Set css files for include        $this->view->js = array('users/bin/js/register.js'); //Set javascript files for include        $this->view->render('users/views/register'); //Render main content    }    function dologin()    { //Run function when called like domain/login/run        $this->model->doLogin(); //Run the model function run which will log user in		    }	function doregister()    {        $this->model->doRegister(); //Run model function Run to register user.    }    function destroy()    { //Run function when called like domain/login/destroy        $this->model->logout(); //Run the model function logout which destroys the session and logs the user out    }		function user_exists($email)    { //Run this by calling domain/register/user_exists/useremail        echo $this->model->user_exists($email); //Run model user_exist function and pass in email to check.    }}?>