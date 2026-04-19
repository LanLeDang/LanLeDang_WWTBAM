<?php
require_once __DIR__ . '/includes/bootstrap.php';

//stores sticky form value and messages
$username = '';
$successMessage = '';
$errorMessage = '';

//handles registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    //validates registration input
    if ($username === '' || $password === '' || $confirmPassword === '') {
        $errorMessage = 'Please fill in all fields.';
    } elseif (strlen($username) < 3) {
        $errorMessage = 'Username must be at least 3 characters long.';
    } elseif (strlen($password) < 4) {
        $errorMessage = 'Password must be at least 4 characters long.';
    } elseif ($password !== $confirmPassword) {
        $errorMessage = 'Passwords do not match.';
    } elseif (account_exists($username)) {
        $errorMessage = 'That username already exists. Choose a different one.';
    } else {
        //saves the new account
        register_account($username, $password);
        $successMessage = 'Registration successful! You can now use that account on the login page.';
        $username = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Panther Millionaire</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="page-wrapper">
    <!--navigation-->
    <header class="topbar">
      <div class="topbar-inner">
        <div class="brand">Panther Millionaire</div>
        <nav class="top-links">
          <a href="index.php">Home</a>
          <a href="register.php">Register</a>
          <a href="login.php">Login</a>
          <a href="leaderboard.php">Leaderboard</a>
          <a href="team.html">Team</a>
        </nav>
      </div>
    </header>

    <!--registration page-->
    <main class="hero">
      <section class="page-card">
        <h2>Register a Player</h2>
        <p class="subtitle">Create player accounts before starting the 2-player match.</p>

        <?php if ($errorMessage !== ''): ?>
          <div class="message error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <?php if ($successMessage !== ''): ?>
          <div class="message success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>

        <!--registration form-->
        <form action="register.php" method="post">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
          </div>

          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-secondary">Go to Login</a>
          </div>
        </form>
      </section>
    </main>
  </div>
</body>
</html>