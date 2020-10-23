<?php
require_once ( __DIR__ . '/../deconnect.php');

class UserLogic {
  /**
   * ユーザー登録をする
   * @param array $userData
   * @return bool $result
   */
  public static function createUser($userData) {
    $result = false;
    // 画像のアップロード
    $icon = uniqid(mt_rand(), true);
    $icon .= '.' . substr(strrchr($_FILES['icon']['name'], '.'), 1);
    $tempfile = $_FILES['icon']['tmp_name'];
    $filename = 'img/' . $icon;

    if (is_uploaded_file($tempfile)) {
      if ( move_uploaded_file($tempfile , $filename )) {
      } else {
        $filename = 'null';
      }
    } else {
      $filename = 'null';
    }
    $sql = 'INSERT INTO user (name, password, icon, info, twitter, github, website) VALUES (?, ?, ?, ?, ?, ?, ?)';
    // ユーザーデータを配列に入れる
    $arr = [];
    $arr[] = $userData['username'];
    $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);
    $arr[] = $filename ;
    $arr[] = $userData['info'];
    $arr[] = $userData['twitter'];
    $arr[] = $userData['github'];
    $arr[] = $userData['website'];
    try {
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }
  /**
   * ログイン処理
     * @param array $username
     * @param array $password
     * @return bool $result
   */
  public static function login($username, $password) {
    $result = false;
    // ユーザーをemailから検索して取得
    $user = self::getUserByName($username);
    if(!$user) {
      $_SESSION['msgUsername'] = 'ユーザー名が一致しません。';
      return $result;
    }
    // パスワードの照会
    if(password_verify($password, $user['password'])) {
      // ログイン成功
      session_regenerate_id(true);
      $_SESSION['login_user'] =$user;
      $result = true;
      return $result;
    }

    $_SESSION['msgPassword'] = 'パスワードが一致しません。';
      return $result;
  }
    /**
   * ユーザー名からユーザーを取得
   * @param array $username
   * @return array|bool $user|false
   */
  public static function getUserByName($username){
    // SQLの準備
    // SQLの実行
    // SQLの結果を返す
    $sql = 'SELECT * FROM user WHERE name = ?';

    // ユーザー名を配列に入れる。
    $arr = [];
    $arr[] = $username;
    
    try {
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      // SQLの値を返す
      $user = $stmt->fetch();
      return $user;
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }
  /**
   * ログインチェック
   * @param void 
   * @return bool $result
   */
  public static function checkLogin() {
    $result = false;
    // セッションにログインユーザーが入ってなかったらfalse
    if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0) {
      return $result = true;
    }
    return $result;
  }
    /**
     * ログアウトの処理 
     * @param void
     * @return bool
     */
    public static function logout() {
      $_SESSION = array();
      session_destroy();
    }
  /**
   * ユーザ情報アップデート
   * @param void
   * @return bool $result
  */
  public static function updateUser() {
    $result = false;
    // 画像のアップロード
    $icon = uniqid(mt_rand(), true);
    $icon .= '.' . substr(strrchr($_FILES['icon']['name'], '.'), 1);
    $tempfile = $_FILES['icon']['tmp_name'];
    $filename = 'img/' . $icon;
    if (is_uploaded_file($tempfile)) {
      if ( move_uploaded_file($tempfile , $filename )) {
        $username = $_POST['username'];
        $info = $_POST['info'];
        $twitter = $_POST['twitter'];
        $github = $_POST['github'];
        $website = $_POST['website'];
        try {
          if(empty($_POST['id'])) throw new Exception('ID不正');
          $id = $_POST['id'];
          $sql = 'UPDATE user SET name = ?, icon = ?, info = ?, twitter = ?, github = ?, website = ? WHERE id = ?';
          $stmt = connect()->prepare($sql);
          $stmt->bindValue(1, $username, PDO::PARAM_STR);
          $stmt->bindValue(2, $filename, PDO::PARAM_STR);
          $stmt->bindValue(3, $info, PDO::PARAM_STR);
          $stmt->bindValue(4, $twitter, PDO::PARAM_STR);
          $stmt->bindValue(5, $github, PDO::PARAM_STR);
          $stmt->bindValue(6, $website, PDO::PARAM_STR);
          $stmt->bindValue(7, $id, PDO::PARAM_INT);
          $stmt->execute();
          $url = '/user/index.php?' . http_build_query(['id' => $id]);
          header("Location: " . $url);
          exit();
    
          header('Location: /traial/index.php');
        } catch (\Exception $e) {
          echo $e->getMessage();
        }
        return $result;
    
      } else {
        echo "ファイルをアップロードできません。";
      }
    } else {
      $username = $_POST['username'];
      $info = $_POST['info'];
      $twitter = $_POST['twitter'];
      $github = $_POST['github'];
      $website = $_POST['website'];
      try {
        if(empty($_POST['id'])) throw new Exception('ID不正');
        $id = $_POST['id'];
        $sql = 'UPDATE user SET name = ?, info = ?, twitter = ?, github = ?, website = ? WHERE id = ?';
        $stmt = connect()->prepare($sql);
        $stmt->bindValue(1, $username, PDO::PARAM_STR);
        $stmt->bindValue(2, $info, PDO::PARAM_STR);
        $stmt->bindValue(3, $twitter, PDO::PARAM_STR);
        $stmt->bindValue(4, $github, PDO::PARAM_STR);
        $stmt->bindValue(5, $website, PDO::PARAM_STR);
        $stmt->bindValue(6, $id, PDO::PARAM_INT);
        $stmt->execute();
        $url = '/user/index.php?' . http_build_query(['id' => $id]);
        header("Location: " . $url);
        exit();
        header('Location: /traial/index.php');
      } catch (\Exception $e) {
        echo $e->getMessage();
      }
      return $result;
    }
  }
  /**
   * ポートフォリオを投稿する
   * @param array $postData
   * @return bool $result
   */
  public static function postPortfolio($postData) {
    $result = false;
    // 画像のアップロード
    $primg = uniqid(mt_rand(), true);
    $primg .= '.' . substr(strrchr($_FILES['primg']['name'], '.'), 1);
    // var_dump($fname);
    $tempfile = $_FILES['primg']['tmp_name'];
    $filename ='img/' . $primg;
    if (is_uploaded_file($tempfile)) {
      if ( move_uploaded_file($tempfile , $filename )) {
      } else {
        echo "ファイルをアップロードできません。";
      }
    } else {
      echo "ファイルが選択されていません。";
    }
    $sql = 'INSERT INTO post (title, bio, primg, url, reference, referenceUrl, lang, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    // ポストデータを配列に入れる
    $arr = [];
    $arr[] = $postData['title'];
    $arr[] = $postData['bio'];
    $arr[] = $filename ;
    $arr[] = $postData['url'];
    $arr[] = $postData['reference'];
    $arr[] = $postData['referenceUrl'];
    $arr[] = $postData['lang'];
    $arr[] = $postData['user_id'];
    try {
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
      // header('Location: /catalog/index.php');
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }
  /**
   * コメントを投稿する
   * @param array $commentData
   * @return bool $result
   */
  public static function commentPortfolio($commentData) {
    $result = false;
    $sql = 'INSERT INTO comment (comment, user_post_id, post_id) VALUES (?, ?, ?)';
    // コメントデータを配列に入れる
    $arr = [];
    $arr[] = $commentData['comment'];
    $arr[] = $commentData['user_post_id'];
    $arr[] = $commentData['post_id'];
    try {
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }
  /**
   * ナイスを投稿する
   * @param array $niceData
   * @return bool $result
   */
  public static function nicePortfolio($niceData) {
    
    $result = false;
    $sql = 'INSERT INTO nice (nice_user_id, nice_post_id) VALUES (?, ?)';
    // コメントデータを配列に入れる
    $arr = [];
    $arr[] = $niceData['nice_user_id'];
    $arr[] = $niceData['nice_post_id'];
    try {
      $stmt = connect()->prepare($sql);
      $result = $stmt->execute($arr);
      return $result;
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  // /**
  //  * ページネーション機能
  //  * @param void 
  //  * @return bool $result
  //  */
  // public static function pageNationRecentPost() {
  //   $result = false;
  //   // 投稿の総数を取得
  //   try {
  //     $count_sql = 'SELECT count(*) FROM post';
  //     $count_stmt = connect()->query($count_sql);
  //     $count = $count_stmt->fetch(PDO::FETCH_ASSOC);
  //   } catch (\Exception $e) {
  //     echo $e->getMessage();
  //   }
  //   $postCnt= ((int)$count['count(*)']);
  //   // 1ページあたりの投稿数
  //   $perPage = 2;
  //   // 最大ページ
  //   $totalPage = ceil($postCnt / $perPage);
  //   var_dump($totalPage);
  //   // 現在のページを取得
  //   if(!isset($_GET['page'])){ 
  //     $now = 1; 
  //   }else{
  //     $now = $_GET['page'];
  //   }
  // var_dump($now);
  // $startPost = ($now - 1) * $perPage;
  // var_dump($startPost);
  // $disp_data = array_slice($result, $startPost, $perPage, true);

  // }
}
?>