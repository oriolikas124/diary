<?php
session_start();

$dataFile = './data/users.csv';
if (!file_exists($dataFile)) {
  $handle = fopen($dataFile, 'w');
  fclose($handle);
}

function isEmailUnique($email) {
  global $dataFile;
  $file = fopen($dataFile, 'r');
  while (($user = fgetcsv($file)) !== false) {
    if ($user[1] === $email) {
      fclose($file);
      return false;
    }
  }
  fclose($file);
  return true;
}

if ($_SERVER["REQUEST_METHOD"]  == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (isEmailUnique($email)) {
    $userId = uniqid();

    $file = fopen($dataFile, 'a');
    fputcsv($file, [$userId, $email, $name, $password]);
    fclose($file);

    header("Location: login.php");
    exit;
  } else {
    $error = "this Email already exists";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>日記投稿サイト</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <h1>Registration</h1>

    <?php
    if(!empty($error)) {
      echo "<p style='color:red;'>$error</p>";
    }
    ?>

    <form method="POST" action="">
      <div>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required>
      </div><br>
      <div>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required>
      </div><br>
      <div>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required>
      </div><br>
      <div>
        <button type="submit">Registrate</button>
      </div>
      <div>
        <p><a href="login.php">Back to Login</a></p>
      </div>
    </form>

  </body>
</html>
