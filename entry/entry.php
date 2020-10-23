<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';
// 登録時のエラー処理
$err = [];
$password = filter_input(INPUT_POST, 'password');
// 半角英数字8文字以上100文字以下の正規表現
if(!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)) {
  $err[] ='パスワードは英数字8文字以上100文字以下にしてください。';
}
// 確認用パスワードのエラー処理
$password_conf = filter_input(INPUT_POST, 'password_conf');
if($password !== $password_conf) {
  $err[] ='「記入したパスワード」と「確認用パスワード」が異なっています。';
}
// 既存の名前を検索
$username = $_POST['username'];
$sql = "SELECT * FROM user WHERE name = '$username'";
$stmt = connect()->query($sql);
$stmt->bindValue(1, $username, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if ($username == $result['name']) {
  $err[] ='その名前はすでに登録されています。';
}
if(count($err) == 0) {
  //ユーザー登録の処理
  $hasCreated = UserLogic::createUser($_POST);
  header('Location: ../login/index.php');
  if (!$hasCreated) {
    $err[] = '登録に失敗しました。';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登録完了画面</title>
</head>
<body>
  <?php if(count($err) > 0) : ?>
    <?php foreach($err as $e) : ?>
      <p><?php echo $e ?></p>
      <p><a href="/index.php">戻る</a></p>
    <?php endforeach ?>
  <?php else : ?>
  <p>登録が完了しました。</p>
  <?php endif ?>
</body>
</html>