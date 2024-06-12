<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css"/>
    <title>Todo-App</title>
</head>
<body>


    <?php 




        include_once 'db.php';



        $id =0;
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        } elseif(isset($_POST['id'])){
            $id = $_POST['id'];
        } 
        
        $qry = "SELECT * FROM tasks where id='".$id."'";
        $response = mysqli_query($conn, $qry);
        $row = mysqli_fetch_assoc($response);
    ?>

    
    <div class="todo-main">
        <h1>Daily Tasks Manage</h1>
    
        <h3>Edit Todo</h3>
    <form method="POST" action="edit-todo.php">
        <div>
            <input name="title" type="text" value="<?php echo isset( $row['title']) ?  $row['title'] : '';?>"  />
            <input name="id" type="hidden" value="<?php  echo isset( $row['id']) ?  $row['id'] : ''; ?>"  />
            </div>

            <select name="status" value="<?php echo isset( $row['status']) ?  $row['status'] : ''; ?>">
                <option value="pending">pending </option>
                <option value="completed">Completed </option>
                </select>
                <button type="submit">Add</button>



            <?php
            

     
            if(isset($_POST['id'], $_POST['title'],$_POST['status'] )){

                $updated_title =  $_POST['title'];  
                $updated_status = $_POST['status'];
                $id = $_POST['id'];

                $qry = "UPDATE tasks set title='$updated_title', status='$updated_status' where id='$id'";


                $result = mysqli_query($conn, $qry);
                if(!$result){
                    die('Failed to Updated');
                }

                echo 'Updated Succesfull';
            }

            
            

            
            
            
            ?>
        </form>
    
    
</div>

    

</body>
</html>