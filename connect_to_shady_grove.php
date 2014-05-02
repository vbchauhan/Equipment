<?php # connect_to_shady_grove.php

// Created by: Siddharth Choksi in May 2010
// This file contains the database access information. 
// This file also establishes a connection to MySQL and selects the database.
// Set the database access information as constants.

DEFINE ('DB_USER', 'sid25786');
DEFINE ('DB_PASSWORD', 'sjfksjIsnfdsf');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'shadygrove');

$dbc = @mysqli_connect ("root", "root", DB_NAME) OR die ('Could not connect to MySQL: ' .mysqli_connect_error() );
?>