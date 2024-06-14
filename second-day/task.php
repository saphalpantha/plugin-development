
<?php


include_once 'TodoDb.php';
class Task
{
    
    public $url = "index.php";

    function create_task($title, $status)
    {
        global $conn;
        $qry = "INSERT INTO tasks values (NULL, '$title', '$status')";
        $stmt =$conn->prepare($qry);
        $stmt->execute();
    }


    function update_task($id, $title, $status)
    {
        global $conn;
        $qry = "UPDATE  tasks set title='$title', status='$status' where id=$id";
        $stmt =$conn->prepare($qry);
        $stmt->execute();
    }

    function get_all_task()
    {
        global $conn;
        $qry = "SELECT * FROM tasks ORDER BY id DESC";
        $stmt = $conn->prepare($qry);
        $stmt =$conn->prepare($qry);
        $stmt->execute();
        return $stmt;


    }


    function get_task_by_id($id)
    {
        global $conn;
        $qry = "SELECT * FROM tasks where id=$id;";
        $stmt =$conn->prepare($qry);
        $stmt->execute();
        return $stmt;
    }

    function delete_task_by_id($id)
    {
        echo $id;
        global $conn;
        $qry = "DELETE from tasks where id=$id";
        $stmt =$conn->prepare($qry);
        $stmt->execute();
    }

    function delete_all_task()
    {
        global $conn;
        $qry = "TRUNCATE table tasks";
        $stmt =$conn->prepare($qry);
        $stmt->execute();

    }
}



$task = new Task();
