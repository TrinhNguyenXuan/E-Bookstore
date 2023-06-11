<?php
    class Database{
        private $server;
        private $username;
        private $password;
        private $db;

        function connect($server,$username,$password,$db)
        {
            $this->server = $server;
            $this->username = $username;
            $this->password = $password;
            $this->db = $db;
            try{
                $conn = mysqli_connect($server,$username,$password,$db);
                return $conn;
            }
            catch(Exception $e){
                die("Error connect!!!" . mysqli_connect_error());
            }
        }
    }

    $hostname = "localhost";
    $username = "root";
    $password = 'Trinh2s$haha';
    $db = "ebookstore";
    $dbconnect = new Database();

    $conn = $dbconnect->connect($hostname,$username,$password,$db);

?>