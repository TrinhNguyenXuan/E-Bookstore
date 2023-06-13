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

    $bookId = $_POST["bookId"];

    $query = "DELETE FROM book WHERE id=$bookId;";
    $conn->query($query);
    header("Location: http://localhost/manager/index.php");
    mysqli_close($conn)
?>
