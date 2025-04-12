<?php

class Figure {
    protected $isBlack;

    public function __construct($isBlack) {
        $this->isBlack = $isBlack;
    }

    /** @noinspection PhpToStringReturnInspection */
    public function __toString() {
        throw new \Exception("Not implemented");
    }

    /**
     * @return mixed
     */
    public function getIsBlack()
    {
        return $this->isBlack;
    }

    public function move($xFrom,$yFrom,$xTo,$yTo){
        throw new \Exception("Not implemented");
    }
    public function kill($xFrom, $yFrom, $xTo, $yTo){
        throw new \Exception("Not implemented");
    }
}
