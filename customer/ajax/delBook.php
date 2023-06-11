<?php 
    include_once '../DB/db.php';
    session_start();
    
    $query = 'DELETE FROM cart WHERE cusId=' .$_SESSION['user']. ' AND bookId=' .$_POST['bookId'] .';';
    $conn->query($query)
?>