<?php
require_once __DIR__ . '/includes/bootstrap.php';

//protects the page unless both players are logged in
require_players_ready();

//loads both players from session
$players = $_SESSION['players'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lobby | Panther Millionaire</title>
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
          <a href="leaderboard.php">Leaderboard</a>
          <a href="team.html">Team</a>
          <a href="logout.php">Logout</a>
        </nav>
      </div>
    </header>

    <!--lobby page-->
    <main class="hero">
      <section class="page-card large-card">
        <h2>Millionaire Lobby</h2>
        <p class="subtitle">Two players, 15 levels, 3 difficulty tiers, lifelines, and the option to walk away.</p>

        <!--shows both players-->
        <div class="two-column-grid">
          <?php foreach ($players as $player): ?>
            <div class="question-box">
              <h3><?php echo htmlspecialchars($player['username']); ?></h3>
              <p class="info-text">Questions: 15 total (5 easy, 5 medium, 5 hard)</p>
              <p class="info-text">Lifelines: 50/50, Hint, Pass</p>
              <p class="info-text">Current winnings: $<?php echo number_format($player['current_winnings']); ?></p>
            </div>
          <?php endforeach; ?>
        </div>

        <!--match instructions-->
        <div class="question-box">
          <h3>How the match works</h3>
          <p class="info-text">Players alternate turns. Each player gets a random 15-question path made up of three difficulty levels. If they answer a question wrong, their run ends. They can also choose to use lifelines with a penalty, or walk away and keep whatever they have won so far.</p>
        </div>

        <div class="button-group compact-group">
          <a href="game.php" class="btn btn-primary">Enter the Hot Seat</a>
          <a href="leaderboard.php" class="btn btn-secondary">View Leaderboard</a>
        </div>
      </section>
    </main>
  </div>
</body>
</html>