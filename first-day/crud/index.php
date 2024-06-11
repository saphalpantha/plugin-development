<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form method="POST"  action="create-user.php"> 
        <input type="text" name="username"/>
        <input type="password" name="password"/>
        <button type="submit">Submit</button>

</form>

<table>

    <tbody>

    <h1>All Users</h1>
    <tr>
        <th>id</th>
        <th>username</th>
        <th>password</th>
        <th>Edit </th>
        <th>delete</th>
</tr>
    <?php
    
        include 'db.php';
        

        $qry = "SELECT * FROM users";        
        
        $result = mysqli_query($conn,$qry);

        if($result){
            while($row = mysqli_fetch_assoc($result)){
            ?>


        <tr>
        <td><?php echo $row['id'] ?></td>
        <td><?php echo $row['username'] ?></td>
        <td><?php echo $row['password'] ?></td>
        <td> <a href="edit-user.php?id=<?php echo $row["id"] ?>">edit</td>
        <td> <a href="delete-user.php?id=<?php echo $row["id"] ?>">delete</td>
        </tr>
        <?php
        }
        }
    ?>
    </tbody>
</table>
</body>
</html>