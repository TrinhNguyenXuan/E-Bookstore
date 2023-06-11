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

    $query = 'DELETE FROM book WHERE id=' .$_POST["bookId"] ;
    $conn->query($query);
    header("Location: http://localhost/manager/index.php");
    mysqli_close($conn)
?>
