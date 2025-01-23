<?php

session_start();

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$dataFile = "./data/users.csv";
$userData = null;

$file = fopen($dataFile, 'r');
while (($user = fgetcsv($file)) !== false) {
  if ($user[1] === $_SESSION['user']) {
    $userData = $user;
    break;
  }
}
fclose($file);

if (!$userData) {
  header("Location: login.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
  <meta charset="UTF-8">
  <title>マイページ</title>
  </head>
  <body>

    <h1>マイページ</h1>

    <p>ID: <?php echo htmlspecialchars($userData[0]); ?></p>
    <p>Email: <?php echo htmlspecialchars($userData[1]); ?></p>
    <p>Name: <?php echo htmlspecialchars($userData[2]); ?></p>

    <ul>
      <li><a href="index.php">日記一覧</a></li>
      <li><a href="edit.php">情報変更</a></li>
      <li><a href="logout.php">ログアウト</a></li>
    </ul>

  </body>
</html>
