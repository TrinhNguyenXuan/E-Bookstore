<?php 
    include_once '../DB/db.php';
    session_start();
    $data = array();
    $data['negative'] =false;
    
    if($_GET['method'] == 'add')
    {
        $query = 'SELECT * FROM cart WHERE cusId=' .$_SESSION['user']. ' AND bookId=' .$_POST['bookId']. ';';
        $result = $conn->query($query);
        $row = mysqli_fetch_assoc($result);
        $quantity = $row['quantity']+1;
        $query = 'UPDATE cart SET quantity =' .$quantity. ' WHERE cusId=' .$_SESSION['user']. ' AND bookId = ' .$_POST['bookId']. ';';
        $conn->query($query);
    }
    else{
        $query = 'SELECT * FROM cart WHERE cusId=' .$_SESSION['user']. ' AND bookId=' .$_POST['bookId']. ';';
        $result = $conn->query($query);
        $row = mysqli_fetch_assoc($result);
        $quantity = $row['quantity']-1;
        if($quantity<1) {
            $quantity=1;
            $data['negative'] = true;
        }
        $query = 'UPDATE cart SET quantity =' .$quantity. ' WHERE cusId=' .$_SESSION['user']. ' AND bookId = ' .$_POST['bookId']. ';';
        $conn->query($query);
    }

    $query = 'SELECT * FROM book WHERE id=' .$_POST['bookId'];
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);

    $data['quantity'] = $quantity;
    $data['price'] = $row['price'];
    echo json_encode($data);

?>