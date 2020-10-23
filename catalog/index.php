<?php
session_start();
require_once '../functions.php';
require_once '../classes/UserLogic.php';

// ログインしているか判定
$login = UserLogic::checkLogin();
if ($login) {
  $login_user = $_SESSION['login_user'];
}

// 記事一覧を取得
try {
  $sql = 'SELECT u. *, p.* FROM user u, post p  WHERE u.id=p.user_id ORDER BY p.id DESC';
  $stmt = connect()->query($sql);
  $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage();
}

// ページネーション作成
try {
  $count_sql = 'SELECT count(*) FROM post';
  $count_stmt = connect()->query($count_sql);
  $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage();
}
$postCnt = ((int)$count['count(*)']);
// 1ページあたりの投稿数
$perPage = 5;
// 最大ページ
$totalPage = ceil($postCnt / $perPage);
// 現在のページを取得
if (!isset($_GET['page'])) {
  $now = 1;
} else {
  $now = $_GET['page'];
}
$startPost = ($now - 1) * $perPage;
// ページごとに表示開始する投稿を指定
$displayPost = array_slice($result, $startPost, $perPage, true);
?>
<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ポートフォリオ一覧｜Collection of Works for engineer</title>
  <meta name="description" content="本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。">
  <meta name="viewport" content="width=device-width">
  <meta name="format-detection" content="telephone=no">
  <meta property="og:type" content="website">
  <meta property="og:title" content="ポートフォリオ一覧｜Collection of Works for engineer">
  <meta property="og:description" content="本サイトはエンジニアが作ったwebサイト、webアプリについて紹介するサービスです。自身で作ったサービスを紹介したり、他エンジニアが作ったサービスを見て知見を深めたりと活用してください。">
  <meta property="og:url" content="https://service.portfolio.progblog-web.com/catalog/index.php">
  <meta property="og:image" content="https://service.portfolio.progblog-web.com/asset/img/symbol/og_img.jpg">
  <meta property="og:site_name" content="ポートフォリオ一覧｜Collection of Works for engineer">
  <meta property="og:locale" content="ja_JP">
  <link rel="canonical" href="https://service.portfolio.progblog-web.com/catalog/index.php">
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
            <?php foreach ($displayPost as $post) : ?>
              <div class="timeline-post">
                <?php if ($post['icon'] == 'null') : ?>
                  <p class="users"><a href="/user/index.php?id=<?php echo h($post['user_id']) ?>"><span class="users-icon"><img src="https://placehold.jp/3d4070/ffffff/272x168.jpg?text=NO%20IMG" alt=""></span><span class="users-name"><?php echo h($post['name']) ?></span></a></p>
                <?php else : ?>
                  <p class="users"><a href="/user/index.php?id=<?php echo h($post['user_id']) ?>"><span class="users-icon"><img src="../user/<?php echo h($post['icon']) ?>" alt=""></span><span class="users-name"><?php echo h($post['name']) ?></span></a></p>
                <?php endif; ?>
                <p class="title"><a href="/catalog/product/index.php?id=<?php echo h($post['id']) ?>" class="timeline-post-link"><?php echo h($post['title']) ?></a></p>
                <p class="detail"><a href="/catalog/product/index.php?id=<?php echo h($post['id']) ?>" class="timeline-post-link"><?php echo h($post['bio']) ?></a></p>
                <p class="portfolio"><a href="<?php echo h($post['url']) ?>"><img src="../portfolio/post/<?php echo h($post['primg']) ?>" alt=""></a></p>
                <?php if (!$post['referenceUrl'] == NULL) : ?>
                  <p class="reference"><a href="<?php echo h($post['referenceUrl']) ?>" class="timeline-post-link"><sup><i class="fas fa-quote-left fa-fw"></i></sup><?php echo h($post['reference']) ?></a></p>
                <?php endif; ?>
                <?php if (!$post['lang'] == NULL) : ?>
                  <?php $lang = explode(",", $post['lang']); ?>
                  <p class="lang">
                    <?php for ($i = 0; $i < count($lang); $i++) : ?>
                      <span class="lang-type"><?php echo h($lang[$i]) ?></span>
                    <?php endfor; ?>
                  <?php endif; ?>
                  </p>
                  <?php
                  // イイネ機能作成
                  $post_id = (int)$post['id'];
                  try {
                    $count_sql = "SELECT count(*) FROM nice WHERE nice_post_id=$post_id";
                    $count_stmt = connect()->query($count_sql);
                    $count_stmt->bindValue(1, $post_id, PDO::PARAM_INT);
                    $count_stmt->execute();
                    $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
                  } catch (\Exception $e) {
                    echo $e->getMessage();
                  }
                  $niceCnt = ((int)$count['count(*)']);
                  $url = $_SERVER['REQUEST_URI'];
                  if ($login) {
                    try {
                      $user_id = $login_user['id'];
                      $count_Mysql = "SELECT count(*) FROM nice WHERE nice_post_id=$post_id AND nice_user_id=$user_id";
                      $count_Mystmt = connect()->query($count_Mysql);
                      $count_Mystmt->bindValue(1, $post_id, PDO::PARAM_INT);
                      $count_Mystmt->execute();
                      $my_count = $count_Mystmt->fetch(PDO::FETCH_ASSOC);
                    } catch (\Exception $e) {
                      echo $e->getMessage();
                    }
                    $my_niceCnt = ((int)$my_count['count(*)']);
                  }
                  ?>
                  <?php if ($login) : ?>
                    <div class="reaction">
                      <form method="POST" action="../catalog/nice.php" class="nice">
                        <p class="reaction-favorite">
                          <input type="hidden" name="nice_post_id" value="<?php echo h($post['id']) ?>">
                          <input type="hidden" name="nice_user_id" value="<?php echo h($login_user['id']) ?>">
                          <input type="hidden" name="now_page" value="<?php echo h($url) ?>">
                          <button type="submit">ナイス
                            <?php if ($my_niceCnt >= 1) : ?>
                              <i class="fas fa-heart is-active"></i>
                            <?php else : ?>
                              <i class="fas fa-heart"></i>
                            <?php endif; ?>
                          </button>
                          <span class="reaction-favorite-num"><i class="fas fa-heart"></i><?php echo $niceCnt ?></span></p>
                      </form>
                      <form method="POST" action="../catalog/comment.php" class="coment">
                        <p class="reaction-coment">
                          <textarea type="text" name="comment" placeholder="コメントする"></textarea>
                          <input type="hidden" name="post_id" value="<?php echo h($post['id']) ?>">
                          <input type="hidden" name="user_post_id" value="<?php echo h($login_user['id']) ?>">
                          <input type="hidden" name="now_page" value="<?php echo h($url) ?>">
                        </p>
                        <p class="reaction-submit"><input type="submit" name="submit" value="コメント"></p>
                      </form>
                    </div>
                  <?php else : ?>
                    <div class="reaction">
                      <p class="reaction-favorite"><button type="submit"><a href="../login/index.php">ナイス<i class="fas fa-heart"></i></a></button><span class="reaction-favorite-num"><i class="fas fa-heart"></i><?php echo $niceCnt ?></span></p>
                      <form method="POST" action="../login/index.php" class="coment">
                        <p class="reaction-coment">
                          <textarea type="text" name="comment" placeholder="コメントする"></textarea>
                          <input type="hidden" name="post_id" value="">
                          <input type="hidden" name="user_post_id" value="">
                        </p>
                        <p class="reaction-submit"><input type="submit" name="submit" value="コメント"></p>
                      </form>
                    </div>
                  <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="page-nation">
            <?php if ($now > 1) : ?>
              <p class="page-num arrow"><a href="index.php?page=<?php echo ($now - 1) ?>"><i class="fas fa-angle-left"></i></a></p>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
              <?php if ($i == $now) : ?>

                <p class="page-num is-now"><?php echo h($now) ?></p>
              <?php else : ?>
                <p class="page-num"><a href="index.php?page=<?php echo h($i) ?>"><?php echo h($i) ?></a></p>
              <?php endif; ?>
            <?php endfor; ?>
            <?php if ($now < $totalPage) : ?>

              <p class="page-num arrow"><a href="index.php?page=<?php echo ($now + 1) ?>"><i class="fas fa-angle-right"></i></a></p>
            <?php endif; ?>
          </div>
        </div>
        <div class="aside-block">
          <?php include('../include/popular.php') ?>
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