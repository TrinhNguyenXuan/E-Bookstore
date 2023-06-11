<?php
    $hostname = "localhost";
    $username = "root";
    $password = 'Trinh2s$haha';
    $db = "ebookstore";
    $conn = mysqli_connect($hostname,$username,$password,$db);
    if(!$conn)
    {
        die("Error connect!!!" . mysqli_connect_error());
    }

    if(empty($_POST["title"] || empty($_POST["price"])) || empty($_POST["img"]))
    {
        echo 'Vui lòng điền đủ thông tin';
        exit();
    }

    $query = 'INSERT INTO book(title,price,img,cateId) VALUES 
    ("' .$_POST["title"]. '",'.$_POST["price"]. ',"' .$_POST["img"]. '",' .$_POST["cateId"]. ')';
    $conn->query($query);
    echo "Success!";
    mysqli_close($conn)
?>
