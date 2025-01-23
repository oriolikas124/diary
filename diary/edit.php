<?php
session_start();

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$dataFile = './data/users.csv';
$userData = null;
$allUsers = [];

$file = fopen($dataFile, 'r');
while (($user = fgetcsv($file)) !== false) {
  $allUsers[] = $user;
  if ($user[1] === $_SESSION['user']) {
    $userData = $user;
  }
}
fclose($file);

if (!$userData) {
  header("Location: login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $newName = trim($_POST['name'] ?? '');
  $newEmail = trim($_POST['email'] ?? '');
  $newPassword = trim($_POST['password'] ?? '');

  if (empty($newName) || empty($newEmail) || empty($newPassword)) {
      echo "All fields are required!";
      exit();
  }

  foreach ($allUsers as &$user) {
    if ($user[1] === $_SESSION['user']) {
        $user[2] = $newName;
        $user[1] = $newEmail;
        $user[3] = $newPassword;
        $_SESSION['user'] = $newEmail;
        break;
    }
}
unset($user);

    $file = fopen($dataFile, 'w');
    foreach ($allUsers as $user) {
      fputcsv($file, $user);
    }
    fclose($file);

    header("Location: my-page.php");
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>情報変更</title>
</head>
<body>

<h1>情報変更</h1>

<form method="POST" action="">
  <div>
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userData[2]); ?>">
  </div><br>
    <div>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData[1]); ?>" required>
    </div><br>
  <div>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($userData[3]); ?>" required>
  </div><br>
  <div>
    <button type="submit">更新</button>
  </div>
</form>

</body>
</html>
