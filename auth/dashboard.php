<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
body{font-family:Arial;background:#f8fafc;padding:40px}
.card{background:#fff;padding:30px;border-radius:10px;width:350px}
img{border-radius:50%}
</style>
</head>
<body>

<div class="card">
  <img src="<?= $_SESSION['picture'] ?>" width="80"><br><br>
  <strong><?= $_SESSION['name'] ?></strong><br>
  <?= $_SESSION['email'] ?><br><br>
  <a href="logout.php">Logout</a>
</div>

</body>
</html>
