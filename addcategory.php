<?php
    session_start();
    include "db.php";
    if(!isset($_SESSION['user_id']) )
    {
        echo "you are not authorized to access this page.";
        header("Location: login.php");
        
    }  
    else
    {
        if($_SESSION['user_role'] == "admin")
        {
            if(isset($_POST['submit']))
            {
                $name = $_POST['name'];
                $sql = "INSERT INTO category(name) VALUES ('$name')";
                $result = mysqli_query($conn, $sql);//function to execute query
                if(!$result)
                {
                    echo "Error!!: {$conn->error}";
                }
                else
                {
                    echo "Category Added Successfully <a href='dashboard.php'>Go to Dashboard</a>";
                }
            }
        }
        else
        {
            header("Location: dashboard.php");
        }
    }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="addcategory.php" method="post">
        Category Name: <input type="text" name="name" required> <br>
        <input type="submit" name="submit" value="Add Category">

    </form>
</body>
</html>