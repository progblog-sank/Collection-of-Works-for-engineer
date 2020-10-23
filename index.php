<?php
session_start();
require_once 'functions.php';
require_once 'classes/UserLogic.php';

// ログインしているか判定
$login = UserLogic::checkLogin();
if ($login) {
  $login_user = $_SESSION['login_user'];
}

// 新着記事を取得
try {
  $sql = 'SELECT u. *, p.* FROM user u, post p WHERE u.id=p.user_id ORDER BY p.id DESC';
  $stmt = connect()->query($sql);
  $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage();
}

?>
<!doctype html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Collection of Works for engineer</title>
  <meta name="description" content="本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。">
  <meta name="viewport" content="width=device-width">
  <meta name="format-detection" content="telephone=no">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Collection of Works for engineer">
  <meta property="og:description" content="本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。">
  <meta property="og:url" content="https://service.portfolio.progblog-web.com/">
  <meta property="og:image" content="https://service.portfolio.progblog-web.com/asset/img/symbol/og_img.jpg">
  <meta property="og:site_name" content="Collection of Works for engineer">
  <meta property="og:locale" content="ja_JP">
  <link rel="canonical" href="https://service.portfolio.progblog-web.com/">
  <link rel="shortcut icon" href="/asset/img/symbol/favicon.ico">
  <link rel="icon" type="image/png" href="/asset/img/symbol/android-chrome-256x256.png">
  <link rel="apple-touch-icon" href="/asset/img/symbol/apple-touch-icon.png">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
  <link rel="stylesheet" href="/asset/css/base.css">
  <link rel="stylesheet" href="/asset/css/include.css">
  <link rel="stylesheet" href="/asset/css/home.css">
</head>

<body>
  <?php include('include/header.php') ?>
  <main>
    <div class="key">
      <div class="key-inner">
        <div class="key-inner-lead">
          <p class="strong">ポートフォリオを<br>自慢してください。</p>
          <p class="desc">本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。</p>
        </div>
        <!-- ログインしていない場合は登録フォームを表示する -->
        <?php if (!$login) : ?>
          <div class="register">
            <form action="/entry/entry.php" method="POST" class="form-area-layout">
              <p class="label">
                <label for="userName">ユーザー名<input type="text" name="username" placeholder="xxx_xxx" required=""></label>
              </p>
              <p class="label">
                <label for="password">パスワード<input type="password" name="password" placeholder="8文字以上の英数字" required=""></label>
              </p>
              <p class="label">
                <label for="password_conf">確認用パスワード<input type="password" name="password_conf" placeholder="8文字以上の英数字" required=""></label>
              </p>
              <p class="label">
                <label for="icon"><input type="hidden" name="icon" placeholder="ウェブ 太郎"></label>
              </p>
              <p class="label">
                <label for="info"><textarea style="display: none;" name="info" placeholder="こんにちは。神奈川在住のウェブエンジニアです。webの勉強中。"></textarea></label>
              </p>
              <p class="label">
                <label for="twitter"><input type="hidden" name="twitter" placeholder="https://twitter.com/xxxxxxxxx"></label>
              </p>
              <p class="label">
                <label for="github"><input type="hidden" name="github" placeholder="https://github.com/xxxxxxxxx"></label>
              </p>
              <p class="label">
                <label for="website"><input type="hidden" name="website" placeholder="https://nuxt.progblog-web.com/"></label>
              </p>
              <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
              <p class="submit">
                <input type="submit" name="submit" value="登録する">
              </p>
            </form>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="content">
      <div class="content-inner">
        <section>
          <div class="heading-2">
            <h2><span class="hdg">最新のポートフォリオ</span></h2>
          </div>
          <div class="main-block">
            <div class="least-post">
              <?php
              $i = 0;
              foreach ($result as $post) {
                if ($i >= 6) {
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
            <?php include('include/popular.php') ?>
          </div>
          <p class="more-link"><a href="/catalog/index.php">ALL VIEW</a></p>
        </section>
        <?php if ($login) : ?>
          <div class="post-action">
            <p class="post-action-triiger"><a href="/portfolio/post/index.php"><i class="fas fa-plus"></i></a></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>
  <footer class="footer">
    <div class="footer-inner">
      <p class="copy"><small>Copyright © 2019 PROGBOLG All Rights Reserved.</small></p>
    </div>
  </footer>
</body>

</html>