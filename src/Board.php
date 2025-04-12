<?php

class Board
{
    private $figures = [];
    private $placement = [];

    private $isBlack = false;

    public function __construct()
    {
        $this->figures['a'][1] = new Rook(false);
        $this->figures['b'][1] = new Knight(false);
        $this->figures['c'][1] = new Bishop(false);
        $this->figures['d'][1] = new Queen(false);
        $this->figures['e'][1] = new King(false);
        $this->figures['f'][1] = new Bishop(false);
        $this->figures['g'][1] = new Knight(false);
        $this->figures['h'][1] = new Rook(false);

        $this->figures['a'][2] = new Pawn(false);
        $this->figures['b'][2] = new Pawn(false);
        $this->figures['c'][2] = new Pawn(false);
        $this->figures['d'][2] = new Pawn(false);
        $this->figures['e'][2] = new Pawn(false);
        $this->figures['f'][2] = new Pawn(false);
        $this->figures['g'][2] = new Pawn(false);
        $this->figures['h'][2] = new Pawn(false);

        $this->figures['a'][7] = new Pawn(true);
        $this->figures['b'][7] = new Pawn(true);
        $this->figures['c'][7] = new Pawn(true);
        $this->figures['d'][7] = new Pawn(true);
        $this->figures['e'][7] = new Pawn(true);
        $this->figures['f'][7] = new Pawn(true);
        $this->figures['g'][7] = new Pawn(true);
        $this->figures['h'][7] = new Pawn(true);
    }

    public function move($move)
    {
        if (!preg_match('/^([a-h])(\d)-([a-h])(\d)$/', $move, $match)) {
            throw new \Exception("Incorrect move");
        }

        $xFrom = $match[1];
        $yFrom = $match[2];
        $xTo = $match[3];
        $yTo = $match[4];

        $canMove = false;
        /* @var Figure $fishka */
        $fishka = new Pawn(false);
        if (isset($this->figures[$xFrom][$yFrom])) {
            $canMove = true;
            $fishka = $this->figures[$xFrom][$yFrom];
        }
        $wasTurn = $canMove
            && $fishka->getIsBlack() === $this->isBlack;

        if (!$wasTurn) {
            throw new \Exception('Нарушена очерёдность ходов');
        }

        $isPawn = $fishka instanceof Pawn;
        if (!$isPawn) {
            throw new \Exception('Выбранная фигура не пешка');
        }
        $delta = 1;
        if ($fishka->getIsBlack()) {
            $delta = -1;
        }
        $hasBarrier = isset($this->figures[$xFrom][$yFrom + $delta]);
        if ($hasBarrier) {
            throw new \Exception('Движение через другие фигуры запрещено');
        }

        $isMove = !isset($this->figures[$xTo][$yTo]);
        if($isMove){
            $fishka->move($xFrom, $yFrom, $xTo, $yTo);
        }
        if(!$isMove){
            $fishka->kill($xFrom, $yFrom, $xTo, $yTo);
        }

        if ($wasTurn) {
            $this->figures[$xTo][$yTo] = $this->figures[$xFrom][$yFrom];
            unset($this->figures[$xFrom][$yFrom]);
            $this->isBlack = !$this->isBlack;
        }
    }

    public function dump() {
        for ($y = 8; $y >= 1; $y--) {
            echo "$y ";
            for ($x = 'a'; $x <= 'h'; $x++) {
                if (isset($this->figures[$x][$y])) {
                    echo $this->figures[$x][$y];
                } else {
                    echo '-';
                }
            }
            echo "\n";
        }
        echo "  abcdefgh\n";
    }
}
