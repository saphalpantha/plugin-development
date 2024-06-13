
<?php


include_once 'db.php';
class Task
{

    public $url = "index.php";
    private $title;
    private $status;




    function create_task($title, $status)
    {
        global $conn;
        echo $title ."from db";
        $qry = "INSERT INTO tasks values (NULL, '$title', '$status')";
        $res = mysqli_query($conn, $qry);
    }


    function update_task($id, $title, $status)
    {
        global $conn;
        $qry = "UPDATE  tasks set title='$title', status='$status' where id='$id'";
        $res = mysqli_query($conn, $qry);

        return $res;
    }

    function get_all_task()
    {
        global $conn;
        $qry = "SELECT * FROM tasks ORDER BY id DESC";
        $res = mysqli_query($conn, $qry);

        return $res;
    }


    function get_task_by_id($id)
    {
        global $conn;
        $qry = "SELECT * FROM tasks where id='$id';";
        $res = mysqli_query($conn, $qry);
        return $res;
    }

    function delete_task_by_id($id)
    {
        global $conn;
        $qry = "DELETE from tasks where id='$id'";
        $res = mysqli_query($conn, $qry);
        return $res;    
    }

    function delete_all_task()
    {
        global $conn;
        $qry = "TRUNCATE table tasks";
        if ($qry) {
            echo 'Successfully deleted all tasks';
        }

    }
}



$task = new Task();


?>