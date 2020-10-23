<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';


// ログインしているか判定
$result = UserLogic::checkLogin();

if(!$result) {
  $_SESSION['login_err'] = 'ユーザーを登録してログインしてください。';
  header('Location: /traial/index.php');
  return;
}
$login_user = $_SESSION['login_user'];

// ユーザ情報アップデート
$result = UserLogic::updateUser();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登録完了画面</title>
</head>
<body>
  <!-- <p>修正が完了しました。</p> -->
  <!-- <p><a href="mypage.php"></a></p> -->
  <?php echo '<a href="user.php?id=' . h($login_user['id']) . '">マイページ</a></p>'?>

</body>
</html>