<?php
require_once '../config/google.php';

// Generate Google Login URL
$loginUrl = $googleClient->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login with Google</title>
<style>
body{
  font-family: Arial, sans-serif;
  background:#f4f6f8;
  display:flex;
  justify-content:center;
  align-items:center;
  height:100vh;
}
.btn{
  padding:14px 28px;
  background:#1a73e8;
  color:#fff;
  text-decoration:none;
  border-radius:6px;
  font-size:16px;
}
</style>
</head>
<body>

<a href="<?= htmlspecialchars($loginUrl) ?>" class="btn">
  Sign in with Google
</a>

</body>
</html>
