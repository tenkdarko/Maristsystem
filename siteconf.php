<?php

//THESE ARE THE DATABASE DETAILS WHICH NEED TO BE CHANGED\\
$user = "root";
$pass = "";
$details = "mysql:dbname=b14_17008663_project;host=localhost";
$database = new PDO($details, $user, $pass);


//THIS IS THE SITE URL. INCLUDE TRAILING SLASH. or http://google.com/ THIS IS USED FOR THE LOCAL HOST

$siteURL = "http://localhost/site/";


//THESE ARE THE ADMIN DETAILS

$adminUser = 'admin';
$secretKey = 'secret123';
?>