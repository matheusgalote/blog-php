<?php

include(ROOT_PATH . '/app/database/db.php');
include(ROOT_PATH . '/app/helpers/validateUser.php');

$errors = array();
$username = '';
$email = '';
$password = '';
$passwordConf = '';


if(isset($_POST['register-btn'])) {
    $errors = validateUser($_POST);  

    if(count($errors) === 0) { 

        unset($_POST['register-btn'], $_POST['passwordConf']);
        // define admin post users, 0[true] or 1[false]
        $_POST['admin'] = 0;
        // encrypted the password 
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // create user and getting id
        $user_id = create('users', $_POST);
        $user = selectOne('users', ['id' => $user_id]);

        // log user in
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['admin'] = $user['admin'];
        $_SESSION['message'] = "You are now logged in";
        $_SESSION['tpye'] = "sucess";
        header('location: '. BASE_URL . '/index.php');
        exit();

    } else {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
}