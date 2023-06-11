<?php 
    session_start();
    if(!empty($_SESSION["user"]))
    {
        header("Location: ./index.php");
    }
    require_once './DB/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8b076892ac.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./CSS/login.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="wrapped col-6 offset-3 py-5">
                    <h1 class="text-center mb-5">Login</h1>
                    <form method="post" class="row" id="login-form">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <span id="error" class="text-danger mb-5"></span>
                        <button type="submit" id="submit" class="btn btn-primary col-6 offset-3">Login</button>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <script>
        $(document).ready(function(){
            $('#submit').click(function(event){
                event.preventDefault()
                $.ajax({
                    url: 'http://localhost/customer/ajax/validate.php',
                    type: 'POST',
                    data: $('#login-form').serialize(),
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
</body>
</html>
