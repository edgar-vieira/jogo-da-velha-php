<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Game.php';

use JogoDaVelha\Game;

session_start();

$game = isset($_SESSION['game']) ? Game::fromArray($_SESSION['game']) : new Game();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reiniciar'])) {
        $game = new Game();
    } elseif (isset($_POST['pos'])) {
        $game->play((int) $_POST['pos']);
    }
    $_SESSION['game'] = $game->toArray();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$board = $game->board();
$winLine = $game->winningLine() ?? [];

if ($game->winner() !== null) {
    $status = 'Jogador ' . $game->winner() . ' venceu! 🎉';
} elseif ($game->isDraw()) {
    $status = 'Deu velha! 🤝';
} else {
    $status = 'Vez do jogador ' . $game->currentPlayer();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jogo da Velha</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Jogo da Velha</h1>
        <p class="status"><?= htmlspecialchars($status) ?></p>

        <form method="post" class="board">
            <?php foreach ($board as $i => $cell): ?>
                <button
                    type="submit"
                    name="pos"
                    value="<?= $i ?>"
                    class="cell <?= strtolower($cell) ?> <?= in_array($i, $winLine, true) ? 'win' : '' ?>"
                    <?= ($cell !== '' || $game->isOver()) ? 'disabled' : '' ?>
                ><?= htmlspecialchars($cell) ?></button>
            <?php endforeach; ?>
        </form>

        <form method="post">
            <button type="submit" name="reiniciar" value="1" class="reset">Reiniciar</button>
        </form>
    </main>
</body>
</html>
