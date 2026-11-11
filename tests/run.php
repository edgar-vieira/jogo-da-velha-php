<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Game.php';

use JogoDaVelha\Game;

$falhas = 0;

function check(string $nome, bool $ok): void
{
    global $falhas;
    echo ($ok ? '✔ ' : '✘ ') . $nome . PHP_EOL;
    if (!$ok) {
        $falhas++;
    }
}

$g = new Game();
$g->play(0);
check('alterna para O após X jogar', $g->currentPlayer() === 'O');
check('rejeita casa ocupada', $g->play(0) === false);
check('rejeita posição inválida', $g->play(9) === false);

$g = new Game();
foreach ([0, 3, 1, 4, 2] as $p) {
    $g->play($p);
}
check('X vence na linha superior', $g->winner() === 'X');
check('jogo termina após vitória', $g->isOver() && $g->play(8) === false);

$g = new Game();
foreach ([0, 1, 4, 2, 8] as $p) {
    $g->play($p);
}
check('X vence na diagonal', $g->winner() === 'X');

$g = new Game();
foreach ([0, 1, 2, 4, 3, 5, 7, 6, 8] as $p) {
    $g->play($p);
}
check('detecta empate', $g->isDraw() && $g->winner() === null);

$g = new Game();
$g->play(4);
$copia = Game::fromArray($g->toArray());
check('serializa e restaura o estado', $copia->board() === $g->board() && $copia->currentPlayer() === 'O');

exit($falhas > 0 ? 1 : 0);
