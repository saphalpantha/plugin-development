<?php





header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Authorization");
//header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');



$method = $_SERVER['REQUEST_METHOD'];





if ($method == 'OPTIONS') {
    http_response_code(200);
    exit();
}



if ($method === 'GET') {

    include 'task.php';
    if (!isset($_GET['id'])) {
        $res = $task->get_all_task();
        if ($res->num_rows == 0) {
            $data = [
                'status' => 404,
                'message' => 'No Todos Found',
            ];
            header("HTTP/1.0 404 No Todos");
            echo json_encode($data);
            exit;
        } else {
            $todos = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'Todos Fetched Succesfull',
                'data' => $todos,
            ];
            header("HTTP/1.0 200 Todo Fetched");
            echo json_encode($data);
            exit;
        }
    } else {
        $res = $task->get_task_by_id($_GET['id']);
        if ($res->num_rows == 0) {
            $data = [
                'status' => 404,
                'message' => 'No Todo Found',
            ];
            header("HTTP/1.0 404 No Todo");
            echo json_encode($data);
            exit;
        } else {
            $todos = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'Todos Fetched Succesfull',
                'data' => $todos,
            ];
            header("HTTP/1.0 200 Todo Fetched");
            echo json_encode($data);
            exit;
        }
    }
} else if ($method === 'POST') {
    include 'task.php';
    
    $user_input = file_get_contents("php://input");
    $user_input = json_decode($user_input, true);
    if (!isset($user_input['title'])) {
        $data = [
            'status' => 404,
            'message' => 'Title Not Provided',
        ];
        header("HTTP/1.0 404 Failed to Create");
        echo json_encode($data);
    } else {
        $result =  $task->create_task($user_input['title'], "pending");
        $data = [
            'status' => 201,
            'message' => 'Todo Created',
        ];
        echo json_encode($data);
        header("HTTP/1.0 201 Created Successfull");
    }
} else if ($method === 'PUT') {
    include 'task.php';
    
    $user_input = file_get_contents("php://input");
    $user_input = json_decode($user_input, true);
    if (!isset($user_input['status'], $user_input['id'], $user_input['title'])) {
        $data = [
            'status' => 404,
            'message' => 'Form Not Valid !',
        ];
        header("HTTP/1.0 404 Failed to Update");
        echo json_encode($data);
    } else {
        $result =  $task->update_task($user_input['id'], $user_input['title'], $user_input['status']);
        $data = [
            'status' => 201,
            'message' => 'Todo Updated',
        ];
        echo json_encode($data);
        header("HTTP/1.0 200 Updated Successfull");
    }
} else if ($method === 'DELETE') {

    include 'task.php';
    if (!isset($_GET['id'])) {
        $data = [
            'status' => 404,
            'message' => 'Invalid ID !',
        ];
        header("HTTP/1.0 404 Failed to Delete");
        echo json_encode($data);
    } else {
        $result =  $task->delete_task_by_id($_GET['id']);
        $data = [
            'status' => 201,
            'message' => 'Todo Deleted',
        ];
        echo json_encode($data);
        header("HTTP/1.0 200 Deleted Successfull");
        exit;
    }
} else {
    $data = [
        'status' => 405,
        'message' => $method . 'Method not Allowed',
    ];
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode($data);
}
