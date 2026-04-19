<?php
require_once __DIR__ . '/includes/bootstrap.php';

//stores sticky form values and login errors
$errorMessage = '';
$player1 = '';
$player2 = '';

//handles 2-player login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $player1 = trim((string) filter_input(INPUT_POST, 'player1', FILTER_SANITIZE_SPECIAL_CHARS));
    $player2 = trim((string) filter_input(INPUT_POST, 'player2', FILTER_SANITIZE_SPECIAL_CHARS));
    $password1 = trim($_POST['password1'] ?? '');
    $password2 = trim($_POST['password2'] ?? '');

    //validates player logins
    if ($player1 === '' || $player2 === '' || $password1 === '' || $password2 === '') {
        $errorMessage = 'Please fill in both usernames and both passwords.';
    } elseif ($player1 === $player2) {
        $errorMessage = 'Player 1 and Player 2 must use different accounts.';
    } elseif (!verify_account($player1, $password1) || !verify_account($player2, $password2)) {
        $errorMessage = 'One or both login credentials are invalid.';
    } else {
        //starts the match after both players are verified
        initialize_match($player1, $player2);
        header('Location: lobby.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Panther Millionaire</title>
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

    <!--login page-->
    <main class="hero">
      <section class="page-card large-card">
        <h2>Start a 2-Player Match</h2>
        <p class="subtitle">Both players must log in with their registered accounts before we can begin.</p>

        <?php if ($errorMessage !== ''): ?>
          <div class="message error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <div class="two-column-grid">
          <!--2-player login-->
          <form action="login.php" method="post" class="question-box">
            <h3>Player 1</h3>
            <div class="form-group">
              <label for="player1">Username</label>
              <input type="text" id="player1" name="player1" value="<?php echo htmlspecialchars($player1); ?>" required>
            </div>
            <div class="form-group">
              <label for="password1">Password</label>
              <input type="password" id="password1" name="password1" required>
            </div>

            <h3>Player 2</h3>
            <div class="form-group">
              <label for="player2">Username</label>
              <input type="text" id="player2" name="player2" value="<?php echo htmlspecialchars($player2); ?>" required>
            </div>
            <div class="form-group">
              <label for="password2">Password</label>
              <input type="password" id="password2" name="password2" required>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-primary">Start Match</button>
              <a href="register.php" class="btn btn-secondary">Register More Players</a>
            </div>
          </form>

          <!--login explanation-->
          <div class="question-box">
            <h3>Before You Start</h3>
            <p class="info-text">Make sure both players have already created accounts on the registration page.</p>
            <h3>What this page does</h3>
            <p class="info-text">This page validates both player logins, starts the session, and initializes turn order, question sequence, lifelines, and score tracking.</p>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>