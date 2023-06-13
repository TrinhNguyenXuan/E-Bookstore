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

if(empty($_POST["title"]) || empty($_POST["price"]) || !isset($_FILES["img"]) || empty($_POST["description"]) || empty($_POST['cateId']))
    {
        echo 'Vui lòng điền đủ thông tin';
        exit();
    }

    $image = addslashes(file_get_contents($_FILES["img"]["tmp_name"]));

    $title = $_POST["title"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $cateId = $_POST["cateId"];
    
    $query = "INSERT INTO book(title,price,img,description,cateId) VALUES 
    ('$title', $price, '$image', '$description', $cateId );";

    $conn->query($query);
    echo "Success!";
    mysqli_close($conn)
?>
