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

    if(empty($_POST["title"]) || empty($_POST["price"]) || empty($_POST["description"]) || empty($_POST['cateId']))
    {
        echo 'Vui lòng điền đủ thông tin';
        exit();
    }
    
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $cateId = $_POST['cateId'];
    $id = $_POST['id'];

    if(isset($_FILES["img"])){
        $image = addslashes(file_get_contents($_FILES["img"]["tmp_name"]));
        $query = "UPDATE book 
        SET title='$title ', price= $price, img = $image, description='$description', cateId= $cateId
        WHERE id = $id;";
    }
    else{
        $query = "UPDATE book 
            SET title='$title ', price= $price , description='$description', cateId= $cateId
            WHERE id = $id;";
    }


    $conn->query($query);
    echo "Success!";

    mysqli_close($conn)
?>
