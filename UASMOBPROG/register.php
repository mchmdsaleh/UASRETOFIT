<?php

include "connection.php";

if($_POST){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

    $userQuery = $connection->prepare("SELECT * FROM users where username = ?");
    $userQuery->execute(array($username));

    if($userQuery->rowCount() != 0){
        $response['status'] = false;
        $response['message'] = "Akun Sudah Digunakan";
    }else{
        $insertAccount = 'INSERT INTO users (username,password,name) values (:username, :password, :name)';
        $statement = $connection->prepare($insertAccount);

        try{
        
            $statement->execute([
                ':username' => $username,
                ':password' => md5($password),
                ':name' => $name
            ]);

            $response['status'] = true;
            $response['message'] = "Akun berhasil didaftarkan";
            $response['data'] = [
                'username' => $username,
                'name' => $name
            ];
        } catch (Exception $e){
            die($e->getMessage());
        }
    }

    $json = json_encode($response, JSON_PRETTY_PRINT);

    echo $json;

}