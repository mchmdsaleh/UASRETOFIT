<?php

$connection = null;

try{

    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "loginapps";

    $database = "mysql:dbname=$dbname;host=$host";
    $connection = new PDO($database, $username, $password);
    $connection ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // if($connection){
    //     echo "koneksi yeay";
    // }else{
    //     echo "so sad";
    // }
} catch(PDOException $e){
    echo "Error ! ". $e->getMessage();
    die;
}
?>