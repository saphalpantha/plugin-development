<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css"/>
    <title>Todo-App</title>
</head>
<body>




    
    <div class="todo-main">
        <h1>DTM with OOPS</h1>

    <form method="POST" action="create-todo.php">
        <input name="title" type="text" placeholder="What do you need to do ?"  />
        <button>Add</button>
        
    </form>

    <?php

    
        include_once 'task.php';

        $result = $task->get_all_task();
        if($result->rowCount() < 0){
            ?>
            <h2>NO Todos </h2>
            <?php

        }
        else {
           while($row  = $result->fetch(PDO::FETCH_ASSOC)){
            ?>

            <div class="card-lists">
                <form class="todo-card">
                    <div id="status" class="<?php echo $row['status'] ==  'completed' ? 'completed' : 'pending' ?>"> 
                        <div><?php  echo $row['status'] ?></div>
           </div>
                    <h2><?php echo $row['title']; ?></h2>
                        <div>
                            <a href="edit-todo.php?id=<?php echo $row['id'] ?>" >Edit </a>
                        <a href="remove-todo.php?id=<?php echo $row['id'] ?>" >Remove </a>
                        </div>
                    </form>
                    </div>
                    
                    <?php

           }
        }

        ?>


    



</div>

    

</body>
</html>