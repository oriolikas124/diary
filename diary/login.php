<?php
session_start();

function findUser($email, $password) {
  $file = fopen('./data/users.csv', 'r');
  while (($user = fgetcsv($file)) !== false) {

    if ($user[1] === $email && $user[3] === $password) {
      fclose($file);
      return $user;
    }
  }
  fclose($file);
  return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $remember = isset($_POST['remember']);


  $user = findUser($email, $password);

  if($user) {
    $_SESSION['user'] = $user[1];

    if ($remember) {
      setcookie("remembered_user", $email, time() + (86400 * 30), "/");
    }

    header("Location: index.php");
    exit();
  } else {
    $error = "Wrong email or password";
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
    <h1>ログイン</h1>

    <?php
    if (!empty($error)) {
      echo "<p style='color:red;'>$error</p>";
    }
    ?>

    <form method="POST" action="">
      <div>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required>
      </div><br>
      <div>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required>
      </div><br>
      <div>
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Remember Me</label>
      </div><br>
      <div>
        <button type="submit">Login</button>
      </div>
      <p><a href="register.php">Registration</a></p>
    </form>

  </body>

</html>
