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

    $image = addslashes(file_get_contents($_FILES["img"]["tmp_name"]));

    $title = $_POST["title"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $cateId = $_POST["cateId"];

    if(empty($title) || empty($price) || empty($description) || empty($cateId) || !isset($image))
    {
        echo 'Vui lòng điền đủ thông tin';
        exit();
    }

    
    
    $query = "INSERT INTO book(title,price,img,description,cateId) VALUES 
    ('$title', $price, '$image', '$description', $cateId );";

    $conn->query($query);
    echo "Success!";
    mysqli_close($conn)
?>
