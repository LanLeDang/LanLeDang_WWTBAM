<?php
require_once __DIR__ . '/includes/bootstrap.php';

//loads leaderboard data and current match info
$entries = leaderboard_entries();
$isLoggedIn = !empty($_SESSION['players']);
$currentPlayers = $isLoggedIn ? $_SESSION['players'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leaderboard | Panther Millionaire</title>
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
          <?php if ($isLoggedIn): ?>
            <a href="lobby.php">Lobby</a>
            <a href="logout.php">Logout</a>
          <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
          <?php endif; ?>
          <a href="team.html">Team</a>
        </nav>
      </div>
    </header>

    <!--leaderboard page-->
    <main class="hero">
      <section class="page-card large-card">
        <h2>Leaderboard</h2>
        <p class="subtitle">Top 10 scores saved in this browser.</p>

        <?php if ($isLoggedIn): ?>
          <!--shows current players-->
          <div class="two-column-grid">
            <?php foreach ($currentPlayers as $player): ?>
              <div class="question-box">
                <h3><?php echo htmlspecialchars($player['username']); ?></h3>
                <p class="info-text">Status: <?php echo htmlspecialchars($player['status']); ?></p>
                <p class="info-text">Final score: $<?php echo number_format($player['final_score'] ?: adjusted_score($player)); ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if (!empty($entries)): ?>
          <!--saved leaderboard-->
          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th>Rank</th>
                  <th>Player</th>
                  <th>Score</th>
                  <th>Mode</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($entries as $index => $entry): ?>
                  <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($entry['user']); ?></td>
                    <td>$<?php echo number_format((int) $entry['score']); ?></td>
                    <td><?php echo htmlspecialchars($entry['mode']); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="message error">No scores have been recorded yet. Finish a match to appear on the leaderboard.</div>
        <?php endif; ?>

        <div class="button-group compact-group">
          <?php if ($isLoggedIn): ?>
            <a href="lobby.php" class="btn btn-primary">Return to Lobby</a>
            <a href="logout.php" class="btn btn-secondary">End Match</a>
          <?php else: ?>
            <a href="login.php" class="btn btn-primary">Start New Match</a>
            <a href="index.php" class="btn btn-secondary">Back Home</a>
          <?php endif; ?>
        </div>
      </section>
    </main>
  </div>
</body>
</html>