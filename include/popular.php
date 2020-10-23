<?php
try {
  $count_sql = "SELECT COUNT(*) AS cnt, nice_post_id FROM nice GROUP BY nice_post_id ORDER BY cnt DESC LIMIT 5 ";
  // var_export($count_sql);
  $count_stmt = connect()->query($count_sql);
  // $count_stmt->bindValue(1, $now, PDO::PARAM_INT);
  $count_stmt->execute();
  $count = $count_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\Exception $e) {
  echo $e->getMessage();
}
echo
  '<div class="popular-post">
<p class="box-title">人気のポートフォリオ</p>
<ol class="popular-list">';
foreach ($count as $post) {
  $id = (int)$post['nice_post_id'];

  try {
    $sql = 'SELECT * FROM post WHERE id = ?';
    $stmt = connect()->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    echo $e->getMessage();
  }
  foreach ($result as $post) {

    echo
      '<li><a href="/catalog/product/index.php?id=' . h($post['id']) . '">' . h($post['title']) . '</a></li>';
  }
}
echo '</ol>
</div>';
