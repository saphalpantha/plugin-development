<?php

    include 'task.php';
    if(!isset($_POST['title'])){
        die( 'Title not provided !');
    }

    $result =  $task->create_task($_POST['title'], "pending");
    header('location: index.php');

?>