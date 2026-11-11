# 🎮 Jogo da Velha em PHP

Jogo da velha para dois jogadores feito em PHP puro, sem dependências. O estado da partida fica guardado na sessão.

## Requisitos

- PHP 8.0 ou superior

## Como rodar

```bash
git clone https://github.com/edgar-vieira/jogo-da-velha-php.git
cd jogo-da-velha-php
php -S localhost:8000 -t public
```

Abra <http://localhost:8000> no navegador.

## Como jogar

1. O jogador **X** começa.
2. Clique em uma casa vazia para jogar.
3. Vence quem completar uma linha, coluna ou diagonal.
4. Se todas as casas forem preenchidas sem vencedor, dá velha.
5. Use **Reiniciar** para começar outra partida.

## Testes

```bash
php tests/run.php
```

## Estrutura

```
.
├── public/
│   ├── index.php    # interface e controle das requisições
│   └── style.css    # estilos
├── src/
│   └── Game.php     # regras do jogo (sem HTML)
├── tests/
│   └── run.php      # testes das regras
├── .gitignore
├── LICENSE
└── README.md
```

## Licença

Distribuído sob a licença MIT. Veja [LICENSE](LICENSE).
