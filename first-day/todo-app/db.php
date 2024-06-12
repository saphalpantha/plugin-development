<?php

$host = "localhost";
$user = "root";
$pass = "";
$db_name = "simple-todo";



$conn = mysqli_connect("$host", "$user", "$pass", "$db_name");


if(!$conn){
    die('Failed to Connect !');
}









?>