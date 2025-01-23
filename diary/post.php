<?php
session_start();

if (!isset($_SESSION['user']))  {
  header("Location: login.php");
  exit();
}

$dataFile = './data/diaries.csv';

if (!file_exists($dataFile)) {
  $handle = fopen($dataFile, 'w');
  fclose($handle);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $date = trim($_POST['date'] ?? '');
  $title = trim($_POST['title'] ?? '');
  $content = trim($_POST['content']);

  if (empty($date) || empty($title) || empty($content)) {
    $error = "All fields are required";
  } else {
    $file = fopen($dataFile, 'a');
    fputcsv($file, [$date, $title, $content]);
    fclose($file);

    header("Location: index.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>新規作成</title>
  </head>
  <body>

  <h1>新規作成</h1>

  <?php
  if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
  }
  ?>

<form method="POST" action="">
  <div>
    <label for="date">日付:</label><br>
    <input type="date" id="date" name="date" required>
  </div><br>

  <div>
    <label for="title">タイトル:</label><br>
    <input type="text" id="title" name="title" required>
  </div><br>

  <div>
    <label for="content">内容:</label><br>
    <textarea id="content" name="content" rows="5" required></textarea>
  </div><br>

  <div>
    <button type="submit">投稿</button>
  </div>
</form>

<a href="index.php">戻る</a>

</body>
</html>
