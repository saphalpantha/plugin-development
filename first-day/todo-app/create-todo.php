<?php


    include 'db.php';


    $title = $_POST['title'];

    if(!isset($title) or empty($title)){
        die( "Title Not Provided");
    }
    

    $qry = "INSERT INTO tasks values ('NULL', '$title', 'pending')";

$result = mysqli_query($conn, $qry);

if(!$result){
    die( "Insert Failed");
}

echo "Insert Succesfull";
    

    


    
    
    
    





    

?>