<?php  
    include_once '../DB/db.php';

    extract($_POST);
    $data = array();
    foreach($_POST as $k=>$v){
        array_push($data,$v);
    }

    if(empty($data[0]) || empty($data[1])){
        echo 'Vui lòng nhập username và password';
        return;
    }

    $query = 'SELECT * FROM customer WHERE username = "' .$data[0]. '" AND password ="' .$data[1]. '";';
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);

    if(empty($row)){
        echo 'Sai tên đăng nhập hoặc mật khẩu';
        return;
    }

    session_start();
    $_SESSION["user"] = $row["id"];
    echo "Success!";
?>