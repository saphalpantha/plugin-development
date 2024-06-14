
<?php
class TodoDb
{


    private $conn;

    function __construct($host, $user, $pass, $db_name)
    {
        global $conn;
        if (empty($host) || empty($user) || empty($db_name)) {
            die('Invalid Credintials');
        }

        try{
            $this->$conn = new PDO("mysql:host=$host;dbname=$db_name", $user ,$pass);
            $this->$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
        }
        catch(PDOException $e){
            die("Failed to connect to db" .$e->getMessage());
        }
    }
    function getDb(){
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