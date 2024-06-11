<?php

    include 'db.php';

    $user_id = $_GET['id'];

    $qry = "DELETE FROM users where id='$user_id'";

    $res = mysqli_query($conn, $qry);


if(!$res){
    echo "Failed to Delete";  
}else{
    echo "Delete Successfull";
}
    

?>