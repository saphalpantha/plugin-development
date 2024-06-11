<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form method="POST" action="edit-user.php"> 
        <?php
        include_once 'db.php';
        $id =0;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        } elseif(isset($_POST['id'])){
            $id = $_POST['id'];
        } 


        $qry = "SELECT * FROM users where id='".$id."'";
        $response = mysqli_query($conn, $qry);
         
        $row = mysqli_fetch_assoc($response);


        



        
        ?>
        <input type="text" name="username" value="<?php echo  isset($row['username']) ? $row['username'] : '';?>" >
        <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : ''?>" >
        <input type="password" name="password" value="<?php echo isset($row['password']) ? $row['password'] : ''; ?>">
        <button type="submit">Submit</button>

</form>

<table>
</table>
</body>
</html>


<?php


if( isset( $_POST['id'],$_POST['username'], $_POST['password'] )){


$user_id =  $_POST['id'];
$username =  $_POST['username'];
$password =  $_POST['password'];



 $qry = "UPDATE users set username='$username', password='$password' where id='$user_id'";

$res = mysqli_query($conn, $qry);


 if(!$res){
     echo "Failed to Update";  
 }else{
     echo "Update Succesfull";
 }
}



?>