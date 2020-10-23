<?php
session_start();
require_once '../functions.php';
require_once '../classes/UserLogic.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>新規登録｜Collection of Works for engineer</title>
  <meta name="description" content="本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。">
  <meta name="viewport" content="width=device-width">
  <meta name="format-detection" content="telephone=no">
  <meta property="og:type" content="website">
  <meta property="og:title" content="新規登録｜Collection of Works for engineer">
  <meta property="og:description" content="本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。">
  <meta property="og:url" content="https://service.portfolio.progblog-web.com/entry/index.php">
  <meta property="og:image" content="https://service.portfolio.progblog-web.com/asset/img/symbol/og_img.jpg">
  <meta property="og:site_name" content="新規登録｜Collection of Works for engineer">
  <meta property="og:locale" content="ja_JP">
  <link rel="canonical" href="https://service.portfolio.progblog-web.com/entry/index.php">
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
          <p class="form-area-title">新規登録</p>
          <form action="entry.php" method="POST" enctype="multipart/form-data" class="form-area-layout">
            <p class="label">
              <label for="userName">ユーザー名<input type="text" name="username" placeholder="xxx_xxx" required=""></label>
            </p>
            <p class="label">
              <label for="password">パスワード<input type="password" name="password" placeholder="8文字以上の英数字" required=""></label>
            </p>
            <p class="label">
              <label for="password_conf">確認用パスワード<input type="password" name="password_conf" placeholder="8文字以上の英数字" required=""></label>
            </p>
            <!-- <p class="form-area-layout-detail-display"><i class="fas fa-arrow-down fa-fw"></i>詳細も登録する（必須じゃありません）</p>
            <div class="form-area-layout-detail">
              <p class="label">
                <label for="icon">画像<input type="file" name="icon" placeholder="ウェブ 太郎" ></label>
              </p>
              <p class="label">
                <label for="info">自己紹介<textarea type="text" name="info" placeholder="こんにちは。神奈川在住のウェブエンジニアです。webの勉強中。" maxlength='255'></textarea></label>
              </p>
              <p class="label">
                <label for="twitter">Twitter<input type="text" name="twitter" placeholder="https://twitter.com/xxxxxxxxx"></label>
              </p>
              <p class="label">
                <label for="github">github<input type="text" name="github" placeholder="https://github.com/xxxxxxxxx"></label>
              </p>
              <p class="label">
                <label for="website">webサイト<input type="text" name="website" placeholder="https://nuxt.progblog-web.com/" ></label>
              </p>
            </div> -->
            <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
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