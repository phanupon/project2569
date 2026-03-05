<?php
echo "Hello, World!";
?>

<form action="register_process.php" method="get">
  <label for="username">First name:</label><br>
  <input type="text" id="name" name="name" required><br>
  <label for="lname">Login name:</label><br>
  <input type="text" id="loginname" name="loginname" required><br>
  <label for="email">email:</label><br>
  <input type="text" id="email" name="email" required><br>
  <label for="passwd">Password:</label><br>
  <input type="password" id="passwd" name="passwd" required ><br><br>

  <button type="submit">Register</button>
</form> 