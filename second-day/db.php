
<?php
class TodoDB
{


    private $conn;
    function __construct($host, $user, $pass, $db_name)
    {
        global $conn;
        if (empty($host) || empty($user) || empty($db_name)) {
            die('Invalid Credintials');
        }
        
        $this->$conn = mysqli_connect($host, $user, $pass, $db_name);
    }
    function getDb()
    {
        global $conn;
        if ($this->$conn) {
            return $this->$conn;
        }

        die('Failed to Connect to Db');
    }
}


$host = "localhost";
$user = "root";
$pass = "";
$db_name = "simple-todo";

$db = new TodoDB($host, "root", "$pass", "$db_name");
$conn = $db->getDb();

?>