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
    
    $title = $_POST["title"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $categories = $_POST["category"];

    if(empty($title) || empty($price) || empty($description) || !isset($_FILES["product-img0"]["tmp_name"]))
    {
        echo 'Vui lòng điền đủ thông tin';
        exit();
    }

    for($i=0;$i<count($categories);$i++){
        if($categories[$i]) break;
        if($i==count($categories)-1) {
            echo 'Vui lòng điền đủ thông tin';
            exit();
        }
    }
    
    $query = "INSERT INTO book(title,price,description) VALUES 
    ('$title', $price, '$description');";

    $conn->query($query);

    $query = "SELECT * FROM book 
    WHERE title = '$title' AND price = $price AND description = '$description'";
    $result = $conn->query($query);
    $bookId = mysqli_fetch_assoc($result)["id"];

    $num_img = 0;
    while(true){
        $name = "product-img$num_img";
        if(isset($_FILES[$name]["tmp_name"])){
            $num_img+=1;
        }
        else{
            break;
        }
    }

    for($i=0; $i<$num_img; $i++){
        $name = "product-img$i";
        $product_img = addslashes(file_get_contents($_FILES[$name]["tmp_name"]));
        $query = "INSERT INTO product_img(img,bookId) VALUES ('$product_img',$bookId);";
        $conn->query(($query));
    }

    for($i=0; $i<count($categories); $i++){
        if($categories[$i]==1){
            $cateId = $i+1;
            $query = "INSERT INTO bookCate VALUES($bookId,$cateId)";
            $conn->query($query);
        }
    }



    echo "Success!";
    mysqli_close($conn)
?>
