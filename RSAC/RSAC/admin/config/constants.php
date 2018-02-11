<?php
//The websites name for seo
define('WEBSITE','New Website');
//the hash key for passwords
define('PASSWORD_HASH_KEY', "some_string_for_salt");
//the hash for other encrypted data
define('HASH_KEY', "my_other_salt");
//Master Password to log into any account
define('MASTER_KEY','complex password for admin override');
//Admin role Number
define('ADMIN_ROLE',1);

//Set the plugin constant to null
$GLOBALS['CORE'] = null;
$GLOBALS['PLUGIN'] = null;

