<?php/*Publisher: Jamie NicholsDate: 5/21/2014Name: IndexType: ModelFunction: Do backend functions for the current pageas well as render the view it's self.*/ class Index_Model extends Model{ //Define the class as a Model    function __construct()    { //Call the constructor which runs when the class is loaded        parent::__construct();//Call the main controller class constructor		header("location:dashboard");    }}