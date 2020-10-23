<?php
session_start();
require_once '../../functions.php';
require_once '../../classes/UserLogic.php';

// ログインしているかの判断
$login = UserLogic::checkLogin();
if(!$login) {
  header('Location: ../../login/index.php');
}
$login_user = $_SESSION['login_user'];
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ポートフォリオを投稿する｜Collection of Works for engineer</title>
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
          <p class="form-area-title">ポートフォリオを投稿する</p>
          <form action="post.php"  method="POST" enctype="multipart/form-data" class="form-area-layout">
            <p class="label">
              <label for="title">タイトル<input type="text" name="title" placeholder="NUXTでポートフォリオサイトを作りました。" required=""></label>
            </p>
            <p class="label">
              <label for="bio">概要(255字以内)<textarea name="bio" placeholder="いままでWordPressサイトを多く作ってきたが、新しい技術に触れたく、vue.jsのフレームワークであるnuxt.jsを使用し、ポートフォリオサイトを作成した。" maxlength='255' required=""></textarea>
            </p>
            <p class="label">
              <label for="primg">画像<input type="file" name="primg" placeholder="ウェブ 太郎" required=""></label>
            </p>
            <p class="label">
              <label for="url">ポートフォリオのURL<input type="url" name="url" placeholder="https://nuxt.progblog-web.com/" required=""></label>
            </p>
            <p class="label">
              <label for="reference">制作ブログ etc<input type="text" name="reference" placeholder="エンジニア初心者がブログを作った話" ></label>
            </p>
            <p class="label">
              <label for="referenceUrl">制作ブログ etc のURL<input type="url" name="referenceUrl" placeholder="https://nuxt.progblog-web.com/blog/k9fo84ny3"></label>
            </p>
            <p class="label">
              <label for="lang">使用言語（「 , 」カンマ区切りで記入ください）<input type="text" name="lang" placeholder="html,css,javascript"></label>
            </p>
            <input type="hidden" name="user_id" value="<?php echo h($login_user['id']); ?>">
            <p class="submit">
              <input type="submit" name="submit" value="投稿する">
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