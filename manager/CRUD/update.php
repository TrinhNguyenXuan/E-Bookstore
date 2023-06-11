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

    if(empty($_POST["title"]) || empty($_POST["price"]) || empty($_POST["img"]))
    {
        echo 'Vui lòng điền đủ thông tin';
        exit();
    }

    $query = 'UPDATE book 
        SET title="' .$_POST["title"]. '",price='.$_POST["price"]. ',img="' .$_POST["img"].'", cateId= ' .$_POST['cateId']. '
        WHERE id =' . $_POST["id"] .';';
    $conn->query($query);
    echo "Success!";

    mysqli_close($conn)
?>
