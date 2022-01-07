<?php

include 'connection.php';

if($_POST){

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $response = [];

    $userQuery = $connection->prepare("SELECT * FROM users where username = ?");
    $userQuery->execute(array($username));
    $query = $userQuery->fetch();

    if($userQuery->rowCount() == 0){
        $response['status'] = false;
        $response['message'] = "Username Tidak Terdaftar";
    }else{
    
        $passwordDB = $query['password'];
        if(strcmp(md5($password), $passwordDB) === 0){
            $response['status'] = true;
            $response['message'] = "Login Berhasil";
            $response['data'] = [
                'user_id' => $query['id'],
                'username' => $query['username'],
                'name' => $query['name']
            ];
        }else{
            $response['status'] = false;
            $response['message'] = "Wrong Password";
        }
    }
    $json = json_encode($response, JSON_PRETTY_PRINT);

    echo $json;
}