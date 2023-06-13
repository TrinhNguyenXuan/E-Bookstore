<?php 
    require_once './DB/db.php';

    $query = 'SELECT * FROM book
        WHERE id  = ' .$_GET["id"]. ';';
    $result = $conn->query($query);
    $book = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="./ckeditor/ckeditor.js"></script>
    <script src="./ckfinder/ckfinder.js"></script>
    <link rel="stylesheet" href="./CSS/newbook.css">
    <link rel="stylesheet" href="./CSS/global.css">
    <title>Document</title>
</head>
<body>
    <?php require './Global_component/header/header.php' ?>
    <div class="main container my-5">
        <div class="row">
            <div class="col-6 offset-3">
                <form method="post" class="row" id="book-form">
                    <div class="mb3">
                        <label for="id" class="form-label">Id</label>
                        <?php 
                            echo '<input id="id" type="number" name="id" class="form-control" value="' .$book["id"]. '"readonly style="background-color: gainsboro;">'
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <?php 
                            echo '<input type="text" name="title" class="form-control" id="title" value="' .$book["title"]. '">';
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <?php 
                            echo '<input type="number" name="price" class="form-control" id="price" value="' .$book["price"].'">';
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Image</label>
                        <input type="file" name="img" class="form-control" id="img">
                    </div>
                    <div class="mb-3">
                        <label for="cateId" class="form-label">Category</label>
                        <select class="form-select" name="cateId" id="cateId" aria-label="Default select example">
                            <?php 
                                $query = 'SELECT * FROM category';
                                $result = $conn->query($query);
                                while($row = mysqli_fetch_assoc($result)){
                                    if($row['id']==$book["cateId"]) echo '<option value="1" selected>' .$row['name'].'</option>';
                                    else{
                                        echo '<option value="' .$row['id']. '">' .$row['name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editor1" class="form-label">Description</label>
                        <textarea name="description" id="editor1" cols="30" rows="10"></textarea>
                    </div>
                    <span id="error" class="text-danger my-2"></span>
                    <button type="submit" id="submit" class="btn btn-primary col-6 offset-3 mt-5">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <?php require './Global_component/footer/footer.php' ?>

    <script>
        $(document).ready(function(){
            $('#submit').click(function(event){
                event.preventDefault()
                
                var fileData = $('#img').prop('files')[0];
                var description = CKEDITOR.instances.editor1.getData();
                var formData = new FormData();
                var id = <?php echo $_GET['id']; ?>;
                formData.append('img',fileData)
                formData.append('title', $('#title').val())
                formData.append('price', $('#price').val())
                formData.append('cateId', $('#cateId').val())
                formData.append('description', description)
                formData.append('id', id)

                $.ajax({
                    url: 'http://localhost/manager/CRUD/update.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        if(response == "Success!") window.location.href = "./index.php"
                        else{
                            $('#error').text(response)
                            $('#error').show()
                        }
                    },
                    error: function(){
                        alert('Error call api!!!')
                    }
                })
            })
        })
    </script>

    <script>
        $(document).ready(function(){
            CKEDITOR.replace( 'editor1', {
            filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
            filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserWindowWidth: '1000',
            filebrowserWindowHeight: '700'
            } );
            CKEDITOR.instances.editor1.setData(<?php echo '`'. $book['description'] .'`' ?>);

        })

    </script>
</body>
</html>

<?php 
    mysqli_close($conn)
?>


