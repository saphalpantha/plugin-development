<?php

    $username = $_POST['username'];
    $password = $_POST['password'];


    include './db.php';

    $qry = "INSERT INTO users values ('NULL', '$username', '$password')";
    $res = mysqli_query($conn, $qry);

    if(!$res){
        echo "Failed to Insert";
    }
    else{
        echo "Inserted Succesfully";
    }


    

    


    


    


?>