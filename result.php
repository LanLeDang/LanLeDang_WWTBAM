<?php
require_once __DIR__ . '/includes/bootstrap.php';

//protects the page unless both players are ready
require_players_ready();

//checks if this page was opened after a completed turn or walk-away
$turnFinished = isset($_GET['turn_finished']);
$walkAway = isset($_GET['walk']);
$playerKey = current_player_key();
$player = current_player();
$question = current_question();

if ($turnFinished) {
    //shows message when one player's run has ended
    $resultTitle = 'Turn Finished';
    $resultMessage = $player['username'] . ' completed their run. The next player may now take the hot seat.';
    $resultClass = 'success';
    $primaryLink = match_over() ? 'leaderboard.php' : 'game.php';
    $primaryText = match_over() ? 'View Leaderboard' : 'Continue Match';
} elseif ($walkAway) {
    //ends the turn if the player chooses to walk away
    end_current_turn('walked away');
    $player = $_SESSION['players'][$playerKey];
    $resultTitle = 'Walked Away';
    $resultMessage = $player['username'] . ' chose to walk away with $' . number_format($player['final_score']) . '.';
    $resultClass = 'success';
    $primaryLink = match_over() ? 'leaderboard.php' : 'game.php';
    $primaryText = match_over() ? 'View Leaderboard' : 'Next Player';
} else {
    //only accepts valid answer submissions from game form
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $question === null) {
        header('Location: game.php');
        exit();
    }

    $selectedAnswer = trim((string) ($_POST['answer'] ?? ''));
    if ($selectedAnswer === '') {
        $_SESSION['flash_message'] = 'Please select an answer before continuing.';
        header('Location: game.php');
        exit();
    }

    $correctAnswer = $question['answer'];
    $isCorrect = ($selectedAnswer === $correctAnswer);
    $selectedAnswerSafe = $selectedAnswer;

    if ($isCorrect) {
        //updates winnings and moves forward
        $prizes = prize_ladder();
        $player['current_winnings'] = $prizes[$player['question_index']];
        $player['question_index'] += 1;
        $player['last_three'][] = true;
        $player['last_three'] = array_slice($player['last_three'], -3);
        unset($player['hidden_options'][$question['id']]);
        $_SESSION['players'][$playerKey] = $player;

        if ($player['question_index'] >= 15) {
            //ends the turn if the player completed all 15 questions
            end_current_turn('completed');
            $player = $_SESSION['players'][$playerKey];
            $resultTitle = 'Player Completed All 15 Levels';
            $resultMessage = $player['username'] . ' answered all 15 questions and finished with $' . number_format($player['final_score']) . '.';
            $resultClass = 'success';
            $primaryLink = match_over() ? 'leaderboard.php' : 'game.php';
            $primaryText = match_over() ? 'View Leaderboard' : 'Next Player';
        } else {
            $resultTitle = 'Correct Answer';
            $resultMessage = 'The answer was correct. The player advances to the next level.';
            $resultClass = 'success';
            $primaryLink = 'game.php';
            $primaryText = 'Next Question';
        }
    } else {
        //ends the turn if the answer was wrong
        $player['last_three'][] = false;
        $player['last_three'] = array_slice($player['last_three'], -3);
        $_SESSION['players'][$playerKey] = $player;
        end_current_turn('wrong answer');
        $player = $_SESSION['players'][$playerKey];
        $resultTitle = 'Incorrect Answer';
        $resultMessage = $player['username'] . ' answered incorrectly and leaves with $' . number_format($player['final_score']) . '.';
        $resultClass = 'error';
        $primaryLink = match_over() ? 'leaderboard.php' : 'game.php';
        $primaryText = match_over() ? 'View Leaderboard' : 'Next Player';
    }
}

if (!isset($selectedAnswerSafe)) {
    $selectedAnswerSafe = $walkAway ? 'Walked Away' : 'Turn Finished';
}

$displayPlayer = $_SESSION['players'][$playerKey];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Result | Panther Millionaire</title>
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

    <!--result page-->
    <main class="hero">
      <section class="page-card large-card">
        <div class="center-text">
          <div class="score-pill"><?php echo htmlspecialchars($displayPlayer['username']); ?> • Adjusted Score: $<?php echo number_format($displayPlayer['final_score'] ?: adjusted_score($displayPlayer)); ?></div>
        </div>

        <h2><?php echo htmlspecialchars($resultTitle); ?></h2>
        <div class="message <?php echo htmlspecialchars($resultClass); ?>"><?php echo htmlspecialchars($resultMessage); ?></div>

        <?php if (!$turnFinished): ?>
          <div class="two-column-grid">
            <div class="question-box">
              <h3>Selected Answer</h3>
              <p class="info-text"><?php echo htmlspecialchars($selectedAnswerSafe); ?></p>
            </div>
            <?php if (!$walkAway && isset($correctAnswer)): ?>
              <div class="question-box">
                <h3>Correct Answer</h3>
                <p class="info-text"><?php echo htmlspecialchars($correctAnswer); ?></p>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <div class="form-actions">
          <a href="<?php echo htmlspecialchars($primaryLink); ?>" class="btn btn-primary"><?php echo htmlspecialchars($primaryText); ?></a>
          <a href="leaderboard.php" class="btn btn-secondary">Go to Leaderboard</a>
        </div>
      </section>
    </main>
  </div>
</body>
</html>