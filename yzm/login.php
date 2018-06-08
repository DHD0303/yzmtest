<?php
/**
 * Created by PhpStorm.
 * User: DingHaodong
 * Date: 2018/6/8
 * Time: 21:22
 */

    session_start();
    include "sql.php";
    if( !isset($_SESSION['code']) ) {
        die('请输入验证码');
    }
    $username=$_POST['username'];
    $password=$_POST['password'];
    if( !preg_match("/^[\S]{6,16}/",$username) ) {
        die('账户格式错误');
    }
    if ( !preg_match("/^[\S]{6,16}/",$password) ) {
        die('密码格式错误');//匹配失败
    }
    if(strtolower($_POST['code']) != $_SESSION['code']) {
        var_dump($_SESSION['code']);
        die('验证码错误');
    }
    if( !$conn ) {
        die('登录出错');
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT password FROM test WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if( !$result ) {
        die('登录出错,用户不存在');
    }
    $pass = $result[0][0];
    if( $password == $pass ) {
        echo '登录成功';
    } else {
        echo '用户名密码不匹配！';
    }