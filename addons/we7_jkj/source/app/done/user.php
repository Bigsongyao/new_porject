<?php

if(empty($_SESSION['user_id'])){
    $_user = get_cookie('user');
    if($_user){
        $_SESSION['user_id'] = $_user['user_id'];
        $_SESSION['username'] = $_user['username'];
        $_SESSION['headimg'] = $_user['headimg'];
        $_SESSION['is_designer'] = $_user['is_designer'];
        $_SESSION['is_shoper'] = $_user['is_shoper'];
    }
}

if(empty($_SESSION['user_id'])){
    die(json_encode(in_error(1)));
}else{
    $data = array(
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'headimg' => $_SESSION['headimg'],
        'is_designer' => $_SESSION['is_designer'],
        'is_shoper' => $_SESSION['is_shoper'],
    );
    die(json_encode(in_success(0, $data)));
}