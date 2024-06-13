<?php




header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
header("Access-Control-Allow-Method:GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers");



$method = $_SERVER['REQUEST_METHOD'];


if ($method === 'GET') {
    include 'task.php';
    $res = $task->get_all_task();
    if ($res->num_rows == 0) {
        $data = [
            'status' => 404,
            'message' => 'No Todos Found',
        ];
        header("HTTP/1.0 404 No Todos");
        echo $data;
    } else {
        $todos = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $data = [
            'status' => 200,
            'message' => 'Todos Fetched Succesfull',
            'data' => $todos,
        ];
        header("HTTP/1.0 404 No Todos");
        echo json_encode($data);
    }
}

else if($method === 'POST'){
    include 'task.php';
    
    if(!isset($_POST['title'])){
        $data = [
            'status' => 404,
            'message' => 'Title Not Provided',
        ];
        header("HTTP/1.0 404 Failed to Create");
        echo json_encode($data);
        }
        else{
            $result =  $task->create_task($_POST['title'], "pending");
            $data = [
            'status' => 201,
            'message' => 'Todo Created',
        ];
            echo json_encode($data);
            header("HTTP/1.0 201 Created Successfull");
            
    }

}

else if($method === 'PUT'){
    include 'task.php';

    if(!isset($_PUT['status'] , $_POST['id'] , $_POST['title'])){
        $data = [
            'status' => 404,
            'message' => 'Form Not Valid !',
        ];
        header("HTTP/1.0 404 Failed to Update");
        echo json_encode($data);
        }
        else{
            $result =  $task->update_task($_POST['id'], $_POST['title'], $_POST['status']);
            $data = [
            'status' => 201,
            'message' => 'Todo Updated',
        ];
            echo json_encode($data);
            header("HTTP/1.0 200 Updated Successfull");
            
    }
}


else if($method === 'DELETE'){

    if (!isset($_DELETE['id'])){
        $data = [
            'status' => 404,
            'message' => 'Invalid ID !',
        ];
        header("HTTP/1.0 404 Failed to Delete");
        echo json_encode($data);
        }
        else{
            $result =  $task->delete_task_by_id($_POST['id']);
            $data = [
            'status' => 201,
            'message' => 'Todo Deleted',
        ];
            echo json_encode($data);
            header("HTTP/1.0 200 Deleted Successfull");
            
    }
}
else {
    $data = [
        'status' => 405,
        'message' => $method . 'Method not Allowed',
    ];
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode($data);
}

