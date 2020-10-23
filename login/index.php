<?php
session_start();
require_once '../classes/UserLogic.php';

$result = UserLogic::checkLogin();
if($result) {
  $id =$_SESSION['login_user']['id'];
  $url = '/user/index.php?' . http_build_query(['id' => $id]);
  // var_dump($url);
  header("Location: " . $url);
  exit();
}
$err = $_SESSION;
// セッションを消す
$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ログイン｜Collection of Works for engineer</title>
  <meta name="description" content="本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。">
  <meta name="viewport" content="width=device-width">
  <meta name="format-detection" content="telephone=no">
  <meta property="og:type" content="website">
  <meta property="og:title" content="ログイン｜Collection of Works for engineer">
  <meta property="og:description" content="本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。">
  <meta property="og:url" content="https://service.portfolio.progblog-web.com/login/index.php">
  <meta property="og:image" content="https://service.portfolio.progblog-web.com/asset/img/symbol/og_img.jpg">
  <meta property="og:site_name" content="ログイン｜Collection of Works for engineer">
  <meta property="og:locale" content="ja_JP">
  <link rel="canonical" href="https://service.portfolio.progblog-web.com/login/index.php">
  <link rel="shortcut icon" href="/asset/img/symbol/favicon.ico">
  <link rel="icon" type="image/png" href="/asset/img/symbol/android-chrome-256x256.png">
  <link rel="apple-touch-icon" href="/asset/img/symbol/apple-touch-icon.png">
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
          <p class="form-area-title">ログイン</p>
          <form action="login.php" method="POST" class="form-area-layout">
            <p class="label">
              <label for="">ユーザー名<input type="text" name="username" placeholder="xxx_xxx" required=""></label>
            </p>
            <?php if (isset($err['msgUsername'])) : ?>
                <p class="err-msg"><?php echo $err['msgUsername']; ?></p>
              <?php endif; ?>
            <p class="label">
              <label for="">パスワード<input type="password" name="password" placeholder="8文字以上の英数字" required=""></label>
            </p>
            <?php if (isset($err['msgPassword'])) : ?>
                <p class="err-msg"><?php echo $err['msgPassword']; ?></p>
              <?php endif; ?>
            <p class="submit">
              <input type="submit" name="submit" value="ログインする">
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