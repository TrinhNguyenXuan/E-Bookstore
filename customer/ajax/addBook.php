<?php
    include_once '../DB/db.php';
    session_start();
    if(empty($_SESSION['user']))
    {
        echo "no login";
        exit();
    }

    $query = 'SELECT * FROM cart WHERE cusId = ' .$_SESSION['user']. ' AND bookId = '. $_POST['bookId']. ';';
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);
    if(empty($row)){
        $query = 'INSERT INTO cart(bookId,cusId,quantity) VALUE (' . $_POST['bookId']. ','. $_SESSION["user"]. ', 1);';
        $conn->query($query);
    }
    else{
        $quantity = $row['quantity'] +1;
        $query = 'UPDATE cart SET quantity = ' .$quantity. ' WHERE cusId = ' .$_SESSION['user']. ' AND bookId = '. $_POST['bookId']. ';';
        $conn->query($query);
    }

?>