<?php
session_start();
require_once '../functions.php';
require_once '../classes/UserLogic.php';

// ログインしているかの判断
$login = UserLogic::checkLogin();

// 全ての投稿を取得する
try {
  $id = $_GET['id'];
  $sql = 'SELECT * FROM post ORDER BY id DESC';
  $stmt = connect()->query($sql);
  $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
  // var_dump($result);
} catch (\Exception $e) {
  echo $e->getMessage();
}
// 記事の数を取得
try {
  $id = $_GET['id'];
  $count_sql = 'SELECT count(*) FROM post WHERE user_id = ?';
  $count_stmt = connect()->prepare($count_sql);
  $count_stmt->bindValue(1, $id, PDO::PARAM_INT);
  $count_stmt->execute();
  $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
  $postCnt = ((int)$count['count(*)']);
} catch (\Exception $e) {
  echo $e->getMessage();
}

// マイ情報を表示する
try {
  if (empty($_GET['id'])) throw new Exception('ID不正');
  $id = $_GET['id'];
  $sql_my = 'SELECT * FROM user WHERE id = ?';
  $stmt_my = connect()->prepare($sql_my);
  $stmt_my->bindValue(1, $id, PDO::PARAM_INT);
  $stmt_my->execute();
  $result_my = $stmt_my->fetch(PDO::FETCH_ASSOC);
  // print_r($result);
} catch (\Exception $e) {
  echo $e->getMessage();
}
if ($result_my == NULL) {
  header("Location: /404.php");
}

?>

<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo h($result_my['name']); ?>｜Collection of Works for engineer</title>
  <meta name="description" content="<?php echo h($result_my['info']); ?>">
  <meta name="viewport" content="width=device-width">
  <meta name="format-detection" content="telephone=no">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?php echo h($result_my['name']); ?>｜Collection of Works for engineer">
  <meta property="og:description" content="<?php echo h($result_my['info']); ?>">
  <meta property="og:url" content="https://service.portfolio.progblog-web.com/user/index.php">
  <meta property="og:image" content="https://service.portfolio.progblog-web.com/asset/img/symbol/og_img.jpg">
  <meta property="og:site_name" content="<?php echo h($result_my['name']); ?>｜Collection of Works for engineer">
  <meta property="og:locale" content="ja_JP">
  <link rel="canonical" href="https://service.portfolio.progblog-web.com/user/index.php">
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
        <div class="main-block">
          <div class="timeline">
            <?php foreach ($result as $post) : ?>
              <?php if ($id == $post['user_id']) : ?>
                <div class="timeline-post">
                  <?php if ($login) : ?>
                    <?php if ($id == $login_user['id']) : ?>
                      <form class="post-delete" action="/catalog/delete.php?id=<?php echo h($post['id']); ?>" method="POST" name="deleteform" onsubmit="return disp()">
                        <input type="hidden" name="userid" value="<?php echo h($id) ?>">
                        <input type="submit" name="delete" value="&#xf1f8;" class="fas">
                      </form>
                    <?php endif; ?>
                  <?php endif; ?>
                  <p class="title" style="margin-top: 0;"><a href="/catalog/product/index.php?id=<?php echo h($post['id']); ?>" class="timeline-post-link"><?php echo h($post['title']); ?></a></p>
                  <p class="detail"><a href="/catalog/product/index.php?id=<?php echo h($post['id']); ?>" class="timeline-post-link"><?php echo h($post['bio']); ?></a></p>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
            <?php if ($postCnt == 0) : ?>
              <div class="timeline-post">
                <p>まだ投稿がありません</p>
              </div>
            <?php endif; ?>

          </div>
        </div>
        <div class="aside-block">
          <div class="user-profile">
            <?php if ($result_my['icon'] == 'null') : ?>
              <p class="user-profile-img"><img src="https://placehold.jp/3d4070/ffffff/272x168.jpg?text=NO%20IMG" alt=""></p>
            <?php else : ?>
              <p class="user-profile-img"><img src="/user/<?php echo h($result_my['icon']); ?>" alt=""></p>
            <?php endif; ?>
            <p class="user-profile-name"><?php echo h($result_my['name']) ?></p>
            <p class="user-profile-desc"><?php echo h($result_my['info']) ?></p>
            <div class="user-profile-link">
              <?php if (!$result_my['twitter'] == NULL) : ?>
                <p class="user-profile-link-item"><a href="<?php echo ($result_my['twitter']); ?>" target="_blank"><i class="fab fa-twitter"></i><span class="link-name">Twitter</span></a></p>
              <?php endif; ?>
              <?php if (!$result_my['github'] == NULL) : ?>
                <p class="user-profile-link-item"><a href="<?php echo ($result_my['github']); ?>" target="_blank"><i class="fab fa-github"></i><span class="link-name">github</span></a></p>
              <?php endif; ?>
              <?php if (!$result_my['website'] == NULL) : ?>
                <p class="user-profile-link-item"><a href="<?php echo ($result_my['website']); ?>" target="_blank"><i class="fas fa-sitemap"></i><span class="link-name">website</span></a></p>
              <?php endif; ?>
            </div>
            <?php if ($login) : ?>
              <?php if ($id == $login_user['id']) : ?>

                <p class="user-profile-fix"><a href="update_form.php?id=<?php echo h($id); ?>"><i class="fas fa-arrow-right fa-fw"></i>情報を修正する</a></p>
                <form class="logout user-profile-logout" action="/login/logout.php" method="POST"><i class="fas fa-arrow-right fa-fw"></i><input type="submit" name="logout" value="ログアウト"></form>
                <form class="user-delete" action="/user/delete.php?id=<?php echo h($id); ?>" method="POST" onsubmit="return disp()"><i class="fas fa-arrow-right fa-fw"></i><input type="submit" name="delete" value="アカウントを削除する">
                </form>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php if ($login) : ?>
        <div class="post-action">
          <p class="post-action-triiger"><a href="/portfolio/post/index.php"><i class="fas fa-plus"></i></a></p>
        </div>
      <?php endif; ?>

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