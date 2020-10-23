<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';

// エラーメッセージ
$err = [];
// バリデーション
if(!$username = filter_input(INPUT_POST, 'username')) {
  $err['username'] = 'ユーザー名を入力してください';
}
if(!$password = filter_input(INPUT_POST, 'password')) {
  $err['password'] = 'パスワードを入力してください';
}

if(count($err) > 0) {
  //エラーがあった場合は戻す
  $_SESSION = $err;
  header('Location: index.php');
  return;
}

// ログイン成功時の処理
$result = UserLogic::login($username, $password);

if(!$result) {
  header('Location: index.php');
  return;
} else {
    $id =$_SESSION['login_user']['id'];
    $url = '/user/index.php?' . http_build_query(['id' => $id]);
    // var_dump($url);
    header("Location: " . $url);
    exit();
}
$login_user = $_SESSION['login_user'];
?>