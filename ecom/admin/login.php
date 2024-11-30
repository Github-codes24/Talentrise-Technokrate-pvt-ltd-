<?php
@session_start();
require_once ('../config/connection.inc.php');
if(!empty($_SESSION["username"]) || !empty($_SESSION["admin_id"])) {
   header("Location: index.php");
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo $site_name; ?> | Login</title>
   <!-- bootstrap 5 -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <link rel="stylesheet" href="css/login.css">
   <link rel="stylesheet" href="../assets/css/alert.css">
</head>

<body>
   <div class="background">
      <div class="shape"></div>
      <div class="shape"></div>
   </div>
   <?php require_once ('../assets/custom_alert/alert.php'); ?>

   <form method="POST" id="loginForm">
      <h3>Admin Login</h3>
      <div class="error-container" id="error-container">

      </div>
      <label for="email">Username</label>
      <input type="text" placeholder="Username" name="username" id="username">
      <span class="error-message" id="usernameError"></span>
      <label for="password">Password</label>
      <input type="password" placeholder="Password" name="password" id="password">
      <span class="error-message" id="passwordError"></span>
      <button type="button" name="loginBtn" id="loginBtn">Log In</button>
   </form>
   <!-- jquery cdn -->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

   <script src="../assets/custom_alert/js/alert.js"></script>
   <script src="../assets/custom_alert/js/custom_alert.js"></script>
   <!-- request handler -->
   <script src="../js/requestHandler.js"></script>
   <script src="js/login.js"></script>
</body>

</html>