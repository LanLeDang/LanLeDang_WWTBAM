<?php

//get all registered accounts from cookie
function get_registered_accounts(): array
{
    return !empty($_COOKIE['pm_registered_accounts'])
        ? (json_decode($_COOKIE['pm_registered_accounts'], true) ?: [])
        : [];
}

//save registered accounts back into cookies
function save_registered_accounts(array $accounts): void
{
    setcookie(
        'pm_registered_accounts',
        json_encode($accounts),
        time() + (86400 * 30),
        '/'
    );
}

//checks if username already exists.
function account_exists(string $username): bool
{
    $accounts = get_registered_accounts();
    return array_key_exists($username, $accounts);
}

//register a new player
function register_account(string $username, string $password): bool
{
    $accounts = get_registered_accounts();

    if (isset($accounts[$username])) {
        return false;
    }

    $accounts[$username] = password_hash($password, PASSWORD_DEFAULT);
    save_registered_accounts($accounts);
    return true;
}

//verify login info
function verify_account(string $username, string $password): bool
{
    $accounts = get_registered_accounts();

    if (!isset($accounts[$username])) {
        return false;
    }

    return password_verify($password, $accounts[$username]);
}

//get leaderboard from cookie
function leaderboard_entries(): array
{
    if (empty($_COOKIE['pm_leaderboard'])) {
        return [];
    }

    $decoded = json_decode($_COOKIE['pm_leaderboard'], true);
    if (!is_array($decoded)) {
        return [];
    }

    $clean = [];
    foreach ($decoded as $entry) {
        if (is_array($entry) && isset($entry['user'], $entry['score'])) {
            $clean[] = [
                'user' => (string) $entry['user'],
                'score' => (int) $entry['score'],
                'mode' => isset($entry['mode']) ? (string) $entry['mode'] : 'Millionaire',
            ];
        }
    }

    usort($clean, function ($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    return $clean;
}

//adds new score to leaderboard
function add_leaderboard_entry(string $username, int $score): void
{
    $entries = leaderboard_entries();
    $entries[] = [
        'user' => $username,
        'score' => max(0, $score),
        'mode' => 'Millionaire',
    ];

    usort($entries, function ($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    $entries = array_slice($entries, 0, 10);

    setcookie(
        'pm_leaderboard',
        json_encode($entries),
        time() + (86400 * 30),
        '/'
    );
}

//send back to login if match is not ready
function require_players_ready(): void
{
    if (empty($_SESSION['players']) || empty($_SESSION['turn'])) {
        header('Location: login.php');
        exit();
    }
}

//build 15 question path
function build_question_sequence(): array
{
    $bank = question_bank();
    $sequence = [];

    foreach (['easy', 'medium', 'hard'] as $tier) {
        $questions = $bank[$tier];
        shuffle($questions);
        $sequence = array_merge($sequence, array_slice($questions, 0, 5));
    }

    return array_values($sequence);
}

//start a new 2 player match
function initialize_match(string $player1, string $player2): void
{
    $_SESSION['players'] = [
        'p1' => [
            'username' => $player1,
            'question_index' => 0,
            'current_winnings' => 0,
            'penalty' => 0,
            'lifelines' => ['5050' => true, 'hint' => true, 'pass' => true],
            'hidden_options' => [],
            'sequence' => build_question_sequence(),
            'status' => 'playing',
            'final_score' => 0,
            'recorded' => false,
            'last_three' => [],
        ],
        'p2' => [
            'username' => $player2,
            'question_index' => 0,
            'current_winnings' => 0,
            'penalty' => 0,
            'lifelines' => ['5050' => true, 'hint' => true, 'pass' => true],
            'hidden_options' => [],
            'sequence' => build_question_sequence(),
            'status' => 'playing',
            'final_score' => 0,
            'recorded' => false,
            'last_three' => [],
        ],
    ];

    $_SESSION['turn'] = 'p1';
    $_SESSION['flash_message'] = '';
}

//get current player key
function current_player_key(): string
{
    return $_SESSION['turn'] ?? 'p1';
}

//get current player
function current_player(): array
{
    $key = current_player_key();
    return $_SESSION['players'][$key];
}

//save current player updates
function update_current_player(array $player): void
{
    $key = current_player_key();
    $_SESSION['players'][$key] = $player;
}

//get current question
function current_question(): ?array
{
    $player = current_player();
    $index = $player['question_index'];
    return $player['sequence'][$index] ?? null;
}

//difficulty label
function level_label(int $questionIndex): string
{
    if ($questionIndex < 5) {
        return 'Easy';
    }
    if ($questionIndex < 10) {
        return 'Medium';
    }
    return 'Hard';
}

//score after penalties.
function adjusted_score(array $player): int
{
    return max(0, $player['current_winnings'] - $player['penalty']);
}

//end current player's run and record score
function end_current_turn(string $reason): void
{
    $key = current_player_key();
    $player = $_SESSION['players'][$key];
    $player['status'] = $reason;
    $player['final_score'] = adjusted_score($player);

    if (!$player['recorded']) {
        add_leaderboard_entry($player['username'], $player['final_score']);
        $player['recorded'] = true;
    }

    $_SESSION['players'][$key] = $player;

    $otherKey = ($key === 'p1') ? 'p2' : 'p1';
    if ($_SESSION['players'][$otherKey]['status'] === 'playing') {
        $_SESSION['turn'] = $otherKey;
    }
}

//checks if both players are done
function match_over(): bool
{
    return ($_SESSION['players']['p1']['status'] !== 'playing') && ($_SESSION['players']['p2']['status'] !== 'playing');
}

//moves to next player if needed
function next_turn_if_needed(): void
{
    if (match_over()) {
        header('Location: leaderboard.php');
        exit();
    }

    if (current_player()['status'] !== 'playing') {
        $_SESSION['turn'] = (current_player_key() === 'p1') ? 'p2' : 'p1';
    }
}

//50/50 lifeline
function use_5050(array &$player, array $question): void
{
    $wrong = array_values(array_filter($question['options'], fn($opt) => $opt !== $question['answer']));
    shuffle($wrong);
    $hide = array_slice($wrong, 0, 2);
    $player['hidden_options'][$question['id']] = $hide;
    $player['lifelines']['5050'] = false;
    $player['penalty'] += 500;
}

//small difficulty status label
function difficulty_badge(array $player): string
{
    $recent = $player['last_three'];
    if (count($recent) < 3) {
        return level_label($player['question_index']);
    }

    $correct = count(array_filter($recent));
    if ($correct >= 2) {
        return 'Rising';
    }
    if ($correct <= 1) {
        return 'Adjusting';
    }

    return level_label($player['question_index']);
}