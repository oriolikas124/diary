<?php
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$dataFile = './data/diaries.csv';
$posts= [];

if (file_exists($dataFile)) {
  $file = fopen($dataFile, 'r');
  while (($post = fgetcsv($file)) !== false) {
    $posts[] = $post;
  }
  fclose($file);
}


?><!DOCTYPE html>
<html>
  <head>
    <title>日記投稿サイト</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>

    <h1>日記一覧</h1>
    <a href="my-page.php">マイページへ</a><br>
    <a href="post.php">新規作成</a>

    <?php

  if (empty($posts)): ?>
    <p>まだ投稿がありません。</p>
    <?php else: ?>
      <ul>
        <?php foreach ($posts as $post): ?>
          <li>
            <strong>日付:</strong> <?php echo htmlspecialchars($post[0]); ?><br>
            <strong>タイトル:</strong> <?php echo htmlspecialchars($post[1]); ?><br>
            <strong>内容:</strong> <?php echo nl2br(htmlspecialchars($post[2])); ?>
          </li>
          <hr>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="my-page.php">マイページ</a><br>
<a href="logout.php">ログアウト</a>

</body>
</html>
