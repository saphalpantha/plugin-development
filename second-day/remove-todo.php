<?php

    include 'task.php';
    
    $user_id = $_GET['id'];

    $task->delete_task_by_id($user_id);

    header("location: {$task->url}");