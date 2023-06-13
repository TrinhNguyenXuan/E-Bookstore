<?php
    require_once './DB/db.php';
    if(isset($_GET['cateId'])) $filter=$_GET['cateId'];
    else $filter=0
?>

<!-- ckeditor
book detail
description
 -->

 <?php require './Global_component/header/header.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="./CSS/global.css">
    <link rel="stylesheet" href="./CSS/home.css">
    <script src="https://kit.fontawesome.com/8b076892ac.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="main container my-5">
        <div class="row mb-3">
            <div class="col-3">
                <a class="btn btn-primary" href="./newbook.php" role="button">+ Add new book</a>
            </div>
            <div class="col-3 offset-6">
                <label for="cateId" class="form-label">Category</label>
                <select class="form-select" name="cateId" id="cateId">
                <?php 
                    $query = 'SELECT * FROM category';
                    $result = $conn->query($query);
                    if($filter==0) echo '<option value="0" selected>Chọn thể loại</option>';
                    else echo '<option value="0">Chọn thể loại</option>';
                    while($row = mysqli_fetch_assoc($result)){
                        if($row['id'] == $filter) echo '<option value="' .$row['id']. '" selected>' .$row['name'].'</option>';
                        else echo '<option value="' .$row['id']. '">' .$row['name'].'</option>';
                    }
                ?>
                </select>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Price</th>
                    <th scope="col">Image</th>
                    <th scope="col">Category</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if($filter>0) $query = 'SELECT * FROM book WHERE cateId=' .$filter. ';';
                    else $query = "SELECT * FROM book;";
                    $result = $conn->query($query);
                    while($row = mysqli_fetch_assoc($result)){
                        $query = 'SELECT * FROM category WHERE id=' .$row['cateId'];
                        $result2 = $conn->query($query);
                        $category = mysqli_fetch_assoc($result2);
                        echo 
                        '<tr>
                            <th scope="row">' .$row["id"]. '</th>
                            <td>' .$row["title"]. '</td>
                            <td>' .$row["price"]. '</td>
                            <td><img src="data:image/jpg;base64, '.base64_encode($row["img"]). '" /></td>
                            <td>' .$category['name']. '</td>
                            <td><a class="btn btn-primary" href="http://localhost/manager/edit_book.php?id=' .$row["id"]. '" role="button"><i class="fa-regular fa-pen-to-square"></i></a></td>
                            <td>
                                <button class="btn btn-danger" name="id" onclick="delBook(' .$row['id'].')"><i class="fa-regular fa-trash"></i></button>  
                            </<td>
                        </tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php require './Global_component/footer/footer.php' ?>

    <script>
        function delBook(id)
        {
            if(confirm('Xác nhận xóa sản phẩm'))
            {
                $.ajax({
                    url: 'http://localhost/manager/CRUD/delete.php',
                    method: 'POST',
                    data: {
                        bookId: id
                    },
                    success: function(response){
                        alert('Xóa sản phẩm thành công')
                        window.location.href = './index.php'
                    },
                    error: function(e){
                        console.log(e.message)
                        throw e
                    }

                })
            }
        }

        $('#cateId').on('change', function(){
            var value = this.value;
            var path = './index.php?cateId='+value;
            window.location.href = path
        })
        
    </script>
</body>
</html>

<?php 
    mysqli_close($conn)
?>