<?php
/**
 * Created by PhpStorm.
 * User: DingHaodong
 * Date: 2018/6/8
 * Time: 22:22
 */
    session_start();
    include "sql.php";
    $username=$_POST['username'];
    $password=$_POST['password'];
    if( !preg_match("/^[\S]{6,16}/",$username) ) {
        die('账户格式错误！');
    }
    if ( !preg_match("/^[\S]{6,16}/",$password) ) {
        die('密码格式错误！');//匹配失败
    }
    if( !isset($_SESSION['code']) ) {
        die('请输入验证码');
    }
    if(strtolower($_POST['code']) != $_SESSION['code']) {
        die('验证码错误');
    }
    if( !$conn ) {
        die('注册出错');
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT password FROM test WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if( !empty($result) ) {
        die('用户已存在');
    }
    echo $password, $username;
    $regist = $conn->prepare("INSERT INTO test (username, password) VALUES (:username,:password)");
    $regist->bindParam(':username', $username);
    $regist->bindParam(':password', $password);
    $regist->execute();
    echo '<a href="index.html">创建成功,点击返回登录</a>>';
?>