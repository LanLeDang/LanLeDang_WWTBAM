<?php
require_once __DIR__ . '/includes/bootstrap.php';

//protects the page unless the match is ready
require_players_ready();

//switches players if needed
next_turn_if_needed();

//gets current player and question
$player = current_player();
$playerKey = current_player_key();
$question = current_question();

//if there are no more questions, end this player's run
if ($question === null) {
    end_current_turn('completed');
    if (match_over()) {
        header('Location: leaderboard.php');
    } else {
        header('Location: result.php?turn_finished=1');
    }
    exit();
}

//loads any temporary message
$flashMessage = '';
if (!empty($_SESSION['flash_message'])) {
    $flashMessage = (string) $_SESSION['flash_message'];
    $_SESSION['flash_message'] = '';
}

//checks if player used a lifeline
$action = trim((string) ($_GET['action'] ?? ''));
if ($action !== '') {
    if ($action === '5050' && $player['lifelines']['5050']) {
        use_5050($player, $question);
        update_current_player($player);
        $flashMessage = '50/50 used. Two wrong answers were removed. Penalty: $500.';
    } elseif ($action === 'hint' && $player['lifelines']['hint']) {
        $player['lifelines']['hint'] = false;
        $player['penalty'] += 750;
        $player['active_hint'] = $question['hint'];
        update_current_player($player);
        $flashMessage = 'Hint revealed. Penalty: $750.';
    } elseif ($action === 'pass' && $player['lifelines']['pass']) {
        $player['lifelines']['pass'] = false;
        $player['penalty'] += 1000;
        $player['question_index'] += 1;
        $player['last_three'][] = false;
        $player['last_three'] = array_slice($player['last_three'], -3);
        update_current_player($player);
        $_SESSION['flash_message'] = 'Pass used. The question was skipped with a $1,000 penalty.';
        header('Location: game.php');
        exit();
    }

    //reloads player's data after any lifeline use
    $player = current_player();
}

//loads question display values
$hiddenOptions = $player['hidden_options'][$question['id']] ?? [];
$questionNumber = $player['question_index'] + 1;
$prizes = prize_ladder();
$currentPrize = $prizes[$player['question_index']];
$currentTier = level_label($player['question_index']);
$activeHint = $player['active_hint'] ?? '';
unset($_SESSION['players'][$playerKey]['active_hint']);
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
          <a href="lobby.php">Lobby</a>
          <a href="leaderboard.php">Leaderboard</a>
          <a href="logout.php">Logout</a>
        </nav>
      </div>
    </header>

    <!--game page-->
    <main class="hero">
      <section class="page-card xl-card">
        <!--top game info-->
        <div class="game-header-row">
          <div class="score-pill">Current Player: <?php echo htmlspecialchars($player['username']); ?></div>
          <div class="score-pill">Question <?php echo $questionNumber; ?>/15</div>
          <div class="score-pill">Tier: <?php echo htmlspecialchars($currentTier); ?></div>
          <div class="score-pill">Prize: $<?php echo number_format($currentPrize); ?></div>
        </div>

        <?php if ($flashMessage !== ''): ?>
          <div class="message success"><?php echo htmlspecialchars($flashMessage); ?></div>
        <?php endif; ?>

        <!--shows hint if player used hint lifeline-->
        <?php if ($activeHint !== ''): ?>
          <div class="question-box hint-box">
            <h3>Hint</h3>
            <p class="info-text"><?php echo htmlspecialchars($activeHint); ?></p>
          </div>
        <?php endif; ?>

        <!--question and answer form-->
        <div class="question-box game-show-box reveal-card">
          <h2><?php echo htmlspecialchars($question['question']); ?></h2>
          <form action="result.php" method="post">
            <?php foreach ($question['options'] as $option): ?>
              <?php if (!in_array($option, $hiddenOptions, true)): ?>
                <label class="answer-option reveal-card">
                  <input type="radio" name="answer" value="<?php echo htmlspecialchars($option); ?>" required>
                  <?php echo htmlspecialchars($option); ?>
                </label>
              <?php endif; ?>
            <?php endforeach; ?>

            <div class="form-actions">
              <button type="submit" class="btn btn-primary">Lock In Answer</button>
              <a href="result.php?walk=1" class="btn btn-secondary">Walk Away</a>
            </div>
          </form>
        </div>

        <div class="two-column-grid">
          <!--lifelines box-->
          <div class="question-box">
            <h3>Lifelines</h3>
            <div class="button-group compact-group left-group">
              <a href="game.php?action=5050" class="btn btn-outline <?php echo $player['lifelines']['5050'] ? '' : 'btn-disabled'; ?>">50/50</a>
              <a href="game.php?action=hint" class="btn btn-outline <?php echo $player['lifelines']['hint'] ? '' : 'btn-disabled'; ?>">Hint</a>
              <a href="game.php?action=pass" class="btn btn-outline <?php echo $player['lifelines']['pass'] ? '' : 'btn-disabled'; ?>">Pass</a>
            </div>
            <p class="info-text">Used lifelines reduce the final score.</p>
          </div>

          <!--player status box-->
          <div class="question-box">
            <h3>Player Status</h3>
            <p class="info-text">Current winnings: $<?php echo number_format($player['current_winnings']); ?></p>
            <p class="info-text">Penalty total: $<?php echo number_format($player['penalty']); ?></p>
            <p class="info-text">Adjusted score: $<?php echo number_format(adjusted_score($player)); ?></p>
            <p class="info-text">Difficulty indicator: <?php echo htmlspecialchars(difficulty_badge($player)); ?></p>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>