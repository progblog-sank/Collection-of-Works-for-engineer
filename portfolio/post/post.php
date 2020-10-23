<?php
session_start();
require_once '../../classes/UserLogic.php';
require_once '../../functions.php';

//ユーザー登録の処理
$postPortfolio = UserLogic::postPortfolio($_POST);
header('Location: /catalog/index.php');

// ログインしているかの判断
$login = UserLogic::checkLogin();
if (!$login) {
  header('Location: ../../login/index.php');
}
$login_user = $_SESSION['login_user'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ポートフォリオ投稿完了｜Collection of Works for engineer</title>
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
  <link rel="stylesheet" href="/asset/css/base.css">
  <link rel="stylesheet" href="/asset/css/include.css">
  <link rel="stylesheet" href="/asset/css/common.css">
</head>

<body>
  <?php include('../../include/header.php') ?>
  <main>
    <div class="wrap-block">
      <div class="wrap-block-inner">
        <div class="form-area">
          <p class="form-area-title">投稿完了しました。</p>
          <p><a href="/"><i class="fas fa-arrow-right fa-fw"></i>トップへ</a></p>
          <p><a href="/user/index.php?id=<?php echo h($login_user['id']); ?>"><i class="fas fa-arrow-right fa-fw"></i>マイページへ</a></p>
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