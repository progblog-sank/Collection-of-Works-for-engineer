<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';

// ログインしているか判定し、していなかったら新規登録画面へ戻す
$result = UserLogic::checkLogin();

if (!$result) {
  $_SESSION['login_err'] = 'ユーザーを登録してログインしてください。';
  header('Location: signup_form.php');
  return;
}
$login_user = $_SESSION['login_user'];

// ユーザIDを所得する
// $result = UserLogic::checkId();
try {
  if (empty($_GET['id'])) throw new Exception('ID不正');
  $id = $_GET['id'];
  // var_dump($id);
  $sql = 'DELETE FROM user WHERE id = ?';
  $stmt = connect()->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
  $sql_post = 'DELETE FROM post WHERE user_id = ?';
  $stmt_post = connect()->prepare($sql_post);
  $stmt_post->bindValue(1, $id, PDO::PARAM_INT);
  $stmt_post->execute();
  UserLogic::logout();
  header("Location: /index.php");
} catch (\Exception $e) {
  echo $e->getMessage();
}
