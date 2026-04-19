<?php
require_once __DIR__ . '/includes/bootstrap.php';

//checks if a match is already running
$isLoggedIn = !empty($_SESSION['players']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panther Millionaire</title>
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

    <!--homepage-->
    <main class="hero">
      <section class="hero-card">
        <div class="hero-content">
          <div class="kicker">Cat Trivia!</div>
          <h1>Who Wants to Be a <span>Millionaire?</span></h1>
          <p>
            A multiplayer, turn-based PHP cat trivia game! Register two players,
            progress through 15 levels, use lifelines wisely, and decide whether to keep playing or walk away!
          </p>

          <!--main buttons-->
          <div class="button-group">
            <a href="register.php" class="btn btn-primary">Register Players</a>
            <a href="login.php" class="btn btn-secondary">Start Match</a>
            <a href="leaderboard.php" class="btn btn-outline">View Leaderboard</a>
          </div>

          <!--feature boxes-->
          <div class="info-grid">
            <div class="info-box">
              <h3>15 Levels</h3>
              <p>Play through 5 easy, 5 medium, and 5 hard cat-trivia questions with increasing prize values.</p>
            </div>
            <div class="info-box">
              <h3>2-Player Turns</h3>
              <p>Two registered players duke it out to see who wins in the end!</p>
            </div>
            <div class="info-box">
              <h3>Lifelines & Walk Away</h3>
              <p>You can use 50/50, hint, or pass but not without penalties or you can choose to walk away and keep your current winnings!</p>
            </div>
          </div>

          <?php if ($isLoggedIn): ?>
            <p class="footer-note">A match is already active. Continue from the lobby.</p>
            <div class="button-group compact-group">
              <a href="lobby.php" class="btn btn-primary">Go to Lobby</a>
              <a href="logout.php" class="btn btn-secondary">End Match</a>
            </div>
          <?php else: ?>
            <p class="footer-note">Register two players, then log in to begin the Millionaire match.</p>
          <?php endif; ?>
        </div>
      </section>
    </main>
  </div>
</body>
</html>