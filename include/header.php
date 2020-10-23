<?php
require_once ( __DIR__ . '/../classes/UserLogic.php');
// ログインしているか判定
$login = UserLogic::checkLogin();
if($login) {
  $login_user = $_SESSION['login_user'];
}
// var_dump($login_user['id'] );

?>
<header class="header">
    <div class="header-inner">
      <div class="logo"><h1><a href="/"><img src="/asset/img/symbol/logo.png" alt="Collection of Works for engineer"></a></h1></div>
      <div class="menu">
        <div class="join">
        <?php
        if($login) {
          echo '<p class="login"><a href="/user/index.php?id='. h($login_user['id']) . '">マイページ</a></p>';
          // echo '<form class="logout" action="/login/logout.php" method="POST"><input type="submit" name="logout" value="ログアウト"></form>';
        } else {
          echo '<p class="login"><a href="/login/index.php">ログイン</a></p>';
          echo '<p class="login" style = "margin-top: 10px;"><a href="/entry/index.php">新規登録</a></p>';
        }
        ?>
        </div>
      </div>
    </div>
</header>