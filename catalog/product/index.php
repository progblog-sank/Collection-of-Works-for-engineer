<?php
session_start();
require_once '../../functions.php';
require_once '../../classes/UserLogic.php';

// ログインしているか判定
$login = UserLogic::checkLogin();
if ($login) {
  $login_user = $_SESSION['login_user'];
}

// 記事一覧を取得
try {
  if (empty($_GET['id'])) throw new Exception('ID不正');
  $id = $_GET['id'];
  $sql = 'SELECT u. *, p .*, c. * FROM user u, post p, comment c WHERE u.id=p.user_id AND p.id = ?';
  $stmt = connect()->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($result['title']);
  if ($result['post_id'] == NULL) {
    header("Location: /404.php");
  }
} catch (\Exception $e) {
  echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/website#">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo h($result['title']); ?>｜Collection of Works for engineer</title>
  <meta name="description" content="<?php echo h($result['bio']); ?>">
  <meta name="viewport" content="width=device-width">
  <meta name="format-detection" content="telephone=no">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?php echo h($result['title']); ?>｜Collection of Works for engineer">
  <meta property="og:description" content="<?php echo h($result['bio']); ?>">
  <meta property="og:url" content="https://service.portfolio.progblog-web.com/catalog/product/index.php">
  <meta property="og:image" content="https://service.portfolio.progblog-web.com/asset/img/symbol/og_img.jpg">
  <meta property="og:site_name" content="<?php echo h($result['title']); ?>｜Collection of Works for engineer">
  <meta property="og:locale" content="ja_JP">
  <link rel="canonical" href="https://service.portfolio.progblog-web.com/catalog/product/index.php">
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
  <?php include('../../include/header.php') ?>
  <main>
    <div class="wrap-block">
      <div class="wrap-block-inner">
        <div class="main-block">
          <div class="timeline">
            <div class="timeline-post">
              <?php if ($result['icon'] == 'null') : ?>
                <p class="users"><a href="/user/index.php?id=<?php echo h($result['user_id']) ?>"><span class="users-icon"><img src="https://placehold.jp/3d4070/ffffff/272x168.jpg?text=NO%20IMG" alt=""></span><span class="users-name"><?php echo h($result['name']) ?></span></a></p>
              <?php else : ?>
                <p class="users"><a href="/user/index.php?id=<?php echo h($result['user_id']) ?>"><span class="users-icon"><img src="../../user/<?php echo h($result['icon']) ?>" alt=""></span><span class="users-name"><?php echo h($result['name']) ?></span></a></p>
              <?php endif; ?>
              <p class="title"><?php echo h($result['title']); ?></p>
              <p class="detail"><?php echo h($result['bio']); ?></p>
              <p class="portfolio"><a href="<?php echo h($result['url']); ?>" target="_blank"><img src="../../portfolio/post/<?php echo h($result['primg']); ?>" alt=""></a></p>
              <?php if (!$result['referenceUrl'] == NULL) : ?>
                <p class="reference"><a href="<?php echo h($result['referenceUrl']) ?>" class="timeline-post-link"><sup><i class="fas fa-quote-left fa-fw"></i></sup><?php echo h($result['reference']) ?></a></p>
              <?php endif; ?>
              <?php if (!$result['lang'] == NULL) : ?>
                <?php $lang = explode(",", $result['lang']); ?>
                <p class="lang">
                  <?php for ($i = 0; $i < count($lang); $i++) : ?>
                    <span class="lang-type"><?php echo h($lang[$i]) ?></span>
                  <?php endfor; ?>
                <?php endif; ?>
                </p>

                <?php
                // イイネ機能作成
                $post_id = (int)$result['id'];
                $now = $_GET['id'];

                try {
                  $count_sql = "SELECT count(*) FROM nice WHERE nice_post_id=$now";
                  $count_stmt = connect()->query($count_sql);
                  $count_stmt->bindValue(1, $now, PDO::PARAM_INT);
                  $count_stmt->execute();
                  $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
                } catch (\Exception $e) {
                  echo $e->getMessage();
                }
                $url = $_SERVER['REQUEST_URI'];

                $niceCnt = ((int)$count['count(*)']);
                if ($login) {
                  try {
                    $user_id = $login_user['id'];
                    $count_Mysql = "SELECT count(*) FROM nice WHERE nice_post_id=$now AND nice_user_id=$user_id";
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
                    <form method="POST" action="../../catalog/nice.php" class="nice">
                      <p class="reaction-favorite">
                        <input type="hidden" name="nice_post_id" value="<?php echo h($now)  ?>">
                        <input type="hidden" name="nice_user_id" value="<?php echo h($login_user['id']) ?>">
                        <input type="hidden" name="now_page" value="<?php echo h($url) ?>">
                        <button type="submit">ナイス
                          <?php if ($my_niceCnt >= 1) : ?>
                            <i class="fas fa-heart is-active"></i>
                          <?php else : ?>
                            <i class="fas fa-heart"></i>
                          <?php endif; ?>
                        </button>
                        <span class="reaction-favorite-num"><i class="fas fa-heart"></i><?php echo h($niceCnt) ?></span></p>
                    </form>
                    <form method="POST" action="../comment.php" class="coment">
                      <p class="reaction-coment">
                        <textarea type="text" name="comment" placeholder="コメントする"></textarea>
                        <input type="hidden" name="post_id" value="<?php echo h($now)  ?>">
                        <input type="hidden" name="user_post_id" value="<?php echo h($login_user['id']) ?>">
                        <input type="hidden" name="now_page" value="<?php echo h($url) ?>">
                      </p>
                      <p class="reaction-submit"><input type="submit" name="submit" value="コメント"></p>
                    </form>
                  </div>
                <?php else : ?>

                  <div class="reaction">
                    <p class="reaction-favorite"><button type="submit"><a href="../../login/index.php">ナイス<i class="fas fa-heart"></i></a></button><span class="reaction-favorite-num"><i class="fas fa-heart"></i><?php echo h($niceCnt) ?></span></p>
                    <form method="POST" action="../../login/index.php" class="coment">
                      <p class="reaction-coment">
                        <textarea type="text" name="comment" placeholder="コメントする"></textarea>
                        <input type="hidden" name="post_id" value="">
                        <input type="hidden" name="user_post_id" value="">
                      </p>
                      <p class="reaction-submit"><input type="submit" name="submit" value="コメント"></p>
                    </form>
                  </div>
                <?php endif; ?>
                <?php
                try {
                  $id = $_GET['id'];
                  $sql = 'SELECT u. *, p.*, c.* FROM user u, post p, comment c WHERE c.user_post_id = u.id AND p.id =c.post_id';
                  $stmt = connect()->query($sql);
                  $stmt->bindValue(1, $id, PDO::PARAM_INT);
                  $stmt->execute();
                  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (\Exception $e) {
                  echo $e->getMessage();
                }
                ?>
                <?php foreach ($result as $post) : ?>
                  <?php if ($id == $post['post_id']) : ?>
                    <div class="reaction-re">
                      <div class="reaction-re-coment">
                      <?php if ($post['icon'] == 'null') : ?>
                        <p class="users"><a href="/user/index.php?id=<?php echo h($post['user_post_id']) ?>"><span class="users-icon"><img src="https://placehold.jp/3d4070/ffffff/272x168.jpg?text=NO%20IMG" alt=""></span><span class="users-name"><?php echo h($post['name']) ?></span></a></p>

                        <?php else : ?>
                        <p class="users"><a href="/user/index.php?id=<?php echo h($post['user_post_id']) ?>"><span class="users-icon"><img src="../../user/<?php echo h($post['icon']) ?>" alt=""></span><span class="users-name"><?php echo h($post['name']) ?></span></a></p>
                        <?php endif ;?>
                        <p class="detail"><?php echo h($post['comment']) ?></p>
                      </div>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
            </div>
          </div>
          <p class="more-link"><a href="/catalog/">ALL VIEW</a></p>
        </div>
        <div class="aside-block">
          <?php include('../../include/popular.php') ?>
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