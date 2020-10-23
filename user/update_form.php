<?php
session_start();
require_once '../functions.php';
require_once '../classes/UserLogic.php';
// ログインしているか判定し、していなかったら新規登録画面へ戻す
$result = UserLogic::checkLogin();
if(!$result) {
  $_SESSION['login_err'] = 'ユーザーを登録してログインしてください。';
  header('Location: signup_form.php');
  return;
}
$login_user = $_SESSION['login_user'];

// ユーザIDを所得する
try {
  if(empty($_GET['id'])) throw new Exception('ID不正');
  $id = $_GET['id'];
  $sql = 'SELECT * FROM user WHERE id = ?';
  $stmt = connect()->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページを修正する｜Collection of Works for engineer</title>
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
  <link rel="stylesheet" href="/asset/css/base.css">
  <link rel="stylesheet" href="/asset/css/include.css">
  <link rel="stylesheet" href="/asset/css/common.css">
</head>
<body>
<?php include('../include/header.php') ?>
  <main>
    <div class="wrap-block">
      <div class="wrap-block-inner">
        <div class="form-area">
          <p class="form-area-title">マイページを修正する</p>
          <form action="update_user.php"  method="POST" enctype="multipart/form-data" class="form-area-layout">
            <p class="label">
              <label for="userName">ユーザー名<input type="text" name="username" value="<?php echo h($result['name']) ?>" placeholder="xxx_xxx" required=""></label>
            </p>
              <p class="label">
                <label for="icon">画像<input type="file" name="icon" value="<?php echo h($result['icon']) ?>" require></label>
              </p>
              <p class="label">
                <label for="info">自己紹介<textarea type="text" name="info" placeholder="こんにちは。神奈川在住のウェブエンジニアです。webの勉強中。" maxlength='255'><?php echo h($result['info']) ?></textarea></label>
              </p>
              <p class="label">
                <label for="twitter">Twitter<input type="url" name="twitter" value="<?php echo h($result['twitter']) ?>" placeholder="https://twitter.com/xxxxxxxxx"></label>
              </p>
              <p class="label">
                <label for="github">github<input type="url" name="github" value="<?php echo h($result['github']) ?>" placeholder="https://github.com/xxxxxxxxx"></label>
              </p>
              <p class="label">
                <label for="website">webサイト<input type="url" name="website" value="<?php echo h($result['github']) ?>" placeholder="https://nuxt.progblog-web.com/" ></label>
              </p>
              <input type="hidden" name="id" class="input-area" value="<?php echo h($result['id']) ?>">
            <p class="submit">
              <input type="submit" name="submit" value="登録する">
            </p>
          </form>
        </div>
      </div>
    </div>
  </main>
  <footer class="footer">
    <div class="footer-inner">
      <p class="copy"><small>Copyright © 2019 PROGBOLG All Rights Reserved.</small></p>
    </div>
  </footer>
  <script src="/asset/javascript/init.js"></script>
</body>
</html>