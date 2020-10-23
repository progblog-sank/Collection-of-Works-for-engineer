<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';
// ログインユーザーがイイネした投稿の回数を調べる
$user_id = $_POST['nice_user_id'];
$post_id = $_POST['nice_post_id'];
$url = $_POST['now_page'];
// var_dump($now);
try {
  $sql = "SELECT * FROM nice WHERE nice_user_id= $user_id AND nice_post_id= $post_id";
  // var_export($sql);
  $stmt = connect()->query($sql);
  $stmt->bindValue(2, $user_id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage();
}
$nice_id = $result['nice_id'];
if ($nice_id > 1) {
  try {
    $sql = "DELETE FROM nice WHERE nice_id = $nice_id ";
    $stmt = connect()->query($sql);
    $stmt->bindValue(1, $nice_id, PDO::PARAM_INT);
    $stmt->execute();
    print_r('イイネを消しました。');
    // $url = '/catalog/index.php?page=' . $now;
    header("Location: " . $url);
  } catch (\Exception $e) {
    echo $e->getMessage();
  }
} else {
  $nicePortfolio = UserLogic::nicePortfolio($_POST);
  print_r('イイネしました。');
  // $url = '/catalog/index.php?page=' . $now;
  header("Location: " . $url);
}
// try {
//   $count_sql = "SELECT count(nice_user_id) FROM nice WHERE nice_user_id= $user_id ";
//   // var_export($count_sql);
//   $count_stmt = connect()->query($count_sql);
//   $count_stmt->bindValue(2, $post_id, PDO::PARAM_INT);
//   $count_stmt->execute();
//   $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
// } catch (\Exception $e) {
//   echo $e->getMessage();
// }
// $user_niceCnt = ((int)$count['count(nice_user_id)']);
// try {
//   $count_sql = "SELECT count(nice_post_id) FROM nice WHERE nice_post_id= $post_id "; 
//   // var_export($count_sql);
//   $count_stmt = connect()->query($count_sql);
//   $count_stmt->bindValue(3, $post_id, PDO::PARAM_INT);
//   $count_stmt->execute();
//   $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
// } catch (\Exception $e) {
//   echo $e->getMessage();
// }
// $posts_niceCnt = ((int)$count['count(nice_post_id)']);

// $toatal_post = $user_niceCnt + $posts_niceCnt;
// var_dump($toatal_post);

// var_dump($user);
// try {
//   $sql = "SELECT * FROM nice WHERE nice_user_id = $user ";
//   $stmt = connect()->query($sql);
//   $stmt->bindValue(1, $user, PDO::PARAM_INT);
//   $stmt->execute();
//   $result = $stmt->fetch(PDO::FETCH_ASSOC);
// } catch (\Exception $e) {
//   echo $e->getMessage();
// }
// if ($result['nice_user_id'] == $user && $post == $result['nice_post_id']) {
//   try {
//     $sql = "DELETE FROM nice WHERE nice_user_id = $post ";
//     $stmt = connect()->query($sql);
//     $stmt->bindValue(3, $post, PDO::PARAM_INT);
//     $stmt->execute();
//     print_r('イイネを消しました。');
//   } catch (\Exception $e) {
//     echo $e->getMessage();
//   }
// } else {
//   //　イイネ機能
//   $nicePortfolio = UserLogic::nicePortfolio($_POST);
//   print_r('イイネしました。');
// }
// ここまで


// $url = '/catalog/index.php';
// header("Location: " . $url);

$login = UserLogic::checkLogin();
if (!$login) {
  header('Location: ../../login/index.php');
}
$login_user = $_SESSION['login_user'];

?>
<!-- <!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>コメント投稿完了｜Collection of Works for engineer</title>
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
</html> -->