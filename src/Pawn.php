<?php

class Pawn extends Figure
{
    private $isFirstMove = true;

    public function __construct($isBlack)
    {
        parent::__construct($isBlack);

        $this->diagonal['a'] = 1;
        $this->diagonal['b'] = 2;
        $this->diagonal['c'] = 3;
        $this->diagonal['d'] = 4;
        $this->diagonal['e'] = 5;
        $this->diagonal['f'] = 6;
        $this->diagonal['g'] = 7;
        $this->diagonal['h'] = 8;
    }

    public function __toString()
    {
        return $this->isBlack ? '♟' : '♙';
    }

    public function move($xFrom, $yFrom, $xTo, $yTo)
    {
        if ($xFrom !== $xTo) {
            throw new \Exception(
                'Ошибка: Движение пешкой по диагонали'
            );
        }

        $distance = $this->calculateDistance($yTo, $yFrom);

        $isValid = ($distance === 1)
            || ($distance === 2 && $this->isFirstMove);

        if(!$isValid){
            throw new \Exception(
                'Ошибка: Ход больше чем на одну клетку и это не первый ход'
            );
        }

        $this->isFirstMove = false;
    }

    public function kill($xFrom, $yFrom, $xTo, $yTo)
    {
        $vertical = $this->calculateDistance($yTo, $yFrom);
        if ($vertical !== 1) {
            throw new \Exception(
                'Ошибка: Рубка должна быть по диагонали на одну клетку'
            );
        }
        $horizontal = $this->diagonal[$xFrom]-$this->diagonal[$xTo];
        if ($horizontal !== 1) {
            throw new \Exception(
                'Ошибка: Рубка должна быть по диагонали на одну клетку'
            );
        }
    }

    /**
     * @param $yTo
     * @param $yFrom
     * @return int
     */
    private function calculateDistance($yTo, $yFrom): int
    {
        $distance = $yTo - $yFrom;
        if ($this->getIsBlack()) {
            $distance *= -1;
        }

        return $distance;
    }
}
