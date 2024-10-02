<?php

$card_scores = [
    "2" => 2,
    "3" => 3,
    "4" => 4,
    "5" => 5,
    "6" => 6,
    "7" => 7,
    "8" => 8,
    "9" => 9,
    "1" => 10,
    "J" => 10,
    "Q" => 10,
    "K" => 10,
    "A" => 11,
];

$rank = [2, 3, 4, 5, 6, 7, 8, 9, 10, "Jack", "Queen", "King", "Ace"];
$suits = ["Spades", "Hearts", "Clubs", "Diamonds"];
$deck = create_deck($rank, $suits);
$cards_played = [];

$game_over = false;

$player_1_hand = [];
$player_2_hand = [];
$player_1_score = 0;
$player_2_score = 0;
$current_player = "Player 1";

function create_deck(array $rank, array $suits): array
{
    $deck = [];
    foreach ($suits as $suit) {
        foreach ($rank as $card) {
            $suited_card = $card . " of " . $suit;
            $deck[] = $suited_card;
        }
    }
    return $deck;
}

function draw_card(array $deck): string
{
    $index = array_rand($deck);
    return $deck[$index];
}

function remove_card(array $deck, string $card): array
{
    $index = array_search($card, $deck);
    unset($deck[$index]);
    return $deck;
}

function get_card_score(string $card, array $card_scores): int
{
    if (strlen($card) === 3) {
        $card_rank = substr($card, 0, 2);
    } else {
        $card_rank = substr($card, 0, 1);
    }
    return $card_scores[$card_rank];
}

function check_winner(int $player_1_score, int $player_2_score): string
{
    if ($player_1_score > 21) {
        return "Player 2 Wins!";
    } else if ($player_2_score > 21) {
        return "Player 1 Wins!";
    } else if ($player_1_score > $player_2_score) {
        return "Player 1 Wins!";
    } else if ($player_1_score === $player_2_score) {
        return "It's a draw!";
    } else {
        return "Player 2 Wins!";
    }
}

function announce_scores(array $player_1_hand, int $player_1_score, array $player_2_hand, int $player_2_score)
{
    echo "Player 1 Hand: ";
    echo implode(", ", $player_1_hand);

    echo "<br>";

    echo "Player 1 Score: ";
    echo $player_1_score;

    echo "<br>";
    echo "<br>";

    echo "Player 2 Hand: ";
    echo implode(", ", $player_2_hand);

    echo "<br>";

    echo "Player 2 Score: ";
    echo $player_2_score;

    echo "<br>";
    echo "<br>";
    echo check_winner($player_1_score, $player_2_score);
}

while ($game_over === false) {

    $card = draw_card($deck);
    $score = get_card_score($card, $card_scores);

    if ($current_player == "Player 1" && $player_1_score < 14) {
        $player_1_hand[] = $card;
        $player_1_score += $score;
        $cards_played[] = $card;
        $deck = remove_card($deck, $card);
        $current_player = "Player 2";
    } else if ($current_player = "Player 2" && $player_2_score < 14) {
        $player_2_hand[] = $card;
        $player_2_score += $score;
        $cards_played[] = $card;
        $deck = remove_card($deck, $card);
        $current_player = "Player 1";
    } else {
        announce_scores($player_1_hand, $player_1_score, $player_2_hand, $player_2_score);
        $game_over = true;
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blackjack</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<div class="container grid">
    <div class="col-container">
        <h1>Player 1</h1>
        <div class="card-container">
            <div class="card"></div>
            <div class="card"></div>
            <div class="card"></div>
        </div>
        <p>Score: <?php echo $player_1_score ?> </p>
    </div>
    <div class="col-container">
        <h1>Player 2</h1>
        <div class="card-container">
            <div class="card"></div>
            <div class="card"></div>
        </div>
        <p>Score: <?php echo $player_2_score ?> </p>
    </div>
</div>
</body>
</html>





