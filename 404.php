<?php
session_start();
require_once 'functions.php';
require_once 'classes/UserLogic.php';
// ログインしているか判定
$login = UserLogic::checkLogin();
if ($login) {
  $login_user = $_SESSION['login_user'];
  // var_dump($login_user['id']);
}
try {
  $sql = 'SELECT u. *, p.* FROM user u, post p WHERE u.id=p.user_id ORDER BY p.id DESC';
  $stmt = connect()->query($sql);
  $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>not found｜Collection of Works for engineer</title>
  <meta name="description" content="本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。">
  <meta name="viewport" content="width=device-width">
  <meta name="format-detection" content="telephone=no">
  <meta property="og:type" content="website">
  <meta property="og:title" content="not found｜Collection of Works for engineer">
  <meta property="og:description" content="本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。">
  <meta property="og:url" content="https://service.portfolio.progblog-web.com/404.php">
  <meta property="og:image" content="https://service.portfolio.progblog-web.com/asset/img/symbol/og_img.jpg">
  <meta property="og:site_name" content="not found｜Collection of Works for engineer">
  <meta property="og:locale" content="ja_JP">
  <link rel="canonical" href="https://service.portfolio.progblog-web.com/404.php">
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
  <?php include('include/header.php') ?>
  <main>
    <div class="wrap-block">
      <div class="wrap-block-inner">
        <div class="main-block">
              <p class="notfound-title">お探しのページが見つかりませんでした。</p>
              <p class="notfound-desc">このページはすでに削除されているか、URLが間違っている可能性があります。<br>よろしければ他のポートフォリオをご参照ください。</p>
          <div class="least-post">
                <?php
                $i = 0;
                foreach ($result as $post) {
                  if ($i >= 4) {
                    break;
                  } else {
                    echo '<div class="post">';
                    echo '<p><a href="/catalog/product/index.php?id=' . h($post['id']) . '"><img src="/portfolio/post/' . h($post['primg']) . '" alt=""></a></p>';
                    echo '</div>';
                    $i++;
                  }
                }
                ?>
              </div>
              <p class="more-link"><a href="/catalog/index.php">ALL VIEW</a></p>

        </div>
        <div class="aside-block">
          <?php include('include/popular.php') ?>
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