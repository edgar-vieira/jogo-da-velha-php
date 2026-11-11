<?php

declare(strict_types=1);

namespace JogoDaVelha;

/**
 * Regras do jogo da velha. Não depende de HTML nem de sessão.
 */
class Game
{
    private const LINHAS_VENCEDORAS = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8], // linhas
        [0, 3, 6], [1, 4, 7], [2, 5, 8], // colunas
        [0, 4, 8], [2, 4, 6],            // diagonais
    ];

    /** @var array<int, string> */
    private array $board;
    private string $current;

    public function __construct(?array $board = null, string $current = 'X')
    {
        $this->board = $board ?? array_fill(0, 9, '');
        $this->current = $current;
    }

    public function play(int $position): bool
    {
        if ($position < 0 || $position > 8) {
            return false;
        }
        if ($this->board[$position] !== '' || $this->isOver()) {
            return false;
        }

        $this->board[$position] = $this->current;

        if (!$this->isOver()) {
            $this->current = $this->current === 'X' ? 'O' : 'X';
        }

        return true;
    }

    /** Retorna 'X', 'O' ou null. */
    public function winner(): ?string
    {
        $line = $this->winningLine();
        return $line !== null ? $this->board[$line[0]] : null;
    }

    /** @return int[]|null */
    public function winningLine(): ?array
    {
        foreach (self::LINHAS_VENCEDORAS as $line) {
            [$a, $b, $c] = $line;
            if ($this->board[$a] !== '' && $this->board[$a] === $this->board[$b] && $this->board[$b] === $this->board[$c]) {
                return $line;
            }
        }
        return null;
    }

    public function isDraw(): bool
    {
        return $this->winner() === null && !in_array('', $this->board, true);
    }

    public function isOver(): bool
    {
        return $this->winner() !== null || $this->isDraw();
    }

    public function currentPlayer(): string
    {
        return $this->current;
    }

    /** @return array<int, string> */
    public function board(): array
    {
        return $this->board;
    }

    public function toArray(): array
    {
        return ['board' => $this->board, 'current' => $this->current];
    }

    public static function fromArray(array $data): self
    {
        return new self($data['board'] ?? null, $data['current'] ?? 'X');
    }
}
